@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
             @include('flash/message')
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.project') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_project') }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile" >
                    <div class="tile-body">
                        @include('flash/message')
                        <div class="row">
                            <div class="col-md-6">
                                @if(Auth::user()->can('create-project') || $isAdministrator)
                                    <a class="btn btn-small btn-success" href="{{ URL::to('project/create') }}">{{trans('item.new_project')}}</a>
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                <form action="/project" method="get">
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
                                    <td>@sortablelink('id',trans('item.project_no'))</td>
                                    <td>@sortablelink('property_name',trans('item.project_name'))</td>
                                    <td>@sortablelink('address_street',trans('item.address_street'))</td>
                                    <td>@sortablelink('address_number',trans('item.address_number'))</td>
                                    <td>@sortablelink('ground_surface',trans('item.ground_surface'))</td>
                                    <td>@sortablelink('land_id', __("item.land"))</td>
                                    <td>@sortablelink('', __("item.zone"))</td>
                                    <td>{{ __('item.total_expense') }}</td>
                                    <td>{{ __('item.function') }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item as $key => $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->property_name }}</td>
                                        <td>{{ $value->address_street }}</td>
                                        <td>{{ $value->address_number }}</td>
                                        <td><span class="badge badge-warning">{{ $value->ground_surface*1 }} m<sup>2</sup></span></td>
                                        <td>{{ isset($value->land->property_name)?$value->land->property_name:'' }}</td>
                                        <td>
                                            <a href="{{ route("projectzone", $value->id) }}">
                                                <span class="badge badge-primary">
                                                 {{ $value->projectZone()->count()  }}
                                            </span>
                                            </a>

                                        </td>
                                        <td><b>{{ "$ ".number_format((float)$value->expense->sum("amount"), 2, '.', '') }}</b></td>
                                        <td>
                                        @if(Auth::user()->can('view-project') || $isAdministrator)
                                            <a class="btn btn-sm btn-primary" href="{{ URL::to('project/' . $value->id . '/detail') }}">{{trans('item.detail')}}</a>
                                        @endif
                                        @if(Auth::user()->can('view-project-commission') || $isAdministrator)
                                            <a class="btn btn-sm btn-info" href="{{ URL::to('project/commission/'.$value->id) }}">{{ __('item.commission') }}</a>
                                        @endif
                                        @if(Auth::user()->can('edit-project') || $isAdministrator)
                                            <a class="btn btn-sm btn-info" href="{{ URL::to('project/' . $value->id . '/edit') }}">{{trans('item.edit')}}</a>
                                        @endif
                                        @if(Auth::user()->can('delete-project') || $isAdministrator && 1==4)
                                            <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                               href="{{ URL::to('project/delete/' . $value->id ) }}">{{ trans('item.delete')}}</a>
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
                        <div class="clearfix">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
