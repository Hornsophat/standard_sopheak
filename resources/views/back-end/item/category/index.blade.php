@extends('back-end/master')
@section('title',"List Product Category")
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
                <li class="breadcrumb-item"><a href="{{ route('productList') }}">{{ __('item.product') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_categories') }}</a></li>
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
                                     @if(Auth::user()->can('create-product-category') || $isAdministrator)
                                         <a class="btn btn-small btn-success" href="{{ route('product.category.create') }}">{{ __('item.new_category') }}</a>
                                     @endif
                                 </div>

                                <div class="col-md-6 text-right">
                                    <form action="{{ route('product.categories') }}" method="get">
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
                                            <td>@sortablelink('name',__('item.name'))</td>
                                            <td>@sortablelink('description',__('item.description'))</td>
                                            <td>{{ __('item.function') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item as $key => $value)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->description }}</td>
                                            <td>
                                            @if(Auth::user()->can('edit-product-category') || $isAdministrator)
                                                <a class="btn btn-sm btn-info" href="{{ route('product.category.edit',['id' => $value->id]) }}">{{trans('item.edit')}}</a>
                                            @endif
                                            @if(Auth::user()->can('delete-product-category') || $isAdministrator)
                                                <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                   href="#">{{ trans('item.delete')}}</a>
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
