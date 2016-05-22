<?php
class museoweb_modules_routes_views_components_LinkedRoute extends org_glizy_components_RecordSetList
{
    function init()
    {
        $this->defineAttribute('dataProvider',    false,     NULL,    COMPONENT_TYPE_OBJECT);  // override parent definition because must be not mandatory
        $this->defineAttribute('routeId',    false,     NULL,    COMPONENT_TYPE_STRING);
        parent::init();

        $this->canHaveChilds = false;
    }

    public function process()
    {
        $cssClass = explode(',', $this->getAttribute('cssClass'));

        $this->_content = new org_glizy_components_RecordSetListVO();
        $this->_content->pageType = $this->_application->getPageType();
        $this->_content->title = $this->getAttributeString('title');
        $this->_content->total = 0;

        $iterator = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.routes.models.Route');
        $routeId = $this->getAttribute('routeId');
        if (!$routeId) {
            $routeId = __Request::get(museoweb_modules_routes_Module::MW_RouteThemes);
        }
        $iterator->where('routedetail_FK_routetheme_id', $routeId);

        $this->_content->records = new org_glizy_components_RecordSetListIterator( $this->_application, $this, $iterator, $this->routeUrl, $cssClass, $this->getAttribute('processCell') );
        $this->_content->total = $iterator->count();
    }
}