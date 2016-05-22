<?php
class museoweb_modules_mediaArchiveExplorer_controllers_Index extends org_glizy_mvc_core_Command
{
    function execute()
    {
        if ($this->user->isLogged()) {
            __Request::set('customPath', __Paths::get('APPLICATION_MEDIA_ARCHIVE'));
            __Request::set('enableDownload', true);
        }
    }
}