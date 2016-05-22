<?php
class museoweb_modules_ecommerce_views_components_admin_OrderDetail extends org_glizy_components_Component
{
    function render()
    {
        $recordId = __Request::get('id');
        $itOrder = org_glizy_ObjectFactory::createModelIterator( 'museoweb.modules.ecommerce.models.OrderItem',
                                                                    'orderDetailForAdmin',
                                                                    array(
                                                                            'filters' => array( 'orderitem_FK_order_id = '.$recordId ),
                                                                            'checkIntegrity' => false ) );

        $output = '';
        while ( $itOrder->hasMore() )
        {
            $ar = $itOrder->current();
            $itOrder->next();

            if ( empty( $output ) )
            {
// TODO: localizzare
                // dati dell'utente
                $output = '<h4>Dati dell\'utente</h4>';
                $output .= '<ul>';
                $output .= '<li>Nome: <strong>'.$ar->user_firstName.'</strong></li>';
                $output .= '<li>Cognome: <strong>'.$ar->user_lastName.'</strong></li>';
                $output .= '<li>Email: <strong>'.$ar->user_email.'</strong></li>';
                $output .= '<li>Indirizzo: <strong>'.$ar->user_address.'</strong></li>';
                $output .= '<li>Città: <strong>'.$ar->user_city.'</strong></li>';
                $output .= '<li>Provincia: <strong>'.$ar->user_state.'</strong></li>';
                $output .= '<li>CAP: <strong>'.$ar->user_zip.'</strong></li>';
                $output .= '<li>Nazione: <strong>'.$ar->user_country.'</strong></li>';
                $output .= '<li>Partita IVA: <strong>'.$ar->user_iva.'</strong></li>';
                $output .= '<li>Codice Fiscale: <strong>'.$ar->user_cf.'</strong></li>';
                $output .= '</ul>';

                $output .= '<h4>Dati della transazione</h4>';
                $output .= '<ul>';
                $output .= '<li>Codice ordine: <strong>'.$ar->order_code.'</strong></li>';
                $output .= '<li>Numero transazione: <strong>'.$ar->order_transactionCode.'</strong></li>';
                $output .= '<li>Data: <strong>'.$ar->order_date     .'</strong></li>';
                $output .= '</ul>';

                $output .= '<h4>Oggetti acquistati</h4>';
            }

            $output .= '<div class="ecommOrderItem">';
            $output .= '<ul>';
            $output .= '<li>Codice oggetto: <strong>'.$ar->orderitem_catalogCode.'</strong></li>';
            $output .= '<li>Titolo: <strong>'.$ar->catalogdetail_title.'</strong></li>';
            $output .= '<li>Licenza: <strong>'.$ar->licensedetail_name.'</strong></li>';
            $output .= '<li>Licenza Uso: <strong>'.$ar->licensedetail_use.'</strong></li>';
            $output .= '<li>Prezzo: <strong>&euro; '.$ar->orderitem_price.'</strong></li>';
            $output .= '</div>';

        }

        $this->addOutputCode( $output );
    }
}
