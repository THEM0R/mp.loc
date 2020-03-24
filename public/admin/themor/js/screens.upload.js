$(function () {

  function imageUpload(method) {

    // action
    modal.preview
      .hide()
      .html('');

    modal.lg
      .hide();

    // upload input
    modal.button_file.change(function () {

      console.log('2: change button_file');

      var poster = this.files[0];
      var format = poster.name.split('.').pop().toLowerCase();

      if (!isValid(format)) {

        $(this).val('');

      } else {

        var reader = new FileReader();

        reader.onload = function (e) {

          modal.mcroppie.croppie('bind', {
            url: e.target.result
          }).then(function () {
            console.log('3: croppie bind complete');
          });

          modal.selector
            .removeClass('modal-sm')
            .addClass('modal-lg');

          modal.sm.hide();

          modal.mcroppie.show();

          modal.lg.show();

        };
        reader.readAsDataURL(poster);

      }
    });
    // upload url
    modal.button_url.change(function () {

      console.log('2: change button_url');

      var url = $(this).val();

      var format = url.split('.').pop().toLowerCase();

      if (!isValid(format)) {

        $(this).val('');

      } else {

        $.ajax({
          type: 'POST',
          url: '/upload/url',
          data: {
            url: url
          },
          dataType: 'json',
          success: function (response) {
            if (response.type != 'error') {

              modal.mcroppie.croppie('bind', {
                url: response.data
              }).then(function () {
                console.log('3: croppie bind complete');
              });

              modal.selector
                .removeClass('modal-sm')
                .addClass('modal-lg');

              modal.sm.hide();

              modal.mcroppie.show();

              modal.lg.show();

            }
          }
        });

        $(this).val('');
      }

    });
    // ajax result
    modal.button_croppie_upload.click(function () {

      console.log('4: click button_croppie_upload');

      modal.mcroppie.croppie('result', {

        type: 'base64',
        size: 'viewport',
        format: 'jpeg'

      }).then(function (response) {

        // view

        console.log(method);

        addScreens(response);

        // modal
        modal.button_file.val('');

        modal.mcroppie.children('div').children('img').attr('src', '');

        modal.selector
          .removeClass('modal-lg')
          .addClass('modal-sm');

        modal.sm.show();
        modal.lg.hide();

        modal.preview.html('');

        modal.mcroppie.hide();

        //modal.mcroppie.croppie('destroy');

        modal.modals.modal('hide');
      });

      modal.mcroppie.croppie('destroy');

    });

    // others
    modal.mcroppie.croppie({

      enableExif: true,
      viewport: {
        width: 300,
        height: 250,
        type: 'canvas'
      },
      boundary: {
        width: 766,
        height: 450
      }
    });



  }

  screens.link.click(function () {

    console.clear();
    console.log('1: screens link click');

    imageUpload();

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

  });

});