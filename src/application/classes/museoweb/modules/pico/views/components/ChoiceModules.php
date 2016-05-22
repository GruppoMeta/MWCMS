<?php

class museoweb_modules_pico_views_components_ChoiceModules extends org_glizy_components_HtmlFormElement
{
	function render()
	{
		$output = array();
		$class 				= $this->getAttribute('cssClass')!='' ? ' class="'.$this->getAttribute('cssClass').'"' : '';
		$output = '<fieldset'.$class.'><legend>'.$this->getAttribute('label').'</legend>';

        $availableModules = museoweb_modules_pico_Module::getMappingToModule();
		$mappingToLabel = museoweb_modules_pico_Module::getMappingToLabel();
        $modules = org_glizy_Modules::getModules();
        foreach ($availableModules as $k=>$v) {
            if (isset($modules[$v]) && $this->_user->acl($v, 'all')) {
                $mappingClass = array_search($m->id, $availableModules);
                $attributes                 = array();
                $attributes['id']           = $k;
                $attributes['name']         = $k;
                $attributes['type']         = 'checkbox';
                $attributes['data-type']    = 'checkbox';
                $checkbox  = '<input '.$this->_renderAttributes($attributes).'/>';
                $label = org_glizy_helpers_Html::label(__T($mappingToLabel[$k]), $k, false, '', array('class' => 'control-label'), false);
                $output .= $this->applyItemTemplate($label, $checkbox);
            }
        }

		$output .= '</fieldset>';
		$this->addOutputCode($output);
	}
}
