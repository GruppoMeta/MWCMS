<?php
class org_glizycms_contents_controllers_pageEdit_ajax_GetChildBlocks extends org_glizy_mvc_core_CommandAjax
{
    public function execute($id)
    {
        $this->checkPermissionForBackend();
        $this->directOutput = true;
        $output = array();

        $languageId = org_glizy_ObjectValues::get('org.glizy', 'editingLanguageId');
        $menuProxy = org_glizy_ObjectFactory::createObject('org.glizycms.contents.models.proxy.MenuProxy');
        $contentProxy = org_glizy_ObjectFactory::createObject('org.glizycms.contents.models.proxy.ContentProxy');

        $itMenus = $menuProxy->getChildMenusFromId($id, $languageId, false);
        foreach($itMenus as $subMenu) {
            if ($subMenu->menu_type!=='BLOCK') continue;
            $content = $contentProxy->readRawContentFromMenu($subMenu->menu_id, $languageId, 'PUBLISHED');
            $description = '';
            if ($content) {
                $description = property_exists($content->content, 'text') ? $content->content->text :
                                (property_exists($content->content, 'description') ? $content->content->description : '');
            }

            $output[] = array(
                'id' => $subMenu->menu_id,
                'title' => $subMenu->menudetail_title,
                'visible' => $subMenu->menudetail_isVisible,
                'description' => glz_strtrim($description).' ('.__T($subMenu->menu_pageType).')'
            );

        }

        return $output;
    }
}