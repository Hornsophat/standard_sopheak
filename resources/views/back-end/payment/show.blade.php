@extends('back-end/master')
@section('title',"Payment Detail")
@section('style')

    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')

	<main class="app-content">
		<div class="app-title">
	        <ul class="app-breadcrumb breadcrumb side">
	          	<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
	          	<li class="breadcrumb-item">{{ __('item.payment') }} </li>
	          	<li class="breadcrumb-item active"><a href="#">{{ __('item.payment_details') }}</a></li>
	        </ul>
      	</div>
        <div class="col-lg-12">
            @include('flash/message')
          	<div class="panel-body bg-white rounded overflow_hidden p-4" style="min-height: 500px;">
          		<h4 class="text-dark text-left mb-4">{{ __('item.payment_details') }}</h4>
                    {!! Form::input('hidden','id', $item->id??'') !!}
                    {{ csrf_field() }}
                    
                    <table border="0" cellpadding="5" cellspacing="0" style="margin-left: 10px; margin-bottom: 50px;">
                        <tr>
                            <td>{{ __('item.title') }}: {{$item->title ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('item.remarks') }}: {{$item->remark ?? ''}}</td>
                        </tr>
                    </table>

                    <div class="clearfix">&nbsp;</div>
                    <div class="rows">
                        <ol>
                            @if($item->paymentTimelineDetails->count())
                                @foreach($item->paymentTimelineDetails as $value)
                                    @if($value->duration_type == '1')
                                        @php $type = 'Days'; @endphp
                                    @elseif($value->duration_type == '2')
                                        @php $type = 'Weeks'; @endphp
                                    @elseif($value->duration_type == '3')
                                        @php $type = 'Months'; @endphp
                                    @else
                                        @php $type = ''; @endphp
                                    @endif


                                    @php $label = $value->amount_to_pay_percentage . '%'; @endphp

                                    <?php
                                        $width = 100 / ($item->paymentTimelineDetails->count() != 0?$item->paymentTimelineDetails->count():1);
                                    ?>
                                        <li class="payment_timeline" style="width: {{$width}}%!important;">
                                            <p class="diplome">{{ $label }}</p>
                                            <span class="point"></span>
                                            <p class="description">
                                                {{ $value->duration . ' '. $type }}
                                            </p>
                                        </li>


                                @endforeach
                            @endif
                        </ol>
                    </div>
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
        }); 
    </script>
@stop