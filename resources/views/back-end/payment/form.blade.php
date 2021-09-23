@php
    if(!empty($item)){
        $payment_timeline_method = __('item.edit_payment_timeline');
    }else{
        $payment_timeline_method = __('item.add_payment_timeline');
    }
@endphp
@extends('back-end/master')
@section('title',$payment_timeline_method)
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.payment_timeline') }}</li>
	          	<li class="breadcrumb-item active"><a href="#">{{$payment_timeline_method }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4">
          		<h4 class="text-dark text-left mb-4">{{ __('item.timeline') }}</h4>
                {{ Form::open(["url" => !empty($item) ? route('payment-timeline.update', $item->id) : route("payment-timeline.store"), "method" => (!empty($item)?'PUT':'POST'), "class" => "form-horizontal"]) }}
                    {!! Form::input('hidden','id', $item->id??'') !!}
                    {{ csrf_field() }}
                    <!-- Name -->
                    <div class="col-lg-12 form-group d-lg-flex align-items-center{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="control-label col-lg-1 text-right">{{ __('item.title') }} </label>
                            <div class="col-lg-11 p-0">
                                {{ Form::text('title', $item->title ?? '', ['class' => 'form-control', 'required', 'autofocus']) }}
                                @if ($errors->has('title'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="col-lg-12 form-group d-lg-flex align-items-center{{ $errors->has('remark') ? ' has-error' : '' }}">
                            <label for="remark" class="control-label col-lg-1 text-right">{{ __('item.remarks') }} </label>
                            <div class="col-lg-11 p-0">
                                <!-- <textarea name="description" class="form-control" required>{{old('remark')}}</textarea> -->
                                {{ Form::textarea('remark', $item->remark ?? '', ['class' => 'form-control', 'rows' => 5]) }}
                                @if ($errors->has('remark'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('remark') }}</strong>
                                    </span> 
                                @endif
                            </div>
                        </div>

                        <h5 class="text-dark text-left mb-4">{{ __('item.step') }}</h5>
                        <div class="row payment-list" style="padding-left: 20px;">
                                <div class="row timeline-item" style="width: 100%;margin-bottom: 10px">
                                    {{-- <div class="col-lg-3">{{ __('item.duration_type') }}</div>
                                    <div class="col-lg-4">{{ __('item.duration') }}</div>
                                    <div class="col-lg-4">{{ __('item.amount_in_percentage') }}</div> --}}
                                </div>
                                @if(isset($item) && $item->paymentTimelineDetails->count())
                                    @foreach($item->paymentTimelineDetails as $key => $value)
                                        <div class="row timeline-item" style="width: 100%;">
                                            <div class="col-lg-3 form-group {{ $errors->has('duration_type') ? ' has-error' : '' }}">
                                                {{ Form::select('duration_type_[]', $duration_type ?? [], $value->duration_type, ['class' => 'form-control duration_type'])}}
                                            </div>

                                            <div class="col-lg-4 form-group {{ $errors->has('duration') ? ' has-error' : '' }}">
                                                {{ Form::number('duration_[]', $value->duration ?? '', ['class' => 'form-control duration']) }}
                                            </div>

                                            <div class="col-lg-4 form-group{{ $errors->has('amount_to_pay_percentage') ? ' has-error' : '' }}">
                                                <div class="input-group">
                                                    {{ Form::number('amount_to_pay_percentage_[]', $value->amount_to_pay_percentage ?? '', ['class' => 'form-control amount_to_pay_percentage', 'autofocus']) }}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                 </div>
                                            </div>

                                            @if($key == 0)
                                                <div class="col-lg-1">
                                                    <a href="javascript:;" class="btn btn-success btn-sm add-payment-detail-item">{{ __('item.add') }}</a>
                                                </div>
                                            @else
                                                <div class="col-lg-1"><i class="fa fa-remove text-danger" style="cursor:pointer;"></i></div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row timeline-item" style="width: 100%;">
                                        <div class="col-lg-3 form-group {{ $errors->has('duration_type') ? ' has-error' : '' }}">
                                            <label for="duration_type" class="control-label">{{ __('item.duration_type') }} </label>

                                            {{ Form::select('duration_type_[]', $duration_type ?? [], '', ['class' => 'form-control duration_type'])}}
                                            @if ($errors->has('duration_type'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('duration_type') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-4 form-group {{ $errors->has('duration') ? ' has-error' : '' }}">
                                            <label for="duration" class="control-label">{{ __('item.duration') }} </label>
                                            {{ Form::number('duration_[]', $item->duration ?? '', ['class' => 'form-control duration']) }}
                                            @if ($errors->has('duration'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('duration') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-4 form-group{{ $errors->has('amount_to_pay_percentage') ? ' has-error' : '' }}">
                                            <label for="amount_to_pay_percentage" class="control-label">{{ __('item.amount_in_percentage') }} </label>

                                            {{ Form::number('amount_to_pay_percentage_[]', $item->amount_to_pay_percentage ?? '', ['class' => 'form-control amount_to_pay_percentage', 'autofocus']) }}
                                            @if ($errors->has('amount_to_pay_percentage'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('amount_to_pay_percentage') }}</strong>
                                                </span>
                                            @endif

                                        </div>
                                        <div class="col-lg-1">
                                            <a href="javascript:;" class="btn btn-success btn-sm add-payment-detail-item" style="margin-top: 32px;">{{ __('item.add') }}</a>
                                        </div>
                                    </div>
                                @endif
                        </div>

                    <!-- Submit Form -->
                    <div class="col-lg-12">
                        <a href="{{ route('payment-timeline.index') }}" class="action btn-sm pr-2 btn btn-danger" title="View Detail">{{ __('item.back') }}</a>
                        <input type="submit" value="{{ __('item.save') }}" name="btnSave" class="btn btn-sm btn-primary float-right">
                    </div>
                <!-- </form> -->
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

            $('.add-payment-detail-item').on('click', function() {
                var html = '<div class="row timeline-item" style="width: 100%;"><div class="col-lg-3 form-group ">';
                    html += '<select class="form-control duration_type" name="duration_type_[]"><option value="1">Days</option><option value="2">Week</option><option value="3">Month</option></select>';
                    html += '</div>';
                    html += '<div class="col-lg-4 form-group ">';
                    html += '<input class="form-control duration" name="duration_[]" type="number" value="">'; 
                    html += '</div>';
                    html += '<div class="col-lg-4 form-group">';
                    html += ' <div class="input-group"><input class="form-control amount_to_pay_percentage" autofocus="" name="amount_to_pay_percentage_[]" type="number" value=""><div class="input-group-append"><span class="input-group-text">%</span></div></div>';
                    html += '</div>';
                    html += '<div class="col-lg-1"><i class="fa fa-remove text-danger" style="cursor:pointer;"></i></div></div>';

                $('.payment-list').append(html);
            });

            $(document).on('click', '.fa-remove', function(){
                $(this).closest('.timeline-item').remove();
            });

        }); 
    </script>
@stop