@extends('back-end.master')
@section('title',"No Permission")
@section('content')

<main class="app-content">
        <div class="tile">
            <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a class="btn btn-small btn-warning" href="javascript:;">{{__("Warning")}}</a><div class="clearfix">&nbsp;</div>
                                    <div class="alert alert-warning alert-dismissible">
										<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
										<h4><i class="icon fa fa-warning"></i> {{__("No Permission!")}}</h4>
										{{__("Sorry, You don't have permission to access this module!!")}}
									</div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</main>


@stop


