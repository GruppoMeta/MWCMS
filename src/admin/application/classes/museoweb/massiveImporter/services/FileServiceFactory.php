<?php
class museoweb_massiveImporter_services_FileServiceFactory extends GlizyObject
{
    public function createFileService($options)
    {
        $filePath = $options['filePath'];
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($ext == 'xls') {
            return org_glizy_objectFactory::createObject('museoweb.massiveImporter.services.XLSFileService', $options);
        } elseif ($ext == 'xlsx') {
            return org_glizy_objectFactory::createObject('museoweb.massiveImporter.services.XLSXFileService', $options);
        } elseif ($ext == 'csv') {
            return org_glizy_objectFactory::createObject('museoweb.massiveImporter.services.CVSFileService', $options);
        } else {
            $this->logAndMessage('Il file caricato non è in un formato di quelli accettati', null, true);
            return null;
        }
    }
}