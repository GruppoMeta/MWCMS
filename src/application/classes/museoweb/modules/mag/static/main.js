GlizyApp.pages[ 'museoweb.modules.mag.views.Admin' ] = function( state, routing ) {
    // todo: localizzare
    $(function(){
        if ('export' == state || 'massiveimport' == state || 'import' == state) {
            $.ajax({
                url: Glizy.ajaxUrl+"&controllerName=museoweb.modules.mag.controllers.ajax.GetModules",
                dataType: "json"
            }).done(function(result) {
                var html = '';
                if (result['result'].length > 0) {
                    html += 'massiveimport' == state ? '<option value="">-</option>' : '<option value="free">{i18n:Libero}</option>';
                    for (var i = 0; i < result['result'].length; i++) {
                        html += '<option value="' + result['result'][i]['id'] + '">' + result['result'][i]['value'] + '</option>';
                    }
                    $("#moduleId").html(html);
                    $("#moduleId").parents('div[class="control-group"]').show();
                }
            });

            $('input.js-export').click(function(e){
                e.preventDefault();
                var data = {moduleId: $('#moduleId').val(),
                            moduleName: $('#moduleId option:selected').text(),
                            from: $('#from').val(),
                            to: $('#to').val(),
                            exportMode: $("input[type=radio][name=exportMode]:checked").val()
                            };
                Glizy.startAjaxSteps(data, function(data) {
                    if ( data.status ) {
                        if (data.result[0] === undefined || data.result[0].action != "ExportMag") {
                            alert( 'Non ci sono record da esportare' );
                            return false;
                        }
                        return true;
                    }
                });
            });

        }
    });
}

