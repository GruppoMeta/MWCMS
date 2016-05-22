<?php
class museoweb_modules_mag_models_proxy_MagProxy extends GlizyObject
{
    const EXPORT_MAG_PER_STEP = 10;

    public function searchForAutocomplete($type, $term)
    {
        $mapping = $this->getMapping($type);
        $term = '%'.$term.'%';

        $it = org_glizy_ObjectFactory::createModelIterator($type);
        $filters = array();
        $filters[$mapping['dc_title']] = array('value' => $term, 'condition' => 'LIKE');
        $filters[$mapping['dc_identifier']] = array('value' => $term, 'condition' => 'LIKE');
        $filters[$mapping['dc_subject']] = array('value' => $term, 'condition' => 'LIKE');
        $it->setOrFilters($filters);
        $it->orderBy($mapping['dc_title']);
        $it->limit(0, 10);

        $result = array();
        foreach( $it as $ar ) {
            $data = $this->applyMapping($ar->document_detail_object, $mapping);
            $data['ref_id'] = $this->getInternalIdentifier($type, $ar);
            $result[] = array(
                    'id' => $ar->document_id,
                    'text' => $ar->$mapping['dc_title'],
                    'path' => trim($ar->$mapping['dc_identifier'].' '.$ar->$mapping['dc_subject']),
                    'data' => $data
                );
        }
        return $result;
    }


    public function getRecordInfoById($id)
    {
        list($type, $recordId, $languageId) = explode(':', $id);
        $mapping = $this->getMapping($type);
        $ar = org_glizy_objectFactory::createModel($type);
        $ar->load($recordId);
        $result = array();
        $data = $this->applyMapping($ar->getValues(), $mapping);
        $data['ref_id'] = $this->getInternalIdentifier($type, $ar);
        $result[] = array(
                    'id' => $ar->document_id,
                    'text' => $ar->$mapping['dc_title'],
                    'path' => trim($ar->$mapping['dc_identifier'].' '.$ar->$mapping['dc_subject']),
                    'data' => $data
                );
        return $result;
    }

    public function getImageInfoById($id)
    {
        $nisoProxy = org_glizy_ObjectFactory::createObject('museoweb.mediaArchive.models.proxy.NisoProxy');
        $niso = $nisoProxy->get($id);
        $media = org_glizy_ObjectFactory::createModel('org.glizycms.models.Media');
        $media->load($id);
        $file = org_glizy_media_MediaManager::getMediaById($id);
        if(isset($file) &&  method_exists ($file, 'getImageInfo')) {
            $mediaInfo = @$file->getImageInfo();
        } else {
            $mediaInfo = $media->media_fileName;
        }
        $md5 = @md5_file($mediaInfo['fileName']);
        $mag = array('mag_file_href' => $mediaInfo['fileName'],
                     'mag_filesize' => $media->media_size,
                     'mag_datetimecreated' => $media->media_creationDate,
                     'mag_md5' => $md5,
                     'img_id' => $id,
                     'imgName' => $media->media_title);
                      $data = array_merge($mag, $niso);
        return $data;
    }

    public function overrideDataWithOriginalRecordValues($id, $data)
    {
        list($type, $recordId, $languageId) = explode(':', $id);
        $mapping = $this->getMapping($type);
        $ar = org_glizy_objectFactory::createModel($type);
        $ar->load($recordId);
        $result = array();
        $data = $this->applyMapping($ar->getValues(), $mapping, $data);
        return $data;
    }

    public function overrideDataFromNiso($mode, $data)
    {
       $ids = $data->img_id;
       if($ids) {
            $nisoProxy = org_glizy_ObjectFactory::createObject('museoweb.mediaArchive.models.proxy.NisoProxy');
            foreach ($ids as $index => $id){
                if($mode[$index] === 'free') continue;
                $niso = $nisoProxy->get($id);
                foreach ($niso as $field => $value) {
                    $data->{$field}[$index] = $value ?: '';
                }
                $data->img_name[$index] = $data->imgName[$index];
            }
       }
    }

    public function getTotalsOfMagToExport($moduleId, $from, $to)
    {
        $it = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.mag.models.Model');
        /* TODO da cambiare con ref_model_id */
        if ($moduleId !== 'free') {
            $it->where('ref_id', $moduleId.'%', 'LIKE');
        } else if($moduleId === 'free') {
            $it->where('ref_id', '0');
        }
        if ($from) {
            $it->where('gen_creation', $from, '>=');
        }
        if ($to) {
            $it->where('gen_creation', $to, '<=');
        }
        return $it->count();
    }

    public function getMagIteratorToExport($moduleId, $page)
    {
        /* TODO da cambiare con ref_model_id */
        $it = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.mag.models.Model');
        $it->limit(($page - 1) * self::EXPORT_MAG_PER_STEP, self::EXPORT_MAG_PER_STEP);
        if ($moduleId !== 'free') {
            $it->where('ref_id', $moduleId.'%', 'LIKE');
        }  else if($moduleId === 'free') {
            $it->where('ref_id', '0');
        }
        $it->orderBy('document_id');
        return $it;
    }

    public function getExportFolder()
    {
        return __Paths::get('CACHE').'magExport/';
    }

    public function getExportZip()
    {
        return __Paths::get('CACHE').'magExport.zip';
    }

    public function getMagFolder()
    {
        return __Paths::get('APPLICATION_MEDIA_ARCHIVE').'Mag/';
    }


    private function getInternalIdentifier($type, $ar)
    {
        return $type.':'.$ar->document_id.':'.$ar->document_detail_FK_language_id;
    }

    private function applyMapping($document, $mapping, $result=null)
    {
        if (is_string($document))
        {
            $document = json_decode($document);
        }
        $result = is_null($result) ? array() : $result;
        foreach($mapping as $k=>$v) {
            $imgId = array();
            if ($k=='img') {
                if(!is_array($v)){
                    $v = array($v);
                }
                foreach($v as $value) {
                    $it = $document->{$value}->image_id ?: array($document->$value);
                    if($it) {
                        foreach($it as $img) {
                            if (is_string($img)) {
                                $img = json_decode($img);
                                $imgId[] = $img->id;
                            }
                        }
                    }
                }
                $document->{$v} = new StdClass;
                $document->{$v}->img_id = $imgId;
            }
            if ($v && is_array($result)) {
                $result[$k] = $document->$v ?: '';//$result[$k];
            } else if ($v) {
                $result->$k = $document->$v ?: '';//$result->$k;
            }
        }
        return $result;
    }

    public function getMapping($type)
    {
        $className = str_replace('.', '_', $type);
        if (file_exists(__DIR__.'/../../mapping/'.$className.'.php')) {
            include(__DIR__.'/../../mapping/'.$className.'.php');
            return $mapping;
        } else {
            return false;
        }
    }

}
