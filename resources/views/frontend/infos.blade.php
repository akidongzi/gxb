@extends ('frontend.layouts.default')

@section('style')
<link rel="stylesheet" href="{{ asset('front/info/common.css?2211') }}">
<link rel="stylesheet" href="{{ asset('front/info/info.css?2211') }}">
<link rel="stylesheet" href="{{ asset('front/css/list.css?2211') }}">
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
    <div class="detail-nav clear">
        <div class="detail">
            <h2 class="">{{$article->title}}</h2>
            <p class="title-p clear"><span class="float-left">{{$article->created_at}}</span><span
                        class="float-right">支持 ← → 键翻阅图片️</span></p>
            <div class="banner one-row">
                <div class="clear list-nav" style="width: 400%;position: relative;left: 0;top: 0;">
                    @foreach($article->atlas as $item1)
                        <div class="innerwraper">
                            <a>
                                <img src="{{$item1->banner}}"/>
                            </a>
                        </div>
                    @endforeach
                </div>
                <span class="img-prev"></span>
                <span class="img-next"></span>
            </div>
            <div class="display-none atlas">
                <h3 class="atlas-title">图集推荐 <span class="float-right">X</span></h3>
                <ul class="atlas-list clear" id="buttons">
                    {{--@foreach($hotArticles as $hotArticle)--}}
                        {{--<a href="/articles/{{$hotArticle->id}}">--}}
                            {{--<li>--}}
                                {{--<img src="{{$hotArticle->Atlas->first()->banner??''}}"/>--}}
                                {{--<p class="recommend-list-li-p">{{$hotArticle->title}}</p>--}}
                            {{--</li>--}}
                        {{--</a>--}}
                    {{--@endforeach--}}
                </ul>
            </div>
            <div class="clear info-nav">
                <p class="float-left info-nav-left"><span>1</span> / {{count($article->atlas)}}</p>
                <div class="float-right info-nav-right">
                    @foreach($article->atlas as $item)
                        <p class="display-none">
                            {{$item->brief}}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="recommend">
            <h1><span>相关推荐</span></h1>
            <ul class="recommend-list clear">
                {{--@foreach($recommends as $k=>$recommend)--}}
                    {{--<a href="/articles/{{$recommend->id}}">--}}
                        {{--<li>--}}
                            {{--<img src="{{$recommend->Atlas->first()->banner??''}}"/>--}}
                            {{--<p class="recommend-list-li-p">{{$recommend->title}}</p>--}}
                        {{--</li>--}}
                    {{--</a>--}}
                    {{--@if ($k == 3) @break @endif--}}
                {{--@endforeach--}}
            </ul>
        </div>
    </div>
</div>
<!-- E 内容主体部分 -->
@endsection

@section('script')
<script type="application/javascript" src="/front/info/common.js"></script>
@endsection
