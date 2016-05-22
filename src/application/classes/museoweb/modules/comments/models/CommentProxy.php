<?php
class museoweb_modules_comments_models_CommentProxy extends GlizyObject
{
    private $application;
    private $user;

    function __construct()
    {
        $this->application = org_glizy_ObjectValues::get('org.glizy', 'application');
        $this->user = $this->application->getCurrentUser();
    }

    public function addComment($resourceId, $text, $title='')
    {
        if (!$this->user->isLogged()) {
            throw museoweb_modules_comments_CommentException::userNotLogged();
        }

        $text = strip_tags($text);
        if (!$resourceId || !$text) {
            throw museoweb_modules_comments_CommentException::wrongParams($resourceId, $text);
        }

        $ar = org_glizy_ObjectFactory::createModel('museoweb.modules.comments.models.Comment');
        $ar->userId = $this->user->id;
        $ar->resourceId = $resourceId;
        $ar->title = $title;
        $ar->text = $text;
        $ar->date = new org_glizy_types_DateTime();

        try {
            return $ar->save();
        }
        catch (org_glizy_validators_ValidationException $e) {
            return $e->getErrors();
        }
    }

    public function getCommentsForResourceId($resourceId)
    {
        $it = org_glizy_objectFactory::createModelIterator('museoweb.modules.comments.models.Comment')
                        ->load('getCommentsForResourceId', array('resourceId' => $resourceId));
        return $it;
    }

    public function deleteComment($id)
    {
        $ar = org_glizy_objectFactory::createModel('museoweb.modules.comments.models.Comment');
        if ($ar->load($id)) {
            if ($this->canAdmin($ar)) {
                $ar->delete();
            } else {
                throw museoweb_modules_comments_CommentException::forbidden();
            }
        } else {
            throw museoweb_modules_comments_CommentException::notFound($id);
        }
    }

    public function canAdmin($ar)
    {
        return $this->user->groupId == 1 || $ar->userId = $this->user->id;
    }
}