@extends('back-end/master')
@section('title',"Sale Details")
@section('content')

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.config') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">
                <h3 class="text-danger">{{ __('item.settings') }}</h3><hr>
                <div class="rows">
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                    {{ Form::open(["url" => url('setting/save'), "method" => 'POST', "class" => "", 'id' => 'form-setting', 'files' => true]) }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('site_name', trans('item.site_name')) !!}
                                    {{ Form::text('site_name', Setting::get('SITE_NAME', trans('item.site_name')), ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('contact_phone', trans('item.contact_phone')) !!}
                                    {{ Form::text('contact_phone', Setting::get('CONTACT_PHONE', trans('item.contact_phone')), ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('site_comment', trans('item.site_comment')) !!}
                                    {{ Form::textarea('site_comment', Setting::get('SITE_COMMENT', trans('item.site_comment')), ['class' => 'form-control', 'rows' => 3]) }}
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('site_address', trans('item.site_address')) !!}
                                    {{ Form::textarea('site_address', Setting::get('SITE_ADDRESS', trans('item.site_address')), ['class' => 'form-control', 'rows' => 3]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 form-group align-items-center">
                                <label for="avatar" class="control-label">{{ __('item.logo') }} </label><br/>
                                <div class="">
                                    <input id="avatar" type="file" name="logo" class="form-control" value="" accept=".jpg,.jpeg,.png">
                                </div>
                                <img src="{{Setting::get('LOGO')}}" width="100">
                            </div>

                            <div class="col-lg-6 form-group align-items-center">
                                <label for="avatar" class="control-label">{{ __('item.icon') }} </label><br/>
                                <div class="">
                                    <input id="avatar" type="file" name="icon" class="form-control" value="" accept=".jpg,.jpeg,.png">
                                </div>
                                <img src="{{Setting::get('ICON')}}" width="100">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'submit-button')) !!}
                            <div class="clearfix">&nbsp;</div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </main>


    @endsection