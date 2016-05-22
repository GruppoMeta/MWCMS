<?php
class museoweb_massiveImporter_controllers_ModeSelection extends org_glizy_mvc_core_Command
{
    protected function processFile($filePath)
    {
        __Session::set('massiveImporter_filePath', $filePath);

        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        if (strtolower($ext) == 'csv') {
            $this->changeAction('csvDelimiters');
        } else {
            $this->changeAction('fileValidation');
        }
    }

    public function execute($moduleId, $source)
    {
        __Session::set('massiveImporter_moduleId', $moduleId);
        __Session::set('massiveImporter_source', $source);

        switch ($source) {
            case 'file':
                $fileDestDir = __Paths::get('CACHE');

                $file = $_FILES['filename'];
                $fileName = $file['name'];
                $tmpPath = $file['tmp_name'];
                $fileDestPath = $fileDestDir.$fileName;

                if (move_uploaded_file($tmpPath, $fileDestPath)) {
                    $this->processFile($fileDestPath);
                } else {
                    $this->logAndMessage('Errore durante il caricamento del file', null, true);
                    $this->changeAction('sourceSelection');
                }
                break;

            case 'serverFile':
                $serverFile = __Request::get('serverFile');
                if ($serverFile) {
                    $mappingService = $this->application->retrieveProxy('org.glizycms.mediaArchive.services.MediaMappingService');
                    $filePath = $mappingService->getRealPath($serverFile);
                    $this->processFile($filePath);
                } else {
                    $this->logAndMessage('Selezionare un file', null, true);
                    $this->changeAction('sourceSelection');
                }
                break;

            case 'mysql':
            case 'pgsql':
                $host =__Request::get('host');
                $port = __Request::get('port');
                $user = __Request::get('user');
                $psw = __Request::get('psw');
                $dbname = __Request::get('dbname');

                if ($host) {
                    try {
                        $dbServiceFactory = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.DbServiceFactory');
                        $dbService = $dbServiceFactory->createDbService($source);
                        $status = $dbService->connect($host, $port, $user, $psw, $dbname);

                        if ($status) {
                            __Session::set('massiveImporterDB_host', __Request::get('host'));
                            __Session::set('massiveImporterDB_port', __Request::get('port'));
                            __Session::set('massiveImporterDB_user', __Request::get('user'));
                            __Session::set('massiveImporterDB_psw', __Request::get('psw'));
                            __Session::set('massiveImporterDB_dbname', __Request::get('dbname'));

                            $this->changeAction('dbValidation');
                        }
                        else {
                            $this->logAndMessage('Connessione al database fallita, controllare i parametri', null, true);
                            $this->changeAction('sourceSelection');
                        }
                    } catch (Exception $e) {
                        $this->logAndMessage($e->getMessage(), null, true);
                        $this->changeAction('sourceSelection');
                    }
                } else {
                    $this->logAndMessage('Inserire tutti i parametri obbligatori per la connessione', null, true);
                    $this->changeAction('sourceSelection');
                }
                break;
        }
    }
}