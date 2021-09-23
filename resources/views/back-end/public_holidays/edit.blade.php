@extends('back-end/master')
@section('title',__('item.edit_public_holiday'))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    
@stop
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item"><a href="{{ route('public_holidays') }}">{{ __('item.public_holiday') }}</a></li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.edit_public_holiday') }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4">
          		<h3 class="text-dark mb-4">{{ __('item.edit_public_holiday') }}</h3><hr/>

                {{ Form::model($public_holiday, ['route'=>['public_holiday.edit', 'public_holiday'=>$public_holiday->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <!-- First name -->
                    <div class="col-lg-6 offset-lg-3 form-group d-lg-flex align-items-center{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="control-label col-lg-3 p-0">{{ __('item.title') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="title" class="form-control" value="{{isset($public_holiday->title)?$public_holiday->title:old('title')}}" required autofocus>
                            @if ($errors->has('title'))
    	                        <span class="help-block text-danger">
    	                            <strong>{{ $errors->first('title') }}</strong>
    	                        </span> 
    	                    @endif
                        </div>
                    </div>

                    <div class="col-lg-6 offset-lg-3 form-group d-lg-flex align-items-center{{ $errors->has('date') ? ' has-error' : '' }}">
                        <label for="date" class="control-label col-lg-3 p-0">{{ __('item.date') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            {{ Form::text('date', date('d-m-Y', strtotime($public_holiday->date ?? old('date'))), ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => 'Date', 'required']) }}
                            @if ($errors->has('date'))
    	                        <span class="help-block text-danger">
    	                            <strong>{{ $errors->first('date') }}</strong>
    	                        </span> 
    	                    @endif
                        </div>
                    </div>

                    <div class="col-lg-6 form-group offset-lg-3 d-lg-flex align-items-center{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="control-label col-lg-3 p-0"> {{ __('item.description') }} </label>
                        <div class="col-lg-9 p-0">
                            <textarea rows="3" name="description" class="form-control" >{{$public_holiday->description ?? old('description')}}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Submit Form -->
                    <div class="col-lg-12">
                        <input type="submit" value="{{ __('item.save') }}" name="btnSave" class="btn btn-primary float-right">
                    </div>
                {{Form::close()}}
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
        $(document).ready(function() {
            callFileInput('#profile', 1, 5120, ["jpg" , "jpeg" , "png"]);

            $("#check_sale").click(function() {
                // this function will get executed every time the #home element is clicked (or tab-spacebar changed)
                if($("#check_sale").is(":checked")) // "this" refers to the element that fired the event
                {
                    $("#sale_type").removeAttr('disabled');
                }else{
                    $("#sale_type").val("").trigger("change");
                    $("#sale_type").attr('disabled', 'disabled');
                }
            });

            $('.demoDate').datepicker({
	            format: "dd-mm-yyyy",
	            autoclose: true,
	            todayHighlight: true
	        });

        }); 
    </script>
@stop