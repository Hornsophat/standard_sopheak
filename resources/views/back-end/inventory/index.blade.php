@extends('back-end/master')
@section('title',__('item.inventory'))
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
                <li class="breadcrumb-item"><a href="#">{{ __('item.inventory') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_inventory') }}</a></li>
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
                                 <div class="col-md-6">
                                    {{-- @if(Auth::user()->can('inventory-purchase') || $isAdministrator)
                                        <a class="btn btn-small btn-success" href="{{ route('purchase.create') }}">Add Purschase</a>
                                    @endif
                                    @if(Auth::user()->can('inventory-retrieve') || $isAdministrator)
                                        <a class="btn btn-small btn-danger" href="{{ route('inventory.retrieve') }}">Add Retrieve</a>
                                    @endif --}}
                                 </div>
                                <div class="col-md-6 text-right">
                                    <form action="{{ route('inventories') }}" method="get">
                                        <div class="row">
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6">
                                               <div class="form-group" style="margin-bottom: 5px!important;">
                                                    <select class="form-control select2-option-picker" onchange="this.form.submit()" name="product">
                                                        <option  value="">-- Select Product --</option>
                                                        @foreach($products as $product)
                                                        <option value="{{ $product->id }}" @if($request->product==$product->id) selected @endif>{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                               </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" name="search" class="form-control pull-right" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
                                                </div>
                                            </div> --}}
                                        </div>
                                    </form>
                                </div>
                             </div>
                            <hr />

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td>{{ __('item.no') }}</td>
                                            <td>@sortablelink('created_at',__('item.date'))</td>
                                            <td>{{ __('item.reference') }}</td>
                                            <td>@sortablelink('material_id', __('item.product'))</td>
                                            <td>@sortablelink('created_by',__('item.add_by'))</td>
                                            <td>@sortablelink('qty',__('item.qty'))</td>
                                            <td>@sortablelink('unit_cost',__('item.unit_cost'))</td>
                                            <td>@sortablelink('total_cost',__('item.total_cost'))</td>
                                            <td>@sortablelink('status',__('item.status'))</td>
                                            <td>{{ __('item.type') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inventories as $key => $value)
                                        <tr>
                                            <td class="text-right">{{ ++$key }}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            <td>{{ $value->reference }}</td>
                                            <td>{{ $value->product }}</td>
                                            <td>{{ ucfirst($value->user_name) }}</td>
                                            <td class="text-right">{{ $value->in_out_qty }}</td>
                                            <td class="text-right">$ {{ number_format($value->unit_cost,2) }}</td>
                                            <td class="text-right">$ {{ number_format($value->total_cost,2) }}</td>
                                            <td class="text-center">
                                                @if($value->status=='received')
                                                    <span class="badge badge-success">{{ $value->status }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $value->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($value->type=='purchase')
                                                    <span class="badge badge-success">{{ $value->type }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $value->type }}</span>
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
                                        {!! $inventories->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            </div>                 
                    </div>
                </div>
        </div>
        </div>
    </main>
@endsection
