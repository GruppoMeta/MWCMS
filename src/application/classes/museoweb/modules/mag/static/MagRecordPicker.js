if (jQuery && jQuery.GlizyRegisterType) {
jQuery.GlizyRegisterType('MwcmsRecordPicker', {
	__construct: function () {
        var self = this;
        var el = $(this);
        el.removeAttr('value');

        self.controllerName = $(this).data('controllername');
        self.typeVal = '';
        self.typeEl = null;
        self.init = function() {
            // aggiunge un elemento prima per la scelta del tipo di record

            var htmlMagAvailable = '';
            $(mwcmsMagAvailable).each(function(index, value){
                htmlMagAvailable += '<option value="'+value[0]+'">'+value[1]+'</option>';
            });
            var type = $('<div class="controls" style="margin-bottom: 5px;"><input id="ref_idaa" type="hidden" value="" /><select id="modeLinkedObject">'+
                            '<option value="">Libero</option>'+
                            htmlMagAvailable+
                            '</select></div>');

            el.parent().before(type);
            self.typeEl = type.find('select').first();
            self.typeOnChange(self.typeEl.on('change', function(){
                self.typeOnChange();
            }));

            // inizializza select2
            el.select2({
                placeholder: '',
                allowClear: true,
                minimumInputLength: 3,
                ajax: {
                    url: Glizy.ajaxUrl + "&controllerName="+self.controllerName,
                    dataType: 'json',
                    quietMillis: 100,
                    data: function(term) {
                        return {
                            term: term,
                            type: self.typeVal
                        };
                    },
                    results: function(data, page ) {
                        return { results: data }
                    }
                },
                formatResult: function(data) {
                    return data.text+'<br><small>'+data.path+'</small>';
                },
                formatSelection: function(data) {
                    self.selectFromPicker(data.data);
                    return data.text+' <small>'+data.path+'</small>';
                }
            });

            // reimposta i valori
            var value = el.data('origValue');
            if (value) {
                var valuePart = value.split(':');
                self.typeEl.val(valuePart[0]);
                self.typeOnChange();
                $.ajax({
                    url: Glizy.ajaxUrl + "&controllerName="+self.controllerName,
                    dataType: 'json',
                    data: {id: value},
                    success: function(data) {
                        el.select2('data', data[0]);
                    }
                });
            }
        }

        self.typeOnChange = function() {
            self.typeVal = self.typeEl.val();
            self.removeReadOnlyFields();
            if (!self.typeVal) {
                self.hidePicker();
            } else {
                self.showPicker();
            }
            $('#ref_model_id').val(self.typeVal);
        };

        self.hidePicker = function() {
            el.data('ref_id', 0);
            el.parent().hide();
        };


        self.showPicker = function() {
            el.data('ref_id', 0);
            el.parent().show();
        };

        self.selectFromPicker = function(data) {
            // applica i valori ai campi ritornati ed imposta i campi come readOnly
            self.removeReadOnlyFields();
            if(!$('#mag_lock').prop('checked'))
            {
                for (var k in data) {
                    var tempEl = $('#'+k);
                    if (data[k] && tempEl) {
                        if (k=='img') {
                            var message = {};
                            message.targetId = 'img';
                            message.data = data[k];
                            Glizy.events.broadcast("glizycms.repeater.setValues", message);
                            continue;
                        }
                        tempEl.val(data[k]);
                        tempEl.attr('readonly', true);
                    }
                }
            }
            el.data('ref_id', data['ref_id']);
        };

        self.removeReadOnlyFields = function() {
            /*TODO rimuove tutti i readonly*/
            if($('#mag_lock').prop('checked') && $('#mag_lock').prop('disabled') ) {
                $("#modeLinkedObject").prop('disabled', true);
                return;
            }
            $('input[readOnly]').not('[name*="img["]').attr('readonly', false);
        };
        self.init();
	},

	getValue: function () {
        return $(this).data('ref_id');
	},

	setValue: function (value) {
        if (value && value.length && value[0].id) {
            $(this).select2('data', value);
        }
	},

	destroy: function () {
	}
});

}