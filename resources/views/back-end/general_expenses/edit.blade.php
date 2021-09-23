@extends('back-end/master')
@section('title',"Edit Expense")
@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/bootstrap-fileinput-4.4.7.css')}}">
    
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.expense') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.edit_expense') }}</a></li>
            </ul>
        </div>
        <div class="col-lg-12">
            @include('flash/message')
            <div class="panel-body bg-white rounded overflow_hidden p-4">
                <h3 class="text-dark mb-4">{{ __('item.edit_expense') }}</h3><hr/>

                <form action="{{ route('general_expense.edit',['id'=>$general_expense->id]) }}" method="POST" class="row form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-lg-3 col-md-2"></div>
                    <div class=" col-lg-6 col-md-8 col-sm-12">
                        <div class="row">
                            <div class="col-md-12 form-group d-lg-flex align-items-center{{ $errors->has('date') ? ' has-error' : '' }}">
                                <label for="date" class="control-label col-lg-3 p-0">{{ __('item.date') }}<span class="required">*</span> </label>
                                <div class="col-lg-9 p-0">
                                    <input type="text" name="date" class="form-control demoDate" value="{{ $general_expense->date }}" id="date" required >
                                    @if ($errors->has('date'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>

                            <!-- First name -->
                            <div class="col-md-12 form-group d-lg-flex align-items-center{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="control-label col-lg-3 p-0">{{ __('item.title') }}<span class="required">*</span> </label>
                                <div class="col-lg-9 p-0">
                                    <input type="text" name="title" class="form-control" value="{{$general_expense->title}}" required autofocus>
                                    @if ($errors->has('title'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 form-group d-lg-flex align-items-center{{ $errors->has('group') ? ' has-error' : '' }}">
                                <label for="group" class="control-label col-lg-3 p-0">{{ __('item.type') }}<span class="required">*</span> </label>
                                <div class="col-lg-9 p-0">
                                    <select name="group" id="group" class="form-control" required>
                                        <option value>-- {{__('item.select')}} {{__('item.type')}} --</option>
                                        @foreach($expense_groups as $group)
                                            <option value="{{ $group->id }}"
                                                @if ($general_expense->group_id == $group->id)
                                                selected="selected"
                                                @endif
                                            >{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('group'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('group') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 form-group d-lg-flex align-items-center{{ $errors->has('project') ? ' has-error' : '' }}">
                                <label for="project" class="control-label col-lg-3 p-0">{{ __('item.project') }}<span class="required">*</span> </label>
                                <div class="col-lg-9 p-0">
                                    <select name="project" id="project" class="form-control">
                                        <option value>-- {{__('item.select')}} {{__('item.project')}} --</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}"
                                                @if ($general_expense->project_id == $project->id)
                                                selected="selected"
                                                @endif
                                            >{{ $project->property_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('project'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('project') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group d-lg-flex align-items-center{{ $errors->has('employee') ? ' has-error' : '' }}">
                                <label for="employee" class="control-label col-lg-3 p-0">{{ __('item.employee') }}</label>
                                <div class="col-lg-9 p-0">
                                    <select name="employee" id="employee" class="form-control">
                                        <option value>-- {{__('item.select')}} {{__('item.employee')}} --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                @if ($general_expense->employee_id == $employee->id)
                                                selected="selected"
                                                @endif
                                            >{{ $employee->first_name.' '.$employee->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('employee'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('employee') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 form-group d-lg-flex align-items-center{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="control-label col-lg-3 p-0">{{ __('item.amount') }} ($)<span class="required">*</span> </label>
                                <div class="col-lg-9 p-0">
                                    <input type="text" id="amount" name="amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" min="0" value="{{$general_expense->amount*1}}" required>
                                    @if ($errors->has('amount'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 form-group d-lg-flex align-items-center{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label col-lg-3 p-0">{{ __('item.description') }}</label>
                                <div class="col-lg-9 p-0">
                                    <textarea rows="3" name="description" class="form-control" >{{$general_expense->description}}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Form -->
                    <div class="col-lg-12">
                        <input type="submit" value="{{ __('item.save') }}" name="btnSave" class="btn btn-primary float-right">
                    </div>
                </form>
            </div>
        </div>

    </main>


@stop

@section('script')
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7.js')}}"></script>
    <script src="{{URL::asset('back-end/js/plugins/bootstrap-fileinput-4.4.7-fa-theme.js')}}"></script>
    <script src="{{URL::asset('back-end/js/initFileInput.js')}}"></script>
    <script type="text/javascript" src="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="https://pratikborsadiya.in/vali-admin/js/plugins/bootstrap-datepicker.min.js">
    <script type="text/javascript">
        $('#project, #group, #employee').select2();
        $(document).ready(function() {
            $('input').attr( "autocomplete", "off" );
            $('.demoDate').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true
            });
        }); 

        $(document).on('change', '#employee', function(){
            var employee = $('#employee option:selected').val();
            if(!employee || employee==0){
                return 0;
            }
            $.ajax({
                type:'get',
                url: '{{ route("general_expense.get_employee_salary") }}',
                data:{employee:employee},
                success:function(data){
                    $('#amount').val(data.salary);
                }
            })
        });
    </script>
@stop