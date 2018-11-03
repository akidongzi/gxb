$(document).ready(function() {
    var listWrapper = $('.aui-list-item-wrapper');
    var currentPage = 0;
    var pageSize = 10;
    var totalPage = 1;
    var currentVideoList = [];
    var isLoading = false;

    // init
    getFixedPageData();

    function getFixedPageData() {
        isLoading = true;
        currentPage++;
        if (currentPage > 1) {
            listWrapper.append('<div class="aui-list-loading"></div>');
        }
        $.ajax({
            method: 'get',
            url: YDUI.util.serverHost + '/api/list_videos',
            data: {
                page: currentPage
            },
            success: function(result) {
                isLoading = false;
                totalPage = result.ResultData.last_page;
                var videoList = result.ResultData.data;
                var tpl = '';
                if (currentPage == 1) {
                    if (videoList.length == 0) {
                        listWrapper.html('<div class="page-no-data">没有符合条件的内容。</div>');
                        return false;
                    }
                    listWrapper.html('');
                } else {
                    $('.aui-list-loading').remove();
                }
                videoList.forEach(function(listItem) {
                    tpl += '<div class="aui-news-item aui-news-list-one">';
                    tpl += '<div class="aui-news-item-img">';
                    tpl += '<video ';
                    if (listItem.poster) {
                        tpl += 'poster="' + listItem.poster_url + '"';
                    } else {
                        tpl += 'preload="metadata" ';
                    }

                    tpl += ' src="' + listItem.file_url + '" controls class="j-media-video" x5-video-player-type="h5" webkit-playsinline="true" playsinline="true">';
                    tpl += '<source src="' + listItem.file_url + '" type="video/mp4"></video>';
                    tpl += '</div>';
                    tpl += '<div class="aui-news-item-text">';
                    tpl += '<h2 class="aui-news-item-text-title">' + listItem.title + '</h2>';
                    tpl += '<div class="aui-news-item-text-info">';
                    tpl += '<span class="aui-news-item-text-info-text">' + listItem.source + '&nbsp;&nbsp;&nbsp;' + YDUI.util.formatFixedDate(new Date(listItem.updated_at.replace(/\-/g, "/")), 'yyyy-MM') + '</span>';
                    tpl += '</div></div></div>';
                });

                listWrapper.append(tpl);
                // 第一页
                if (currentPage == 1) {
                    bindEvents();
                }
                // 最后一页
                if (currentPage == totalPage) {
                    listWrapper.append('<div class="aui-list-nodata">已全部加载完毕</div>');
                }
            }
        });
    }


    function bindEvents() {
        // scroll
        listWrapper.scroll(function(event) {
            // 暂停播放
            currentVideoList.forEach(function(currentVideo) {
                if (currentVideo && !YDUI.util.isInViewPort(currentVideo)) {
                    currentVideo.pause();
                }
            });

            var scrollTop = $(this).scrollTop();
            var elemHeight = $(this).outerHeight();
            var scrollHeight = $(this).get(0).scrollHeight;
            if (scrollTop + elemHeight == scrollHeight && currentPage < totalPage && !isLoading) {
                getFixedPageData();
            }
        });

        // video play
        listWrapper.find('.j-media-video').on('play', function(event) {
            var target = event.target || event.srcElement;
            if (currentVideoList.indexOf(target) == -1) {
                currentVideoList.push(target);
            }
        });
    }
});