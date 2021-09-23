@extends('back-end/master')
@section('title', __('item.payment'))
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
                <li class="breadcrumb-item active"><a href="#">{{ __('item.payment') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.payment') }}</h3><hr/>
                            <div class="error display_message"></div><br/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('error-message'))
                                    <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                                @endif
                                {{-- {!! Html::ul($errors->all()) !!} --}}

                                {!! Form::open(array('url' => route('sale_property.sale_payment',['sale_item'=>$sale_item, 'loan'=>$loan]) , 'method' => 'POST', 'files' => true)) !!}
                                
                                <div class="row">
                                    <div class="col-md-4"> 
                                       <div class="form-group">
                                            {!! Form::label('code', trans('item.code')) !!}
                                            {!! Form::text('code', $code, array('class' => 'form-control', 'readonly')) !!}
                                        </div>
                                   </div>
                                   <div class="col-md-4"> 
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
                                   <div class="col-md-4"> 
                                       <div class="form-group">
                                            {!! Form::label('customer', trans('item.customer')) !!}
                                            {!! Form::text(null, $customer->last_name.' '.$customer->first_name, array('class' => 'form-control', 'readonly')) !!}
                                        </div>
                                   </div>
                                   <div class="col-md-12">
                                       <h5>{{ __('item.payment_date') }}</h5>
                                       <div class="table-responsive">
                                           <table class="table table-nowrap">
                                               <thead>
                                                   <tr class="badge-primary">
                                                        <th>{{ __('item.no') }}</th>
                                                        <th>{{ __('item.date') }}</th>
                                                        <th>{{ __('item.amount') }}</th>
                                                        <th>{{ __("item.amount_paid") }}</th>
                                                        <th>{{ __('item.amount_to_be_paid') }}</th>
                                                   </tr>
                                               </thead>
                                               <tbody id="scheduleContent">
                                                    <tr>
                                                        <td>1</td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime($payment_schedule->payment_date)) }}</td>
                                                        <td class="text-right">${{ number_format($loan->loan_amount,2) }}</td>
                                                        <td class="text-right">${{ number_format($sale_item->deposit+$payment_schedule->paid,2) }}</td>
                                                        <td class="text-right">${{ number_format($payment_schedule->amount_to_spend-$payment_schedule->paid,2) }}</td>
                                                    </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                                   <div class="col-md-6"></div>
                                   <div class="col-md-6">
                                       <div class="row">
                                           <div class="col-md-12 mb-3"> 
                                               <div class="input-group">
                                                    {!! Form::label('amount', trans('item.amount'), array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('amount', ($payment_schedule->amount_to_spend-$payment_schedule->paid)*1, array('class' => 'form-control','id'=>'amount','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" >$</span>
                                                    </div>
                                                    @if ($errors->has('amount'))
                                                        <span class="help-block text-danger" style="width: 100%;">
                                                            <strong>{{ $errors->first('amount') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                           </div>
                                           <div class="col-md-12 mb-3"> 
                                               <div class="input-group">
                                                    {!! Form::label('penalty', trans('item.penalty'), array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('penalty', null, array('class' => 'form-control change-total','id'=>'penalty','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" >$</span>
                                                    </div>
                                                    @if ($errors->has('penalty'))
                                                        <span class="help-block text-danger" style="width: 100%;">
                                                            <strong>{{ $errors->first('penalty') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                           </div>
                                           <div class="col-md-12 mb-3"> 
                                               <div class="input-group">
                                                    {!! Form::label('discount', trans('item.discount'), array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('discount', null, array('class' => 'form-control change-total','id'=>'discount','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" >$</span>
                                                    </div>
                                                    @if ($errors->has('discount'))
                                                        <span class="help-block text-danger" style="width: 100%;">
                                                            <strong>{{ $errors->first('discount') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                           </div>
                                           <div class="col-md-12 mb-3"> 
                                               <div class="input-group">
                                                    {!! Form::label('total', trans('item.total'), array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('total', ($payment_schedule->amount_to_spend-$payment_schedule->paid)*1, array('class' => 'form-control','id'=>'total','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');", 'readonly')) !!}
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
                                           <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    {!! Form::label('remark', trans('item.description')) !!}
                                                    {!! Form::textarea('remark', null, array('class' => 'form-control', 'rows'=>3)) !!}
                                                </div>
                                            </div>
                                        </div>
                                       </div>
                                   </div>
                                {!! Form::button(trans('item.back'), array('class' => 'btn btn-danger pull-left','onclick' => 'window.history.back();')) !!}
                                {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'property_submit')) !!}

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
    <script type="text/javascript">
        $(document).ready(function(){
            // loadTotal();
        });
        $('#customer, #payment_stage').select2();
        $('.date-picker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
        $(document).on('keyup', '.change-total', function(){
            loadTotal();
        });
        function loadTotal(){
            var penalty = $('#penalty').val();
            var discount = $('#discount').val();
            if(!penalty){
                penalty=0;
            }
            if(!discount){
                discount=0;
            }
            getOldTotal();
            var total = $('#total').val();
            total = parseFloat(total);
            discount = parseFloat(discount);
            if(discount>total){
                discount =0;
                $('#discount').val(discount);
                getOldTotal();
                loadTotal();
                return false;
            }
            penalty = parseFloat(penalty);
            $('#amount').val(total+penalty-discount);
            $('#total').val(total+penalty-discount);
        }
        $(document).on('keyup','#amount',function(){
            var penalty = $('#penalty').val();
            var discount = $('#discount').val();
            var total = $('#total').val();
            var t_amount = 1*total+1*penalty-1*discount;
            var amount = $(this).val();
            amount*=1;
            if(amount>t_amount){
                $(this).val(t_amount);
            }
        });
        function getOldTotal(){
            $('#total').val({{ ($payment_schedule->amount_to_spend-$payment_schedule->paid)*1 }});
        }
    </script>
@stop