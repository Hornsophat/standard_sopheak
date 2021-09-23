@extends('back-end/master')
@section('style')
    <style type="text/css">
        .table th, .table td{
            padding: 0.30rem!important;
        }
    </style>
@stop
@section('content')
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">{{ __('item.property') }}</li>
                <li class="breadcrumb-item active"><a href="#">{{ __('item.view_property') }}</a></li>
            </ul>
        </div>
        <div class="tile">
            <div class="tile-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <h3>{{ __('item.property_detail') }}</h3><hr/>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.property_name') }}</td>
                                                <td>{{ $item->property_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px;">{{ trans('item.property_no') }}</td>
                                                <td>{{ $item->property_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.project_name') }}</td>
                                                <td>{{ $item->project->property_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.project_zone') }}</td>
                                                <td>{{ $item->projectZone->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.property_type') }}</td>
                                                <td>{{ $item->propertyType->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.status') }}</td>
                                                <td>
                                                    @if($item->status==1)
                                                    {{ __('item.available') }}
                                                    @elseif($item->status==2)
                                                    {{ __('item.sold') }}
                                                    @elseif($item->status==3)
                                                    {{ __('item.booked') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.price') }}</td>
                                                <td>{{ $item->property_price*1 }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.discount') }}</td>
                                                <td>{{ $item->property_discount_amount*1 }}</td>
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
                                                <td>{{ trans('item.zipcode') }}</td>
                                                <td>{{ $item->address_zip_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.bedroom') }}</td>
                                                <td>{{ $item->bed_rooms }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.bathroom') }}</td>
                                                <td>{{ $item->bathrooms }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.other_room') }}</td>
                                                <td>{{ $item->other_room }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.elevator') }}</td>
                                                <td>{{ $item->has_elevator == 1 ? 'Yes' : 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.basement') }}</td>
                                                <td>{{ $item->has_basement == 1 ? 'Yes' : 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.swimming_pool') }}</td>
                                                <td>{{ $item->has_swimming_pool == 1 ? 'Yes' : 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.living_room_surface') }}</td>
                                                <td>{{ $item->living_room_surface }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.built_up_surface') }}</td>
                                                <td>{{ $item->built_up_surface }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.habitable_surface') }}</td>
                                                <td>{{ $item->habitable_surface }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.ground_surface') }}</td>
                                                <td>{{ $item->ground_surface }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.year_of_construction') }}</td>
                                                <td>{{ $item->year_of_construction }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.year_of_renovation') }}</td>
                                                <td>{{ $item->year_of_renovation }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.floor_number') }}</td>
                                                <td>{{ $item->floor_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('item.total_number_of_floors_building') }}</td>
                                                <td>{{ $item->total_number_of_floors_building }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ trans('item.boundaries') }}</th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>&emsp;{{ trans('item.boundary_east') }}</td>
                                                <td>{{ $item->boundary_east }}</td>
                                            </tr>
                                            <tr>
                                                <td>&emsp;{{ trans('item.boundary_west') }}</td>
                                                <td>{{ $item->boundary_west }}</td>
                                            </tr>
                                            <tr>
                                                <td>&emsp;{{ trans('item.boundary_north') }}</td>
                                                <td>{{ $item->boundary_north }}</td>
                                            </tr>
                                            <tr>
                                                <td>&emsp;{{ trans('item.boundary_south') }}</td>
                                                <td>{{ $item->boundary_south }}</td>
                                            </tr>
                                            @if($abouts)
                                            <tr>
                                                <th>{{ trans('item.abouts') }}</th>
                                                <td></td>
                                            </tr>
                                            @endif
                                            @foreach($abouts as $about)
                                            <tr>
                                                <td colspan="2">&emsp;{{ $about }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="map" style="height: 500px !important;" id="map_out"></div>
                                        <div class="map" id="map_in"></div>
                                        <div style="text-align:center; margin-top: 15px;">
                                            <input type="hidden" class="btn btn-danger" id="clear_shapes" value="Clear Map" type="button"  />
                                            <input type="hidden" class="btn btn-primary" id="save_raw" type="button" />
                                            <input type="hidden" name="map_data" class="default-data" id="data" value='{{ $item->map_data }}' style="width:100%" readonly/>
                                            <input type="hidden" id="restore" value="restore(IO.OUT(array,map))" type="button" />
                                        </div>



                                    </div>
                                </div>
                                <div class="row" >
                                    @foreach($images as $image)
                                        <div class="col-lg-2" id="image_{{ $image->id }}" style="margin-bottom: 10px;">
                                            <i class="fa fa-remove remove-image" onclick="removeImage({{$image->id }})"></i>
                                            <img class="img-thumbnail imagepop" style="height:120px;" src="{{ asset('public'.$image->path) }}">
                                        </div>
                                    @endforeach
                                </div>


                                <hr/>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <a class="btn btn-small btn-info" href="{{ URL::to('property/' . $item->id . '/edit') }}">{{trans('item.edit')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{--popup image--}}
    <div class="popup-image" style="display: none">
        <i class="fa fa-remove close-popup"></i>
        <img src=""/>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script>
    <script src="{{URL::asset('back-end/js/map.selector.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var isMapData = {{ ($item->map_data != "" && $item->map_data != "[]") ? 1 : 0 }};
            if(isMapData) {
                $("#map_out, #change_map, #cancel_map").show();
            }else {
                $("#map_out, #change_map, #cancel_map").hide();
            }

            setTimeout(function(){
                console.log("asdas");
                $("#restore").trigger("click");
            }, 1000);

            /* Image popup */
            $(document).on('click', '.imagepop', function(){
               var src = $(this).attr('src');
               $('.popup-image').fadeIn(350).find("img").attr("src", src);
            });

            /* close popup */
            $(document).on('click', '.popup-image', function(){
                $('.popup-image').fadeOut(250).find("img").attr("src", "");
            });
            $(document).keyup(function(e) {
                if (e.keyCode == 27) { // escape key maps to keycode `27`
                    $('.popup-image').fadeOut(250).find("img").attr("src", "");
                }
            });
        });

        function removeImage(id) {
            if(confirm('Are you sure you want to remove this image?')) {
                $.ajax({
                    url: '{{ url('/property/delete/image') }}/'+id,
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