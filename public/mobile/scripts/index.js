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

    var perPage = 15;
    var page = 1;
    var luts = 0;

    function renderList(data)
    {
        var template = '';
        console.log('data:', data);

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

    var pageData = [];
    var miniRefresh = new MiniRefresh({
        container: '#minirefresh',
        // 下拉刷新
		down: {
			callback: function() {
                // ajax 请求
                $.ajax({
                    url:"/api/article_pages",
                    type:"get",
                    data:{
                        "page": 1,
                        "type": TYPE,
                        "luts": luts,
                        "position_id": POSITION_ID
                    },
                    success:function(result) {
                        var numUpdated = 0;
                        if (result.updated_at > 0 && result.updated_at > luts) {
                            luts = result.updated_at;
                            var data = result.ResultData.data;

                            if (luts == 0) {
                                pageData = data;
                            } else {
                                for (var di = data.length - 1; di >=0; di --) {
                                    pageData.unshift(data[di]);
                                }
                            }
                            numUpdated = data.length;
                            data = null;
                            if (pageData.length > perPage) {
                                pageData = pageData.slice(0, perPage - 1);
                            }

                            page = 1;
                        }
                        var template = renderList(pageData);

                        setTimeout(function() {
                            // 每次下拉刷新后，上拉的状态会被自动重置
                            console.log("DDD:", listDom, template);
                            appendTestData(listDom, template, true);
                            miniRefresh.endDownLoading(true);

                            // 提示更新几条信息
                            if (numUpdated > 0) {
                                $('.update-number').text('为您更新了' + numUpdated + '篇文章').slideDown()
                            } else {
                                $('.update-number').text('没有更新的文章，请稍后再试').slideDown()
                            }
                            setTimeout(function () {
                                $('.update-number').slideUp();
                            }, 2000)

                        }, requestDelayTime);
                    }
                });
			}
        },
        // 上拉加载
		up: {
			isAuto: true,
			callback: function() {
                // ajax 请求
                var keyword = YDUI.util.getQueryString('keyword');
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
                            var resData = result.ResultData.data;

                            if (page == 1) {
                                luts = result.updated_at;
                                pageData = resData;
                            } else {
                                pageData.push.apply(pageData, resData);
                            }

                            var more = true;
                            if (page >= result.ResultData.last_page) {
                                more = false;
                            }
                            res = handleData(resData, more);
                            if (res == true) {
                                page ++;
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