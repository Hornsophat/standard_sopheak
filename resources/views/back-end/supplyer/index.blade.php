@extends('back-end/master')
@section('title',"List Supplyer")
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.supplier') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.list_supplier') }}</a></li>
	        </ul>
      	</div>

		{{-- List Customer --}}
      	<div class="row">
        	<div class="col-md-12">
				@include('flash/message')

          		<div class="tile">
            		<div class="tile-body">
						<div class="row">
							<div class="col-md-6">
								@if(Auth::user()->can('create-supplyer') || $isAdministrator)
									<a href="{{ route('supplyer.create')}}" class="btn btn-small btn-success">{{ __('item.new_supplier') }}</a>
								@endif
							</div>
							<div class="col-md-6 text-right">
								<form action="{{ route('supplyers') }}" method="get">
									<div class="input-group">
										<div class="col-md-6"></div>
										<input type="text" name="search" class="form-control col-md-6 pull-right" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
									</div>
								</form>
							</div>
						</div>
						<hr/>
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-nowrap">
				                <thead>
				                  	<tr>
					                    <th>@sortablelink('id',trans('item.no'))</th>
					                    <th>{{ __('item.thumbnail') }}</th>
					                    <th>@sortablelink('firstname',trans('item.name'))</th>
					                    <th>@sortablelink('phone1',trans('item.phone'))</th>
					                    <th>@sortablelink('email',trans('item.email'))</th>
					                    <th>@sortablelink('sex',trans('item.gender'))</th>
					                    <th>@sortablelink('address',trans('item.address'))</th>
					                    <th>{{ __('item.function') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
									@if($supplyers)
										@foreach ($supplyers as $key=>$value)
											<tr>
												<td>{{ $value->id }}</td>
												<td>
													@php
		                                                $url = asset('/images/default/no_image.png');
		                                                if($value->profile_pic != null && file_exists(public_path($value->profile_pic)))
		                                                    $url = asset('public'.$value->profile_pic);
		                                            @endphp
													<img src="{{ $url }}"  style="width: 50px; height: 50px; object-fit: cover;" />

												</td>
												<td>{{ $value->lastname." ".$value->firstname }}</td>
												<td>{{ $value->phone1 }}</td>
												<td>{{ $value->email }}</td>
												<td>{{ $value->sex }}</td>
												<td>{{ $value->address }}</td>
												<td>
												@if(Auth::user()->can('view-supplyer') || $isAdministrator)
													<a class="btn btn-sm btn-primary" href="{{ route('supplyer.view', ['id'=>$value->id]) }}">{{ __('item.view') }}</a>
												@endif
												@if(Auth::user()->can('edit-supplyer') || $isAdministrator)
													<a class="btn btn-sm btn-info" href="{{ route('supplyer.edit', ['id'=>$value->id]) }}">{{trans('item.edit')}}</a>
												@endif
												@if(Auth::user()->can('delete-supplyer') || $isAdministrator)
													<a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
													   href="{{ route('supplyer.destroy', ['id'=>$value->id]) }}">{{ trans('item.delete')}}</a>
												@endif

												</td>

											</tr>
										@endforeach
										@else
										<tr>
											<td colspan="7">No Found!</td>
										</tr>
										@endif
				                </tbody>
		              		</table>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
									{!! $supplyers->links() !!}
								</div>
							</div>
						</div>
            		</div>
          		</div>
        	</div>
      	</div>
      	{{-- End List Customer --}}
	</main>
@stop
@section('script')

@stop