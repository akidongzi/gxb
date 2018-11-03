@extends ('backend.layouts.app')

@section ('title', '模块管理 | 修改位置')

@section('breadcrumb-links')
    @include('backend.block.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($block, 'PATCH', route('admin.blocks.update', $block->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        模块管理
                        <small class="text-muted">修改模块</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('模块名称')->class('col-md-2 form-control-label')->for('title') }}

                        <div class="col-md-10">
                            {{ html()->text('title')
                                ->class('form-control')
                                ->placeholder('请输入模块名称')
                                ->attribute('maxlength', 64)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                            {{ html()->label('编码')->class('col-md-2 form-control-label')->for('code') }}
                            <div class="col-md-10">
                                {{ html()->text('code')
                                    ->class('form-control')
                                    ->placeholder('请输入编码')
                                    ->attribute('maxlength', 64)
                                    ->attribute('readOnly', 'readOnly')
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label('模板路径')->class('col-md-2 form-control-label')->for('tpl') }}
                            <div class="col-md-10">
                                {{ html()->text('tpl')
                                    ->class('form-control')
                                    ->placeholder('请输入模板路径')
                                    ->attribute('maxlength', 64)
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label('描述')->class('col-md-2 form-control-label')->for('desc') }}
                            <div class="col-md-10">
                                {{ html()->textarea('desc')
                                    ->class('form-control')
                                    ->placeholder('请输入模块描述')
                                    ->attribute('maxlength', 255)
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.blocks.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection
