<?php
class museoweb_modules_ecommerce_views_components_admin_ChoiceModules extends org_glizy_components_HtmlFormElement
{
    function render()
    {
        $output = '<table id="'.$this->getAttribute('id').'" class="table table-striped table-bordered bootstrap-datatable dataTable">';
        // TODO: localizzare
        $output .= '<thead><tr><th>Modulo</th><th>Attivo</th><th>Identificativo/Titolo</th><th>Media</th><th>Flag carrello</th></tr></thead>';
        $output .= '<tbody>';

        $modules = org_glizy_Modules::getModulesSorted();
        foreach( $modules as $k=>$m) {
            if (!$this->_user->acl($m->id, 'all') || !$m->model) {
                continue;
            }
            $moduleId = $m->id;
            $attributes                 = array();
            $attributes['id']           = 'ck_'.$moduleId;
            $attributes['name']         = 'ck_'.$moduleId;
            $attributes['value']         = '';
            $attributes['type']         = 'checkbox';
            $attributes['class']         = 'js-ecomm';
            $attributes['data-type']    = 'checkbox';
            $checkbox = '<input '.$this->_renderAttributes($attributes).'/>';
            $output .=
                    '<tr>'.
                    '<td>'.$m->name.'</td>'.
                    '<td>'.$checkbox.org_glizy_helpers_Html::hidden($moduleId, '').'</td>'.
                    '<td><select id="s1_'.$moduleId.'" class="js-ecomm-select" data-module="'.$moduleId.'" disabled></select></td>'.
                    '<td><select id="s2_'.$moduleId.'" class="js-ecomm-select" data-module="'.$moduleId.'" disabled></select></td>'.
                    '<td><select id="s3_'.$moduleId.'" class="js-ecomm-select" data-module="'.$moduleId.'" disabled></select></td>'.
                    '</tr>';
        }
        $output .= '</tbody></table>';

        $ajaxUrl = 'ajax.php?pageId='.$this->_application->getPageId().'&ajaxTarget='.$this->_parent->getId().'&action=';
        $message = __T('Verifica i campi indicati');

        $output .= <<<EOD
<script>

$(function(){
    $('input.js-ecomm').change(function(){
        var \$el = \$(this);
        var \$elHidden = \$el.next();
        var moduleId = \$elHidden.attr('name');
        if (this.checked) {
            var value = \$elHidden.val();
            if (value) {
                value = JSON.parse(value);
            } else {
                value = {};
            }
            $.ajax({
                    url: '{$ajaxUrl}GetModuleInfo',
                    data: {id: moduleId},
                    success: function(data) {
                        if (data.status===true) {
                            var mediaField = value.mediaField ? value.mediaField.id || '' : '';
                            var checkField = value.checkField ? value.checkField.id || '' : '';
                            $('#s1_'+moduleId).data('results', data.result);
                            $('#s1_'+moduleId).prop('disabled', false).html(Glizy.template.render('ecomm-options', {items: data.result.fields, value: value.idField || ''}));
                            $('#s2_'+moduleId).prop('disabled', false).html(Glizy.template.render('ecomm-options', {items: data.result.media, value: mediaField}));
                            $('#s3_'+moduleId).prop('disabled', false).html(Glizy.template.render('ecomm-options', {items: _.union(data.result.fields, data.result.media), value: checkField}));
                        }
                    }
            });
        } else {
            \$elHidden.val(JSON.stringify({enabled: false}));
            $('#s1_'+moduleId).val('').prop('disabled', true)
            $('#s2_'+moduleId).val('').prop('disabled', true)
            $('#s3_'+moduleId).val('').prop('disabled', true)
        }
    });

    $('select.js-ecomm-select').change(function(){
        var \$el = \$(this);
        var moduleId = \$el.data('module');
        var \$elHidden = \$('#'+moduleId);

        var results = \$('#s1_'+moduleId).data('results');
        var mediaField = \$('#s2_'+moduleId).val();
        var checkField = \$('#s3_'+moduleId).val();

        \$elHidden.val(JSON.stringify({
                enabled: true,
                idField: $('#s1_'+moduleId).val(),
                mediaField: _.findWhere(results.media, {id: mediaField}),
                checkField: _.findWhere(_.union(results.fields, results.media), {id: checkField})
            }));
    });

    window.ecommValidation = function(e) {
        var result = true;
        $('input.js-ecomm').each(function(index, el){
            var \$el = \$(el);
            \$el.parent().prev().removeClass('GFEValidationError');
            if (el.checked) {
                var \$elHidden = \$el.next();
                var value = JSON.parse(\$elHidden.val());
                if (typeof(value)=='object') {
                    if (value.enabled && (!value.idField || !value.mediaField || !value.checkField)) {
                        \$el.parent().prev().addClass('GFEValidationError');
                        result = false;
                    }
                } else {
                    \$el.parent().prev().addClass('GFEValidationError');
                    result = false;
                }
            }
        });

        return result ? null : "$message";
    }

    Glizy.events.on("glizycms.formEdit.onReady", function(){
        $('input.js-ecomm').each(function(index, el){
            var \$el = \$(el);
            var \$elHidden = \$el.next();
            var value = \$elHidden.val();
            if (value) {
                value = JSON.parse(value);
                if (value.enabled) {
                    \$el.trigger('change');
                }
            } else {
                \$elHidden.val(JSON.stringify({enabled: false}));
            }
        });
    });


    Glizy.template.define('ecomm-options', ''+
        '<option value=""></option>'+
        '<% _.each(items, function(item) { %>'+
            '<option value="<%= item.id %>" <%= (item.id==value ? \'selected\':\'\')%>><%= item.label %></option>'+
        '<% }); %>'
        );
})
</script>
EOD;
        $this->addOutputCode($output);
    }
}
