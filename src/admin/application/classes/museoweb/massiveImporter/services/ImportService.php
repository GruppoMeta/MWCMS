<?php
set_time_limit(0);

class museoweb_massiveImporter_services_importService extends GlizyObject
{
    protected $mappedFolder;

    public function import($recordIterator, $moduleId, $mapping, $importMode, $mappedFolder = null)
    {
        $this->mappedFolder = $mappedFolder;
        $moduleService = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.ModuleService');
        $modelPath = $moduleService->getModelPath($moduleId);

        if ($importMode == 'new') {
            return $this->importData($moduleId, $moduleService, $modelPath, $recordIterator, $mapping, $importMode);
        } elseif ($importMode == 'substite') {
            // cancella i dati prima di importare
            $it = org_glizy_ObjectFactory::createModelIterator($modelPath);

            foreach ($it as $ar) {
                $ar->delete();
            }

            return $this->importData($moduleId, $moduleService, $modelPath, $recordIterator, $mapping, $importMode);
        } elseif ($importMode = 'update') {
            return $this->importData($moduleId, $moduleService, $modelPath, $recordIterator, $mapping, $importMode);
        }
    }

    protected function importData($moduleId, $moduleService, $modelPath, $recordIterator, $mapping, $importMode)
    {
        $moduleFields = $moduleService->getFields($moduleId);
        $model = org_glizy_ObjectFactory::createModel($modelPath);
        $model->enableIndexQueue();

        org_glizy_dataAccessDoctrine_DataAccess::beginTransaction();

        foreach ($recordIterator as $row) {
            if ($importMode == 'update') {
                $externalId = $mapping['external_id'];
                $model->find(array('external_id' => $row->$externalId));
            }

            $data = new StdClass();

            // mapping dei dati sui campi del model
            foreach ($mapping as $field => $mappedField) {
                if ($mappedField != '') {
                    $rowMappedField = trim($row->$mappedField);
                    $fieldComponent = $moduleFields[$field];
                    $fieldData = $fieldComponent->getAttribute('data');
                    // gestione importazione immagini
                    if (strpos($fieldData, 'type=mediapicker') !== false && $rowMappedField) {
                        $model->$field = $this->getMediaJson($rowMappedField);
                        $this->setNisoData(json_decode($model->$field));
                    // gestione importazione elenco media, elenco immagini
                    } elseif (strpos($fieldData, 'type=repeat') !== false && $rowMappedField) {
                        $medias = explode(',', $rowMappedField);

                        $imgArray = array();

                        foreach ($medias as $media) {
                            $currentImg = $this->getMediaJson($media);
                            $imgArray[] = $currentImg;
                            $this->setNisoData(json_decode($currentImg));

                        }
                        $imgId = $fieldComponent->childComponents[0]->getAttribute('id');

                        if (!empty($imgArray)) {
                            $model->$field = array($imgId => $imgArray);
                        }
                    } else {
                        $data->$field = $rowMappedField;
                        $model->$field = $rowMappedField;
                    }
                }
            }

            if ($model->fieldExists('fulltext')) {
                $model->fulltext = org_glizycms_core_helpers_Fulltext::make($data, $model, false);
            }

            try {
                $model->publish();
                $model->emptyRecord();
            } catch (org_glizy_validators_ValidationException $e) {
                org_glizy_dataAccessDoctrine_DataAccess::rollBack();
                return array('errors' => $e->getErrors());
            }
        }

        org_glizy_dataAccessDoctrine_DataAccess::commit();
        $model->executeIndexQueue();
        return true;
    }

    protected function getMediaJson($mediaMappingName)
    {
        if ($this->mappedFolder != '') {
            $mediaMappingName = $this->mappedFolder.'://'.$mediaMappingName;
        }

        $img = org_glizycms_mediaArchive_models_proxy_MediaProxy::getMediaJson($mediaMappingName);

        if ($img) {
            return $img;
        } else {
            $this->importMedia($mediaMappingName);
            return org_glizycms_mediaArchive_models_proxy_MediaProxy::getMediaJson($mediaMappingName);
        }
    }

    protected function importMedia($mediaMappingName, $copyToCMS = false)
    {
        $application = &org_glizy_ObjectValues::get('org.glizy', 'application');
        $mappingService = $application->retrieveProxy('org.glizycms.mediaArchive.services.MediaMappingService');
        $file_path = $mappingService->getRealPath(str_replace('://', '/',$mediaMappingName));
        $file_name = pathinfo($file_path, PATHINFO_BASENAME);

        $media = new stdClass();
        $media->media_fileName = $mediaMappingName;
        $media->__filePath = $file_path;
        $media->__originalFileName = $file_name;
        $media->media_title = $file_name;
        $mediaProxy = org_glizy_ObjectFactory::createObject('org.glizycms.mediaArchive.models.proxy.MediaProxy');
        return $mediaProxy->saveMedia($media, $copyToCMS, true);
    }

    private function setNisoData($currentImg){
        $media = org_glizy_media_MediaManager::getMediaById($currentImg->id);
        $nisoProxy = org_glizy_ObjectFactory::createObject('museoweb.mediaArchive.models.proxy.NisoProxy');
        if (method_exists($media, 'getOriginalSizes')) {
            $originalSize = $media->getOriginalSizes();
            $nisoData = $nisoProxy->getDataFromImage($currentImg->id, $currentImg->filename, $originalSize);
            $nisoData = array_merge(__Session::get('nisoData'), $nisoData);
            $nisoProxy->save($nisoData, __Session::get('nisoMode'));
        }
    }
}
