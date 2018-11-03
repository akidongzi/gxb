$(function () {
    var appendTestData = Common.appendTestData,
		// 记录一个最新
		maxDataSize = 100, // 最大列表数量, 超过将不会触发加载更多
		listDom = document.querySelector('#listdata'),
		requestDelayTime = 600; // 请求延迟时间
    page = 1;
    last_id = 0;

    var page_data = [];

    function render_list(data)
    {
        var template = ''
        for (let i in data) {
            page_data[data[i].id] = data[i];

            template += '<div class="images__item">'
            template += '<h4 class="images__item-title">'+ data[i].title +'</h4>'
            template += '<ul class="index-list__info2_imgwrap matginTB10">'

            for (let imgidx = 0; imgidx < 3; imgidx ++) {
                template += '<li class="index-list__info2_imgwrap-item" data-aid="' + data[i].id + '" data-img-id="' + data[i].atlas[imgidx].id + '">'
                template += '<img class="index-list__head-img" src="'+ data[i].atlas[imgidx].banner_url +'" alt="">'
                template += '</li>'
            }

            template += '</ul>'
            template += '<dl class="index-list__reports">'
            template += '<dt class="index-list__reports-name">'+ data[i].author +'</dt>'
            template += '<dt class="index-list__reports-time">'+ data[i].created_at +'</dt>'
            template += '</dl>'
            template += '</div>'
        }

        return template;
    }

	var miniRefresh = new MiniRefresh({
        container: '#minirefresh',
        // 下拉刷新
		down: {
			callback: function() {
                // ajax 请求
                // ajax 请求
                page = 1;
                data = [];
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
                                page++  
                            }
                        }
                    });
                }
                loadData(function (data) {
                    var template = render_list(data);

                    setTimeout(function() {

                        // 每次下拉刷新后，上拉的状态会被自动重置
                        appendTestData(listDom, template, false);
                        miniRefresh.endDownLoading(true);
                        
                        // 提示更新几条信息
                        // $('.update-number').text('为您更新了5篇文章').slideDown()
                        if (data.length > 0) {
                            $('.update-number').text('为您更新了'+data.length+'篇文章').slideDown()
                        } else {
                            $('.update-number').text('没有更新的文章，请稍后再试').slideDown()
                        }
                        
                        // setTimeout(function () {
                        //     // $('.update-number').slideUp();
                        // }, 2000)
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
                            "page":page,
                            "type":TYPE,
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
                    var template = render_list(data)

                    setTimeout(function() {
                        appendTestData(listDom, template, false);

                        if (more == false || listDom.children.length >= maxDataSize) {
                            miniRefresh.endUpLoading(true);
                        } else {
                            miniRefresh.endUpLoading(false);
                        }
                        // console.log(data);
                        // miniRefresh.endUpLoading(listDom.children.length >= maxDataSize ? true : false);
                        
                        // 结束上拉加载
                        // 参数为true代表没有更多数据，否则接下来可以继续加载
                        // miniRefresh.endUpLoading(true);
                    }, requestDelayTime);
                    return true;
                });

                
			}
		}
    });
    
    // 图片查看器
    var swiper = new Swiper('.imglook__swiper', {
        pagination: {
            el: '.imglook__pagination',
            type: 'fraction'
        },
        initialSlide: 0, // 设置第几张开始
        observer: true,//修改swiper自己或子元素时，自动初始化swiper
        observeParents: true//修改swiper的父元素时，自动初始化swiper
    });

    $(".images-list").on("click",".index-list__info2_imgwrap-item",function () {
        //图集id
        var aid = $(this).data('aid'),
            imgid = $(this).data('img-id');

        var load_album = page_data[aid];
        if (! load_album) {
            console.log('没有找到相应的图集（' + aid + '）！');
            return;
        }

        var data = load_album.atlas;
        var template = ''

        for (let i in data) {
            template += '<div class="imglook__slide swiper-slide">'
                template += '<img src="'+ data[i].banner_url +'" alt="">'
                template += '<div class="imglook__slide_intro">'
                    template += '<h4 class="imglook__slide_title">'+ data[i].brief +'</h4>'
                    template += '<p class="imglook__slide_content">'+ data[i].brief +'</p>'
                template += '</div>'
            template += '</div>'
        }

        console.log(template);

        $('.imglook__wrapper').append(template)
        $('.imglook').fadeIn();
    })
    // 点击关闭查看器
    $('.imglook__wrapper').click(function (e) { 
        $('.imglook').fadeOut();
    });
})