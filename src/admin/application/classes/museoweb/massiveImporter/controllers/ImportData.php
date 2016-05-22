<?php
class museoweb_massiveImporter_controllers_ImportData extends org_glizy_mvc_core_Command
{
    public function execute($importMode)
    {
        if ($importMode) {
            $moduleId = __Session::get('massiveImporter_moduleId');
            $mapping = __Session::get('massiveImporter_mapping');

            // in modalità aggiornamento il campo external id deve essere mappato
            if ($importMode == 'update' && $mapping['external_id'] === '') {
                $this->logAndMessage('Mappare il campo ID', null, true);
                $this->changeAction('fieldMapping');
                return;
            }

            $source = __Session::get('massiveImporter_source') ;

            if ($source == 'file' || $source == 'serverFile') {
                $options = array(
                    'filePath' => __Session::get('massiveImporter_filePath'),
                    'enclosure' => __Session::get('massiveImporter_csv_enclosure'),
                    'delimiter' => __Session::get('massiveImporter_csv_delimiter')
                );
                $fileServiceFactory = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.FileServiceFactory');
                $recordIterator = $fileServiceFactory->createFileService($options);
            } else {
                $dbType = __Session::get('massiveImporter_source');
                $host = __Session::get('massiveImporterDB_host');
                $port = __Session::get('massiveImporterDB_port');
                $user = __Session::get('massiveImporterDB_user');
                $psw = __Session::get('massiveImporterDB_psw');
                $dbname = __Session::get('massiveImporterDB_dbname');
                $tableName = __Session::get('massiveImporter_tableName');
                $query = __Session::get('massiveImporter_query');

                $dbServiceFactory = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.DbServiceFactory');
                $dbService = $dbServiceFactory->createDbService($dbType);
                $dbService->connect($host, $port, $user, $psw, $dbname);
                $recordIterator = $dbService->createRecordIterator('museoweb.massiveImporter.models.Table', $tableName);
                $recordIterator->setSqlQuery(array('sql' => $query, 'params' => array()));
            }
            
            $mappedFolder = __Session::get('massiveImporter_mappedFolder');
            
            $importService = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.ImportService');
            $result = $importService->import($recordIterator, $moduleId, $mapping, $importMode, $mappedFolder);

            if ($result['errors']) {
                foreach ($result['errors'] as $error) {
                    $this->logAndMessage($error, null, true);
                }

                $this->changeAction('fieldMapping');
            } else {
                $this->changeAction('importComplete');
            }
        }
    }
}