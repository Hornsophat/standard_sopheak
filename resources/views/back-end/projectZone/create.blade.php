@extends('back-end/master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.project_zone') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.add_project_zone') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.add_zone') }}</h3><hr/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                {!! Html::ul($errors->all()) !!}

                                {!! Form::open(array('url' => 'projectzone/create')) !!}

                                <div class="form-group">
                                    {!! Form::label('zone_name', trans('item.zone_name'))."<span class='star'> *</span>" !!}
                                    {!! Form::text('zone_name', Input::old('zone_name'), array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('zone_code', trans('item.zone_code'))."<span class='star'> *</span>" !!}
                                    {!! Form::text('zone_code', Input::old('zone_code'), array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('project', trans('item.project'))."<span class='star'> *</span>" !!}
                                    <select name="project" id="project" class="form-control">
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project  ->property_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Maps --}}
                                <div class="col-lg-12 form-group align-items-center">
                                    <div class="map" style="height: 300px !important;" id="map_in"></div>
                                    <div style="text-align:center; margin-top: 15px;">
                                        <input class="btn btn-danger" id="clear_shapes" value="{{ __('item.clear_map') }}" type="button"  />
                                        <input type="hidden" class="btn btn-primary" id="save_raw" type="button" />
                                        <input type="hidden" id="restore" value="restore(IO.OUT(array,map))"         type="button" />
                                        <input type="hidden" name="map_data" id="data" value="" style="width:100%" readonly/>
                                    </div>
                                    <div class="map" id="map_out"></div>
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