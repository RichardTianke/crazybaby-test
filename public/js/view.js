var articleId = getUrlParam('id');
if (!articleId || articleId == 0 || isNaN(articleId)) {
    alert('无效页面');
    window.location.href = './index.html';
}

$.ajax({
    type: 'GET',
    url: './api/article/' + articleId,
    dataType: 'json',
    success: function (data) {
        if (isEmptyObject(data)) {
            alert('文章不存在');
            window.location.href = './index.html';
        }
        $('.article-title').html(data.title);
        $('.article-content').html(data.content);
        $('.article-author').html(data.author);
        $('.article-time').html(data.created_at);
        $('.article-comment-number').html(data.comment);
    }
});
function loadComment() {
    $.ajax({
        type: 'GET',
        url: './api/comment/',
        data: {article_id: articleId},
        dataType: 'json',
        success: function (data) {
            $('.article-comment').html('');
            for (var i = 0; i < data.length; i++) {
                var html = '<blockquote>' +
                        '<p class="article-comment-content">' + data[i].content + '</p>' +
                        '<small><span class="article-comment-author">' + data[i].author + '</span> By <span class="article-comment-time">' + data[i].created_at + '</span></small>' +
                        '</blockquote>';
                $('.article-comment').append(html);
            }
        }
    });
}
loadComment();

$.ajax({
    type: 'GET',
    url: './api/comment/create',
    success: function (data) {
        $('.comment-form-section').append(data);
    }
});

$('.comment-create-btn').on('click', function () {
    var token = $(".comment-section input[name=_token]").val();
    var author = $('.comment-author').val();
    var content = $('.comment-content').val();
    if (token == '') {
        alert('非法请求，请您重试');
        return false;
    }
    if (author == '') {
        $('.comment-author-section').addClass('error');
        $('.comment-author-error').text('请您填写您的昵称');
        return false;
    } else {
        $('.comment-author-section').removeClass('error');
        $('.comment-author-error').text('');
    }

    if (content == '') {
        $('.comment-content-section').addClass('error');
        $('.comment-content-error').text('请您填写内容');
        return false;
    } else {
        $('.comment-content-section').removeClass('error');
        $('.comment-content-error').text('');
    }

    $.ajax({
        type: 'POST',
        url: './api/comment',
        data: {
            article_id: articleId,
            author: author,
            content: content
        },
        headers: {
            'X-CSRF-TOKEN': token
        },
        dataType: 'json',
        success: function (data) {
            $('#myModal').modal('hide');
            loadComment();
            var commentNumber = $('.article-comment-number').text();
            commentNumber++;
            $('.article-comment-number').text(commentNumber);
            $('.comment-author').val('');
            $('.comment-content').val('');
        },
        error: function (event, XMLHttpRequest, textStatus, errorThrown) {
            var responseText = eval("(" + event.responseText + ")");
            $.each(responseText, function (key, value) {
                for (var i = 0; i < value.length; i++) {
                    console.log(value[i]);
                    $('.comment-form-section').prepend('<div class="control-group error"><span class="help-inline">*' + value[i] + '</span></div>');
                }
            });
        },
    });
});