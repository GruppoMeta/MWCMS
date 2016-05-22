<?php
class museoweb_modules_ecommerce_controllers_Checkout extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        $itemsInCart = museoweb_modules_ecommerce_Helper::itemsInCart();

        if ($itemsInCart==0) {
            $this->changeAction('ShowCart');
        }

        if (!$this->user->isLogged()) {
            __Session::set( 'glizy.loginUrl', GLZ_HOST.'/'.__Request::get( '__url__' ) );
            $this->changeAction('login');
        }

        $prefix = museoweb_modules_ecommerce_Helper::getPrefix();

        // memorizza il carrello nel DB
        $arOrder = org_glizy_ObjectFactory::createModel('museoweb.modules.ecommerce.models.Order');
        $arOrder->order_date = new org_glizy_types_DateTime();
        $arOrder->order_state = 'open';
        $arOrder->order_FK_user_id = $this->user->id;
        $orderId = $arOrder->save();
        $orderCode = $prefix.'-'.str_pad( $orderId, 6, '0', STR_PAD_LEFT);
        $arOrder->order_code = $orderCode;
        $arOrder->save();

        $cart = museoweb_modules_ecommerce_Helper::getCart();
        $arItem = org_glizy_ObjectFactory::createModel( 'museoweb.modules.ecommerce.models.OrderItem' );
        $total = 0;
        $items = array();
        foreach($cart as $k=>$v) {
            $total += $v['licence_price'];

            $arItem->emptyRecord();
            $arItem->orderitem_FK_order_id = $orderId;
            $arItem->orderitem_price = $v['licence_price'];
            $arItem->orderitem_code = $v[ '__code__' ];
            $arItem->orderitem_title = $v[ 'title' ];
            $arItem->orderitem_url = $v[ '__url__' ];
            $arItem->orderitem_FK_license_id = $v[ 'licenceId' ];
            $arItem->save();

            $items[] = array(
                                'price' => $v['licence_price'],
                                'code' => $v['__code__'],
                                'title' => $v['title'].' - '.$v['licence_name']
                );
        }

        $total= number_format( $total, 2, '.', '' );
        $gateway = org_glizy_ObjectFactory::createObject(__Config::get('museoweb.ecommerce.gateway'));
        if ($gateway) {
            if (!$gateway->pay($this->user, $orderId, $orderCode, $total, $items)) {
                org_glizy_application_MessageStack::add(__T('Errore nella procedura di pagamento'), GLZ_MESSAGE_ERROR);
                $this->changeAction('report');
            }
        } else {
            $this->changePage('museoweb_ecommConfirmError');
        }
    }
}