$(function(){
    var progressPart, progress, steps, stepPos, stepResult;

    function openExportDialog() {
        window.onbeforeunload = exitWarning;
        $( "#progress_bar" ).modal({ overlayCss: {background: "#000"}, overlayClose: false, closeHTML:'' });
    }

    function closeExportDialog() {
        window.onbeforeunload = null;
        $.modal.close();
        resetProgressBar();
    }

    function exitWarning(e) {
        var msg = 'Attenzione, uscendo da questa pagina verra\' interrotto il processo!';
        e = e || window.event;
        // For IE and Firefox prior to version 4
        if (e) {
          e.returnValue = msg;
        }
        // For Safari
        return msg;
    };

    function resetProgressBar() {
        jQuery.fx.off = true;
        $('#progress_bar .ui-progress').width("0%");
        $('#progress_bar .ui-label').hide();
    };

    function execStep() {
        if ( stepPos >= steps.length )
        {
            closeExportDialog();
            if ( stepResult.status )
            {
                alert('Indice aggiornato');
            }
            return;
        }
        progress += progressPart;

        $('#progress_bar .ui-progress').animateProgress( progress );
        // per ogni azione esegue una richiesta ajax
        jQuery.ajax( {
            url: Glizy.ajaxUrl+steps[ stepPos ].action,
            data: steps[ stepPos ].params,
            dataType: "json",
            success: function( data ){
                stepResult = data;
                stepPos++;
                execStep();
            } } );

    }

    window.mwcms_startAjaxSteps = function() {
        openExportDialog();

        $.ajax({
           url: Glizy.ajaxUrl+"getSteps",
            dataType: 'json',
            success: function( data ) {
                if ( data.status )
                {
                    progressPart = 100 / data.result.length;
                    progress = 0;
                    stepPos = 0;
                    steps = data.result;
                    execStep();
                }
                else
                {
                    closeExportDialog();
                    alert( 'Si è verificato un errore' );
                }
            }
        });
    };
});