@extends('back-end/master')
@section('title', __('item.public_holiday'))
@section('content')
    <main class="app-content">
        <div class="app-title">
             @include('flash/message')
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-cog fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.public_holiday') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_public_holiday') }}</a></li>
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
                                @if(Auth::user()->can('add-public-holiday') || $isAdministrator)
                                    <a class="btn btn-small btn-success" href="{{ Route('public_holiday.create') }}">{{trans('item.add_public_holiday')}}</a>
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                <form action="{{ route('public_holidays') }}" method="get">
                                	<div class="row">
                                		<div class="col-md-6">
	                                    	<div class="input-group">
		                                        <input type="number" name="year" class="form-control" value="{{ $year }}" placeholder="{{ __('item.year') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
		                                    </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                    	<div class="input-group">
		                                        <input type="text" name="search" class="form-control" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
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
                                    <td>{{ __('item.date') }}</td>
                                    <td>{{ __('item.title') }}</td>
                                    <td>{{ __('item.description') }}</td>
                                    <td>{{ __('item.function') }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                        @if(Auth::user()->can('edit-public-holiday') || $isAdministrator)
                                            <a class="btn btn-sm btn-info" href="{{ route('public_holiday.edit', ['public_holiday' => $item->id]) }}">{{trans('item.edit')}}</a>
                                        @endif
                                        @if(Auth::user()->can('delete-public-holiday') || $isAdministrator)
                                            <a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
                                               href="{{ route('public_holiday.destroy', ['public_holiday'=>$item->id]) }}">{{ trans('item.delete')}}</a>
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
