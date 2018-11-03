@extends ('backend.layouts.app')

@section ('title',  '位置管理 | 绑定文章')

@section('breadcrumb-links')
    @include('backend.position.includes.breadcrumb-links')
@endsection

@section('content')
    <form action="{{'/admin/positions_saveContent/'.$position->id}}" method="post">

        {{csrf_field()}}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            绑定文章
                            <small class="text-muted">{{$position->name}}</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr/>

                <div class="row mt-4 mb-4">
                    <div class="col">
                        

                        <div class="form-group row">
                            {{ html()->label('位置名称')->class('col-md-2 form-control-label')->for('name') }}

                            <div class="col-md-10">
                               {{ html()->text('name')
                                    ->class('form-control')
                                    ->value($position->name)
                                    ->attribute('maxlength', 125)
                                    ->attribute('readOnly', 'readOnly')
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label('模块名称')->class('col-md-2 form-control-label')->for('block_title') }}

                            <div class="col-md-10">
                               {{ html()->text('block_title')
                                    ->class('form-control')
                                    ->value($position->block['title'])
                                    ->attribute('maxlength', 125)
                                    ->attribute('readOnly', 'readOnly')
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label('绑定文章id')->class('col-md-2 form-control-label')->for('content_ids') }}

                            <div class="col-md-10">
                               {{ html()->text('content_ids')
                                    ->class('form-control')
                                    ->value($position->content_ids)
                                    ->attribute('maxlength', 125)
                                    ->placeholder('多个id请用半角逗号隔开')
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->



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