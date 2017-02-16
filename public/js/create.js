
$.ajax({
    type: 'GET',
    url: './api/article/create',
    success: function (data) {
        $('.article-form-section').append(data);
    }
});

$(document).on('click','.article-create-btn',function(){
    var token = $(".article-form-section input[name=_token]").val();
    var title = $('.article-title').val();
    var author = $('.article-author').val();
    var description = $('.article-description').val();
    var content = $('.article-content').val();
    if (token == '') {
        alert('非法请求，请您重试');
        return false;
    }
    if (title == '') {
        $('.article-title-section').addClass('error');
        $('.article-title-error').text('请您填写文章标题');
        return false;
    } else {
        $('.article-title-section').removeClass('error');
        $('.article-title-error').text('');
    }
    if (author == '') {
        $('.article-author-section').addClass('error');
        $('.article-author-error').text('请您填写文章作者');
        return false;
    } else {
        $('.article-author-section').removeClass('error');
        $('.article-author-error').text('');
    }
    if (description == '') {
        $('.article-description-section').addClass('error');
        $('.article-description-error').text('请您填写文章简述');
        return false;
    } else {
        $('.article-description-section').removeClass('error');
        $('.article-description-error').text('');
    }
    if (content == '') {
        $('.article-content-section').addClass('error');
        $('.article-content-error').text('请您填写内容');
        return false;
    } else {
        $('.article-content-section').removeClass('error');
        $('.article-content-error').text('');
    }

    $.ajax({
        type: 'POST',
        url: './api/article',
        data: {
            title: title,
            author: author,
            description: description,
            content: content
        },
        headers: {
            'X-CSRF-TOKEN': token
        },
        dataType: 'json',
        success: function (data) {
            //alert('提交成功');
            window.location.href = './index.html';
        },
        error: function (event, XMLHttpRequest, textStatus, errorThrown) {
            var responseText = eval("(" + event.responseText + ")");
            $.each(responseText, function (key, value) {
                for (var i = 0; i < value.length; i++) {
                    $('.article-form-section').prepend('<div class="control-group error"><span class="help-inline">*' + value[i] + '</span></div>');
                }
            });
        },
    });
})