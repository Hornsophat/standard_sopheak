@extends('back-end/master')
@section('title', __('item.list_province'))
@section('content')
    <main class="app-content">
        <div class="app-title">
             @include('flash/message')
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-cog fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.address') }}</li>
                <li class="breadcrumb-item active"><a href="{{ route('setting.address.province.index') }}">{{ __('item.list_province') }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile" >
                    <div class="tile-body">
                        @include('flash/message')
                        @if (Session::has('error-message'))
                            <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                @if(Auth::user()->can('add-province') || $isAdministrator)
                                    <a class="btn btn-small btn-success" href="#">{{trans('item.add_province')}}</a>
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                <form action="{{ route('setting.address.province.index') }}" method="get">
                                	<div class="row">
                                		<div class="col-md-6">
	                                    	{{-- <div class="input-group">
		                                        <input type="number" name="year" class="form-control" value="{{ $year }}" placeholder="{{ __('item.year') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
		                                    </div> --}}
	                                    </div>
	                                    <div class="col-md-6">
	                                    	<div class="input-group">
		                                        <input type="text" name="search" class="form-control" value="{{ isset($request->search)? $request->search:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
		                                    </div>
	                                    </div>
                                	</div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-nowrap">
                                <thead>
                                <tr>
                                    <td>{{ __('item.no') }}</td>
                                    <td>{{ __('item.name_khmer') }}</td>
                                    <td>{{ __('item.name_english') }}</td>
                                    <td style="width: 140px">{{ __('item.function') }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($provinces as $key => $province)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $province->province_kh_name }}</td>
                                        <td>{{ $province->province_en_name }}</td>
                                        <td class="text-right">
                                        @if(Auth::user()->can('list-district') || $isAdministrator)
                                            <a class="btn btn-sm btn-primary" href="{{ route('setting.address.district.index', ['province_id' => $province->province_id]) }}">{{trans('item.district')}}</a>
                                        @endif
                                        @if(Auth::user()->can('edit-province') || $isAdministrator)
                                            <a class="btn btn-sm btn-info" href="#">{{trans('item.edit')}}</a>
                                        @endif

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
