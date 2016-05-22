<?php
class museoweb_massiveImporter_controllers_MappingValidation extends org_glizy_mvc_core_Command
{
    public function execute($mapping, $mappingName)
    {
        // controllo validità della mappatura, verifcando che i campi del modulo
        // che sono obbligatori siano mappati e compilati nel file da importare
        $moduleId = __Session::get('massiveImporter_moduleId');

        $moduleService = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.ModuleService');
        $fields = $moduleService->getFields($moduleId);

        $errors = false;

        foreach ($fields as $fieldId => $c) {
            $id = $c->getattribute('id');
            if ($c->getattribute('required') && $mapping[$id] == '') {
                $errors = true;
                break;
            }
        }

        if (!$errors) {
            // se l'utente vuole salvare il mapping
            if ($mappingName) {
                $ar = org_glizy_ObjectFactory::createModel('museoweb.massiveImporter.models.Mapping');
                $ar->find(array('massiveimporter_mapping_name' => $mappingName));
                $ar->massiveimporter_mapping_name = $mappingName;
                $ar->massiveimporter_mapping_moduleid = $moduleId;
                $ar->massiveimporter_mapping_heading = serialize(__Session::get('massiveImporter_heading'));
                $ar->massiveimporter_mapping_mapping = serialize($mapping);
                $ar->save();
            }
            __Session::set('massiveImporter_mapping', $mapping);
            $this->changeAction('imageFolder');
        } else {
            $this->logAndMessage('Mappare tutti i campi obbligatori', null, true);
            $this->changeAction('fieldMapping');
        }
    }
}