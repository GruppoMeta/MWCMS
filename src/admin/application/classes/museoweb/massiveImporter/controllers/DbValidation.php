<?php
class museoweb_massiveImporter_controllers_DbValidation extends org_glizy_mvc_core_Command
{
    public function execute($tableName, $query)
    {
        if ($tableName) {
            $dbType = __Session::get('massiveImporter_source');
            $host = __Session::get('massiveImporterDB_host');
            $port = __Session::get('massiveImporterDB_port');
            $user = __Session::get('massiveImporterDB_user');
            $psw = __Session::get('massiveImporterDB_psw');
            $dbname = __Session::get('massiveImporterDB_dbname');

            $dbServiceFactory = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.DbServiceFactory');
            $dbService = $dbServiceFactory->createDbService($dbType);
            $dbService->connect($host, $port, $user, $psw, $dbname);
            $columnNames = $dbService->getColumnNames($tableName);

            $heading = array_combine(array_values($columnNames), array_values($columnNames));

            __Session::set('massiveImporter_heading', $heading);
            __Session::set('massiveImporter_tableName', $tableName);
            __Session::set('massiveImporter_query', $query);

            $this->changeAction('fieldMapping');
        }
    }
}