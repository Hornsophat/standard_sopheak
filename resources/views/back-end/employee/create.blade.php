@extends('back-end/master')
@section('title',"Add Employee")
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    
@stop
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.employee') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.add_employee') }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4">
          		<h3 class="text-dark mb-4">{{ __('item.add_employee') }}</h3><hr/>

                <form action="{{ route('saveEmployee') }}" method="POST" class="row form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!-- First name -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="control-label col-lg-3 p-0">{{ __('item.first_name') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" required autofocus>
                            @if ($errors->has('first_name'))
    	                        <span class="help-block text-danger">
    	                            <strong>{{ $errors->first('first_name') }}</strong>
    	                        </span> 
    	                    @endif
                        </div>
                    </div>
                    <!-- Lastname -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="lastname" class="control-label col-lg-3 p-0">{{ __('item.last_name') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" required>
                            @if ($errors->has('last_name'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Position -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('id_card') ? ' has-error' : '' }}">
                        <label for="position" class="control-label col-lg-3 p-0">{{ __('item.id_card') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="id_card" class="form-control" value="{{old('id_card')}}" required>
                            @if ($errors->has('id_card'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('id_card') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Salary -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('salary') ? ' has-error' : '' }}">
                        <label for="position" class="control-label col-lg-3 p-0">{{ __('item.salary') }} : </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="salary" class="form-control" value="{{old('salary')}}">
                            @if ($errors->has('salary'))
                                <span class="help-block text-danger">
                                <strong>{{ $errors->first('salary') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    {{--postion--}}
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('position') ? ' has-error' : '' }}">
                        <label for="position" class="control-label col-lg-3 p-0">{{ __('item.position') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <div class="input-group mb-3">
                                {{ Form::select('position', $position, old("position"), ['class' => 'form-control', 'id' => 'select-position', 'required'] ) }}
                              <div class="input-group-prepend">
                                <label class="input-group-text input-group-text-position" for="position"><i class="fa fa-plus"></i></label>
                              </div>
                            </div>
                            @if ($errors->has('position'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('position') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{--department--}}
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('department') ? ' has-error' : '' }}">
                        <label for="department" class="control-label col-lg-3 p-0">{{ __('item.department') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <div class="input-group mb-3">
                                {{ Form::select('department', $department, old("department"), ['class' => 'form-control', 'id' => 'select-department', 'required'] ) }}
                              <div class="input-group-prepend">
                                <label class="input-group-text input-group-text-department" for="department"><i class="fa fa-plus"></i></label>
                              </div>
                            </div>
                            @if ($errors->has('department'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('department') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Age -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('age') ? ' has-error' : '' }}">
                        <label for="age" class="control-label col-lg-3 p-0">{{ __('item.age') }} </label>
                        <div class="col-lg-9 p-0">
                            <input type="number" name="age" class="form-control" value="{{old('age')}}" min="0" max="100">
                            @if ($errors->has('age'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('age') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Sex -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('sex') ? ' has-error' : '' }}">
                        <label for="sex" class="control-label col-lg-3 p-0">{{ __('item.sex') }}</label>
                        <div class="col-lg-9 p-0">
                            <select class="form-control" name="sex">
                            <option value="">-- {{ __('item.select') }} --</option>
                            <option value="1" {{ old("sex") ==1? "selected":"" }}>{{ __('item.male') }}</option>
                            <option value="2" {{ old("sex") ==2? "selected":"" }}>{{ __('item.female') }}</option>
                        </select>
                            @if ($errors->has('sex'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('sex') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Country -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('country') ? ' has-error' : '' }}">
                        <label for="department" class="control-label col-lg-3 p-0">{{ __('item.country') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <select name="country" class="form-control" id="country" required>
                                <option value="">-- {{ __('item.select') }} --</option>
                                @foreach($country as $key => $value)
                                    <option value="{{ $value->id }}" {{old("country") == $value->id?"selected":""}}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- Nationality -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('nationality') ? ' has-error' : '' }}">
                        <label for="nationality" class="control-label col-lg-3 p-0">{{ __('item.nationality') }}</label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="nationality" class="form-control" value="{{old('nationality')}}">
                            @if ($errors->has('nationality'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('sale_type') ? ' has-error' : '' }}">
                        <label for="sale_type" class="control-label col-lg-3 p-0">{{ __('item.sale_type') }}<span class="required">*</span> </label>
                        <div class="col-lg-1 p-0 text-center">
                         <input type="checkbox" name="check_sale" id="check_sale" class="checkbox"/>
                        </div>
                        <div class="col-lg-8 p-0">
                            <div class="input-group mb-3">
                                {{ Form::select('sale_type', $sale_type, old("sale_type"), ['class' => 'form-control select-sale-type', 'required', 'id' => 'sale_type', 'disabled'] ) }}
                              <div class="input-group-prepend">
                                <label class="input-group-text input-group-text-sale_type" for="sale_type"><i class="fa fa-plus"></i></label>
                              </div>
                            </div>
                            @if ($errors->has('sale_type'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('sale_type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('identity') ? ' has-error' : '' }}">
                        <label for="identity" class="control-label col-lg-3 p-0">{{ __('item.identity_number') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="identity" class="form-control" value="{{old('identity')}}" required> 
                            @if ($errors->has('identity'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('identity') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label for="fax" class="control-label col-lg-3 p-0">{{ __('item.dob') }} : </label>
                        <div class="col-lg-9 p-0">
                            <input type="date" name="dob" class="form-control dateISO" value="{{old("dob")}}">
                            @if ($errors->has('dob'))
                                <span class="help-block text-danger">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('pob') ? ' has-error' : '' }}">
                        <label for="fax" class="control-label col-lg-3 p-0">{{ __('item.pob') }}</label>
                        <div class="col-lg-9 p-0">
                            <textarea name="pob" class="form-control">{{ old("pob") }}</textarea>
                            @if ($errors->has('pob'))
                                <span class="help-block text-danger">
                                <strong>{{ $errors->first('pob') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> --}}
                    <!-- Place of Birth -->
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <h5>{{ __('item.pob') }}</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('pob_province') ? ' has-error' : '' }}">
                        <label for="pob_province" class="control-label col-lg-3 p-0">{{ __('item.province') }}</label>
                        <div class="col-lg-9 p-0">
                            <select name="pob_province" class="form-control" id="pob_province">
                                <option value=>-- {{ __('item.select') }} --</option>
                                @foreach($provinces as $key => $value)
                                    <option value="{{ $value->province_id }}" {{old("pob_province") == $value->province_id?"selected":""}}>{{ $value->province_kh_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('pob_province'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('pob_province') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('pob_district') ? ' has-error' : '' }}">
                        <label for="pob_district" class="control-label col-lg-3 p-0">{{ __('item.district') }}</label>
                        <div class="col-lg-9 p-0">
                            <select name="pob_district" class="form-control" id="pob_district" disabled>
                                <option value=>-- {{ __('item.select') }} --</option>
                            </select>
                            @if ($errors->has('pob_district'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('pob_district') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('pob_commune') ? ' has-error' : '' }}">
                        <label for="pob_commune" class="control-label col-lg-3 p-0">{{ __('item.commune') }}</label>
                        <div class="col-lg-9 p-0">
                            <select name="pob_commune" class="form-control" id="pob_commune" disabled>
                                <option value=>-- {{ __('item.select') }} --</option>
                            </select>
                            @if ($errors->has('pob_commune'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('pob_commune') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('pob_village') ? ' has-error' : '' }}">
                        <label for="pob_village" class="control-label col-lg-3 p-0">{{ __('item.village') }}</label>
                        <div class="col-lg-9 p-0">
                            <select name="pob_village" class="form-control" id="pob_village" disabled>
                                <option value=>-- {{ __('item.select') }} --</option>
                            </select>
                            @if ($errors->has('pob_village'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('pob_village') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    {{-- Contact --}}
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <h5>{{ __('item.contact') }}</h5>
                            <hr>
                        </div>
                    </div>
                    <!-- Phone1 -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('phone1') ? ' has-error' : '' }}">
                        <label for="phone1" class="control-label col-lg-3 p-0">{{ __('item.phone1') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="phone1" class="form-control" value="{{old('phone1')}}" required>
                            @if ($errors->has('phone1'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('phone1') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Phone2 -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('phone2') ? ' has-error' : '' }}">
                        <label for="phone1" class="control-label col-lg-3 p-0">{{ __('item.phone2') }}</label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="phone2" class="form-control" value="{{old('phone2')}}">
                            @if ($errors->has('phone2'))
                                <span class="help-block text-danger">
                                <strong>{{ $errors->first('phone2') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label col-lg-3 p-0">{{ __('item.email') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <input type="email" name="email" class="form-control" value="{{old('email')}}" required> 
                            @if ($errors->has('email'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Fax -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('fax') ? ' has-error' : '' }}">
                        <label for="fax" class="control-label col-lg-3 p-0">{{ __('item.fax') }}</label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="fax" class="form-control" value="{{old('fax')}}">
                            @if ($errors->has('fax'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('fax') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Address -->
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <h5>{{ __('item.address') }}</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('province') ? ' has-error' : '' }}">
                        <label for="province" class="control-label col-lg-3 p-0">{{ __('item.province') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
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
                    </div>

                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('district') ? ' has-error' : '' }}">
                        <label for="district" class="control-label col-lg-3 p-0">{{ __('item.district') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <select name="district" class="form-control" id="district" required disabled>
                                <option value=>-- {{ __('item.select') }} --</option>
                            </select>
                            @if ($errors->has('district'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('district') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('commune') ? ' has-error' : '' }}">
                        <label for="commune" class="control-label col-lg-3 p-0">{{ __('item.commune') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <select name="commune" class="form-control" id="commune" required disabled>
                                <option value=>-- {{ __('item.select') }} --</option>
                            </select>
                            @if ($errors->has('commune'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('commune') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('village') ? ' has-error' : '' }}">
                        <label for="village" class="control-label col-lg-3 p-0">{{ __('item.village') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <select name="village" class="form-control" id="village" required disabled>
                                <option value=>-- {{ __('item.select') }} --</option>
                            </select>
                            @if ($errors->has('village'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('village') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Profile -->
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <h5>{{ __('item.profile_image') }}</h5>
                            <hr>
                        </div>
                    </div>
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

                    <!-- Submit Form -->
                    <div class="col-lg-12">
                        <input type="submit" value="{{ __('item.save') }}" name="btnSave" class="btn btn-primary float-right">
                    </div>
                </form>
            </div>
        </div>

	</main>


@stop

@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script type="text/javascript">
        $('#select-department ,#country ,#province, #district, #commune, #village, #pob_province, #pob_district, #pob_commune, #pob_village').select2();
        $(document).ready(function() {
            callFileInput('#profile', 1, 5120, ["jpg" , "jpeg" , "png"]);

            $("#check_sale").click(function() {
                // this function will get executed every time the #home element is clicked (or tab-spacebar changed)
                if($("#check_sale").is(":checked")) // "this" refers to the element that fired the event
                {
                    $("#sale_type").removeAttr('disabled');
                }else{
                    $("#sale_type").val("").trigger("change");
                    $("#sale_type").attr('disabled', 'disabled');
                }
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



        // =========== Place Of Bith =========
        $(document).on('change', '#pob_province', function(){
            $('#pob_village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#pob_village').attr('disabled', 'disabled');
            $('#pob_commune').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#pob_commune').attr('disabled', 'disabled');
            var province = $('#pob_province option:selected').val();
            if(!province || province==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_districts") }}',
                type:'get',
                data:{province:province},
                success:function(data){
                    $('#pob_district').removeAttr('disabled');
                    $('#pob_district').html(data.option);
                }
            });
        });
        $(document).on('change', '#pob_district', function(){
            $('#pob_village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#pob_village').attr('disabled', 'disabled');
            var district = $('#pob_district option:selected').val();
            if(!district || district==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_communes") }}',
                type:'get',
                data:{district:district},
                success:function(data){
                    $('#pob_commune').removeAttr('disabled');
                    $('#pob_commune').html(data.option);
                }
            });
        });
        $(document).on('change', '#pob_commune', function(){
            var commune = $('#pob_commune option:selected').val();
            if(!commune || commune==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_villages") }}',
                type:'get',
                data:{commune:commune},
                success:function(data){
                    $('#pob_village').removeAttr('disabled');
                    $('#pob_village').html(data.option);
                }
            });
        });
    </script>
@stop