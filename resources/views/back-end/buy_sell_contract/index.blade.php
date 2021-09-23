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
       				<button class="btn btn-lg btn-success btnPrint" onclick="printFunc();"><i class="fa fa-print" aria-hidden="true"></i>{{ __('item.print_this_page') }}</button>
       			</div>          				
       			<hr>
         		<div class="tile-body">
						<style type="text/css">
							.table-responsive{
								overflow-y: scroll;
								height: 16.8cm;
								width: 21.5cm;
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
								height: 27.5cm;
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
							<div class="card">
								<div class="content">
									<table class="table">
										<div class="box-logo">
											<img src="{{ asset('/public/images/products/logo.jpg') }}" width="100%" height="100%">
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
											<tr>
						                	<td><span style="text-align: justify;padding: 0px;margin:0px;">យោងៈ<span style="font-family: 'Khmer OS System';font-size: 16px;"> -	វិញ្ញាបនបត្រសម្គាល់ម្ចាស់អចលនវត្ថុលេខៈ.....................ចុះថ្ងៃទី....... ខែ........ ឆ្នាំ២០.....។</span></span>
						                	</td>
						               </tr>
						               <tr>
						                	<td><p class="p" style="text-align: center !important;">កិច្ចសន្យានេះធ្វើឡើងនៅខេត្តសៀមរាប ចុះថ្ងៃទី០២ ខែកញ្ញា ឆ្នំា២០១៩</p></td>
						               </tr>
					                	<tr>
					                		<td>រវាង</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;លោក <span style="font-family: 'Khmer OS Muol Light';">សាម សុជាង</span> កើតឆ្នាំ១៩៨២ ជនជាតិខ្មែរ កាន់អត្តសញ្ញានប័ណ្ណលេខៈ១១០៤៨៦៩២២ ចុះថ្ងៃទី២៤ ខែមិថុនា ឆ្នាំ២០១៩ មានទីលំនៅបច្ចុប្បន្នភូមិគោក ឃុំកណ្តែក ស្រុកប្រាសាទបាគង ខេត្តសៀមរាប ជាអ្នកលក់ ហៅកាត់ភាគី (ក) ។</p>
					                		</td>
					                	</tr><br>
					                	<tr>
					                		<td>និង</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';">ហេង គឹមលាង</span> ភេទស្រី កើតឆ្នាំ១៩៨៩ សញ្ជាតិខ្មែរ កាន់អត្តសញ្ញាណប័ណ្ណលេខៈ១៥០៤៧២៩០៩(០១) ចុះថ្ងៃទី១៨ ខែធ្នូ ឆ្នាំ២០១៨ មានទីលំនៅភូមិបឹងដូនប៉ា សង្កាត់ស្លក្រាម ក្រុង/ខេត្តសៀមរាប ជាភាគីអ្នកទិញ ហៅកាត់ភាគី (ខ) ។</p>
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
											            <li>ផ្ទះលក់(តទៅនេះហៅថា"អចលនទ្រព្យ")៖ ភាគី "ក" ឯកភាពលក់ទៅឲ្យភាគី "ខ" និងភាគី "ខ" ឯកភាពទិញពី ភាគី "ក"  នូវផ្ទះល្វែងចំនួន០២ល្វែង(F9,F10)  ដែលមានក្បាលដីលេខៈ........... ស្ថិតនៅក្នុងភូមិតាភុល សង្កាត់ស្វាយដង្គំ ក្រុង/ខេត្តសៀមរាប ។<br>
											            	<table width="100%">
											            		<tr>
												            		<td width="15.2%" style="padding: 0px;"><p class="p">មានព្រំប្រទល់ៈ</p></td>
												            		<td width="40%" style="padding: 0px;"><p class="p">ខាងកើតទល់នឹងផ្លូវ</p></td>
												            		<td width="35%" style="padding: 0px;"><p class="p">ខាងលិចទល់នឹងF8</p></td>
												            	</tr>
												            	<tr>
												            		<td width="15.2%" style="padding: 0px;"><p class="p"></p></td>
												            		<td width="40%" style="padding: 0px;"><p class="p">ខាងជើងទល់នឹងផ្លូវកៅស៊ូ១៥ម៉ែត្រ</p></td>
												            		<td width="35%" style="padding: 0px;"><p class="p">ខាងត្បួងទល់នឹងផ្ទះល្វែង</p></td>
												            	</tr>
											            	</table>
											            </li>
											        </ul>
											    </p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			<div class="td-margin-top td-margin">
						                			<p class="p">១.៣&emsp;&ensp;អំពីផ្ទះល្វែងក្នុងមួយល្វែងៈ</p>
						                			<ul style="float: left;" class="ul">
						                				<li>ក/ ទទឹង៤ម៉ែត្រ បណ្តោយ១៦ម៉ែត្រ</li>
															<li>ខ/ កំពស់បីជាន់</li>
															<li>គ/ បន្ទប់គេង០៤ មិនមានសម្ភារៈបំពាក់(ពីរល្វែង)</li>
															<li>ឃ/ បន្ទប់ទឹក០៥ មានសម្ភារៈបំពាក់(ពីរល្វែង)</li>
															<li>ង/ នៅផ្នែកខាងមុខ និងខាងក្រោយមានចាក់សាប ឬក្រាលការ៉ូឡា ។</li>	
														</ul>
													</div>
					                		</td>
					                	</tr>
						                </tbody>						                	
				              		</table>
				              		<div class="footer">
				              			<footer>
					              			<p class="p" class="pull-right">Page <strong>1</strong> of <strong>5</strong></p>
					              		</footer>
				              		</div>				              		
			              	</div>			              		
							</div>
							<br>	
							<div class="card">
								<div class="content">
									<table class="table">
				                		<tbody>
				                			<tr>
												<td align="left">
													<ul>
														<li>ច/ គុណភាព និងសម្ភារៈសំណង់(ត្រូវយកតាមគម្រូប្រហាក់ប្រហែល ឬល្អជាងផ្ទះល្វែងរបស់ភាគី  ”ក” ដែលមានសង់រួចនៅជិតវត្តស្វាយដង្គំ) ហើយភាគី”ខ” បានឯកភាពលើគុណភាព និងសម្ភារៈនេះមុនពេលចុះកិច្ចសន្យាទិញ លក់នេះ ។</li>
													</ul>
												</td>
											</tr>
											<tr>
												<td>
													<div class="margin-top margin">
														<p class="p">១.២&emsp;&ensp;តំលៃលក់ៈ តំលៃលក់សរុបគឺៈ<b>៤៥០,០០០ USD (បួនរយហាសិបពាន់ដុល្លារអាមេរិកគត់) ។</b></p>
													</div>
												</td>
											</tr>
											<tr>
												<td align="left">ប្រការ២៖ ការប្រគល់ប្រាក់ថ្លៃលក់អចលនវត្ថុ</td>
											</tr>
											<tr>
						                		<td><p class="p">២.១
						                			<ul>
						                				<li><b>ការប្រគល់ប្រាក់ដំណាក់កាលលើកទី១</b>	៖ ភាគី "ខ" ត្រូវប្រគល់ប្រាក់ចំនួនៈ<b>១០,០០០USD (ដប់ពាន់ដុល្លារអាមេរិកគត់)</b> ទៅឲ្យភាគី"ក"នៅថ្ងៃទី០២ ខែកញ្ញា ឆ្នាំ២០១៩ ។</li>
						                			</ul>
						                		</p>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td>
						                			<div class="margin-top">
						                				<p class="p">២.២
								                			<ul>
								                				<li><b>ការប្រគល់ប្រាក់ដំណាក់កាលលើកទី២៖</b>ភាគី "ខ" ត្រូវប្រគល់ប្រាក់ឲ្យបានចំនួនៈ<b>១០,០០០USD (ដប់ពាន់ដុល្លារអាមេរិកគត់)</b>ទៅឲ្យភាគី"ក"ជារៀងរាល់ខែក្នុងរយៈពេល០៨ខែដែលស្នើនិងចំនួនៈ<b>៨០,០០០USD(ប៉ែតសិបពាន់ដុល្លារអាមេរិកគត់)</b> ឬនៅពេលដែលផ្ទះពីរល្វែងខាងលើបានសាងសង់រួចរាល់ ។
										                		</li>
										                	</ul>
									                	</p>
								                	</div>
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="left">
						                			<div class="margin-top">
							                			<p class="p">២.២
							                				<ul>
							                					<li><b>ការបង់ប្រាក់បង្រ្គប់ ៖</b>ការបង់ប្រាក់បង្គ្រប់ដែលនៅសល់ចំនួនៈ<b>៣៦០,០០០USD (បីរយសាមសិបពាន់ដុលា្លរអាមេរិកគត់)</b> ទៀតគឺត្រូវធ្វើឡើងនៅពេលដែលភាគី”ក”បានសាងសង់ផ្ទះរួចរាល់ ឬនៅពេលដែលភាគី”ក”បានកាត់ឈ្មោះផ្ទេរសិទិ្ធរួចរាល់ទៅឲ្យភាគី”ខ”  ។
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
						                </tbody>						                	
				              		</table>
				              		<div class="footer">
				              			<footer>
					              			<p class="p" class="pull-right">Page <strong>2</strong> of <strong>5</strong></p>
					              		</footer>
				              		</div>				              		
			              		</div>			              		
							</div>	
							<br>	
							<div class="card">
								<div class="content">
									<table class="table">
				                		<tbody>
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
						                </tbody>						                	
				              		</table>
				              		<div class="footer">
				              			<footer>
					              			<p class="p" class="pull-right">Page <strong>3</strong> of <strong>5</strong></p>
					              		</footer>
				              		</div>				              		
			              		</div>			              		
							</div>	
							<br>	
							<div class="card">
								<div class="content">
									<table class="table">
				                		<tbody>
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
					                				<tr>
					                					<td width="40%">សាម សុជាង</td>
					                					<td width="20%"></td>
					                					<td width="40%">ហេង គឹមលាង</td>
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
					                	</tr>
						            </tbody>						                	
				              	</table>
				              		<div class="footer">
				              			<footer>
					              			<p class="p" class="pull-right">Page <strong>4</strong> of <strong>5</strong></p>
					              		</footer>
				              		</div>				              		
			              		</div>			              		
							</div>
							<br>
							<div class="card">
								<div class="content">
									<table class="table">
										<div class="box-logo">
											<img src="{{ asset('/public/images/products/logo.jpg') }}" width="100%" height="100%">
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
						                	<td align="justify"><span style="padding: 0px;margin:0px;">យោងៈ<span style="font-family: 'Khmer OS System';font-size: 16px;"> កិច្ចសន្យាទិញលក់ផ្ទះល្វែងលេខ(F9.F10) ចុះថ្ងៃទី០២  ខែកញ្ញា ឆ្នាំ២០១៩ ។</span></span>
						                	</td>
						               </tr>
					                	<tr style="line-height: 19px !important;">
					                		<td align="center">
					                			<p class="p" align="center" style="margin-left: 60px;">-
						                			<ul style="text-align: justify;margin-left: 30px;">
						                				<li>
						                					លិខិតនេះធ្វើនៅខេត្តសៀមរាប ថ្ងៃទី០២ ខែកញ្ញា ឆ្នាំ២០១៩ ។
						                				</li>
						                			</ul>
					                			</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="td-margin-top" style="margin-top: -21px;">
						                			<p class="p"><b>តំណាងភាគីអ្នកប្រគល់ប្រាក់ៈ</b> ឈ្មោះ <b>ហេង គឹមលាង</b>  ភេទស្រី កើតឆ្នាំ១៩៨៩ សញ្ជាតិខ្មែរ កាន់អត្តសញ្ញាណប័ណ្ណលេខៈ១៥០៤៧២៩០៩(០១) ចុះថ្ងៃទី១៨ ខែធ្នូ ឆ្នាំ២០១៨ មានទីលំនៅភូមិបឹងដូនប៉ា សង្កាត់ស្លក្រាម ក្រុង/ខេត្តសៀមរាប  ជាភាគីអ្នកទិញ បានប្រគល់ប្រាក់ដំណាក់កាលទី១ចំនួនៈ<b>១០,០០០USD (ដប់ពាន់ដុល្លារអាមេរិកគត់) ទៅឲ្យៈ</b></p>
					                			</div>
					                		</td>
					                	</tr><br>
					                	<tr>
					                		<td align="left">ភាគីអ្នកទទួលប្រាក់ៈ</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div class="td-margin-top" style="margin-top: -10px;">
						                			<p class="p">លោក <b>សាម សុជាង</b> កើតឆ្នាំ១៩៨២ ជនជាតិខ្មែរ កាន់អត្តសញ្ញានប័ណ្ណលេខៈ១១០៤៨៦៩២២ ចុះថ្ងៃទី២៤ ខែមិថុនា ឆ្នាំ២០១៩ មានទីលំនៅបច្ចុប្បន្នភូមិគោក ឃុំកណ្តែក ស្រុកប្រាសាទបាគង ខេត្តសៀមរាប ជាអ្នកលក់ ពិតជាបានទទួលប្រាក់ដំណាក់កាលទី១ចំនួនខាងលើគឺៈ<b>១០,០០០USD (ដប់ពាន់ដុល្លារអាមេរិកគត់)</b> ពីអ្នកទិញ ពិតប្រាកដមែន ។</p>
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
					                				<tr>
					                					<td width="40%">ហេង គឹមលាង</td>
					                					<td width="20%"></td>
					                					<td width="40%">សាម សុជាង</td>
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
				              		<div class="footer">
				              			<footer>
					              			<p class="p" class="pull-right">Page <strong>5</strong> of <strong>5</strong></p>
					              		</footer>
				              		</div>				              		
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
				'.card{width: 21cm;height: 29.7cm;border-radius: unset;margin:0px;}'+
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
				'.box-logo{position: absolute;width: 200px;height: 70px;margin-top: 60px;}'+
			'}</style>';
		   css += divToPrint.outerHTML;
		   newWin = window.open('');
		   newWin.document.write('<title>Contract</title>');
		   newWin.document.write(css);
		   newWin.print();
		   newWin.close();
	   }
	</script>
@stop
