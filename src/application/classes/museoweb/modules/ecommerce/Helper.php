<?php
class museoweb_modules_ecommerce_Helper extends GlizyObject
{
    const CART_NAME = "mwEcommCart";
    private $pref;

    public function __construct()
    {
        $this->pref = self::getRegistry();
        if ($this->pref && $this->pref->enabled) {
            $this->addEventListener(GLZ_EVT_START_PROCESS, $this);
            __Config::set('mwcms.ecomm.enabled', true);
        }
    }

    public function onProcessStart($evt)
    {
        $application = org_glizy_ObjectValues::get('org.glizy', 'application');
        $pageType = $application->getPageType();
        if (is_object($this->pref) && property_exists($this->pref->fe, $pageType) && $this->pref->fe->{$pageType}) {
            // override component
            org_glizy_ObjectFactory::remapClass('org.glizy.components.RecordDetail', 'museoweb.modules.ecommerce.views.components.RecordDetail');
            org_glizy_ObjectFactory::remapClass('museoweb.modules.catalogs.views.components.CatalogRecordDetail', 'museoweb.modules.ecommerce.views.components.CatalogRecordDetail');
        }

        // add the cart button
        $rootComponent = $application->getRootComponent();
        $cartBarComponent = org_glizy_ObjectFactory::createComponent('museoweb.modules.ecommerce.views.components.CartBar', $application, $rootComponent, 'CartBar', 'cartBar');
        $cartBarComponent->init();
        $rootComponent->addChild($cartBarComponent);
    }

    static function setRegistry($value)
    {
        org_glizy_Registry::set('museoweb/ecommerce', serialize($value));
    }

    static function getRegistry()
    {
        $value = unserialize(org_glizy_Registry::get('museoweb/ecommerce'));
        if (!$value || !is_object($value)) {
            $value = new StdClass;
            $value->enabled = false;
        }
        return $value;
    }

    static function getModuleSetting($pageType)
    {
        $pref = self::getRegistry();
        $modules = org_glizy_Modules::getModules();
        foreach($modules as $k=>$v) {
            if ($v->pageType==$pageType) {
                $temp = $pref->{$k};
                if ($temp) {
                    $temp->id = $k;
                    return $temp;
                }
            }
        }
        return false;
    }

    static function getPrefix()
    {
        $pref = self::getRegistry();
        return $pref->prefix;
    }

    static function createCode($moduleId, $model, $id, $licId)
    {
        return $moduleId.'#'.$model.'#'.$id.'#'.$licId;
    }

    static function getNumDownloads()
    {
        $pref = self::getRegistry();
        $val = (int)$pref->numDownloads;
        return $val ? $val : 10000;
    }

    static function getDownloadExpirationDays()
    {
        $pref = self::getRegistry();
        $val = (int)$pref->downloadExpirationDays;
        return $val ? $val : 10000;
    }

    static function saveCart($cart)
    {
        return __Session::set(self::CART_NAME, $cart);
    }

    static function getCart()
    {
        return __Session::get(self::CART_NAME, array());
    }

    static function resetCart()
    {
        return __Session::set(self::CART_NAME, array());
    }

    static function itemsInCart()
    {
        return count(self::getCart());
    }

    static function getDetailsFromCode($code)
    {
        list($moduleId, $model, $documentId, $licenceId) = explode('#', $code);
        $ar = org_glizy_ObjectFactory::createModel($model);
        $r1 = $ar->load($documentId);

        $arL = org_glizy_ObjectFactory::createModel('museoweb.modules.ecommerce.models.Licence');
        $r2 = $arL->load($licenceId);

        $modules = org_glizy_Modules::getModules();
        if ($r1 && $r2 && isset($modules[$moduleId])) {
            $modulePref = self::getModuleSetting($modules[$moduleId]->pageType);
            if ($modulePref) {
                $value = $ar->{$modulePref->mediaField->id};
                if (is_object($value)) {
                    $keys = array_keys((array)$value);
                    $tempValue = array();
                    foreach($value->{$keys[0]} as $v) {
                        $tempValue[] = json_decode($v);
                    }
                    $value = $tempValue;
                } else {
                    $value = array(json_decode($ar->{$modulePref->mediaField->id}));
                }
                return array('media' => $value, 'licence' => $arL);
            }
        }

        return null;
    }

    static function makeDownloadUrl($baseUrl, $orderItemId)
    {
        return $baseUrl.'?download=1&id='.urlencode(base64_encode($orderItemId));
    }
}
