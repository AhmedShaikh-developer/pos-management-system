/*=============================================
PARTIAL PAYMENT - SHOW/HIDE SECTION
=============================================*/

$('#paymentStatus').on('change', function(){
	
	var status = $(this).val();
	
	if(status == 'Partial'){
		$('#partialPaymentSection').slideDown();
		
		// Make partial payment fields required
		$('#partialAmountPaid').prop('required', true);
		
		// Update balance calculation with current total
		updatePartialBalance();
		
	}else{
		$('#partialPaymentSection').slideUp();
		
		// Remove required attribute
		$('#partialAmountPaid').prop('required', false);
		
		// Clear fields
		$('#partialAmountPaid').val('');
		$('#partialBalanceRemaining').val('');
		$('#partialPaymentReference').val('');
		$('#partialPaymentNotes').val('');
	}
	
});

/*=============================================
CALCULATE REMAINING BALANCE
=============================================*/

function updatePartialBalance(){
	
	// Get total amount (for sales or purchases)
	var total = 0;
	
	if($('#newSaleTotal').length){
		// For sales
		total = parseFloat($('#newSaleTotal').val()) || 0;
	}else if($('#newPurchaseTotal').length){
		// For purchases
		total = parseFloat($('#newPurchaseTotal').val()) || 0;
	}
	
	var amountPaid = parseFloat($('#partialAmountPaid').val()) || 0;
	var balance = total - amountPaid;
	
	// Validate: amount paid cannot exceed total
	if(amountPaid > total){
		swal({
			type: "warning",
			title: "Amount Exceeded",
			text: "Amount paid cannot exceed total amount of " + total.toFixed(2),
			showConfirmButton: false,
			timer: 2000
		});
		
		$('#partialAmountPaid').val(total.toFixed(2));
		balance = 0;
	}
	
	// Prevent negative amounts
	if(amountPaid < 0){
		$('#partialAmountPaid').val('0.00');
		balance = total;
	}
	
	$('#partialBalanceRemaining').val(balance.toFixed(2));
}

// Update balance on amount paid input
$('#partialAmountPaid').on('input', function(){
	updatePartialBalance();
});

// Update balance when total changes (for both sales and purchases)
$('#newSaleTotal, #newPurchaseTotal').on('change input', function(){
	if($('#paymentStatus').val() == 'Partial'){
		updatePartialBalance();
	}
});

/*=============================================
FORM VALIDATION BEFORE SUBMIT
=============================================*/

$('form.saleForm, form.purchaseForm').on('submit', function(e){
	
	var paymentStatus = $('#paymentStatus').val();
	
	if(paymentStatus == 'Partial'){
		
		var total = 0;
		
		if($('#newSaleTotal').length){
			total = parseFloat($('#newSaleTotal').val()) || 0;
		}else if($('#newPurchaseTotal').length){
			total = parseFloat($('#newPurchaseTotal').val()) || 0;
		}
		
		var amountPaid = parseFloat($('#partialAmountPaid').val()) || 0;
		
		// Validation: amount paid is required for partial
		if(amountPaid <= 0){
			e.preventDefault();
			swal({
				type: "error",
				title: "Invalid Amount",
				text: "Please enter amount paid for partial payment",
				showConfirmButton: true,
				confirmButtonText: "Close"
			});
			return false;
		}
		
		// Validation: amount paid cannot exceed total
		if(amountPaid > total){
			e.preventDefault();
			swal({
				type: "error",
				title: "Amount Exceeded",
				text: "Amount paid (" + amountPaid.toFixed(2) + ") cannot exceed total (" + total.toFixed(2) + ")",
				showConfirmButton: true,
				confirmButtonText: "Close"
			});
			return false;
		}
		
		// Validation: amount paid should be less than total (otherwise it's fully paid)
		if(amountPaid >= total){
			e.preventDefault();
			swal({
				type: "warning",
				title: "Fully Paid",
				text: "Amount paid equals total. Please select 'Paid' status instead of 'Partial'",
				showConfirmButton: true,
				confirmButtonText: "Close"
			});
			return false;
		}
		
	}
	
});

