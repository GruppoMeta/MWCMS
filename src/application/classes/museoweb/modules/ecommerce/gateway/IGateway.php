<?php
interface museoweb_modules_ecommerce_gateway_IGateway
{
    public function pay($user, $orderId, $orderCode, $total, $items);
    public function s2s();
    public function confirm();
}
