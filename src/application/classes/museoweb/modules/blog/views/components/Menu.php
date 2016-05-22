<?php

class museoweb_modules_blog_views_components_Menu extends org_glizy_components_Component
{
    private $siteMap;
    private $currentMenu;
    private $menuId;

    function process()
    {
        // $authorId = $this->_parent->getAuthorId();

        // create the blog navigation menu
        $this->siteMap = &$this->_application->getSiteMap();
        $this->currentMenu = &$this->siteMap->getNodeById($this->_application->getPageId());
        $this->menuId = $this->currentMenu->id;

        $menuRecord = $this->siteMap->getEmptyMenu();
        $menuRecord['title'] = __T( "MW_BLOG_LATEST_POSTS" );
        $menuRecord['description']      = '';
        $menuRecord['id']               = 'blog:'.$this->menuId++;
        $menuRecord['pageType']         = '';
        $menuRecord['creationDate']     = $this->currentMenu->creationDate;
        $menuRecord['modificationDate'] = $this->currentMenu->modificationDate;
        $menuRecord['url']              = org_glizy_helpers_Link::makeURL( 'museoweb_blog_list' );
        $this->siteMap->addChildMenu( $this->currentMenu, $menuRecord );

        // categories
        $it = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.blog.models.Category')
                ->load('allPostCategories', array('languageId' => $this->_application->getLanguageId()));
        $this->makeSubMenu( $it, __T( 'MW_BLOG_CATEGORIES'), 'categoryMakeTitle', 'categoryMakeUrl', 'categoryCheckMenu' );

        // authors
        $it = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.blog.models.Author')
                ->load('allPostAuthors', array('languageId' => $this->_application->getLanguageId()));
        $this->makeSubMenu( $it, __T( 'MW_BLOG_AUTHORS'), 'authorMakeTitle', 'authorMakeUrl', 'authorCheckMenu' );

        // archive
        $it = org_glizy_ObjectFactory::createModelIterator('museoweb.modules.blog.models.Archive')
                ->load('allPostArchive', array('languageId' => $this->_application->getLanguageId()));
        $this->makeSubMenu( $it, __T( 'MW_BLOG_ARCHIVE'), 'archiveMakeTitle', 'archiveMakeUrl', 'archiveCheckMenu' );

        $evt = array('type' => GLZ_EVT_SITEMAP_UPDATE );
        $this->dispatchEvent($evt);
    }




    private function makeSubMenu( $it, $title, $menuTitleFunction, $menuUrlFunction, $menuCheckFunction )
    {
        $groupMenu = null;
        foreach($it as $arC) {
            $menuTitle = call_user_func(array($this, $menuTitleFunction),  $arC);

            $menuRecord = $this->siteMap->getEmptyMenu();
            $menuRecord['title']            = $menuTitle;
            $menuRecord['description']      = '';
            $menuRecord['id']               = 'blog:'.$this->menuId++;
            $menuRecord['pageType']         = '';
            $menuRecord['creationDate']     = $this->currentMenu->creationDate;
            $menuRecord['modifiAutionDate'] = $this->currentMenu->modifiAutionDate;
            $menuRecord['url']              = call_user_func(array($this, $menuUrlFunction),  $arC );

            if ( is_null( $groupMenu ) ) {
                $menuRecord['title'] = $title;
                $this->siteMap->addChildMenu( $this->currentMenu, $menuRecord );
                $groupMenu = &$this->siteMap->getNodeById( $menuRecord['id'] );

                $menuRecord['title']    = $menuTitle;
                $menuRecord['id']       = 'blog:'.$this->menuId++;
            }

            $this->siteMap->addChildMenu($groupMenu , $menuRecord);

            call_user_func(array($this, $menuCheckFunction), $arC, $menuRecord );
        }
    }

    function categoryMakeTitle( $ar )
    {
        return  $ar->document_index_text_value;
    }

    function categoryMakeUrl( $ar )
    {
        return museoweb_modules_blog_Module::getCategoryUrl($this->categoryMakeTitle($ar));
    }

    function categoryCheckMenu( $ar, $menuRecord )
    {
        $categoryId = museoweb_modules_blog_Module::getRequestCategory();
        if ( $categoryId == $ar->document_index_text_value )
        {
            // the category is selected, the menu is set how current page
            $this->_application->setPageId( $menuRecord['id'] );
        }
    }

    function authorMakeTitle( $ar )
    {
        return $ar->user_firstName.' '.$ar->user_lastName;
    }

    function authorMakeUrl( $ar )
    {
        return museoweb_modules_blog_Module::getAuthorUrl($ar->user_id);
    }

    function authorCheckMenu( $ar, $menuRecord )
    {
        $authorId = museoweb_modules_blog_Module::getRequestAuthor();
        if ( $authorId == $ar->user_id )
        {
            $this->_application->setPageId( $menuRecord['id'] );
        }
    }

    function archiveMakeTitle( $ar )
    {
        $v = (int)$ar->document_index_int_value;
        $year = floor($v/100);
        $month = $v - ($year * 100);
        $months = __T ( 'GLZ_MONTHS' );
        return $months[ $month - 1 ].' '.$year;
    }

    function archiveMakeUrl( $ar )
    {
        return museoweb_modules_blog_Module::getArchiveUrl($ar->document_index_int_value);
    }

    function archiveCheckMenu( $ar, $menuRecord )
    {
        $archiveId = museoweb_modules_blog_Module::getRequestArchive();
        if ( $archiveId == $ar->document_index_int_value )
        {
            $this->_application->setPageId( $menuRecord['id'] );
        }
    }
}
