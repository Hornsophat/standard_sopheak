<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth, Validator, View;
use App\Helpers\AppHelper;
use App\Model\PenaltyGroup;
use App\Model\Penalty;
class PenaltyController extends Controller
{
    public function index(Request $request){
        if(!Auth::user()->can('list-penalty') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        
        $items = new PenaltyGroup();
        if($request->search){
            $items->where('title', 'LIKE', '%'.$request->search.'%');
        }
        $items = $items->get();
        return view('back-end.penalties.index', compact('items', 'request'));
    }
    public function create(Request $request){
        if(!Auth::user()->can('create-penalty') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if($request->method()=='GET'){
            return view('back-end.penalties.create');
        }elseif($request->method()=='POST'){
            $this->validate($request,[
                'title' => 'required|string|max:100',
                'description' => 'nullable|string|max:255',
                'percent.*' => 'required|numeric|min:0|max:100',
                'min_day.*' => 'required|numeric|min:1',
                'max_day.*' => 'nullable|numeric|min:1',
                'item_description.*' => 'nullable|string|max:255'
            ]);
            $user_id = Auth::id();
            if(is_null($request->percent)){
                return redirect()->back();
            }
            $penalty_group = PenaltyGroup::create([
                'title' => $request->title,
                'description' => $request->description,
                'created_by' => $user_id
            ]);
            $percents = $request->percent;
            $min_days = $request->min_day;
            $max_days = $request->max_day;
            $item_descriptions = $request->item_description;
            foreach($percents as $key => $percent){
                Penalty::create([
                    'penalty_group_id' => $penalty_group->id,
                    'percent' => $percent,
                    'min_day' => $min_days[$key],
                    'max_day' => $max_days[$key],
                    'description' => $item_descriptions[$key],
                    'created_by' => $user_id
                ]);
            }
            return redirect()->route('penalties')->with('message', 'Successfully created penalty');
        }
    }
    public function edit(Request $request, PenaltyGroup $penalty){
        if(!Auth::user()->can('edit-penalty') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(empty($penalty)){
            return redirect()->back()->with('message', 'Not Found!');
        }else{
            $penalty_group = $penalty;
            if($request->method()=='GET'){
                $penalties = Penalty::where('penalty_group_id', '=', $penalty_group->id)
                ->orderBy('min_day', 'ASC')->get();
                return view('back-end.penalties.edit');
            }elseif($request->method()=='POST'){
                $this->validate($request,[
                    'title' => 'required|string|max:100',
                    'description' => 'nullable|string|max:255',
                    'percent.*' => 'required|numeric|min:0|max:100',
                    'min_day.*' => 'required|numeric|min:1',
                    'max_day.*' => 'nullable|numeric|min:1',
                    'item_description.*' => 'nullable|string|max:255'
                ]);
                $user_id = Auth::id();
                if(is_null($request->percent)){
                    return redirect()->back();
                }
                $penalty_group = $penalty_group->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'updated_by' => $user_id
                ]);
    
                $percents = $request->percent;
                $min_days = $request->min_day;
                $max_days = $request->max_day;
                $item_descriptions = $request->item_description;
                Penalty::where('penalty_group_id', '=', $penalty_group->id)
                ->delete();
    
                foreach($percents as $key => $percent){
                    Penalty::create([
                        'penalty_group_id' => $penalty_group->id,
                        'percent' => $percent,
                        'min_day' => $min_days[$key],
                        'max_day' => $max_days[$key],
                        'description' => $item_descriptions[$key],
                        'created_by' => $user_id
                    ]);
                }
                return redirect()->route('penalties')->with('message', 'Successfully updated penalty');
            }
        }
    }
    public function show(PenaltyGroup $penalty){
        if(!Auth::user()->can('list-penalty') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        if(empty($penalty)){
            return redirect()->back()->with('message', 'Not Found!');
        }else{
            $penalty_group =$penalty;
            $penalties = Penalty::where('penalty_group_id', '=', $penalty_group->id)->get();
            return view('back-end.penalties.view', compact('penalty_group', 'penalties'));
        }
    }
}