<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>中华文化走出去网 - 首页</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="/front/css/reset.css?1122">
    <link rel="stylesheet" href="/front/css/swiper.min.css?1122">
    <link rel="stylesheet" href="/front/v3/css/common.css?201811022210">

    @yield('style')
    <!--[if IE]>
    <script src="./js/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="@yield('container-class')">
    <!-- S 网站公共头部 -->
    @include('frontend.includes.header')
    <!-- E 网站公共头部 -->

    <!-- S banner 部分 -->
    <div class="bannerbox" style="background: url({{ asset('front/images/homepage-bg.png') }}) no-repeat top center;">
        <div class="bannerbox__mask">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($headline as $news)
                        <div class="swiper-slide">
                            <h2 class="bannerbox__title">
                                <a href="{{ route('frontend.articles.show', ['id' => $news->id, 'position_id' => $position->id]) }}"
                                   target="_blank">{{ mb_substr($news->title, 0, 20) . (mb_strlen($news->title) > 20 ? '...' : '') }}</a>
                            </h2>
                            <ol class="bannerbox__symbol">
                                <li class="bannerbox__symbol-left"></li>
                                <li class="bannerbox__symbol-right"></li>
                            </ol>
                            <h4 class="bannerbox__content">{{ mb_substr($news->brief, 0, 60) . (mb_strlen($news->brief) > 60 ? '...' : '') }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <ol class="banner-bottom-bar">
        <li class="banner-bottom-bar__item" style="background: #3494CF"></li>
        <li class="banner-bottom-bar__item" style="background: #202423"></li>
        <li class="banner-bottom-bar__item" style="background: #E4103B"></li>
        <li class="banner-bottom-bar__item" style="background: #F7A117"></li>
        <li class="banner-bottom-bar__item" style="background: #3DA55C"></li>
    </ol>
    <!-- E banner 部分 -->

    <!-- S 交流活动页主体 -->
    <div class="activities-main pull-center">

        <!-- S 板块大标题 -->
        <div class="plates">
            <h3 class="plates__title"><span style="color: #E2062C;">交流</span><span style="color: #000000;">活动</span></h3>
            <h6 class="plates__small">Exchange Activity</h6>
            <ul class="plates-btns pull-right">
                <a href="{{ route('frontend.articles.index', ['position_id' => $position->id]) }}">
                    <li class="plates-btns_item pull-left @if(request('list_mode') != 1) icon_img_type_active @else icon_img_type @endif">图片模式</li>
                </a>
                <a href="{{ route('frontend.articles.index', ['position_id' => $position->id, 'list_mode' => 1]) }}">
                    <li class="plates-btns_item pull-right @if(request('list_mode') == 1) icon_list_type_active @else icon_list_type @endif">列表模式</li>
                </a>
            </ul>
        </div>
        <!-- E 板块大标题 -->

        <!-- S 搜索列表 -->
        <div class="search-bar">
            <!-- 品牌活动下拉框 -->
            <el-select style="width: 180px; height: 30px;" v-model="searchForm.brandVal" filterable placeholder="品牌活动名称"
                       size="small" clearable>
                @foreach ($brand_activities as $b_activity)
                    <el-option label="{{ $b_activity->value }}" value="{{ $b_activity->value }}"></el-option>
                @endforeach
            </el-select>

            <!-- 国家下拉框 -->
            <el-select style="width: 120px; height: 30px;" v-model="searchForm.countriesVal" filterable placeholder="国家"
                       size="small" clearable @change="countriesChange">
                <el-option v-for="(item, index) of countries" :label="item.display" :value="index"></el-option>
            </el-select>
            <!-- 城市下拉框 -->
            <el-select style="width: 120px; height: 30px;" v-model="searchForm.cityVal" filterable placeholder="城市"
                       size="small" clearable @change="citiesChange">
                <el-option v-for="(item, index) of cities" :label="item.display" :value="index"></el-option>
            </el-select>
            <!-- 子活动下拉框 -->
            <el-select style="width: 120px; height: 30px;" v-model="searchForm.childVal" filterable placeholder="子活动"
                       size="small" clearable>
                @foreach ($sub_activities as $s_activity)
                    <el-option label="{{ $s_activity->value }}" value="{{ $s_activity->value }}"></el-option>
                @endforeach
            </el-select>
            <!-- 时间选择器 -->
            <el-date-picker style="width: 260px; height: 32px; margin-top: 2px;" v-model="searchForm.dateRange"
                            type="daterange" range-separator="至" start-placeholder="开始日期" value-format="yyyy-MM-dd"
                            end-placeholder="结束日期" size="small">
            </el-date-picker>
            <!-- 媒体来源下拉框 -->
            <el-select style="width: 120px; height: 30px;" v-model="searchForm.mediaVal" filterable placeholder="媒体来源"
                       size="small" clearable>
                @foreach(\App\Models\Article::$mediaSources as $ms)
                    <el-option label="{{ $ms }}" value="{{ $ms }}"></el-option>
                @endforeach
            </el-select>
            <!-- 素材类型下拉框 -->
            <el-select style="width: 120px; height: 30px;" v-model="searchForm.materialVal" filterable placeholder="素材类型"
                       size="small" clearable>
                @foreach(\App\Models\Article::$articleTypes as $at_val => $at)
                    @if($at_val == \App\Models\Article::TYPE_ADVERT)
                        @continue
                    @endif
                    <el-option label="{{ $at }}" value="{{ $at_val }}"></el-option>
                @endforeach
            </el-select>
            <button class="search-bar_btn" :disabled="isSearch" @click="handleSearch">搜索</button>
            <button class="search-bar_btn-reset" :disabled="isSearch" @click="resetSearch">重置</button>
        </div>
        <!-- E 搜索列表 -->

        @yield('content')

        <!-- S 合作伙伴 -->
        @include('frontend.includes.partners')
        <!-- E 合作伙伴 -->

            <!-- S 友情链接 -->
        @include('frontend.includes.links')
        <!-- E 友情链接 -->
    </div>
    <!-- S 交流活动页主体 -->

    <!-- 隐藏域 -->
    <input type="hidden" id="BASE_API" value="{{ env('API_DOMAIN') ?? request()->getSchemeAndHttpHost() }}">
    <input type="hidden" id="SUBJECT_ID" value="{{ $position->id }}">

<!-- S 网站公共尾部 -->
    <div class="bottombar">
        <div class="bottombar__company-info">
            <p class="bottombar_crumbs pull-center">
                <a href="#">CICIC</a> &gt; <a href="{{ route('frontend.articles.index', ['position_id' => $position->id]) }}">{{ $position->name }}</a>
            </p>
            <ul class="bottombar__content pull-center">
                <li class="bottombar__footer-log pull-left"></li>
                <li class="bottombar__record-info pull-left">
                        <span class="bottombar__record-txt">
                            京ICP备18040577号-1&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;京公网安备
                            11010202007426号&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;增值电信业务经营许可证（京B2-20170698）
                        </span>
                    <span class="bottombar__record-txt">
                            网络传播视听节目许可证号 0310548&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;视听节目制作许可证（京）字第08992号
                        </span>
                </li>
                <li class="bottombar__phone pull-left">
                    <span class="bottombar__title">联系电话</span>
                    <span class="bottombar__number">010-58565824</span>
                </li>
                <li class="bottombar__email pull-left">
                    <span class="bottombar__title">联系邮箱</span>
                    <span class="bottombar__number">news@cicic.org.cn</span>
                </li>
            </ul>
        </div>
        <div class="bottombar__copywrap">
            <div class="bottombar__copybar pull-center">
                <p class="bottombar__copybar_title pull-left">Copyright &#169 2018 五洲融媒体科技股份有限公司.All rights
                    reserved.
                    未经书面授权禁止使用</p>
                <ul class="bottombar__copybar_language pull-right">
                    <li class="bottombar__copybar_language_flag pull-left" style="background: url(./images/flag_English.png) no-repeat center center;"></li>
                    <li class="bottombar__copybar_language_txt pull-right">中文</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- E 网站公共尾部 -->
</div>
<!-- S 右侧快捷功能 -->
<ul class="menu">
    <!--<li class="menu__item menu__item_sweep"></li>-->
    <li class="menu__item menu__item_star"></li>
    <li class="menu__item menu__item_top"></li>
</ul>
<!-- E 右侧快捷功能 -->
</body>
@stack('before-scripts')
<script src="/front/js/jquery-1.8.3.js"></script>
<script src="/front/js/swiper.min.js"></script>
<script src="/front/v3/js/common.js?201811031213"></script>
@yield('script')
@stack('after-scripts')

</html>
