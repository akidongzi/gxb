$(function () {

    page = 2;
    data = [];
    // 加载更多
    $('.container_loading-more').click(function (e) {

        function loadData(handleData) {
            $.ajax({
                url:"/api/article_pages",
                type:"get",
                data:{
                    "page":page,
                    "type":0,
                    "position_id": POSITION_ID
                },
                success:function(result) {
                    res = handleData(result.ResultData.data);
                    if (res == true) {
                        page++
                    }
                }
            });
        }

        loadData(function (data) {

            if (data.length == 0) {
                $('.container_loading-more').off('click').text("已加载全部内容");
                return false;
            }
            var str = ''
            for (let i in data) {
                if (data[i].type == 2) {
                    if (data[i].covers_num > 4) {
                        data[i].covers_num = 4;
                    }
                } else {
                    if (data[i].covers_num > 1) {
                        data[i].covers_num = 1;
                    }
                }

                str += '<div class="container_news-list">'
                    +   '<a href="/articles/' + data[i].id + '?position_id=' + POSITION_ID + '" target="_blank">'
                    +       '<h4 class="container_news-list_title ellipsis">' + data[i].title + '</h4>'
                    +   '</a>'
                    +   '<ul class="container_news-list_meta-info">'
                    +       '<li>作者: <span>' + data[i].meta_info + '</span></li>'
                    +       '<li>发布时间: <span>' + data[i].published_at.substr(0, 10) + '</span></li>'
                    +   '</ul>'
                    +   '<ul class="container_info clearfix">'
                    +       '<li class="container_content pull-left" style="width:100%;">'
                    +           '<span class="container_content-text">' + data[i].brief + '</span>'
                    +       '</li>'
                    +   '</ul>'
                    +  '</div>';


            }
            var appendH = $(document).scrollTop()
            $(str).insertBefore($('.container_left .container_loading-more'));
            $(document).scrollTop(appendH)
            return true;
        });

    });
})
