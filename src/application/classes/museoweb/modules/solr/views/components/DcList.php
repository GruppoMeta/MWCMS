<?php
class  museoweb_modules_solr_views_components_DcList extends org_glizy_components_Input
{
    function init()
    {
        parent::init();

        $dcProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.solr.models.proxy.DcProxy');
        $dcOption = $dcProxy->getOptions();
        $dcField = $dcProxy->getFields();

        $this->setAttribute('type', 'hidden');
        $this->setAttribute('data', ';type=mwcmsDcList;controllername='.$this->getAttribute('ajaxController'), true);
        $this->setAttribute('data', ';fields='.json_encode($dcField), true);
        $this->setAttribute('data', ';options='.json_encode($dcOption), true);
    }
}
