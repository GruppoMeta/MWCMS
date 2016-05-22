<?php
class museoweb_modules_mountings_views_components_LinkedParts extends org_glizy_components_RecordSetList
{
    function init()
    {
        $this->defineAttribute('dataProvider',    false,     NULL,    COMPONENT_TYPE_OBJECT);
        parent::init();

        $this->canHaveChilds = false;
    }

    public function process()
    {
        $value = $this->_parent->loadContent('document_id');
        $cssClass = explode(',', $this->getAttribute('cssClass'));

        $this->_content = new org_glizy_components_RecordSetListVO();
        $this->_content->pageType = $this->_application->getPageType();
        $this->_content->title = $this->getAttributeString('title');
        $this->_content->total = 0;
        $this->_content->records = null;

        if ($value) {
            $iterator = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.mountings.models.MountingPart');
            $iterator->where('mountingpartdetail_FK_mounting_id', $value);
            $iterator->orderBy('mountingpartdetail_title');

            $this->_content->records = new org_glizy_components_RecordSetListIterator( $this->_application, $this, $iterator, $this->routeUrl, $cssClass, $this->getAttribute('processCell') );
            $this->_content->total = $iterator->count();
            if ($this->_content->total==0) {
                $this->_content->records = null;
            }
        }
    }
}