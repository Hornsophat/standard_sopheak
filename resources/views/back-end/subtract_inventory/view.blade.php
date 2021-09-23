@extends('back-end/master')
@section('title',"Subtract Inventory Details")
@section('content')
<style type="text/css">
    table tr th, table tr td{
        white-space: nowrap;
    }
    .view-detail:hover{
        cursor: pointer;
    }
</style>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.subtract_inventory') }}</li>
                <li class="breadcrumb-item"><a href="{{ route("subtract_inventories") }}">{{ __('item.list_subtract_inventory') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.subtract_inventory_details') }}</a></li>
            </ul>
        </div>
    <div class="tile">
        <div class="tile-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('flash/message')
                        <div class="panel panel-default">
                            <div class="panel-body">
                             <div class="row">
                                 <div class="col-md-12" align="center">
                                    <h4>{{ __('item.subtract_inventory_details') }}</h4>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <table width="100%">
                                        <tr>
                                            <th style="font-size: 14px;">{{ __('item.date') }} : {{ date('d-F-Y', strtotime($subtract_inventory->created_at)) }}</th>
                                            <th style="font-size: 14px;" class="text-right">{{ __('item.subtracter') }} : {{ ucwords($subtract_inventory->created_name) }}</th>
                                        </tr>
                                    </table>
                                </div>
                             </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td>{{ __('item.no') }}</td>
                                            <td>{{ __('item.name') }}</td>
                                            <td>{{ __('item.quantity') }}</td>
                                            <td>{{ __('item.quantity_received') }}</td>
                                            <td>{{ __('item.total_cost') }}</td>
                                            <td>{{ __('item.status') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subtract_inventory_details as $key => $value)
                                        <tr class="view-detail" title="click for show item">
                                            <td class="text-right">{{ ++$key }} <input type="hidden" class="hidden-material" value="{{ $value->material_id }}"></td>
                                            <td>{{ ucwords($value->material_name) }}</td>
                                            <td class="text-right">{{ $value->quantity }}</td>
                                            <td class="text-right">{{ $value->quantity_subtracted }}</td>
                                            <td class="text-right">{{ number_format($value->total_cost,2) }}</td>
                                            <td class="text-center">
                                                @if($value->status=='received')
                                                    <span class="badge badge-success">{{ $value->status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $value->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if(Auth::user()->can('receive-subtract-inventory') || $isAdministrator && $subtract_inventory->status!='received')
                                        <a class="btn btn-sm btn-success pull-right" onclick="return confirm('Are you sure you want to receive this item?');" href="{{ route('subtract_inventory.receive', ['id'=>$subtract_inventory->id]) }}">{{ __('item.receive') }}</a>
                                    @endif
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
    $(document).on('click', 'body .view-detail', function(){
        var eThis = $(this);
        var material = eThis.find('.hidden-material').val();
        $.ajax({
            type:'get',
            url:'{{ route("subtract_inventory.view_subtract_from_inventory") }}',
            data:{product:material, sub:'{{ $subtract_inventory->id }}'},
            contentType:false,
            dataType:'html',
            success:function(data){
                eThis.after(data);
                eThis.removeAttr('title');
                eThis.removeClass('view-detail');
                eThis.addClass('remove-tr');
            },
            error:function(error){
                alert('Falied Selection!!!');
            }
        });
    });
    $(document).on('click', 'body .remove-tr', function(){
        var eThis = $(this);
        eThis.next().remove();
        eThis.removeClass('remove-tr');
        eThis.addClass('view-detail');
    });
</script>
@endsection
