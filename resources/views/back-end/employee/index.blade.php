@extends('back-end/master')
@section('title',"List Employee")
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.employee') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.list_employee') }}</a></li>
	        </ul>
      	</div>
		{{-- List Employee --}}
      	<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body">
            			<div class="row">
            				<div class="col-md-6">
	            				@if(Auth::user()->can('create-employee') || $isAdministrator)
									<a href="{{ route('addEmployee')}}" class="btn btn-success mb-4">{{ __('item.new_employee') }}</a>
								@endif
	            			</div>
							<div class="col-md-6 text-right">
								<form action="{{ route('listEmployee') }}" method="get">
									<div class="input-group">
										<div class="col-md-6"></div>
										<input type="text" name="search" class="form-control col-md-6 pull-right" value="{{ isset($_GET['search'])? $_GET['search']:"" }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()" autocomplete="off"/>&nbsp;&nbsp;
									</div>
								</form>
							</div>
            			</div>
              			<div class="table-responsive">
              				<table class="table table-hover table-bordered table-nowrap">
				                <thead>
				                  	<tr>
					                    <th>@sortablelink('id',trans('item.employee_no'))</th>
										<th>{{ __('item.thumbnail') }}</th>
										<th>@sortablelink('id_card',trans('item.id_card'))</th>
					                    <th>@sortablelink('first_name',trans('item.name'))</th>
										<th>@sortablelink('phone1',trans('item.phone'))</th>
										<th>@sortablelink('email',trans('item.email'))</th>
										<th>{{ __('item.country') }}</th>
					                    <th>{{ __('item.position') }}</th>
										<th>{{ __('item.department') }}</th>
										{{-- <th>Address</th> --}}
					                    <th>@sortablelink('salary',trans('item.salary'))</th>
					                    <th>{{ __('item.function') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
		                			@foreach ($employee as $item)
					                	<tr>
						                    <td>{{ $item->id }}</td>
											<td>
												@php
	                                                $url = asset('/images/default/no_image.png');
	                                                if($item->profile != null && file_exists(public_path($item->profile)))
	                                                    $url = asset('public'.$item->profile);
	                                            @endphp
												<img src="{{ $url }}" alt="Missing Image" width="50px"/>

											</td>
											<td>{{ $item->id_card }}</td>
						                    <td>{{ $item->last_name." ".$item->first_name  }}</td>
											<td>{{ $item->phone1 }}</td>
											<td>{{ $item->email }}</td>
						                    <td>{{ !is_null($item->countries)?$item->countries->name:"" }}</td>
						                    <td>{{ !is_null($item->position)? $item->position->title:"" }}</td>
						                    <td>{{ !is_null($item->department)? $item->department->title:"" }}</td>
						                    {{-- <td>{{ !is_null($item->addr)?$item->addr:'' }}</td> --}}
						                    <td>{{ "$ ".$item->salary }}</td>
											<td>
											@if(Auth::user()->can('view-employee') || $isAdministrator)
												<a class="btn btn-sm btn-primary" href="{{ URL::to('employee/' . $item->id . '/view') }}">{{ __('item.view') }}</a>
											@endif
											@if(Auth::user()->can('edit-employee') || $isAdministrator)
												<a class="btn btn-sm btn-info" title="Edit" href="{{ URL::to('employee/' . $item->id . '/edit') }}">{{ __('item.edit') }}</a>
											@endif
											@if(Auth::user()->can('delete-employee') || $isAdministrator)
												<a class="btn btn-sm btn-warning" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"
												   href="{{ URL::to('employee/'.$item->id.'/delete' ) }}">{{ __('item.delete') }}</a>
											@endif
											</td>
						                </tr>
					                @endforeach
				                </tbody>
		              		</table>
		              		<div class="pull-right">
								{!! $employee->appends(\Request::except('page'))->render() !!}
							</div>
              			</div>
            		</div>
          		</div>
        	</div>
      	</div>
      	{{-- End List Employee --}}
	</main>
@stop
@section('script')

@stop