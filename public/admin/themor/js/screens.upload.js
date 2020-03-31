$(function () {

  var modal = {
    // modal
    selector: $('#modal-screen .modal-dialog'),
    sm: $('#modal-screen .sm'),
    lg: $('#modal-screen .lg'),
    preview: $('#modal-screen .preview'),
    modals: $('#modal-screen.modal'),
    modals2: $('#modal-screens.modal'),
    modals_view: $('#view-image.modal'),
    // croppie
    mcroppie: $('#modal-screen .modal-body .croppie'),
    mcroppie2: $('#modal-screen .modal-body .croppie2'),
    // ajax
    button_croppie_poster: $('#modal-screen.poster .modal-body .croppie-upload'),
    button_croppie: $('#modal-screen .modal-body .croppie-upload'),
    // button
    button_parsing: $('#modal-screen .modal-body .btn-parsing'),
    button_file: $('#modal-screen .modal-body #btn-upload-file-screen'),
    button_url: $('#modal-screen .modal-body .btn-upload-url'),
  };

  var screens = {
    link: $("#screens .add-screen"),
    images: $("#screens .screens"),
    screen: $("#screens .screens .screen"),
    overlay: $("#screens .screens .screen .overlay"),
    view: $("#screens .screens .screen .overlay .view"),
    count_screen: $("#screens .screens .screen").length,
    count: screens_count,
  };


  // action
  modal.preview
    .hide()
    .html('');

  modal.lg
    .hide();

  modal.modals_view
    .find('.view > img')
    .attr('src','');

  screens.view.click(function () {

    var img = $(this).attr('data-img');

    modal.modals_view
      .find('.view > img')
      .attr('src',img);

    modal.modals_view.modal('show');

  });


  if (screens.count_screen > screens.count) {
    screens.link.parents('.card').hide();
  }

  screens.link.click(function (event) {

    event.preventDefault();

    console.log(screens.count_screen);

    if (screens.count_screen > screens.count) {

      console.clear();
      console.log('1: screens full block');
      screens.link.parents('.card').hide();

    } else {

      console.clear();
      console.log('1: screens link click');

      console.log(screens.count_screen);


      modal.modals
        .children('.modal-dialog')
        .addClass('modal-sm');

      modal.modals
        .modal('show');
    }


  });

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

        modal.mcroppie.croppie('bind', {
          url: e.target.result
        }).then(function () {
          console.log('3: croppie bind complete');
        });

        modal.selector
          .removeClass('modal-sm')
          .addClass('modal-lg');

        modal.sm.hide();

        modal.mcroppie.show();

        modal.lg.show();

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

            modal.mcroppie.croppie('bind', {
              url: response.data
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
        }
      });

      $(this).val('');
    }

  });
  // ajax result
  modal.button_croppie.click(function () {

    console.log('4: click button_croppie_screen');

    modal.mcroppie.croppie('result', {

      type: 'base64',
      size: 'viewport',
      format: 'jpeg'

    }).then(function (response) {

      // view

      var count_screens = $("#screens .screens .screen").length;

      screens.count_screen = count_screens + 1;

      console.log(screens.count_screen);

      screens.images.append(
        `<!-- screen -->
        <div class="screen screen-` + screens.count_screen + ` card col-6 float-left">
          <div class="card-body">
            <div class="form-group">
              <img src="` + response + `" class="img-fluid" alt="">
              
              <div class="overlay text-center">
                <div class="delete btn btn-primary" style="color: white; cursor: pointer">
                  <i class="fas fa-search"></i>
                </div>
                <div class="delete btn btn-danger ml-2" style="color: white; cursor: pointer">
                  <i class="far fa-trash-alt"></i>
                </div>
              </div>
              
            </div>
          </div>
          <input type="hidden" name="screens[` + screens.count_screen + `][data-type]" value="base64">
          <input type="hidden" name="screens[` + screens.count_screen + `][image]" value="` + response + `">
        </div>
        <!--./ screen -->`
      );


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


      if (screens.count_screen > screens.count) {
        screens.link.parents('.card').hide();
      }

      $("#screens").find('.screen').mouseover(function () {
        $(this).find('.overlay').css({'opacity': '1'});
      });

      $("#screens").find('.screen').mouseout(function () {
        $(this).find('.overlay').css({'opacity': '0'});
      });

    });

    //modal.mcroppie.croppie('destroy');

  });

  // others

  function isValid(format) {

    if ($.inArray(format, ['gif', 'png', 'jpg', 'jpeg']) == -1) {

      //$(this).val('');
      alert('Недопустимый формат файла');
      return false;

    } else {
      return true;
    }

  }

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


  // $('.screen .overlay').mouseover(function () {
  //   $(this).addClass('add');
  // });

  modal.modals.on('hide.bs.modal', function (e) {
    // action
    modal.selector
      .removeClass('modal-lg')
      .addClass('modal-sm');

    modal.sm.show();
    modal.lg.hide();

    modal.mcroppie.find('img.cr-image').attr('src', '');
  });


  screens.screen.on('mouseover', function () {
    $(this).find('.overlay').css({'opacity': '1'});
  });
  screens.screen.on('mouseout', function () {
    $(this).find('.overlay').css({'opacity': '0'});
  });
  screens.overlay.mouseover(function () {
    $(this).css({'opacity': '1'});
  });
  screens.overlay.mouseout(function () {
    $(this).css({'opacity': '0'});
  });


});