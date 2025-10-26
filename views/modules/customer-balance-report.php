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
      
      Customer Balance Report
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="reports">Reports</a></li>
      
      <li class="active">Customer Balance Report</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <div class="row">

          <div class="col-md-6">

            <label>
              <input type="checkbox" id="filterUnpaid" class="minimal">
              Show Only Unpaid Balances
            </label>

          </div>

          <div class="col-md-6 text-right">

            <button type="button" class="btn btn-default" id="daterange-btn3">
              <i class="fa fa-calendar"></i> Date Range
            </button>

            <div class="btn-group">

              <?php

              if(isset($_GET["initialDate"])){

                echo '<a href="extensions/export-customer-balance.php?report=customer-balance&initialDate='.$_GET["initialDate"].'&finalDate='.$_GET["finalDate"].'">';

              }else{

                echo '<a href="extensions/export-customer-balance.php?report=customer-balance">';

              }         

              ?>

                <button class="btn btn-success">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </button>

              </a>

              <a href="extensions/tcpdf/pdf/customer-balance-report.php" target="_blank">
                <button class="btn btn-danger">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </button>
              </a>

            </div>

          </div>

        </div>
        
      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive customerBalanceTable" width="100%">
         
          <thead>
           
           <tr>
             <th>#</th>
             <th>Customer Name</th>
             <th>Phone</th>
             <th>Total Purchases</th>
             <th>Paid Amount</th>
             <th>Unpaid Balance</th>
             <th>Last Transaction</th>
             <th>Status</th>
           </tr> 

          </thead>

          <tbody>

          <?php

            $item = null;
            $value = null;

            $customers = ControllerCustomers::ctrShowCustomers($item, $value);

            foreach ($customers as $key => $customer) {

              $itemSales = "idCustomer";
              $valueSales = $customer["id"];

              $sales = ControllerSales::ctrShowSales($itemSales, $valueSales);

              $totalPurchases = 0;
              $totalPaid = 0;
              $lastTransaction = $customer["lastPurchase"];

              if($sales){

                if(isset($sales["totalPrice"])){
                  $totalPurchases = $sales["totalPrice"];
                  $totalPaid = $sales["totalPrice"];
                }else{
                  foreach ($sales as $sale) {
                    $totalPurchases += $sale["totalPrice"];
                    $totalPaid += $sale["totalPrice"];
                  }
                }

              }

              $unpaidBalance = $totalPurchases - $totalPaid;

              if($unpaidBalance == 0){
                $statusBadge = '<span class="label label-success">Paid</span>';
                $rowClass = 'success-row';
              }else{
                $statusBadge = '<span class="label label-danger">Unpaid</span>';
                $rowClass = 'danger-row';
              }

              echo '<tr class="'.$rowClass.'" data-unpaid="'.$unpaidBalance.'">
                      <td>'.($key+1).'</td>
                      <td><a href="customers">'.$customer["name"].'</a></td>
                      <td>'.$customer["phone"].'</td>
                      <td>'.number_format($totalPurchases, 2).'</td>
                      <td>'.number_format($totalPaid, 2).'</td>
                      <td>'.number_format($unpaidBalance, 2).'</td>
                      <td>'.$lastTransaction.'</td>
                      <td>'.$statusBadge.'</td>
                    </tr>';

            }

          ?>

          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

