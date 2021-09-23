@extends('back-end/master')
@section('title',"Sale Report")
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
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.sale_report') }}</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body bg-white rounded overflow_hidden p-4">
						<div class="rows">
							<form action="{{ url('sale_report') }}" method="get" class="form-inline" id="frmSubmit">
								<div class="col-md-3">
									{{ Form::text('start_date', $start_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => Lang::get('item.start_date')]) }}
								</div>
								<div class="col-md-3">
									{{ Form::text('end_date', $end_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => Lang::get('item.end_date')]) }}
								</div>
								<div class="col-md-3">
									<select class="form-control width-100" name="filter_status" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="sold" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 'sold'?"selected":"" }}>Sold</option>
										<option value="completed" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 'completed'?"selected":"" }}>Completed</option>
										<option value="cancel" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 'cancel'?"selected":"" }}>Cancel</option>
									</select>
								</div>
								<div class="col-md-3">
									{{ Form::select('project', $projects,$request->project,['class' => 'form-control width-100']) }}
								</div>
								<div class="col-md-12">
									{{Form::hidden('between_date',null,['id'=>'between_date'])}}
									<a href="#" id="btnToday" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> Today</a>
									<a href="#" id="btnYesterday" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> Yesterday</a>
									<a href="#" id="btnThisWeek" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> This Week</a>
									<a href="#" id="btnLastWeek" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> Last Week</a>
									<a href="#" id="btnThisMonth" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> This Month</a>
									<a href="#" id="btnLastMonth" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> Last Month</a>
									<a href="#" id="btnThisYear" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> This Year</a>
									<a href="#" id="btnLastYear" class="btn btn-sm rounded p-1 btn-outline-dark mt-1"><i class="fa fa-calendar-o"></i> Last Year</a>
									<a href="#" onclick="$('#frmSubmit').submit()" class="btn btn-sm rounded p-1 btn-primary mt-1 pull-right"><i class="fa fa-search"></i> Filter</a>
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
								<h3 style="text-transform: uppercase;">{{ __('item.sale_report') }}</h3>
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
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
				                <thead>
				                  	<tr>
					                    <th width="70" class="text-center">{{ __('item.no') }}</th>
					                    <th class="text-center">{{ __('item.sale_date') }}</th>
					                    <th class="text-center">{{ __('item.property_no') }}</th>
					                    <th class="text-center">{{ __('item.property_name') }}</th>
					                    <th class="text-center">{{ __('item.project_name') }}</th>
										<th class="text-center">{{ __('item.customer') }}</th>
					                    <th class="text-center">{{ __('item.total_item') }}</th>
					                    <th class="text-center">{{ __('item.price') }}</th>
					                    <th class="text-center">{{ __('item.discount') }}</th>
					                    <th class="text-center">{{ __('item.grand_total') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
		                			@php
		                				$grand_total = 0;
		                				$total_discount = 0;
		                				$total_price = 0;
		                				$total_qty = 0;
		                			@endphp
		                			@foreach ($item as $item)	
		                				@php
		                					$grand_total += $item->grand_totals;
		                					$total_discount += $item->discount_amount;
		                					$total_price += $item->total_price;
		                					$qty =1;
		                					if($item->qty_merge>1){
		                						$qty = $item->qty_merge;
		                					}
		                					$total_qty += $qty;              					
		                				@endphp								
					                	<tr>
						                    <td class="text-center">{{ $loop->iteration }}</td>
						                    <td class="text-center">{{ date("d-M-Y", strtotime($item->sale_date)) }}</td>
						                    <td class="text-center">{{ $item->property_no }}</td>
						                    <td class="text-center">{{ $item->property_name }}</td>
						                    <td class="text-center">{{ $item->project_name }}</td>
											<td class="text-center">{{ $item->customer_name }}</td>
						                    <td class="text-center">{{ $qty }}</td>
											<td class="text-center">{{ "$ ". number_format($item->total_price,2) }}</td>
						                    <td class="text-center">{{ "$ ". number_format($item->discount_amount,2) }}</td>
						                    <td class="text-center">{{ "$ ". number_format($item->grand_totals,2) }}</td>
						                </tr>
					                @endforeach
				                	<tr>
				                		<td colspan="5" style="text-align: right;">{{ __('item.total') }}</td>
				                		<td class="text-center">{{ $total_qty }}</td>
				                		<td class="text-center">{{ "$ ". number_format($total_price,2) }}</td>
				                		<td class="text-center">{{ "$ ". number_format($total_discount,2) }}</td>
				                		<td class="text-center">{{ "$ ". number_format($grand_total,2) }}</td>
				                	</tr>
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
        $('#btnYesterday').click(function(){
	        $('#between_date').val('yesterday');
	        $('#frmSubmit').submit();
	    });
	    $('#btnToday').click(function(){
	        $('#between_date').val('today');
	        $('#frmSubmit').submit();
	    });
	    $('#btnThisWeek').click(function(){
	        $('#between_date').val('this_week');
	        $('#frmSubmit').submit();
	    });
	    $('#btnThisMonth').click(function(){
	        $('#between_date').val('this_month');
	        $('#frmSubmit').submit();
	    });
	    $('#btnLastWeek').click(function(){
	        $('#between_date').val('last_week');
	        $('#frmSubmit').submit();
	    });
	    $('#btnLastMonth').click(function(){
	        $('#between_date').val('last_month');
	        $('#frmSubmit').submit();
	    });
	    $('#btnThisYear').click(function(){
	        $('#between_date').val('this_year');
	        $('#frmSubmit').submit();
	    });
	    $('#btnLastYear').click(function(){
	        $('#between_date').val('last_year');
	        $('#frmSubmit').submit();
	    });
    });
</script>
@stop