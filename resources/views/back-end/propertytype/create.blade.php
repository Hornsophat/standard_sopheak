@extends('back-end/master')
@section('style')

@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.property_types') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.add_property_type') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.add_property_type') }}</h3><hr/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                {!! Html::ul($errors->all()) !!}

                                {!! Form::open(array('url' => 'propertytype/create')) !!}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('propertytype_name', trans('item.propertytype_name'))."<span class='star'> *</span>" !!}
                                            {!! Form::text('propertytype_name', Input::old('propertytype_name'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('propertytype_name_kh', 'Name (khmer)')."<span class='star'> *</span>" !!}
                                            {!! Form::text('propertytype_name_kh', Input::old('propertytype_name_kh'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('group', 'Group')."<span class='star'> *</span>" !!}
                                            {!! Form::text('group', Input::old('group'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('extension', 'Extension')."<span class='star'> *</span>" !!}
                                            {!! Form::text('extension', Input::old('extension'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'land_submit')) !!}

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
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@stop