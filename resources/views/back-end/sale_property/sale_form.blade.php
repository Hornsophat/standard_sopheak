@extends('back-end/master')
@section('title', __('item.add_sale'))
@section('style')
    <style type="text/css">
        table thead tr th{
            text-align: center;
        }
    </style>
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="{{ route('property') }}">{{ __('item.property') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.add_sale') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.add_sale') }}</h3><hr/>
                            <div class="error display_message"></div><br/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('error-message'))
                                    <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                                @endif
                                {{-- {!! Html::ul($errors->all()) !!} --}}

                                {!! Form::open(array('url' => route('sale_property.sale',['property'=>$property]) , 'method' => 'POST', 'files' => true)) !!}
                                
                                <div class="row">
                                    <div class="col-md-6"> 
                                       <div class="form-group" style="display:none">
                                            {!! Form::label('contract', trans('item.contract')) !!}
                                            <button type="button" class="btn btn-sm btn-warning pull-right" onclick="preview_contarct_sample()" data-toggle="modal" data-target="#contractModal"><i class="fa fa-eye"></i> {{ __('item.preview') }}</button>
                                            {!! Form::select('contract', $contracts,null, array('class' => 'form-control', 'id' => 'contract','required')) !!}

                                            @if ($errors->has('contract'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('contract') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"></div>
                                    <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('code', trans('item.code')) !!}
                                            {!! Form::text('code', $code, array('class' => 'form-control', 'readonly')) !!}
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('date', trans('item.date'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('date', date('d-m-Y'), array('class' => 'form-control date-picker', 'style'=>'cursor:pointer;','autocomplete' => 'off', 'placeholder' => 'dd-mm-yyyy', 'required'=>'true')) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" ><i class="fa fa-calendar"></i></span>
                                            </div>
                                            @if ($errors->has('date'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('date') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('customer', trans('item.customer')) !!}
                                            @if($reservation)
                                            {!! Form::select('customer', $customers,isset($reservation->customer_id)?$reservation->customer_id:null, array('class' => 'form-control', 'id' => 'customer','required', 'disabled')) !!}
                                            @else
                                            {!! Form::select('customer', $customers,isset($reservation->customer_id)?$reservation->customer_id:null, array('class' => 'form-control', 'id' => 'customer','required')) !!}
                                            @endif
                                            @if ($errors->has('customer'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('customer') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <!-- <div class="col-md-6">
                                       <div class="form-group" style="padding-left: 20px">
                                            <p>&emsp;</p>
                                           {!! Form::checkbox('free_land_register', 1, false, ['class' => 'form-check-input', 'style'=>'cursor:pointer;']) !!}
                                           {!! Form::label('property', 'Free Land Register',['class' => 'rounded badge-success pr-1 pl-1']) !!}
                                           @if ($errors->has('free_land_register'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('free_land_register') }}</strong>
                                                </span> 
                                            @endif
                                       </div>
                                   </div> -->
                                   <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('customer_partner_id', 'Partner') !!}
                                            @if($reservation)
                                                {!! Form::select('customer_partner_id', $customers,isset($reservation->customer_partner_id)?$reservation->customer_partner_id:null, array('class' => 'form-control', 'id' => 'customer_partner_id')) !!}
                                            @else
                                                <select name="customer_partner_id" class="form-control" id="customer_partner_id" disabled>
                                                    <option value=>-- {{ __('item.select') }} --</option>
                                                </select>
                                            @endif
                                            @if ($errors->has('customer_partner_id'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('customer_partner_id') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('property', trans('item.property')) !!}
                                            {!! Form::text('property', $property->property_no.' | '.$property->property_name, array('class' => 'form-control', 'readonly')) !!}
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                    <div class="input-group" style="font-family: 'Times New Roman', Times, serif">
                                         {!! Form::label('penalty_of_late_payment', trans('item.penalty_of_late_payment'), array('style'=>'width:100%;')) !!}
                                         {!! Form::text('penalty_of_late_payment', $property->penalty_of_late_payment*1, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                         <div class="input-group-append">
                                             <span class="input-group-text" >Days</span>
                                         </div>
                                     </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="input-group" style="font-family: 'Times New Roman', Times, serif">
                                         {!! Form::label('penalty', trans('item.penalty'), array('style'=>'width:100%;')) !!}
                                         {!! Form::text('penalty', $property->penalty*1, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                         <div class="input-group-append">
                                             <span class="input-group-text" >$</span>
                                         </div>
                                     </div>
                                </div>
                                <br>
                                   <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('price', trans('item.price'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('price', $property->property_price*1, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('price'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('price') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6 mb-3"> 
                                       <div class="input-group">
                                            {!! Form::label('discount', trans('item.discount'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('discount', $property->property_discount_amount*1, array('style' => 'width:70%;','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >{{ __('item.is') }}</span>
                                            </div>
                                            {!! Form::select('discount_type', $discount_types,null, array('style' => 'width:20%;padding:8px 5px;', 'id' => 'discount_type')) !!}
                                            @if ($errors->has('discount'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('discount') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                        <div class="input-group">
                                            
                                        </div>
                                   </div>
                                   <div class="col-md-6 mb-3"> 
                                       <div class="input-group">
                                            {!! Form::label('total', trans('item.total'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('total', ($property->property_price*1)-($property->property_discount_amount*1), array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');", 'readonly')) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('total'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('total') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6 "> 
                                       <div class="input-group">
                                            {!! Form::label('deposit', trans('item.deposit'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('deposit', (isset($reservation->amount)?$reservation->amount:0)*1, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');", 'readonly')) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('deposit'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('deposit') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group"​ style="display:none">
                                                    {!! Form::label('interest_rate', trans('item.interest_rate'), array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('interest_rate', null, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" >%</span>
                                                    </div>
                                                    @if ($errors->has('interest_rate'))
                                                        <span class="help-block text-danger" style="width: 100%;">
                                                            <strong>{{ $errors->first('interest_rate') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                            </div>
                                           <div class="col-md-12"> 
                                               <div class="input-group" style="display:none">
                                                    {!! HTML::decode(Form::label('loan_term', trans('item.loan_term').'<span class="required">*</span>', array('style'=>'width:100%;'))) !!}
                                                    {!! Form::text('loan_term', 15, array('style' => 'width:65%;','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" >{{ __('item.is') }}</span>
                                                    </div>
                                                    {!! Form::select('loan_term_type', $loan_term_types,null, array('style' => 'width:20%;padding:8px 5px;', 'id' => 'loan_term_type')) !!}
                                                    @if ($errors->has('loan_term'))
                                                        <span class="help-block text-danger" style="width: 100%;">
                                                            <strong>{{ $errors->first('loan_term') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                                <div class="input-group">
                                                    
                                                </div>
                                           </div>
                                           <div class="col-md-12"> 
                                               <div class="form-group" style="">
                                                    {!! Form::label('payment_stage', trans('item.payment_stage')) !!}
                                                    {!! Form::select('payment_stage', $payment_stages,null, array('class' => 'form-control', 'id' => 'payment_stage')) !!}
                                                    @if ($errors->has('payment_stage'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('payment_stage') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-md-12" style="display:none">
                                       <h5>{{ __('item.payment_date') }}</h5>
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                    <th>{{ __('item.no') }}</th>
                                                    <th>{{ __('item.date') }}</th>
                                                    <th>{{ __('item.currency') }}</th>
                                                    <th>{{ __('item.amount') }}</th>
                                                    <th>{{ __('item.interest_amount') }}</th>
                                                    <th>{{ __('item.total_amount_to_be_paid') }}</th>
                                                    <th>{{ __("item.amount_paid") }}</th>
                                               </tr>
                                           </thead>
                                           <tbody id="scheduleContent">
                                           </tbody>
                                       </table>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="form-group" style="display:none">
                                            {!! Form::label('employee', trans('item.employee')) !!}
                                            {!! Form::select('employee', $employees,isset($reservation->employee_id)?$reservation->employee_id:null, array('class' => 'form-control', 'id' => 'employee')) !!}
                                            @if ($errors->has('employee'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('employee') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="input-group" style="display:none">
                                            {!! Form::label('commission', trans('item.commission'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('commission', null, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" >$</span>
                                            </div>
                                            @if ($errors->has('commission'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('commission') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-12 mt-3 mb-3">
                                        <div class="form-group">
                                            {!! Form::label('remark', trans('រាយមុខទ្រព្យសម្បត្តិដាក់បញ្ចាំ')) !!}
                                            {!! Form::textarea('remark', null, array('class' => 'form-control', 'rows'=>3)) !!}
                                        </div>
                                    </div>
                                </div>
                                
                                {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'property_submit')) !!}

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@include('back-end.sale_property.sale_form_model')

@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
    <script type="text/javascript">
        $(document).ready(function(){
            getTotal();
            
        });
        $('#customer, #payment_stage, #customer_partner_id').select2();
        $('.date-picker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
        $(document).on('keyup', '#price, #discount', function(){
            getTotal();
        });
        $(document).on('change', '#discount_type', function(){
            $('#discount').val(0);
            getTotal();
        });
        $(document).on('change', '#payment_stage', function(){
            var stage = $('#payment_stage option:selected').val();
            var total = $('#total').val();
            var date = $('#date').val();
            var deposit = $('#deposit').val();
            var loan_term = $('#loan_term').val()
            var loan_term_type = $('#loan_term_type option:selected').val()
            var interest_rate = $('#interest_rate').val();
            if(!stage || stage==0){
                $('#scheduleContent').html('');
                return false;
            }
            $.ajax({
                type:'get',
                url:"{{ route('sale_property.get_preview_schedule_first_pay') }}", 
                data:{date:date,stage:stage,total:total,deposit:deposit,loan_term:loan_term, loan_term_type:loan_term_type, interest_rate:interest_rate},
                dataType:false,
                success:function(data){
                    $('#scheduleContent').html(data.html);
                },
                error:function(errors){
                    console.log(errors)
                }
            });
        })
        function getTotal(){
            var price = $('#price').val();
            var discount = $('#discount').val();
            var dis_type = $('#discount_type option:selected').val();
            if(dis_type=='discount_percent'){
                discount = discount/100;
                $('#total').val(price-(price*discount));
            }else{
                $('#total').val(price-discount);
            }
            $('#scheduleContent').html('');
            $("#payment_stage").val(null).change();
        }

        $('#loan_term_type, #loan_term').change(function(){
            getTotal()
        })

        function preview_contarct_sample(){
            var id = $('#contract option:selected').val();
            $.ajax({
                method:'get',
                url:"{{ route('sale_property.preview_contarct_sample') }}",
                data:{id:id},
                success:function(data){
                    $('#contractContentModal').html(data.html);
                }
            })
        }
        $('#contractModal').on('hidden.bs.modal', function (e) {
            $('#contractContentModal').html('');
        });
        $(document).on('change', '#customer', function(){
            var customer = $('#customer option:selected').val();
            if(!customer || customer==0){
                return 0;
            }
            $.ajax({
                url:'{{ route("get_partner") }}',
                type:'get',
                data:{customer_id:customer},
                success:function(data){
                    $('#customer_partner_id').removeAttr('disabled');
                    $('#customer_partner_id').html(data.option);
                }
            });
        });
    </script>
@stop