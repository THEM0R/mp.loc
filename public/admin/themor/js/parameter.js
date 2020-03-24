var modal = {
  // modal
  selector: $('#modal-image .modal-dialog'),
  sm: $('#modal-image .sm'),
  lg: $('#modal-image .lg'),
  preview: $('#modal-image .preview'),
  modals: $('#modal-image.modal'),
  modals2: $('#modal-screens.modal'),
  // croppie
  mcroppie: $('#modal-image .modal-body .croppie'),
  mcroppie2: $('#modal-image .modal-body .croppie2'),
  // ajax
  button_croppie_poster: $('#modal-image.poster .modal-body .croppie-upload'),
  button_croppie_screen: $('#modal-image.screen .modal-body .croppie-upload'),
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
  link: $('.poster .link'),
  submit: $('input[type=submit]'),
  image_data_type: $('.poster .preview').attr('data-type'),
  image_data_name: $('.poster .preview').attr('data-name'),
  image_data_url: $('.poster .preview').attr('data-url'),
  button_delete: $('.poster .overlay .delete'),
  button_update: $('.poster .overlay .update'),
};

var screens = {
  link: $("#screens .add-screen"),
  images: $("#screens .screens"),
};

