@extends('back-end/master')
@section('title',"Sale List")
@section('content')
<style type="text/css">
	.width-100 {
		width: 100% !important;
	}
	.m-r-0 {
		margin-right: 0px !important;
	}
</style>
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.sale_report') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.list_sale_report') }}</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body bg-white rounded overflow_hidden p-4">
						<div class="rows">
							<form action="{{ url('report') }}" method="get" class="form-inline">
								<div class="col-md-4">
									{{ Form::text('start', $start_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => Lang::get('item.start_date')]) }}
								</div>
								<div class="col-md-4">
									{{ Form::text('end', $end_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => Lang::get('item.end_date')]) }}
								</div>
								<div class="col-md-4">
									<select class="form-control width-100" name="filter_status" onchange="this.form.submit()">
										<option value="">All</option>
											<option value="1" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 1?"selected":"" }} >Deposit</option>
										<option value="2" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 2?"selected":"" }} >Completed</option>
										<option value="3" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 3?"selected":"" }} >Cancel</option>
								
									</select>
								</div>
							</form>
						</div>

						<div class="text-success display_message text-center"></div><br>
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-nowrap">
				                <thead>
				                  	<tr>
					                    <th width="70" class="text-center">@sortablelink('sex',__('item.no'))</th>
										<th class="text-center">@sortablelink('sale_date',__('item.sale_date'))</th>
					                    <th class="text-center">@sortablelink('customer_id',__('item.customer'))</th>
					                    <th class="text-center">@sortablelink('employee_id',__('item.employee'))</th>
					                    <th class="text-center">@sortablelink('total_discount',__('item.discount'))</th>
					                    <th class="text-center">@sortablelink('total_sale_commission',__('item.commission'))</th>
					                    <th class="text-center">@sortablelink('grand_total',__('item.grand_total'))</th>
					                    <th class="text-center">@sortablelink('',__('item.total_item'))</th>
					                    <th class="text-center">@sortablelink('',__('item.payment_process'))</th>
				                  	</tr>
				                </thead>
		                		<tbody>

		                			@foreach ($items as $item)
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
											<td>{{Date("d-M-Y h:i:s A", strtotime($item->sale_date))  }}</td>
											<td><a href="{{ route("viewEmployee", $item->employee_id) }}"><b>{{ $item->soleToCustomer->first_name .' '. $item->soleToCustomer->last_name }}</b></a></td>
						                    <td><a href="{{ route("viewCustomer", $item->customer_id) }}"><b>{{ $item->soldByEmployee->first_name .' '. $item->soldByEmployee->last_name }}</b></a></td>
											<td class="text-center"><span class="badge badge-success">{{ "$ ". ($item->total_discount !=null?$item->total_discount:"0.00") }}</span></td>
											<td class="text-center"><span class="badge badge-success">{{ "$ ". $item->total_sale_commission }}</span></td>
											<td class="text-center"><span class="badge badge-success">{{ "$ ". $item->grand_total }}</span></td>
											<td class="text-center"><span class="badge badge-warning">{{ $item->salesDetail()->count() }}</span> </td>
											<td>
												<div class="progress">
													<div class="progress-bar progress-bar-striped progress-bar-animated {{$class}}" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%">
														@if($percentage==100)
															<b><span>{{ number_format($percentage,0) ."%" }}</span></b>
														@else
															<b><span>{{ number_format($percentage,2) ."%" }}</span></b>
														@endif
													</div>
												</div>
											</td>
						                </tr>
					                @endforeach
				                </tbody>
		              		</table>

						</div>
						<div class="pull-right">
							{!! $items->render() !!}
							<a href="{{ $url_excel ?? '' }}" class="btn btn-success btn-sm" title="Excel"><i class="fa fa-file-excel-o m-r-0"></i></a>
					        <a href="{{ route('report.pdf') }}" class="btn btn-info btn-sm" title="PDF"><i class="fa fa-file-pdf-o m-r-0"></i></a>
						</div>
            		</div>
          		</div>
        	</div>
      	</div>
      	
	</main>
@stop
@section('script')
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
<script type="text/javascript">
	$(document).ready(function() {
        $('.demoDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
@stop