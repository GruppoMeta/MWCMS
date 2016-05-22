<?php
class org_glizycms_contents_controllers_siteTree_ajax_Lock extends org_glizy_mvc_core_CommandAjax
{
    public function execute($menuId) {
// TODO: CONTROLLO ACL
        if ($menuId) {
            $languageId = org_glizy_ObjectValues::get('org.glizy', 'editingLanguageId');
            $menuProxy = org_glizy_ObjectFactory::createObject('org.glizycms.contents.models.proxy.MenuProxy');
            $menuProxy->lockUnlock($menuId, true);
            return true;
        }

        return false;
    }
}