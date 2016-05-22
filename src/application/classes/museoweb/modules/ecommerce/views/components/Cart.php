<?php
class museoweb_modules_ecommerce_views_components_Cart extends org_glizy_components_Component
{
    function init()
    {
        $this->defineAttribute('isReport', false, false, COMPONENT_TYPE_BOOLEAN);
        parent::init();
    }

    function process()
    {
        $url = __Request::get('__url__');
        $this->_content = array();
        $this->_content[ 'title' ] = $this->getAttribute( 'title' );
        $this->_content[ 'records' ] = array_merge(array(), museoweb_modules_ecommerce_Helper::getCart());
        $this->_content[ 'isReport' ] = $this->getAttribute( 'isReport' );
        $tot = 0;
        foreach( $this->_content[ 'records' ] as $k=>&$v )
        {
            $tot += $v[ 'licence_price' ];
            $v['__url__'] = $url.'?deleteCart=1&id='.urlencode(base64_encode($k));
        }

        $this->_content[ 'total' ] = number_format( $tot, 2, '.', '' );
        org_glizy_helpers_Array::arrayMultisortByLabel( $this->_content[ 'records' ], 'title' );
    }
}
