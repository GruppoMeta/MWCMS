<?php
class museoweb_modules_ecommerce_controllers_Index extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        $itemsInCart = museoweb_modules_ecommerce_Helper::itemsInCart();
        $this->setComponentsVisibility('panelButtons', $itemsInCart!=0);
    }
}