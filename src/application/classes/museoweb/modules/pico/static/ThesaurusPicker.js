jQuery.GlizyRegisterType('picoThesaurus', {
	__construct: function () {
        var self = this,
            el = $(this),
            glizyOpt = el.data('glizyOpt');

        el.hide();

        // self.controllerName = $(this).data('controllername');
        // self.typeVal = '';
        self.thesaurus = null;
        self.thesaurusAdd = null;
        self.init = function() {
            // aggiunge un elemento prima per la scelta del tipo di record
            var html = $('<div class="thesaurus"></div><div class="thesaurusAdd"></div>');

            el.parent().before(html);
            self.thesaurus = html.first();
            self.thesaurusAdd = self.thesaurus.next();
            self.thesaurusAdd.click(function(){
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
                var el = $(this);
                self.removeThesaurus(el.data('id'));
            });

            self.updateState();
        };

        self.addThesaurus = function(newVal) {
            Glizy.closeIFrameDialog();

            var value = el.val();
            if ( value.indexOf( newVal ) != -1 ) return;
            if ( value == "" ) value = "__pico__";
            else value += ",";
            value += newVal;
            el.val(value);
            self.updateState();
        }

        self.updateState = function(newVal) {
            var value = el.val();
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
            self.thesaurus.html(html);
        }

        self.removeThesaurus = function( id )
        {
            var value = el.val();
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
                el.val("__pico__"+newValues.join(","));
            }
            else
            {
                el.val("");
            }
            self.updateState();
        };

        self.init();
	},

    getValue: function () {
        return $(this).val();
    },

    setValue: function (value) {
        $(this).val(value);
    },

    destroy: function () {
    }
});
