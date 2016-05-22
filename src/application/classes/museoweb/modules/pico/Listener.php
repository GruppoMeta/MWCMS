<?php
class museoweb_modules_pico_Listener extends GlizyObject
{
    function __construct()
    {
        // si mette in ascolto dello start process
        // per poter fare i listener dei vari moduli
        $this->addEventListener(GLZ_EVT_START_PROCESS, $this);
    }


    public function startProcess($evt)
    {
        $this->application = org_glizy_ObjectValues::get('org.glizy', 'application');
        $this->language = $this->application->isAdmin() ? $this->application->getEditingLanguage() : $this->application->getLanguage();

        $enabledModules = museoweb_modules_pico_Module::getEnabledModules();
        $mappingToModel = museoweb_modules_pico_Module::getMappingToModel();

        foreach( $mappingToModel as $k=>$model) {
            if (in_array($model, $enabledModules)) {
                $this->addEventListener( GLZ_EVT_AR_UPDATE.'@'.$model , $this, false, 'updateRecord' );
                $this->addEventListener( GLZ_EVT_AR_INSERT.'@'.$model , $this, false, 'insertRecord' );
                $this->addEventListener( GLZ_EVT_AR_DELETE.'@'.$model , $this, false, 'deleteRecord' );
                $this->addEventListener( museoweb_modules_pico_Module::EVT_INDEX_MODEL.'@'.$model , $this, false, 'insertRecord' );
            }
            $this->addEventListener( museoweb_modules_pico_Module::EVT_DELETE_MODEL.'@'.$model , $this, false, 'deleteAll' );
        }
    }

    public function updateRecord( $evt )
    {
        $this->insertInQueue($evt, 'update');
    }

    public function insertRecord( $evt )
    {
        $this->insertInQueue($evt, 'insert');
    }

    public function deleteRecord( $evt )
    {
        $this->insertInQueue($evt, 'delete');
    }

    public function deleteAll($evt)
    {
        $ar = org_glizy_ObjectFactory::createModel('org.glizy.oaipmh.models.PicoQueue');
        $ar->delete(array('picoqueue_recordModule' => $evt->data));
    }

    private function insertInQueue($evt, $action)
    {
        $mapping = $this->getMapping($evt);
        if ($mapping) {
            $id = $evt->data->getId();

            $ar = org_glizy_ObjectFactory::createModel('org.glizy.oaipmh.models.PicoQueue');
            $ar->delete(array('picoqueue_recordId' => $id, 'picoqueue_recordModule' => $mapping));

            $canAccept = false;
            $fields = $evt->data->getFields();
            foreach ($fields as $k=>$v) {
                if (preg_match('/_thesaurus$/', $k) && $evt->data->{$k}) {
                    $canAccept = true;
                    break;
                }
            }

            if ($canAccept) {
                // scrive il valore
                $ar = org_glizy_ObjectFactory::createModel('org.glizy.oaipmh.models.PicoQueue');
                $ar->picoqueue_date = new org_glizy_types_DateTime();
                $ar->picoqueue_identifier = $this->language.'/'.$mapping.'/'.$id;
                $ar->picoqueue_action = $action;
                $ar->picoqueue_recordId = $id;
                $ar->picoqueue_recordModule = $mapping;
                $ar->save();
            }
        }
    }

    private function getMapping($evt)
    {
        $availableModules = museoweb_modules_pico_Module::getMappingToModel();
        $model = $evt->data->getClassName(false);
        return array_search($model, $availableModules);
    }
}
