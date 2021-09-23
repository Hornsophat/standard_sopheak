@extends('back-end/master')
@section('title',"Sale Detail Report")
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
		table tbody tr td{
			padding-bottom: 3px!important;
			padding-top: 3px!important;
		}
       
    }
	table tbody tr td{
		padding-bottom: 3px!important;
		padding-top: 3px!important;
	}
    }
</style>
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.sale') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.sale_detail_report') }}</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body bg-white rounded overflow_hidden p-4">
						<div class="rows">
							<form action="{{ url('sale_detail_report') }}" method="get" class="form-inline" id="frmSubmit">
								<div class="col-md-6 col-lg-3">
									{{ Form::text('start_date', $start_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => Lang::get('item.start_date')]) }}
								</div>
								<div class="col-md-6 col-lg-3">
									{{ Form::text('end_date', $end_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => Lang::get('item.end_date')]) }}
								</div>
								<div class="col-md-6 col-lg-3">
									<select class="form-control width-100" name="filter_status" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="sold" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 'sold'?"selected":"" }}>Sold</option>
										<option value="completed" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 'completed'?"selected":"" }}>Completed</option>
										{{-- <option value="cancel" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 'cancel'?"selected":"" }}>Cancel</option> --}}
									</select>
								</div>
								<div class="col-md-6 col-lg-3">
									<div class="form-group">
										{{  Form::text('search', $request->search,['class' => 'width-100 form-control search', 'placeholder'=>__('item.search')]) }}
									</div>
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
								<h3 style="text-transform: uppercase;">{{ __('item.sale_detail_report') }}</h3>
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
					                    <th width="70" class="text-center">ល.រ</th>
					                    <th class="text-center">ថ្ងៃខែឆ្នាំ​ បង់ប្រាក់</th>
										<th class="text-center">ឈ្មោះអតិថិជន</th>
					                    <th class="text-center">ទ្រព្យសម្បត្តិ</th>
					                    <th class="text-center">សរុប</th>
					                    <th class="text-center">តម្លៃលក់សរុប</th>
					                    <th class="text-center">ប្រាក់ដែលបានកក់</th>
					                    <th class="text-center">ប្រាក់ដែលបានបង់</th>
					                    <th class="text-center">ប្រាក់ដែលនៅសល់</th>
					                    <th class="text-center">បង់លើកទី</th>
					                    <th class="text-center">ថ្ងៃរំលស់</th>
					                    <th class="text-center">ផ្សេងៗ</th>
				                  	</tr>
				                </thead>
		                		<tbody>
		                			@foreach ($items as $collection)						
										@foreach ($collection as $item)
											@if(!empty($item['total_paid']))
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td colspan="6"></td>
												<td>សរុបប្រាក់ដែលបានបង់</td>
												<td class="text-right">{{$item['total_paid']}}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											@elseif(!empty($item['total_outstanding_amount']))
											<tr>
												<td colspan="6"></td>
												<td >សរុបប្រាក់ដើមដែលនៅសល់</td>
												<td class="text-right">{{$item['total_outstanding_amount']}}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr><td colspan="11">&nbsp;</td></tr>
											@else
											<tr>
												<td>{{$item['no']}}</td>
												<td>{{$item['sale_date']}}</td>
												<td>{{$item['customer_name']}}</td>
												<td>{{$item['property_number']}}</td>
												<td>{{$item['total_property']}}</td>
												<td class="text-right">{{$item['total_sale_amount']}}</td>
												<td class="text-right">{{$item['deposit']}}</td>
												<td class="text-right">{{$item['paid']}}</td>
												<td></td>
												<td class="text-center">{{$item['payment_order']}}</td>
												<td class="text-center">{{$item['pay_date']}}</td>
												<td></td>
											</tr>
											@endif
										@endforeach
									@endforeach
									@if(!empty($data_total))
									<tr>
										<td colspan="3"></td>
										<td style="font-weight: bold;">សរុប</td>
										<td>{{ $data_total['total_qty'] }}</td>
										<td></td>
										<td style="font-weight: bold">សរុបប្រាក់ដែលបានលក់ទាំងអស់</td>
										<td class="text-right">${{number_format($data_total['total_price'],2)}}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td colspan="6"></td>
										<td style="font-weight: bold">សរុបប្រាក់ដែលបានបង់ទាំងអស់</td>
										<td class="text-right">${{number_format($data_total['total_paid'],2)}}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td colspan="6"></td>
										<td style="font-weight: bold">សរុបប្រាក់ដើមដែលនៅសល់ទាំងអស់</td>
										<td class="text-right">${{number_format($data_total['total_outstanding_amount'],2)}}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									@endif
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