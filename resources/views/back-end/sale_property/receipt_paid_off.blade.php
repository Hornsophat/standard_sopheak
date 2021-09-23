@php
    use App\Helpers\AppHelper;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <link rel="icon" type="image/png" href="{{ Setting::get('ICON') }}" sizes="32x32">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/listswap.css')}}">

    <link rel="stylesheet" href="{{URL::asset('back-end/css/normalize.css')}}"/>
    <link rel="stylesheet" href="{{URL::asset('back-end/css/planit.css')}}"/>
    <style type="text/css" id="stylePrint">
        @font-face{
            font-family: 'Khmer OS Muol Light';
            src: url('{{ asset('public/back-end/fonts/print-font/KhmerOSmuollight.ttf') }}') format("truetype");
        }
        @font-face{
            font-family: 'Khmer OS System';
            src: url('{{ asset('public/back-end/fonts/print-font/KhmerOSsys.ttf') }}') format("truetype");
        }
        .content-printer{
            width: 180mm;
            height: 110mm;
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
            font-size: 16px;
        }
        .body{
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        .header .title{
            font-size: 22px;
        }
        .logo{
            position: absolute;
            top:0;
            margin-left: 35px;
        }
        .logo img{
            width: 100px;
            height: auto;
        }
        table{
            white-space: nowrap;
            border-collapse: collapse;
            border-spacing: 0 0.5em;
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
        p ,span{
            color: black;
        }
        .p-footer, .p-footer span{
            color: white;
        }
        .p-border-bottom{
            border-color:black;
        }
        .footer{
            font-size: 12px;
            /*padding: 0px 15px;*/
        }
        @media print{
            
            table tr{
                line-height: 20px;
                padding:20px;
            }
          
            table tr td{font-size:12px !important; padding:2px 5px;}
            .title p{
                font-size: 16px;
            }
            .row{
                width: 100%;
            }
            .col-sm-6{
                float: left;
                width: 50%!important;
            }
            .col-sm-4{
                float: left;
                width: 33.333%!important;
            }
            .col-md-12{
                float: left;
                width: 100%!important;
            }
            .col-mb-7{
                margin-bottom: 80px;
            }
            .col-mb-4{
                margin-bottom: 10px;
            }
            .text-center{
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div style="width: 188mm; margin:auto; color: #22228e!important;">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div class="content-printer clearfix" id="table_print" style="background: #a59b9b1f">
                        <div class="header">
                            <div class="logo">
                                <img src="{{Setting::get('LOGO')}}" width="100%" height="100%">
                            </div>
                            <div class="title">
                                <p style="margin-bottom: 0; font-family: Khmer OS Muol Light;font-size:20px">ក្រុមហ៊ុន រដ្ឋ ស៊ីង​ អចនទ្រព្យ</p>
                                <p class="p-border-bottom" style="display:inline-block;border-bottom:2px solid #22228e;padding-bottom:1px;font-family:'Times New Roman', Times, serif;font-size:23px; font-weight: bold;">RothSing Real Estate Co,Ltd</p>
                            </div>
                            <div class="title">
                                <p style="margin-bottom: 0;"><span style="font-family: Khmer OS Muol Light;">បង្កាន់ដៃបង់ប្រាក់</span></p>
                            </div>
                        </div>
                        <br><br>
                        <?php
                        $gender ="ស្រី";
                        if($customer->sex==1){
                            $gender = 'ប្រុស';
                        }
                        $old = '';
                        if($customer->dob){
                            $old = (date('Y')*1)-(date('Y', strtotime($customer->dob))*1);
                        }
                        $price = $sale_item->total_price-$sale_item->discount_amount;
                        $price *=1;
                        $paid = $payment_transaction->amount*1;
                        $paid_date=$payment_transaction->payment_date;
                        $paid_day_number = AppHelper::khMultipleNumber(date('d', strtotime($paid_date)));
                        $paid_month = AppHelper::khMonth(date('m', strtotime($paid_date)));
                        $paid_year = AppHelper::khMultipleNumber(date('Y', strtotime($paid_date)));
                        $paid_day_number_next='';
                        $paid_month_next='';
                        $paid_year_next='';
                        if(!empty($payment_schedule_next)){
                            $paid_date_next=$payment_schedule_next->payment_date;
                            $paid_day_number_next = AppHelper::khMultipleNumber(date('d', strtotime($paid_date_next)));
                            $paid_month_next = AppHelper::khMonth(date('m', strtotime($paid_date_next)));
                            $paid_year_next = AppHelper::khMultipleNumber(date('Y', strtotime($paid_date_next)));
                        }
                        ?>
                        <div class="body"​​​​ >   
                            {{-- <p>&nbsp;</p> --}}
                            <p class="text-justify f-kh" style="text-align: justify-all;">
                            
                              <span class="f-kh">លេខកូដអតិថិជន</span>
                                <span class="horizontal_dotted_lines" style="min-width: 140px">&nbsp;{{$customer->customer_no}}</span>
                                <span class="f-kh">លេខកិច្ចសន្យា</span>
                                <span class="horizontal_dotted_lines" style="min-width: 140px">&nbsp;{{ $sale_item->reference}}</span>
                                <br>
                                <span class="f-kh">ឈ្មោះអតិថិជនៈ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 170px">&nbsp;{{ $customer->last_name.' '.$customer->first_name }} </span>
                                <span class="f-kh">ឡាតាំង</span>
                                <span class="horizontal_dotted_lines" style="min-width: 195px">&nbsp;{{ strtoupper($customer->last_name_en.' '.$customer->first_name_en) }} </span>
                                <span class="f-kh">ភេទៈ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 60px">&nbsp;{{ $gender }} </span>
                                <span class="f-kh">អាយុៈ</span><span class="horizontal_dotted_lines" style="min-width: 30px">&nbsp;{{$old}}</span>
                                <span class="f-kh">ឆ្នាំ</span>

                                <br>
                                <span class="f-kh">បានបញ្ចាំលេខៈ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 50px">&nbsp;{{$property->property_no}}</span>
                                {{-- <span class="f-kh">ផ្លូវលេខៈ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 70px">&nbsp;{{$property->address_number}}</span> --}}

                                {{-- <span class="f-kh">គម្រោងៈ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 150px">&nbsp;{{ $project->property_name }} </span> --}}
                                <span class="f-kh">តម្លៃបញ្ចាំ:​</span>
                                <span class="horizontal_dotted_lines" style="min-width: 50px">&nbsp;​${{ number_format($price,2) }} </span>
                                (
                                <span class="horizontal_dotted_lines" style="min-width: 260px">&nbsp;​{{ AppHelper::khNumberWord($price) }}ដុល្លារអាមេរិក</span>
                                )
                                    <br>
                                    
                                <span class="f-kh">ទឹកប្រាក់បានបង់ៈ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 140px">&nbsp;​${{ number_format($paid,2) }} </span>
                                (
                                <span class="horizontal_dotted_lines" style="min-width: 260px">&nbsp;​{{ AppHelper::khNumberWord($paid) }}ដុល្លារអាមេរិក</span>
                                )
                                <br>

                                <span class="f-kh">កាលបរិច្ឆេទបង់ប្រាក់ថ្ងៃទី</span>
                                <span class="horizontal_dotted_lines" style="min-width: 30px">&nbsp;​{{ $paid_day_number }} </span>
                                <span class="f-kh">ខែ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 80px">&nbsp;{{ $paid_month }} </span>
                                <span class="f-kh">ឆ្នាំ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 50px">&nbsp;{{ $paid_year }} </span>
                                {{-- <span class="f-kh">កាលបរិច្ឆេទត្រូវបង់បន្ទាប់</span>
                                <span class="horizontal_dotted_lines" style="min-width: 30px">&nbsp;​{{ $paid_day_number_next }} </span>
                                <span class="f-kh">ខែ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 80px">&nbsp;{{ $paid_month_next }} </span>
                                <span class="f-kh">ឆ្នាំ</span>
                                <span class="horizontal_dotted_lines" style="min-width: 50px">&nbsp;{{ $paid_year_next }} </span> --}}
                                <br>
                                @if (!empty($payment_transaction->remark))
                                <span class="f-kh" style="color: red">កំណត់ចំណាំ: {{ $payment_transaction->remark }}</span>
                                @endif
                                <br>
                                <span class="f-kh"><strong>បញ្ជាក់៖</strong>ក្នុងករណីដែលអតិថិជនបង់ប្រាក់ពុំទៀងទាត់តាមកាលកំណត់នឺងត្រូវពិន័យដូចបានចែងក្នុងកិច្ចសន្យាខ្ចីប្រាក់។</span>
                              
                                <br><br>
                               
                            </p>
                        </div>
                        <div class="footer col-mb-7" >
                            <div class="row f-kh" style="margin: 0px;padding: 0px;">
                                <div class="col-sm-3" style="overflow: hidden;">
                                    <p style="overflow: hidden; float: right;">
                                        <span>រាជធានីភ្នំពេញ, ថ្ងៃទី​</span>
                                        <span class="horizontal_dotted_lines" style="min-width: 25px">&nbsp;{{ $paid_day_number }} </span>
                                        <span class="f-kh">ខែ</span>
                                        <span class="horizontal_dotted_lines" style="min-width: 80px">&nbsp;{{ $paid_month }} </span>
                                        <span class="f-kh">ឆ្នាំ</span>
                                        <span class="horizontal_dotted_lines" style="min-width: 70px">&nbsp;{{ $paid_year }} </span>
                                    </p>
                                </div>
                                <div class="col-sm-4 col-mb-7 text-left" style="margin-left:120px">
                                    <span class="f-kh">ហត្ថលេខាអ្នកប្រគល់</span><br><br><br>
                                    <span>..........................</span>
                                </div>
                                <div class="col-sm-4 col-mb-7 text-left">
                                    <span class="f-kh">ហត្ថលេខាអ្នកទទួល(បេឡាករ)</span><br><br><br>
                                    <span>..........................</span>
                                </div>
                                <div class="col-md-12" style="background: #22228e; color:white; text-align: center;">
                                    <p class="f-kh p-footer" style="margin-bottom: 100px; margin-top: 5px;">អាស័យដ្ឋាន៖ ភូមិក្បាលស្ពាន1 សង្កាត់ប៉ោយប៉ែត ក្រុងប៉ោយប៉ែត  លេខទូរស័ព្ទ៖ 089 71 23 23 / 070 71 23 23</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-4" style="text-align: center;">
                        <button class="btn btn-small btn-primary" style="width: 180mm;" id="btn_print" type=""><i class="fa fa-print"></i>{{ __('item.print') }}</button>
                    </div>
                    <div class="col-md-12 mt-2" style="text-align: center;">
                        <button class="btn btn-small btn-danger" style="width: 180mm;" onclick="window.close();" type=""><i class="fa fa-close"></i>{{ __('item.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="{{URL::asset('back-end/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('back-end/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('back-end/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('back-end/js/main.js')}}"></script>

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
</body>
</html>