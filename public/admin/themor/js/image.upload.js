

$(function () {

  // action
  view.link.click(function (event) {

    //event.preventDefault();
    console.clear();
    console.log('1: poster click link');

    imageUpload(addPoster);

    croppies({w: 300, h: 250}, {w: 700, h: 400});

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

  });




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