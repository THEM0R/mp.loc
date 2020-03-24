function views(view, response) {
  // view
  view.preview
    .attr('src', response)
    .attr('data-name', '')
    .attr('data-url', '')
    .attr('data-type', 'base64')
    .show();

  view.data_type = 'base64';
  view.poster_input.attr('value', response);
  view.image.show();
  view.no_image.hide();
}

function croppies(window, viewport = {w: 300, h: 250, t: 'canvas'}, boundary = {w: 766, h: 450}) {

  window.croppie({

    enableExif: true,
    viewport: {
      width: viewport.w,
      height: viewport.h,
      type: viewport.t
    },
    boundary: {
      width: boundary.w,
      height: boundary.h
    }
  });

}

function bindCroppie(data) {

  modal.mcroppie.croppie('bind', {
    url: data
  }).then(function () {
    console.log('jQuery bind complete');
  });

  modal.selector
    .removeClass('modal-sm')
    .addClass('modal-lg');

  modal.sm.hide();

  modal.mcroppie.show();

  modal.lg.show();

}

function isValid(format) {

  if ($.inArray(format, ['gif', 'png', 'jpg', 'jpeg']) == -1) {

    //$(this).val('');
    alert('Недопустимый формат файла');
    return false;

  } else {
    return true;
  }

}

function imageUpload(modal, view) {

  // action
  modal.preview
    .hide()
    .html('');

  modal.lg
    .hide();

  // upload input
  modal.button_file.change(function () {

    var poster = this.files[0];
    var format = poster.name.split('.').pop().toLowerCase();

    if (!isValid(format)) {
      $(this).val('');
    } else {
      var reader = new FileReader();
      reader.onload = function (e) {
        bindCroppie(e.target.result);
      };
      reader.readAsDataURL(poster);
    }

  });
  // upload url
  modal.button_url.change(function () {

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

            bindCroppie(response.data);

          }
        }
      });

      $(this).val('');
    }

  });
  // ajax result
  modal.button_croppie_upload.click(function () {

    modal.mcroppie.croppie('result', {

      type: 'base64',
      size: 'viewport',
      format: 'jpeg'

    }).then(function (response) {

      // view
      views(view, response);

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
      modal.modals.modal('hide');

    });

  });

  // others
  croppies(modal.mcroppie, {w: 300, h: 250}, {w: 700, h: 400});
  // croppies(modal.mcroppie);

}