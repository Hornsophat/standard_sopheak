@extends('back-end/master')
@section('title',"List Expenses")
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.expense') }}</li>
	          	{{-- <li class="breadcrumb-item active"><a href="#">{{ __('item.list_employee') }}</a></li> --}}
	          	<li class="breadcrumb-item active"><a href="@if(Auth::user()->can('list-general-expense') || $isAdministrator) {{ route('general_expenses') }} @else # @endif">{{ __('item.list_expense') }}</a></li>
	        </ul>
      	</div>
		{{-- List Employee --}}
      	<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body">
            			<div class="row">
            				<div class="col-md-3">
            					@if(Auth::user()->can('add-exspense-group') || $isAdministrator)
									<a href="{{ route('general_expense.create')}}" class="btn btn-success mb-4">{{ __('item.new_expense') }}</a>
								@endif
            				</div>
            				<div class="col-md-9">
        					<form action="{{ route('general_expenses') }}" method="GET">
    							<div class="row">
    								<div class="col-md-4">
	    								<div class="form-group">
		    								<label>{{ __('item.expense_type') }}</label>
		    								<select name="group" id="group" class="form-control" onchange="this.form.submit()">
		                                        <option value>-- {{__('item.select')}} {{__('item.type')}} --</option>
		                                        @foreach($expense_groups as $group)
		                                            <option value="{{ $group->id }}"
		                                                @if ($request->group == $group->id)
		                                                selected="selected"
		                                                @endif
		                                            >{{ $group->name }}</option>
		                                        @endforeach
		                                    </select>
		    							</div>
	    							</div>
	    							<div class="col-md-4">
	    								<div class="form-group">
											<label>{{ __('item.project') }}</label>
											<select name="project" id="project" class="form-control" onchange="this.form.submit()">
		                                        <option value>-- {{__('item.select')}} {{__('item.project')}} --</option>
		                                        @foreach($projects as $project)
		                                            <option value="{{ $project->id }}"
		                                                @if ($request->project == $project->id)
		                                                selected="selected"
		                                                @endif
		                                            >{{ $project->property_name }}</option>
		                                        @endforeach
		                                    </select>
										</div>
	    							</div>
	    							<div class="col-md-4">
	    								<div class="form-group">
											<label>{{ __('item.employee') }}</label>
											<select name="employee" id="employee" class="form-control" onchange="this.form.submit()">
		                                        <option value>-- {{__('item.select')}} {{__('item.employee')}} --</option>
		                                        @foreach($employees as $employee)
		                                            <option value="{{ $employee->id }}"
		                                                @if ($request->employee == $employee->id)
		                                                selected="selected"
		                                                @endif
		                                            >{{ $employee->first_name.' '.$employee->last_name }}</option>
		                                        @endforeach
		                                    </select>
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
					                    <th>@sortablelink('id',__('item.expense_no'))</th>
					                    <th>@sortablelink('date', __('item.date'))</th>
										<th>@sortablelink('title',__('item.title'))</th>
										<th>@sortablelink('group_id',__('item.type'))</th>
										<th>{{ __('item.project') }}</th>
										<th>{{ __('item.employee') }}</th>
										<th>@sortablelink('amount', __('item.expense_amount'))</th>
										<th>@sortablelink('created_by', __('item.created_by'))</th>
					                    <th>@sortablelink('description',__('item.description'))</th>
					                    <th>{{ __('item.function') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
		                			@php
		                				$total_amount =0;
		                			@endphp
		                			@foreach ($general_expenses as $key => $item)
		                			@php
		                				$total_amount += $item->amount;
		                			@endphp
					                	<tr>
						                    <td>{{ ++$key }}</td>
						                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
						                    <td>{{ $item->title  }}</td>
						                    <td>{{ isset($item->expenseGroup->name)?$item->expenseGroup->name:'N\A' }}</td>
						                    <td>
						                    	{{ isset($item->project->property_name)?$item->project->property_name:'' }}
						                    </td>
						                    <td>
						                    	{{ isset($item->employee->first_name)?$item->employee->first_name:'' }}{{ isset($item->employee->last_name)?$item->employee->last_name:'' }}
						                    </td>
						                    <td class="text-right text-danger">$ {{ $item->amount }}</td>
						                    <td>{{ ucfirst(isset($item->createdBy->name)?$item->createdBy->name:'N\A') }}</td>
											<td>{{ $item->description }}</td>
											<td>
											@if(Auth::user()->can('edit-general-expense') || $isAdministrator)
												@if(Auth::id() != $item->created_by)
													<a class="btn btn-sm btn-info" style="opacity: 0.8; cursor: not-allowed;" title="Edit" href="#">{{ __('item.edit') }}</a>
												@else
													<a class="btn btn-sm btn-info" title="Edit" href="{{ route('general_expense.edit',['id' => $item->id]) }}">{{ __('item.edit') }}</a>
												@endif
											@endif
											@if(Auth::user()->can('delete-general-expense') || $isAdministrator)
												<a class="btn btn-sm btn-warning" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"
												   href="{{ route('general_expense.destroy', ['id' => $item->id]) }}">{{ __('item.delete') }}</a>
											@endif
											</td>
						                </tr>
					                @endforeach
				                </tbody>
				                <tfoot>
				                	<tr>
				                		<th colspan="6" class="text-right">{{ __('item.total') }} : </th>
				                		<th class="text-right">$ {{ $total_amount }}</th>
				                		<th colspan="3"></th>
				                	</tr>
				                </tfoot>
		              		</table>
              			</div>
              			<div class="row">
              				<div class="col-md-12">
              					<div class="pull-right">
									{!! $general_expenses->render() !!}
								</div>
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
<script type="text/javascript">
	$('#project, #group, #employee').select2();
</script>
@stop