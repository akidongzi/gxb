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
                    str += '<a href="/articles/'+data[i].id+'?position_id='+POSITION_ID+'" target="_blank"><h4 class="container_news-list_title ellipsis">'+data[i].title+'</h4></a>',
                    str += '<ul class="container_info clearfix">'
                    if (data[i].covers_num == 0) {
                        str += '<li class="container_content pull-left" style="width:100%;">'
                            str += '<span class="container_content-text">'+data[i].brief+'</span>'
                            str += '<span class="container_content-time">'+data[i].source+' '+data[i].published_at.substr(0, 10)+'</span>'
                        str += '</li>'
                    } else if ($.inArray(data[i].covers_num, [2,3])) {
                        for (j = 0; j < data[i].covers_num; j++) {
                            str += '<li class="container_img pull-left">'
                                str += '<a href="/articles/'+data[i].id+'?position_id='+POSITION_ID+'" target="_blank">'
                                str += '<img test="1" src="'+data[i].covers_url[j]+'?x-oss-process=image/resize,m_fill,w_181,h_120'+'" alt="123" onerror="javascript:this.src=\'https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png\'">'
                                str += '</a>'
                            str += '</li>'
                        }
                        console.log(data[i].covers_num);
                        if (data[i].covers_num == 4) {
                            str += '<li class="container_content pull-left" style="display:none;">'
                        } else {
                            str += '<li class="container_content pull-left">'
                        }
                            str += '<span class="container_content-text">'+data[i].brief+'</span>'
                            str += '<span class="container_content-time">'+data[i].source+' '+data[i].published_at.substr(0, 10)+'</span>'
                        str += '</li>'
                    }  else if ($.inArray(data[i].covers_num, [4])) {
                        for (j = 0; j < data[i].covers_num; j++) {
                            str += '<li class="container_img pull-left">'
                                str += '<a href="/articles/'+data[i].id+'?position_id='+POSITION_ID+'" target="_blank">'
                                str += '<img test="1" src="'+data[i].covers_url[j]+'?x-oss-process=image/resize,m_fill,w_181,h_120'+'" alt="123" onerror="javascript:this.src=\'https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png\'">'
                                str += '</a>'
                            str += '</li>'
                        }
                    } else {
                        str += '<li class="container_img pull-left">'
                            str += '<a href="/articles/'+data[i].id+'?position_id='+POSITION_ID+'" target="_blank">'
                            str += '<img test="1" src="'+data[i].banner_url+'" alt="123" onerror="javascript:this.src=\'https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png\'">'
                            str += '</a>'
                        str += '</li>'
                        str += '<li class="container_content pull-left">'
                            str += '<span class="container_content-text">'+data[i].brief+'</span>'
                            str += '<span class="container_content-time">'+data[i].source+' '+data[i].published_at.substr(0, 10)+'</span>'
                        str += '</li>'
                    }
                    str += '</ul>'
                str += '</div>'
            }
            var appendH = $(document).scrollTop()
            $('.container_left').append(str);
            $(document).scrollTop(appendH)
            return true;
        });
        
    });
})
