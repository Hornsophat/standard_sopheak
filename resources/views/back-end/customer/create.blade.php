@extends('back-end/master')
@section('title',"Add Customer")
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    <style type="text/css">
    /*CAMERA*/
    #camera_view{
        width: 640px;
        height: 480px;
    }
    .form-control {
    line-height: 2;}
    </style>
@stop
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.customer') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.add_customer') }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4">
                <h3>{{ __('item.add_customer') }}</h3>
                <hr/>
                <form action="{{ route('storeCustomer') }}" method="POST" class="row form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <h5>{{ __('item.pertional_information') }}</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="firstname" class="control-label col-lg-3 p-0">{{ __('item.id') }}<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" class="form-control" value="{{$customer_no}}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6"></div>
                    <!-- Firstname En -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('first_name_en') ? ' has-error' : '' }}">
                        <label for="firstname" class="control-label col-lg-3 p-0">{{ __('item.first_name') }} (En)<span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="first_name_en" class="form-control" value="{{old('first_name_en')}}" required autofocus>
                            @if ($errors->has('first_name_en'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('first_name_en') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Lastname En -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('last_name_en') ? ' has-error' : '' }}">
                        <label for="last_name" class="control-label col-lg-3 p-0">{{ __('item.last_name') }} (En)<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="last_name_en" class="form-control" value="{{old('last_name_en')}}" required>
                            @if ($errors->has('last_name_en'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('last_name_en') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Firstname -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="firstname" class="control-label col-lg-3 p-0">{{ __('item.first_name') }} (Kh)<span class="required">*</span> </label>
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
                        <label for="last_name" class="control-label col-lg-3 p-0">{{ __('item.last_name') }} (Kh)<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" required>
                            @if ($errors->has('last_name'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Age -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('age') ? ' has-error' : '' }}">
                        <label for="age" class="control-label col-lg-3 p-0">{{ __('item.age') }} : </label>
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
                        <label for="sex" class="control-label col-lg-3 p-0">{{ __('item.sex') }} : </label>
                        <div class="col-lg-9 p-0">
                            <select class="form-control" name="sex">
                                <option value="">-- {{ __('item.select') }} --</option>
                                <option value="1">{{ __('item.male') }}</option>
                                <option value="2">{{ __('item.female') }}</option>
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
                        <label for="country" class="control-label col-lg-3 p-0">{{ __('item.country') }} <span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <select name="country" class="form-control" id="country" required>
                                <option value="">-- {{ __('item.select') }} --</option>
                                @foreach($countries as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                        <label for="nationality" class="control-label col-lg-3 p-0">{{ __('item.nationality') }} <span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="nationality" class="form-control" value="{{old('nationality')}}" required> 
                            @if ($errors->has('nationality'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('nationality') }}</strong>
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
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('identity_set_date') ? ' has-error' : '' }}">
                        <label for="fax" class="control-label col-lg-3 p-0">{{ __('item.identity_set_date') }}<span class="required">*</span></label>
                        <div class="col-lg-9 p-0">
                            <input type="date" name="identity_set_date" class="form-control dateISO" value="{{old("identity_set_date")}}" required>
                            @if ($errors->has('identity_set_date'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('identity_set_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('pob') ? ' has-error' : '' }}">
                        <label for="fax" class="control-label col-lg-3 p-0">{{ __('item.pob') }} : </label>
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


                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <h5>{{ __('item.contact') }}</h5>
                            <hr>
                        </div>
                    </div>
                    <!-- Contact -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('phone1') ? ' has-error' : '' }}">
                        <label for="contact" class="control-label col-lg-3 p-0">{{ __('item.phone1') }} <span class="required">*</span> </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="phone1" class="form-control" value="{{old('phone1')}}" required>
                            @if ($errors->has('phone1'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('phone1') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('phone2') ? ' has-error' : '' }}">
                        <label for="contact" class="control-label col-lg-3 p-0">{{ __('item.phone2') }} </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="phone2" class="form-control" value="{{old('phone2')}}">
                            @if ($errors->has('phone2'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('phone2') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- Fax -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('fax') ? ' has-error' : '' }}">
                        <label for="fax" class="control-label col-lg-3 p-0">{{ __('??????????????????') }} : </label>
                        <div class="col-lg-9 p-0">
                            <input type="text" name="fax" class="form-control" value="{{old('fax')}}">
                            @if ($errors->has('fax'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('fax') }}</strong>
                                </span> 
                            @endif
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label col-lg-3 p-0">{{ __('item.email') }} : </label>
                        <div class="col-lg-9 p-0">
                            <input type="email" name="email" class="form-control" value="{{old('email')}}">
                            @if ($errors->has('email'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
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
                                    <option value="{{ $value->province_id }}" {{old('province') == $value->province_id?"selected":""}}>{{ $value->province_kh_name }}</option>
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
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('house_number') ? ' has-error' : '' }}">
                        <label for="house_number" class="control-label col-lg-3 p-0">House Number</span></label>
                        <div class="col-lg-9 p-0">
                            <input name="house_number" type="text" class="form-control" value="{{ old('house_number') }}">
                            @if ($errors->has('house_number'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('house_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 form-group d-lg-flex align-items-center{{ $errors->has('street_number') ? ' has-error' : '' }}">
                        <label for="street_number" class="control-label col-lg-3 p-0">Street Number</span></label>
                        <div class="col-lg-9 p-0">
                            <input name="street_number" type="text" class="form-control" value="{{ old('street_number') }}">
                            @if ($errors->has('street_number'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('street_number') }}</strong>
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

                    {{-- WebCam --}}
                    <div class="col-lg-6">
                        <img src="{{ asset('images/default/camera_image.jpg') }}" id="uploadPreview" style='width:180px; height:210px;margin:auto; margin-bottom:15px; border:1px solid #CCCCCC; object-fit: cover'>
                        {{-- <img src="{{ asset('images/default/no_image.png') }}" id="uploadPreview" style='width:120px; height:150px; margin-bottom:15px; border:1px solid #CCCCCC; object-fit: cover'> --}}
                        <input id="uploadImage" type="file" accept="image/*" name="userfile" onchange="PreviewImage();" style="visibility:hidden; display:none;" />
                        <input type="hidden" id="cameraImage" name="cameraImage" value=""><br>
                        <button type="button" class="btn btn-outline-primary" style="width:180px;" onclick="open_camera()"><i class="fa fa-camera"></i> Camera</button>
                    </div>
                    <!-- Submit Form -->
                    <div class="col-lg-12">
                        <input type="submit" value="{{ __('item.save') }}" name="btnSave" class="btn btn-primary float-right">
                    </div>
                </form>
            </div>
        </div>
	</main>

<!-- CAMERA VIEW MODAL -->
<!-- Modal -->
<div id="CamModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Camera View</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" align="center">
        <div id="camera_view"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="capture_photo()" ><i class="fa fa-camera"></i> Capture</button>
      </div>
    </div>

  </div>
</div>
@stop

@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script src="{{URL::asset('back-end/js/webcam.min.js')}}"></script>

    <script type="text/javascript">
        $('#country ,#province, #district, #commune, #village, #pob_province, #pob_district, #pob_commune, #pob_village').select2();
        $(document).ready(function() {
            callFileInput('#profile', 1, 5120, ["jpg" , "jpeg" , "png"]);
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


    {{-- Webcam --}}
    <script type="text/javascript">
        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
                document.getElementById("uploadPreview").style.backgroundImage = "none";
            };
        }

        // Webcam.set({
        //     crop_width:600,
        //     crop_height:720,
        // });
        Webcam.set({
            crop_width:640,
            crop_height:480,
        });
        function open_camera(){
            $('#CamModal').modal('show');

            setTimeout(function(){
                Webcam.attach('#camera_view');
            },300);
        }
        function capture_photo(){
            Webcam.snap( function(data_uri) {
                document.getElementById("uploadPreview").src = data_uri;
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                document.getElementById('cameraImage').value = raw_image_data;
            } );
            setTimeout(function(){
                $('#CamModal').modal('hide')
            }, 300)
        }
        $('#CamModal').on('hidden.bs.modal', function () {
            Webcam.reset(); //shutdown camera
        });
    </script>
@stop