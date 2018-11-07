@extends ('backend.layouts.app')

@section ('title', '位置管理 | 修改位置')

@section('breadcrumb-links')
    @include('backend.position.includes.breadcrumb-links')
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
@endsection

@section('content')
{{ html()->modelForm($position, 'PATCH', route('admin.positions.update', $position->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        位置管理
                        <small class="text-muted">修改位置</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col-md-3">
                    <div class="form-group">
                        {{ html()->label('位置名')->class('form-control-label')->for('name') }}

                        {{ html()->text('name')
                            ->class('form-control')
                            ->placeholder('位置名')
                            ->attribute('maxlength', 64)
                            ->required()
                            ->autofocus() }}
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ html()->label('编码')->class('form-control-label')->for('code') }}

                        {{ html()->text('code')
                            ->class('form-control')
                            ->placeholder('请输入编码')
                            ->attribute('maxlength', 64)
                            ->disabled()
                            ->required()
                            ->autofocus() }}
                    </div><!--form-group-->


                    <div class="form-group">
                        {{ html()->label('模块')->class('form-control-label')->for('block_id') }}
                        <select name="block_id" class="form-control">
                            <option value="">无</option>
                            @foreach ($blocks as $block)
                                <option @if($block->id=== $position->block_id) selected @endif value="{{ $block->id }}">{{ $block->title }}</option>
                            @endforeach
                        </select>
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ html()->label('级别')->class('form-control-label')->for('stage') }}
                        <select name="stage" class="form-control" required="required">
                            <option @if($position->stage == 1) selected @endif value="1">一级</option>
                            <option @if($position->stage == 2) selected @endif value="2">二级</option>
                        </select>
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ html()->label('所属一级')->class('form-control-label')->for('parent_id') }}

                        <select name="parent_id" class="form-control">
                            <option value="">无</option>
                            @foreach ($parents as $parent)
                                <option @if($parent->id=== $position->parent_id) selected @endif value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ html()->label('是否导航展示')->class('form-control-label')->for('nav_show') }}
                        <label class="switch switch-3d switch-primary">
                            <input class="switch-input" type="checkbox" name="nav_show" id="nav_show" value="1" @if($position->nav_show===1) checked @endif>
                            <span class="switch-label"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ html()->label('排序')->class('form-control-label')->for('sort') }}

                        {{ html()->text('sort')
                            ->class('form-control')
                            ->placeholder('排序')
                            ->attribute('type','number')
                            ->autofocus() }}
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ html()->label('手机排序')->class('form-control-label')->for('msort') }}

                        {{ html()->text('msort')
                            ->class('form-control')
                            ->placeholder('排序')
                            ->attribute('type','number')
                            ->autofocus() }}
                    </div><!--form-group-->
                </div>

                <div class="col-md-5">
                    <label class="form-control-label">自定义数据</label>

                    <div class="alert alert-info">
                        <!-- Position image data -->
                        <div class="pos-img-list">
                            <label class="form-control-label">图片</label>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="form-group">
                            <a href="javascript:;" class="btn btn-add-pos-img btn-block btn-outline-info">添加图片数据</a>
                        </div>
                        <!-- End of Position image data -->

                        <div class="clearfix">&nbsp;</div>

                        <!-- Position text data -->
                        <div class="pos-txt-list">
                            <label class="form-control-label">文本</label>

                        </div>
                        <div class="form-group">
                            <a href="javascript:;" class="btn btn-add-pos-txt btn-block btn-outline-info">添加文本数据</a>
                        </div>
                        <!-- End of Position text data -->

                    </div>

                </div>

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
{{ html()->closeModelForm() }}
@endsection

@section('scripts')
<script src="{{ asset('js/upload.js') }}"></script>
<script src="{{ asset('backend/js/position.js') }}"></script>
<script type="text/javascript">
var posExtData = {};
@if(! empty($ext_data['txt']))
posExtData.txt = {!! json_encode($ext_data['txt']) !!};
@endif

@if(! empty($ext_data['img']))
posExtData.img = {!! json_encode($ext_data['img']) !!};
@endif

$(function () {
    if (posExtData.txt) {
        for (var k in posExtData.txt) {
            addPosTxtItem(k, posExtData.txt[k]);
        }
    }

    if (posExtData.img) {
        for (var k in posExtData.img) {
            addPosImgItem(k, posExtData.img[k]);
        }
    }
});
</script>
@endsection
