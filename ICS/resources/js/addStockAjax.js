$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

});

// limited_count作成用の当日のタイムスタンプ
let now = new Date();
let nowTime = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();
now = new Date(nowTime).setUTCHours(24);;

$(function() {
    $('.orderBtn').on('click', function() {

        // テーブルリセット
        $('.tableData').each(function(index, tableData) {
            $(tableData).remove();
        });

        // ajax データ取得
        $.ajax({
            url: '/ajax',
            type: 'POST',
            data: {
                'name_search' : $('.name_search').val(),
                'cate_search' : $('.cate_search').val()
                },　
            dataType: 'json',
            cache: true,
        })

        // ajax通信成功
        .done(function(data) {
            const obj = JSON.parse(JSON.stringify(data));

            obj.forEach(o => {
                let tableDataLayout = function() {

                      return '\
                      <tr class="tableData">\
                          <td style="display: none">' + o.id + '</td>\
                          <td>' + o.name + '</a></td>\
                          <td>' + o.category_name + '</td>\
                          <td><input class="choice" type="button" value="選択" /></td>\
                      </tr>';
                }

                $('.inventories_table').append(tableDataLayout());
            });
        })

        // ajax通信失敗
        .fail(function() {
            console.log('例外エラー：再度同じ操作をしてください');
        });
    });
});
