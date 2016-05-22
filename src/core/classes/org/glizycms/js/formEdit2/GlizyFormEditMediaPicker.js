Glizy.oop.declare("glizy.FormEdit.mediapicker", {
    $extends: Glizy.oop.get('glizy.FormEdit.standard'),
    $mediaPicker: null,
    populateDataEnabled: false,
    
    initialize: function (element, glizyOpt) {
        element.data('instance', this);
        this.$element = element;
        this.populateDataEnabled = element.attr('data-populate_data') == 'true';
        
        var that = this;
        var $input = element.hide(),
            pickerType = $input.attr('data-mediatype'),
            hasPreview = $input.attr('data-preview') == 'true';
        
        that.$mediaPicker =
            hasPreview ? jQuery('<div id="'+element.attr('name')+'-mediapicker" class="mediaPickerSelector mediaPickerField"><div class="mediaPickerCaption"></div><div class="mediaPickerElement">' + GlizyLocale.MediaPicker.imageEmpty + '</div></div>')
            : jQuery('<input class="mediaPickerField" type="text" size="50" readonly="readonly" style="cursor:pointer" value="' + GlizyLocale.MediaPicker.imageEmptyText + '">');

        if (!$input.next().hasClass('mediaPickerField')) {
            that.$mediaPicker.insertAfter($input).click(function() {
                    var url = glizyOpt.mediaPicker;
                    if (pickerType) {
                        url += '&mediaType=' + pickerType;
                    }
                    Glizy.openIFrameDialog( hasPreview ? GlizyLocale.MediaPicker.imageTitle : GlizyLocale.MediaPicker.mediaTitle,
                                            url,
                                            900,
                                            50,
                                            50,
                                            that.openDialogCallback );
                    Glizy.lastMediaPicker = that;
                });
        }
        
    },
    
    getValue: function () {
        return this.$element.val();
    },
    
    setValue: function (value) {
        if (value) {
            this.setProps(JSON.parse(value));
        }
    },
    
    populateData: function(values) {
        // TODO: slegare il componente dal repeater
        var $container = this.$element.closest('.GFERowContainer');
        
        for (var field in values) {
            var $el = $container.find('input[data-media_picker_mapping='+field+']');
            if ($el) {
                var obj = $el.data('instance');
            
                if (obj) {
                    obj.setValue(values[field]);
                }
            }
        }
    },
    
    clearData: function() {
        // TODO: slegare il componente dal repeater
        var $container = this.$element.closest('.GFERowContainer');
        $container.find('input[disabled=disabled]').val('');
    },
    
    setProps: function (props) {
        var $this = this.$mediaPicker,
            $img = $this.find('img');
            
        if (this.populateDataEnabled) {
            if (props) {
                this.populateData(props);
            } else {
                this.clearData();
            }
        }

        if (!props || !props.id) {
            if ($img.length) {
                $img.replaceWith(GlizyLocale.MediaPicker.imageEmpty);
            }
            else {
                $this.val(GlizyLocale.MediaPicker.imageEmptyText);
            }
            $this.prev().val('');
        }
        else {
            if ($img.length) {
                $img.load(function () {

                        var w = this.naturalWidth,
                            h = this.naturalHeight,
                            maxW = $this.width() -6,
                            maxH = $this.height() -6;

                        if (w > maxW) {
                            h = h * (maxW / w);
                            w = maxW;
                        }
                        if (h > maxH) {
                            w = w * (maxH / h);
                            h = maxH;
                        }
                        jQuery(this).attr({width: w, height: h})
                            .show();
                    })
                    .hide();

                $img.attr({title: props.title, src: 'getImage.php?id='+props.id+'&w=150&h=150&c=1&co=0&f=0&t=1&.jpg'})
                    .data({id: props.id, fileName: props.fileName});

                if ($img[0].complete && $img[0].naturalWidth !== 0) {
                    $img.trigger('load');
                }
            }
            else {
                $this.val(props.title);
            }
            $this.prev().val( JSON.stringify(props) );
        }
    },
    
    getName: function () {
        return this.$element.attr('name');
    },
    
    getPreview: function (val) {
        try {
            var props = JSON.parse(val);
            return props.title;
        } catch(e) {
            return val;
        }
    },
    
    openDialogCallback: function() {
        var that = this;
        var $frame = jQuery(this).children();
        $frame.load(function () {
            jQuery( "a.js-glizyMediaPicker-a", $frame.contents().get(0)).click( function(){
                var $img = jQuery( this ).find("img.js-glizyMediaPicker");

                Glizy.lastMediaPicker.setProps({
                    id: $img.data( "id" ),
                    fileName: $img.data( "filename" ),
                    title: $img.attr( "title" ),
                    src: $img.attr( "src" ),
                    category: $img.data( "category" ),
                    author: $img.data( "author" ),
                    date: $img.data( "date" ),
                    copyright: $img.data( "copyright" )
                });

                Glizy.closeIFrameDialog();
                //var mediaPickerId = $input.attr('id')+'-mediapicker';
                //$('#'+mediaPickerId).removeClass('GFEValidationError');
            });

            jQuery( ".js-glizycmsMediaPicker-noMedia", $frame.contents().get(0)).click( function(){
                Glizy.lastMediaPicker.setProps();
                Glizy.closeIFrameDialog();
            });
        });
    },

    focus: function () {
        var mediaPickerId = this.$element.attr('id')+'-mediapicker';
        $('#'+mediaPickerId).addClass('GFEValidationError');
        document.getElementById(mediaPickerId).scrollIntoView();
    },
    
    destroy: function() {
    },
    
    isDisabled: function() {
        return this.$element.attr('disabled') == 'disabled';
    },
    
    addClass: function(className) {
        this.$element.addClass(className);
    },
    
    removeClass: function(className) {
        this.$element.removeClass(className);
    }
});