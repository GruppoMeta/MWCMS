<?php
class museoweb_modules_ecommerce_controllers_Download extends org_glizy_mvc_core_Command
{
    public function execute($download, $id)
    {
        if (!$this->user->isLogged()) {
            __Session::set( 'glizy.loginUrl', GLZ_HOST.'/'.__Request::get('__url__'));
            __Session::set( 'museoweb.ecommerce.download', GLZ_HOST.'/'.__Request::get('__url__').'?'.__Request::get('__back__url__') );
            $this->changeAction('login');
        }

        // todo: localizzare
        if ( $download && $id) {
            require_once(org_glizy_Paths::get('APPLICATION').'/libs/dZip.inc.php');
            set_time_limit(0);
            $selfUrl = GLZ_HOST.'/'.__Request::get('__url__');

            if ( $this->user->isLogged()) {
                $error = '';
                $id = (int)base64_decode($id);
                $it = org_glizy_ObjectFactory::createModelIterator( 'museoweb.modules.ecommerce.models.OrderItem' )
                    ->load('download', array(
                                'userId' => $this->user->id,
                                'orderItemId' => $id
                                ));
                $ar = $it->first();
                $itemDetails = museoweb_modules_ecommerce_Helper::getDetailsFromCode($ar->orderitem_code);

                if ($ar && $itemDetails) {
                    $maxDownloads = museoweb_modules_ecommerce_Helper::getNumDownloads();
                    $maxDays = museoweb_modules_ecommerce_Helper::getDownloadExpirationDays();

                    // controlla il numero di download effettuati
                    if ( $ar->orderitem_downloads <= $maxDownloads ) {
                        // controlla la scadenza
                        $orderDate = preg_replace( "/(\d{4}-\d{2}-\d{2}).*/", "$1", $ar->order_date );
                        list( $y, $m, $d ) = explode( "-", $orderDate );
                        $orderDate = mktime(0, 0, 0, $m, $d, $y);

                        if ( mktime() - $orderDate < ( $maxDays * 60 * 60 * 24 ) ) {
                            $ar->orderitem_downloads++;
                            $ar->save();
                            if (!$this->downloadFile($itemDetails)) {
                                $error = __T( 'Problemi nel recupero del file, contattare l\'amministratore del sistema' );
                            }

                        } else {
                            $error = __T( 'Sono passati più di '.$maxDays.' giorni dall\'acquisto, il tempo per il download è scaduto.' );
                        }
                    }
                    else
                    {
                        $error = __T( 'Si è raggiunto il numero massimo di download consentiti.' );
                    }
                } else {
                    $error = __T( 'Si sta cercando di scaricare un ordine non esistente.' );
                }

                if ( $error ) {
                    org_glizy_application_MessageStack::add( $error, GLZ_MESSAGE_ERROR );
                }
            }

            org_glizy_helpers_Navigation::gotoUrl( $selfUrl );
        }
    }

    private function downloadFile($itemDetails)
    {
        $zipPath = __Paths::get('CACHE').uniqid(true).'.zip';
        $zip = new dZip($zipPath);

        $itemsAdded = 0;
        foreach($itemDetails['media'] as $item) {
            $mediaId = $item->id;
            $media = org_glizycms_mediaArchive_MediaManager::getMediaById($mediaId);

            if (!$media || !$media->exists()) {
                continue;
            }

            $itemsAdded++;
            if ($itemDetails['licence']->licence_action=='resize') {
                $mediaInfo = $media->getResizeImage($itemDetails['licence']->licence_w, $itemDetails['licence']->licence_h);
                $filename = $mediaInfo['fileName'];
            } else {
                $filename = $media->getFileName();
            }

            $zip->addFile($filename, $media->originalFileName);
        }

        if (!$itemsAdded) {
            return false;
        } else {
            $zip->save();
        }

        $extension = 'zip';
        $originalFileName = 'ordine.zip';
        $browser = $this->id_browser();
        switch( $extension )
        {
            case "pdf": $ctype="application/pdf"; break;
            case "vcf": $ctype="application/vcard"; break;
            case "exe":
                $ctype= ($browser=='IE' || $browser=='OPERA') ? "application/octetstream" : "application/octet-stream";
                break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default: $ctype="application/force-download";
        }

        header("Pragma: public");
        header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: $ctype");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment; filename=\"".$originalFileName."\"");
        @readfile($zipPath) or die();
        @unlink($zipPath);
        exit;
    }


    private function id_browser()
    {
        $browser=$GLOBALS['__SERVER']['HTTP_USER_AGENT'];

        if(ereg('Opera(/| )([0-9].[0-9]{1,2})', $browser)) {
           return 'OPERA';
        } else if(ereg('MSIE ([0-9].[0-9]{1,2})', $browser)) {
           return 'IE';
        } else if(ereg('OmniWeb/([0-9].[0-9]{1,2})', $browser)) {
           return 'OMNIWEB';
        } else if(ereg('(Konqueror/)(.*)', $browser)) {
           return 'KONQUEROR';
        } else if(ereg('Mozilla/([0-9].[0-9]{1,2})', $browser)) {
           return 'MOZILLA';
        } else {
           return 'OTHER';
        }
    }
}
