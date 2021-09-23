<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{ __('item.name') }}:</strong>
            <input type="text" name="name" placeholder="{{ __('item.name') }}" class="form-control" value="{{old("name")?"name":(isset($role)?$role->name:'')}}" />
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{ __('item.description') }}:</strong>
            <textarea name="description" placeholder="{{ __('item.description') }}" class="form-control" style="height:100px">{{strip_tags(old("description")? old("description"): (isset($role)?$role->description:"")) }}</textarea>
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <select id="source_3" data-text="Permission" autocomplete="true">
            @foreach($permission as $value)
                @if(isset($permission_role))
                    @if(!in_array($value->id, $permission_role))
                        <option value="{{$value->id}}">{{ $value->display_name }}</option>
                        @endif
                    @else
                    <option value="{{$value->id}}">{{ $value->display_name }}</option>
                @endif
            @endforeach
        </select>
        <select id="destination_3" data-text="Permission selected">
            @foreach($permission as $value)
                @if(isset($permission_role) && in_array($value->id, $permission_role))
                    <option value="{{$value->id}}" >{{ $value->display_name }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div id="storeCheckbox" style="display: none!important;">
        @if(!empty($permission_role))
            @foreach ($permission_role as $key=>$value)
                <input type="checkbox" name="permission[]" value="{{ $value }}" checked class="permission-{{$value}}"/>
                @endforeach
            @endif
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 pull-right">
        <button type="submit" class="btn btn-primary pull-right">{{ __('item.submit') }}</button>
    </div>
</div>
