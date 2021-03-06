$(function () {

  var modal = {
    // modal
    selector: $('#modal-drawing .modal-dialog'),
    sm: $('#modal-drawing .sm'),
    lg: $('#modal-drawing .lg'),
    preview: $('#modal-drawing .preview'),
    modals: $('#modal-drawing.modal'),
    modals2: $('#modal-screens.modal'),
    // croppie
    mcroppie: $('#modal-drawing .modal-body .croppie'),
    mcroppie2: $('#modal-drawing .modal-body .croppie2'),
    // ajax
    button_croppie: $('#modal-drawing .modal-body .croppie-upload'),
    button_croppie_screen: $('#modal-drawing.screen .modal-body .croppie-upload'),
    // button
    button_parsing: $('#modal-drawing .modal-body .btn-parsing'),
    button_file: $('#modal-drawing .modal-body #btn-upload-file-drawing'),
    button_url: $('#modal-drawing .modal-body .btn-upload-url'),
  };

  var view = {
    image: $(".drawing .image"),
    no_image: $(".drawing .no-image"),
    drawing_input: $(".drawing input[name=drawing]"),
    drawing_data_type: $(".drawing input[name=drawing-data-type]"),
    kpid: $('[name=kpid]'),
    preview: $('.drawing .preview'),
    overlay: $('.drawing .overlay'),
    error: $('.error'),
    link: $('.drawing .link'),
    submit: $('input[type=submit]'),
    image_data_type: $('.drawing .preview').attr('data-type'),
    image_data_name: $('.drawing .preview').attr('data-name'),
    image_data_url: $('.drawing .preview').attr('data-url'),
    button_delete: $('.drawing .overlay .delete'),
    button_update: $('.drawing .overlay .update'),
  };

  // action

  view.button_update.click(function (event) {
    event.preventDefault();

    console.clear();
    console.log('1: drawing click button_update');

    // modal.mcroppie2.croppie('destroy');
    // console.log('mcroppie2 destroy');

    // modal.mcroppie.croppie('destroy');
    // console.log('mcroppie destroy');

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

  });

  view.link.click(function (event) {
    event.preventDefault();

    console.clear();
    console.log('1: drawing click link');

    // modal.mcroppie2.croppie('destroy');
    // console.log('mcroppie2 destroy');

    // modal.mcroppie.croppie('destroy');
    // console.log('mcroppie destroy');

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

  });


  // action
  modal.preview
    .hide()
    .html('');

  modal.lg
    .hide();

  // upload input
  modal.button_file.on('change',function () {

    console.log('2: change button_file');

    var poster = this.files[0];
    var format = poster.name.split('.').pop().toLowerCase();

    if (!isValid(format)) {

      $(this).val('');

    } else {

      var reader = new FileReader();

      reader.onload = function (e) {

        var base64 = e.target.result;

        bindCroppie(base64);

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
  modal.button_croppie.click(function () {

    console.log('4: click button_croppie');

    modal.mcroppie.croppie('result', {

      type: 'base64',
      size: 'viewport',
      format: 'png',
      backgroundColor:'#fff'

    }).then(function (response) {

      // view
      addView(response);

      // modal
      addModal();

    });

    //modal.mcroppie.croppie('destroy');


  });

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

  function addView(response){
    // view
    view.preview
      .attr('src', response)
      .attr('data-name', '')
      .attr('data-url', '')
      .attr('data-type', 'base64')
      .show();

    view.image_data_type = 'base64';
    view.drawing_input.attr('value', response);
    view.drawing_data_type.attr('value', 'base64');
    view.image.show();
    view.no_image.hide();

  }

  function addModal(){
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

  modal.modals.on('hide.bs.modal', function (e) {
    // action
    modal.selector
      .removeClass('modal-lg')
      .addClass('modal-sm');

    modal.sm.show();
    modal.lg.hide();

    modal.mcroppie.find('img.cr-image').attr('src','');
  });


  // others
  modal.mcroppie.croppie({
    format: 'png',
    backgroundColor:'#fff',
    enableExif: true,
    viewport: {
      width: 700,
      height: 200,
      type: 'canvas'
    },
    boundary: {
      width: 766,
      height: 450
    }
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

            view.drawing_input.val('');

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

      view.drawing_input.val('');
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