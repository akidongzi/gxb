<div class="focus-month">
    <!-- 精彩推荐列表 -->
    @foreach($data as $k => $item)
    <ul class="recommend">
        <li class="recommend__img">
            <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}" target="_blank">
            <img src="{{ img_resize($item->banner_url, 280, 192) }}" alt="" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
            </a>
        </li>
        {{--<a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}" target="_blank">--}}
            {{--<li class="recommend__text ellipsis">{{$item->title}}</li>--}}
        {{--</a>--}}
    </ul>
    @endforeach

</div>
