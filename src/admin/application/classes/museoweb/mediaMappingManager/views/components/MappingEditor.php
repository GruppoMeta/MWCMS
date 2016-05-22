<?php
class museoweb_mediaMappingManager_views_components_MappingEditor extends org_glizy_components_ComponentContainer
{
    function init()
    {
        $this->defineAttribute('controller',     true, NULL, COMPONENT_TYPE_OBJECT);
    
        // call the superclass for validate the attributes
        parent::init();
    }
    
    function render()
    {
        $mappingService = $this->_application->retrieveProxy('org.glizycms.mediaArchive.services.MediaMappingService');
        $mappings = $mappingService->getAllMappings();
        
        $output .= '<table class="table table-striped table-bordered bootstrap-datatable dataTable">';
        $output .= '<thead><tr><th>Nome della cartella</th><th>Percorso filesystem</th><th style="width: 20px;"></th><th style="width: 20px;"></th></tr></thead>';
        $output .= '<tbody>';
        
        $i = 0;
        foreach ($mappings as $name => $target) {
            $class = $i++ % 2 ? 'odd' : 'even';
            $output .= '<tr class="'.$class.'">';
            $output .= '<td>'.$name.'</td><td>'.$target.'</td>';
            $output .= '<td style="text-align: left;">';
            
            if ($this->_user->acl($this->_application->getPageId(), 'edit')) {
               $output .= '<img title="'.org_glizy_locale_Locale::get('GLZ_RECORD_EDIT').'" id="edit_'.$name.'" class="DataGridCommand" src="'.org_glizy_Assets::get('ICON_EDIT').'" width="16" height="16" border="0" style="cursor: pointer;"/>';
            }
            
            $output .= '</td>';
            $output .= '<td style="text-align: left;">';
            
            if ($this->_user->acl($this->_application->getPageId(), 'delete')) {
                $output .= '<img title="'.org_glizy_locale_Locale::get('GLZ_RECORD_DELETE').'" id="delete_'.$name.'" class="DataGridCommand" src="'.org_glizy_Assets::get('ICON_DELETE').'" width="16" height="16" border="0" style="cursor: pointer;"/>';
            }
            
            $output .= '</td>';
            $output .= '</tr>';
        }
        
        $output .= '</tbody>';
        $output .= "</table>";
        
        $this->addOutputCode($output);
        
        $jsMessage = org_glizy_locale_Locale::get('GLZ_RECORD_MSG_DELETE');
        
        // controllare che il valore di controller sia settato
        $controllerClass     = &$this->getAttribute('controller');
        if (is_object($controllerClass))
        {
            $jsStateUrl         = $controllerClass->changeStateUrl();
            // TODO
            $jsStateUrl         = __Link::removeParams(array($controllerClass->getId().'_recordId'), $jsStateUrl);
            $jsCurrentStateUrl    = $controllerClass->changeStateUrl($controllerClass->getState() );
            $controllerId        = $controllerClass->getid();
        }
        else
        {
            $jsStateUrl         = __Link::removeParams(array($jsId.'_orderBy', $jsId.'_orderDirection'));
            $jsCurrentStateUrl    = $jsStateUrl ;
            $controllerId        = '';
        }
        
        
        
        $output = <<<EOD
<script language="JavaScript" type="text/JavaScript">
jQuery(document).ready(function() {
    jQuery('.DataGridCommand, .DataGridHeader').each(function(index, element)
    {
        $(element).css( 'cursor', 'pointer' );
        $(element).click( function()
        {
            var command = element.id.split('_');
            var loc = "{$jsStateUrl}"+command[0]+"&{$controllerId}_recordId="+command[1];
            switch (command[0])
            {
                case 'delete':
                    element.parentNode.parentNode.oldClass2        = element.parentNode.parentNode.oldClass;
                    element.parentNode.parentNode.className2    = element.parentNode.parentNode.className;
                    element.parentNode.parentNode.className        = "ruled";
                    element.parentNode.parentNode.oldClass        = "ruled";
                    
                    if (confirm("{$jsMessage}"))
                    {
                        location.href = loc;
                    }
                    
                    element.parentNode.parentNode.oldClass    = element.parentNode.parentNode.oldClass2;
                    element.parentNode.parentNode.className    = element.parentNode.parentNode.oldClass2;
                    break;    
                case 'orderBy':
                    loc = "{$jsCurrentStateUrl}&{$jsId}_orderBy="+command[1]+"&{$jsId}_orderDirection="+command[2];
                    location.href = loc;

                default:
                    location.href = loc;
                    break;
    
            };
        });
    });
});
</script>
EOD;

        $this->addOutputCode($output);
    }
}
?>