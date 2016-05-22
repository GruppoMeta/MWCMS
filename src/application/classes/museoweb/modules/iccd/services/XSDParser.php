<?php
class museoweb_modules_iccd_services_XSDParser extends GlizyObject
{
    protected $moduleName;
    protected $elements;
    protected $fieldsAttributes = array();

    public function getFieldsAttributes()
    {
        return $this->fieldsAttributes;
    }

    public function getAuthorityFile()
    {
        return $this->fieldsAttributes['authorityFile'];
    }

    public function getIndex()
    {
        return $this->fieldsAttributes['index'];
    }

    protected function parseRequiredFile($xmlFile)
    {
        if (!$xmlFile) {
            return;
        }

        $xmlString = file_get_contents($xmlFile);

        $xml = new DomDocument();
        $xml->preserveWhiteSpace = false;
        $xml->loadXml($xmlString);

        $this->fieldsAttributes = array();
        $fields = $xml->getElementsByTagName('field');

        foreach ($fields as $field) {
            $fieldAttribute = array();
            $fieldName = $field->getAttribute('name');

            if ($field->getAttribute('required')) {
                $fieldAttribute['required'] = $field->getAttribute('required');
            }

            if ($field->getAttribute('index')) {
                $fieldAttribute['index'] = $field->getAttribute('index');
            }

            if ($field->hasAttribute('label')) {
                $fieldAttribute['label'] = $field->getAttribute('label');
            }

            if ($field->hasAttribute('type')) {
                $fieldAttribute['type'] = $field->getAttribute('type');
            }

            if ($field->hasChildNodes()) {
                foreach ($field->childNodes as $child) {
                    if ($child->nodeName == 'thesaurus') {
                        $thesaurusNode = $field->firstChild;

                        $dict = array();

                        foreach($thesaurusNode->childNodes as $child){
                            $dict[] = $child->getAttribute('value');
                        }

                        $fieldAttribute['thesaurus'] = $dict;
                    } else if ($child->nodeName == 'authorityFile') {
                        $thesaurusNode = $field->firstChild;
                        $module = $thesaurusNode->getAttribute('module');

                        $ar = org_glizy_objectFactory::createModel($module.'.models.Model');

                        $fields = array();

                        foreach ($ar->getFields() as $field) {
                            if (!$field->isSystemField) {
                                $fields[$field->name] = true;
                            }
                        }

                        $fieldAttribute['authorityFile'] = array (
                            'pageId' => $module.'.popup',
                            'controller' => $module.'.controllers.ajax.FindTerm',
                            'model' => $module.'.models.Model',
                            'fields' => $fields
                        );
                    }
                }
            }

            $this->fieldsAttributes[$fieldName] = $fieldAttribute;
        }
    }

    public function parseFile($xsdFile, $xmlFileRequired, $moduleName)
    {
        $this->moduleName = lcfirst(preg_replace('/\W+/', '', $moduleName));

        $this->parseRequiredFile($xmlFileRequired);

        $xmlString = file_get_contents($xsdFile);

        $xml = new DomDocument();
        $xml->loadXml($xmlString);

        $xpath = new DOMXpath($xml);

        $scheda = $xpath->query('//xs:element[@name="scheda"]')->item(0);

        foreach ($scheda->childNodes as $child) {
            if ($child->nodeName == 'xs:complexType') {
                $this->elements = $this->parseComplexType($child);
                break;
            }
        }

        return $this->elements;
    }

    public function makeHtmlElements()
    {
        $output = '';

        foreach ($this->elements as $element) {
            $output .= $this->makeElement($element, 0, $element);
        }

        return $output;
    }

    public function makeElement($element, $level, $parent)
    {
        $elementName = $element['name'];

        if ($this->fieldsAttributes[$elementName]['authorityFile']) {
            $attr = $this->fieldsAttributes[$elementName]['authorityFile'];

            $attributesInput = array(
                'id' => '__'.$elementName,
                'label' => '{i18n:__'.$elementName.'}',
                //'maxLength' => $element['maxLength'],
                'data' => 'type=modalPage;pageid='.str_replace('.', '_', $attr['pageId']).';controller='.str_replace('.', '_', $attr['controller'])
            );

            $authorityInput = org_glizy_helpers_Html::renderTag('glz:Input', $attributesInput).PHP_EOL;
        }

        if ($element['children']) {
            $attributes = array(
                'id' => $elementName,
                'label' => '{i18n:'.$elementName.'}'
            );

          	$element['minOccurs'] = $element['required'] === 'true' ? 1 : 0;

            // se è un campo ripetibile
            if (!($element['minOccurs'] == 1 && $element['maxOccurs'] == 1) || $element['maxOccurs'] > 1 || $element['maxOccurs'] == 'unbounded') {
                $attributes['data'] = 'type=repeat;collapsable=false;repeatMin='.$element['minOccurs'].($element['maxOccurs'] == 'unbounded' || !$element['maxOccurs']  ? '' : ';repeatMax='.$element['maxOccurs']);
            }

            if ($element['required']) {
                $attributes['required'] = $element['required'];
            }

            $content = PHP_EOL;

            if ($authorityInput) {
                $content .= str_repeat('  ', $level+1).$authorityInput;
            }

            foreach ($element['children'] as $child) {
                $content .= str_repeat('  ', $level+1).$this->makeElement($child, $level+1, $element);
            }

            $output = org_glizy_helpers_Html::renderTag('glz:Fieldset', $attributes, true, $content).PHP_EOL;
        } else {
            $attributes = array(
                'id' => $elementName,
                'label' => '{i18n:'.$elementName.'}'
            );

            if ($element['required'] === 'true') {
                $attributes['required'] = $element['required'];
            }

            $element['minOccurs'] = $element['required'] === 'true' ? 1 : 0;

            if ($element['maxOccurs'] > 1 || $element['maxOccurs'] == 'unbounded') {
                $attributes['data'] = 'type=repeat;collapsable=false;repeatMin='.$element['minOccurs'].($element['maxOccurs'] == 'unbounded' ? '' : ';repeatMax='.$element['maxOccurs']);

                $content = PHP_EOL;

                if ($authorityInput) {
                    $content .= str_repeat('  ', $level+2).$authorityInput;
                }

                $attributesInput = array(
                    'id' => $elementName.'-element',
                    'label' => '{i18n:'.$elementName.'}',
                    //'maxLength' => $element['maxLength']
                );

                if ($this->fieldsAttributes[$parent['name']]['authorityFile']) {
                    $authorityFields = $this->fieldsAttributes[$parent['name']]['authorityFile']['fields'];
                    if ($authorityFields[$elementName]) {
                        $attributesInput['disabled'] = 'true';
                    }
                }

                if ($this->fieldsAttributes[$elementName]['type'] === 'image') {
                    $attributesInput['data'] = 'type=mediapicker;mediatype=IMAGE;preview=true';
                }

                if ($this->fieldsAttributes[$elementName]['type'] === 'media') {
                    $attributesInput['data'] = 'type=mediapicker;mediatype=ALL;preview=false';
                }

                $content .= str_repeat('  ', $level+2).org_glizy_helpers_Html::renderTag('glz:Input', $attributesInput).PHP_EOL;
                $output = org_glizy_helpers_Html::renderTag('glz:Fieldset', $attributes, true, $content).PHP_EOL;
            } else {
                //$attributes['maxLength'] = $element['maxLength'];

                if ($element['thesaurus']) {
                    $code = $element['thesaurus']['code'];
                    $level = $element['thesaurus']['level'];
                    $dict = $this->fieldsAttributes[$elementName]['thesaurus'];

                    // se è un Vocabolario Aperto (VA) allora possono essere aggiunti nuovi termini
                    if (substr($code, 0, 2) == "VA") {
                        $attributes['data']= 'type=selectfrom;multiple=false;add_new_values=true;proxy=museoweb.modules.iccd.models.proxy.ThesaurusProxy;proxy_params={##module##:##'.$this->moduleName.'##,##code##:##'.$code.'##,##level##:##'.$level.'##};selected_callback=museoweb.modules.iccd.controllers.ajax.AddTerm';
                    } else { // Vocabolario Chiuso (VC)
                        if (count($dict) == 1) {
                            $attributes['value'] = $dict[0];
                            // TODO: http://phabricator.glizy.org/T282
                            //$attributes['disabled'] = 'true';
                        } else {
                            $attributes['data']= 'type=selectfrom;multiple=false;add_new_values=false;proxy=museoweb.modules.iccd.models.proxy.ThesaurusProxy;proxy_params={##module##:##'.$this->moduleName.'##,##code##:##'.$code.'##,##level##:##'.$level.'##}';
                        }
                    }

                    foreach ((array) $dict as $item) {
                        $ar = org_glizy_objectFactory::createModel('museoweb.modules.iccd.models.ICCDThesaurus');

                        $result = $ar->find(array(
                            'iccd_theasaurs_module' => $this->moduleName,
                            'iccd_theasaurs_code' => $code,
                            'iccd_theasaurs_level' => $level,
                            'iccd_theasaurs_key' => $item
                        ));

                        if (!$result) {
                            $ar->iccd_theasaurs_module = $this->moduleName;
                            $ar->iccd_theasaurs_code = $code;
                            $ar->iccd_theasaurs_level = $level;
                            $ar->iccd_theasaurs_key = $item;
                            $ar->iccd_theasaurs_value = $item;
                            $ar->save();
                        }
                    }
                }

                if ($this->fieldsAttributes[$parent['name']]['authorityFile']) {
                    $authorityFields = $this->fieldsAttributes[$parent['name']]['authorityFile']['fields'];
                    if ($authorityFields[$elementName]) {
                        $attributes['disabled'] = 'true';
                    }
                }

                if ($this->fieldsAttributes[$elementName]['type'] === 'image') {
                    $attributes['data'] = 'type=mediapicker;mediatype=IMAGE;preview=true';
                }

                if ($this->fieldsAttributes[$elementName]['type'] === 'media') {
                    $attributes['data'] = 'type=mediapicker;mediatype=ALL;preview=false';
                }

                $output = org_glizy_helpers_Html::renderTag('glz:Input', $attributes).PHP_EOL;
            }
        }

        return $output;
    }

    public function parseComplexType($node)
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeName == 'xs:sequence') {
                $sequence = $child;
                break;
            }
        }

        return $this->parseSequence($sequence);
    }

    public function parseSequence($node)
    {
        $elements = array();

        foreach ($node->childNodes as $child) {
            if ($child->nodeName == 'xs:element') {
                $element = array(
                    'name' => $child->getAttribute('name'),
                    'minOccurs' => $child->getAttribute('minOccurs'),
                    'maxOccurs' => $child->getAttribute('maxOccurs')
                );

                foreach ($child->childNodes as $subChild) {
                    if ($subChild->nodeName == 'xs:complexType') {
                        $element['children'] = $this->parseComplexType($subChild);
                        break;
                    } elseif ($subChild->nodeName == 'xs:simpleType') {
                        $element['maxLength'] = $this->parseSimpleType($subChild);
                        break;
                    } elseif ($subChild->nodeType == XML_COMMENT_NODE) {
                        preg_match('/NOME THESAURUS: " (.+) ", LIVELLO TERMINE: " \$(\d+) "/', $subChild->nodeValue, $m);
                        $element['thesaurus'] = array(
                            'code' => $m[1],
                            'level' => $m[2]
                        );
                    }
                }

                if ($this->fieldsAttributes[$element['name']]['required']) {
                    $element['required'] = $this->fieldsAttributes[$element['name']]['required'];
                }

                $elements[] = $element;
            }
        }

        return $elements;
    }

    public function parseSimpleType($node)
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeName == 'xs:restriction') {
                $restriction = $child;
                break;
            }
        }

        foreach ($restriction->childNodes as $child) {
            if ($child->nodeName == 'xs:maxLength') {
                return $child->getAttribute('value');
            }
        }
    }
}
