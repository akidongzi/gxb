@extends ('backend.layouts.app')

@section ('title',  '视频管理 | 编辑视频')

@section('breadcrumb-links')
    @include('backend.video.includes.breadcrumb-links')
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/admin_crop.min.css"/>
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

    form video {
        width:100%;
        max-width:500px;
    }
</style>
@endsection

@section('content')
    @include('vendor.ueditor.assets')

    {{ html()->modelForm($video, 'PATCH', route('admin.videos.update', $video->id))->attribute('enctype', 'multipart/form-data')->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        视频管理
                        <small class="text-muted">编辑视频</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('标题* ')->class('col-md-2 form-control-label')->for('title') }}

                        <div class="col-md-10">
                            {{ html()->text('title')
                                ->class('form-control')
                                ->placeholder('标题')
                                ->attribute('maxlength', 125)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('来源')->class('col-md-2 form-control-label')->for('source') }}

                        <div class="col-md-10">
                            {{ html()->text('source')
                                ->class('form-control')
                                ->placeholder('来源')
                                ->attribute('maxlength', 32)
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('编辑 *')->class('col-md-2 form-control-label')->for('editor') }}

                        <div class="col-md-10">
                            {{ html()->text('editor')
                                ->class('form-control')
                                ->placeholder('编辑')
                                ->attribute('maxlength', 64)
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->


                    {{--缩略图--}}
                    <div class="form-group row">
                        {{ html()->label('自定义封面')->class('col-md-2 form-control-label')->for('poster') }}

                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <a href="javascript:void(0);" id="banner">
                                <img id="banner_up-img" src="{{$video->poster??'/upLoad.jpg'}}" onerror='this.src="/upLoad.jpg"'/>
                            </a>
                            <a href="javascript:;" class="close" id="remove-poster" style="float:none; @if(! $video->poster) display:none; @endif">&times;</a>
                        </div>
                        <input required type="hidden" name="poster" value="{{$video->poster}}"
                               id="banner_up">
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('视频 *')->class('col-md-2 form-control-label')->for('video') }}

                        <div class="col-md-10">
                            <video src="{{ $video->file_url }}" controls="true"></video>
                            {{ html()->file('video')
                                ->class('form-control') }}
                        </div><!--col-->
                    </div><!--form-group-->


                    <div class="form-group row">
                        {{ html()->label('排序')->class('col-md-2 form-control-label')->for('sort') }}

                        <div class="col-md-10">
                            {{ html()->text('sort')
                                ->class('form-control')
                                ->placeholder('排序')
                                ->attribute('type','number')
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">标签 *</label>

                        <div class="table-responsive col-md-10">
                            <div class="form-group row">
                                @foreach($labels as $k=>$label)
                                    <div class="checkbox col-md-2">
                                        <label class="switch switch-sm switch-3d switch-primary"
                                               for="permission-{{$k}}"><input
                                                    class="switch-input" type="checkbox" @if(in_array($label->id,$video->labels->pluck('id')->toArray())) checked @endif name="labels[]"
                                                    id="permission-{{$k}}" value="{{$label->id}}"><span
                                                    class="switch-label"></span><span
                                                    class="switch-handle"></span></label>
                                        <label for="permission-1">{{$label->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div><!--col-->
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.videos.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
<div id="zxzApp"></div>
{{--缩略图--}}
<div id="banner_up_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close-model" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">上传自定义封面</h4>
            </div>
            <div class="modal-body">
                <div class="container_crop">
                    <div class="imageBox">
                        <div class="thumbBox"></div>
                        <div class="spinner" style="display: none"><span class="font-18" style="">Loading...</span>
                        </div>
                    </div>
                    <div class="action">
                        <!-- <input type="file" id="file" style=" width: 200px">-->
                        <div class="new-contentarea tc">
                            <a href="javascript:void(0)" class="upload-img"> <label
                                        for="upload-file">选择图像</label>
                            </a> <input type="file" class="" name="upload-file" id="upload-file"/>
                        </div>
                        <input type="button" id="btnCrop" class="Btnsty_peyton" value="裁切">
                        <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+">
                        <input type="button" id="btnZoomOut" class="Btnsty_peyton"
                               value="-">
                    </div>
                    {{--<div class="cropped"></div>--}}
                </div>
                <div class="view-mail">
                    <br>
                    <p id="show-content"></p>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('scripts')
    <script type="text/javascript">
        window.zxzIsGood = function(data, field){
            if (data.StatusCode===200){
                $('#banner_up-img').attr('src',data.ResultData);
                $('#banner_up').val(data.ResultData);
                $('.vicp-icon4').trigger('click');

                $('#remove-poster').show();
            }else{
                alert(data.ResultData);
            }
        }

        $('#remove-poster').on('click', function () {
            $('#banner_up-img').attr('src', '/upload.jpg');
            $('#banner_up').val('');
            $(this).hide();
        });
    </script>

    <script src="/crop.min.js"></script>
@endsection