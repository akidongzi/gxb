@extends('mobile.layouts.no-nav')

@section('content')
<!-- S 顶部公共导航 -->
<div class="navtop navtop_search">
    <div class="navtop__bar">
        <p class="search_wrap">
            <input class="search_input" id="keyword" type="text" placeholder="输入关键字">
        </p>
        <p class="navtop__controls icon_search"></p>
    </div>
</div>
<!-- E 顶部公共导航 -->

<div class="search-main minirefresh-wrap" id="minirefresh">
    <div class="minirefresh-scroll">
       
        <div class="index-list data-list" id="listdata">
        </div>
    </div>
</div>


@section('body_end')
<script type="text/javascript">
    POSITION_ID = 0;
    TYPE = 1;
    var keyword = YDUI.util.getQueryString('keyword');
    if (keyword) {
        $("#keyword").val(keyword);
    }
    // search
    $('.icon_search').click(function() {
        var value = $("#keyword").val();
        window.location.href = '/search?keyword=' + value;
    });
</script>
<script src="{{ asset('mobile/scripts/index.js?201811022310') }}"></script>
@endsection

@endsection