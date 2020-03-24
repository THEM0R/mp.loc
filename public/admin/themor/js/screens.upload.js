$(function () {

  var modal = {
    // modal
    selector: $('#modal-screen .modal-dialog'),
    sm: $('#modal-screen .sm'),
    lg: $('#modal-screen .lg'),
    preview: $('#modal-screen .preview'),
    modals: $('#modal-screen.modal'),
    modals2: $('#modal-screens.modal'),
    // croppie
    mcroppie: $('#modal-screen .modal-body .croppie'),
    mcroppie2: $('#modal-screen .modal-body .croppie2'),
    // ajax
    button_croppie_poster: $('#modal-screen.poster .modal-body .croppie-upload'),
    button_croppie: $('#modal-screen .modal-body .croppie-upload'),
    // button
    button_parsing: $('#modal-screen .modal-body .btn-parsing'),
    button_file: $('#modal-screen .modal-body #btn-upload-file-csreen'),
    button_url: $('#modal-screen .modal-body .btn-upload-url'),
  };

  var screens = {
    link: $("#screens .add-screen"),
    images: $("#screens .screens"),
  };




  // action
  modal.preview
    .hide()
    .html('');

  modal.lg
    .hide();

  // upload input
  modal.button_file.change( function () {

    console.log('2: change button_file');

    var poster = this.files[0];
    var format = poster.name.split('.').pop().toLowerCase();


    if (!isValid(format)) {

      $(this).val('');

    } else {

      var reader = new FileReader();

      console.log($(this).val());

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

    console.log('4: click button_croppie_screen');

    modal.mcroppie2.croppie('result', {

      type: 'base64',
      size: 'viewport',
      format: 'jpeg'

    }).then(function (response) {

      // view

      console.log(method);

      addScreens(response);

      // modal
      modal.button_file.val('');

      modal.mcroppie2.children('div').children('img').attr('src', '');

      modal.selector
        .removeClass('modal-lg')
        .addClass('modal-sm');

      modal.sm.show();
      modal.lg.hide();

      modal.preview.html('');

      modal.mcroppie2.hide();

      //modal.mcroppie2.croppie('destroy');

      modal.modals.modal('hide');
    });

    //modal.mcroppie2.croppie('destroy');

  });


  screens.link.click(function (event) {
    event.preventDefault();

    console.clear();
    console.log('1: screens link click');

    // modal.mcroppie.croppie('destroy');
    // console.log('mcroppie destroy');

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

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
  modal.mcroppie2.croppie({

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


});