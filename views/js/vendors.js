/*=============================================
EDIT VENDOR
=============================================*/

$(".tables").on("click", "tbody .btnEditVendor", function(){

	var idVendor = $(this).attr("idVendor");

	var datum = new FormData();
    datum.append("idVendor", idVendor);

    $.ajax({

      url:"ajax/vendors.ajax.php",
      method: "POST",
      data: datum,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
      
      	 $("#idVendor").val(answer["id"]);
	       $("#editVendor").val(answer["name"]);
	       $("#editPhone").val(answer["phone"]);
	       $("#editAddress").val(answer["address"]);
	  }

  	})

})

/*=============================================
DELETE VENDOR
=============================================*/

$(".tables").on("click", "tbody .btnDeleteVendor", function(){

	var idVendor = $(this).attr("idVendor");
	
	swal({
        title: '¿Are you sure you want to delete this vendor?',
        text: "¡If you're not you can cancel the action!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes, delete vendor!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?route=vendors&idVendor="+idVendor;
        }

  })

})

