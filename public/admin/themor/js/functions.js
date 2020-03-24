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
        bindCroppie(e.target.result);
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
            bindCroppie(response.data);
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

      method(response);

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



  });

  // others
  // modal.mcroppie.croppie({
  //
  //   enableExif: true,
  //   viewport: {
  //     width: 300,
  //     height: 250,
  //     type: 'canvas'
  //   },
  //   boundary: {
  //     width: 766,
  //     height: 450
  //   }
  // });

  //croppies({w: 300, h: 250}, {w: 700, h: 400});

}

function addPoster(response) {
  // view
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
}

function addScreens(response) {
  // Screens

  screens.images.append(
    `<!-- screen -->
        <div style="" class="card col-6 float-left">
          <div class="card-body">
            <div class="form-group">
              <img src="`+response+`" class="img-fluid" alt="">
            </div>
          </div>
        </div>
        <!--./ screen -->`
  );

  modal.modals.modal('hide');

  // view.preview
  //   .attr('src', response)
  //   .attr('data-name', '')
  //   .attr('data-url', '')
  //   .attr('data-type', 'base64')
  //   .show();
  //
  // view.image_data_type = 'base64';
  // view.poster_input.attr('value', response);
  // view.image.show();
  // view.no_image.hide();
}

function croppies(viewport = {w: 300, h: 250, t: 'canvas'}, boundary = {w: 766, h: 450}) {

  modal.mcroppie.croppie({

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
    console.log('3: croppie bind complete');
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


