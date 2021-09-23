@extends('back-end/master')
@section('title',"List Customer")
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.customer') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.customer_visit') }}</a></li>
            </ul>
        </div>

        {{-- List Customer --}}
        <div class="row">
            <div class="col-md-12">
                @include('flash/message')

                <div class="tile">
                    <h4><a href="{{route("viewCustomer", $customer->id)}}"><b>{{ $customer->first_name." " .$customer->last_name}}</b></a></h4><br/>
                    <div class="tile-body">

                        <form action="{{ route("storeVisit", $customer->id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="row" style="margin-bottom: 50px;">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="sale">{{ __('item.sale') }}<span class="required">*</span></label>
                                        <select name="sale" id="sale" class="form-control" required>
                                            <option value="">-- {{ __('item.select') }} --</option>
                                            @foreach($sale as $key=>$value)
                                                <option value="{{ $value->id }}" {{ old("sale") == $value->id?"selected":"" }}>{{ $value->first_name. " ". $value->last_name }}</option>
                                                @endforeach
                                        </select>
                                        @if ($errors->has('sale'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('sale') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">{{ __('item.remarks') }}<span class="required">*</span></label>
                                        <textarea name="remark" class="form-control" required>{{ old("remark") }}</textarea>
                                        @if ($errors->has('remark'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('remark') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button name="submit" class="btn btn-primary pull-right">{{ __('item.submit') }}</button>
                                </div>


                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap">
                                <thead>
                                    <th>{{ __('item.no') }}</th>
                                    <th>{{ __('item.sale') }}</th>
                                    <th>{{ __('item.remarks') }}</th>
                                    <th>{{ __('item.status') }}</th>
                                    <th>{{ __('item.create_on') }}</th>
                                </thead>
                                <tbody>
                                @if($customer_visit->count()>0)
                                    @foreach($customer_visit as $key=>$value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><a href="{{ route("viewEmployee",!is_null($value->sale)?$value->id:"-1") }}"> {{ !is_null($value->sale)?$value->sale->first_name. ' '. $value->sale->last_name:"" }}</a></td>
                                            <td>{{ $value->remark }}</td>
                                            <td>{!! $value->status ==1 ? "<span class='badge badge-info'>active</span>" : "<span class='badge badge-danger'>Inactive</span>" !!}</td>
                                            <td>{{ $value->created_at }}</td>
                                        </tr>

                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Found!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
