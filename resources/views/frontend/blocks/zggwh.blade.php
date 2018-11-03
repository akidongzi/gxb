

<!-- S 中国馆文化推荐 -->
<div class="container_right pull-right container_three">
    <ul class="real-time-news__list">
        @foreach($data as $k => $item)
        <li class="real-time-news__item margin-top21 clearfix">
            <span class="real-time-news__number pull-left">1</span>
            <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }} " target="_blank">
                <span class="real-time-news__title-txt pull-right">{{$item->title}}</span>
            </a>
        </li>
        @endforeach
    </ul>
</div>

<!-- E 中国馆文化推荐 -->
