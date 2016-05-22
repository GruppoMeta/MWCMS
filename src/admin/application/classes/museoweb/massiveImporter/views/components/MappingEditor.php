<?php
class museoweb_massiveImporter_views_components_MappingEditor extends org_glizy_components_Input
{
    function init()
    {
        $this->defineAttribute('pageId', false, null, COMPONENT_TYPE_STRING);

        // call the superclass for validate the attributes
        parent::init();
    }

    function process()
    {
        parent::process();

        if (is_string($this->_content)) {
            $this->_content = unserialize($this->_content);
            if (!$this->_content) {
                $this->_content = array();
            }
        }
    }

    function render()
    {
        $moduleId = $this->_content['moduleId'];
        $heading = $this->_content['heading'];
        $mapping = $this->_content['mapping'];

        if (!$moduleId) {
            return;
        }

        $moduleService = org_glizy_ObjectFactory::createObject('museoweb.massiveImporter.services.ModuleService');
        $fields = $moduleService->getFields($moduleId);

        $output .= '<table id="'.$this->getAttribute('id').'" class="table table-striped table-bordered bootstrap-datatable dataTable">';
        $output .= '<thead><tr><th>Campi del modulo</th><th>Campi da mappare</th></tr></thead>';
        $output .= '<tbody>';

        $i = 0;
        foreach ($fields as $fieldId => $c) {
            $label = $c->getattribute('label');
            $required = $c->getattribute('required') ? 'required' : '';
            $class = $i++ % 2 ? 'odd' : 'even';
            $name = $this->getAttribute('name').'['.$fieldId.']';

            $select  = '<select id="'.$name.'" name="'.$name.'">';
            $select .= '<option></option>';

            $selectedIndex = $mapping[$fieldId] != '' ? $mapping[$fieldId] : -1;

            $optionIndex = 0;
            foreach ($heading as $k => $v) {
                $selected = $optionIndex == $selectedIndex ? 'selected="selected"' : '';
                $select .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                $optionIndex++;
            }

            $select .= '</select>';

            $output .= '<tr class="'.$class.'">';
            $output .= '  <td class="'.$required.'">'.$label.'</td><td>'.$select.'</td>';
            $output .= '</tr>';
        }

        $output .= '</tbody>';
        $output .= "</table>";

        $this->addOutputCode($output);
    }
}