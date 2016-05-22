<?php
class museoweb_modules_mag_controllers_ajax_MassiveImport extends org_glizy_mvc_core_CommandAjax
{
    private $magProxy;
    private $magModule;
    private $count = 0;
    const DEFAULT_MAG_ID = '0000000000';

    public function execute($data)
    {
         set_time_limit(0);
         $this->directOutput = true;
         if ($this->user->isLogged()) {
            $data = json_decode($data);
            $type = $data->moduleId;
            $ar = org_glizy_ObjectFactory::createModelIterator($type);
            $ar->load('all');
            $this->magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
            $this->magModule = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.mag.models.Model');

            // overwrite
            if($data->importMode == 'overwrite') {
                $this->magModule->setOrFilters(array("ref_model_id" => $type));
                foreach ($this->magModule as $mod) {
                    if($mod->mag_lock != 1) {
                        $mod->delete();
                    }
                }
            }

            foreach ($ar as $index => $item) {
                $refId = $type.":".$item->document_id.":".$item->document_detail_FK_language_id;
                $moduleData = $this->magProxy->getRecordInfoById($refId);
                if($this->importModule((object)$moduleData[0]['data'], $data, $refId))
                {
                    ++$this->count;
                }
            }
            $message = "Mag importati/aggiornati: ".$this->count.".";
            $this->logAndMessage(__T($message));
            return array('url' => $this->changeAction(''));
        }
    }

    private function importModule($magData, $formData, $refId)
    {
        $this->magModule->setOrFilters(array("ref_id" => $refId));
        $countModule = $this->magModule->count();

        foreach($formData as $key=> $value) {
            if(!isset($magData->$key) || $magData->$key == '') {
                $magData->$key = $value ?: '';
            }
        }
        foreach ($magData->img->img_id as $id) {
            $image = $this->magProxy->getImageInfoById($id);
            foreach ($image as $key=> $value) {
                if($key != 'img_id') {
                    $magData->img->{$key}[] = $value ?: '';
                }
            }
        }
        $magData->__model = 'museoweb.modules.mag.models.Model';
        if ($magData->dc_identifier == '') {
            $magData->dc_identifier = self::DEFAULT_MAG_ID;
        }
        $magData->path = $magData->dc_identifier;
        $magData->text = $magData->dc_title;
        $magData->ref_id = $refId ?: 0;
        $magData->ref_model_id = $formData->moduleId ?: '';

        $result = false;
        if($countModule && $formData->importMode == 'update') {
            foreach($this->magModule as $arMag) {
                if($arMag->mag_lock != 1)
                {
                    foreach($magData as $key=> $value) {
                        $arMag->{$key} = $value ?: '';
                    }
                    $arMag->save();
                    ++$this->count;
                }

            }
        } else if($formData->importMode == 'overwrite') {

            $arMag = $this->magModule->current();
            if($arMag->mag_lock != 1)
            {
                $contentproxy = org_glizy_objectFactory::createObject('org.glizycms.contents.models.proxy.ModuleContentProxy');
                $result = $contentproxy->saveContent($magData);
            }
        } else {
            $contentproxy = org_glizy_objectFactory::createObject('org.glizycms.contents.models.proxy.ModuleContentProxy');
            $result = $contentproxy->saveContent($magData);
        }

        if($result) {
            return true;
        } else {
            return false;
        }
    }

}
