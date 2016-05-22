<?php
class museoweb_modules_blog_views_renderer_CellPost extends org_glizy_components_render_RenderCellRecordSetList
{
    private $commentProxy;

    function __construct(&$application)
    {
        parent::__construct($application);
        $this->commentProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.comments.models.CommentProxy');
    }

    function renderCell( &$ar, $params )
    {
        // add categories link
        $categories = array();
        array_map(function($item) use (&$categories) {
            $url = museoweb_modules_blog_Module::getCategoryUrl($item);
            $categories[] = __Link::makeSimpleLink($item, $url);
        }, $ar->blogpost_category);
        $ar->blogpost_category = $categories;

        // TODO improve the count
        $resourceId = 'blog:'.$ar->document_id;
        $it = $this->commentProxy->getCommentsForResourceId($resourceId);
        $ar->comments = $it->count();
    }
}
