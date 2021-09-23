<?php
namespace App\Http\Controllers;
use App\Http\Requests\blockLandRequest;
use App\Model\Address;
use App\Http\Requests\LandRequest;
use App\Model\BlockLand;
use App\Model\Customer;
use App\Model\Image;
use App\Model\Land;
use App\Model\LandOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Helpers\AppHelper;
use App\Model\Province;
use App\Model\District;
use App\Model\Commune;
use App\Model\Village;
use Validator, DB, View;
use App\Model\LandAddress;
class LandController extends Controller
{
    protected  $base_path;
    public function __construct()
    {
        $this->middleware('auth');
        $this->base_path = "/images/land/";
    }
    public function index(Request $request, Land $land)
    {
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
        $items = $items->sortable()->paginate(20);
        return view('back-end.land.index')->with('item', $items);
    }
    public function create()
    {
        if(!Auth::user()->can('create-land') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        // $addresses = Address::where('sub_of', 0)->orderBy('name', 'asc')->get();
        $provinces = Province::get();
        return view('back-end.land.create', compact('provinces'));
    }
    public function blockLand(blockLandRequest $request, $id)
    {
        BlockLand::create([
            'land_id'=> $id,
            'customer_id' => $request->customer,
            'x' => $request->value_x,
            'y' => $request->value_y,
            'description' => $request->block_description,
        ]);
        return json_encode([
            'land_id'=> $id,
            'customer_id' => $request->customer_id,
            'description' => $request->block_description,
            'x' => $request->value_x,
            'y' => $request->value_y,
        ]);
    }
    public function deleteBlockLand($id)
    {
        BlockLand::where(['id' => $id])->delete();
        Session::flash('message', 'You have successfully deleted block land');
        return redirect()->back();
    }
    public function getAddress(Request $request){
        if ($request->ajax()) {
            $addresses = address::where('sub_of', $request->pro_id)->orderBy('name', 'asc')->get();
            return $addresses;
        }
    }
    public function store(LandRequest $request)
    {
        if(!Auth::user()->can('create-land') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = new Land();
        $items->property_name = Input::get('land_name');
        $items->item_type = 1;
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->ground_surface = Input::get('ground_surface');
        $items->land_num = Input::get('land_num');
        $items->map_data = Input::get('map_data');
        $items->project_id = -1;
        $items->province = Input::get('province');
        $items->district = Input::get('district');
        $items->commune = Input::get('commune');
        $items->village = Input::get('village');
        $items->save();
        $image = $request->file('land_layout');
        if(!empty($image)) {
            $extension = $image->getClientOriginalExtension();
            $imageName = 'land_layout_' .$items->id. $extension;
            $image->move(public_path($this->base_path), $imageName);
            \App\Model\Image::create([
                'object_id' => $items->id,
                'object_key' => 3,
                'path' => $this->base_path.$imageName
            ]);
        }
        return redirect(route("editLand", $items->id).'?tab=2')->with("success", "You have successfully added land");
    }
    public function edit($id, $land_owner_id = null)
    {
        if(!Auth::user()->can('edit-land') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(!empty($land_owner_id)){
            $land_owner = LandOwner::find($land_owner_id);
        }else{
            $land_owner = new LandOwner();
        }
        $addresses = Address::where('sub_of', 0)->orderBy('name', 'asc')->get();
        $item = Land::findOrFail($id);
        $customer = Customer::all();
        $land_layout = Image::where([ 'object_id' => $id, 'object_key' => 3])->first();
        if(is_null($land_layout)){
            $land_layout = new Image();
        }
        $blockLand = BlockLand::where('land_id', $id)->get();
        $provinces = Province::get();
        $districts=[];
        if($item->province){
            $districts = District::where('pro_id', '=', $item->province)->get();
        }
        $communes =[];
        if($item->district){
            $communes = Commune::where('district_id', '=', $item->district)->get();
        }
        $villages =[];
        if($item->commune){
            $villages = Village::where('commune_id', '=', $item->commune)->get();
        }
        $land_address = LandAddress::select(DB::raw('
            land_id AS id,
            provinces.province_kh_name AS province_name,
            districts.district_namekh AS district_name,
            communes.commune_namekh AS commune_name,
            villages.village_namekh AS village_name
        '))
        ->where('land_id', '=', $item->id)
        ->join('provinces', 'province_id', '=', 'pro_id')
        ->join('districts',  'district_id', '=', 'dis_id')
        ->join('communes', 'commune_id', '=', 'com_id')
        ->join('villages', 'village_id', '=', 'vill_id')
        ->get();
        return view('back-end.land.edit', compact('customer', 'item', 'land_owner','addresses', 'land_layout', 'blockLand','provinces', 'districts', 'communes', 'villages', 'land_address'));
    }
    public function destroy($id)
    {
        // $items = Land::find($id);
        // $items->delete();
        Session::flash('message', 'You have successfully deleted land');
        return Redirect::to('land');
    }
    public function deleteLandOwner($id)
    {
        LandOwner::where(['id' => $id])->delete();
        Session::flash('message', 'You have successfully deleted land owner.');
        return Redirect()->back();
    }
    public function update(LandRequest $request, $id)
    {
        // dd($request->all()); 
        $items = Land::findOrFail($id);
        $items->property_name = Input::get('land_name');
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->map_data = Input::get('map_data');
        $items->project_id = -1;
        $items->province = Input::get('province');
        $items->district = Input::get('district');
        $items->commune = Input::get('commune');
        $items->village = Input::get('village');
        $items->save();
        $image = $request->file('land_layout');
        
        if(!empty($image)) {
            $extension = $image->getClientOriginalExtension();
            $imageName = 'land_layout_'.$id. $extension;
            $image->move(public_path($this->base_path), $imageName);
            $user = \App\Model\Image::firstOrNew(array('object_id' => $id, 'object_key' => 3 ));
            $user->object_id = $id;
            $user->object_key = 3;
            $user->path = $this->base_path.$imageName;
            $user->save();
        }
        Session::flash('message', 'You have successfully updated land');
        return Redirect::to('land');
    }
    public function createLandOwner(Request $request, $land_id)
    {
        if($request->id && !empty($request->id)){
            $land_owner = LandOwner::where('id', $request->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->sex,
                'land_id' => $land_id,
                'price' => $request->price,
                'ground_surface' => $request->ground_surface,
                'note' => $request->remark
                ]);
        }else{
            $land_owner = LandOwner::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->sex,
                'land_id' => $land_id,
                'price' => $request->price,
                'ground_surface' => $request->ground_surface,
                'note' => $request->remark
            ]);
        }
        if($land_owner){
            return redirect(route("editLand", $land_id).'?tab=2')->with('success', 'Successfully create land owner.');
        }
        return redirect()->back()->withInput(Input::all())->with('error', 'Unable create land owner.');
    }
    public function add_other_address(Request $request, $land_id){
        $this->validate($request, [
            'mod_province' => 'required',
            'mod_district' => 'required',
            'mod_commune' => 'required',
            'mod_village' => 'required'
        ]);
        LandAddress::create([
            'land_id' => $land_id,
            'province_id' => $request->mod_province,
            'district_id' => $request->mod_district,
            'commune_id' => $request->mod_commune,
            'village_id' => $request->mod_village,
            'created_by' => Auth::id()
        ]);
        $data['message'] = 'Add address successfully';
        return response()->json($data, 200);
    }
    public function edit_other_address(Request $request){
        if(!$request->id){
            return response()->json(['message' => 'No Data Found!'], 404);
        }
        $item = LandAddress::select(DB::raw('
            id,
            province_id AS province,
            district_id AS district,
            commune_id AS commune,
            village_id AS village
        '))
        ->where('id', $request->id)->first();
        $provinces = Province::get();
        $districts=[];
        if($item->province){
            $districts = District::where('provice_id', '=', $item->province)->get();
        }
        $communes =[];
        if($item->district){
            $communes = Commune::where('district_id', '=', $item->district)->get();
        }
        $villages =[];
        if($item->commune){
            $villages = Village::where('commune_id', '=', $item->commune)->get();
        }
        $data['html_data'] = "".View::make('back-end.land.edit_address', compact('item', 'provinces', 'districts', 'communes', 'villages'));
        return response()->json($data, 200);
    }
    public function update_other_address(Request $request,$id){
        $land_address =  LandAddress::find($id);
        if(empty($land_address)){
            return response()->json(['message' => 'No Data Found!'], 404);
        }
        $this->validate($request, [
            'emod_province' => 'required',
            'emod_district' => 'required',
            'emod_commune' => 'required',
            'emod_village' => 'required'
        ]);
        $land_address->update([
            'province_id' => $request->emod_province,
            'district_id' => $request->emod_district,
            'commune_id' => $request->emod_commune,
            'village_id' => $request->emod_village
        ]);
        $data['message'] = 'Edit address successfully';
        return response()->json($data, 200);
    }
}
?>