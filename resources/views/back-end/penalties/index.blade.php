@extends('back-end/master')
@section('title', __('item.penalties'))
@section('content')
    <main class="app-content">
        <div class="app-title">
             @include('flash/message')
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.penalty') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.list_penalty') }}</a></li>
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
                                    <a class="btn btn-small btn-success" href="{{ Route('penalty.create') }}">{{trans('item.add_penalty')}}</a>
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                <form action="{{ route('penalties') }}" method="get">
                                	<div class="row">
	                                    <div class="col-md-12">
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
                                    <td>{{ __('item.title') }}</td>
                                    <td>{{ __('item.description') }}</td>
                                    <td>{{ __('item.function') }}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                        @if(Auth::user()->can('edit-penalty') || $isAdministrator)
                                            <a class="btn btn-sm btn-info" href="{{ route('penalty.edit', ['penalty' => $item->id]) }}">{{trans('item.edit')}}</a>
                                        @endif
                                        @if(Auth::user()->can('list-penalty') || $isAdministrator)
                                            <a class="btn btn-sm btn-primary" href="{{ route('penalty.show', ['penalty' => $item->id]) }}">{{trans('item.detail')}}</a>
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
