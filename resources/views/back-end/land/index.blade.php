@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.land') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_land') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            @include('flash/message')

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if(Auth::user()->can('list-land') || $isAdministrator)
                                                <a class="btn btn-small btn-success" href="{{ URL::to('land/create') }}">{{trans('item.new_land')}}</a>
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <form action="{{ route('land') }}" method="get">
                                                <div class="input-group">
                                                    <div class="col-md-6"></div>
                                                    <input type="text" name="search" class="form-control col-md-6 pull-right" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <td>@sortablelink('id',__("item.land_no"))</td>
                                                <td>@sortablelink('property_name',__('item.land_name'))</td>
                                                <td>{{ __('item.address') }}</td>
                                                <td>@sortablelink('address_street',__('item.address_street'))</td>
                                                <td>@sortablelink('address_number',__('item.address_number'))</td>
                                                <td>@sortablelink('',__('item.ground_surface'))</td>
                                                <td>@sortablelink('', __("item.total_price"))</td>
                                                <td>@sortablelink('', __("item.owner"))</td>
                                                <td>{{ __('item.function') }}</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($item as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration  }}</td>
                                                    <td>{{ $value->property_name }}</td>
                                                    <td>
                                                        {{ isset($value->eProvince->province_kh_name)?$value->eProvince->province_kh_name:'' }},
                                                        {{ isset($value->eDistrict->district_namekh)?$value->eDistrict->district_namekh:'' }},
                                                        {{ isset($value->eCommune->commune_namekh)?$value->eCommune->commune_namekh:'' }},
                                                        {{ isset($value->eVillage->village_namekh)?$value->eVillage->village_namekh:'' }}
                                                    </td>
                                                    <td>{{ $value->address_street }}</td>
                                                    <td>{{ $value->address_number }}</td>
                                                    <td><span class="badge badge-warning">{{ $value->landOwner->sum("ground_surface") }} m<sup>2</sup></span></td>
                                                    <td><span class="badge badge-primary">{{ "$ ".$value->landOwner->sum("price") }}</span> </td>
                                                    <td><a href="{{ route("editLand",$value->id )."?tab=2" }}"><span class="badge badge-info">{{ $value->landOwner()->count() }}</span></a></td>
                                                    <td>
                                                    @if(Auth::user()->can('edit-land') || $isAdministrator)
                                                        <a class="btn btn-sm btn-info" href="{{ URL::to('land/' . $value->id . '/edit') }}">{{trans('item.edit')}}</a>
                                                    @endif
                                                    {{-- @if(Auth::user()->can('delete-land') || $isAdministrator)
                                                        <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                                           href="{{ URL::to('land/delete/' . $value->id ) }}">{{ trans('item.delete')}}</a>
                                                    @endif --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                {!! $item->appends(\Request::except('page'))->render() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </main>
@endsection
