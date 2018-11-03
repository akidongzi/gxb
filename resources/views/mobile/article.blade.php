@extends('mobile.layouts.no-nav')

@section('navtop')
<div class="navtop">
		<div class="navtop__bar">
			<a href="/"><p class="navtop__logo"></p></a>
			<p class="navtop__controls icon_share"></p>
		</div>
		<div class="navtop__swiper swiper-container">
			<p class="edit-breadcrumb pull-center">
				<a href="/">首页</a> &gt; 
				<a href="{{ route('mobile.list', [], false) }}?positionId={{ $position->id }}">{{$position->name}}</a>
		</div>
	</div>
@endsection

@section('content')
<!-- S 详情部分 -->
<div class="edit-main">
	<div class="edit-title pull-center">{{$article->title}}</div>
	<dl class="index-list__reports">
		<dt class="index-list__reports-name">{{$article->source}}</dt>
		<dt class="index-list__reports-time">{{$article->published_at->format("Y-m-d")}}</dt>
	</dl>

	<div class="edit__info">
		{!! $article->content !!}
	</div>

	<!-- <ul class="edit__tag">
		<li class="edit__tag_item">国际新闻</li>
		<li class="edit__tag_item">头条</li>
		<li class="edit__tag_item">朋友圈</li>
		<li class="edit__tag_item">国际新闻</li>
		<li class="edit__tag_item">头条</li>
		<li class="edit__tag_item">朋友圈</li>
		<li class="edit__tag_item">国际新闻</li>
		<li class="edit__tag_item">头条</li>
		<li class="edit__tag_item">朋友圈</li>
	</ul> -->

	<!-- 精彩推荐 -->
	<h4 class="edit__recommend_title">精彩推荐</h4>
	<p class="edit__recommend_title_bline pull-center"></p>
	<div class="edit__recommend">

		<!-- <ul class="index-list__wrap">
			<li class="index-list__info">
				<a href="edit.html">
					<span class="index-list__title ellipsis">中非合作论坛第七届部长级中非合作论坛第七届部长级</span>
					<span class="index-list__content ellipsis2">中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。</span>
					<dl class="index-list__reports">
						<dt class="index-list__reports-name">新华网</dt>
						<dt class="index-list__reports-time">2018-10-05</dt>
					</dl>
				</a>
			</li>
			<li class="index-list__head">
				<a href="edit.html">
					<img class="index-list__head-img" src="https://www.cicic.org.cn/storage/uploads/news-img/wcm.files/upload/CMSydylgw/201809/201809290409020.jpg" alt="">
				</a>
			</li>
		</ul>

		<ul class="index-list__wrap">
			<li class="index-list__info" style="width: 100%;">
				<a href="edit.html">
					<span class="index-list__title ellipsis">中非合作论坛第七届部长级中非合作论坛第七届部长级</span>
					<span class="index-list__content ellipsis2">中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。中非合作论坛第七届部长级会议2日在北京钓鱼台国宾馆举行。</span>
					<dl class="index-list__reports">
						<dt class="index-list__reports-name">新华网</dt>
						<dt class="index-list__reports-time">2018-10-05</dt>
					</dl>
				</a>
			</li>
		</ul> -->
		
		<div class="find-more_wrap">
			<p class="find-more_info pull-center">发现更多资讯</p>
		</div>
	</div>
</div>
<!-- E 详情部分 -->
@endsection

@section('body_end')
<script src="{{ asset('mobile/scripts/edit.js?1122311') }}"></script>

<script type="text/javascript">
    POSITION_ID = "{{ app('request')->input('positionId') }}";
    $(function () {
    	$(".find-more_wrap").trigger('click');
    });

</script>
@endsection