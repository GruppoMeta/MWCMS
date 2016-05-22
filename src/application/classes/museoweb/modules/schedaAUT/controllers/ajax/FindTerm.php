<?php
class museoweb_modules_schedaAUT_controllers_ajax_FindTerm extends org_glizy_mvc_core_CommandAjax
{
    public function execute($fieldName, $model, $term, $id)
    {
        $it = org_glizy_objectFactory::createModelIterator('museoweb.modules.schedaAUT.models.Model');

        if ($term != '') {
            $it->where('AUTN', '%'.$term.'%', 'ILIKE');
        } else if ($id != '') {
            $it->where('document_id', $id);
        }

        $result = array();

        foreach($it as $ar) {
            $result[] = array(
                'id' => $ar->getId(),
                'text' => $ar->AUTN.' - '.$ar->AUTB.' - '.$ar->AUTA,
                'values' => $ar->getValuesAsArray()
            );
        }

        return $result;
    }
}