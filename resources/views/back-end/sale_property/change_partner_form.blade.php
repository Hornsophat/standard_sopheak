
<form action="{{ route('sale_item.change_partner') }}" method="POST" id="frmChangePartner" enctype="multipart/form-data" accept-charset="UTF-8">
    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    <input type="hidden" name="sale_item_id" value="{{ $sale->id }}">
    <div class="form-group">
    	<select name="partner_id" class="form-control" id="partner_id" style="width:100%!important;" >
	    	<option value="">Select Partner</option>
	    	@foreach($partners as $partner)
	    		<option value="{{ $partner->id }}" @if($sale->customer_partner_id==$partner->id) selected @endif>{{ $partner->customer_no }} | {{ $partner->last_name }} {{ $partner->first_name }}</option>
	    	@endforeach
	    </select>
    </div>
</form>