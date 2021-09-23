@extends('back-end/master')
@section('style')

@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.project') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.add_project') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.add_project') }}</h3><hr/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                {!! Html::ul($errors->all()) !!}

                                {!! Form::open(array('url' => 'project/create', 'files' => true)) !!}

                                <div class="form-group">
                                    {!! Form::label('project_name', trans('item.project_name'))."<span class='star'> *</span>" !!}
                                    {!! Form::text('project_name', Input::old('project_name'), array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('land', trans('item.land'))."<span class='star'> *</span>" !!}
                                    <select name="land" id="land" class="form-control">
                                        @foreach($land as $item)
                                            <option value="{{ $item->id }}">{{ $item->property_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('address_street', trans('item.address_street')) !!}
                                    {!! Form::text('address_street', Input::old('address_street'), array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('address_number', trans('item.address_number')) !!}
                                    {!! Form::text('address_number', Input::old('address_number'), array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('ground_surface', trans('item.ground_surface')) !!}
                                    {!! Form::number('ground_surface', Input::old('ground_surface'), array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    <label>{{ __('item.project_image') }}(Multiple)</label>
                                    <input class="form-control" id="images" name="images[]" type="file" multiple accept="image/x-png,image/bmp,image/jpeg">
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