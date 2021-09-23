@extends('back-end/master')
@section('style')

@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.property') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.merge_property') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.merge_property') }}</h3><hr/>
                            <div class="error display_message"></div><br/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('error-message'))
                                    <div class="alert alert-danger">{{ Session::get('message') }}</div>
                                @endif
                                {!! Html::ul($errors->all()) !!}

                                {!! Form::open(array('route' => array('property_merge') , 'files' => true, 'method' => 'POST')) !!}

                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('property', trans('item.property'))."<span class='star'> *</span>" !!}
                                        {{ Form::select(null, $properties ?? [], $item->project_id ?? '', ['class' => 'form-control', 'id'=>'boxProperty'])}}
                                        {!! Form::hidden('merge_properties',null,['id'=>'merge_properties']) !!}
                                    </div>
                                    <div class="col-lg-8 form-group">
                                        {!! Form::label('property', trans('item.property'))."<span class='star'> *</span>" !!}
                                        {{ Form::text(null, null, ['class' => 'form-control merge-text', 'readonly'])}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('project', trans('item.project_name'))."<span class='star'> *</span>" !!}
                                        {{ Form::select('project', $projects ?? [], $item->project_id ?? '', ['class' => 'form-control project_id', 'id'=>'project', 'required'])}}
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('project_zone', trans('item.project_zone'))."<span class='star'> *</span>" !!}
                                        {{ Form::select('project_zone', [], '', ['id' => 'project_zone', 'class' => 'form-control zone_id','id'=>'zone', 'required'])}}
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('property_type', trans('item.property_type'))."<span class='star'> *</span>" !!}
                                        <select name="property_type" id="property_type" class="form-control" required="true">
                                            @foreach($propertytypes as $propertytype)
                                                <option value="{{ $propertytype->id }}">{{ $propertytype->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                            {!! Form::label('property_name', trans('item.property_name'))."<span class='star'> *</span>" !!}
                                            {!! Form::text('property_name', Input::old('property_name'), array('class' => 'form-control', 'required')) !!}
                                        </div>
                                   </div> 
                                   <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('property_no', trans('item.property_no'))."<span class='star'> *</span>" !!}
                                            {!! Form::text('property_no', Input::old('property_no'), array('class' => 'form-control', 'id'=>'property_no', 'required')) !!}
                                        </div>
                                   </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('price', trans('item.price'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('price', null, array('class' => 'form-control','id'=>'price','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('price'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('price') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('discount_amount', trans('item.discount'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('discount_amount', null, array('class' => 'form-control','id'=>'discount_amount','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('discount_amount'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('discount_amount') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <h5>{{ __('item.boundaries') }}</h5>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('boundary_north', trans('item.boundary_north')) !!}
                                        {!! Form::text('boundary_north', Input::old('boundary_north'), array('class' => 'form-control')) !!}
                                    </div>
                                     <div class="col-md-6">
                                        {!! Form::label('boundary_south', trans('item.boundary_south')) !!}
                                        {!! Form::text('boundary_south', Input::old('boundary_south'), array('class' => 'form-control')) !!}
                                    </div>
                                     <div class="col-md-6">
                                        {!! Form::label('boundary_east', trans('item.boundary_east')) !!}
                                        {!! Form::text('boundary_east', Input::old('boundary_east'), array('class' => 'form-control')) !!}
                                    </div>
                                     <div class="col-md-6">
                                        {!! Form::label('boundary_west', trans('item.boundary_west')) !!}
                                        {!! Form::text('boundary_west', Input::old('boundary_west'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>

                                <div class="row" id="aboutContent">
                                    <div class="col-md-12 mt-2">
                                        <h5>{{ __('item.abouts') }} &emsp;<button type="button" class="btn btn-sm btn-primary" id="btnAddAbout"><i class="fa fa-plus"></i></button></h5>
                                        <hr>
                                    </div>
                                    <div class="col-md-12" id="contentAbout">
                                        {!! Form::label('about[]', trans('item.about')) !!} <span class="btn btn-sm btn-outline-danger btn-remove-about"><i class="fa fa-close"></i></span>
                                        {!! Form::text('about[]', Input::old('about[]'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('address_street', trans('item.address_street')) !!}
                                        {!! Form::text('address_street', Input::old('address_street'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('address_number', trans('item.address_number')) !!}
                                        {!! Form::text('address_number', Input::old('address_number'), array('class' => 'form-control')) !!}
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('zip_code', trans('item.zipcode')) !!}
                                        {!! Form::text('zip_code', Input::old('zip_code'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('bed_room', trans('item.bedroom')) !!}
                                        {!! Form::number('bed_room', Input::old('bed_room'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('bath_room', trans('item.bathroom')) !!}
                                        {!! Form::number('bath_room', Input::old('bath_room'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('other_room', trans('item.other_room')) !!}
                                        {!! Form::number('other_room', Input::old('other_room'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <div class="checkbox">
                                            <label><input name="has_elevator" id="has_elevator" value="1" type="checkbox"> {{ trans('item.elevator') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <div class="checkbox">
                                            <label><input name="has_basement" id="has_basement" type="checkbox" value="1"> {{ trans('item.basement') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <div class="checkbox">
                                            <label><input name="has_swimming_pool" id="has_elevator" type="checkbox" value="1"> {{ trans('item.swimming_pool') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('living_room_surface', trans('item.living_room_surface')) !!}
                                        {!! Form::number('living_room_surface', Input::old('living_room_surface'), array('class' => 'form-control', 'step'=>'any')) !!}
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('built_up_surface', trans('item.built_up_surface')) !!}
                                        {!! Form::number('built_up_surface', Input::old('built_up_surface'), array('class' => 'form-control', 'step'=>'any')) !!}
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('habitable_surface', trans('item.habitable_surface')) !!}
                                        {!! Form::number('habitable_surface', Input::old('habitable_surface'), array('class' => 'form-control', 'step'=>'any')) !!}
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('ground_surface', trans('item.ground_surface')) !!}
                                        {!! Form::number('ground_surface', Input::old('ground_surface'), array('class' => 'form-control', 'step'=>'any')) !!}
                                    </div>

                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('year_of_construction', trans('item.year_of_construction')) !!}
                                        {!! Form::number('year_of_construction', Input::old('year_of_construction'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('year_of_renovation', trans('item.year_of_renovation')) !!}
                                        {!! Form::number('year_of_renovation', Input::old('year_of_renovation'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('floor_number', trans('item.floor_number')) !!}
                                        {!! Form::number('floor_number', Input::old('floor_number'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        {!! Form::label('total_number_of_floors_building', trans('item.total_number_of_floors_building')) !!}
                                        {!! Form::number('total_number_of_floors_building', Input::old('total_number_of_floors_building'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('item.property_image') }}(Multiple)</label>
                                    <input class="form-control" id="images" name="images[]" type="file" multiple accept="image/x-png,image/bmp,image/jpeg">
                                </div>

                                {{-- Maps --}}
                                <div class="col-lg-12 form-group align-items-center">
                                    <div class="map" style="height: 400px !important;" id="map_in"></div>
                                    <div style="text-align:center; margin-top: 15px;">
                                        <input class="btn btn-danger" id="clear_shapes" value="{{ __('item.clear_map') }}" type="button"  />
                                        <input type="hidden" class="btn btn-primary" id="save_raw" type="button" />
                                        <input type="hidden" id="restore" value="restore(IO.OUT(array,map))"         type="button" />
                                        <input type="hidden" name="map_data" id="data" value="" style="width:100%" readonly/>
                                    </div>
                                    <div class="map" id="map_out"></div>
                                </div>
                                {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'property_submit')) !!}

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
        $('#boxProperty').select2();
        $(document).on('click', '#btnAddAbout', function(){
            var text = `<div class="col-md-12">`;
                text +=     `{!! Form::label('about[]', trans('item.about')) !!} <span class="btn btn-sm btn-outline-danger btn-remove-about"><i class="fa fa-close"></i></span>`;
                text +=     `{!! Form::text('about[]', Input::old('about[]'), array('class' => 'form-control')) !!}`;
                text +=`</div>`;
            $('#aboutContent').append(text);
        });
        $(document).on('click', 'body .btn-remove-about', function(){
            $(this).parent('div').remove();
        });
        $(document).ready(function() {
            $("#property_submit").click(function(event){
                $("#save_raw").trigger("click");
            });

            $('.project_id').on('change', function() {
                if(this.value == '') {
                    $(".display_message").html("Please select a valid project!");
                   return false;
                }
                $(".display_message").html("");

                var url = "{{url('property/get-zone-ajax/')}}" + '/' + this.value;
                $.ajax({
                    url: url, 
                    success: function(result){
                        if(result.status && result.data != null) {
                            $('.zone_id').removeAttr("disabled");
                            var html_zone = "<option value=''>-- Select --</option>";
                            $.each(result.data.zones, function (key, val) {
                                html_zone += "<option value='"+ key +"'>" + val + "</option>";
                            });
                            $('.zone_id').html(html_zone);
                        }
                    }
                });
            });
        });

        $('#boxProperty').change(function(){
            var property = $('#boxProperty option:selected').val()
            var merge_properties = $('#merge_properties').val();
            var merge_text = $('.merge-text').val();
            var property_no = $('#property_no').val();
            if(!property){
                return false;
            }
            $.ajax({
                method:'get',
                url:"{{ route('merge_get_property') }}",
                data:{property:property, merge_properties:merge_properties, merge_text:merge_text, property_no:property_no},
                success:function(data){
                    $('#boxProperty').html(data.html_property)
                    $('#property_no').val(data.property_no)
                    $('#project').html(data.html_project)
                    $('#zone').html(data.html_zone)
                    $('#property_type').html(data.html_property_type)
                    $('#merge_properties').val(data.merge_properties)
                    $('.merge-text').val(data.merge_text)
                    $('#price').val(data.price)
                    $('#discount_amount').val(data.discount_amount)
                    $('#boundary_east').val(data.boundary_east)
                    $('#boundary_north').val(data.boundary_north)
                    $('#boundary_south').val(data.boundary_south)
                    $('#boundary_west').val(data.boundary_west)
                    $('#contentAbout').html(data.content_about)
                }
            })
        })
    </script>
@stop