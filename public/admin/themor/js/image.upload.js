$(function () {

  // action
  view.poster_link.click(function (event) {

    event.preventDefault();

    imageUpload(modal, view);

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

  });


  // delete view.image_datatype
  view.button_delete.click(function () {
    console.log('view button delete click');
    console.log(view.data_type);
    if (view.data_type == 'image') {
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

    } else if (view.data_type == 'base64') {
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