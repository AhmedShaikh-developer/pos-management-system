/*=============================================
LOAD DYNAMIC PURCHASES TABLE
=============================================*/

$('.purchasesTable').DataTable({
	"ajax": "ajax/datatable-purchases.ajax.php", 
	"deferRender": true,
	"retrieve": true,
	"processing": true
});

/*=============================================
PRINT PURCHASE BUTTON
=============================================*/

$(document).on("click", ".btnPrintPurchase", function(e){

	e.preventDefault();
	
	var referenceNo = $(this).attr("href");
	
	// Open PDF in new window
	window.open(referenceNo, '_blank');

})

/*=============================================
ADDING PRODUCTS TO THE PURCHASE FROM THE TABLE
=============================================*/

$(".purchasesProductsTable tbody").on("click", "button.addProductPurchase", function(){

	var idProduct = $(this).attr("idProduct");

	$(this).removeClass("btn-primary addProductPurchase");

	$(this).addClass("btn-default");

	var datum = new FormData();
    datum.append("idProduct", idProduct);

     $.ajax({

     	url:"ajax/products.ajax.php",
      	method: "POST",
      	data: datum,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(answer){

      	    var description = answer["description"];
          	var stock = answer["stock"];
          	var price = answer["buyingPrice"];

          	$(".newPurchaseProduct").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Product description -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removePurchaseProduct" idProduct="'+idProduct+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control newPurchaseProductDescription" idProduct="'+idProduct+'" name="addProductPurchase" value="'+description+'" readonly required>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Product quantity -->'+

	          '<div class="col-xs-3">'+
	            
	             '<input type="number" class="form-control newPurchaseProductQuantity" name="newPurchaseProductQuantity" min="1" value="1" required>'+

	          '</div>' +

	          '<!-- product price -->'+

	          '<div class="col-xs-3 enterPrice" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control newPurchaseProductPrice" realPrice="'+price+'" name="newPurchaseProductPrice" value="'+price+'" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>')

	        addingTotalPurchasePrices()

	        addPurchaseTax()

	        listPurchaseProducts()

	        $(".newPurchaseProductPrice").number(true, 2);

      	}

     })

});

/*=============================================
REMOVE PRODUCTS FROM THE PURCHASE
=============================================*/

var idRemovePurchaseProduct = [];

localStorage.removeItem("removePurchaseProduct");

$(".purchaseForm").on("click", "button.removePurchaseProduct", function(){

	$(this).parent().parent().parent().parent().remove();

	var idProduct = $(this).attr("idProduct");

	if(localStorage.getItem("removePurchaseProduct") == null){

		idRemovePurchaseProduct = [];
	
	}else{

		idRemovePurchaseProduct.concat(localStorage.getItem("removePurchaseProduct"))

	}

	idRemovePurchaseProduct.push({"idProduct":idProduct});

	localStorage.setItem("removePurchaseProduct", JSON.stringify(idRemovePurchaseProduct));

	$("button.recoverButton[idProduct='"+idProduct+"']").removeClass('btn-default');

	$("button.recoverButton[idProduct='"+idProduct+"']").addClass('btn-primary addProductPurchase');

	if($(".newPurchaseProduct").children().length == 0){

		$("#newTaxPurchase").val(0);
		$("#newPurchaseTotal").val(0);
		$("#purchaseTotal").val(0);
		$("#newPurchaseTotal").attr("totalPurchase",0);

	}else{

    	addingTotalPurchasePrices()

        addPurchaseTax()

        listPurchaseProducts()

	}

})

/*=============================================
ADDING PRODUCT FROM A DEVICE
=============================================*/

var numPurchaseProduct = 0;

$(".btnAddPurchaseProduct").click(function(){

	numPurchaseProduct ++;

	var datum = new FormData();
	datum.append("getProducts", "ok");

	$.ajax({

		url:"ajax/products.ajax.php",
      	method: "POST",
      	data: datum,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(answer){
      	    
      	    	$(".newPurchaseProduct").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Product description -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removePurchaseProduct" idProduct><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control newPurchaseProductDescription" id="purchaseProduct'+numPurchaseProduct+'" idProduct name="newPurchaseProductDescription" required>'+

	              '<option>Select product</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

	          '<!-- Product quantity -->'+

	          '<div class="col-xs-3 enterQuantity">'+
	            
	             '<input type="number" class="form-control newPurchaseProductQuantity" name="newPurchaseProductQuantity" min="1" value="1" required>'+

	          '</div>' +

	          '<!-- Product price -->'+

	          '<div class="col-xs-3 enterPrice" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control newPurchaseProductPrice" realPrice="" name="newPurchaseProductPrice" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');

	         answer.forEach(functionForEach);

	         function functionForEach(item, index){

	         	$("#purchaseProduct"+numPurchaseProduct).append(

					'<option idProduct="'+item.id+'" value="'+item.description+'">'+item.description+'</option>'
	         	)

	         }

			addingTotalPurchasePrices()

		    addPurchaseTax()

	        $(".newPurchaseProductPrice").number(true, 2);

      	}

	})

})

/*=============================================
SELECT PRODUCT
=============================================*/

$(".purchaseForm").on("change", "select.newPurchaseProductDescription", function(){

	var productName = $(this).val();

	var newPurchaseProductDescription = $(this).parent().parent().parent().children().children().children(".newPurchaseProductDescription");

	var newPurchaseProductPrice = $(this).parent().parent().parent().children(".enterPrice").children().children(".newPurchaseProductPrice");

	var newPurchaseProductQuantity = $(this).parent().parent().parent().children(".enterQuantity").children(".newPurchaseProductQuantity");

	var datum = new FormData();
    datum.append("productName", productName);

	  $.ajax({

     	url:"ajax/products.ajax.php",
      	method: "POST",
      	data: datum,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(answer){
      	    
      	    $(newPurchaseProductDescription).attr("idProduct", answer["id"]);
      	    $(newPurchaseProductPrice).val(answer["buyingPrice"]);
      	    $(newPurchaseProductPrice).attr("realPrice", answer["buyingPrice"]);

	        listPurchaseProducts()

      	}

      })
})

/*=============================================
MODIFY QUANTITY
=============================================*/

$(".purchaseForm").on("change", "input.newPurchaseProductQuantity", function(){

	var price = $(this).parent().parent().children(".enterPrice").children().children(".newPurchaseProductPrice");

	var finalPrice = $(this).val() * price.attr("realPrice");
	
	price.val(finalPrice);

	addingTotalPurchasePrices();

	addPurchaseTax()

    listPurchaseProducts()

})

/*=============================================
PRICES ADDITION
=============================================*/

function addingTotalPurchasePrices(){

	var priceItem = $(".newPurchaseProductPrice");
	var arrayAdditionPrice = [];  

	for(var i = 0; i < priceItem.length; i++){

		 arrayAdditionPrice.push(Number($(priceItem[i]).val()));
		 
	}

	function additionArrayPrices(totalPurchase, numberArray){

		return totalPurchase + numberArray;

	}

	var addingTotalPrice = arrayAdditionPrice.reduce(additionArrayPrices);
	
	$("#newPurchaseTotal").val(addingTotalPrice);
	$("#purchaseTotal").val(addingTotalPrice);
	$("#newPurchaseTotal").attr("totalPurchase",addingTotalPrice);

}

/*=============================================
ADD TAX
=============================================*/

function addPurchaseTax(){

	var tax = $("#newTaxPurchase").val();

	var totalPrice = $("#newPurchaseTotal").attr("totalPurchase");

	var taxPrice = Number(totalPrice * tax/100);

	var totalwithTax = Number(taxPrice) + Number(totalPrice);
	
	$("#newPurchaseTotal").val(totalwithTax.toFixed(2));

	$("#purchaseTotal").val(totalwithTax.toFixed(2));

}

/*=============================================
WHEN TAX CHANGES
=============================================*/

$("#newTaxPurchase").change(function(){

	addPurchaseTax();

});

/*=============================================
FINAL PRICE FORMAT
=============================================*/

$("#newPurchaseTotal").number(true, 2);

/*=============================================
LIST ALL THE PRODUCTS
=============================================*/

function listPurchaseProducts(){

	var productsList = [];

	var description = $(".newPurchaseProductDescription");

	var quantity = $(".newPurchaseProductQuantity");

	var price = $(".newPurchaseProductPrice");

	for(var i = 0; i < description.length; i++){

		productsList.push({ "id" : $(description[i]).attr("idProduct"), 
							  "description" : $(description[i]).val(),
							  "quantity" : $(quantity[i]).val(),
							  "price" : $(price[i]).attr("realPrice"),
							  "totalPrice" : $(price[i]).val()})
	}

	$("#productsList").val(JSON.stringify(productsList)); 

}

/*=============================================
EDIT PURCHASE BUTTON
=============================================*/

$(document).on("click", ".btnEditPurchase", function(){

	var idPurchase = $(this).attr("idPurchase");

	window.location = "index.php?route=edit-purchase&idPurchase="+idPurchase;

})

/*=============================================
DELETE PURCHASE
=============================================*/

$(document).on("click", ".btnDeletePurchase", function(){

  var idPurchase = $(this).attr("idPurchase");

  swal({
        title: 'Are you sure you want to delete this purchase slip?',
        text: "If you're not, you can cancel!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, delete it!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?route=purchases&idPurchaseSlip="+idPurchase;
        }

  })

})

/*=============================================
GET VENDOR BALANCE
=============================================*/

$("#selectVendor").change(function(){

	var vendorId = $(this).val();

	var datum = new FormData();
    datum.append("vendorId", vendorId);

    $.ajax({

      url:"ajax/purchases.ajax.php",
      method: "POST",
      data: datum,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
      
      	if(answer && answer["balance"]){

      		$("#vendorBalance").html("Unpaid Balance: " + Number(answer["balance"]).toFixed(2));

      	}else{

      		$("#vendorBalance").html("Unpaid Balance: 0.00");

      	}
	  }

  	})

})

