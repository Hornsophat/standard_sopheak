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
            width: 210mm;
            height: 148mm;
            margin:auto;
            margin-top: 25px;
            position: relative;
        }
        .header{
            width: 100%;
            position: relative;
            text-align: center;
        }
        .body{
            width: 100%;
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
            width: 180px;
            height: auto;
        }
        table{
            white-space: nowrap;
            border-collapse: separate;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div class="content-printer clearfix" id="table_print">
                        <div class="header">
                            <div class="logo">
                                <img src="{{Setting::get('LOGO')}}" width="100%" height="100%">
                            </div>
                            <div class="title">
                                <p style="margin-bottom: 0; font-family: Khmer OS Muol Light;">បង្កាន់ដៃទទួលប្រាក់</p>
                                <p>Official Receipt</p>
                            </div>
                        </div>
                        <div class="body">
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <td colspan="7" style="text-align: right;"><span style="font-family: Khmer OS System;">រំលស់</span> N<sup>o</sup> : {{ isset($payment->reference)?$payment->reference:date('Ymd').'-'.str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr​>
                                        <td style="font-family: Khmer OS System;">លេខកូដ</td>
                                        <td style="width: 65mm;border:solid 1px grey;">25222</td>
                                        <td width="30mm"></td>
                                        <td style="font-family: Khmer OS System;">ប្រាក់ត្រូវបង់</td>
                                        <td style="width:30mm;border:solid 1px grey">${{ number_format($payment->amount_to_spend,2) }}</td>
                                        <td style="font-family: Khmer OS System;">ថ្ងៃត្រូវបង់</td>
                                        <td style="font-family: Khmer OS System;width:30mm;border:solid 1px grey">{{ AppHelper::khMultipleNumber(date('d', strtotime($payment->payment_date))).'-'.AppHelper::khMonth(date('m', strtotime($payment->payment_date))).'-'.AppHelper::khMultipleNumber(date('Y', strtotime($payment->payment_date))) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">ឈ្មោះ</td>
                                        <td style="width: 65mm;font-family: Khmer OS System;border:solid 1px grey;">{{ $sale->soleToCustomer->first_name. ' '. $sale->soleToCustomer->last_name }}</td>
                                        <td width="30mm"></td>
                                        <td style="font-family: Khmer OS System;">សងបន្ថែម</td>
                                        <td style="width:30mm;border:solid 1px grey">$0.00</td>
                                        <td style="font-family: Khmer OS System;">ប្រាក់ពិន័យ</td>
                                        <td style="width:30mm;border:solid 1px grey">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">តុល្យការប្រាក់កម្ចី</td>
                                        <td style="width: 65mm;border:solid 1px grey;">${{ number_format($debt_amount,2) }}</td>
                                        <td width="30mm"></td>
                                        <td style="font-family: Khmer OS System;">សរុប</td>
                                        <td colspan="3" style="border:solid 1px grey">${{ number_format($payment->amount_to_spend,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">ថ្ងៃផ្តល់កម្ចី</td>
                                        <td style="font-family: Khmer OS System;width: 65mm;border:solid 1px grey;">{{ AppHelper::khMultipleNumber(date('d', strtotime($sale->sale_date))).'-'.AppHelper::khMonth(date('m', strtotime($sale->sale_date))).'-'.AppHelper::khMultipleNumber(date('Y', strtotime($sale->sale_date))) }}</td>
                                        <td width="30mm"></td>
                                        <td style="font-family: Khmer OS System;">ថ្ងៃទទួល</td>
                                        <td colspan="3" style="font-family: Khmer OS System;border:solid 1px grey">{{ AppHelper::khMultipleNumber(date('d', strtotime($payment->actual_payment_date))).'-'.AppHelper::khMonth(date('m', strtotime($payment->actual_payment_date))).'-'.AppHelper::khMultipleNumber(date('Y', strtotime($payment->actual_payment_date))) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">ទីតាំង</td>
                                        <td style="width: 65mm;border:solid 1px grey;"></td>
                                        <td width="30mm"></td>
                                        <td style="font-family: Khmer OS System;">សែក</td>
                                        <td colspan="3" style="border:solid 1px grey"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="footer">
                            <span style="font-size:11px!important;font-family: Khmer OS System;">* ក្នុងករណីបង់ប្រាក់មិនទៀងទាត់.............................................</span>
                            {{-- <span style="font-size:11px!important;font-family: Khmer OS System;">* ក្នុងករណីបង់ប្រាក់មិនទៀងទាត់និងត្រូវផាកពិន័យដូចចែងក្នុងកិច្ចសន្យា</span> --}}
                            <span style="font-size:12px!important;font-family: Khmer OS System; float: right">អ្នកទទួល:.......................................................................</span>
                            <hr style="border:1px solid grey; margin-top: 3px;">
                        </div>
                        <span​​ style="font-size: 18px;font-family: Khmer OS System; position: absolute;right: 120px;bottom:90px;">បេឡា</span>
                    </div>
                    <div class="col-sm-12 mt-4" style="text-align: center;">
                        <button class="btn btn-small btn-primary" style="width: 210mm;" id="btn_print" type=""><i class="fa fa-print"></i>{{ __('item.print') }}</button>
                    </div>
                    <div class="col-md-12 mt-2" style="text-align: center;">
                        <button class="btn btn-small btn-danger" style="width: 210mm;" onclick="window.close();" type=""><i class="fa fa-close"></i>{{ __('item.close') }}</button>
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
            t.document.write("<style>"+styleP+" table tr td{font-size:11px !important}</style>");
            t.document.write($('#table_print').html());
            t.print();
            t.close();
        });
    });
</script>
</body>
</html>