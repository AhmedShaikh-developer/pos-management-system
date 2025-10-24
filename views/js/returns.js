/*=============================================
LOAD DYNAMIC RETURNS TABLE
=============================================*/

$('.returnsTable').DataTable({
	"ajax": "ajax/datatable-returns.ajax.php", 
	"deferRender": true,
	"retrieve": true,
	"processing": true
});

/*=============================================
WHEN SALE IS SELECTED, LOAD PRODUCTS
=============================================*/

$("#saleId").change(function(){

	var saleId = $(this).val();

	var datum = new FormData();
    datum.append("saleId", saleId);

    $.ajax({

      url:"ajax/returns.ajax.php",
      method: "POST",
      data: datum,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
      
      	if(answer){

      		var products = JSON.parse(answer["products"]);

      		$(".newReturnProduct").html("");

      		products.forEach(function(product, index){

      			var datum2 = new FormData();
			    datum2.append("idProduct", product.id);

			    $.ajax({

			      url:"ajax/products.ajax.php",
			      method: "POST",
			      data: datum2,
			      cache: false,
			      contentType: false,
			      processData: false,
			      dataType:"json",
			      success:function(productData){

			      	$(".newReturnProduct").append(

			      		'<div class="col-xs-12" style="padding:5px 15px">'+

						  '<div class="row">'+

				          '<div class="col-xs-6" style="padding-right:0px">'+
				          
				            '<div class="input-group">'+
				              
				              '<span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>'+

				              '<input type="text" class="form-control returnProductDescription" idProduct="'+product.id+'" value="'+productData["description"]+'" readonly required>'+

				            '</div>'+

				          '</div>'+

				          '<div class="col-xs-2">'+

				          	'<div class="input-group">'+
				              
				              '<span class="input-group-addon">Max</span>'+
				            
				             '<input type="number" class="form-control" value="'+product.quantity+'" readonly>'+

				            '</div>'+

				          '</div>' +

				          '<div class="col-xs-2">'+
				            
				             '<input type="number" class="form-control returnProductQuantity" name="returnProductQuantity" min="1" max="'+product.quantity+'" value="1" stock="'+product.quantity+'" required>'+

				          '</div>' +

				          '<div class="col-xs-2 enterPrice" style="padding-left:0px">'+

				            '<div class="input-group">'+

				              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
				                 
				              '<input type="text" class="form-control returnProductPrice" realPrice="'+product.price+'" name="returnProductPrice" value="'+product.price+'" readonly required>'+
				 
				            '</div>'+
				             
				          '</div>'+

				        '</div>'+

				        '</div>'

			      	)

			      	addingTotalReturnPrices()

			      	listReturnProducts()

			      	$(".returnProductPrice").number(true, 2);

			      }

			    })

      		})

      	}

	  }

  	})

})

/*=============================================
MODIFY QUANTITY
=============================================*/

$(".returnForm").on("change", "input.returnProductQuantity", function(){

	var price = $(this).parent().parent().children(".enterPrice").children().children(".returnProductPrice");

	var finalPrice = $(this).val() * price.attr("realPrice");
	
	price.val(finalPrice);

	var maxStock = $(this).attr("stock");

	if(Number($(this).val()) > Number(maxStock)){

		$(this).val(1);

		var finalPrice = $(this).val() * price.attr("realPrice");

		price.val(finalPrice);

		addingTotalReturnPrices();

		swal({
	      title: "The quantity is more than purchased quantity",
	      text: "¡There's only "+maxStock+" units!",
	      type: "error",
	      confirmButtonText: "Close!"
	    });

	    return;

	}

	addingTotalReturnPrices()

    listReturnProducts()

})

/*=============================================
PRICES ADDITION
=============================================*/

function addingTotalReturnPrices(){

	var priceItem = $(".returnProductPrice");
	var arrayAdditionPrice = [];  

	for(var i = 0; i < priceItem.length; i++){

		 arrayAdditionPrice.push(Number($(priceItem[i]).val()));
		 
	}

	function additionArrayPrices(totalReturn, numberArray){

		return totalReturn + numberArray;

	}

	var addingTotalPrice = arrayAdditionPrice.reduce(additionArrayPrices);
	
	$("#newReturnTotal").val(addingTotalPrice.toFixed(2));
	$("#returnTotal").val(addingTotalPrice.toFixed(2));

}

/*=============================================
FINAL PRICE FORMAT
=============================================*/

$("#newReturnTotal").number(true, 2);

/*=============================================
LIST ALL THE PRODUCTS
=============================================*/

function listReturnProducts(){

	var productsList = [];

	var description = $(".returnProductDescription");

	var quantity = $(".returnProductQuantity");

	var price = $(".returnProductPrice");

	for(var i = 0; i < description.length; i++){

		productsList.push({ "id" : $(description[i]).attr("idProduct"), 
							  "description" : $(description[i]).val(),
							  "quantity" : $(quantity[i]).val(),
							  "price" : $(price[i]).attr("realPrice"),
							  "totalPrice" : $(price[i]).val()})
	}

	$("#returnProductsList").val(JSON.stringify(productsList)); 

}

/*=============================================
DELETE RETURN
=============================================*/

$(document).on("click", ".btnDeleteReturn", function(){

  var idReturn = $(this).attr("idReturn");

  swal({
        title: 'Are you sure you want to delete this return?',
        text: "If you're not, you can cancel!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, delete it!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?route=returns&idReturn="+idReturn;
        }

  })

})

/*=============================================
PRINT RETURN BUTTON
=============================================*/

$(document).on("click", ".btnPrintReturn", function(e){

	e.preventDefault();
	
	var returnSlip = $(this).attr("href");
	
	window.open(returnSlip, '_blank');

})

