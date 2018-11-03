@extends ('backend.layouts.app')

@section ('title', app_name() . ' | 综合检索')

@section('breadcrumb-links')
    @include('backend.position.includes.breadcrumb-links')
@endsection
@section('styles')
<style type="text/css">
	.dropdownpdown-toggle {
		border: 1px solid #c2cfd6;
	}
</style>
<link rel="stylesheet" type="text/css" href="/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="/vendor/multiselect/css/bootstrap-multiselect.css"/>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
    	<!-- 导航 -->
    	<div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    综合检索
                </h4>
            </div><!--col-->
        </div><!--row-->
        <hr style="margin-bottom:10px;">
        <!-- 搜索 -->
        <div class="row">
            <form class="form-inline">
            	<input type="hidden" value="{{Request::get('tab')}}" name="tab" />
				<div class="form-group mx-sm-3 mb-2">
					<label for="title" class="sr-only">标题</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="请输入标题" value="{{Request::get('title')}}">
				</div>
				<div class="form-group mx-sm-5 mb-2">
					<label for="labels" class="sr-only">标签</label>

					<select id="labels" name="labels[]" class="form-control" multiple="multiple">
						@foreach ($labels as $label)
					    <option value="{{$label->id}}" @if (in_array($label->id, (array)Request::get('labels'))) selected="selected" @endif>{{$label->name}}</option>
					    @endforeach
					</select>
				</div>
				<div class="form-group mx-sm-3 mb-2">
					<label for="date" class="sr-only">创建时间</label>
					<input type="text" class="form-control" id="date" name="date" placeholder="" value="{{Request::get('date')}}" autocomplete="off">
				</div>
				<button type="submit" class="btn btn-primary mb-2">查询</button>
			</form>
        </div><!--row-->
        <ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link  @if (!Request::get('tab') || Request::get('tab') == 'article') active @endif" href="/admin/search?tab=article&{{$params}}">文章</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::get('tab') == 'atlas') active @endif" href="/admin/search?tab=atlas&{{$params}}">图集</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::get('tab') == 'video') active @endif" href="/admin/search?tab=video&{{$params}}">视频</a>
            </li>
        </ul>
        <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>标题</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{!! $item->action_buttons !!}</td>
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
                        {!! $list->total() !!} {{ trans_choice('共计', $list->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $list->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('#stage').change(function () {
        window.location.href='/admin/positions?stage='+$(this).val()
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#labels').multiselect({
            enableFiltering: true,
            filterPlaceholder: '搜索...',
            nonSelectedText: '请选择标签',
            templates: {
            }
        });
    });
    $(function () {
        $( "#date" ).datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
<script src="/vendor/multiselect/js/bootstrap-multiselect.js"></script>
<script src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
@endsection