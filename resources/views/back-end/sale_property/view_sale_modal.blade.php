
    <div class="modal fade bd-example-modal-lg" id="loanScheduleModal" tabindex="-1" role="dialog" aria-labelledby="loanScheduleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loanScheduleModalLabel">{{ __('item.payment_schedule') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead class="badge-primary">
                                <tr>
                                    <th>{{ __('item.no') }}</th>
                                    <th>{{ __('item.date') }}</th>
                                    <th>{{ __('item.number_of_days_to_penalty') }}</th>
                                    <th>{{ __('item.currency') }}</th>
                                    <th class="text-center">{{ __("item.balance") }}</th>
                                      <th>{{ __("item.late_paid") }}</th>
                                    <th>{{ __("item.total_amount_to_be_paid") }}</th>
                                    <th>{{ __("item.interest_amount") }}</th>
                                    <th>{{ __('item.amount') }}</th>
                                    <th>{{ __('item.total_amount') }}</th>
                                    <th>{{ __('item.principle_balance') }}</th>
                                    <th class="text-center">{{ __("item.amount_paid") }}</th>
                                    <th>{{ __('item.payment_status') }}</th>
                                    <th class="text-center">{{ __('item.function') }}</th>
                                </tr>
                            </thead>
                            <tbody id="contentloanScheduleModal" style="height: 90%; overflow-y: auto;">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                    {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="contractModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document" style="max-width: 860px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contractModalLabel">{{ __('item.contract') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contractContentModal" style="position: relative; margin:auto; padding:5px; width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                    {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document" style="max-width: 950px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">{{ __('item.schedule') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="scheduleContentModal" style="position: relative; min-height: 800px; margin:auto;padding:5px;width:100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                    {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">{{ __('item.payment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead class="badge-primary">
                                <tr>
                                    <th>{{ __('item.no') }}</th>
                                    <th>{{ __('item.code') }}</th>
                                    <th>{{ __('item.date') }}</th>
                                    <th>{{ __('item.amount') }}</th>
                                    <th>{{ __('item.function') }}</th>
                                </tr>
                            </thead>
                            <tbody id="contentPaymentModal">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                    {{-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeAddressModal" tabindex="-1" role="dialog" aria-labelledby="changeAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeAddressModalLabel">Change Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="min-height: 300px;">
                    <form action="{{ route('sale_item.change_address') }}" method="POST" id="frmChangeAddress" enctype="multipart/form-data" accept-charset="UTF-8">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="sale_item_id" value="{{ $sale->id }}">
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead class="badge-primary">
                                    <tr>
                                        <th></th>
                                        <th>{{ __('item.province') }}</th>
                                        <th>{{ __('item.district') }}</th>
                                        <th>{{ __('item.commune') }}</th>
                                        <th>{{ __('item.village') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="contentchangeAddressModal">
                                    @if(!empty($land))
                                        @php
                                            $land_province = $land->eProvince;
                                            $land_district = $land->eDistrict;
                                            $land_commune =  $land->eCommune;
                                            $land_village =  $land->eVillage;
                                        @endphp
                                        <tr>
                                            <td><input type="radio" name="other_address" value="" @if(is_null($sale->land_address_id)) checked @endif></td>
                                            <td>
                                                @if(!empty($land_province))
                                                    {{ $land_province->province_kh_name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($land_district))
                                                {{ $land_district->district_namekh }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($land_commune))
                                                {{ $land_commune->commune_namekh }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($land_village))
                                                {{ $land_village->village_namekh }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($land_address!==[])
                                        @foreach($land_address as $address)
                                            <tr>
                                                <td><input type="radio" name="other_address" value={{ $address->id }} @if(!is_null($sale->land_address_id) && $sale->land_address_id==$address->id) checked @endif></td>
                                                <td>{{ $address->province_name }}</td>
                                                <td>{{ $address->district_name }}</td>
                                                <td>{{ $address->commune_name }}</td>
                                                <td>{{ $address->village_name }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="changeAddress()">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="changePartnerModal" tabindex="-1" role="dialog" aria-labelledby="changePartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePartnerModalLabel">Change Partner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contentChangePartnerModal" style="min-height: 300px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('item.close') }}</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="changePartner()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
