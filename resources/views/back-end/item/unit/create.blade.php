@extends('back-end/master')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
<main class="app-content">
	<div class="app-title">
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="{{ route('productList') }}">{{ __('item.product') }}</a></li>
			<li class="breadcrumb-item"><a href="{{ route('product.units') }}">{{ __('item.list_unit') }}</a></li>
			<li class="breadcrumb-item active"><a href="#">{{ __('item.new_unit') }}</a></li>
		</ul>
	</div>

	<div class="tile">
		<div class="tile-body">

			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default">
						<h3>{{ __('item.add_unit') }}</h3><hr/>
						<div class="panel-body">
							@if (Session::has('message'))
							<div class="alert alert-info">{{ Session::get('message') }}</div>
							@endif

							{!! Form::open(array(route('product.unit.create'), 'files' => true)) !!}

							<div class="form-group">
							{!! Form::label('name', trans('item.name'))."<span class='star'> *</span>" !!}
							{!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
								@if ($errors->has('name'))
									<span class="help-block text-danger">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
								{!! Form::label('description', trans('item.description')) !!}
								{!! Form::textarea('description', Input::old('description'), array('class' => 'form-control')) !!}
							</div>
							{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary pull-right')) !!}

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
	<script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
	<script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
	<script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            callFileInput('#avatar', 1, 5120, ["jpg" , "jpeg" , "png"]);
        });
	</script>
@stop