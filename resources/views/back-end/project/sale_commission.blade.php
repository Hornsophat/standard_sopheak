@extends('back-end/master')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.project') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.sale_commission') }}</a></li>
            </ul>
        </div>

        @include('flash/message')
        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route("storeCommission", request()->route('project_id')) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="commission_id" value="{{ old("commission_id") }}"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="sale_type">{{ __('item.sale_type') }}</label>
                                        <select class="form-control" id="sale_type" name="sale_type" required>
                                            <option value="">-- Select --</option>
                                            @foreach($sale_type as $key => $value)
                                                <option value="{{ $value->id }}" {{ old("sale_type") == $value->id?"selected":"" }}>{{ $value->name }}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="commission">{{ __('item.commission') }}(%)</label>
                                        <div class="input-group">
                                            <input type="number" name="commission" value="{{ old("commission") }}" id="commission" class="form-control" min="1" max="100" required/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="{{ __('item.submit') }}" class="btn btn-primary pull-right"/>
                        </form>

                    </div>
                    <div class="col-md-6">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('item.no') }}</th>
                                    <th>{{ __('item.sale_type') }}</th>
                                    <th>{{ __('item.commission') }}(%)</th>
                                    <th>{{ __('item.status') }}</th>
                                    <th>{{ __('item.function') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($commission->count() <=0)
                                <tr>
                                    <td colspan="5" class="text-center">No Found!</td>
                                </tr>
                                @else

                                @foreach($commission as $key=>$value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ !is_null($value->saleType)?$value->saleType->name:"" }}</td>
                                        <td>{{ $value->commission ." %" }}</td>
                                        <td>{!! $value->status ==1 ? "<span class='badge badge-info'>active</span>" : "<span class='badge badge-danger'>Inactive</span>" !!}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info edit_commission" id="{{ $value->id }}" commission="{{ $value->commission }}" sale_type="{{ $value->sale_type }}">{{ __('item.edit') }}</a>
                                            <a href="{{ URL::to("project/commission/".$value->id."/".($value->status == 1 ? 2:1)."/changeStatus")}}" class="btn btn-sm {{ $value->status ==1?"btn-warning": "btn-primary"}}">{{ $value->status ==1? Lang::get('item.deactivate') :Lang::get('item.active') }}</a>
                                            <a  onclick="return confirm('Are you sure you want to delete this item?');" href="{{ URL::to('project/commission/'. $value->id .'/delete' ) }}" class="btn btn-sm btn-danger">{{ __('item.delete') }}</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function(){
            $(".edit_commission").click(function(){

                $("input[name=commission]").val($(this).attr("commission"));
                $("input[name=commission_id]").val($(this).attr("id"));
                $("#sale_type").val($(this).attr("sale_type")).trigger("change");
            });
        })
    </script>
@stop