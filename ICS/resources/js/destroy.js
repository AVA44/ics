$(function() {
  $('.destroy_choice').on('click', function() {
      let id = $(this).closest('td').prevAll('.id').val();
      let name = $(this).closest('td').prevAll('.name').text();
      let category = $(this).closest('td').prevAll('.category').text();

      $('.destroy_field').append('\
                                    <div class="desFields desField' + id + '">\
                                        <p class="destroy_inventory">' + id + ' ' + name + ' ' +  category + '</p>\
                                        <input class="destroy_cancel" type="button" value="×" />\
                                        <hr/>\
                                    </div>\
                                ');
      $('.destroy_form').append('<input type="hidden" name="destroy[]" value="' + id + '"/>');

      // 同じ景品を選択できないようにdisabled:trueを設定
      $(this).prop('disabled', true);
  });

  // 選択をキャンセル
  $(document).on('click', '.destroy_cancel', function() {
      let cancelId = $(this).prev('.destroy_inventory').text().split(' ')[0];

      // 表示されている選択した景品の情報を削除
      $('.desField' + cancelId).remove();

      // 選択キャンセルした時に景品を選択し直せるようにdisabled:falseを設定
      $('.desBtn' + cancelId).prop('disabled', false);
  })

  $('.destroy_submit').on('click', function() {
      $('.destroy_form').submit();
  })
})
