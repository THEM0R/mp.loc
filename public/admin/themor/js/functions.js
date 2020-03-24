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

