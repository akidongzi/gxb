@extends ('frontend.layouts.jlhd')

@section('container-class', 'index-container')

@section('style')
<link rel="stylesheet" href="{{ asset('front/css/element-ui.css') }}">
<link rel="stylesheet" href="{{ asset('front/v3/css/jlhd-index.css?201811022210') }}">
@endsection

@section('content')
<!-- S 瀑布流 -->
<div class="waterfall" v-if="dataLoading || (articles.data && articles.data.length)">
    <div class="waterfall__grid">

        <ul class="waterfall__grid-item" v-for="item of articles.data">
            <li v-if="item.meta_data['activity.brand']" class="waterfall__style1_img">
                <a :href="item.page_url"><img :src="item.cover" alt=""></a>
                <span class="waterfall__style1_small" v-text="item.meta_data['activity.brand']"></span>
            </li>
            <li v-else class="waterfall__style2_img">
                <a :href="item.page_url"><img :src="item.cover" alt=""></a>
            </li>
            <li v-if="item.type == '-1'" class="waterfall__style3_img">
                <a :href="item.page_url"><img :src="item.cover" alt=""></a>
                <dl class="waterfall__style3_info">
                    <dt class="waterfall__style3_namec" v-text="item.title"></dt>
                    <dt class="waterfall__style3_namee" v-text="item.brief"></dt>
                </dl>
            </li>
            <li v-if="item.type == 4 && item.tagTop" class="waterfall__tag-top">
                <el-tag v-for="item of item.tagTop"
                        class="waterfall__tag-top_item" size="small"
                        closable v-text="item.name">
                </el-tag>
            </li>
            <li v-if="item.type == 4 && item.tagBottom" class="waterfall__tag-bottom">
                <el-tag v-for="item of item.tagBottom" class="waterfall__tag-bottom_item"
                        size="small" :style="{color: tagColor[parseInt(Math.random()*tagColor.length)]}"
                        v-text="item.name">
                    <span v-if="item.isHot" class="waterfall__tag-hot"></span>
                </el-tag>
            </li>
            <li v-if="item.title" class="waterfall__style1_title">
                <a :href="item.page_url" v-text="item.title"></a>
            </li>
            <li v-if="item.brief" class="waterfall__style1_content">
                <a :href="item.page_url" v-text="item.brief"></a>
            </li>
            <li v-if="item.published_at" class="waterfall__style1_date" v-text="item.published_at"></li>
        </ul>

    </div>
    <p class="waterfall__loading-more" @click="handleLoadMore" v-show="!dataLoading" v-text="moreMsg"></p>

    <div class="loading" v-show="dataLoading == true"><div class="loading__spiner"></div></div>
</div>
<div v-if="!dataLoading && (!articles.data || !articles.data.length)" class="waterfall-empty">
    暂无数据
</div>
<!-- E 瀑布流 -->
@endsection

@push('before-scripts')
<script src="{{ asset('front/js/vue.min.js') }}"></script>
<script src="{{ asset('front/js/element-ui.js') }}"></script>
@endpush

@section('script')
<script src="{{ asset('front/js/minigrid.js?201811021950') }}"></script>
<script src="{{ asset('front/v3/js/jlhd-index.js?201811031213') }}"></script>
@endsection