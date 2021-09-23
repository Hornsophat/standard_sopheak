@extends('back-end/master')
@section('style')


@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.project') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.view_project') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>{{ __('item.project_detail') }}</h5>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a class="btn btn-sm btn-info" href="{{ URL::to('project/' . $item->id . '/edit') }}" style="padding-bottom: 10px;">
                                        &nbsp;<i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <br/>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="width: 250px;">{{ trans('item.project_name') }}</td>
                                            <td>{{ $item->property_name }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ trans('item.address_street') }}</td>
                                            <td>{{ $item->address_street }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('item.address_number') }}</td>
                                            <td>{{ $item->address_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('item.ground_surface') }}</td>
                                            <td>{{ $item->ground_surface }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row" >
                                    @foreach($images as $image)
                                        <div class="col-lg-2" id="image_{{ $image->id }}" style="margin-bottom: 10px;">
                                            <i class="fa fa-remove remove-image" onclick="removeImage({{$image->id }})"></i>
                                            <img class="img-thumbnail imagepop" style="height:120px;" src="{{ asset($image->path) }}">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>{{ __('item.sale_commission') }}</h5>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>{{ __('item.no') }}</th>
                                                <th>{{ __('item.sale_type') }}</th>
                                                <th>{{ __('item.commission') }}(%)</th>
                                                <th>{{ __('item.status') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(is_null($item->sale_commission))
                                                <tr>
                                                    <td colspan="5" class="text-center">No Found!</td>
                                                </tr>
                                            @else

                                                @foreach($item->sale_commission as $key=>$value)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ !is_null($value->saleType)?$value->saleType->name:"" }}</td>
                                                        <td>{{ $value->commission ." %" }}</td>
                                                        <td>{!! $value->status ==1 ? "<span class='badge badge-info'>active</span>" : "<span class='badge badge-danger'>Inactive</span>" !!}</td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>{{ __('item.zone') }}</h5>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <th>{{ __('item.no') }}#</th>
                                            <th>{{ __('item.name') }}</th>
                                            <th>{{ __('item.code') }}</th>
                                            <th>{{ __('item.created_on') }}</th>
                                            <th>{{ __('item.updated_on') }}</th>
                                            </thead>
                                            <tbody>

                                            @foreach($item->projectZone as $key => $value)
                                                <tr>
                                                    <td>{{ $value->id }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->code }}</td>
                                                    <td>{{ $value->created_at }}</td>
                                                    <td>{{ $value->updated_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <h5>{{ __('item.property') }}</h5>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <th>{{ __('item.no') }}#</th>
                                            <th>{{ __('item.name') }}</th>
                                            <th>{{ __('item.property_no') }}</th>
                                            <th>{{ __('item.zone') }}</th>
                                            <th>{{ __('item.status') }}</th>
                                            <th>{{ __('item.created_on') }}</th>
                                            <th>{{ __('item.updated_on') }}</th>
                                            </thead>
                                            <tbody>

                                            @foreach($properties as $key => $value)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $value->property_name }}</td>
                                                    <td>{{ $value->property_no }}</td>
                                                    <td>{{ $value->zone_name }}</td>
                                                    <td>{!! $value->status == 1 ? "<span class='badge badge-primary'>Available</span>" : "<span class='badge badge-danger'>Sold</span>" !!}</td>
                                                    <td>{{ $value->created_at }}</td>
                                                    <td>{{ $value->updated_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <h5 style="margin-top: 50px"><u>{{ __('item.project_expense') }}</u></h5>

                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        @if(session()->has('error'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('error') }}
                                            </div>
                                        @endif


                                        <form action="{{ url("expense/store",$item->id ) }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>{{ __('item.expense_type') }}<span class="required"> *</span> </label>
                                                        <select name="expense_type" class="form-control expense_type" required>
                                                            <option value="" {{ old("expense_type")==""?"selected":"" }}>Please Select</option>
                                                            <option value="1" {{ old("expense_type")==1?"selected":"" }}>Material</option>
                                                            <option value="2" {{ old("expense_type")==2?"selected":"" }}>Employee</option>

                                                        </select>
                                                        @if ($errors->has('expense_type'))
                                                            <div class="error">{{ $errors->first('expense_type') }}</div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>{{ __('item.item') }}<span class="required"> *</span></label>
                                                        <select name="item" class="form-control item" required >
                                                            <option value="">Please Select</option>
                                                        </select>
                                                        @if ($errors->has('item'))
                                                            <div class="error">{{ $errors->first('item') }}</div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>{{ __('item.duration_qty') }}</label>
                                                        <div class="input-group">
                                                            <input type="number" name="duration_qty" class="form-control" value="{{ old("duration_qty") }}" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ __('item.hour_unit') }}</span>
                                                            </div>

                                                        </div>
                                                        @if ($errors->has('duration_qty'))
                                                            <div class="error">{{ $errors->first('duration_qty') }}</div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>{{ __('item.amount_to_spend') }}<span class="required"> *</span></label>
                                                        <input type="number" name="amount" class="form-control" value="{{ old("amount") }}" required/>
                                                        @if ($errors->has('amount'))
                                                            <div class="error">{{ $errors->first('amount') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>{{ __('item.remarks') }}</label>
                                                        <textarea class="form-control" name="remark"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <input type="submit" class="btn btn-primary" value="{{ __('item.submit') }}" />
                                            </div>
                                        </form>
                                    </div> --}}
                                    <?php

                                    $expense = $item->expense()->orderBy("id","desc")->paginate(20);
                                    ?>
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead>
                                            <th>{{ __('item.for') }}</th>
                                            <th>{{ __('item.item') }}</th>
                                            <th>{{ __('item.duration_qty') }}</th>
                                            <th>{{ __('item.price') }}</th>
                                            <th>{{ __('item.remarks') }}</th>
                                            </thead>
                                            <tbody>
                                            @if(!empty($item->expense))
                                                @foreach($expense as $key => $value)
                                                    <tr>
                                                        <td><span class="label label-danger"> {{ expense_type($value->expense_type) }}</span></td>
                                                        <td>
                                                            <a href="{{ $value->expense_type == 1 ? url("product/'.$value->material->id.'/view") : url("product/".$value->employee->id."/view") }} ">
                                                                {{ ($value->expense_type) == "1" ? $value->material->name : $value->employee->first_name.' '.$value->employee->last_name}}
                                                            </a>
                                                        </td>
                                                        <td><span class="badge badge-danger">
                                                                {{ ($value->expense_type) == "1" ? ($value->qty > 0?$value->qty .' unit':"N/A"): ($value->working_duration >0?$value->working_duration." hour":"N/A")}}
                                                            </span></td>
                                                        <td>{{ "$ ".$value->amount }}</td>
                                                        <td>{{ $value->remark }}</td>
                                                    </tr>

                                                @endforeach
                                            @endif

                                            <tr>
                                                <td colspan="3" class="text-right">
                                                    {{ __('item.total_for_material') }}:<br/>
                                                    {{ __('item.total_for_employee') }}:<br/>
                                                    {{ __('item.total_expense') }}:
                                                </td>

                                                <td colspan="2">
                                                    <b>{{ $item->expense()->where("expense_type",1)->sum("qty"). " unit = ".  "$ ". number_format((float)$item->expense()->where("expense_type",1)->sum("amount"), 2, '.', '')}}</b><br/>
                                                    <b>{{ (int)$item->expense()->where("expense_type",2)->sum("working_duration"). " hour = "."$ ". number_format((float)$item->expense()->where("expense_type",2)->sum("amount"), 2, '.', '') }}</b><br/>
                                                    <b>{{ "$ ".number_format((float)$item->expense->sum("amount"), 2, '.', '') }}</b>
                                                </td>
                                            </tr>
                                            </tbody>

                                        </table>
                                        <div class="pull-right">
                                            {!! $expense->render() !!}
                                        </div>

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

    <script type="text/javascript">
        $(document).ready(function () {

            var form_data = new FormData

            $(".expense_type").change(function(){
                $.ajax({
                    url: "{{ url("expense/get-item") }}/"+$(".expense_type").val(),
                    type: "GET",
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function(response) {
                        $(".item").html(response)
                    },
                    error:function(error){
                        console.log(error);
                        return;

                    }
                });
            });


        })

        function removeImage(id) {
            if(confirm('Are you sure you want to remove this image?')) {
                $.ajax({
                    url: '{{ url('/project/delete/image') }}/'+id,
                    type: 'GET',
                    success: function(response) {
                        $("#image_"+id).remove();
                    },
                    error: function() {
                        alert("Cannot remove image!")
                    }
                });
            }
        }
    </script>
@stop