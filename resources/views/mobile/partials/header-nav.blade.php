<!-- S 顶部公共导航 -->
<div class="navtop">
    <div class="navtop__bar">
        <a href="/"><p class="navtop__logo"></p></a>
        <a href="{{ route('mobile.search') }}"><p class="navtop__controls icon_search"></p></a>
    </div>
    <div class="navtop__swiper swiper-container">
        <div class="navtop__wrap swiper-wrapper">
            <a href="/" class="navtop__item swiper-slide @if (app('request')->input('positionId') == '') navtop__item_active @endif">
                首页
                <p class="navtop__item_active-bottom"></p>
            </a>
            @foreach($__vs_nav_data['pos'] as $pos)
            <a href="{{ route('mobile.list', [], false) }}?positionId={{ $pos->id }}" class="navtop__item swiper-slide  @if (app('request')->input('positionId') == $pos->id) navtop__item_active @endif" >
                {{ $pos->name }}
                <p class="navtop__item_active-bottom"></p>
            </a>
            @endforeach
        </div>
    </div>
</div>
<!-- E 顶部公共导航 -->