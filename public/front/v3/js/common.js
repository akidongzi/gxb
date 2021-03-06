$(function () {
    // 扫描
    $('.menu__item_sweep').click(function (e) {
        console.log('扫描')
    });

    // 收藏
    $('.menu__item_star').click(function (e) {
        _addFavorite()
    });

    // 返回顶部
    $('.menu__item_top').click(function (e) {
        $('html,body').animate({ scrollTop: 0 }, 'slow');
    });

    // 搜索
    $('.topbar__input-search').click(function (e) {
        searchInfo()
    });
    // 回车搜索
    $('.topbar__input').keydown(function (e) {
        var keyCode = window.event ? e.keyCode : e.which;
        if (keyCode == 13) {
            searchInfo()
        }
    });
    // 搜索函数
    function searchInfo() {
        var inpVal = $('.topbar__input').val()
        if (inpVal == '') {
            alert('请输入搜索内容')
            return
        }
        window.location.href = '/search?keyword='+inpVal
    }

    // 收藏功能
    function _addFavorite() {
        var url = window.location;
        var title = document.title;
        var ua = navigator.userAgent.toLowerCase();
        if (ua.indexOf("360se") > -1) {
            alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
        }
        else if (ua.indexOf("msie 8") > -1) {
            window.external.AddToFavoritesBar(url, title); //IE8
        }
        else if (document.all) {//IE类浏览器
            try {
                window.external.addFavorite(url, title);
            } catch (e) {
                alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
            }
        }
        else if (window.sidebar) {//firfox等浏览器；
            window.sidebar.addPanel(title, url, "");
        }
        else {
            alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
        }
    }
})


// 全局常量设定
var CONST_VAR = {
    BASE_API: $('#BASE_API').val() // 接口域名
}

// 封装的 ajax 请求
function cAjax (ajaxObj) {
    $.ajax({
        type: ajaxObj.method || 'POST',
        url: CONST_VAR.BASE_API + ajaxObj.url,
        data: ajaxObj.data,
        dataType: 'json',
        success: function (response) {
            if (response.status == 1) {
				ajaxObj.callback && ajaxObj.callback(response.data)
			} else {
                ajaxObj.errorCallback && ajaxObj.errorCallback(response.errno)
                alert('请求失败!')
			}
        },
        error: function () {
			alert('网络有问题，请稍后重试')
		}
    });
}

function getTranslateFromStyle(item) {
    var transStyle = item.style.transform;
    if (transStyle) {
        var match = /translate\s*\(\s*([\d\.]+)\s*(\w+)\s*,\s*([\d\.]+)\s*(\w+)\s*\)/.exec(transStyle);
        if (match) {
            return match.slice(1, 5);
        }
    }
}

if (NodeList.prototype.forEach == undefined) {
    NodeList.prototype.forEach = Array.prototype.forEach;
}
