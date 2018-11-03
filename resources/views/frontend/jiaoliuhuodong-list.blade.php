@extends ('frontend.layouts.jlhd')

@section('container-class', 'index-list-container')

@section('style')
<link rel="stylesheet" href="{{ asset('front/css/element-ui.css') }}">
<link rel="stylesheet" href="{{ asset('front/v3/css/jlhd-index.css') }}">
@endsection

@section('content')
<!-- S 瀑布流 -->
<div class="waterfall">
    <div class="waterfall__grid">

        <ul class="waterfall__list" v-if="articles.data && articles.data.length" v-for="item of articles.data">
            <li class="waterfall__list-left" v-show="item.cover != null">
                <a :href="item.page_url">
                    <img :src="item.cover" alt="">
                </a>
            </li>
            <li v-if="item.title" class="waterfall__list-right" :style="item.cover == null ? 'width:auto;' : ''">
                <h5 class="waterfall__list-title">
                    <a :href="item.page_url" v-text="item.title"></a>
                </h5>
                <span v-if="item.meta_data['activity.brand']" class="waterfall__list-small" v-text="item.meta_data['activity.brand']"></span>

                <p class="waterfall__list-content">
                    <a :href="item.page_url" v-text="item.brief"></a>
                </p>
                <span class="waterfall__list-date" v-text="item.published_at"></span>
            </li>
            <li v-if="item.type == 4" class="waterfall__list-tag">
                <el-tag v-for="item of item.tagBottom"
                        class="waterfall__tag-bottom_item" size="small"
                        :style="{color: tagColor[parseInt(Math.random()*tagColor.length)]}"
                        v-text="item.name">
                    <span v-if="item.isHot" class="waterfall__tag-hot"></span>
                </el-tag>
            </li>
        </ul>

    </div>
    <p class="waterfall__loading-more" @click="handleLoadMore" v-show="!dataLoading" v-text="moreMsg"></p>
    <div class="loading" v-show="dataLoading == true"><div class="loading__spiner"></div></div>
</div>
<!-- E 瀑布流 -->
@endsection

@push('before-scripts')
<script src="{{ asset('front/js/vue.min.js') }}"></script>
<script src="{{ asset('front/js/element-ui.js') }}"></script>
@endpush

@section('script')
<script src="{{ asset('front/js/minigrid.js?201811021950') }}"></script>
<script src="{{ asset('front/v3/js/jlhd-index-list.js?201811031213') }}"></script>
@endsection