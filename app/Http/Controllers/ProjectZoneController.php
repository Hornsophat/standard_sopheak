<?php
namespace App\Http\Controllers;
use App\Model\Land;
use App\Model\Project;
use App\Model\ProjectZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Helpers\AppHelper;
class ProjectZoneController extends Controller
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
    public function index(Request $request, ProjectZone $projectZone, $project_id = null)
    {
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
        $items = $items->sortable()->paginate(20);
        return view('back-end.projectZone.index')->with('item', $items);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('create-property-zone') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $projects = Project::whereNull("project_id")->get();
        return view('back-end.projectZone.create')->with('projects', $projects);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('create-property-zone') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = new ProjectZone();
        $items->name = Input::get('zone_name');
        $items->code = Input::get('zone_code');
        $items->project_id = Input::get('project');
        $items->map_data = Input::get('map_data');
        $items->save();
        Session::flash('message', 'You have successfully added zone');
        return Redirect::to('projectzone/index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('edit-property-zone') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = ProjectZone::findOrFail($id);
        $projects = Project::whereNull("project_id")->get();
        return view('back-end.projectZone.edit', ['item' => $items, 'projects' => $projects]);
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
        if(!Auth::user()->can('edit-property-zone') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = ProjectZone::findOrFail($id);
        $items->project_id = Input::get('project');
        $items->name = Input::get('zone_name');
        $items->code = Input::get('zone_code');
        $items->map_data = Input::get('map_data');
        $items->save();
        Session::flash('message', 'You have successfully updated project zone.');
        return Redirect::to('projectzone/index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('delete-property-zone') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $items = ProjectZone::find($id);
        $items->delete();
        Session::flash('message', 'You have successfully deleted land');
        return Redirect::to('projectzone/index');

    
    }
}
?>