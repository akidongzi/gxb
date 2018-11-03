@extends('mobile.layouts.main')

@section('content')

<div class="main minirefresh-wrap" id="minirefresh">
    <div class="minirefresh-scroll">
        <p class="update-number"></p>
        <!-- 轮播图 -->
        <div class="index-swiper">
            <div class="index-swiper__container swiper-container">
                <div class="index-swiper__wrap swiper-wrapper">
                    @foreach($banners as $banner)
                    <div class="index-swiper__item swiper-slide">
                        <a href="{{ $banner->url }}"><img class="index-swiper__item-img" src="{{ $banner->banner_url }}" alt="{{ $banner->title }}"></a>
                        <p class="index-swiper__item-text">{{ $banner->title }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="index-swiper__pagination swiper-pagination"></div>
            </div>
        </div>
        <div class="index-list data-list" id="listdata">
        </div>
    </div>
</div>
@include('mobile.partials.footer-nav')

@section('body_end')
<script type="text/javascript">
    POSITION_ID = 0;
    TYPE = 1;
</script>
@endsection

@endsection