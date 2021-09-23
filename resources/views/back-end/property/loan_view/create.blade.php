@extends('back-end/master')
@section('style')

@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.vehicle') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.add_vehicle') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.add_vehicle') }}</h3><hr/>
                            <div class="error display_message"></div><br/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                {!! Html::ul($errors->all()) !!}

                                {!! Form::open(array('url' => 'property/create' , 'files' => true)) !!}

                                <div class="row">
                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('project', trans('item.vehicle_name'))."<span class='star'> *</span>" !!}
                                        {{ Form::select('project', $projects ?? [], $item->project_id ?? '', ['class' => 'form-control project_id', 'required'])}}
                                        
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        {!! Form::label('project_zone', trans('item.project_zone'))."<span class='star'> *</span>" !!}
                                        {{ Form::select('project_zone', [], '', ['id' => 'project_zone', 'class' => 'form-control zone_id', 'disabled', 'required'])}}
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
                                            {!! Form::label('type_vehicle', trans('item.type_vehicle'))."<span class='star'> *</span>" !!}
                                            {!! Form::text('property_name', Input::old('property_name'), array('class' => 'form-control', 'required')) !!}
                                        </div>
                                   </div> 
                                   <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('vehicle_no', trans('item.vehicle_no'))."<span class='star'> *</span>" !!}
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
                                            {!! Form::label('nb_machine', trans('item.nb_machine'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('nb_machine', Input::old('nb_machine'), array('class' => 'form-control', 'required')) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('nb_machine'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('nb_machine') }}</strong>
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
                                <br>
                               
                                <div class="row" id="aboutContent" style = "display:none;">
                                    <div class="col-md-12 mt-2">
                                        <h5>{{ __('item.abouts') }} &emsp;<button type="button" class="btn btn-sm btn-primary" id="btnAddAbout"><i class="fa fa-plus"></i></button></h5>
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::label('about[]', trans('item.about')) !!} <span class="btn btn-sm btn-outline-danger btn-remove-about"><i class="fa fa-close"></i></span>
                                        {!! Form::text('about[]', Input::old('about[]'), array('class' => 'form-control')) !!}
                                    </div>
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
        $('#width, #length').on('input',function(){
            $('#ground_surface').val($('#width').val()*$('#length').val())
        })
    </script>
@stop