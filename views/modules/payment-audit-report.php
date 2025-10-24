<?php

if($_SESSION["profile"] != "Administrator"){

  echo '<script>

    window.location = "home";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Payment Audit Trail
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="reports">Reports</a></li>
      
      <li class="active">Payment Audit Trail</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <h3 class="box-title">All Payment Status Changes</h3>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tables" width="100%">
         
          <thead>
           
           <tr>
             <th>#</th>
             <th>Sale Code</th>
             <th>Customer</th>
             <th>Old Status</th>
             <th>New Status</th>
             <th>Changed By</th>
             <th>Date/Time</th>
             <th>Remarks</th>
           </tr> 

          </thead>

          <tbody>

          <?php

            $item = null;
            $value = null;

            $auditLogs = ControllerPaymentAudit::ctrShowPaymentAudit($item, $value);

            if($auditLogs){

              foreach ($auditLogs as $key => $log) {

                $itemSale = "id";
                $valueSale = $log["sale_id"];

                $sale = ControllerSales::ctrShowSales($itemSale, $valueSale);

                $itemCustomer = "id";
                $valueCustomer = $log["customer_id"];

                $customer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);

                $itemUser = "id";
                $valueUser = $log["changed_by"];

                $user = ControllerUsers::ctrShowUsers($itemUser, $valueUser);

                if($log["old_status"] == "Paid"){
                  $oldStatusBadge = '<span class="label label-success">Paid</span>';
                }elseif($log["old_status"] == "Partial"){
                  $oldStatusBadge = '<span class="label label-warning">Partial</span>';
                }else{
                  $oldStatusBadge = '<span class="label label-danger">Unpaid</span>';
                }

                if($log["new_status"] == "Paid"){
                  $newStatusBadge = '<span class="label label-success">Paid</span>';
                }elseif($log["new_status"] == "Partial"){
                  $newStatusBadge = '<span class="label label-warning">Partial</span>';
                }else{
                  $newStatusBadge = '<span class="label label-danger">Unpaid</span>';
                }

                echo '<tr>
                        <td>'.($key+1).'</td>
                        <td>'.$sale["code"].'</td>
                        <td>'.$customer["name"].'</td>
                        <td>'.$oldStatusBadge.'</td>
                        <td>'.$newStatusBadge.'</td>
                        <td>'.$user["name"].'</td>
                        <td>'.$log["changed_at"].'</td>
                        <td>'.$log["remarks"].'</td>
                      </tr>';

              }

            }

          ?>

          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

