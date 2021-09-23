@extends('back-end/master')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
<style>
	.file-drop-zone{
		overflow: hidden;
	}
	.file-drop-zone img{
		object-fit: cover;
	}
</style>
<main class="app-content">
	<div class="app-title">
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="{{ route('productList') }}">{{ __('item.product') }}</a></li>
			<li class="breadcrumb-item"><a href="{{ route('product.units') }}">{{ __('item.list_unit') }}</a></li>
			<li class="breadcrumb-item active"><a href="#">{{ __('item.edit_unit') }}</a></li>
		</ul>
	</div>

	<div class="tile">
		<div class="tile-body">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<h3>{{ __('item.edit_unit') }}</h3><hr/>
						<div class="panel-body">
							{!! Form::model($unit, array('route' => array('product.unit.edit', $unit->id))) !!}

							<div class="form-group">
							{!! Form::label('name', trans('item.name'))."<span class='star'> *</span>"  !!}
							{!! Form::text('name', null, array('class' => 'form-control')) !!}
							@if ($errors->has('name'))
								<span class="help-block text-danger">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
							</div>
							<div class="form-group">
								{!! Form::label('description', trans('item.description')) !!}
								{!! Form::textarea('description', null, array('class' => 'form-control')) !!}
								@if ($errors->has('description'))
								<span class="help-block text-danger">
									<strong>{{ $errors->first('description') }}</strong>
								</span>
							@endif
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