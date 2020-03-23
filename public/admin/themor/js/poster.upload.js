$(function () {

  var view_image = $(".poster .image");
  var view_no_image = $(".poster .no-image");

  var view_poster_input = $(".poster input[name=poster]");

  var view_kpid = $('[name=kpid]');

  var view_preview = $('.poster .preview');

  var view_overlay = $('.poster .overlay');

  var view_error = $('.error');

  var view_poster_link = $('.poster .link');

  var view_submit = $('input[type=submit]');

  var view_image_data_type = $('.poster .preview').attr('data-type');
  var view_image_data_name = $('.poster .preview').attr('data-name');
  var view_image_data_url = $('.poster .preview').attr('data-url');
  var view_button_delete = $('.poster .overlay .delete');
  var view_button_update = $('.poster .overlay .update');

  // modal
  var modal = $('#modal-image.modal');

  // action
  view_poster_link.click(function (event) {

    event.preventDefault();

    modal
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modal('show');

  });

});