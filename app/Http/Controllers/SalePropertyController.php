<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth, Validator, View;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Input;
use App\Helpers\InstallmentHelper;
use App\Helpers\SaleInstallmentHelper;
use App\Model\SaleItem;
use App\Model\Project;
use App\Model\Property;
use App\Model\Reservation;
use App\Model\Customer;
use App\Model\Employee;
use App\Model\User;
use App\Model\PaymentStage;
use App\Model\PaymentTransaction;
use App\Model\Transaction;
use App\Model\PaymentSchedule;
use App\Model\Loan;
use DB;
use Carbon\Carbon;
use Config;
use App\Model\Payment;
use App\Model\ApproveCancelPayment;
use App\Model\Contract;
use App\Model\LandAddress;
use App\Model\Land;
class SalePropertyController extends Controller
{
    
   
    
    function booking(Request $request, Property $property){
    	if(!Auth::user()->can('booking-propery') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if($property->status!=Config::get('app.property_status_available')){
        	return redirect()->back()->with('error-message', __('item.error_booking'));
        }
        if($request->method() == 'GET'){
        	$payment_transaction = PaymentTransaction::orWhereNull('deleted_at')->latest()->first();
        	$code = (isset($payment_transaction->id)?$payment_transaction->id:0) +1;
        	$code ='P'.str_pad($code, 6, '0', STR_PAD_LEFT);
        	$cus = Customer::get();
        	$customers[null] = "-- ".__('item.select')." ".__('item.customer')." --";
        	foreach ($cus as $key => $value) {
        		$customers[$value->id] = $value->customer_no." | ".$value->last_name." | ".$value->first_name;
        	}
        	return view('back-end.sale_property.booking', compact('property', 'code', 'customers'));
        }elseif($request->method()=='POST'){
        	$this->validate($request,[
        		'date' => 'required|date',
        		'date_expire' => 'required|date',
        		'price' => 'required|numeric|min:0',
        		'deposit' => 'required|numeric|min:0',
        		'customer' => 'required|numeric',
        		'remark' => 'nullable|max:255',
                'customer_partner_id' => 'nullable|min:1|numeric'
        	]);
        	DB::transaction(function() use($request, $property){
        		$reservation = Reservation::create([
        			'project_id' => $property->project_id,
        			'property_id' => $property->id,
                    'customer_id' => $request->customer,
        			'customer_partner_id' => $request->customer_partner_id,
        			'date_booked' => date('Y-m-d', strtotime($request->date)),
        			'date_expire' => date('Y-m-d', strtotime($request->date_expire)),
        			'amount' => $request->deposit,
        			'status' => 'booked',
        			'remark' => $request->remark,
        			'created_by' => Auth::id()
        		]);
        		$payment_transaction = PaymentTransaction::create([
        			'project_id' => $property->project_id,
        			'property_id' => $property->id,
        			'payment_date' => date('Y-m-d', strtotime($request->date)),
        			'reservation_id' => $reservation->id,
        			'customer_id' => $request->customer,
        			'amount' => $request->deposit,
        			'remark' => 'booking',
        			'created_by' => Auth::id()
        		]);
        		Transaction::create([
        			'project_id' => $property->project_id,
        			'property_id' => $property->id,
        			'date' => date('Y-m-d', strtotime($request->date)),
                    'payment_transaction_id' => $payment_transaction->id,
        			'reservation_id' => $reservation->id,
        			'customer_id' => $request->customer,
        			'amount' => $request->deposit,
        			'remark' => 'booking',
        			'created_by' => Auth::id()
        		]);
        		$property->status=Config::get('app.property_status_booked');
        		$property->save();
        	});
        	return redirect()->route('property')->with('message', __('item.success_booking'));
        }
    }
    function view_booking(Request $request){
        if(!Auth::user()->can('booking-propery') && !AppHelper::checkAdministrator())
        return view('back-end.common.no-permission');
    $property = Property::find($request->property);
    $reservation = Reservation::select(DB::raw('
        reservations.*, CONCAT(last_name," ", first_name) as customer_name
        '))
    ->where('property_id', '=', $property->id)
    ->leftJoin('customers as cs', 'cs.id', '=', 'customer_id')
    ->latest()
    ->first();
    $payment_transaction = PaymentTransaction::where('reservation_id', '=', $reservation->id)->first();
    $data['html'] = ''.View::make('back-end.sale_property.view_booking', compact('property', 'reservation', 'payment_transaction'));
    return $data;
    }
    function edit_booking(Request $request, $id){
        if(!Auth::user()->can('booking-propery') && !AppHelper::checkAdministrator())
        return view('back-end.common.no-permission');
    $reservation = Reservation::find($id);
    if(!$reservation){
        return redirect()->back()->with('error-message', __('item.not_found'));
    }
    $property = Property::find($reservation->property_id);
    if(!$property){
        return redirect()->back()->with('error-message', __('item.not_found'));
    }
    if($reservation->status!='booked' || $property->status!=Config::get('app.property_status_booked')){
        return redirect()->back()->with('error-message', __('item.error_edit_booking'));
    }
    if($request->method()=='GET'){
        $cus = Customer::get();
        $customers[null] = "-- ".__('item.select')." ".__('item.customer')." --";
        foreach ($cus as $key => $value) {
            $customers[$value->id] = $value->customer_no." | ".$value->last_name." ".$value->first_name;
        }
        $payment_transaction = PaymentTransaction::where('reservation_id', '=', $reservation->id)->first();
        return view('back-end.sale_property.edit_booking', compact('property',  'customers', 'reservation', 'payment_transaction'));
    }elseif($request->method()=='POST'){
        $this->validate($request,[
            'date' => 'required|date',
            'date_expire' => 'required|date',
            'price' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'customer' => 'required|numeric',
            'remark' => 'nullable|max:255',
            'customer_partner_id' => 'nullable|min:1|numeric'
        ]);
        DB::transaction(function() use($request, $property, $reservation){
            $payment_transaction = PaymentTransaction::where('reservation_id', '=', $reservation->id)->first();
            Transaction::create([
                'project_id' => $property->project_id,
                'property_id' => $property->id,
                'date' => date('Y-m-d', strtotime($reservation->date_booked)),
                'payment_transaction_id' => $payment_transaction->id,
                'reservation_id' => $reservation->id,
                'customer_id' => $reservation->customer_id,
                'amount' => $reservation->amount*(-1),
                'remark' => 'booking',
                'created_by' => Auth::id()
            ]);
            $reservation->update([
                'project_id' => $property->project_id,
                'property_id' => $property->id,
                'customer_id' => $request->customer,
                'customer_partner_id' => $request->customer_partner_id,
                'date_booked' => date('Y-m-d', strtotime($request->date)),
                'date_expire' => date('Y-m-d', strtotime($request->date_expire)),
                'amount' => $request->deposit,
                'status' => 'booked',
                'remark' => $request->remark,
                'updated_by' => Auth::id()
            ]);
            $payment_transaction->update([
                'project_id' => $property->project_id,
                'property_id' => $property->id,
                'payment_date' => date('Y-m-d', strtotime($request->date)),
                'customer_id' => $request->customer,
                'amount' => $request->deposit,
                'remark' => 'booking',
                'updated_by' => Auth::id()
            ]);
            Transaction::create([
                'project_id' => $property->project_id,
                'property_id' => $property->id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'payment_transaction_id' => $payment_transaction->id,
                'reservation_id' => $reservation->id,
                'customer_id' => $request->customer,
                'amount' => $request->deposit,
                'remark' => 'booking',
                'created_by' => Auth::id()
            ]);
            $property->status=Config::get('app.property_status_booked');
            $property->save();
        });
        return redirect()->route('property')->with('message', __('item.success_edit_booking'));
    }
    }
    function delete_booking($id){
    	if(!Auth::user()->can('booking-propery') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $reservation = Reservation::find($id);
        if(!$reservation){
        	return redirect()->back()->with('error-message', __('item.not_found'));
        }
        $property = Property::find($reservation->property_id);
        if(!$property){
        	return redirect()->back()->with('error-message', __('item.not_found'));
        }
        if($reservation->status!='booked' || $property->status!=Config::get('app.property_status_booked')){
        	return redirect()->back()->with('error-message', __('item.error_delete_booking'));
        }
        DB::transaction(function() use($property, $reservation){
                $payment_transaction = PaymentTransaction::where('reservation_id', '=', $reservation->id)->first();
        		$payment_transaction->update([
        			'project_id' => $property->project_id,
        			'property_id' => $property->id,
        			'payment_date' => date('Y-m-d', strtotime($reservation->date_booked)),
        			'customer_id' => $reservation->customer_id,
        			'amount' => 0,
        			'remark' => 'cancel_booking',
        			'updated_by' => Auth::id()
        		]);
        		Transaction::create([
        			'project_id' => $property->project_id,
        			'property_id' => $property->id,
        			'date' => date('Y-m-d', strtotime($reservation->date_booked)),
                    'payment_transaction_id' => $payment_transaction->id,
        			'reservation_id' => $reservation->id,
        			'customer_id' => $reservation->customer_id,
        			'amount' => $reservation->amount*(-1),
        			'remark' => 'booking',
        			'created_by' => Auth::id()
        		]);
        		$reservation->update([
        			'status' => 'canceled',
        			'updated_by' => Auth::id()
        		]);
        		$property->status=Config::get('app.property_status_available');
        		$property->save();
        	});
        return redirect()->back()->with('message', __('item.success_delete_booking'));
    }
    function expire_booking($id){
    	if(!Auth::user()->can('booking-propery') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $reservation = Reservation::find($id);
        if(!$reservation){
        	return redirect()->back()->with('error-message', __('item.not_found'));
        }
        $property = Property::find($reservation->property_id);
        if(!$property){
        	return redirect()->back()->with('error-message', __('item.not_found'));
        }
        $date_expire = date('Y-m-d', strtotime($reservation->date_expire));
        if($reservation->status!='booked' || $property->status!=Config::get('app.property_status_booked') || $date_expire>date('Y-m-d')){
        	 return redirect()->back()->with('error-message', __('item.error_expire_booking'));
        }
        DB::transaction(function() use($property, $reservation){
        		$reservation->update([
        			'status' => 'expired',
        			'updated_by' => Auth::id()
        		]);
        		$property->status=Config::get('app.property_status_available');
        		$property->save();
        	});
        return redirect()->back()->with('message', __('item.success_expire_booking'));
    }
    function print_receipt_booking($id){
    	if(!Auth::user()->can('booking-propery') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $reservation = Reservation::find($id);
        if(!$reservation){
        	return redirect()->back()->with('error-message', __('item.not_found'));
        }
        $property = Property::find($reservation->property_id);
        if(!$property){
        	return redirect()->back()->with('error-message', __('item.not_found'));
        }
        $customer=Customer::find($reservation->customer_id);
        $project=Project::find($reservation->project_id);
        $created_by = User::find($reservation->created_by);
        $payment_transaction = PaymentTransaction::where('reservation_id', '=', $reservation->id)->first();
        return view('back-end.sale_property.receipt_booking', compact('property', 'reservation', 'customer', 'project', 'created_by', 'payment_transaction'));
    }
     function uploadPdf(Request $request)
    {
        
        if($request->file('file')) 
        {
            $file = $request->file('file');
            $filename = $request->id.".pdf";
            $filePath = public_path() . '/file/pdf';
            $file->move($filePath, $filename);
            return redirect()->route('sale_property.view_sale', ['property'=>$request->id])->with('message', __('item.success_create'));
        }
        return redirect()->route('sale_property.view_sale', ['property'=>$request->id])->with('message', __('Error'));
    
    }
    function sale(Request $request, Property $property){
        if(!Auth::user()->can('create-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(!$property || $property->is_merge){
            return redirect()->back()->with('error-message', __('item.not_found'));
        }
        if($property->status==Config::get('app.property_status_sold')){
            return redirect()->back()->with('error-message', __('item.error_create'));
        }
        $reservation = Reservation::where([
                ['property_id', '=', $property->id],
                ['status', '=', 'booked']
            ])->latest()->first();
        if($request->method() =='GET'){
            if($property->status==Config::get('app.property_status_available')){
                $reservation=null;
            }
            $last_sale = SaleItem::latest()->first();
            $code = (isset($last_sale->id)?$last_sale->id:0) +1;
            $code ='S'.str_pad($code, 6, '0', STR_PAD_LEFT);
            $cus = Customer::get();
            $customers[null] = "-- ".__('item.select')." ".__('item.customer')." --";
            foreach ($cus as $key => $value) {
                $customers[$value->id] = $value->customer_no." | ".$value->last_name." ".$value->first_name." | ".$value->fax;
            }
            $em = Employee::get();
            $employees[null] = "-- ".__('item.select')." ".__('item.employee')." --";
            foreach ($em as $key => $value) {
                $employees[$value->id] = $value->last_name." ".$value->first_name;
            }
            $stage = PaymentStage::get();
            $payment_stages[null] = '-- '.__('item.select').' '.__('item.payment_stage').' --';
            $payment_stages['pay_full'] = '100%';
            foreach ($stage as $key => $value) {
                $payment_stages[$value->id] = __('ដំណាក់កាល :').'( $'.($value->amount*1).' )='.$value->remark.'';
            }
            $discount_types['cash'] = __('item.cash');
            $discount_types['discount_percent']='%';
            $cont = Contract::get();
            $contracts=[];
            foreach ($cont as $value) {
                $contracts[$value->id] = $value->title;
            }
            $loan_term_types['monthly'] =__('item.monthly');
            $loan_term_types['weekly'] =__('item.weekly');
            
            return view('back-end/sale_property/sale_form', compact('property', 'reservation', 'customers', 'code', 'payment_stages', 'discount_types', 'employees','contracts', 'loan_term_types'));
        }
        elseif($request->method() == 'POST'){
            $this->validate($request,[
                'date' => 'required|date',
                'payment_stage' => 'required',
                'contract' => 'required|numeric|min:1',
                'price' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'loan_term' => 'required|numeric|min:1',
                'loan_term_type' => 'required',
                'discount' => 'nullable|numeric|min:0',
                'remark' => 'nullable|max:255',
                'free_land_register' => 'nullable|min:1|max:1',
                'customer_partner_id' => 'nullable|min:1|numeric'
            ]);
            $deposit =0;
            if(empty($reservation)){
                $this->validate($request,[
                    'customer' => 'required',
                ]);
                $customer_id = $request->customer;
            }else{
                $customer_id = $reservation->customer_id;
                $deposit = $reservation->amount;
            }
            if($request->payment_stage!='pay_full'){
                $payment_stage = PaymentStage::find($request->payment_stage);
                // if($deposit>$payment_stage->amount){
                //     return redirect()->back()->with('error-message', __('item.payment_stage').'!!!');
                // }
            }
            $discount_percent=null;
            $discount_amount = 0;
            if($request->discount_type=='discount_percent'){
                $discount_percent = $request->discount;
                $discount_amount = $request->price*($request->discount/100);
            }else{
                $discount_amount = $request->discount;
            }
            $grand_total = $request->price;
            $grand_total -= $discount_amount;
            $payment_stage_amount =0;
            if($request->payment_stage=='pay_full'){
                $payment_stage_amount = $grand_total;
            }else{
                $payment_stage = PaymentStage::find($request->payment_stage);
                $payment_stage_amount = $payment_stage->amount;
            }
            // if($payment_stage_amount<$deposit){
            //     return redirect()->back()->with('error-message', 'Please check payment stage and deposit!');
            // }
            $date = date('Y-m-d', strtotime($request->date));
            $sale = SaleItem::create([
                'project_id' => $property->project_id,
                'penalty_of_late_payment' => $request->penalty_of_late_payment,
                'penalty' => $request->penalty,
                'property_id' => $property->id,
                'customer_id' => $customer_id,
                'customer_partner_id' => $request->customer_partner_id,
                'sale_date' => $date,
                'total_price' => $request->price,
                'discount_percent' => $discount_percent,
                'discount_amount' => $discount_amount,
                'deposit' => $deposit,
                'grand_total' => $grand_total,
                'total_loan_amount' => 0,
                'total_repay_amount' => $deposit,
                'is_free_land_register' => isset($request->free_land_register)?$request->free_land_register:0,
                'remark' => $request->remark,
                'status' => 'sold',
                'contract_id' => $request->contract,
                'created_by' => Auth::id()
            ]);
            if(!empty($reservation)){
                $reservation->status='sold';
                $reservation->save();
            }
            $property->status=Config::get('app.property_status_sold');
            $property->save();
            $loan = Loan::create([
                'sale_id' => $sale->id,
                'customer_id' => $customer_id,
                'loan_date' => $date,
                'loan_amount' => $payment_stage_amount,
                'outstanding_amount' => $payment_stage_amount-$deposit,
                'first_pay_date' => $date,
                'installment_term'=>$request->loan_term,
                'duration_type' => $request->loan_term_type,
                'interest_rate' =>0,
                'status' => Config::get('app.loan_status_loaned'),
                'created_by' => Auth::id()
            ]);
            if($loan->outstanding_amount<=0){
                $loan->status=Config::get('app.loan_status_completed');
                $loan->save();
            }
            $sale_installment_term = SaleInstallmentHelper::payment_term($payment_stage_amount ,$request->loan_term, $request->loan_term_type, $date, $date,0);
            $sche_deposit_amount =$deposit;
            foreach ($sale_installment_term as $key => $value) {
                $paid =0;
                $has_pay_date=0;
                $sche_payment_status=Config::get('app.payment_status_pending');
                if($sche_deposit_amount>0){
                    if($sche_deposit_amount>=$value['pay_total']){
                        $sche_deposit_amount-=$value['pay_total'];
                        $paid = $value['pay_total'];
                        $sche_payment_status=Config::get('app.payment_status_paid');
                    }else{
                        $paid = $sche_deposit_amount;
                        $sche_payment_status=Config::get('app.payment_status_partial');
                        $sche_deposit_amount=0;
                    }
                    $has_pay_date=1;
                }
                $pay_sche = PaymentSchedule::create([
                    'sale_id' => $sale->id,
                    'loan_id' => $loan->id,
                    'order' => $value['order'],
                    'customer_id' => $customer_id,
                    'payment_date' => date('Y-m-d', strtotime($value['pay_date'])),
                    'amount_to_spend' => $value['pay_total'],
                    'number_of_day' => $value['pay_gap'],
                    'principle' => $value['amount'],
                    'paid' => $paid,
                    'principle_balance' => $value['balance'],
                    'payment_status' => $sche_payment_status,
                    'status' => 'loaned',
                    'created_by' => Auth::id()
                ]);
                if($has_pay_date==1){
                    $pay_sche->actual_payment_date=$date;
                    $pay_sche->save();
                }
            } 
            $sale->total_loan_amount = $payment_stage_amount;
            $sale->grand_total -= $payment_stage_amount;
            if(!empty($request->employee) && !empty($request->commission)){
                $sale->commission_amount = $request->commission;
                $sale->employee_id = $request->employee;
                Transaction::create([
                    'date' => $date,
                    'sale_id' => $sale->id,
                    'project_id' => $property->project_id,
                    'property_id' => $property->id,
                    'employee_id' => $request->employee,
                    'amount' => $request->commission*(-1),
                    'created_by' => Auth::id()
                ]);
            }
            $sale->save();
            return redirect()->route('sale_property.view_sale', ['property'=>$property->id])->with('message', __('item.success_create'));
        }
        
    }
    
    public function get_preview_schedule_first_pay(Request $request){
         $data['html'] ='';
        if(!empty($request->all())){
            $date = date('Y-m-d', strtotime($request->date));
            $next_date = Carbon::parse($date)->addMonths(1);
            $amount=0;
            $total_balance =0;
            if($request->stage=='pay_full'){
                $amount = $request->total*1;
            }else{
                $payment_stage = PaymentStage::find($request->stage);
                $amount = $payment_stage->amount*1;
                $total_balance =$request->total-$payment_stage->amount;
            }
            $interest_rate = $request->interest_rate*1;
            $sale_payment_terms = SaleInstallmentHelper::payment_term($amount ,$request->loan_term, $request->loan_term_type, $date, $date,$interest_rate);
            $deposit_amount = $request->deposit;
            foreach ($sale_payment_terms as $key => $value) {
                $paid =0;
                if($deposit_amount>0){
                    if($deposit_amount>=$value['pay_total']){
                        $deposit_amount-=$value['pay_total'];
                        $paid = $value['pay_total'];
                    }else{
                        $paid = $deposit_amount;
                        $deposit_amount=0;
                    }
                }
                $data['html'] .='<tr>
                    <td>'.++$key.'</td>
                    <td class="text-center">'.date('d-m-Y', strtotime($value['pay_date'])).'</td>
                    <td class="text-right">USD</td>
                    <td class="text-right">$'.number_format($value['amount'],2).'</td>
                    <td class="text-right">$'.number_format($value['interest'],2).'</td>
                    <td class="text-right">$'.number_format($value['pay_total'],2).'</td>
                    <td class="text-right">$'.number_format($paid,2).'</td>
               </tr>';
            }
            $data['html'] .='<tr>
                <th>Total​ Balance :</th>
                <th colspan="6">$'.number_format($total_balance,2).'</th>
           </tr>';
        }
        return $data;
    }
    public function view_sale(Property $property){
        if(!Auth::user()->can('view-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(!$property){
            return redirect()->back()->with('error-message', __('item.not_found'));
        }
        if($property->status!=Config::get('app.property_status_sold')){
            return redirect()->back()->with('error-message', __('item.not_found'));
        }
        $sale = SaleItem::where('property_id', '=', $property->id)->where('status', '<>', 'cancel')->latest()->first();
        $customer = Customer::find($sale->customer_id);
        $address = DB::table('customers')
        ->select('customers.*',
            'prov.province_kh_name as prov_name',
            'com.commune_namekh as com_kh',
            'vil.village_namekh as vil_kh',
            'dis.district_namekh as dis_kh'
            
        )
       
        ->join('provinces as prov', 'customers.province', '=', 'prov.province_id')
        ->join('communes as com', 'customers.commune', '=', 'com.com_id')
        ->join('villages as vil', 'customers.village', '=', 'vil.vill_id')
        ->join('districts as dis', 'customers.district', '=', 'dis.dis_id')
        ->where('customers.id', '=', $sale->customer_id)
        ->first();
        $loan_first = Loan::where('sale_id','=', $sale->id)->whereNull('loan_type')->first();
        $loans = Loan::where('sale_id','=', $sale->id)->whereNotNull('loan_type')->get();
        $loanId = Loan::orderBy('id','desc')->where('sale_id','=', $sale->id)->first();
        $payment_schedule = PaymentSchedule::where('loan_id', '=', $loan_first->id)->first();
        $paid_off = PaymentTransaction::where('sale_id', '=', $sale->id)->whereNull('loan_id')->first();
        $project = Project::find($property->project_id);
        $land_address = [];
        $land=[];
        if($project){
            $land = Land::find($project->land_id);
            if($land){
                $land_address =  LandAddress::select(DB::raw('
                    land_id AS id,
                    province_kh_name AS province_name,
                    district_namekh AS district_name,
                    commune_namekh AS commune_name,
                    village_namekh AS village_name
                '))->where('land_id', $land->id)
                    ->join('provinces', 'pro_id', '=', 'province_id')
                    ->join('districts',  'district_id', '=', 'dis_id')
                    ->join('communes', 'commune_id', '=', 'com_id')
                    ->join('villages', 'village_id', '=', 'vill_id')
                    ->get();
            }
        }
        $loan = [];
       
        return view('back-end.sale_property.view_sale', compact('address','loan','property', 'customer', 'sale', 'loan_first','loans','payment_schedule','paid_off', 'land_address', 'land'));
    }
    function sale_payment(SaleItem $sale_item,Loan $loan,Request $request){
        if(!Auth::user()->can('sale-payment') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $payment_schedule = PaymentSchedule::where([
            ['loan_id', '=', $loan->id],
            ['payment_status', '<>', 'paid']
        ])->first();
        if(empty($payment_schedule) || $payment_schedule->payment_status=='paid'){
            return redirect()->back()->with('error-message', __('item.not_found'));
        }
        if ($request->method()=='GET') {
            $payment_transaction = PaymentTransaction::orWhereNull('deleted_at')->latest()->first();
            $code = (isset($payment_transaction->id)?$payment_transaction->id:0) +1;
            $code ='P'.str_pad($code, 6, '0', STR_PAD_LEFT);
            $customer =Customer::find($sale_item->customer_id);
            return view('back-end.sale_property.sale_payment_form', compact('sale_item', 'loan', 'code', 'customer', 'payment_schedule'));
        }
        elseif($request->method()=='POST'){
            $this->validate($request,[
                'date' => 'required|date',
                'amount' => 'required|numeric|min:0',
                'penalty' => 'nullable|numeric|min:0',
                'discount' => 'nullable|numeric|min:0'
            ]);
            $date = date('Y-m-d', strtotime($request->date));
            $amount = $request->amount;
            $penalty = $request->penalty;
            $discount = $request->discount;
            $payment_schedule->actual_payment_date = $date;
            $amount_to_spend = $payment_schedule->amount_to_spend+$penalty-$discount;
            $payment_schedule->penalty_amount += $penalty;
            $payment_schedule->discount_amount += $discount;
            
            $p_total = $payment_schedule->paid+$amount;
            if($amount_to_spend<=$p_total){
                $partial ='paid';
                $loan->status = Config::get('app.loan_status_completed');
            }
            $payment_schedule->amount_to_spend=$amount_to_spend;
            $payment_schedule->paid += $amount;
            $payment_schedule->payment_status = 'partial';
            $payment_schedule->updated_by = Auth::id();
            $payment_schedule->save();
            $payment_transaction = PaymentTransaction::create([
                'project_id' => $sale_item->project_id,
                'property_id' => $sale_item->property_id,
                'payment_date' => $date,
                'sale_id' => $sale_item->id,
                'loan_id' => $loan->id,
                'payment_schedule_id' => $payment_schedule->id,
                'customer_id' => $sale_item->customer_id,
                'amount' => $amount,
                'remark' => $request->remark,
                'created_by' => Auth::id()
            ]);
            Transaction::create([
                'project_id' => $sale_item->project_id,
                'property_id' => $sale_item->property_id,
                'date' => $date,
                'payment_transaction_id' => $payment_transaction->id,
                'sale_id' => $sale_item->id,
                'loan_id' => $loan->id,
                'payment_schedule_id' => $payment_schedule->id,
                'customer_id' => $sale_item->customer_id,
                'amount' => $amount,
                'remark' => 'sale payment',
                'created_by' => Auth::id()
            ]);
            if(($amount+$penalty+$discount) > $payment_schedule->principle){
                $loan->outstanding_amount-=$payment_schedule->principle;
            }else{
                $loan->outstanding_amount-=$amount-$penalty+$discount;
            }
            $loan->save();
            if ($sale_item->grand_total==0 && $loan->outstanding_amount<=0) {
                $count_has_schedule = PaymentSchedule::where([
                    ['loan_id', '=', $loan->id],
                    ['payment_status', '<>', 'paid']
                ])->get()->count();
                if($count_has_schedule==0 && $this->all_loan_paid_for_complete_sale($sale_item->id)){
                    $sale_item->status = 'completed';
                }
            }
            $sale_item->total_repay_amount+=$amount+$penalty-$discount;
            $sale_item->save();
            return redirect()->route('sale_property.sale_payment_receipt',['id'=>$payment_transaction->id,'day_penalty'=>$reday_penalty, 'back' => 1])->with('message', __('item.success_create'));
        }
    }
    public function view_sale_first_payment(Request $request){
        $reservation = Reservation::where([
                ['property_id', '=', $request->property],
                ['customer_id', '=', $request->customer],
                ['status', '=', 'sold']


            ])->latest()->first();
        $payment_transactions = PaymentTransaction::select('id','reference', 'amount', 'payment_date', 'is_cancel')
        ->where('payment_schedule_id', '=', $request->payment_schedule);
        $payment_schedule = PaymentSchedule::find($request->payment_schedule);
        $order_schedules = PaymentSchedule::where('loan_id', '=', $payment_schedule->loan_id)
        ->where([
            ['payment_status', '<>', 'pending'],
            ['order', '>', $payment_schedule->order]
        ])->get()->count();
        if(!empty($reservation)){
            $payment_transactions = $payment_transactions->orWhere('reservation_id', '=', $reservation->id);
        }
        $payment_transactions = $payment_transactions->get();
        $data['html']="";
        foreach ($payment_transactions as $key => $value) {
             $background='';
            if($value->is_cancel==1){
                $background='style="background:#ca7b7b54;"';
            }
            $data['html'].='<tr '.$background.'>
                                <td>'.($key+1).'</td>
                                <td><a href="'.route('sale_property.sale_payment_receipt',['id'=>$value->id]).'" target="_blank">'.$value->reference.'</a></td>
                                <td>'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                                <td class="text-right">$'.number_format($value->amount,2).'</td>';
            if($value->is_cancel==1){
                $data['html'].='<td class="text-right"><a " style="cursor: no-drop; opacity:07"><span class="rounded p-1 badge-danger">'.__('item.cancel').'</span></a></td>';
            }else{
                $this_order_transaction = DB::table('payment_transactions')->where([
                    ['payment_schedule_id', '=', $payment_schedule->id],
                    ['id', '>', $value->id],
                    ['is_cancel', '<>', 1]
                ])->get()->count();
                if($this_order_transaction>0 || $order_schedules>0){
                    $data['html'].='<td class="text-right"><a " style="cursor: no-drop; opacity:07"><span class="rounded p-1 badge-danger">'.__('item.cancel').'</span></a></td>';
                }else{
                    $data['html'].='<td class="text-right"><a onclick="cancel_sale_payment('.$value->id.')" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.cancel').'</span></a></td>';
                }
            }
        }
        return $data;
    }
    function sale_payment_receipt($id){
        $payment_transaction = PaymentTransaction::find($id);
        $sale_item = SaleItem::find($payment_transaction->sale_id);
        $customer = Customer::find($payment_transaction->customer_id);
        
        $address = DB::table('customers')
        ->select('customers.*',
            'prov.province_kh_name as prov_name',
            'com.commune_namekh as com_kh',
            'vil.village_namekh as vil_kh',
            'dis.district_namekh as dis_kh'
            
        )
       
        ->join('provinces as prov', 'customers.province', '=', 'prov.province_id')
        ->join('communes as com', 'customers.commune', '=', 'com.com_id')
        ->join('villages as vil', 'customers.village', '=', 'vil.vill_id')
        ->join('districts as dis', 'customers.district', '=', 'dis.dis_id')
        ->where('customers.id', '=', $payment_transaction->customer_id)
        ->first();

        $project = Project::find($payment_transaction->project_id);
        $property = Property::find($payment_transaction->property_id);
        $created_by = User::select('name')->find($payment_transaction->created_by);
        
        if(!is_null($payment_transaction->reservation_id)){
            $reservation =  Reservation::find($payment_transaction->reservation_id);
            return view('back-end.sale_property.receipt_booking', compact('property', 'reservation', 'customer', 'project', 'created_by', 'payment_transaction'));
        }else{
            $loan = Loan::find($payment_transaction->loan_id);
            $day_penalty = 
            $payment_schedule = PaymentSchedule::find($payment_transaction->payment_schedule_id);
            $payment_schedule_next = PaymentSchedule::where([
                ['loan_id', '=', $payment_schedule->loan_id],
                ['order', '>', $payment_schedule->order]
            ])
            ->first();
            $day_penalty = Input::get('day_penalty',false);
            return view('back-end.sale_property.receipt_payment', compact('address','day_penalty','property','sale_item', 'payment_schedule', 'loan','customer', 'project', 'created_by', 'payment_transaction','payment_schedule_next'))->with('can_redirect_back', Request()->back);
        }
    }
 
    function create_loan(SaleItem $sale_item, Request $request){
        if(!Auth::user()->can('create_loan') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if($this->has_loan_is_not_completed($sale_item->id) || $sale_item->status=='completed'){
            return redirect()->back()->with('error-message', __('item.can_not_create_loan'));
        }
        if($request->method()=='GET'){
            $last_loan = Loan::orWhereNull('deleted_at')->latest()->first();
            $last_id = (isset($last_loan->id)?$last_loan->id:0)+1;
            $code = 'LNI-'.str_pad($last_id, 6, '0', STR_PAD_LEFT);
            $customer = Customer::find($sale_item->customer_id);
            $loan_types[NULL] = '-- '.__('item.select').' '.__('item.loan_type').' --';
            $loan_types[Config::get('app.type_free_interest')] = __('item.loan_type_free_interest');
            $loan_types[Config::get('app.type_simple')] = __('item.loan_type_simple');
            $loan_types[Config::get('app.type_eoc')] = __('item.loan_type_eoc');
            $loan_types[Config::get('app.type_emi')] =  __('item.loan_type_emi');
            $loan_types[Config::get('app.type_installment')] = __('-- Select Loan Type --');
            $loan_term_types['monthly'] =__('item.monthly');
            $loan_term_types['weekly'] =__('item.weekly');
            $loan_term_types['day'] =__('item.daily');
            $stage = PaymentStage::get();
            $payment_stages[null] = '-- '.__('item.select').' '.__('item.payment_stage').' --';
            $payment_stages['pay_full'] = '100%';
            foreach ($stage as $key => $value) {
                $payment_stages[$value->id] = __('ដំណាក់កាល :').'( $'.($value->amount*1 ).' )='.$value->remark.'';
            }
            return view('back-end.sale_property.loan_form', compact('sale_item', 'code', 'customer', 'loan_types', 'payment_stages','loan_term_types'));
        }elseif ($request->method()=='POST') {
            $this->validate($request,[
                'date' => 'required|date',
                'amount' => 'required|numeric|min:0|max:'.$sale_item->grand_total*1,
                'loan_type' => 'required',
                'loan_term' => 'required|numeric|min:1',
                'loan_term_type' => 'required',
                'periodic_payment' => 'nullable|numeric|min:0',
                'interest_rate' => 'nullable|numeric|min:0|max:100',
                'payment_start_date' =>'required|date',
                'paynalty_of_late_payment' =>'nullable|numeric|min:0'
            ]);
            $schedules = InstallmentHelper::generate_installment_schedule(
                $request->loan_type,
                $request->amount,
                $request->loan_term,
                $request->loan_term_type,
                $request->date,
                $request->payment_start_date,
                $request->interest_rate
            );
            // if(empty($schedules)){
            //     return redirect()->back()->with('error-message', __('itemplease_check'));
            // }
            {
                $user_id = Auth::id();
                $request_date = date('Y-m-d', strtotime($request->date));
                $first_pay_date = date('Y-m-d', strtotime($request->payment_start_date));
                $loan = Loan::create([
                    'sale_id' => $sale_item->id,
                    'customer_id' => $sale_item->customer_id,
                    'loan_date' => $request_date,
                    'loan_type' => $request->loan_type,
                    'loan_amount' => $request->amount,
                    'outstanding_amount' => $request->amount,
                    'first_pay_date' => $first_pay_date,
                    'installment_term'=>$request->loan_term,
                    'duration_type' => $request->loan_term_type,
                    'interest_rate' =>$request->interest_rate,
                    'status' => Config::get('app.loan_status_loaned'),
                    'created_by' => $user_id
                ]);
                foreach ($schedules as $key => $value) {
                    PaymentSchedule::create([
                        'order' => $value['order'],
                        'sale_id' => $sale_item->id,
                        'loan_id' => $loan->id,
                        'customer_id' => $sale_item->customer_id,
                        'number_of_day' => $value['pay_gap'],
                        'payment_date' => date('Y-m-d',strtotime($value['pay_date'])),
                        'amount_to_spend' => $value['pay_total'],
                        'principle' => $value['amount'],
                        'paid' => 0,
                        'principle_balance' => $value['balance'],
                        'interest_type' => 'percent',
                        'interest' => $request->interest_rate,
                        'total_interest' => $value['interest'],
                        'penalty_percent' => $request->paynalty_of_late_payment,
                        'payment_status' => 'pending',
                        'status' => Config::get('app.loan_status_loaned'),
                        'created_by' => $user_id
                    ]);
                }
                $sale_item->total_loan_amount+=$request->amount;
                $sale_item->grand_total -= $request->amount;
                $sale_item->save();
                return redirect()->route('sale_property.view_sale',['property'=>$sale_item->property_id])->with('message', _('item.success_create'));
            }
        }
    }
    function get_payment_stage_amount(Request $request){
        $data['amount'] = $request->amount*1 -$payment_stage->deposit;
        if($request->payment_stage){
            if($request->payment_stage!='pay_full'){
                $payment_stage = PaymentStage::find($request->payment_stage);
                if($payment_stage){
                    $data['amount'] = $payment_stage->amount*1 -$payment_stage->deposit;
                }
            }
        }
        return $data;
    }
    function get_payment_schedule(Request $request){
        $principle_balance = $request->principle_balance;
        $schedules = InstallmentHelper::generate_installment_schedule(
            $request->loan_type,
            $request->amount,
            $request->loan_term,
            $request->loan_term_type,
            $request->loan_date,
            $request->payment_start_date,
            $request->interest_rate
        );
        $data['html'] ='';
        $total_amount=0;
        $total_interest_rate=0;
        if(empty($schedules)){
            $data['html'].='<tr><td colspan="9" class="text-center">'.__('item.no_data').'!</td></tr>';
        }else{
            foreach ($schedules as $key => $value) {
                $total_amount += $value['amount'];
                $total_interest_rate += $value['interest'];
                $data['html'] .='<tr>
                                    <td class="text-center">'.($value['order']).'</td>
                                    <td class="text-center">'.date('d-m-Y',strtotime($value['pay_date'])).'</td>
                                    <td class="text-center">'.__('item.usd').'</td>
                                    <td class="text-right">'.number_format($value['pay_total'],2).'</td>
                                    <td class="text-right">'.number_format($value['interest'],2).'</td>
                                    <td class="text-right">'.number_format($value['amount'],2).'</td>
                                    <td class="text-right">'.number_format($value['balance'],2).'</td>
                                </tr>';
            }
            $data['html'].='<tr>
                                <td class="text-center">'.__('item.total').'</td>
                                <td class="text-center"></td>
                                <td class="text-center">'.__('item.usd').'</td>
                                <td class="text-right">'.number_format($total_amount,2).'</td>
                                <td class="text-right">'.number_format($total_interest_rate,2).'</td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>';
        }
        return $data;
    }
    public function view_loan_schedule(Request $request){
        if(empty($request->loan)){
            $data['html']="";
            return $data;
        }else{
            $payment_schedules = PaymentSchedule::where('loan_id', '=', $request->loan['id'])->get();
            $sale = DB::table('sale_items')->where('id',$request->loan['sale_id'])->first();
            $data['html']="";
            $can_pay =1;
            foreach ($payment_schedules as $key => $value) {
               
                $plus_payment_date = date('Y-m-d', strtotime($value->payment_date . " +".$sale->penalty_of_late_payment."day"));
                if((strtotime($plus_payment_date) < strtotime(date("Y-m-d")) && $value->payment_status=='pending') || (strtotime($plus_payment_date) < strtotime(date("Y-m-d")) && $value->payment_status=='partial'&& $value->paid>0 && $value->paid<$value->amount_to_spend) )
                {
                    $month_pay = 0;
                    $partial_pay =0;
                    //total penalty
                    if($value->payment_status=='partial')
                    {
                        $plus_payment_date = date('Y-m-d', strtotime($value->actual_payment_date . " +".$sale->penalty_of_late_payment."day"));
                       
                        $total_penalty = number_format(($per_day_penalty = date("d") - date('d', strtotime($plus_payment_date))) * $sale->penalty ,2);
                        if($total_penalty<=0)
                        {
                            $total_penalty=0;
                           $partial_total = $value->amount_to_spend -$value->paid;
                           $month_pay = $partial_total;
                           $partial_pay = $month_pay;
                        }else{
                            $partial_total = $value->amount_to_spend + $total_penalty;
                            $month_pay = $partial_total;
                            $partial_pay = $month_pay;
                        }
                    }else{
                        $total_penalty = number_format(($per_day_penalty = date("d") - date('d', strtotime($plus_payment_date))) * $sale->penalty ,2);
                        $partial_total = $value->amount_to_spend + $total_penalty;
                        $month_pay = $partial_total-$total_penalty;
                        $partial_pay = $month_pay;
                    }
                    
                    
                    $data['html'].='<tr style = "background-color:red">
                    <td style="font-family:Khmer os System;font-size:18px">'.($key+1).'</td>
                    <td style="font-family:Khmer os System;font-size:18px">'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                    <td class="text-center" style="font-family:Khmer os System;font-size:18px">'.$sale->penalty_of_late_payment.'</td>
                    <td class="text-center" style="font-family:Time New Roman">'.__('item.usd').'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px;color:blue">'.number_format($partial_pay ,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px;color:black">'.$total_penalty.'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($month_pay,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->total_interest,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($partial_total,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle_balance,2).'</td>';
                    $data['html'].='<td class="text-right" style="font-family:Time New Roman;font-size:18px">'.number_format($value->paid,2).'</td>';
                    if($value->payment_status=='pending'){
                        $data['html'].='<td class="text-center"><span class="rounded p-1 badge-warning">'.__('item.pending').'</span></td>';
                    }elseif($value->payment_status=='partial'){
                        $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-primary">'.__('item.partial').'</span></a></td>';
                    }else{
                        $can_pay =1;
                        $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer; " onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-success">'.__('item.paid').'</span></a></td>';
                    }
                    if($value->payment_status!='paid'){
                        if($can_pay){
                            $can_pay =0;
                            $data['html'].='<td class="text-right"><a href="'.route('sale_property.loan_payment',['payment_schedule' => $value]).'" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                        }else{
                            $data['html'].='<td class="text-right"><a href="'.route('sale_property.loan_payment',['payment_schedule' => $value]).'" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                        }
                    }

                    $data['html'].='</tr>';
                 
                }
                
                
                else if(strtotime($value->payment_date) < strtotime(date("Y-m-d")) && strtotime($plus_payment_date) >= strtotime(date("Y-m-d")) && $value->payment_status=='pending')
                {
                    $data['html'].='<tr style = "background:yellow;">
                    <td style="font-family:Time New Roman;font-size:18px">'.($key+1).'</td>
                    <td style="font-family:Time New Roman;font-size:18px">'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                    <td class="text-center" style="font-family:Khmer os System;font-size:18px">'.$sale->penalty_of_late_payment.'</td>
                    <td class="text-center" style="font-family:Time New Roman">'.__('item.usd').'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px;color:blue">'.number_format($value->amount_to_spend - $value->paid,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format(0,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->total_interest,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle_balance,2).'</td>';
                    $data['html'].='<td class="text-right" style="font-family:Time New Roman;font-size:18px">'.number_format($value->paid,2).'</td>';
                    if($value->payment_status=='pending'){
                        $data['html'].='<td class="text-center"><span class="rounded p-1 badge-warning">'.__('item.pending').'</span></td>';
                    }elseif($value->payment_status=='partial'){
                        $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-primary">'.__('item.partial').'</span></a></td>';
                    }else{
                        $can_pay =1;
                        $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer; " onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-success">'.__('item.paid').'</span></a></td>';
                    }
                    if($value->payment_status!='paid'){
                        if($can_pay){
                            $can_pay =0;
                            $data['html'].='<td class="text-right"><a href="'.route('sale_property.loan_payment',['payment_schedule' => $value]).'" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                        }else{
                            $data['html'].='<td class="text-right"><a style="cursor: no-drop; opacity:07"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                        }
                    }

                    $data['html'].='</tr>';
                }
                else if(number_format($value->amount_to_spend - $value->paid,2)=="0.00" )
                {
                    $data['html'].='<tr style = "background:rgb(87, 243, 87);">
                    <td style="font-family:Khmer os System;font-size:18px">'.($key+1).'</td>
                    <td style="font-family:Khmer os System;font-size:18px">'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                    <td class="text-center" style="font-family:Khmer os System;font-size:18px">'.$sale->penalty_of_late_payment.'</td>
                    <td class="text-center" style="font-family:Time New Roman">'.__('item.usd').'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px;color:blue">'.number_format($value->amount_to_spend - $value->paid,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format(0,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->total_interest,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                    <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle_balance,2).'</td>';
                    $data['html'].='<td class="text-right" style="font-family:Time New Roman;font-size:18px">'.number_format($value->paid,2).'</td>';
                    if($value->payment_status=='pending'){
                        $data['html'].='<td class="text-center"><span class="rounded p-1 badge-warning">'.__('item.pending').'</span></td>';
                    }elseif($value->payment_status=='patial'){
                        $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-primary">'.__('item.partial').'</span></a></td>';
                    }else{
                        $can_pay =1;
                        $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer; " onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-success">'.__('item.paid').'</span></a></td>';
                    }
                    if($value->payment_status!='paid'){
                        if($can_pay){
                            $can_pay =0;
                            $data['html'].='<td class="text-right"></td>';
                        }else{
                            $data['html'].='<td class="text-right"><a style="cursor: no-drop; opacity:07"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                        }
                    }

                    $data['html'].='</tr>';
                 
                }
                else
                {
                    if($value->paid==$value->amount_to_spend){
                        $data['html'].='<tr style="background-color:rgb(87, 243, 87)" >
                        <td style="font-family:Time New Roman;font-size:18px">'.($key+1).'</td>
                        <td style="font-family:Time New Roman;font-size:18px">'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                        <td class="text-center" style="font-family:Khmer os System;font-size:18px;">'.$sale->penalty_of_late_payment.'</td>
                        <td class="text-center" style="font-family:Time New Roman">'.__('item.usd').'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px;color:blue">'.number_format($value->amount_to_spend - $value->paid,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format(0,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->total_interest,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle_balance,2).'</td>';
                        $data['html'].='<td class="text-right" style="font-family:Time New Roman;font-size:18px">'.number_format($value->paid,2).'</td>';
                        if($value->payment_status=='pending'){
                            $data['html'].='<td class="text-center"><span class="rounded p-1 badge-warning">'.__('item.pending').'</span></td>';
                        }elseif($value->payment_status=='partal'){
                            $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-primary">'.__('item.partial').'</span></a></td>';
                        }else{
                            $can_pay =1;
                            $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-success">'.__('item.paid').'</span></a></td>';
                        }
                        if($value->payment_status!='paid'){
                            if($can_pay){
                                $can_pay =0;
                            }else{
                                $data['html'].='<td class="text-right"><a style="cursor: no-drop; opacity:07"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                            }
                        }
    
                        $data['html'].='</tr>';
                    }
                    elseif($value->payment_status=='partial'){
                        $data['html'].='<tr style="background-color:yellow" >
                        <td style="font-family:Time New Roman;font-size:18px">'.($key+1).'</td>
                        <td style="font-family:Time New Roman;font-size:18px">'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                        <td class="text-center" style="font-family:Khmer os System;font-size:18px;">'.$sale->penalty_of_late_payment.'</td>
                        <td class="text-center" style="font-family:Time New Roman">'.__('item.usd').'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px;color:blue">'.number_format($value->amount_to_spend - $value->paid,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format(0,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->total_interest,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle_balance,2).'</td>';
                        $data['html'].='<td class="text-right" style="font-family:Time New Roman;font-size:18px">'.number_format($value->paid,2).'</td>';
                        if($value->payment_status=='pending'){
                            $data['html'].='<td class="text-center"><span class="rounded p-1 badge-warning">'.__('item.pending').'</span></td>';
                        }elseif($value->payment_status=='partial'){
                            $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-primary">'.__('item.partial').'</span></a></td>';
                        }else{
                            $can_pay =1;
                            $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-success">'.__('item.paid').'</span></a></td>';
                        }
                        if($value->payment_status!='paid'){
                            if($can_pay){
                                $can_pay =0;
                                $data['html'].='<td class="text-right"><a href="'.route('sale_property.loan_payment',['payment_schedule' => $value]).'" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                            }else{
                                $data['html'].='<td class="text-right"><a href="'.route('sale_property.loan_payment',['payment_schedule' => $value]).'" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                            }
                        }
    
                        $data['html'].='</tr>';
                    }
                    else{
                        $data['html'].='<tr >
                        <td style="font-family:Time New Roman;font-size:18px">'.($key+1).'</td>
                        <td style="font-family:Time New Roman;font-size:18px">'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                        <td class="text-center" style="font-family:Khmer os System;font-size:18px;">'.$sale->penalty_of_late_payment.'</td>
                        <td class="text-center" style="font-family:Time New Roman">'.__('item.usd').'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px;color:blue">'.number_format($value->amount_to_spend - $value->paid,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format(0,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->total_interest,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->amount_to_spend,2).'</td>
                        <td class="text-center" style="font-family:Time New Roman;font-size:18px">'.number_format($value->principle_balance,2).'</td>';
                        $data['html'].='<td class="text-right" style="font-family:Time New Roman;font-size:18px"> '.number_format($value->paid,2).'</td>';
                        if($value->payment_status=='pending'){
                            $data['html'].='<td class="text-center"><span class="rounded p-1 badge-warning">'.__('item.pending').'</span></td>';
                        }elseif($value->payment_status=='partial'){
                            $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-primary">'.__('item.partial').'</span></a></td>';
                        }else{
                            $can_pay =1;
                            $data['html'].='<td class="text-center"><a data-toggle="modal" data-target="#paymentModal" style="cursor: pointer;" onclick="view_loan_payment('.$value->id.')"><span class="rounded p-1 badge-success">'.__('item.paid').'</span></a></td>';
                        }
                        if($value->payment_status!='paid'){
                            if($can_pay){
                                $can_pay =0;
                                $data['html'].='<td class="text-right"><a href="'.route('sale_property.loan_payment',['payment_schedule' => $value]).'" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                            }else{
                                $data['html'].='<td class="text-right"><a href="'.route('sale_property.loan_payment',['payment_schedule' => $value]).'" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.pay').'</span></a></td>';
                            }
                        }
    
                        $data['html'].='</tr>';

                    }
                    }
                   
               
            }
            return $data;
        }
    }
    public function view_schedule(Request $request){
        
        if(empty($request->loan)){
            $data['html']="";
            return $data;
        }else{
            $payment_schedules = PaymentSchedule::where('loan_id', '=', $request->loan['id'])->get();
            $sale = DB::table('sale_items')->where('id',$request->loan['sale_id'])->first();
            $customer = DB::table('sale_items')->where('id',$request->loan['customer_id'])->first();
            // $loan = DB::table('loans')->where('sale_id',$sale->id)->first();
            $data_array = [];
            $data['html']="";
            $payment_schedule['html']="";
            $can_pay =1;
            $loanId = Loan::orderBy('id','desc')->where('sale_id','=', $sale->id)->first();
            $payment_schedule = PaymentSchedule::where('loan_id', '=', $loanId->id)->first();
            $payment_schedule['html'] = $payment_schedule;
            $data['html'] ='';
            $total_amount1=0;
            $total_interest_rate1=0;
            $total_price=0;
            foreach ($payment_schedules as $key => $value) {
                $total_amount1 += $value['amount_to_spend'];
                $total_interest_rate1 += $value['total_interest'];
                $total_price += $value['principle'];
                    $data['html'].='<tr style = "">
                    <td style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px">'.($key+1).'</td>
                    <td style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px">'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                    <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px">$ '.number_format($value->amount_to_spend,2).'</td>
                    <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px">$ '.number_format($value->total_interest,2).'</td>
                    <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px">$ '.number_format($value->principle,2).'</td>
                    <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px">$ '.number_format($value->principle_balance,2).'</td>';
                    $data['html'].='</tr>';
               
                }
                $data['html'].='<tr>
                <td class="text-center" style="border:1px solid black;padding:0;font-family:Khmer OS Muol light;font-size:17px">'.__('item.total').'</td>
                <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px"></td>
                <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px;font-weight:bold">$ '.number_format($total_amount1,2).'</td>
                <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px;font-weight:bold">$ '.number_format($total_interest_rate1,2).'</td>
                <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px;font-weight:bold">$ '.number_format ($total_price,2).'</td>
                <td class="text-center" style="border:1px solid black;padding:0;font-family:Time New Roman;font-size:17px"></td>
            </tr>';
               
            }
            $data_array = [
                "data"=>$data['html'],
                "payment_schedule"=>$payment_schedule->total_interest
            ];
            return $data_array;
        
    }
    function loan_payment(PaymentSchedule $payment_schedule,Request $request){
        if(!Auth::user()->can('loan-payment') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $loan = Loan::find($payment_schedule->loan_id);
        $members = PaymentSchedule::where('loan_id','=', $payment_schedule->loan_id)
        ->where([
            ['order', '<', $payment_schedule->order],
            ['payment_status', '<>', 'paid']
        ])->get();
        $sale_item = SaleItem::findOrFail($payment_schedule->sale_id);
        if($payment_schedule->payment_status=='paid'){
            if($payment_schedule->payment_status=='paid' || empty($loan) || $members->count()>0 ){
            return redirect()->route('sale_property.view_sale',['property'=>$sale_item->property_id])->with('error-message', __('item.not_found'));
            }
            elseif(strtotime($value->payment_date) < strtotime(date("Y-m-d"))){

            }
        } 
        if ($request->method()=='GET') {
            $payment_transaction = PaymentTransaction::orWhereNull('deleted_at')->latest()->first();
            $code = (isset($payment_transaction->id)?$payment_transaction->id:0) +1;
            $code ='P'.str_pad($code, 6, '0', STR_PAD_LEFT);
            $customer =Customer::find($payment_schedule->customer_id);
            return view('back-end.sale_property.loan_payment_form', compact('loan', 'code', 'customer','sale_item', 'payment_schedule'));
        }
        elseif($request->method()=='POST'){
            $this->validate($request,[
                'date' => 'required|date',
                'amount' => 'required|numeric|min:0',
                'penalty' => 'nullable|numeric|min:0',
                'discount' => 'nullable|numeric|min:0'
            ]);
            $date = date('Y-m-d', strtotime($request->date));
            if($request->selectStatus=="paid")
            {
                $amount = $request->total1;
            }else{
                $amount = $request->amount;
            }
           
            $penalty = $request->penalty;
            $discount = $request->discount;
            $payment_schedule->actual_payment_date = $date;
            $amount_to_spend = $payment_schedule->amount_to_spend+$penalty-$discount;
            $payment_schedule->penalty_amount += $penalty;
            $payment_schedule->discount_amount += $discount;
            
            $p_total = $payment_schedule->paid+$amount;
            if($amount_to_spend<=$p_total){
                $partial ='paid';
                $payment_schedules = PaymentSchedule::where([
                    ['loan_id', '=', $loan->id],
                    ['id', '>', $payment_schedule->id]
                ])->get()->count();
                if($payment_schedules<=0){
                    $loan->status = Config::get('app.loan_status_completed');
                }
            }
            $payment_schedule->amount_to_spend=$amount_to_spend;
            $payment_schedule->paid += $amount;
            $payment_schedule->payment_status = 'partial';
            $payment_schedule->updated_by = Auth::id();
            $payment_schedule->save();
            $payment_transaction = PaymentTransaction::create([
                'project_id' => $sale_item->project_id,
                'property_id' => $sale_item->property_id,
                'payment_date' => $date,
                'sale_id' => $sale_item->id,
                'loan_id' => $loan->id,
                'payment_schedule_id' => $payment_schedule->id,
                'customer_id' => $sale_item->customer_id,
                'amount' => $amount,
                'remark' => $request->remark,
                'created_by' => Auth::id()
            ]);
            Transaction::create([
                'project_id' => $sale_item->project_id,
                'property_id' => $sale_item->property_id,
                'date' => $date,
                'payment_transaction_id' => $payment_transaction->id,
                'sale_id' => $sale_item->id,
                'loan_id' => $loan->id,
                'payment_schedule_id' => $payment_schedule->id,
                'customer_id' => $sale_item->customer_id,
                'amount' => $amount,
                'remark' => 'loan payment',
                'created_by' => Auth::id()
            ]);
            if(($amount+$penalty+$discount) > $payment_schedule->principle){
                $loan->outstanding_amount-=$payment_schedule->principle;
            }else{
                $loan->outstanding_amount-=$amount-$penalty+$discount;
            }
            $loan->save();
            if ($sale_item->grand_total==0) {
                $count_has_schedule = PaymentSchedule::where([
                    ['loan_id', '=', $loan->id],
                    ['payment_status', '<>', 'paid']
                ])->get()->count();
                if($count_has_schedule==0 && $this->all_loan_paid_for_complete_sale($sale_item->id)){
                    $sale_item->status = 'completed';
                }
            }
            $sale_item->total_repay_amount+=$amount;
            $sale_item->save();
            return redirect()->route('sale_property.sale_payment_receipt',['id'=>$payment_transaction->id,'day_penalty'=>$request->day_penalty, 'back'=>1])->with('message', __('item.success_create'));
        }
    }
    public function view_loan_payment(Request $request){
        $payment_transactions = PaymentTransaction::select('id','reference', 'amount', 'payment_date','is_cancel')
        ->where('payment_schedule_id', '=', $request->payment_schedule);
        $payment_transactions = $payment_transactions->get();
        $payment_schedule = PaymentSchedule::find($request->payment_schedule);
        $order_schedules = PaymentSchedule::where('loan_id', '=', $payment_schedule->loan_id)
        ->where([
            ['payment_status', '<>', 'pending'],
            ['order', '>', $payment_schedule->order]
        ])->get()->count();
        $data['html']="";
        foreach ($payment_transactions as $key => $value) {
            $background='';
            if($value->is_cancel==1){
                $background='style="background:#ca7b7b54;"';
            }
            $data['html'].='<tr '.$background.'>
                                <td>'.($key+1).'</td>
                                <td><a href="'.route('sale_property.sale_payment_receipt',['id'=>$value->id]).'" target="_blank">'.$value->reference.'</a></td>
                                <td>'.date('d-m-Y', strtotime($value->payment_date)).'</td>
                                <td class="text-right">$'.number_format($value->amount,2).'</td>';
            if($value->is_cancel==1){
                $data['html'].='<td class="text-right"><a " style="cursor: no-drop; opacity:07"><span class="rounded p-1 badge-danger">'.__('item.cancel').'</span></a></td>';
            }else{
                $this_order_transaction = DB::table('payment_transactions')->where([
                    ['payment_schedule_id', '=', $payment_schedule->id],
                    ['id', '>', $value->id],
                    ['is_cancel', '<>', 1]
                ])->get()->count();
                if($this_order_transaction>0 || $order_schedules>0){
                    $data['html'].='<td class="text-right"><a " style="cursor: no-drop; opacity:07"><span class="rounded p-1 badge-danger">'.__('item.cancel').'</span></a></td>';
                }else{
                    $data['html'].='<td class="text-right"><a onclick="cancel_loan_payment('.$value->id.')" style="cursor: pointer;"><span class="rounded p-1 badge-danger">'.__('item.cancel').'</span></a></td>';
                }
            }
           $data['html'].='</tr>';
        }
        return $data;
    }
    public function cancel_loan_payment(Request $request){
        if(!Auth::user()->can('cancel-loan-payment') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $data['message'] =0;
        if(!empty($request->payment_transaction)){
            $payment_transaction = PaymentTransaction::find($request->payment_transaction);
            if(!empty($payment_transaction)){
                if($payment_transaction->amount<=0 || $payment_transaction->is_cancel==1){
                    return $data;
                }
                $payment_schedule = PaymentSchedule::find($payment_transaction->payment_schedule_id);
                $loan = Loan::find($payment_transaction->loan_id);
                if(!empty($loan) && !empty($payment_schedule)){
                    $sale_item = SaleItem::find($payment_schedule->sale_id);
                    if($loan->id==$payment_schedule->loan_id && !empty($sale_item) && $sale_item->status!='completed'){
                        $order_schedules = PaymentSchedule::where('loan_id', '=', $loan->id)
                        ->where([
                            ['payment_status', '<>', 'pending'],
                            ['order', '>', $payment_schedule->order]
                        ])->get()->count();
                        $this_order_transaction = DB::table('payment_transactions')->where([
                            ['payment_schedule_id', '=', $payment_schedule->id],
                            ['id', '>', $payment_transaction->id],
                            ['is_cancel', '<>', 1]
                        ])->get()->count();
                        if($order_schedules<=0 && $this_order_transaction<=0 && !$this->has_next_loan($loan->id)){
                            if(AppHelper::checkAdministrator()){
                                $amount = $payment_transaction->amount;
                                $penalty_amount = $payment_schedule->penalty_amount;
                                $discount_amount = $payment_schedule->discount_amount;
                                $payment_schedule->amount_to_spend -= $penalty_amount-$discount_amount;
                                $actual_payment_date =$payment_schedule->actual_payment_date;
                                $payment_schedule->penalty_amount = 0;
                                $payment_schedule->discount_amount =0;
                                if($payment_schedule->paid == $payment_transaction->amount){
                                    $payment_schedule->paid =0;
                                    $payment_schedule->actual_payment_date=NULL;
                                    $payment_schedule->payment_status = 'pending';
                                }elseif($payment_schedule->paid < $payment_transaction->amount){
                                    return $data;
                                }
                                else{
                                    $payment_schedule->payment_status = 'partial';
                                    $payment_schedule->paid -= $payment_transaction->amount;
                                }
                                $subtract_amount = $payment_transaction->amount-$penalty_amount+$discount_amount;
                                $loan->outstanding_amount += $subtract_amount;
                                $sale_item->total_repay_amount -=$payment_transaction->amount;
                                $new_payment_transaction = PaymentTransaction::create([
                                    'project_id' => $sale_item->project_id,
                                    'property_id' => $sale_item->property_id,
                                    'payment_date' => $actual_payment_date,
                                    'sale_id' => $sale_item->id,
                                    'loan_id' => $loan->id,
                                    'payment_schedule_id' => $payment_schedule->id,
                                    'customer_id' => $sale_item->customer_id,
                                    'amount' => $amount*(-1),
                                    'remark' => $request->remark,
                                    'is_cancel' => 1,
                                    'created_by' => Auth::id()
                                ]);
                                Transaction::create([
                                    'project_id' => $sale_item->project_id,
                                    'property_id' => $sale_item->property_id,
                                    'date' => $actual_payment_date,
                                    'payment_transaction_id' => $new_payment_transaction->id,
                                    'sale_id' => $sale_item->id,
                                    'loan_id' => $loan->id,
                                    'payment_schedule_id' => $payment_schedule->id,
                                    'customer_id' => $sale_item->customer_id,
                                    'amount' => $amount*(-1),
                                    'remark' => 'loan payment',
                                    'created_by' => Auth::id()
                                ]);
                                $payment_transaction->is_cancel =1;
                                $payment_transaction->save();
                                $payment_schedule->save();
                                $loan->save();
                                $sale_item->save();
                                $approves = '';
                                if($request->approve){
                                    $approves=ApproveCancelPayment::find($request->approve);
                                }
                                if(!empty($approves) && $approves!=''){
                                    $approves->status='approved';
                                    $approves->updated_by = Auth::id();
                                    $approves->save();
                                }else{
                                    ApproveCancelPayment::create([
                                        'payment_transaction' => $payment_transaction->id,
                                        'status' => 'approved',
                                        'updated_by' => Auth::id(),
                                        'created_by' => Auth::id()
                                    ]);
                                }
                                $data['message'] =1;
                            }else{
                                
                                $approves=ApproveCancelPayment::where([
                                    ['payment_transaction', '=', $payment_transaction->id],
                                    ['created_by', '=', Auth::id()],
                                    ['status', '=', 'waitting']
                                ])->first();
                                if(empty($approves)){
                                    ApproveCancelPayment::create([
                                        'payment_transaction' => $payment_transaction->id,
                                        'created_by' => Auth::id()
                                    ]);
                                }
                                $data['message'] =3;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
    public function cancel_approve_cancel_payment(Request $request){
        $data['message'] =0;
        if(!AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $approve = ApproveCancelPayment::where([
            ['id', '=', $request->approve],
            ['status', '=', 'waitting']
        ])->first();
        if(!empty($approve)){
            $approve->status='canceled';
            $approve->updated_by = Auth::id();
            $approve->save();
            $data['message'] =1;
        }
        return $data;
    }
    public function cancel_loan(Request $request){
        if(!Auth::user()->can('cancel-loan-payment') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $data['message'] =0;
        if(!empty($request->loan)){
            $loan = Loan::find($request->loan);
            if(!empty($loan)){
                if($loan->outstanding_amount==$loan->loan_amount && $loan->status==Config::get('app.loan_status_loaned')){
                    $sale_item = SaleItem::find($loan->sale_id);
                    if(!empty($sale_item) && $sale_item!='completed'){
                        $order_loan = Loan::where([
                            ['sale_id', '=', $loan->sale_id],
                            ['id', '>', $loan->id],
                            ['status', '<>', Config::get('app.loan_status_cancel')]
                        ])->get()->count();
                        if ($order_loan<=0) {
                            $payment_schedule = PaymentSchedule::where('loan_id', '=', $loan->id)->
                            update(['status' => 'cancel']);
                            $sale_item->total_loan_amount -= $loan->loan_amount;
                            $sale_item->grand_total += $loan->loan_amount;
                            $loan->status = Config::get('app.loan_status_cancel');
                            $sale_item->save();
                            $loan->save();
                            $data['message'] =1;
                        }
                    }
                }
            }
        }
        return $data;
    }
    function sale_contract(Request $request){
        $data['html'] ='';
        $sale = DB::table('sale_items')
        ->select(DB::raw('
            sale_items.*,
            CONCAT(cs.last_name," ",cs.first_name) as customer_name,
            cs.nationality as customer_nationality,
            cs.identity as customer_identity,
            cs.identity_set_date as customer_identity_set_date,
            cs.dob as customer_date_of_birht,
            cs.pob as customer_place_of_birth,
            cs.phone1 as customer_phone,
            IF(cssex="1", "ប្រុស", "ស្រី") as customer_gender,
            cs.email as customer_email,
            cs.house_number AS customer_house_number,
            cs.provinces.province_kh_name as province_name,
            cs.districts.district_namekh as district_name,
            cs.communes.commune_namekh as commune_name,
            cs.villages.village_namekh as village_name,
            CONCAT(cs_partnerlast_name," ",partnerfirst_name) as customer_partner_name,
            cs.partner.nationality as customer_partner_nationality,
            cs.partner.identity as customer_partner_identity,
            cs.partner.identity_set_date as customer_partner_identity_set_date,
            cs.partner.dob as customer_partner_date_of_birht,
            cs.partner.pob as customer_partner_place_of_birth,
            cs.partner.phone1 as customer_partner_phone,
            IF(cs_partnersex="1", "ប្រុស", "ស្រី") as customer_partner_gender,
            cs.partner.email as customer_partner_email,
            cs.partner_provinces.province_kh_name as province_name,
            cs.partner_districts.district_namekh as district_name,
            cs.partner_communes.commune_namekh as commune_name,
            cs.partner_villages.village_namekh as village_name,
            CO.CAT(em.first_name," ",em.last_name) as employee_name,
            em.nationality as employee_nationality,
            em.dob as employee_date_of_birht,
            em.pob as employee_place_of_birth,
            CONCAT(emphone1," ",emphone2) as employee_phone,
            em.address as employee_address,
            em.provinces.province_kh_name as province_name,
            em.districts.district_namekh as district_name,
            em.communes.commune_namekh as commune_name,
            em.villages.village_namekh as village_name,
            IF(emsex="1", "ប្រុស", "ស្រី") as employee_gender,
            em.email as em.ployee_email,
            items.project_id as item_project_id,
            items.property_name as item_name,
            items.property_no as item_number,
            items.boundary_north as north,
            items.boundary_south as south,
            items.boundary_east as east,
            items.boundary_west as west,
            items.village as vill,
            items.commune as comm,
            items.district as dis,
            items.province as pro,
            items.about as item_abouts,
            items.address_street AS address_street,
            items.width AS width,
            items.length AS length,
            items.house_number AS house_number,
            item.types.name_kh as item_type_name,
            item.types.group as item_type_group,
            item.types.extension as item_type_extension,
            provinces.province_kh_name as province_name,
            districts.district_namekh as district_name,
            communesc.ommune_namekh as commune_name,
            villages.village_namekh as village_name
        '))
        ->where('sale_items.id', '=', $request->id)
        ->join('customers as cs', 'sale_items.customer_id', '=', 'csid')
        ->leftJoin('provinces as cs.provinces', 'provinces.province_id', '=', 'cs.province')
        ->leftJoin('districts as cs.districts', 'cs_districts.dis_id', '=', 'cs.district')
        ->leftJoin('communes as cs.communes', 'communes.com_id', '=', 'cs.commune')
        ->leftJoin('villages as cs.villages', 'villages.vill_id', '=', 'cs.village')
        ->leftJoin('customers as cs.partner', 'customer.partner_id', '=', 'cs_partnerid')
        ->leftJoin('provinces as cs.partner_provinces', 'provinces.province_id', '=', 'cs.partner.province')
        ->leftJoin('districts as cs.partner_districts', 'districts.dis_id', '=', 'cs.partner.district')
        ->leftJoin('communes as cs.partner_communes', 'communes.com_id', '=', 'cs.partner.commune')
        ->leftJoin('villages as cs.partner_villages', 'villages.vill_id', '=', 'cs.partner.village')
        ->leftJoin('employees as em', 'employee_id', '=', 'em.id')
        ->leftJoin('provinces as em.provinces', 'provinces.province_id', '=', 'em.province')
        ->leftJoin('districts as em.districts', 'districts.dis_id', '=', 'em.district')
        ->leftJoin('communes as em.communes', 'communes.com_id', '=', 'em.commune')
        ->leftJoin('villages as em.villages', 'villages.vill_id', '=', 'em.village')
        ->leftJoin('items as projects', 'projects.id', '=', 'projects.project_id')
        ->leftJoin('items as lands', 'lands.id', '=', 'lands.land_id')
        ->leftJoin('provinces as lands', 'province_id', '=', 'lands.province')
        ->leftJoin('districts as lands', 'dis_id', '=', 'lands.district')
        ->leftJoin('communes as lands', 'com_id', '=', ' lands.commune')
        ->leftJoin('villages as lands', 'vill_id', '=', 'lands.village')
        ->leftJoin('items', 'items.id', '=', 'property_id')
        ->leftJoin('item_types', 'item_types.id', '=', 'items.item_type')
        ->first();
        $first_loan = Loan::where([
            ['sale_id', '=', $sale->id],
            ['status', '<>', Config::get('app.loan_status_cancel')]
        ])
        ->whereNull('loan_type')->first();
        $last_loan = Loan::where([
            ['sale_id', '=', $sale->id],
            ['status', '<>', Config::get('app.loan_status_cancel')]
        ])
        ->latest()->first();
        $first_step_sche_payments = PaymentSchedule::where('loan_id', '=', $last_loan->id)->get();
        $num_of_pay_later = PaymentSchedule::where([
            ['loan_id', '=', $last_loan->id],
            ['payment_status', '<>', 'paid']
        ])->count();
        // $installment_payment = Loan::where([
        //     ['sale_id', '=', $sale->id],
        //     ['status', '<>', Config::get('apploan_status_cancel')]
        // ])
        // ->whereNotNull('loan_type')->first();
        // $payment_schedules = PaymentSchedule::where('loan_id', '=', $installment_payment->id)->get();
        
        $properties = '';
        foreach ($sale_details as $key => $value) {
            if($key==0){
                $properties = $value->item_name;
            }else{
                $properties = $properties.','.$value->item_name;
            }
        }
        $property_type = '';
        $property_type_group ='';
        $property_type_extension='';
        if($sale){
            $property_type = '';
            $property_type_group ='';
            $property_type_extension='';
            $land=null;
            if($sale_details){
                $property_type = "["->item_type_name;
                $property_type_group = "["->item_type_group;
                $property_type_extension = "["->item_type_extension;
                $project = Project::find("["->item_project_id);
                if($project){
                    $land = Land::find($project->land_id);
                }
            }
        }
        $paid_payments = PaymentTransaction::select('amount', 'payment_date')
        ->where([
            ['property_id', $sale->property_id],
            ['customer_id', $sale->customer_id],
            ['is_cancel', '=',  0]
        ])->get();
        // $payments = Payment::where('sale_id', '=', $sale->id)->get();
        $contract_view_name =  Contract::find($sale->contract_id)->reality_view_name;
        if(!empty($sale) && !is_null($sale->land_address_id)){
            $land_address =  LandAddress::select(DB::raw('
                land_id AS id,
                province_kh_name AS province_name,
                district_namekh AS district_name,
                commune_namekh AS commune_name,
                village_namekh AS village_name
            '))->where('id', $sale->land_address_id)
                ->join('provinces', 'pro_id', '=', 'province_id')
                ->join('districts',  'district_id', '=', 'dis_id')
                ->join('communes', 'commune_id', '=', 'com_id')
                ->join('villages', 'village_id', '=', 'vill_id')
                ->first();
            if(!empty($land_address)){
                $sale->province_name = $land_address->province_name;
                $sale->district_name = $land_address->district_name;
                $sale->commune_name = $land_address->commune_name;
                $sale->village_name = $land_address->village_name;
            }
        }
        $data['html'].=(string)View::make('back-end.'.$contract_view_name, compact('sale','sale_details','property_type', 'property_type_group', 'property_type_extension', 'land', 'properties', 'first_loan', 'first_step_sche_payments', 'num_of_pay_later', 'paid_payments','last_loan'));
        return $data;
    }
    public function print_schedule(Request $request){
        $data['html'] ='';
        if(!empty($request->id)){
            $loan = Loan::find($request->id);
            if(!empty($loan)){
                $customer = Customer::find($loan->customer_id);
                $payment_schedules = PaymentSchedule::where('loan_id', '=', $loan->id)->get();
                $sale_item = SaleItem::select('items.property_name')
                ->where('sale_items.id', '=', $loan->sale_id)
                ->leftJoin('items', 'items.id', '=', 'sale_items.property_id')
                ->first();
                if(!empty($payment_schedules) && !empty($customer)){
                    $data['html'].=(string)View::make('back-end.sale_property.print_schedule', compact('loan', 'customer', 'payment_schedules','sale_item'));
                }
            }
        }
        return $data;
    }
    public function cancel_sale_payment(Request $request){
        if(!Auth::user()->can('cancel-sale-payment') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $data['message'] =0;
        if(!empty($request->payment_transaction)){
            $payment_transaction = PaymentTransaction::find($request->payment_transaction);
            if(!empty($payment_transaction)){
                if($payment_transaction->amount<=0 || $payment_transaction->is_cancel==1){
                    return $data;
                }
                $payment_schedule = PaymentSchedule::find($payment_transaction->payment_schedule_id);
                $loan = Loan::find($payment_transaction->loan_id);
                if(!empty($loan) && !empty($payment_schedule)){
                    $sale_item = SaleItem::find($payment_schedule->sale_id);
                    if($loan->id==$payment_schedule->loan_id && !empty($sale_item)){
                        $order_schedules = PaymentSchedule::where('loan_id', '=', $loan->id)
                        ->where([
                            ['payment_status', '<>', 'pending'],
                            ['order', '>', $payment_schedule->order]
                        ])->get()->count();
                        $this_order_transaction = DB::table('payment_transactions')->where([
                            ['payment_schedule_id', '=', $payment_schedule->id],
                            ['id', '>', $payment_transaction->id],
                            ['is_cancel', '<>', 1]
                        ])->get()->count();
                        if($order_schedules<=0 && $this_order_transaction<=0 && !$this->has_next_loan($loan->id)){
                            $amount = $payment_transaction->amount;
                            $penalty_amount = $payment_schedule->penalty_amount;
                            $discount_amount = $payment_schedule->discount_amount;
                            $payment_schedule->amount_to_spend -= $penalty_amount-$discount_amount;
                            $actual_payment_date =$payment_schedule->actual_payment_date;
                            $payment_schedule->penalty_amount = 0;
                            $payment_schedule->discount_amount =0;
                            if($payment_schedule->paid == $payment_transaction->amount){
                                $payment_schedule->paid =0;
                                $payment_schedule->actual_payment_date=NULL;
                                $payment_schedule->payment_status = 'pending';
                            }elseif($payment_schedule->paid < $payment_transaction->amount){
                                return $data;
                            }
                            else{
                                $payment_schedule->payment_status = 'partial';
                                $payment_schedule->paid -= $payment_transaction->amount;
                            }
                            $subtract_amount = $payment_transaction->amount-$penalty_amount+$discount_amount;
                            $loan->outstanding_amount += $subtract_amount;
                            $sale_item->total_repay_amount -=$payment_transaction->amount;
                            $new_payment_transaction = PaymentTransaction::create([
                                'project_id' => $sale_item->project_id,
                                'property_id' => $sale_item->property_id,
                                'payment_date' => $actual_payment_date,
                                'sale_id' => $sale_item->id,
                                'loan_id' => $loan->id,
                                'payment_schedule_id' => $payment_schedule->id,
                                'customer_id' => $sale_item->customer_id,
                                'amount' => $amount*(-1),
                                'remark' => $request->remark,
                                'is_cancel' => 1,
                                'created_by' => Auth::id()
                            ]);
                            Transaction::create([
                                'project_id' => $sale_item->project_id,
                                'property_id' => $sale_item->property_id,
                                'date' => $actual_payment_date,
                                'payment_transaction_id' => $new_payment_transaction->id,
                                'sale_id' => $sale_item->id,
                                'loan_id' => $loan->id,
                                'payment_schedule_id' => $payment_schedule->id,
                                'customer_id' => $sale_item->customer_id,
                                'amount' => $amount*(-1),
                                'remark' => 'loan payment',
                                'created_by' => Auth::id()
                            ]);
                            $payment_transaction->is_cancel =1;
                            $payment_transaction->save();
                            $payment_schedule->save();
                            $loan->save();
                            $sale_item->save();
                            $data['message'] =1;
                        }
                    }
                }
            }
        }
        return $data;
    }
    public function cancel_sale(Request $request){
        if(!Auth::user()->can('cancel-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $data['message'] =0;
        if(!empty($request->sale)){
            $sale = SaleItem::find($request->sale);
            if(!empty($sale)){
                $loan_first = Loan::where('sale_id', '=', $sale->id)
                ->whereNull('loan_type')->first();
                $sale_pay_num = PaymentTransaction::where([
                    ['sale_id', '=', $sale->id],
                    ['is_cancel', '=', 0]
                ])->count();
                if(!empty($loan_first) && $sale->status!='completed' && $sale_pay_num==0){
                    $payment_schedule =  PaymentSchedule::where('loan_id', '=', $loan_first->id)->first();
                    if(!empty($payment_schedule)){
                        $this_order_transaction = DB::table('payment_transactions')->where([
                            ['payment_schedule_id', '=', $payment_schedule->id],
                            ['is_cancel', '<>', 1]
                        ])->get()->count();
                        $loans = Loan::where([
                            ['sale_id', '=', $sale->id],
                            ['status', '<>', Config::get('app.loan_status_cancel')]
                        ])
                        ->whereNotNull('loan_type')->get()->count();
                        if($loans<=0 && $this_order_transaction<=0){
                            // this cancel sale
                            $property = Property::find($sale->property_id);
                            if (!empty($property)) {
                                $reservation = Reservation::where([
                                    ['property_id', '=', $property->id],
                                    ['status', '=', 'sold']
                                ])->latest()->first();
                                if (!empty($reservation)) {
                                    $reservation->status ='booked';
                                    $property->status = Config::get('app.property_status_booked');
                                    $reservation->save();
                                }else{
                                    $property->status=Config::get('app.property_status_available');
                                }
                                $sale->status = 'cancel';
                            }
                            $payment_schedule->paid =0;
                            $payment_schedule->payment_status = 'pending';
                            $payment_schedule->status= 'cancel';
                            $payment_schedule->save();
                            $loan_first->status =  Config::get('app.loan_status_cancel');
                            $loan_first->save();
                            $property->save();
                            if(!empty($sale->employee_id)){
                                Transaction::create([
                                    'date' => date('Y-m-d'),
                                    'sale_id' => $sale->id,
                                    'project_id' => $sale->project_id,
                                    'property_id' => $sale->property_id,
                                    'employee_id' => $sale->employee_id,
                                    'amount' => $sale->commission_amount*1,
                                    'created_by' => Auth::id()
                                ]);
                            }
                            $sale->updated_by = Auth::id();
                            $sale->save();
                            $data['message'] = 1;
                        }
                    }
                }
            }
        }
        return $data;
    }
    function has_next_loan($loan_id){
        $data = 0;
        $loan = Loan::find($loan_id);
        if(!empty($loan)){
            $next_loan = Loan::where([
                ['sale_id', '=', $loan->sale_id],
                ['id', '>', $loan->id],
                ['status', '<>', Config::get('app.loan_status_cancel')]
            ])->get()->count();
            // if($next_loan>0){
            //     $data = 1;
            // }
            // MODIFY FOR ALLOW MULTIPLE LOANS
            if($loan->status==Config::get('app.loan_status_completed')){
                $data = 1;
            }
        }
        return $data;
    }
    function has_loan_is_not_completed($sale_id){
        $data = 0;
        $loans = Loan::where([
            ['sale_id', '=', $sale_id],
            ['status', '=', Config::get('app.loan_status_loaned')]
        ])->get()->count();
        if($loans>0){
            $data = 1;
        }
        // IT ALLOW FOR CREATE MULTIPLE LOAN IN ONE SALE (MODIFY)
        $data =0;
        // END IT
        return $data;
    }
    function all_loan_paid_for_complete_sale($sale_id){
        $data =0;
        $loans = Loan::where([
            ['sale_id', '=', $sale_id],
            ['status', '=', Config::get('app.loan_status_loaned')]
        ])->get()->count();
        $sale_item = SaleItem::find($sale_id);
        if(!empty($sale_item) && $sale_item->grand_total<=0 && $loans<=0){
            $data = 1;
        }
        return $data;
    }
    function paid_off(SaleItem $sale_item,Request $request){
        if(!Auth::user()->can('paid-off-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $loans = Loan::where([
            ['sale_id', '=', $sale_item->id],
            ['status', '=', 'loaned']
        ])->get();
        $amount_to_paid =0;
        $amount_to_paid += $sale_item->grand_total;
        foreach ($loans as $key => $value) {
            $pay = PaymentSchedule::where([
                ['loan_id', '=', $value->id],
                ['payment_status', '<>', 'paid']
            ])->first();
            if(!empty($pay)){
                $amount_to_paid+= $pay->principle_balance + $pay->principle - $pay->paid;
            }
        }
        if($amount_to_paid<=0){
            return redirect()->back()->with('error-message', 'Can not paid off!');
        }
        if ($request->method()=='GET') {
            // dd($amount_to_paid);
            $payment_transaction = PaymentTransaction::orWhereNull('deleted_at')->latest()->first();
            $code = (isset($payment_transaction->id)?$payment_transaction->id:0) +1;
            $code ='P'.str_pad($code, 6, '0', STR_PAD_LEFT);
            $customer =Customer::find($sale_item->customer_id);
            return view('back-end.sale_property.paid_off_form', compact('sale_item', 'code', 'customer', 'amount_to_paid'));
        }
        elseif($request->method()=='POST'){
            $this->validate($request,[
                'date' => 'required|date',
                'adjustment_amount' => 'nullable|numeric|min:0',
                'remark' => 'required|string|max:300'
            ]);
            $date = date('Y-m-d', strtotime($request->date));
            $adjustment_amount = $request->adjustment_amount*1;
            $amount =  $amount_to_paid+$adjustment_amount;
            foreach ($loans as $loan) {
                PaymentSchedule::where([
                    ['loan_id', '=', $loan->id],
                    ['payment_status', '<>', 'paid']
                ])
                ->update([
                    'actual_payment_date' => $date,
                    'payment_status'=>'paid',
                    'updated_by' => Auth::id()
                ]);
                $loan->outstanding_amount=0;
                $loan->status =Config::get('app.loan_status_completed');
                $loan->save();
            }
            $payment_transaction = PaymentTransaction::create([
                'project_id' => $sale_item->project_id,
                'property_id' => $sale_item->property_id,
                'payment_date' => $date,
                'sale_id' => $sale_item->id,
                'customer_id' => $sale_item->customer_id,
                'amount' => $amount,
                'remark' => $request->remark,
                'created_by' => Auth::id()
            ]);
            Transaction::create([
                'project_id' => $sale_item->project_id,
                'property_id' => $sale_item->property_id,
                'date' => $date,
                'payment_transaction_id' => $payment_transaction->id,
                'sale_id' => $sale_item->id,
                'customer_id' => $sale_item->customer_id,
                'amount' => $amount,
                'remark' => $request->remark,
                'created_by' => Auth::id()
            ]);
            $sale_item->sale_paid_off += $sale_item->grand_total;
            $sale_item->grand_total=0;
            $sale_item->total_repay_amount+=$amount;
            $sale_item->status = 'completed';
            $sale_item->save();
            return redirect()->route('sale_property.view_sale',['property'=>$sale_item->property_id])->with('message', _('item.success_create'));
        }
    }
    function sale_paid_off_receipt($id){
        $payment_transaction = PaymentTransaction::find($id);
        $sale_item = SaleItem::find($payment_transaction->sale_id);
        $customer = Customer::find($payment_transaction->customer_id);
        $project = Project::find($payment_transaction->project_id);
        $property = Property::find($payment_transaction->property_id);
        $created_by = User::select('name')->find($payment_transaction->created_by);
        return view('back-end.sale_property.receipt_paid_off', compact('property','sale_item', 'customer', 'project', 'created_by', 'payment_transaction'));
    }
    function preview_contarct_sample(Request $request){
        $data['html'] ='';
        $contract_view_name =  Contract::find($request->id)->sample_view_name;
        $data['html'].=(string)View::make('back-end.'.$contract_view_name);
        return $data;
    }
    function change_address(Request $request){
        $this->validate($request,[
            'sale_item_id' => 'required',
        ]);
        $sale_item = SaleItem::findOrFail($request->sale_item_id);
        $sale_item->land_address_id = $request->other_address;
        $sale_item->save();
        return response()->json(['message'=>'Change address successfully'],200);
    }
    function getchange_partner(Request $request){
        $data['html'] = '';
        if($request->sale_item_id){
            $sale = SaleItem::findOrFail($request->sale_item_id);
            $partners=Customer::whereNotIn('id', [$sale->customer_id])->get();
            $data['html']="".View::make('back-end.sale_property.change_partner_form', compact('sale', 'partners'));
        }
        return response()->json($data, 200);
    }
    function change_partner(Request $request){
        if(!Auth::user()->can('change-partner') && !AppHelper::checkAdministrator())
            return response()->json(['message'=>'Sorry you don not has permission!'],200);
        $this->validate($request,[
            'sale_item_id' => 'required'
        ]);
        $sale_item = SaleItem::findOrFail($request->sale_item_id);
        $sale_item->customer_partner_id = $request->partner_id;
        $sale_item->save();
        return response()->json(['message'=>'Change partner successfully'],200);
    }
}