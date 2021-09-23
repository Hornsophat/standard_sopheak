@extends('back-end.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.department') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.create_department') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.add_department') }}</h3><hr/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                {!! Html::ul($errors->all()) !!}

                                {!! Form::open(['url' => $action, 'method' => $method ?? '']) !!}

                                    <div class="form-group">
                                        {!! Form::label('title', trans('item.title'))."<span class='star'> *</span>" !!}
                                        {!! Form::text('title', $item->title ?? '', array('class' => 'form-control')) !!}
                                    </div>

                                    {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right')) !!}

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script>
    <script src="{{URL::asset('back-end/js/map.selector.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#land_submit").click(function(event){
                $("#save_raw").trigger("click");
            });
        });

    </script>
@stop