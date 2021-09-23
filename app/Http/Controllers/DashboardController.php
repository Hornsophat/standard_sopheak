<?php
namespace App\Http\Controllers;
use App\Model\Dashboard;
use App\Model\Land;
use App\Model\Project;
use App\Model\Property;
use App\Model\SaleItem;
use App\Model\Reservation;
use App\Model\User;
use App\Model\PaymentSchedule;
use App\Model\ApproveCancelPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('dskfhln hdsfnj ');
        $loan_eoc = DB::table('loans')->where('loan_type','eoc')->count();
        $loan_emi = DB::table('loans')->where('loan_type','emi')->count();
        $loan_simple = DB::table('loans')->where('loan_type','flat rate')->count();
        $loan_free = DB::table('loans')->where('loan_type','free_interest')->count();


        $land = Land::where("item_type", 1)->get()->toArray();
        $lat_lon = "";
        foreach ($land as $key => $value)
        {
            reset($land);
            if ($key === key($land)){
                $lat_lon .= str_replace("}]","},", $value['map_data']);
                continue;
            }
            end($land);
            if ($key === key($land)){
                $lat_lon .= str_replace("[{","{", $value['map_data']);
                continue;
            }
            $str = str_replace("}]","},", $value['map_data']);
            $str = str_replace("[{","{", $str);
            $lat_lon .= $str;
        }
        $land = Land::where("item_type", 1)->get();
        $project = Project::where("item_type", 2)->get();
        $property = Property::where("item_type", ">", 2)->get();
        $customers = DB::table('customers')->count();
        $payment_stages = DB::table('payment_stages')->count();
        $users = User::all();
        $data = SaleItem::select(
            DB::raw('sum(total_price) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%M') as months")
        )
        ->whereYear('created_at', '=', date('Y'))
        ->groupBy('months')
        ->get();
        $output=[
            "January" => 0,
            "February" => 0,
            "March" => 0,
            "April" => 0,
            "May" => 0,
            "June" => 0,
            "July" => 0,
            "August" => 0,
            "September" => 0,
            "October" => 0,
            "November" => 0,
            "December" => 0
        ];
        foreach ($data as $key => $value)
        {
            $output[$value->months]= $value->sums;
        }
        $now = date('Y-m-d 00:00:00');
        $end = date("Y-m-d 23:59:59", strtotime($now." +1 week"));
       // $items = Payment::where('payment_date','>=',$now)->where('payment_date','<=',$end)->where('status','<>',2)->paginate(10);
        $items = PaymentSchedule::where([
            ['payment_schedules.payment_status','<>','paid'],
            ['payment_schedules.status','=','loaned'],
            ['payment_schedules.payment_date','<=',$end]
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
        
        $total_sale = SaleItem::where('status' ,'<>','cancel')->sum("total_price");
        $total_deposit = Reservation::where('status' ,'<>','cancel')->sum("amount");
        $approve_cancel_payments = ApproveCancelPayment::select(DB::raw('
            payment_transactions.id as payment_id,
            approve_cancel_payments.id as approve_id,
            payment_transactions.reference,
            FORMAT(payment_transactions.amount,2) as amount,
            CONCAT(customers.last_name_en, " ",customers.first_name_en) as customer_name,
            DATE_FORMAT(approve_cancel_payments.created_at, "%d-%m-%Y") as request_date,
            users.name as reqeust_by
        '))
        ->join('payment_transactions', 'payment_transactions.id', '=', 'approve_cancel_payments.payment_transaction')
        ->leftJoin('customers', 'customers.id', '=', 'payment_transactions.customer_id')
        ->leftJoin('users', 'users.id', '=', 'approve_cancel_payments.created_by')
        ->where('approve_cancel_payments.status', '=', 'waitting')
        ->get();
        return view('back-end/dashboard/dashboard', compact("loan_simple","loan_eoc","loan_emi","loan_free","lat_lon","land", "project", "property", "users", "output", "total_deposit", "total_sale","customers","payment_stages","items","approve_cancel_payments"));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
?>