<?php
// TODO: mettere 10 in una variablie  config
class museoweb_massiveImporter_services_MysqlService extends museoweb_massiveImporter_services_AbstractDbService
{
    public function connect($host, $port, $user, $psw, $dbname)
    {
        $this->setConnParam('DB_TYPE', 'mysql');
        return parent::connect($host, $port, $user, $psw, $dbname);
    }
}