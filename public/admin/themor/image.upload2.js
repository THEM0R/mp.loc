

$(function () {
  // modal
  var modal_selector = $('#modal-image .modal-dialog');

  var modal_sm = $('#modal-image .sm');
  var modal_lg = $('#modal-image .lg');

  var modal_preview = $('#modal-image .preview');

  var modal = $('#modal-image.modal');

  // croppie
  var modal_croppie = $('#modal-image .modal-body .croppie');

  // ajax
  var modal_button_croppie_upload = $('#modal-image .modal-body .croppie-upload');

  // button
  var modal_button_parsing = $('#modal-image .modal-body .btn-parsing');

  var modal_button_file = $('#modal-image .modal-body #btn-upload-file');

  var modal_button_url = $('#modal-image .modal-body .btn-upload-url');

  // action
  modal_preview.hide().html('');
  modal_lg.hide();
  // upload url
  modal_button_url.change(function () {

    var url = $(this).val();

    var format = url.split('.').pop().toLowerCase();

    if ($.inArray(format, ['gif', 'png', 'jpg', 'jpeg']) == -1) {

      $(this).val('');
      alert('Недопустимый формат файла');

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

            modal_croppie.croppie('bind', {
              url: response.data
            }).then(function () {
              console.log('jQuery bind complete');
            });

            modal_selector
              .removeClass('modal-sm')
              .addClass('modal-lg');

            modal_sm.hide();

            modal_croppie.show();

            modal_lg.show();

          }
        }
      });

      $(this).val('');
    }

  });
  // upload input
  modal_button_file.change(function () {
    var poster = this.files[0];
    var format = poster.name.split('.').pop().toLowerCase();
    if ($.inArray(format, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
      $(this).val('');
      alert('Недопустимый формат файла');
    } else {

      var reader = new FileReader();

      reader.onload = function (e) {

        modal_croppie.croppie('bind', {
          url: e.target.result
        }).then(function () {
          console.log('jQuery bind complete');
        });

        modal_selector
          .removeClass('modal-sm')
          .addClass('modal-lg');

        modal_sm.hide();

        modal_croppie.show();

        modal_lg.show();

      };

      reader.readAsDataURL(poster);
    }

  });
  // ajax result
  modal_button_croppie_upload.click(function () {

    modal_croppie.croppie('result', {

      type: 'base64',
      size: 'viewport',
      format: 'jpeg'

    }).then(function (resp) {

      console.log('document');

      // view_preview.css('background-image', "url('" + resp + "')").show();
      view_preview
        .attr('src', resp)
        .attr('data-name', '')
        .attr('data-url', '')
        .attr('data-type', 'base64')
        .show();

      view_image_data_type = 'base64';

      view_overlay.show();

      view_poster_input.attr('value', resp).attr('data-type', 'base64');

      view_image.show();
      view_no_image.hide();

      modal_button_file.val('');

      modal_croppie.children('div').children('img').attr('src', '');

      modal_selector
        .removeClass('modal-lg')
        .addClass('modal-sm');

      modal_sm.show();
      modal_lg.hide();

      modal_preview.html('');

      modal_croppie.hide();
      modal.modal('hide');

    });

  });

  // others
  modal_croppie.croppie({

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


  // delete view_image_datatype
  view_button_delete.click(function () {
    console.log('view button delete click');
    console.log(view_image_data_type);
    if (view_image_data_type == 'image') {
      // remove image
      $.ajax({
        type: 'POST',
        url: '/upload/delete',
        data: {
          url: view_image_data_url,
          name: view_image_data_name
        },
        dataType: 'json',
        success: function (response) {

          if (response.type != 'error') {

            view_image.hide();
            view_no_image.show();

            view_preview
              .attr('src', '')
              .attr('data-name', '')
              .attr('data-url', '')
              .attr('data-type', '');

            view_poster_input.val('');

          }
        }
      });

    } else if (view_image_data_type == 'base64') {
      // remove base64

      view_image.hide();
      view_no_image.show();

      view_preview
        .attr('src', '')
        .attr('data-name', '')
        .attr('data-url', '')
        .attr('data-type', '')
        .hide();

      view_poster_input.val('');
    }

  });

  view_preview.mouseover(function () {
    view_overlay.css({'opacity': '1'});
  });
  view_preview.mouseout(function () {
    view_overlay.css({'opacity': '0'});
  });
  view_overlay.mouseover(function () {
    $(this).css({'opacity': '1'});
  });
  view_overlay.mouseout(function () {
    $(this).css({'opacity': '0'});
  });


});