<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Sale;
use App\Model\Loan;
use App\Model\Customer;
use App\Model\Project;
use App\Model\ProjectZone;
use App\Model\Property;
use App\Model\PaymentSchedule;
use App\Model\PropertyPriceTransaction;
use App\Model\PropertyType;
use App\Model\PaymentTimeline;
use App\Model\PaymentTimelineDetail;
use App\Model\GeneralExpense;
use App\Model\ExpenseGroup;
use App\Model\Purchase;
use App\Model\PurchaseDetail;
use App\Model\Supplyer;
use App\Model\Employee;
use App\Http\Requests\SaleRequest;
use App\Model\SaleDetail;
use Session, Auth;
use App\Model\Payment;
use App\Model\Land;
use App\Model\SaleItem;
use App\Model\PaymentTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Exports\InvoicesExport;
use Form;
use App\Helpers\AppHelper;
use DB;
class ReportController extends Controller
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
        
        $serial =  shell_exec('wmic DISKDRIVE GET SerialNumber 2>&1');
        $serial = explode("\n", $serial);
        $serial_arr = [];
        foreach ($serial as  $value) {
            $serial_arr[] = trim(str_replace(' ', '', $value));
        }
        $check = false;
        $serial_arr_pc_hdd = array('200659800779');
        foreach ($serial_arr_pc_hdd as $key_value) {
            if (in_array($key_value, $serial_arr)) {
                $check = true;
            }
        }
       
    }
    public function index(Request $request)
    {
        if(!Auth::user()->can('list-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $start_date = $request->get('start', '');
        $end_date = $request->get('end', '');
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit', 10);
        $items = $this->sale->where(function ($query) use($start_date, $end_date, $status) {
            if($status != '') {
                $query->where('status', '=', $status);
            }
            if($start_date != '' && $end_date != '') {
                $start_date = Date('Y-m-d H:i:s', strtotime($start_date));
                $end_date = Date('Y-m-d H:i:s', strtotime($end_date));
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        });
        $items = $items->sortable()->paginate($limit)->appends([
            'start' => $start_date,
            'end' => $end_date,
            'filter_status' => $status
        ]);
        $url_excel = url('report/excel?start='.$start_date.'&end='.$end_date.'&filter_status='.$status);
        return view('back-end.report.index', compact('items', 'start_date', 'end_date', 'url_excel'))->withInput(Input::all());
    }
    public function sale_report(Request $request){
        if(!Auth::user()->can('list-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        $items = SaleItem::select(DB::raw('
            sale_items.*,
            (total_price - discount_amount) as grand_totals,
            items.property_no as property_no,
            items.property_name as property_name,
            items.qty_merge as qty_merge,
            project.property_name as project_name,           
            CONCAT(employees.last_name, " ", employees.first_name) as employee_name,
            CONCAT(customers.last_name, " ",customers.first_name) as customer_name
        '));
        if($request->project){
            $items = $items->where('items.project_id',$request->project);
        }
        $items = $items->where(function ($query) use($start_date, $end_date, $status) {
            if($status != '') {
                $query->where('sale_items.status', '=', $status);
            }else{
                $query->where('sale_items.status', '<>', 'cancel');
            }
            $query->whereBetween('sale_items.created_at', [$start_date, $end_date]);
        });
        $items = $items->join('items','items.id','=','sale_items.property_id');
        $items = $items->leftJoin('items as project', 'items.project_id', '=', 'project.id');
        $items = $items->join('customers','customers.id','=','sale_items.customer_id');
        $items = $items->leftJoin('employees', 'employees.id', '=', 'sale_items.employee_id');        
        $items = $items->get();
        $pro = Project::where('item_type', '=', 2)->get();
        $projects[] = 'Select Project';
        foreach($pro as $p){
            $projects[$p->id] = $p->property_name;
        }
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.sale_report',compact('start_date','end_date', 'projects', 'request'))->with('item', $items);
    }
    public function land_report(Request $request, Land $land){
        if(!Auth::user()->can('list-land') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = $land;
        if($request->search && !empty($request->search)){
            $search = $request->search;
            $items = $items
                ->where(function ($query) use($search) {
                    $query->where('id',      'like',     '%'.$search.'%');
                    $query->orWhere('property_name',      'like',     '%'.$search.'%');
                    $query->orWhere('address_street',      'like',     '%'.$search.'%');
                    $query->orWhere('address_number',      'like',     '%'.$search.'%');
                })
                ->where("item_type", 1);
        }else{
            $items = $items->where("item_type", 1);
        }
       
        $items = $items->get();
        return view('back-end.reports.land_report')->with('item', $items);
    }
    public function late_payment(Request $request, Land $land){
        if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
        return view('back-end.common.no-permission');
    $date = date('Y-m-d');
    Carbon::setWeekStartsAt(Carbon::MONDAY);
    $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
    $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
    if($request->between_date == 'today'){
        $start_date = $date;
        $end_date = $date;
    }
    elseif($request->between_date == 'yesterday'){
        $start_date = date('Y-m-d',strtotime($date .'-1 day'));
        $end_date = date('Y-m-d', strtotime($date .'-1 day'));
    }
    elseif($request->between_date == 'this_week'){
        $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
        $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
    }
    elseif($request->between_date == 'last_week'){
        $start_date = Carbon::now()->startOfWeek();
        $end_date = Carbon::now()->endOfWeek();
        $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
        $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
    }
    elseif($request->between_date == 'this_month'){
        $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
    }
    elseif($request->between_date == 'last_month'){
        $start = new Carbon('first day of last month');
        $end = new Carbon('last day of last month');
        $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
        $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
    }
    elseif($request->between_date == 'this_year'){
        $start = new Carbon('first day of January '.date('Y'));
        $end = new Carbon('last day of December '.date('Y'));
        $start_date = date('Y-m-d', strtotime($start));
        $end_date = date('Y-m-d', strtotime($end));
    }
    elseif($request->between_date == 'last_year'){
        $last_year = date('Y')-1;
        $start = new Carbon('first day of January '.$last_year);
        $end = new Carbon('last day of December '.$last_year);
        $start_date = date('Y-m-d', strtotime($start));
        $end_date = date('Y-m-d', strtotime($end));
    }
    elseif($start_date != '' && $end_date != '') {
        $start_date = Date('Y-m-d', strtotime($start_date));
        $end_date = Date('Y-m-d', strtotime($end_date));
    }

   // $items = Payment::where('payment_date','>=',$now)->where('payment_date','<=',$end)->where('status','<>',2)->paginate(10);
    $items = PaymentSchedule::where([
        ['payment_schedules.payment_status','<>','paid'],
        ['payment_schedules.status','=','loaned'],
        ['payment_schedules.payment_date','<=',$end_date]
    ])
    ->select(DB::raw('
        payment_schedules.id,
        FORMAT(payment_schedules.amount_to_spend,2) as amount,
        DATE_FORMAT(payment_schedules.payment_date, "%d-%m-%Y") as payment_date,
        DATE_FORMAT(loans.loan_date, "%d-%m-%Y") as loan_date,
        CONCAT(customers.last_name," ",customers.first_name) as customer_name,
        items.property_name as property_name,
        sale_items.id as sale_id,
        items.id as property_id
    '))
    ->join('loans', 'loans.id', '=', 'payment_schedules.loan_id')
    ->leftJoin('customers', 'customers.id', '=', 'payment_schedules.customer_id')
    ->leftJoin('sale_items', 'sale_items.id', '=', 'payment_schedules.sale_id')
    ->leftJoin('items', 'items.id', '=', 'sale_items.property_id')
    ->orderBy('payment_schedules.id', 'DESC')->paginate(10);
    if($request->search && !empty($request->search)){
        $search = $request->search;
        $items = $items
            ->where(function ($query) use($search) {
                $query->where('pt.id',      'like',     '%'.$search.'%');
                $query->orWhere('pt.reference',      'like',     '%'.$search.'%');
                $query->orWhere('projects.property_name',      'like',     '%'.$search.'%');
                $query->orWhere('properties.property_name',      'like',     '%'.$search.'%');
                $query->orWhere('customers.last_name',      'like',     '%'.$search.'%');
                $query->orWhere('customers.first_name',      'like',     '%'.$search.'%');
            })
            ->where("pt.is_cancel", '<>', 1);
    }else{
        $items = $items->where("pt.is_cancel", '<>', 1);
    }
    $start_date = date('d-m-Y', strtotime($start_date));
    $end_date = date('d-m-Y', strtotime($end_date));
    return view('back-end.reports.late_payment', compact('end_date', 'start_date', 'request'))->with('item', $items);
    }
    public function zone_report(Request $request, ProjectZone $projectZone, $project_id = null){
        if(!Auth::user()->can('list-property-zone') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = $projectZone;
        if(is_null($project_id)){
            if($request->search && !empty($request->search)){
                $search = $request->search;
                $items = $items
                    ->where(function ($query) use($search) {
                        $query->where('id',      'like',     '%'.$search.'%');
                        $query->orWhere('name',      'like',     '%'.$search.'%');
                        $query->orWhere('code',      'like',     '%'.$search.'%');
                    });
            }
        }else{
            if($request->search && !empty($request->search)){
                $search = $request->search;
                $items = $items
                    ->where(function ($query) use($search) {
                        $query->where('id',      'like',     '%'.$search.'%');
                        $query->orWhere('name',      'like',     '%'.$search.'%');
                        $query->orWhere('code',      'like',     '%'.$search.'%');
                    })
                    ->where("project_id", $project_id);
            }else{
                $items = $items->where("project_id", $project_id);
            }
        }
        $items = $items->get();
        return view('back-end.reports.zone_report')->with('item', $items);
    }
    public function customer_report(Request $request,Customer $customer){
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $customers = $customer
        ->select(DB::raw('
            CONCAT(customers.last_name," ",customers.first_name) as customer_name,
            customers.sex,
            customers.phone1,
            customers.phone2,
            customers.email,
            CONCAT(provinces.province_kh_name,", ",districts.district_namekh,", ",communes.commune_namekh,", ",villages.village_namekh) customer_address,
            DATE_FORMAT(customers.created_at, "%d-%m-%Y") as customer_date
        '))->orderBy('last_name', 'ASC') ;
        if($request->search && !empty($request->search)){
            $search = $request->search;
            $customers = $customers
                ->where(function ($query) use($search) {
                $query->where('id',      'like',     '%'.$search.'%');
                $query->orWhere('customers.first_name',      'like',     '%'.$search.'%');
                $query->orWhere('customers.last_name',      'like',     '%'.$search.'%');
                $query->orWhere('customers.age',      'like',     '%'.$search.'%');
                $query->orWhere('customers.phone1',      'like',     '%'.$search.'%');
                $query->orWhere('customers.phone2',      'like',     '%'.$search.'%');
                $query->orWhere('customers.email',      'like',     '%'.$search.'%');
                $query->orWhere('customers.fax',      'like',     '%'.$search.'%');
                $query->orWhere('customers.address',      'like',     '%'.$search.'%');
                $query->orWhere('customers.pob',      'like',     '%'.$search.'%');
            })
            ->where("customers.deleted", 0);
        }else{
            $customers = $customers->where("customers.deleted", 0);
        }
        $customers = $customers
            ->leftJoin('provinces', 'provinces.province_id', '=', 'customers.province')
            ->leftJoin('districts', 'districts.dis_id', '=', 'customers.district')
            ->leftJoin('communes', 'communes.com_id', '=', 'customers.commune')
            ->leftJoin('villages', 'villages.vill_id', '=', 'customers.village');
        
        $customers = $customers->whereBetween('customers.created_at', [$start_date, $end_date]);
        $customers = $customers->get();
        $items = $customers;
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.customer_report',compact('request', 'start_date', 'end_date'))->with('item', $items);
    }
    public function property_report(Request $request,Property $property){
        if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = $property;
        $land = Land::whereNull('land_id')->pluck('property_name','id');
        $project = Project::whereNull("project_id")->where('land_id',$request->land_id)->pluck('property_name','id');
        $zone = projectZone::where('project_id',$request->project_id)->pluck('name','id');
        $items = Property::select('items.*')
        ->join('items AS pro', 'items.id', '=', 'pro.id')
        ->join('item_zones AS zone', 'pro.item_zone', '=', 'zone.id')
        ->join('items AS project', 'pro.project_id', '=', 'project.id')
        ->join('items AS land', 'project.land_id', '=', 'land.id');
        if($request->land_id){
           $items = $items->where('project.land_id',$request->land_id);
        }
        if($request->project_id){
           $items = $items->where('pro.project_id',$request->project_id);
        }
        if($request->zone_id){
           $items = $items->where('pro.item_zone',$request->zone_id);
        }
        $items= $items->get();
        return view('back-end.reports.property_report',compact('land','project','zone','request'))->with('item', $items);
    }
    public function project_report(Request $request, Project $project){
        if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = $project;
        if($request->search && !empty($request->search)){
            $search = $request->search;
            $items = $items
                ->where(function ($query) use($search) {
                    $query->where('id',      'like',     '%'.$search.'%');
                    $query->orWhere('property_name',      'like',     '%'.$search.'%');
                    $query->orWhere('address_street',      'like',     '%'.$search.'%');
                    $query->orWhere('address_number',      'like',     '%'.$search.'%');
                    $query->orWhere('ground_surface',      'like',     '%'.$search.'%');
                })
                ->where("item_type", 2);
        }else{
            $items = $items->where("item_type", 2);
        }
        $items = $items->get();
        return view('back-end.reports.project_report')->with('item', $items);
    }
    public function deposit_report(Request $request){
        if(!Auth::user()->can('list-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $start_date = $request->get('start', '');
        $end_date = $request->get('end', '');
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        $land = Land::whereNull('land_id')->pluck('property_name','id');
        $project = Project::whereNull("project_id")->where('land_id',$request->land_id)->pluck('property_name','id');
        $zone = projectZone::where('project_id',$request->project_id)->pluck('name','id');
        $items = Sale::select('sales.*','pro.property_name as property_name','zone.name as zone_name','project.property_name as project_name','land.property_name as land_name')
        ->join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
        ->join('items AS pro', 'sale_details.item_id', '=', 'pro.id')
        ->join('item_zones AS zone', 'pro.item_zone', '=', 'zone.id')
        ->join('items AS project', 'pro.project_id', '=', 'project.id')
        ->join('items AS land', 'project.land_id', '=', 'land.id');
        $items = $items->where('sales.deposit','>', 0);
        if($request->land_id){
            $items = $items->where('project.land_id',$request->land_id);
        }
        if($request->project_id){
           $items = $items->where('pro.project_id',$request->project_id);
        }
        if($request->zone_id){
           $items = $items->where('pro.item_zone',$request->zone_id);
        }
        $items = $items->get();
        // dd($items->all());
        return view('back-end.reports.deposit_report',compact('start_date','end_date','land','project','zone','request'))->with('item', $items);
    }
    public function commission_report(Request $request){
        if(!Auth::user()->can('list-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $items = SaleItem::select(DB::raw('
            sale_items.*,
            (total_price - discount_amount) as grand_totals,
            items.property_name as property_name,            
            CONCAT(employees.last_name, " ", employees.first_name) as employee_name,
            CONCAT(customers.last_name, " ",customers.first_name) as customer_name,
            projects.property_name as project_name
        '));
        $items = $items->where(function ($query) use($status) {
            if($status != '') {
                $query->where('sale_items.status', '=', $status);
            }else{
                $query->where('sale_items.status', '<>', 'cancel');
            }      
        });
        $items = $items->where('sale_items.commission_amount', '>', 0);
        $items = $items->join('items','items.id','=','sale_items.property_id');
        $items = $items->leftJoin('items as projects','projects.id','=','sale_items.project_id');
        $items = $items->join('customers','customers.id','=','sale_items.customer_id');
        $items = $items->leftJoin('employees', 'employees.id', '=', 'sale_items.employee_id');      
        $items = $items->whereBetween('sale_items.sale_date', [$start_date,$end_date]);   
        $items = $items->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.commission_report',compact('start_date','end_date','request'))->with('item', $items);
    }
    public function receivable_report(Request $request){
        $land = Land::whereNull('land_id')->pluck('property_name','id');
        $project = Project::whereNull("project_id")->where('land_id',$request->land_id)->pluck('property_name','id');
        $zone = projectZone::where('project_id',$request->project_id)->pluck('name','id');
        $items = Sale::select('sales.*','pro.property_name as property_names','zone.name as zone_name','project.property_name as project_name','land.property_name as land_name')
        ->join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
        ->join('items AS pro', 'sale_details.item_id', '=', 'pro.id')
        ->join('item_zones AS zone', 'pro.item_zone', '=', 'zone.id')
        ->join('items AS project', 'pro.project_id', '=', 'project.id')
        ->join('items AS land', 'project.land_id', '=', 'land.id');
        if($request->land_id){
           $items = $items->where('project.land_id',$request->land_id);
        }
        if($request->project_id){
           $items = $items->where('pro.project_id',$request->project_id);
        }
        if($request->zone_id){
           $items = $items->where('pro.item_zone',$request->zone_id);
        }
        if($request->start != '' && $request->end != '') {
            $items = $items->whereBetween('sales.created_at', [date('Y-m-d H:i:s',strtotime($request->start)), date('Y-m-d H:i:s',strtotime($request->end))]);
        }
        $items= $items->get();
        // ->where('status','approved')
        // ->where(function($query) use($name_cid) {
        //     $query
        //     ->Where('loan_code', 'like', '%'.$name_cid.'%')
        //     ->orWhere('full_name', 'like', '%'.$name_cid.'%');
        // })
        // ->orderBy('created_at', 'DESC')
        // ->paginate(50)
        // ->withPath('?name_cid='.$name_cid);
//         SELECT s.*,pro.property_name,zone.`name`,project.property_name as project_name,land.property_name as land_name FROM sale_details sd
// INNER JOIN sales s ON sd.sale_id = s.id
// INNER JOIN items pro ON sd.item_id = pro.id
// INNER JOIN item_zones zone ON pro.item_zone = zone.id
// INNER JOIN items project ON pro.project_id = project.id
// INNER JOIN items land ON project.land_id = land.id
        return view('back-end.reports.receivable_report',compact('request','land','project','zone'))->with('item', $items);
    }
    public function payment_report(Request $request){
        if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $items = DB::table('payment_transactions as pt')->select(DB::raw('
           pt.reference,
           DATE_FORMAT(pt.payment_date, "%d") as payment_day,
           DATE_FORMAT(pt.payment_date, "%m") as payment_month,
           DATE_FORMAT(pt.payment_date, "%Y") as payment_year,
           FORMAT(pt.amount,2) as pay_amount,
           pt.amount,
           projects.property_name as project_name,
           properties.property_name as property_name,
           CONCAT(customers.last_name," ", customers.first_name) as customer_name
        '))
        ->leftJoin('customers', 'customers.id', '=', 'pt.customer_id')
        ->leftJoin('items as projects', 'projects.id', '=', 'pt.project_id')
        ->leftJoin('items as properties', 'properties.id', '=', 'pt.property_id');
        if($request->search && !empty($request->search)){
            $search = $request->search;
            $items = $items
                ->where(function ($query) use($search) {
                    $query->where('pt.id',      'like',     '%'.$search.'%');
                    $query->orWhere('pt.reference',      'like',     '%'.$search.'%');
                    $query->orWhere('projects.property_name',      'like',     '%'.$search.'%');
                    $query->orWhere('properties.property_name',      'like',     '%'.$search.'%');
                    $query->orWhere('customers.last_name',      'like',     '%'.$search.'%');
                    $query->orWhere('customers.first_name',      'like',     '%'.$search.'%');
                })
                ->where("pt.is_cancel", '<>', 1);
        }else{
            $items = $items->where("pt.is_cancel", '<>', 1);
        }
        $items = $items->whereBetween('pt.payment_date',[$start_date, $end_date]);
        $items = $items->orderBy('pt.id','ASC')->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.payment_report', compact('end_date', 'start_date', 'request'))->with('item', $items);
    }
    public function exportToPdfFile(Request $request) {
        $start_date = $request->get('start', '');
        $end_date = $request->get('end', '');
        $status = $request->get('filter_status', '');
        $sales = Sale::where(function ($query)  use($start_date, $end_date, $status){
            if($status != '') {
                $query->where('status', '=', $status);
            }
            
            if($start_date != '' && $end_date != '') {
                $start_date = Date('Y-m-d H:i:s', strtotime($start_date));
                $end_date = Date('Y-m-d H:i:s', strtotime($end_date));
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        });
        $items = $sales->get();
        $total_price = $sales->sum('total_price');
        $total_sale_commission = $sales->sum('total_sale_commission');
        $total_discount = $sales->sum('total_discount');
        $total = $sales->sum('grand_total');
        $pdf = \PDF::loadView('back-end.report.pdf', compact('total', 'total_price', 'total_discount', 'total_sale_commission', 'items'));
        return $pdf->download('invoice.pdf');
    }
    public function exportToExcelFile(Request $request) {
        $start_date = $request->get('start', '');
        $end_date = $request->get('end', '');
        $status = $request->get('filter_status', '');
        return (new InvoicesExport($start_date, $end_date, $status))->download('invoices.xlsx');
    }
    public function get_project_by_land(Request $request){
        $project = Project::whereNull("project_id")->where('land_id',$request->land_id)->pluck('property_name','id');
        $proj =  Form::select('project_id',$project->prepend('Select Project',''),null,['id'=>'project_id','onchange'=>'getzone()','style'=>'width:100%;','class'=>'form-control ']);
        $res = [
            'project' => (String) $proj
        ];
        return response()->json($res);
    }
    public function get_zone_by_pro(Request $request){
        $zones = projectZone::where('project_id',$request->project_id)->pluck('name','id');
        $zone =  Form::select('zone_id',$zones->prepend('Select Zone',''),null,['id'=>'zone_id','style'=>'width:100%;','class'=>'form-control ']);
        $res = [
            'zones' => (String) $zone
        ];
        return response()->json($res);
    }
    public function expense_report(Request $request){
        if(!Auth::user()->can('list-expense') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $expense_types = ExpenseGroup::select('name', 'id')->get();
        $expense_groups[]  = 'ទាំងអស់';
        foreach ($expense_types as $key => $value) {
            $expense_groups[$value->id] = $value->name;
        }
        $pro = Project::where('item_type', '=', 2)->get();
        $projects[] = 'ទាំងអស់';
        foreach($pro as $p){
            $projects[$p->id] = $p->property_name;
        }
        $ems = Employee::get();
        $employees[] = 'ទាំងអស់';
        foreach($ems as $em){
            $employees[$em->id] =  $em->first_name.' '.$em->last_name;
        }
        $items = GeneralExpense::select(DB::raw('
            general_expenses.date as date,
            general_expenses.title as expense_name,
            general_expenses.amount as amount,
            expense_groups.name as group_name,
            items.property_name as project_name,
            CONCAT(employees.first_name," ",employees.last_name) as employee_name
        '))->join('expense_groups', 'expense_groups.id', '=', 'general_expenses.group_id')
        ->leftJoin('items', 'items.id', '=', 'general_expenses.project_id')
        ->leftJoin('employees', 'employees.id', '=', 'general_expenses.employee_id');
        if($request->expense_type){
            $items = $items->where('group_id', '=', $request->expense_type);
        }
        if($request->project){
            $items = $items->where('general_expenses.project_id', '=', $request->project);
        }
        if($request->employee){
            $items = $items->where('general_expenses.employee_id', '=', $request->employee);
        }
        $items = $items->whereBetween('general_expenses.date', [$start_date,$end_date]);
        $items = $items->orderBy('general_expenses.date','DESC')->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.expense_report', compact('expense_groups', 'projects', 'employees', 'request', 'start_date', 'end_date'))->with('item', $items);
    }
    public function purchase_report(Request $request){
        if(!Auth::user()->can('list-purchase') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $supp = Supplyer::whereNull('deleted_at')->select('id', 'firstname', 'lastname')->get();
        $supplyers[] = "All";
        foreach ($supp as $value) {
            $supplyers[$value->id] = ucwords($value->firstname.' '.$value->lastname);
        }
        $items = Purchase::whereNull('purchases.deleted_at')
        ->where('status', '=', 'received')
        ->select(DB::raw('
            purchases.received_date as date,
            purchases.reference as reference,
            purchases.cost_total as cost,
            purchases.discount_amount as discount_amount,
            purchases.grand_total as grand_total,
            CONCAT(supplyers.firstname," ",supplyers.lastname) as supplyer_name
            '))
        ->rightJoin('supplyers', 'supplyers.id', '=', 'purchases.supplyer_id');
        if($request->supplyer){
            $items = $items->where('purchases.supplyer_id', '=', $request->supplyer);
        }
        $items = $items->whereBetween('purchases.received_date', [$start_date,$end_date]);
        $items = $items->orderBy('purchases.received_date', 'DESC')->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.purchase_report', compact('supplyers', 'request', 'start_date', 'end_date'))->with('item', $items);
    }
    public function purchase_detail_report(Request $request){
        if(!Auth::user()->can('list-purchase') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $supp = Supplyer::whereNull('deleted_at')->select('id', 'firstname', 'lastname')->get();
        $supplyers[] = "All";
        foreach ($supp as $value) {
            $supplyers[$value->id] = ucwords($value->firstname.' '.$value->lastname);
        }
        $items = PurchaseDetail::whereNull('purchase_details.deleted_at')
        ->where('purchase_details.status', '=', 'received')
        ->select(DB::raw('
            purchase_details.received_date as date,
            purchase_details.purchase_id as purchases,
            purchase_details.cost as cost,
            purchase_details.sub_total as total,
            purchase_details.quantity,
            materials.name as name,
            purchases.reference as reference,
            CONCAT(supplyers.firstname," ",supplyers.lastname) as supplyer_name
            '))
        ->join('materials','materials.id','=','purchase_details.material_id')
        ->join('purchases','purchases.id','=','purchase_details.purchase_id')
        ->join('supplyers', 'supplyers.id', '=', 'purchase_details.supplyer_id');
        
        if($request->supplyer){
            $items = $items->where('purchase_details.supplyer_id', '=', $request->supplyer);
        }
        $items = $items->whereBetween('purchase_details.received_date', [$start_date,$end_date]);
        $items = $items->orderBy('purchase_details.received_date', 'DESC')->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.purchase_detail_report', compact('supplyers', 'request', 'start_date', 'end_date'))->with('item', $items);
    }
    public function loan_report(Request $request){
        if(!Auth::user()->can('loan-report') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        $items = Loan::select(DB::raw('
            loans.reference,
            DATE_FORMAT(loans.loan_date, "%d") as loan_day,
            DATE_FORMAT(loans.loan_date, "%m") as loan_month,
            DATE_FORMAT(loans.loan_date, "%Y") as loan_year,
            loans.loan_amount AS loan_amount,
            loans.outstanding_amount AS outstanding_amount,
            loans.loan_type,
            loans.installment_term,
            loans.duration_type,
            FORMAT(loans.interest_rate,2) AS interest_rate,
            loans.status,
            CONCAT(customers.last_name, " ", customers.first_name) AS customer_name
        '))
        ->leftJoin('customers', 'customers.id', '=', 'loans.customer_id')
        ->whereNotNull('loan_type')
        ->where('loans.status', '<>', 'cancel');
        if($request->status=='completed' || $request->status=='loaned'){
            $items = $items->where('loans.status', '=', $request->status);
        }
        $items = $items->whereBetween('loans.loan_date', [$start_date, $end_date]);
        $items =  $items->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.loan_report',compact('start_date','end_date'))->with('item', $items);
    }
    public function property_price_report(Request $request){
        if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $items = DB::table('property_price_transactions as p')->select(DB::raw('
            FORMAT(p.amount,2) as property_price,
            DATE_FORMAT(p.created_at, "%d-%m-%Y") as property_date,
            items.property_no as property_number,
            items.property_name as property_name,
            projects.property_name as project_name,
            zones.name as zone_name
        '))
        ->join('items', 'items.id', '=', 'p.property_id')
        ->leftJoin('items as projects', 'projects.id', '=', 'p.project_id')
        ->leftJoin('item_zones as zones', 'zones.id', '=', 'p.zone_id')
        ->whereNull('items.deleted_at');
        if($request->search && !empty($request->search)){
            $items = $items->where(function($query) use($request){
                $query->where('items.property_no', 'LIKE', '%'.$request->search.'%');
                $query->orWhere('items.property_name', 'LIKE', '%'.$request->search.'%');
                $query->orWhere('zones.name', 'LIKE', '%'.$request->search.'%');
                $query->orWhere('projects.property_name', 'LIKE', '%'.$request->search.'%');
            });
        }
        $items = $items->whereBetween('p.created_at', [$start_date, $end_date]);
        $items =  $items->orderBy('p.id', 'DESC')->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        return view('back-end.reports.property_price_report',compact('request','start_date','end_date'))->with('item', $items);
    }
    public function sale_detail_report(Request $request){
        if(!Auth::user()->can('list-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $date = date('Y-m-d');
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
        $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        $status = $request->get('filter_status', '');
        $limit = $request->get('limit',10);
        if($request->between_date == 'today'){
            $start_date = $date;
            $end_date = $date;
        }
        elseif($request->between_date == 'yesterday'){
            $start_date = date('Y-m-d',strtotime($date .'-1 day'));
            $end_date = date('Y-m-d', strtotime($date .'-1 day'));
        }
        elseif($request->between_date == 'this_week'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfWeek()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfWeek()));
        }
        elseif($request->between_date == 'last_week'){
            $start_date = Carbon::now()->startOfWeek();
            $end_date = Carbon::now()->endOfWeek();
            $start_date = date('Y-m-d', strtotime($start_date. ' -7 day'));
            $end_date = date('Y-m-d', strtotime($end_date. ' -7 day'));
        }
        elseif($request->between_date == 'this_month'){
            $start_date = date('Y-m-d', strtotime(Carbon::now()->startOfMonth()));
            $end_date = date('Y-m-d', strtotime(Carbon::now()->endOfMonth()));
        }
        elseif($request->between_date == 'last_month'){
            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');
            $start_date = date('Y-m-d', strtotime($start->startOfMonth()));
            $end_date = date('Y-m-d', strtotime($end->endOfMonth()));
        }
        elseif($request->between_date == 'this_year'){
            $start = new Carbon('first day of January '.date('Y'));
            $end = new Carbon('last day of December '.date('Y'));
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($request->between_date == 'last_year'){
            $last_year = date('Y')-1;
            $start = new Carbon('first day of January '.$last_year);
            $end = new Carbon('last day of December '.$last_year);
            $start_date = date('Y-m-d', strtotime($start));
            $end_date = date('Y-m-d', strtotime($end));
        }
        elseif($start_date != '' && $end_date != '') {
            $start_date = Date('Y-m-d', strtotime($start_date));
            $end_date = Date('Y-m-d', strtotime($end_date));
        }
        $items = SaleItem::select(DB::raw('
            sale_items.id as id,
            sale_items.reference,
            sale_items.deposit,
            sale_items.sale_date,
            (sale_items.total_price - sale_items.discount_amount) as grand_totals,
            sale_items.grand_total as outstanding_amount,
            items.property_no as property_no,
            items.qty_merge as qty_merge,
            items.property_name as property_name,
            CONCAT(customers.last_name, " ",customers.first_name) as customer_name
        '));
        if($request->search){
            $items = $items->where(function($query) use($request){
                $query->where('customers.first_name', 'LIKE', '%'.$request->search.'%');
                $query->orWhere('customers.last_name', 'LIKE', '%'.$request->search.'%');
                $query->orWhere('items.property_no', 'LIKE', '%'.$request->search.'%');
            });
        }
        $items = $items->where(function ($query) use($start_date, $end_date, $status, $request,$date) {
            if($status != '') {
                $query->where('sale_items.status', '=', $status);
            }else{
                $query->where('sale_items.status', '<>', 'cancel');
            }
            $query->whereBetween('sale_items.sale_date', [$start_date, $end_date]);
        });
        $items = $items->join('items','items.id','=','sale_items.property_id');
        $items = $items->join('customers','customers.id','=','sale_items.customer_id'); 
        $items = $items->orderBy('sale_date', 'ASC')->get();
        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));
        $data =[];
        $data_total=[];
        $data_total['total_qty'] =0;
        $data_total['total_price'] =0;
        $data_total['total_paid'] =0;
        $data_total['total_outstanding_amount'] =0;
        foreach($items as $key => $item){
            $qty=1;
            if($item->qty_merge){
                $qty=$item->qty_merge;
            }
            $data_total['total_qty'] +=$qty;
            $deposit =0;
            if($item->deposit>0){
                $deposit = $item->deposit;
            }
            $row =[
                'no' => $key+1,
                'sale_no' => $item->reference,
                'sale_date' => date('d-m-Y', strtotime($item->sale_date)),
                'customer_name' => $item->customer_name,
                'property_number' => $item->property_no,
                'total_property' => $qty,
                'total_sale_amount' => '$'.number_format($item->grand_totals),
                'deposit' => '$'.number_format($deposit,2),
                'paid' => '',
                'pay_date' => '',
                'total_paid' => '',
                'total_outstanding_amount' => '',
                'payment_order' => ''
            ];
            $data_total['total_price'] +=$item->grand_totals;
            $data[$key][] =$row;
            $loans =  Loan::select('id', 'outstanding_amount')
            ->where([
                ['sale_id', '=', $item->id],
                ['status', '', 'loaned']
            ])->get();
            $index =0;
            $total_paid=0;
            $total_oustanding_amount = 0;
            foreach($loans as $loan){
                $total_oustanding_amount +=$loan->outstanding_amount;
            }
            $payment_transaction = PaymentTransaction::select(DB::raw('
                payment_transactions.*,
                payment_schedules.order AS payment_order
            '))
            ->where([
                ['payment_transactions.sale_id', '=', $item->id],
                ['payment_transactions.is_cancel', '<>', 1]
            ])
            ->leftJoin('payment_schedules', 'payment_schedules.id', '=', 'payment_transactions.payment_schedule_id')
            ->get();
            foreach($payment_transaction as $in => $tansaction){
                $row =[
                    'no' => '',
                    'sale_no' => '',
                    'sale_date' => '',
                    'customer_name' => '',
                    'property_number' => '',
                    'total_property' => '',
                    'total_sale_amount' => '',
                    'deposit' => '',
                    'paid' => '$'.number_format($tansaction->amount,2),
                    'pay_date' => date('d-m-Y', strtotime($tansaction->payment_date)),
                    'total_paid' => '',
                    'total_outstanding_amount' => '',
                    'payment_order' => $tansaction->payment_order
                ];
                $data[$key][++$in]=$row;
                $index = $in;
                $total_paid += $tansaction->amount;
            }
            $row =[
                'no' => '',
                'sale_no' => '',
                'sale_date' => '',
                'customer_name' => '',
                'property_number' => '',
                'total_property' => '',
                'total_sale_amount' => '',
                'deposit' => '',
                'paid' => '',
                'pay_date' => '',
                'total_paid' => '$'.number_format($total_paid+$deposit,2),
                'total_outstanding_amount' => '',
                'payment_order' => ''
            ];
            $data[$key][++$index]=$row;
            $row =[
                'no' => '',
                'sale_no' => '',
                'sale_date' => '',
                'customer_name' => '',
                'property_number' => '',
                'total_property' => '',
                'total_sale_amount' => '',
                'deposit' => '',
                'paid' => '',
                'pay_date' => '',
                'total_paid' => '',
                'total_outstanding_amount' => '$'.number_format($total_oustanding_amount+$item->outstanding_amount,2),
                'payment_order' => ''
            ];
            $data[$key][++$index]=$row;
            $data_total['total_paid'] += $total_paid+$deposit;
            $data_total['total_outstanding_amount'] += $total_oustanding_amount+$item->outstanding_amount;
        }
        return view('back-end.reports.sale_detail_report',compact('start_date','end_date', 'data_total', 'request'))->with('items', $data);
    }
}
?>