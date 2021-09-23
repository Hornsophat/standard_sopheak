@extends('back-end/master')
@section('title',"View Supplyer")
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.supplier') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.view_supplier') }}</a></li>
            </ul>
        </div>

        {{-- List Customer --}}
        <div class="row">
            <div class="col-md-12">
                @include('flash/message')

                <div class="tile">
                    <div class="tile-body">
                        <a href="{{ route('supplyer.edit', $supplyer->id)}}" class="btn btn-small btn-success">{{ __('item.edit_supplier') }}</a>
                        <hr/>

                        <table class="table table-hover">
                            <tr>
                                <td>{{ __('item.profile') }}</td>
                                <td>
                                    @php
                                        $url = asset('/images/default/no_image.png');
                                        if($supplyer->profile_pic != null && file_exists(public_path($supplyer->profile_pic)))
                                            $url = asset('public'.$supplyer->profile_pic);
                                    @endphp
                                    <img src="{{ $url }}" alt="Missing Image" width="150px"/>

                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('item.first_name') }}</td>
                                <td>{{ $supplyer->firstname }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('item.last_name') }}</td>
                                <td>{{ $supplyer->lastname }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.age') }}</td>
                                <td>{{ $supplyer->age }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.sex') }}</td>
                                <td>{{ $supplyer->sex }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.country') }}</td>
                                <td>{{ !is_null($supplyer->countries)?$supplyer->countries->name:"" }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.nationality') }}</td>
                                <td>{{ $supplyer->nationality }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.phone1') }}</td>
                                <td>{{ $supplyer->phone1 }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.phone2') }}</td>
                                <td>{{ $supplyer->phone2 }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.email') }}</td>
                                <td>{{ $supplyer->email }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.fax') }}</td>
                                <td>{{ $supplyer->fax }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.dob') }}</td>
                                <td>{{ date('d-F-Y', strtotime($supplyer->dob)) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.pob') }}</td>
                                <td>
                                    {{ isset($supplyer->pobProvince->province_kh_name)?$supplyer->pobProvince->province_kh_name:'' }},
                                    {{ isset($supplyer->pobDistrict->district_namekh)?$supplyer->pobDistrict->district_namekh:'' }},
                                    {{ isset($supplyer->pobCommune->commune_namekh)?$supplyer->pobCommune->commune_namekh:'' }},
                                    {{ isset($supplyer->pobVillage->village_namekh)?$supplyer->pobVillage->village_namekh:'' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('item.address') }}</td>
                                <td>
                                    {{ isset($supplyer->eProvince->province_kh_name)?$supplyer->eProvince->province_kh_name:'' }},
                                    {{ isset($supplyer->eDistrict->district_namekh)?$supplyer->eDistrict->district_namekh:'' }},
                                    {{ isset($supplyer->eCommune->commune_namekh)?$supplyer->eCommune->commune_namekh:'' }},
                                    {{ isset($supplyer->eVillage->village_namekh)?$supplyer->eVillage->village_namekh:'' }}
                                </td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
