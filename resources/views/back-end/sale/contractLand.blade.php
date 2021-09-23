@php
	use App\Helpers\AppHelper;
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
											<img src="{{Setting::get('LOGO')}}" width="50%" height="200%">
										</div>
				                	<tbody>
						@php
						//datetime next 
                     $datefirst=$loan->first_pay_date;
					 $loanterm=$loan->installment_term;
					 $effectiveDate = date('Y-m-d', strtotime("+$loanterm month", strtotime($datefirst)));
					 $amount_booked=$sale->amount;
					 $amount_sale=$sale->p_pp;
					 $amount_paid=$loan->outstanding_amount;
					 $last_balance=$amount_sale -($amount_booked + $amount_paid);  						
						@endphp

				                		<tr>
												<td style="color:blue; font-family: 'Khmer OS Muol Light'; ; font-size:25px">ព្រះរាជាណាចក្រកម្ពុជា</td>
											</tr>
											<tr>
												<td style="color:blue; font-family: 'Khmer OS Muol Light'; ; font-size:25px">ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
											</tr>
											<tr>
												<td style="font-family: Tacteing;text-align:center;font-size:40px">6</td>
											</tr>
											<tr><td><p></p></td></tr>
											<tr>
												<td style="font-size: 13pt; font-family: 'Khmer OS Muol Light';">កិច្ចសន្យាលក់-ទិញផ្ទះ{{$sale->about }}</td>
											</tr>
											<br>
											<!-- <tr style="text-align: unset;">
						                	<td><span style="text-align: justify;padding: 0px;margin:0px;">យោងៈ<span style="font-family: 'Khmer OS System';font-size: 16px;"> -	វិញ្ញាបនបត្រសម្គាល់ម្ចាស់អចលនវត្ថុលេខៈ.....................ចុះថ្ងៃទី....... ខែ........ ឆ្នាំ២០.....។</span></span>
						                	</td> -->
						               </tr>
						               <tr style="text-align: center">
						                	<td style="tab-size:8"><p class="p" style=" tab-size:8!important;">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;កិច្ចសន្យានេះធ្វើឡើងនៅខេត្តសៀមរាប ចុះថ្ងៃទី {{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} ខែ {{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}} ឆ្នាំ {{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</p></td>
						               </tr> 
									<tr style="text-align: center">
											<td style="font-size: 13pt; font-family: 'Khmer OS Muol Light';">រវាង៖</td>
									</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;​<b style="text-decoration: underline;">ភាគីម្ចាស់អចលនវត្ថុ ឬភាគីអ្នកលក់</b>៖ ឈ្មោះ​ <b style="font-family: 'Khmer OS Muol Light';">សាន្ត រដ្ឋស៊ីង </b> កាន់អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខ ០៣០៦០៣៥២៩ ចុះថ្ងៃទី១៥ ខែវិច្ឆិកា ឆ្នាំ២០១៥ មានអាសយដ្ឋានបច្ចុប្បន្ននៅភូមិគោកធ្លក ឃុំកណ្តែក ស្រុកប្រាសាទបាគង ខេត្តសៀមរាប ចាប់ពីពេលនេះតទៅ នៅក្នុងកិច្ចសន្យានេះហៅកាត់ថា ភាគី “ក” ។ </p>
					                		</td>
					                	</tr><br>
					                	
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp; <b style="text-decoration:underline">  ភាគីអ្នកទិញ</b> ៖ ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';"><b>{{$sale->customer_name}}</b></span>ភេទ <b>{{$sale->customer_gender}}</b>  កើតនៅ​ ឆ្នាំ​ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_date_of_birht)))}} </b> សញ្ជាតិ <b>{{$sale->customer_nationality}}</b> មានអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខៈ <b>{{AppHelper::khMultipleNumber((string)$sale->customer_identity)}}</b> ចុះថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->cs_ident)))}} </b> ខែ  <b>{{AppHelper::khMultipleNumber(date('m', strtotime($sale->cs_ident)))}} </b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->cs_ident)))}} </b> អាស័យដ្ឋានបច្ចុប្បន្ន​ ផ្លូវលេខ <b>{{ $sale->street_number }}</b> ផ្ទះលេខ <b>{{$sale->cs_house_n}}</b>  ភូមិ <b> {{$sale-> vil_kh}}  </b> ឃុំ/សង្កាត់ <b>{{$sale->com_kh}}</b>  ​ស្រុក/ខណ្ឌ <b>{{$sale->dis_kh }}</b> រាជធានី/ខេត្ត <b>{{$sale->prov_name}}</b>  ហៅកាត់ភាគី (ខ) ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align:center; font-family: 'Khmer OS Muol Light';">គូភាគីបានព្រមព្រៀងគ្នាតាមលក្ខខ័ណ្ឌ និងប្រការដែលមានខ្លឹមសារដូចខាងក្រោម៖</p>
					                		
					                		</td>
					                	</tr>
					                	<tr>
					                		<!-- <td>
					                			ខចែង និងលក្ខខណ្ឌ
					                		</td> -->
					                	</tr>
					                	<tr>
					                		<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ១៖ កម្មវត្ថុនៃកិច្ចសន្យា
					                		</td>
					                	</tr>
										<tr><td></td></tr><tr><td></td></tr>
										<tr>
										<td align="left" style="font-family: 'Khmer OS System';">
										&emsp;&emsp;&emsp; <b>គូភាគីបានព្រមព្រៀងគ្នាលក់-ទិញផ្ទះ{{$sale->property_name  }}មួយកន្លែងដូចខាងក្រោម៖</b> 
										</td>
										</tr>
					                	<tr>
					                		<td>
								                 <ul>
											           
											            	<table width="100%">
											            		<tr>
												            		<td width="20.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- ផ្ទះវីឡាលេខ <b>{{$sale->p_pn  }}</b> </p></td>

												            	
												            	</tr>
												            	<tr>
																	<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- មានទំហំក្បាលដី {{$sale->land_num}} ម៉ែត្រ បណ្តោយ.........ម៉ែត្រ និងទំហំផ្ទះ <b>{{$sale->width }} </b> ម៉ែត្រ X <b>{{$sale->length}}</b> ម៉ែត្រ។</p></td>
												            	
												            	</tr>
																<tr>
																	<td width="20.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- មានព្រំប្រទល់ខាងជើងទល់នឹងផ្ទះលេខ <b>{{ $sale->boundary_north }}</b> ខាងត្បូងទល់នឹងផ្ទះលេខ {{$sale->boundary_south }}  <br> &emsp;&emsp;&emsp;&emsp;ខាងកើតទល់នឹង <b>{{$sale->boundary_east  }}</b> ខាងលិចទល់នឹងផ្ទះលេខ <b>{{$sale->boundary_west  }}</b> ។ </p></td>
												            	
												            	</tr>
																<tr>
																	<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- មានទីតាំងស្ថិតនៅភូមិល្អក់ ឃុំកណ្តែក ស្រុកប្រាសាទបាគង ខេត្តសៀមរាប ។</p></td>
												            	
												            	</tr>
																
											            	</table>
											        </ul>
					                		</td>
					                	</tr>
					                	
					                	</tr>
											<tr>
											<tr>
					                		<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ២៖ អំពីលក្ខណ:សំណង់
					                		</td>
					                	</tr>
						                	</tr>
						                	<tr>
										<td align="left" style="font-family: 'Khmer OS system';">
										&emsp;&emsp;&emsp;អំពីលក្ខណៈ និងគុណភាពសំណង់លម្អិតនឹងមានភា្ជប់ជាមួយឧប្បសម្ព័ន្ធ ។
										</td>
										</tr>
											<tr>
					                		<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ៣៖ តម្លៃនៃការលក់-ទិញ
					                		</td>
					                	</tr>
										<tr>
											<td></td>
										</tr>
					                	<tr>
					                		<td>
					                			<div class="margin-top-10">
					                				<p class="p">&emsp;&emsp;គូភាគីបានព្រមព្រៀងគ្នាលក់-ទិញផ្ទះវីឡាទោល​​ ដែលជាកម្មវត្ថុនៃកិច្ចសន្យានេះ ក្នុងតម្លៃសរុបចំនួន $<b>{{$sale->p_pp}}</b>  ចំនួនទឹកប្រាក់ជាអក្សរ <b> (&nbsp;​{{ AppHelper::khNumberWord($sale->p_pp) }}</b> ដុល្លារអាមេរិកគត់)។</p>
					                			</div>
					                		</td>
					                	</tr>
					                	<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ៤៖ ការទូទាត់ប្រាក់ថ្លៃលក់-ទិញ 
					                		</td>
					                	</tr>
										<tr>
											<td>
												<p class="p"><b>&emsp;៤.១.</b> 
													<ul>
														<li><b>&emsp;គូភាគីបានព្រមព្រៀងគ្នាទូទាត់ប្រាក់ថ្លៃលក់ទិញជាដំណាក់កាលដូចខាងក្រោម៖</b>
														</li>
														<tr>
															<td align="left" style="font-family: 'Khmer OS system">
														&emsp;&emsp;​​​​​​​​​​ <b>៤.១.១. ដំណាក់កាលទី១</b>  ៖ ភាគី “ខ” យល់ព្រមបង់ប្រាក់កក់ចំនួន $  <b>{{  $sale->amount }}</b><b>(​{{ AppHelper::khNumberWord( $sale->amount) }}) ដុល្លារអាមេរិកគត់</b> ឲ្យទៅភាគី “ក” នៅថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->date_booked)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->date_booked)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->date_booked)))}}</b>។
															</td>
														</tr>
														<tr>
															<td align="left" style="font-family: 'Khmer OS system">
														&emsp;&emsp; <b>៤.១.២. ដំណាក់កាលទី២</b> ៖ ភាគី “ខ” យល់ព្រមបង់ប្រាក់បន្ថែមចំនួន​ $ <b>{{$loan->outstanding_amount  }}</b> <b>(​{{ AppHelper::khNumberWord( $loan->outstanding_amount) }}) ដុល្លារអាមេរិកគត់</b> ឲ្យទៅភាគី “ក” នៅថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($loan->loan_date)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($loan->loan_date)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($loan->loan_date)))}}</b>។
															</td>
														</tr>
														<tr>
															<td align="left" style="font-family: 'Khmer OS system">
														&emsp;&emsp; <b>៤.១.៣.	ដំណាក់កាលទី៣</b> ៖ ភាគី “ខ” នឹងបង់ប្រាក់ដែលនៅសល់បង្រ្គប់ចំនួន $ <b>{{ $last_balance  }} </b>  <b>(​{{ AppHelper::khNumberWord( $last_balance) }}) ដុល្លារអាមេរិកគត់</b> ឲ្យទៅភាគី “ក” នៅថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($effectiveDate)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($effectiveDate)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($effectiveDate)))}}</b> ហើយភាគី “ក” ត្រូវបញ្ចប់ការសាងសង់ និងកាត់ឈ្មោះផ្ទេរកម្មសិទ្ធិរួចរាល់ជាស្ថាពរឲ្យទៅភាគី“ខ” ហើយភាគី “ក” ត្រូវប្រគល់ប័ណ្ណកម្មសិទ្ធិដែលបានផ្ទេរសិទ្ធិទៅភាគី “ខ” រួចរាល់នោះ ឲ្យទៅភាគី “ខ” ។
															</td>
														</tr>
														<tr>
															<td><b>រាល់ការបង់ប្រាក់ និងទទួលប្រាក់ភាគី “ក” នឹងចេញវិក័យបត្រជូនភាគី “ខ” ។</b></td>
														</tr>
													</ul>
												</p>
											</td>
										</tr>
										<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
											ប្រការ៥៖ មធ្យោបាយនៃការបង់ប្រាក់
										</td>
									</tr>
									<tr>
										<td style="font-family: 'Khmer OS System';">
											ភាគី “ខ” អាចបង់ប្រាក់ទៅភាគី “ក” ជាសាច់ប្រាក់ផ្ទាល់ ឬតាមរយៈប្រព័ន្ធធនាគារ ដោយផ្ទេរសាច់ប្រាក់ចូលទៅក្នុងគណនីធនាគាររបស់ភាគី “ក” ធនាគារ ABA ៖គណនេយ្យលេខ ០០០ ៤៥៧០៧៧ គណនេយ្យឈ្មោះ SAN ROTHSING, ធនាគារ ACLEDA៖គណនេយ្យលេខ ៣៤៥១២០៧៥៧៣០៣១១ គណនេយ្យឈ្មោះ SAN ROTHSING ។ 
										</td>
									</tr>
								<tr>	
									<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
										ប្រការ៦៖ កិច្ចព្រមព្រៀងពិសេស
									</td>
								</tr>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">&emsp;&emsp;៦.១.ភាគី “ក” ធានាអះអាងថានឹងបញ្ចប់ការសាងសង់ និងកាត់ឈ្មោះផ្ទេរកម្មសិទ្ធិនៅមន្ទីរសុរិយោដីទៅឲ្យភាគី “ខ” នៅថ្ងៃទី......... ខែ........... ឆ្នាំ...........។ ក្នុងករណីភាគី “ក” មិនអាចបញ្ចប់ការសាងសង់ និងកាត់ឈ្មោះផ្ទេរកម្មសិទ្ធិតាមពេលដែលបានកំណត់ នោះភាគី “ក” ត្រូវសងប្រាក់ទៅភាគី “ខ” ស្មើនឹងអត្រាការប្រាក់ ១.៥% ក្នុងមួយខែ នៃប្រាក់ដែលភាគី “ខ” បានបង់រួចឲ្យទៅភាគី “ខ” ។ </td>
								</tr>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">&emsp;&emsp;៦.២. ភាគី “ក” ធានាអះអាងលើគុណភាពសំណង់សម្រាប់រយៈពេល ០២(ពីរ) ឆ្នាំ ករណីមានការខូចខាតផ្នែកណាមួយ ឬទាំងមូលនៃអាគារដែលបណ្តាលពីបច្ចេកទេសសាងសង់របស់ភាគី “ក” នោះភាគី “ក” ធានាជួសជុលឲ្យភាគី “ខ” ដោយមិនគិតថ្លៃសេវា និងតម្លៃសម្ភារៈពីភាគី “ខ” ឡើយ ។ ករណីមានការខូចខាតបណ្តាលមកពីប្រធានសក្តិ មិនមែនជាបន្ទុករបស់ភាគី “ក” នោះទេ។</td>
								</tr>
								<tr>
									<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;៦.៣. ករណីមានការយឺតយ៉ាវ ឬផ្អាកការសាងសង់ដោយមូលហេតុប្រធានសក្តិ ឬមូលហេតុផ្សេងៗដែលមិនមែនកើតឡើងដោយកំហុសរបស់ភាគី “ក” គូភាគីត្រូវជួបចរចា គ្នាដោយសន្តិវិធី យោគយល់ និងអធ្យាស្រ័យខ្ពស់រវាងគ្នាដើម្បីដោះស្រាយ។ ប៉ុន្តែប្រសិនបើការយឺតយ៉ាវ ឬផ្អាកការសាងសង់កើតឡើងពីកំហុសចេតនារបស់ភាគី “ក” ភាគី “ក” ត្រូវសងសំណងស្មើនឹងអត្រាការប្រាក់ ១.៥%  ក្នុងមួយខែ នៃប្រាក់ដែលភាគី “ខ” បានបង់រួច ឲ្យទៅភាគី “ខ” ។  </td>
								</tr>
								<tr>
									<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;៦.៤. ករណីភាគី “ខ” ខកខានមិនបានបង់ប្រាក់តាមដំណាក់កាលណាមួយ ដូចមានចែងនៅក្នុងប្រការ៤ រយៈពេល ០៣ (បី)ខែ ជាប់ៗគ្នា នោះប្រាក់ដែលភាគី “ខ” បានបង់រួច ត្រូវទុកជាប្រយោជន៍របស់ភាគី “ក” ដោយស្វ័យប្រវត្តិ ហើយភាគី “ខ” គ្មានសិទ្ធិប្តឹងតវ៉ាភាគី “ក” ឡើយ ។</td>
								</tr>
								
								
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
									ប្រការ៧៖ អំពីការបន្ថែមសម្ភារៈ 
								</td>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">នៅក្នុងការលក់ទិញនេះភាគី “ក” បានព្រមព្រៀងបន្ថែមនូវសម្ភារៈឲ្យទៅភាគី “ខ” រួមមាន៖</td>
								</tr>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">&emsp;&emsp; ១-បន្ថែម  &emsp;&emsp;<b>{{$sale->product_first  }}</b></td>
								</tr>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">&emsp;&emsp; ២-បន្ថែម  &emsp;&emsp;<b>{{$sale->product_second  }}</b></td>
								</tr>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">&emsp;&emsp; ៣-បន្ថែម  &emsp;&emsp;<b>{{$sale->product_third  }}</b></td>
								</tr>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">&emsp;&emsp; ៤-បន្ថែម   &emsp;&emsp;<b>{{$sale->product_four  }}</b></td>
								</tr>
								<tr>
									<td align="left" style="font-family: 'Khmer OS System';">&emsp;&emsp; ៥-បន្ថែម   &emsp;&emsp;<b>{{$sale->product_five  }}</b></td>
								</tr>
							</tr>
						<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ៨៖ អំពីការលក់បន្ត និងផ្ទេរសិទ្ធិទៅតតិយជន 
							</td>
							<tr>
								<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;៨.១. ភាគី “ខ” មានសិទ្ធិលក់បន្តលើកម្មវត្ថុនៃការលក់ទិញក្នុងកិច្ចសន្យានេះ ទៅឲ្យតតិយជនក្នុង  កំឡុងពេលនៃកិច្ចសន្យាលក់ទិញនេះបាន ។ ការលក់បន្តលើកម្មវត្ថុនៃកិច្ចសន្យាលក់ទិញនេះទៅឲ្យតតិយជន ភាគី “ខ” ត្រូវជូនដំណឹងជាលាយលក្ខអក្សរ ឬដោយផ្ទាល់មាត់ភ្លាមៗទៅភាគី “ក”  ដើម្បីឲ្យភាគី “ក”  ធ្វើការរៀបចំឯកសារផ្លូវច្បាប់ជាមួយតតិយជននោះ។ ការផ្ទេរកម្មសិទ្ធិដោយផ្ទាល់ពីភាគី “ក” ទៅតតិយជន ជាបន្ទុករបស់ភាគី “ក” លុះត្រាតែក្នុងលក្ខខណ្ឌដែលភាគី “ក” មិនទាន់បានផ្ទេរកម្មសិទ្ធិរួចរាល់ស្ថាពរឲ្យទៅភាគី “ខ” ប៉ុណ្ណោះ។ </td>
							</tr>
							<tr>
								<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;៨.២. យោងតាមចំណុច ៨.១.ខាងលើ ភាគី “ខ” ត្រូវចំណាយលើសេវារដ្ឋបាល និងសេវាមេធាវីចំនួន <b>១៥០$(មួយរយហាសិបដុល្លារអាមេរិក)</b> ក្នុងមួយដង នៃប្រតិបត្តិការកាត់ឈ្មោះផ្ទេរកម្មសិទ្ធិទៅឲ្យតតិយជន ។</td>
							</tr>
							<tr>
								<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;៨.៣.យោងតាមចំណុច ៨.១. ភាគី “ខ” ត្រូវបំពេញកាតព្វកិច្ចក្នុងការទូទាត់ប្រាក់ថ្លៃលក់ទិញឲ្យបានគ្រប់ចំនួនឲ្យទៅភាគី “ក” ដូចមានចែងនៅក្នុង ប្រការ៤ នៃកិច្ចសន្យានេះ។</td>
							</tr>
							<tr>
								<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;៨.៤.ករណីភាគី “ក” បានផ្ទេរកម្មសិទ្ធិឲ្យទៅភាគី “ខ” រួចរាល់ជាស្ថាពរ ហើយត្រូវធ្វើការផ្ទេរកម្មសិទ្ធិបន្តទៅតតិយជន នោះការចំណាយលើការផ្ទេរកម្មសិទ្ធិ និងការបង់ពន្ធគឺជាបន្ទុករបស់ភាគី “ខ” ទាំងស្រុង ។</td>
							</tr>
						</tr>
						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ៩៖អំពីទាយាទ ឬសិទ្ធិបន្តស្របច្បាប់
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;ករណីភាគីណាមួយនៅក្នុងកិច្ចសន្យានេះ មិនអាចអនុវត្តសិទ្ធិ ឬកាតព្វកិច្ច ឬការទទួលខុសត្រូវដែលមានចែងនៅក្នុងកិច្ចសន្យានេះ ដោយមូលហេតុបណ្តាលមកពីអសមត្ថភាព ឬមរណភាព ឬពិការភាព ឬអវត្តមាននៅក្នុងប្រទេស រាល់ការអនុវត្តសិទ្ធិ ឬកាតព្វកិច្ច ឬការទទួលខុសត្រូវ ត្រូវប្រគល់ជូនទាយាទ ឬអ្នកតំណាងស្របច្បាប់ណាមួយរបស់ភាគីជាអ្នកអនុវត្តបន្ត។</td>
						</tr>
						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១០៖កំហុស និងសំណង់
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១០.១.	ត្រូវបានចាត់ទុកថាជាកំហុសរបស់ភាគី “ក” ប្រសិនបើការអះអាងរបស់ភាគី “ក” ខាងលើខុសពីការពិត ឬភាគី “ក” កែប្រែឈប់លក់វិញ នោះភាគី “ក” ត្រូវសងប្រាក់ទៅភាគី “ខ” វិញស្មើនឹងចំនួនពីរដងនៃចំនួនប្រាក់ដែលភាគី “ខ” បានបង់រួចដោយឥតប្រកែកតវ៉ានោះឡើយ ។ </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១០.២.	ករណីដែលភាគី “ខ” កែប្រែឈប់ទិញ ឬក្នុងករណីដែលភាគី “ខ” មិនបានបំពេញកាតព្វកិច្ចតាមកិច្ចសន្យា  នោះភាគី “ខ” យល់ព្រមបោះបង់ចោលប្រាក់ដែលភាគី “ខ” បានបង់រួចរាល់ ឲ្យទៅភាគី “ក” ដោយឥតប្រកែកតវ៉ាអ្វីឡើយ។</td>
						</tr>
						
						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១១៖ការចុះបញ្ជីផ្ទេរកម្មសិទ្ធិ
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១១.១.	ភាគី “ក” មានកាតព្វកិច្ចផ្ទេរសិទ្ធិកាត់ឈ្មោះលើកម្មសិទ្ធិ ដែលជាកម្មវត្ថុនៃការលក់ទិញខាងលើទៅឲ្យភាគី “ខ” នៅមន្ទីររៀបចំដែនដី នគរូបនីយកម្ម សំណង់ និងសុរិយោដី ខេត្តសៀមរាប (ប្លង់រឹង)។ </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១១.២.	ការចំណាយលើការផ្ទេរសិទ្ធិកាត់ឈ្មោះសិទ្ធិលើកម្មសិទ្ធិរហូតសម្រេចជាស្ថាពរ ជាបន្ទុករបស់ភាគី “ក” ។</td>
						</tr>				
						
						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១២៖កាតព្វកិច្ចរបស់គូភាគី
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១២.១.	ភាគី “ក” មានកាតព្វកិច្ចបំពេញកាតព្វកិច្ចដូចមានចែងនៅក្នុងកិច្ចសន្យានេះ និងប្រគល់ដី-ផ្ទះ និងប័ណ្ណកម្មសិទ្ធិលើដី-ផ្ទះ ដែលជាកម្មវត្ថុនៃការលក់ទិញខាងលើ ឲ្យទៅភាគី “ខ” ។</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១២.២.	ភាគី “ខ” មានកាតព្វកិច្ចបំពេញកាតព្វកិច្ចដូចមានចែងនៅក្នុងកិច្ចសន្យានេះ និងត្រូវធ្វើការទូទាត់ប្រាក់ទៅតាមកាលកំណត់ដូចមានចែងក្នុងប្រការ៤ នៃកិច្ចសន្យានេះ ទៅឲ្យភាគី “ក” ។</td>
						</tr>				

						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១៣៖ការជូនដំណឹងរបស់គូភាគី
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៣.១.	មធ្យោបាយទំនាក់ទំនង ឬការជូនដំណឹងទៅវិញទៅមក ត្រូវធ្វើឡើងជាលាយលក្ខណ៍ អក្សរ ផ្ញើរទៅកាន់អាសយដ្ឋានរបស់ភាគីម្ខាងទៀត ឬតាមរយៈសារអេឡិចត្រូនិចដូចខាងក្រោម៖  </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp; <b>+ ភាគី "ក"៖</b> </td>
						</tr>				
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <b>- ជម្រាបជូន</b> ៖ លោក <b style="font-family: Khmer OS Muol Light">សាន្ត រដ្ឋស៊ីង</b> </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <b>- មានអាស័យដ្ឋាន</b> ៖ នៅភូមិគោកធ្លក ឃុំកណ្តែក ស្រុកប្រាសាទបាគង ខេត្តសៀមរាប ។ </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <b>- លេខទូរស័ព្ទ</b> ៖ ០៨៩ ៤៥ ៦៥ ៧៦  </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp; <b>+ ភាគី "ខ"៖</b> </td>
						</tr>				
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <b>- ជម្រាបជូន</b> ៖ លោក <b> {{$sale->customer_name}}</b> </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <b>- មានអាស័យដ្ឋាន</b> ៖ ផ្លូវលេខ <b>{{ $sale->street_number }}</b> ផ្ទះលេខ <b>{{$sale->cs_house_n}}</b>  ភូមិ <b> {{$sale-> vil_kh}}  </b> ឃុំ/សង្កាត់ <b>{{$sale->com_kh}}</b>  ​ស្រុក/ខណ្ឌ <b>{{$sale->dis_kh }}</b> រាជធានី/ខេត្ត <b>{{$sale->prov_name}}</b> </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <b>- លេខទូរស័ព្ទ</b> ៖ {{$sale->phone1 .' / '. $sale->phone2  }}  </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៣.២.	ចំពោះការជូនដំណឹងខាងលើនេះ គូភាគីបានឯកភាពទទួលស្គាល់ជាផ្លូវការ ប្រសិនបើភាគីណាធ្វើការជូនដំណឹងដល់ភាគីម្ខាងទៀត ហើយភាគីម្ខាងទៀតនោះ គេចវេសមិនព្រមទទួលដំណឹង នោះភាគីជូនដំណឹងមានសិទ្ធិ បិទលិខិតជូនដំណឹងនៅមុខផ្ទះរបស់ភាគីនោះ ហើយថតទុកជាភស្ដុងតាង និងការជូនដំណឹងចុងក្រោយតាមរយៈសារអេឡិចត្រូនិច មានទូរស័ព្ទដៃ និងបណ្ដាញទំនាក់ទំនងសង្គម ទុកជាបានការ។</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៣.៣.ក្នុងករណីដែលភាគីណាមួយ ធ្វើការផ្លាស់ប្ដូរអាសយដ្ឋាន ឬមធ្យោបាយទំនាក់ទំនងផ្សេងទៀត ភាគីដែលធ្វើការផ្លាស់ប្ដូរនោះ ត្រូវធ្វើការជូនដំណឹងអំពីការផ្លាស់ប្ដូរនោះទៅភាគីម្ខាងទៀតក្នុងរយៈពេល ៥ (ប្រាំ) ថ្ងៃ នៃថ្ងៃធ្វើការ បន្ទាប់ពីការផ្លាស់ប្ដូរនោះ។ ក្នុងករណីភាគីណាមួយ ខកខានមិនបានធ្វើការជូនដំណឹងអំពីការផ្លាស់ប្ដូរអាសយដ្ឋាន នោះភាគីដែលផ្លាស់ប្ដូរអាសយដ្ឋានត្រូវចាត់ទុកថាបានទទួលដំណឹង ប្រសិនបើភាគីម្ខាងទៀតធ្វើការជូនដំណឹងទៅអាសយដ្ឋានចាស់របស់ខ្លួន។</td>
						</tr>

						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១៤៖ការរំលាយមុនកិច្ចសន្យា
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៤.១.	ក្នុងករណីដែល ភាគី “ក” មានកំហុស ឬចង់រំលាយកិច្ចសន្យានេះ ភាគី “ក” យល់ព្រមសងប្រាក់ទៅភាគី “ខ” វិញស្មើនឹងចំនួនពីរដងនៃចំនួនប្រាក់ដែលភាគី “ខ” បានបង់រួច ដោយឥតប្រកែកតវ៉ានោះឡើយ ។ </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៤.២.	ក្នុងករណីដែល ភាគី “ខ” មានកំហុស ឬចង់រំលាយកិច្ចសន្យានេះ ភាគី “ក” មានសិទ្ធិរឹបអូសយកប្រាក់ដែលភាគី “ខ” បានបង់រួច ដោយគ្មានការតវ៉ា ។</td>
						</tr>

						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១៥៖ករណីប្រធានសក្តិ
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៥.១.	ករណីប្រធានសក្តិ មានន័យថាជាអំពើ ឬស្ថានការណ៍មួយដែលមិនអាចដឹងមុនបាន មិនអាចជៀសវាងបាន និងរារាំងភាគីមិនឲ្យបំពេញកាតព្វកិច្ចរបស់ខ្លួនដែលមានចែងក្នុងកិច្ចព្រមព្រៀងនេះបាន ហើយដរាបណាអំពើ ព្រឹត្តិការណ៍ ឬស្ថានភាពទាំងនោះហួសពីសមត្ថភាពគ្រប់គ្រង និងមិនមែនកើតឡើងដោយចេតនា ឬដោយសារខ្វះការ ប្រុងប្រយ័ត្នរបស់ភាគី។ អំពើ ឬស្ថានភាពទាំងនោះមាន គ្រោះមហន្តរាយធម្មជាតិ រញ្ជួយដី សង្រ្គាម.ល. ។</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៥.២.	ក្នុងករណីមានការខូចខាតកម្មវត្ថុនៃការលក់ទិញខាងលើ ជាយថាហេតុដោយគ្រោះថ្នាក់ធម្មជាតិ នោះគូភាគីត្រូវពិភាក្សា ចូលរួមគ្នាដោះសា្រយដោយសន្តិវិធី ។</td>
						</tr>

						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១៦៖ការដោះស្រាយវិវាទ
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៦.១.	ប្រសិនបើមានវិវាទដោយសារការបកស្រាយនៃកិច្ចសន្យានេះ ឬសិទ្ធិ ឬកិច្ចការ ឬទំនួលខុសត្រូវ ឬកាតព្វកិច្ចរបស់ភាគីណាមួយ ឬវិវាទដែលស្រដៀងនឹងកិច្ចសន្យានេះ ឬពាក់ព័ន្ធនឹងកិច្ចសន្យានេះ ភាគីទាំងពីរត្រូវជួបសហការដោះស្រាយគ្នាដោយសន្តិវិធី ដោយយោគយល់គ្នា និងអធ្យាស្រ័យគ្នាខ្ពស់ ឬអាចអញ្ជើញមេធាវីឲ្យចូលរួមផងដែរ។</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៦.២.	ប្រសិនបើគូភាគីដោះស្រាយគ្នាដោយសន្តិវិធីនៅតែមិនអាចដោះស្រាយបាន វិវាទនឹងត្រូវយកទៅដោះស្រាយតាមផ្លូវតុលាការនៃព្រះរាជាណាចក្រកម្ពុជា។</td>
						</tr>

						
						<tr>
							<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
								ប្រការ១៧៖អវសាន្តបញ្ញាត្តិនៃកិច្ចសន្យា
							</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៧.១.	គូភាគីបានអាន និងស្ដាប់យល់នូវអត្ថន័យគ្រប់ចំណុចនៃកិច្ចសន្យានេះ ហើយសន្យាថានឹងអនុវត្តតាមប្រការនីមួយៗនៃកិច្ចសន្យានេះដោយម៉ឺងម៉ាត់ ហើយយល់ព្រមផ្ដិតមេដៃស្ដាំទុកជាភស្ដុតាង។ កិច្ចសន្យានេះមានសុពលភាពអនុវត្តចាប់ពីថ្ងៃផ្ដិតមេដៃលើកិច្ចសន្យានេះតទៅ ហើយអស់សុពលភាពអនុវត្តនៅពេលដែលគូ ភាគីបានអនុវត្តកាតព្វកិច្ចរួចរាល់ជាស្ថាពររៀងៗខ្លួន ។</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;១៧.២.	កិច្ចសន្យានេះត្រូវបានធ្វើឡើងភាសាខ្មែរចំនួន ០៣ (បី) ច្បាប់ ដែលមានខ្លឹមសារ និង មានសុពលភាពអនុវត្តដូចៗគ្នា ដោយរក្សាទុកនៅ៖</td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp; <b>-ភាគី “ក” ចំនួន ០១ ច្បាប់</b> </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp; <b>-ភាគី “ខ” ចំនួន ០១ ច្បាប់</b> </td>
						</tr>
						<tr>
							<td align="left"style="font-family: 'Khmer OS System';">&emsp;&emsp;&emsp;&emsp; <b>-និងរក្សាទុកនៅការិយាល័យមេធាវីចំនួន០១ ច្បាប់។</b> </td>
						</tr>			
										<table class="text-center" style="width:100%;font-size:15px;height:350px;margin-top:-70px;font-family:Khmer OS System">
											<tr>
											<th>ស្នាមមេដៃភាគីភាគី៉៉​​"ក"</th>
											<th>ស្នាមមេដៃភាគីភាគី៉៉​​"ខ"</th>
											</tr>
											<tr>
											<td style="font-family: Khmer OS Muol Light">&emsp;&emsp; សាន រដ្ឋស៊ីង <br> <span style="font-family: Khmer OS System;font-weight:bold;margin-left:30px">(ភាគីម្ចាស់អចលនវត្ថុ)</span></td>
											<td>&emsp;&emsp;​ <b>{{$sale->customer_name}}</b> <br> <span style="font-family: Khmer OS System;font-weight:bold;margin-left:30px">(ភាគីអ្នកទិញ)</span></td>
											</tr>
										</table>
										<table  style="margin-left:30%;width:50%;font-size:15px;height:350px;margin-top:-10px;font-family:Khmer OS System">
											<tr>
											<th></th>
											<th>សាក្សី</th>
											</tr>
											<tr>
											<td>&emsp;&emsp;------------------------- </td>
											<td>&emsp;&emsp;-------------------------</td>
											</tr>
										</table>
										<tr>
											<td> <p  class="text-center" style="font-family: Khmer OS Muol Light">បានឃើញ និងបញ្ជាក់ថា៖</p></td>
										</tr>
										<tr>
											<td ><p class="text-center" style="font-size:16px;font-family:Khmer OS System"> ធ្វើនៅសៀមរាប, ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</b> <br> ភាគីឲខ្ចីប្រាក់ តំណាង-ក្រុមហ៊ុន ភី.អឹម.ប៊ី</p> </td>
										</tr>
										<tr>
											<td> <p  class="text-center" style="font-family: Khmer OS Muol Light">ហត្ថលេខា និងត្រា</p></td>
										</tr>
							</div>
						</div>			
						<br><br><br><br>
										<div class="form-group">
											<hr>
											<button class="btn btn-lg btn-success pull-right" onclick="printFuncsTion();"><i class="fa fa-print" aria-hidden="true"></i>{{ __('item.print_this_page') }}</button>
										<div class="table-responsive" id="table-responsive-2">
											<div class="">
												<div class="content">
													<table class="table">
														<div class="box-logo">
															<img src="{{Setting::get('LOGO')}}" width="50%" height="200%">
														</div>
													<tbody>
														<tr>
																<td style="font-family: 'Khmer OS Muol Light';font-size:20px;color:blue;">ព្រះរាជាណាចក្រកម្ពុជា</td>
															</tr>
															<tr>
																<td style="font-family: 'Khmer OS Muol Light';font-size:20px;color:blue;">ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
															</tr>
															<tr>
																<td style="font-family: 'Tacteing';text-align:center;font-size:40px">6</td>
															</tr>
															<tr><td><p></p></td></tr>
															<tr>
																<td style="text-decoration: underline;font-family: 'Khmer OS Muol Light';font-size:20px">លិខិតទិញ-លក់{{ $sale->p_name }}</td>
															</tr>
															<tr>
																<td>
																	<p class="align-left" style="text-align: justify;">&emsp;&emsp;&emsp;ខ្ញុំបាទ/នាងខ្ញុំឈ្មោះ  <span style="font-family: 'Khmer OS Muol Light';"><b>{{$sale->customer_name}}</b></span> ភេទ <b>{{$sale->customer_gender}} </b>កើតឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_date_of_birht)))}} </b>សញ្ជាតិ <b>{{$sale->customer_nationality}}</b>  មានអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខៈ <b>{{AppHelper::khMultipleNumber((string)$sale->customer_identity)}}</b>  ចុះថ្ងៃទី  <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->cs_ident)))}} </b> ខែ  <b>{{AppHelper::khMultipleNumber(date('m', strtotime($sale->cs_ident)))}} </b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->cs_ident)))}} </b>អាស័យដ្ឋានបច្ចុប្បន្ន ផ្ទះលេខ <b>{{ $sale->cs_house_n}}</b>  ភូមិ <b> {{$sale-> vil_kh}}  </b> ឃុំ/សង្កាត់ <b>{{$sale->com_kh}}</b> ស្រុក/ខណ្ឌ <b>{{$sale->dis_kh}} </b>ក្រុង/ខេត្ត <b>{{$sale->prov_name}}</b> លេខទូរស័ព្ទ <b>{{ $sale->phone1 }}</b>។ </p> 
																</td>
															</tr>
																		<?php
													if($child_item!==[])
													{
														$i=1;
															foreach($child_item as $c)
														{
															?>
															<tr>
																<td>
																	<p align="left"​ style="text-align: justify;">&emsp;&emsp;&emsp;បានព្រមព្រៀងលក់ <b>{{ $c->property_name }}</b>  ចំនួន​​ ១ កន្លែង មានក្បាលដីលេខ <b>{{$c->land_num  }}</b>  បណ្តោយ <b>{{ $c->length }}</b> ម៉ែត្រ   ទទឹង <b>{{ $c->width }}</b> ម៉ែត្រ ទំហំសរុបចំនួន <b>{{ $c->ground_surface }}</b> ម៉ែត្រការ៉េ សិ្ថតក្នុង ផ្លូវលេខ <b>{{ $c->address_street }}</b>​ ផ្ទះលេខ <b>{{ $c->address_number }}</b>  ភូមិ <b>{{ $c->village }}</b> ឃុំ/សង្កាត់ <b>{{ $c->commune }}</b>  ស្រុក/ខណ្ឌ <b>{{ $c->district }}</b> ខេត្ត/ក្រុង <b>{{ $c->province }}</b> ។ 
																</td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;"> មានព្រំប្រទល់ជាប់នឹង៖</p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- ខាងជេីងទល់នឹង <b>{{ $c->boundary_north }}</b>​​ <span style="margin-left:250px">- ខាងត្បូងទល់នឹង <b>{{ $c->boundary_south }} </b></span></p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- ខាងកើតទល់នឹង <b>{{ $c-> boundary_east}}</b><span style="margin-left:255px">- ខាងលិចទល់នឹង <b>{{ $c->boundary_west }} </b></span></p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- លេខលិខិតកម្មសិទ្ធ <b>{{ $c->property_no }}</b> ចុះថ្ងៃទី.......ខែ........ឆ្នាំ.......... </p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- សមត្ថកិច្ចចេញលិខិត........................................</p> </td>
															</tr>

														<?php
														}	
															}else{
																?>
															<tr>
																<td>
																	<p align="left"​ style="text-align: justify;font-family: Khmer OS System">&emsp;&emsp;&emsp;បានព្រមព្រៀងលក់ដី <b>{{ $sale->property_name }}</b>  ចំនួន​​ ១ កន្លែង មានក្បាលដីលេខ <b>{{$sale->land_num  }}</b>  បណ្តោយ <b>{{ $sale->length }}</b> ម៉ែត្រ   ទទឹង <b>{{ $sale->width }}</b> ម៉ែត្រ ទំហំសរុបចំនួន <b>{{ $sale->gf }}</b> ម៉ែត្រការ៉េ សិ្ថតក្នុង ភូមិ <b>{{ $sale->village }}</b> ឃុំ/សង្កាត់ <b>{{ $sale->commune }}</b>  ស្រុក/ខណ្ឌ <b>{{ $sale->district }}</b> ខេត្ត/ក្រុង <b>{{ $sale->province }}</b> ។ 
																</td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;"> មានព្រំប្រទល់ជាប់នឹង៖</p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- ខាងជេីងទល់នឹង <b>{{ $sale->boundary_north }}</b>​​ <span style="margin-left:250px">- ខាងត្បូងទល់នឹង <b>{{ $sale->boundary_south }} </b></span></p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- ខាងកើតទល់នឹង <b>{{ $sale-> boundary_east}}</b><span style="margin-left:255px">- ខាងលិចទល់នឹង <b>{{ $sale->boundary_west }} </b></span></p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- លេខលិខិតកម្មសិទ្ធ <b>{{ $sale->p_pn }}</b> ចុះថ្ងៃទី.......ខែ........ឆ្នាំ.......... </p></td>
															</tr>
															<tr>
																<td><p align="left"​ style="font-size:17px;">- សមត្ថកិច្ចចេញលិខិត........................................</p> </td>
															</tr>
															<?php
															}?>

															<tr>
																<td class="text-center"><b>កិច្ចព្រមព្រៀងនៃកិច្ចសន្យា </b></td>
															</tr>
															<tr>
																<td align="left"​ ><b>ប្រការ១: ភាគីទាំងពីរបានឯកភាពគ្នាបង់ប្រាក់តាមកិច្ចព្រមព្រៀងដូចខាងក្រោម</b></td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;១.ភាគី«ខ»បានយល់ព្រមបង់ប្រាក់ជា…១ ដំណាក់កាលសំរាប់ចំនួន១៥% ចំនួន ១១,៩៨៨$(មួយម៉ឺនមួយពាន់ប្រាបួនរយប៉ែតសិបប្រាំបីដុល្លាអាមេរិកគត់)។</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;២.ភាគី«ខ»បានយល់ព្រមបង់ដំណាក់កាលទី១ កក់បិតផ្ទះ៥០០$(ប្រាំរយដុល្លារអាមេរិក)នៅថ្ងៃទី០១ ខែកុម្ភៈ ឆ្នាំ២០២១ ។</td>
															</tr>
															<tr>
																<td align="left"​><b>ដំណាក់កាលទី២</b> ភាគី«ខ»យល់ព្រមបង់បន្ថែមបង្រ្គប់ ១៥%នៃតម្លៃសរុបស្មើនឹង ១១,៤៨០$(មួយម៉ឺនមួយពាន់បួនរយប៉ែតសិបដុល្លារ) ឪ្យទៅភាគី«ក»</td>
															</tr>
															<tr>
																<td align="left"​><b>ដំណាក់កាលទី៣</b> ភាគី«ខ»នឹងបង់រំលោះចំនួនចាប់ពី ៦០០$(ប្រាំមួយរយដុល្លារ)ឡើងទៅ ក្នុងមួយខែ រហូតដល់១២ខែ(១ឆ្នាំ)គិតចាប់ពីថ្ងៃទី០៨ ខែមេសា ឆ្នាំ២០២១ តទៅ</td>
															</tr>
															<tr>
																<td align="left"​>២.១. ការទទួលខុសត្រូវរបស់ភាគី«ក»</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;    ភាគី«ក» ទទួលខុសត្រូវរត់ការកាត់ឈ្មោះផ្ទេរសិទ្ធិ និងប្រគល់ប្លង់រឹងអោយទៅភាគី«ខ»អោយបានត្រឹមត្រូវតាមច្បាប់ នៅពេលប្រគល់ផ្ទះជូនភាគីខក្នុងកំឡុងពេលបង់បង្រ្គប់១០០%នៃតម្លៃផ្ទះសរុប។</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;    ភាគី«ក» ជាអ្នកទទួលខុសត្រូវលើការចំណាយផ្សេងៗក្នុងការកាត់ឈ្មោះផ្ទេរសិទ្ធិអោយទៅភាគី«ខ»។</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;    ភាគី«ក»ទទួលខុសត្រូវលើការសាងសង់រយះពេល ១២ខែដោយគិតចាប់ពីទទួលលុយកក់គ្រប់ ៣០% អោយរួចរាល់ជូនភាគី«ខ»។ករណីមានការយឺតយ៉ាវ ឬផ្អាកសំណង់ដោយមូលហេតុប្រធានសក្តិ ឬមូលហេតុផ្សេងៗដែលមិនមែនជាកំហុសភាគី “ក”គូភាគីត្រូវជួបចរចាគ្នាដោយសន្តិវិធី យោគយល់និងអធ្យាស្រ័យខ្ពស់រវាងគ្នាដើម្បីដោះស្រាយ។ ប៉ុន្តែប្រសិនបើការយឺតយ៉ាវ ឬផ្អាកសាងសង់កើតឡើងដោយពីកំហុសចេតនារបស់ភាគី”ក”ត្រូវសងសំណងស្មើនឹងអត្រាការប្រាក់ចំនួន១.៥%នៃចំនួនទឹកប្រាក់ដែលភាគី”ក”បានទទួល ។</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;   ករណីប្រធានសក្តិមានន័យថាជាអំពើ ឬស្ថានការណ៍មួយដែលមិនអាចដឹងមុនបាន មិនអាចជៀសបាន និងរារាំងភាគីមិនឪ្យបំពេញកាតព្វកិច្ចរបស់ខ្លួនដែលមានចែងក្នុងកិច្ចព្រមព្រៀងនេះបានហើយដរាបណាអំពើ ព្រឹត្តិការណ៍ ឬស្ថានភាពទាំងនោះហួសពីសមត្ថភាពគ្រប់គ្រង និងមិនមែនកើតឡើងដោយចេតនា ឬដោយខ្វះការប្រិងប្រយ័ត្នរបស់ភាគី។ អំពើ ឬស្ថានភាពទាំងនោះមាន គ្រោះមហន្តរាយធម្មជាតិ រញ្ជួយដី សង្រ្គាម។ល។</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;   ក្នុងករណីមានការខូចខាតកម្មវត្ថុនៃការលក់ទិញខាងលើ ជាយថាហេតុដោយគ្រោះថ្នាក់ធម្មជាតិនោះគូភាគីត្រូវពិភាក្សា ចូលរួមគ្នាដោះស្រាយដោយសន្តិវិធី។</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;   ភាគី«ក»ទទួលដាក់ប្រព័ន្ធភ្លើងចំនួន៣២អាំពែរម៉ែត្រ និងរត់ប្រព័ន្ធទឹករដ្ឋជូនភាគីខ និងរត់ប្រព័ន្ធខែ្សកាបទូរទស្សន៍ អ៊ីនធឺនិតដោយបង្កប់ចូលជាមួយប្រព័ន្ធភ្លើងតែម្តងចូលដល់ក្នុងផ្ទះ។</td>
															</tr>
															<tr>
																<td align="left"​> ២.២. ការទទួលខុសត្រូវរបស់ភាគី«ខ»</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;   ភាគី«ខ»បានសន្យាថានិងបង់ប្រាក់អោយបានទៀងទាត់តាមពេលវេលាដូចដែលបានឯកភាពខាងលើ។</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;   ភាគី«ខ»ប្រសិនបើមានការបង់ប្រាក់យឺតចាប់ពី៣០ថ្ងៃសុខចិត្តទទួលការផាកពិន័យការប្រាក់ 1.5% នៃទឹកប្រាក់ដែលភាគីខមានកាតព្វកិច្ចបង់ជូនភាគី ក ។</td>
															</tr>

															<tr>
																<td align="left"​ ប្រការ៣: អំពីការបន្ថែមសម្ភារៈ</td>
															</tr>
															<tr>
																<td align="left"​>-ថែមជូន ដេគ័រក្នុងផ្ទះ</td>
															</tr>
															<tr>
																<td align="left"​>-ថែមជូន ទូតាំងក្នុងបន្ទប់ទទួលភ្ញៀវ និង សាឡុង</td>
															</tr>
															<tr>
																<td align="left"​>-ថែមជូន ទូចង្រ្កានបាយលើ ក្រោម និងម៉ាស៊ីនបឺតក្លិន</td>
															</tr>
															<tr>
																<td align="left"​>-ថែមជូន វាំងននក្នុងផ្ទះ</td>
															</tr>
															<tr>
																<td align="left"​>-ថែមជូនជាពិសេសសម្រាប់បន្ទប់មេគ្រួសារមានដូចជា៖ គ្រែ ពូក ខ្នើយ ទូខោអាវ ម៉ាស៊ីនត្រជាក់ ម៉ាស៊ីនទឹកក្តៅ ទឹកត្រជាក់ និងទូក្រោមឡាបូ</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;&emsp;  នៅក្នុងទិញលក់នេះភាគី”ក”បានបន្ថែមនូវសម្ភារៈដូចខាងក្រោម</td>
															</tr>
															<tr>
																<td align="left"​>&emsp;&emsp;&emsp;&emsp;កិច្ចព្រមព្រៀងនេះគ្រប់គ្រងដោយច្បាប់នៃព្រះរាជាណាចក្រកម្ពុជា។</td>
															</tr>

															<tr>
																<td align="left"​><b>ប្រការ៤: អវសាន្តនៃកិច្ចសន្យា</b></td>
															</tr>
															<tr>
																<td align="left"​> &emsp;&emsp;ភាគីទាំងពីរបានឯកភាពគ្នាគ្រប់ចំណុចដូចដែលបានចែងក្នុងប្រការទាំងឡាយខាងលើដោយមិនមានការបង្ខិតបង្ខំ ឫក្លែងបន្លំឡើយ។</td>
															</tr>
															<tr>
																<td align="left"​> &emsp;&emsp;កិច្ចសន្យានេះបានចូលជាធរមាន និងមានសុពលភាពចាប់ពីថ្ងៃផ្ដិតមេដៃស្ដាំនេះតទៅ និងបានធ្វើឡើងជា២ច្បាប់ជាភាសាខ្មែរហើយមានតម្លៃស្មើគ្នាចំពោះមុខច្បាប់។</td>
															</tr>
															<tr>
																<td align="right"​>ធ្វើនៅសៀមរាប ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</b></td>
															</tr>
															<tr>
																<td></td>
															</tr>
															<tr>
																<td></td>
															</tr>
																<table style="width:100%;font-size:15px;height:350px;margin-top:-100px;font-family:Khmer OS System">
																	<tr>
																	<th>ស្នាមមេដៃភាគីអ្នកលក់</th>
																	<th>សាក្សីភាគីអ្នកលក់</th>
																	<th>សាក្សីភាគីអ្នកទិញ</th>
																	<th>ស្នាមមេដៃភាគីអ្នកទិញ</th>
																	</tr>
																	<tr>
																	<td>{{$sale->customer_name}}</td>
																	<td>-------------------------</td>
																	<td>{{$sale->employee_name}}</td>
																	<td>យុគ​ ចិត្ត្រា</td>
																	</tr>
																	</table>
																
															
													</tbody>						                	
												  </table>			              		
												  </div>			              		
											</div>					
										</div>												
										<div class="row">
											<div class="col-md-12">
												<div class="pull-left">
													{{-- {!! $customers->appends(\Request::except('page'))->render() !!} --}}
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
			'}</style>';
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
