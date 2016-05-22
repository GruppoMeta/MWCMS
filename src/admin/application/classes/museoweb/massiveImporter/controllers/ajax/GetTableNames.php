<?php
class museoweb_massiveImporter_controllers_ajax_GetTableNames extends org_glizy_mvc_core_CommandAjax
{
    public function execute()
    {
        $dbType = __Session::get('massiveImporter_source');
        $host = __Session::get('massiveImporterDB_host');
        $port = __Session::get('massiveImporterDB_port');
        $user = __Session::get('massiveImporterDB_user');
        $psw = __Session::get('massiveImporterDB_psw');
        $dbname = __Session::get('massiveImporterDB_dbname');

        try {
            $dbServiceFactory = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.DbServiceFactory');
            $dbService = $dbServiceFactory->createDbService($dbType);
            $status = $dbService->connect($host, $port, $user, $psw, $dbname);

            if ($status) {
                $this->directOutput = true;
                return $dbService->getTableNames();
            }
        } catch (Exception $e) {
        }
    }
}