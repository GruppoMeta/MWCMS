<?php

class museoweb_massiveImporter_services_DbServiceFactory extends GlizyObject
{
    public function createDbService($dbType)
    {
        if ($dbType == 'mysql') {
            return org_glizy_objectFactory::createObject('museoweb.massiveImporter.services.MysqlService', 11);
        } else if ($dbType == 'pgsql') {
            return org_glizy_objectFactory::createObject('museoweb.massiveImporter.services.PgsqlService', 12);
        } else {
            $this->logAndMessage('Il dbms selezionato non è supportato', null, true);
            return null;
        }
    }
}