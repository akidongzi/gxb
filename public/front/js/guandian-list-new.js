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

                str += '<div class="gd-list-item">'
                    +       '<div class="gd-list-item__atr pull-left">'
                    +           '<div class="gd-list-item__atr-icon"></div>'
                    +           '<div class="gd-list-item__atr-name"><span>' + (data[i].metaData['作者'] ? data[i].metaData['作者'].meta_value : '无') + '</span></div>'
                    +           '<div class="gd-list-item__atr-desc">' + (data[i].metaData['作者简介'] ? data[i].metaData['作者简介'].meta_value : '暂无') + '</div>'
                    +       '</div>'
                    +       '<div class="gd-list-item__body pull-right">'
                    +           '<div class="gd-list-item__body-arrow"></div>'
                    +           '<div class="gd-list-item__title">'
                    +               '<a href="/articles/' + data[i].id + '?position_id=' + POSITION_ID + '" target="_blank">'
                    +                   '<span>' + data[i].title + '</span>'
                    +               '</a>'
                    +           '</div>'
                    +           '<div class="gd-list-item__brief">' + data[i].brief.substr(0, 138) + (data[i].brief.length > 138 ? '...' : '') + '</div>'
                    +           '<div class="gd-list-item__info">'
                    +               '<span class="gd-list-item__info-pub-time">' + data[i].published_at.substr(0, 10) + '</span>'
                    // +               '<div class="gd-list-item__info-tags pull-right">'
                    // +                   '<span class="gd-list-item__tag">城市</span>'
                    // +                   '<span class="gd-list-item__tag">国家</span>'
                    // +                   '<span class="gd-list-item__tag">大学</span>'
                    // +               '</div>'
                    +           '</div>'
                    +       '</div>'
                    +   '</div>';
            }
            var appendH = $(document).scrollTop()
            $(str).insertBefore($('.gd-list .container_loading-more'));

            $(document).scrollTop(appendH)
            return true;
        });

    });
})
