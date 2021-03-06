@extends ('backend.layouts.app')

@section ('title', app_name() . ' | 文章管理')

@section('breadcrumb-links')
    @include('backend.article.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        文章管理
                        <small class="text-muted">文章列表</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.article.includes.header-buttons')
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
                                <th>缩略图</th>
                                <!-- <th width="200px;">简述</th> -->
                                <th width="120px;">作者</th>
                                <th>来源</th>
                                <th width="100px;">页面展现</th>
                                <th width="170px">创建时间</th>
                                <!-- <th>上次更新时间</th> -->
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td>{{ $article->id}}</td>
                                    <td>{{ $article->title}}</td>
                                    <td>
                                        <img src="{{ img_resize($article->banner_url) }}" style="width: 70px;height: 70px;">
                                    </td>
                                    <!-- <td title="{{$article->brief}}">{{str_limit($article->brief,10,'...')}}</td> -->
                                    <td>{{ $article->author}}</td>
                                    <td>{{ $article->source}}</td>
                                    <td>{{ $article->pv}}</td>
                                    <td>{{ $article->created_at}}</td>
                                    <!-- <td>{{ $article->updated_at}}</td> -->
                                    <td>{!! $article->action_buttons !!}</td>
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
                        {!! $articles->total() !!} 文章总计
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $articles->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
