if (jQuery && jQuery.GlizyRegisterType) { jQuery.GlizyRegisterType('mwcmsDcList', {
    __construct: function () {
        var self = $(this).data('formEdit');
        self.val = $(this).val();
        self.element = $(this);
        self.controllerName = $(this).data('controllername');
        self.fields = $(this).data('fields');
        self.options = $(this).data('options');
        self.id = $(this).attr('id');
        self.pos = self.element.parent().parent().parent().find('div').first();

        var htmlTr =  '<% _.each( rc.items, function(item, key) { %>' +
                      '<tr>' +
                          '<td>' +
                            '<% if (rc.index <= 2) {%>'+
                                '<select id="field_<%- rc.index %>" data-type="select" disabled="disabled" class="readonly">' +
                            '<%} else { %>' +
                                '<select id="field_<%- rc.index %>" data-type="select" class="required">' +
                            '<%}%>' +
                                '<% _.each( rc.fields, function(field, label) {' +
                                    'if (rc.index > 2) {' +
                                      'selected = label === key ? \'selected\' : \'\';' +
                                    '} else if (rc.index == 0 ){' +
                                      'selected = label === \'title\' ? \'selected\' : \'\';' +
                                    '} else if (rc.index == 1 ){' +
                                      'selected = label === \'image\' ? \'selected\' : \'\';' +
                                    '} else {' +
                                      'selected = label === \'description\' ? \'selected\' : \'\';' +
                                    '} %>' +
                                    '<option value="<%- label %>" <%- selected %> ><%- label %></option>' +
                                '<%});%>' +
                            '</select>' +
                          '</td>' +
                          '<td>' +
                            '<input type="text" data-type="text" id="title_<%- rc.index %>" value="<%- item.title %>" class="required" />' +
                          '</td>' +
                          '<% _.each( rc.options, function(option) {'+
                            ' var checked = item[option] ? \'checked\' : \'\';%>' +
                            '<td>' +
                                '<input id="<%- option %>_<%- rc.index %>" value="<%- item[option] %>" type="checkbox" data-type="checkbox" <%- checked %> />' +
                            '</td>' +
                          '<% });%>' +
                          '<td>' +
                            '<% if (rc.index > 2) {%>' +
                              '<a title="{i18n:Delete}" class="js-solr-del pull-right" >' +
                                '<i class="icon-trash btn-icon"></i>' +
                              '</a>' +
                            '<%}%>' +
                          '</td>' +
                          '<% if(rc.index==0) delete rc.fields[\'title\'];' +
                          'rc.index++; });%>' +
                        '</tr>';

        var htmlTable = '<table id="<%- rc.id %>" class="table table-striped table-bordered bootstrap-datatable dataTable">' +
                          '<thead><tr><th>{i18n:Field}</th><th>{i18n:Title}</th><th style="width:1%; white-space:nowrap;">{i18n:SOLR}</th><th style="width:1%; white-space:nowrap;">{i18n:Facets}</th><th style="width:1%; white-space:nowrap;">{i18n:Lod mapping}</th><th style="width:1%; white-space:nowrap;">{i18n:Action}</th></tr></thead>' +
                          '<tbody>' +
                            htmlTr +
                          '</tbody>' +
                        '</table>';

        var defaultItem = { title: '', solr: 1, facets: 0, lod: 1 }
        var items = { 'dc:title' : defaultItem, 'image' : defaultItem };
        var rc = {
            id : self.id,
            fields : self.fields,
            options : self.options,
            items : items,
            index : 0
        };

        self.init = function() {
            self.getProfile();
            self.render(self.pos, htmlTable);
        };

        self.render = function(pos, html) {
            Glizy.template.define('dcList', html)
            pos.append(Glizy.template.render('dcList', {rc: rc}));
            //rc.index++;
        };

        self.setProfile = function () {
          var solrProfile = {};
          $('#' + self.id + ' tr').each(function(index) {
            if (index) {
              var i = index -1;
              var item = {};
              item.solr = $('#solr_' + i).prop('checked') ? 1 : 0;
              item.facets = $('#facets_' + i).prop('checked') ? 1 : 0;
              item.lod = $('#lod_' + i).prop('checked') ? 1 : 0;
              item.title = $('#title_' + i).val();
              solrProfile[$('#field_' + i).val()] = item;
            }
          });
          return JSON.stringify(solrProfile);
        };

        self.getProfile = function() {
            $.ajax({
                url: Glizy.ajaxUrl + "&controllerName="+self.controllerName,
                dataType: 'json',
                async: false,
                success: function(data) {
                  if(data.status && data.result) {
                    rc.items = data.result;
                  }
                }
            });
        };


        self.init();

        $('.js-glizycms-add').on('click', function(){
            rc.items = { '-' : defaultItem};
            pos = $('#' + self.id + ' tbody');
            self.render(pos, htmlTr);
        });

        $(document).on('click', '.js-solr-del',  function() {
           $(this).parent().parent().remove();
        });

    },

    getValue: function () {
       var self = $(this).data('formEdit');
       var val = self.setProfile();;
       return val;
    },

    setValue: function (value) {
        $(this).val(value);
    },

    destroy: function () { }
});}
