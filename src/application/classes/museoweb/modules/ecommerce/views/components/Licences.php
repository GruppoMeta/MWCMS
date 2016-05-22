<?php
class museoweb_modules_ecommerce_views_components_Licences extends org_glizy_components_RecordSetList
{
    function init()
    {
        $this->defineAttribute('dataProvider', false, NULL, COMPONENT_TYPE_OBJECT);
        parent::init();

        // todo: tradurre
        $this->setAttributes(array(
                            'skin' => 'Ecomm_licences.html',
                            'title' => __T('Licenze disponibili'),
                            'processCell' => 'museoweb.modules.ecommerce.views.renderers.CellAddCart',
                            'controllerName' => 'museoweb.modules.ecommerce.controllers.AddCart'
                            ));
    }

    function process()
    {
        $cssClass = explode(',', $this->getAttribute('cssClass'));

        $this->_content = new org_glizy_components_RecordSetListVO();
        $this->_content->title = $this->getAttributeString('title');
        $this->_content->pageType = $this->_application->getPageType();
        $this->_content->total = 0;

        $modulePref = museoweb_modules_ecommerce_Helper::getModuleSetting($this->_application->getPageType());
        if ($modulePref) {
            $ar = $this->getAttribute('record');

            if ($ar->{$modulePref->checkField->id}) {
                $iterator = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.ecommerce.models.Licence', 'licencesToBuy');

                $this->_content->records = new org_glizy_components_RecordSetListIterator( $this->_application, $this, $iterator, $this->routeUrl, $cssClass, $this->getAttribute('processCell'), $ar->getId() );
                $this->_content->total = $iterator->count();
            }
        }
    }
}
