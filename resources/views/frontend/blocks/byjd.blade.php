<div class="focus-month">
    <h5 class="focus-month_title">本月<span class="text-color-red">焦点</span></h5>
    <p class="focus-month_title-line pull-center"></p>

    @foreach($data as $k => $item)
    <div class="focus-month_imgwrap">
        <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}" target="_blank">
        <img src="{{ img_resize($item->banner_url, 280, 192) }}" alt="{{$item->title}}" onerror="javascript:this.src='https://cici-images.oss-cn-beijing.aliyuncs.com/201810/06/contactus-bg.png'">
        </a>
    </div>
    <a href="{{ route('frontend.articles.show', ['article' => $item->id, 'position_id' => $position->id]) }}" target="_blank">
        <p class="focus-month_content">
            {{$item->title}}
        </p>
    </a>
    @endforeach
</div>
