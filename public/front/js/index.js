$(function () {
    // 轮播图
    new Swiper('.bannerswiper .swiper-container', {
        // effect: 'fade',
        loop : true,
        autoplay: 3000,
        autoplayDisableOnInteraction : false,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        paginationBulletRender: function (swiper, index, className) {
            return '<span class="' + className + '">' + (index + 1) + '</span>';
        }
    });

    // 折叠窗
    $('.real-time-news__content').eq(4).css('display', 'block')
    $('.real-time-news__item').mouseover(function () {
        var currIndex = $(this).index()
        $('.real-time-news__list').find('.real-time-news__content').each(function (indexInArray, valueOfElement) { 
            if (currIndex == indexInArray) {
                $(this).show()
            } else {
                $(this).hide()
            }
        })
    })
})