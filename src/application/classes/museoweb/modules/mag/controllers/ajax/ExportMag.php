<?php
class museoweb_modules_mag_controllers_ajax_ExportMag extends org_glizy_mvc_core_CommandAjax
{
    private $templClass;

    function execute($moduleId, $page)
    {
        if ($this->user->isLogged())
        {
            $this->initPhpTal();
            $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
            $exportFolder = $magProxy->getExportFolder();

            $it = $magProxy->getMagIteratorToExport($moduleId, $page);
            foreach ($it as $ar) {
                $data = $ar->getValuesForced();
                if (isset($data->mag_lock) && !$data->mag_lock) {
                    if (@$data->ref_id) {
                        // c'è un record collegato
                        // esegue l'override dei valori
                        $data = $magProxy->overrideDataWithOriginalRecordValues($data->ref_id, $data);
                    }
                    $magProxy->overrideDataFromNiso($data->img->importMode, $data->img);
                }
                $data->img = $this->convertToObject($data->img);
                $data->gen_creation = str_replace(' ', 'T', glz_localeDate2ISO($data->gen_creation));
                $data->dc_description = '<![CDATA['.$data->dc_description.']]>';
                $data->doc = $this->convertToObject($data->doc, 'd');
                $data->audio = $this->convertToObject($data->audio, 'a');
                $data->video = $this->convertToObject($data->video, 'v');

                // renderizza l'output tramite un template tal
                $this->render($data, $exportFolder.'/Mag_'.$ar->document_id.'.xml');
            }
            return true;
        }
    }


    private function render($data, $filename)
    {
        if (!$this->templClass) {
            $this->templClass = new PHPTAL();

            $this->templClass->setPhpCodeDestination(org_glizy_Paths::getRealPath('CACHE'))
                    ->setTemplate(__Paths::get('APPLICATION_TO_ADMIN').'classes/museoweb/modules/mag/static/mag.html')
                    ->setForceReparse(false)
                    ->setEncoding(__Config::get('CHARSET'));
        }

        $this->templClass->set('Component', $data);
        $res = $this->templClass->execute();
        $res = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $res);
        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($res);
        $dom->formatOutput = true;
        $xml_string = $dom->saveXML();
        file_put_contents($filename, $xml_string);
        // echo '<pre>'.htmlentities($res).'</pre>';
    }

    protected function convertToObject($data, $prefix='')
    {
        $result = array();
        if (is_object($data)) {
            $defaultFields = array( 'mag_sequence_number' => '',
                                    'mag_nomenclature' => '',
                                    'mag_usage' => '1',
                                    'mag_side' => '',
                                    'mag_file_href' => '',
                                    'mag_md5' => '',
                                    'mag_filesize' => '',
                                    'niso_sourcetype' => '',
                                    'mag_datetimecreated' => '',
                                    );
            $objectKeys = array_keys(get_object_vars($data));
            if ($objectKeys) {
                $numItems = 0;
                foreach($objectKeys as $k) {
                    $numItems = max(count($data->{$k}), $numItems);
                }
                for($i=0; $i < $numItems; $i++) {
                    $tempObj = new StdClass;
                    foreach($objectKeys as $k) {
                        $value = $data->{$k}[$i];
                        if ($k==$prefix.'mag_datetimecreated') {
                            $value = str_replace(' ', 'T', glz_localeDate2ISO($value));
                        }
                        $tempObj->{$k} = $value;
                    }
                    foreach($defaultFields as $f=>$v) {
                        if (!property_exists($tempObj, $prefix.$f)) {
                            $tempObj->{$prefix.$f} = $v;
                        }
                    }
                    $result[] = $tempObj;
                }
            }
        }
        return $result;
    }


    private function initPhpTal()
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . GLZ_LIBS_DIR . 'PHPTAL5/');
        set_include_path(get_include_path() . PATH_SEPARATOR . GLZ_LIBS_DIR . 'PHPTAL5/PHPTAL/');
        require_once(GLZ_LIBS_DIR.'PHPTAL5/PHPTAL.php');
    }

}
