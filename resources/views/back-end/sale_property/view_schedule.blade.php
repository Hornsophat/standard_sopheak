@php
    use App\Helpers\AppHelper;
@endphp
<!DOCTYPE html>
<html>
  <body>
    <div style="width: 188mm; margin:auto;">
        <div class="modal fade bd-example-modal-lg" id="ScheduleModal" tabindex="-1" role="dialog" aria-labelledby="ScheduleModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="col-sm-12 mt-4" style="text-align: center;">
                            <button class="btn btn-small btn-primary" style="width: 30mm;margin-left:700px" id="btn_print" type=""><i class="fa fa-print"></i>{{ __('item.print') }}</button>
                        </div>
                    </div>
                   
                    <div class="modal-body">
                        <div class="content-printer clearfix" id="table_print" style="background: #a59b9b1f"> 
                           <style>
                                #id1{
                             width:150px;
                             
                         }
                         .content-printer{
                             width: 300mm;
                             height: 410mm;
                             margin:auto;
                             margin-top: 25px;
                             position: relative;
                             
                         }
                        
                         .header{
                             width: 100%;
                             position: relative;
                             text-align: center;
                         }
                         .title p{
                             font-size: 20px;
                         }
                         .body{
                             width: 100%;
                             overflow: hidden;
                             position: relative;
                             
                         }
                         .row{
                             font-family: Khmer OS System !important;
                         }
                         .header .title{
                             font-size: 22px;
                         }
                         .logo{
                             position: absolute;
                             top:0;
                             margin-left: 50px;
                         }
                         .logo img{
                             width: 100px;
                             height: auto;
                         }
                         table{
                             white-space: nowrap;
                             border-collapse: collapse;
                             border-spacing: 0 0.5em;
                             width: 90%;
                             
                         }
                         table tr{
                             line-height: 20px;
                             padding:20px;
                         }
                         .footer{
                             position: absolute;
                             left: 0;
                             bottom: 0;
                             width: 100%;
                         }
                         .col-mb-7{
                             margin-bottom: 70px;
                         }
                         .foot{
                             
                         }
                         .col-mb-4{
                             margin-bottom: 40px;
                         }
                         table tr td{padding:2px 5px;}
                          .horizontal_dotted_lines{
                             /*padding: 0px 9px;*/
                             position: relative;
                             /*text-align: left;*/
                             display: inline-table;
                             font-weight: 600;
                     
                         }
                         .horizontal_dotted_lines::before {
                             content: '\0000a0';
                             position: absolute;
                             width: 100%;
                             bottom: 2px !important;
                             border-bottom: 0.1px dotted #bdbdbd;
                         }
                         .f-kh{
                             font-family: Khmer OS System;
                         }
                         .text-justify{
                             text-align: justify !important;
                             text-justify: inter-word !important;
                             justify-content: space-between;
                         }
                         .f-kh{
                             font-size: 12px;
                         }
                         
                        
                         .p-footer, .p-footer span{
                             color: white;
                         }

                         .table-responsive1{
                         /*height: 16.8cm;*/
                         margin:auto;
                         background-image:url('{{Setting::get('LOGO')}}')  ;
                         background-repeat:no-repeat ;
                         background-size:250px ;
                         opacity:1;     
                         background-position: center ; 
                     }
                        
                         .footer{
                             font-size: 12px;
                             /*padding: 0px 15px;*/
                         }
                         @media print{
                             
                             table tr{
                                
                             }
                             table tr td{font-size:20px !important;height:40px}
                             .title p{
                                 font-size: 16px;
                             }
                             .row{
                                 width: 100%;
                             }
                             b{
                                 font-weight:bold !important;
                             }
                             table{
                             white-space: nowrap;
                             border-collapse: collapse;
                             border-spacing: 0 0.5em;
                             width: 97%;
                             }
                             .col-md-4{
                                 float: left;
                                 width: 35%!important;
                             }
                             .col-md-2{
                                 float: left;
                                 width: 15%!important;
                             }
                            
                         }
                      
                         </style> 
                        @php
                        if($loan)
                        {
                        $datefirst=$loan->loan_date;
                        $loanterm=($loan->installment_term - 1);
                        $effectiveDate = date('Y-m-d', strtotime("+$loanterm month", strtotime($datefirst)));	
                         }					
                        @endphp
                        <div style="width: 288mm; margin:auto;">
                            <div class=" ">
                                <div class="col-md-12">
                         <div class="table-responsive font_size">
                            <div class="header">
                                {{-- <div class="logo" style="margin-left:-5px;">
                                    <img id = "id1" src="{{Setting::get('LOGO')}}" >
                                </div> --}}
                                <div class="title">
                                    <p style="margin-bottom: 0;"><span style="font-family: Khmer OS Muol Light;font-size:30px">យក់ សុភ័ក្រ ហាងលក់ទូរស័ព្ទដៃទំនើប និងសម្ភារ:អេឡិចត្រូនិច</span></p>
                                </div>
                                <div class="title">
                                    <p><span style="font-family: Khmer OS System;font-size:25px;font-weight:bold"><b>លេខទូរស័ព្ទ៖ 070 608 111 / 068 345 666​ / 011 608 111</b></span></p>
                                </div>
                                <div class="title">
                                    <p style="margin-bottom: 0;"><span style="font-family: Khmer OS Muol Light;font-size:25px">តារាងបង់ប្រាក់ប្រចាំខែ</span></p>
                                </div>
                            </div>
                            <br>
                            <div id="font"  class="row"​ style="font-family: Khmer os; font-size:17px">
                                <div class="col-md-2" style="font-size:23px !important;font-family:Khmer OS System">ឈ្មោះភាគី(ខ) </div>
                                <div class="col-md-4" style="font-size:23px !important;font-family:Khmer OS System">: <b>{{ $customer->last_name .' '. $customer->first_name }} </b></div>
                                <div class="col-md-2" style="font-size:23px !important;font-family:Khmer OS System">លេខកូដកម្ចី </div>
                                @if($loan)
                                <div class="col-md-4" style="font-size:23px !important;font-family:Khmer OS System">: <b>{{$loan->reference  }}</b></div>
                                @endif
                                <div class="col-md-2" style="font-size:23px !important;font-family:Khmer OS System">អាស័យដ្ឋាន </div>
                                <div class="col-md-4" style="font-size:23px !important;font-family:Khmer OS System">:ភូមិ <b>{{ $address->vil_kh  }}</b> ឃុំ <b>{{$address->com_kh }}</b> ស្រុក<b>{{$address->dis_kh  }}</b> ខេត្ត/ក្រុង <b>{{$address->prov_name  }}</b></div>
                                <div class="col-md-2" style="font-size:23px !important;font-family:Khmer OS System">ធ្វើនៅថ្ងៃទី </div>
                                <div class="col-md-4" style="font-size:23px !important;font-family:Khmer OS System">: <b>{{ $sale->created_at }}</b></div>
                                <div class="col-md-2" style="font-size:23px !important;font-family:Khmer OS System">ចំនួនទឹកប្រាក់ </div>
                                @if($loan)
                                <div class="col-md-4" style="font-size:23px !important;font-family:Khmer OS System">: <b>$ {{ $loan->loan_amount }} ({{ AppHelper::khNumberWord($loan->loan_amount) }}ដុល្លាអាមេរិក)</b></div>
                                @endif
                                <div class="col-md-2" style="font-size:23px !important;font-family:Khmer OS System">លេខទូរស័ព្ទ </div>
                                <div class="col-md-4" style="font-size:23px !important;font-family:Khmer OS System">: <b>{{ $customer->phone1 .' / '. $customer->phone2 }}</b></div>
                                <div class="col-md-2"  style="font-size:23px !important;font-family:Khmer OS System">អាត្រាការប្រាក់ </div>
                                @if($loan)
                                <div class="col-md-4"  style="font-size:23px !important;font-family:Khmer OS System">: <b>% {{ $loan->interest_rate }}</b> </div>
                                @endif
                                <div class="col-md-2"  style="font-size:23px !important;font-family:Khmer OS System">កាលបរិច្ឆេទ </div>
                                @if($loan)
                                   <div class="col-md-4"  style="font-size:23px !important;font-family:Khmer OS System">:  <b>{{date('d-m-Y', strtotime($loan->first_pay_date))  }} - {{ date('d-m-Y', strtotime($effectiveDate))  }}</b></div>
                                @endif
                                <div class="col-md-2"  style="font-size:23px !important;font-family:Khmer OS System">រយ:ពេល(ខែ) </div>
                                @if($loan)
                                <div class="col-md-4"  style="font-size:23px !important;font-family:Khmer OS System">: <b>{{$loan->installment_term  }} ខែ </b></div>
                                @endif
                                {{-- @if($loan)
                                <div class="col-md-2" style="font-size:23px !important;font-family:Khmer OS System">ការប្រាក់/ខែ </div>
                                <div style=" font-weight: bold;font-size:23px !important;font-family:Khmer OS System"class="col-md-4" id="loanIn"></div>
                                @endif --}}
                            </div>
                                <br><br>
                           <table class="mt-4" style="width:100px margin-left:10px;height:60px;border:1px solid black;text-align:center;font-family:Bo" >
                                    <tr>
                                            <th style="border:1px solid black;border-bottom:1px solid black;height:60px;font-family:Khmer OS System;font-size:20px !important;">ល.រ</th>
                                            <th style="border:1px solid black;border-bottom:1px solid black;height:60px;font-family:Khmer OS System;font-size:20px !important">កាលបរិច្ឆេទបង់ប្រាក់</th>
                                            {{-- <th>{{ __('item.number_of_days_to_penalty') }}</th> --}}
                                            <th style="border:1px solid black;border-bottom:1px solid black;height:60px;font-family:Khmer OS System;font-size:20px !important">{{ __("item.total_amount_to_be_paid") }}</th>
                                            <th style="border:1px solid black;border-bottom:1px solid black;height:60px;font-family:Khmer OS System;font-size:20px !important">{{ __("item.interest_amount") }}</th>
                                            <th style="border:1px solid black;border-bottom:1px solid black;height:60px;font-family:Khmer OS System;font-size:20px !important">{{ __('item.amount') }}</th>
                                            <th style="border:1px solid black;border-bottom:1px solid black;height:60px;font-family:Khmer OS System;font-size:20px !important">{{ __('item.principle_balance') }}</th>
                                            {{-- <th class="text-center">{{ __("item.amount_paid") }}</th> --}}
                                            {{-- <th>{{ __('item.payment_status') }}</th>
                                            <th class="text-center">{{ __('item.function') }}</th> --}}
                                        </tr>
                                        <tr>
                                        <tbody id="contentScheduleModal" style=" overflow-y: auto;">
                                        </tbody>
                                    </tr>
                                </table>
                            <div>
                                <!-- <p style="font-family: Khmer os; font-size:18px;"><b>ចំណាំ៖</b> តម្រូវឲ្យភាគី(ខ)​ បង់ការប្រាក់មុន</p>
                                <p style="font-family: Khmer os; font-size:18px;">ក្រោយពីបានពិនិត្យកិច្ចសន្យា និងបង់តារាងបង់ប្រាក់ខាងលើ ខ្ញុំបាទ/នាងខ្ញុំ យល់ព្រមដោយស្ម័គ្រចិត្តក្នុងការសងប្រាក់មកក្រុមហ៊ុន ភី.អិម.ប៊ី (PMB) វិញទាំងប្រាក់ដើម និងការប្រាក់ ទៅតាមកាលបរិច្ឆេទដែលបានកំណត់ខាងលើ។</p> -->
                                {{-- <tr>
                                    <td ><p class="text-right" style="font-size:23px;font-family:Khmer OS System;margin-left:650px;margin-top:50px"> ស្រីសន្ធរ, ថ្ងៃទី<b>{{AppHelper::khMultipleNumber(date('d', strtotime($sale->created_at)))}} </b>ខែ <b>{{AppHelper::khMonth(date('m', strtotime($sale->created_at)))}}</b>  ឆ្នាំ <b>{{AppHelper::khMultipleNumber(date('Y', strtotime($sale->created_at)))}}</b></p> </td>
                                </tr>
										<table style="width:100%;font-size:23px;font-family:Khmer OS System">
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
											<td style="font-family: Khmer OS;font-weight:bold;font-size:26px ">&emsp;&emsp;&emsp;&emsp;&emsp; <span style="font-size:28px;"> ប្តី<span>​​ &emsp;&emsp;&emsp;&emsp;&emsp; ប្រពន្ធ​</td>
											</tr>
											<tr style="height:300px">
										    <td>&emsp;&emsp;<b>{{ $customer->last_name .' '. $customer->first_name }} </b></td>
											<td>&emsp;&emsp;.................................</td>
											<td>&emsp;&emsp;.................................</td>
											<td>&emsp;&emsp;ថ្លាង សុភារិទ្ធិ​​ &emsp;&emsp;&emsp;&emsp;&emsp;យក់ សុភ័ក្រ</td>
											</tr>
										</table> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                     {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
                        </div>
                </div>       
            </div>
        </div>
    </div>        
    
        
    
  </body>  

    <script type="text/javascript" src="{{URL::asset('back-end/js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('back-end/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('back-end/js/bootstrap.min.js')}}"></script>
    {{-- <script type="text/javascript" src="{{URL::asset('back-end/js/main.js')}}"></script> --}}
    
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
    <script type="text/javascript" src="{{ asset('js/printThis.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var styleP = $('#stylePrint').text();
            $('#btn_print').click(function(){
                var t = window.open();
                t.document.write("<style>"+styleP+"</style>");
                t.document.write($('#table_print').html());
                t.print();
                t.close();
            });
        });
    </script>
</html>    