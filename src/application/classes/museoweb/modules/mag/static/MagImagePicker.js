if (jQuery && jQuery.GlizyRegisterType) {

jQuery.GlizyRegisterType('MwcmsImagePicker', {

    $media : '',
    sequence: 0,

    getSequenceNumber: function(name){
        return name.substr(name.length -2, 1);
    },

    __construct: function () {
        var self = $(this).data('formEdit');
        self.val = $(this).val();
        self.element = $(this)
        glizyOpt = $(this).data('glizyOpt');
        self.id = self.element.parent().find('input').attr('name');
        sequence = self.getSequenceNumber(self.id);
        self.selectEl = null;
        self.currentId = 0;
        self.currentSequence = 0;
        self.controllerName = $(this).data('controllername');

        if(self.val === 'media') {
            freeSelected = '';
            mediaSelected = 'selected';
        } else {
            freeSelected = 'selected';
            mediaSelected = '';
        }

        $media = ($('[name^="img[img_name][' + sequence + ']"]').val())?$('[name^="img[img_name][' + sequence + ']"]').val():'';

        var html = $('<div class="controls js-mwcmsImagePicker" style="margin-bottom: 5px;">' +
                            '<select id="img[importMode][' + sequence + ']" name="img[importMode][' + sequence + ']" class="span11">'+
                                '<option value="free" ' + freeSelected +'>{i18n:Free}</option>'+
                                '<option value="media" ' + mediaSelected +'>{i18n:Get image from Media Archive}</option>'+
                            '</select>' +
                    '</div>'+
                    '<div class="js-filePickerDiv" id = "img[filePickerDiv][' + sequence + ']">' +
                        '<div>' +
                            '<label for="argumentId" class="control-label required">{i18n:File name}</label>' +
                            '<div class="controls">' +
                                '<input type="text" name ="img[imgName][' + sequence + ']" id="img[imgName][' + sequence + ']" value="' + $media + '" class="span6"/>' +
                                '<input id="img[mediaFilePicker][' + sequence + ']" type="button" value="{i18n:Select}" class="btn"/>' +
                            '</div>' +
                    '</div>'
                    );

        self.init = function() {
            var tempHtml = self.element.parent().parent().find('.js-mwcmsImagePicker');
            if (tempHtml.length==0) {
                self.element.parent().after(html);
                self.element.parent().hide();
            } else {
                html = tempHtml;
            }

            var $selectEl = html.find('select').first();
            var $filePicker = $selectEl.parent().parent().find('.js-filePickerDiv').first();

            $filePicker.find('input').click( function() {
                if( $selectEl.val() !== 'media') {
                    return true;
                }
                $media = $(this).find('input').first();
                self.currentSequence = self.getSequenceNumber($(this).attr('id'));
                var url = glizyOpt.mediaPicker;
                url += '&mediaType=IMAGE';
                Glizy.closeIFrameDialog(true);
                Glizy.openIFrameDialog( GlizyLocale.MediaPicker.imageTitle,
                                        url,
                                        900,
                                        50,
                                        50,
                                        self.openDialogCallback);
            });

            $media = html.find('input').first();


            if($('[name^="img[img_id][' + sequence + ']"]').val()) {
                $selectEl.val('media');
                $filePicker.show();
                self.currentId = $('[name^="img[img_id][' + sequence + ']"]').val();
                self.currentSequence = sequence;
                self.getMediaInfo();
            } else {
                self.changeMode($filePicker, self.val || $selectEl.val());
            }

            $selectEl.on('change', function(){
                self.changeMode($filePicker, $(this).val())
            });

            if($('#mag_lock').prop('checked')) {
                self.reFillSelect();
            };
        };

        self.changeMode = function($filePicker, mode){
             self.currentSequence = self.getSequenceNumber($filePicker.attr('id'));
             if(mode === 'media') {
                $filePicker.find('input:button').first().show();
                self.setReadOnlyField();
            } else {
                $filePicker.find('input:button').first().hide();
                self.removeReadOnlyField();
            }
            self.element.parent().val(mode);
        };

        self.openDialogCallback = function() {
            var $frame = $(this).children();
            $frame.on("load", function () {
                var $frameDocument = $($frame.contents().get(0));
                $('img', $frameDocument).on('click', function() {
                    $media.val($(this).attr('title'));
                    self.currentId = $(this).attr('data-id');
                    self.getMediaInfo();
                    Glizy.closeIFrameDialog(true);
                });

                $frameDocument.on('keyup', function(e) {
                    var charCode = e.charCode || e.keyCode || e.which;
                    if (charCode == 27){
                        checkList = [];
                        Glizy.closeIFrameDialog(true);
                        self.initImageParams();
                    }
                });
            });
        };

        self.getMediaInfo = function() {
            $.ajax({
                url: Glizy.ajaxUrl + "&controllerName="+self.controllerName,
                dataType: 'json',
                async: false,
                data: {id: self.currentId},
                success: function(data) {
                    $.each(data.result, function( key, value) {
                        $('[name="img['+ key + '][' + self.currentSequence + ']"]').val(value).prop('readonly', true).addClass('readonly').prop('disabled', true);
                    });

                }
            });
        };

        self.setReadOnlyField = function(){
            $.each($('[name^="img["][name$="[' + self.currentSequence +']"]').not('[name*=importMode], [name*=imgName], [name*=mag_sequence_number],[name*=mag_nomenclature],[name*=mag_usage],[name*=mag_side]'), function( key, value) {
                $(this).prop('disabled', true).addClass('readonly').prop('readonly', true);
                $('[name*=imgName]').addClass('readonly').prop('readonly', true);
            });
            if($('#mag_lock').prop('checked') && $('#mag_lock').prop('disabled')) {
                $('[name*=importMode]').prop('disabled', true).prop('readonly', true);
            }
        };

        self.removeReadOnlyField = function(){
            if($('#mag_lock').prop('checked') && $('#mag_lock').prop('disabled') ) {
                return;
            }
            $.each($('[name^="img["][name$="[' + self.currentSequence +']"]').not('[name*=importMode]', '[name*=imgName]'), function( key, value) {
               $(this).prop('disabled', false).removeClass('readonly').prop('readonly', false);
               $('[name*=imgName]').removeClass('readonly').prop('readonly', false);
            });
        };

        self.reFillSelect = function() {
            $.each($('select[name^="img["][name$="[' + sequence +']"]'), function( key, value) {
               value = $(this).parent().find('input').val();
               name = $(this).attr('name');
               if( value ){
                    $(this).val(value);
               }
            });
        };

        self.init();

    },

    getValue: function () {
       return $(this).parent().val();
    },

    setValue: function (value) {
        $(this).parent().val(value);
    },

    destroy: function () {
    }
});
}
