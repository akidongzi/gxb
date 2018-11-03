$(function () {
    var appendTestData = Common.appendTestData,
		// 记录一个最新
		maxDataSize = 100, // 最大列表数量, 超过将不会触发加载更多
		listDom = document.querySelector('#listdata'),
		requestDelayTime = 600; // 请求延迟时间
    page = 1;
	var miniRefresh = new MiniRefresh({
        container: '#minirefresh',
        // 下拉刷新
		down: {
			callback: function() {
                // ajax 请求
                page = 1;
                data = [];
                function loadData(handleData) {
                    $.ajax({
                        url:"/api/list_videos",
                        type:"get",
                        data:{
                            "page":page
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
                    var template = ''
                    for (let i in data) {

                       template += '<ul class="video__wrap">'
                        template += '<li class="video__res">'
                            template += '<video class="video__wrap_media" poster="'+ data[i].poster_url +'" src="'+ data[i].file_url +'" controls="">'
                                template += '<source src="'+ data[i].poster_url +'" type="video/mp4">'
                            template += '</video>'
                        template += '</li>'
                        template += '<li class="video__title">'+ data[i].title +'</li>'
                        template += '<li class="video__report">'
                            template += '<dl class="index-list__reports">'
                                template += '<dt class="index-list__reports-name">'+ data[i].source +'</dt>'
                                template += '<dt class="index-list__reports-time">'+ data[i].created_at.substr(0, 10) +'</dt>'
                            template += '</dl>'
                        template += '</li>'
                        template += '</ul>'

                    }
                    setTimeout(function() {
                        // 每次下拉刷新后，上拉的状态会被自动重置
                        appendTestData(listDom, template, true);
                        miniRefresh.endDownLoading(true);
                        
                        // 提示更新几条信息
                        // $('.update-number').text('为您更新了5篇文章').slideDown()
                        // setTimeout(function () {
                        //     $('.update-number').slideUp();
                        // }, 2000)
                    }, requestDelayTime);
                    return true;
                });

               
			} // callback
        },
        // 上拉加载
		up: {
			isAuto: true,
              callback: function() {
                // ajax 请求
                data = [];
                function loadData(handleData) {
                    $.ajax({
                        url:"/api/list_videos",
                        type:"get",
                        data:{
                            "page":page
                        },
                        success:function(result) {
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
                    var template = ''
                    for (let i in data) {

                       template += '<ul class="video__wrap">'
                        template += '<li class="video__res">'
                            template += '<video class="video__wrap_media" poster="'+ data[i].poster_url +'" src="'+ data[i].file_url +'" controls="">'
                                template += '<source src="'+ data[i].poster_url +'" type="video/mp4">'
                            template += '</video>'
                        template += '</li>'
                        template += '<li class="video__title">'+ data[i].title +'</li>'
                        template += '<li class="video__report">'
                            template += '<dl class="index-list__reports">'
                                template += '<dt class="index-list__reports-name">'+ data[i].source +'</dt>'
                                template += '<dt class="index-list__reports-time">'+ data[i].created_at.substr(0, 10) +'</dt>'
                            template += '</dl>'
                        template += '</li>'
                        template += '</ul>'

                    }
                    setTimeout(function() {
                        appendTestData(listDom, template);

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
			}//callback
		}
	});
})