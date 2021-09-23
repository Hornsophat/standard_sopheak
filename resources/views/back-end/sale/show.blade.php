@extends('back-end/master')
@section('title',"Sale Details")
@section('content')

    <main class="app-content">
        <div class="tile">
            <div class="tile-body">
                <h3 class="text-danger">{{ __('item.sale_detail') }}</h3>
                <div class="row table-responsive">
                    <div class="col-md-6">
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
                                <td>{{ "$ ".$sale->total_price }}</td>
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
                    <div class="col-md-6">
                        <table class="table table-hover table-nowrap">
                            <thead>
                            <th>{{ __('item.item') }}</th>
                            <th>{{ __('item.qty') }}</th>
                            <th>{{ __('item.price') }}</th>
                            <th>{{ __('item.discount') }}</th>
                            {{-- <th>{{ __('item.commission') }}</th> --}}
                            <th>{{ __('item.amount') }}</th>
                            </thead>

                            @foreach($sale->salesDetail as $key=> $value)
                                <tr>
                                    <td><a href="{{ URL::to('property/' . (!is_null($value->property) ? $value->property->id : '') . '/detail') }}">{{  !is_null($value->property)?$value->property->property_name:"" }}</a></td>
                                    <td>{{ $value->qty }}</td>
                                    <td>{{ "$ ". $value->price }}</td>
                                    <td>$ {{ ($value->discount != null?$value->discount:"0") }}</td>
                                    {{-- <td>{{ ($value->sale_commission !=null?$value->sale_commission:0)." %" }}</td> --}}
                                    <td>{{ "$ ".($value->amount !=null?$value->amount:"0") }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>



            </div>

        </div>
    </main>


    @endsection