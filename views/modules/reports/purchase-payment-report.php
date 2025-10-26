<?php

error_reporting(0);

// Use the same date range from sales report filter
if(isset($_GET["initialDate"])){

    $purchaseInitialDate = $_GET["initialDate"];
    $purchaseFinalDate = $_GET["finalDate"];

}else{

$purchaseInitialDate = null;
$purchaseFinalDate = null;

}

// Get purchase slips within date range
$purchases = ControllerPurchases::ctrPurchaseSlipsDateRange($purchaseInitialDate, $purchaseFinalDate);

$totalPurchases = 0;
$paidPurchases = 0;
$partialPurchases = 0;
$unpaidPurchases = 0;
$totalPaidAmount = 0;
$totalUnpaidAmount = 0;

if($purchases && is_array($purchases)){

    foreach ($purchases as $key => $value) {

        $totalPurchases += $value["total_amount"];
        
        $paymentStatus = isset($value["payment_status"]) ? $value["payment_status"] : "Paid";
        
        if($paymentStatus == "Paid"){
            $paidPurchases += $value["total_amount"];
            $totalPaidAmount += $value["total_amount"];
        }elseif($paymentStatus == "Partial"){
            $partialPurchases += $value["total_amount"];
            // For partial payments, get the actual amount paid from purchase_partial_payments table
            try {
                $partialPayment = PartialPaymentsController::ctrShowPurchasePartialPayment($value["id"]);
                if($partialPayment && isset($partialPayment["amount_paid"])){
                    $totalPaidAmount += $partialPayment["amount_paid"];
                    $totalUnpaidAmount += $partialPayment["balance_remaining"];
                }else{
                    // If no partial payment record found, count as unpaid
                    $totalUnpaidAmount += $value["total_amount"];
                }
            } catch (Exception $e) {
                // If partial payments table doesn't exist or has issues, count as unpaid
                $totalUnpaidAmount += $value["total_amount"];
            }
        }else{
            $unpaidPurchases += $value["total_amount"];
            $totalUnpaidAmount += $value["total_amount"];
        }

    }

}

?>

<!--=====================================
PURCHASE PAYMENT STATUS REPORT
======================================-->

<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-shopping-cart"></i>

  		<h3 class="box-title">Purchase Payment Status Report</h3>

	</div>

	<div class="box-body">

		<div class="row">

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box" style="background-color: white;">
					<span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
					<div class="info-box-content">
						<span class="info-box-text" style="color: #333;">Fully Paid</span>
						<span class="info-box-number" style="color: #333;"><?php echo number_format($paidPurchases, 2); ?></span>
					</div>
				</div>
		</div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box" style="background-color: white;">
				<span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
				<div class="info-box-content">
					<span class="info-box-text" style="color: #333;">Partial Payments</span>
					<span class="info-box-number" style="color: #333;"><?php echo number_format($partialPurchases, 2); ?></span>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box" style="background-color: white;">
				<span class="info-box-icon bg-red"><i class="fa fa-exclamation"></i></span>
					<div class="info-box-content">
						<span class="info-box-text" style="color: #333;">Unpaid</span>
						<span class="info-box-number" style="color: #333;"><?php echo number_format($unpaidPurchases, 2); ?></span>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box" style="background-color: white;">
					<span class="info-box-icon bg-blue"><i class="fa fa-dollar"></i></span>
					<div class="info-box-content">
						<span class="info-box-text" style="color: #333;">Total Paid</span>
						<span class="info-box-number" style="color: #333;"><?php echo number_format($totalPaidAmount, 2); ?></span>
					</div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-md-6">
				<div class="box box-primary" style="background-color: white;">
					<div class="box-header" style="background-color: white;">
						<h3 class="box-title" style="color: #333;">Payment Status Distribution</h3>
					</div>
					<div class="box-body" style="background-color: white;">
						<div class="chart" id="purchase-payment-status-chart" style="height: 300px;"></div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="box box-success" style="background-color: white;">
					<div class="box-header" style="background-color: white;">
						<h3 class="box-title" style="color: #333;">Payment Summary</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered" style="background-color: white;">
							<tr>
								<td style="color: #333;"><strong>Total Purchases Value:</strong></td>
								<td class="text-right" style="color: #333;"><?php echo number_format($totalPurchases, 2); ?></td>
							</tr>
							<tr>
								<td style="color: #333;"><strong>Total Paid:</strong></td>
								<td class="text-right" style="color: #00a65a; font-weight: bold;"><?php echo number_format($totalPaidAmount, 2); ?></td>
							</tr>
							<tr>
								<td style="color: #333;"><strong>Outstanding Balance:</strong></td>
								<td class="text-right" style="color: #dd4b39; font-weight: bold;"><?php echo number_format($totalUnpaidAmount, 2); ?></td>
							</tr>
							<tr>
								<td style="color: #333;"><strong>Payment Rate:</strong></td>
								<td class="text-right" style="color: #333; font-weight: bold;">
									<?php 
									$paymentRate = $totalPurchases > 0 ? ($totalPaidAmount / $totalPurchases) * 100 : 0;
									echo number_format($paymentRate, 1) . '%';
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>

<script>
	
// Purchase Payment Status Pie Chart
var purchasePaymentChart = new Morris.Donut({
    element: 'purchase-payment-status-chart',
    data: [
        {label: "Fully Paid", value: <?php echo $paidPurchases; ?>},
        {label: "Partial Payments", value: <?php echo $partialPurchases; ?>},
        {label: "Unpaid", value: <?php echo $unpaidPurchases; ?>}
    ],
    colors: ['#00a65a', '#f39c12', '#dd4b39'],
    formatter: function (value) { return value.toFixed(2); }
});

</script>

