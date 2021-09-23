@extends('back-end/master')
@section('title',"Add Sale")
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
<style type="text/css">
    .table td {
        vertical-align: middle;
    }
    .border-none {
        border: none;
    }
    .sub_commission{
        background: white!important;
    }
    .border-bottom {
        border-bottom: 1px solid gray !important;
    }
    .sub_price{
        background: white!important;
    }
</style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.sale') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.new_sale') }}</a></li>
            </ul>
        </div>
        <div class="col-lg-12">
            @include('flash/message')
            <div class="panel panel-default">
                <div class="panel-body bg-white rounded overflow_hidden p-4">
                    <!-- <h4 class="text-dark text-left mb-4">New Sale</h4><hr> -->
                    <h5 class="text-dark text-left">{{ __('item.general') }}</h5><hr>
                    <div class="error display_message"></div><br/>
                    {{ Form::open(["url" => $url ?? '', "method" => 'POST', "class" => "form-horizontal", 'id' => 'form-sale']) }}
                        {!! Form::input('hidden', 'id', $item->id ?? '') !!}
                        {{ csrf_field() }}

                        {!! Html::ul($errors->all()) !!}

                        <div class="row">
                            <div class="col-sm-5">
                            {!! Form::label('employee_id', trans('item.sale'))." <span class='required'>*</span>  " !!}
                                <div class="form-group">
                                    
                                    {{ Form::select('employee_id', $employee_list ?? [], $item->employee_id ?? '', ['class' => 'form-control demoSelect employee_id', 'id' => 'demoSelect'])}}
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5">
                                {!! Form::label('item_id', trans('item.customer'))." <span class='required'>*</span> " !!}
                                <div class="form-group">
                                    {{ Form::select('customer_id', $customer_list ?? [], $item->customer_id ?? '', ['class' => 'form-control demoSelect customer_id', 'id' => 'demoSelect'])}}
                                </div>
                            </div>
                        </div>
                            <hr width="80%" class="text-center"/>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::label('project_id', trans('item.project_name'))." <span class='required'>*</span>  " !!}
                                    {{ Form::select('project_id', $project_list ?? [], $item->item_id ?? '', ['class' => 'form-control project_id'])}}
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                <!-- $project_zone_list ??  -->
                                    {!! Form::label('zone_id', trans('item.project_zone'))." <span class='required'>*</span>  " !!}
                                    {{ Form::select('zone_id', [], $item->zone_id ?? '', ['class' => 'form-control zone_id'])}}
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::label('property_id', trans('item.property'))." <span class='required'>*</span>  " !!}
                                    {{ Form::select('property_id', $property_list ?? [], $item->property_id ?? '', ['class' => 'form-control property_id'])}}
                                </div>
                            </div>
                            <div class="col-sm-1" style="display: none;">
                                <div class="form-group">
                                    {!! Form::label('quantity', trans('item.qty'))." <span class='required'>*</span>  " !!}
                                    {{Form::number('quantity', 1, ['class' => 'form-control quantity', 'min' => 1])}}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::label('price', trans('item.price'))." <span class='required'>*</span>  " !!}
                                    {{ Form::number('price', 0, ['class' => 'form-control price', 'min'=> 0]) }}
                                </div>
                            </div>

                            <div class="col-sm-1">
                                <div class="form-group">
                                    {!! Form::label('discount', trans('item.discount').'(%)') !!}
                                    {{ Form::number('discount', 0, ['class' => 'form-control discount', 'min' => 0]) }}
                                </div>
                            </div>

                            <div class="col-sm-2" style="display: none;">
                                <div class="form-group">
                                    {!! Form::label('sale_commission', trans('item.commission')."(%)")." <span class='required'>*</span>  " !!}
                                    {{Form::number('sale_commission', 0, ['class' => 'form-control sale_commission'])}}
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-sm-12">
                                <div class="form-group" style="padding-top: 0px;">
                                    <a href="javascript:;" class="btn btn-primary btn-sm pull-right add-sale-item"><i class="fa fa-plus"></i>{{ __('item.add') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive clone-table">
                            <table class="table table-bordered rows-t" id="table-sale-item" width="100%" cellpadding="5" cellspacing="0">
                                <thead>
                                    <!-- <th width="60" class="text-center">No</th> -->
                                    <th>{{ __('item.project_name') }}</th>
                                    <th width="50" class="text-center">{{ __('item.qty') }}</th>
                                    <th class="text-center">{{ __('item.price') }}</th>
                                    <th class="text-center">{{ __('item.commission') }}</th>
                                    <th class="text-center">{{ __('item.discount') }}</th>
                                    <th class="text-center">{{ __('item.amount') }}</th>
                                    <th class="text-center"><i onclick="clear_sale_item()" class="fa fa-refresh" style="cursor:pointer;"></i></th>
                                </thead>
                                <tbody id="sale-item">
                                    <tr class="no_result">
                                        <td colspan="7" class="text-center">No Found!</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    @php $colspan = 5; @endphp
                                    <tr style="border-left: 2px solid white;">
                                        <td colspan="{{ $colspan }}" class="text-right" align="right" style="border-left: 2px solid white;border-bottom: 2px solid white;">{{ __('item.total') }}</td>
                                        <td class="text-right total">$   0.00</td>
                                        <td class="hidden"></td>
                                    </tr>
                                    <tr style="border-left: 2px solid white;">
                                        <td colspan="{{ $colspan }}" class="text-right" align="right" style="border-left: 2px solid white;border-bottom: 2px solid white;border-top: 2px solid white;">{{ __('item.deposit') }} ($)</td>
                                        <td class="text-right" width="100">
                                            <input style="width: 100px;" type="number" value="0" min="0" name="deposit" class="text-right deposit border-none" data-deposite="{{$check_deposite}}">
                                        </td>
                                        <td class="hidden"></td>
                                    </tr>
                                    <tr style="border-left: 2px solid white; display: none">
                                        <td colspan="{{ $colspan }}" class="text-right" align="right" style="border-left: 2px solid white;border-bottom: 2px solid white;border-top: 2px solid white;">{{ __('item.total_commission') }}</td>
                                        <td class="text-right commission">$   0.00</td>
                                        <td class="hidden"></td>
                                    </tr>
                                    <tr style="border-left: 2px solid white;">
                                        <td colspan="{{ $colspan }}" class="text-right" align="right" style="border-left: 2px solid white;border-bottom: 2px solid white;border-top: 2px solid white;">{{ __('item.discount') }}</td>
                                        <td class="text-right latest_discount">$   0.00</td>
                                        <td class="hidden"></td>
                                    </tr>
                                    <tr style="border-left: 2px solid white;">
                                        <td colspan="{{ $colspan }}" class="text-right" align="right" style="border-left: 2px solid white;border-bottom: 2px solid white;border-top: 2px solid white;">{{ __('item.grand_total') }}</td>
                                        <td class="text-right grand-total">$   0.00</td>
                                        <td class="hidden"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="rows" id="pament-element">
                            <div class="rows">
                                <h5 class="text-dark text-left">Pament Timeline</h5><hr>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('payment_id', trans('Payments')) !!}
                                        {{ Form::select('payment_id', $payment_list ?? [], $item->payment_id ?? '', ['class' => 'form-control payment_id'])}}
                                    </div>
                                </div>

                                <div class="col-sm-9 payment_detail">
                                    
                                </div>
                                <div class="clearfix">&nbsp;</div>
                            </div>
                        </div>

                        <div class="rows pull-right">
                            <!-- {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'submit-button')) !!} -->
                            <a href="javascript:;" class="btn btn-primary pull-right" id="submit-button">Submit</a>
                        </div>
                        {{ Form::hidden('total_price', 0, ['id' => 'total_price']) }}
                        {{ Form::hidden('sale_total_commission', 0, ['id' => 'sale_total_commission'])}}
                        {{ Form::hidden('latest_discount_value', 0, ['id' => 'latest_discount_value'])}}
                        {{ Form::hidden('check_deposite', $check_deposite) }}
                    {{ Form::close() }}
            </div>
        </div>
        </div>

        @include('back-end.sale.invoice')

    </main>

    <div class="col-12 text-right d-none"><a id="let-print" onClick="printPage()" class="btn btn-primary" href="javascript:;" target="_blank"><i class="fa fa-print"></i> Print</a></div>

@stop

@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".project_id").attr('disabled','disabled');
            $('.property_id').attr('disabled','disabled');
            disableInput();

            $('#pament-element').hide();
            $('#submit-button').hide();


            callFileInput('#thumbnail', 1, 5120, ["jpg" , "jpeg" , "png"]);
            $('.demoSelect').select2();
            $('.property_id').select2();
        }); 

        $(function(){

            $('#submit-button').on('click', function(){
                var payment_id = $('.payment_id').find(":selected").val();
                if(payment_id == ''){
                    alertFunction('Please choose a pament timeline!');
                    return false;
                }

                deposit = $('.deposit').attr('data-deposite');
                deposit_val = $('.deposit').val();
                if(deposit == 'yes' && deposit_val == 0) {
                    $(".display_message").html("Please enter deposit.");
                    $('.deposit').focus();
                    return false;
                }

                printPage();
                $('#form-sale').submit();
            });

            $('.customer_id').on('change', function() {
                var employee_id = $('.employee_id').find(":selected").val();
                if(employee_id == ''){
                    $(".display_message").html("Please Select sale man.");
                    $(this).val('').trigger('change.select2');
                    return false;
                }
                $(".display_message").html("");
                $(".project_id").removeAttr('disabled');

            });

            $('.project_id').on('change', function() {
                if(this.value == '') {
                   disableInput();
                   return false;
                }

                var customer_id = $('.customer_id').find(":selected").val();
                if(customer_id == ''){
                    $(".display_message").html("Please choose customer!");
                    $(this).val('').trigger('change.select2');
                    return false;
                }

                var employee_id = $('.employee_id').find(":selected").val();
                if(employee_id == ''){
                    $(".display_message").html("Please choose sale man!");
                    $(this).val('').trigger('change.select2');
                    return false;
                }

                var url = "{{url('sale/get-project-ajax/')}}" + '/' + this.value + '?employee_id=' + employee_id;
                $.ajax({url: url, success: function(result){

                    $('.zone_id').removeAttr("disabled");
                    var html_zone = "<option value=''>-- Select --</option>";
                    $.each(result.zones, function (key, val) {
                        html_zone += "<option value='"+ key +"'>" + val + "</option>";
                    });
                    $('.zone_id').html(html_zone);

                    var commission = 0;
                    if(result.sale_commission != 0) {
                        commission = result.sale_commission.commission;
                    }

                    $('.quantity').removeAttr("disabled");
                    $('.price').removeAttr("disabled");
                    $('.sale_commission').val(commission);

                }});
            });

            $('.zone_id').on('change', function(e) {
                e.preventDefault();
                var employee_id = $('.employee_id').find(":selected").val();
                if(employee_id == ''){
                    $(".display_message").html("Please choose sale man!");
                    $(this).val('').trigger('change.select2');
                    return false;
                }

                var customer_id = $('.customer_id').find(":selected").val();
                if(customer_id == ''){
                    $(".display_message").html("Please choose sale man!");
                    $(this).val('').trigger('change.select2');
                    return false;
                }

                var project_id = $('.project_id').find(":selected").val();
                if(project_id == '') {
                    $(".display_message").html('Please choose a project!');
                    return false;
                }

                if(this.value == '') {
                   $(".display_message").html('Please select one other zone!');
                   return false;
                }

                var url = "{{url('sale/get-property-by-zone/')}}" + '/' + this.value + '?project_id=' + project_id;
                $.ajax({
                    url: url, 
                    success: function(result){console.log(result);
                        if(result.properties != 0) {
                            var html_property = "<option value=''>-- Select --</option>";
                            $.each(result.properties, function (key, val) {
                                html_property += "<option value='"+ key +"'>" + val + "</option>";
                            });
                            $('#property_id').removeAttr("disabled");
                            $('.discount').removeAttr("disabled");
                            $('.property_id').html(html_property);
                        } else {
                            $('.property_id').html('');
                            $('.property_id').html("<option value=''>-- Select --</option>");
                            $('.property_id option[value=""]').prop("selected", true);
                        }
                        $('.property_id').val('').trigger('change.select2');
                    }
                });
            });

            $('.payment_id').on('change', function(e) {
                e.preventDefault();
                if(this.value == '') {
                    $('#submit-button').hide();
                    $('.payment_detail').html('');
                    return false;
                }
                var url = "{{url('sale/get-payment-ajax/')}}" + '/' + this.value + '?total=' + sum_grant_total();
                $.ajax({url: url, success: function(result){
                    $('.payment_detail').html(result.view);
                    $('#submit-button').show();
                }});
            });

            $('.add-sale-item').on('click', function() {
                var price = $('.price').val();
                
                var quantity = $('.quantity').val();
                var price = $('.price').val();
                var property_name = $('.property_id').find(":selected").text();
                var property_id = $('.property_id').find(":selected").val();
                var customer_id = $('.customer_id').find(":selected").val();
                var employee_id = $('.employee_id').find(":selected").val();
                var project_id = $('.project_id').find(":selected").val();
                var zone_id = $('.zone_id').find(":selected").val();
                var sale_commission = $('.sale_commission').val();
                var discount = $('.discount').val();

                if(employee_id == '') {
                    $(".display_message").html('Please choose sale man!');
                }else if(customer_id == '') {
                    $(".display_message").html('Please choose customer!');
                }else if (zone_id == ''){
                    $(".display_message").html('Please choose zone!');
                }else if(property_id == '') {
                    $(".display_message").html('Please choose property!');
                }else if(project_id == '') {
                    $(".display_message").html('Please choose a project!');
                }else if(price == '' || price == 0){
                    $(".display_message").html("Please enter property price!");
                } else {
                    if($('#sale-item').find('.exist_property_id_' + property_id).length > 0) {
                        var old_qty = $('.property_id_' + property_id).val();
                        var new_qty = parseInt(old_qty) + parseInt(quantity);
                        var new_price = new_qty * parseInt(price);
                        $('.property_id_' + property_id).val(new_qty);
                        $('.sub_total_' + property_id).val(new_price);
                        $('.total').text('$   ' + sum_total() + '.00');
                        $('.grand-total').text('$   ' + sum_grant_total() + '.00');
                        $('.commission').text('$   ' + sum_total_commission());
                        $('.payment_id').val('').trigger('change.select2');
                        $('.payment_detail').html('');
                        disableInput();
                        return false;
                    }

                    var total = quantity*price;
                    var html_sale_item = '<tr class="sale-item" style="height: 45px;">';
                    html_sale_item += '<td>';
                    html_sale_item+= '<input type="hidden" name="project_ids[]" value="'+project_id+'">';
                    html_sale_item += '<input name="property_id[]" type="hidden" value="'+ property_id +'" class="exist_property_id_'+ property_id +'">'+property_name;
                    html_sale_item += '</td>';

                    // Qty
                    html_sale_item += '<td class="text-center">';
                    html_sale_item += ' <input style="width: 50px;border:1px solid white;" readonly name="quantity[]" type="number" value="'+ quantity +'" class="quantity-item quantity-t border-none text-center property_id_' + property_id +'" data-propertyid="'+ property_id +'">';
                    html_sale_item += '</td>';

                    // Price
                    html_sale_item += '<td class="text-center">';
                    html_sale_item += '<input style="border:1px solid white;" name="price[]" type="number" value="'+ parseFloat(price).toFixed(2) +'" class="border-none price-item text-right price_' + property_id +'" data-propertyid="'+ property_id +'">$';
                    // Commission
                    html_sale_item += '</td>';
                    html_sale_item += '<td class="text-right style="border:1px solid white;" total_' + property_id +'">';
                    html_sale_item += '<input style="border:1px solid white;" name="sub_commission[]" type="text" value="'+ sale_commission +'" class="border-none text-right sub_commission sub_commission_' + property_id +'" disabled> %<input type="hidden" name="sub_commission_value[]" value="' + sale_commission + '" class="sum_sub_commission_value sub_commission_value_' + property_id + '"> <span class="sub_commission_span_'+ property_id +'">='+ parseFloat(price * sale_commission / 100).toFixed(2) +'$</span>';
                    html_sale_item += '</td>';

                    // Discount
                    html_sale_item += '</td>';
                    html_sale_item += '<td class="text-right style="border:1px solid white;" total_' + property_id +'">';
                    html_sale_item += '<input style="border:1px solid white;" min="0" name="sub_discount[]" type="number" value="'+ parseFloat(discount).toFixed(2) +'" class="border-none text-right discount-item sub_discount sub_discount_' + property_id +'" data-propertyid="'+ property_id +'"> % <input type="hidden" name="sub_discount_value[]" value="' + parseFloat(price * discount / 100).toFixed(2) + '" class="sum_sub_discount_value sub_discount_value_' + property_id + '"> <span class="sub_discount_span_'+ property_id +'">='+ parseFloat(price * discount / 100).toFixed(2) +'$</span>';
                    html_sale_item += '</td>';

                    // Total
                    html_sale_item += '<td class="text-center total_' + property_id +'">';
                    html_sale_item += '<input style="border:1px solid white;" name="sub_total[]" type="text" value="'+ parseFloat(total).toFixed(2) +'" class="border-none text-right sub_price sub_total_' + property_id +'" disabled>$<input type="hidden" name="sub_total_value[]" value="' + parseFloat(total).toFixed(2) + '" class="sub_total_value_' + property_id + '">';
                    html_sale_item += '</td>';
                    html_sale_item += '<td width="50" class="text-center">';
                    html_sale_item += '<i class="fa fa-remove text-danger" style="cursor:pointer;"></i>';
                    html_sale_item += '</td>';
                    html_sale_item += '</tr>';
                    $(".no_result").remove();
                    $('#sale-item').append(html_sale_item);
                    $('.total').text('$   ' + parseFloat(sum_total()).toFixed(2));
                    $('.grand-total').text('$   ' + parseFloat(sum_grant_total()).toFixed(2));
                    $('#pament-element').show();
                    $('.commission').text('$   ' + parseFloat(sum_total_commission()).toFixed(2));
                    $('.latest_discount').text('$   ' + parseFloat(sum_discount()).toFixed(2));

                    disableInput();
                    triggerItemQty();
                    triggerItemPrice();
                    triggerItemDiscount();
                }
            });

            $('#sale-item').on('click', '.fa-remove', function(){
                if ($(this).closest('table').find('tr').length > 5) {
                    $(this).closest('.sale-item').remove();
                }
                else {
                    $(this).closest('.sale-item').remove();
                    var html_sale_item = '<tr class="no_result">';
                    html_sale_item +='<td colspan="6" class="text-center">No Found!</td>';
                    html_sale_item +='</tr>';
                    $('#sale-item').append(html_sale_item);
                }

                $('.total').text('$   ' + sum_total() + '.00');
                $('.grand-total').text('$   ' + sum_grant_total() + '.00');
                 $('.commission').text('$   ' + sum_total_commission());
                $('#submit-button').hide();
                $('.payment_detail').html('');
                $('.payment_id').val('').trigger('change.select2');
            });

            $('.deposit').on('input', function(){
                deposit = $(this).val();
                if(deposit >sum_grant_total()){
                    $(this).val(0);
                    swal('Deposit!', 'Please Check Grand Total!');
                }
                $('.grand-total').text('$   ' + parseFloat(sum_grant_total()).toFixed(2));
                $('.payment_detail').html('');
                $('.payment_id').val('').trigger('change.select2');
            });

            triggerItemQty();
            triggerItemPrice();
            triggerItemDiscount();

            // $('#submit-button').on('click', function(){
                
            // });
            $('body').addClass('sidenav-toggled');

        });

        function triggerItemQty() {
            $('#sale-item').find('td').find('.quantity-item').on('input', function(){
                if($(this).attr('data-propertyid') !== undefined) {
                    id = $(this).attr('data-propertyid');
                    price = $('.price_' + id).val();
                    total = $(this).val() * price;
                    $('.sub_total_' + id).val(parseFloat(total).toFixed(2));
                    $('.sub_total_value_' + id).val(parseFloat(total).toFixed(2));
                    sub_discount = parseFloat($('.sub_discount_' + id).val()).toFixed(2);
                    discount_val = parseFloat(total * sub_discount / 100).toFixed(2);
                    $('.sub_discount_span_' + id).text('=$ '+discount_val);
                    $('.sub_discount_value_' + id).val(discount_val);
                    sub_commission = parseFloat($('.sub_commission_' + id).val()).toFixed(2);
                    commission_val = parseFloat(total * sub_commission / 100).toFixed(2);
                    $('.sub_commission_span_' + id).text('=$ '+commission_val);
                }
                $('.total').text('$   ' + parseFloat(sum_total()).toFixed(2));
                $('.grand-total').text('$   ' + parseFloat(sum_grant_total()).toFixed(2));
                $('#pament-element').show();
                $('.commission').text('$   ' + parseFloat(sum_total_commission()).toFixed(2));
                $('.latest_discount').text('$   ' + parseFloat(sum_discount()).toFixed(2));
            });
        }

        function triggerItemPrice() {
            $('#sale-item').find('td').find('.price-item').on('input', function(){
                if($(this).attr('data-propertyid') !== undefined) {
                    id = $(this).attr('data-propertyid');
                    qty = $('.property_id_' + id).val();
                    total = $(this).val() * qty;
                    $('.sub_total_' + id).val(parseFloat(total).toFixed(2));
                    $('.sub_total_value_' + id).val(parseFloat(total).toFixed(2));
                    sub_discount = parseFloat($('.sub_discount_' + id).val()).toFixed(2);
                    discount_val = parseFloat(total * sub_discount / 100).toFixed(2);
                    $('.sub_discount_span_' + id).text('=$ '+discount_val);
                    $('.sub_discount_value_' + id).val(discount_val);
                    sub_commission = parseFloat($('.sub_commission_' + id).val()).toFixed(2);
                    commission_val = parseFloat(total * sub_commission / 100).toFixed(2);
                    $('.sub_commission_span_' + id).text('=$ '+commission_val);
                }
                $('.total').text('$   ' + parseFloat(sum_total()).toFixed(2));
                $('.grand-total').text('$   ' + parseFloat(sum_grant_total()).toFixed(2));
                $('#pament-element').show();
                $('.commission').text('$   ' + parseFloat(sum_total_commission()).toFixed(2));
                $('.latest_discount').text('$   ' + parseFloat(sum_discount()).toFixed(2));
            });
        }

        function triggerItemDiscount() {
            $('#sale-item').find('td').find('.discount-item').on('input', function(){
                if($(this).attr('data-propertyid') !== undefined) {
                    id = $(this).attr('data-propertyid');
                    price = $('.price_' + id).val();
                    total = parseFloat(price * $(this).val() / 100).toFixed(2);
                    $('.sub_discount_span_' + id).text(total);
                    $('.sub_discount_value_' + id).val(total);
                }
                $('.grand-total').text('$   ' + parseFloat(sum_grant_total()).toFixed(2));
                $('.latest_discount').text('$   ' + parseFloat(sum_discount()).toFixed(2));
            });
        }

        function disableInput()
        {
            $('.project_id').val("").trigger("change.select2")
            $('.property_id').val("").trigger("change.select2");
            $('.property_id').attr("disabled", "disabled");
            $('.zone_id').val('');
            $('.zone_id').attr("disabled", "disabled");
            $('.sale_commission').val(0);
            $('.sale_commission').attr("disabled", "disabled");
            $(".price").val("0");
            $(".price").attr('disabled','disabled');
            $(".quantity").attr('disabled','disabled');
            $(".discount").val("0");
            $(".discount").attr('disabled','disabled');
            $(".quantity").val("1");
        }
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

        function sum_commission(){
            var sum_commission = 0;
            $(".sum_sub_discount_value").each(function() {
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0) {
                    sum_commission += parseFloat(value);
                }
            });
            return sum_commission;
        }

        function sum_total_commission(){
            var sum_total_commission = sum_total() - sum_grant_total();
            $('#sale_total_commission').val(sum_total_commission);
            return sum_total_commission;
        }

        function sum_grant_total(){
            var deposit = $('.deposit').val();
            var sum = (sum_total() - sum_discount()) - deposit;
            $("#total_price").val(sum);
            return sum;
        }

        function clear_sale_item(){
            $('#sale-item').html('');
            $('.total').text('$   ' + sum_total() + '.00');
            $('.grand-total').text('$   0.00');
            $('#submit-button').hide();
            $('.payment_detail').html('');
            $('#pament-element').hide();
            $('.payment_id').val('').trigger('change.select2');
            $('.commission').text('$   ' + sum_total_commission());
        }

        function sum_discount() {
            var sum_discount = 0;
            $(".sum_sub_discount_value").each(function() {
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0) {
                    sum_discount += parseFloat(value);
                }
            });
            $('#latest_discount_value').val(sum_discount);
            return sum_discount;
        }

    </script>

    <script type="text/javascript" src="{{URL::asset('back-end/js/plugins/sweetalert.min.js')}}"></script>
    <script type="text/javascript">
        $('#project_id').select2();
        $('#zone_id').select2();
        $('#property_id').select2();
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

        function alertFunction(str) {
            swal({
                title: str,
                type: "warning",
                showCancelButton: false,
                confirmButtonText: "Ok",
                closeOnConfirm: false,
                closeOnCancel: true
            });
        }

        /*
        |
        | Print Page
        |
        */
        var printPage = function() {
            var customer_name = $('.customer_id').find(":selected").text();
            $('#customer_name').text(customer_name);
            var html = $('.clone-table').clone().appendTo('.table-print');
            $(".table-print th:last-child, .table-print td:last-child").remove();
            var divToPrint = document.getElementById('print-element');
            var htmlToPrint = '<style type="text/css"> table th, table td { border:1px solid #000;}</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close()

            $('.table-print').html('');

        }
    </script>
@stop