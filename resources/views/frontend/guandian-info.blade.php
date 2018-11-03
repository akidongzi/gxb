@extends ('frontend.layouts.default')

@section('style')
    <link rel="stylesheet" href="/front/css/list.css?201810261655">
    <style type="text/css">
    .gd-quote {
        display:inline-block;
        font-size:60px;
        height:40px;
        overflow:hidden;
        line-height: normal;
    }
    .gd-quote-left {}
    .gd-quote-right {
        margin-left:-30px;
        margin-top: -15px;
    }
    .gd-brief {
        margin:15px 0;
        color:#000;
        background:#eee;
        padding:10px 8px;
        text-indent: 1em;
        font-size:20px;
        line-height: 35px;
    }
    </style>
@endsection

@section('content')
    <!-- 面包屑 -->
    <div class="main_navbar">
        <p class="main_bread pull-center">
            首页 &gt;
            <a href="/articles?position_id={{$position->id}}">{{$position->name}} </a>&gt; {{$article->title}}
            <i class="main_bottom-line"></i>
        </p>
    </div>

    <!-- S 内容主体部分 -->
    <div class="container pull-center clearfix">

        <div class="container_left pull-left">
            <div class="edit_head" style="border:0;">
                <h3 class="edit_title">{{$article->title}}</h3>
                <p class="edit_title-small">
                    发布时间：{{ $article->published_at ? $article->published_at->format('Y-m-d') : $article->created_at->format('Y-m-d') }}
                    @if($article->source)
                        <span style="display:inline-block; width:30px;">&nbsp;</span>
                        <span class="article-from">来源：
                        <a href="{{ $article->url }}" target="_blank"
                           rel="nofollow">{{$article->source}}</a>
                    </span>
                    @endif
                </p>

                @if($article->getMeta(\App\Models\Article::META_AUTHOR))
                <p class="edit_title-small">
                作者：{{ $article->getMeta(\App\Models\Article::META_AUTHOR) }}，{{ $article->getMeta(\App\Models\Article::META_AUTHOR_BRIEF) }}
                </p>
                @endif

                <div class="gd-brief">
                    <span class="gd-quote gd-quote-left">“</span>
                    {{ $article->brief }}
                    <span class="gd-quote gd-quote-right">”</span>
                    @if($article->getMeta(\App\Models\Article::META_AUTHOR))
                    —— <span>{{ $article->getMeta(\App\Models\Article::META_AUTHOR) }}，{{ $article->getMeta(\App\Models\Article::META_AUTHOR_BRIEF) }}</span>
                    @endif
                </div>

            </div>

            <!-- S 编辑器内容 -->
            <div class="edit-main">
                @if($article->type == 2)
                    @foreach($article->atlas as $atlas)
                        <p>
                            <img src="{{ $atlas->banner }}" />
                            <span class="edit-main_img-desc">{{ $atlas->brief }}</span>
                        </p>
                    @endforeach
                @else
                    {!! $article->content !!}
                @endif
            </div>
            <!-- E 编辑器内容 -->

            <!-- <div class="edit_footer">
                <ul class="page_wrap">
                    <li class="page_prev pull-left">上一条</li>
                    <li class="page_next pull-right">下一条</li>
                </ul>
                <ul class="page_wrap">
                    <a href="">
                        <li class="info_prev pull-left">没有了</li>
                    </a>
                    <a href="">
                        <li class="info_next pull-right">习近平：教育是国之大计、党之大计</li>
                    </a>
                </ul>
            </div> -->

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
        POSITION_ID = "2"
    </script>
    <script src="/front/js/list.js"></script>
@endsection