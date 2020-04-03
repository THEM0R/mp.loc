$(function () {

  var price = {
    // price
    btn_delete: $('.price').children('.card-footer').find('.delete'),
    id: 0,
    href: '',
    article: ''
  };

  var modal = $('#modal-alert.modal');

  $('#prices').find('.price_id_delete').click(function () {

    price.href = $(this).attr('data-href');
    price.id = $(this).attr('data-id');
    price.article = $(this).attr('data-article');



    modal.modal('show');



  });

  var btn_true = $('#modal-alert.modal .security .true');

  btn_true.click(function () {

    modal.modal('hide');

    $.ajax({
      type: 'POST',
      url: price.href,
      data:{
        id: price.id,
        article: price.article
      },
      dataType: 'json',
      success: function (response) {
        if (response.type != 'error') {
          window.location.href = response.url;
        }
      }
    });

  });

  $('#add-column222').click(function () {

    //
    $('#prices222').append(`<tr>

            <input type="hidden" name="<?=$pric['id']?>[id]" value="<?=$pric['id']?>">
            <input type="hidden" name="<?=$pric['id']?>[type]" value="">

            <td>
              <select
                name="<?=$pric['id']?>[category]"
                id="selectCategory" class="form-control custom-select" style="width: 100%;">
                <option value="0" selected disabled>Вибрати</option>
                <option value="1">Матеріали</option>
                <option value="2">Металопрокат</option>
              </select>
            </td>
            <td>
              <select name="<?=$pric['id']?>[article]" id="selectArticle"
                      class="form-control custom-select" style="width: 100%;">
                <? foreach($article as $art) : ?>
                <option value="<?=$art['id'];?>" selected><?=$art['name'];?></option>
                <? endforeach; ?>
              </select>
            </td>
            <td>
              <input type="text" name="<?=$pric['id']?>[header]"
                     value="<?=$pric['header']?>"
                     class="form-control">
            </td>
            <td>
              <input type="text" name="<?=$pric['id']?>[name]"
                     value="<?=$pric['name']?>"
                     class="form-control">
            </td>


            <td>
              <input type="text" name="<?=$pric['id']?>[price_1]"
                     value="<?=$pric['price_1']?>"
                     class="form-control">
            </td>
            <td>
              <input type="text" name="<?=$pric['id']?>[price_2]"
                     value="<?=$pric['price_2']?>"
                     class="form-control">
            </td>

            <td>
              <div class="btn btn-danger disabled" style="cursor: pointer">
                <i class="fas fa-trash-alt"></i>
              </div>
            </td>

          </tr>`);
  });


});