<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Customer;
use Auth;
use App\Helpers\AppHelper;
class PartnerController extends Controller
{
    function get_partner(Request $request){
    	if(!Auth::user()->can('create-sale') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
    	$customer_id = $request->customer_id;
    	$partner = Customer::where('id','<>', $customer_id)->get();
    	$partners='<option value>-- Select Partner --</option>';
    	foreach ($partner as $value) {
    		$partners .='<option value="'.$value->id.'">'.$value->customer_no.' | '.$value->last_name.' '.$value->first_name.'</option>';
    	}
    	$data['option'] =$partners; 
    	return $data;
    }
}
?>