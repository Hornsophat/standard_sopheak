@extends('back-end/master')
@section('title', 'List Property')
@section('content')
<style type="text/css">
    .property_booked{
        cursor: pointer;
    }
</style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.property') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_property') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash/message')
                            @if (Session::has('error-message'))
                                <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                            @endif
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-12">
                                            @if(Auth::user()->can('create-property') || $isAdministrator)
                                                <a class="btn btn-small btn-success" href="{{ URL::to('property/others/create') }}">{{trans('item.new_others')}}</a>
                                            @endif
                                            @if(Auth::user()->can('merge-property') || $isAdministrator)
                                                <!-- <a class="btn btn-small btn-outline-success" href="{{ route('property_merge') }}">{{trans('item.merge_property')}}</a> -->
                                            @endif
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                        <h1 style = "font-size:50px;"><?php echo strtoupper ($loan_type) ?></h1>
                                            <form action="{{ URL('property') }}" method="get">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label>{{ __('item.customer') }}</label>
                                                            <select name="customer" id="customer" class="form-control" onchange="this.form.submit()">
                                                                <option value>-- {{__('item.select')}} {{__('item.type')}} --</option>
                                                                @foreach($customers as $customer)
                                                                    <option value="{{ $customer->id }}"
                                                                        @if ($request->customer == $customer->id)
                                                                        selected="selected"
                                                                        @endif
                                                                    >{{ $customer->last_name.' '.$customer->first_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                                        <div class="input-group">
                                                            <label style="width: 100%">{{ __('item.search') }}</label>
                                                            <input type="text" name="search" class="form-control" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-nowrap">
                                            <thead>
                                            <tr>
                                                <td>{{ __('item.property_id') }}</td>
                                                <td>{{ __('item.property_name') }}</td>
                                                <td>{{ __('item.customer') }}</td>
                                                <td>{{ __('item.price') }}</td>
                                                <td>{{ __('item.discount') }}</td>
                                                <td>{{ __('item.loan_amount') }}</td>
                                                <td>{{ __('item.loan_date') }}</td>
                                                <td>{{ __('item.loan_term') }}</td>
                                                <td>{{ __('item.interest_rate') }}</td>
                                                <td>{{ __('item.vehicle_color') }}</td>
                                                <td>{{ __('item.vehicle_date') }}</td>
                                                <td>{{ __('item.vehicle_quantity') }}</td>
                                                <td>{{ __('item.function') }}</td>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($item as $key => $value)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $value->property_name }}</td>
                                                    <td>{{ $value->property_no }}</td>
                                                    <td>{{ $value->customer_name }}</td>
                                                    <td class="text-right">${{ number_format($value->property_price*1,2) }}</td>
                                                    <td class="text-right">${{ number_format($value->property_discount_amount*1,2) }}</td>
                                                    <td>${{ $value->loan_amount }}</td>
                                                    <td>{{ $value->loan_date }}</td>
                                                    <td>{{ $value->installament_term.$value->duration_type }}</td>
                                                    <td>{{ $value->interest_rate."%" }}</td>
                                                    <td>{{ $value->vehicle_color }}</td>
                                                    <td>{{ $value->vehicle_date }}</td>
                                                    <td>{{ $value->vehicle_quantity }}</td>
                                                   
                                                    <td>
                                                    
                                                        <a class="btn btn-sm btn-info" href="{{ URL::to('property/view_sale/' . $value->id) }}">View Detail</a>
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                {!! $item->appends(\Request::except('page'))->render() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">{{ __('item.property') }}{{ __('item.booked') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contentBookingModal">
                    <table style="width: 100%;">
                        
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                    {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#project, #customer').select2();
        function view_booking(property){
            $('#contentBookingModal').html('...');
            $.ajax({
                type:'get',
                url:"{{ route('sale_property.view_booking') }}",
                data:{property:property},
                success:function(data){
                    $('#contentBookingModal').html(data.html);
                },
                error:function(errors){
                    $('#contentBookingModal').html('No Data!!!');
                }
            })
        }
    </script>
@endsection
