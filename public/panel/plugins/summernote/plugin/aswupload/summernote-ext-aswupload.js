(function(factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(window.jQuery);
  }
}(function($) {
  // pull in some summernote core functions
  var ui = $.summernote.ui;
  var dom = $.summernote.dom;

  // define the popover plugin
  var AswUploadPlugin = function(context) {
    var self = this;
    var options = context.options;
    var lang = options.langInfo;

    self.icon = '<i class="fa fa-image"/>';

    // add context menu button for dialog
    context.memo('button.aswupload', function() {
      return ui.button({
        contents: self.icon,
        tooltip: lang.aswupload.insert,
        click: context.createInvokeHandler('aswupload.showDialog'),
      }).render();
    });

    // add popover edit button
    context.memo('button.aswuploadDialog', function() {
      return ui.button({
        contents: self.icon,
        tooltip: lang.aswupload.edit,
        click: context.createInvokeHandler('aswupload.showDialog'),
      }).render();
    });






    //  add popover size buttons
    context.memo('button.aswuploadSize100', function() {
      return ui.button({
        contents: '<span class="note-fontsize-10">100%</span>',
        tooltip: lang.image.resizeFull,
        click: context.createInvokeHandler('editor.resize', '1'),
      }).render();
    });
    context.memo('button.aswuploadSize50', function() {
      return ui.button({
        contents: '<span class="note-fontsize-10">50%</span>',
        tooltip: lang.image.resizeHalf,
        click: context.createInvokeHandler('editor.resize', '0.5'),
      }).render();
    });
    context.memo('button.aswuploadSize25', function() {
      return ui.button({
        contents: '<span class="note-fontsize-10">25%</span>',
        tooltip: lang.image.resizeQuarter,
        click: context.createInvokeHandler('editor.resize', '0.25'),
      }).render();
    });




    self.events = {
      'summernote.init': function(we, e) {
        // update existing containers
        $('data.ext-aswupload', e.editable).each(function() { self.setContent($(this)); });
        // TODO: make this an undo snapshot...
      },
      'summernote.keyup summernote.mouseup summernote.change summernote.scroll': function() {
        self.update();
      },
      'summernote.dialog.shown': function() {
        self.hidePopover();
      },
    };

    self.initialize = function() {
      // create dialog markup
      var $container = options.dialogsInBody ? $(document.body) : context.layoutInfo.editor;

      var body = '<div class="form-group row-fluid">' +
          '<label>' + lang.aswupload.inputLabel + '</label>' +
          '<input class="ext-aswupload-file form-control" type="file" name="file" />' +
          '</div>';
      var footer = '<button href="#" class="btn btn-primary ext-aswupload-save">' + lang.aswupload.insert + '</button>';

      self.$dialog = ui.dialog({
        title: lang.aswupload.name,
        fade: options.dialogsFade,
        body: body,
        footer: footer,
      }).render().appendTo($container);

      // create popover
      self.$popover = ui.popover({
        className: 'ext-aswupload-popover',
      }).render().appendTo('body');
      var $content = self.$popover.find('.popover-content');

      context.invoke('buttons.build', $content, options.popover.aswupload);
    };

    self.destroy = function() {
      self.$popover.remove();
      self.$popover = null;
      self.$dialog.remove();
      self.$dialog = null;
    };

    self.update = function() {
      // Prevent focusing on editable when invoke('code') is executed
      if (!context.invoke('editor.hasFocus')) {
        self.hidePopover();
        return;
      }

      var rng = context.invoke('editor.createRange');
      var visible = false;

      if (rng.isOnData()) {
        var $data = $(rng.sc).closest('data.ext-aswupload');

        if ($data.length) {
          var pos = dom.posFromPlaceholder($data[0]);

          self.$popover.css({
            display: 'block',
            left: pos.left,
            top: pos.top,
          });

          // save editor target to let size buttons resize the container
          context.invoke('editor.saveTarget', $data[0]);

          visible = true;
        }
      }

      // hide if not visible
      if (!visible) {
        self.hidePopover();
      }
    };

    self.hidePopover = function() {
      self.$popover.hide();
    };

    // define plugin dialog
    self.getInfo = function() {
      var rng = context.invoke('editor.createRange');

      if (rng.isOnData()) {
        var $data = $(rng.sc).closest('data.ext-aswupload');

        if ($data.length) {
          // Get the first node on range(for edit).
          return {
            node: $data,
            test: $data.attr('data-test'),
          };
        }
      }

      return {};
    };

    self.setContent = function($node) {
      $node.html('<p contenteditable="false">' + self.icon + ' ' + lang.aswupload.name + ': ' +
        $node.attr('data-test') + '</p>');
    };

    self.updateNode = function(info) {
      self.setContent(info.node
        .attr('data-test', info.test));
    };

    self.createNode = function(info) {
      var $node = $('<img class="img-responsive img-fluid" />');

      if ($node) {
        // save node to info structure
        info.node = $node;
        // insert node into editor dom
        context.invoke('editor.insertNode', $node[0]);
      }

      return $node;
    };

    self.showDialog = function() {
      var info = self.getInfo();
      var newNode = !info.node;
      context.invoke('editor.saveRange');

      self
        .openDialog(info)
        .then(function(dialogInfo) {
          // [workaround] hide dialog before restore range for IE range focus
          ui.hideDialog(self.$dialog);
          context.invoke('editor.restoreRange');

          // insert a new node
          if (newNode) {
            self.createNode(info);
          }

          // update info with dialog info
          $.extend(info, dialogInfo);

          self.updateNode(info);
        })
        .fail(function() {
          context.invoke('editor.restoreRange');
        });
    };

    self.openDialog = function(info) {
      return $.Deferred(function(deferred) {
        var $fileInput = self.$dialog.find('.ext-aswupload-file');
        var $saveButton = self.$dialog.find('.ext-aswupload-save');
        var onKeyup = function(event) {
          if (event.keyCode === 13) {
            $saveButton.trigger('click');
          }
        };

        ui.onDialogShown(self.$dialog, function() {
          context.triggerEvent('dialog.shown');

          $fileInput.val(info.test).on('input', function() {
            ui.toggleBtn($saveButton, $fileInput.val());
          }).trigger('focus').on('keyup', onKeyup);

          $saveButton
            .text(info.node ? lang.aswupload.edit : lang.aswupload.insert)
            .click(function(event) {
              event.preventDefault();
              //alert("Butona Tıklandı");
              var ajaxImageUploadUrl = $('#ajaxImageUploadUrl').val();
              var file = $fileInput[0].files[0];
              var formData = new FormData();
              formData.append('image', file);
              $.ajax({
                  url: ajaxImageUploadUrl,
                  type: 'POST',
                  data: formData,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  enctype: 'multipart/form-data',
                  success: function(cevap){
                      if(cevap.status == true){
                          var img = $('<img src="'+cevap.image+'" class="img-responsive img-fluid"/>');
                          context.invoke('editor.insertNode', img[0]);
                          ui.hideDialog(self.$dialog);
                      }
                  }
              });

              //deferred.resolve({ test: $fileInput.val() });
            });

          // init save button
          ui.toggleBtn($saveButton, $fileInput.val());
        });

        ui.onDialogHidden(self.$dialog, function() {
          $fileInput.off('input keyup');
          $saveButton.off('click');

          if (deferred.state() === 'pending') {
            deferred.reject();
          }
        });

        ui.showDialog(self.$dialog);
      });
    };
  };

  // Extends summernote
  $.extend(true, $.summernote, {
    plugins: {
      aswupload: AswUploadPlugin,
    },

    options: {
      popover: {
        aswupload: [
          ['aswupload', ['aswuploadDialog', 'aswuploadSize100', 'aswuploadSize50', 'aswuploadSize25', 'aswuploadFloatLeft']],
        ],
      },
    },

    // add localization texts
    lang: {
      'tr-TR': {
        aswupload: {
          name: 'ASW Görsel Yükleme (Upload)',
          insert: 'Görsel Yükle (Upload)',
          edit: 'Görseli Düzenle',
          inputLabel: 'Görseli seçin',
        },
      },
    },

  });
}));
