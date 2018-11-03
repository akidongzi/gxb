@extends ('backend.layouts.app')

@section ('title', app_name() . ' | 模块管理')

@section('breadcrumb-links')
    @include('backend.position.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        模块管理
                        <small class="text-muted">模块列表</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.block.includes.header-buttons')
                </div><!--col-->
                <div class="col-sm-3">
                    <!-- <select id="stage" class="form-control input-sm">
                        <option value="">全部级别</option>
                        <option value="1" @if(!empty(Request::get('stage'))&&Request::get('stage')==1)selected @endif>一级</option>
                        <option value="2" @if(!empty(Request::get('stage'))&&Request::get('stage')==2)selected @endif>二级</option>
                    </select> -->
                </div>

            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>模块名称</th>
                                <th>模版路径</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($blocks as $block)
                                <tr>
                                    <th>{{ $block->id }}</th>
                                    <th>{{ $block->title }}</th>
                                    <th>{{ $block->tpl }}</th>
                                    <th>{{ $block->created_at}}</th>
                                    <td>{!! $block->action_buttons !!}</td>
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
                        {!! $blocks->total() !!} {{ trans_choice('位置共计', $blocks->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $blocks->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
@section('scripts')
@endsection