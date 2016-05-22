<?php
class museoweb_modules_iccd_controllers_ajax_AddTerm extends org_glizy_mvc_core_CommandAjax
{
    function execute($fieldName, $model, $query, $term, $proxy, $proxyParams, $getId)
    {
        $proxyParams = json_decode($proxyParams);

        $ar = org_glizy_objectFactory::createModel('museoweb.modules.iccd.models.ICCDThesaurus');

        $result = $ar->find(array(
            'iccd_theasaurs_code' => $proxyParams->code,
            'iccd_theasaurs_level' => $proxyParams->level,
            'iccd_theasaurs_key' => $term,
            'iccd_theasaurs_value' => $term,
        ));

        if (!$result) {
            $ar->iccd_theasaurs_code = $proxyParams->code;
            $ar->iccd_theasaurs_level = $proxyParams->level;
            $ar->iccd_theasaurs_key = $term;
            $ar->iccd_theasaurs_value = $term;
            $ar->save();
        }
    }
}