@extends('back-end/master')
@section('title',"List Penalty")
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.employee') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.penalty') }}</a></li>
            </ul>
        </div>

        {{-- List Customer --}}
        <div class="row">
            <div class="col-md-12">
                @include('flash/message')

                <div class="tile">
                    <div class="tile-body">
                        {{-- @dd($employee) --}}
                        <a href="{{ route('penalty.edit', ['penalty' => $penalty_group->id]) }}" class="btn btn-small btn-success">{{ __('item.edit') }}</a>
                        <hr/>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-hover table-nowrap">
                                    <tr>
                                        <td style="width: 100px">{{__('item.title')}}</td>
                                        <th>{{$penalty_group->title}}</th>
                                    </tr>
                                    <tr>
                                        <td>{{__('item.description')}}</td>
                                        <td>{{$penalty_group->description}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-8 table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Percet (%)</td>
                                            <td>Min Day</td>
                                            <td>Max Day</td>
                                            <td>Description</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penalties as $key => $penalty)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$penalty->percent*1}}</td>
                                                <td>{{$penalty->min_day*1}}</td>
                                                <td>{{$penalty->max_day*1}}</td>
                                                <td>{{$penalty->description}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                di
            </div>
        </div>
    </main>
@stop
