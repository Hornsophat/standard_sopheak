@php
	use App\Helpers\AppHelper;
@endphp
   	<div class="row" style="display: block;">
        <div class="col-md-12">
				@include('flash/message')
       		<div class="tile">
       			<div class="row">
       				<div class="col-md-12">
       					<div class="form-group">
		       				<button class="btn btn-lg btn-success pull-right btnPrint" onclick="printFunc();"><i class="fa fa-print" aria-hidden="true"></i>{{ __('item.print_this_page') }}</button>
		       			</div>
       				</div>
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
											<img src="{{Setting::get('LOGO')}}" width="100%" height="100%">
										</div>
				                	<tbody>
				                		<tr>
												<td>ព្រះរាជាណាចក្រកម្ពុជា</td>
											</tr>
											<tr>
												<td>ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
											</tr>
											<tr><td><p></p></td></tr>
											<tr>
												<td style="text-decoration: underline;font-size: 13pt;">កិច្ចសន្យាទិញ-លក់ផ្ទះល្វែង</td>
											</tr>
											<tr style="text-align: unset;">
						                	<td><span style="text-align: justify;padding: 0px;margin:0px;">យោងៈ<span style="font-family: 'Khmer OS System';font-size: 16px;"> -	វិញ្ញាបនបត្រសម្គាល់ម្ចាស់អចលនវត្ថុលេខៈ.....................ចុះថ្ងៃទី....... ខែ........ ឆ្នាំ២០.....។</span></span>
						                	</td>
						               </tr>
						               <tr style="text-align: center;">
						                	<td style="tab-size:8"><p class="p" style="text-align: center !important; tab-size:8!important;">កិច្ចសន្យានេះធ្វើឡើងនៅខេត្តសៀមរាប ចុះថ្ងៃទី {{AppHelper::khMultipleNumber(date('d', strtotime($sale->sale_date)))}} ខែ{{AppHelper::khMonth(date('m', strtotime($sale->sale_date)))}} ឆ្នាំ{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->sale_date)))}}</p></td>
						               </tr>
					                	<tr>
					                		<td>រវាង</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;លោក <span style="font-family: 'Khmer OS Muol Light';">--------------------</span> កើតឆ្នាំ....... ជនជាតិខ្មែរ កាន់អត្តសញ្ញានប័ណ្ណលេខៈ.................. ចុះថ្ងៃទី........... ខែមិថុនា ឆ្នាំ២០១៩ មានទីលំនៅបច្ចុប្បន្ន.......... ឃុំ......... ស្រុក............ ខេត្ត...... ជាអ្នកលក់ ហៅកាត់ភាគី (ក) ។</p>
					                		</td>
					                	</tr><br>
					                	<tr>
					                		<td>និង</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';">{{$sale->customer_name}}</span> ភេទ{{$sale->customer_gender}} កើតឆ្នាំ{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_date_of_birht)))}} សញ្ជាតិ{{$sale->customer_nationality}} កាន់អត្តសញ្ញាណប័ណ្ណលេខៈ{{AppHelper::khMultipleNumber((string)$sale->customer_identity)}}(០១) ចុះថ្ងៃទី{{AppHelper::khMultipleNumber(date('d', strtotime($sale->customer_identity_set_date)))}} ខែ{{AppHelper::khMonth(date('m', strtotime($sale->customer_identity_set_date)))}} ឆ្នាំ{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_identity_set_date)))}} មានទីលំនៅភូមិ{{$sale->cs_village_name}} ឃុំ/សង្កាត់{{$sale->cs_commune_name}} ស្រុក/ខណ្ឌ{{$sale->cs_district_name}} ខេត្ត/ក្រុង{{$sale->cs_province_name}} ជាភាគីអ្នកទិញ ហៅកាត់ភាគី (ខ) ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: center;float: none;">ភាគី "ក" និង ភាគី "ខ" ហៅដាច់ដោយឡែកពីគ្នា ភាគីនឹងហៅរួមគ្នាថា "គូភាគី"។</p>
					                			<span style="font-family: 'Khmer OS System';font-size: 16px;text-align: center;">គូភាគីបានស្ម័គ្រចិត្ត ចុះកិច្ចសន្យានេះ ក្រោមខចែង និងលក្ខខណ្ឌដូចតទៅៈ</span>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			ខចែង និងលក្ខខណ្ឌ
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ១៖ កម្មវត្ថុ នៃការទិញ លក់ៈ
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
								                <p class="p">១.១
											        <ul>
											            <li>{{$sale->item_type_group}}លក់(តទៅនេះហៅថា"អចលនទ្រព្យ")៖ ភាគី "ក" ឯកភាពលក់ទៅឲ្យភាគី "ខ" និងភាគី "ខ" ឯកភាពទិញពី ភាគី "ក"  នូវ{{$sale->item_type_group}}ចំនួន@if(count($sale_details)<10)០@endif{{ AppHelper::khMultipleNumber(1) }}{{$sale->item_type_extension}}({{ $sale->item_name }})  ដែលមានក្បាលដីលេខៈ{{ isset($sale->item_number)?$sale->item_number:'...........' }} ស្ថិតនៅក្នុងភូមិ{{isset($sale->village_name)?$sale->village_name:'........'}} សង្កាត់{{isset($sale->district_name)?$sale->district_name:'........'}} ក្រុង/ខេត្ត{{isset($sale->province_name)?$sale->province_name:'........'}} ។<br>
											            	<table width="100%">
											            		<tr>
												            		<td width="15.2%" style="padding: 0px;"><p class="p">មានព្រំប្រទល់ៈ</p></td>
												            		<td width="40%" style="padding: 0px;"><p class="p">ខាងកើតទល់នឹង{{ $sale->east }}</p></td>
												            		<td width="35%" style="padding: 0px;"><p class="p">ខាងលិចទល់នឹង{{ $sale->west }}</p></td>
												            	</tr>
												            	<tr>
												            		<td width="15.2%" style="padding: 0px;"><p class="p"></p></td>
												            		<td width="40%" style="padding: 0px;"><p class="p">ខាងជើងទល់នឹង{{ $sale->north }}</p></td>
												            		<td width="35%" style="padding: 0px;"><p class="p">ខាងត្បួងទល់នឹង{{ $sale->south }}</p></td>
												            	</tr>
											            	</table>
											            </li>
											        </ul>
											    </p>
					                		</td>
					                	</tr>
					                	<tr>
												<td>
													<div class="margin-top">
														<p class="p">១.២&emsp;&ensp;តំលៃលក់ៈ តំលៃលក់សរុបគឺៈ<b>{{AppHelper::khMultipleNumber(number_format($sale->total_price-$sale->discount_amount,0))}}USD ({{AppHelper::khNumberWord($sale->total_price-$sale->discount_amount)}}) ។</b></p>
													</div>
												</td>
											</tr>
					                	<tr>
					                		<td align="left">
					                			<div class="td-margin-top td-margin">
						                			<p class="p">១.៣&emsp;&ensp;អំពី{{$property_type}}ក្នុងមួយ{{$property_type_extension}}</p><br>
						                			<ul style="float: left;" class="ul">
					                					@php
					                						$abouts = explode("&&$,$&&", $sale->item_abouts);
					                					@endphp
				                						@foreach($abouts as $key => $about)
				                							@if($about!=null && $about!='')
				                							<li style="list-style-type: none;">{{ AppHelper::khCharacter($key) }} {{$about}}</li>
				                							@endif
				                						@endforeach
													</ul>
												</div>
					                		</td>
					                	</tr>
											<tr>
												<td align="left">ប្រការ២៖ ការប្រគល់ប្រាក់ថ្លៃលក់អចលនវត្ថុ</td>
											</tr>
											<tr>
						                		<td><p class="p">២.១
						                			<ul>
						                				<li><b>ការប្រគល់ប្រាក់ដំណាក់កាលលើកទី១</b>	៖ ភាគី "ខ" ត្រូវប្រគល់ប្រាក់ចំនួនៈ<b>{{AppHelper::khMultipleNumber(number_format($first_payment->loan_amount,0))}}USD ({{AppHelper::khNumberWord($first_payment->loan_amount)}})</b> ទៅឲ្យភាគី"ក"នៅថ្ងៃទី{{AppHelper::khMultipleNumber(date('d', strtotime($first_payment->first_pay_date)))}} ខែ{{AppHelper::khMonth(date('m', strtotime($first_payment->first_pay_date)))}} ឆ្នាំ{{AppHelper::khMultipleNumber(date('Y', strtotime($first_payment->first_pay_date)))}} ។</li>
						                			</ul>
						                		</p>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<div class="margin-top">
						                				<p class="p">២.២
								                			<ul>
								                				@php
								                					$paybymonth=0;
								                					$payments_length = count($payment_schedules);
								                					$total_spend = 0;
								                					foreach ($payment_schedules as $key => $value) {
								                						$paybymonth+=$value->amount_to_spend;
								                						$total_spend+=$value->amount_to_spend;
								                					}
								                					$paybymonth = $paybymonth/$payments_length;
								                				@endphp
								                				<li><b>ការប្រគល់ប្រាក់ដំណាក់កាលលើកទី២៖</b>ភាគី "ខ" ត្រូវប្រគល់ប្រាក់ឲ្យបានចំនួនៈ<b>{{AppHelper::khMultipleNumber(number_format($paybymonth))}}USD ({{AppHelper::khNumberWord($paybymonth)}})</b>ទៅឲ្យភាគី"ក"ជារៀងរាល់ខែក្នុងរយៈពេល@if($payments_length<10)០@endif{{AppHelper::khMultipleNumber($payments_length)}}ខែដែលស្នើនិងចំនួនៈ<b>{{AppHelper::khMultipleNumber(number_format($total_spend,0))}}USD({{AppHelper::khNumberWord($total_spend)}})</b> ឬនៅពេលដែលផ្ទះពីរល្វែងខាងលើបានសាងសង់រួចរាល់ ។
										                		</li>
										                	</ul>
									                	</p>
								                	</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="left">
						                			<div class="margin-top">
							                			<p class="p">២.៣
							                				@php
							                					$total_to_spend_future = ($sale->grand_total+$sale->total_loan_amount+$sale->deposit)-($installment_payment->loan_amount+$first_payment->loan_amount)
							                				@endphp
							                				<ul>
							                					<li><b>ការបង់ប្រាក់បង្រ្គប់ ៖</b>ការបង់ប្រាក់បង្គ្រប់ដែលនៅសល់ចំនួនៈ<b>{{AppHelper::khMultipleNumber(number_format($total_to_spend_future))}}USD ({{AppHelper::khNumberWord($total_to_spend_future)}})</b> ទៀតគឺត្រូវធ្វើឡើងនៅពេលដែលភាគី”ក”បានសាងសង់ផ្ទះរួចរាល់ ឬនៅពេលដែលភាគី”ក”បានកាត់ឈ្មោះផ្ទេរសិទិ្ធរួចរាល់ទៅឲ្យភាគី”ខ”  ។
								                				</li>
								                			</ul>
							                			</p>
							                		</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="left">
						                			<div class="td-margin-top">ប្រការ៣៖ ការកាត់ឈ្មោះផ្ទេរសិទ្ធិកម្មសិទ្ធិ</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<p class="p">៣.១
						                				<ul>
									                		<li>
									                		ភាគី "ក" ត្រូវរត់ការកាត់ឈ្មោះផ្ទេកម្មសិទ្ធិ លើអចលនទ្រព្យទៅឲ្យភាគី "ខ" ក្នុងរយៈពេល០២ខែ បន្ទាប់ពីផ្ទះបានសាងសង់ជិតរួចរាល់៩០%(កៅសិប) ភាគរយ។
									                		</li>
									                	</ul>
									                </p>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<div class="margin-top">
							                			<p class="p">៣.២
							                				<ul>
							                					<li>រាល់សោហ៊ុយចំណាយ ដែលពាក់ព័ន្ធនឹងការកាត់ឈ្មោះផ្ទេរកម្មសិទ្ធិលើអចលនទ្រព្យនេះទៅ ភាគី "ខ" រួមទាំងការបង់ពន្ធ គឺជាបន្ទុកទទួលខុសត្រូវរបស់ភាគី "ក" ទាំងស្រុង។
								                				</li>
								                			</ul>
								                		</p>
						                			</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="left">
						                			<div class="td-margin-top">ប្រការ៤៖ ការចូលកាន់កាប់</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<p class="p">៤.១
						                				<ul>
						                					<li>ភាគី "ខ" មានសិទ្ធិកាន់កាប់អចលនវត្ថុខាងលើនេះតាមការកំណត់ក្នុងប្រការប្រការ២.១ខាងលើនេះ ។
						                					</li>
						                				</ul>
						                			</p>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="left">
						                			<div class="td-margin-top">ប្រការ៥៖ ការធានា និងការអះអាងរបស់ ភាគី "ក"</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
							                		<p class="p">៥.១
								                		<ul>
								                			<li>ភាគី "ក" ធានាអះអាងថា អចលនទ្រព្យក្នុងកិច្ចសន្យានេះ ពិតជាទ្រព្យកម្មសិទ្ធិស្របច្បាប់របស់ខ្លួន និងមិនជាប់បំណុល ការផ្ទេរ ការធ្វើអំណោយ ឬចាត់ចែងផ្សេងទៀត ឬជាប់ដីការឃាត់ទុករបស់តុលាការមានសមត្តកិច្ច ជាអាទិ៍ឡើយ។
								                			</li>
								                		</ul>
							                		</p>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<div class="margin-top margin-1">
							                			<p class="p">៥.២
							                				<ul>
							                					<li>ភាគី "ក" ត្រូវទទួលខុសត្រូវ និងរ៉ាប់រងលើការចំណាយសំរាប់ដោះស្រាយបញ្ហានានា ពាក់ព័ន្ធនឹងការទាមទារផ្សេងៗពីតតិយជន លើសិទ្ធិកាន់កាប់នៃអចលនទ្រព្យលក់នេះ។ និងធានាលើសំណងក្នុងការជុសជុលរយៈពេលមួយឆ្នាំបន្ទាប់ផ្ទះសាងសង់រួចរាល់។
							                					</li>
							                				</ul>
							                			</p>
							                		</div>
						                		</td>
						                	</tr>
						                
				                			<tr>
						                		<td align="left">
						                			<div class="td-margin-top">ប្រការ៦៖ កំហុស និងការទទួលខុសត្រូវរបស់គូភាគី</div>
						                		</td>
						                	</tr>
				                			<tr>
												<td align="left">
													<p class="p">៦.១
													<ul>
														<li>ករណីភាគី "ក" ធ្វើការកែប្រែឈប់លក់អចលនទ្រព្យ ឬគេសវេស ឬបដិសេធ មិនធ្វើការផ្ទេរកម្មសិទ្ធិដីទៅឲ្យភាគី "ខ" ជាអាទិ នោះភាគី "ក" ត្រូវវសងទៅភាគី "ខ" នូវប្រាក់ចំនួនពីរដងនៃប្រាក់ដែលភាគី "ខ" បានប្រគល់ឲ្យភាគី "ក"  ។</li>
													</ul>
												</p>
												</td>
											</tr>
											<tr>
												<td>
													<div class="margin-top">
														<p class="p">៦.២
															<ul>
																<li>ក្នុងករណីដែលភាគី"ខ"មិនបានអនុវត្តកតព្វកិច្ចដែលបានព្រមព្រៀងក្នុងកិច្ចសន្យានេះ ពិសេសកាតព្វកិច្ចនៃការបង់ប្រាក់ក្នុងប្រការ២ខាងលើ ឬសម្រេចចិត្តឈប់ទិញអចលនទ្រព្យពីភាគី "ខ" ដោយសារមូលហេតុណាមួយដែលមិនមែនកើតចេញពីកំហុសរបស់ភាគី "ក" នោះត្រូវចាត់ទុកថាភាគី "ខ"  បោះបង់ប្រាក់កក់ដែលខ្លួនបានបង់ទៅឲ្យភាគី "ក" ទាំងអស់ ហើយ ភាគី "ខ"  ទទួលរ៉ាប់រងលើការរត់ការផ្ទេរកម្មសិទ្ធិលើអចលនទ្រព្យ ទៅឲ្យភាគី "ក" វិញ រួមទាំងសោហ៊ុយចំណាយទាំងស្រុង សំរាប់ការផ្ទេរនេះ បើសិនភាគី  "ក" បានផ្ទេរកម្មសិទ្ធិលើអចលនទ្រព្យនោះរួចរាល់ក្នុងដំណាក់កាលណាមួយ។
																</li>
															</ul>
														</p>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="margin-top">
														<p class="p">
															៦.៣
															<ul>
																<li>ភាគី”ខ” ត្រូវរៀបចំប្រគល់ឯកសារនានាដែលពាក់ព័ន្ធ ទៅនិងការកាត់ឈ្មោះផ្ទេរសិទិ្ធអោយបានគ្រប់ចំនួន និងទាន់ពេលវេលា មកអោយភាគី”ក” ។</li>
															</ul>
														</p>
													</div>
												</td>
											</tr>
											<tr>
						                	<td align="left">
						                		<div class="td-margin-top">ប្រការ៧៖ វិវាទ និងការដោះស្រាយ</div>
						                	</td>
						                	</tr>
						                	<tr>
						                		<td>
					                				<p class="p">
							                			<ul>
							                				<li>ក្នុងករណីដែលមានវិវាទណាមួយកើតឡើងពាក់ព័ន្ធនឹងការបំពេញកតព្វកិច្ចរបស់ភាគីណាមួយ ឬទៅនឹង ការបកស្រាយ ខចែង និងលក្ខខណ្ឌណាមួយនៃកិច្ចសន្យានេះ នោះគូភាគីអាចប្ដឹងទៅតុលាការ ដែលមានយុត្ថាធិការ នៅក្នុងព្រះរាជាណាចក្រកម្ពុជា ក្រោយការចរចារដោយការយោគយល់គ្នាមិនបានសម្រេច។
									                		</li>
									                	</ul>
								                	</p>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="left"><div class="td-margin-top">ប្រការ៨៖ ករណីប្រធានស័ក្កិ</div></td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<p class="p">៨.១
							                			<ul>
							                				<li>អនុលោមតាមប្រការនេះ គ្មានភាគីណាម្នាក់ត្រូវទទួលខុសត្រូវលើការខាតបង់ ការខូចខាត ឬការពន្យាការអនុវត្តកតព្វកិច្ច ដែលកើតឡើងពីករណីប្រធានស័ក្កិ ចំពោះភាគីណាម្ខាងទៀត ឡើយ។ ប៉ុន្តែភាគីនោះត្រូវតែបង្ហាញឲ្យឃើញថា ករណីប្រធានស័ក្កិនេះ     ពិតជាឧបសគ្គរាំងស្ទះដល់ការអនុវត្តកតព្វកិច្ចរបស់ខ្លួនដើម្បីបានរួចផុតពីការទទួលខុសត្រូវនេះ។
									                		</li>
									                	</ul>
								                	</p>
								                </td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<div class="margin-top">
							                			<p class="p">៨.២
							                				<ul>
										                		<li>រណីប្រធានស័ក្កិសំដៅលើកាលៈទេសៈទាំងឡាយណា ដែលហួសពីសមត្តភាពគ្រប់គ្រងរបស់ភាគីដែលត្រូវអនុវត្តកតព្វកិច្ច ដែលមិនអាចអាចអនុវត្តបានដោយសារតែកាលៈទេសៈនេះបានកើតឡើង ក្នុងនោះរួមមានគ្រោះធម្មជាតិ អគ្គីភ័យ ការរញ្ជួយដី ភេរវកម្ម កុប្បកម្ម សង្រ្គាម ជាអាទិ ដែលមានឥទ្ធិពលនៃកាលៈទេសៈទាំងនេះធ្វើឲ្យភាគីស្ថិតក្នុងស្ថានភាពមិនអាចអនុវត្តកតព្វកិច្ចរបស់ខ្លួន ដូចដែលមានចែងនៅក្នុងកិច្ចសន្យានេះបាន។ ក៏រាប់បញ្ជូលផងដែរជា ករណីប្រធានស័ក្កិចំពោះការផ្លាស់ប្ដូរ កែប្រែច្បាប់ គោលនយោបាយរដ្ឋាភិបាល និងវិធានផ្សេងៗរបស់រដ្ឋដែលរារាំងដល់ការកាត់ឈ្មោះផ្ទេរកម្មសិទ្ធិកាន់កាប់អចលនទ្រព្យលក់។
										                		</li>
										                	</ul>
										                </p>
									                </div>
						                		</td>
						                	</tr>
						                
				                			<tr>
						                		<td align="left">
						                			<div class="td-margin-top">ប្រការ៩៖ ការបញ្ចប់កិច្ចព្រមព្រៀង</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<p class="p">កិច្ចសន្យានេះត្រូវបញ្ចប់ក្នុងករណីណាមួយដូចខាងក្រោមៈ
						                			</p>
						                		</td>
						                	</tr>
				                			<tr>
												<td align="left">
													<p class="p">៩.១
													<ul>
														<li>ភាគីទាំងអស់បានអនុវត្តកតព្វកិច្ចរបស់ខ្លួន ដែលមានចែងក្នុងកិច្ចព្រមព្រៀងចប់សព្វគ្រប់តាមផ្លូវច្បាប់។</li>
													</ul>
												</p>
												</td>
											</tr>
											<tr>
												<td>
													<div class="margin-top">
														<p class="p">៩.២
															<ul>
																<li>មានការចង្អុលបង្ហាញពីលក្ខខណ្ឌនៃការបញ្ចប់នេះ ដោយប្រការណាមួយនៅក្នុងកិច្ចសន្យានេះ។</li>
															</ul>
														</p>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="margin-top">
														<p class="p">៩.៣
															<ul>
																<li>មានការឯកភាពបញ្ចប់កិច្ចសន្យានេះ ជាលាយលក្ខណ៍អក្សររបស់ភាគីទាំងអស់។</li>
															</ul>
														</p>
													</div>
												</td>
											</tr>
											<tr>
					                		<td align="left">
					                			<div class="td-margin-top">ប្រការ១០៖ ការជូនដំណឹង</div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
				                				<p class="p">
						                			<ul>
						                				<li>រាល់ការជូនដំណឹង ឬការទំនាក់ទំនង ពាក់ព័ន្ធនឹងកិច្ចសន្យានេះ ត្រូវធ្វើឡើងជាលាយលក្ខណ៍អក្សរ និងត្រូវបញ្ជូនទៅឲ្យភាគី ដែលពាក់ព័ន្ធតាមអាស័យដ្ឋានដែលមានរៀបរាប់ក្នុងទំព័រ១ នៃកិច្ចសន្យានេះ ឬទៅអាស័យដ្ឋានផ្សេងទៀត បើមានការជូនដំណឹងជាក្រោយពីការផ្លាស់ប្ដូរ    អាស័យដ្ឋានរបស់គូភាគីនោះ។</li>
								                	</ul>
							                	</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left"><div class="td-margin-top">ប្រការ១១៖ បញ្ញត្តិផ្សេងៗ</div></td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p">១១.១
						                			<ul>
						                				<li><b>ការធ្វើវិសោធនកម្មៈ</b> រាល់ការផ្លាស់ប្ដូរ កែប្រែទៅលើកិច្ចព្រមព្រៀងនេះ នឹងពុំមានសុពលភាពបានឡើយ លុះត្រាតែ មានការព្រមព្រៀងជាលាយលក្ខណ៍អក្សរ និងធ្វើឡើងដោយគូភាគី។</li>
								                	</ul>
							                	</p>
							                </td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="margin-top">
						                			<p class="p">១១.២
						                				<ul>
									                		<li><b>អនុភាពចងកតព្វកិច្ចៈ</b> កិច្ចសន្យានេះ មានអនុភាពអនុវត្តចំពោះគូភាគី និងអ្នកទទួលសិទ្ធិបន្ត រួមទាំងអ្នកតំណាង និងទាយាទរបស់គូភាគី ចាប់ពីកាលបរិច្ចេទនេះតទៅ។</li>
									                	</ul>
									                </p>
								                </div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="margin-top">
						                			<p class="p">១១.៣
						                				<ul>
									                		<li><b>ភាសាៈ</b> កិច្ចសន្យានេះត្រូវតាក់តែងឡើងជាភាសាខ្មែរ។</li>
									                	</ul>
									                </p>
								                </div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="margin-top">
						                			<p class="p">១១.៤
						                				<ul>
									                		<li><b>ច្បាប់គ្រប់គ្រងៈ</b>កិច្ចសន្យានេះត្រូវស្ថិតនៅក្រោម ការបកស្រាយ និងការគ្រប់គ្រងដោយច្បាប់នៃព្រះរាជាណាចក្រកម្ពុជា។ </li>
									                	</ul>
									                </p>
								                </div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="margin-top margin-top-10">
					                				<p class="p"><b>នៅចំពោះមុខសាក្សី</b>  គូភាគីបានចុះកិច្ចសន្យានេះចំនួន០៣ ច្បាប់ជាភាសាខ្មែរ ដោយរក្សាទុកនៅភាគីនិមួយៗម្នាក់ ០១ច្បាប់ ទុកនៅអាជ្ញាធរពាក់ព័ន្ធមួយច្បាប់ និងមួយច្បាប់ទៀតទុកនៅមេធាវីប្រថាប់ត្រាបន្ទាប់ពីចុះ ហត្ថលេខា/ផ្ដិតមេដៃ និង/ឬ បោះត្រារួច។</p>
					                			</div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div style="margin-top: -10px;">
					                				<p style="text-align: center;font-family: 'Khmer OS System';font-size: 16px;padding: 0px;margin:0px;">គូភាគីបានយល់ព្រមផ្តិតមេដៃស្តំាដើម្បីទុកជាភស្តុតាងដូចខាងក្រោម</p>
					                			</div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<table width="100%">
					                				<tr>
					                					<td width="40%">ស្នាមមេដៃភាគី "ក"</td>
					                					<td width="20%"></td>
					                					<td width="40%">ស្នាមមេដៃភាគី "ខ"</td>
					                				</tr>
					                				<tr><td><br></td></tr>
					                				<tr><td><br></td></tr>
					                				<tr>
					                					<td width="40%">--------------------</td>
					                					<td width="20%"></td>
					                					<td width="40%">{{ $sale->customer_name }}</td>
					                				</tr>
					                			</table>
					                			<div class="row">
					                				<div class="col-md-12" style="font-family: 'Khmer OS System';font-size: 16px;font-weight: bold;">
					                					<p>បានឃើញ និងបញ្ជាក់ថាគូភាគី</p>
														<p>បានផ្តិតមេដៃនៅចំពោះមុខ</p>
														<p>មេធាវីពិតប្រាកដមែន</p>
					                				</div>
					                			</div>
					                		</td>
					     				</tbody>			                	
				              	</table>			              		
			              		</div>			              		
							</div>					
						</div>
						<div class="form-group mt-4">
							<hr>
							<button class="btn btn-lg btn-success pull-right" onclick="printFuncsTion();"><i class="fa fa-print" aria-hidden="true"></i>{{ __('item.print_this_page') }}</button>
						</div>
					    <div class="table-responsive" id="table-responsive-2">
							<div class="">
								<div class="content">
									<table class="table">
										<div class="box-logo">
											<img src="{{Setting::get('LOGO')}}" width="100%" height="100%">
										</div>
				                	<tbody>
				                		<tr>
												<td>ព្រះរាជាណាចក្រកម្ពុជា</td>
											</tr>
											<tr>
												<td>ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
											</tr>
											<tr><td><p></p></td></tr>
											<tr>
												<td style="text-decoration: underline;">លិខិតប្រគល់ ទទួលប្រាក់ដំណាក់កាលទី១</td>
											</tr>
											<tr style="line-height: 19px !important;">
												{{-- {{AppHelper::khMultipleNumber(number_format($sale->total_price-$sale->discount_amount,0))}}USD ({{AppHelper::khNumberWord($sale->total_price-$sale->discount_amount)}} --}}
						                	<td align="justify"><span style="padding: 0px;margin:0px;">យោងៈ<span style="font-family: 'Khmer OS System';font-size: 16px;"> កិច្ចសន្យាទិញលក់ផ្ទះល្វែងលេខ({{ $sale->item_name }}) ចុះថ្ងៃទី{{AppHelper::khMultipleNumber(date('d', strtotime($sale->sale_date)))}} ខែ{{AppHelper::khMonth(date('m', strtotime($sale->sale_date)))}} ឆ្នាំ{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->sale_date)))}} ។</span></span>
						                	</td>
						               </tr>
					                	<tr style="line-height: 19px !important;">
					                		<td align="center">
					                			<p class="p" align="center" style="margin-left: 60px;">-
						                			<ul style="text-align: justify;margin-left: 30px;">
						                				<li>
						                					លិខិតនេះធ្វើនៅខេត្តសៀមរាប ថ្ងៃទី{{AppHelper::khMultipleNumber(date('d', strtotime($sale->sale_date)))}} ខែ{{AppHelper::khMonth(date('m', strtotime($sale->sale_date)))}} ឆ្នាំ{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->sale_date)))}} ។
						                				</li>
						                			</ul>
					                			</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="td-margin-top" style="margin-top: -21px;">
						                			<p class="p"><b>តំណាងភាគីអ្នកប្រគល់ប្រាក់ៈ</b> ឈ្មោះ <b>{{$sale->customer_name}}</b>  ភេទ{{$sale->customer_name}} កើតឆ្នាំ{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->customer_date_of_birht)))}} សញ្ជាតិ{{$sale->customer_nationality}} កាន់អត្តសញ្ញាណប័ណ្ណលេខៈ{{AppHelper::khMultipleNumber((string)$sale->customer_identity)}}(០១) ចុះថ្ងៃទី១៨ ខែធ្នូ ឆ្នាំ២០១៨ មានទីលំនៅភូមិ{{$sale->cs_village_name}} ឃុំ/សង្កាត់{{$sale->cs_commune_name}} សរ្ុក/ខណ្ឌ{{$sale->cs_district_name}} ក្រុង/ខេត្ត{{$sale->cs_province_name}}  ជាភាគីអ្នកទិញ បានប្រគល់ប្រាក់ដំណាក់កាលទី១ចំនួនៈ<b>{{AppHelper::khMultipleNumber(number_format($first_payment->loan_amount,0))}}USD ({{AppHelper::khNumberWord($first_payment->loan_amount)}}) ទៅឲ្យៈ</b></p>
					                			</div>
					                		</td>
					                	</tr><br>
					                	<tr>
					                		<td align="left">ភាគីអ្នកទទួលប្រាក់ៈ</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="td-margin-top" style="margin-top: -10px;">
						                			<p class="p">លោក <b>--------------------</b> កើតឆ្នាំ........... ជនជាតិខ្មែរ កាន់អត្តសញ្ញានប័ណ្ណលេខៈ............ ចុះថ្ងៃទី២៤ ខែមិថុនា ឆ្នាំ២០១៩ មានទីលំនៅបច្ចុប្បន្នភូមិ....... ឃុំ....... ស្រុក............ ខេត្ត........... ជាអ្នកលក់ ពិតជាបានទទួលប្រាក់ដំណាក់កាលទី១ចំនួនខាងលើគឺៈ<b>{{AppHelper::khMultipleNumber(number_format($first_payment->loan_amount,0))}}USD ({{AppHelper::khNumberWord($first_payment->loan_amount)}})</b> ពីអ្នកទិញ ពិតប្រាកដមែន ។</p>
						                		</div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="td-margin-top" style="margin-top: -10px;">
						                			<p class="p" style="text-align: center;float: none;">
						                				<ul>
						                					<li>ដើម្បីទុកជាភស្តុតាង គូភាគីនៃកិច្ចសន្យាបានយល់ព្រមចុះហត្ថលេខា ឬស្នាមដៃអនុវត្តកិច្ចសន្យានេះនៅកាលបរិច្ឆេទដែលបានសរសេរនៅខាងលើបំផុត ។</li>
						                				</ul>
						                			</p>
					                			</div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<table width="100%">
					                				<tr>
					                					<td width="40%">ស្នាមមេដៃអ្នកប្រគល់</td>
					                					<td width="20%"></td>
					                					<td width="40%">ស្នាមមេដៃអ្នកទទួល</td>
					                				</tr>
					                				<tr><td><br></td></tr>
					                				<tr><td><br></td></tr>
					                				<tr>
					                					<td width="40%">{{ $sale->customer_name }}</td>
					                					<td width="20%"></td>
					                					<td width="40%">--------------------</td>
					                				</tr>
					                			</table>
					                			<div class="row">
					                				<div class="col-md-12" style="font-family: 'Khmer OS System';font-size: 16px;">
					                					<p>បានឃើញ និងបញ្ជាក់ថា</p>
															<p>គូភាគីទាំងអស់បានផ្តិតមេដៃ</p>
															<p>នៅចំពោះមុខ មេធាវីពិតប្រាកដមែន។</p>
					                				</div>
					                			</div>
					                		</td>
					                	</tr>
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
         		</div>
       		</div>
        	</div>
   	</div>
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
