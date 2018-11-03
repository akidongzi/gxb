@extends ('backend.layouts.app')

@section ('title', app_name() . ' |  视频管理')

@section('breadcrumb-links')
    @include('backend.article.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        视频管理
                        <small class="text-muted">视频列表</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.video.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->
            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>标题</th>
                                <th>来源</th>
                                <th>自定义封面</th>
                                <th>编辑</th>
                                <th>排序</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($videos as $v)
                                <tr>
                                    <td>{{ $v->id}}</td>
                                    <td>{{ $v->title}}</td>
                                    <td>{{ $v->source}}</td>
                                    <td>
                                    @if($v->poster)
                                        <img src="{{ $v->poster}}" style="width: 70px;height: 30px;">
                                    @else
                                        <div style="width: 70px;height: 30px; background:#ddd;color:#333;line-height:30px;text-align: center;">暂无</div>
                                    @endif
                                    </td>
                                    <td>{{ $v->editor}}</td>
                                    <td>{{ $v->sort}}</td>
                                    <td>{{ $v->created_at}}</td>
                                    <td>{{ $v->updated_at}}</td>
                                    <td>{!! $v->action_buttons !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {!! $videos->total() !!} 视频总计
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $videos->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
