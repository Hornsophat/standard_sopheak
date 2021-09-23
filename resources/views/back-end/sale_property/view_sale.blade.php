@extends('back-end/master')
@section('title', __('item.sale_detail'))
@section('style')
    <style type="text/css">
        .table_nowrap tr td, .table_nowrap tr th{
            white-space: nowrap;
        }
        .modal-lg {
            max-width: 1250px;
        }
    </style>
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="{{ route('property') }}">{{ __('item.property') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.sale_detail') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('Loan Detail') }}</h3><br>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('error-message'))
                                    <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.code') }}</td>
                                                <td>{{ $sale->reference }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">កាលបរិច្ឆេទ</td>
                                                <td>{{ date('d-m-Y', strtotime($sale->sale_date)) }}</td>
                                            </tr>
                                            <!-- <tr>
                                                <td style="width: 200px;">{{ trans('អតិថិជន') }}</td>
                                                <td>{{ $customer->last_name.' '.$customer->first_name }}</td>
                                            </tr> -->
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.property_no') }}</td>
                                                <td>{{ $property->property_no }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <td style="width: 200px;">{{ trans('item.property_name') }}</td>
                                                <td>{{ $property->property_name }}</td>
                                            </tr> --}}
                                            <tr>
                                                <td style="width: 200px;">{{ trans('ក្រុមហ៊ុន ឬ អ្នកផ្គត់ផ្គង់') }}</td>
                                                <td>{{ $property->model }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.vehicle_color') }}</td>
                                                <td>{{ $property->vehicle_color }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.vehicle_date') }}</td>
                                                <td>{{ $property->vehicle_date }}</td>
                                            </tr>
                                            <!-- @if($sale->is_free_land_register==1)
                                            <tr>
                                                <td style="width: 200px;">Free Land Register</td>
                                                <td><span class="rounded badge-success pr-1 pl-1">Yes</span></td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td style="width: 200px;">Free Land Register</td>
                                                <td><span class="rounded badge-danger pr-1 pl-1">No</span></td>
                                            </tr>
                                            @endif -->
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.price') }}</td>
                                                <td>${{ number_format($sale->total_price,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.discount') }}</td>
                                                <td>${{ number_format($sale->discount_amount,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.total') }}</td>
                                                <td>${{ number_format($sale->total_price-$sale->discount_amount,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.deposit') }}</td>
                                                <td>${{ number_format($sale->deposit,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.description') }}</td>
                                                <td>{{ $sale->remark }}</td>
                                            </tr>
                                            @if($isAdministrator)
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.created_by') }}</td>
                                                <td>{{ isset($sale->createBy->name)?$sale->createBy->name:'' }}</td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    <div class="col-lg-6">
                                    <center><h1>Customer</h1></center>
                                        <table class="table" style ="text-align:center;">
                                            <tbody>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.code') }}</td>
                                                <td>{{ $customer->customer_no }}</td>
                                            </tr>
                                          
                                            <tr>
                                                <td style="width: 200px;">{{ trans('អតិថិជន') }}</td>
                                                <td>{{ $customer->last_name.' '.$customer->first_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.name') }}</td>
                                                <td>{{ $customer->last_name_en.' '.$customer->first_name_en  }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.gender') }}</td>
                                                <td><?php if($customer->sex==1){
                                                    echo "Male";
                                                }else{
                                                    echo "Female";
                                                }?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.phone') }}</td>
                                                <td>{{ $customer->phone2 }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.email') }}</td>
                                                <td>{{ $customer->email }}</td>
                                            </tr>
                                           
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.image') }}</td>
                                                <?php $image = "http://localhost/anakut/Model_app/pmb_loan/public/".$customer->profile;?>
                                                <td><img src = "<?php echo $image;?>"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-10 ">
                                        {{-- @if($property->property_name="Tota")
                                        <a class="btn btn-sm btn-primary pull-left"  href="{{ route('sale.contract',['id'=>$sale->id]) }}">{{ __('Contract Vehicle') }}</a>&nbsp;
                                        @endif --}}
                                        {{-- <a style="margin-left:12px" class="btn btn-sm btn-primary pull-right"  href="{{ route('sale.contractLand',['id'=>$sale->id]) }}">{{ __('កិច្ចសន្យា​ លក់ Villa​​ / ​House') }}</a> --}}
                                        <a style="margin-left:12px" class="btn btn-sm btn-primary pull-right"  href="{{ route('sale.contractother',['id'=>$sale->id]) }}">{{ __('កិច្ចសន្យា​ លក់ របស់របរផ្សេងៗ') }}</a>
                                        <!-- <button type="button" class="btn btn-sm btn-info" style="cursor: pointer;" data-toggle="modal" data-target="#changeAddressModal">Change Address</button>
                                        <button type="button" class="btn btn-sm btn-info" style="cursor: pointer;" data-toggle="modal" data-target="#changePartnerModal" onclick="getChangePartner()">Change Partner</button> -->
                                        <a class="btn btn-sm btn-primary pull-right" href="{{ route('sale_property.create_loan', ['sale_item'=>$sale->id]) }}">{{ __('item.create_loan') }}</a>
                                        @if(!empty($paid_off))
                                            <a class="btn btn-sm btn-warning pull-right mr-2" style="cursor: no-drop;">Paid off</a>
                                            <a class="btn btn-sm btn-success pull-right mr-2" href="{{ route('sale_property.sale_paid_off_receipt',['id'=>$paid_off->id]) }}" target="_blank">Paid</a>
                                        @else
                                            <a class="btn btn-sm btn-warning pull-right mr-2" href="{{ route('sale_property.paid_off', ['sale_item'=>$sale->id]) }})">Paid off</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                               
                                <!-- Contract -->
                                <form action="http://127.0.0.1/loanvilla/resources/assets" method="post" enctype="multipart/form-data" >
                                    @csrf
  
                                
                                
                                </form>
                                    
                                </div>
                               
                                
                                <div class="row">
                                    <div class="col-lg-10 col-md-12">
                                        <h5>{{ __('item.payment_date') }}</h5>
                                            <div class="table-responsive">
                                                <table class="table table_nowrap">
                                                   <thead>
                                                       <tr>
                                                            <th>{{ __('item.no') }}</th>
                                                            <th class="text-center">{{ __('item.date') }}</th>
                                                            <th class="text-center">{{ __('item.currency') }}</th>
                                                            <th class="text-center">{{ __('item.amount') }}</th>
                                                            <th class="text-center">{{ __("item.amount_paid") }}</th>
                                                            <th class="text-center">{{ __('item.function') }}</th>
                                                       
                                                   </thead>
                                                   <tbody id="scheduleContent">                                           
                                                          @php
                                                        $index=1;
                                                    @endphp

                                                    @if($sale->deposit !=NULL)
                                                    
                                                    <tr style="background-color:#7FFF00"  @if($loan_first->status=='cancel') style="background: #ca7b7b54; " @endif>
                                                        <td>{{ $index }}</td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime($loan_first->loan_date)) }}</td>
                                                        <td class="text-right">{{ __('item.usd') }}</td>
                                                        <td class="text-right">${{ number_format($loan_first->loan_amount,2) }}</td>
                                                        <td class="text-right">${{ number_format($loan_first->loan_amount-$loan_first->outstanding_amount,2) }}</td>
                                                        <td class="text-right">
                                                            @if($loan_first->status=='cancel')
                                                                <a style="cursor: no-drop;"><span class='rounded p-1 badge-warning'>{{ __('item.payment_schedule') }}</span></a>
                                                                <a style="cursor: no-drop;"><span class='rounded p-1 badge-danger'>{{ __('item.cancel') }}</span></a>
                                                            @else
                                                                <!-- <a style="cursor: pointer;" onclick="print_schedule({{ $loan_first->id }})" data-toggle="modal" data-target="#scheduleModal"><span class='rounded p-1 badge-primary'>{{ __('item.schedule') }}</span></a> -->
                                                                <!-- <a style="cursor: pointer;" onclick="view_loan_schedule({{ $loan_first }})" data-toggle="modal" data-target="#loanScheduleModal"><span class='rounded p-1 badge-warning'>{{ __('item.payment_schedule') }}</span></a> -->
                                                                <a style="cursor: pointer;" onclick="cancel_loan({{ $loan_first->id }})"><span class='rounded p-1 badge-danger'>{{ __('item.cancel') }}</span></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                      @foreach($loans as $loan)
                                                        <tr  @if($loan->status=='cancel') style="background: #ca7b7b54" @endif>
                                                            <td>{{ ++$index }}</td>
                                                            <td class="text-center">{{ date('d-m-Y', strtotime($loan->loan_date)) }}</td>
                                                            <td class="text-right">{{ __('item.usd') }}</td>
                                                            <td class="text-right">${{ number_format($loan->loan_amount,2) }}</td>
                                                            <td class="text-right">${{ number_format($loan->loan_amount-$loan->outstanding_amount,2) }}</td>
                                                            <td class="text-right">
                                                                @if($loan->status=='cancel')
                                                                    <a style="cursor: no-drop;"><span class='rounded p-1 badge-warning'>{{ __('item.payment_schedule') }}</span></a>
                                                                    <a style="cursor: no-drop;"><span class='rounded p-1 badge-danger'>{{ __('item.cancel') }}</span></a>
                                                                @else
                                                                <a style="cursor: pointer;" onclick="view_schedule({{ $loan }})" data-toggle="modal" data-target="#ScheduleModal"><span class='rounded p-1 badge-primary'>{{ __('item.schedule') }}</span></a>
                                                                    <a style="cursor: pointer;" onclick="view_loan_schedule({{ $loan }})" data-toggle="modal" data-target="#loanScheduleModal"><span class='rounded p-1 badge-warning'>{{ __('item.payment_schedule') }}</span></a>
                                                                    <a style="cursor: pointer;" onclick="cancel_loan({{ $loan->id }})"><span class='rounded p-1 badge-danger'>{{ __('item.cancel') }}</span></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                       
                                                    @endforeach
                                                   </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-sm btn-danger" style="cursor: pointer;" onclick="cancel_sale({{ $sale->id }})">{{ __('item.cancel') }}</button>
                                    </div>
                                    {{-- <div class="col-lg-2">
                                        <a class="btn btn-small btn-info" href="{{ URL::to('property/' . $item->id . '/edit') }}">{{trans('item.edit')}}</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{--popup image--}}
    <div class="popup-image" style="display: none">
        <i class="fa fa-remove close-popup"></i>
        <img src=""/>
    </div>

@include('back-end.sale_property.view_sale_modal')
@include('back-end.sale_property.view_schedule')
@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script>
    @include('back-end.sale_property.view_sale_script')
@stop