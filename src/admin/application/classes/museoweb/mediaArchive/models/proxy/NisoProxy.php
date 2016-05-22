<?php

class museoweb_mediaArchive_models_proxy_NisoProxy extends GlizyObject
{
    public function save($data, $mode = 'edit')
    {
        $niso = org_glizy_ObjectFactory::createModel('museoweb.mediaArchive.models.Niso');
        if ($mode === 'add') {
          $this->getExifData($niso, $data['niso_FK_media_id']);
        } else if ($mode === 'insertNew' && $niso->find(array('niso_FK_media_id' => $data['niso_FK_media_id']))) {
                return;
        } else if ($mode ==='edit' && !$niso->find(array('niso_FK_media_id' => $data->media_id))) {
          return;
        }
        $this->setNisoData($data, $niso, $mode);
        return $niso->save();
    }

    public function get($imageId)
    {
        if($imageId)
        {
          $ar = org_glizy_ObjectFactory::createModel('museoweb.mediaArchive.models.Niso');
          $ar->find(array('niso_FK_media_id' => $imageId));
          return (array)$ar->getValuesForced();
        } else {
          $ar = org_glizy_ObjectFactory::createModel('museoweb.mediaArchive.models.Niso');
          return (array)$ar->getValuesForced();
        }
    }

    public function delete($id)
    {
        $ar = org_glizy_ObjectFactory::createModel('museoweb.mediaArchive.models.Niso');
        $ar->delete(array('niso_FK_media_id' => $id));
    }

    public function setNisoData($data, $niso, $mode = 'edit')
    {
        foreach ($data as $k => $v) {
            if (!$niso->fieldExists($k) || !$v || ($niso->$k && $mode === 'updateEmpty') ) continue;
            if($k === 'niso_source_ydimension' || $k === 'niso_source_xdimension' ||
               $k === 'niso_ysamplingfrequency' || $k === 'niso_xsamplingfrequency' ) {
               $v = abs($v);
               if($k === 'niso_ysamplingfrequency' || $k === 'niso_ysamplingfrequency') {
                 $v = round($v);
               }
            }
            $niso->$k = $v;
        }
    }

    public function getDataFromImage($id, $name, $size) {
        $ext = strtolower(substr(strrchr($name, '.'),1));
        $mime = $this->getMime($ext);
        return array( 'niso_FK_media_id' => $id,
                            'niso_imagelength' => $size['height'],
                            'niso_imagewidth' => $size['width'],
                            'niso_name' => $ext,
                            'niso_mime' => $mime ?: false
                           );
    }

   private function getMime($extension) {
        $ctype = false;
        switch( $extension )
        {
          case "gif": $ctype="image/gif"; break;
          case "png": $ctype="image/png"; break;
          case "jpeg":
          case "jpg": $ctype="image/jpeg"; break;
          case "tiff":
          case "tif": $ctype="image/tiff"; break;
        }
        return $ctype;
    }

    private function getExifData($niso, $id) {
      $ar = org_glizy_ObjectFactory::createModel('org.glizycms.mediaArchive.models.Exif');
        $result = $ar->find(array('exif_FK_media_id' => $id));
        if($result) {
            $niso->niso_scanner_manufacturer = $ar->exif_make;
            $niso->niso_scanner_model = $ar->exif_model;
            if($ar->exif_resolution !='') {
                $niso->niso_samplingfrequencyunit = '2';
                list($niso->niso_xsamplingfrequency, $niso->niso_ysamplingfrequency) = explode('x', $ar->exif_resolution);
            }
        }
    }

}
