@extends('back-end/master')

@section('content')
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
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>{{ __('item.create_new_role') }}</h2>
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
                <form method="post" action="{{ route('role.store') }}">
                    {{ csrf_field() }}
                    @include('back-end.roles.form')
                </form>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script src="{{ asset('back-end/js/jquery.min.js') }}"></script>
<script src="{{ asset('back-end/js/jquery.listswap.js') }}"></script>
<script>
    $.noConflict();
    jQuery(document).ready(function($){
        $('#source_3, #destination_3').listswap({
            truncate:true,
            height:162,
            is_scroll:true,
        });
    });
</script>
@endsection

