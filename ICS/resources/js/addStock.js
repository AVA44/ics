$(function() {

    // 選択した景品情報表示
    $(document).on('click', '.choice_btn', function() {

        // 選択した景品の情報を取得
        let id = $(this).closest('tr').children("td")[0].innerText;
        let name = $(this).closest('tr').children("td")[1].innerText;
        let category_name = $(this).closest('tr').children("td")[2].innerText;
        let select = $('.taste' + id).html();
        if (typeof select == 'undefined') {
           select = '<select class="select" name="taste_name[]"><option value="new">新しい味</option></select>';
        };

        // 景品のフィールドを作って入力欄作成
        $('.addDataForm').append('\
            <div class="field' + id + ' fields">\
                <p>' + name + '</p>\
                <p>' + category_name + '</p>\
                <label>納品個数:</label><input class="empty_alert addInput" type="number" name="stock[]" min=0 />\
                <input class="inventory_cancel ' + id + '" type="button" value="×" />\
                <div class="add_data' + id + '" style="display: flex;">\
                    <div class="input" style="display: flex;">\
                        <input type="hidden" name="inventory_id[]" value="' + id + '"/>\
                        <label>味：</label>' + select + '\
                        <div class="new_taste">\
                            <input class="empty_alert addInput" type="text" name="new_taste_name[]" />\
                        </div>\
                        <label>賞味期限:</label><input class="empty_alert addInput" type="date" name="expired_at[]" />\
                    </div>\
                    <div>\
                        <input class="cancel ' + id + '" type="button" value="×" />\
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
        let select = $('.taste' + id).html();
        if (typeof select == 'undefined') {
           select = '<select class="select" name="taste_name[]"><option value="new">新しい味</option></select>';
        };

        $('.field' + id).append('\
            <div class="add_data' + id + '" style="display: flex;">\
                <div class="input" style="display: flex;">\
                    <input type="hidden" name="inventory_id[]" value="' + id + '"/>\
                    <p></p>\
                    <p></p>\
                    <label>味：</label>' + select + '\
                    <div class="new_taste">\
                        <input class="empty_alert addInput" type="text" name="new_taste_name[]" />\
                    </div>\
                    <label>賞味期限:</label><input class="empty_alert addInput" type="date" name="expired_at[]" />\
                    <input type="hidden" name="stock[]" value="0" />\
                </div>\
                <div>\
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
        if (option == 'new') {
            $(this).nextAll('.new_taste:first').css('display', 'block');
            $(this).nextAll('.new_taste:first').find('.addInput').addClass('empty_alert');
        } else {
            $(this).nextAll('.new_taste:first').css('display', 'none');
            $(this).nextAll('.new_taste:first').find('.addInput').removeClass('empty_alert');
        }
    });

    // inputが全て入力
      // フォーム送信ボタンされているかの確認
    $(document).on('change', '.addInput', function() {
        let inputVal = $(this).val();

        if (inputVal == '') {
            $(this).addClass('empty_alert');
        } else if (inputVal != '') {
            $(this).removeClass('empty_alert');
        }
    });

    // フォーム送信ボタン
    $('.add').on('click', function() {
        if (typeof $('.empty_alert').val() == 'undefined') {
            $('.addDataForm').submit();
        } else {
            alert('入力されてない項目があります！');
        }
    })
})
