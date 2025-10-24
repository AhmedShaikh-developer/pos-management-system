<?php

if($_SESSION["profile"] == "Special"){

  echo '<script>

    window.location = "home";

  </script>';

  return;

}


$xml = ControllerSales::ctrDownloadXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success openXML" file="xml/'.$_GET["xml"].'.xml" href="sales">The XML file has been created succesfully<span class="fa fa-times pull-right"></span></a>';

}

?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>
      Sales Management

    </h1>

    <ol class="breadcrumb">

      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Dashboard</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="create-sale">
          <button class="btn btn-success" >
        
          <i class="fa fa-plus"></i> Add Sale
  
          </button>
        </a>

        <button type="button" class="btn btn-primary pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> Date Range
            </span>

            <i class="fa fa-caret-down"></i>

        </button>

      </div>

      <div class="box-body">
        <table class="table table-bordered table-hover table-striped dt-responsive tables" width="100%">
       
          <thead>
           
           <tr>
             
             <th style="width:10px">#</th>
             <th>Bill</th>
             <th>Customer</th>
             <th>Seller</th>
             <th>Payment Method</th>
             <th>Payment Status</th>
             <th>Net Cost</th>
             <th>Total Cost</th>
             <th>Date</th>
             <th>Actions</th>

           </tr> 

          </thead>

          <tbody>

            <?php

          if(isset($_GET["initialDate"])){

            $initialDate = $_GET["initialDate"];
            $finalDate = $_GET["finalDate"];

          }else{

            $initialDate = null;
            $finalDate = null;

          }

          $answer = ControllerSales::ctrSalesDatesRange($initialDate, $finalDate);

          foreach ($answer as $key => $value) {
           

           echo '<td>'.($key+1).'</td>

                  <td>'.$value["code"].'</td>';

                  $itemCustomer = "id";
                  $valueCustomer = $value["idCustomer"];

                  $customerAnswer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);

                  echo '<td>'.$customerAnswer["name"].'</td>';

                  $itemUser = "id";
                  $valueUser = $value["idSeller"];

                  $userAnswer = ControllerUsers::ctrShowUsers($itemUser, $valueUser);

                  echo '<td>'.$userAnswer["name"].'</td>

                  <td>'.$value["paymentMethod"].'</td>';

                  $paymentStatus = isset($value["payment_status"]) ? $value["payment_status"] : "Paid";

                  if($paymentStatus == "Paid"){
                    echo '<td><span class="label label-success">Paid</span></td>';
                  }elseif($paymentStatus == "Partial"){
                    echo '<td><span class="label label-warning">Partial</span></td>';
                  }else{
                    echo '<td><span class="label label-danger">Unpaid</span></td>';
                  }

                  echo '<td>$ '.number_format($value["netPrice"],2).'</td>

                  <td>$ '.number_format($value["totalPrice"],2).'</td>

                  <td>'.$value["saledate"].'</td>

                  <td>

                    <div class="btn-group">
                        
                      <div class="btn-group">

                      <a class="btn btn-success" href="index.php?route=sales&xml='.$value["code"].'">xml</a>
                        
                      <button class="btn btn-warning btnPrintBill" saleCode="'.$value["code"].'">

                        <i class="fa fa-print"></i>

                      </button>';

                       if($_SESSION["profile"] == "Administrator"){
                        
                         echo '<button class="btn btn-info btnViewAuditLog" saleId="'.$value["id"].'" data-toggle="modal" data-target="#modalAuditLog"><i class="fa fa-history"></i></button>

                          <button class="btn btn-primary btnEditSale" idSale="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                          <button class="btn btn-danger btnDeleteSale" idSale="'.$value["id"].'"><i class="fa fa-trash"></i></button>';
                       }

                   echo '</div>  

                  </td>

                </tr>';
            }

        ?>


          </tbody>

        </table>

         <?php

          $deleteSale = new ControllerSales();
          $deleteSale -> ctrDeleteSale();

          ?>

      </div>
    
    </div>
  </section>

</div>

<!--=====================================
MODAL VIEW AUDIT LOG
======================================-->

<div id="modalAuditLog" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#3C8DBC; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Payment Audit Log</h4>

      </div>

      <div class="modal-body">

        <div class="box-body">

          <div id="auditLogContent">
            
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Date/Time</th>
                  <th>Old Status</th>
                  <th>New Status</th>
                  <th>Changed By</th>
                  <th>Remarks</th>
                </tr>
              </thead>
              <tbody id="auditLogTableBody">
                
              </tbody>
            </table>

          </div>

          <hr>

          <form role="form" method="POST">

            <input type="hidden" name="saleId" id="modalSaleId">

            <div class="form-group">
              <label>Update Payment Status:</label>
              <select class="form-control" name="newPaymentStatus" id="newPaymentStatus" required>
                <option value="">-Select Status-</option>
                <option value="Paid">Paid</option>
                <option value="Partial">Partial</option>
                <option value="Unpaid">Unpaid</option>
              </select>
            </div>

            <div class="form-group">
              <label>Remarks (Optional):</label>
              <textarea class="form-control" name="paymentRemarks" id="paymentRemarks" rows="2" placeholder="Enter any remarks"></textarea>
            </div>

            <button type="submit" name="updatePaymentStatus" class="btn btn-success">Update Status</button>

          </form>

          <?php

            $updateStatus = new ControllerPaymentAudit();
            $updateStatus -> ctrUpdatePaymentStatus();

          ?>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>