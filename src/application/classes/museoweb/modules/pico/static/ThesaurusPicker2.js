Glizy.oop.declare("glizy.FormEdit.picoThesaurus", {
    $extends: Glizy.oop.get('glizy.FormEdit.standard'),

    thesaurus: null,
    thesaurusAdd: null,
    
	initialize: function (element, glizyOpt) {
        this.$super(element);
        var self = this;
    
        element.hide();

        // self.controllerName = $(this).data('controllername');
        // self.typeVal = '';

        // aggiunge un elemento prima per la scelta del tipo di record
        var html = $('<div class="thesaurus"></div><div class="thesaurusAdd"></div>');

        element.parent().before(html);
        this.thesaurus = html.first();
        this.thesaurusAdd = this.thesaurus.next();
        this.thesaurusAdd.click(function(){
            var url = glizyOpt.mediaPicker.replace(/MediaArchive_picker/i, 'PicoThesaurus_picker');
            Glizy.picoThesaurus = self;
            Glizy.openIFrameDialog( 'Seleziona voci da aggiungere al thesaurus PICO',
                    url,
                    900,
                    50,
                    50,
                    null );
        });

        $(document).on('click', 'a.js-removeThesaurus', function(e) {
            e.preventDefault();
            self.removeThesaurus($(this).data('id'));
        });

        this.updateState();
	},
    
    addThesaurus: function(newVal) {
        Glizy.closeIFrameDialog();

        var value = this.$element.val();
        if ( value.indexOf( newVal ) != -1 ) return;
        if ( value == "" ) value = "__pico__";
        else value += ",";
        value += newVal;
        this.$element.val(value);
        this.updateState();
    },
    
   updateState: function(newVal) {
        var value = this.$element.val();
        var html = "";
        if ( value != "" ) {
            value = value.substring( 8 )
            var aValues = value.split( "," );
            for( var i=0; i < aValues.length; i++ )
            {
                var part = aValues[ i ].split( "\"" );
                html += "<div class=\"thesaurusItem\">"+part[ 1 ]+"<a href=\"#\" class=\"js-removeThesaurus\" data-id=\""+part[0]+"\"></a></div>";
            }
        }
        this.thesaurus.html(html);
    },
    
    removeThesaurus: function( id ) {
        var value = this.$element.val();
        value = value.substring( 8 )
        var aValues = value.split( "," );
        var newValues = [];
        for( var i=0; i < aValues.length; i++ )
        {
            var part = aValues[ i ].split( "\"" );
            if ( part[ 0 ] != id )
            {
                newValues.push( aValues[ i ] );
            }
        }

        if ( newValues.length )
        {
            this.$element.val("__pico__"+newValues.join(","));
        }
        else
        {
            this.$element.val("");
        }
        this.updateState();
    },
});
