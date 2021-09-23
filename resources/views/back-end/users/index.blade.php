@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.user') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_user') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">
                <div class="row">
                @if(Auth::user()->can('create-user') || $isAdministrator)
                    <div class="col-lg-12 margin-tb">
                        <a class="btn btn-success" href="{{ route('user.create') }}">{{ __('item.new_user') }}</a>
                    </div>
                </div>
                <br/>
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
                            <th>{{__("item.profile")}}</th>
                            <th>@sortablelink('name',__("item.name"))</th>
                            <th>@sortablelink('email',__("item.email"))</th>
                            <th>{{ __('item.role') }}</th>
                            <th width="280px">{{ __('item.function') }}</th>
                        </tr>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @php
                                        $url = asset('/images/default/no_image.png');
                                        if($user->profile != null && file_exists(public_path($user->profile)))
                                            $url = asset('public'.$user->profile);
                                    @endphp
                                    <img src="{{ $url }}" alt="Missing Image" width="50px"/>

                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                 <label class="label label-success">{{ isset($user->roles[0])?$user->roles[0]->name:"" }}</label>
                                </td>
                                <td>
                                @if(Auth::user()->can('edit-user') || $isAdministrator)
                                    <a class="btn btn-primary" href="users/{{$user->id}}/edit">{{ __('item.edit') }}</a>
                                @endif
                                @if(Auth::user()->can('delete-user') || $isAdministrator)
                                    <a onclick="return confirm('Are you sure you want to delete this item?');"
                                       class="btn btn-danger" href="users/{{$user->id}}/delete">{{ __('item.delete') }}</a>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! $data->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
