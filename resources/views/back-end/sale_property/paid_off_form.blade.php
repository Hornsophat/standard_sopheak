@extends('back-end/master')
@section('title', 'Paid off')
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
                <li class="breadcrumb-item active">Sale : {{ $sale_item->reference }}</li>
                <li class="breadcrumb-item active">Customer : {{ $customer->customer_no }}</li>
                <li class="breadcrumb-item active"><a href="#">Paid off</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <h3>Paid off</h3><hr/>
                                    <div class="error display_message"></div><br/>
                                    <div class="panel-body">
                                        @if (Session::has('message'))
                                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                                        @endif
                                        @if (Session::has('error-message'))
                                            <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                                        @endif
                                        {{-- {!! Html::ul($errors->all()) !!} --}}

                                        {!! Form::open(array('url' => route('sale_property.paid_off',['sale_item' => $sale_item->id]) , 'method' => 'POST', 'files' => true)) !!}
                                        
                                        <div class="row">
                                            <div class="col-md-12"> 
                                               <div class="form-group">
                                                    {!! Form::label('code', trans('item.code')) !!}
                                                    {!! Form::text('code', $code, array('class' => 'form-control', 'readonly')) !!}
                                                </div>
                                           </div>
                                           <div class="col-md-12 mb-3"> 
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
                                           <div class="col-md-12"> 
                                               <div class="form-group">
                                                    {!! Form::label('customer', trans('item.customer')) !!}
                                                    {!! Form::text(null, $customer->last_name_en.' '.$customer->first_name_en, array('class' => 'form-control', 'readonly')) !!}
                                                </div>
                                           </div>
                                           <div class="col-md-12 mb-3"> 
                                               <div class="input-group"​​​ style="font-family: Time New Roman">
                                                    {!! Form::label('amount', trans('តម្លៃសរុប'), array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('amount', ($amount_to_paid)*1, array('class' => 'form-control','id'=>'amount','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');", 'readonly')) !!}
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
                                                    {!! Form::label('adjustment_amount', 'Adjustment Amount', array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('adjustment_amount', 0, array('class' => 'form-control','id'=>'adjustment_amount','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" >$</span>
                                                    </div>
                                                    @if ($errors->has('adjustment_amount'))
                                                        <span class="help-block text-danger" style="width: 100%;">
                                                            <strong>{{ $errors->first('adjustment_amount') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                           </div>
                                           <div class="col-md-12 mb-3"> 
                                               <div class="input-group">
                                                    {!! Form::label('total_paid_amount', 'Total Paid Amount', array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('total_paid_amount', ($amount_to_paid)*1, array('class' => 'form-control','id'=>'total_paid_amount','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');", 'readonly')) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" >$</span>
                                                    </div>
                                                    @if ($errors->has('total_paid_amount'))
                                                        <span class="help-block text-danger" style="width: 100%;">
                                                            <strong>{{ $errors->first('total_paid_amount') }}</strong>
                                                        </span> 
                                                    @endif
                                                </div>
                                           </div>
                                           <div class="col-md-12 mt-3 mb-3">
                                                <div class="form-group">
                                                    {!! Form::label('remark', trans('item.description')) !!}
                                                    {!! Form::textarea('remark', null, array('class' => 'form-control', 'rows'=>3)) !!}
                                                </div>
                                            </div>
                                           <div class="col-md-12">
                                               {!! Form::button(trans('item.back'), array('class' => 'btn btn-danger pull-left','onclick' => 'window.history.back();')) !!}
                                                {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right', 'id' => 'property_submit')) !!}
                                           </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('back-end/js/lib/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('back-end/js/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('back-end/js/lib/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $('#customer, #payment_stage').select2();
        $('.date-picker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
        $('#adjustment_amount').keyup(function(){
            $('#total_paid_amount').val(($('#amount').val()*1)+($(this).val()*1))
        });
    </script>
@stop