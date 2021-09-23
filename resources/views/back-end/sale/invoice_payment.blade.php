@php
	use App\Helpers\AppHelper;
@endphp
@extends('back-end/master')
@section('title',"Invoice Payment")
@section('content')
<style type="text/css" id="stylePrint">
	@font-face{
      font-family: 'Khmer OS Muol Light';
      src: url('{{ asset('public/back-end/fonts/print-font/KhmerOSmuollight.ttf') }}') format("truetype");
   }
   @font-face{
      font-family: 'Khmer OS System';
      src: url('{{ asset('public/back-end/fonts/print-font/KhmerOSsys.ttf') }}') format("truetype");
   }
	div{
		font-family: 'Khmer OS System';
		font-size: 12pt;
	}
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
        	.col-md-6{width: 50%;float: left;}
        	.col-md-12{width: 100%;float:left;}
        	.text-center{text-align: center;}
        	.table-bordered {border: 1px solid #dee2e6;}
			.table{width: 100%;max-width: 100%;margin-bottom: 1rem;background-color: transparent;}
			tr{display: table-row;vertical-align: inherit;border-color: inherit;}
			.table-bordered th, .table-bordered td {border: 1px solid #dee2e6;}
			table{border-collapse: collapse;border-spacing: 0;font-family: 'Khmer OS System';font-size: 12pt;}
			.text-right{text-align: right;}
			.row{padding: 0px;margin: 0px;}
			p{padding: 0px;margin: 0px;}
			div{font-family: 'Khmer OS System';font-size: 12pt;}
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
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<button class="btn btn-small btn-danger" id="btn_cancel" type=""><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>{{ __('item.cancel') }}</button>
									<button class="btn btn-small btn-success" id="btn_print" type=""><i class="fa fa-print" aria-hidden="true"></i>{{ __('item.print') }}</button>
								</div>								
							</div>
						</div>
						<hr>
						<div id="table_print">
							<div class="text-success display_message text-center"></div><br>
							<div class="row">
								<div class="col-md-12 text-center">
									<span style="font-family: Khmer OS Muol Light; font-size: 24px;">វិក័យប័ត្រ</span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<img src="{{Setting::get('LOGO')}}" style="height: 50px;margin-bottom: 20px;">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-md-6">									
									<p>អតិថិជន : {{ ucwords($customer->first_name.' '.$customer->last_name) }}</p>
									<p>ទូរស័ព្ទ : {{ $customer->phone1.' '.$customer->phone2 }}</p>
									<p>អាសយដ្ឋាន : {{ $customer->village.', '.$customer->commune.', '.$customer->district.', '.$customer->province }}</p>
								</div>
								<div class="col-sm-6 col-md-6">
									<div style="position:relative;left: 50%;">
										<p>អចលនទ្រព្យ : {{ $property_names }}</p>
										<p>តម្លៃសរុប : ${{ number_format($sale->total_price,2) }}</p>
										@if($sale->total_discount>0)
										<p>បញ្ចុះតម្លៃ : ${{ number_format($sale->total_discount,2) }}</p>
										@endif
										<p>ប្រាក់កក់ : ${{ number_format($sale->deposit,2) }}</p>
										<p>តម្លៃបូក​សរុប : ${{ number_format($sale->grand_total,2) }}</p>
										{{-- <p>រយៈពេលបង់: </p> --}}
										<br>
									</div>									
								</div>								
							</div>
							<br>
							<table class="table table-hover table-bordered">
			               <thead>
		                  	<tr>
			                    	<th width="70" class="text-center">{{ __('item.no') }}</th>
			                    	<th class="text-center">{{ __('ថ្ងៃ-ខែ-ឆ្នាំ​ បង់ប្រាក់') }}</th>
										<th class="text-center">{{ __('ប្រាក់ត្រូវបង់') }}</th>
			                    	<th class="text-center">{{ __('ថ្ងៃ-ខែ-ឆ្នាំ​ បង់ប្រាក់ជាក់ស្ដែង') }}</th>
			                    	<th class="text-center">{{ __('ប្រាក់ទទួល') }}</th>
			                    	<th class="text-center">{{ __('ផ្សេងៗ') }}</th>
		                  	</tr>
			               </thead>
	                		<tbody>
	                			@foreach($payments as $pay)
			                	<tr>
					                 <td class="text-center">{{ $loop->iteration }}</td>
					                 <td class="text-center">{{ AppHelper::khMultipleNumber(date('d', strtotime($pay->payment_date))).'-'.AppHelper::khMonth(date('m', strtotime($pay->payment_date))).'-'.AppHelper::khMultipleNumber(date('Y', strtotime($pay->payment_date))) }}</td>
									<td class="text-center">${{ number_format($pay->amount_to_spend,2) }}</td>
									
									@if($pay->status==2)
									<td class="text-center">
										{{ AppHelper::khMultipleNumber(date('d', strtotime($pay->actual_payment_date))).'-'.AppHelper::khMonth(date('m', strtotime($pay->actual_payment_date))).'-'.AppHelper::khMultipleNumber(date('Y', strtotime($pay->actual_payment_date))) }}
									</td>
									<td class="text-center">${{ number_format($pay->amount_to_spend,2) }}</td>
									@else
									<td></td><td></td>
									@endif
					                 <td class="text-center"></td>
				                </tr>
				                @endforeach
			               </tbody>
		              	</table><br><br><br><br><br>
		              	{{-- <div class="row">
		              		<div class="col-md-6">1</div>
		              		<div class="col-md-6 text-right">
		              			<p>{{ AppHelper::khMultipleNumber(date('d')).'-'.AppHelper::khMonth(date('m')).'-'.AppHelper::khMultipleNumber(date('Y')) }}</p>
		              			<p>-------------------</p>
		              		</div>
		              	</div><br> --}}
		              	{{-- <div class="row">
		              		<div class="col-md-12 text-right">
		              			<p>-------------------</p>
		              			<p>012555 666</p></div>
		              	</div>
		              	<div class="row">
		              		<div class="col-md-12"><p>ចំណាំៈ​ ក្នុងករណីបង់យឺតចាប់ពីមួយខែឡើងទៅ.............</p></div>
		              		<div class="col-md-12"><p><b>ការទូទាត់អាចផ្ទេរតាមធនាគារទៅ៖ </b></p></div>
		              	</div>
		              	<div class="row">
		              		<div class="col-md-6"><p>ឈ្មោះគនណី: <b>..................</b></p></div>
		              		<div class="col-md-6"><p>ឈ្មោះគនណី: <b>..................</b></p></div>
		              	</div>
		              	<div class="row">
		              		<div class="col-md-6"><p>លេខគនណី: <b>..................</b></p></div>
		              		<div class="col-md-6"><p>លេខគនណី: <b>..................</b></p></div>
		              	</div>
		              	<div class="row">		              		
		              		<div class="col-md-6"><p>ឈ្មោះធនាគា: <b>..................</b></p></div>
		              		<div class="col-md-6"><p>ឈ្មោះធនាគា: <b>..................</b></p></div>
		              	</div> --}}
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
<script type="text/javascript" src="{{ asset('js/printThis.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#btn_cancel').click(function(){
			window.history.back();
		});
		var styleP = $('#stylePrint').text();
     	$('#btn_print').click(function(){
         var t = window.open();
         t.document.write("<style>"+styleP+" table tr td{font-size:11px !important}</style>");
         t.document.write($('#table_print').html());
         t.print();
         t.close();
     	});
    });
</script>
@stop