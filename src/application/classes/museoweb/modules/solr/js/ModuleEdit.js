if (jQuery && jQuery.GlizyRegisterType) { jQuery.GlizyRegisterType('mwcmsModuleEdit', {

    __construct: function () {
        var self = $(this).data('formEdit');
        self.val = $(this).val();
        self.element = $(this);
        self.controllerName = $(this).data('controllername');
        self.moduleId = $(this).data('module_id');
        self.fields = $(this).data('fields');
        self.actions = $(this).data('actions');
        self.id = $(this).attr('id');
        self.pos = self.element.parent().parent().parent().find('div').first();

        var htmlTr = '<% _.each( rc.currentMapping, function(mapping) {' +
                        'if (mapping[1] == _.last(rc.actions)) {' +
                            'var selectedHidden = "hidden"; var inputHidden = ""; var inputValue = mapping[0];' +
                        '} else {' +
                            'var selectedHidden = ""; var inputHidden = "hidden"; var inputValue = "";' +
                        '}%>'+
                        '<div class="control-group">' +
                        '<select class="js-solr-select-field span4 <%- selectedHidden %>" style="margin-left:25px;">' +
                            '<option value="" >-</option>' +
                            '<% _.each( rc.fields, function(field) {' +
                              'if(field.label) {' +
                                  'var selected = field.id == mapping[0] ? "selected" : ""; %>' +
                                  '<option value="<%- field.id %>" <%- selected%> ><%- field.label %></option>' +
                              '<%}'+
                            '});%>' +
                        '</select>' +
                        '<input type="text" value="<%- inputValue %>" class="<%- inputHidden %> span4" style="margin-left:25px;"/>' +
                        '<select class="js-solr-select-action span4" style="margin-left:25px;">' +
                          '<option value="" >-</option>' +
                        '<% _.each( rc.actions, function(action) {' +
                            'if(action) {' +
                                'var selected = action[0] == mapping[1] ? "selected" : ""; %>' +
                                '<option value="<%- action[0] %>" <%- selected%> ><%- action[1] %></option>' +
                            '<%}'+
                         '});%>'+
                         '</select>' +
                       '</div>' +
                     '<% });%>';

        var htmlTable = '<table id="<%- rc.id %>" class="solr-mapping table table-striped table-bordered bootstrap-datatable dataTable">' +
                          '<thead><tr><th>{i18n:Title}</th><th>{i18n:Mapping}</th></tr></thead>' +
                          '<tbody>' +
                           '<%  var i = rc.index;' +
                      '_.each( rc.items, function(item, key) {' +
                        ' rc.currentMapping = item.mapping ? item.mapping : rc.defaultMapping; %>' +
                        '<tr>' +
                           '<td>' +
                               '<%- item.title %>' +
                               '<input type="hidden" value="<%- key %>">' +
                            '</td>' +
                            '<td>' +
                              htmlTr +
                              '<a title="{i18n:Add}" class="js-solr-add solr-mapping-add" style="margin-top:15px;">' +
                                '<i class="icon-plus btn-icon"></i>' +
                              '</a>' +
                              '<% var delHidden = rc.currentMapping.length > 1 ? "" : "hidden";%>' +
                              '<a title="{i18n:Delete}" class="js-solr-del pull-right solr-mapping-delete <%- delHidden %>" >' +
                                '<i class="icon-trash btn-icon"></i>' +
                              '</a>' +
                            '</td>' +
                          '</tr>' +
                        '<%});%>';
                          '</tbody>' +
                        '</table>';

        var defaultMapping = [ ['-', '-'] ];
        var defaultItem = { title: '', solr: 1, facets: 0, lod: 1, mapping: defaultMapping };
        var items = { '' : defaultItem };
        var rc = {
            id : self.moduleId,
            items : items,
            fields : self.fields,
            actions : self.actions,
            currentMapping : defaultMapping,
            defaultMapping : defaultMapping
        };

        self.init = function() {
          self.getProfile();
          self.getMapping();
          self.render(self.pos, htmlTable);
        };

        self.render = function(pos, html) {
            Glizy.template.define('dcList', html)
            pos.append(Glizy.template.render('dcList', {rc: rc}));
            rc.index++;
        };

        self.getProfile = function() {
            $.ajax({
                url: Glizy.ajaxUrl + "&controllerName="+ self.controllerName + ".DcList",
                dataType: 'json',
                async: false,
                success: function(data) {
                  if(data.status && data.result) {
                    rc.items = data.result;
                  }
                }
            });
        }

         self.getMapping = function() {
            $.ajax({
                url: Glizy.ajaxUrl + "&controllerName="+ self.controllerName + ".GetMapping",
                dataType: 'json',
                data: {'id' : self.moduleId},
                async: false,
                success: function(data) {
                  if(data.status && data.result) {
                    $.each(data.result, function( key, value) {
                        if(key in rc.items) {
                          rc.items[key].mapping = value;
                        }
                    });
                  }
                }
            });
        }

        self.init();

        $(".js-solr-add").on('click', function() {
            rc.currentMapping = defaultMapping;
            rc.defaultMapping = defaultMapping;
            self.render($(this).parent(), htmlTr);
            $find = $(this).parent().parent().find('div');
            if($find.length > 1) {
              $(this).parent().find('.js-solr-del').first().removeClass('hidden');
            } else {
              $(this).parent().find('.js-solr-del').first().addClass('hidden');
            }
        });

        $(document).on('click', '.js-solr-del',  function() {
          $find = $(this).parent().parent().find('div');
           if($find.length > 1) {
              $find.last().remove();
           }
           if($find.length <=2 ) {
              $(this).addClass('hidden');
           }
        });

        $(document).on('change', '.js-solr-select-action',  function() {
            if($(this).val() === 'fixed') {
              $(this).parent().find('.js-solr-select-field').first().addClass('hidden');
              $(this).parent().find('input').first().removeClass('hidden');
            } else {
              $(this).parent().find('.js-solr-select-field').first().removeClass('hidden');
              $(this).parent().find('input').first().addClass('hidden');
            }
        });

    },

    getValue: function () {
      var mapping = {};
       $('#' + $(this).data('module_id') ).find('tr').each (function() {
          var key = $(this).find('input:hidden').first().val();
          if(key) {
            item = [];
            var i = 0;
            var field = [];
            $(this).find('input, select').not(':hidden').each (function() {
              field.push($(this).val() ? $(this).val() : '');
              if(++i%2 == 0) {
                item.push(field);
                field = [];
              }
            });
            mapping[key] = (item);
          }
       });
       return {'moduleId': $(this).data('module_id'), 'mapping': mapping};
    },

    setValue: function (value) {
        $(this).val(value);
    },

    destroy: function () { }

});}
