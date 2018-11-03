$(function () {
    new Swiper('.index-swiper__container', {
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.index-swiper__pagination',
            clickable: true,
        },
        observer: true,//修改swiper自己或子元素时，自动初始化swiper
        observeParents: true//修改swiper的父元素时，自动初始化swiper
    })
    
    var appendTestData = Common.appendTestData,
		// 记录一个最新
		maxDataSize = 100, // 最大列表数量, 超过将不会触发加载更多
		listDom = document.querySelector('#listdata'),
		requestDelayTime = 600; // 请求延迟时间

    page = 1;
    last_id = 0;

    function renderList(data)
    {
        var template = '';

        for (let i in data) {

            if (data[i].covers_url.length >= 3) {
                template += '<div class="index-list__info2">'
                template += '<a href="/article?articleId=' + data[i].id + '&positionId=' + POSITION_ID + '"><h4 class="index-list__info2_title">' + data[i].title + '</h4></a>'
                template += '<a href="/article?articleId=' + data[i].id + '&positionId=' + POSITION_ID + '"><p class="index-list__info2_content">' + data[i].brief + '</p></a>'
                template += '<ul class="index-list__info2_imgwrap">'

                for (let ci = 0; ci < 3; ci ++) {
                    template += '<li class="index-list__info2_imgwrap-item">'
                    template += '<a href="/article?articleId=' + data[i].id + '&positionId=' + POSITION_ID + '">'
                    template += '<img class="index-list__head-img" src="' + data[i].covers_url[ci] + '" alt="">'
                    template += '</a>'
                    template += '</li>'
                }

                template += '</ul>'
                template += '<dl class="index-list__reports">'
                template += '<dt class="index-list__reports-name">'+ data[i].source +'</dt>'
                template += '<dt class="index-list__reports-time">'+ data[i].published_at.substr(0, 10) +'</dt>'
                template += '</dl>'
                template += '</div>'

            } else {
                template += '<ul class="index-list__wrap">'
                template += '<li class="index-list__info"' + (data[i].covers_url.length == 0 ? ' style="width:100%;"' : '') + '>'
                template += '<a href="/article?articleId=' + data[i].id + '&positionId=' + POSITION_ID + '">'
                template += '<span class="index-list__title ellipsis">'+ data[i].title +'</span>'
                template += '<span class="index-list__content ellipsis2">'+ data[i].brief +'</span>'
                template += '<dl class="index-list__reports">'
                template += '<dt class="index-list__reports-name">'+ data[i].source +'</dt>'
                template += '<dt class="index-list__reports-time">'+ data[i].published_at.substr(0, 10) +'</dt>'
                template += '</dl>'
                template += '</a>'
                template += '</li>'

                if (data[i].covers_url.length > 0) {
                    template += '<li class="index-list__head">'
                    for (let ci in data[i].covers_url) {
                        if (ci == 1) {
                            break;
                        }
                        template += '<a href="/article?articleId=' + data[i].id + '&positionId=' + POSITION_ID + '">'
                        template += '<img class="index-list__head-img" src="'+ data[i].covers_url[ci] +'" alt="">'
                        template += '</a>'
                    }
                    template += '</li>'
                }

                template += '</ul>'
            }
        }

        return template;
    }

    var miniRefresh = new MiniRefresh({
        container: '#minirefresh',
        // 下拉刷新
		down: {
			callback: function() {
                // ajax 请求
                function loadData(handleData) {
                    $.ajax({
                        url:"/api/article_pages",
                        type:"get",
                        data:{
                            "page":page,
                            "type":TYPE,
                            "last_id":last_id,
                            "position_id": POSITION_ID
                        },
                        success:function(result) {
                            if (result.last_id > 0) {
                                last_id = result.last_id
                            }
                            // last_id = result.last_id

                            res = handleData(result.ResultData.data);
                            if (res == true) {
                                page ++
                            }
                        }
                    });
                }

                loadData(function (data) {
                    var template = renderList(data);

                    setTimeout(function() {
                        // 每次下拉刷新后，上拉的状态会被自动重置
                        appendTestData(listDom, template, true);
                        miniRefresh.endDownLoading(true);

                        // 提示更新几条信息
                        if (data.length > 0) {
                            $('.update-number').text('为您更新了'+data.length+'篇文章').slideDown()
                        } else {
                            $('.update-number').text('没有更新的文章，请稍后再试').slideDown()
                        }
                        setTimeout(function () {
                            $('.update-number').slideUp();
                        }, 2000)

                    }, requestDelayTime);

                    return true;
                });

			}
        },
        // 上拉加载
		up: {
			isAuto: true,
			callback: function() {
                // ajax 请求
                var keyword = YDUI.util.getQueryString('keyword');
                data = [];
                function loadData(handleData) {
                    $.ajax({
                        url:"/api/article_pages",
                        type:"get",
                        data:{
                            "page": page,
                            "type": TYPE,
                            "position_id": POSITION_ID,
                            "title": keyword
                        },
                        success:function(result) {

                            if (result.last_id > 0) {
                                last_id = result.last_id
                            }
                            var more = true;
                            if (page >= result.ResultData.last_page) {
                                more = false;
                            }
                            res = handleData(result.ResultData.data, more);
                            if (res == true) {
                                page++
                            }
                        }
                    });
                }

                loadData(function (data, more) {
                    var template = renderList(data);

                    setTimeout(function() {
                        appendTestData(listDom, template);
                        miniRefresh.endUpLoading((more == false || listDom.children.length >= maxDataSize) ? true : false);

                        // 结束上拉加载
                        // 参数为true代表没有更多数据，否则接下来可以继续加载
                        // miniRefresh.endUpLoading(true);
                    }, requestDelayTime);

                    return true;
                });
			}
		}
	});
})