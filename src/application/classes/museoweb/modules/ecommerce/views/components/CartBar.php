<?php
class museoweb_modules_ecommerce_views_components_CartBar extends org_glizy_components_Component
{
    function render()
    {
        // todo: localizzare
        $itemsInCart = museoweb_modules_ecommerce_Helper::itemsInCart();
        $label = __T('Il mio carrello').( $itemsInCart ? ' ('.$itemsInCart.')' : '' );
        $output = __Link::makeLink( 'museoweb_ecommShowCart', array( 'title' => $label ) );
        $this->addOutputCode( $output );
    }
}
