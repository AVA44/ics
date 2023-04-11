$(function() {
  $('.destroy_choice').on('click', function() {
      let id = $(this).closest('td').prevAll('.id').val();
      let name = $(this).closest('td').prevAll('.name').text();
      let category = $(this).closest('td').prevAll('.category').text();

      $('#destroy_field').append('\
                                    <div class="desFields desField' + id + '">\
                                        <input class="destroy_id" type="hidden" value="' + id + '" />\
                                        <p class="destroy_inventory">' + name + ' ' +  category + '</p>\
                                        <input class="destroy_cancel" type="button" value="×" />\
                                    </div>\
                                    <hr/>\
                                ');
      $('#destroy_form').append('<input type="hidden" name="destroy[]" value="' + id + '"/>');

      // 同じ景品を選択できないようにdisabled:trueを設定
      $(this).prop('disabled', true);
  });

  // 選択をキャンセル
  $(document).on('click', '.destroy_cancel', function() {
      let cancelId = $(this).prevAll('.destroy_id').val();

      // 表示されている選択した景品の情報を削除
      $('.desField' + cancelId).next().remove();
      $('.desField' + cancelId).remove();

      // 選択キャンセルした時に景品を選択し直せるようにdisabled:falseを設定
      $('.desBtn' + cancelId).prop('disabled', false);
  })

  $('#destroy_submit').on('click', function() {
      $('#destroy_form').submit();
  })
})
