<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\Product;
use App\Model\Inventory;
use App\Http\Requests\ProductRequest;
use Auth, \Redirect, \Input, \Session;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AppHelper;
use App\Model\Unit;
use App\Model\Category;
use DB;
class ProductController extends Controller {
    protected  $base_path;
	public function __construct()
	{
		$this->middleware('auth');
		$this->base_path = "/images/products/";
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request,Product $product)
	{
        if(!Auth::user()->can('list-product') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = $product->select(DB::raw('
            materials.id as id,
            materials.name as name,
            materials.size as size,
            materials.description as description,
            materials.avatar as avatar,
            materials.qty as qty,
            categories.name as category_name,
            units.name as unit_name
        '));
        $items = $items->join('categories', 'categories.id', 'materials.category');
        $items = $items->join('units', 'units.id', 'materials.unit');
        if($request->search && !empty($request->search)){
            $search = $request->search;
            $items = $items->where(function ($query) use($search) {
                $query->where('id',      'like',     '%'.$search.'%');
                $query->orWhere('name',      'like',     '%'.$search.'%');
                $query->orWhere('size',      'like',     '%'.$search.'%');
                $query->orWhere('description',      'like',     '%'.$search.'%');
                $query->orWhere('cost_price',      'like',     '%'.$search.'%');
                $query->orWhere('qty',      'like',     '%'.$search.'%');
            });
        }
        $items = $items->where('is_active', '<>', 0);
        $items =$items->sortable()->paginate(20);
        return view('back-end.item.index')->with('item', $items);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(!Auth::user()->can('create-product') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $unit_item = Unit::all();
        $category_item = Category::all();
        $units = [];
        $categories = [];
        foreach ($unit_item as $value) {
            $units[$value->id] = ucfirst($value->name);
        }
        foreach ($category_item as $value) {
            $categories[$value->id] = ucfirst($value->name);
        }
		return view('back-end.item.create', compact('units', 'categories'));
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        if(!Auth::user()->can('create-product') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'item_name' => 'required|string|max:100',
            'description' => 'nullable|string:|max:255',
            'unit' => 'required|numeric',
            'category' => 'required|numeric'
        ]);
        $items = Product::create([
            'name' => $request->item_name,
            'unit' => $request->unit,
            'category' => $request->category,
            'size' => $request->size,
            'description' => $request->description,
            'qty' => 0,
            'is_active' => 1,
            'created_by' => Auth::id()
        ]);
        // process avatar
        $image = $request->file('avatar');
        if(!empty($image))
        {
            $avatarName = 'product' . $items->id.""  
            .$request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(
                base_path() . '/public/'.$this->base_path, $avatarName
            );
            $img = Image::make(base_path() . '/public/'.$this->base_path . $avatarName);
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
            $itemAvatar = Product::find($items->id);
            $itemAvatar->avatar = '/'.$this->base_path .$avatarName;
            $itemAvatar->save();
        }
        Session::flash('message', 'You have successfully added item');
        return Redirect::to('product');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!Auth::user()->can('edit-product') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $unit_item = Unit::all();
        $category_item = Category::all();
        $units = [];
        $categories = [];
        foreach ($unit_item as $value) {
            $units[$value->id] = ucfirst($value->name);
        }
        foreach ($category_item as $value) {
            $categories[$value->id] = ucfirst($value->name);
        }
		$items = Product::find($id);
	        return view('back-end/item/edit', compact('units', 'categories'))
	            ->with('item', $items);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        if(!Auth::user()->can('edit-product') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $this->validate($request,[
            'item_name' => 'required|string|max:100',
            'description' => 'nullable|string:|max:255',
            'unit' => 'required|numeric',
            'category' => 'required|numeric'
        ]);
        $data =[
            'name' => $request->item_name,
            'unit' => $request->unit,
            'category' => $request->category,
            'size' => $request->size,
            'description' => $request->description,
            'updated_by' => Auth::id()
        ];
        $items = Product::findOrFail($id);
        $items = $items->update($data);
        // process avatar
        $image = $request->file('avatar');
        if(!empty($image)) {
            $avatarName = 'product' . $id . "" .
            $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(
            base_path() . '/public/'.$this->base_path, $avatarName
            );
            $img = Image::make(base_path() . '/public/'.$this->base_path . $avatarName);
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();
            $itemAvatar = Product::find($id);
            $itemAvatar->avatar = $this->base_path.$avatarName;
            $itemAvatar->save();
        }
        Session::flash('message', 'You have successfully updated item');
        return Redirect::to('product');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!Auth::user()->can('delete-product') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
			$items = Product::find($id);
	        $items->update(['is_active' => 0]);
	        Session::flash('message', 'You have successfully deleted item');
	        return Redirect::to('product');
	}
    public function unit_list(Request $request){
        if(!Auth::user()->can('list-product-unit') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = new Unit;
        if($request->search){
            $search = $request->search;
            $items = $items->where(function ($query) use($search) {
                $query->orWhere('name',      'like',     '%'.$search.'%');
                $query->orWhere('description',      'like',     '%'.$search.'%');
            });
        }
        $items =  $items->sortable()->paginate(20);
        return view('back-end/item/unit/index')->with('item', $items);
    }
    public function unit_create(Request $request){
        if(!Auth::user()->can('create-product-unit') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(!$request->all())
            return view('back-end/item/unit/create');
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'description' => 'nullable|string:|max:255'
        ]);
        $unit =[
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id()
        ];
        Unit::create($unit);
        return redirect()->route('product.unit.create')->with('message', 'Successfully create Product Unit.');
    }
    public function unit_edit(Request $request, $id){
        if(!Auth::user()->can('edit-product-unit') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $unit = Unit::find($id);
        if(!$unit)
            return redirect()->back()->with('error', 'Not Fount');
        if(!$request->all())
            return view('back-end/item/unit/edit', compact('unit'));
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'description' => 'nullable|string:|max:255'
        ]);
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->updated_by = Auth::id();
        $unit->save();
        if($unit)
            return redirect()->route('product.units')->with('success', 'Successfully updated  Product Unit');
        return redirect()->back()->with('error', 'Failed Update Product Unit');
    }
    public function category_list(Request $request){
        if(!Auth::user()->can('list-product-category') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = new Category;
        if($request->search){
            $search = $request->search;
            $items = $items->where(function ($query) use($search) {
                $query->orWhere('name',      'like',     '%'.$search.'%');
                $query->orWhere('description',      'like',     '%'.$search.'%');
            });
        }
        $items =  $items->sortable()->paginate(20);
        return view('back-end/item/category/index')->with('item', $items);
    }
    public function category_create(Request $request){
        if(!Auth::user()->can('create-product-unit') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(!$request->all())
            return view('back-end/item/category/create');
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'description' => 'nullable|string:|max:255'
        ]);
        $category =[
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id()
        ];
        Category::create($category);
        return redirect()->route('product.category.create')->with('message', 'Successfully create Product Category.');
    }
    public function category_edit(Request $request, $id){
        if(!Auth::user()->can('edit-product-category') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $category = Category::find($id);
        if(!$category)
            return redirect()->back()->with('error', 'Not Fount');
        if(!$request->all())
            return view('back-end/item/category/edit', compact('category'));
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'description' => 'nullable|string:|max:255'
        ]);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->updated_by = Auth::id();
        $category->save();
        if($category)
            return redirect()->route('product.categories')->with('success', 'Successfully updated  Product Category');
        return redirect()->back()->with('error', 'Failed Update Product Category');
    }
}