@extends('back-end/master')
@section('title',"Land Report")
@section('content')
<style type="text/css">
	.width-100 {
		width: 100% !important;
	}
	.m-r-0 {
		margin-right: 0px !important;
	}
	   @media print{
        
        
        .col-sm-6{width: 50%; float: left;}
        .col-sm-3{width: 25%; float: left;}
        .col-sm-9{width: 75%; float: left;}
        .col-md-4{width: 33.333%; float: left;}
       
    }
    }
</style>
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">Sales</li>
	          	<li class="breadcrumb-item active"><a href="#">Land Report</a></li>
	        </ul>
      	</div>
		<div class="row">
        	<div class="col-md-12">
				@include('flash/message')
          		<div class="tile">
            		<div class="tile-body bg-white rounded overflow_hidden p-4">
						<div class="rows">
							<form action="{{ url('report') }}" method="get" class="form-inline">
								<div class="col-md-4">
									{{ Form::text('start', $start_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => 'Start Date']) }}
								</div>
								<div class="col-md-4">
									{{ Form::text('end', $end_date ?? '', ['class' => 'width-100 form-control demoDate', 'autocomplete' => 'off', 'placeholder' => 'End Date']) }}
								</div>
								<div class="col-md-4">
									<select class="form-control width-100" name="filter_status" onchange="this.form.submit()">
										<option value="">All</option>
										<option value="1" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 1?"selected":"" }}>Deposit</option>
										<option value="2" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 2?"selected":"" }}>Completed</option>
										<option value="3" {{ isset($_GET['filter_status']) && $_GET['filter_status'] == 3?"selected":"" }}>Cancel</option>
									</select>
								</div>
							</form>
						</div><br>
						<div class="row">
							<div class="col-sm-12">
								<button class="btn btn-small btn-success pull-right" id="btn_print" type="">Print</button>
							</div>
							
						</div>
						<div id="table_print">
						<div class="text-success display_message text-center"></div><br>
						<div class="row">
							<div class="col-sm-4 col-md-4"><img src="{{Setting::get('LOGO')}}" style="height: 50px;margin-bottom: 20px;"></div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h3>LAND REPORTS</h3>
							</div>
						</div>
						<div class="row">
								<div class="col-sm-4 col-md-4">
									<p>Customer Name : </p>
								
								</div>
								<div class="col-sm-4 col-md-4"></div>
								<div class="col-sm-4 col-md-4">
									<p>Sale No : 000000</p>
									
								</div>
						</div>
						<br>
						<table class="table table-hover table-bordered">
			                <thead>
			                  	<tr>
				                    <th width="70" class="text-center">No</th>
				                    <th class="text-center">Number of </th>
									<th class="text-center">Payment Date</th>
				                    <th class="text-center">Amount To Spend</th>
				                    <th class="text-center">Balance</th>
			                  	</tr>
			                </thead>
	                		<tbody>
	                		
				                	<tr>
					                    <td class="text-center">sd</td>
					                    <td class="text-center">sdesfd}</td>
										<td class="text-center"rgv</td>
										<td class="text-center">fdg</td>
					                    <td class="text-center">fdgfdv</td>{{-- 
										<td class="text-center"><span class="badge badge-success">thsbfb</span></td>
										<td class="text-center"><span class="badge badge-success">hfh</span></td>
										<td class="text-center"><span class="badge badge-success">hgfhfg</span></td>
										<td class="text-center"><span class="badge badge-warning">fghfgh</span> </td> --}}
					                </tr>
				               
			                </tbody>
	              		</table>
	              		</div>
						<div class="pull-right">
							{{-- {!! $items->render() !!} --}}
							{{-- <a href="{{ $url_excel ?? '' }}" class="btn btn-success btn-sm" title="Excel"><i class="fa fa-file-excel-o m-r-0"></i></a>
					        <a href="{{ route('report.pdf') }}" class="btn btn-info btn-sm" title="PDF"><i class="fa fa-file-pdf-o m-r-0"></i></a> --}}
						</div>
            		</div>
          		</div>
        	</div>
      	</div>
      	
	</main>
@stop
@section('script')
<script type="text/javascript" src="{{ asset('back-end/js/lib/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('back-end/js/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('back-end/js/lib/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/printThis.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#btn_print').click(function(){
			 $('#table_print').printThis({
                importStyle: true,
                importCSS: true      
            });
		});
        $('.demoDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
@stop