

<!-- S 实时要闻 -->
<div class="real-time-news">
    <div class="real-time-news__bar"></div>
    <h4 class="real-time-news__title">{{ $title }}</h4>
    <!-- 实时要闻列表 -->
    <ul class="real-time-news__list">
        @foreach($data as $k => $item)
        <li class="real-time-news__item clearfix">
            <span class="real-time-news__number pull-left">{{$k+1}}</span>
            <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}" target="_blank"><span class="real-time-news__title-txt pull-right">{{$item->title}}</span></a>
            <div class="real-time-news__content pull-left">
                {{ mb_substr($item->brief, 0, 53, 'utf-8') }}...
            </div>
        </li>
        @endforeach
    
    </ul>
</div>
<!-- E 实时要闻 -->
