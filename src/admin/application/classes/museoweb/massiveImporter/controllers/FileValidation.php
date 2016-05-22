<?php
class museoweb_massiveImporter_controllers_FileValidation extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        $options = array(
            'filePath' => __Session::get('massiveImporter_filePath'),
            'enclosure' => __Session::get('massiveImporter_csv_enclosure'),
            'delimiter' => __Session::get('massiveImporter_csv_delimiter')
        );

        $fileServiceFactory = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.FileServiceFactory');
        $fileService = $fileServiceFactory->createFileService($options);
        $heading = $fileService->getHeading();

        __Session::set('massiveImporter_heading', $heading);
        __Request::set('heading', implode(' | ', $heading));
    }
}