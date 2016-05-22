<?php
class museoweb_modules_ecommerce_controllers_Server extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        $gateway = org_glizy_ObjectFactory::createObject(__Config::get('museoweb.ecommerce.gateway'));
        if ($gateway) {
            $gateway->s2s();
        }
    }
}