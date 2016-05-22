<?php
class museoweb_modules_ecommerce_controllers_admin_ajax_GetModuleInfo extends org_glizy_mvc_core_CommandAjax
{
    public function execute($id)
    {
        // TODO: controllo permessi
       $module = org_glizy_Modules::getModule($id);
       if ($module) {
            $moduleHelper = org_glizy_ObjectFactory::createObject('org.glizycms.helpers.Modules');
            $fields = $moduleHelper->getFields($id);

            $result = array('fields' => array(), 'media' => array());
            foreach($fields as $k=>$v) {
                if ($v->type==org_glizycms_core_models_enum_FieldTypeEnum::IMAGE ||
                    $v->type==org_glizycms_core_models_enum_FieldTypeEnum::MEDIA ||
                    $v->type==org_glizycms_core_models_enum_FieldTypeEnum::REPEATER_IMAGE ||
                    $v->type==org_glizycms_core_models_enum_FieldTypeEnum::REPEATER_MEDIA
                    ) {
                   $result['media'][] = $v;
                } else {
                   $result['fields'][] = $v;
                }
            }
            return $result;
       } else {
           return false;
       }
    }


}