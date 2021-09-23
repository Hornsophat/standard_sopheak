@extends('back-end/master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.land') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.create_land') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.add_land') }}</h3><hr/>
                            <div class="panel-body">
                                    @if (Session::has('message'))
                                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                                    @endif
                                    {!! Html::ul($errors->all()) !!}

                                    {!! Form::open(array('url' => 'land/create', 'files' => true)) !!}

                                    <div class="form-group">
                                        {!! Form::label('land_name', trans('item.land_name'))."<span class='star'> *</span>" !!}
                                        {!! Form::text('land_name', Input::old('land_name'), array('class' => 'form-control')) !!}
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
                                        <label for="province">{{ __('item.province') }}<span class="required">*</span></label>
                                        <select name="province" class="form-control" id="province" required>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                            @foreach($provinces as $key => $value)
                                                <option value="{{ $value->province_id }}" {{old("province") == $value->province_id?"selected":""}}>{{ $value->province_kh_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('province'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('province') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="district">{{ __('item.district') }}<span class="required">*</span></label>
                                        <select name="district" class="form-control" id="district" required disabled>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                        </select>
                                        @if ($errors->has('district'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('district') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="commune">{{ __('item.commune') }}<span class="required">*</span></label>
                                        <select name="commune" class="form-control" id="commune" required disabled>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                        </select>
                                        @if ($errors->has('commune'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('commune') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="village">{{ __('item.village') }}</label>
                                        <select name="village" class="form-control" id="village" disabled>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                        </select>
                                        @if ($errors->has('village'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('village') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label >{{ __('item.land_layout') }}</label>
                                        <input class="form-control" id="land_layout" name="land_layout" type="file" accept="image/x-png,image/bmp,image/jpeg">
                                    </div>

                                    <div class="form-group" style="display: none;">
                                        {!! Form::label('ground_surface', trans('item.ground_surface'))." (m<sup>2</sup>)" !!}
                                        {!! Form::text('ground_surface', Input::old('ground_surface'), array('class' => 'form-control')) !!}
                                    </div>


                                    {{-- Maps --}}
                                    <div class="form-group">
                                        <div class="map" style="height: 400px !important;" id="map_in"></div>
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
        $('#country ,#province, #district, #commune, #village').select2();
        $(document).ready(function() {
            $("#land_submit").click(function(event){
                $("#save_raw").trigger("click");
            });
        });

        $(document).on('change', '#province', function(){
            $('#village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#village').attr('disabled', 'disabled');
            $('#commune').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#commune').attr('disabled', 'disabled');
            var province = $('#province option:selected').val();
            if(!province || province==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_districts") }}',
                type:'get',
                data:{province:province},
                success:function(data){
                    $('#district').removeAttr('disabled');
                    $('#district').html(data.option);
                }
            });
        });
        $(document).on('change', '#district', function(){
            $('#village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#village').attr('disabled', 'disabled');
            var district = $('#district option:selected').val();
            if(!district || district==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_communes") }}',
                type:'get',
                data:{district:district},
                success:function(data){
                    $('#commune').removeAttr('disabled');
                    $('#commune').html(data.option);
                }
            });
        });
        $(document).on('change', '#commune', function(){
            var commune = $('#commune option:selected').val();
            if(!commune || commune==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_villages") }}',
                type:'get',
                data:{commune:commune},
                success:function(data){
                    $('#village').removeAttr('disabled');
                    $('#village').html(data.option);
                }
            });
        });

    </script>
@stop