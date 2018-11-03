@extends ('backend.layouts.app')

@section ('title',  '文章管理 | 添加文章')

@section('breadcrumb-links')
    @include('backend.article.includes.breadcrumb-links')
@endsection
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/app.css') }}" />
    <link rel="stylesheet" type="text/css" href="/admin_crop.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/components/chosen/chosen.min.css') }}" />
    <style type="text/css">
        /*.edui-default .edui-editor {*/
        .edui-default .edui-editor-iframeholder {
            background-image: url(/img/backend/col-dot.png);
            background-position-x: 765px;
            background-repeat: repeat-y;
        }

        .edui-default .edui-editor {
            background-image: url(/img/backend/col-dot.png);
            background-repeat: repeat-y;
            background-position-x: calc(50% + 385px);
        }
    </style>
@endsection

@section('content')
    @include('vendor.ueditor.assets')

    {{ html()->form('POST', route('admin.articles.store'))->class('form')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        文章管理
                        <small class="text-muted">新建文章</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr/>

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group">
                        {{ html()->label('标题')->class('form-control-label')->for('title') }}

                        {{ html()->text('title')
                            ->class('form-control')
                            ->placeholder('标题')
                            ->attribute('maxlength', 125)
                            ->attribute('autocomplete', 'off')
                            ->required()
                            ->autofocus() }}
                    </div><!--form-group-->

                    <div class="row">
                        <div class="col-xl-6">

                            <div class="form-group">
                                {{ html()->label('简述(最多255字)')->class('form-control-label')->for('brief') }}

                                {{ html()->textarea('brief')
                                    ->class('form-control')
                                    ->placeholder('简述')
                                    ->style('height:100px;')
                                    ->attribute('maxlength', 255)
                                    ->required()
                                    ->autofocus() }}
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    {{ html()->label('缩略图')->class('col form-control-label')->for('banner') }}
                                    <div class="col-md-12">
                                        <div class="produtPic" id="J_pruductPic">
                                            <input name="pics" type="file" class="form-control J_uploadFile" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    {{ html()->label('编辑')->class('form-control-label')->for('author') }}
                                    {{ html()->text('author')
                                        ->class('form-control')
                                        ->placeholder('编辑')
                                        ->attribute('maxlength', 64)
                                        ->autofocus() }}
                                </div>

                                <div class="col-md-6">
                                    {{ html()->label('来源')->class('form-control-label')->for('source') }}

                                    {{ html()->text('source')
                                        ->class('form-control')
                                        ->placeholder('来源名称')
                                        ->attribute('maxlength', 32)
                                        ->autofocus() }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ html()->label('文章链接')->class('form-control-label')->for('url') }}
                                {{ html()->text('url')
                                    ->class('form-control')
                                    ->placeholder('来源链接')
                                    ->attribute('maxlength', 255)
                                    ->attribute('type','url')
                                    ->autofocus() }}
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    {{ html()->label('排序')->class('form-control-label')->for('sort') }}

                                    {{ html()->text('sort')
                                        ->class('form-control')
                                        ->value(0)
                                        ->attribute('type','number')
                                        ->autofocus() }}
                                </div>

                                <div class="col-md-6">
                                    {{ html()->label('自定义热度')->class('form-control-label')->for('fake_pv') }}

                                    {{ html()->text('fake_pv')
                                        ->class('form-control')
                                        ->value(0)
                                        ->attribute('type','number')
                                        ->autofocus() }}
                                </div>

                            </div><!--form-group-->
                        </div>

                        <div class="col-xl-6">
                            <div class="row">
                                <fieldset class="form-group col-lg-12 meta-info" style="padding-bottom:10px;">
                                    <div class="form-control-label row">
                                        <div class="col-lg-5">
                                            <div style="height:1px; background:#ccc; width:100%;margin-top:10px;">&nbsp;</div>
                                        </div>
                                        <div class="col-lg-2 text-center">
                                            <span class="badge-pill badge-primary">元信息</span>
                                        </div>
                                        <div class="col-lg-5">
                                            <div style="height:1px; background:#ccc; width:100%;margin-top:10px;">&nbsp;</div>
                                        </div>


                                    </div>

                                    @include('backend.includes.article-meta-editor')

                                </fieldset>
                            </div><!--form-group-->
                        </div>
                    </div>

                    <div class="form-group alert alert-info col-xs-12">
                        <label class="form-control-label">标签</label>

                        @include('backend.includes.tag-input', ['labels' => $labels])
                    </div>

                    <div class="form-group">
                        {{ html()->label('内容')->class('form-control-label')->for('content') }}

                        {{ html()->textarea('content')
                            ->placeholder('内容')
                            ->attribute('id','content')
                            ->style(['height'=>'300px'])
                            ->autofocus() }}
                    </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer clearfix">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.articles.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
    <div id="zxzApp"></div>
    
@endsection
@section('scripts')
    <script type="text/javascript">
        var ue = UE.getEditor('content', {});
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        window.zxzIsGood = function (data, field) {
            if (data.StatusCode === 200) {
                $('#banner_up-img').attr('src', data.ResultData);
                $('#banner_up').val(data.ResultData);
                $('.vicp-icon4').trigger('click');
            } else {
                alert(data.ResultData);
            }
        }

        $(function () {
            $("#J_pruductPic").dccUploadFiles({
                width:100,
                height:100,
                max:3,//最多上传图片数量，默认上限20
                uploadUrl:"/admin/uploadBanner",
                // delUrl:"/Upload/deleteAjax",//不进行服务器端物理删除则可以不写
            });
        });
    </script>
    <script src="/js/upload.js"></script>
    <script src="/crop.min.js"></script>
    <script src="{{ asset('backend/components/chosen/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/js/article-meta-editor.js') }}"></script>
@endsection