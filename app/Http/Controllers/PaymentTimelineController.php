<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\PaymentTimeline;
use App\Model\PaymentTimelineDetail;
use Session, Auth;
use App\Helpers\AppHelper;
class PaymentTimelineController extends Controller
{
    function __construct(PaymentTimelineDetail $paymentTimelineDetail, PaymentTimeline $paymentTimeline) {
        $this->middleware('auth');
        $this->paymentTimelineDetail = $paymentTimelineDetail;
        $this->paymentTimeline = $paymentTimeline;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('list-timeline') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
            
        $limited = $request->get('limited', 10);
        $items = $this->paymentTimeline->orderby('title', 'asc')->paginate($limited)->appends(['limited' => $limited]);
        return view('back-end.payment.index', compact('items'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('create-timeline') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $duration_type = [
            '1' => 'Days',
            '2' => 'Week',
            '3' => 'Month'
        ];
        return view('back-end.payment.form', compact('duration_type'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('create-timeline') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $payment_saved = $this->paymentTimeline->create($request->all());
        if($payment_saved) {
            $payment_details = $request->get('duration_', []);
            $data = [];
            foreach ($payment_details as $key => $value) {
                $data = [
                    'duration_type' => $request->duration_type_[$key],
                    'duration' => $request->duration_[$key],
                    'amount_to_pay_percentage' => $request->amount_to_pay_percentage_[$key],
                    'payment_timeline_id' => $payment_saved->id
                ];
                $this->paymentTimelineDetail->create($data);
            }
            Session::flash('message', 'You have successfully added item');
            return redirect(route('payment-timeline.index'));
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->can('view-timeline') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $item = $this->paymentTimeline->find($id);
        if(!$item) {
            Session::flash('message', 'Item not found!');
            return redirect(route('payment-timeline.index'));
        }
        $duration_type = [
            '1' => 'Days',
            '2' => 'Week',
            '3' => 'Month'
        ];
        return view('back-end.payment.show', compact('item', 'duration_type'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('edit-timeline') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $duration_type = [
            '1' => 'Days',
            '2' => 'Week',
            '3' => 'Month'
        ];
        $item = $this->paymentTimeline->find($id);
        if(!$item) {
            Session::flash('message', 'Item not found!');
            return redirect(route('payment-timeline.index'));
        }
        return view('back-end.payment.form', compact('item', 'duration_type'));
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
        if(!Auth::user()->can('edit-timeline') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $item = $this->paymentTimeline->find($id);
        if(!$item) {
            Session::flash('message', 'Item not found!');
            return redirect(route('payment-timeline.index'));
        }
        $update_item = $item->update($request->all());
        if($update_item) {
            $item->paymentTimelineDetails()->delete();
            $payment_details = $request->get('duration_', []);
            $data = [];
            foreach ($payment_details as $key => $value) {
                $data = [
                    'duration_type' => $request->duration_type_[$key],
                    'duration' => $request->duration_[$key],
                    'amount_to_pay_percentage' => $request->amount_to_pay_percentage_[$key],
                    'payment_timeline_id' => $id
                ];
                $this->paymentTimelineDetail->create($data);
            }
            Session::flash('message', 'You have successfully update item');
            return redirect(route('payment-timeline.index'));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('delete-timeline') && !AppHelper::checkAdministrator())
            return view('back-end.common.no-permission');
        $item = $this->paymentTimeline->find($id);
        if(!$item) {
            Session::flash('message', 'Delete fails!');
            return redirect(route('payment-timeline.index'));
        }
        $item->paymentTimelineDetails()->delete();
        if($item->delete()) {
            Session::flash('message', 'You have successfully delete item');
            return redirect(route('payment-timeline.index'));
        }
    }
}