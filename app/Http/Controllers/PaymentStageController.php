<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB, Auth, Validator;
use App\Model\PaymentStage;
use App\Helpers\AppHelper;
class PaymentStageController extends Controller
{
    function index(Request $request){
    	$item = new PaymentStage;
        if($request->search && !empty($request->search)){
            $search = $request->search;
            $item = $item
                ->where(function ($query) use($search) {
                $query->where('id',      'like',     '%'.$search.'%');
                $query->orWhere('amount',      'like',     '%'.$search.'%');
                $query->orWhere('remark',      'like',     '%'.$search.'%');
            });
        }
    	$item = $item->paginate(20)->withPath('?search='.$request->search);
    	return view('back-end.payment_stages.index', compact('item', 'request'));
    }
    function create(Request $request){
    	if(!Auth::user()->can('add-payment-stage') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if($request->method() =='GET'){
            return view('back-end.payment_stages.create');
        }elseif($request->method()=='POST'){
            $this->validate($request,[
                'amount' => 'required|numeric|min:0',
                'remark' => 'nullable|max:255'
            ]);
            try {
                PaymentStage::create([
                    'amount' => $request->amount,
                    'remark' => $request->remark,
                    'created_by' => Auth::id()
                ]);   
                return redirect()->route('payment_stages')->with('message', __('item.success_create'));
            } catch (Exception $e) {
                return redirect()->route('payment_stages')->with('error-message', __('item.error_create'));
            }
        }
    }
    function edit(Request $request, PaymentStage $payment_stage){
    	if(!Auth::user()->can('edit-payment-stage') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(empty($payment_stage)){
            return redirect()->back()->with('error-message', __('item.not_found'));
        }
        if($request->method() =='GET'){
            return view('back-end.payment_stages.edit', compact('payment_stage'));
        }elseif($request->method()=='POST'){
        	$this->validate($request,[
                'amount' => 'required|numeric|min:0',
                'remark' => 'nullable|max:255'
            ]);
            try {
                $payment_stage->amount = $request->amount;
                $payment_stage->remark = $request->remark;
                $payment_stage->updated_by = Auth::id();
                $payment_stage->save();
                return redirect()->route('payment_stages')->with('message', __('item.success_edit'));
            } catch (Exception $e) {
                return redirect()->route('payment_stages')->with('error-message', __('item.error_edit'));
            }
        }
    }
    function destroy(PaymentStage $payment_stage){
    	if(!Auth::user()->can('delete-payment-stage') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        try {
        	$payment_stage->deleted_by = Auth::id();
        	$payment_stage->update();
        	$payment_stage->delete();
        	return redirect()->back()->with('message', __('item.success_delete'));
        } catch (Exception $e) {
        	return redirect()->back()->with('error-message', __('item.error_delete'));
        }
    }
}
?>