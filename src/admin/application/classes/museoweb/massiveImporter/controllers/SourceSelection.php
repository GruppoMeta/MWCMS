<?php
class museoweb_massiveImporter_controllers_SourceSelection extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        __Request::set('host', __Session::get('massiveImporterDB_host'));
        __Request::set('port', __Session::get('massiveImporterDB_port'));
        __Request::set('user', __Session::get('massiveImporterDB_user'));
        __Request::set('psw', __Session::get('massiveImporterDB_psw'));
        __Request::set('dbname', __Session::get('massiveImporterDB_dbname'));

        // rimuove tutte le variabili di sessione massiveImporter_*
        __Session::removeKeysStartingWith('massiveImporter_');
    }
}