@extends('back-end/master')
@section('title',"Add Payment")
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!------ Include the above in your HEAD tag ---------->
@stop
@section('content')
<style type="text/css">
    .table td {
        vertical-align: middle;
    }
    .border-none {
        border: none;
    }
</style>
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">Sales</li>
	          	<li class="breadcrumb-item active"><a href="#">New Sale</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
            <div class="panel panel-default">
              	<div class="panel-body bg-white rounded overflow_hidden p-4">
              		<!-- <h4 class="text-dark text-left mb-4">New Sale</h4><hr> -->
                    <h5 class="text-dark text-left">General</h5><hr>
                    {{ Form::open(["url" => !empty($item) ? route('sale.update', $item->id) : route("sale.store"), "method" => (!empty($item)?'PUT':'POST'), "class" => "form-horizontal"]) }}
                        {!! Form::input('hidden', 'id', $item->id ?? '') !!}
                        {{ csrf_field() }}

                        {!! Html::ul($errors->all()) !!}

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('item_id', trans('Customers')) !!}
                                    {{ Form::select('customer_id', $customer_list ?? [], $item->customer_id ?? '', ['class' => 'form-control demoSelect customer_id', 'id' => 'demoSelect'])}}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('employee_id', trans('Employees')) !!}
                                    {{ Form::select('employee_id', $employee_list ?? [], $item->employee_id ?? '', ['class' => 'form-control demoSelect employee_id', 'id' => 'demoSelect'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('project_id', trans('item.project_name')) !!}
                                    {{ Form::select('project_id', $project_list ?? [], $item->project_id ?? '', ['class' => 'form-control project_id'])}}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                <!-- $project_zone_list ??  -->
                                    {!! Form::label('zone_id', trans('item.project_zone')) !!}
                                    {{ Form::select('zone_id', [], $item->zone_id ?? '', ['class' => 'form-control zone_id'])}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('property_id', trans('Properties')) !!}
                                    {{ Form::select('property_id', $property_list ?? [], $item->property_id ?? '', ['class' => 'form-control property_id'])}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('price', 'Price') !!}
                                    {{ Form::text('price', 0, ['class' => 'form-control price']) }}
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('sale_commission', trans('Commission')) !!}
                                    {{Form::text('sale_commission', 0, ['class' => 'form-control sale_commission'])}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('quantity', trans('Quantity')) !!}
                                    {{Form::text('quantity', 1, ['class' => 'form-control quantity'])}}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" style="padding-top: 0px;">
                                    <a href="javascript:;" class="btn btn-primary btn-sm pull-right add-sale-item"><i class="fa fa-plus"></i>ADD</a>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <!-- <th width="60" class="text-center">No</th> -->
                                <th>Property Name</th>
                                <th width="50" class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <td class="text-center">Sub-Commission</td>
                                <td class="text-center">Sub-Total</td>
                                <th class="text-center"><i onclick="clear_sale_item()" class="fa fa-refresh" style="cursor:pointer;"></i></th>
                            </thead>
                            <tbody id="sale-item">
                                @if($item)
                                    @foreach($item->salesDetail as $sale_item)
                                        <tr class="sale-item" style="height: 45px;">
                                            <td>
                                                <input name="property_id[]" type="hidden" value="1" class="exist_property_id_{{$sale_item->id}}">
                                                {{App\Model\Property::find($sale_item->item_id)->property_name}}
                                            </td>
                                            <td class="text-center">
                                                <input style="width: 50px;" name="quantity[]" type="text" value="{{$sale_item->qty}}" class="border-none text-center property_id_{{$sale_item->id}}">
                                            </td>
                                            <td class="text-center">
                                                $<input name="price[]" type="text" value="{{$sale_item->price}}" class="border-none text-right price_{{$sale_item->id}}">
                                            </td>
                                            <td class="text-center">
                                                %<input name="sub_commission[]" type="text" value="{{$sale_item->sale_commission}}" class="border-none text-right sub_commission sub_commission_{{$sale_item->id}}">
                                            </td>
                                            <td class="text-center total_{{$sale_item->id}}">
                                                $<input name="sub_total[]" type="text" value="{{$sale_item->qty * $sale_item->price}}.00" class="border-none text-right sub_price sub_total_{{$sale_item->id}}">
                                            </td>
                                            <td width="50" class="text-center">
                                                <i class="fa fa-remove text-danger" style="cursor:pointer;"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                @if($item)
                                    <tr style="border-left: 2px solid white;">
                                        <td colspan="4" class="text-right" style="border-bottom: 2px solid white;">Total</td>
                                        <td class="text-right total">${{$item->total_sale_commission + $item->grand_total}}.00</td>
                                    </tr>
                                    <tr style="border-left: 2px solid white;">
                                        <td colspan="4" class="text-right" style="border-bottom: 2px solid white;">Commission</td>
                                        <td class="text-right commission">${{$item->total_sale_commission ?? 0}}</td>
                                    </tr>
                                    <tr style="border-left: 2px solid white;">
                                        <td colspan="4" class="text-right" style="border-bottom: 2px solid white;">Grand-Total</td>
                                        <td class="text-right grand-total">${{$item->grand_total}}</td>
                                    </tr>
                                @endif
                            </tfoot>
                        </table>

                        <div class="rows" id="pament-element">
                            <h5 class="text-dark text-left">Pament Timeline</h5><hr>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('payment_id', trans('Payments')) !!}
                                    {{ Form::select('payment_id', $payment_list ?? [], $item->payment_timeline_id ?? '', ['class' => 'form-control payment_id'])}}
                                </div>
                            </div>

                            <div class="col-sm-12 payment_detail">
                                @if($item)
                                    @php $grand_total = $item->grand_total; @endphp
                                    @include('back-end.sale.payment_detail', ['total' => $grand_total, 'item' => $payment_item])
                                @endif
                            </div>
                            <div class="clearfix">&nbsp;</div>
                        </div>

                        <div class="rows pull-right">
                            {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'submit-button')) !!}
                        </div>
                        {{ Form::hidden('total_price', 0, ['id' => 'total_price']) }}
                    {{ Form::close() }}
            </div>
        </div>
	</main>

@stop

@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            callFileInput('#thumbnail', 1, 5120, ["jpg" , "jpeg" , "png"]);
            $('.demoSelect').select2();
            $('.property_id').select2();
        }); 

        $(function(){

            $('#submit-button').on('click', function(){
                var payment_id = $('.payment_id').find(":selected").val();
                if(payment_id == ''){
                    swal({
                        title: "Please choose a pament timeline!",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "Ok",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                    return false;
                }
            });

            // $('#pament-element').hide();
            // $('#submit-button').hide();

            $('.customer_id').on('change', function() {
                // var url = "{{url('sale/get-customer-ajax/')}}" + '/' + this.value;
                // $.ajax({url: url, success: function(result){
                //     $('.first_name').val(result.customer.first_name);
                // }});
            });

            $('.employee_id').on('change', function() {
                var url = "{{url('sale/get-employee-ajax/')}}" + '/' + this.value;
                $.ajax({url: url, success: function(result){
                    console.log(result);
                }});
            });

            $('.project_id').on('change', function() {
                var url = "{{url('sale/get-project-ajax/')}}" + '/' + this.value;
                $.ajax({url: url, success: function(result){
                    console.log(result.sale_commission);
                    $('.zone_id').html("<option value='"+ result.zone.id +"'>" + result.zone.name + "</option>");
                    $('.zone_id option[value="' +result.zone.id+ '"]').prop("selected", true);

                    var html_property = "<option value=''>Select one...</option>";
                    $.each(result.properties, function (key, val) {
                        html_property += "<option value='"+ key +"'>" + val + "</option>";
                    });
                    $('.property_id').html(html_property);

                    if(result.sale_commission.commission != 0) {
                        $('.sale_commission').val(result.sale_commission.commission);
                        $('.commission').text('%   ' + result.sale_commission.commission);
                    }

                }});
            });

            $('.payment_id').on('change', function() {
                var url = "{{url('sale/get-payment-ajax/')}}" + '/' + this.value + '?total=' + sum_grant_total();
                $.ajax({url: url, success: function(result){
                    $('.payment_detail').html(result.view);
                    $('#submit-button').show();
                }});
            });

            $('.add-sale-item').on('click', function() {
                var quantity = $('.quantity').val();
                var price = $('.price').val();
                var property_name = $('.property_id').find(":selected").text();
                var property_id = $('.property_id').find(":selected").val();
                var customer_id = $('.customer_id').find(":selected").val();
                var employee_id = $('.employee_id').find(":selected").val();
                var project_id = $('.project_id').find(":selected").val();

                if(employee_id == '') {
                    swal({
                        title: "Please choose sale man!",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "Ok",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }else if(customer_id == '') {
                    swal({
                        title: "Please choose customer!",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "Ok",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }else if(property_id == '') {
                    swal({
                        title: "Please choose a property!",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "Ok",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }else if(project_id == '') {
                    swal({
                        title: "Please choose a project!",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "Ok",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                } else {
                    if($('#sale-item').find('.exist_property_id_' + property_id).length > 0) {
                        var old_qty = $('.property_id_' + property_id).val();
                        var new_qty = parseInt(old_qty) + parseInt(quantity);
                        var new_price = new_qty * parseInt(price);
                        $('.property_id_' + property_id).val(new_qty);
                        $('.sub_total_' + property_id).val(new_price);
                        $('.total').text('$   ' + sum_total() + '.00');
                        $('.grand-total').text('$   ' + sum_grant_total() + '.00');
                        return false;
                    }

                    var total = quantity*price;
                    var html_sale_item = '<tr class="sale-item" style="height: 45px;">';
                    // html_sale_item += '<td class="text-center">';
                    // html_sale_item += '1';
                    // html_sale_item += '</td>';
                    html_sale_item += '<td>';
                    html_sale_item += '<input name="property_id[]" type="hidden" value="'+ quantity +'" class="exist_property_id_'+ property_id +'">'+property_name;
                    html_sale_item += '</td>';
                    html_sale_item += '<td class="text-center">';
                    html_sale_item += ' <input style="width: 50px;" name="quantity[]" type="text" value="'+ quantity +'" class="border-none text-center property_id_' + property_id +'">';
                    html_sale_item += '</td>';
                    html_sale_item += '<td class="text-center">';
                    html_sale_item += '$<input name="price[]" type="text" value="'+ price +'" class="border-none text-right price_' + property_id +'">.00';
                    html_sale_item += '</td>';
                    html_sale_item += '</td>';
                    html_sale_item += '<td class="text-center total_' + property_id +'">';
                    html_sale_item += '$<input name="sub_total[]" type="text" value="'+ total +'" class="border-none text-right sub_price sub_total_' + property_id +'">.00';
                    html_sale_item += '</td>';
                    html_sale_item += '<td width="50" class="text-center">';
                    html_sale_item += '<i class="fa fa-remove text-danger" style="cursor:pointer;"></i>';
                    html_sale_item += '</td>';
                    html_sale_item += '</tr>';

                    $('#sale-item').append(html_sale_item);
                    $('.total').text('$   ' + sum_total() + '.00');
                    $('.grand-total').text('$   ' + sum_grant_total() + '.00');
                    $('#pament-element').show();
                }
            });

            $('#sale-item').on('click', '.fa-remove', function(){
                $(this).closest('.sale-item').remove();
                $('.total').text('$   ' + sum_total() + '.00');
                $('.grand-total').text('$   ' + sum_grant_total() + '.00');
            });

        });

        function sum_total(){
            var sub_price = 0;
            $(".sub_price").each(function() {
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0) {
                    sub_price += parseFloat(value);
                }
            });
            return sub_price;
        }

        function sum_grant_total(){
            var commission = $('.sale_commission').val();
            var sum = sum_total() - (sum_total() * commission / 100);
            $("#total_price").val(sum);
            return sum;
        }

        function clear_sale_item(){
            $('#sale-item').html('');
            $('.total').text('$   ' + sum_total() + '.00');
            $('.grand-total').text('$   0.00');
        }

    </script>

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
            });
        }
    </script>
@stop