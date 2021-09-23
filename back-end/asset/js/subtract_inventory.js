
$(document).ready(function() {
    callFileInput('#avatar', 1, 5120, ["jpg" , "jpeg" , "png"]);
    $('#addItem')[0].disabled=true;
    $('#cancelItem').click(function(){
    	var sms = 'Are you sure you want to cancel?';
    	if(confirm(sms)){
    		localStorage.removeItem('spItem');
    		location.reload();
    	}
    });
    $('#numproduct').change(function(){
        $('#addItem')[0].disabled=true;
    });
    $('body').on('click', '.drop-item', function(){
    	var sms = "Are you sure you want to drop this item?";
    	if(confirm(sms)){
    		var eThis = $(this);
        	var parents = eThis.parents('tr');
        	var iIndex = parents.find('.pro_item_index').val();
        	var items = JSON.parse(localStorage.getItem('spItem'));
        	items.splice(iIndex,1);
        	localStorage.setItem('spItem', JSON.stringify(items));
        	loadItem();
    	}
    });
    $('body').on('click', '.itemEdit', function(){
    	var eThis = $(this);
    	var parents = eThis.parents('tr');
    	var product_no = parents.find('.product_no').val();
    	var items = JSON.parse(localStorage.getItem('spItem'));
    	$.each(items, function(){
    		var item = this;
    		if(item.product_no == product_no){
    			$('#editItemModalTitle').find('span').text(item.product);
    			$('#pro_noModal').val(item.product_no);
    			$('#qtyModal').val(item.quantity);
    		}
    	})
    	$('#btnEditItem')[0].disabled=true;
    });
    $('#btnEditItem').click(function(){
    	var product_no = $('#pro_noModal').val();
    	var product_qty = $('#qtyModal').val();
    	var items = JSON.parse(localStorage.getItem('spItem'));
    	var iIndex;
    	if(!product_qty  || product_qty<1){
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
    		'quantity' : product_qty
    	}
    	localStorage.setItem('spItem', JSON.stringify(items));
    	loadItem();
    	$('#btnEditItem')[0].disabled=true;
    	$('#editItemModal').modal('toggle');
    });
    $('#addItem').click(function(){
    	var product_name =  $('#numproduct option:selected').text();
    	var product_no  = $('#numproduct').val();
    	var qty = $('#numQty').val();
    	var items=JSON.parse(localStorage.getItem('spItem'));
    	var its;
    	
    	if(!qty ||  product_no==0 || qty<1){
    		return;
    	}
    	if(localStorage.getItem('spItem')){
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
            		'quantity' : parseInt(items[specailIndex].quantity)+parseInt(qty)
            	};
    		}else{
    			items.push({
            		'product' : product_name,
            		'product_no' : product_no,
            		'quantity' : qty
            	});
    		}
    	}else{
    		items=[{
        		'product' : product_name,
        		'product_no' : product_no,
        		'quantity' : qty
        	}];
    	}
    	localStorage.setItem('spItem', JSON.stringify(items));
    	loadItem();
    	$('#numQty').val('');
    	$('#addItem')[0].disabled=true;
    });
});
function loadItem(){
	var bodyItem = $('#bodyItem');
	var items = JSON.parse(localStorage.getItem('spItem'));
	var pHTML = '';
	var iIndex=0;
	var subTotal =0;
	$.each(items, function (index) {
    	var item = this;
		iIndex++;
		subTotal += item.quantity*1;
		pHTML+='<tr>';
		pHTML+='<td class="text-right"><span>'+iIndex+'</span><input type="hidden" class="pro_item_index" value="'+index+'"></td>';
		pHTML+='<td class="text-left"><span class="pro_name">'+item.product+'</span><input type="hidden" class="product_no" name="products_no[]" value="'+item.product_no+'"><input type="hidden" name="products[]" value="'+item.product+'"></td>';
		pHTML+='<td class="text-right"><span>'+item.quantity+'</span><input type="hidden" class="pro_quantity" name="quantities[]" value="'+item.quantity+'"></td>';
		pHTML+='<td class="text-center"><a data-toggle="modal" data-target="#editItemModal" href="#" class="itemEdit"><i class="fa fa-edit"></i>Edit</a><a href="#" class="ml-4 text-danger drop-item"><i class="fa fa-times"></i>Drop</a></td>';
		pHTML+='</tr>';
	});
	bodyItem.html(pHTML);
	$('#subTotal').text(subTotal);
}
function check_product_quantity(this_url){
    var eThis = $('#numQty');
    var pro = $('#numproduct').val();
    var project_id = $('#project option:selected').val();
    if($('#project option:selected').index()==0){
        alert('Please Select Project');
        return 0;
    }
    if($('#numproduct option:selected').index()==0){
        alert('Please Select Product');
        return 0;
    }
    if(eThis.val()<1 || !eThis.val()){
        alert("Failed Input Quantity!!!");
        return 0;
    }
    var item_qty =0;
    var items=JSON.parse(localStorage.getItem('spItem'));
    $.each(items, function (index) {
        var item = this;
        if(item.product_no == pro){
            item_qty = item.quantity;
        }
    });
    var qty = parseInt(eThis.val());
    qty = qty+parseInt(item_qty);
    $.ajax({
        url:this_url,
        type: 'get',
        data:{pro_no:pro, qty:qty, project_id:project_id},
        contentType:false,
        dataType: 'json',
        success:function(data){
            if(data.not_found){
                alert("Please Check Your Product Selected!");
                $('#addItem')[0].disabled=true;
            }else if(data.out_of_stock){
                alert('Please check current quantity in stock');
                $('#addItem')[0].disabled=true;
            }else if(!data.out_of_stock){
                $('#addItem')[0].disabled=false;
            }
        },
        error:function(error){
            alert('Failed data!');
        }
    });
}
function check_product_quantity_edit(this_url){
    var eThis = $('#qtyModal');
    var pro = $('#pro_noModal').val();
    var project_id =  $('#project option:selected').val();
    if(eThis.val()<1 || !eThis.val() || $('#project option:selected').index()==0){
        alert("Failed Input Quantity!!!");
        return 0;
    }
    var qty = parseInt(eThis.val());
    $.ajax({
        url:this_url,
        type: 'get',
        data:{pro_no:pro, qty:eThis.val(), project_id:project_id},
        contentType:false,
        dataType: 'json',
        success:function(data){
            if(data.not_found){
                alert("Please Check Your Product Selected!");
                $('#btnEditItem')[0].disabled=true;
            }else if(data.out_of_stock){
                alert('Please check current quantity in stock');
                $('#btnEditItem')[0].disabled=true;
            }else if(!data.out_of_stock){
                $('#btnEditItem')[0].disabled=false;
            }
        },
        error:function(error){
            alert('Failed data!');
        }
    });
}