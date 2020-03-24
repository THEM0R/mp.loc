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
        view.preview
          .attr('src', response)
          .attr('data-name', '')
          .attr('data-url', '')
          .attr('data-type', 'base64')
          .show();

        view.image_data_type = 'base64';
        view.poster_input.attr('value', response);
        view.image.show();
        view.no_image.hide();

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

  // action
  view.link.click(function (event) {

    //event.preventDefault();
    console.clear();
    console.log('1: poster click link');

    imageUpload();

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

  });

  // delete view.image_datatype
  view.button_delete.click(function () {

    console.log('5: view button delete click');
    //console.log(view.image_data_type);

    if (view.image_data_type == 'image') {
      // remove image
      $.ajax({
        type: 'POST',
        url: '/upload/delete',
        data: {
          url: view.image_data_url,
          name: view.image_data_name
        },
        dataType: 'json',
        success: function (response) {

          if (response.type != 'error') {

            view.image.hide();
            view.no_image.show();

            view.preview
              .attr('src', '')
              .attr('data-name', '')
              .attr('data-url', '')
              .attr('data-type', '');

            view.poster_input.val('');

          }
        }
      });

    } else if (view.image_data_type == 'base64') {
      // remove base64

      view.image.hide();
      view.no_image.show();

      view.preview
        .attr('src', '')
        .attr('data-name', '')
        .attr('data-url', '')
        .attr('data-type', '')
        .hide();

      view.poster_input.val('');
    }

  });

  view.preview.mouseover(function () {
    view.overlay.css({'opacity': '1'});
  });
  view.preview.mouseout(function () {
    view.overlay.css({'opacity': '0'});
  });
  view.overlay.mouseover(function () {
    $(this).css({'opacity': '1'});
  });
  view.overlay.mouseout(function () {
    $(this).css({'opacity': '0'});
  });


});