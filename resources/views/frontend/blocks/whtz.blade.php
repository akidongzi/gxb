<div class="focus-month">
    <h5 class="focus-month_title">文化<span class="text-color-red">投资</span></h5>
    <p class="focus-month_title-line pull-center"></p>
    <!-- 文化投资列表 -->
    <ul class="real-time-news__list">
        @foreach($data as $k => $item)
        <li class="real-time-news__item clearfix">
            <span class="real-time-news__number pull-left">{{$k}}</span>
            <a target="_blank" href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}"><span class="real-time-news__title-txt pull-right">{{$item->title}}...</span></a>
        </li>
        @endforeach

    </ul>
</div>
