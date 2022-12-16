$(function() {
    $('.orderBtn').on('click', function() {
        $.ajax({
            url: ('app/Http/contact.php'),
            type: 'GET',
            data: {
                'search': $('search').value(),
                'sort': $('sort').value(); },　
            dataType: 'json',
            cache: true,
            success: function(data) {
                // 引数でデータを受け取り
                console.log('テーブルを作る処理');
            },
                // ajax通信失敗
            error: function() {
                console.log('例外エラー：再度同じ操作をしてください');
            }
        })
    })
})
