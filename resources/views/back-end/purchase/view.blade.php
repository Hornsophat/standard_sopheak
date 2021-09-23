@extends('back-end/master')
@section('title',"Purschase Details")
@section('content')
<style type="text/css">
    table tr th, table tr td{
        white-space: nowrap;
    }
</style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">{{ __('item.purchase') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route("purchases") }}">{{ __('item.list_purchase') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.purchases_details') }}</a></li>
            </ul>
        </div>
    <div class="tile">
        <div class="tile-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('flash/message')
                        <div class="panel panel-default">
                            <div class="panel-body">
                             <div class="row">
                                 <div class="col-md-12" align="center">
                                    <h4>{{ __('item.purchases_details') }}</h4>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <table width="100%">
                                        <tr>
                                            <th style="font-size: 14px;">{{ __('item.date') }} : {{ date('d-F-Y', strtotime($purchase->created_at)) }}</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th style="font-size: 14px;">{{ __('item.supplier') }} : {{ ucwords($purchase->supplyer_name) }}</th>
                                            <th style="font-size: 14px;" class="text-right">{{ __('item.purchaser') }} : {{ ucwords($purchase->purchaser) }}</th>
                                        </tr>
                                    </table>
                                </div>
                             </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td>{{ __('item.no') }}</td>
                                            <td>{{ __('item.name') }}</td>
                                            <td>{{ __('item.cost') }}</td>
                                            <td>{{ __('item.quantity') }}</td>
                                            <td>{{ __('item.quantity_received') }}</td>
                                            <td>{{ __('item.sub_total') }}</td>
                                            <td>{{ __('item.status') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($total=0)
                                    @foreach($purchase_details as $key => $value)
                                        @php($total+=$value->sub_total)
                                        <tr>
                                            <td class="text-right">{{ ++$key }}</td>
                                            <td>{{ ucwords($value->material_name) }}</td>
                                            <td class="text-right">${{ $value->cost }}</td>
                                            <td class="text-right">{{ $value->quantity }}</td>
                                            <td class="text-right">{{ $value->quantity_received }}</td>
                                            <td class="text-right">${{ $value->sub_total }}</td>
                                            <td class="text-center">
                                                @if($value->status=='received')
                                                    <span class="badge badge-success">{{ $value->status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $value->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">{{ __('item.total') }}</th>
                                            <th class="text-right">${{ number_format($total,2) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" class="text-right">{{ __('item.discount') }}</th>
                                            <th class="text-right">${{ number_format($purchase->discount_amount,2) }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" class="text-right">{{ __('item.grand_total') }}</th>
                                            <th class="text-right">${{ number_format($total-$purchase->discount_amount,2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if(Auth::user()->can('receive-purchase') || $isAdministrator && $purchase->status!='received')
                                        <a class="btn btn-sm btn-success pull-right" onclick="return confirm('Are you sure you want to receive this item?');" href="{{ route('purchase.receive', ['id'=>$purchase->id]) }}">{{ __('item.receive') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>
        </div>
        </div>
    </main>
@endsection
