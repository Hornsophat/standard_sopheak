@extends('back-end/master')
@section('title',"Sale List")
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.sale') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.sale_list') }}</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile"> 
            		<div class="tile-body">
						<div class="row">
							<div class="col-md-6">
								{{-- @if(Auth::user()->can('create-sale') || $isAdministrator)
									<a href="{{ route('sale.create')}}" class="btn btn-small btn-success mb-4">{{ __('item.new_sale') }}</a>
								@endif --}}
								@if(Auth::user()->can('create-deposite') || $isAdministrator)
									<a href="{{ url('sale/create?deposit=1')}}" class="btn btn-small btn-success mb-4">{{ __('item.new_sale') }}</a>
								@endif
							</div>
	
							<div class="col-md-6">
								<form action="{{ route('sale.index') }}" method="get">
									<div class="input-group">

											<input type="text" name="search" class="form-control col-md-6" value="{{ isset($_GET['search'])? $_GET['search']: }}" placeholder="{{ __('item.search') }}" onkeydown="if (event.keyCode == 13) this.form.submit()">&nbsp;&nbsp;
											<select class="form-control col-md-6" name="filter_status" onchange="this.form.submit()">
												<option value="">All</option>
												<option value="1" <?php isset($_GET['filter_status']) && $_GET['filter_status'] == 1?"selected":"" ?> >Deposit</option>
										<option value="2" {{   isset($_GET['filter_status']) && $_GET['filter_status'] == 2?"selected":"" }} >Completed</option>
										<option value="3" {{   isset($_GET['filter_status']) && $_GET['filter_status'] == 3?"selected":"" }} >Cancel</option>
											</select>
									</div>
								</form>
							</div>

						</div>

						<div class="text-success display_message text-center"></div><br>
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-nowrap">
				                <thead>
				                  	<tr>
					                    <th width="70" class="text-center">@sortablelink('sex',__('item.no'))</th>
										<th class="text-center">@sortablelink('sale_date',__('item.sale_date'))</th>
										<th class="text-center">{{ __('item.reference') }}</th>
					                    <th class="text-center">@sortablelink('customer_id',__('item.customer'))</th>
					                    <th class="text-center">@sortablelink('employee_id',__('item.employee'))</th>
					                    <th class="text-center">@sortablelink('total_discount',__('item.discount'))</th>
					                    <th class="text-center">@sortablelink('total_sale_commission',__('item.commission'))</th>
					                    <th class="text-center">@sortablelink('grand_total',__('item.grand_total'))</th>
					                    <th class="text-center">@sortablelink('',__('item.total_item'))</th>
					                    <th class="text-center">@sortablelink('',__('item.payment_process'))</th>
					                    <th class="text-center">{{ __('item.function') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
		                			@php
		                				function numFormat( $val , $length=2)
											{
			   									$decimal = is_numeric( $val ) && floor( $val ) != $val;
			   									if($decimal){
			   										return number_format($val,$length);
			   									}else{
			   										return $val;
			   									}
											}
		                			@endphp

		                			@foreach ($items as $item)
										@php
											$class ="";
											$percentage = 0;
											$x = $item->payment()->where("status", 2)->sum("amount_to_spend");
											if($x) {
												$total = $item->payment()->sum("amount_to_spend");
												$percentage = ($x*100)/$total;
												$class = "bg-success";
												if($percentage <=30){
													$class ="bg-danger";
												}else if($percentage <=60){
													$class ="bg-warning";
												}
											}
										@endphp

					                	<tr>
						                    <td class="text-center">{{ $loop->iteration }}</td>
											<td>{{Date("d-M-Y h:i:s A", strtotime($item->sale_date))  }}</td>
											<td>{{ $item->reference }}</td>
											<td><a href="{{ route('viewEmployee', $item->employee_id) }}"><b>{{ $item->soleToCustomer->first_name .' '. $item->soleToCustomer->last_name }}</b></a></td>
						                    <td><a href="{{ route('viewCustomer', $item->customer_id) }}"><b>{{ $item->soldByEmployee->first_name .' '. $item->soldByEmployee->last_name }}</b></a></td>
											<td class="text-center"><span class="badge badge-success">{{ "$ ". ($item->total_discount !=null?$item->total_discount:"0.00") }}</span></td>
											<td class="text-center"><span class="badge badge-success">{{ "$ ". $item->total_sale_commission }}</span></td>
											<td class="text-center"><span class="badge badge-success">{{ "$ ". $item->grand_total }}</span></td>
											<td class="text-center"><span class="badge badge-warning">{{ $item->salesDetail()->count() }}</span> </td>
											<td>
												<div class="progress" style="text-align: center;">
													<div class="progress-bar progress-bar-striped progress-bar-animated {{$class}}" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%">
														@if($percentage==100)
															<b><span style="color:black;">{{ number_format($percentage,0) ."%" }}</span></b>
														@else
															<b><span style="color:black;">{{ number_format($percentage,2) ."%" }}</span></b>
														@endif
													</div>
												</div>
											</td>
						                    <td class="text-center">
						                    <a href="{{ route('sale.cotract',$item->) }}" class="action btn btn-outline-info btn-sm" title="Contract">{{ __('item.contract') }}</a>
						                    <a href="{{ route('sale.invoice',$item->id) }}" class="action btn btn-outline-success btn-sm" title="invoice">{{ __('item.invoice') }}</a>
						                    @if(Auth::user()->can('view-sale') || $isAdministrator)
						                    	<a href="{{ route('viewSale',$item->id) }}" class="action btn btn-info btn-sm" title="Edit">{{ __('item.detail') }}</a>
						                    @endif
											@if($item->status == 1)

												@if(Auth::user()->can('complete-sale') || $isAdministrator)
													<a href="javascript:;" onclick="completeSale(this)" data-url="{{ route('completeSale',$item->id) }}" class="action btn btn-warning btn-sm" title="Edit">{{ __('item.complete') }}</a>
												@endif
												@if(Auth::user()->can('cancel-sale') || $isAdministrator)
													<a href="javascript:;" onclick="cancelSale(this)" data-url="{{ route('cancelSale',$item->id) }}" class="action btn btn-danger  btn-sm" title="Edit">{{ __('item.cancel') }}</a>
												@endif
											@else
												@if(Auth::user()->can('view-payment') || $isAdministrator)
													<a href="{{route('salePayment', $item->id)}}" class="action btn btn-success btn-sm" title="Payments">{{ __('item.payment') }}</a>
												@endif
											@endif
						                    </td>
						                </tr>
					                @endforeach
				                </tbody>
		              		</table>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
									{!! $items->render() !!}
								</div>
							</div>
						</div>
            		</div>
          		</div>
        	</div>
      	</div>
      	
	</main>
@stop
@section('script')

    <script type="text/javascript" src="{{URL::asset('back-end/js/plugins/sweetalert.min.js')}}"></script>
    <script type="text/javascript">
    
    	function deleteProduct(id , name) {
    		swal({
	      		title: "Are you sure to delete " +name+ " product?",
	      		type: "warning",
	      		showCancelButton: true,
	      		confirmButtonText: "Yes, delete it!",
	      		cancelButtonText: "No, Thanks!",
	      		closeOnConfirm: false,
	      		closeOnCancel: true
	      	},function(isConfirm) {
	      		if (isConfirm) {
	      			parent.location='{{URL('product/deleteProduct')}}'+'/'+id;
	      		}
	      	});
    	}

    	function cancelSale(el) {
    		var obj = $(el);
    		var url = obj.attr('data-url');
    		swal({
	      		title: "Are you sure want to cancel this sale?",
	      		type: "warning",
	      		showCancelButton: true,
	      		confirmButtonText: "Yes",
	      		cancelButtonText: "No",
	      		closeOnConfirm: true,
	      		closeOnCancel: true
	      	},function(isConfirm) {
	      		if (isConfirm) {
	      			$.ajax({
		                url: url, 
		                success: function(result){
		                    if(result.status) {
		                        $(".display_message").html(result.message);
		                    } else {
		                        $(".display_message").html(result.message);
		                    }
		                    setTimeout(function(){ location.reload(); }, 2000);
		                }
		            });	
	      		}
	      	});
    	}

    	function completeSale(el) {
    		var obj = $(el);
    		var url = obj.attr('data-url');
    		swal({
	      		title: "Are you sure want to complete this sale?",
	      		type: "warning",
	      		showCancelButton: true,
	      		confirmButtonText: "Yes",
	      		cancelButtonText: "No",
	      		closeOnConfirm: true,
	      		closeOnCancel: true
	      	},function(isConfirm) {
	      		if (isConfirm) {
	      			$.ajax({
		                url: url, 
		                success: function(result){
		                    if(result.status) {
		                        $(".display_message").html(result.message);
		                    } else {
		                        $(".display_message").html(result.message);
		                    }
		                    setTimeout(function(){ location.reload(); }, 2000);
		                }
		            });	
	      		}
	      	});
    	}
    </script>
@stop