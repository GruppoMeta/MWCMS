GlizyApp.pages[ 'museoweb.modules.solr.views.Admin' ] = function( state, routing ) {

    $(function(){
        if ('index'==state) {
            window.mwcms_startAjaxSteps = function() {
                Glizy.startAjaxSteps([]);
            }
        }
    });
}
