<?php
class museoweb_modules_touristRoutes_views_components_LinkedSite extends org_glizy_components_RecordSetList
{
    function init()
    {
        $this->defineAttribute('dataProvider',    false,     NULL,    COMPONENT_TYPE_OBJECT);  // override parent definition because must be not mandatory
        $this->defineAttribute('inverse',    false,     false,    COMPONENT_TYPE_BOOLEAN);
        parent::init();

        $this->canHaveChilds = false;
    }

    public function process()
    {
        $inverse = $this->getAttribute('inverse');
        $values = !$inverse ? $this->_parent->loadContent($this->getId()) : array($this->_parent->loadContent('document_id'));
        $cssClass = explode(',', $this->getAttribute('cssClass'));

        $this->_content = new org_glizy_components_RecordSetListVO();
        $this->_content->pageType = $this->_application->getPageType();
        $this->_content->title = $this->getAttributeString('title');
        $this->_content->total = 0;
        $this->_content->records = null;

        if (is_array($values) && count($values)) {
            $iterator = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.touristRoutes.models.Site');

            $i = 0;
            foreach ($values as $v) {
                if ($i++ > 0 ) {
                    $iterator->newQueryInOr();
                }
                if (!$inverse) {
                    $iterator->where('document_id', $v->id);
                } else {
                    $iterator->where('touristsitedetail_FK_touristroute', $v);
                }
            }

            $this->_content->records = new org_glizy_components_RecordSetListIterator( $this->_application, $this, $iterator, $this->routeUrl, $cssClass, $this->getAttribute('processCell') );
            $this->_content->total = $iterator->count();
            if ($this->_content->total==0) {
                $this->_content->records = null;
            }
        }
    }
}