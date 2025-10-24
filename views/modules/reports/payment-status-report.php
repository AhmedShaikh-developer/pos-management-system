<?php

error_reporting(0);

if(isset($_GET["initialDate"])){

    $initialDate = $_GET["initialDate"];
    $finalDate = $_GET["finalDate"];

}else{

$initialDate = null;
$finalDate = null;

}

$answer = ControllerSales::ctrSalesDatesRange($initialDate, $finalDate);

$totalSales = 0;
$paidSales = 0;
$partialSales = 0;
$unpaidSales = 0;
$totalPaidAmount = 0;
$totalUnpaidAmount = 0;

foreach ($answer as $key => $value) {

    $totalSales += $value["totalPrice"];
    
    $paymentStatus = isset($value["payment_status"]) ? $value["payment_status"] : "Paid";
    
    if($paymentStatus == "Paid"){
        $paidSales += $value["totalPrice"];
        $totalPaidAmount += $value["totalPrice"];
    }elseif($paymentStatus == "Partial"){
        $partialSales += $value["totalPrice"];
        // Get partial payment amount
        $partialPaid = ModelPartialPayments::mdlGetTotalPaidAmount($value["id"]);
        $totalPaidAmount += $partialPaid;
        $totalUnpaidAmount += ($value["totalPrice"] - $partialPaid);
    }else{
        $unpaidSales += $value["totalPrice"];
        $totalUnpaidAmount += $value["totalPrice"];
    }

}

?>

<!--=====================================
PAYMENT STATUS REPORT
======================================-->

<div class="box box-solid bg-green-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-credit-card"></i>

  		<h3 class="box-title">Payment Status Report</h3>

	</div>

	<div class="box-body">

		<div class="row">

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Fully Paid</span>
						<span class="info-box-number">$<?php echo number_format($paidSales, 2); ?></span>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Partial Payments</span>
						<span class="info-box-number">$<?php echo number_format($partialSales, 2); ?></span>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-exclamation"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Unpaid</span>
						<span class="info-box-number">$<?php echo number_format($unpaidSales, 2); ?></span>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="fa fa-dollar"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Total Collected</span>
						<span class="info-box-number">$<?php echo number_format($totalPaidAmount, 2); ?></span>
					</div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Payment Status Distribution</h3>
					</div>
					<div class="box-body">
						<div class="chart" id="payment-status-chart" style="height: 300px;"></div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header">
						<h3 class="box-title">Collection Summary</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered">
							<tr>
								<td><strong>Total Sales Value:</strong></td>
								<td class="text-right">$<?php echo number_format($totalSales, 2); ?></td>
							</tr>
							<tr>
								<td><strong>Total Collected:</strong></td>
								<td class="text-right text-green">$<?php echo number_format($totalPaidAmount, 2); ?></td>
							</tr>
							<tr>
								<td><strong>Outstanding Balance:</strong></td>
								<td class="text-right text-red">$<?php echo number_format($totalUnpaidAmount, 2); ?></td>
							</tr>
							<tr>
								<td><strong>Collection Rate:</strong></td>
								<td class="text-right">
									<?php 
									$collectionRate = $totalSales > 0 ? ($totalPaidAmount / $totalSales) * 100 : 0;
									echo number_format($collectionRate, 1) . '%';
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
	
// Payment Status Pie Chart
var pieChart = new Morris.Donut({
    element: 'payment-status-chart',
    data: [
        {label: "Fully Paid", value: <?php echo $paidSales; ?>},
        {label: "Partial Payments", value: <?php echo $partialSales; ?>},
        {label: "Unpaid", value: <?php echo $unpaidSales; ?>}
    ],
    colors: ['#00a65a', '#f39c12', '#dd4b39'],
    formatter: function (value) { return '$' + value.toFixed(2); }
});

</script>
