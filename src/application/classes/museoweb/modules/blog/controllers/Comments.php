<?php
class museoweb_modules_blog_controllers_Comments extends org_glizy_mvc_core_Command
{
    public function execute($message)
    {
        $commentProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.comments.models.CommentProxy');

        $c = $this->view->getComponentById('entry');
        $ar = $c->getRecord();
        $resourceId = 'blog:'.$ar->document_id;
        $canAddComment = $this->user->isLogged() && $ar->blogpost_hasComment;

        $this->view->setAttribute('showComments', $ar->blogpost_hasComment);
        $this->view->setAttribute('addComment', $canAddComment);
        $this->view->setAttribute('resourseId', $resourceId);

        if ($canAddComment && $message) {
            $r = $commentProxy->addComment($resourceId, $message);
        }

        $cid = __Request::get('cid');
        $commentAction = __Request::get('commentAction');
        if ($commentAction=='deleteComment' && $cid) {
            try {
                $commentProxy->deleteComment($cid);
            } catch (Exception $e) {}

            $url = __Link::removeParams(array('commentAction', 'cid'));
            org_glizy_helpers_Navigation::gotoUrl($url);
        }
    }
}