@extends ('frontend.layouts.default')

@section('style')
    <link rel="stylesheet" href="/front/css/list.css?2223111">
    <link rel="stylesheet" href="/front/css/article.css?2223111">
@endsection

@section('content')

    <!-- 面包屑 -->
    <div class="main_navbar">
        <p class="main_bread pull-center">
            @if ($pposition->name)
                <a href="/">首页</a> &gt; {{$pposition->name}} > {{$position->name}}
            @else
                <a href="/">首页</a> &gt; {{$position->name}}
            @endif
            <i class="main_bottom-line"></i>
        </p>
    </div>
    <!-- <h2 class="page-type_navbar pull-center">
    <span class="page-type_cn">{{$position->name}}</span>
    <span class="page-type_en">News</span>
</h2> -->


    <div class="container_banner container_banner_zgg">
        <h2 class="page-type_navbar pull-center">
            @if ($position->code == "ZGG")
                <span class="page-type_cn">中国<em>馆</em><i>China Pavilion</i></span>
            @elseif($position->code == "KZXY")
                <span class="page-type_cn">中国<em>学院</em><i>China Pavilion</i></span>
            @elseif($position->code == "ZGWHZX")
                <span class="page-type_cn">中国<em>文化</em>中心<i>China Pavilion</i></span>
            @endif
        </h2>
        {{--<img src="/front/v3/images/banner_type4.png" alt="">--}}
    </div>
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
                        <ul class="container_info clearfix">

                            @if ($item->coversNum == 0)
                                <li class="container_content pull-left" style="width:100%;">
                                    <span class="container_content-text">{{$item->brief}}</span>
                                    <span class="container_content-time">{{$item->source}} {{$item->published_at->format("Y-m-d") }}</span>
                                </li>
                            @elseif ($item->coversNUm >= 1)
                                <div class="container_news-list">
                                    <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id]) }}">
                                        <h4 class="container_news-list_title ellipsis">{{$item->title}}</h4>
                                    </a>
                                    <ul class="container_info clearfix">

                                        @if($item->type == 2)
                                            @foreach ($item->atlas as $uidx => $atlas)
                                                @if($uidx > 3)
                                                    @break
                                                @endif
                                                <li class="container_img pull-left">
                                                    <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id]) }}"><img src="{{img_resize($atlas->banner, 181,120)}}" alt=""></a>
                                                </li>
                                            @endforeach
                                        @else
                                            @foreach ($item->coversUrl as $uidx => $url)
                                                @if($uidx > 0)
                                                    @break
                                                @endif
                                                <li class="container_img pull-left">
                                                    <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id]) }}"><img src="{{img_resize($url,181,120)}}" alt=""></a>
                                                </li>
                                            @endforeach
                                            <li class="container_content pull-left">
                                                <span class="container_content-text">{{$item->brief}}</span>
                                                <span class="container_content-time">{{$item->source}} {{$item->published_at->format("Y-m-d")}}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <li class="container_img pull-left">
                                    <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id'=>$position->id]) }}" target="_blank">
                                        <img src="{{img_resize($item->banner_url,400,276) }}" alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
                                    </a>
                                </li>
                                <li class="container_content pull-left">
                                    <span class="container_content-text">{{$item->brief}}</span>
                                    <span class="container_content-time">{{$item->source}} {{$item->published_at->format("Y-m-d") }}</span>
                                </li>
                            @endif
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

            <!--S 孔子学院-->
            @foreach ($sideArticle as $k=>$item)
                @if($k <=1)
                    <div class="focus-month focus-month_kzxy">
                        <a target="_blank"  href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}">
                            <img src="{{img_resize($item->banner_url, 280, 368) }}" alt="" width="280" height="368">
                        </a>
                    </div>
            @endif
        @endforeach
        <!--E 孔子学院-->

            <!-- S 其他 -->
        @if ($qtposition)
            {!! $qtposition->getBlock() !!}
        @endif
        <!-- E 其他 -->
        </div>
    </div>
    <!-- E 内容主体部分 -->

    <div class="container_banner container_banner_zgg1">
        <ul>
            <li class="tit">中国馆</li>
            <li class="desc">五洲传播中心（五洲传播出版社）成立于1993年12月，是一家综合性国际文化传播机构，拥有影视传播、图书期刊出版、文化交流和网络传播等四个外向型传播平台。五洲传播中心（五洲传播出版社）致力于中外文化交流与国际合作，以“让世界了解中国，让中国了解世界”为宗旨，以更好地向世界传播中国声音。同时，将世界其他国家的优秀文化成果介绍给中国人民。</li>
            <li class="contact">
                <strong>联系人电话</strong>
                <span>+86-010-87768992</span>
            </li>
        </ul>
        {{--<img src="/front/v3/images/banner_type4.png" alt=""> --}}
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        POSITION_ID = "{{$position->id}}"
    </script>
    <script src="{{ asset('front/js/list.js?201810252124') }}"></script>
@endsection
