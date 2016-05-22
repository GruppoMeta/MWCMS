<?php
class museoweb_massiveImporter_controllers_ImageFolderSelection extends org_glizy_mvc_core_Command
{
    public function execute($mediaFileServer)
    {
        $this->setNisoData();
        __Session::set('massiveImporter_mappedFolder', $mediaFileServer);
        $this->changeAction('importData');
    }

    private function setNisoData()
    {
        $data = __Request::getAllAsArray();
        $niso = org_glizy_ObjectFactory::createModel('museoweb.mediaArchive.models.Niso');
        $nisoProxy = org_glizy_ObjectFactory::createObject('museoweb.mediaArchive.models.proxy.NisoProxy');
        $niso = org_glizy_ObjectFactory::createModel('museoweb.mediaArchive.models.Niso');
        $nisoProxy->setNisoData($data, $niso);
        __Session::set('nisoData', $niso->getValuesAsArray());
        __Session::set('nisoMode', $data['nisoMode']);
    }
}