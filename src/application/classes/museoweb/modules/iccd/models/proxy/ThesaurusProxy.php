<?php

class museoweb_modules_iccd_models_proxy_ThesaurusProxy extends GlizyObject
{
    public function findTerm($fieldName, $model, $query, $term, $proxyParams)
    {
        $it = org_glizy_objectFactory::createModelIterator('museoweb.modules.iccd.models.ICCDThesaurus');

        if ($term != '') {
            $it->where('iccd_theasaurs_value', '%'.$term.'%', 'ILIKE');
        }

        $it->where('iccd_theasaurs_module', $proxyParams->module)
           ->where('iccd_theasaurs_code', $proxyParams->code)
           ->where('iccd_theasaurs_level', $proxyParams->level)
           ->orderBy('iccd_theasaurs_value');

        $result = array();

        foreach($it as $ar) {
            $result[] = array(
                'id' => $ar->iccd_theasaurs_key,
                'text' => $ar->iccd_theasaurs_value
            );
        }

        return $result;
    }
}