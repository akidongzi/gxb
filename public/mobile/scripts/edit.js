$(function () {
    page = 1;
    $('.find-more_wrap').click(function (e) { 
        
        data = [];
            function loadData(handleData) {
                $.ajax({
                    url:"/api/article_pages",
                    type:"get",
                    data:{
                        "page":page,
                        "type":1,
                        "position_id": POSITION_ID
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
                        if (more == false) {
                            $(".find-more_info").text("已加载全部内容");
                            $(".find-more_wrap").unbind('click');
                        }
                    }
                });
            }

            loadData(function (data, more) {

                var template = ''
                for (let i in data) {

                    if (data[i].banner_url) {
                        template += '<ul class="index-list__wrap" >'
                        template += '<li class="index-list__info">'
                            template += '<a href="/article?articleId='+data[i].id+'">'
                                template += '<span class="index-list__title ellipsis">'+ data[i].title +'</span>'
                                template += '<span class="index-list__content ellipsis2">'+ data[i].brief +'</span>'
                                template += '<dl class="index-list__reports">'
                                    template += '<dt class="index-list__reports-name">'+ data[i].author +'</dt>'
                                    template += '<dt class="index-list__reports-time">'+ data[i].created_at +'</dt>'
                                template += '</dl>'
                            template += '</a>'
                        template += '</li>'

                        template += '<li class="index-list__head">'
                        template += '<a href="/acticle?acticleId='+data[i].id+'">'
                            template += '<img class="index-list__head-img" src="'+ data[i].banner_url +'" alt="">'
                        template += '</a>'
                        template += '</li>'
                        
                        template += '</ul>'

                    } else {
                        template += '<ul class="index-list__wrap" >'
                        template += '<li class="index-list__info" style="width: 100%;">'
                            template += '<a href="/article?articleId='+data[i].id+'">'
                                template += '<span class="index-list__title ellipsis">'+ data[i].title +'</span>'
                                template += '<span class="index-list__content ellipsis2">'+ data[i].brief +'</span>'
                                template += '<dl class="index-list__reports">'
                                    template += '<dt class="index-list__reports-name">'+ data[i].author +'</dt>'
                                    template += '<dt class="index-list__reports-time">'+ data[i].created_at +'</dt>'
                                template += '</dl>'
                            template += '</a>'
                        template += '</li>'
                        
                        template += '</ul>'

                    }

                }
                var appendH = $('.edit-main').scrollTop()
                $('.edit__recommend').append(template);
                $('.edit-main').scrollTop(appendH)
                return true;
            });
        // // ajax 请求
        // var data = [
        //     {
        //         id: 1,
        //         title: '1中非合作论坛第七届部长级中非合作论坛第七届部长级',
        //         content: '1中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。',
        //         name: '新华网',
        //         time: '2018-10-05',
        //         img: 'https://www.cicic.org.cn/storage/uploads/news-img/wcm.files/upload/CMSydylgw/201809/201809290409020.jpg'
        //     },
        //     {
        //         id: 2,
        //         title: '2中非合作论坛第七届部长级中非合作论坛第七届部长级',
        //         content: '2中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。',
        //         name: '新华网',
        //         time: '2018-10-05',
        //         img: 'https://www.cicic.org.cn/storage/uploads/news-img/wcm.files/upload/CMSydylgw/201809/201809290409020.jpg'
        //     },
        //     {
        //         id: 3,
        //         title: '3中非合作论坛第七届部长级中非合作论坛第七届部长级',
        //         content: '3中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。',
        //         name: '新华网',
        //         time: '2018-10-05',
        //         img: 'https://www.cicic.org.cn/storage/uploads/news-img/wcm.files/upload/CMSydylgw/201809/201809290409020.jpg'
        //     },
        //     {
        //         id: 4,
        //         title: '4中非合作论坛第七届部长级中非合作论坛第七届部长级',
        //         content: '4中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。',
        //         name: '新华网',
        //         time: '2018-10-05',
        //         img: 'https://www.cicic.org.cn/storage/uploads/news-img/wcm.files/upload/CMSydylgw/201809/201809290409020.jpg'
        //     },
        //     {
        //         id: 5,
        //         title: '5中非合作论坛第七届部长级中非合作论坛第七届部长级',
        //         content: '5中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。',
        //         name: '新华网',
        //         time: '2018-10-05',
        //         img: 'https://www.cicic.org.cn/storage/uploads/news-img/wcm.files/upload/CMSydylgw/201809/201809290409020.jpg'
        //     }
        // ]

        // var template = ''
        // for (let i in data) {
        //     template += '<ul class="index-list__wrap">'
        //         template += '<li class="index-list__info">'
        //             template += '<a href="edit.html">'
        //                 template += '<span class="index-list__title ellipsis">'+ data[i].title +'</span>'
        //                 template += '<span class="index-list__content ellipsis2">'+ data[i].content +'</span>'
        //                 template += '<dl class="index-list__reports">'
        //                     template += '<dt class="index-list__reports-name">'+ data[i].name +'</dt>'
        //                     template += '<dt class="index-list__reports-time">'+ data[i].time +'</dt>'
        //                 template += '</dl>'
        //             template += '</a>'
        //         template += '</li>'
        //         template += '<li class="index-list__head">'
        //             template += '<a href="edit.html">'
        //                 template += '<img class="index-list__head-img" src="'+ data[i].img +'" alt="">'
        //             template += '</a>'
        //         template += '</li>'
        //     template += '</ul>'
        // }


        // var appendH = $('.edit-main').scrollTop()
        // $('.edit__recommend').append(template);
        // $('.edit-main').scrollTop(appendH)
    });
})