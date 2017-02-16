$.ajax({
    type: 'GET',
    url: './api/article',
    dataType: 'json',
    success: function (data) {
        for (var i = 0; i < data.length; i++) {
            var html = '<div class="row-fluid">' +
                    '<div class="span12">' +
                    '<h2>' + data[i].title + '</h2><span class="article-delete"></span>' +
                    '<p>' + data[i].description + ' </p>' +
                    '<p><a class="btn" href="/view.html?id=' + data[i].id + '">查看详情 &raquo;</a> <span>评论数(' + data[i].comment + ')</span></p>' +
                    '</div><!--/span--></div><!--/row--><hr>';
            $('.article-list').append(html);
        }
    }
});

$('.search-btn').on('click', function () {
    var keyword = $('.search-keyword').val();
    $.ajax({
        type: 'GET',
        url: './api/article',
        data: {
            keyword: keyword,
        },
        dataType: 'json',
        success: function (data) {
            $('.article-list').html('');
            for (var i = 0; i < data.length; i++) {
                var html = '<div class="row-fluid">' +
                        '<div class="span12">' +
                        '<h2>' + data[i].title + '</h2><span class="article-delete"></span>' +
                        '<p>' + data[i].description + ' </p>' +
                        '<p><a class="btn" href="/view.html?id=' + data[i].id + '">查看详情 &raquo;</a> <span>评论数(' + data[i].comment + ')</span></p>' +
                        '</div><!--/span--></div><!--/row--><hr>';
                $('.article-list').append(html);
            }
        },
        error: function (event, XMLHttpRequest, textStatus, errorThrown) {
            alert('搜索失败，请您检查您输入的关键字是否符合规范');
        },
    });
})