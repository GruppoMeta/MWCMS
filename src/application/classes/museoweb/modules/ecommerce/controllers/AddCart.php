<?php
class museoweb_modules_ecommerce_controllers_AddCart extends org_glizy_mvc_core_Command
{
    public function execute($addToCart, $licId, $id)
    {
        if ($addToCart && $licId && $id) {
            $selfUrl = GLZ_HOST.'/'.__Request::get('__url__');
            $modulePref = museoweb_modules_ecommerce_Helper::getModuleSetting($this->application->getPageType());

            // check if the record and licence exixts
            $ar = $this->view->getAttribute('record');
            $arL = org_glizy_ObjectFactory::createModel('museoweb.modules.ecommerce.models.Licence');
            $r = $arL->load($licId);
            if ($modulePref && is_object($ar) && $ar->getId()==$id && $r) {
                $cart = museoweb_modules_ecommerce_Helper::getCart();
                $cartkey = museoweb_modules_ecommerce_Helper::createCode($modulePref->id, $ar->getClassName(false), $id, $licId);
                if ( !array_key_exists( $cartkey, $cart ) ) {
                    $cart[$cartkey] = array( 'recordId' => $id,
                                             'licenceId' => $licId,
                                             'licence_name' => $arL->licence_name,
                                             'licence_use' => $arL->licence_use,
                                             'licence_price' => $arL->licence_price,
                                             'title' => $ar->{$modulePref->idField},
                                             '__code__' => $cartkey,
                                             '__url__' => $selfUrl
                                            );
                    // todo: localizzare
                    org_glizy_application_MessageStack::add(__T('Prodotto aggiunto al carrello'), GLZ_MESSAGE_SUCCESS);
                    museoweb_modules_ecommerce_Helper::saveCart($cart);
                }
            }
            org_glizy_helpers_Navigation::gotoUrl($selfUrl);
        }
    }
}