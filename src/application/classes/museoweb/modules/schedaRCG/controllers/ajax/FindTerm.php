<?php
class museoweb_modules_schedaRCG_controllers_ajax_FindTerm extends org_glizy_mvc_core_CommandAjax
{
    public function execute($fieldName, $model, $term)
    {
        $it = org_glizy_objectFactory::createModelIterator('museoweb.modules.schedaRCG.models.Model');

        if ($term != '') {
            $it->where('ESC', '%'.$term.'%', 'ILIKE');
        }

        $result = array();

        foreach($it as $ar) {
            $result[] = array(
                'id' => $ar->getId(),
                'text' => $ar->ESC,
                'values' => $ar->getValuesAsArray()
            );
        }

        return $result;
    }
}