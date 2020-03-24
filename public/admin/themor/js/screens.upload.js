$(function () {

  screens.link.click(function () {

    console.clear();
    console.log('1: screens link click');


    imageUpload(addScreens);

    croppies({w: 300, h: 250}, {w: 700, h: 400});

    modal.modals
      .children('.modal-dialog')
      .addClass('modal-sm');

    modal.modals
      .modal('show');

  });

});