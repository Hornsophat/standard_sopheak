<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Inventory;
use Auth, \Redirect, \Input, \Session;
use App\Helpers\AppHelper;
use App\Model\InventoryDetail;
use Validator;
use DB;
use Hash;
use App\Model\Supplyer;
use App\Model\Purchase;
use App\Model\PurchaseDetail;
use App\Model\SubtractInventory;
use App\Model\SubtractInventoryDetail;
use App\Model\ProjectMaterial;
use App\Model\Project;
use View;
class SubtractInventoryController extends Controller
{
	private $cost_type; // fifo lifo average
	function __construct(){
		$this->cost_type='fifo';
	}
    function index(){
    	if(!Auth::user()->can('list-subtract-inventory') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $subtract_inventories = SubtractInventory::select('subtract_inventories.*','creaters.name as created_name','receiveds.name as received_name',
    		'projects.property_name as project_name')
        ->whereNull('subtract_inventories.deleted_at')
        ->leftJoin('items as projects', 'projects.id', '=', 'subtract_inventories.project_id')
        ->leftJoin('users as creaters', 'subtract_inventories.created_by', 'creaters.id')
        ->leftJoin('users as receiveds', 'subtract_inventories.received_by', 'receiveds.id')
        ->sortable()->orderBy('subtract_inventories.id', 'DESC')->paginate(20);
        return view('back-end.subtract_inventory.index', compact('subtract_inventories'));
    }
    function create(Request $request){
    	if(!Auth::user()->can('create-subtract-inventory') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if($request->method() == 'GET'){
        	$items = Product::where('is_active', "<>", 0)->get();
        	$products[]= '-- Select --';
        	foreach ($items as $key => $value) {
        		$products[$value->id] = $value->name;
        	}
        	$pro = Project::where('item_type', '=', 2)->get();
        	$projects[null] = '-- '.__('item.select').' '.__('item.project').' --';
        	foreach ($pro as $key => $value) {
        		$projects[$value->id] = $value->property_name;
        	}
        	$statuses['ordered'] = 'Ordered';
        	$statuses['received'] = 'Received';
        	return view('back-end.subtract_inventory.create', compact('items', 'products', 'statuses', 'projects'));
        }else if($request->method() == 'POST'){
        	$this->validate($request, [
	        	'status' => 'required|string|max:100',
	        	'project' => 'required',
	        	'remarks' => 'nullable|string|max:250',
	        	'products.*' => 'nullable|string|max:100',
	        	'products_no.*' => 'required|numeric|min:1',
	        	'quantities.*' =>'required|numeric|integer|min:1'
	        ],[
	        	'products_no.*' => 'Some Product Not Found!'
	        ],[
	        	'products.*' => 'Product Name',
	        	'quantities.*' => 'Quantity',
	        	'products_no.*' => 'Product'
	        ]);
	        $user_id = Auth::id();
        	$product_noes = $request->products_no;
        	$product_names = $request->products;
        	$product_quantities = $request->quantities;
        	$description = $request->remarks;
        	$status = $request->status;
        	$has_error_validation =0;
        	$error_message='';
        	foreach ($product_noes as $key => $value) {
        		$product = ProjectMaterial::where([
        			['project_id', '=', $request->project],
        			['material_id', '=', $value]
        		])->first();
        		if(!$product){
        			$error_message = 'Failed product in row ('.($key+1).')';
        			return redirect()->back()->with('error_validations', $error_message);
        		}else{
        			if($product->material_qty<$product_quantities[$key]){
        				$has_error_validation =1;
        				$error_message= 'Product in row ('.($key + 1).') has quantity more than quantity in stock';
        			}
        		}
        	}
        	if($has_error_validation){
        		return redirect()->back()->with('error_validations',$error_message);
        	}
        	DB::transaction(function() use ($request, $user_id, $product_noes, $product_names, $product_quantities,$description, $status){
        		$subtract_inventory = SubtractInventory::create([
        			'project_id' => $request->project,
        			'status' => $status,
        			'description' =>$description,
        			'total_cost' =>0,
        			'created_by' => $user_id
        		]);
        		$subtract_inventory_total_cost =0;
        		foreach ($product_noes as $key => $value) {
	        		$pro_no  = $product_noes[$key];
	        		$pro_qty = $product_quantities[$key];
	        		$pro_name = $product_names[$key];
	        		$subtract_inventory_detail = SubtractInventoryDetail::create([
	        			'project_id' => $request->project,
	        			'subtract_id' => $subtract_inventory->id,
	        			'material_id' => $pro_no,
	        			'material_name' => $pro_name,
	        			'quantity' => $pro_qty,
	        			'quantity_subtracted' => 0,
	        			'status' => $status,
	        			'created_by' => $user_id
	        		]);
	        		if($status=='received'){
	        			$product = Product::find($pro_no);
	        			$project_product = ProjectMaterial::where([
	        				['project_id', '=', $request->project],
	        				['material_id', '=', $pro_no]
	        			])->first();
	        			$fun_subtract_inventory = $this->subtract_inventory($request->project,$pro_no, $pro_qty, $user_id, $subtract_inventory->id, $this->cost_type);
	        			$total_cost_inv = $fun_subtract_inventory['total_cost_inv'];
	        			$subtract_inventory_total_cost += $total_cost_inv;
	        			$product_subtracted_qty = $pro_qty - $fun_subtract_inventory['product_subtract_qty'];
	        			$subtract_inventory_detail->quantity_subtracted += $product_subtracted_qty;
	        			$subtract_inventory_detail->subtracted_date = date('Y-m-d');
		        		$subtract_inventory_detail->received_by = $user_id;
		        		$subtract_inventory_detail->total_cost = $total_cost_inv;
	        			$subtract_inventory_detail->save();
	        			$product->qty -= $product_subtracted_qty;
	        			$product->save();
	        			$project_product->material_qty -= $product_subtracted_qty;
	        			$project_product->save();
	        		}
	        	}
	        	if($status=='received'){
	        		$subtract_inventory->total_cost +=$subtract_inventory_total_cost;
	        		$subtract_inventory->received_date = date('Y-m-d');
	        		$subtract_inventory->received_by = $user_id;
	        		$subtract_inventory->save();
	        	}
	        	Session::put('remove_spitem',1);
        	});
        	return redirect()->route('subtract_inventories')->with('success', 'Successfully Insert Subtract Inventory');
        }
    }
    function view($id){
    	if(!Auth::user()->can('view-subtract-inventory') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $subtract_inventory = SubtractInventory::where('subtract_inventories.id', '=', $id)
        ->select('subtract_inventories.*','creaters.name as created_name','receiveds.name as received_name')
        ->whereNull('subtract_inventories.deleted_at')
        ->leftJoin('users as creaters', 'subtract_inventories.created_by', 'creaters.id')
        ->leftJoin('users as receiveds', 'subtract_inventories.received_by', 'receiveds.id')
        ->first();
        $subtract_inventory_details = SubtractInventoryDetail::where('subtract_id', '=', $id)
        ->whereNull('deleted_at')
        ->get();
        return view('back-end.subtract_inventory.view', compact('subtract_inventory', 'subtract_inventory_details'));
    }
    public function edit(Request $request,$id){
    	if(!Auth::user()->can('edit-subtract-inventory') && !AppHelper::checkAdministrator()){
            return view('back-end.common.no-permission');
		}else{
			$subtract_inventory = SubtractInventory::find($id);
			if(!$subtract_inventory){
				return redirect()->back()->with('message', 'Not Found');
			}else{
				if($subtract_inventory->status == 'received'){
	        		return redirect()->back()->with('message', 'Can not edit Subtract Inventory');
	        	}else{
	        		if($request->method() == 'GET'){
	        			$items = Product::where('is_active', '<>', 0)->get();
			        	$products[]= '-- Select --';
			        	foreach ($items as $value) {
			        		$products[$value->id] = ucfirst($value->name);
			        	}
			        	$statuses['ordered'] = 'Ordered';
			        	$statuses['received'] = 'Received';
			        	$subtract_inventory_details = SubtractInventoryDetail::where('subtract_id', '=', $subtract_inventory->id)
			        	->where('status', '<>', 'received')->get();
			        	$rows = [];
			        	foreach ($subtract_inventory_details as $key => $value) {
			        		$rows[$key] = [
		        				'product' => $value->material_name,
		        				'product_no' => $value->material_id,
		        				'quantity' => $value->quantity
		        			];
			        	}
			        	$pro = Project::where('item_type', '=', 2)->get();
			        	$projects[null] = '-- '.__('item.select').' '.__('item.project').' --';
			        	foreach ($pro as $key => $value) {
			        		$projects[$value->id] = $value->property_name;
			        	}
			        	return view('back-end.subtract_inventory.edit', compact('items', 'products', 'statuses', 'rows', 'subtract_inventory', 'projects'));
			        }else if($request->method() == 'POST'){
			        	$this->validate($request, [
				        	'status' => 'required|string|max:100',
				        	'remarks' => 'nullable|string|max:250',
				        	'products.*' => 'nullable|string|max:100',
				        	'products_no.*' => 'required|numeric|min:1',
				        	'quantities.*' =>'required|numeric|integer|min:1'
				        ],[
				        	'products_no.*' => 'Some Product Not Found!'
				        ],[
				        	'products.*' => 'Product Name',
				        	'quantities.*' => 'Quantity',
				        	'products_no.*' => 'Product'
				        ]);
				        $user_id = Auth::id();
			        	$product_noes = $request->products_no;
			        	$product_names = $request->products;
			        	$product_quantities = $request->quantities;
			        	$description = $request->remarks;
			        	$status = $request->status;
			        	$has_error_validation =0;
			        	$error_message='';
			        	foreach ($product_noes as $key => $value) {
			        		$product = ProjectMaterial::where([
			        			['project_id', '=', $request->project],
			        			['material_id', '=', $value]
			        		])->first();
			        		if(!$product){
			        			$error_message = 'Failed product in row ('.($key+1).')';
			        			return redirect()->back()->with('error_validations', $error_message);
			        		}else{
			        			if($product->material_qty<$product_quantities[$key]){
			        				$has_error_validation =1;
			        				$error_message= 'Product in row ('.($key+1).') has quantity more than quantity in stock';
			        			}
			        		}
			        	}
			        	if($has_error_validation){
			        		return redirect()->back()->with('error_validations',$error_message);
			        	}
			        	DB::transaction(function() use ($subtract_inventory, $request, $user_id, $product_noes, $product_names, $product_quantities,$description, $status){
			        		$old_subtract_inventory_details = SubtractInventoryDetail::where([
			        			['project_id', '=', $request->project_id],
			        			['subtract_id', '=', $subtract_inventory->id],
			        			['status', '<>', 'received']
			        		])->get();
			        		foreach($old_subtract_inventory_details as $old_subtract_detail){
			        			$old_subtract_detail->status = 'cancel';
			        			$old_subtract_detail->deleted_by = $user_id;
			        			$old_subtract_detail->save();
			        			$old_subtract_detail->delete();
			        		}
			        		$subtract_inventory_total_cost =0;
			        		foreach ($product_noes as $key => $value) {
				        		$pro_no  = $product_noes[$key];
				        		$pro_qty = $product_quantities[$key];
				        		$pro_name = $product_names[$key];
				        		$subtract_inventory_detail = SubtractInventoryDetail::create([
				        			'project_id' => $request->project,
				        			'subtract_id' => $subtract_inventory->id,
				        			'material_id' => $pro_no,
				        			'material_name' => $pro_name,
				        			'quantity' => $pro_qty,
	        						'quantity_subtracted' => 0,
				        			'status' => $status,
				        			'created_by' => $user_id
				        		]);
				        		if($status=='received'){
				        			$product = Product::find($pro_no);
				        			$project_product = ProjectMaterial::where([
				        				['project_id', '=', $request->project],
				        				['material_id', '=', $pro_no]
				        			])->first();
				        			$fun_subtract_inventory = $this->subtract_inventory($request->project,$pro_no, $pro_qty, $user_id, $subtract_inventory->id, $this->cost_type);
				        			$total_cost_inv = $fun_subtract_inventory['total_cost_inv'];
				        			$subtract_inventory_total_cost += $total_cost_inv;
				        			$product_subtracted_qty = $pro_qty - $fun_subtract_inventory['product_subtract_qty'];
				        			$subtract_inventory_detail->quantity_subtracted += $product_subtracted_qty;
				        			$subtract_inventory_detail->subtracted_date = date('Y-m-d');
				        			$subtract_inventory_detail->total_cost = $total_cost_inv;
		        					$subtract_inventory_detail->received_by = $user_id;
				        			$subtract_inventory_detail->save();
				        			$product->qty -= $product_subtracted_qty;
				        			$product->save();
				        			$project_product->material_qty -= $product_subtracted_qty;
				        			$project_product->save();
				        		}
				        	}
				        	if($status=='received'){
				        		$subtract_inventory->total_cost = $subtract_inventory_total_cost; 
				        		$subtract_inventory->received_date = date('Y-m-d');
				        		$subtract_inventory->received_by = $user_id;
				        	}
				        	$subtract_inventory->status = $status;
				        	$subtract_inventory->updated_by = $user_id;
				        	$subtract_inventory->save();
				        	Session::put('remove_spitem',1);
			        	});
			        	return redirect()->route('subtract_inventories')->with('success', 'Successfully updated Subtract Inventory');
			        }
	        	}
			}
		}
    }
    public function receive($id){
    	if(!Auth::user()->can('receive-subtract-inventory') && !AppHelper::checkAdministrator()){
            return view('back-end.common.no-permission');
		}else{
			$subtract_inventory = SubtractInventory::find($id);
			if(!$subtract_inventory){
				return redirect()->back()->with('message', 'Not Found');
			}else{
				if($subtract_inventory->status == 'received'){
	        		return redirect()->back()->with('message', 'Can not edit Subtract Inventory');
	        	}else{
	        		$user_id = Auth::id();
	        		$subtract_inventory_details = SubtractInventoryDetail::where([
	        			['project_id', '=', $subtract_inventory->project_id],
	        			['subtract_id', '=', $subtract_inventory->id],
	        			['status', '<>', 'received']
	        		])
	        		->whereNull('deleted_at')->get();
	        		foreach ($subtract_inventory_details as $value) {
		        		$product = ProjectMaterial::where([
	        				['project_id', '=', $subtract_inventory->project_id],
	        				['material_id', '=', $value->material_id]
	        			])->first();
		        		if(!$product){
		        			$error_message = 'Some Product Not found!';
		        			return redirect()->back()->with('message', $error_message);
		        		}else{
		        			if($product->material_qty<$value->quantity){
		        				$error_message= 'Some Product has quantity more than quantity in stock!!!';
		        				return redirect()->route('subtract_inventory.edit',['id'=>$subtract_inventory->id])->with('message',$error_message);
		        			}
		        		}
		        	}
		        	DB::transaction(function() use($user_id,$subtract_inventory,$subtract_inventory_details){
		        		$subtract_inventory_total_cost =0;
		        		foreach ($subtract_inventory_details as $sub_detail) {
			        		$pro_no = $sub_detail->material_id;
			        		$pro_qty = $sub_detail->quantity;
			        		$product = Product::find($pro_no);
			        		$project_product = ProjectMaterial::where([
		        				['project_id', '=', $subtract_inventory->project_id],
		        				['material_id', '=', $pro_no]
		        			])->first();
			        		$fun_subtract_inventory = $this->subtract_inventory($subtract_inventory->project_id,$pro_no, $pro_qty, $user_id, $subtract_inventory->id, $this->cost_type);
			        		$total_cost_inv = $fun_subtract_inventory['total_cost_inv'];
			        		$subtract_inventory_total_cost += $total_cost_inv;
		        			$product_subtracted_qty = $pro_qty - $fun_subtract_inventory['product_subtract_qty'];
		        			$sub_detail->quantity_subtracted += $product_subtracted_qty;
		        			$sub_detail->subtracted_date = date('Y-m-d');
		        			$sub_detail->received_by = $user_id;
		        			$sub_detail->total_cost = $total_cost_inv;
		        			$sub_detail->status = 'received';
		        			$sub_detail->save();
		        			$product->qty -= $product_subtracted_qty;
		        			$product->save();
		        			$project_product->material_qty -= $product_subtracted_qty;
		        			$project_product->save();
			        	}
			        	$subtract_inventory->total_cost += $subtract_inventory_total_cost;
		        		$subtract_inventory->received_date = date('Y-m-d');
		        		$subtract_inventory->received_by = $user_id;
			        	$subtract_inventory->status = 'received';
			        	$subtract_inventory->updated_by = $user_id;
			        	$subtract_inventory->save();
		        	});
		        	return redirect()->back()->with('message', 'Successfully Received SubtractInventory');
	        	}
			}
		}
    }
    public function destroy($id){
    	if(!Auth::user()->can('delete-subtract-inventory') && !AppHelper::checkAdministrator()){
            return view('back-end.common.no-permission');
		}else{
			$subtract_inventory = SubtractInventory::find($id);
			if(!$subtract_inventory){
				return redirect()->back()->with('message', 'Not Found');
			}else{
				if($subtract_inventory->status == 'received'){
	        		return redirect()->back()->with('message', 'Can not Delete Subtract Inventory');
	        	}else{
	        		DB::transaction(function() use($subtract_inventory){
	        			$user_id = Auth::id();
	        			$old_subtract_inventory_details = SubtractInventoryDetail::where('subtract_id', $subtract_inventory->id)
	        			->where('status', '<>', 'received')->get();
			        	foreach ($old_subtract_inventory_details as $old_detail) {
			        		$old_detail->status = 'cancel';
			        		$old_detail->deleted_by = $user_id;
			        		$old_detail->save();
			        		$old_detail->delete();
			        	}
			        	$subtract_inventory->status = 'cancel';
			        	$subtract_inventory->deleted_by = $user_id;
			        	$subtract_inventory->save();
			        	$subtract_inventory->delete();
	        		});
	        		return redirect()->back()->with('success', 'SuccessFully Delete Subtract Inventory');
	        	}
			}
		}
    }
    function get_product(Request $request){
    	$product = ProjectMaterial::where([
    		['project_id', '=', $request->project_id],
    		['material_id', '=', $request->pro_no]
    	])->first();
    	if($product && $request->qty){
    		if($product->material_qty<$request->qty){
    			$data['out_of_stock']=1;
    		}else if($product->material_qty >= $request->qty){
    			$data['out_of_stock']=0;
    		}
    	}else{
    		$data['not_found']=1;
    	}
    	return response()->json($data);
    }
    function view_subtract_from_inventory(Request $request){
    	if(!$request->product && $request->sub){
    		return '<tr>not found</tr>';
    	}
    	$inventory_details = InventoryDetail::where([
    		['inventory_details.subtract_id', '=', $request->sub],
    		['inventory_details.material_id', '=', $request->product]
    	])
    	->select('inventory_details.*', 'inv_subtracted.reference as inv_reference')
    	->join('inventories as inv_subtracted', 'inv_subtracted.id', 'inventory_details.subtract_from_inventory_id')
    	->get();
    	$viewhtml = '<tr style="background:grey!important"> <td style="padding-bottom:0px!important"></td><td colspan="5" style="padding-bottom:0px!important"><table class="table">
                    <tr><td>N<sup>o</sup></td><td>Inventory Reference</td><td>Cost</td> <td>Quantity</td><td>Total</td></tr>';
        foreach($inventory_details as $key => $value) {
        	$viewhtml.='<tr>';
        	$viewhtml.='<td class="text-right">'.($key+1).'</td>';
        	$viewhtml.='<td>'.$value->inv_reference.'</td>';
        	$viewhtml.='<td class="text-right">'.number_format($value->unit_cost,2).'</td>';
        	$viewhtml.='<td class="text-right">'.$value->qty.'</td>';
        	$viewhtml.='<td class="text-right">'.number_format($value->total_cost,2).'</td>';
        	$viewhtml.='</tr>';
        }
        $viewhtml.='</table></td></tr>';
        return $viewhtml;
    }
    function subtract_inventory($project_id,$product_id, $product_qty, $received_by, $subtract_id, $costing_type){
    	$inventories = Inventory::where([
    		['project_id', '=', $project_id],
    		['type', '=', 'purchase'],
    		['stock_status', '=','instock'],
    		['status', '=', 'received'],
    		['in_stock_qty', '>',0],
    		['material_id', '=', $product_id]
    	])
    	->orderBy('id', 'ASC')
    	->get();
    	$product_subtract_qty = $product_qty;
    	$total_cost_inv = 0;
    	if ($inventories) {
    		$subtract_a_inventory = Inventory::create([
    			'project_id' => $project_id,
    			'material_id' => $product_id,
    			'subtract_id' => $subtract_id,
    			'in_out_qty' => 0,
    			'in_stock_qty' => 0,
    			'status' => 'received',
    			'type' => 'subtract',
    			'remarks' => 'Add subtract',
    			'created_by' => $received_by,
    		]);
    		$row_cost_total =[];
    		$unit_cost_total_old =0;
    		foreach($inventories as $key => $inv){
	    		if($product_subtract_qty>0){
	    			$inv_qty = $inv->in_stock_qty;
	    			$curren_subtract_qty =0;
	    			if($inv_qty>=$product_subtract_qty){
	    				$inv_qty -= $product_subtract_qty;
	    				$curren_subtract_qty = $product_subtract_qty;
	    				$product_subtract_qty =0;
	    			}elseif($inv_qty<$product_subtract_qty) {
	    				$product_subtract_qty -= $inv_qty;
	    				$curren_subtract_qty = $inv_qty;
	    				$inv_qty =0;
	    			}
	    			if($inv_qty>0){
	    				$inv->in_stock_qty = $inv_qty;
	    				$inv->stock_status = 'instock';
	    				$inv->save();
	    			}else{
	    				$inv->in_stock_qty = $inv_qty;
	    				$inv->stock_status = 'outstock';
	    				$inv->save();
	    			}
	    			$this_inventory_detail = InventoryDetail::create([
	    				'project_id' => $project_id,
	    				'inventory_id' => $subtract_a_inventory->id,
	    				'subtract_from_inventory_id' => $inv->id,
	    				'subtract_id' => $subtract_id,
	    				'material_id' => $product_id,
	    				'qty' => $curren_subtract_qty *(-1),
	    				'status' => 'received',
	    				'created_by' => $received_by
	    			]);
	    			$unit_cost_total_old += $inv->unit_cost;
    				$row_cost_total[]=[
    					'unit_cost' => $inv->unit_cost,
    					'quantity' => $curren_subtract_qty,
    					'inventory_detail' => $this_inventory_detail
    				];
	    			$subtract_a_inventory->in_out_qty -= $curren_subtract_qty;
	    			$subtract_a_inventory->save();
	    		}
	    	}
	    	if($costing_type == 'fifo'){
	    		foreach ($row_cost_total as $key => $value) {
	    			$value['inventory_detail']->unit_cost = $value['unit_cost'];
	    			$value['inventory_detail']->total_cost = $value['unit_cost']*$value['quantity'];
	    			$value['inventory_detail']->save();
	    			$total_cost_inv += $value['unit_cost']*$value['quantity'];
	    		}
	    	}elseif($costing_type == 'lifo'){
		    	$last_inventory = Inventory::where([
		    		['project_id', '=', $project_id],
		    		['type', '=', 'purchase'],
		    		['status', '=', 'received'],
		    		['material_id', '=', $product_id]
		    	])->latest()->first();
		    	$last_cost = isset($last_inventory->unit_cost)?$last_inventory->unit_cost:0;
	    		foreach ($row_cost_total as $key => $value) {
	    			$value['inventory_detail']->unit_cost = $last_cost;
	    			$value['inventory_detail']->total_cost = $last_cost*$value['quantity'];
	    			$value['inventory_detail']->save();
	    			$total_cost_inv += $last_cost*$value['quantity'];
	    		}
	    	}elseif($costing_type =='average'){
	    		$unit_cost_total_old = $unit_cost_total_old/count($row_cost_total);
	    		foreach ($row_cost_total as $key => $value) {
	    			$value['inventory_detail']->unit_cost = $unit_cost_total_old;
	    			$value['inventory_detail']->total_cost = $unit_cost_total_old*$value['quantity'];
	    			$value['inventory_detail']->save();
	    			$total_cost_inv +=$unit_cost_total_old*$value['quantity'];
	    		}
	    	}
	    	$subtract_a_inventory->total_cost = $total_cost_inv;
	    	$subtract_a_inventory->save();
    	}
    	$data =[
    		'product_subtract_qty' => $product_subtract_qty*1,
    		'total_cost_inv' => $total_cost_inv
    	];
    	return $data;
    }
}