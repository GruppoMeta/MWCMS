<?php
class museoweb_views_components_FormBuilder extends org_glizy_components_ComponentContainer
{

	public function init()
	{
		parent::init();
		$this->childComponents = array();
	}

	public function process()
	{
        $this->_content = $this->_parent->loadContent($this->getId());

        if (property_exists($this->_content, 'fieldName')) {
	        $numItems = count($this->_content->fieldName);
	        $info = array();
	        for ($i=0; $i<$numItems; $i++) {
	        	$label = $this->_content->fieldName[$i];
	        	$title = $this->_content->fieldDescription[$i];
	        	$required = $this->_content->fieldRequired[$i] ? true : false;
				$fieldId = 'fld_'.glz_sanitizeUrlTitle($label, true);
				$component = 'Input';
				$attributes = array(
										'label' => $label,
										'title' => $title,
										'id' => $fieldId,
										'required' => $required,
										'validationType' => $required ? 'not_empty' : '',
			   					   );
				switch ($this->_content->fieldType[$i]) {
					case 'TEXT':
						$attributes['cssClass'] = 'long';
						break;

					case 'SHORTTEXT':
						$attributes['cssClass'] = 'short';
						break;

					case 'LONGTEXT':
						$attributes['type'] = 'multiline';
						$attributes['rows'] = 10;
						$attributes['cols'] = 20;
						$attributes['wrap'] = 'auto';
						break;

					case 'EMAIL':
						$attributes['validationType'] = 'email';
						break;

					case 'CHECKBOX':
						$component = 'Checkbox';
						$attributes['validationType'] = '';
						break;

					case 'UPLOAD':
						$attributes['type'] = 'file';
						break;
				}

				$info[] = array('id' => $fieldId, 'label' => $label, 'type' => $this->_content->fieldType[$i]);

			 	$c = &org_glizy_ObjectFactory::createComponent('org.glizy.components.'.$component, $this->_application, $this, 'glz:'.$component, $fieldId, $fieldId);
    			$c->setAttributes($attributes);
    			$this->addChild($c);
	        }

	        $c = &org_glizy_ObjectFactory::createComponent('org.glizy.components.Hidden', $this->_application, $this, 'glz:Hidden', 'formBuilderInfo', 'formBuilderInfo');
			$c->setAttributes(array('value' => glz_encodeOutput(json_encode($info))));
			$this->addChild($c);

	        $this->initChilds();
        }

		parent::process();
	}


	public static function translateForMode_edit($node) {
        $attributes = array();
        $attributes['id'] = $node->getAttribute('id');
        $attributes['label'] = $node->getAttribute('label');
        $attributes['data'] = 'type=repeat;repeatMin='.$min.';repeatMax='.$max.';collapsable=false';
        if ($node->hasAttribute('adm:data')) {
            $attributes['data'] .= ';'.$node->getAttribute('adm:data');
        }

        return org_glizy_helpers_Html::renderTag('glz:Fieldset', $attributes);
    }
}
