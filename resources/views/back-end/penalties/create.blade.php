@extends('back-end/master')
@section('title',__('item.add_penalty'))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    
@stop
@section('content')
<style>
    .item-td-input{
        width: 60px;
    }
</style>
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item"><a href="{{ route('penalties') }}">{{ __('item.penalty') }}</a></li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.add_penalty') }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4">
          		<h3 class="text-dark mb-4">{{ __('item.add_penalty') }}</h3><hr/>

                <form action="{{ route('penalty.create') }}" method="POST" class="row form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!-- First name -->
                    <div class="col-lg-6 offset-lg-3 form-group d-lg-flex align-items-center{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="control-label col-lg-3 p-0">{{ __('item.title') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="title" class="form-control" value="{{old('title')}}" required autofocus>
                            @if ($errors->has('title'))
    	                        <span class="help-block text-danger">
    	                            <strong>{{ $errors->first('title') }}</strong>
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
                    <div class="col-lg-6 col-md-12 offset-lg-3">
                        <div class="table-responsive">
                            <table class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                    <th>{{__('item.no')}}</th>
                                    <th>Percent(%)</th>
                                    <th>Min Day</th>
                                    <th>Max Day</th>
                                    <th>Description</th>
                                    <th><button type="button" class="btn btn-sm btn-success" id="addRow"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody id="tBodyContent">
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="item-td-input" name="percent[]" required value></td>
                                        <td><input type="text" class="item-td-input" name="min_day[]" required value></td>
                                        <td><input type="text" class="item-td-input" name="max_day[]" value></td>
                                        <td><input type="text" name='item_description[]' value></td>
                                        <td><button type="button" class="btn btn-sm btn-danger item-row"><i class="fa fa-close"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
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

    <script type="text/javascript" src="{{ asset('back-end/js/lib/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('back-end/js/lib/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('back-end/js/lib/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script type="text/javascript">
        $(document).on('click','#addRow',function(){
            var index = $("#tBodyContent tr").length+1;
            var tr ='<tr>';
                tr +='<td>'+index+'</td>';
                tr +='<td><input type="text" class="item-td-input" name="percent[]" required value></td>';
                tr +='<td><input type="text" class="item-td-input" name="min_day[]" required value></td>';
                tr +='<td><input type="text" class="item-td-input" name="max_day[]" value></td>';
                tr +='<td><input type="text" name="item_description[]" value></td>';
                tr +='<td><button type="button" class="btn btn-sm btn-danger item-row"><i class="fa fa-close"></i></button></td>';
                tr +='</tr>';
            $('#tBodyContent').append(tr)
        });
        $(document).on('click','.item-row',function(){
            $(this).parents('tr').remove()
        });
    </script>
@stop

