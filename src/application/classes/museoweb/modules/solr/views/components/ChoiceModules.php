<?php
class museoweb_modules_solr_views_components_ChoiceModules extends org_glizy_components_HtmlFormElement
{
	CONST REGISTRY_SOLR_MAP_ACTIVE = '/solr/mapping/activeModules';

	function render()
	{
		$output = array();
        $class = $this->getAttribute('cssClass')!='' ? ' class="'.$this->getAttribute('cssClass').'"' : '';
		$output = '<fieldset'.$class.'><legend>'.$this->getAttribute('label').'</legend>';

		$availableModules = unserialize(org_glizy_Registry::get(__Config::get('BASE_REGISTRY_PATH').self::REGISTRY_SOLR_MAP_ACTIVE, '')) ?: array();
        $modules = org_glizy_Modules::getModules();
        foreach( $modules as $m ) {
            if (!$this->_user->acl($m->id, 'all')) {
                continue;
            }

            //$model = $m->classPath.'.models.Model';
            if (array_key_exists($m->id, $availableModules)) {
				$attributes 				= array();
				$attributes['id'] 			= $m->id;
				$attributes['name'] 		= $m->id;
				$attributes['type'] 		= 'checkbox';
				$attributes['data-type'] 	= 'checkbox';
				$checkbox  = '<input '.$this->_renderAttributes($attributes).' />';
				$label = org_glizy_helpers_Html::label($m->name, $k, false, '', array('class' => 'control-label'), false);
				$output .= $this->applyItemTemplate($label, $checkbox);
            }
        }
		$output .= '</fieldset>';
		$this->addOutputCode($output);
	}
}
