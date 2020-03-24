$(function () {

  var modal = {
    // modal
    selector: $('#modal-poster .modal-dialog'),
    sm: $('#modal-poster .sm'),
    lg: $('#modal-poster .lg'),
    preview: $('#modal-poster .preview'),
    modals: $('#modal-poster.modal'),
    modals2: $('#modal-screens.modal'),
    // croppie
    mcroppie: $('#modal-poster .modal-body .croppie'),
    mcroppie2: $('#modal-poster .modal-body .croppie2'),
    // ajax
    button_croppie: $('#modal-poster .modal-body .croppie-upload'),
    button_croppie_screen: $('#modal-poster.screen .modal-body .croppie-upload'),
    // button
    button_parsing: $('#modal-poster .modal-body .btn-parsing'),
    button_file: $('#modal-poster .modal-body #btn-upload-file-poster'),
    button_url: $('#modal-poster .modal-body .btn-upload-url'),
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

  // action
  view.link.click(function (event) {
    event.preventDefault();

    console.clear();
    console.log('1: poster click link');

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
      format: 'jpeg'

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
    view.poster_input.attr('value', response);
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

  $(modal.modals).on('hide.bs.modal', function (e) {
    // do something...
    $(this).removeClass('screen')
      .removeClass('poster');
  });


  // others
  modal.mcroppie.croppie({

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