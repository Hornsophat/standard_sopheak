@extends('back-end/master')
@section('title',"Dashboard")
@section('content')

  <main class="app-content">
    <!-- Title & Breadcrumb -->
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">@yield('title')</a></li>
        </ul>
    </div>
    <!-- End Title & Breadcrumb -->

    <!-- Report -->
    <div class="box">
    <div class="box-header">
        <h2 style="font-size:20px;margin-top:10px"><i style="font-size:20px" class="fa fa-dashboard"> </i> Dashboard​ / ទំព័រដើម</h2>
    </div>
    <div class="box-content">
    <div class="row">
      <div class="col-md-6 col-lg-3">
      <a href="{{ URL::to('users')}}" class="btn btn-small ">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-2x"></i>
          <div class="info">
            <h4>{{ __('item.user') }}</h4>
            <p><b>{{ $users->count() }}</b></p>
          </div>
        </div>
        </a>
      </div>
        <div class="col-md-6 col-lg-4">
        <a href="{{ URL::to('customer')}}" class="btn btn-small ">
            <div class="widget-small warning coloured-icon"><i class="icon fa fa-user fa-3x"></i>
                <div class="info">
                    <h4>{{ __('item.customer') }}</h4>
                    <p><b>{{ $customers }}</b></p>
                </div>
            </div>
            </a>
        </div>

      <div class="col-md-6 col-lg-3">
      <a href="{{ URL::to('payment_stages')}}" class="btn btn-small ">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-usd fa-3x"></i>
          <div class="info">
            <h4>{{ __('item.payment_stage') }}</h4>
            <p><b>{{   $payment_stages }}</b></p>
          </div>
        </div>
        </a>
      </div>

      <div class="col-md-6 col-lg-4">
      <a href="{{ URL::to('property')}}" class="btn btn-small" >
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-university fa-3x"></i>
          <div class="info">
            <h4>{{ __('item.property') }}</h4>
            <p><b>{{ $property->count() }}</b></p>
          </div>
        </div>
        </a>
      </div>
    </div>
   </div>
   </div> 

    
    <!-- End Report -->
    @if($isAdministrator)
    <div class="row" >
        <div class="col-md-12">
        <div class="tile">
              <div class="tile-body" style="display:none">

                    <ul class="app-breadcrumb breadcrumb side">
                        <li class="breadcrumb-item">Cancel Payment</li>
                        {{-- <li><a class="ml-3" href="{{ route('send_mail') }}">Send Mail</a></li> --}}
                    </ul>
                    <br>
                <div class="table-responsive">
                <table class="table table-hover table-bordered table-nowrap">
                          <thead>
                              <tr>
                                <th width="70" class="text-center">{{ __('item.no') }}</th>
                                <th class="text-center">Request Date</th>
                                <th class="text-center">Payment Reference</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Reqeust By</th>
                                <th class="text-center">{{ __('item.function') }}</th>
                              </tr>
                          </thead>
                          <tbody>

                            @foreach ($approve_cancel_payments as $approve)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $approve->request_date }}</td>
                                    <td class="text-center">{{ $approve->reference }}</td>
                                    <td>{{ $approve->customer_name }}</td>
                                    <td class="text-right">${{ $approve->amount }}</td>
                                    <td>{{ $approve->reqeust_by }}</td>
                                    <td class="text-center">
                                        <a href="#" class="action btn btn-danger btn-sm" onclick="cancel_approve_cancel_payment({{ $approve->approve_id }})" title="cancel">Cancel</a>
                                        <a href="#" class="action btn btn-success btn-sm" onclick="approve_cancel_payment({{ $approve->payment_id }}, {{ $approve->approve_id }})" title="approve">Approve</a>
                                    </td>
                                </tr>
                        @endforeach
                      </tbody>
                   </table>
                </div>
                <div class="row">
                     <div class="col-md-12" style="overflow: auto;">
                        <div class="pull-right">
                            {{-- {{ $items->links() }} --}}
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    @endif
    <div class="box">
    <div class="box-header">
        <h2 style="font-size:20px;margin-top:10px"><i style="font-size:20px" class="fa fa-money"> </i> Loan Type / ប្រភេទនៃការបង់រំលស់</h2>
    </div>
    <div class="row" style = "margin-bottom:20px;">
    <center>
    <a href="{{ URL::to('loan_view/flat rate')}}" class="btn btn-small " >
      <div class="col-md-6 col-lg-3">   
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-money fa-3x"></i>
            <div class="info">
              <h4>{{ __('item.loan_type_simple') }}</h4>
              <p><b>{{ $loan_simple }}</b></p>
            </div>
          </div>
        </div>
    </a>
      
    <a href="{{ URL::to('loan_view/eoc')}}" class="btn btn-small " >
      <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-money fa-3x"></i>
            <div class="info">
              <h4>{{ __('item.loan_type_eoc') }}</h4>
              <p><b>{{ $loan_eoc }}</b></p>
            </div>
          </div>
        </div>
    </a>

    <a href="{{ URL::to('loan_view/emi')}}" class="btn btn-small " >
      <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-money fa-3x"></i>
            <div class="info">
              <h4>{{ __('item.loan_type_emi') }}</h4>
              <p><b>{{ $loan_emi }}</b></p>
            </div>
          </div>
        </div>
    </a>

    <a href="{{ URL::to('loan_view/free_interest')}}" class="btn btn-small " >
      <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-money fa-3x"></i>
            <div class="info">
              <h4>{{ __('item.free_interest') }}</h4>
              <p><b>{{ $loan_free }}</b></p>
            </div>
          </div>
        </div>
    </a>
    </center>
    </div>
    </div>
    </div>
    <div class="box">
    <div class="box-header">
        <h2 style="font-size:20px;margin-top:10px"><i style="font-size:20px" class="fa fa-user"> </i> Customer Pay / បញ្ជីអតិថិជនដែលត្រូវបង់ប្រាក់</h2>
    </div> 
  <div class="row">
    <div class="col-md-12">
    <div class="tile">
          <div class="tile-body">

                <ul class="app-breadcrumb breadcrumb side">
                    <li class="breadcrumb-item">{{ __('item.customer_list_to_pay') }}</li>
                </ul>
                <br>
            <div class="table-responsive​​​ ">
            <table class="table table-hover table-bordered table-nowrap">
                      <thead>
                          <tr>
                            <th width="70" class="text-center">{{ __('item.no') }}</th>
                            <th class="text-center">{{ __('អតិថិជន') }}</th>
                            <th class="text-center">{{ __('item.property') }}</th>
                            <th class="text-center">{{ __('item.loan_date') }}</th>
                            <th class="text-center">{{ __('item.payment_date') }}</th>
                            <td class="text-center">{{ __('item.amount_to_spend') }}</td>
                            <th class="text-center">{{ __('item.function') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($items as $item)
                          <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->customer_name }}</td>
                            <td>{{ $item->property_name }}</td>
                            <td class="text-center">{{ $item->loan_date }}</td>
                            <td class="text-center">{{ $item->payment_date }}</td>
                            <td>${{ $item->amount }}</td>
                            <td class="text-center">
                                @if(Auth::user()->can('view-sale') || $isAdministrator)
                                    <a href="{{ route('sale_property.loan_payment', ['payment_schedule'=>$item->id]) }}" class="action btn btn-danger btn-sm" title="pay"><i class="fa fa-money"></i> {{ __('item.payment') }}</a>
                                @endif
                            </td>
                    </tr>
                    @endforeach
                  </tbody>
               </table>
            </div>
           </div>
           </div> 
           <div class="box">
    <div class="box-header">
        <h2 style="font-size:20px;margin-top:70px"><i style="font-size:20px" class="fa fa-report  fa-line-chart"> </i> Report / របាយការណ៍</h2>
    </div>
            <div class="row">
                 <div class="col-md-12" style="overflow: auto;">
                    <div class="pull-right">
                        {{-- {{ $items->links() }} --}}
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
  </div>

    <!-- Chart -->
    <div class="row">
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">{{ __('item.monthly_sale') }}</h3>
          <div class="embed-responsive embed-responsive-16by9">
            <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">{{ __('item.total') }} {{ __('item.sale') }}/{{ __('item.deposit') }}</h3>
          <div class="embed-responsive embed-responsive-16by9">
            <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>


    <div class="map" style="height: 500px !important;" id="map_out"></div>
    <div class="map" id="map_in"></div>
    <div style="text-align:center; margin-top: 15px;">
      <input type="hidden" class="btn btn-danger" id="clear_shapes" value="Clear Map" type="button"  />
      <input type="hidden" class="btn btn-primary" id="save_raw" type="button" />
      <input type="hidden" name="map_data" class="default-data" id="data" value='{{ $lat_lon }}' style="width:100%" readonly/>
      <input type="hidden" id="restore" value="restore(IO.OUT(array,map))" type="button" />
    </div>
  </main>
@stop

@section('script')
  <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ GOOGLE_MAP_API_KEY }}&libraries=drawing"></script> -->
  <script src="{{URL::asset('back-end/js/map.selector.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $("#map_out").show();

        setTimeout(function(){
            $("#restore").trigger("click");
        }, 1000);

    });
    var $chars_data =[];
    @foreach($output as $key=>$value)
         $chars_data.push({{ $value }});

        @endforeach

      var data = {
        labels: ["{{ __('month.anuary') }}", "{{ __('month.february') }}", "{{ __('month.march') }}", "{{ __('month.april') }}", "{{ __('month.may') }}", "{{ __('month.june') }}", "{{ __('month.july') }}", "{{ __('month.august') }}", "{{ __('month.september') }}", "{{ __('month.october') }}", "{{ __('month.november') }}", "{{ __('month.december') }}"],
        datasets: [
          {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: $chars_data
          }
        ]
      };
      var pdata = [
        {
          value: {{ $total_sale }},
          color: "#46BFBD",
          highlight: "#5AD3D1",
          label: "Sold"
        },
        {
          value: {{ $total_deposit }},
          color:"#F7464A",
          highlight: "#FF5A5E",
          label: "Deposit"
        }
      ] 
      
      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);
      
      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);

      if(document.location.hostname == 'pratikborsadiya.in') {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
      }

      function approve_cancel_payment(payment_transaction,approve){
            swal({
                title: "Cancel Payment",
                text: "Are you sure you want to approve?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(confirm) {
                if (confirm) {
                    $.ajax({
                        type:'get',
                        url:"{{ route('sale_property.cancel_loan_payment') }}",
                        data:{payment_transaction:payment_transaction, approve:approve},
                        success:function(data){
                            if(data.message==1){
                                swal({
                                    title: 'Successfully Cancel Payment',
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                                setTimeout(function(){
                                    location.reload();
                                },2500)
                            }
                            else{
                                swal({
                                    title: 'Failed Cancel Payment',
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                            }
                        },
                        error:function(errors){
                            swal({
                                title: 'Failed Cancel Payment',
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "{{ __('item.ok') }}",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            });
                        }
                    })
                }else{
                    swal({
                        title: '{{ __('item.stop') }}',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            });
        }

        function cancel_approve_cancel_payment(approve){
            swal({
                title: "Delete! Cancel Payment",
                text: "Are you sure you want to delete this request?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(confirm) {
                if (confirm) {
                    $.ajax({
                        type:'get',
                        url:"{{ route('sale_property.cancel_approve_cancel_payment') }}",
                        data:{approve:approve},
                        success:function(data){
                            if(data.message==1){
                                swal({
                                    title: 'Successfully',
                                    text:'Delete cancel payment',
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                                setTimeout(function(){
                                    location.reload();
                                },2500)
                            }
                            else{
                                swal({
                                    title: 'Failed',
                                    text:'Delete Cancel Payment',
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                            }
                        },
                        error:function(errors){
                            swal({
                                title: 'Failed',
                                text:'Delete Cancel Payment',
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "{{ __('item.ok') }}",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            });
                        }
                    })
                }else{
                    swal({
                        title: '{{ __('item.stop') }}',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            });
        }
    </script>
@stop