<?php
namespace App\Http\Controllers;
use App\Http\Requests\PropertyRequest;
use App\Model\Project;
use App\Model\ProjectZone;
use App\Model\Property;
use App\Model\PropertyPriceTransaction;
use App\Model\Customer;
use App\Model\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Auth, Validator;
use App\Helpers\AppHelper;
use DB, Form;
class PropertyController extends Controller
{
    protected  $base_path;
    protected  $thumb_path;
    public function __construct()
    {
        $this->middleware('auth');
        $this->base_path = "/images/property/";
        $this->thumb_path = "/images/property/thumbs/";
        $this->select_one = ['' => '-- Select --'];
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request,Property $property)
    // {
    //     if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
    //         return view('back-end.common.no-permission');
    //     /**
    //      * Land and Project have Fixed ID value
    //      * Land = 1
    //      * Project = 2
    //      */
    //     $items = new Property();
    //     $items = $items->select(DB::raw('
    //         items.*,
    //         CONCAT(customers.last_name," ",customers.first_name) as customer_name
    //     '))
    //     ->whereNull('items.is_merge');
    //     if($request->search && !empty($request->search)) {
    //         $search = $request->search;
    //         $items = $items
    //             ->where(function ($query) use($search) {
    //                 $query->where('items.id',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.property_name',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.property_no',      'like',     '%'.$search.'%');
    //                 $query->orWhere('customers.first_name',      'like',     '%'.$search.'%');
    //                 $query->orWhere('customers.last_name',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.address_street',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.year_of_construction',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.status',      'like',     '%'.$search.'%');
    //             })
    //             ->where("items.item_type", ">", 2);
    //     }else{
    //         $items = $items->where("items.item_type", ">", 2);
    //     }
    //     if(!empty($request->customer)){
    //         $items = $items->where('customers.id', '=', $request->customer);
    //     }
    //     if(!empty($request->project)){
    //         $items = $items->where('items.project_id', '=', $request->project);
    //     }

    //     //custom query---query fix value of project with number  for house or land
    //     $items = $items->where(array(["items.project_id",'>', 6],["items.project_id",'<', 9]));
    //     $items = $items
    //     ->leftJoin('sale_items',function($query){
    //         $query->on('sale_items.property_id', '=', 'items.id');
    //         $query->where(function($subquery){
    //             $subquery->where('sale_items.status', '=', 'sold');
    //             $subquery->orWhere('sale_items.status', '=', 'completed');
    //         });
    //     })
    //     ->leftJoin('customers', 'customers.id', '=', 'sale_items.customer_id');
    //     $items= $items->sortable()->orderBy('items.property_name', 'DESC')->paginate(20);
    //     $projects=Project::select('id', 'property_name')->whereNull('project_id')->get();
    //     $customers =Customer::get();
    //     return view('back-end.property.others.index', compact('projects', 'customers', 'request'))->with('item', $items);
    // }
    // public function vehicle(Request $request,Property $property)
    // {
    //     if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
    //         return view('back-end.common.no-permission');
    //     /**
    //      * Land and Project have Fixed ID value
    //      * Land = 1
    //      * Project = 2
    //      */
    //     $items = new Property();
    //     $items = $items->select(DB::raw('
    //         items.*,
    //         CONCAT(customers.last_name," ",customers.first_name) as customer_name
    //     '))
    //     ->whereNull('items.is_merge');
    //     if($request->search && !empty($request->search)) {
    //         $search = $request->search;
    //         $items = $items
    //             ->where(function ($query) use($search) {
    //                 $query->where('items.id',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.property_name',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.property_no',      'like',     '%'.$search.'%');
    //                 $query->orWhere('customers.first_name',      'like',     '%'.$search.'%');
    //                 $query->orWhere('customers.last_name',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.address_street',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.year_of_construction',      'like',     '%'.$search.'%');
    //                 $query->orWhere('items.status',      'like',     '%'.$search.'%');
    //             })
    //             ->where("items.item_type", ">", 2);
    //     }else{
    //         $items = $items->where("items.item_type", ">", 2);
    //     }
    //     if(!empty($request->customer)){
    //         $items = $items->where('customers.id', '=', $request->customer);
    //     }
    //     if(!empty($request->project)){
    //         $items = $items->where('items.project_id', '=', $request->project);
    //     }
    //     //custom query---query fix value of project with number 1 for vehicle
    //     $items = $items->where(array(["items.project_id",'>', 3],["items.project_id",'<', 6]));
    //     $items = $items ->leftJoin('sale_items',function($query){
    //         $query->on('sale_items.property_id', '=', 'items.id');
    //         $query->where(function($subquery){
    //             $subquery->where('sale_items.status', '=', 'sold');
    //             $subquery->orWhere('sale_items.status', '=', 'completed');
    //         });
    //     })
    //     ->leftJoin('customers', 'customers.id', '=', 'sale_items.customer_id');
    //     $items= $items->sortable()->orderBy('items.property_name', 'DESC')->paginate(20);
    //     $projects=Project::select('id', 'property_name')->whereNull('project_id')->get();
    //     $customers =Customer::get();
    //     return view('back-end.property.vehicle.index', compact('projects', 'customers', 'request'))->with('item', $items);
    // }
    public function others(Request $request,Property $property)
    {
        if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        /**
         * Land and Project have Fixed ID value
         * Land = 1
         * Project = 2
         */
        $items = new Property();
        $items = $items->select(DB::raw('
            items.*,
            CONCAT(customers.last_name," ",customers.first_name) as customer_name
        '))
        ->whereNull('items.is_merge');
        if($request->search && !empty($request->search)) {
            $search = $request->search;
            $items = $items
                ->where(function ($query) use($search) {
                    $query->where('items.id',      'like',     '%'.$search.'%');
                    $query->orWhere(DB::raw('CONCAT(last_name," ",first_name)'), 'LIKE', '%' . $search . '%');
                    $query->orWhere('items.property_name',      'like',     '%'.$search.'%');
                    $query->orWhere('items.property_no',      'like',     '%'.$search.'%');
                    $query->orWhere('customers.first_name',      'like',     '%'.$search.'%');
                    $query->orWhere('customers.last_name',      'like',     '%'.$search.'%');
                    $query->orWhere('items.address_street',      'like',     '%'.$search.'%');
                    $query->orWhere('items.year_of_construction',      'like',     '%'.$search.'%');
                    $query->orWhere('items.status',      'like',     '%'.$search.'%');
                })
                ->where("items.item_type", ">", 2);
        }else{
            $items = $items->where("items.item_type", ">", 2);
        }
        if(!empty($request->customer)){
            $items = $items->where('customers.id', '=', $request->customer);
        }
        if(!empty($request->project)){
            $items = $items->where('items.project_id', '=', $request->project);
        }
        //custom query---query fix value of project with number 1 for vehicle
        $items = $items->where(array(["items.project_id",'>', 3],["items.project_id",'<', 10]));


        $items = $items
        ->leftJoin('sale_items',function($query){
            $query->on('sale_items.property_id', '=', 'items.id');
            $query->where(function($subquery){
                $subquery->where('sale_items.status', '=', 'sold');
                $subquery->orWhere('sale_items.status', '=', 'completed');
            });
        })
        ->leftJoin('customers', 'customers.id', '=', 'sale_items.customer_id');
        $items= $items->sortable()->orderBy('items.property_name', 'DESC')->paginate(20);
        $projects=Project::select('id', 'property_name')->whereNull('project_id')->get();
        $customers =Customer::get();
        return view('back-end.property.others.index', compact('projects', 'customers', 'request'))->with('item', $items);
    }
    public function loan_view($loan_type,Request $request)
    {
        if(!Auth::user()->can('list-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        /**
         * Land and Project have Fixed ID value
         * Land = 1
         * Project = 2
         */
        $items = new Property();
        $items = $items->select(DB::raw('
            items.*,loans.id as loan_id,loans.loan_amount,loans.loan_date,loans.installment_term,loans.duration_type,loans.interest_rate,
            CONCAT(customers.last_name," ",customers.first_name) as customer_name
        '))
        ->whereNull('items.is_merge');
        if($request->search && !empty($request->search)) {
            $search = $request->search;
            $items = $items
                ->where(function ($query) use($search) {
                    $query->where('items.id',      'like',     '%'.$search.'%');
                    $query->orWhere('items.property_name',      'like',     '%'.$search.'%');
                    $query->orWhere('items.property_no',      'like',     '%'.$search.'%');
                    $query->orWhere('customers.first_name',      'like',     '%'.$search.'%');
                    $query->orWhere('customers.last_name',      'like',     '%'.$search.'%');
                    $query->orWhere('items.address_street',      'like',     '%'.$search.'%');
                    $query->orWhere('items.year_of_construction',      'like',     '%'.$search.'%');
                    $query->orWhere('items.status',      'like',     '%'.$search.'%');
                })
                ->where("items.item_type", ">", 2);
        }else{
            $items = $items->where("items.item_type", ">", 2);
        }
        if(!empty($request->customer)){
            $items = $items->where('customers.id', '=', $request->customer);
        }
        if(!empty($request->project)){
            $items = $items->where('items.project_id', '=', $request->project);
        }
      
        


        $items = $items
        ->leftJoin('sale_items',function($query){
            $query->on('sale_items.property_id', '=', 'items.id');
            $query->where(function($subquery){
                $subquery->where('sale_items.status', '=', 'sold');
                $subquery->orWhere('sale_items.status', '=', 'completed');
            });
        })
        ->leftJoin('customers', 'customers.id', '=', 'sale_items.customer_id')
        ->Join('loans', 'loans.sale_id', '=', 'sale_items.id')  
        ->where('loans.loan_type',$loan_type);
        $items= $items->sortable()->orderBy('items.property_name', 'DESC')->paginate(20);
        $projects=Project::select('id', 'property_name')->whereNull('project_id')->get();
        $customers =Customer::get();
        return view('back-end.property.loan_view.index', compact('projects', 'customers', 'request'))->with(array('item'=> $items,'loan_type'=>$loan_type));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vehicle_create()
    {
        //project id 1 for vehicle ---custom
        if(!Auth::user()->can('create-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $projects = $this->select_one + Project::where(array("item_type"=> 2,["id",'>', 3],["id",'<', 6]))->pluck('property_name', 'id')->toArray();
        $projectzones = ProjectZone::all();
        $propertytypes = PropertyType::where("id", ">", 2)->get();
        return view('back-end.property.vehicle.create', [
            'projects' => $projects,
            'propertytypes' => $propertytypes,
            'projectzones' => $projectzones
        ]);
    }
    public function others_create()
    {
        //project id 1 for vehicle ---custom
        if(!Auth::user()->can('create-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
            $projects = $this->select_one + Project::where(array("item_type"=> 2,["id",'>', 3],["id",'<', 10]))->pluck('property_name', 'id')->toArray();
        $projectzones = ProjectZone::all();
        $propertytypes = PropertyType::where("id", ">", 2)->get();
        return view('back-end.property.others.create', [
            'projects' => $projects,
            'propertytypes' => $propertytypes,
            'projectzones' => $projectzones
        ]);
    }
    public function create()
    {
        if(!Auth::user()->can('create-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $projects = $this->select_one + Project::where(array("item_type"=> 2,["id",'>', 6],["id",'<', 9]))->pluck('property_name', 'id')->toArray();
        $projectzones = ProjectZone::all();
        $propertytypes = PropertyType::where("id", ">", 2)->get();
        return view('back-end.property.create', [
            'projects' => $projects,
            'propertytypes' => $propertytypes,
            'projectzones' => $projectzones
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('create-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'project' => 'required',
            'project_zone' => 'required',
            'property_type' => 'required',
            'property_name' => 'required',
            // property_no' => 'required|unique:items,property_no'
            'property_no' => 'required'
        ],[],[
            'property_no' => 'Property Number',
            'property_type' => 'Property Type'
        ]);
        $items = new Property();
        //custom vehicle
        $items->vehicle_color = Input::get('vehicle_color');
        $items->vehicle_quantity = Input::get('vehicle_quantity');
        $items->number_plate = Input::get('number_plate');
        $items->model = Input::get('model');
        $items->owner_vehicle = Input::get('owner_vehicle');
        $items->vehicle_date = Input::get('vehicle_date');
        $items->date_property_no = Input::get('date_property_no');
        $items->nb_machine = Input::get('nb_machine');
        $items->project_id = Input::get('project');
        $items->item_zone = Input::get('project_zone');
        $items->land_id = -1;
        $items->item_type = Input::get('property_type');
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->property_name = Input::get('property_name');
        $items->property_no = Input::get('property_no');
        $items->address_zip_code = Input::get('zip_code');
        $items->bed_rooms = Input::get('bed_room');
        $items->bathrooms = Input::get('bath_room');
        $items->other_room = Input::get('other_room');
        $items->property_price = Input::get('price');
        $items->property_discount_amount = Input::get('discount_amount');
        $items->boundary_north = Input::get('boundary_north');
        $items->boundary_south = Input::get('boundary_south');
        $items->boundary_east = Input::get('boundary_east');
        $items->boundary_west = Input::get('boundary_west');
        $items->product_first = Input::get('product_first');
        $items->product_second = Input::get('product_second');
        $items->product_third = Input::get('product_third');
        $items->product_four = Input::get('product_four');
        $items->product_five = Input::get('product_five');
        $items->village = Input::get('village');
        $items->commune = Input::get('commune');
        $items->district = Input::get('district');
        $items->province = Input::get('province');
        $items->has_elevator = Input::get('has_elevator');
        $items->has_basement = Input::get('has_basement');
        $items->has_swimming_pool = Input::get('has_swimming_pool');
        $items->living_room_surface = Input::get('living_room_surface');
        $items->built_up_surface = Input::get('built_up_surface');
        $items->habitable_surface = Input::get('habitable_surface');
        $items->ground_surface = Input::get('ground_surface');
        $items->land_num = Input::get('land_num');
        $items->width = Input::get('width');
        $items->length = Input::get('length');
        $items->house_number = Input::get('house_number');
        $items->year_of_construction = Input::get('year_of_construction');
        $items->year_of_renovation = Input::get('year_of_renovation');
        $items->floor_number = Input::get('floor_number');
        $items->total_number_of_floors_building = Input::get('total_number_of_floors_building');
        $items->map_data = Input::get('map_data');
        $items->status = 1;
        $abouts = Input::get('about');
        $about='';
        foreach($abouts as $key => $value){
            if($key==0){
                $about.=$value;
            }else{
                $about.='&&$,$&&'.$value;
            }
        }
        $items->about = $about;
        $items->save();
        PropertyPriceTransaction::create([
            'project_id' => $items->project_id,
            'zone_id' => $items->item_zone,
            'property_type' => $items->item_type,
            'property_id' => $items->id,
            'amount' => $items->property_price,
            'created_by' => Auth::id()
        ]);
        $images = $request->file('images');
        if(!empty($images)) {
            foreach ($images as $index => $image) {
                $image_name = "property".$items->id."_".date("His").$index.$image->getClientOriginalExtension();
                $image->move(
                    base_path() . '/public/'.$this->base_path, $image_name
                );
                $img = Image::make(base_path() . '/public/'.$this->base_path . $image_name);
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                try{
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                } catch (\Exception $e) {
                    mkdir(base_path() . '/public/'.$this->thumb_path);
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                }
                \App\Model\Image::create([
                    'object_id' => $items->id,
                    'object_key' => 3,
                    'path' => $this->base_path.$image_name
                ]);
            }
        }
        Session::flash('message', 'You have successfully added property');
        return Redirect::to('property');
    }
    public function vehicleStore(Request $request)
    {
        if(!Auth::user()->can('create-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'project' => 'required',
            'project_zone' => 'required',
            'property_type' => 'required',
            'property_name' => 'required',
            // 'property_no' => 'required|unique:items,property_no'
            'property_no' => 'required'
        ],[],[
            'property_no' => 'Property Number',
            'property_type' => 'Property Type'
        ]);
        $items = new Property();
        //custom vehicle
        $items->vehicle_color = Input::get('vehicle_color');
        $items->vehicle_quantity = Input::get('vehicle_quantity');
        $items->number_plate = Input::get('number_plate');
        $items->model = Input::get('model');
        $items->owner_vehicle = Input::get('owner_vehicle');
        $items->vehicle_date = Input::get('vehicle_date');
        $items->date_property_no = Input::get('date_property_no');
        $items->nb_machine = Input::get('nb_machine');
        $items->project_id = Input::get('project');
        $items->item_zone = Input::get('project_zone');
        $items->land_id = -1;
        $items->item_type = Input::get('property_type');
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->property_name = Input::get('property_name');
        $items->property_no = Input::get('property_no');
        $items->address_zip_code = Input::get('zip_code');
        $items->bed_rooms = Input::get('bed_room');
        $items->bathrooms = Input::get('bath_room');
        $items->other_room = Input::get('other_room');
        $items->property_price = Input::get('price');
        $items->property_discount_amount = Input::get('discount_amount');
        $items->boundary_north = Input::get('boundary_north');
        $items->boundary_south = Input::get('boundary_south');
        $items->boundary_east = Input::get('boundary_east');
        $items->boundary_west = Input::get('boundary_west');
        $items->product_first = Input::get('product_first');
        $items->product_second = Input::get('product_second');
        $items->product_third = Input::get('product_third');
        $items->product_four = Input::get('product_four');
        $items->product_five = Input::get('product_five');
        $items->village = Input::get('village');
        $items->commune = Input::get('commune');
        $items->district = Input::get('district');
        $items->province = Input::get('province');
        $items->has_elevator = Input::get('has_elevator');
        $items->has_basement = Input::get('has_basement');
        $items->has_swimming_pool = Input::get('has_swimming_pool');
        $items->living_room_surface = Input::get('living_room_surface');
        $items->built_up_surface = Input::get('built_up_surface');
        $items->habitable_surface = Input::get('habitable_surface');
        $items->ground_surface = Input::get('ground_surface');
        $items->land_num = Input::get('land_num');
        $items->width = Input::get('width');
        $items->length = Input::get('length');
        $items->house_number = Input::get('house_number');
        $items->year_of_construction = Input::get('year_of_construction');
        $items->year_of_renovation = Input::get('year_of_renovation');
        $items->floor_number = Input::get('floor_number');
        $items->total_number_of_floors_building = Input::get('total_number_of_floors_building');
        $items->map_data = Input::get('map_data');
        $items->status = 1;
        $abouts = Input::get('about');
        $about='';
        foreach($abouts as $key => $value){
            if($key==0){
                $about.=$value;
            }else{
                $about.='&&$,$&&'.$value;
            }
        }
        $items->about = $about;
        $items->save();
        PropertyPriceTransaction::create([
            'project_id' => $items->project_id,
            'zone_id' => $items->item_zone,
            'property_type' => $items->item_type,
            'property_id' => $items->id,
            'amount' => $items->property_price,
            'created_by' => Auth::id()
        ]);
        $images = $request->file('images');
        if(!empty($images)) {
            foreach ($images as $index => $image) {
                $image_name = "property".$items->id."_".date("His").$index.$image->getClientOriginalExtension();
                $image->move(
                    base_path() . '/public/'.$this->base_path, $image_name
                );
                $img = Image::make(base_path() . '/public/'.$this->base_path . $image_name);
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                try{
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                } catch (\Exception $e) {
                    mkdir(base_path() . '/public/'.$this->thumb_path);
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                }
                \App\Model\Image::create([
                    'object_id' => $items->id,
                    'object_key' => 3,
                    'path' => $this->base_path.$image_name
                ]);
            }
        }
        Session::flash('message', 'You have successfully added property');
        return Redirect::to('vehicle');
    }
    public function othersStore(Request $request)
    {
        if(!Auth::user()->can('create-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'project' => 'required',
            'project_zone' => 'required',
            'property_type' => 'required',
            'property_name' => 'required',
            // 'property_no' => 'required|unique:items,property_no'
            'property_no' => 'required'
        ],[],[
            'property_no' => 'Property Number',
            'property_type' => 'Property Type'
        ]);
        $items = new Property();
        //custom vehicle
        $items->vehicle_color = Input::get('vehicle_color');
        $items->vehicle_quantity = Input::get('vehicle_quantity');
        $items->number_plate = Input::get('number_plate');
        $items->model = Input::get('model');
        $items->owner_vehicle = Input::get('owner_vehicle');
        $items->vehicle_date = Input::get('vehicle_date');
        $items->date_property_no = Input::get('date_property_no');
        $items->nb_machine = Input::get('nb_machine');
        $items->project_id = Input::get('project');
        $items->item_zone = Input::get('project_zone');
        $items->land_id = -1;
        $items->item_type = Input::get('property_type');
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->property_name = Input::get('property_name');
        $items->property_no = Input::get('property_no');
        $items->address_zip_code = Input::get('zip_code');
        $items->bed_rooms = Input::get('bed_room');
        $items->bathrooms = Input::get('bath_room');
        $items->other_room = Input::get('other_room');
        $items->property_price = Input::get('price');
        $items->property_discount_amount = Input::get('discount_amount');
        $items->boundary_north = Input::get('boundary_north');
        $items->boundary_south = Input::get('boundary_south');
        $items->boundary_east = Input::get('boundary_east');
        $items->boundary_west = Input::get('boundary_west');
        $items->product_first = Input::get('product_first');
        $items->product_second = Input::get('product_second');
        $items->product_third = Input::get('product_third');
        $items->product_four = Input::get('product_four');
        $items->product_five = Input::get('product_five');
        $items->village = Input::get('village');
        $items->commune = Input::get('commune');
        $items->district = Input::get('district');
        $items->province = Input::get('province');
        $items->has_elevator = Input::get('has_elevator');
        $items->has_basement = Input::get('has_basement');
        $items->has_swimming_pool = Input::get('has_swimming_pool');
        $items->living_room_surface = Input::get('living_room_surface');
        $items->built_up_surface = Input::get('built_up_surface');
        $items->habitable_surface = Input::get('habitable_surface');
        $items->ground_surface = Input::get('ground_surface');
        $items->land_num = Input::get('land_num');
        $items->width = Input::get('width');
        $items->length = Input::get('length');
        $items->house_number = Input::get('house_number');
        $items->year_of_construction = Input::get('year_of_construction');
        $items->year_of_renovation = Input::get('year_of_renovation');
        $items->floor_number = Input::get('floor_number');
        $items->total_number_of_floors_building = Input::get('total_number_of_floors_building');
        $items->map_data = Input::get('map_data');
        $items->status = 1;
        $abouts = Input::get('about');
        $about='';
        foreach($abouts as $key => $value){
            if($key==0){
                $about.=$value;
            }else{
                $about.='&&$,$&&'.$value;
            }
        }
        $items->about = $about;
        $items->save();
        PropertyPriceTransaction::create([
            'project_id' => $items->project_id,
            'zone_id' => $items->item_zone,
            'property_type' => $items->item_type,
            'property_id' => $items->id,
            'amount' => $items->property_price,
            'created_by' => Auth::id()
        ]);
        $images = $request->file('images');
        if(!empty($images)) {
            foreach ($images as $index => $image) {
                $image_name = "property".$items->id."_".date("His").$index.$image->getClientOriginalExtension();
                $image->move(
                    base_path() . '/public/'.$this->base_path, $image_name
                );
                $img = Image::make(base_path() . '/public/'.$this->base_path . $image_name);
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                try{
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                } catch (\Exception $e) {
                    mkdir(base_path() . '/public/'.$this->thumb_path);
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                }
                \App\Model\Image::create([
                    'object_id' => $items->id,
                    'object_key' => 3,
                    'path' => $this->base_path.$image_name
                ]);
            }
        }
        Session::flash('message', 'You have successfully added property');
        return Redirect::to('others');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('edit-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        // $projects = Project::where("item_type", 2)->get();
        $projects = $this->select_one + Project::where(array("item_type"=> 2,["id",'>', 3],["id",'<', 10]))->pluck('property_name', 'id')->toArray();
        $projectzones = ProjectZone::all();
        $propertytypes = PropertyType::where("id", ">", 2)->get();
        $properties = Property::findOrFail($id);
        $abouts=[];
        if($properties){
            $abouts=explode("&&$,$&&", $properties->about);
        }
        return view('back-end.property.edit', [
            'projects' => $projects,
            'propertytypes' => $propertytypes,
            'projectzones' => $projectzones  ,
            'item' => $properties,
            'abouts' => $abouts
        ]);
    }
    public function edit_vehicle($id)
    {
        if(!Auth::user()->can('edit-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        // $projects = Project::where("item_type", 2)->get();
        $projects = $this->select_one + Project::where(array("item_type"=> 2,["id",'>', 3],["id",'<', 6]))->pluck('property_name', 'id')->toArray();
        $projectzones = ProjectZone::all();
        $propertytypes = PropertyType::where("id", ">", 2)->get();
        $properties = Property::findOrFail($id);
        $abouts=[];
        if($properties){
            $abouts=explode("&&$,$&&", $properties->about);
        }
        return view('back-end.property.vehicle.edit', [
            'projects' => $projects,
            'propertytypes' => $propertytypes,
            'project_zones' => $this->select_one + $properties->project->projectZone()->pluck('name', 'id')->toArray(),
            'item' => $properties,
            'abouts' => $abouts
        ]);
    }
    public function show($id) {
        if(!Auth::user()->can('view-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $item = Property::findOrFail($id);
        $images = \App\Model\Image::where("object_id", $id)->where('object_key', 3)->get();
        $abouts=[];
        if($item){
            $abouts=explode("&&$,$&&", $item->about);
        }
        return view('back-end.property.detail', [
            'item' => $item,
            'images' => $images,
            'abouts' => $abouts
        ]);
    }

    public function edit_others($id)
    {
        if(!Auth::user()->can('edit-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        // $projects = Project::where("item_type", 2)->get();
        $projects = $this->select_one + Project::where(array("item_type"=> 2,["id",'>', 3],["id",'<', 10]))->pluck('property_name', 'id')->toArray();
        $projectzones = ProjectZone::all();
        $propertytypes = PropertyType::where("id", ">", 2)->get();
        $properties = Property::findOrFail($id);
        $abouts=[];
        if($properties){
            $abouts=explode("&&$,$&&", $properties->about);
        }
        return view('back-end.property.others.edit', [
            'projects' => $projects,
            'propertytypes' => $propertytypes,
            'project_zones' => $this->select_one + $properties->project->projectZone()->pluck('name', 'id')->toArray(),
            'item' => $properties,
            'abouts' => $abouts
        ]);
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->can('edit-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'project' => 'required',
            'project_zone' => 'required',
            'property_type' => 'required',
            'property_name' => 'required',
            // 'property_no' => 'required|unique:items,property_no,'.$id
            'property_no' => 'required'
        ],[],[
            'property_no' => 'Property Number',
            'property_type' => 'Property Type'
        ]);
        $items = Property::findOrFail($id);
        $items->project_id = Input::get('project');
        $items->item_zone = Input::get('project_zone');
        $items->land_id = -1;
        $items->item_type = Input::get('property_type');
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->property_name = Input::get('property_name');
        $items->property_no = Input::get('property_no');
        $items->address_zip_code = Input::get('zip_code');
        $items->bed_rooms = Input::get('bed_room');
        $items->bathrooms = Input::get('bath_room');
        $items->other_room = Input::get('other_room');
        if($items->status !=2){
        $items->property_price = Input::get('price');
        $items->property_discount_amount = Input::get('discount_amount');
        }
        $items->boundary_north = Input::get('boundary_north');
        $items->boundary_south = Input::get('boundary_south');
        $items->boundary_east = Input::get('boundary_east');
        $items->boundary_west = Input::get('boundary_west');
        $items->product_first = Input::get('product_first');
        $items->product_second = Input::get('product_second');
        $items->product_third = Input::get('product_third');
        $items->product_four = Input::get('product_four');
        $items->product_five = Input::get('product_five');
        $items->village = Input::get('village');
        $items->commune = Input::get('commune');
        $items->district = Input::get('district');
        $items->province = Input::get('province');
        $items->has_elevator = Input::get('has_elevator');
        $items->has_basement = Input::get('has_basement');
        $items->has_swimming_pool = Input::get('has_swimming_pool');
        $items->living_room_surface = Input::get('living_room_surface');
        $items->built_up_surface = Input::get('built_up_surface');
        $items->habitable_surface = Input::get('habitable_surface');
        $items->ground_surface = Input::get('ground_surface');
        $items->land_num = Input::get('land_num');
        $items->width = Input::get('width');
        $items->length = Input::get('length');
        $items->house_number = Input::get('house_number');
        $items->year_of_construction = Input::get('year_of_construction');
        $items->year_of_renovation = Input::get('year_of_renovation');
        $items->floor_number = Input::get('floor_number');
        $items->total_number_of_floors_building = Input::get('total_number_of_floors_building');
        $items->map_data = Input::get('map_data');
        // $items->status = Input::get('status');
        $abouts = Input::get('about');
        $about='';
        foreach($abouts as $key => $value){
            if($key==0){
                $about.=$value;
            }else{
                $about.='&&$,$&&'.$value;
            }
        }
        $items->about = $about;
        $items->save();
        PropertyPriceTransaction::create([
            'project_id' => $items->project_id,
            'zone_id' => $items->item_zone,
            'property_type' => $items->item_type,
            'property_id' => $items->id,
            'amount' => $items->property_price,
            'created_by' => Auth::id()
        ]);
        $images = $request->file('images');
        if(!empty($images)) {
            foreach ($images as $index => $image) {
                $image_name = "property".$items->id."_".date("His").$index.$image->getClientOriginalExtension();
                $image->move(
                    base_path() . '/public/'.$this->base_path, $image_name
                );
                $img = Image::make(base_path() . '/public/'.$this->base_path . $image_name);
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                try{
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                } catch (\Exception $e) {
                    mkdir(base_path() . '/public/'.$this->thumb_path);
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                }
                \App\Model\Image::create([
                    'object_id' => $items->id,
                    'object_key' => 3,
                    'path' => $this->base_path.$image_name
                ]);
            }
        }
        Session::flash('message', 'You have successfully updated property');
        return Redirect::to('property');
    }

    public function update_vehicle(Request $request, $id)
    {
        if(!Auth::user()->can('edit-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'project' => 'required',
            'project_zone' => 'required',
            'property_type' => 'required',
            'property_name' => 'required',
            // 'property_no' => 'required|unique:items,property_no,'.$id
            'property_no' => 'required'
        ],[],[
            'property_no' => 'Property Number',
            'property_type' => 'Property Type'
        ]);
        $items = Property::findOrFail($id);
        $items->project_id = Input::get('project');
        $items->item_zone = Input::get('project_zone');
        $items->land_id = -1;
        $items->item_type = Input::get('property_type');
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->property_name = Input::get('property_name');
        $items->property_no = Input::get('property_no');
        $items->address_zip_code = Input::get('zip_code');
        $items->bed_rooms = Input::get('bed_room');
        $items->bathrooms = Input::get('bath_room');
        $items->other_room = Input::get('other_room');
        $items->nb_machine = Input::get('nb_machine');
        if($items->status !=2){
        $items->property_price = Input::get('price');
        $items->property_discount_amount = Input::get('discount_amount');
        }
        $items->boundary_north = Input::get('boundary_north');
        $items->boundary_south = Input::get('boundary_south');
        $items->boundary_east = Input::get('boundary_east');
        $items->boundary_west = Input::get('boundary_west');
        $items->product_first = Input::get('product_first');
        $items->product_second = Input::get('product_second');
        $items->product_third = Input::get('product_third');
        $items->product_four = Input::get('product_four');
        $items->product_five = Input::get('product_five');
        $items->village = Input::get('village');
        $items->commune = Input::get('commune');
        $items->district = Input::get('district');
        $items->province = Input::get('province');
        $items->has_elevator = Input::get('has_elevator');
        $items->has_basement = Input::get('has_basement');
        $items->has_swimming_pool = Input::get('has_swimming_pool');
        $items->living_room_surface = Input::get('living_room_surface');
        $items->built_up_surface = Input::get('built_up_surface');
        $items->habitable_surface = Input::get('habitable_surface');
        $items->ground_surface = Input::get('ground_surface');
        $items->land_num = Input::get('land_num');
        $items->width = Input::get('width');
        $items->length = Input::get('length');
        $items->house_number = Input::get('house_number');
        $items->year_of_construction = Input::get('year_of_construction');
        $items->year_of_renovation = Input::get('year_of_renovation');
        $items->floor_number = Input::get('floor_number');
        $items->total_number_of_floors_building = Input::get('total_number_of_floors_building');
        $items->map_data = Input::get('map_data');
        // $items->status = Input::get('status');
        $abouts = Input::get('about');
        $about='';
        foreach($abouts as $key => $value){
            if($key==0){
                $about.=$value;
            }else{
                $about.='&&$,$&&'.$value;
            }
        }
        $items->about = $about;
        $items->save();
        PropertyPriceTransaction::create([
            'project_id' => $items->project_id,
            'zone_id' => $items->item_zone,
            'property_type' => $items->item_type,
            'property_id' => $items->id,
            'amount' => $items->property_price,
            'created_by' => Auth::id()
        ]);
        $images = $request->file('images');
        if(!empty($images)) {
            foreach ($images as $index => $image) {
                $image_name = "property".$items->id."_".date("His").$index.$image->getClientOriginalExtension();
                $image->move(
                    base_path() . '/public/'.$this->base_path, $image_name
                );
                $img = Image::make(base_path() . '/public/'.$this->base_path . $image_name);
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                try{
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                } catch (\Exception $e) {
                    mkdir(base_path() . '/public/'.$this->thumb_path);
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                }
                \App\Model\Image::create([
                    'object_id' => $items->id,
                    'object_key' => 3,
                    'path' => $this->base_path.$image_name
                ]);
            }
        }
        Session::flash('message', 'You have successfully updated vehicle');
        return Redirect::to('vehicle');
    }
    public function update_others(Request $request, $id)
    {
        if(!Auth::user()->can('edit-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'project' => 'required',
            'project_zone' => 'required',
            'property_type' => 'required',
            'property_name' => 'required',
            // 'property_no' => 'required|unique:items,property_no,'.$id
            'property_no' => 'required'
        ],[],[
            'property_no' => 'Property Number',
            'property_type' => 'Property Type'
        ]);
        $items = Property::findOrFail($id);
        $items->project_id = Input::get('project');
        $items->item_zone = Input::get('project_zone');
        $items->land_id = -1;
        $items->item_type = Input::get('property_type');
        $items->address_street = Input::get('address_street');
        $items->address_number = Input::get('address_number');
        $items->property_name = Input::get('property_name');
        $items->property_no = Input::get('property_no');
        $items->address_zip_code = Input::get('zip_code');
        $items->bed_rooms = Input::get('bed_room');
        $items->model = Input::get('model');
        $items->nb_machine = Input::get('nb_machine');
        $items->bathrooms = Input::get('bath_room');
        $items->other_room = Input::get('other_room');
        if($items->status !=2){
        $items->property_price = Input::get('price');
        $items->property_discount_amount = Input::get('discount_amount');
        }
        $items->boundary_north = Input::get('boundary_north');
        $items->boundary_south = Input::get('boundary_south');
        $items->boundary_east = Input::get('boundary_east');
        $items->boundary_west = Input::get('boundary_west');
        $items->product_first = Input::get('product_first');
        $items->product_second = Input::get('product_second');
        $items->product_third = Input::get('product_third');
        $items->product_four = Input::get('product_four');
        $items->product_five = Input::get('product_five');
        $items->village = Input::get('village');
        $items->commune = Input::get('commune');
        $items->district = Input::get('district');
        $items->province = Input::get('province');
        $items->has_elevator = Input::get('has_elevator');
        $items->has_basement = Input::get('has_basement');
        $items->has_swimming_pool = Input::get('has_swimming_pool');
        $items->living_room_surface = Input::get('living_room_surface');
        $items->built_up_surface = Input::get('built_up_surface');
        $items->habitable_surface = Input::get('habitable_surface');
        $items->ground_surface = Input::get('ground_surface');
        $items->land_num = Input::get('land_num');
        $items->width = Input::get('width');
        $items->length = Input::get('length');
        $items->house_number = Input::get('house_number');
        $items->year_of_construction = Input::get('year_of_construction');
        $items->year_of_renovation = Input::get('year_of_renovation');
        $items->floor_number = Input::get('floor_number');
        $items->total_number_of_floors_building = Input::get('total_number_of_floors_building');
        $items->map_data = Input::get('map_data');
        // $items->status = Input::get('status');
        $abouts = Input::get('about');
        $about='';
        foreach($abouts as $key => $value){
            if($key==0){
                $about.=$value;
            }else{
                $about.='&&$,$&&'.$value;
            }
        }
        $items->about = $about;
        $items->save();
        PropertyPriceTransaction::create([
            'project_id' => $items->project_id,
            'zone_id' => $items->item_zone,
            'property_type' => $items->item_type,
            'property_id' => $items->id,
            'amount' => $items->property_price,
            'created_by' => Auth::id()
        ]);
        $images = $request->file('images');
        if(!empty($images)) {
            foreach ($images as $index => $image) {
                $image_name = "property".$items->id."_".date("His").$index.$image->getClientOriginalExtension();
                $image->move(
                    base_path() . '/public/'.$this->base_path, $image_name
                );
                $img = Image::make(base_path() . '/public/'.$this->base_path . $image_name);
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                try{
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                } catch (\Exception $e) {
                    mkdir(base_path() . '/public/'.$this->thumb_path);
                    $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                }
                \App\Model\Image::create([
                    'object_id' => $items->id,
                    'object_key' => 3,
                    'path' => $this->base_path.$image_name
                ]);
            }
        }
        Session::flash('message', 'You have successfully updated others');
        return Redirect::to('others');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('delete-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = Property::find($id);
        if($items->status==1){
            $items->deleted_by = Auth::id();
            $items->save();
            $items->delete();
        }else{
            return redirect()->back()->with('error-message', __('item.error_delete'));
        }
        Session::flash('message', __('item.success_delete'));
        return Redirect::to('property');
    }
    public function deleteImage($id) {
        \App\Model\Image::findOrFail($id)->delete();
    }
    public function getZoneAjax($id)
    {
        $project = Project::find($id);
        if(!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Project not found!'
            ]);
        }
        if(!$project->projectZone) {
            return response()->json([
                'status' => true,
                'message' => 'Project no have zone!',
                'data' => null
            ]);
        }
        $zones = $project->projectZone()->pluck('name', 'id')->toArray();
        return response()->json([
            'status' => true,
            'message' => 'Project no have zone!',
            'data' => ['zones' => $zones]
        ]);
    }
    public function duplicate($id)
    {
        if(!Auth::user()->can('duplicate-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        // $projects = Project::where("item_type", 2)->get();
        $projects = $this->select_one + Project::where("item_type", 2)->pluck('property_name', 'id')->toArray();
        $projectzones = ProjectZone::all();
        $propertytypes = PropertyType::where("id", ">", 2)->get();
        $properties = Property::findOrFail($id);
        $abouts=[];
        if($properties){
            $abouts=explode("&&$,$&&", $properties->about);
        }
        return view('back-end.property.duplicate', [
            'projects' => $projects,
            'propertytypes' => $propertytypes,
            'project_zones' => $this->select_one + $properties->project->projectZone()->pluck('name', 'id')->toArray(),
            'item' => $properties,
            'abouts' => $abouts
        ]);
    }
    public function merge(Request $request){
        if(!Auth::user()->can('merge-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if($request->method()=='GET'){
            $pro = Property::where([
                ['status', '=', 1]
            ])
            ->whereNotNull('project_id')
            ->get();
            $properties[null] =  '-- '.__('item.select').' '.__('item.property').' --';
            foreach ($pro as $key => $value) {
                $properties[$value->id] =  $value->property_no.' | '.$value->property_name;
            }
            $propertytypes=[];
            return view('back-end.property.merge', compact('properties', 'propertytypes'));
        }elseif($request->method()=='POST'){
            $this->validate($request,[
                'project' => 'required',
                'project_zone' => 'required',
                'property_type' => 'required',
                'property_name' => 'required',
                'property_no' => 'required|unique:items,property_no'
            ],[],[
                'property_no' => 'Property Number',
                'property_type' => 'Property Type'
            ]);
            $merge_properties = explode(',', Input::get('merge_properties'));
            if(count($merge_properties)<2){
                return redirect()->back()->with('error-message', 'Can not merge!!!');
            }
            foreach ($merge_properties as $key => $value) {
                $pro = Property::find($value);
                $pro->is_merge =1;
                $pro->save();
            }
            $items = new Property();
            $items->project_id = Input::get('project');
            $items->item_zone = Input::get('project_zone');
            $items->land_id = -1;
            $items->chile_merge = Input::get('merge_properties');
            $items->qty_merge = count($merge_properties);
            $items->item_type = Input::get('property_type');
            $items->address_street = Input::get('address_street');
            $items->address_number = Input::get('address_number');
            $items->property_name = Input::get('property_name');
            $items->property_no = Input::get('property_no');
            $items->address_zip_code = Input::get('zip_code');
            $items->bed_rooms = Input::get('bed_room');
            $items->bathrooms = Input::get('bath_room');
            $items->other_room = Input::get('other_room');
            $items->property_price = Input::get('price');
            $items->property_discount_amount = Input::get('discount_amount');
            $items->boundary_north = Input::get('boundary_north');
            $items->boundary_south = Input::get('boundary_south');
            $items->boundary_east = Input::get('boundary_east');
            $items->boundary_west = Input::get('boundary_west');
            $items->product_first = Input::get('product_first');
            $items->product_second = Input::get('product_second');
            $items->product_third = Input::get('product_third');
            $items->product_four = Input::get('product_four');
            $items->product_five = Input::get('product_five');
            $items->village = Input::get('village');
            $items->commune = Input::get('commune');
            $items->district = Input::get('district');
            $items->province = Input::get('province');
            $items->has_elevator = Input::get('has_elevator');
            $items->has_basement = Input::get('has_basement');
            $items->has_swimming_pool = Input::get('has_swimming_pool');
            $items->living_room_surface = Input::get('living_room_surface');
            $items->built_up_surface = Input::get('built_up_surface');
            $items->habitable_surface = Input::get('habitable_surface');
            $items->ground_surface = Input::get('ground_surface');
            $items->land_num = Input::get('land_num');
            $items->width = Input::get('width');
            $items->length = Input::get('length');
            $items->house_number = Input::get('house_number');
            $items->year_of_construction = Input::get('year_of_construction');
            $items->year_of_renovation = Input::get('year_of_renovation');
            $items->floor_number = Input::get('floor_number');
            $items->total_number_of_floors_building = Input::get('total_number_of_floors_building');
            $items->map_data = Input::get('map_data');
            $items->status = 1;
            $abouts = Input::get('about');
            $about='';
            foreach($abouts as $key => $value){
                if($key==0){
                    $about.=$value;
                }else{
                    $about.='&&$,$&&'.$value;
                }
            }
            $items->about = $about;
            $items->save();
            PropertyPriceTransaction::create([
                'project_id' => $items->project_id,
                'zone_id' => $items->item_zone,
                'property_type' => $items->item_type,
                'property_id' => $items->id,
                'amount' => $items->property_price,
                'created_by' => Auth::id()
            ]);
            $images = $request->file('images');
            if(!empty($images)) {
                foreach ($images as $index => $image) {
                    $image_name = "property".$items->id."_".date("His").$index.$image->getClientOriginalExtension();
                    $image->move(
                        base_path() . '/public/'.$this->base_path, $image_name
                    );
                    $img = Image::make(base_path() . '/public/'.$this->base_path . $image_name);
                    $img->resize(100, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    try{
                        $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                    } catch (\Exception $e) {
                        mkdir(base_path() . '/public/'.$this->thumb_path);
                        $img->save(base_path() . '/public/'.$this->thumb_path . $image_name);
                    }
                    \App\Model\Image::create([
                        'object_id' => $items->id,
                        'object_key' => 3,
                        'path' => $this->base_path.$image_name
                    ]);
                }
            }
            Session::flash('message', 'You have successfully merged property');
            return Redirect::to('property');
        }
    }
    public function merge_get_property(Request $request){
        $data =[];
        $property = Property::find($request->property);
        if(!empty($property)){
            $properties =[];
            if($request->merge_properties){
                $properties = explode(',',$request->merge_properties);
            }
            if(count($properties)>0){
                $first_property = Property::find($properties[0]);
                if($first_property->project_id==$property->project_id){
                    $data['merge_properties'] = $request->merge_properties.','.$property->id;
                    $data['merge_text'] = $request->merge_text.',  '.$property->property_no.' | '.$property->property_name;
                    $data['property_no'] = $request->property_no.','.$property->property_no;
                }
            }else{
                $data['merge_properties'] = $property->id;
                $data['merge_text'] = $property->property_no.' | '.$property->property_name;
                $data['property_no'] = $property->property_no;
            }
            $property_items =  explode(',', $data['merge_properties']);
            $property_price = 0;
            $property_discount =0;
            foreach ($property_items as $value) {
                $item = Property::find($value);
                if(!empty($item)){
                    $property_price += $item->property_price*1;
                    $property_discount += $item->property_discount_amount*1;
                }
            }
            $pro = Property::where([
                ['status', '=', 1],
                ['item_type', '=', $property->item_type],
                ['project_id', '=', $property->project_id],
                ['item_zone', '=', $property->item_zone]
            ])
            ->whereNotNull('project_id')
            ->whereNotIn('id', $properties)
            ->whereNotIn('id', [$property->id])
            ->get();
            $data['html_property'] =  '<option >-- '.__('item.select').' '.__('item.property').' --</option>';
            foreach ($pro as $key => $value) {
                $data['html_property'] .= '<option value="'.$value->id.'">'.$value->property_no.' | '.$value->property_name.'</option>';
            }
            $project = Project::find($property->project_id);
            $data['html_project'] = '<option value="'.$project->id.'">'.$project->property_name.'</option>';
            $zone = ProjectZone::find($property->item_zone);
            $data['html_zone'] = '<option value="'.$zone->id.'">'.$zone->name.'</option>';
            $property_type = PropertyType::find($property->item_type);
            $data['html_property_type'] = '<option value="'.$property_type->id.'">'.$property_type->name.'</option>';
            $data['price'] = $property_price*1; 
            $data['discount_amount'] = $property_discount*1;
            $data['boundary_east'] = $property->boundary_east;
            $data['boundary_north'] = $property->boundary_north;
            $data['boundary_south'] = $property->boundary_south;
            $data['boundary_west'] = $property->boundary_west;
            $data['product_first']  = $property->product_first;
            $data['product_second']  = $property->product_second;
            $data['product_third']  = $property->product_third;
            $data['product_four']  = $property->product_four;
            $data['product_five']  = $property->product_five;
            $data['village'] = $property->village;
            $data['commune'] = $property->commune;
            $data['district'] = $property->district;
            $data['province'] = $property->province;
            $abouts = explode('&&$,$&&', $property->about);
            $data['content_about'] ='';
            foreach ($abouts as $key => $value) {
                $data['content_about'] .= Form::label('about[]', trans('item.about')).'<span class="btn btn-sm btn-outline-danger btn-remove-about"><i class="fa fa-close"></i></span>';
                $data['content_about'] .= Form::text('about[]', $value, array('class' => 'form-control'));
            }
        }
        return $data;
    }
    public function cancel_merge($id){
        if(!Auth::user()->can('cancel-merge-property') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $property = Property::find($id);
        if(!empty($property)){
            if(!empty($property->chile_merge) && $property->status==1){
                $chiles = explode(',', $property->chile_merge);
                foreach ($chiles as $key => $value) {
                    $pro = Property::find($value);
                    $pro->is_merge = NULL;
                    $pro->save();
                }
                $property->chile_merge='';
                $property->qty_merge=NULL;
                $property->deleted_by = Auth::id();
                $property->save();
                $property->delete();
                return redirect()->back()->with('message', 'Success Cancel Merge');
            }
        }
        return redirect()->back()->with('error-message', 'Fail Cancel Merge');
    }
}