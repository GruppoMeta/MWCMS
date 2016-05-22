<?php
class museoweb_modules_mag_views_components_MagRecordPicker extends org_glizy_components_Input
{
	function init()
	{
		// define the custom attributes
		$this->defineAttribute('ajaxController', false, 'museoweb.modules.mag.controllers.ajax.MagRecordPicker', COMPONENT_TYPE_STRING);

		parent::init();

		$this->setAttribute('data', ';type=MwcmsRecordPicker;controllername='.$this->getAttribute('ajaxController'), true);
	}

	public function render_html()
	{
		$output = array();

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
            if (in_array($model, $availableModules)) {
            	$availableMag[] = array($model, $m->name);
            }
        }

		parent::render_html();

		$this->addOutputCode( org_glizy_helpers_JS::JScode( 'var mwcmsMagAvailable = '.json_encode($availableMag).';' ));
	}
}
