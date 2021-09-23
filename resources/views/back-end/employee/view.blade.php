@extends('back-end/master')
@section('title',"List Customer")
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.employee') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.view_employee') }}</a></li>
            </ul>
        </div>

        {{-- List Customer --}}
        <div class="row">
            <div class="col-md-12">
                @include('flash/message')

                <div class="tile">
                    <div class="tile-body table-responsive">
                        {{-- @dd($employee) --}}
                        <a href="{{ route('editEmployee', $employee->id)}}" class="btn btn-small btn-success">{{ __('item.edit_employee') }}</a>
                        <hr/>

                        <table class="table table-hover table-nowrap">
                            <tr>
                                <td>{{ __('item.profile') }}</td>
                                <td>
                                    @php
                                        $url = asset('/images/default/no_image.png');
                                        if($employee->profile != null && file_exists(public_path($employee->profile)))
                                            $url = asset('public'.$employee->profile);
                                    @endphp
                                    <img src="{{ $url }}" onerror="this.src='/images/default/no_image.png';" alt="Missing Image" width="150px"/>

                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('item.first_name') }}</td>
                                <td>{{ $employee->first_name }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('item.last_name') }}</td>
                                <td>{{ $employee->last_name }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.id_card') }}</td>
                                <td>{{ $employee->id_card }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.position') }}</td>
                                <td>{{ !is_null($employee->position)?$employee->position->title:"" }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.department') }}</td>
                                <td>{{ !is_null($employee->department)?$employee->department->title:"" }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.salary') }}</td>
                                <td>{{ "$ ".$employee->salary }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.age') }}</td>
                                <td>{{ $employee->age }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.sex') }}</td>
                                <td>{{ gender($employee->sex) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.identity_number') }}</td>
                                <td>{{ $employee->identity }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.country') }}</td>
                                <td>{{ !is_null($employee->countries)?$employee->countries->name:"" }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.nationality') }}</td>
                                <td>{{ $employee->nationality }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.phone1') }}</td>
                                <td>{{ $employee->phone1 }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.phone2') }}</td>
                                <td>{{ $employee->phone2 }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.email') }}</td>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.fax') }}</td>
                                <td>{{ $employee->fax }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.dob') }}</td>
                                <td>{{ date('d-F-Y', strtotime($employee->dob)) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.pob') }}</td>
                                <td>
                                    {{ isset($employee->pobProvince->province_kh_name)?$employee->pobProvince->province_kh_name:'' }},
                                    {{ isset($employee->pobDistrict->district_namekh)?$employee->pobDistrict->district_namekh:'' }},
                                    {{ isset($employee->pobCommune->commune_namekh)?$employee->pobCommune->commune_namekh:'' }},
                                    {{ isset($employee->pobVillage->village_namekh)?$employee->pobVillage->village_namekh:'' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('item.address') }}</td>
                                <td>
                                    {{ isset($employee->eProvince->province_kh_name)?$employee->eProvince->province_kh_name:'' }},
                                    {{ isset($employee->eDistrict->district_namekh)?$employee->eDistrict->district_namekh:'' }},
                                    {{ isset($employee->eCommune->commune_namekh)?$employee->eCommune->commune_namekh:'' }},
                                    {{ isset($employee->eVillage->village_namekh)?$employee->eVillage->village_namekh:'' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
