<?php
class museoweb_modules_ecommerce_controllers_admin_Index extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        $data = museoweb_modules_ecommerce_Helper::getRegistry();
        foreach($data as $k=>$v) {
            if (is_object($v)) {
                $data->{$k} = json_encode($v);
                $data->{'ck_'.$k} = $v->enabled ? 1 : 0;
            }
        }
        $this->view->setData($data);
    }
}