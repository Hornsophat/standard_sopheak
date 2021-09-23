@extends('back-end/master')
@section('title',"List Expense Groups")
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.expense_type') }}</li>
	          	{{-- <li class="breadcrumb-item active"><a href="#">{{ __('item.list_employee') }}</a></li> --}}
	          	<li class="breadcrumb-item active"><a href="@if(Auth::user()->can('list-exspense-group') || $isAdministrator) {{ route('expense_groups') }} @else # @endif">{{ __('item.list_expense_type') }}</a></li>
	        </ul>
      	</div>
		{{-- List Employee --}}
      	<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body">
            			@if(Auth::user()->can('add-exspense-group') || $isAdministrator)
							{{-- <a href="{{ route('addEmployee')}}" class="btn btn-success mb-4">{{ __('item.new_employee') }}</a> --}}
							<a href="{{ route('expense_group.create')}}" class="btn btn-success mb-4">{{ __('item.new_expense_type') }}</a>
						@endif
              			<div class="table-responsive">
              				<table class="table table-hover table-bordered table-nowrap">
				                <thead>
				                  	<tr>
					                    <th>@sortablelink('id',__('item.expense_type_no'))</th>
										<th>@sortablelink('name',__('item.name'))</th>
					                    <th>@sortablelink('description',__('item.description'))</th>
					                    <th>{{ __('item.function') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
		                			@foreach ($expense_groups as $key => $item)
					                	<tr>
						                    <td>{{ ++$key }}</td>
						                    <td>{{ $item->name  }}</td>
											<td>{{ $item->description }}</td>
											<td>
											@if(Auth::user()->can('edit-exspense-group') || $isAdministrator)
												<a class="btn btn-sm btn-info" title="Edit" href="{{ route('expense_group.edit',['id' => $item->id]) }}">{{ __('item.edit') }}</a>
											@endif
											@if(Auth::user()->can('delete-exspense-group') || $isAdministrator)
												<a class="btn btn-sm btn-warning" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"
												   href="{{ route('expense_group.destroy', ['id' => $item->id]) }}">{{ __('item.delete') }}</a>
											@endif
											</td>
						                </tr>
					                @endforeach
				                </tbody>
		              		</table>
		              		<div class="pull-right">
								{!! $expense_groups->links() !!}
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