<?php
class museoweb_modules_ecommerce_views_components_CatalogRecordDetail extends org_glizy_components_RecordDetail
{
    private $licencesComponent;

    function init()
    {
        parent::init();

        $this->licencesComponent = org_glizy_ObjectFactory::createComponent('museoweb.modules.ecommerce.views.components.Licences', $this->_application, $this->_parent, 'Licences', 'licences');


        $this->_parent->addChild($this->licencesComponent);
        $this->licencesComponent->init();
    }

    function process()
    {
        parent::process();
        $this->licencesComponent->setAttribute('record', $this->ar);
    }
}
