$(function () {
	// 顶部导航
	new Swiper('.navtop__swiper', {
        slidesPerView: 'auto',
        freeMode: true,
        preventLinksPropagation : false,
        slideToClickedSlide: true,
		// centeredSlides: true,
		initialSlide: getNavIndex(), // 决定默认显示第几个
		on: {
			tap: function(event){
				var currIndex = $(event.target).index()
				$('.navtop__item').removeClass('navtop__item_active').eq(currIndex).addClass('navtop__item_active')
				getNavIndex()
			},
		},
	});

	function getNavIndex () {
		var index = 0
		$('.navtop__item').each(function () {
			if ($(this).hasClass('navtop__item_active')) {
				$(this).find('.navtop__item_active-bottom').addClass('navtop__item_active-show')
				index = $(this).index()
			} else {
				$(this).find('.navtop__item_active-bottom').removeClass('navtop__item_active-show')
			}
		})
		return index
	}

	// 底部导航
	$('.navbottom__item').click(function () {
		$('.navbottom__item').eq(0).removeClass('icon_nav-bottom_news-active').addClass('icon_nav-bottom_news')
		$('.navbottom__item').eq(1).removeClass('icon_nav-bottom_img-active').addClass('icon_nav-bottom_img')
		$('.navbottom__item').eq(2).removeClass('icon_nav-bottom_video-active').addClass('icon_nav-bottom_video')
		if ($(this).hasClass('icon_nav-bottom_news')) {
			$(this).removeClass('icon_nav-bottom_news').addClass('icon_nav-bottom_news-active')
		}
		if ($(this).hasClass('icon_nav-bottom_img')) {
			$(this).removeClass('icon_nav-bottom_img').addClass('icon_nav-bottom_img-active')
		}
		if ($(this).hasClass('icon_nav-bottom_video')) {
			$(this).removeClass('icon_nav-bottom_video').addClass('icon_nav-bottom_video-active')
		}
	})

	// 分享
	$('.icon_share').click(function (e) {
		var str = ''
		str += '<div class="layer_bottom">'
			str += '<div class="layer_bottom_top">'
				str += '<p class="layer_bottom_top_item icon_weixin">微信好友</p>'
				str += '<p class="layer_bottom_top_item icon_weibo">新浪微博</p>'
			str += '</div>'
			str += '<div class="layer_bottom_bottom">取 消</div>'
		str += '</div>'
		layer.open({
			type: 1,
			content: str,
			anim: 'up',
			style: 'position:fixed; bottom:0; left:0; width: 100%;'
		});

		// 分享微信操作
		$('.icon_weixin').click(function () {
			console.log('微信')
			layer.closeAll()
			layer.open({
				title: '复制下列文字粘贴到微信',
				content: '中华文化走出去 尽在https://m.cici.org.cn/',
				btn: '复制',
				shadeClose: true,
				yes: function(){
					layer.open({
						content: '复制成功'
						,time: 2
						,skin: 'msg'
					});
				}
			})
		})

		// 分享微博操作
		$('.icon_weibo').click(function () {
			console.log('微博')
			layer.closeAll()
			layer.open({
				title: '复制下列文字粘贴到微博',
				content: '中华文化走出去 尽在https://m.cici.org.cn/',
				btn: '复制',
				shadeClose: true,
				yes: function(){
					layer.open({
						content: '复制成功'
						,time: 2
						,skin: 'msg'
					});
				}
			})
		})

		// 关闭
		$('.layer_bottom_bottom').click(function () {
			layer.closeAll()
		})
		
	});


	var tur = true
	function scro(){
		tur = true
	}
	// 滑动底部当行隐藏/出现
	var currTop = 0
	var scrollTop = 0
	$('#minirefresh').scroll(function (e) {
		currTop = $(this).scrollTop()
	if(tur){
		setTimeout(scro,500)
		tur = false
		if (scrollTop < currTop && currTop != 0 ) {
			$('.navbottom').slideUp('fast')
		} else {
			$('.navbottom').slideDown('fast')
		}
	}
		scrollTop = currTop
	});
})



// tost提示
function showToast(str) {
	if (window.tostshowing) {
		return
	}
	window.tostshowing = true
	var $toast = $(".toast");
	if ($toast[0]) {
		$toast.html(str);
	} else {
		$("body").append("<div class='toast'>" + str + "</div>");
		$toast = $(".toast");
	}
	$toast.fadeIn();
	setTimeout(function () {
		$toast.fadeOut()
		window.tostshowing = null
	}, 2000)
}

function versionCompare(v1, v2) {
	var GTR = 1; //大于
	var LSS = -1; //小于
	var EQU = 0; //等于
	var v1arr = String(v1).split(".").map(function (a) {
		return parseInt(a);
	});
	var v2arr = String(v2).split(".").map(function (a) {
		return parseInt(a);
	});
	var arrLen = Math.max(v1arr.length, v2arr.length);
	var result;

	//排除错误调用
	if (v1 == undefined || v2 == undefined) {
		throw new Error();
	}

	//检查空字符串，任何非空字符串都大于空字符串
	if (v1.length == 0 && v2.length == 0) {
		return EQU;
	} else if (v1.length == 0) {
		return LSS;
	} else if (v2.length == 0) {
		return GTR;
	}

	//循环比较版本号
	for (var i = 0; i < arrLen; i++) {
		result = getResult(v1arr[i], v2arr[i]);
		if (result == EQU) {
			continue;
		} else {
			break;
		}
	}
	return result;

	function getResult(n1, n2) {
		if (typeof n1 != "number") {
			n1 = 0;
		}
		if (typeof n2 != "number") {
			n2 = 0;
		}
		if (n1 > n2) {
			return GTR;
		} else if (n1 < n2) {
			return LSS;
		} else {
			return EQU;
		}
	}
}

// 统一的ajax方法，参数如下
function ztAjax(obj) {
	/*  obj = {
			url: '/drawproxy/drawgift/v1.0',
			method: 'post', // 可以不传
			data:{},
			callback: function (res) {}
			errorCallback: function () {}
		}
	*/
	var currentHost = window.location.host
	var prefix = 'pro'
	if (currentHost.indexOf('-') > -1) {
		prefix = currentHost.split('-')[0]
	}
	var BASE_API = ''
	if (currentHost.indexOf("172.16.202.") > -1) {
		prefix = 'alpha'
	}
	switch (prefix) {
		case 'dev':
			BASE_API = 'http://dev-api-edge.szy.net'
			break
		case 'alpha':
			BASE_API = 'http://alpha-api.szy.com'
			break
		case 'rc':
			BASE_API = 'http://rc-api.szy.cn'
			break
		default:
			BASE_API = 'http://api.szy.cn'
			break
	}
	$.ajax({
		contentType: "application/json",
		type: obj.method || 'post',
		url: BASE_API + obj.url,
		data: JSON.stringify(obj.data),
		success: function (data) {
			if (data.code === 10000) {
				if (isEmptyObj(data.body)) {
					obj.callback('')
				} else {
					obj.callback(data.body)
				}
			} else {
				obj.errorCallback && obj.errorCallback()
				if (obj.url.indexOf('drawproxy/collectaddress/v1.0') > -1) { // 提交收货信息失败要给个特殊的提示
					showSubmitError()
				} else {
					showToast(data.message)
				}
			}
		},
		error: function () {
			if (obj.url.indexOf('drawproxy/collectaddress/v1.0') > -1) { // 提交收货信息失败要给个特殊的提示
				showSubmitError()
			} else {
				showToast('网络有问题，请稍后重试')
			}
		}
	});
}

function isEmptyObj(obj) { // 判断是否是空对象
	if (!obj) {
		return true
	}
	for (var key in obj) {
		return false
	}
	return true
}

function getTransferHost() {
	var currentHost = window.location.host
	var prefix = ''
	var url = ''
	if (currentHost.indexOf('-') > -1) {
		prefix = currentHost.split('-')[0]
	}
	switch (prefix) {
		case 'alpha':
			url = 'http://alpha-api.szy.com/score/duiba/transfer/v1.0'
			break
		case 'rc':
			url = 'http://rc-api.szy.cn/score/duiba/transfer/v1.0'
			break
		default:
			url = 'http://api.szy.cn/score/duiba/transfer/v1.0'
			break
	}
	return url
}
