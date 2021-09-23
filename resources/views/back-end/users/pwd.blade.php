@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.user') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.change_password') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{ __('item.change_password') }}</h2>
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
                <form method="POST" action="{{ route('user.update-password') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('item.old_password') }}:</strong>
                                <input type="password" name="password" placeholder="{{ __('item.old_password') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('item.new_password') }}:</strong>
                                <input type="password" name="new_password" placeholder="{{ __('item.new_password') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('item.confirm_password') }}:</strong>
                                <input type="password" name="password_confirmation" placeholder="{{ __('item.confirm_password') }}" class="form-control" />
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
