@extends('back-end/master')
@section('style')

@stop
@section('content')
<style type="text/css">
    .width-100{
        width: 100% !important;
    }
</style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.land') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.edit_land') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('flash/message')
                        <div class="panel panel-default">
                            <h3>{{ __('item.edit_land') }}</h3>
                            <hr/>
                            <div class="panel-body">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ isset($_GET['tab']) && $_GET['tab'] ==1? "active":(!isset($_GET['tab'])?"active":"")}}"
                                           id="home-tab" data-toggle="tab" value="1" href="#land_information" role="tab"
                                           aria-controls="land_information" aria-selected="true">
                                            <i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.land_infor') }}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ isset($_GET['tab']) && $_GET['tab'] ==2? "active":""}}"
                                           id="profile-tab" data-toggle="tab" href="#land_owner" value="2" role="tab"
                                           aria-controls="land_owner" aria-selected="false">
                                            <i class="fa fa-address-book" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.land_owner') }}
                                        </a>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade {{ isset($_GET['tab']) && $_GET['tab'] ==1? "show active":(!isset($_GET['tab'])?"show active":"")}}"
                                         id="land_information" role="tabpanel" aria-labelledby="home-tab">
                                        <br/><br/>
                                        <div class="row ">
                                            <div class="col-md-12">
                                                {!! Html::ul($errors->all()) !!}

                                                {!! Form::open(array('url' => 'land/'.$item->id.'/edit', 'files' => true)) !!}

                                                <div class="form-group">
                                                    {!! Form::label('land_name', trans('item.land_name'))."<span class='star'> *</span>" !!}
                                                    {!! Form::text('land_name', $item->property_name, array('class' => 'form-control')) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('address_street', trans('item.address_street')) !!}
                                                    {!! Form::text('address_street', $item->address_street, array('class' => 'form-control')) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('address_number', trans('item.address_number')) !!}
                                                    {!! Form::text('address_number', $item->address_number, array('class' => 'form-control')) !!}
                                                </div>
                                                <div class="form-group">
                                                    <label for="province">{{ __('item.province') }}<span class="required">*</span></label>
                                                    <select name="province" class="form-control" id="province" required>
                                                        <option value=>-- {{ __('item.select') }} --</option>
                                                        @foreach($provinces as $key => $value)
                                                            <option value="{{ $value->province_id }}" @if($value->province_id==$item->province) selected @endif>{{ $value->province_kh_name }}</option>
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
                                                    <select name="district" class="form-control" id="district" required  @if(!$item->district) disabled @endif>
                                                        <option value=>-- {{ __('item.select') }} --</option>
                                                        @foreach($districts as $key => $value)
                                                            <option value="{{ $value->dis_id }}" @if($value->dis_id==$item->district) selected @endif>{{ $value->district_namekh }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('district'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('district') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="commune">{{ __('item.commune') }}<span class="required">*</span></label>
                                                    <select name="commune" class="form-control" id="commune" required @if(!$item->commune) disabled @endif>
                                                        <option value=>-- {{ __('item.select') }} --</option>
                                                        @foreach($communes as $key => $value)
                                                            <option value="{{ $value->com_id }}" @if($value->com_id==$item->commune) selected @endif>{{ $value->commune_namekh }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('commune'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('commune') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="village">{{ __('item.village') }}</label>
                                                    <select name="village" class="form-control" id="village"  @if(!$item->village) disabled @endif>
                                                        <option value=>-- {{ __('item.select') }} --</option>
                                                        @foreach($villages as $key => $value)
                                                            <option value="{{ $value->vill_id }}" @if($value->vill_id==$item->village) selected @endif>{{ $value->village_namekh }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('village'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('village') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addressModal"> <i class="fa fa-plus"></i> Add other address </button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        @if($land_address->isNotEmpty())
                                                        <table class="table mt-2">
                                                            <thead>
                                                                <tr class="badge-primary">
                                                                    <th>{{ __('item.no') }}</th>
                                                                    <th>{{ __('item.province') }}</th>
                                                                    <th>{{ __('item.district') }}</th>
                                                                    <th>{{ __('item.commune') }}</th>
                                                                    <th>{{ __('item.village') }}</th>
                                                                    <th width="70px">{{ __('item.function') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($land_address as $key => $address)
                                                                <tr>
                                                                    <td>{{ $key+1 }}</td>
                                                                    <td>{{ $address->province_name }}</td>
                                                                    <td>{{ $address->district_name }}</td>
                                                                    <td>{{ $address->commune_name }}</td>
                                                                    <td>{{ $address->village_name }}</td>
                                                                    <td><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editAddressModal" onclick="getEditLandAddress({{ $address->id }})">Edit</button></td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('item.land_layout') }}</label>
                                                    <input class="form-control" id="land_layout" name="land_layout" type="file" accept="image/x-png,image/bmp,image/jpeg">
                                                </div>

                                                <div class="form-group">
                                                    @php
                                                        $image = \App\Model\Image::where('object_id', $item->id)->first();
                                                        $image_path ='';
                                                        if($image){
                                                            $image_path = $image->path;
                                                        }
                                                    @endphp
                                                    @if($image_path!='' && file_exists('public'.$image_path))
                                                        <img style="width: 100%" src="{{ asset('public'.$image_path) }}">
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('ground_surface', trans('item.ground_surface'))." m<sup>2</sup>" !!}
                                                    {!! Form::text('ground_surface', $item->landOwner->sum("ground_surface"), array('class' => 'form-control')) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('Total Price', trans('item.total_price')) !!}
                                                    {!! Form::text('total_price', "$ ". $item->landOwner->sum("price"), array('class' => 'form-control', 'disabled')) !!}
                                                </div>

                                                {{-- Maps --}}
                                                <div class="form-group">

                                                    <div class="map" style="height: 300px !important;" id="map_out"></div>
                                                    <hr/>

                                                    <div class="map" style="height: 400px !important;" id="map_in"></div>
                                                    <div style="text-align:center; margin-top: 15px;">
                                                        <input class="btn btn-danger" id="clear_shapes" value="{{ __('item.clear_map') }}"
                                                               type="button"/>
                                                        <input class="btn btn-danger" id="cancel_map" value="{{ __('item.cancel_map') }}"
                                                               type="button"/>
                                                        <input class="btn btn-primary" id="change_map" value="{{ __('item.change_map') }}"
                                                               type="button"/>
                                                        <input type="hidden" class="btn btn-primary" id="save_raw"
                                                               type="button"/>
                                                        <input type="hidden" name="map_data" class="default-data" id="data"
                                                               value='{{ $item->map_data }}' style="width:100%" readonly/>
                                                        <input type="hidden" id="restore" value="restore(IO.OUT(array,map))"
                                                               type="button"/>
                                                    </div>
                                                </div>

                                                {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'land_submit')) !!}

                                                {!! Form::close() !!}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(file_exists(public_path($land_layout->path)))
                                                    <div id="planit" style="width: 100%;"></div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>



                                    <div class="tab-pane fade {{ isset($_GET['tab']) && $_GET['tab'] ==2? "show active":""}}"
                                         id="land_owner" role="tabpanel" aria-labelledby="profile-tab">
                                        <br/><br/>
                                        <form action="{{ route("createLandOwner", $item->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $land_owner->id }}">
                                            <!-- Firstname -->
                                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                <label for="first_name" class="control-label p-0">{{ __('item.first_name') }} <span
                                                            class="required">*</span> </label>
                                                <input type="text" name="first_name" class="form-control"
                                                       value="{{old('first_name')?old('first_name'):$land_owner->first_name}}"
                                                       required autofocus>
                                                @if ($errors->has('first_name'))
                                                    <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <!-- Lastname -->
                                            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                <label for="last_name" class="control-label col-lg-3 p-0">{{ __('item.last_name') }}
                                                    <span class="required">*</span></label>
                                                <input type="text" name="last_name" class="form-control"
                                                       value="{{old('last_name')?old('last_name'):$land_owner->last_name}}"
                                                       required>
                                                @if ($errors->has('last_name'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('sex') ? ' has-error' : '' }}">
                                                <label for="sex" class="control-label p-0">{{ __('item.sex') }} : </label>

                                                <select class="form-control" name="sex">
                                                    <option value="">-- {{ __('item.select') }} --</option>
                                                    <option value="1" {{ old("sex") == 1?"selected":($land_owner->gender == 1? "selected":"") }}>
                                                        {{ __('item.male') }}
                                                    </option>
                                                    <option value="2" {{ old("sex") == 2?"selected":($land_owner->gender == 2? "selected":"") }}>
                                                        {{ __('item.female') }}
                                                    </option>
                                                </select>
                                                @if ($errors->has('sex'))
                                                    <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('sex') }}</strong>
                                                </span>
                                                @endif

                                            </div>

                                            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                                <label for="price" class="control-label p-0">{{ __('item.price') }} <span
                                                            class="required">*</span> </label>
                                                <input type="number" name="price" id="price" class="form-control"
                                                       min="1"
                                                       value="{{ old("price")?old("price"): $land_owner->price }}"
                                                       required/>
                                                @if ($errors->has('price'))
                                                    <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('price') }}</strong>
                                                </span>
                                                @endif

                                            </div>

                                            <div class="form-group {{ $errors->has('ground_surface') ? ' has-error' : '' }}">
                                                <label for="price" class="control-label p-0">{{ __('item.ground_surface') }}
                                                    (m<sup>2</sup>)<span class="required">*</span> </label>
                                                <input type="number" name="ground_surface" id="ground_surface" min="1"
                                                       class="form-control"
                                                       value="{{ old("ground_surface")?old("ground_surface"):$land_owner->ground_surface }}"
                                                       required/>
                                                @if ($errors->has('ground_surface'))
                                                    <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('ground_surface') }}</strong>
                                                </span>
                                                @endif

                                            </div>

                                            <div class="form-group {{ $errors->has('remark') ? ' has-error' : '' }}">
                                                <label for="remark" class="control-label p-0">{{ __('item.remarks') }}</label>
                                                <textarea class="form-control" name="remark"
                                                          id="remark">{{ old('remark')?old('remark'):$land_owner->note }}</textarea>
                                                @if ($errors->has('ground_surface'))
                                                    <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('ground_surface') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                            <input type="submit" class="btn btn-primary pull-right"
                                                   style="margin-bottom: 30px;" value="{{ __('item.submit') }}" />

                                        </form>

                                        <table class="table table-hover">
                                            <thead>
                                            <th>{{ __('item.no') }}#</th>
                                            <th>{{ __('item.name') }}</th>
                                            <th>{{ __('item.sex') }}</th>
                                            <th>{{ __('item.price') }}</th>
                                            <th>{{ __('item.ground_surface') }}</th>
                                            <th>{{ __('item.remarks') }}</th>
                                            <th></th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $landOwner = $item->landOwner()->paginate(20);
                                            @endphp

                                            @if($landOwner->count()<=0)
                                                <tr>
                                                    <td colspan="6" class="text-center">No Found!</td>
                                                </tr>
                                            @else

                                                @foreach($landOwner as $key => $value)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $value->first_name.' '. $value->last_name }}</td>
                                                        <td>{{ gender($value->gender) }}</td>
                                                        <td>
                                                            <span class="badge badge-primary">{{ "$ ". $value->price }}</span>
                                                        </td>
                                                        <td><span class="badge badge-warning">{{ $value->ground_surface }}
                                                                m<sup>2</sup></span></td>
                                                        <td>{{ $value->note }}</td>
                                                        <td>
                                                            <a href="{{ route("editLand", [$item->id, $value->id]) }}?tab=2"
                                                               class="btn btn-sm btn-info">{{ __('item.edit') }}</a>
                                                            <a onclick="return confirm('Are you sure you want to delete this item?');"
                                                               href="{{ route("deleteLandOwner", [$value->id]) }}?tab=2"
                                                               class="btn btn-sm btn-danger">{{ __('item.delete') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            @endif
                                            </tbody>
                                        </table>

                                        @if(!empty($landOwner))
                                            {!! $landOwner->links() !!}
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary d-none btn-add-block-land" data-toggle="modal" data-target="#modal-modal-department"></button>

        <div class="modal fade" id="modal-modal-department" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Block Land</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="error display_message"></div>
                        <div class="form-group">
                            <label for="customer">Description <span class="required">*</span> </label>
                            <select name="customer" class="form-control">
                                <option value="">-- Select ---</option>
                                @foreach($customer as $value)
                                    <option value="{{ $value->id }}">{{ $value->first_name.' '. $value->last_name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="block_description">Description <span class="required">*</span> </label>
                            <textarea name="block_description" class="form-control" id="block_description" required></textarea>
                            <input type="hidden" name="x" id="x"/>
                            <input type="hidden" name="y" id="y"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-save-block-land" data-url="{{ route('blockLand', $item->id) }}">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Add Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="addressContentModal" style="position: relative; margin:auto; padding:5px; width: 100%;">

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(array('url' => route('land.address.add', ['land_id' =>$item->id]), 'files' => true, 'id' => 'frmLandAddress')) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="mod_province">{{ __('item.province') }}<span class="required">*</span></label>
                                        <select name="mod_province" class="form-control width-100" id="mod_province" required>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                            @foreach($provinces as $key => $value)
                                                <option value="{{ $value->province_id }}" @if($value->province_id==$item->province) selected @endif>{{ $value->province_kh_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('mod_province'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('mod_province') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="mod_district">{{ __('item.district') }}<span class="required">*</span></label>
                                        <select name="mod_district" class="form-control width-100" id="mod_district" required  @if(!$item->district) disabled @endif>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                            @foreach($districts as $key => $value)
                                                <option value="{{ $value->dis_id }}" @if($value->dis_id==$item->district) selected @endif>{{ $value->district_namekh }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('mod_district'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('mod_district') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="mod_commune">{{ __('item.commune') }}<span class="required">*</span></label>
                                        <select name="mod_commune" class="form-control width-100" id="mod_commune" required @if(!$item->commune) disabled @endif>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                            @foreach($communes as $key => $value)
                                                <option value="{{ $value->com_id }}" @if($value->com_id==$item->commune) selected @endif>{{ $value->commune_namekh }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('mod_commune'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('mod_commune') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="mod_village">{{ __('item.village') }}<span class="required">*</span></label>
                                        <select name="mod_village" class="form-control width-100" id="mod_village"  @if(!$item->village) disabled @endif>
                                            <option value=>-- {{ __('item.select') }} --</option>
                                            @foreach($villages as $key => $value)
                                                <option value="{{ $value->vill_id }}" @if($value->vill_id==$item->village) selected @endif>{{ $value->village_namekh }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('mod_village'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('mod_village') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="addLandAddress()">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAddressModal" tabindex="-1" role="dialog" aria-labelledby="editAddressModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="editAddressContentModal" style="position: relative; margin:auto; padding:5px; width: 100%;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="editLandAddress()">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2An2Il-aqbhjc2RewhCmuY1X8h5Wc-RA&libraries=drawing"></script> -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2An2Il-aqbhjc2RewhCmuY1X8h5Wc-RA&libraries=drawing"></script>
    <script src="{{URL::asset('back-end/js/map.selector.js')}}"></script>

    <script src="{{URL::asset('back-end/js/planit.js')}}"></script>
    <script>
        $('#country ,#province, #district, #commune, #village').select2();
        $(document).ready(function(){
            var maker = [];
            @if(!is_null($blockLand))
                @foreach($blockLand as $key => $value)
                    var html_txt = "<div class='row col-md-12' style='padding-top: 20px!important;padding-bottom: 10px!important;min-width: 350px;'>";
                    html_txt += "<h5>Customer: <a href='/customer/{{ $value->customer_id }}/view'>{{ !is_null($value->customer)?($value->customer->first_name.' '. $value->customer->last_name):"N/A" }}</a></h5>";
                    html_txt +="</div><div class='row col-md-12'>";
                    html_txt +="<h6>{{ $value->description }}</h6>";
                    html_txt +="</div>"
                    html_txt +="<a onclick=\"return confirm('Are you sure you want to delete this item?');\" href='/land/delete_block_land/{{ $value->id }}' style='color:red;padding-bottom: 10px;' class='pull-right'><b>Remove</b></a>";
                    html_txt +="</div>";
                    var obj ={
                            coords: [{{$value->x}},  {{$value->y}}],
                            draggable: false,
                            infobox: {
                                html: html_txt,
                                position: 'top',
                                arrow: true
                            },
                            color: "red",
                            size: 30
                        };
                    maker.push(obj);
                    @endforeach
                @endif
            p = planit.new({
                container: 'planit',
                image: {
                    url: "{{asset($land_layout->path)}}",
                    zoom: true

                },
                markers: maker,
                markerDragEnd: function(event, marker) {
                    // console.log(marker.position());
                    // console.log(marker.coords());
                },
                markerClick: function(event, marker) {
                    console.log(marker.position());
                    // console.log(marker.position());
                    p.centerOn(marker.position());

                    setTimeout(marker.showInfobox, 250);

                    // console.log(marker.position());
                },
                canvasClick: function(event, coords) {
                     console.log(coords);
                    // console.log(marker.coords());

                    $('.btn-add-block-land').trigger('click');
                    $("#x").val(coords[0]);
                    $("#y").val(coords[1]);

                    p.zoomTo(0);
                }
            });

            $('.btn-save-block-land').on('click', function() {
                if($('textarea[name=block_description]').val() == ""||
                    $('input[name=x]').val() == ""||
                    $('input[name=y]').val() =="" ||
                    $('select[name=customer]').val() ==""
                ){

                    $(".display_message").html("Please fill all form required...");
                    return;
                }
                $.ajax({
                    url: $(this).attr('data-url'),
                    method: 'POST',
                    data: {
                        _token:$('input[name=_token]').val(),
                        block_description:$('textarea[name=block_description]').val(),
                        value_x: $('input[name=x]').val(),
                        value_y: $('input[name=y]').val(),
                        customer: $('select[name=customer]').val(),
                    },
                    success: function(response){

                        window.location.reload();
                    },
                    error: function(error){
                        alert("Server Error");
                        console.log(error);
                        return false;
                    }
                });
            });

        });

    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            $(".nav-link").click(function () {

                document.location = replaceUrlParam(document.location.href, "tab", $(this).attr("value"));
            });


            $("#land_submit").click(function (event) {
                if (!$("#data").hasClass("default-data") || $("#data").val() == "[]") {
                    $("#save_raw").trigger("click");
                }
            });

            setTimeout(function () {
                $("#restore").trigger("click");
            }, 1000);

            $("#clear_shapes").click(function () {
                $("#data").removeClass("default-data");
            });

            var isMapData = {{ ($item->map_data != "" && $item->map_data != "[]") ? 1 : 0 }};
            if (!isMapData) {
                $("#map_out, #change_map, #cancel_map").hide();
            } else {
                $("#map_in, #clear_shapes, #cancel_map").hide();
            }

            $(document).on("click", "#change_map", function () {
                $("#data").removeClass("default-data")
                $("#map_out, #change_map").hide();
                $("#map_in, #clear_shapes, #cancel_map").show();
            });

            $(document).on("click", "#cancel_map", function () {
                $("#data").addClass("default-data");
                $("#map_out, #change_map").show();
                $("#map_in, #clear_shapes, #cancel_map").hide();
            });

        });

        function replaceUrlParam(url, paramName, paramValue) {
            var pattern = new RegExp('(\\?|\\&)(' + paramName + '=).*?(&|$)')
            var newUrl = url
            if (url.search(pattern) >= 0) {
                newUrl = url.replace(pattern, '$1$2' + paramValue + '$3');
            }
            else {
                newUrl = newUrl + (newUrl.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
            }
            return newUrl
        }

        

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



        $(document).on('change', 'body #mod_province', function(){
            $('#mod_village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#mod_village').attr('disabled', 'disabled');
            $('#mod_commune').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#mod_commune').attr('disabled', 'disabled');
            var province = $('#mod_province option:selected').val();
            if(!province || province==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_districts") }}',
                type:'get',
                data:{province:province},
                success:function(data){
                    $('#mod_district').removeAttr('disabled');
                    $('#mod_district').html(data.option);
                }
            });
        });
        $(document).on('change', 'body #mod_district', function(){
            $('#mod_village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('#mod_village').attr('disabled', 'disabled');
            var district = $('#mod_district option:selected').val();
            if(!district || district==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_communes") }}',
                type:'get',
                data:{district:district},
                success:function(data){
                    $('#mod_commune').removeAttr('disabled');
                    $('#mod_commune').html(data.option);
                }
            });
        });
        $(document).on('change', 'body #mod_commune', function(){
            var commune = $('#mod_commune option:selected').val();
            if(!commune || commune==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_villages") }}',
                type:'get',
                data:{commune:commune},
                success:function(data){
                    $('#mod_village').removeAttr('disabled');
                    $('#mod_village').html(data.option);
                }
            });
        });


        function addLandAddress(){
            var form =  $('#frmLandAddress');
            var url = form.attr('action')
            $.ajax({
                type:"POST",
                url:url,
                data:form.serialize(),
                complete: function(response){
                    if(response.status==200){
                        setTimeout(function(){
                            location.reload()
                        }, 5000)
                    }
                    alert(response.responseJSON.message)
                }
            })
        }


        $(document).on('change', 'body #emod_province', function(){
            $('body #emod_village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('body #emod_village').attr('disabled', 'disabled');
            $('body #emod_commune').html("<option value>-- {{ __('item.select') }} --</option>");
            $('body #emod_commune').attr('disabled', 'disabled');
            var province = $('body #emod_province option:selected').val();
            if(!province || province==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_districts") }}',
                type:'get',
                data:{province:province},
                success:function(data){
                    $('body #emod_district').removeAttr('disabled');
                    $('body #emod_district').html(data.option);
                }
            });
        });
        $(document).on('change', 'body #emod_district', function(){
            $('body #emod_village').html("<option value>-- {{ __('item.select') }} --</option>");
            $('body #emod_village').attr('disabled', 'disabled');
            var district = $('body #emod_district option:selected').val();
            if(!district || district==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_communes") }}',
                type:'get',
                data:{district:district},
                success:function(data){
                    $('body #emod_commune').removeAttr('disabled');
                    $('body #emod_commune').html(data.option);
                }
            });
        });
        $(document).on('change', 'body #emod_commune', function(){
            var commune = $('body #emod_commune option:selected').val();
            if(!commune || commune==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_villages") }}',
                type:'get',
                data:{commune:commune},
                success:function(data){
                    $('body #emod_village').removeAttr('disabled');
                    $('body #emod_village').html(data.option);
                }
            });
        });

        function getEditLandAddress(id){
            $.ajax({
                method:"get",
                url:'{{ route("land.address.edit") }}',
                data:{id:id},
                complete: function(response){
                    console.log(response)
                    if(response.status==200){
                        $('body #editAddressContentModal').html(response.responseJSON.html_data)
                    }
                },
                error:function(errors){
                    alert(errors.responseJSON.message)
                }
            })
        }

        function editLandAddress(){
            var form =  $('body #editFrmLandAddress');
            var url = form.attr('action')
            $.ajax({
                type:"POST",
                url:url,
                data:form.serialize(),
                complete: function(response){
                    if(response.status==200){
                        setTimeout(function(){
                            location.reload()
                        }, 5000)
                    }
                    alert(response.responseJSON.message)
                }
            })
        }


    </script>
@stop