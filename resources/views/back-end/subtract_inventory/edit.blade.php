@extends('back-end/master')
@section('title', 'Edit Subtract Inventory')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
<main class="app-content">
	<div class="app-title">
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="{{ route('subtract_inventories') }}">{{ __('item.list_subtract_inventory') }}</a></li>
			<li class="breadcrumb-item active"><a href="#">{{ __('item.edit_subtract_inventory') }}</a></li>
		</ul>
	</div>

	<div class="tile">
		<div class="tile-body">

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<h3>{{ __('item.add_subtract_inventory') }}</h3><hr/>
						<div class="panel-body">
							@if (Session::has('message'))
							<div class="alert alert-info">{{ Session::get('message') }}</div>
							@endif

							{!! Form::model(array(route('subtract_inventory.edit',['id' => $subtract_inventory->id]), 'files' => true, 'method'=>'POST')) !!}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('product', trans('item.product'))."<span class='star'> *</span>" !!}
									{!! Form::select('product',$products , Input::old('product'), array('class' => 'form-control select2-option-picker cal-total-cost', 'id' => 'numproduct')) !!}
										@if ($errors->has('product'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('product') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('qty', trans('item.quantity'))."<span class='star'> *</span>" !!}
									{!! Form::number('qty', Input::old('qty'), array('class' => 'form-control', 'id' => 'numQty', 'min'=>'0')) !!}
										@if ($errors->has('qty'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('qty') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<input type="button" class="btn btn-success pull-right mb-2" id="addItem" value="{{ __('item.add') }}"></input>
								</div>
								@if($errors->any())
								<div class="col-md-12 mb-1">
									<h6 class="text-danger" style="text-decoration: underline;">Product Validation Require</h6>
									<ul>
										@foreach($errors->all() as $error)
											<span class="help-block text-danger">
												<li><strong>{{ $error }}</strong></li>
											</span>
										@endforeach
									</ul>
								</div>
								@endif
								@if (Session::has('error_validations'))
								<div class="col-md-12 mb-1">
									<h6 class="text-danger" style="text-decoration: underline;">Product Validation Require</h6>
										<span class="help-block text-danger">
											<strong>{{ Session::get('error_validations') }}</strong>
										</span>
								</div>
								@endif
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-nowrap table-hover table-bordered">
											<thead>
												<tr>
													<th class="text-center">{{ __('item.no') }}</th>
													<th class="text-center">{{ __('item.product_name') }}</th>
													<th class="text-center">{{ __('item.quantity') }}</th>
													<th class="text-center">{{ __('item.function') }}</th>
												</tr>
											</thead>
											<tbody id="bodyItem">
											</tbody>
											<tfoot>
												<tr>
													<th colspan="2" class="text-right">{{ __('item.total') }}</th>
													<th class="text-right" id="subTotal"></th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('status', trans('item.status'))."<span class='star'> *</span>" !!}
									{!! Form::select('status',$statuses , $subtract_inventory->status, array('class' => 'form-control cal-total-cost', 'id' => 'status')) !!}
										@if ($errors->has('status'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('status') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										{!! Form::label('remarks', trans('item.comment')) !!}
										{!! Form::textarea('remarks', Input::old('remarks'), array('class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right')) !!}
							<input type="button" class="btn btn-danger pull-right mb-2 mr-4" id="cancelItem" value="{{ __('item.cancel') }}"></input>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editItemModalTitle">Edit Item (<span></span>)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="pro_noModal">
    	<div class="form-group">
    		<label class="label-control">Quantity</label>
    		<input type="number" class="form-control modal-cal-total" min="0" id="qtyModal">
    	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnEditItem">Submit</button>
      </div>
    </div>
  </div>
</div>
</main>


@endsection

@section('script')
	<script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
	<script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
	<script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script src="{{ asset('back-end/asset/js/subtract_inventory.js') }}"></script>
    <script type="text/javascript">
        if("{{ Session::get('remove_spitem') }}"){
            if(localStorage.getItem('spItem')){
                localStorage.removeItem('spItem');
            }
            @php(Session::forget('remove_spitem'))
        }
        $(document).on('change', '#numQty',function(){
        	var url= '{{ route("subtract_inventory.get_product") }}';
        	check_product_quantity(url);
        });
        $(document).ready(function(){
        	localStorage.setItem('spItem', JSON.stringify(@json($rows)));
            loadItem();
        });
        $(document).on('change', '#qtyModal', function(){
        	var url= '{{ route("subtract_inventory.get_product") }}';
        	check_product_quantity_edit(url);
        })
    </script>
@stop