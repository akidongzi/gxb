@extends ('frontend.layouts.default')

@section('style')
    <link rel="stylesheet" href="/front/css/guandian-list.css?201810231128">
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
        <span class="page-type_cn">{{$position->name}}</span>
        <span class="page-type_en">Viewpoint</span>
    </h2>

    <!-- S 内容主体部分 -->
    <div class="container pull-center clearfix">

        <div class="container_left pull-left">
            @if ($list->count() == 0)
                <div class="container_news-list_empty">暂无信息</div>
            @else
                @foreach ($list as $item)
                    <div class="container_news-list">
                        <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id]) }}" target="_blank">
                            <h4 class="container_news-list_title ellipsis">{{$item->title}}</h4>
                        </a>
                        <ul class="container_news-list_meta-info">
                            @if($item->meta_info)<li>作者: <span>{{ $item->meta_info }}</span></li>@endif
                            <li>发布时间: <span>{{ $item->published_at->format("Y-m-d") }}</span></li>
                        </ul>
                        <ul class="container_info clearfix">
                            <li class="container_content pull-left" style="width:100%;">
                                <span class="container_content-text">{{ $item->brief }}</span>
                            </li>
                        </ul>
                    </div>
                @endforeach
            @endif

        <!-- 加载更多 //已全部加载完毕 -->
            @if ($loading)
                <p class="container_loading-more">加载更多</p>
            @else
                <p class="container_loading-more">已加载全部内容</p>
            @endif

        </div>

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
    <script src="{{ asset('front/js/guandian-list.js?201810241858') }}"></script>
@endsection
