$(function() {

  // 選択した景品情報表示
  $(document).on('click', '.choice_btn', function() {

    // 選択した景品の情報を取得
    let id = $(this).closest('tr').children("td")[0].innerText;
    let name = $(this).closest('tr').children("td")[1].innerText;
    let category_name = $(this).closest('tr').children("td")[2].innerText;
    let select = $('#taste' + id).html();

    // 指定した景品に在庫がない場合
    // 味選択のセレクトタグを『新しい味』で固定
    if (typeof select == 'undefined') {
      select = '<select class="select addInput" name="taste_name[]"><option value="new">新しい味</option></select>';
    };

    // 景品のフィールドを作って入力欄作成
    // 納品個数入力欄、納品した景品の情報入力欄
    $('#addDataForm').append('\
      <div class="field' + id + ' fields">\
        <input class="inventory_cancel ' + id + '" type="button" value="×" />\
        <h3>' + name + ' ' + category_name + '</h3>\
        \
        <div class="add_data_stock">\
          <label>納品個数</label><span>：</span><input class="empty_alert addInput" type="number" name="stock[]" min=0 />\
        </div>\
        \
        <div class="add_data' + id + '">\
          <div class="add_data_input">\
            <input type="hidden" name="inventory_id[]" value="' + id + '"/>\
            \
            <label>味：</label>\
            <div class="add_data_taste_input">\
              ' + select + '\
              <div class="new_taste">\
                <input class="empty_alert addInput" type="text" name="new_taste_name[]" placeholder="20字以内" />\
              </div>\
            </div>\
            <label>賞味期限</label><span>：</span><input class="empty_alert addInput" type="date" name="expired_at[]" max="9999-12-31" />\
            \
          </div>\
        </div>\
      </div>\
    ');

    // 同じ景品を選択できないように.choiceにdisabled trueを設定
    $(this).prop('disabled', true);

    // 味追加ボタンを押せるように.add_tasteにdisabled falseを設定
    $('.add_taste' + id).prop('disabled', false);
  });

  // 味追加
  $(document).on('click', '.add_taste_btn', function() {
    let id = $(this).closest('tr').children("td")[0].innerText;
    let select = $('#taste' + id).html();

    // 指定した景品に在庫がない場合
    // 味選択のセレクトタグを『新しい味』で固定
    if (typeof select == 'undefined') {
      select = '<select class="select addInput" name="taste_name[]"><option value="new">新しい味</option></select>';
    };

    // 作成されたフィールドに追加
    // 納品した景品の情報入力欄
    $('.field' + id).append('\
      <div class="add_data' + id + '">\
        <div class="add_data_input">\
          <input type="hidden" name="inventory_id[]" value="' + id + '"/>\
          \
          <label>味：</label>\
          <div class="add_data_taste_input">\
            ' + select + '\
            <div class="new_taste">\
              <input class="empty_alert addInput" type="text" name="new_taste_name[]" placeholder="20字以内" />\
            </div>\
          </div>\
          <label>賞味期限</label><span>：</span><input class="empty_alert addInput" type="date" name="expired_at[]" max="9999-12-31" />\
          \
          <input type="hidden" name="stock[]" value="0" />\
          <input class="cancel ' + id + '" type="button" value="×" />\
        </div>\
      </div>\
    ');
  })

  // 景品選択解除
  $(document).on('click', '.inventory_cancel', function() {

    // 選択解除
    $(this).closest('.fields').remove();

    // 選択し直せるようにdisabled解除、味追加ボタンは押せない用事disabled登録
    let id = $(this).attr('class').split(' ');
    $('.choice' + id[1]).prop('disabled', false);
    $('.add_taste' + id[1]).prop('disabled', true);
  });

  // 追加景品情報入力欄１つ削除
  $(document).on('click', '.cancel', function() {
    let id = $(this).attr('class').split(' ');
    $(this).closest('.add_data' + id[1]).remove();
  });

  // select boxで’新しい味’が選択されている時text boxを表示
  $(document).on('change', '.select', function() {
    let option = $(this).val();

    // 新しい味か既存の味か
    // 新しい時入力欄を表示, 余分だempty_alertクラスを削除
    if (option == 'new') {
      $(this).nextAll('.new_taste:first').css('display', 'block');
      $(this).nextAll('.new_taste:first').find('.addInput').addClass('empty_alert');

    // 既存の味の時入力欄非表示
    } else {
      $(this).nextAll('.new_taste:first').css('display', 'none');
      $(this).nextAll('.new_taste:first').find('.addInput').removeClass('empty_alert');
    }
  });

  // inputが全て入力されているかの確認①
  $(document).on('change', '.addInput', function() {
    let addInput = $(this).val();

    // 入力されていない時empty_alertクラス追加
    if (addInput == '') {
      $(this).addClass('empty_alert');

    // されていたら削除
    } else if (addInput != '') {
      $(this).removeClass('empty_alert');
    }
  });

  // フォーム送信ボタン
  $('#add').on('click', function() {

    // 景品を選択していない場合
    if ($('.fields').length == 0) {
      alert('追加する項目がありません！');

    // 入力に不備がある場合
    } else if (typeof $('.empty_alert').val() != 'undefined') {
      alert('入力されてない項目があります！');

    // 送信
    } else {
      $('#addDataForm').submit();
    }
  })
})
