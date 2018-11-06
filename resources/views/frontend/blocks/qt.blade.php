<!-- S 其他 -->
<div class="focus-month">
    <h5 class="focus-month_title">其他</h5>
    <p class="focus-month_title-line pull-center"></p>
    <!-- 文化投资列表 -->
    <ul class="real-time-news__list">
        @foreach($data as $k => $item)
        <li class="real-time-news__item margin-top21 clearfix">
            <span class="real-time-news__number pull-left">{{$k+1}}</span>
            <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}" target="_blank"><span class="real-time-news__title-txt pull-right">{{$item->title}}</span></a>
        </li>
        @endforeach
    </ul>
    {{--<p class="link"><a href="">查看更多 &gt;</a></p>--}}
</div>
<!-- E 其他 -->