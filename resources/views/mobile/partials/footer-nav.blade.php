<!-- S 底部公共导航 -->
<div class="navbottom">
	<ul class="navbottom__wrap">
		<a href="{{ route('mobile.index') }}"><li class="navbottom__item
		@if('/' == request()->getPathInfo() || '/list' == request()->getPathInfo()) icon_nav-bottom_news-active @else icon_nav-bottom_news @endif">要闻</li></a>
		<a href="{{ route('mobile.gallery.list') }}"><li class="navbottom__item icon_nav-bottom_img 
			@if(route('mobile.gallery.list', [], false) == request()->getPathInfo()) icon_nav-bottom_img-active @else icon_nav-bottom_img  @endif">图片</li></a>
		<a href="{{ route('mobile.video.list') }}"><li class="navbottom__item icon_nav-bottom_video 
			@if(route('mobile.video.list', [], false) == request()->getPathInfo()) icon_nav-bottom_video-active @else icon_nav-bottom_video @endif">视频</li></a>
	</ul>
</div>
<!-- E 底部公共导航 -->