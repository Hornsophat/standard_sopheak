@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.project_zone') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_project_zone') }}</a></li>
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
                                                <a class="btn btn-small btn-success" href="{{ route("projectzoneCreate") }}">{{trans('item.new_zone')}}</a>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <form action="/projectzone/index" method="get">
                                                <div class="input-group">
                                                    <div class="col-md-6"></div>
                                                    <input type="text" name="search" class="form-control col-md-6 pull-right" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                    <hr />

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-nowrap">
                                            <thead>
                                            <tr>
                                                <td>@sortablelink('id',trans('item.zone_id'))</td>
                                                <td>@sortablelink('name',trans('item.zone_name'))</td>
                                                <td>@sortablelink('code',trans('item.zone_code'))</td>
                                                <td>@sortablelink('code', __("item.project"))</td>
                                                <td>{{ __('item.function') }}</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($item as $key => $value)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->code }}</td>
                                                    <td>{{ isset($value->project->property_name) ? $value->project->property_name : "" }}</td>
                                                    <td>
                                                        @if(Auth::user()->can('edit-property-zone') || $isAdministrator)
                                                            <a class="btn btn-sm btn-info" href="{{ URL::to('projectzone/' . $value->id . '/edit') }}">{{trans('item.edit')}}</a>
                                                        @endif
                                                        @if(Auth::user()->can('delete-property-zone') || $isAdministrator)
                                                        <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                           href="{{ URL::to('projectzone/delete/' . $value->id ) }}">{{ trans('item.delete')}}</a>
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
