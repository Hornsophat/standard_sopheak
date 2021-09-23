<table border="1" cellpadding="5" cellspacing="0">
    <thead>
      	<tr>
            <th width="20">No</th>
			<th>Sale Date</th>
            <th>Customer</th>
            <th>Employee</th>
            <th>Discount</th>
            <th>Commission</th>
            <th>Grand Total</th>
            <th>Payment</th>
      	</tr>
    </thead>
	<tbody>

		@foreach ($items as $item)
			@php
				$percentage = 0;
				$x = $item->payment()->where("status", 2)->sum("amount_to_spend");
				if($x) {
					$_total = $item->payment()->sum("amount_to_spend");
					$percentage = ($x*100)/$_total;
				}
			@endphp

        	<tr>
                <td>{{ $loop->iteration }}</td>
				<td>{{Date("d-M-Y h:i:s A", strtotime($item->sale_date))  }}</td>
				<td>{{ $item->soleToCustomer->first_name .' '. $item->soleToCustomer->last_name }}</td>
                <td>{{ $item->soldByEmployee->first_name .' '. $item->soldByEmployee->last_name }}</td>
				<td>{{ "$ ". ($item->total_discount !=null?$item->total_discount:"0.00") }}</td>
				<td>{{ "$ ". $item->total_sale_commission }}</td>
				<td>{{ "$ ". $item->grand_total }}</td>
				<td>
					{{ $percentage ."%" }}
				</td>
            </tr>
            <tr>
            	<td colspan="8" align="right">
            		<table border="1" cellpadding="5" cellspacing="0" width="100%">
				        <tr>
				        	<td>No</td>
							<td><strong>Property Name</strong></td>
							<td><strong>Quantity</strong></td>
							<td><strong>Price</strong></td>
							<td><strong>Commission</strong></td>
							<td><strong>Discount</strong></td>
							<td><strong>Amount</strong></td>
				        </tr>

				        @foreach($item->salesDetail as $key => $sale_item)
					        <tr>
					        	<td>{{$key + 1}}</td>
								<td>{{App\Model\Property::find($sale_item->item_id)->property_name ?? 'N/A'}}</td>
								<td>{{$sale_item->qty}}</td>
								<td>{{"$ ". $sale_item->price}}</td>
								<td>{{"$ ". $sale_item->sale_commission}}</td>
								<td>{{"$ ". $sale_item->dicount}}</td>
								<td>{{"$ ". $sale_item->qty * $sale_item->price}}</td>
							</tr>
				        @endforeach
						@php
							$colspan = 7;
						@endphp
					</table>	
            	</td>
            </tr>
        @endforeach
        <tr>
			<td colspan="{{$colspan}}" align="right" style="border-left: 0px solid #fff;border-bottom: 3px solid #fff;"><strong>Total</strong></td>
			<td >{{ "$ ".$total_price }}</td>
		</tr>
		<tr>
			<td colspan="{{$colspan}}" align="right" style="border-left: 0px solid #fff;border-bottom: 3px solid #fff;"><strong>Total Commission</strong></td>
			<td >{{ "$ ".$total_sale_commission }}</td>
		</tr>
		<tr>
			<td colspan="{{$colspan}}" align="right" style="border-left: 0px solid #fff;border-bottom: 3px solid #fff;"><strong>Total Discount</strong></td>
			<td >{{ "$ ".$total_discount }}</td>
		</tr>
		<tr>
			<td colspan="{{$colspan}}" align="right" style="border-left: 0px solid #fff;border-bottom: 3px solid #fff;"><strong>Grand Total</strong></td>
			<td >{{ "$ ".$total }}</td>
		</tr>
    </tbody>
	</table>