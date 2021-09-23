@extends('back-end/master')
@section('title',"Inventory")
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
                <li class="breadcrumb-item"><a href="{{ route('productList') }}">Product</a></li>
                <li class="breadcrumb-item active"><a href="#">Inventory Data Tracking</a></li>
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
                                    @if(Auth::user()->can('inventory-purchase') || $isAdministrator)
                                        <a class="btn btn-small btn-success" href="{{ route('purchase.create') }}">Add Purschase</a>
                                    @endif
                                    @if(Auth::user()->can('inventory-retrieve') || $isAdministrator)
                                        <a class="btn btn-small btn-danger" href="{{ route('inventory.retrieve') }}">Add Retrieve</a>
                                    @endif
                                 </div>

                                <div class="col-md-6 text-right">
                                    <form action="{{ route('inventories') }}" method="get">
                                        <div class="input-group">
                                            <div class="col-md-6"></div>
                                            <input type="text" name="search" class="form-control col-md-6 pull-right" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
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
                                            <td>@sortablelink('created_at','Date')</td>
                                            <td>@sortablelink('material_id', 'Product')</td>
                                            <td>@sortablelink('created_by','Add By')</td>
                                            <td>@sortablelink('qty','Qty')</td>
                                            <td>@sortablelink('unit_cost','Unit Cost')</td>
                                            <td>@sortablelink('total_cost','Total Cost')</td>
                                            <td>@sortablelink('status','Status')</td>
                                            <td>Type</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inventories as $key => $value)
                                        <tr>
                                            <td class="text-right">{{ ++$key }}</td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{{ $value->product }}</td>
                                            <td>{{ ucfirst($value->user_name) }}</td>
                                            <td class="text-right">{{ $value->in_out_qty }}</td>
                                            <td class="text-right">{{ number_format($value->unit_cost,2) }}</td>
                                            <td class="text-right">{{ number_format($value->total_cost,2) }}</td>
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
                                        {!! $inventories->links() !!}
                                    </div>
                                </div>
                            </div>                 
                    </div>
                </div>
        </div>
        </div>
    </main>
@endsection
