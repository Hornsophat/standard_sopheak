@extends('back-end/master')
@section('title',"Sale Details")
@section('content')
<style type="text/css">
    .fa-pencil, .fa-check {
        cursor: pointer;
    }
</style>
    <main class="app-content">
        <div class="tile">
            <div class="tile-body">
                <h3 class="text-danger">{{ __('item.payment_timeline') }}</h3>
                <div class="text-success display_message text-center"></div><br>
                <div class="row">
                    <div class="col-md-4 table-responsive">
                        <table class="table table-hover table-nowrap">
                            <tr>
                                <td>{{ __('item.no') }}#</td>
                                <td>{{ $sale->id }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.sale_date') }}</td>
                                <td>{{ Date("d-M-Y h:i:s A", strtotime($sale->sale_date)) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.customer') }}</td>
                                <td><a href="{{ route("viewCustomer", $sale->customer_id) }}">{{ $sale->soleToCustomer->first_name .' '. $sale->soleToCustomer->last_name }}</a></td>
                            </tr>
                            <tr>
                                <td>{{ __('item.employee') }}</td>
                                <td><a href="{{ route("viewEmployee", $sale->customer_id) }}">{{ $sale->soldByEmployee->first_name .' '. $sale->soldByEmployee->last_name }}</a></td>
                            </tr>
                            <tr>
                                <td>{{ __('item.total_price') }}</td>
                                <td>$ {{ $sale->total_price }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.deposit') }}</td>
                                <td>$ {{ $sale->deposit }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.total_sale_commission') }}</td>
                                <td>{{ "$ ".number_format($sale->total_sale_commission+$sale->payment()->where('status',2)->sum('total_commission'),2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.total_discount') }}</td>
                                <td>{{ "$ ". $sale->total_discount }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.grand_total') }}</td>
                                <td>{{ "$ ". $sale->grand_total }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.remarks') }}</td>
                                <td>{{ $sale->remark }}</td>
                            </tr>
                            @if($debt_amount>0)
                            <tr class="text-danger">
                                <td>Debt Amount</td>
                                <td>{{ number_format($debt_amount,2) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{ __('item.payment_process') }}</td>
                                <td>
                                    @php
                                        $class ="";
                                        $percentage = 0;
                                        $x = $sale->payment()->where("status", 2)->sum("amount_to_spend");
                                        if($x) {
                                            $total = $sale->payment()->sum("amount_to_spend");
                                            $percentage = ($x*100)/$total;
                                            $class = "bg-success";
                                            if($percentage <=30){
                                                $class ="bg-danger";
                                            }else if($percentage <=60){
                                                $class ="bg-warning";
                                            }
                                        }
                                    @endphp

                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated {{$class}}" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%">
                                            <b><span>{{ $percentage ."%" }}</span></b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-8 col-sm-12 table-responsive">
                        <table class="table table-hover table-nowrap">
                            <thead>
                            <th>{{ __('item.payment_date') }}</th>
                            <th>{{ __('item.actual_payment_date') }}</th>
                            <th>{{ __('item.amount_to_spend') }}</th>
                            <th>{{ __('item.status') }}</th>
                            </thead>
                            @if($sale->payment)
                            	@foreach($sale->payment as $key=> $value)
                                    @php
                                        if($value->status == 2) {
                                            $class_btn = 'btn-success btn-sm';
                                            $status_label = '<i class="fa fa-check"></i>Paid&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                            $url = '';
                                        } else {
                                            $class_btn = 'btn-danger btn-sm';
                                            $status_label = '<i class="fa fa-money"></i>Pay Now';
                                            $url = route('salePaymentPaid', $value->id);
                                        }
                                    @endphp
	                                <tr>
	                                    <td>{{ Date('d-M-Y', strtotime($value->payment_date)) }}</td>
	                                    <td>
                                            {{ Form::text('actaul_'.$value->id, !empty($value->actual_payment_date)?Date('d-M-Y', strtotime($value->actual_payment_date)):"", ['class' => 'demoDate actual-'.$value->id, 'disabled']) }}
                                           @if(!empty($value->actual_payment_date))
                                                <i class="fa fa-pencil fa-xs" data-id="{{$value->id}}"></i>
                                                <i class="fa fa-check fa-xs" data-id="{{$value->id}}"></i>
                                               @endif
                                        </td>
	                                    <td>{{ "$ ". number_format($value->amount_to_spend, 2, '.', ',') }}</td>
	                                    <td>
                                            @if($value->nextPayItem($sale->id) == $value->id)
                                                <a href="javascript:;" onclick="paynow(this)" data-url="{{$url}}" class="btn {{$class_btn}}">{!!$status_label!!}</a>
                                            @else
                                                <a href="javascript:;" data-url="{{$url}}" class="disabled btn {{$class_btn}}">{!!$status_label!!}</a>
                                            @endif
                                            @if($value->status == 2)
                                                <a href="{{ route('sale.receipt', ['sale_id'=>$sale->id,'id'=>$value->id]) }}" target="_blank"  class="btn btn-sm btn-success">{{ __('item.receipt') }}</a>
                                            @endif
                                        </td>
	                                </tr>
	                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>



            </div>

        </div>
    </main>
    

    @endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
<script type="text/javascript">
    $(document).ready(function() {
        $('.demoDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
        $(".fa-pencil").click(function(event){
            id = $(this).attr('data-id');
            $('.actual-'+id).removeAttr('disabled');
            $('.actual-'+id).focus();
        });
        $(".fa-check").click(function(event){
            id = $(this).attr('data-id');
            $('.actual-'+id).attr('disabled', 'disabled');
            date = $('.actual-'+id).val();
            var url = "{{url('sale/post-actual-payment-date-ajax/?id=')}}" + id + "&date=" + date;
            $.ajax({
                url: url, 
                success: function(result){
                    if(result.status) {
                        $(".display_message").html(result.message);
                    } else {
                        $(".display_message").html(result.message);
                    }
                    setTimeout(function(){ $(".display_message").html(''); }, 2000);
                }
            });
        });
    });
    function paynow(el) {
        var obj = $(el);
        var url = obj.attr('data-url');
        $.ajax({url: url, success: function(result){
            obj.removeClass('btn-danger');
            obj.addClass('btn-success');
            obj.html('<i class="fa fa-check"></i>Paid&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
            $('.display_message').html(result.message);
            setTimeout(function(){ location.reload(); }, 2000);
        }});
    }
</script>
@stop