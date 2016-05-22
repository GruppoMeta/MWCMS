<?php

class museoweb_modules_catalogs_Search extends museoweb_search_Module
{
    function __construct()
    {
        $this->tableName = 'museoweb.modules.catalog';
        $this->title = 'catalogdetail_title';
        $this->description = 'catalogdetail_description';
        $this->pageType = 'museoweb.modules.catalogs.views.FrontEnd';
        $this->routeUrl = 'museoweb_Catalogs';
    }
}