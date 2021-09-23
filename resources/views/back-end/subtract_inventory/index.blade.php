@extends('back-end/master')
@section('title',"Subtract Inventory")
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
                <li class="breadcrumb-item"><a href="#">{{ __('item.subtract_inventory') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_subtract_inventory') }}</a></li>
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
                                    @if(Auth::user()->can('create-subtract-inventory') || $isAdministrator)
                                        <a class="btn btn-small btn-success" href="{{ route('subtract_inventory.create') }}">{{ __('item.add_subtract_inventory') }}</a>
                                    @endif
                                 </div>

                                <div class="col-md-6 text-right">
                                    <form action="{{ route('subtract_inventories') }}" method="get">
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
                                            <td>@sortablelink('created_at',__('item.date'))</td>
                                            <td>{{ __('item.reference') }}</td>
                                            <td>{{ __('item.project') }}</td>
                                            <td>{{ __('item.total_cost') }}</td>
                                            <td>{{ __('item.add_by') }}</td>
                                            <td>{{ __('item.received_by') }}</td>
                                            <td>{{ __('item.description') }}</td>
                                            <td>@sortablelink('status',__('item.status'))</td>
                                            <td>{{ __('item.function') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subtract_inventories as $key => $value)
                                        <tr>
                                            <td class="text-right">{{ ++$key }}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            <td>{{ $value->reference }}</td>
                                            <td>{{ $value->project_name }}</td>
                                            <td class="text-right">$ {{ number_format($value->total_cost,2) }}</td>
                                            <td>{{ ucfirst($value->created_name) }}</td>
                                            <td>{{ ucfirst($value->received_name) }}</td>
                                            <td>{{ $value->description }}</td>
                                            <td class="text-center">
                                                @if($value->status=='received')
                                                    <span class="badge badge-success">{{ $value->status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $value->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(Auth::user()->can('receive-subtract-inventory') || $isAdministrator && $value->status!='received')
                                                    <a class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to receive this item?');" href="{{ route('subtract_inventory.receive', ['id'=>$value->id]) }}">Receive</a>
                                                @endif
                                                @if(Auth::user()->can('view-subtract-innventory') || $isAdministrator)
                                                    <a class="btn btn-sm btn-primary" href="{{ route('subtract_inventory.view', ['id'=>$value->id]) }}">{{ __('item.detail') }}</a>
                                                @endif
                                                @if(Auth::user()->can('edit-subtract-innventory') || $isAdministrator && $value->status!='received')
                                                    <a class="btn btn-sm btn-info" href="{{ route('subtract_inventory.edit', ['id'=>$value->id]) }}">{{trans('item.edit')}}</a>
                                                @endif
                                                @if(Auth::user()->can('delete-subtract-innventory') || $isAdministrator && $value->status!='received')
                                                    <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                       href="{{ route('subtract_inventory.destroy', ['id'=>$value->id]) }}">{{ trans('item.delete')}}</a>
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
                                        {!! $subtract_inventories->appends(\Request::except('page'))->render() !!}
                                    </div>
                                </div>
                            </div>                 
                    </div>
                </div>
        </div>
        </div>
    </main>
@endsection
