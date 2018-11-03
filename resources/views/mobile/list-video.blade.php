@extends('mobile.layouts.no-nav')

@section('html_head')
<link rel="stylesheet" href="{{ asset('mobile/css/video.css') }}">
@endsection

@section('navtop')
<div class="navtop">
    <div class="navtop__bar">
        <p class="navtop__logo"></p>
        <a href="/search"><p class="navtop__controls icon_search"></p></a>
    </div>
</div>
@endsection

@section('content')
<!-- S 首页主体 -->
<div class="video-main minirefresh-wrap" id="minirefresh">
    <div class="minirefresh-scroll">
        <div class="video-list data-list" id="listdata"></div>
    </div>
</div>
<!-- E 首页主体 -->

@include('mobile.partials.footer-nav')
@endsection

@section('body_end')
<script src="{{ asset('mobile/scripts/video.js?1234234') }}"></script>
@endsection