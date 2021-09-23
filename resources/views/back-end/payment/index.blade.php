@extends('back-end/master')
@section('title',"Payment Timeline")
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.payment_timeline') }}</li>
	          	{{-- <li class="breadcrumb-item active"><a href="#">{{ __('item.payment_list') }}</a></li> --}}
	        </ul>
      	</div>
		@include('flash/message')
      	<div class="row">
        	<div class="col-md-12">
        		<a href="{{ route('payment-timeline.create')}}" class="btn btn-success mb-4">{{ __('item.new_payment') }}</a>

          		<div class="tile">
            		<div class="tile-body">
            		<!-- id="dataTable" -->
              			<div class="table-responsive">
              				<table class="table table-hover table-bordered table-nowrap">
				                <thead>
				                  	<tr>
					                    <th class="text-center">@sortablelink("id", __('item.no'))</th>
					                    <th>@sortablelink("title",__("item.title"))</th>
					                    <th>@sortablelink("remark",__("item.remarks"))</th>
					                    <th class="text-center">{{ __('item.step') }}</th>
					                    <th>{{ __('item.function') }}</th>
				                  	</tr>
				                </thead>
		                		<tbody>
		                			@foreach ($items as $item)
					                	<tr>
						                    <td class="text-center" width="70">{{ $loop->iteration }}</td>
						                    <td>{{ $item->title }}</td>
						                    <td>{{ $item->remark }}</td>
						                    <td class="text-center">
												<span class="badge badge-primary">
													{{ $item->paymentTimelineDetails()->count()	 }}
												</span>
											</td>
						                    <td class="text-center">
						                    	<a href="{{ route('payment-timeline.show',$item->id) }}" class="btn btn-sm btn-primary" title="View Detail">{{ __('item.view') }}</a>
						                    	<a href="{{ route('payment-timeline.edit',$item->id) }}" class="btn btn-sm btn-info" title="Edit">{{ __('item.edit') }}</a>
												<a href="#" onclick="deleteItem({{$item->id}} , '{{$item->name}}');" class="btn btn-sm btn-warning" title="Delete">{{ __('item.delete') }}</a>
						                    </td>
						                </tr>
					                @endforeach
				                </tbody>
		              		</table>
              			</div>
	              		<div class="row">
	              			<div class="col-md-12">
	              				{!! $items->render() !!}
	              			</div>
	              		</div>
            		</div>
          		</div>
        	</div>
      	</div>
      	
	</main>
@stop
@section('script')
	<script type="text/javascript" src="{{URL::asset('back-end/js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('back-end/js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('back-end/js/plugins/sweetalert.min.js')}}"></script>
    <script type="text/javascript">
    	$('#dataTable').DataTable();
    	function deleteItem(id , name) {
    		swal({
	      		title: "Are you sure to delete " +name+ " item?",
	      		type: "warning",
	      		showCancelButton: true,
	      		confirmButtonText: "Yes, delete it!",
	      		cancelButtonText: "No, Thanks!",
	      		closeOnConfirm: false,
	      		closeOnCancel: true
	      	},function(isConfirm) {
	      		if (isConfirm) {
	      			parent.location='{{url("payment/delete")}}'+'/'+id;
	      		}
	      	});
    	}
    </script>
@stop