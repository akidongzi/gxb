@extends ('backend.layouts.app')

@section ('title',  '轮播图管理 | 编辑轮播图')

@section('breadcrumb-links')
    @include('backend.banner.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($banner, 'PATCH', route('admin.banners.update', $banner->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        轮播图管理
                        <small class="text-muted">编辑</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('标题')->class('col-md-2 form-control-label')->for('title') }}

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
                        {{ html()->label('轮播图链接')->class('col-md-2 form-control-label')->for('url') }}
                        <div class="col-md-10">
                            {{ html()->text('url')
                                ->class('form-control')
                                ->placeholder('轮播图链接')
                                ->attribute('maxlength', 255)
                                ->attribute('type','url')
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    {{--缩略图--}}
                    
                    <div class="form-group row">
                        {{ html()->label('缩略图')->class('col-md-2 form-control-label')->for('banner') }}
                        <div class="col-md-9 col-sm-9 col-xs-12">     
                            <div class="produtPic" id="J_pruductPic">
                                <input name="file" type="file" class="form-control J_uploadFile" default-val="
                                {{$banner->file}}"/>
                            </div>
        
                        </div>
                    </div>

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
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.banners.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
<div id="zxzApp"></div>

@endsection
@section('scripts')
    <script type="text/javascript">
        window.zxzIsGood = function(data, field){
            if (data.StatusCode===200){
                $('#banner_up-img').attr('src',data.ResultData);
                $('#banner_up').val(data.ResultData);
                $('.vicp-icon4').trigger('click');
            }else{
                alert(data.ResultData);
            }
        }
        $(function () {
            $("#J_pruductPic").dccUploadFiles({
                width:350,
                height:200,
                max:1,//最多上传图片数量，默认上限20
                uploadUrl:"/admin/uploadBanner",
            });
        });
    </script>

    <script src="/js/upload.js"></script>
    <script src="/crop.min.js"></script>
@endsection