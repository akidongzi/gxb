@extends ('backend.layouts.app')

@section ('title',  '位置管理 | 绑定标签')

@section('breadcrumb-links')
    @include('backend.position.includes.breadcrumb-links')
@endsection

@section('content')
    <form action="{{'/admin/positions_saveLabels/'.$position->id}}" method="post">

        {{csrf_field()}}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            绑定标签
                            <small class="text-muted">{{$position->name}}</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr/>

                <div class="row mt-4 mb-4">
                    <div class="col">
                        

                        <div class="form-group row">
                            {{ html()->label('排序依据')->class('col-md-2 form-control-label')->for('sort_type') }}

                            <div class="col-md-10">
                                <select name="sort_type" class="form-control">
                                    @foreach(\App\Models\Position::$sortTypes as $sortType => $sortTypeInfo)
                                    <option @if($sortType == $position->sort_type) selected @endif value="{{ $sortType }}">{{ $sortTypeInfo['name'] }}</option>
                                    @endforeach
                                </select>
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label('排序方向')->class('col-md-2 form-control-label')->for('sort_dir') }}

                            <div class="col-md-10">
                                <select name="sort_dir" class="form-control">
                                    @foreach(\App\Models\Position::$sortDirections as $sortDir => $sortDirName)
                                    <option @if($sortDir == $position->sort_dir) selected @endif value="{{ $sortDir }}">{{ $sortDirName }}</option>
                                    @endforeach
                                </select>
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label('显示数量')->class('col-md-2 form-control-label')->for('num_show') }}

                            <div class="col-md-10">
                                {{ html()->text('num_show')
                                    ->class('form-control')
                                    ->value($position->num_show)
                                    ->placeholder('0不限制')
                                    ->attribute('maxlength', 125)
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label">标签</label>

                            <div class="table-responsive col-md-10">
                                <div class="form-group row">
                                    @foreach($labels as $k=>$label)
                                        <div class="checkbox col-md-2">
                                            <label class="switch switch-sm switch-3d switch-primary"
                                                   for="permission-{{$k}}"><input
                                                        class="switch-input" type="checkbox"
                                                        @if(in_array($label->id,$myLabels)) checked @endif name="labels[]"
                                                        id="permission-{{$k}}" value="{{$label->id}}"><span
                                                        class="switch-label"></span><span
                                                        class="switch-handle"></span></label>
                                            <label for="permission-1">{{$label->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div><!--col-->
                        </div>
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.positions.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
        </div><!--card-->
    </form>
@endsection