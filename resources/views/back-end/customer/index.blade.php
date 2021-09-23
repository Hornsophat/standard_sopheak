@extends('back-end/master')
@section('title',"List Customer")
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.customer') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.list_customer') }}</a></li>
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
								@if(Auth::user()->can('create-customer') || $isAdministrator)
									<a href="{{ route('addCustomer')}}" class="btn btn-small btn-success">{{ __('item.new_customer') }}</a>
								@endif
							</div>
							<div class="col-md-6 text-right">
								<form action="{{ route('listCustomer') }}" method="get">
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
					                    <th>{{ __('item.id') }}</th>
					                    <th>@sortablelink('first_name',trans('item.name')) (Kh)</th>
					                    <th>@sortablelink('first_name_en',trans('item.name')) (En)</th>
					                    <th>@sortablelink('phone1',trans('item.phone'))</th>
					                    <th>@sortablelink('email',trans('item.email'))</th>
					                    <th>@sortablelink('sex',trans('item.gender'))</th>
					                    {{-- <th>@sortablelink('address',trans('item.address'))</th> --}}
					                    <th>{{ __('item.function') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
									@if($customers)
										@foreach ($customers as $key=>$value)
											<tr>
												<td>{{ $value->id }}</td>
												<td>
													@php
		                                                $url = asset('/images/default/no_image.png');
		                                                if($value->profile != null && file_exists(public_path($value->profile)))
		                                                    $url = asset('public'.$value->profile);
		                                            @endphp
													<img src="{{ $url }}" onerror="this.src='/images/default/no_image.png';" alt="Missing Image" width="50px"/>

												</td>
												<td>{{ $value->customer_no }}</td>
												<td>{{ $value->last_name." ".$value->first_name  }}</td>
												<td>{{ $value->last_name_en." ".$value->first_name_en  }}</td>
												<td>{{ $value->phone1 }}</td>
												<td>{{ $value->email }}</td>
												<td>{{ gender($value->sex) }}</td>
												{{-- <td>{{ !is_null($value->addr)?$value->addr:'' }}</td> --}}
												<td>
												@if(Auth::user()->can('view-customer') || $isAdministrator)
													<a class="btn btn-sm btn-primary" href="{{ URL::to('customer/' . $value->id . '/view') }}">{{ __('item.view') }}</a>
												@endif
												@if(Auth::user()->can('visit-customer') || $isAdministrator)
													<a class="btn btn-sm btn-success" href="{{ URL::to('customer/' . $value->id . '/visit') }}">{{ __('item.visit') }}&nbsp;&nbsp;<span class="badge badge-light">{{ !is_null($value->customer_visit)?($value->customer_visit->count()):0 }}</span></a>
												@endif
												@if(Auth::user()->can('edit-customer') || $isAdministrator)
													<a class="btn btn-sm btn-info" href="{{ URL::to('customer/' . $value->id . '/edit') }}">{{trans('item.edit')}}</a>
												@endif
												@if(Auth::user()->can('delete-customer') || $isAdministrator)
													<a class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to delete this item?');"
													   href="{{ URL::to('customer/'.$value->id.'/delete' ) }}">{{ trans('item.delete')}}</a>
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
									{!! $customers->appends(\Request::except('page'))->render() !!}
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