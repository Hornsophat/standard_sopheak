@extends('back-end/master')
@section('title', 'Edit Booking Property')
@section('style')

@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.property') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.edit_booking') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.edit_booking') }}</h3><hr/>
                            <div class="error display_message"></div><br/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('error-message'))
                                    <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                                @endif
                                {{-- {!! Html::ul($errors->all()) !!} --}}

                                {!! Form::model(array('url' => route('sale_property.edit_booking',['id'=>$reservation->id]) , 'method' => 'POST', 'files' => true)) !!}
                                
                                <div class="row">
                                    <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('code', trans('item.code')) !!}
                                            {!! Form::text('code', $payment_transaction->reference, array('class' => 'form-control', 'readonly')) !!}
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('date', trans('item.date'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('date', date('d-m-Y', strtotime($reservation->date_booked)), array('class' => 'form-control date-picker', 'style'=>'cursor:pointer;','autocomplete' => 'off', 'placeholder' => 'dd-mm-yyyy')) !!}
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
                                            {!! Form::select('customer', $customers,$reservation->customer_id, array('class' => 'form-control', 'id' => 'customer')) !!}
                                            @if ($errors->has('customer'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('customer') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="form-group">
                                            {!! Form::label('customer_partner_id', 'Partner') !!}
                                            @if($reservation->customer_partner_id)
                                                {!! Form::select('customer_partner_id', $customers,$reservation->customer_partner_id, array('class' => 'form-control', 'id' => 'customer_partner_id', 'disabled')) !!}
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
                                   <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('date_expire', trans('item.expire_date'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('date_expire', date('d-m-Y', strtotime($reservation->date_expire)), array('class' => 'form-control date-picker', 'style'=>'cursor:pointer;','autocomplete' => 'off', 'placeholder' => 'dd-mm-yyyy')) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text" ><i class="fa fa-calendar"></i></span>
                                            </div>
                                            @if ($errors->has('date_expire'))
                                                <span class="help-block text-danger" style="width: 100%;">
                                                    <strong>{{ $errors->first('date_expire') }}</strong>
                                                </span> 
                                            @endif
                                        </div>
                                   </div>
                                   <div class="col-md-6"> 
                                       <div class="input-group">
                                            {!! Form::label('deposit', trans('item.deposit'), array('style'=>'width:100%;')) !!}
                                            {!! Form::text('deposit', $reservation->amount*1, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
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
                                   <div class="col-md-12 mt-3 mb-3">
                                        <div class="form-group">
                                            {!! Form::label('remark', trans('item.description')) !!}
                                            {!! Form::textarea('remark', $reservation->remark, array('class' => 'form-control', 'rows'=>3)) !!}
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


@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
    <script type="text/javascript">
        $('#customer, #customer_partner_id').select2();
        $('.date-picker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
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