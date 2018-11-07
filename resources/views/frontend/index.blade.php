@extends ('frontend.layouts.default')

@section('style')
<link rel="stylesheet" href="/front/css/index.css?201810251854">
@endsection

@section('content')

<!-- S banner 部分 -->
@if ($toutiaoPosition)
@foreach ($toutiaoPosition->getData() as $val)
<div class="bannerbox">
    <h2 class="main__banner-title">
        <a href="{{ route('frontend.articles.show', ['article' => $val->id, 'position_id'=>$toutiaoPosition->id]) }}" target="_blank">
            {{ mb_substr($val->title, 0, 20) . (mb_strlen($val->title) > 20 ? '...' : '') }}
        </a>
    </h2>
    <h4 class="main__banner-small pull-center">{{ mb_substr($val->brief, 0, 120) . (mb_strlen($val->brief) > 120 ? '...' : '') }}</h4>
</div>
@endforeach
@endif

<!-- E banner 部分 -->

<!-- S 主要内容部分 -->
<div class="container pull-center clearfix">

    <div class="container__left pull-left">

        <!-- S 轮播图 -->
        <div class="bannerswiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @if(! empty($banners))
                    @foreach($banners as $banner)
                    <div class="swiper-slide">
                        <a href="{{$banner->url}}" target="_blank">
                            <img src="{{ img_resize($banner->file, 800, 280)}}" alt="{{$banner->title}}">
                            <p class="bannerswiper__desc">{{$banner->title}}</p>
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!-- E 轮播图 -->

        <a target="_blank" href="http://www.cicc.org.cn/html/2018/dtzx_0823/4957.html">
            <div class="conference-banner"></div>
        </a>

        <!-- 新闻要点 -->
        <div class="news">
            <div class="news_title-wrap">
                <h5 class="news_title-text pull-left">{{ $newPointsPosition ? $newPointsPosition->name : '-' }}</h5>
                <span class="news_small pull-left">Top News</span>
                <p class="news_more-wrap pull-right">
                    <a href="/articles?position_id={{ $newPointsPosition ? $newPointsPosition->id : 0 }}" target="_blank">
                        <span class="news_more">更多</span>
                    </a>
                </p>
            </div>
            <!-- 新闻列表 -->
            <div class="newslist clearfix">
                @if ($newPointsPosition)
                @foreach($newPointsPosition->getData(6) as $k => $item)
                <ul class="newslist_item">
                    @if($item->banner_url)
                    <li class="newslist_img pull-left">
                        <a target="_blank" href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$newPointsPosition->id]) }}">

                        @if ($item->banner_url)
                        <img class="newslist_img-url" src="{{img_resize($item->banner_url, 320, 220) }}" alt="">
                        @endif
                        </a>
                    </li>
                    @endif
                    <li class="newslist_content pull-right" @if (!$item->banner_url) style="width:100%" @endif>
                        <a target="_blank" href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$newPointsPosition->id]) }}">
                            <span class="newslist_content-title">{{str_limit($item->title, 40, '')}}</span>
                        </a>
                        <a target="_blank" href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$newPointsPosition->id]) }}">
                        <span class="newslist_content-small">{{str_limit($item->brief, 50)}}</span>
                        </a>
                    </li>
                </ul>
                @endforeach
                @endif
            </div>
        </div>

        <!-- 外媒宣传 -->
        <div class="foreign-media">

            <div class="news_title-wrap">
                <h5 class="news_title-text pull-left">{{ $newsOutPosition ? $newsOutPosition->name : '-' }}</h5>
                <span class="news_small pull-left">Propaganda Media</span>
                <p class="news_more-wrap pull-right">
                    <a href="/articles?position_id={{ $newsOutPosition ? $newsOutPosition->id : 0 }}" target="_blank">
                        <span class="news_more">更多</span>
                    </a>
                </p>
            </div>

            <!-- 外媒宣传列表 -->
            <div class="foreign-media-list clearfix">
                @if ($newsOutPosition)
                @foreach($newsOutPosition->getData(4) as $k => $item)
                <ul class="foreign-media-list_item">
                    @if($item->banner_url)
                    <li class="foreign-media_img pull-left">
                        <a href="{{ route('frontend.articles.show', ['article' => $item->id,'position_id'=>$newsOutPosition->id]) }}" target="_blank">
                        @if ($item->banner_url)
                        <img class="foreign-media_img-url" src="{{img_resize($item->banner_url,420,288) }}" alt="" >
                        @endif
                        </a>
                    </li>
                    @endif
                    <li class="foreign-media_content pull-right" @if (!$item->banner_url) style="width:100%" @endif>
                        <a href="{{ route('frontend.articles.show', ['article' => $item->id,'position_id'=>$newsOutPosition->id]) }}" target="_blank">
                            <span class="foreign-media_content-title">{{$item->title}}</span>
                        </a>
                        <a href="{{ route('frontend.articles.show', ['article' => $item->id,'position_id'=>$newsOutPosition->id]) }}" target="_blank">
                        <span class="foreign-media_content-small">{{$item->brief}}</span>
                        </a>
                        <span class="foreign-media_time">{{$item->source}} · {{$item->published_at->diffForHumans() }}</span>
                    </li>
                </ul>
                @endforeach
                @endif
            </div>
        </div>

        <!-- S 专题活动 -->
        <div class="project-activitie">
            <div class="news_title-wrap">
                <h5 class="news_title-text pull-left">{{ $themePosition ? $themePosition->name : '' }}</h5>
                <span class="news_small pull-left">Activities</span>
                <p class="news_more-wrap pull-right">
                    <a href="/articles?position_id={{ $themePosition ? $themePosition->id : 0 }}" target="_blank">
                        <span class="news_more">更多</span>
                    </a>
                </p>
            </div>
            <!-- 专题活动列表 -->
            <div class="project-activitie_list clearfix">
                @if ($themePosition)
                @foreach($themePosition->getData(4) as $k => $item)
                <ul class="project-activitie_item">
                    <li class="project-activitie_img">
                        <a href="{{ route('frontend.articles.show', ['article' => $item->id,'position_id'=>$themePosition->id]) }}" target="_blank">
                            <img class="project-activitie_img-url" src="{{img_resize($item->banner_url,400,276) }}" alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
                        </a>
                    </li>
                    <a href="{{ route('frontend.articles.show', ['article' => $item->id,'position_id'=>$themePosition->id]) }}" target="_blank">
                        <li class="project-activitie_title">{{str_limit($item->title, 50)}}</li>
                    </a>
                    <li class="project-activitie_time">{{str_limit($item->source, 20, '')}} · {{$item->published_at->diffForHumans() }}</li>
                </ul>
                @endforeach
                @endif
            </div>
        </div>
        <!-- E 专题活动 -->

    </div>

    <div class="container__right pull-right">

        <!-- S 实时要闻 -->
        {!! $newsTimePosition ? $newsTimePosition->getBlock() : '' !!}
        <!-- E 实时要闻 -->

        <!-- S 文化信息查询入口 -->
        <a href="javascript::void(0);"><div class="culture-search"></div></a>
        <!-- E 文化信息查询入口 -->

        <!-- S 关注我们 -->
        <div class="focusus">
            <h5 class="focusus__title">关注我们</h5>
            <p class="focusus__title_line pull-center"></p>
            <p class="focusus__wechart-title">关注微信公众号，了解最新精彩内容</p>
            <ul class="focusus__wechart-wrap pull-center">
                <li class="focusus__wechart-item">
                    <img src="/front/images/qrcode_left.png" alt="">
                    <span class="focusus__wechart_txt">五洲融媒体</span>
                </li>
                <li class="focusus__wechart-item">
                    <img src="/front/images/qrcode_left.png" alt="">
                    <span class="focusus__wechart_txt">文化交流中心</span>
                </li>
            </ul>
        </div>
        <!-- E 关注我们 -->

        <!-- S 本月焦点 -->
        {!! $monthPointPosition ? $monthPointPosition->getBlock() : '' !!}
        <!-- E 本月焦点 -->

        <!-- S 文化投资 -->
        {!! $culturalPosition ? $culturalPosition->getBlock() : '' !!}
        <!-- E 文化投资 -->

        <!-- S 精彩推荐 -->
        {!! $recommendPosition ? $recommendPosition->getBlock() : '' !!}
        
        <!-- E 精彩推荐 -->
    </div>

    <!-- S 合作伙伴 -->
    @include('frontend.includes.partners')
    <!-- E 合作伙伴 -->

    <!-- S 友情链接 -->
    @include('frontend.includes.links')
    <!-- E 友情链接 -->
</div>
<!-- E 主要内容部分 -->
@endsection

@section('script')
<script src="/front/js/index.js"></script>
@endsection
