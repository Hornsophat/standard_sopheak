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
                                                <a class="btn btn-small btn-success" href="{{ URL::to('property/vehicle/create') }}">{{trans('item.new_vehicle')}}</a>
                                            @endif
                                            @if(Auth::user()->can('merge-property') || $isAdministrator)
                                                <!-- <a class="btn btn-small btn-outline-success" href="{{ route('property_merge') }}">{{trans('item.merge_property')}}</a> -->
                                            @endif
                                        </div>
                                        <div class="col-lg-9 col-sm-12">
                                            <form action="{{ URL('property') }}" method="get">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                                        <!-- <div class="form-group">
                                                            <label>{{ __('item.project') }}</label>
                                                            <select name="project" id="project" class="form-control" onchange="this.form.submit()">
                                                                <option value>-- {{__('item.select')}} {{__('item.type')}} --</option>
                                                                @foreach($projects as $project)
                                                                    <option value="{{ $project->id }}"
                                                                        @if ($request->project == $project->id)
                                                                        selected="selected"
                                                                        @endif
                                                                    >{{ $project->property_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> -->
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

                                    <div class="table-responsive" >
                                        <table class="table table-hover table-bordered table-nowrap" >
                                            <thead >
                                            <tr >
                                                <td>{{ __('item.property_id') }}</td>
                                                <td>{{ __('item.vehicle_name') }}</td>
                                                <td >{{ __('item.vehicle_no') }}</td>
                                                <td>{{ __('item.customer') }}</td>
                                                <td>{{ __('item.price') }}</td>
                                                <td>{{ __('item.discount') }}</td>
                                                <!-- <td>{{ __('item.address_street') }}</td>
                                                <td>{{ __('item.year_of_construction') }}</td> -->
                                                <td>{{ __('item.property_type') }}</td>
                                                <td>{{ __('item.project_name') }}</td>
                                                <td>{{ __('item.zone') }}</td>
                                                <td>{{ __('item.status') }}</td>
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
                                                    <td>{{ $value->address_street }}</td>
                                                    <td>{{ $value->year_of_construction }}</td>
                                                    <td>{{ isset($value->propertyType->name) ? $value->propertyType->name : "" }}</td>
                                                    <td>{{ !is_null($value->project)?$value->project->property_name:"" }}</td>
                                                    <td>{{ !is_null($value->projectZone)?$value->projectZone->name:"" }}</td>
                                                    <td>
                                                        @if($value->status==1)
                                                        {!! "<span class='rounded p-1 badge-primary'>".__('item.available')."</span>" !!}
                                                        @elseif($value->status==2)
                                                        <a href="{{ route('sale_property.view_sale', ['property'=>$value]) }}"><span class='rounded p-1 badge-danger'>{{ __('item.sold') }}</span></a>
                                                        @elseif($value->status==3)
                                                        <a onclick="view_booking({{ $value->id }})" data-toggle="modal" data-target="#bookingModal" class='property_booked'><span class='rounded p-1 badge-warning'>{{ __('item.booked') }}</span></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                    @if(Auth::user()->can('edit-property') || $isAdministrator)
                                                        <a class="btn btn-sm btn-info" href="{{ URL::to('property/vehicle/' . $value->id . '/edit') }}">{{trans('item.edit')}}</a>
                                                      
                                                    @endif


                                                    @if(Auth::user()->can('delete-property') || $isAdministrator)
                                                        <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                           href="{{ URL::to('property/delete/' . $value->id ) }}">{{ trans('item.delete')}}</a>
                                                    @endif
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            {{trans('item.more')}}
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @if($value->status!=2)
                                                                <div class="dropdown-item"></div>
                                                                <a class="dropdown-item" href="{{ route('sale_property.sale', ['property'=>$value]) }}"><i class="fa fa-shopping-cart"></i>{{trans('បញ្ចាំ')}}</a>
                                                                <!-- @if($value->status==1)
                                                                <a class="dropdown-item" href="{{ route('sale_property.booking',['property'=>$value]) }}"><i class="fa  fa-book"></i>{{trans('item.property_book')}}</a>
                                                                @endif -->
                                                            @endif
                                                            @if(Auth::user()->can('add-property') || $isAdministrator)
                                                            <a class="dropdown-item" href="{{ URL::to('property/' . $value->id . '/duplicate') }}"><i class="fa fa-plus"></i>{{trans('item.duplicate_copy')}}</a>
                                                        @endif
                                                        @if(Auth::user()->can('view-property') || $isAdministrator)
                                                        <a class="dropdown-item" href="{{ URL::to('property/view_sale/' . $value->id) }}"><i class="fa fa-eye"></i>View Payment</a>
                                                        <a class="dropdown-item" href="{{ URL::to('property/' . $value->id . '/detail') }}"><i class="fa fa-eye"></i>{{trans('item.detail')}}</a>
                                                        @endif
                                                                @if(Auth::user()->can('cancel-merge-property') || $isAdministrator && !empty($value->chile_merge))
                                                                    <a class="dropdown-item" href="{{ route('property.cancel_merge',['id'=>$value->id]) }}"><i class="fa fa-ban"></i>{{trans('item.cancel_merge')}}</a>
                                                                @endif
                                                            
                                                            </div>
                                                        </div>

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
