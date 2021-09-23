@extends('back-end/master')
@section('title',__('item.edit_commune'))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    
@stop
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-cog fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.address') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('setting.address.province.index') }}">{{ __('item.list_province') }}</a></li>
                @if(App::getLocale()=='en')
                    <li class="breadcrumb-item active"><a href="{{ route('setting.address.district.index', array('province_id' => $province->province_id)) }}">{{ $province->province_en_name }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('setting.address.commune.index', array('district_id' => $district->dis_id)) }}">{{ $district->district_name }}</a></li>
                @else
                    <li class="breadcrumb-item active"><a href="{{ route('setting.address.district.index', array('province_id' => $province->province_id)) }}">{{ $province->province_kh_name }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('setting.address.commune.index', array('district_id' => $district->dis_id)) }}">{{ $district->district_namekh }}</a></li>
                @endif
                <li class="breadcrumb-item active"><a href="{{ route('setting.address.commune.edit', array('id' => $commune->com_id)) }}">{{ __('item.edit_commune') }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4">
          		<h3 class="text-dark mb-4">{{ __('item.edit_district') }}</h3><hr/>
                {!! Form::model($commune,array('url' => route('setting.address.commune.update',array('id'=>$commune->com_id)), 'method'=>'POST', 'enctype' => 'multipart/form-data', 'class' => 'row form-horizontal')) !!}
                    <div class="col-lg-6 offset-lg-3 form-group d-lg-flex align-items-center{{ $errors->has('district_id') ? ' has-error' : '' }}">
                        <label for="district_id" class="control-label col-lg-3 p-0">{{ __('item.district') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            {!! Form::select('district_id', $districts, $commune->district_id, array('class'=>'form-control', 'id'=>'district_id', 'required', 'autofocus')) !!}
                            @if ($errors->has('district_id'))
    	                        <span class="help-block text-danger">
    	                            <strong>{{ $errors->first('district_id') }}</strong>
    	                        </span> 
    	                    @endif
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-3 form-group d-lg-flex align-items-center{{ $errors->has('commune_namekh') ? ' has-error' : '' }}">
                        <label for="commune_namekh" class="control-label col-lg-3 p-0">{{ __('item.name_khmer') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            {!! Form::text('commune_namekh', null, array('class'=>'form-control', 'required', 'autofocus')) !!}
                            @if ($errors->has('commune_namekh'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('commune_namekh') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-3 form-group d-lg-flex align-items-center{{ $errors->has('commune_name') ? ' has-error' : '' }}">
                        <label for="commune_name" class="control-label col-lg-3 p-0">{{ __('item.name_english') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            {!! Form::text('commune_name', null, array('class'=>'form-control', 'required')) !!}
                            @if ($errors->has('commune_name'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('commune_name') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Submit Form -->
                    <div class="col-lg-12">
                        {!! Form::submit(__('item.save'), array('class' => 'btn btn-primary float-right')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

	</main>


@stop

@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>

    <script type="text/javascript" src="{{ asset('back-end/js/lib/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('back-end/js/lib/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('back-end/js/lib/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script type="text/javascript">
        $('#district_id').select2()
    </script>
@stop