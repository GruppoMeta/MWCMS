<?php
class museoweb_modules_ecommerce_controllers_Login extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        if ( $this->user->isLogged()) {
            $url = __Session::get( 'glizy.loginUrl', GLZ_HOST.'/'.__Link::makeUrl( 'museoweb_ecommReport' ) );
            __Session::remove( 'glizy.loginUrl' );
            org_glizy_helpers_Navigation::gotoUrl( $url );
        }
    }
}