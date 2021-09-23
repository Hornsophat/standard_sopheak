@extends('back-end/master')
@section('title',"Add Expense Group")
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    
@stop
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.expense_type') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.add_expense_type') }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4">
          		<h3 class="text-dark mb-4">{{ __('item.add_expense_type') }}</h3><hr/>

                <form action="{{ route('expense_group.create') }}" method="POST" class="row form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!-- First name -->
                    <div class="col-lg-6 offset-lg-3 form-group d-lg-flex align-items-center{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label col-lg-3 p-0">{{ __('item.name') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="name" class="form-control" value="{{old('name')}}" required autofocus>
                            @if ($errors->has('name'))
    	                        <span class="help-block text-danger">
    	                            <strong>{{ $errors->first('name') }}</strong>
    	                        </span> 
    	                    @endif
                        </div>
                    </div>

                    <div class="col-lg-6 form-group offset-lg-3 d-lg-flex align-items-center{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="control-label col-lg-3 p-0"> {{ __('item.description') }} </label>
                        <div class="col-lg-9 p-0">
                            <textarea rows="3" name="description" class="form-control" >{{old('description')}}</textarea>
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
                </form>
            </div>
        </div>

	</main>


@stop

@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
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

        }); 
    </script>
@stop