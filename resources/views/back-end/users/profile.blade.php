@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.user') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.edit_profile') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{ __('item.edit_profile') }}</h2>
                        </div>

                    </div>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-info">{{ Session::get('success') }}</div>
                @endif
                <form method="POST" action="{{ route('user.profile', ['id'=>$user->id]) }}"> 
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('item.name') }}:</strong>
                                <input type="text" name="name" placeholder="{{ __('item.name') }}" class="form-control"  value="{{ old('name')? old("name"): $user->name }}"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('item.email') }}:</strong>
                                <input type="email" name="email" placeholder="{{ __('item.email') }}" class="form-control" value="{{ old('email')? old("email"): $user->email }}"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">{{ __('item.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
