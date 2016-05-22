<?php
class museoweb_modules_ecommerce_gateway_AbstractGateway
{
    public function sendEmail($orderId, $arOrder=null)
    {
        $pref = museoweb_modules_ecommerce_Helper::getRegistry();
        if (!$arOrder) {
            $arOrder = org_glizy_ObjectFactory::createModel('museoweb.modules.ecommerce.models.Order');
            $r = $arOrder->load($orderId);
            if (!$r || $arOrder->order_state != 'completed') {
                // TODO: controllo errore se non esiste l'ordine
            }
        }

        $arUser = org_glizy_ObjectFactory::createModel('org.glizy.models.User');
        $arUser->load($arOrder->order_FK_user_id);

        // invia l'email di conferma
        $url = __Link::makeUrl('museoweb_ecommOrders');
        $orders = array();
        $ordersInternal = array();
        $it = org_glizy_ObjectFactory::createModelIterator( 'museoweb.modules.ecommerce.models.OrderItem' )
            ->load('orderDetails', array(
                        'userId' => $arOrder->order_FK_user_id,
                        'orderId' => $arOrder->order_id
                        ));
        foreach($it as $ar) {
            $arLicence = json_decode($ar->document_detail_object);
            $stringOrder = $ar->orderitem_title.'<br />';
            $stringOrder .= $arLicence->licence_name.', '.$arLicence->licence_use.' ,'.$ar->orderitem_price.'<br />';
            $stringOrder .= museoweb_modules_ecommerce_Helper::makeDownloadUrl($url, $ar->orderitem_id);
            $orders[] = $stringOrder;

            $stringOrder = $ar->orderitem_title.'<br />';
            $stringOrder .= $arLicence->licence_name.', '.$arLicence->licence_use.' ,'.$ar->orderitem_price.'<br />';
            $stringOrder .= $ar->orderitem_url.'<br /><br />';
            $ordersInternal[] = $stringOrder;
        }

        $emailInfo = org_glizy_helpers_Mail::getEmailInfoStructure();
        $emailInfo[ 'ORDER_NUM' ] = $arOrder->order_code;
        $emailInfo[ 'ORDER_DATE' ] = $arOrder->order_date;
        $emailInfo[ 'USER' ] = $arUser->user_firstName.' '.$arUser->user_lastName;
        $emailInfo[ 'USER_EMAIL' ] = $arUser->user_email;
        $emailInfo[ 'USER_ADDRESS' ] = $arUser->user_address;
        $emailInfo[ 'USER_CITY' ] = $arUser->user_city;
        $emailInfo[ 'USER_ZIP' ] = $arUser->user_zip;
        $emailInfo[ 'USER_STATE' ] = $arUser->user_state;
        $emailInfo[ 'USER_PHONE' ] = $arUser->user_phone;
        $emailInfo[ 'USER_MOBILE' ] = $arUser->user_mobile;
        $emailInfo[ 'USER_CF' ] = $arUser->user_fiscalCode. ' '.$arUser->user_vat;
        $emailInfo[ 'SITE_NAME' ] = __Config::get('APP_NAME');

        // email esterna
        $emailInfo[ 'ORDERS' ] = implode( '<br />', $orders );
        $emailInfo[ 'EMAIL' ] = $arUser->user_email;
        $emailInfo[ 'FIRST_NAME' ] = $arUser->user_firstName;
        $emailInfo[ 'LAST_NAME' ] = $arUser->user_lastName;
        org_glizy_helpers_Mail::sendEmailFromTemplate( 'ecommConfirmExternal', $emailInfo );

        // email interna
        if ($pref->confirmEmail) {
            $emailInfo[ 'ORDERS' ] = implode( '<br />', $ordersInternal );
            $emailInfo[ 'EMAIL' ] = $pref->confirmEmail;
            $emailInfo[ 'FIRST_NAME' ] = '';
            $emailInfo[ 'LAST_NAME' ] = '';
            org_glizy_helpers_Mail::sendEmailFromTemplate( 'ecommConfirmInternal', $emailInfo );
        }
    }
}
