<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Model\Sale;

class InvoicesExport implements FromView
{
	use Exportable;

    protected $start_date, $end_date, $status;

	public function __construct($start_date, $end_date, $status)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
    }

	
    public function view(): View
    {
    	$sales = Sale::where(function ($query) {

    		if($this->status != '') {
        		$query->where('status', '=', $this->status);
        	}
        	
        	if($this->start_date != '' && $this->end_date != '') {
        		$start_date = Date('Y-m-d H:i:s', strtotime($this->start_date));
        		$end_date = Date('Y-m-d H:i:s', strtotime($this->end_date));
        		$query->whereBetween('created_at', [$start_date, $end_date]);
        	}

        });
        $items = $sales->get();
        $total_price = $sales->sum('total_price');
        $total_sale_commission = $sales->sum('total_sale_commission');
        $total_discount = $sales->sum('total_discount');
        $total = $sales->sum('grand_total');
        return view('back-end.report.excel', [
            'items' => $items,
            'total' => $total,
            'total_sale_commission' => $total_sale_commission,
            'total_discount' => $total_discount,
            'total_price' => $total_price
        ]);
    }
}