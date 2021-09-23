@extends('back-end/master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.user') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.edit_user') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{ __('item.edit_new_user') }}</h2>
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
                <form method="POST" action="{{ route('user.edit',['id'=>$user->id]) }}" enctype="multipart/form-data">
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
                            <div class="form-group">
                                <strong>{{ __('item.password') }}:</strong>
                                <input type="password" name="password" placeholder="{{ __('item.password') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('item.confirm_password') }}:</strong>
                                <input type="password" name="confirm-password" placeholder="{{ __('item.confirm_password') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('item.role') }}:</strong>
                                <select name="roles[]" class="form-control">
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}" {{ $role->id == (isset($user->roles[0]) && $user->roles[0]->id) ? "selected": "" }}>{{$role->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <h5>{{ __('item.profile_image') }}</h5>
                                <hr>
                            </div>
                        </div>
                        <!-- Profile -->
                        <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('profile') ? ' has-error' : '' }}">
                            <label for="profile" class="control-label col-lg-3 p-0">{{ __('item.image') }} : </label>
                            <div class="col-lg-9 p-0">
                                <input id="profile" type="file" name="profile" class="form-control" value="{{old('profile')}}" accept=".jpg,.jpeg,.png">
                                @if ($errors->has('profile'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('profile') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">{{ __('item.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script>
        $(document).ready(function() {
            callFileInput('#profile', 1, 5120, ["jpg" , "jpeg" , "png"]);
        });
    </script>
@stop
