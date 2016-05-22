<?php
class museoweb_modules_comments_views_renderer_CellComment extends org_glizy_components_render_RenderCellRecordSetList
{
    private $commentProxy;

    function __construct(&$application)
    {
        parent::__construct($application);
        $this->commentProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.comments.models.CommentProxy');
    }

    function renderCell( &$ar, $params )
    {
        $ar->isAdmin = $this->commentProxy->canAdmin($ar);
        $ar->__urldelete__ = $ar->isAdmin ? __Link::addParams(array('commentAction' => 'deleteComment', 'cid' => $ar->simple_document_id)) : '';
    }
}
