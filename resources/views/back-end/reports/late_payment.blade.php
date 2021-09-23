@php
	use App\Helpers\AppHelper;
@endphp
@extends('back-end/master')
@section('title',"Receipt Report")
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
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.receipt_report') }}</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body bg-white rounded overflow_hidden p-4">
						
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
								<h3>{{ __('item.date_payment') }}</h3>
							</div>
						</div>
						<br>
						<table class="table table-hover table-bordered table-nowrap">
							<thead>
								<tr>
								  <th width="70" class="text-center">{{ __('item.no') }}</th>
								  <th class="text-center">{{ __('អតិថិជន') }}</th>
								  <th class="text-center">{{ __('item.property') }}</th>
								  <th class="text-center">{{ __('item.loan_date') }}</th>
								  <th class="text-center">{{ __('item.payment_date') }}</th>
								  <td class="text-center">{{ __('item.amount_to_spend') }}</td>
								  {{-- <th class="text-center">{{ __('item.function') }}</th> --}}
								</tr>
							</thead>
							<tbody>
							  @foreach ($item as $item)
								<tr>
								  <td class="text-center">{{ $loop->iteration }}</td>
								  <td>{{ $item->customer_name }}</td>
								  <td>{{ $item->property_name }}</td>
								  <td class="text-center">{{ $item->loan_date }}</td>
								  <td class="text-center">{{ $item->payment_date }}</td>
								  <td>${{ $item->amount }}</td>
								  {{-- <td class="text-center">
									  @if(Auth::user()->can('view-sale') || $isAdministrator)
										  <a href="{{ route('sale_property.loan_payment', ['payment_schedule'=>$item->id]) }}" class="action btn btn-danger btn-sm" title="pay"><i class="fa fa-money"></i> {{ __('item.payment') }}</a>
									  @endif
									  
								  </td> --}}
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
        $('.demoDate, .search').change(function(){
        	$(this).parents().find('form').submit();
        })
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