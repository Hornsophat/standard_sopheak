$(document).ready(function() {
    callFileInput('#avatar', 1, 5120, ["jpg" , "jpeg" , "png"]);
    $('#addItem')[0].disabled=true;
    $('.cal-total-cost').keyup(function(){
    	var qty = $('#numQty').val();
    	var cost = $('#unitCost').val();
    	if(!qty || !cost){
    		return;
    	}
    	qty = parseInt(qty);
    	cost = parseFloat(cost);
    	if(typeof qty=='number' && typeof cost=='number'){
    		$('#totalCost').val(qty*cost);
    		$('#addItem')[0].disabled=false;
    	}
    });
    $('.modal-cal-total').keyup(function(){
    	var qty = $('#qtyModal').val();
    	var cost = $('#costModal').val();
    	if(!qty || !cost){
    		return;
    	}
    	qty = parseInt(qty);
    	cost = parseFloat(cost);
    	if(typeof qty=='number' && typeof cost=='number'){
    		$('#totalModal').val(qty*cost);
    		$('#btnEditItem')[0].disabled=false;
    	}
    });
    $('#cancelItem').click(function(){
    	var sms = 'Are you sure you want to cancel?';
    	if(confirm(sms)){
    		localStorage.removeItem('pItem');
    		location.reload();
    	}
    });
    $('body').on('click', '.drop-item', function(){
    	var sms = "Are you sure you want to drop this item?";
    	if(confirm(sms)){
    		var eThis = $(this);
        	var parents = eThis.parents('tr');
        	var iIndex = parents.find('.pro_item_index').val();
        	var items = JSON.parse(localStorage.getItem('pItem'));
        	items.splice(iIndex,1);
        	localStorage.setItem('pItem', JSON.stringify(items));
        	loadItem();
    	}
    });
    $('body').on('click', '.itemEdit', function(){
    	var eThis = $(this);
    	var parents = eThis.parents('tr');
    	var product_no = parents.find('.product_no').val();
    	var items = JSON.parse(localStorage.getItem('pItem'));
    	$.each(items, function(){
    		var item = this;
    		if(item.product_no == product_no){
    			$('#editItemModalTitle').find('span').text(item.product);
    			$('#pro_noModal').val(item.product_no);
    			$('#qtyModal').val(item.quantity);
    			$('#costModal').val(item.cost);
    			$('#totalModal').val(item.cost*item.quantity);
    		}
    	})
    	$('#btnEditItem')[0].disabled=true;
    });
    $('#btnEditItem').click(function(){
    	var product_no = $('#pro_noModal').val();
    	var product_qty = $('#qtyModal').val();
    	var product_cost = $('#costModal').val();
    	var items = JSON.parse(localStorage.getItem('pItem'));
    	var iIndex;
    	if(!product_qty || !product_cost || product_qty<1){
    		return;
    	}
    	$.each(items, function(index){
    		var item=this;
    		if(item.product_no == product_no){
    			iIndex = index;
    		}
    	})
    	items[iIndex]={
    		'product' : items[iIndex].product,
    		'product_no' : product_no,
    		'cost' : product_cost,
    		'quantity' : product_qty
    	}
    	localStorage.setItem('pItem', JSON.stringify(items));
    	loadItem();
    	$('#btnEditItem')[0].disabled=true;
    	$('#editItemModal').modal('toggle');
    })
    $('#addItem').click(function(){
    	var product_name =  $('#numproduct option:selected').text();
    	var product_no  = $('#numproduct').val();
    	var qty = $('#numQty').val();
    	var cost = $('#unitCost').val();
    	var items=JSON.parse(localStorage.getItem('pItem'));
    	var its;
    	
    	if(!qty || !cost || product_no==0 || qty<1){
    		return;
    	}
    	if(localStorage.getItem('pItem')){
    		let iIndex = 0;
    		var specailIndex;
    		var dup_product=0;
    		$.each(items, function(){
    			var item = this;
    			if(item.product_no == product_no){
    				specailIndex=iIndex;
    				dup_product=1;
    			}
    			iIndex++;
    		})
    		if(dup_product){
    			items[specailIndex]={
            		'product' : product_name,
            		'product_no' : product_no,
            		'cost' : cost,
            		'quantity' : parseInt(items[specailIndex].quantity)+parseInt(qty)
            	};
    		}else{
    			items.push({
            		'product' : product_name,
            		'product_no' : product_no,
            		'cost' : cost,
            		'quantity' : qty
            	});
    		}
    	}else{
    		items=[{
        		'product' : product_name,
        		'product_no' : product_no,
        		'cost' : cost,
        		'quantity' : qty
        	}];
    	}
    	localStorage.setItem('pItem', JSON.stringify(items));
    	loadItem();
    	$('#numQty').val('');
    	$('#unitCost').val('');
    	$('#totalCost').val('');
    	$('#addItem')[0].disabled=true;
    });
});
function loadItem(){
	var bodyItem = $('#bodyItem');
	var items = JSON.parse(localStorage.getItem('pItem'));
	var pHTML = '';
	var iIndex=0;
	var subTotal =0;
	$.each(items, function (index) {
    	var item = this;
		iIndex++;
		subTotal += item.cost*item.quantity;
		pHTML+='<tr>';
		pHTML+='<td class="text-right"><span>'+iIndex+'</span><input type="hidden" class="pro_item_index" value="'+index+'"></td>';
		pHTML+='<td class="text-left"><span class="pro_name">'+item.product+'</span><input type="hidden" class="product_no" name="products_no[]" value="'+item.product_no+'"><input type="hidden" name="products[]" value="'+item.product+'"></td>';
		pHTML+='<td class="text-right"><span>'+item.quantity+'</span><input type="hidden" class="pro_quantity" name="quantities[]" value="'+item.quantity+'"></td>';
		pHTML+='<td class="text-right"><span>'+item.cost+'</span><input type="hidden" class="pro_cost" name="costs[]" value="'+item.cost+'"></td>';
		pHTML+='<td class="text-right"><span>'+item.cost*item.quantity+'</span><input class="pro_total" type="hidden" name="totals[]" value="'+item.cost*item.quantity+'"></td>';
		pHTML+='<td class="text-center"><a data-toggle="modal" data-target="#editItemModal" href="#" class="itemEdit"><i class="fa fa-edit"></i>Edit</a><a href="#" class="ml-4 text-danger drop-item"><i class="fa fa-times"></i>Drop</a></td>';
		pHTML+='</tr>';
	});
	bodyItem.html(pHTML);
	$('#subTotal').text(subTotal);
    getTotal(subTotal)
}

$(document).on('keyup', '#grand_total, #discount', function(){
    loadItem()
});
$(document).on('change', '#discount_type', function(){
    $('#discount').val(0);
    loadItem()
});
function getTotal(grand_total){
    var discount = $('#discount').val();
    var dis_type = $('#discount_type option:selected').val();
    if(dis_type=='discount_percent'){
        discount = discount/100;
        $('#grand_total').val(grand_total-(grand_total*discount));
    }else{
        if(discount>grand_total){
            $('#discount').val(0)
            loadItem()
        }else{
            $('#grand_total').val(grand_total-discount);
        }
    }
}