<?php
class museoweb_modules_blog_Module
{
    static function registerModule()
    {
        $moduleVO = org_glizy_Modules::getModuleVO();
        $moduleVO->id = 'museoweb_blog';
        $moduleVO->name = __T('museoweb.modules.blog.views.FrontEnd');
        $moduleVO->description = 'Modulo Blog';
        $moduleVO->version = '1.0.0';
        $moduleVO->classPath = 'museoweb.modules.blog';
        $moduleVO->pageType = 'museoweb.modules.blog.views.FrontEnd';
        $moduleVO->model = 'museoweb.modules.blog.models.Model';
        $moduleVO->author = 'META srl';
        $moduleVO->authorUrl = 'http://www.gruppometa.it';
        $moduleVO->pluginUrl = 'http://www.museowebcms.it';
        $moduleVO->siteMapAdmin = '<glz:Page pageType="museoweb.modules.blog.views.Admin" id="museoweb_blog" value="{i18n:Blog}" icon="icon-circle-blank" adm:acl="*" />';
        $moduleVO->canDuplicated = false;
        org_glizy_Modules::addModule( $moduleVO );

        GlizyClassLoader::addLib('Hashids', __Paths::get('APPLICATION_LIBS').'Hashids');
    }


    static function getRequestCategory()
    {
        return urldecode(__Request::get('category'));
    }

    static function getCategoryUrl($category)
    {
        return __Link::makeUrl('museoweb_blog_category_list', array('category' => '')).urlencode($category);
    }

    static function getRequestAuthor()
    {
        return self::getAuthorIdFromUid(__Request::get('author'));
    }

    static function getAuthorUidFromId($id)
    {
        $hashids = new Hashids\Hashids();
        return $hashids->encode(array($id, $id));
    }

    static function getAuthorIdFromUid($uid)
    {
        $hashids = new Hashids\Hashids();
        $uid = $hashids->decode($uid);
        return $uid[1];
    }

    static function getAuthorUrl($id)
    {
        $id = self::getAuthorUidFromId($id);
        return __Link::makeUrl('museoweb_blog_author_list', array('author' => '')).$id;
    }

    static function getRequestArchive()
    {
        return __Request::get('archive');
    }

    static function getArchiveUrl($ym)
    {
        return __Link::makeUrl('museoweb_blog_archive_list', array('archive' => $ym));
    }
}
