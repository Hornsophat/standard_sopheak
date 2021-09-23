@extends('back-end/master')
@section('title',"List Customer")
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.customer') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.view_customer') }}</a></li>
            </ul>
        </div>

        {{-- List Customer --}}
        <div class="row">
            <div class="col-md-12">
                @include('flash/message')

                <div class="tile">
                    <div class="tile-body">
                        <a href="{{ route('editCustomer', $customer->id)}}" class="btn btn-small btn-success">{{ __('item.edit_customer') }}</a>
                        <hr/>

                        <table class="table table-hover">
                            <tr>
                                <td>{{ __('item.profile') }}</td>
                                <td>
                                    @php
                                        $url = asset('/images/default/no_image.png');
                                        if($customer->profile != null && file_exists(public_path($customer->profile)))
                                            $url = asset('public'.$customer->profile);
                                    @endphp
                                    <img src="{{ $url }}"  alt="Missing Image" width="150px"/>

                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('item.id') }}</td>
                                <td>{{ $customer->customer_no }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.first_name') }} (Kh)</td>
                                <td>{{ $customer->first_name }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('item.last_name') }} (Kh)</td>
                                <td>{{ $customer->last_name }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.first_name') }} (En)</td>
                                <td>{{ $customer->first_name_en }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('item.last_name') }} (En)</td>
                                <td>{{ $customer->last_name_en }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.age') }}</td>
                                <td>{{ $customer->age }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.sex') }}</td>
                                <td>{{ gender($customer->sex) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.identity_number') }}</td>
                                <td>{{ $customer->identity }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.identity_set_date') }}</td>
                                <td>{{ date('d-m-Y', strtotime($customer->identity_set_date)) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.country') }}</td>
                                <td>{{ !is_null($customer->countries)?$customer->countries->name:"" }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.nationality') }}</td>
                                <td>{{ $customer->nationality }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.phone1') }}</td>
                                <td>{{ $customer->phone1 }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.phone2') }}</td>
                                <td>{{ $customer->phone2 }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.email') }}</td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('តួនាទី') }}</td>
                                <td>{{ $customer->fax }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.dob') }}</td>
                                <td>{{ $customer->dob }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('item.pob') }}</td>
                                <td>
                                    {{ isset($customer->pobProvince->province_kh_name)?$customer->pobProvince->province_kh_name:'' }},
                                    {{ isset($customer->pobDistrict->district_namekh)?$customer->pobDistrict->district_namekh:'' }},
                                    {{ isset($customer->pobCommune->commune_namekh)?$customer->pobCommune->commune_namekh:'' }},
                                    {{ isset($customer->pobVillage->village_namekh)?$customer->pobVillage->village_namekh:'' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('item.address') }}</td>
                                <td>
                                    {{ isset($customer->eProvince->province_kh_name)?$customer->eProvince->province_kh_name:'' }},
                                    {{ isset($customer->eDistrict->district_namekh)?$customer->eDistrict->district_namekh:'' }},
                                    {{ isset($customer->eCommune->commune_namekh)?$customer->eCommune->commune_namekh:'' }},
                                    {{ isset($customer->eVillage->village_namekh)?$customer->eVillage->village_namekh:'' }}
                                </td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
