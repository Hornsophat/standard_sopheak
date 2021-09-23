@php
	use App\Helpers\AppHelper;
	use Illuminate\Support\Carbon;
@endphp
@extends('back-end/master')
@section('title',"Contract")
@section('content')
	<main class="app-content">
		<div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          	<li class="breadcrumb-item">{{ __('item.contract') }}</li>
          	<li class="breadcrumb-item active"><a href="#">{{ __('item.contract') }}</a></li>
        </ul>
      </div>

		{{-- List Customer --}}
   	<div class="row">
        	<div class="col-md-12" style="height: 40px;">
				@include('flash/message')
       		<div class="tile">
       			<div class="form-group">
       				<button class="btn btn-lg btn-danger" onclick="goBack();"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>{{ __('item.back') }}</button>
       				<button class="btn btn-lg btn-success pull-right btnPrint" onclick="printFunc();"><i class="fa fa-print" aria-hidden="true"></i>{{ __('item.print_this_page') }}</button>
       			</div>          				
       			<hr>
         		<div class="tile-body">
						<style type="text/css">
							.table-responsive{
								overflow-y: scroll;
								/*height: 16.8cm;*/
								width: 21.5cm;
								margin:auto;
							}
							.table-responsive::-webkit-scrollbar {
								width: 0.95em;
							}													 
							.table-responsive::-webkit-scrollbar-track {
								background: linear-gradient(transparent,#eee);
							  	box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2);
							  	display: none;
							}	
							.table-responsive::-webkit-scrollbar-track:hover{
								display: block;
							}							 
							.table-responsive::-webkit-scrollbar-thumb {
								background: linear-gradient(transparent,#ccc);	
								display: none;
							}
							.table-responsive::-webkit-scrollbar-thumb:hover{
								background: linear-gradient(transparent,#00c6ff);
								display: block;
							}
							table.table {
							   border: none !important;
							   line-height: 29px;
							}
							@font-face{
								font-family: 'Khmer OS Muol Light';
								src: url('{{ asset('public/back-end/fonts/print-font/KhmerOSmuollight.ttf') }}') format("truetype");
							}
							@font-face{
								font-family: 'Khmer OS System';
								src: url('{{ asset('public/back-end/fonts/print-font/KhmerOSsys.ttf') }}') format("truetype");
							}
							@font-face {
								font-family: 'Tacteing';
								src:url('{{ asset('public/back-end/fonts/print-font/TACTENG.ttf') }}')  format('truetype');
							}
						.alig{
												text-align:center;
											 }
											 
						.table tr{
								padding:0px;
								margin: 0px;
								text-align: center;
								font-family: 'Khmer OS Muol Light';
								font-size: 12pt;
							}
							.table td ul{
								list-style: none;
								font-family: 'Khmer OS System';
								font-size: 16px;
								text-align: justify;
							}
							.table td ul li{
								margin-left: 12px;
							}
							.table th, .table td {
							    border: none !important;
							    padding:5px;
							}
							.table .p{
								font-family: 'Khmer OS System';
								font-size: 16px;
								padding: 0px;
								margin:0px;
								text-align: justify;
								float: left;
							}
							.card{
								width: 21cm;
								height: 29.7cm;
								border-radius: unset;
							}
							.card .content{
								padding:40px;
								overflow: hidden;
								/*height: 27.5cm;*/
							}
							.card .content .footer{
								position: absolute;
								padding: 20px;
								bottom: 30px;
								right: 20px;
								overflow: hidden;
							}
							.footer footer .p{
								color: #A4A4A4;
								font-size: 15px;
							}
							.margin-top{
								margin-top: -25px;
							}
							.td-margin-top{
								margin-top: -16px;
							}
							.box-logo{
								position: absolute;
								width: 200px;
								height: 70px;
								margin-top: 35px;
							}
						</style>
						<div class="table-responsive" id="table-responsive">
							<div class="">
								<div class="content">
									<table class="table">
										<div class="box-logo">
											{{-- <img src="{{Setting::get('LOGO')}}" width="50%" height="200%"> --}}
										</div>
				                	<tbody>
										@php
										//datetime next 
									 $datefirst=$loan->first_pay_date;
									 $loanterm=$loan->installment_term;
									 $effectiveDate = date('Y-m-d', strtotime("+$loanterm month", strtotime($datefirst)));						
										@endphp
									<center>
									   <tr>
										   <td>
											   <p class="p" style="margin-left:30%;font-size:20px;font-family:Khmer OS Muol light;color:red"> កិច្ចសន្យាបង់រំលស់ ឬខ្ចីប្រាក់</p>
										   </td>
									   </tr>
									   {{--Age User--}}
									   <?php 
										$startDate = Carbon::parse('05-02-1985'); 
										$endDate = Carbon::parse('now'); 
										$ageuser = $startDate->diffInYears($endDate);
										 ?>
									   {{-- <tr>
										   <td>
											   <p class="p" style="margin-left:24%;font-weight:bold;font-size:20px;font-family:'Times New Roman', Times, serif">YOUK SOPHEAK MODERN PHONE SHOP</p>
										   </td>
									   </tr> --}}
									   </center>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;រវាងខ្ញុំបាទ ថ្លាង សុភារិទ្ធិ ភេទ ប្រុស អាយុ {{$ageuser}} ឆ្នាំ កាន់អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខ 061978295 ចុះថ្ងៃទី 23-09-2015 និងភរិយាខ្ញុំបាទ យក់ សុភ័ក្រ ភេទ ស្រី  ភូមិព្រែកពោធិ៍ក្រោម ឃុំព្រែកពោធិ៍ ស្រុកស្រីសន្ធរ ខេត្តកំពង់ចាម ហៅកាត់ថា ភាគី”ក” អ្នកលក់។</p>
					                		</td>
					                	</tr><br>
					                	
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ខ្ញុំបាទ/នាងខ្ញុំ ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';"><b>{{$sale->customer_name}}</b></span> ភេទ <b>{{$sale->customer_gender}}</b>  កើតនៅ​ ឆ្នាំ​ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_date_of_birht)))}} </b> សញ្ជាតិ <b>{{$sale->customer_nationality}}</b> មានអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខៈ <b>{{AppHelper::khMultipleNumber((string)$sale->customer_identity)}}</b> ចុះថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->cs_ident)))}} </b> ខែ  <b>{{AppHelper::khMultipleNumber(date('m', strtotime($sale->cs_ident)))}} </b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->cs_ident)))}} </b> អាស័យដ្ឋានបច្ចុប្បន្ន​ ផ្លូវលេខ <b>{{ $sale->street_number }}</b> ផ្ទះលេខ <b> {{$sale->cs_house_n}}</b>  ភូមិ <b> {{$sale-> vil_kh}}  </b> ឃុំ/សង្កាត់ <b>{{$sale->com_kh}}</b>  ​ស្រុក/ខណ្ឌ/ក្រុង <b>{{$sale->dis_kh }}</b> ខេត្ត/រាជធានី <b>{{$sale->prov_name}}</b>  ហៅកាត់ភាគី (ខ) ។</p>
					                		</td>
					                	</tr>
										@if($sale->customer_partner_id != Null)	
										<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;<b style="text-decoration:underline">  ភាគីរួមកម្ចី </b>៖ ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';"><b>{{$sale->partner_name}}</b></span> ភេទ <b>{{$sale->partner_gender}}</b>  កើតនៅ ថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->date_of_birth_partner)))}} </b>  ខែ​ <b>{{AppHelper::khMonth(date('m', strtotime($sale->date_of_birth_partner)))}}</b>  ឆ្នាំ​ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->date_of_birth_partner)))}}</b> សញ្ជាតិ <b>{{$sale->customer_nationality}}</b>  មានអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខៈ <b>{{AppHelper::khMultipleNumber((string)$sale->partner_identity)}}</b> ចុះថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->pn_identity_date)))}} </b> ខែ <b>{{AppHelper::khMultipleNumber(date('m', strtotime($sale->pn_identity_date)))}}</b> ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->pn_identity_date)))}} </b> អាសយដ្ឋានបច្ចុប្បន្ន​ ផ្ទះលេខ <b>{{$sale->pn_house_n}}</b>  ផ្លូវលេខ <b>{{ $sale->partner_street_number }}</b>  ភូមិ <b> {{$sale-> partner_village}}  </b> ឃុំ/សង្កាត់ <b>{{$sale->partner_commune}}</b>  ក្រុង/ស្រុក/ខណ្ឌ <b>{{$sale->partner_district }}</b> រាជធានី/ខេត្ត <b>{{$sale->partner_province}}</b>  ហៅកាត់ភាគី (ខ) ។</p>
					                		</td>
					                	</tr>
										@endif
					                	<tr>
					                		<td>
					                			<p class="p" style="float: none;">ភាគី "ក" និង ភាគី "ខ" បានព្រមព្រៀងគ្នាដោយអនុវត្តតាមរាល់ប្រការដូចខាងក្រោម៖</p>
					                		
					                		</td>
					                	</tr>
										<!-- calculate -->
										<?php  $last_balance=$sale->p_pp -  $sale->deposit ?>
										<tr>
											<td>
												<p class="p">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>ប្រការ១</b>: ភាគី”ក”យល់ព្រមឲ្យភាគី”ខ”បង់ប្រាក់ចូលរួមចំនួន $​​ <b>{{ number_format( $sale->deposit,2) }}</b> និងសល់សរុប $​ <b>{{ number_format ($last_balance,2)}}</b>(<b>{{ AppHelper::khNumberWord($last_balance) }}ដុល្លារគត់</b>) បន្តបង់រលស់។
													ភាគី”ខ”បានប្រគល់ប្រាក់ចូលរួមចំនួន $​​ <b>{{ number_format( $sale->deposit,2) }}</b>(<b>{{ AppHelper::khNumberWord($sale->deposit) }}ដុល្លារគត់</b>) ជូនដល់ភាគី”ក” ។</p>
											</td>
										</tr>
										<tr>
											<td>
												<p class="p">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>ប្រការ២</b>: ភាគី”ខ” សន្យាបង់ប្រាក់ទាំងដើមទាំងការ ឲ្យភាគី”ក” ដោយមិនមានការយឺតយ៉ាវ ឬគេចវេស ហើយភាគី”ក” យល់ព្រមទទួលទាំងប្រាក់ដើម និងការបា្រក់ពីភាគី”ខ”  ដែលបានកំណត់ក្នុងកិច្ចសន្យាលេខ <b>{{$loan->reference  }}</b>។
													ចាប់ពីថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($loan->first_pay_date)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($loan->first_pay_date)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($loan->first_pay_date)))}}</b>  រហូតដល់ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime( $effectiveDate)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime( $effectiveDate)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime( $effectiveDate)))}}</b> ដែលមានរយៈពេល <b>{{$loan->installment_term}}</b>ខែ ។</p>
											</td>
										</tr>
										<tr>
											<td>
												<p class="p">ភាគី”ខ”យល់ព្រមប្រគល់ប្រាក់ពិន័យ និងប្រាក់ផ្សេងៗ សោហ៊ុយខាតបង់ពេលវេលាឲ្យភាគី”ក”ដោយគ្មានការតវ៉ាឡើយ។</p>
											</td>
										</tr>
										<tr>
											<td>
												<p class="p">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>ប្រការ៣</b>: យោងកិច្ចសន្យានេះ ដើម្បីធានាដល់ការបំពេញកាតព្វកិច្ច ភាគី”ខ” បានដាក់អចលនទ្រព្យ ឬឯកសារធានាមានដូចជា៖</p>
											</td>
										</tr>
										
										<table style="border:1px solid black;width:90%;height:150px">
											<tr  style="border:1px solid black;border-bottom:1px solid black !important;height:40px;font-size:15px;">
											<th class="alig" style="border-right:1px solid black !important;border-bottom:1px solid black !important;font-family:Khmer OS System;width:10px;">&emsp; ល.រ </th>	
											<th style="border-bottom:1px solid black !important;font-family:Khmer OS System">&emsp;&emsp;&emsp;រាយមុខទ្រព្យសម្បត្តិដាក់បញ្ចាំ </th>
											</tr>			 
														<th class="alig" style="border-right:1px solid black !important;font-family:Khmer OS System;font-size:15px">&emsp;&emsp;&emsp; ១.</th>
														<td  style="font-size:15px;font-family:Khmer OS System">&emsp;&emsp;&emsp;{{$sale->remark}}</td>
											</table>
											<tr>
												<td>
													<p></p>
												</td>
											</tr>
										<tr>
											<td>
												<p  style="font-size:16px;font-family:Khmer OS System">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>ប្រការ៤</b>: កិច្ចសន្យានេះធ្វើឡើងជាភាសាខ្មែរចំនួន ០២ច្បាប់ សម្រាប់ភាគី”ក” និងភាគី”ខ” រក្សាទុកចំនួន០១ច្បាប់ម្នាក់។</p>
											</td>
										</tr>
										<tr>
											<td>
												<p  style="font-size:16px;font-family:Khmer OS System">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>ប្រការ៥</b>: កិច្ចសន្យានេះធ្វើឡើងរវាងភាគី”ក” និងភាគី”ខ” ដោយគ្មានការបង្ខិតបង្ខំពីភាគីណាមួយឡើយ ហើយកិច្ចសន្យានេះមានសុពលភាពនៅពេលដែលចុះហត្ថលេខា និងផ្តិតស្នាមមេដៃស្តាំ ជាភស្តុតាង។</p>
											</td>
										</tr>
										
										 {{-- <p style="font-family: Khmer os; font-size:14px;">ក្រោយពីបានពិនិត្យកិច្ចសន្យា និងបង់តារាងបង់ប្រាក់ខាងលើ ខ្ញុំបាទ/នាងខ្ញុំ យល់ព្រមដោយស្ម័គ្រចិត្តក្នុងការសងប្រាក់មកក្រុមហ៊ុន ភី.អិម.ប៊ី (PMB) វិញទាំងប្រាក់ដើម និងការប្រាក់ ទៅតាមកាលបរិច្ឆេទដែលបានកំណត់ខាងលើ។</p>  --}}
                                <tr>
                                    <td ><p class="text-right" style="font-size:14px;font-family:Khmer OS System;margin-left:450px;margin-top:50px"> ស្រីសន្ធរ, ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</b></p> </td>
                                </tr>
										<table style="width:100%;font-size:14px;font-family:Khmer OS System">
											<tr>
											<th>ភាគីខ្ចីប្រាក់ភាគី(ខ)</th>
											<th> សាក្សីខាងភាគី(ខ)</th>
											<th> សាក្សីខាងភាគី(ក)</th>
											<th>ភាគី(ក)</th>
											</tr>
											<tr>
											<td>&emsp;&emsp; </td>
											<td>&emsp;&emsp;</td>
											<td>&emsp;&emsp;</td>
											<td style="font-family: Khmer OS;font-weight:bold;font-size:14px ">&emsp;&emsp;&emsp;&emsp;&emsp; <span style="font-size:14px;"> ប្តី<span>​​ &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; ប្រពន្ធ​</td>
											</tr>
											<tr style="height:100px">
										    <td></td>
											<td></td>
											<td></td>
											<td></td>
											</tr>
                                            <tr>
										    <td>&emsp;&emsp;<b>{{ $sale->customer_name }} </b></td>
											<td>&emsp;.................................</td>
											<td>&emsp;.................................</td>
											<td>&emsp;&emsp;ថ្លាង សុភារិទ្ធិ​​ &emsp;&emsp;&emsp;&emsp;&emsp;យក់ សុភ័ក្រ</td>
											</tr>
										</table> 
									</div>
							</div>
						</div>			
										
					</main>
@stop
@section('script')
	<script>
		function goBack() {
		  window.history.back();
		}
		function printFunc() {
	    	var divToPrint = document.getElementById('table-responsive');
	    	var fontUrl = "{{ asset('public/back-end/fonts/print-font/KhmerOSmuollight.ttf') }}";
	    	var font_khsys_url = "{{ asset('public/back-end/fonts/print-font/KhmerOSsys.ttf') }}";
	    	var css = '' +
	      '<style type="text/css">@media print{'+
	      	'@font-face{font-family: "Khmer OS Muol Light";'+
				'src: url('+fontUrl+') format("truetype");}'+
				'@font-face{font-family: "Khmer OS System";src: url('+font_khsys_url+') format("truetype");}'+
				'table.table {border: none !important;line-height: 29px;}'+
				'.table tr{padding:0px;margin: 0px;text-align: center;font-family: "Khmer OS Muol Light","Khmer OS System";font-size: 17px;}'+
				'.table td ul{list-style: none;font-family: "Khmer OS System";font-size: 16px;text-align: justify;}'+
				'.table td ul li{margin-left: 12px;}'+
				'.table th, .table td {border: none !important;padding:5px;}'+
				'.table .p{font-family: "Khmer OS System";font-size: 16px;padding: 0px;margin:0px;text-align: justify;float: left;}'+
				'.card{width: 21cm;min-height:100%;height: 29.7cm;border-radius: unset;margin:0px;}'+
				'.card .content{padding:40px;overflow: hidden;height: 27.5cm;position:relative;}'+
				'.content .footer{position:absolute; z-index:99999;padding: 20px;bottom: -25px;right: 25px;overflow: hidden;}'+
				'.footer footer .p{color: #A4A4A4;font-size: 15px;}'+
				'div.margin-top{margin-top: -43px;padding:0px;}'+
				'div.margin-top-10{margin-top:-26px;}'+
				'div.td-margin-top{margin-top: -16px;padding:0px;}'+
				'div.margin{margin-top:-30px;}'+
				'div.margin-1{margin-top:-40px;}'+
				'div.td-margin{margin-top:-27px;}'+
				'.ul{margin-top: -1px;}'+
				'.box-logo{position: absolute;width: 200px;height: 70px;margin-top: 20px;}'+
				'#custom{height:180px;}'+'}</style>';
		   css += divToPrint.outerHTML;
		   newWin = window.open('');
		   newWin.document.write(css);
		   newWin.print();
		   newWin.close();
	   }
	   function printFuncsTion() {
	    	var divToPrint = document.getElementById('table-responsive-2');
	    	var fontUrl = "{{ asset('public/back-end/fonts/print-font/KhmerOSmuollight.ttf') }}";
	    	var font_khsys_url = "{{ asset('public/back-end/fonts/print-font/KhmerOSsys.ttf') }}";
	    	var css = '' +
	      '<style type="text/css">@media print{'+
	      	'@font-face{font-family: "Khmer OS Muol Light";'+
				'src: url('+fontUrl+') format("truetype");}'+
				'@font-face{font-family: "Khmer OS System";src: url('+font_khsys_url+') format("truetype");}'+
				'table.table {border: none !important;line-height: 29px;}'+
				'.table tr{padding:0px;margin: 0px;text-align: center;font-family: "Khmer OS Muol Light","Khmer OS System";font-size: 17px;}'+
				'.table td ul{list-style: none;font-family: "Khmer OS System";font-size: 16px;text-align: justify;}'+
				'.table td ul li{margin-left: 12px;}'+
				'.table th, .table td {border: none !important;padding:5px;}'+
				'.table .p{font-family: "Khmer OS System";font-size: 16px;padding: 0px;margin:0px;text-align: justify;float: left;}'+
				'.card{width: 21cm;min-height:100%;height: 29.7cm;border-radius: unset;margin:0px;}'+
				'.card .content{padding:40px;overflow: hidden;height: 27.5cm;position:relative;}'+
				'.content .footer{position:absolute; z-index:99999;padding: 20px;bottom: -25px;right: 25px;overflow: hidden;}'+
				'.footer footer .p{color: #A4A4A4;font-size: 15px;}'+
				'div.margin-top{margin-top: -43px;padding:0px;}'+
				'div.margin-top-10{margin-top:-26px;}'+
				'div.td-margin-top{margin-top: -16px;padding:0px;}'+
				'div.margin{margin-top:-30px;}'+
				'div.margin-1{margin-top:-40px;}'+
				'div.td-margin{margin-top:-27px;}'+
				'.ul{margin-top: -1px;}'+
				'.box-logo{position: absolute;width: 200px;height: 70px;margin-top: 20px;}'+
			'}</style>';
		   css += divToPrint.outerHTML;
		   newWin = window.open('');
		   newWin.document.write(css);
		   newWin.print();
		   newWin.close();
	   }
	</script>
@stop
