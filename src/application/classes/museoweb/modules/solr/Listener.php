<?php
class museoweb_modules_solr_Listener extends GlizyObject
{
    private $application;
    private $language;
    private $host;
    private $documents = array();
    private $mapModelToModule = array();
    private $solrProfile;
    private $dcFields;

    function __construct()
    {
        // si mette in ascolto dello start process
        // per poter fare i listener dei vari moduli
        $this->addEventListener(GLZ_EVT_START_PROCESS, $this);
    }

    public function onProcessStart($evt)
    {
        $url = __Config::get('metacms.solr.url');
        $pushEnabled = org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').museoweb_modules_solr_Module::REGISTRY_SOLR_ENABLED) == 'true';

        if ($url) {

            $this->application = org_glizy_ObjectValues::get('org.glizy', 'application');
            $this->language = $this->application->isAdmin() ? $this->application->getEditingLanguage() : $this->application->getLanguage();
            $this->host = str_replace( '/admin', '', GLZ_HOST);


            $enabledModules = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').museoweb_modules_solr_Module::REGISTRY_SOLR_MAP_ACTIVE, '')) ?: array();
            $modules = org_glizy_Modules::getModules();
            foreach( $modules as $m ) {
                $model = $m->classPath.'.models.Model';
                if (isset($enabledModules[$m->id]) && $enabledModules[$m->id]) {
                    $this->mapModelToModule[$model] = $m->id;
                    if ($pushEnabled) {
                        $this->addEventListener( GLZ_EVT_AR_UPDATE.'@'.$model , $this, false, 'updateRecord' );
                        $this->addEventListener( GLZ_EVT_AR_INSERT.'@'.$model , $this, false, 'insertRecord' );
                        $this->addEventListener( GLZ_EVT_AR_DELETE.'@'.$model , $this, false, 'deleteRecord' );
                    }
                    $this->addEventListener( museoweb_modules_solr_Module::EVT_INDEX_MODEL.'@'.$model , $this, false, 'insertRecord' );
                    $this->addEventListener( museoweb_modules_solr_Module::EVT_QUEUE_MODEL.'@'.$model , $this, false, 'queueRecord' );
                }
                $this->addEventListener( museoweb_modules_solr_Module::EVT_DELETE_MODEL.'@'.$model , $this, false, 'deleteAll' );
            }

            $this->addEventListener( museoweb_modules_solr_Module::EVT_QUEUE_COMMIT, $this, false, 'queueCommit' );
        }
    }

    public function updateRecord( $evt )
    {
        $this->insertRecord($evt);
    }

    public function insertRecord( $evt )
    {
        $doc = $this->getMapping($evt);
        if ($doc) {
            $this->sendRequest('add', $doc);
        }
    }


    public function queueRecord( $evt )
    {
        $doc = $this->getMapping($evt);
        if ($doc) {
            $this->sendRequest('queue', $doc);
        }
    }

    public function queueCommit( $evt )
    {
        $this->sendRequest('commit', null);
        $this->documents = array();
    }

    public function deleteRecord( $evt )
    {
        $this->sendRequest('delete', $this->createDocumentId($evt->data));
    }

    public function deleteAll($evt)
    {
        $this->sendRequest('deleteAll', $evt->data);
    }

    private function sendRequest($action, $doc)
    {
        if ($action=='add' || $action=='queue') {
            $command = 'update/json';
            $json = array(
                'add' => array(
                    'doc' => $doc,
                    'boost' => 1.0,
                    'overwrite' => true,
                    'commitWithin' => 5000
                    )
            );

            if ($action=='queue') {
                $this->documents[] = trim(@json_encode($json), '{}').'}';
                return;
            }
        } else if ($action=='commit') {
            $command = 'update/json';
            $json = '{'.implode(',', $this->documents).', "commit":{}}';
        } else if ($action=='delete') {
            $command = 'update/json';
            $json = array(
                'delete' => array(
                    'id' => $doc
                    ),
                'commit' => ''
            );
        } else if ($action=='deleteAll') {
            $command = 'update/json';
            $json = array(
                'delete' => array(
                    'query' => 'glizyModule_s:'.$doc.' AND descSource:'.__Config::get('mwcms.site.name'),
                ),
                'commit' => '',
                'optimize' => array('waitFlush' => false, 'waitSearcher' => false)
            );
        }

        $request = org_glizy_ObjectFactory::createObject('org.glizy.rest.core.RestRequest',
            __Config::get('metacms.solr.url').$command.'?wt=json&commit=true ',
            'POST',
            is_string($json) ? $json : @json_encode($json),
            'application/json'
        );

    $request->execute();
    }


    private function getMapping($evt)
    {
        $this->getSolrProfile();
        $model = $evt->data->getClassName(false);
        if (isset($this->mapModelToModule[$model])) {
            $mapping = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').
                                            museoweb_modules_solr_Module::REGISTRY_SOLR_MAP.'/'.
                                            $this->mapModelToModule[$model])) ?: array();
            return $this->createJsonRecord($evt->data, $this->mapModelToModule[$model], $mapping);
        }
        return false;
    }

    private function createJsonRecord($ar, $moduleId, $mapping)
    {
        $json = new StdClass();
        $lod = '';

        foreach($this->solrProfile as $k=>$v) {
            $value = '';
            if (property_exists($mapping, $k)) {
                $value = $this->readDocumentValue($ar, $mapping->{$k});
            }
            if ($value) {
                if ($v->solr) {
                    $suffix = $this->dcFields[$k]['solr'];
                    $solrFields = $suffix ? $k.'_'.$suffix : $k;
                    $json->{$solrFields} = $value;
                }
                if ($v->facets) {
                    $solrFields = $k.'_facet';
                    $json->{$solrFields} = $value;
                }
                if ($v->lod) {
                    $tag = $this->dcFields[$k]['lod'];
                    $value = strip_tags($value);
                    $lod .= '<'.$tag.'>'.$this->xmlEntities($value).'</'.$tag.'>';
                }
            }
        }

        $json->glizyModule_s = $moduleId;
        $json->id = $this->createDocumentId($ar);
        $json->url_s = $this->createDocumentUrl($ar, $json->glizyModule_s);
        $json->lang_s = $this->language;
        $json->lang_facet = $this->language;
        $json->descSource = __Config::get('mwcms.site.name');
        $json->job = 0;
        $json->title_t = $json->title;
        $json->module_facet = __T($json->glizyModule_s);
        $json->source_facet = __Config::get('mwcms.site.name');
        $json->sourceType_facet = __Config::get('mwcms.site.type');
        if ($lod) $json->pico_s = $this->getPicoDocument($lod, $json->url_s);

        return $json;
    }

    private function readDocumentValue($ar, $actions)
    {
        $result = array();
        foreach($actions as $action) {
            $command = $action[1];
            $field = $action[0];
            $value = $ar->fieldExists($field) ? $ar->{$field} : '';

            switch ($command) {
                case 'fixed':
                    $value = $field;
                    break;

                case 'strip html':
                    $value = html_entity_decode(strip_tags($ar->{$field}), ENT_QUOTES, 'UTF-8');
                    break;

                case 'split date':
                    $anno = substr($value, 1, 4);
                    $mese = substr($value, 5, 2);
                    $giorno = substr($value, 7, 2);
                    $value = $giorno.'/'.$mese.'/'.$anno;
                    break;

                case 'split pos. 1':
                case 'split pos. 2':
                case 'split pos. 3':
                    $tempValue = explode(',', $value);
                    $value = $tempValue[$command[str_replace('split pos. ', '', $command)]];
                    break;

                case 'image':
                    $value = $this->getImageUrl($value);
                    break;

            }
            $result[] = trim($value);
        }

        return trim(implode(' ', $result));
    }

    private function createDocumentId($ar)
    {
        return $this->host.'/'.$this->language.'/'.$ar->getClassName(false).'/'.$ar->getId();;
    }

    private function createDocumentUrl($ar, $module)
    {
        return $this->host.'/'.$this->language.'/go/'.$module.'/'.$ar->getId();
    }

    private function getImageUrl($id)
    {
        $id = @json_decode($id);
        if ($id) {
            return $this->host.'/getImage.php?id='.$id->id;
        } else {
            return '';
        }
    }

    private function getSolrProfile()
    {
         if (!$this->solrProfile) {
            $this->solrProfile = (unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').
                                            museoweb_modules_solr_Module::REGISTRY_SOLR_PROFILE)) ?: array());

            $dcProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.solr.models.proxy.DcProxy');
            $this->dcFields = $dcProxy->getFields();
        }
    }

    private function getPicoDocument($xml, $url)
    {
        $output = '<?xml version="1.0" encoding="utf-8"?><pico:record xmlns:pico="http://purl.org/pico/1.0/" '.
'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '.
'xmlns:dc="http://purl.org/dc/elements/1.1/" '.
'xmlns:dcterms="http://purl.org/dc/terms/" '.
'xsi:schemaLocation="http://purl.org/pico/1.0/ http://www.culturaitalia.it/pico/schemas/1.0/pico.xsd '.
'http://purl.org/dc/elements/1.1/ http://www.dublincore.org/schemas/xmls/qdc/2006/06/01/dc.xsd '.
'http://purl.org/dc/terms/ http://www.dublincore.org/schemas/xmls/qdc/2006/01/06/dcterms.xsd">';
        $output .= $xml;
        $output .= '<dcterms:references>'.$url.'</dcterms:references>';
        $output .= '</pico:record>';
        return $output;
    }

    private function xmlEntities($string) {
        return strtr(
            $string,
            array(
                "<" => "&lt;",
                ">" => "&gt;",
                '"' => "&quot;",
                "'" => "&apos;",
                "&" => "&amp;",
            )
        );
    }
}
