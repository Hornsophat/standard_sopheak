@extends('back-end/master')
@section('style')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
@stop
@section('content')
<main class="app-content">
	<div class="app-title">
		<ul class="app-breadcrumb breadcrumb side">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item">{{ __('item.product') }}</li>
			<li class="breadcrumb-item active"><a href="#">{{ __('item.create_product') }}</a></li>
		</ul>
	</div>

	<div class="tile">
		<div class="tile-body">

			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default">
						<h3>{{ __('item.add_product') }}</h3><hr/>
						<div class="panel-body">
							@if (Session::has('message'))
							<div class="alert alert-info">{{ Session::get('message') }}</div>
							@endif
							{!! Html::ul($errors->all()) !!}

							{!! Form::open(array('url' => 'product/create', 'files' => true)) !!}

							<div class="form-group">
							{!! Form::label('item_name', trans('item.item_name'))."<span class='star'> *</span>" !!}
							{!! Form::text('item_name', Input::old('item_name'), array('class' => 'form-control')) !!}
								@if ($errors->has('item_name'))
									<span class="help-block text-danger">
										<strong>{{ $errors->first('item_name') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
							{!! Form::label('category', 'Category')."<span class='star'> *</span>" !!}
							{!! Form::select('category', $categories, null, array('class' => 'form-control')) !!}
								@if ($errors->has('category'))
									<span class="help-block text-danger">
										<strong>{{ $errors->first('category') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
							{!! Form::label('unit', 'Unit')."<span class='star'> *</span>" !!}
							{!! Form::select('unit', $units, null, array('class' => 'form-control')) !!}
								@if ($errors->has('unit'))
									<span class="help-block text-danger">
										<strong>{{ $errors->first('unit') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
							{!! Form::label('size', trans('item.size')) !!}
							{!! Form::text('size', Input::old('size'), array('class' => 'form-control')) !!}
							@if ($errors->has('size'))
								<span class="help-block text-danger">
									<strong>{{ $errors->first('size') }}</strong>
								</span>
							@endif
							</div>



							<div class="col-lg-6 form-group 	 align-items-center{{ $errors->has('avatar') ? ' has-error' : '' }}">
								<label for="avatar" class="control-label">{{ __('item.thumbnail') }} : </label><br/>
								<div class="">
									<input id="avatar" type="file" name="avatar" class="form-control" value="{{old('avatar')}}" accept=".jpg,.jpeg,.png">
									@if ($errors->has('avatar'))
										<span class="help-block text-danger">
											<strong>{{ $errors->first('avatar') }}</strong>
										</span>
									@endif
								</div>
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