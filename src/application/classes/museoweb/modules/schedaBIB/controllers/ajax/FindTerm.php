<?php
class museoweb_modules_schedaBIB_controllers_ajax_FindTerm extends org_glizy_mvc_core_CommandAjax
{
    public function execute($fieldName, $model, $term)
    {
        $it = org_glizy_objectFactory::createModelIterator('museoweb.modules.schedaBIB.models.Model');

        if ($term != '') {
            $it->where('BIBA', '%'.$term.'%', 'ILIKE');
        }

        $result = array();

        foreach($it as $ar) {
            $result[] = array(
                'id' => $ar->getId(),
                'text' => $ar->ESC.' - '.$ar->BIBA.' - '.$ar->BIBF,
                'values' => $ar->getValuesAsArray()
            );
        }

        return $result;
    }
}