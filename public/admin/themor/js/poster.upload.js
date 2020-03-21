$(function () {
  // modal
  var modal_selector = $('#modal-poster .modal-dialog');

  var modal_sm = $('#modal-poster .sm');
  var modal_lg = $('#modal-poster .lg');

  var modal_preview = $('#modal-poster .preview');

  var modal = $('#modal-poster.modal');

  // croppie
  var modal_croppie = $('#modal-poster .modal-body .croppie');

  // view
  var view_image = $(".poster .image");
  var view_no_image = $(".poster .no-image");

  var view_poster_input = $(".poster input[name=poster]");

  var view_kpid = $('[name=kpid]');

  var view_preview = $('.poster .preview');

  var view_overlay = $('.poster .overlay');

  var view_error = $('.error');

  var view_poster_link = $('.poster .link');

  var view_submit = $('input[type=submit]');

  // ajax
  var modal_button_croppie_upload = $('#modal-poster .modal-body .croppie-upload');

  // button
  var modal_button_parsing = $('#modal-poster .modal-body .btn-parsing');

  var modal_button_file = $('#modal-poster .modal-body #btn-upload-file');

  var modal_button_url = $('#modal-poster .modal-body .btn-upload-url');

  // action
  view_poster_link.click(function (event) {

    console.log('click');

    event.preventDefault();

    modal.modal('show');

  });
  modal_preview.hide().html('');
  modal_lg.hide();
  view_image.hide();

  view_error.hide();

  // ajax result
  modal_button_croppie_upload.click(function () {

    modal_croppie.croppie('result', {

      type: 'base64',
      size: 'viewport',
      format: 'jpeg'

    }).then(function (resp) {

      console.log('document');


      // view_preview.css('background-image', "url('" + resp + "')").show();
      view_preview.attr('src',resp).show();
      view_overlay.show();

      view_poster_input.attr('value', resp).attr('data-type', 'base64');

      view_image.show();
      view_no_image.hide();

      modal_button_file.val('');

      modal_croppie.children('div').children('img').attr('src', '');

      modal_selector
        .removeClass('modal-lg')
        .addClass('modal-sm');

      modal_sm.show();
      modal_lg.hide();

      modal_preview.html('');

      modal_croppie.hide();
      modal.modal('hide');

    });

  });

  // others
  modal_croppie.croppie({

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

  // upload url
  modal_button_url.change(function () {

    var url = $(this).val();

    var format = url.split('.').pop().toLowerCase();

    if ($.inArray(format, ['gif', 'png', 'jpg', 'jpeg']) == -1) {

      $(this).val('');
      alert('Недопустимый формат файла');

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

            modal_croppie.croppie('bind', {
              url: response.data
            }).then(function () {
              console.log('jQuery bind complete');
            });

            modal_selector
              .removeClass('modal.sm')
              .addClass('modal-lg');

            modal_sm.hide();

            modal_croppie.show();

            modal_lg.show();

          }
        }
      });

      $(this).val('');
    }

  });
  // upload input
  modal_button_file.change(function () {

    var poster = this.files[0];

    var format = poster.name.split('.').pop().toLowerCase();

    if ($.inArray(format, ['gif', 'png', 'jpg', 'jpeg']) == -1) {

      $(this).val('');
      alert('Недопустимый формат файла');

    } else {
      var reader = new FileReader();

      reader.onload = function (e) {

        modal_croppie.croppie('bind', {
          url: e.target.result
        }).then(function () {
          console.log('jQuery bind complete');
        });

        modal_selector
          .removeClass('modal.sm')
          .addClass('modal-lg');

        modal_sm.hide();

        modal_croppie.show();

        modal_lg.show();

      };

      reader.readAsDataURL(poster);
    }

  });

  // delete
  $('.poster .overlay #delete').click(function () {
    view_poster_link.show();
    view_no_image.show();

    view_preview.hide();
    view_overlay.hide();
    view_preview.css('background-image', "url('')").hide();
    view_poster_input.attr('value', '');
  });

  // modal_selector.on($.modal.CLOSE, function () {
  //
  //   modal_button_file.val('');
  //
  //   view_error.text('').hide();
  //
  //   modal_croppie.children('div').children('img').attr('src', '');
  //
  //   modal_croppie.hide();
  //
  //   modal_sm.show();
  //
  //   modal_preview.hide().html('');
  //
  //   modal_ajax.hide();
  //
  //   modal_selector.removeClass('modal-600');
  //   modal_selector.removeClass('modal-900');
  //
  // });

  $('#modal-poster .close').click(function () {
    modal.modal('hide');
  });

  view_preview.mouseover(function () {
    view_overlay.css({'opacity': '1'});
  });
  view_preview.mouseout(function () {
    view_overlay.css({'opacity': '0'});
  });
  view_overlay.mouseover(function () {
    $(this).css({'opacity': '1'});
  });
  view_overlay.mouseout(function () {
    $(this).css({'opacity': '0'});
  });


});