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
      Returns & Exchanges Management

    </h1>

    <ol class="breadcrumb">

      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Returns</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="create-return">
          <button class="btn btn-success" >
        
          <i class="fa fa-plus"></i> Create Return
  
          </button>
        </a>

      </div>

      <div class="box-body">
        <table class="table table-bordered table-hover table-striped dt-responsive returnsTable" width="100%">
       
          <thead>
           
           <tr>
             
             <th style="width:10px">#</th>
             <th>Return Code</th>
             <th>Sale Code</th>
             <th>Product</th>
             <th>Quantity</th>
             <th>Refund Amount</th>
             <th>Type</th>
             <th>Reason</th>
             <th>Handled By</th>
             <th>Date</th>
             <th>Actions</th>

           </tr> 

          </thead>

        </table>

         <?php

          $deleteReturn = new ControllerReturns();
          $deleteReturn -> ctrDeleteReturn();

          ?>

      </div>
    
    </div>
  </section>

</div>

