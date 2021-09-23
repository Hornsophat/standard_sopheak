<?php
namespace App\Http\Controllers;
use App\Model\CustomerVisit;
use App\Model\Country;
use App\Http\Requests\CustomerRequest;
use App\Model\Employee;
use File;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;
use App\Model\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\AppHelper;
use DB;
use App\Model\Province;
use App\Model\District;
use App\Model\Commune;
use App\Model\Village;
class CustomerController extends Controller
{
    protected $profile_path;
    public  function __construct()
    {
        $this->profile_path = "/images/customer/";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Customer $customer)
    {
        if(!Auth::user()->can('list-customer') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $customers = $customer->select(DB::raw('customers.*,CONCAT(customers.village,", ",customers.commune,", ",customers.district,", ",customers.province) as addr'))->orderBy('last_name', 'ASC');
        if($request->search && !empty($request->search)){
            $search = $request->search;
            $customers = $customers
                ->where(function ($query) use($search) {    
                $query->where('id',      'like',     '%'.$search.'%');
                $query->orWhere(DB::raw('CONCAT(last_name," ",first_name)'), 'LIKE', '%' . $search . '%');
                $query->orWhere('customer_no',      'like',     '%'.$search.'%');
                $query->orWhere('first_name',      'like',     '%'.$search.'%');
                $query->orWhere('last_name',      'like',     '%'.$search.'%');
                $query->orWhere('age',      'like',     '%'.$search.'%');
                $query->orWhere('phone1',      'like',     '%'.$search.'%');
                $query->orWhere('phone2',      'like',     '%'.$search.'%');
                $query->orWhere('email',      'like',     '%'.$search.'%');
                $query->orWhere('fax',      'like',     '%'.$search.'%');
                $query->orWhere('address',      'like',     '%'.$search.'%');
                $query->orWhere('pob',      'like',     '%'.$search.'%');
            })
            ->where("deleted", 0);
        }else{
            $customers = $customers->where("deleted", 0);
        }
        $customers = $customers->sortable()->paginate(20);
        return view('back-end/customer/index' , compact('customers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('create-customer') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $last_customer= Customer::latest()->first();
        $last_id = isset($last_customer->id)?$last_customer->id:0;
        $last_id = $last_id+1;
        $customer_no = 'CID-'.str_pad($last_id, 6, '0', STR_PAD_LEFT);
        $countries = Country::all();
        $provinces = Province::get();
        return view('back-end/customer/create', compact("countries", "provinces", "customer_no"));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        if(!Auth::user()->can('create-customer') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $path = $this->_uploadProfile($request->file('profile'), -1);
        if($request->cameraImage){
            $path = $this->_uploadCameraImage($request->cameraImage);
        }
        $last_customer= Customer::latest()->first();
        $last_id = isset($last_customer->id)?$last_customer->id:0;
        $last_id = $last_id+1;
        // $last_id = 50+1;
        $customer_no = 'CID-'.str_pad($last_id, 6, '0', STR_PAD_LEFT);
        $customer = Customer::create([
            'customer_no' => $customer_no,
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'first_name_en' => $request->first_name_en,
           'last_name_en' => $request->last_name_en,
           'age' => $request->age,
           'sex' => $request->sex,
           'country' => $request->country,
           'nationality' => $request->nationality,
           'identity' => $request->identity,
           'phone1' => $request->phone1,
           'phone2' => $request->phone2,
           'email' => $request->email,
           'fax' => $request->fax,
           'profile' => $path,
           'dob' => date('Y-m-d', strtotime($request->dob)),
           'identity_set_date' => date('Y-m-d', strtotime($request->identity_set_date)),
           'address' => $request->address,
           'village'   => $request->village,
           'commune'   => $request->commune,
           'district'  => $request->district,
           'province'  => $request->province,
           'pob_village'   => $request->pob_village,
           'pob_commune'   => $request->pob_commune,
           'pob_district'  => $request->pob_district,
           'pob_province'  => $request->pob_province,
           'house_number'  => $request->house_number,
           'street_number'  => $request->street_number,
        ]);
        if($customer){
            return redirect("customer")->with('success', 'Successfully create customer.');
        }
        return redirect()->back()->with('error', 'Unable create customer.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->can('view-customer') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $customer = Customer::find($id);
        return view("back-end.customer.view", compact("customer"));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('edit-customer') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $customer = Customer::find($id);
        $countries  = Country::all();
        $provinces = Province::get();
        $districts=[];
        if($customer->province){
            $districts = District::where('pro_id', '=', $customer->province)->get();
        }
        $communes =[];
        if($customer->district){
            $communes = Commune::where('district_id', '=', $customer->district)->get();
        }
        $villages =[];
        if($customer->commune){
            $villages = Village::where('commune_id', '=', $customer->commune)->get();
        }
        $pob_districts=[];
        if($customer->pob_province){
            $pob_districts = District::where('pro_id', '=', $customer->pob_province)->get();
        }
        $pob_communes =[];
        if($customer->pob_district){
            $pob_communes = Commune::where('district_id', '=', $customer->pob_district)->get();
        }
        $pob_villages =[];
        if($customer->pob_commune){
            $pob_villages = Village::where('commune_id', '=', $customer->pob_commune)->get();
        }
        return view("back-end/customer/edit", compact("customer", "countries", "provinces", "districts", "communes", "villages",  "pob_districts", "pob_communes", "pob_villages"));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        if(!Auth::user()->can('edit-customer') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $path = $this->_uploadProfile($request->file('profile'), $id);
        if($request->cameraImage){
            $path = $this->_uploadCameraImage($request->cameraImage);
        }
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
           'first_name_en' => $request->first_name_en,
           'last_name_en' => $request->last_name_en,
            'age' => $request->age,
            'sex' => $request->sex,
            'country' => $request->country,
            'nationality' => $request->nationality,
            'identity' => $request->identity,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'email' => $request->email,
            'fax' => $request->fax,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'identity_set_date' => date('Y-m-d', strtotime($request->identity_set_date)),
            'address' => $request->address,
            'village'   => $request->village,
            'commune'   => $request->commune,
            'district'  => $request->district,
            'province'  => $request->province,
           'pob_village'   => $request->pob_village,
           'pob_commune'   => $request->pob_commune,
           'pob_district'  => $request->pob_district,
           'pob_province'  => $request->pob_province,
           'house_number'  => $request->house_number,
           'street_number'  => $request->street_number,
        ];
        if(!empty($path)){
            $data['profile'] = $path;
        }
        $customer = Customer::where('id', $id)->update($data);
        if($customer){
            return redirect("customer")->with('success', 'Successfully edit customer.');
        }
        return redirect()->back()->with('error', 'Unable edit customer.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('delete-customer') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $customer = Customer::where("id", $id)->update(['deleted'=> 1, "deleted_by" => Auth::user()->id]);
        if($customer){
            return redirect("customer")->with('success', 'Successfully deleted customer.');
        }
        return redirect()->back()->with('error', 'Unable deleted customer.');
    }
    private function _uploadProfile($image, $id)
    {
        $imageName = "";
        if($image !=null)
        {
            $this->_removeProfile($id);
            $imageName = GUID() . " " .
                $image->getClientOriginalExtension();
            $image->move(
                base_path() . '/public/'.$this->profile_path, $imageName
            );
            $img = Image::make(base_path() . '/public/'.$this->profile_path . $imageName);
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
        }
        if(empty($imageName)){
            return $imageName;
        }
        return $this->profile_path. $imageName;
    }
    private function _uploadCameraImage($encoded_data){
        // $encoded_data = $_POST['cameraImage'];
        $binary_data = base64_decode($encoded_data);
        $fileName = 'webcam-'.time().'.jpg';
        $result = file_put_contents(base_path() . '/public/'.$this->profile_path .$fileName, $binary_data );
        return $this->profile_path .$fileName;
    }
    private function _removeProfile($id)
    {
        $customer = Customer::find($id);
        if(is_null($customer)){
            $customer = new Customer();
        }
        $file_path = public_path()."/". $customer->profile;
        File::delete($file_path);
    }
    public function visit($customer_id)
    {
        $customer = Customer::find($customer_id);
        $customer_visit = CustomerVisit::where(['customer_id' => $customer_id])->orderBy('id', 'desc')->get();
        $sale = Employee::where("sale_type","!=","")->get();
        return view("back-end.customer.visit", compact("customer_visit", "sale", "customer"));
    }
    public function customerVisit(Request $request, $customer_id)
    {
        $request->validate([
            'sale' => 'required',
            'remark' => 'required',
        ]);
        // check last visit
        $customer_visit = CustomerVisit::where(['customer_id' => $customer_id])->orderBy('id', 'desc')->first();
        //dd($customer_visit);
        if($customer_visit !=null){
            if($customer_visit->sale_id <> $request->sale){
                return redirect()->back()->withInput(Input::all())
                    ->with('error', "Unable to create visit because you ever visit with another sale. Do you want to change sale <a href='/customer/$customer_id/$request->sale/$request->remark/change-sale'>Click Here</a>?");
            }
        }
        CustomerVisit::where(['customer_id' => $customer_id])->update(['status' => 2]);
        $customer_visit_store = CustomerVisit::create([
            'customer_id' => $customer_id,
            'sale_id' => $request->sale,
            'remark' => $request->remark,
            'status' => 1
        ]);
        if($customer_visit_store){
            return redirect()->back()->with('success', 'Successfully to create customer visit.');
        }
        return redirect()->back()->with('error', 'Unable create customer visit.');
    }
    public function changeSale($customer_id, $sale_id, $remark)
    {
        CustomerVisit::where(['customer_id' => $customer_id])->update(['status' => 2]);
        $customer_visit_store = CustomerVisit::create([
            'customer_id' => $customer_id,
            'sale_id' => $sale_id,
            'remark' => $remark,
            'status' => 1
        ]);
        if($customer_visit_store){
            return redirect()->back()->with('success', 'Successfully to create customer visit.');
        }
        return redirect()->back()->with('error', 'Unable create customer visit.');
    }
}