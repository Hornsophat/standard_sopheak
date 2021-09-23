@extends('back-end/master')
@section('title',"Property Report")
@section('content')
<style type="text/css">
	.width-100 {
		width: 100% !important;
	}
	.m-r-0 {
		margin-right: 0px !important;
	}
	   @media print{
	        .col-sm-6{width: 50%; float: left;}
	        .col-sm-3{width: 25%; float: left;}
	        .col-sm-9{width: 75%; float: left;}
	        .col-md-4{width: 33.333%; float: left;} 
	    }
    }
</style>
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.sale') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.property_report') }}</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body bg-white rounded overflow_hidden p-4">
						<div class="rows">
							<form action="{{ url('property_report') }}" method="get" class="form-inline">
								<div class="col-md-4" style="margin-bottom: 5px;">
									{{ Form::select('land_id', $land->prepend('Select Land',''), $request->land_id, ['class' => 'form-control width-100','id'=>'land_id']) }}
								</div>
								<div class="col-md-4 projects" style="margin-bottom: 5px;">
									{!! Form::select('project_id',$project->prepend('Select Project',''),$request->project_id,['style'=>'width:100%;','class'=>'form-control width-100']) !!}
								</div>
								<div class="col-md-4 zones" style="margin-bottom: 5px;">
									{!! Form::select('zone_id',$zone->prepend('Select Zone',''),$request->zone_id,['style'=>'width:100%;','class'=>'form-control width-100']) !!}
								</div>
								<div class="col-md-12">
									<button class="btn btn-small btn-primary pull-right" type="submit">{{ __('item.filter') }}</button>
								</div>
							</form>
							<br>
							<div class="col-sm-12">
								<button class="btn btn-small btn-success pull-right" id="btn_print" type="">{{ __('item.print') }}</button>
							</div>
						</div><br>
						<div id="table_print">
						<div class="text-success display_message text-center"></div><br>
						<div class="row">
							<div class="col-sm-4 col-md-4"><img src="{{Setting::get('LOGO')}}" style="height: 50px;margin-bottom: 20px;"></div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h3>{{ __('item.property_report') }}</h3>
							</div>
						</div>
						{{-- <div class="row">
								<div class="col-sm-4 col-md-4">
									<p>Customer Name : </p>
								
								</div>
								<div class="col-sm-4 col-md-4"></div>
								<div class="col-sm-4 col-md-4">
									<p>Sale No : 000000</p>
									
								</div>
						</div> --}}
						<br>
						<table class="table table-hover table-bordered">
			                <thead>
			                  	<tr>
				                    <th width="70" class="text-center">{{ __('item.no') }}</th>
				                    <th class="text-center">{{ __('item.property_name') }}</th>
				                    <th class="text-center">{{ __('item.property_no') }}</th>
				                    <th class="text-center">{{ __('item.address_street') }}</th>
									<th class="text-center">{{ __('item.year_of_construction') }}</th>
				                    <th class="text-center">{{ __('item.type') }}</th>
				                    <th class="text-center">{{ __('item.project') }}</th>
				                    <th class="text-center">{{ __('item.zone') }}</th>
				                    <th class="text-center">{{ __('item.status') }}</th>
			                  	</tr>
			                </thead>
	                		<tbody>
	                			@foreach ($item as $key =>$value)
				                	<tr>
					                    <td class="text-center">{{ ++$key }}</td>
					                    <td class="text-center">{{ $value->property_name }}</td>
					                    <td class="text-center">{{ $value->property_no }}</td>
										<td class="text-center">{{ $value->address_street }}</td>
										<td class="text-center">{{ $value->year_of_construction }}</td>
										<td class="text-center">{{ isset($value->propertyType->name) ? $value->propertyType->name : "" }}</td>
										<td class="text-center">{{ !is_null($value->project)?$value->project->property_name:"" }}</td>
										<td class="text-center">{{ !is_null($value->projectZone)?$value->projectZone->name:"" }}</td>
										<td class="text-center">{!! $value->status == 1 ? "Available" : "Sold" !!}</td>
					                </tr>
				               	@endforeach
			                </tbody>
	              		</table>
	              		</div>
						<div class="pull-right">
							{{-- {!! $items->render() !!} --}}
							{{-- <a href="{{ $url_excel ?? '' }}" class="btn btn-success btn-sm" title="Excel"><i class="fa fa-file-excel-o m-r-0"></i></a>
					        <a href="{{ route('report.pdf') }}" class="btn btn-info btn-sm" title="PDF"><i class="fa fa-file-pdf-o m-r-0"></i></a> --}}
						</div>
            		</div>
          		</div>
        	</div>
      	</div>
      	
	</main>
@stop
@section('script')
<script type="text/javascript" src="{{ asset('back-end/js/lib/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('back-end/js/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('back-end/js/lib/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/printThis.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#btn_print').click(function(){
			 $('#table_print').printThis({
                importStyle: true,
                importCSS: true      
            });
		});
        $('.demoDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
    $('#land_id').change(function(){
        	var land_id = $('#land_id :selected').val();
            $.ajax({
                url:"{{route('get_project_by_land')}}",
                type:"get",
                datatype:"json",
                data:{
                    land_id:land_id
                },
                success:function (res) {
                    $('.projects').html(res.project);
                    getzone();
                }
            });
        });
    });
    function getzone(){
    	var project_id = $('#project_id :selected').val();
            $.ajax({
                url:"{{route('get_zone_by_pro')}}",
                type:"get",
                datatype:"json",
                data:{
                    project_id:project_id
                },
                success:function (res) {
                    $('.zones').html(res.zones);
                }
            });
    }
</script>
@stop