<?php
class museoweb_mediaArchive_controllers_Delete extends org_glizycms_mediaArchive_controllers_Delete
{
    public function execute($id)
    {
        $media = org_glizycms_mediaArchive_MediaManager::getMediaById($id);
        if($media->type === 'IMAGE') {
            $nisoProxy = org_glizy_ObjectFactory::createObject('museoweb.mediaArchive.models.proxy.NisoProxy');
            $nisoProxy->delete($id);
        }
        parent::execute($id);
    }
}