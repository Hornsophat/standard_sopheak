@extends('back-end/master')
@section('title',"Deposit Report")
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
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.deposit_report') }}</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body bg-white rounded overflow_hidden p-4">
						<div class="rows">
							<form action="{{ url('deposit_report') }}" method="get" class="form-inline">
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
						</div><br>
						<div class="row">
							<div class="col-sm-12">
								<button class="btn btn-small btn-success pull-right" id="btn_print" type="">{{ __('item.print') }}</button>
							</div>
							
						</div>
						<div id="table_print">
						<div class="text-success display_message text-center"></div><br>
						<div class="row">
							<div class="col-sm-4 col-md-4"><img src="{{Setting::get('LOGO')}}" style="height: 50px;margin-bottom: 20px;"></div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h3>{{ __('item.deposit_report') }}</h3>
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
				                    <th class="text-center">{{ __('item.date') }}</th>
									<th class="text-center">{{ __('item.customer') }}</th>
				                    <th class="text-center">{{ __('item.employee') }}</th>
				                    <th class="text-center">{{ __('item.property') }}</th>
				                    <th class="text-center">{{ __('item.price') }}</th>
				                    <th class="text-center">{{ __('item.discount') }}</th>
				                    <th class="text-center">{{ __('item.commission') }}</th>
				                    <th class="text-center">{{ __('item.deposit') }}</th>
				                    <th class="text-center">{{ __('item.total') }}</th>
				                    <th class="text-center">{{ __('item.item') }}</th>
				                    <th class="text-center">{{ __('item.process') }}</th>
			                  	</tr>
			                </thead>
	                		<tbody>
	                			@foreach ($item as $item)
									@php
										$class ="";
										$percentage = 0;
										$x = $item->payment()->where("status", 2)->sum("amount_to_spend");
										if($x) {
											$total = $item->payment()->sum("amount_to_spend");
											$percentage = ($x*100)/$total;
											$class = "bg-success";
											if($percentage <=30){
												$class ="bg-danger";
											}else if($percentage <=60){
												$class ="bg-warning";
											}
										}
									@endphp
				                	<tr>
					                    <td class="text-center">{{ $loop->iteration }}</td>
					                    <td class="text-center">{{ date("d-M-Y", strtotime($item->sale_date)) }}</td>
										<td class="text-center">{{ $item->soleToCustomer->first_name .' '. $item->soleToCustomer->last_name }}</td>
										<td class="text-center">{{ $item->soldByEmployee->first_name .' '. $item->soldByEmployee->last_name }}</td>
										<td class="text-center">{{ $item->property_names }}</td>
										<td class="text-center">{{ "$ ". number_format($item->deposit + $item->total_price,2) }}</td>
					                    <td class="text-center">{{ "$ ". ($item->total_discount !=null?$item->total_discount:"0.00") }}</td>
					                    <td class="text-center">{{ "$ ". $item->total_sale_commission }}</td>
					                    <td class="text-center">{{ "$ ". $item->deposit }}</td>
					                    <td class="text-center">{{ "$ ". $item->grand_total }}</td>
					                    <td class="text-center">{{ $item->salesDetail()->count() }}</td>
					                    <td class="text-center">{{ number_format($percentage,2) ."%" }}</td>
					                </tr>
				                @endforeach
			                </tbody>
	              		</table>
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