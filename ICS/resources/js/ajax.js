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
            success: function(data) {
                const obj = JSON.parse(JSON.stringify(data));
                obj.forEach(o => {
                    let limit_count = ((new Date(o.limited_at)) - now) / 86400000;

                    let tableDataLayout = function() {
                        return '\
                        <tr class="tableData">\
                            <td><a href="inventory/' + o.id + '">' + o.name + '</a></td>\
                            <td>' + o.category_name + '</td>\
                            <td>' + o.unit_price + '</td>\
                            <td>' + o.expired_at + '</td>\
                            <td>' + o.limited_at + '</td>\
                            <td>' + limit_count + '</td>\
                        </tr>';
                    }
                    $('.inventories_table').append(tableDataLayout());
                })
                console.log('ajax作動');
            },
                // ajax通信失敗
            error: function() {
                console.log('例外エラー：再度同じ操作をしてください');
            }
        })


    })
})
