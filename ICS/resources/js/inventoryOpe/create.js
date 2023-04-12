$(function() {

  // 新しいカテゴリ名か既存のカテゴリ名か
  $('#category_name_input').on('change', function() {

    // 新しい時入力用のBOXを表示
    if ($(this).val() == 'new_category') {
      $('#category_input_box').css('display', 'block');
      $('#category_input_box').addClass('empty_alert');

    // 既存の時非表示
    } else {
      $('#category_input_box').css('display', 'none');
      $('#category_input_box').removeClass('empty_alert');
    }

  })

  // 画像プレビュー
  $('#image_url').on('change', function() {

    // 画像ファイルの選択をキャンセルした時非表示
    if ($(this).val() == '') {
      $('#preview').attr('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');

    // 画像ファイルが選択された時表示
    } else {
      let obj = $(this).prop('files')[0];
      let fileReader = new FileReader();
      fileReader.onload = (function() {
        document.getElementById('preview').src = fileReader.result;
      });
      fileReader.readAsDataURL(obj);
    };
  })

  // 入力必須な項目の入力確認①
  $('.required').on('change', function() {
    let createInput = $(this).val();

    // 入力されていなかった時empty_alertクラスを追加
    if (createInput == '') {
      $(this).closest('.create_form_content').addClass('empty_alert');

    // 入力されていたら削除
    } else {
      $(this).closest('.create_form_content').removeClass('empty_alert');
    }
  })

  // フォーム送信 & 入力必須欄の入力確認②
  $('#create_submit').on('click', function() {
    let emptyAlert = $('.empty_alert').length;

    // 入力必須欄が全て入力されていたらフォーム送信
    if (emptyAlert == '0') {
      $('#create_form').submit();

    // されていなかったらalert表示
    } else {
      alert('入力されていない項目があります！');
    }
  })
})
