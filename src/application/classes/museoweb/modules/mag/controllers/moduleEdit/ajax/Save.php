<?php
class museoweb_modules_mag_controllers_moduleEdit_ajax_Save extends org_glizycms_contents_controllers_moduleEdit_ajax_Save
{
    function execute($data)
    {
        if(!empty($data->img->imgRef)) {
            $this->resetImageId($data);
        }
        return parent::execute($data);
    }

    private function resetImageId(&$data) {
        $data = json_decode($data);
        foreach ($data->img->imgRef as $index => $mode) {
            if($mode == 'free') {
                $data->img->img_id[$index] =  '';
                $data->img->img_name[$index] =  '';
            }
        }
        $data = json_encode($data);
    }
}