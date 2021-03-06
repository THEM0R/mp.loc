$(function () {
  var modal = {
    // modal
    selector: $('#modal-image .modal-dialog'),
    sm: $('#modal-image .sm'),
    lg: $('#modal-image .lg'),
    preview: $('#modal-image .preview'),
    modal: $('#modal-image.modal'),
    // croppie
    croppie: $('#modal-image .modal-body .croppie'),
    // ajax
    button_croppie_upload: $('#modal-image .modal-body .croppie-upload'),
    // button
    button_parsing: $('#modal-image .modal-body .btn-parsing'),
    button_file: $('#modal-image .modal-body #btn-upload-file'),
    button_url: $('#modal-image .modal-body .btn-upload-url'),
  };

  var view = {
    image: $(".poster .image"),
    no_image: $(".poster .no-image"),
    poster_input: $(".poster input[name=poster]"),
    kpid: $('[name=kpid]'),
    preview: $('.poster .preview'),
    overlay: $('.poster .overlay'),
    error: $('.error'),
    poster_link: $('.poster .link'),
    submit: $('input[type=submit]'),
    image_data_type: $('.poster .preview').attr('data-type'),
    image_data_name: $('.poster .preview').attr('data-name'),
    image_data_url: $('.poster .preview').attr('data-url'),
    button_delete: $('.poster .overlay .delete'),
    button_update: $('.poster .overlay .update'),
  };

});