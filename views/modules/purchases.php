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
      Purchase Management

    </h1>

    <ol class="breadcrumb">

      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Purchases</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="create-purchase">
          <button class="btn btn-success" >
        
          <i class="fa fa-plus"></i> Add Purchase
  
          </button>
        </a>

      </div>

      <div class="box-body">
        <table class="table table-bordered table-hover table-striped dt-responsive purchasesTable" width="100%">
       
          <thead>
           
           <tr>
             
             <th style="width:10px">#</th>
             <th>Reference No</th>
             <th>Vendor</th>
             <th>Total Amount</th>
             <th>Payment Status</th>
             <th>Payment Method</th>
             <th>Date</th>
             <th>Actions</th>

           </tr> 

          </thead>

        </table>

         <?php

          $deletePurchase = new ControllerPurchases();
          $deletePurchase -> ctrDeletePurchaseSlip();

          ?>

      </div>
    
    </div>
  </section>

</div>

