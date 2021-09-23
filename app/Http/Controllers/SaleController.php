<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Sale;
use App\Model\Customer;
use App\Model\Project;
use App\Model\Land;
use App\Model\ProjectZone;
use App\Model\Property;
use App\Model\PropertyType;
use App\Model\PaymentTimeline;
use App\Model\PaymentTimelineDetail;
use App\Model\Employee;
use App\Model\SaleCommission;
use App\Http\Requests\SaleRequest;
use App\Model\SaleDetail;
use Session, Auth;
use App\Model\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Helpers\AppHelper;
use DB;
class SaleController extends Controller
{
    function __construct(Customer $customer, Sale $sale, Property $property, PaymentTimelineDetail $paymentTimelineDetail, PaymentTimeline $paymentTimeline, Employee $employee, SaleDetail $saleDetail, Payment $payment) {
        $this->middleware('auth');
        $this->customer = $customer;
        $this->sale = $sale;
        $this->property = $property;
        $this->paymentTimelineDetail = $paymentTimelineDetail;
        $this->paymentTimeline = $paymentTimeline;
        $this->employee = $employee;
        $this->saleDetail = $saleDetail;
        $this->payment = $payment;
    }
    public function index(Request $request)
    {
        $status = "";
        $search = "";
        if(!Auth::user()->can('list-sale') && !AppHelper::checkAdministrator())
            return view('back-endcommonno-permission');
        if($request->filter_status && !empty($request->filter_status)){
            $status = $request->filter_status;
        }
        if($request->search && !empty($request->search)){
            $search = $request->search;
        }
        $items = $this->sale;
        if(!empty($status)){
            $items = $items->where('status', '=', $status);
        }
        if(!empty($search)){
            $items = $items->where(function ($query) use($search) {
                $query->where('id',      'like',     '%'.$search.'%');
                $query->orWhere('total_price',      'like',     '%'.$search.'%');
                $query->orWhere('total_sale_commission',      'like',     '%'.$search.'%');
                $query->orWhere('total_discount',      'like',     '%'.$search.'%');
                $query->orWhere('grand_total',      'like',     '%'.$search.'%');
                $query->orWhere('deposit',      'like',     '%'.$search.'%');
                $query->orWhere('remark',      'like',     '%'.$search.'%');
            });
        }
        $items = $items->sortable()->orderby('id', 'DESC')->paginate(20);
        return view('back-end.sale.index', compact('items'))->withInput(Input::all());
    }
    public function create(Request $request)
    {
        if(!Auth::user()->can('create-sale') && !AppHelper::checkAdministrator())
            return view('back-endcommonno-permission');
        $url = route("salestore");
        
        if($request->deposit) {
            $no = 'yes';
        }
        $select_one = ['' => '-- Select --'];
        $project_list = $select_one + Project::where("item_type", 2)->pluck('property_name', 'id')->toArray();
        $project_zone_list = ProjectZone::pluck('name', 'id');
        $property_list = [];
        $property_type_list = PropertyType::where("id", ">", 2)->pluck('name', 'id')->toArray();
        $payment_list = $select_one + $this->paymentTimeline->pluck('title', 'id')->toArray();
        $customer_list = $select_one + $this->customer
                                            ->select(\DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')
                                            ->pluck('name', 'id')
                                            ->toArray();
        $employee_list = $select_one + $this->employee
                                            ->select(\DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')
                                            ->where("deleted", 0)
                                            ->pluck('name', 'id')->toArray();
        $data = compact('customer_list', 'property_list', 'project_list', 'project_zone_list', 'property_type_list', 'payment_list', 'employee_list', 'url', 'check_deposite');
        return view('back-end.sale.form', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request)
    {
        if(!Auth::user()->can('create-sale') && !AppHelper::checkAdministrator())
            return view('back-endcommonno-permission');
        // return $request->all();
        $deposit = $request->get('check_deposite', 'no');
        $customer_id = $request->get('customer_id');
        $employee_id = $request->get('employee_id');
        $payment_id = $request->get('payment_id');
        $grand_total = $request->get('total_price', 0);
        $sale_date = Date('Y-m-d H:s:i');
        $sale = $this->sale->create([
            'customer_id' => $customer_id, 
            'deposit' => $request->get('deposit'),
            'employee_id' => $employee_id,
            'grand_total' => $grand_total, 
            'remark' => '', 
            'payment_timeline_id' => $payment_id,
            'sale_date' => $sale_date,
            'total_discount' => $request->latest_discount_value,
            'total_price' => $request->total_price + $request->latest_discount_value +  $request->deposit,
            // 'total_sale_commission' => $request->get('sale_total_commission', 0),
            'total_sale_commission' => 0,
            'status' => $deposit == 'yes' ? 1 : null,
            'deposit' => $request->deposit
        ]);
        $employee_a = Employee::find($employee_id);
        $em_sale_type=0;
        if($employee_a){
            $em_sale_type= $employee_a->sale_type;
        }
        $this_sale_total_commission=0; // Sum amount all commission project property in this sale
        $property_array = $request->get('property_id', []);
        $sale_detail_data = [];
        if($sale) {
            foreach ($property_array as $key => $property_id) {
                $sale_detail_data = [
                    'sale_id' => $sale->id,
                    'item_id' => $request->property_id[$key],
                    'price' => $request->price[$key],
                    'qty' => $request->quantity[$key],
                    'amount' => $request->price[$key] * $request->quantity[$key],
                    'discount' => $request->sub_discount_value[$key],//TODO: allow user to enter % of discount for each item on sale form
                    // 'sale_commission' => $request->sub_commission_value[$key] * $request->sub_total_value[$key] / 100
                    'sale_commission' => 0
                ];
                $this->saleDetail->create($sale_detail_data);
                Property::where(['id' => $request->property_id[$key]])->update(['status' => 2]);
                $sale_com = SaleCommission::where([
                    ['project_id', '=', $request->project_ids[$key]],
                    ['sale_type', '=', $em_sale_type]
                ])->first();
                // Sum amount all commission project property in this sale
                if($sale_com){
                    $r_com = $sale_com->commission/100;
                    // $r_d = ($request->price[$key] * $request->quantity[$key])- $request->sub_discount_value[$key];
                    $r_d = ($request->price[$key] * $request->quantity[$key]);
                    $this_sale_total_commission += $r_com * $r_d;
                }
            }
            //===========================================
            
            //Total Price After Discount
            // $t_p_a_d = $request->total_price  +  $request->deposit;
            $t_p_a_d = $request->total_price  +  $request->deposit + $request->latest_discount_value;
            // 
            $d_tp = $request->deposit/$t_p_a_d;
            //Total commission deposit for this sale
            $t_c_f_depo = $this_sale_total_commission*$d_tp;
            //Total commission that customer debt (this commission from debt total_amount) 
            $t_c_f_dept = $this_sale_total_commission - $t_c_f_depo;
            //===========================================
            $sale->total_sale_commission += $t_c_f_depo;
            $sale->save();
            $this_payment_timeline = $this->paymentTimelineDetail->where('payment_timeline_id', $payment_id)->get();
            $status = 2;
            $_date = Date('Y-m-d H:s:i');
            if($deposit == 'yes') { $status = 1; $_date = null; }
            $d = 0;
            $date = date('Y-m-d');
            foreach ($this_payment_timeline as $key => $value) {
                if($value->duration_type == 1) {
                    $date = Carbon::parse($date)->addDay($value->duration);
                } elseif($value->duration_type == 2) { // Week
                    $date = Carbon::parse($date)->addWeeks($value->duration);
                } elseif($value->duration_type == 3) { //month
                    $date = Carbon::parse($date)->addMonths($value->duration);
                }
                $date = date('Y-m-d', strtotime($date));
                
                // THIS PAYMENT NOT COMPLETE TIMELINE
                Payment::create([
                    'payment_date' => $date,
                    'actual_payment_date' => null,
                    'sale_id' => $sale->id,
                    'amount_to_spend' => $grand_total * $value->amount_to_pay_percentage / 100,
                    'total_commission' => $t_c_f_dept * $value->amount_to_pay_percentage / 100,
                    'status' => 1
                ]);
            }
            
            Session::flash('message', 'You have successfully added item sale');
            return redirect(route('sale.index'));
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->can('view-sale') && !AppHelper::checkAdministrator())
            return view('back-endcommonno-permission');
        $sale = Sale::find($id);
        $debt_amount = Payment::select(DB::raw('SUM(paymentsamount_to_spend) as debt_amount'))
        ->where([
            ['sale_id', '=', $id],
            ['status', '=', 1]
        ])->groupBy('sale_id')->first();
        $debt_amount = isset($debt_amount->debt_amount)?$debt_amount->debt_amount:0;
        return view("back-end.sale.show", compact("sale", "debt_amount"));
    }
    public function payment($id)
    {
        if(!Auth::user()->can('view-payment') && !AppHelper::checkAdministrator())
            return view('back-endcommonno-permission');
        $sale = Sale::find($id);
        $debt_amount = Payment::select(DB::raw('SUM(paymentsamount_to_spend) as debt_amount'))
        ->where([
            ['sale_id', '=', $id],
            ['status', '=', 1]
        ])->groupBy('sale_id')->first();
        $debt_amount = isset($debt_amount->debt_amount)?$debt_amount->debt_amount:0;
        return view("back-end.sale.payment", compact("sale", "debt_amount"));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Sale::find($id);
        // return $item;
        $select_one = ['' => '-- Select --'];
        $project_list = $select_one + Project::where("item_type", 2)->where('status', 1)->pluck('property_name', 'id')->toArray();
        $project_zone_list = ProjectZone::pluck('name', 'id');
        $property_list = [];
        $property_type_list = PropertyType::where("id", ">", 2)->pluck('name', 'id')->toArray();
        $payment_list = $select_one + $this->paymentTimeline->pluck('title', 'id')->toArray();
        $customer_list = $select_one + $this->customer
                                            ->select(\DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')
                                            ->pluck('name', 'id')
                                            ->toArray();
        $employee_list = $select_one + $this->employee
                                            ->select(\DB::raw("CONCAT(first_name,' ',last_name) AS name"),'id')
                                            ->where("deleted", 0)
                                            ->pluck('name', 'id')->toArray();
        $payment_item = $this->paymentTimeline->find($item->payment_timeline_id);
        return view('back-end.sale.edit', compact('customer_list', 'property_list', 'project_list', 'project_zone_list', 'property_type_list', 'payment_list', 'employee_list', 'item', 'payment_item'));
    }
    public function update(Request $request, $id){}
    public function destroy($id){}
    public function getCustomerAjax($id)
    {
        $customer = $this->customer->find($id);
        return response()->json([
            'customer' => $customer ?? ''
        ]);
    }
    public function getProjectAjax($id, Request $request)
    {
        $employee_id = $request->get('employee_id');
        $employee = $this->employee->where("deleted", 0)->where('sale_type', '!=', null)->find($employee_id);
        $zones = ProjectZone::where('project_id', $id)->pluck('name', 'id');
        $project = Project::find($id);
        $sale_commission = 0;
        if($project && $employee) {
            $sale_commission = $project->sale_commission()
                                        ->where('project_id', $id)
                                        ->where('sale_type', $employee->sale_type)
                                        ->where('status', 1)
                                        ->first();
            if($sale_commission) {
                $sale_commission = $sale_commission;
            } else {
                $sale_commission = 0;
            }
        }
        
        return response()->json([
            'project' => $project ?? null,
            'zones' => $zones,
            'sale_commission' => $sale_commission
        ]);
    }
    public function getPropertyByZone($zone_id, Request $request)
    {
        $properties = $this->property->where('item_zone', $zone_id)->where('project_id', $request->project_id)->where('item_type' , '>',2)->where('status', 1)->pluck('property_name', 'id');
        if(!empty($properties)) {
            $properties = $properties;
        } else {
            $properties = 0;
        }
        return response()->json([
            'properties' => $properties
        ]);
    }
    public function getPaymentDetailAjax(Request $request,$id)
    {
        $total = $request->get('total', 0);
        $item = $this->paymentTimeline->find($id);
        if(!$item) {
            return response()->json([
                'status' => false,
                'error' => 'Payment not found!'
            ]);
        }
        $view = view('back-end.sale.payment_detail', compact('item', 'total'))->render();
        return response()->json([
            'view' => $view
        ]);
    }
    public function salePaymentPaid($id, Request $request)
    {
        $item = Payment::find($id);
        $item->update(['status' => 2, 'actual_payment_date' => Date('Y-m-d H:s:i')]);
        return response()->json([
            'status' => true,
            'message' => '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            <b><span>100%</span></b>
                                        </div>Payment successfully!'
        ]);
    }
    public function saleActaulPaymentDateAjay(Request $request)
    {
        $item = Payment::find($request->id);
        if($item->update(['actual_payment_date' => date('Y-m-d', strtotime($request->date)).' '.date('H:i:s', time())])) {
            return response()->json([
                'status' => true,
                'message' => '<i class="fa fa-check"></i>Save successfully!'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => '<i class="fa fa-close"></i>Something went wrong!'
        ]);
        
    }
    public function completeSale($id) {
        $sale = Sale::find($id);
        if($sale && $sale->payment && $sale->update(['status' => 2])) {
            $first_paid = $sale->payment()->where('sale_id', $id)->where('status', 1)->orderby('payment_date', 'asc')->first();
            if($first_paid) {
                return response()->json([
                    'status' => true,
                    'message' => '<i class="fa fa-check"></i>Save successfully!'
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => '<i class="fa fa-close"></i>Something went wrong!'
        ]);
    }
    public function cancelSale($id) {
        $sale = Sale::find($id);
        if($sale && $sale->update(['status' => 3])) {
            if($sale->salesDetail) {
                foreach ($sale->salesDetail as $key => $value) {
                    Property::where(['id' => $value->item_id])->update(['status' => 1]);
                }
                return response()->json([
                    'status' => true,
                    'message' => '<i class="fa fa-check"></i>Save successfully!'
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => '<i class="fa fa-close"></i>Something went wrong!'
        ]);
    }
    public function contract($id){
        $sale = DB::table('sale_items')
        ->select(DB::raw('
        sale_items. *,i.chile_merge as child_merge,
            prov.province_kh_name as prov_name,
            com.commune_namekh as com_kh,
            vil.village_namekh as vil_kh,
            dis.district_namekh as dis_kh,
            i.property_name as p_name,
            i.vehicle_quantity as p_vq,
            i.property_price as p_pp,
            i.vehicle_color as p_vihi,
            i.vehicle_quantity as p_quan,i.nb_machine as p_nb,i.vehicle_date as p_date,
            i.property_no as p_pn, 
            i.number_plate,
            i.owner_vehicle,
            i.model,
            i.property_name,
            i.village,
            i.commune,
            i.district,
            i.province,
            i.ground_surface as gf,
            i.boundary_north,
            i.boundary_south,
            i.boundary_east,
            i.boundary_west,
            i.date_property_no,
            CONCAT(cs.first_name," ",cs.last_name) as customer_name,
            cs.nationality as customer_nationality,
            cs.identity as customer_identity,
            cs.phone1,
            cs.phone2,
            cs.street_number,
            cs.dob as customer_date_of_birht,
            cs.pob as customer_place_of_birth,
            cs.house_number as cs_house_n,
            cs.identity_set_date as cs_ident,
            CONCAT(cs.phone1," ",cs.phone2) as customer_phone,
            cs.village as customer_village,
            cs.commune as customer_commune,
            cs.district as customer_district,
            cs.province as customer_province,
            IF(cs.sex="1", "ប្រុស", "ស្រី") as customer_gender,
            cs.email as customer_email,
            CONCAT(em.first_name," ",em.last_name) as employee_name,
            em.nationality as employee_nationality,
            em.dob as employee_date_of_birht,
            em.pob as employee_place_of_birth,
            CONCAT(em.phone1," ",em.phone2) as employee_phone,
            em.address as employee_address,
            IF(em.sex="1", "ប្រុស", "ស្រី") as employee_gender,
            em.email as employee_email
        '))
        ->where('sale_items.id', '=', $id)
        ->join('items as i', 'i.id', '=', 'sale_items.property_id')
        ->join('customers as cs', 'customer_id', '=', 'cs.id')
        ->join('provinces as prov', 'cs.province', '=', 'prov.province_id')
        ->join('communes as com', 'cs.commune', '=', 'com.com_id')
        ->join('villages as vil', 'cs.village', '=', 'vil.vill_id')
        ->join('districts as dis', 'cs.district', '=', 'dis.dis_id')
        ->join('employees as em', 'employee_id', '=', 'em.id')
        ->first();
       
        $properties = '';
        $sale_details =   [];
        // foreach ($sale_details as $key => $value) {
        //     if($key==0){
        //         $properties = $value->item_name;
        //     }else{
        //         $properties = $properties.','.$value->item_name;
        //     }
        // }
        if($sale){
            $property_type = '';
            $property_type_group ='';
            $property_type_extension='';
            $land=null;
            if($sale_details){
                $property_type = "D"->item_type_name;
                $property_type_group = "D"->item_type_group;
                $property_type_extension = "D"->item_type_extension;
                $project = Project::find("D"->item_project_id);
                if($project){
                    $land = Land::find($project->land_id);
                }   
            }
            $payments = Payment::where('sale_id', '=', $sale->id)->get();
            $loan = DB::table('loans')->where('sale_id',$sale->id)->first();

            //merge custom child
            $child_item = array();
            $string = $sale->child_merge;
            if($string!=""||$string!=null)
            {
                $splitter = ",";
                $child = explode($splitter, $string);
                //query data child item
                if($child!==[])
                {
                    $i = 0;
                    for($i=0;$i <= count($child)-1;$i++)
                    {
                        $query = DB::table('items')->where('id',$child[$i])->first();
                        $child_item[$i]=$query;
                    }
                }
            }
            
            return view('back-end.sale.contract', compact('sale','child_item','sale_details','property_type', 'property_type_group', 'property_type_extension', 'land', 'properties', 'payments','loan'));
        }
        else{
            return redirect()->back()->with('message', 'Not Found!');
        }
    }
    public function contractLand($id){
        $sale = DB::table('sale_items')
        ->select(DB::raw('
        sale_items. *,i.chile_merge as child_merge,
            prov.province_kh_name as prov_name,
            com.commune_namekh as com_kh,
            vil.village_namekh as vil_kh,
            dis.district_namekh as dis_kh,
            i.property_name as p_name,
            i.vehicle_quantity as p_vq,
            i.property_price as p_pp,
            i.vehicle_color as p_vihi,
            i.vehicle_quantity as p_quan,i.nb_machine as p_nb,i.vehicle_date as p_date,
            i.property_no as p_pn, 
            i.number_plate,
            i.owner_vehicle,
            i.about,
            i.model,
            i.property_name,
            i.village,
            i.commune,
            i.district,
            i.province,
            i.ground_surface as gf,
            i.land_num,
            i.boundary_north,
            i.product_first,
            i.product_second,
            i.product_third,
            i.product_four,
            i.product_five,
            i.boundary_south,
            i.boundary_east,
            i.boundary_west,
            i.width,
            i.length,
            i.address_number,
            i.address_street,
            i.date_property_no,
            CONCAT(cs.first_name," ",cs.last_name) as customer_name,
            cs.nationality as customer_nationality,
            cs.identity as customer_identity,
            cs.phone1,
            cs.phone2,
            cs.street_number,
            cs.dob as customer_date_of_birht,
            cs.pob as customer_place_of_birth,
            cs.house_number as cs_house_n,
            cs.identity_set_date as cs_ident,
            CONCAT(cs.phone1," ",cs.phone2) as customer_phone,
            cs.village as customer_village,
            cs.commune as customer_commune,
            cs.district as customer_district,
            cs.province as customer_province,
            re.amount,
            re.date_booked,
            IF(cs.sex="1", "ប្រុស", "ស្រី") as customer_gender,
            cs.email as customer_email,
            CONCAT(em.first_name," ",em.last_name) as employee_name,
            em.nationality as employee_nationality,
            em.dob as employee_date_of_birht,
            em.pob as employee_place_of_birth,
            CONCAT(em.phone1," ",em.phone2) as employee_phone,
            em.address as employee_address,
            IF(em.sex="1", "ប្រុស", "ស្រី") as employee_gender,
            em.email as employee_email
        '))
        ->where('sale_items.id', '=', $id)
        ->join('items as i', 'i.id', '=', 'sale_items.property_id')
        ->join('customers as cs', 'customer_id', '=', 'cs.id')
        ->join('provinces as prov', 'cs.province', '=', 'prov.province_id')
        ->join('communes as com', 'cs.commune', '=', 'com.com_id')
        ->join('villages as vil', 'cs.village', '=', 'vil.vill_id')
        ->join('districts as dis', 'cs.district', '=', 'dis.dis_id')
        ->join('employees as em', 'employee_id', '=', 'em.id')
        ->join('reservations as re' , 're.property_id', '=', 'sale_items.property_id')
        ->first();
       
        $properties = '';
        $sale_details =   [];
        // foreach ($sale_details as $key => $value) {
        //     if($key==0){
        //         $properties = $value->item_name;
        //     }else{
        //         $properties = $properties.','.$value->item_name;
        //     }
        // }
        if($sale){
            $property_type = '';
            $property_type_group ='';
            $property_type_extension='';
            $land=null;
            if($sale_details){
                $property_type = "D"->item_type_name;
                $property_type_group = "D"->item_type_group;
                $property_type_extension = "D"->item_type_extension;
                $project = Project::find("D"->item_project_id);
                if($project){
                    $land = Land::find($project->land_id);
                }   
            }
            $payments = Payment::where('sale_id', '=', $sale->id)->get();
            $loan = DB::table('loans')->where('sale_id',$sale->id)->first();
            $payment_schedule = DB::table('payment_schedules')->where('sale_id',$sale->id)->first();

            //merge custom child
            $child_item = array();
            $string = $sale->child_merge;
            if($string!=""||$string!=null)
            {
                $splitter = ",";
                $child = explode($splitter, $string);
                //query data child item
                if($child!==[])
                {
                    $i = 0;
                    for($i=0;$i <= count($child)-1;$i++)
                    {
                        $query = DB::table('items')->where('id',$child[$i])->first();
                        $child_item[$i]=$query;
                    }
                }
            }
            
            return view('back-end.sale.contractLand', compact('payment_schedule','sale','child_item','sale_details','property_type', 'property_type_group', 'property_type_extension', 'land', 'properties', 'payments','loan'));
        }
        else{
            return redirect()->back()->with('message', 'Not Found!');
        }
    }
    public function contractother($id){
        $sale = DB::table('sale_items')
        ->select(DB::raw('
        sale_items. *,i.chile_merge as child_merge,
            prov.province_kh_name as prov_name,
            com.commune_namekh as com_kh,
            vil.village_namekh as vil_kh,
            dis.district_namekh as dis_kh,
            i.property_name as p_name,
            i.vehicle_quantity as p_vq,
            i.property_price as p_pp,
            i.vehicle_color as p_vihi,
            i.vehicle_quantity as p_quan,i.nb_machine as p_nb,i.vehicle_date as p_date,
            i.property_no as p_pn, 
            i.number_plate,
            i.owner_vehicle,
            i.about,
            i.model,
            i.property_name,
            i.village,
            i.commune,
            i.district,
            i.province,
            i.ground_surface as gf,
            i.land_num,
            i.boundary_north,
            i.product_first,
            i.product_second,
            i.product_third,
            i.product_four,
            i.product_five,
            i.boundary_south,
            i.boundary_east,
            i.boundary_west,
            i.width,
            i.length,
            i.address_number,
            i.address_street,
            i.date_property_no,
            CONCAT(cs.last_name," ",cs.first_name) as customer_name,
            cs.nationality as customer_nationality,
            cs.identity as customer_identity,
            cs.phone1,
            cs.phone2,
            cs.street_number,
            cs.dob as customer_date_of_birht,
            cs.pob as customer_place_of_birth,
            cs.house_number as cs_house_n,
            cs.identity_set_date as cs_ident,
            CONCAT(cs.phone1," / ",cs.phone2) as customer_phone,
            cs.village as customer_village,
            cs.commune as customer_commune,
            cs.district as customer_district,
            cs.province as customer_province,
            IF(cs.sex="1", "ប្រុស", "ស្រី") as customer_gender,
            cs.email as customer_email,
            CONCAT(em.first_name," ",em.last_name) as employee_name,
            em.nationality as employee_nationality,
            em.dob as employee_date_of_birht,
            em.pob as employee_place_of_birth,
            CONCAT(em.phone1," ",em.phone2) as employee_phone,
            em.address as employee_address,
            IF(em.sex="1", "ប្រុស", "ស្រី") as employee_gender,
            em.email as employee_email,
            CONCAT(pn.last_name,"​ ",pn.first_name) as partner_name,
            IF(pn.sex="1", "ប្រុស", "ស្រី") as partner_gender,
            pn.dob as date_of_birth_partner,
            pn.pob as place_of_birth_partner,
            pn.nationality as partner_nationality,
            pn.identity as partner_identity,
            pn.phone1 as phone1_partner,
            pn.phone2 as phone2_partner,
            pn.street_number as partner_street_number,
            pn.house_number as pn_house_n,
            pn.identity_set_date as pn_identity_date,
            prov_pn.province_kh_name as partner_province,
            dis_pn.district_namekh as partner_district,
            com_pn.commune_namekh as partner_commune,
            vill_pn.village_namekh as partner_village
        '))
        ->where('sale_items.id', '=', $id)
        ->join('items as i', 'i.id', '=', 'sale_items.property_id')
        ->join('customers as cs', 'customer_id', '=', 'cs.id')
        ->join('provinces as prov', 'cs.province', '=', 'prov.province_id')
        ->join('communes as com', 'cs.commune', '=', 'com.com_id')
        ->join('villages as vil', 'cs.village', '=', 'vil.vill_id')
        ->join('districts as dis', 'cs.district', '=', 'dis.dis_id')
        ->join('employees as em', 'employee_id', '=', 'em.id')
        ->leftJoin('customers as pn', 'pn.id', '=', 'sale_items.customer_partner_id')
        ->leftJoin('provinces as prov_pn', 'prov_pn.province_id', '=', 'pn.province')
        ->leftJoin('districts as dis_pn', 'dis_pn.dis_id', '=', 'pn.district')
        ->leftJoin('communes as com_pn', 'com_pn.com_id', '=', 'pn.commune')
        ->leftJoin('villages as vill_pn', 'vill_pn.vill_id', '=', 'pn.village')
        ->first();
       
        $properties = '';
        $sale_details =   [];
        // foreach ($sale_details as $key => $value) {
        //     if($key==0){
        //         $properties = $value->item_name;
        //     }else{
        //         $properties = $properties.','.$value->item_name;
        //     }
        // }
        if($sale){
            $property_type = '';
            $property_type_group ='';
            $property_type_extension='';
            $land=null;
            if($sale_details){
                $property_type = "D"->item_type_name;
                $property_type_group = "D"->item_type_group;
                $property_type_extension = "D"->item_type_extension;
                $project = Project::find("D"->item_project_id);
                if($project){
                    $land = Land::find($project->land_id);
                }   
            }
            $payments = Payment::where('sale_id', '=', $sale->id)->get();
            $loan = DB::table('loans')->where('sale_id',$sale->id)->first();
            $loans = DB::table('loans')->where(array('sale_id'=>$sale->id,['status','!=',"cancel"]))->get();
            $payment_schedule = DB::table('payment_schedules')->where('sale_id',$sale->id)->first();

            //merge custom child
            $child_item = array();
            $string = $sale->child_merge;
            if($string!=""||$string!=null)
            {
                $splitter = ",";
                $child = explode($splitter, $string);
                //query data child item
                if($child!==[])
                {
                    $i = 0;
                    for($i=0;$i <= count($child)-1;$i++)
                    {
                        $query = DB::table('items')->where('id',$child[$i])->first();
                        $child_item[$i]=$query;
                    }
                }
            }
            
            return view('back-end.sale.contractother', compact('loans','sale','child_item','sale_details','property_type', 'property_type_group', 'property_type_extension', 'land', 'properties', 'payments','loan'));
        }
        else{
            return redirect()->back()->with('message', 'Not Found!');
        }
    }
    function receipt($sale_id,$id){
        $sale = Sale::find($sale_id);
        $payment = Payment::find($id);
        $debt_amount = Payment::select(DB::raw('SUM(paymentsamount_to_spend) as debt_amount'))
        ->where([
            ['sale_id', '=', $sale_id],
            ['status', '=', 1]
        ])->groupBy('sale_id')->first();
        $debt_amount = isset($debt_amount->debt_amount)?$debt_amount->debt_amount:0;
        return view('back-end.sale.receipt', compact('sale', 'payment', 'debt_amount'));
    }
    function invoice($id){
        $sale= Sale::find($id);
        if(!$sale)
            return redirect()->back()->with('message', 'not fount!');
        $customer = Customer::find($sale->customer_id);
        $payment_timeline = PaymentTimeline::find($sale->payment_timeline_id);
        $property_names = SaleDetail::where('sale_id', '=', $sale->id)
        ->select(DB::raw('
        COUNT(sale_id) AS num_pay,
        GROUP_CONCAT(itemsproperty_name) as property_names
        '))
        ->leftJoin('items', 'item_id', '=', 'itemsid')
        ->groupBy('sale_id')
        ->first();
        $property_names = isset($property_names->property_names)?$property_names->property_names:'';
        $payments = Payment::where('sale_id', '=', $id)->get();
        return view('back-end.sale.invoice_payment', compact('sale', 'customer', 'payments', 'property_names'));
    }
}