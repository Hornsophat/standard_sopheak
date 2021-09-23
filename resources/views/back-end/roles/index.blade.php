@extends('back-end/master')

@section('content')
<style type="text/css">
    table tr th , table tr td{
        white-space: nowrap;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">{{ __('item.user_group') }}</li>
            <li class="breadcrumb-item active"><a href="#">{{ __('item.list_user_group') }}</a></li>
        </ul>
    </div>
    <div class="tile">
        <div class="tile-body">
        @if(Auth::user()->can('create-user-group') || $isAdministrator)
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <a class="btn btn-success" href="{{ route('role.create') }}">{{ __('item.new_group') }}</a>
                </div>
            </div><br/>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-nowrap">
                <tr>
                    <th>@sortablelink('id',__("item.no"))</th>
                    <th>@sortablelink('name',__("item.title"))</th>
                    <th>@sortablelink('description',__("item.description"))</th>
                    <th width="280px">{{ __('item.function') }}</th>
                </tr>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                        @if(Auth::user()->can('edit-user-group') || $isAdministrator)
                        <a class="btn btn-primary" href="{{ route('role.edit',['id'=>$role->id]) }}">{{ __('item.edit') }}</a>
                        @endif
                        @if(Auth::user()->can('delete-user-group') || $isAdministrator)
                        <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{ route('role.destroy', ['id'=>$role->id]) }}" class="btn btn-danger">{{ __('item.delete') }}</a>
                        @endif

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $roles->appends(\Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
        </div>
    </div>
</main>
@endsection
