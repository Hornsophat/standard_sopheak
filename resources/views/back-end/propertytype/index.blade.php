@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.property_types') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_property_type') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            @include('flash/message')
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if(Auth::user()->can('create-property-zone') || $isAdministrator)
                                                <a class="btn btn-small btn-success" href="{{ URL::to('propertytype/create') }}">{{trans('item.new_propertytype')}}</a>
                                                <hr />
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <form action="/propertytype" method="get">
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
                                                <td>@sortablelink('id',trans('item.propertytype_id'))</td>
                                                <td>@sortablelink('name',trans('item.propertytype_name'))</td>
                                                <td>Proper Type Name (Khmer)</td>
                                                <td>Group</td>
                                                <td>Extention</td>
                                                <td>{{ __('item.function') }}</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($item as $value)
                                                <tr>
                                                    <td>{{ $value->id }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->name_kh }}</td>
                                                    <td>{{ $value->group }}</td>
                                                    <td>{{ $value->extension }}</td>
                                                    <td>
                                                    @if(Auth::user()->can('edit-property-type') || $isAdministrator)
                                                        <a class="btn btn-sm btn-info" href="{{ URL::to('propertytype/' . $value->id . '/edit') }}">{{trans('item.edit')}}</a>
                                                    @endif
                                                    @if(Auth::user()->can('delete-property-type') || $isAdministrator)
                                                        <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                           href="{{ URL::to('propertytype/delete/' . $value->id ) }}">{{ trans('item.delete')}}</a>
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
@endsection
