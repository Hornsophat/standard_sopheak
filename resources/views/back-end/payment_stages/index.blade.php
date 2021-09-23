@extends('back-end/master')
@section('title', __("item.payment_stage"))
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
                <li class="breadcrumb-item">{{ __('item.payment_stage') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_payment_stage') }}</a></li>
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
                                        <div class="col-md-6">
                                            @if(Auth::user()->can('add-payment-stage') || $isAdministrator)
                                                <a class="btn btn-small btn-success" href="{{ route('payment_stage.create') }}">{{trans('item.add_payment_stage')}}</a><hr>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <form action="{{ route('payment_stages') }}" method="get">
                                                <div class="input-group">
                                                    <div class="col-md-6"></div>
                                                    <input type="text" name="search" class="form-control col-md-6 pull-right" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-nowrap">
                                            <thead>
                                            <tr>
                                                <td>{{ __('item.no') }}</td>
                                                <td>{{ __('item.date') }}</td>
                                                <td>{{ __('item.amount') }}</td>
                                                <td>{{ __('item.description') }}</td>
                                                <td>{{ __('item.function') }}</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($item as $key => $value)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                    <td class="text-right">${{ number_format($value->amount,2) }}</td>
                                                    <td>{{ $value->remark }}</td>
                                                    <td>
                                                    @if(Auth::user()->can('edit-payment-stage') || $isAdministrator)
                                                        <a class="btn btn-sm btn-info" href="{{ route('payment_stage.edit',['payment_stage'=>$value]) }}">{{trans('item.edit')}}</a>
                                                    @endif
                                                    @if(Auth::user()->can('delete-payment-stage') || $isAdministrator)
                                                        <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                           href="{{ route('payment_stage.destroy',['payment_stage'=>$value]) }}">{{ trans('item.delete')}}</a>
                                                    @endif
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
