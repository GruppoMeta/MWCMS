<?php
class museoweb_modules_ecommerce_views_components_Orders extends org_glizy_components_Component
{
    function process()
    {
        $url = __Request::get('__url__');

        $this->_content = array();
        $this->_content[ 'records' ] = array();
        $this->_content[ 'redirect' ] = '';

        $maxDownloads = museoweb_modules_ecommerce_Helper::getNumDownloads();
        $maxDays = museoweb_modules_ecommerce_Helper::getDownloadExpirationDays();

        $it = org_glizy_ObjectFactory::createModelIterator( 'museoweb.modules.ecommerce.models.OrderItem' )
                    ->load('completedForUser', array('userId' => $this->_user->id));

        $orderId = 0;
        $orderDate = 0;
        $items = array();
        foreach($it as $ar) {
            if ( $orderId != $ar->order_id ) {
                if ( count( $items ) ) {
                    org_glizy_helpers_Array::arrayMultisortByLabel( $items, 'orderitem_title' );
                    $this->_content[ 'records' ][] = array( 'date' => $orderDate2, 'items' => $items );
                }
                $items = array();
                $orderId = $ar->order_id;
                $orderDate2 = glz_defaultDate2locale( __T( GLZ_DATETIME_FORMAT ), $ar->order_date );
            }

            $urlDownload = museoweb_modules_ecommerce_Helper::makeDownloadUrl($url, $ar->orderitem_id);

            // controlla se si ha ancora diritto al download
            if ( $ar->orderitem_downloads >= $maxDownloads ) $urlDownload = '';

            $orderDate = preg_replace( "/(\d{4}-\d{2}-\d{2}).*/", "$1", $ar->order_date );
            list( $y, $m, $d ) = explode( "-", $orderDate );
            $orderDate = mktime(0, 0, 0, $m, $d, $y);
            if ( mktime() - $orderDate > ( $maxDays * 60 * 60 * 24 ) ) $urlDownload = '';

            $arLicence = json_decode($ar->document_detail_object);
            $items[] = array(
                             '__url__' => $ar->orderitem_url,
                             '__urlDownload__' => $urlDownload,
                             'licence_name' => $arLicence->licence_name,
                             'licence_use' => $arLicence->licence_use,
                             'title' => $ar->orderitem_title,
                            );
        }

        if ( count( $items ) ) {
            org_glizy_helpers_Array::arrayMultisortByLabel( $items, 'title' );
            $this->_content[ 'records' ][] = array( 'date' => $orderDate2, 'items' => $items );
        }


        $url =  org_glizy_Session::get('museoweb.ecommerce.download', $destPage);
        if ($url) {
            $this->_content[ 'redirect' ] = $url;
            org_glizy_Session::remove('museoweb.ecommerce.download' );
        }
    }
}
