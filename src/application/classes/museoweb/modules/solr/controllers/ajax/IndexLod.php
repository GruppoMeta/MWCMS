<?php
class museoweb_modules_solr_controllers_ajax_IndexLod extends org_glizy_mvc_core_CommandAjax
{
    function execute()
    {
        if ($this->user->isLogged())
        {
            $lodUrl = __Config::get('metacms.lod.url');
            if ($lodUrl) {
                file_get_contents($lodUrl.'crawl/1/now');
            }
        }

        return true;
    }
}
