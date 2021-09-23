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
            width: 82px;
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
        @media print{
            table tr{
                line-height: 20px;
                padding:20px;
            }
            table tr td{font-size:12px !important; padding:2px 5px;}
            .title p{
                font-size: 14px;
            }
            .footer{
                font-size: 12px;
                padding: 0px 15px;
            }
            .row{
                width: 100%;
            }
            .col-sm-4{
                float: left;
                width: 33.333%!important;
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div class="content-printer clearfix" id="table_print">
                        <div class="header">
                            <div class="logo">
                                <img src="{{Setting::get('LOGO')}}" width="50%" height="50%">
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
                                        <td colspan="9" style="text-align: right;​​"><span style="font-family: Khmer OS System;">លេខកូដ</span>  N<sup>o</sup> : <span>{{ $payment_transaction->reference }}</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr​>
                                        <td style="font-family: Khmer OS System;">គម្រោង</td>
                                        <td colspan="3" style="width: 65mm;border:solid 1px grey;">{{ $project->property_name }}</td>
                                        {{-- <td width="5mm"></td> --}}
                                        <td style="font-family: Khmer OS System;">ប្រាក់ដើម</td>
                                        <td style="width:30mm;border:solid 1px grey">${{ number_format($payment_transaction->amount,2) }}</td>
                                        <td style="font-family: Khmer OS System;">បង់លើកទី</td>
                                        <td style="font-family: Khmer OS System;width:30mm;border:solid 1px grey"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">ឈ្មោះអតិថិជន</td>
                                        <td colspan="3" style="width: 65mm;font-family: Khmer OS System;border:solid 1px grey;">{{ $customer->last_name.' '.$customer->first_name }}</td>
                                        {{-- <td width="5mm"></td> --}}
                                        <td style="font-family: Khmer OS System;">ការប្រាក់</td>
                                        <td style="width:30mm;border:solid 1px grey">${{ number_format(0,2) }}</td>
                                        <td style="font-family: Khmer OS System;">ប្រាក់ពិន័យ</td>
                                        <td style="font-family: Khmer OS System;width:30mm;border:solid 1px grey">${{ number_format(0,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">លេខផ្ទះ</td>
                                        <td colspan="3" style="width: 65mm;border:solid 1px grey;">{{ $property->property_no }}</td>
                                        {{-- <td width="5mm"></td> --}}
                                        <td style="font-family: Khmer OS System;">បញ្ជុះតម្លៃ</td>
                                        <td colspan="3" style="border:solid 1px grey;font-family: Khmer OS System;">${{ number_format(0,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">តម្លៃផ្ទះ</td>
                                        <td colspan="3" style="width: 65mm;border:solid 1px grey;">${{ number_format($sale_item->total_price,2) }}</td>
                                        {{-- <td width="5mm"></td> --}}
                                        <td style="font-family: Khmer OS System;">ប្រាក់ត្រូវបង់</td>
                                        <td colspan="3" style="border:solid 1px grey;font-family: Khmer OS System;">${{ number_format($payment_transaction->amount,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: Khmer OS System;">ប្រាក់បានបង់សរុប</td>
                                        <td colspan="" style="width:30mm;border:solid 1px grey">${{ number_format($payment_transaction->amount,2) }}</td>
                                        <td style="font-family: Khmer OS System;">ប្រាក់នៅសល់</td>
                                        <td colspan="" style="width:30mm;border:solid 1px grey">${{ number_format(0,2) }}</td>
                                        {{-- <td width="5mm"></td> --}}
                                        <td style="font-family: Khmer OS System;">ប្រាក់បានទទួល</td>
                                        <td colspan="3" style="border:solid 1px grey;font-family: Khmer OS System;">${{ number_format($payment_transaction->amount,2) }}</td>
                                    </tr>
                                    <tr​>
                                        <td rowspan="2" style="font-family: Khmer OS System;">សម្គាល់</td>
                                        <td rowspan="2" colspan="3" style="width: 65mm;border:solid 1px grey;">{{ $payment_transaction->remark }}</td>
                                        {{-- <td width="5mm"></td> --}}
                                        <td style="font-family: Khmer OS System;">ថ្ងៃត្រូវបង់</td>
                                        <td style="font-family: Khmer OS System;width:30mm;border:solid 1px grey">
                                            {{ AppHelper::khMultipleNumber(date('d', strtotime($payment_transaction->payment_date))).'-'.AppHelper::khMonth(date('m', strtotime($payment_transaction->payment_date))).'-'.AppHelper::khMultipleNumber(date('Y', strtotime($payment_transaction->payment_date))) }}
                                        </td>
                                        <td style="font-family: Khmer OS System;">ថ្ងៃទទួល</td>
                                        <td style="font-family: Khmer OS System;width:30mm;border:solid 1px grey">
                                            {{ AppHelper::khMultipleNumber(date('d', strtotime($payment_transaction->payment_date))).'-'.AppHelper::khMonth(date('m', strtotime($payment_transaction->payment_date))).'-'.AppHelper::khMultipleNumber(date('Y', strtotime($payment_transaction->payment_date))) }}
                                        </td>
                                    </tr>
                                    <tr​>
                                        {{-- <td width="5mm"></td> --}}
                                        <td style="font-family: Khmer OS System;">បង់ជា</td>
                                        <td style="width:30mm;border:solid 1px grey"></td>
                                        <td style="font-family: Khmer OS System;">លេខ</td>
                                        <td style="font-family: Khmer OS System;width:30mm;border:solid 1px grey"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="footer">
                            <div class="row" style="font-family: Khmer OS System;​">
                                <div class="col-sm-4 col-mb-7">
                                    <span>ស្នាម​មេដៃគណនេយ្យ</span>
                                </div>
                                <div class="col-sm-4 col-mb-7 text-center">
                                    <span>ស្នាម​មេដៃអ្នកប្រគល់</span>
                                </div>
                                <div class="col-sm-4 col-mb-7 text-center">
                                    <span>ស្នាម​មេដៃអ្នកទទួល</span>
                                </div>
                                <div class="col-sm-4 col-mb-4">
                                    <span>&ensp;</span>
                                </div>
                                <div class="col-sm-4 col-mb-4 text-center">
                                    <span>ឈ្មោះអតិថិជន</span><br><br>
                                    <span>{{ $customer->last_name.' '.$customer->first_name }}</span>
                                </div>
                                <div class="col-sm-4 col-mb-4 text-center">
                                    <span>ឈ្មោះអ្នកទទួល</span><br><br>
                                    <span>{{ $created_by->name }}</span>
                                </div>
                            </div>
                        </div>
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
            t.document.write("<style>"+styleP+"</style>");
            t.document.write($('#table_print').html());
            t.print();
            t.close();
        });
    });
</script>
</body>
</html>