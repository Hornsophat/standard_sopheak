<div class="row">
    <div class="col-md-12">
        {!! Form::open(array('url' => route('land.address.update', ['id' => $item->id]), 'files' => true, 'id' => 'editFrmLandAddress')) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="emod_province">{{ __('item.province') }}<span class="required">*</span></label>
                        <select name="emod_province" class="form-control width-100" id="emod_province" required>
                            <option value=>-- {{ __('item.select') }} --</option>
                            @foreach($provinces as $key => $value)
                                <option value="{{ $value->province_id }}" @if($value->province_id==$item->province) selected @endif>{{ $value->province_kh_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('emod_province'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('emod_province') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="emod_district">{{ __('item.district') }}<span class="required">*</span></label>
                        <select name="emod_district" class="form-control width-100" id="emod_district" required  @if(!$item->district) disabled @endif>
                            <option value=>-- {{ __('item.select') }} --</option>
                            @foreach($districts as $key => $value)
                                <option value="{{ $value->dis_id }}" @if($value->dis_id==$item->district) selected @endif>{{ $value->district_namekh }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('emod_district'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('emod_district') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="emod_commune">{{ __('item.commune') }}<span class="required">*</span></label>
                        <select name="emod_commune" class="form-control width-100" id="emod_commune" required @if(!$item->commune) disabled @endif>
                            <option value=>-- {{ __('item.select') }} --</option>
                            @foreach($communes as $key => $value)
                                <option value="{{ $value->com_id }}" @if($value->com_id==$item->commune) selected @endif>{{ $value->commune_namekh }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('emod_commune'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('emod_commune') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="emod_village">{{ __('item.village') }}<span class="required">*</span></label>
                        <select name="emod_village" class="form-control width-100" id="emod_village"  @if(!$item->village) disabled @endif>
                            <option value=>-- {{ __('item.select') }} --</option>
                            @foreach($villages as $key => $value)
                                <option value="{{ $value->vill_id }}" @if($value->vill_id==$item->village) selected @endif>{{ $value->village_namekh }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('emod_village'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('emod_village') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>