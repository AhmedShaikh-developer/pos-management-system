/*=============================================
PARTIAL PAYMENTS
=============================================*/

$('.btnRecordPayment').click(function(){

  var saleId = $(this).attr('saleId');
  
  console.log("=== RECORD PAYMENT CLICKED ===");
  console.log("Sale ID:", saleId);

  $('#paymentSaleId').val(saleId);

  // Get sale details and payment summary
  $.ajax({
    url: "ajax/partial-payments.ajax.php",
    method: "GET",
    data: {item: "id", value: saleId},
    dataType: "json",
    success: function(response){

      console.log("=== AJAX RESPONSE RECEIVED ===");
      console.log("Sale Data Response:", response);
      console.log("Response Type:", typeof response);
      console.log("Total Price:", response.totalPrice);

      if(response && response.totalPrice){

        var totalAmount = parseFloat(response.totalPrice) || 0;
        var amountPaid = parseFloat(response.amountPaid) || 0;
        var remainingBalance = totalAmount - amountPaid;

        console.log("Total Amount:", totalAmount); // Debug log
        console.log("Amount Paid:", amountPaid); // Debug log
        console.log("Remaining Balance:", remainingBalance); // Debug log

        $('#totalAmount').text(totalAmount.toFixed(2));
        $('#amountPaid').text(amountPaid.toFixed(2));
        $('#remainingBalance').text(remainingBalance.toFixed(2));

        // Set max amount for payment input
        $('#amountPaidInput').attr('max', remainingBalance);
        $('#amountPaidInput').val(''); // Clear previous value

        // Update payment summary color based on balance
        if(remainingBalance <= 0){
          $('#paymentSummary').removeClass('alert-info alert-warning').addClass('alert-success');
        }else if(remainingBalance < totalAmount){
          $('#paymentSummary').removeClass('alert-info alert-success').addClass('alert-warning');
        }else{
          $('#paymentSummary').removeClass('alert-warning alert-success').addClass('alert-info');
        }

      } else {
        console.error("Invalid sale data received:", response);
        swal({
          type: "error",
          title: "Error",
          text: "Unable to load sale details. Please refresh and try again.",
          showConfirmButton: true,
          confirmButtonText: "Close"
        });
      }

    },
    error: function(xhr, status, error){
      console.error("AJAX Error:", status, error);
      console.error("Response:", xhr.responseText);
      swal({
        type: "error",
        title: "Connection Error",
        text: "Failed to load sale details. Please check your connection.",
        showConfirmButton: true,
        confirmButtonText: "Close"
      });
    }
  });

});

// Validate payment amount
$('#amountPaidInput').on('input', function(){

  var maxAmount = parseFloat($(this).attr('max'));
  var enteredAmount = parseFloat($(this).val());

  console.log("Validating: Entered =", enteredAmount, "Max =", maxAmount); // Debug log

  if(!isNaN(enteredAmount) && !isNaN(maxAmount) && enteredAmount > maxAmount && maxAmount > 0){
    $(this).val(maxAmount.toFixed(2));
    swal({
      type: "warning",
      title: "Amount Exceeded",
      text: "Payment amount cannot exceed remaining balance of $" + maxAmount.toFixed(2),
      showConfirmButton: false,
      timer: 2000
    });
  }

});

// Auto-fill payment amount with remaining balance
$('#amountPaidInput').on('focus', function(){

  var remainingBalance = parseFloat($('#remainingBalance').text());
  
  if(remainingBalance > 0 && $(this).val() == ''){
    $(this).val(remainingBalance.toFixed(2));
  }

});

// Payment form validation
$('#modalRecordPayment form').on('submit', function(e){

  var amountPaid = parseFloat($('#amountPaidInput').val());
  var remainingBalance = parseFloat($('#remainingBalance').text());
  var paymentMethod = $('#paymentMethod').val();

  console.log("Form Submit - Amount:", amountPaid, "Balance:", remainingBalance, "Method:", paymentMethod); // Debug log

  if(isNaN(amountPaid) || amountPaid <= 0){
    e.preventDefault();
    swal({
      type: "error",
      title: "Invalid Amount",
      text: "Please enter a valid payment amount greater than $0.",
      showConfirmButton: true,
      confirmButtonText: "Close"
    });
    return false;
  }

  if(remainingBalance <= 0){
    e.preventDefault();
    swal({
      type: "error",
      title: "Already Fully Paid",
      text: "This sale is already fully paid. Remaining balance is $0.",
      showConfirmButton: true,
      confirmButtonText: "Close"
    });
    return false;
  }

  if(amountPaid > remainingBalance){
    e.preventDefault();
    swal({
      type: "error",
      title: "Amount Exceeded",
      text: "Payment amount ($" + amountPaid.toFixed(2) + ") cannot exceed remaining balance ($" + remainingBalance.toFixed(2) + ").",
      showConfirmButton: true,
      confirmButtonText: "Close"
    });
    return false;
  }

  if(paymentMethod == '' || paymentMethod == null){
    e.preventDefault();
    swal({
      type: "error",
      title: "Payment Method Required",
      text: "Please select a payment method.",
      showConfirmButton: true,
      confirmButtonText: "Close"
    });
    return false;
  }

});

// View payment history
$('.btnViewPaymentHistory').click(function(){

  var saleId = $(this).attr('saleId');

  $.ajax({
    url: "ajax/payment-history.ajax.php",
    method: "GET",
    data: {saleId: saleId},
    dataType: "json",
    success: function(response){

      if(response && response.length > 0){

        var historyHtml = '<table class="table table-bordered table-striped">';
        historyHtml += '<thead><tr><th>Date</th><th>Amount</th><th>Method</th><th>Reference</th><th>Recorded By</th></tr></thead>';
        historyHtml += '<tbody>';

        response.forEach(function(payment){
          historyHtml += '<tr>';
          historyHtml += '<td>' + payment.paid_at + '</td>';
          historyHtml += '<td>$' + parseFloat(payment.amount_paid).toFixed(2) + '</td>';
          historyHtml += '<td>' + payment.payment_method.charAt(0).toUpperCase() + payment.payment_method.slice(1) + '</td>';
          historyHtml += '<td>' + (payment.reference_no || '-') + '</td>';
          historyHtml += '<td>' + (payment.paid_by_name || 'Unknown') + '</td>';
          historyHtml += '</tr>';
        });

        historyHtml += '</tbody></table>';

        swal({
          type: "info",
          title: "Payment History",
          html: historyHtml,
          showConfirmButton: true,
          confirmButtonText: "Close",
          width: "800px"
        });

      }else{

        swal({
          type: "info",
          title: "No Payment History",
          text: "No partial payments have been recorded for this sale.",
          showConfirmButton: true,
          confirmButtonText: "Close"
        });

      }

    },
    error: function(){
      swal({
        type: "error",
        title: "Error",
        text: "Failed to load payment history.",
        showConfirmButton: true,
        confirmButtonText: "Close"
      });
    }
  });

});
