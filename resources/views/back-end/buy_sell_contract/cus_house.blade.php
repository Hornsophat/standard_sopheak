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
								/*height: 29.7cm;*/
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
								margin-top: 20px;
							}
						</style>
						<div class="table-responsive" id="table-responsive">
							<div class="card">
								<div class="content" style="margin-top: 0px; padding-top: 0;">
									<table class="table">
										<div class="box-logo">
											<img style="float: right; margin-right: -45px;" src="{{Setting::get('LOGO')}}" width="60%">
										</div>
				                	<tbody>
				                			<tr style="margin-top: 0; padding-top: 0;">
				                				<td style="margin-top: 0; padding-top: 0;">
				                					<table width="100%">
				                						<tr>
				                							<td width="50%" style="margin-top: 0; padding-top: 0;"></td>
				                							<td width="50%" style="margin-top: 0; padding-top: 0;">ព្រះរាជាណាចក្រកម្ពុជា</td>
				                						</tr>
				                						<tr>
				                							<td width="50%"></td>
				                							<td width="50%">ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
				                						</tr>
				                					</table>
				                				</td>
				                			</tr>
				                			<tr>
												<td>&nbsp;</td>
											</tr>
				                			<tr>
				                				<td style="margin-top: 0; padding-top: 0;">
				                					<table width="100%">
				                						<tr>
				                							<td width="50%">ក្រុមហ៊ុន ស៊ី យូ អេស គ្រុប</td>
				                							<td width="50%"></td>
				                						</tr>
				                						<tr>
				                							<td width="50%" style="font-family: 'Khmer OS System'">លេខៈ………………សយអ</td>
				                							<td width="50%"></td>
				                						</tr>
				                					</table>
				                				</td>
				                			</tr>
				                			{{-- <tr>
												<td>ព្រះរាជាណាចក្រកម្ពុជា</td>
											</tr>
											<tr>
												<td>ជាតិ សាសនា ព្រះមហាក្សត្រ</td>
											</tr> --}}
											<tr><td><p></p></td></tr>
											<tr>
												<td style="text-decoration: none;font-size: 13pt;">កិច្ចសន្យា​ ទិញផ្ទះ</td>
											</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ខ្ញុំបាទឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';">ហន រតនា</span> ភេទប្រុស ឆ្នាំកំណើត ០៧ មករា ១៩៨៧ កាន់អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរលេខ 031048846 មានទីលំនៅផ្ទះលេខ ភូមិរោងចក្រ សង្កាត់គោកឃ្លាង ខណ្ឌសែនសុខ រាជធានីភ្នំពេញដែលជាអ្នកតំណាងក្រុមហ៊ុន <b>ស៊ី យូ អេស គ្រុប (ខេមបូឌា)</b> ជាអ្នកលក់ ហៅកាត់ថា<b>ភាគី “ក”</b> ។</p>
					                		</td>
					                	</tr><br>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ឈ្មោះ <span style="font-family: 'Khmer OS Muol Light';">..........................</span> ភេទ............... ថ្ងៃខែឆ្នាំកំណើត.......................កាន់អត្តសញ្ញាណប័ណ្ណ សញ្ជាតិខ្មែរលេខ...................និងឈ្មោះ..................ភេទ.......ថ្ងៃខែឆ្នាំកំណើត....................កាន់អត្តសញ្ញាណ​​​​ប័ណ្ណ សញ្ជាតិខ្មែរលេខ......................មានទីលំនៅផ្ទះលេខ...... ភូមិ........ ឃុំ/សង្កាត់............. ស្រុក/ក្រុង/ខណ្ឌ........... ខេត្ត/រាជធានី................. ទូរស័ព្ទលេខ...................ជាអ្នកទិញហៅ កាត់ថា<b>ភាគី “ខ”</b> ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			ភាគីទាំងពីរបានព្រមព្រៀងគ្នាដូចខាងក្រោម៖
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ១ - តំលៃអចលនទ្រព្យ និងការទូទាត់
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ភាគី<b>“ក”</b> យល់ព្រមលក់ផ្ទះឡូត៍លេខ .............. ផ្លូវ........ ភូមិ.........   សង្កាត់.......... ខណ្ឌ.......................  រាជធានីភ្នំពេញ   ទៅឲ្យភាគី<b>“ខ”</b>  ក្នុងតំលៃ ................. (...........................................................................) ដុល្លារអាមេរិក។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">ភាគី “ខ” បានបង់ប្រាក់ជូនភាគី “ក” ៖</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;-ប្រាក់ត្រូវបង់លើកទី១ ចំនួន.................... (..............................................................................) នៅថ្ងៃទី........ខែ...............ឆ្នាំ.................</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;-ប្រាក់ត្រូវបង់លើកទី២ ចំនួន.................... (..............................................................................) នៅថ្ងៃទី........ខែ...............ឆ្នាំ.................</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;-ប្រាក់ត្រូវបង់លើកទី៣ ចំនួន.................... (..............................................................................) នៅថ្ងៃទី........ខែ...............ឆ្នាំ.................</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;-ប្រាក់ត្រូវបង់លើកទី៤ ចំនួន.................... (..............................................................................) នៅថ្ងៃទី........ខែ...............ឆ្នាំ.................</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;-ប្រាក់ត្រូវបង់លើកទី៤ ចំនួន.................... (..............................................................................) នៅថ្ងៃទី........ខែ...............ឆ្នាំ.................</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">ប្រាក់នៅសល់ចំនួន................ (.........................................................................) ដុល្លារអាមេរិក     ភាគី “ខ” យល់ព្រមបង់ប្រាក់នៅសល់ទំាងអស់ជូនភាគី”ក” ក្រោយធនាគារដៃគូរបានយល់ព្រមជាមួយភាគី”ខ”។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ក្នុងរយៈពេល (អន្តរកាល) ធនាគារកំពុងសិក្សាវាយតម្លៃកម្ចី អតិថិជនត្រូវបង់ប្រាក់នៅសល់ជាមួយ ក្រុមហ៊ុនជាប្រចាំខែរយៈពេល៣ (បី) ខែដោយបង់មួយខែៗចំនួនយ៉ាងតិច៣០០ (បីរយ)ដុល្លារ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;-	ករណីដែលភាគី”ខ”មិនបានគោរពតាមកិច្ចសន្យានេះ​​ ប្រាក់​កក់​ទាំង​អស់​ត្រូវទុកជាប្រយោជន៍ របស់ភាគី”ក”ដោយស្វ័យប្រវត្តិ ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;-	ករណីដែលភាគី”ក” កែប្រែមិនលក់ផ្ទះវិញ នោះនឹងត្រូវបង់ប្រាក់ពិន័យទៅឱ្យភាគី”ខ”ស្មើនឹង ប្រាក់បានបង់គុណនឹង២ ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ២ -  អំពីការផាកពិន័យ
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ក្នុងករណីភាគី “ខ” បង់ប្រាក់យឺតយ៉ាវ ភាគី “ខ” ត្រូវបង់ប្រាក់ពិន័យជូនភាគី “ក” ដូចខាងក្រោមៈ បង់យឺតចាប់ពី៣ថ្ងៃ ទៅ ១០ថ្ងៃពិន័យ ៥%  បង់យឺតចាប់ពី១១ទៅ៣០ថ្ងៃពិន័យ១០% និងយឺតពី ៣១ថ្ងៃ ទៅ ៩០ថ្ងៃ ពិន័យ ២០% នៃទឹក ប្រាក់ត្រូវបង់។ បើបង់យឺតលើសកំណត់ ៩០ថ្ងៃ ភាគី “ខ” បានយល់ព្រមឲ្យភាគី “ក” ដកហូតយកផ្ទះមកវិញដោយពុំមាន ប្រគល់សំណងទៅភាគី “ខ” វិញឡើយ ហើយប្រាក់ដែលបាន បង់រួចត្រូវទុកជាអសាបង់ ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ៣ - លក្ខខណ្ឌការប្រគល់ផ្ទះ
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;<b>៣.១.ករណីដែលភាគី“ខ” ទិញផ្ទះពីភាគី“ក” ដោយបង់ផ្តាច់</b></p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;នៅពេលដែលភាគី “ខ” បានបង់ប្រាក់ថ្លៃទិញផ្ទះគ្រប់ចំនួន $..............(..........................) នោះទើបភាគី “ក” ប្រគល់វិញ្ញាបនបត្រ សម្គាល់ម្ចាស់អចលនវត្ថុ (ប្លង់រឹងបំបែកក្បាលដី) ជូនទៅភាគី “ខ” ដើម្បីប្រើប្រាស់។ រាល់ការចំណាយកាត់ឈ្មោះ និងបង់ពន្ធជូនរដ្ឋ ជាបន្ទុករបស់ភាគី “ខ”។ ករណីភាគី”ខ” ផ្តល់ឱ្យភាគី”ក”ជាអ្នកផ្ទេរកម្មសិទ្ធ(ប្លង់រឹង) ជូន ភាគី”ខ” ត្រូវចំណាយបន្ថែមចំនួន១០០០ដុល្លារក្នុងផ្ទះមួយ។  ភាគី “ក” ត្រូវសាងសង់ផ្ទះជូនភាគី “ខ” ឲ្យបានរួចរាល់ជាស្ថាពរ មិនលើសពី១៨០ថ្ងៃ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;<b>៣.២.ករណីដែលភាគី“ខ” ទិញផ្ទះពីភាគី“ក” ដោយបង់រំលស់ជាមួយធនាគារ</b></p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;នៅពេលដែលភាគី“ខ”បានបង់ប្រាក់ថ្លៃទិញផ្ទះគ្រប់ចំនួន ..............(..........................................) ដុល្លារអាមេរិក នោះទើបភាគី “ក” ផ្ទេរកម្មសិទ្ធ(ប្លង់រឹង) ជូន ភាគី”ខ” ។  ភាគី “ក” ត្រូវសាងសង់ផ្ទះជូនភាគី “ខ” ឲ្យបានរួចរាល់ជាស្ថាពរ មិនលើសពី១៨០ថ្ងៃ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ៤ - ការទទួលខុសត្រូវនៃកិច្ចសន្យា
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ភាគី “ក” និងភាគី “ខ” សន្យាគោរពយ៉ាងម៉ឺងម៉ាត់រាល់ប្រការខាងលើ ក្នុងករណីមានការអនុវត្តផ្ទុយឬ រំលោភលើលក្ខខណ្ឌណាមួយនៃកិច្ចសន្យានេះ ភាគីណាល្មើសត្រូវទទួលខុសត្រូវចំពោះមុខច្បាប់ជាធរមាន។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ៥ - កិច្ចព្រមព្រៀង
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;កិច្ចសន្យានេះធ្វើឡើងរវាងភាគី “ក” និងភាគី “ខ” ដោយគ្មានការបង្ខិតបង្ខំពីភាគីណាមួយឡើយ ហើយកិច្ចសន្យានេះមានសុពលភាពនៅពេលដែលភាគីទាំងពីរផ្តិតស្នាមមេដៃស្តាំជាភស្តុតាង ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ៦ - លក្ខខណ្ឌទូទៅ 
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;ភាគី“ក” យល់ព្រមបំបែកដីចេញពីប្លង់លេខ........................មានទំហំ............ម៉ែត្រការ៉េ  និងទំហំ ដីផ្ទះ............ម៉ែត្រការ៉េ  មានព្រំប្រទល់ ៖ </p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;&emsp;&emsp;-	ខាងជើងទល់នឹង................................... ខាងកើតទល់នឹង...................................</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;&emsp;&emsp;-	ខាងត្បូងទល់នឹង................................... ខាងលិចទល់នឹង....................................</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">ដីផ្ទះលេខ...............ផ្លូវ...........ភូមិ...................សង្កាត់....................ខណ្ឌ.................. រាជធានីភ្នំពេញ។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td align="left">
					                			ប្រការ៧ - កំណត់សម្គាល់ 
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<p class="p" style="text-align: justify;">&emsp;&emsp;&emsp;កិច្ចសន្យានេះរួមមាន៣ទំព័រ ត្រូវជា៧ប្រការ។ កិច្ចសន្យានេះត្រូវបានរៀបចំធ្វើជាពីរច្បាប់ដើមជា ភាសាខ្មែរ មួយច្បាប់កាន់កាប់ដោយភាគី ”ក” និងមួយច្បាប់ទៀតកាន់កាប់ដោយភាគី ”ខ”។</p>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div style="margin-top: -10px;">
					                				<p style="text-align: center;font-family: 'Khmer OS System';font-size: 16px;padding: 0px;margin:0px;">ថ្ងៃ................. ខែ............ ឆ្នាំ.......... ………………… ព.ស.២៥៦…</p>
					                			</div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<div style="margin-top: -10px;">
					                				<p style="text-align: center;font-family: 'Khmer OS System';font-size: 16px;padding: 0px;margin:0px;">ក្រុងប៉ោយប៉ែត, ថ្ងៃទី..........ខែ........ ឆ្នាំ២០២…</p>
					                			</div>
					                		</td>
					                	</tr>
					                	<tr>
					                		<td>
					                			<table width="100%">
					                				<tr>
					                					<td width="35%">ស្នាមមេដៃស្តាំភាគី “ខ”</td>
					                					<td width="30%">សាក្សី</td>
					                					<td width="35%">ស្នាមមេដៃស្តាំភាគី “ក”</td>
					                				</tr>
					                			</table>
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
				'.card{width: 21cm;border-radius: unset;margin:0px;}'+
				'.card .content{padding:40px;overflow: hidden;position:relative;}'+
				'.content .footer{position:absolute; z-index:99999;padding: 20px;bottom: -25px;right: 25px;overflow: hidden;}'+
				'.footer footer .p{color: #A4A4A4;font-size: 15px;}'+
				'div.margin-top{margin-top: -43px;padding:0px;}'+
				'div.margin-top-10{margin-top:-26px;}'+
				'div.td-margin-top{margin-top: -16px;padding:0px;}'+
				'div.margin{margin-top:-30px;}'+
				'div.margin-1{margin-top:-40px;}'+
				'div.td-margin{margin-top:-27px;}'+
				'.ul{margin-top: -1px;}'+
				'.box-logo{position: absolute;width: 200px;height: 70px;margin-top: 30px;}'+
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
