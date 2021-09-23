@extends('back-end/master')
@section('title', 'Edit Purchase')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
<main class="app-content">
	<div class="app-title">
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="{{ route('purchases') }}">{{ __('item.list_purchase') }}</a></li>
			<li class="breadcrumb-item active"><a href="#">{{ __('item.edit_purchase') }}</a></li>
		</ul>
	</div>

	<div class="tile">
		<div class="tile-body">

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<h3>{{ __('item.edit_purchase') }}</h3><hr/>
						<div class="panel-body">
							@if (Session::has('message'))
							<div class="alert alert-info">{{ Session::get('message') }}</div>
							@endif

							{!! Form::model($purchase, array("route"=>array('purchase.edit', $purchase->id),'method' => 'POST', 'files' => true)) !!}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('project', trans('item.project'))."<span class='star'> *</span>" !!}
									{!! Form::select('project',$projects , $purchase->project_id, array('class' => 'form-control select2-option-picker cal-total-cost', 'id' => 'numproject')) !!}
										@if ($errors->has('project'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('project') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('reference', __('item.reference')) !!}
									{!! Form::text('reference', Input::old('reference'), array('class' => 'form-control', 'id' => 'reference')) !!}
										@if ($errors->has('reference'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('reference') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('supplyer', trans('item.supplier'))."<span class='star'> *</span>" !!}
									{!! Form::select('supplyer',$supplyers , $purchase->supplyer_id, array('class' => 'form-control select2-option-picker cal-total-cost', 'id' => 'numsupplyer')) !!}
										@if ($errors->has('supplyer'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('supplyer') }}</strong>
											</span>
										@endif
									</div>
								</div>
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
									{!! Form::number('qty', Input::old('qty'), array('class' => 'form-control cal-total-cost', 'id' => 'numQty', 'min'=>'0')) !!}
										@if ($errors->has('qty'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('qty') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('unit_cost', trans('item.unit_cost'))."<span class='star'> *</span>" !!}
									{!! Form::number('unit_cost', Input::old('unit_cost'), array('class' => 'form-control cal-total-cost', 'id' => 'unitCost', 'min'=>'0')) !!}
										@if ($errors->has('unit_cost'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('unit_cost') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('total_cost', trans('item.total_cost'))."<span class='star'> *</span>" !!}
									{!! Form::text('total_cost', Input::old('total_cost'), array('class' => 'form-control', 'id' => 'totalCost', 'readonly' => 'true')) !!}
										@if ($errors->has('total_cost'))
											<span class="help-block text-danger">
												<strong>{{ $errors->first('total_cost') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<input type="button" class="btn btn-success pull-right mb-2" id="addItem" value="{{ __('item.add') }}"></input>
								</div>
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-nowrap table-hover table-bordered">
											<thead>
												<tr>
													<th class="text-center">{{ __('item.no') }}</th>
													<th class="text-center">{{ __('item.product_name') }}</th>
													<th class="text-center">{{ __('item.quantity') }}</th>
													<th class="text-center">{{ __('item.cost') }}</th>
													<th class="text-center">{{ __('item.total') }}</th>
													<th class="text-center">{{ __('item.function') }}</th>
												</tr>
											</thead>
											<tbody id="bodyItem">
											</tbody>
											<tfoot>
												<tr>
													<th colspan="4" class="text-right">{{ __('item.sub_total') }}</th>
													<th class="text-right" id="subTotal"></th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								@if(!empty($purchase->discount_percent) && $purchase->discount_percent>0)
								<div class="col-md-6 mb-3"> 
                                   <div class="input-group">
                                        {!! Form::label('discount', trans('item.discount'), array('style'=>'width:100%;')) !!}
                                        {!! Form::text('discount', $purchase->discount_percent*1, array('style' => 'width:70%;','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text" >{{ __('item.is') }}</span>
                                        </div>
                                        {!! Form::select('discount_type', $discount_types,'discount_percent', array('style' => 'width:20%;padding:8px 5px;', 'id' => 'discount_type')) !!}
                                        @if ($errors->has('discount'))
                                            <span class="help-block text-danger" style="width: 100%;">
                                                <strong>{{ $errors->first('discount') }}</strong>
                                            </span> 
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        
                                    </div>
                               	</div>
								@else
								<div class="col-md-6 mb-3"> 
                                   <div class="input-group">
                                        {!! Form::label('discount', trans('item.discount'), array('style'=>'width:100%;')) !!}
                                        {!! Form::text('discount', $purchase->discount_amount*1, array('style' => 'width:70%;','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text" >{{ __('item.is') }}</span>
                                        </div>
                                        {!! Form::select('discount_type', $discount_types,'discount_amount', array('style' => 'width:20%;padding:8px 5px;', 'id' => 'discount_type')) !!}
                                        @if ($errors->has('discount'))
                                            <span class="help-block text-danger" style="width: 100%;">
                                                <strong>{{ $errors->first('discount') }}</strong>
                                            </span> 
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        
                                    </div>
                               	</div>
								@endif
                               	<div class="col-md-6"> 
                                   <div class="input-group">
                                        {!! Form::label('grand_total', trans('item.grand_total'), array('style'=>'width:100%;')) !!}
                                        {!! Form::text('grand_total', null, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');", 'readonly', 'grand_total')) !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text" >$</span>
                                        </div>
                                        @if ($errors->has('grand_total'))
                                            <span class="help-block text-danger" style="width: 100%;">
                                                <strong>{{ $errors->first('grand_total') }}</strong>
                                            </span> 
                                        @endif
                                    </div>
                               	</div>
								<div class="col-md-6">
									<div class="form-group">
									{!! Form::label('status', trans('item.status'))."<span class='star'> *</span>" !!}
									{!! Form::select('status',$statuses , $purchase->status, array('class' => 'form-control cal-total-cost', 'id' => 'status')) !!}
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
    	<div class="form-group">
    		<label class="label-control">Cost</label>
    		<input type="number" class="form-control modal-cal-total" min="0" id="costModal">
    	</div>
    	<div class="form-group">
    		<label class="label-control">Total</label>
    		<input type="number" class="form-control" id="totalModal" readonly>
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
    <script src="{{ asset('back-end/asset/js/purchase.js') }}"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            if("{{ Session::get('remove_pitem') }}"){
                if(localStorage.getItem('pItem')){
                    localStorage.removeItem('pItem');
                }
                @php(Session::forget('remove_pitem'))
            }
            var p_edit_item = @json($rows);
            localStorage.setItem('pItem', JSON.stringify(p_edit_item));
            loadItem();
        });
	</script>
@stop