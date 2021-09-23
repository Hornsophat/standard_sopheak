@extends('back-end/master')
@section('title',"Product List")
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
                <li class="breadcrumb-item">{{ __('item.product') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_product') }}</a></li>
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
                                    @if(Auth::user()->can('create-product') || $isAdministrator)
                                        <a class="btn btn-small btn-success" href="{{ URL::to('product/create') }}">{{ __('item.new_product') }}</a>
                                    @endif
                                    @if(Auth::user()->can('list-product-unit') || $isAdministrator)
                                        <a class="btn btn-small btn-secondary" href="{{ route('product.units') }}">{{ __('item.list_unit') }}</a>
                                    @endif
                                    @if(Auth::user()->can('list-product-category') || $isAdministrator)
                                        <a class="btn btn-small btn-secondary" href="{{ route('product.categories') }}">{{ __('item.list_categories') }}</a>
                                    @endif
                                 </div>

                                <div class="col-md-6 text-right">
                                    <form action="/product" method="get">
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
                                            <td>@sortablelink('id',trans('item.item_id'))</td>
                                            <td>{{trans('item.thumbnail')}}</td>
                                            <td>@sortablelink('name',__('item.name'))</td>
                                            <td>@sortablelink('category', __('item.category'))</td>
                                            <td>@sortablelink('unit', __('item.unit'))</td>
                                            <td>@sortablelink('size',__('item.size'))</td>
                                            {{-- <td>@sortablelink('cost_price',__('item.unit_price'))</td> --}}
                                            <td>@sortablelink('qty',__('item.quantity'))</td>
                                            <td>{{ __('item.function') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item as $key => $value)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            @php
                                                $url = asset('/images/default/no_image.png');
                                                if($value->avatar != null && file_exists(public_path($value->avatar)))
                                                    $url = asset('public'.$value->avatar);
                                            @endphp
                                            <td style="text-align: center">
                                                <img src="{{ $url }}"  alt="Missing Image" width="50px"/>

                                            </td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ ucfirst($value->category_name) }}</td>
                                            <td>{{ ucfirst($value->unit_name) }}</td>
                                            <td>{{ $value->size }}</td>
                                            <td>{{ $value->qty }}</td>
                                            <td>
                                            @if(Auth::user()->can('inventory-product') || $isAdministrator)
                                                <a class="btn btn-sm btn-success" href="{{ route('inventories') }}">{{trans('item.inventory')}}</a>
                                            @endif
                                            @if(Auth::user()->can('edit-product') || $isAdministrator)
                                                <a class="btn btn-sm btn-info" href="{{ URL::to('product/' . $value->id . '/edit') }}">{{trans('item.edit')}}</a>
                                            @endif
                                            @if(Auth::user()->can('delete-product') || $isAdministrator)
                                                <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                   href="{{ URL::to('product/' . $value->id.'/delete' ) }}">{{ trans('item.delete')}}</a>
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
    </main>
@endsection
