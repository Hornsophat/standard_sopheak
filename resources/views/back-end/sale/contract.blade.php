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
												<td style="font-size: 13pt; font-family: 'Khmer OS Muol Light';">កិច្ចសន្យាខ្ចីប្រាក់-ដាក់បញ្ចាំ</td>
											</tr>
											<br>
											<!-- <tr style="text-align: unset;">
						                	<td><span style="text-align: justify;padding: 0px;margin:0px;">យោងៈ<span style="font-family: 'Khmer OS System';font-size: 16px;"> -	វិញ្ញាបនបត្រសម្គាល់ម្ចាស់អចលនវត្ថុលេខៈ.....................ចុះថ្ងៃទី....... ខែ........ ឆ្នាំ២០.....។</span></span>
						                	</td> -->
						               </tr>
						               <!-- <tr style="text-align: center;">
						                	<td style="tab-size:8"><p class="p" style="text-align: center !important; tab-size:8!important;">កិច្ចសន្យានេះធ្វើឡើងនៅខេត្តសៀមរាប ចុះថ្ងៃទី {{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} ខែ {{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}} ឆ្នាំ {{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</p></td>
						               </tr> -->
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;១. ភាគីឲខ្ចីប្រាក់៖ ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';">យុគ​ ចិត្រា(YOK CHETRA)</span> ភេទ ប្រុស មុខរបរ​ រកស៊ី មានអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខ ០១១០២៤៤៥៥២​ ចុះថ្ងៃទី​ ០៥​ ខែ ០៨ ឆ្នាំ ២០១៥ ជាតំណាងស្របច្បាប់របស់ ក្រុមហ៊ុន ភី អិម ប៊ី (PMB) អាស័យដ្ឋាន អាស័យដ្ឋាន៖ ភូមិក្បាលស្ពាន1 សង្កាត់ប៉ោយប៉ែត ក្រុងប៉ោយប៉ែត ខេត្តបាត់ដំបង តទៅហៅកាត់ថា​ ភាគី(ក) ។</p>
					                		</td>
					                	</tr><br>
					                	
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;២. ភាគីខ្ចីប្រាក់៖ ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';"><b>{{$sale->customer_name}}</b></span>ភេទ <b>{{$sale->customer_gender}}</b>  កើតនៅ​ ឆ្នាំ​ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_date_of_birht)))}} </b> សញ្ជាតិ <b>{{$sale->customer_nationality}}</b> មានអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខៈ <b>{{AppHelper::khMultipleNumber((string)$sale->customer_identity)}}</b> ចុះថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->cs_ident)))}} </b> ខែ  <b>{{AppHelper::khMultipleNumber(date('m', strtotime($sale->cs_ident)))}} </b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->cs_ident)))}} </b> អាស័យដ្ឋានបច្ចុប្បន្ន​ ផ្លូវលេខ <b>{{ $sale->street_number }}</b> ផ្ទះលេខ <b>{{$sale->cs_house_n}}</b>  ភូមិ <b> {{$sale-> vil_kh}}  </b> ឃុំ/សង្កាត់ <b>{{$sale->com_kh}}</b>  ​ស្រុក/ខណ្ឌ <b>{{$sale->dis_kh }}</b>  រាជធានី/ខេត្ត <b>{{$sale->prov_name}}</b>  ហៅកាត់ភាគី (ខ) ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="float: none;">ភាគី "ក" និង ភាគី "ខ" បានព្រមព្រៀងគ្នាដោយអនុវត្តតាមរាល់ប្រការដូចខាងក្រោម៖</p>
					                		
					                		</td>
					                	</tr>
					                	<tr>
					                		<!-- <td>
					                			ខចែង និងលក្ខខណ្ឌ
					                		</td> -->
					                	</tr>
					                	<tr>
					                		<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ១៖ អំពីលក្ខខណ្ឌរួម
					                		</td>
					                	</tr>
										<tr><td></td></tr><tr><td></td></tr>
										<tr>
										<td align="left" >
										&emsp;&emsp;&emsp; ភាគី "ក" និង ភាគី "ខ" បានព្រមព្រៀងគ្នាដូចតទៅនេះ៖
										</td>
										</tr>
					                	<tr>
					                		<td>
												<p class="p"​><b>&emsp;&emsp;&emsp;១.១</b>
											        <ul>
											            <li><b>{{$property_type_group}}&emsp;&emsp;ការប្រគល់ប្រាក់កម្ចី</b><br>
											            	<table width="100%">
											            		<tr>
												            		<td width="20.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- ភាគី(ក) បានប្រគល់ប្រាក់កម្ចីចំនួន ​​<b>${{$sale->p_pp}}</b>​<b>({{AppHelper::khNumberWord($sale->p_pp)}}ដុល្លាអាមេរិក)</b> អោយទៅភាគី(ខ)<span style="margin-left: 10px">គ្រប់ចំនួន។</span></p></td>

												            	
												            	</tr>
												            	<tr>
																	<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- កាលបរិច្ឆេទប្រគល់ប្រាក់៖ ថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}}</b> ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</b></p></td>
												            	
												            	</tr>
											            	</table>
											            </li>
											        </ul>
											    </p>
					                		</td>
					                	</tr>
					                	<tr>
												<!-- <td>
													<div class="margin-top">
														<p class="p">១.២&emsp;&ensp;តំលៃលក់ៈ តំលៃលក់សរុបគឺៈ<b>  ។</b></p>
													</div>
												</td> -->
											</tr>
											<tr>
					                		<td>
								                <p class="p"​><b>&emsp;&emsp;&emsp;១.២</b>
											        <ul>
											            <li><b>{{$property_type_group}}&emsp;&emsp;ការទទួលប្រាក់កម្ចី</b><br>
											            	<table width="100%">
											            		<tr>
												            		<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- ភាគី(ខ) បានទទួលប្រាក់កម្ចីចំនួន <b>${{$sale->p_pp}}</b> <b>(​{{ AppHelper::khNumberWord($sale->p_pp) }}ដុល្លាអាមេរិក)</b> ពីភាគី(ក)គ្រប់ចំនួន។</p></td>
												            	</tr>
												            	<tr>
																	<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- រយ:ពេលខ្ចីប្រាក់៖ ចំនួន <b>{{ $loan->installment_term }}</b> ខែ គិតចាប់ពីថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($loan->first_pay_date)))}}</b> ខែ <b>{{AppHelper::khMonth(date('m', strtotime($loan->first_pay_date)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($loan->first_pay_date)))}}</b> ដល់ថ្ងៃទី <b>{{AppHelper::khMultipleNumber(date('d', strtotime($effectiveDate)))}} </b>ខែ <b>{{AppHelper::khMultipleNumber(date('m', strtotime($effectiveDate)))}} </b> ឆ្នាំ <span style="margin-left:60px;font-size:17px"> <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($effectiveDate)))}} </b> បានទទួលប្រាក់តទៅ។</span></p></td>
												            	</tr>
											            	</table>
											            </li>
											        </ul>
											    </p>
					                		</td>
					                	</tr>
										<tr>
					                		<td>
								                <p class="p"​><b>&emsp;&emsp;&emsp;១.២</b>
											        <ul>
											            <li><b>{{$property_type_group}}&emsp;&emsp;ការសងប្រាក់ដើម-ការប្រាក់ និង អត្រាការប្រាក់</b><br>
											            	<table width="100%">
											            		<tr>
												            		<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- ការសងប្រាក់ដើម ៖ ភាគី(ខ) មានកាតព្វកិច្ចសងការប្រាក់ និងប្រាក់ដើមវិញនៅរយ:ពេល <b>{{ $loan->installment_term }}</b> ខែ &emsp;&emsp;&emsp;  ​ គិតចាប់ពីថ្ងៃដែលបានទទួលប្រាក់ពី ភាគី(ក)។</p></td>
												            	</tr>
												            	<tr>
																	<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- របៀបបង់ប្រាក់​ ៖​ ភាគី(ខ) ត្រូវបង់ប្រាក់ការរាល់ខែ និងបង់ប្រាក់ដើមតាមការចរចារអោយ ភាគី(ក)</p></td>
												            	</tr>
																<tr>
																	<td width="15.2%" style="padding: 0px;"><p class="p">&emsp;&emsp;&emsp;- អាត្រាការប្រាក់ ៖ អត្រាការប្រាក់%​ <b>{{$loan->interest_rate}} (ភាគរយ)</b> ស្មើនិងចំនួន <b>$​ {{ ($loan->loan_amount * $loan->interest_rate)/100 }}</b> ក្នុងមួយខែ។</p></td>
												            	</tr>
											            	</table>
											            </li>
											        </ul>
											    </p>
					                		</td>
					                	</tr>
											<tr>
											<tr>
					                		<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ២៖ អំពីលក្ខខណ្ឌពិសេស
					                		</td>
					                	</tr>
						                	</tr>
						                	<tr>
										<td align="left" style="font-family: 'Khmer OS system';">
										&emsp;&emsp;&emsp; ក្នុងករណីដែលភាគី(ខ)មិនបានអនុវត្តតាមកិច្ចសន្យាសងប្រាក់អោយភាគី(ក) មានដូចក្នុងលក្ខខណ្ឌរួមខាងលើនោះភាគី(ខ)យល់ព្រមតាមការអនុវត្តដូចខាងក្រោម៖
										</td>
										</tr>
						                	<tr>
						                		<td>
						                			<p class="p"><b>&emsp;&emsp;&emsp;២.១</b> 
						                				<ul>
									                		<li><b>&emsp;&emsp;ការបង់ប្រាក់យឺតយ៉ាវរយ:ពេលខ្លី</b>
									                		</li>
															<tr>
															<td align="left" style="font-family: 'Khmer OS system">
															&emsp;&emsp;&emsp; ក្នុងករណីដែលភាគី(ខ)យឺតយ៉ាវមិនបានបង់ប្រាក់ប្រចាំខែតាមរបៀបបង់ប្រាក់ខាងលើនោះ ភាគី(ខ)យល់ព្រមបង់ប្រាក់ពិន័យដែលត្រូវស្មើនឹង $ <b>{{number_format( $sale->penalty,2) }}</b> ក្នុងមួយថ្ងៃអោយទៅភាគី(ក)។ ដែលលើសពីចំនួនថ្ងៃខកខានបានបង់ប្រាក់រយ:ពេល​ <b>{{ $sale->penalty_of_late_payment }} </b> ថ្ងៃបន្ទាប់ អោយភាគី(ក​)។
															</td>
															</tr>
									                	</ul>
									                </p>
						                		</td>
						            		</tr>
						                	<tr>
						                		<td>
						                			<p class="p"><b>&emsp;&emsp;&emsp;២.២</b> 
						                				<ul>
									                		<li><b>&emsp;&emsp;ការបង់ប្រាក់យឺតយ៉ាវរយ:ពេលវែង</b>
									                		</li>
															<tr>
															<td align="left" style="font-family: 'Khmer OS system">
															&emsp;&emsp;&emsp; ករណីដែលភាគី(ខ) យឺតយ៉ាវក្នុងការបង់ប្រាក់ប្រចាំខែដូចដែលបានព្រមព្រៀងគ្នាក្នុងរយៈពេល ០២ ខែជាប់គ្នា ឬ៦០ថ្ងៃជាប់គ្នាឡើង នោះភាគី(ក)មានសិទ្ធក្នុងការដក់ហូតយកទ្រព្យសម្បត្តិដែល ភាគី(ខ)បានដាក់បញ្ចាំ មកជាទ្រព្យសម្បត្តិ
															របស់ភាគី(ក)។ ករណីដែលភាគី(ខ) មិនមានដាក់ទ្រព្យបញ្ចាំនោះ ភាគី(ក)នឹងដាក់ពាក្យបណ្តឹងអាជ្ញាធរមានសមត្ថកិច្ចទៅតាមរាល់ឯកសារដែលភាគី(ក)មាន។
															</td>
															</tr>
									                	</ul>
									                </p>
						                		</td>
						            		</tr>
						                	<tr>
						                		<td>
						                			<p class="p"><b>&emsp;&emsp;&emsp;២.៣</b> 
						                				<ul>
									                		<li><b>&emsp;&emsp;ការរំលាយកិច្ចសន្យាដោយភាគី(ក)</b>
									                		</li>
															<tr>
															<td align="left" style="font-family: 'Khmer OS system">
															&emsp;&emsp;&emsp; ករណីដែលភាគី(ខ) មិនសងបំណុលតាមកាលកំណត់ដូចមានក្នុងកិច្ចសន្យាហើយ ភាគី(ក)យល់ឃើញថាបំណុលនោះនិងត្រូវបាត់បង់ នោះភាគី(ខ)យល់ព្រមឲ្យភាគី(ក)រំលាយកិច្ចសន្យានេះមុនកាលកំណត់ដោយ ឯកតោភាគី និង ឥតលក្ខខណ្ឌ។ក្នុងករណីនេះ ភាគី(ខ)មានកាតព្វកិច្ចសងប្រាក់ទៅភាគី(ក)វិញទាំងអស់រួមមាន៖<br><b>ប្រាក់ដើមនៅសល់ + ការប្រាក់ + ប្រាក់ពិន័យ<b> ដែលភាគី(ខ)នៅជំពាក់។
															</td>
															</tr>
									                	</ul>
									                </p>
						                		</td>
						            		</tr>
						                	<tr>
						                		<td>
						                			<p class="p"><b>&emsp;&emsp;&emsp;២.៤</b> 
						                				<ul>
									                		<li><b>&emsp;&emsp;ការរំលាយកិច្ចសន្យាមុនកាលកំណត់</b>
									                		</li>
															<tr>
															<td align="left" style="font-family: 'Khmer OS system">
															&emsp;&emsp;&emsp; ក្នុងករណីដែលភាគី(ខ) បង់ប្រាក់ដើមទៅឲ្យភាគី(ក) វិញមួយផ្នែកឫទាំងអស់មុនកាលកំណត់ ការប្រាក់ត្រូវបានកាត់បន្ថយដោយគណនាសមាមាត្រទៅនឹងចំនួនថ្ងៃដែលបានសងមុនកាលកំណត់នោះ ការប្រាក់ត្រូវគិតលើសមតុល្យប្រាក់កម្ចី នៅសល់ជាក់ស្តែងគឺ៖<br><b>ប្រាក់ដើមនៅសល់ + ការប្រាក់តាមចំនួនថ្ងៃ + ប្រាក់ពិន័យ។</b>
															</td>
															</tr>
									                	</ul>
									                </p>
						                		</td>
						            		</tr>
						                	<tr>
						                		<td>
						                			<p class="p"><b>&emsp;&emsp;&emsp;២.៥</b> 
						                				<ul>
									                		<li><b>&emsp;&emsp;ការខកខានក្នុងការសងបំណុល</b>
									                		</li>
															<tr>
															<td align="left" style="font-family: 'Khmer OS system">
															&emsp;&emsp;&emsp;ក្នុងករណីដែលភាគី(ខ)ខកខានមិនបានសងបំណុលដោយកត្តាហេតុណាមួយ នោះអ្នកស្នងមរតកដែលហៅកាត់ថាភាគី(តតិយជន)ត្រូវសងបំណុលជំនួសភាគី(ខ) រហូតដល់បំណុលត្រូវបានសង់ចប់។
															</td>
															</tr>
									                	</ul>
									                </p>
						                		</td>
						            		</tr>
						                
				                			<tr>
						                		<td>
						                			<p class="p"><b>&emsp;&emsp;&emsp;២.៦</b> 
						                				<ul>
									                		<li><b>&emsp;&emsp;កាតព្វកិច្ច អ្នករួមខ្ចី និងអ្នកធានា</b>
									                		</li>
															<tr>
															<td align="left" style="font-family: 'Khmer OS system">
															&emsp;&emsp;&emsp; ភាគីអ្នករួមខ្ចី និងអ្នកធានា មានកាតព្វកិច្ចសងប្រាក់ដូចភាគីអ្នកខ្ចីប្រាក់ដែរ ក្នុងករណីដែលភាគីអ្នកខ្ចីប្រាក់ខកខានមិនបានសងប្រាក់ ហើយមានការទាមទារឲ្យបង់ប្រាក់ពីភាគី(ក) ឫពីក្រុមហ៊ុន ភី.អិម.ប៊ី (PMB)។
															</td>
															</tr>
									                	</ul>
									                </p>
						                		</td>
						            		</tr>
											<tr>
						                		<td>
						                			<p class="p"><b>&emsp;&emsp;&emsp;២.៧</b> 
						                				<ul>
									                		<li><b>&emsp;&emsp;ការផុតកំណត់នៃកិច្ចសន្យា</b>
									                		</li>
															<tr>
															<td align="left" style="font-family: 'Khmer OS system">
															&emsp;&emsp;&emsp; ក្នុងករណីដែលកិច្ចសន្យាខ្ចីប្រាក់នេះដល់កាលកំណត់ ហើយភាគី(ខ)មិនសងការប្រាក់ និងប្រាក់ដើមឲ្យភាគី(ក)វិញក្នុងរយៈពេលចាប់ពី ០២ខែ ឬលើសពី ៦០ថ្ងៃឡើងទៅ នោះភាគី(ក)មានសិទ្ធស្របច្បាប់ក្នុងការដក់ហូតយកទ្រព្យសម្បត្តិដែលភាគី(ខ)បានដាក់បញ្ចាំ មកជាទ្រព្យសម្បត្តិរបស់ភាគី(ក) ឬក្រុមហ៊ុន ភី.អិម.ប៊ី (PMB) ដោយឥតលក្ខខណ្ឌ។
															</td>
															</tr>
									                	</ul>
									                </p>
						                		</td>
						            		</tr>
											
											<tr>
					                		<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ៣៖ អំពីលក្ខខណ្ឌអវសាន
					                		</td>
					                	</tr>
										<tr>
											<td></td>
										</tr>
					                	<tr>
					                		<td>
					                			<div class="margin-top-10">
					                				<p class="p">&emsp;&emsp;​  ភាគី(ក) និងភាគី(ខ)សន្យាយ៉ាងម៉ឺងម៉ាតគោរពតាមរាល់ប្រការនៃកិច្ចសន្យាខាងលើ។ ក្នុងករណីមានការអនុវត្តផ្ទុយឬរំលោភលើលក្ខខណ្ឌណាមួយនៃកិច្ចសន្យានេះ ភាគីដែលល្មើសត្រូវទទួលខុសត្រូវចំពោះមុខច្បាប់ជាធរមាន។ រាល់សោហ៊ុយចំណាយទាក់ទងនិងការដោះស្រាយវិវាទជាបន្ទុករបស់ភាគី(ខ)ដែលរំលោភបំពានលើកិច្ចសន្យា។</p>
					                			</div>
					                		</td>
					                	</tr>
					                	<td align="left"​ style="font-family: 'Khmer OS Muol Light';">
					                			ប្រការ៤៖ ទ្រព្យបញ្ចាំ 
					                		</td>
					                	</tr>
										<tr>
											<td></td>
										</tr>
					                	<tr>
					                		<td>
					                			<div class="margin-top-10">
					                				<p class="p">&emsp;&emsp;ដើម្បីអោយមានភាពជាក់លាក់​ មានសុវត្ថិភាព និងមានទំនុកចិត្តក្នុងការខ្ចីប្រាក់ ភាគី(ខ)បានយល់ព្រមដាក់តំកល់ទ្រព្យសម្បត្តិឲភាគី(ក) ឬក្រុមហ៊ុន ភី.អិម.ប៊ី ដូចខាងក្រោម៖​​	 </p>
					                			</div>
					                		</td>
					                	</tr>
										
										<table style="border:1px solid black;width:100%;height:150px">
										<tr  style="border:1px solid black;height:40px;font-size:15px;">
										<th style="border-right:1px solid black !important;font-family:Khmer OS System">&emsp;&emsp;&emsp;រាយមុខទ្រព្យសម្បត្តិដាក់បញ្ចាំ </th>
										<th style="border-right:1px solid black !important;text-align:center;font-family:Khmer OS System">ចំនួន </th>
										<th style="border-right:1px solid black !important;text-align:center;font-family:Khmer OS System">តំលៃ</th>
										</tr>
										 <tr>
											<td style="border-right:1px solid black !important;font-size:15px;font-family:Khmer OS System">&emsp;&emsp;១-ប្រភេទទ្រព្យសម្បត្តិ​​: <br>&emsp;&emsp;&emsp; ១.​ ម៉ាក<b> {{ $sale->p_name }}</b>​​ <br>&emsp;&emsp;&emsp;  ម៉ូឌែល <b>{{ $sale->model }}</b> <br>&emsp;&emsp;&emsp; លេខម៉ាស៊ីន <b>{{ $sale->p_nb }}</b> <br>&emsp;&emsp;&emsp;  លេខតួ <b>{{ $sale->p_pn }}</b> ​<br>&emsp;&emsp;&emsp;  ឆ្នាំផលិត <b>{{ $sale->p_date }}</b>។ <br>&emsp;&emsp;&emsp; ពណ៌ <b>{{ $sale->p_vihi }}</b></td>
											<td style="border-right:1px solid black !important;text-align:center;font-size:15px;font-family:Khmer OS System"> 1</td>
											<td style="border-right:1px solid black !important;text-align:center;font-size:15px;font-family:Khmer OS System">${{$sale->p_pp}}</td>
										 </tr>
										</table>
										
										<tr>
					                		<td>
					                			<div class="margin-top-10" style="font-size:15px;margin-top:12px;font-family:Khmer OS System">
					                				<p class="p"> កិច្ចសន្យានេះត្រូវបានធ្វើឡើងជា 02 ច្បាប់ដើម ដើម្បីតម្កល់នៅ៖ <br>
													ភាគី(ខ) 01 ច្បាប់ដើម<br> ភាគី(ក) 01 ច្បាប់ដើម</p>
					                			</div>
					                		</td>
					                	</tr>
										<tr>
											<td ><p class="text-right" style="font-size:16px;font-family:Khmer OS System"> ក្រុងប៉ោយប៉ែត, ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</b> <br> ភាគីឲខ្ចីប្រាក់ តំណាង-ក្រុមហ៊ុន ភី.អឹម.ប៊ី</p> </td>
										</tr>
										<tr>
											<td><p class="text-left" style="font-size:16px;font-family:Khmer OS System">ស្នាមមេដៃស្តាំភាគី(ខ) និងសាក្សី</p></td>
										</tr>
										
										<table style="width:100%;font-size:15px;height:350px;margin-top:-90px;font-family:Khmer OS System">
											<tr>
											<th>ភាគីខ្ចីប្រាក់ ភាគី(ខ)</th>
											<th>សាក្សីខាងភាគី(ខ)</th>
											<th>សាក្សីខាងភាគី(ក)</th>
											<th>ស្នាមមេដៃស្តាំ ភាគី(ក)</th>
											</tr>
											<tr>
											<td>&emsp;&emsp; {{$sale->customer_name}}</td>
											<td>&emsp;&emsp;-------------------------</td>
											<td>&emsp;&emsp;{{$sale->employee_name}}</td>
											<td>&emsp;&emsp;យុគ​ ចិត្ត្រា</td>
											</tr>
										</table>
									</div>
							</div>
						</div>			
										<div class="form-group mt-2">
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
																<td style="text-decoration: underline;font-family: 'Khmer OS Muol Light';font-size:20px">លិខិតទិញ-លក់ឡាន</td>
															</tr>
															<tr>
																<td>
																	<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp; ភាគីអ្នកលក់៖ ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';"><b>{{$sale->customer_name}}</b></span> ភេទ <b>{{$sale->customer_gender}} </b>កើតឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_date_of_birht)))}} </b>សញ្ជាតិ <b>{{$sale->customer_nationality}}</b>  មានអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខៈ <b>{{AppHelper::khMultipleNumber((string)$sale->customer_identity)}}</b>  ចុះថ្ងៃទី  <b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->cs_ident)))}} </b> ខែ  <b>{{AppHelper::khMultipleNumber(date('m', strtotime($sale->cs_ident)))}} </b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->cs_ident)))}} </b>អាស័យដ្ឋានបច្ចុប្បន្ន ផ្ទះលេខ <b>{{ $sale->cs_house_n}}</b>  ភូមិ <b> {{$sale-> vil_kh}}  </b> ឃុំ/សង្កាត់ <b>{{$sale->com_kh}}</b> ស្រុក/ខណ្ឌ <b>{{$sale->dis_kh}} </b>ក្រុង/ខេត្ត <b>{{$sale->prov_name}}</b> លេខទូរស័ព្ទ <b>{{ $sale->phone1 }}</b> ។ បានលក់យានជំនិះ ចំនួន <b>1{{ $sale->p_quan }}</b> គ្រឿង ម៉ាក <b> {{$sale-> p_name  }}</b> មានភិនភាគដូចខាងក្រោម៖
																</td>
															</tr>
															<tr>
																<td><p class="pull-left" style="font-size:17px;font-family:Khmer OS System">- លេខម៉ាស៊ីន  <span style="margin-left:50px"> : <b>{{ $sale->p_nb }}</b></span></p></td>
															</tr>
															<tr>
																<td><p class="pull-left" style="font-size:17px;font-family:Khmer OS System">-  លេខតួ <span style="margin-left:87px"> : <b>{{ $sale->p_pn }}</b></span></p></td>
															</tr>
															<tr>
																<td><p class="pull-left" style="font-size:17px;font-family:Khmer OS System">-  ឆ្នាំផលិត <span style="margin-left:74px"> : ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->p_date)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->p_date)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->p_date)))}}</b></span></p></td>
															</tr>
															<tr>
																<td><p class="pull-left" style="font-size:17px;font-family:Khmer OS System">-  ពណ៌ <span style="margin-left:100px"> :<b> {{ $sale->p_vihi }}</b></span></p></td>
															</tr>
															<tr>
																<td><p class="pull-left" style="font-size:17px;font-family:Khmer OS System">-  ផ្លាកលេខ <span style="margin-left:68px"> :<b> {{ $sale->number_plate }}</b></span></p></td>
															</tr>
														
																<tr>
																	<td><p class="text-left" style="font-size:18px;font-family:Khmer OS System">ឲទៅអ្នកទិញ ឈ្មោះ យុគ ចិត្រ្តា ភេទ ប្រុស មុខរបរបច្ចុប្បន្ន រកស៊ី មានអត្តសញ្ញាណប័ណ្ណ សញ្ញាតិខ្មែរលេខ 011024552 ចុះថ្ងៃទី ០៥​ ខែ ០៨ ឆ្នាំ ២០១៥ ជាតំណាងឲក្រុមហ៊ុន ភី អ៊ីម ប៊ី (PMB) អាស័យដ្ឋានបច្ចុប្បន្ន ផ្ទះលេខ ៥៦CE0 ផ្លូវលេខ ១២២ ភូមិ​ ៩ សង្កាត់ផ្សារដេប៉ូទី៣ ខណ្ឌទួលគោក រាជធានីភ្នំពេញ។ <br>  ក្នុងតម្លៃ USD <b>{{$sale->p_pp}}</b>  ចំនួនទឹកប្រាក់ជាអក្សរ <b> (&nbsp;​{{ AppHelper::khNumberWord($sale->p_pp) }}</b> ដប់ពាន់ដុល្លារអាមេរិកគត់	)</p></td>
																</tr>
																<tr>
																	<td class="text-left" style="font-size:18px;font-family:Khmer OS System"><b style="font-family:Khmer OS Muol Light">បញ្ជាក់: </b>ខ្ញុំបាទ/នាងខ្ញុំ ឈ្មោះ <b>{{$sale->customer_name}}</b>​ ភេទ <b>{{ $sale->customer_gender }} </b>គឺជាអ្នកលក់សូមធានាអះអាង ប្លង់ដីនេះគឺជាកម្មសិទ្ធស្របច្បាប់របស់ខ្ញូំបាទ/នាងខ្ញុំ និងមិនមានជាប់បន្ទុកនៅក្នុងស្ថាប័ន ឬធនាគារណាមួយឡើយ បើមិនពិត ខ្ញុំបាទ/នាងខ្ញុំសូមទទួលខុសត្រូវចំពោះមុខច្បាប់នៃព្រះរាជាណាចក្រកម្ពុជា ជាធរមាន។</td>
																</tr>

																<tr>
																	<td class="text-right"><p style="font-family:Khmer OS System"> ក្រុងប៉ោយប៉ែត, ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</b> <br> តំណាង-នាយកក្រុមហ៊ុន ភី អឹម ប៊ី</p> </td>
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
