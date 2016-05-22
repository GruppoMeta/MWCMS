<?php
class museoweb_modules_mag_controllers_ajax_GetModules extends org_glizy_mvc_core_CommandAjax
{
    public function execute()
    {
    	$availableModules = array();
		$availableMag = array();

        foreach(glob(__DIR__.'/../../mapping/*.php') as $file) {
            $file = pathinfo($file);
            $file = str_replace('_', '.', $file['filename']);
            $availableModules[] = $file;
        }

        $modules = org_glizy_Modules::getModules();

        foreach( $modules as $m ) {
            $model = $m->classPath.'.models.Model';
            if ($this->user->acl($m->id, 'visible') && in_array($model, $availableModules)) {
                $availableMag[] = array(
                    'id' => $model,
                    'value' => $m->name
                );
            }
        }

        return $availableMag;
    }
}