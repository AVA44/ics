$(function() {

    // 選択肢を選択したとき右側に情報と入力フォームを表示
    $(document).on("click", ".choice", function() {

        // 必要な値取得
        // form_field_material取得時使用(inventoryId, name)
        let inventoryId = $(this).closest("tr").children(".inventory_id")[0].value;
        let name = $(this).closest("tr").children("td")[0].innerText;

        // form_field_material取得
        let choiceTable = $('.' + inventoryId).html();

        // 表示
        $('#useDataForm').append('\
            <div class="use_data">\
                <h4 class="use_data_top">' + name + '</h4>\
                ' + choiceTable + '\
                <div class="use_data_cancel_box">\
                    <input class="cancel ' + inventoryId + ' use_data_cancel" type="button" value="×" />\
                </div>\
            </div>\
        ');

        // 同じ景品を選択できないようにdisabledを設定
        $(this).prop('disabled', true);

    })

    // use_stock入力時最小値、最大値をそれぞれ超えたときに最小値最大値に置き換える
    $(document).on("change", ".use_stock", function() {

        // 最大値（在庫数）,最小値（１）,入力された値取得
        let max = $(this).attr("max");
        let min = $(this).attr("min");
        let useStock = $(this).val();

        // 在庫の使用数が入力されていない時０
        if (typeof(useStock) != "undefined") {
            let useStock = 0;
        }

        // 入力されて使用数が最小値より小さい時最小値（１）に
        if (parseInt(useStock) < parseInt(min)) {
            $(this).val(min);

        // 最大値より大きい時最大値に
        } else if (parseInt(useStock) > parseInt(max)) {
            $(this).val(max);
        };
    });

    // 選択キャンセル
    $(document).on('click', '.cancel', function() {
        $(this).closest('.use_data').remove();

        // 選択ボタンを再度押せるように
        let id = $(this).attr('class').split(' ');
        $('.choice' + id[1]).prop('disabled', false);
    });

    // 登録ボタンを押したらフォーム送信
    $(document).on("click", ".use", function() {
        $('#useDataForm').submit();
    })
})
