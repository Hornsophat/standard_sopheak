@extends('back-end/master')
@section('title', __('item.edit_payment_stage'))
@section('style')

@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item" ><a href={{ route('payment_stages') }}>{{ __('item.payment_stage') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.edit_payment_stage') }}</a></li>
            </ul>
        </div>

        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.edit_payment_stage') }}</h3><hr/>
                            <div class="error display_message"></div><br/>
                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('error-message'))
                                    <div class="alert alert-danger">{{ Session::get('error-message') }}</div>
                                @endif
                                {{-- {!! Html::ul($errors->all()) !!} --}}

                                {!! Form::model($payment_stage,array('url' => route('payment_stage.edit', ['payment_stage' => $payment_stage]) , 'method' => 'POST', 'files' => true)) !!}
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="row">
                                           <div class="col-md-12"> 
                                               <div class="input-group">
                                                    {!! Form::label('amount', trans('item.amount'), array('style'=>'width:100%;')) !!}
                                                    {!! Form::text('amount', $payment_stage->amount*1, array('class' => 'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');")) !!}
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
                                           <div class="col-md-12 mt-3 mb-3">
                                                <div class="form-group">
                                                    {!! Form::label('remark', trans('item.description')) !!}
                                                    {!! Form::textarea('remark', null, array('class' => 'form-control', 'rows'=>3)) !!}
                                                </div>
                                            </div>
                                        </div>
                                        
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
    </main>


@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
    <script type="text/javascript">
        $('#customer').select2();
        $('.date-picker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@stop