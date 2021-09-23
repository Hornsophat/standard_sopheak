@extends('back-end/master')
@section('style')

@stop
@section('content')

<style>
.form-control {
    line-height: 2;}
</style>
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
                                    {{-- <div class="col-lg-4 form-group">
                                        {!! Form::label('project', trans('item.vehicle_type'))."<span class='star'> *</span>" !!}
                                        {{ Form::select('project', $projects ?? [], $item->project_id ?? '', ['class' => 'form-control project_id', 'required'])}}
                                        
                                    </div> --}}

                                    {{-- <div class="col-lg-4 form-group">
                                        {!! Form::label('vehicle_name', trans('item.vehicle_quality'))."<span class='star'> *</span>" !!}
                                        {{ Form::select('project_zone', [], '', ['id' => 'project_zone', 'class' => 'form-control zone_id', 'disabled', 'required'])}}
                                    </div> --}}

                                    <div class="col-lg-4 form-group" style = "display:none;"> 
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
                                            {!! Form::text('property_no', Input::old('property_no'), array('class' => 'form-control', 'required')) !!}
                                        </div>
                                   </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('price', trans('item.price'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('price', null, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
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
                                            {!! Form::text('discount_amount', null, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
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
                                <br>
                                <div class="row">
                                <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('brand', trans('item.brand'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('nb_machine', Input::old('nb_machine'), array('class' => 'form-control', 'required')) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >Text</span>
                                            </div>
                                            @if ($errors->has('brand'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('brand') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                   <div class="input-group">
                                            {!! Form::label('vehicle_quantity', trans('item.vehicle_quantity'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('vehicle_quantity', null, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('vehicle_quantity'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('vehicle_quantity') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <br>
                                   <div class="col-lg-6  align-items-center{{ $errors->has('vehicle_date') ? ' has-error' : '' }}">
                                        <label for="fax" class="control-label col-lg-3 p-0">{{ __('item.vehicle_date') }} : </label>
                                        <div class="col-lg-9 p-0">
                                            <input type="date" name="vehicle_date" class="form-control dateISO" value="{{old("vehicle_date")}}">
                                            @if ($errors->has('dob'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('vehicle_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                   <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('vehicle_color', trans('item.vehicle_color'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('vehicle_color', Input::old('vehicle_color'), array('class' => 'form-control', 'required')) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('vehicle_color'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('vehicle_color') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
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
                    $('#village').val(data.village)
                    $('#commune').val(data.commune)
                    $('#district').val(data.district)
                    $('#province').val(data.province)
                    $('#contentAbout').html(data.content_about)
                }
            })
        })
    </script>
@stop