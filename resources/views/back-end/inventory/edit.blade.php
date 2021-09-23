@extends('back-end/master')

@section('content')
<main class="app-content">
	<div class="app-title">
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item">{{ __('item.product') }}</li>
			<li class="breadcrumb-item active"><a href="#">{{ __('item.inventory') }}</a></li>
		</ul>
	</div>

	<div class="tile">
		<div class="tile-body">

			<div class="row">
				<div class="col-md-12">
					<h3>{{trans('item.inventory_data_tracking')}}</h3>
					<div class="panel panel-default">

						<div class="panel-body">
							@if (Session::has('message'))
								<div class="alert alert-info">{{ Session::get('message') }}</div>
							@endif

							{!! Html::ul($errors->all()) !!}

							<table class="table table-bordered">
							<tr><td>{{trans('item.item_name')}}</td><td>{{ $item->name }}</td></tr>
							<tr><td>{{trans('item.current_quantity')}}</td><td>{{ $item->qty}}</td></tr>

							{!! Form::model($item->inventory, array('route' => array('inventory.update', $item->id), 'method' => 'PUT')) !!}
							<tr><td>{{trans('item.inventory_to_add_subtract')}} *</td><td>{!! Form::text('in_out_qty', Input::old('in_out_qty'), array('class' => 'form-control')) !!}</td></tr>
							<tr><td>Unit Cost *</td><td>{!! Form::text('cost', Input::old('cost'), array('class' => 'form-control')) !!}</td></tr>
							<tr><td>{{trans('item.comments')}}</td><td>{!! Form::textarea('remarks', Input::old('remarks'), array('class' => 'form-control', 'rows' => 4)) !!}</td></tr>
							<tr><td>&nbsp;</td><td>{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary')) !!}</td></tr>
							{!! Form::close() !!}
							</table>

							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<td>@sortablelink('created_at', trans('item.inventory_data_tracking'))</td>
										<td>@sortablelink('user_id',trans('item.employee'))</td>
										<td>@sortablelink('in_out_qty', trans('item.in_out_qty'))</td>
										<td>@sortablelink('remarks', trans('item.remarks'))</td>
									</tr>
								</thead>
								<tbody>
								@foreach($inventory as $value)
									<tr>
										<td>{{ $value->created_at }}</td>
										<td>{{ $value->user->name }}</td>
										<td>{!! $value->in_out_qty<0?"<span class='badge badge-danger'>".$value->in_out_qty."</span>":"<span class='badge badge-info'>".$value->in_out_qty."</span>" !!}</td>
										<td>{{ $value->remarks }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>

							<div class="pull-right">
								{!! $inventory->appends(\Request::except('page'))->render() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection