if (jQuery && jQuery.GlizyRegisterType) { jQuery.GlizyRegisterType('mwcmsModulesList', {

    __construct: function () {
        var self = $(this).data('formEdit');
        self.val = $(this).val();
        self.element = $(this);
        self.modules = $(this).data('modules');
        self.activeModules = $(this).data('active_modules');
        self.id = $(this).attr('id');
        self.controllerName = $(this).data('controllername');
        self.pos = self.element.parent().parent().parent().find('div').first();

        var htmlTr =  '<% _.each( rc.modules, function(item, key) {%> ' +
                        '<tr>' +
                           '<td>' +
                               '<%- item %>' +
                            '</td>' +
                            '<td class= "actions" >' +
                            '<input type="hidden" id="<%- key %>" value="<%- item %>" />' +
                              '<% if(key in rc.activeModules) {%>' +
                                '<a title="{i18n:Edit}" class="js-solr-edit">' +
                                  '<i class="icon-pencil btn-icon"></i>' +
                                '</a>' +
                                '<a title="{i18n:Delete}" class="js-solr-del">' +
                                      '<i class="icon-trash btn-icon"></i>' +
                                '</a>' +
                              '<%} else {%>' +
                                '<a title="{i18n:Add}" class="js-solr-add">' +
                                      '<i class="icon-plus btn-icon"></i>' +
                                '</a>' +
                              '<%}%>' +
                            '</td>' +
                          '</tr>' +
                        '<%});%>';

        var htmlTable = '<table id="<%- rc.id %>" class="table table-striped table-bordered bootstrap-datatable dataTable">' +
                          '<thead><tr><th>{i18n:Module}</th><th style="width:1%; white-space:nowrap;">{i18n:Action}</th></tr></thead>' +
                          '<tbody>' +
                            htmlTr +
                          '</tbody>' +
                        '</table>';

        var rc = {
            id : self.id,
            modules : self.modules,
            activeModules : self.activeModules
        };

        self.init = function() {
            self.render(self.pos, rc, htmlTable);
        };

        self.render = function(pos, rc, html) {
            Glizy.template.define('dcList', html)
            pos.append(Glizy.template.render('dcList', {rc: rc}));
        };

        self.getModule = function ($el) {
          currentModule = $el.parent().find('input:hidden').first();
          var url = document.URL;
          var url = url.replace(url.substr(url.lastIndexOf('/') + 1), '') + 'edit/' +currentModule.attr('id');
          window.location.href = url;
        }

        self.init();

        $('.js-solr-edit, .js-solr-add').on('click', function(){
          self.getModule($(this));
        });

        $('.js-solr-del').on('click', function(){
            var moduleId = $(this).parent().parent().find('input:hidden').first().attr('id');
            $.ajax({
                url: Glizy.ajaxUrl + "&controllerName="+ self.controllerName + ".ModuleDelete",
                dataType: 'json',
                data: {'id' : moduleId},
                async: false,
                success: function(data) {
                  if(data.status) {
                    window.location.reload();
                  }
                }
            });
        });

    },

    getValue: function () {
       return $(this).val();
    },

    setValue: function (value) {
        $(this).val(value);
    },

    destroy: function () { }

});}