$(function() {

    // 選択したデータ表示
    $(document).on('click', '.choice', function() {
        let id = $(this).closest('tr').children("td")[0].innerText;
        let name = $(this).closest('tr').children("td")[1].innerText;
        let category_name = $(this).closest('tr').children("td")[2].innerText;
        let select = $('.' + id).html();

        $('.addDataForm').append('\
            <div class="add_data" style="display: flex;">\
                <div class="input" style="display: flex;">\
                    <p>・</p>\
                    <input type="hidden" name="inventory_id[]" value="' + id + '"/>\
                    <p>' + name + '</p>\
                    <p>' + category_name + '</p>\
                    <label>味：</label>' + select + '\
                    <div class="new_taste">\
                        <input class="taste_input" type="text" name="new_taste_name[]" />\
                    </div>\
                    <label>賞味期限:</label><input type="date" name="expired_at[]" />\
                    <label>納品個数:</label><input type="number" name="stock[]" />\
                </div>\
                <div>\
                    <input class="cancel" type="button" value="×" />\
                </div>\
            </div>\
        ');
    });

    // 景品選択されていない時に味追加を押せないようにしたい。選択で景品ごとの箱を作る。箱がなければ味追加できないようにする。
    // 味追加
    $(document).on('click', '.add_taste', function() {
        let id = $(this).closest('tr').children("td")[0].innerText;
        let select = $('.' + id).html();

        $('.addDataForm').append('\
            <div class="add_data" style="display: flex;">\
                <div class="input" style="display: flex;">\
                    <p>・</p>\
                    <input type="hidden" name="inventory_id[]" value="' + id + '"/>\
                    <p></p>\
                    <p></p>\
                    <label>味：</label>' + select + '\
                    <div class="new_taste">\
                        <input class="taste_input" type="text" name="new_taste_name[]" />\
                    </div>\
                    <label>賞味期限:</label><input type="date" name="expired_at[]" />\
                    <input type="hidden" name="stock[]" value="0" />\
                </div>\
                <div>\
                    <input class="cancel" type="button" value="×" />\
                </div>\
            </div>\
        ')
    })

    // 選択したデータ削除
    $(document).on('click', '.cancel', function() {
        $(this).closest('.add_data').remove();
    });

    // select boxで’新しい味’が選択されている時text boxを表示
    $(document).on('change', '.select', function() {
        let option = $(this).val();
        if (option == 'new') {
            $(this).nextAll('.new_taste:first').css('display', 'block');
        } else {
            $(this).nextAll('.new_taste:first').css('display', 'none');
        }
    });

    // フォーム送信ボタン
    $('.add').on('click', function() {
        $('.addDataForm').submit();
    });
})
