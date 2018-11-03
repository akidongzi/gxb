@extends ('frontend.layouts.default')

@section('style')
    <link rel="stylesheet" href="/front/css/guandian-list.css?201810252104">
@endsection

@section('content')

    <!-- 面包屑 -->
    <div class="main_navbar">
        <p class="main_bread pull-center">
            <a href="/">首页</a> &gt; {{$position->name}}
            <i class="main_bottom-line"></i>
        </p>
    </div>
    <h2 class="page-type_navbar pull-center">
        <span class="page-type_cn">观点</span>
        <span class="page-type_en">Viewpoint</span>
    </h2>

    <!-- S 内容主体部分 -->
    <div class="container pull-center clearfix">

        @if ($list->count() == 0)
        <div class="gd-list pull-left">
            <div class="container_news-list_empty">暂无信息</div>
        </div>
        @else
        <div class="gd-list pull-left">
            @foreach ($list as $item)
            <div class="gd-list-item">

                <div class="gd-list-item__atr pull-left">
                    <div class="gd-list-item__atr-icon"></div>
                    <div class="gd-list-item__atr-name"><span>{{ $item->getMeta(\App\Models\Article::META_AUTHOR) ?? '无' }}</span></div>
                    <div class="gd-list-item__atr-desc">{{ $item->getMeta(\App\Models\Article::META_AUTHOR_BRIEF) ?? '暂无' }}</div>
                </div>

                <div class="gd-list-item__body pull-right">
                    <div class="gd-list-item__body-arrow"></div>
                    <div class="gd-list-item__title">
                        <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id]) }}" target="_blank">
                            <span>{{ $item->title }}</span>
                        </a>
                    </div>
                    <div class="gd-list-item__brief">{{ mb_substr($item->brief, 0, 138) }}@if(mb_strlen($item->brief) > 138) ... @endif</div>
                    <div class="gd-list-item__info">
                        <span class="gd-list-item__info-pub-time">{{ $item->published_at->format('Y-m-d') }}</span>

                        {{--<div class="gd-list-item__info-tags pull-right">--}}
                            {{--<span class="gd-list-item__tag">城市</span>--}}
                            {{--<span class="gd-list-item__tag">国家</span>--}}
                            {{--<span class="gd-list-item__tag">大学</span>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
            @endforeach

            <!-- 加载更多 //已全部加载完毕 -->
            @if ($loading)
                <p class="container_loading-more">加载更多</p>
            @else
                <p class="container_loading-more">已加载全部内容</p>
            @endif
        </div>
        @endif

        <div class="container__right pull-right">
            <!-- S 热点排行 -->
        @if ($hotPosition)
            {!! $hotPosition->getBlock() !!}
        @endif
        <!-- E 热点排行 -->

            <!-- S 精彩推荐 -->
        @if ($recommendPosition)
            {!! $recommendPosition->getBlock() !!}
        @endif
        <!-- E 精彩推荐 -->
        </div>

        <!-- S 合作伙伴 -->
    @include('frontend.includes.partners')
    <!-- E 合作伙伴 -->

        <!-- S 友情链接 -->
    @include('frontend.includes.links')
    <!-- E 友情链接 -->
    </div>
    <!-- E 内容主体部分 -->

@endsection

@section('script')
    <script type="text/javascript">
        POSITION_ID = "{{$position->id}}"
    </script>
    <script src="{{ asset('front/js/guandian-list-new.js?201810252148') }}"></script>
@endsection
