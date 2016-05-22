<?php
class museoweb_massiveImporter_controllers_ajax_VerifyConnection extends org_glizy_mvc_core_CommandAjax
{
    public function execute($dbType, $host, $port, $user, $psw, $db)
    {
        if ($host) {
            try {
                $dbServiceFactory = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.DbServiceFactory');
                $dbService = $dbServiceFactory->createDbService($dbType);
                $status = $dbService->connect($host, $port, $user, $psw, $dbname);

                return $status;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
}