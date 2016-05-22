<?php
class museoweb_modules_comments_views_components_Comments extends org_glizy_components_RecordSetList
{
    function init()
    {
        $this->defineAttribute('dataProvider',    false,     NULL,    COMPONENT_TYPE_OBJECT);  // override parent definition because must be not mandatory
        $this->defineAttribute('addComment',    false,     false,    COMPONENT_TYPE_BOOLEAN);
        $this->defineAttribute('resourseId',    false,     '',    COMPONENT_TYPE_STRING);
        $this->defineAttribute('processCell',    false,     'museoweb.modules.comments.views.renderer.CellComment',    COMPONENT_TYPE_STRING);
        parent::init();

        $this->canHaveChilds = false;
    }

    public function process()
    {
        $cssClass = explode(',', $this->getAttribute('cssClass'));

        $this->_content = new org_glizy_components_RecordSetListVO();
        $this->_content->pageType = $this->_application->getPageType();
        $this->_content->title = $this->getAttributeString('title');
        $this->_content->params = new StdClass;
        $this->_content->params->addComment = $this->getAttribute('addComment');
        $this->_content->total = 0;

        $commentProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.comments.models.CommentProxy');
        $iterator = $commentProxy->getCommentsForResourceId($this->getAttribute('resourseId'));

        $this->_content->records = new org_glizy_components_RecordSetListIterator( $this->_application, $this, $iterator, $this->routeUrl, $cssClass, $this->getAttribute('processCell') );
        $this->_content->total = $iterator->count();
    }
}
