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

      Create Return / Exchange

    </h1>

    <ol class="breadcrumb">

      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Create Return</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">
      
      <!--=============================================
      THE FORM
      =============================================-->
      <div class="col-lg-12 col-xs-12">
        
        <div class="box box-default">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="returnForm">

            <div class="box-body">
                
                <div class="box">

                    <!--=====================================
                    =            RETURN CODE INPUT           =
                    ======================================-->
                  
                    
                    <div class="form-group col-xs-6">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        

                        <?php 
                          $item = null;
                          $value = null;

                          $returns = ControllerReturns::ctrShowReturns($item, $value);

                          if(!$returns){

                            echo '<input type="text" class="form-control" name="newReturn" id="newReturn" value="RET-10001" readonly>';
                          }
                          else{

                            foreach ($returns as $key => $value) {
                              
                            }

                            $refNo = explode("-", $value["return_code"]);
                            $code = intval($refNo[1]) + 1;

                            echo '<input type="text" class="form-control" name="newReturn" id="newReturn" value="RET-'.$code.'" readonly>';

                          }

                        ?>

                      </div>


                    </div>


                    <!--=====================================
                    =            SALE CODE INPUT           =
                    ======================================-->
                  
                    <div class="form-group col-xs-6">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                        <select class="form-control" name="saleId" id="saleId" required>
                          
                            <option value="">Select Sale</option>

                            <?php 

                            $item = null;
                            $value = null;

                            $sales = ControllerSales::ctrShowSales($item, $value);

                            foreach ($sales as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["code"].'</option>';
                            }


                            ?>

                        </select>

                      </div>

                    </div>

                    <!--=====================================
                    =            PRODUCTS WILL LOAD HERE           =
                    ======================================-->
                  
                    
                    <div class="form-group row newReturnProduct col-xs-12">


                    </div>

                    <input type="hidden" name="returnProductsList" id="returnProductsList">

                    <hr>

                    <div class="row">

                      <!--=====================================
                        TOTAL REFUND
                      ======================================-->

                      <div class="col-xs-8 pull-right">

                        <table class="table">
                          
                          <thead>
                            
                            <th>Total Refund</th>

                          </thead>


                          <tbody>
                            
                            <tr>

                              <td style="width: 50%">

                                <div class="input-group">
                                  
                                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  
                                  <input type="number" class="form-control" name="newReturnTotal" id="newReturnTotal" placeholder="00000" readonly required>

                                  <input type="hidden" name="returnTotal" id="returnTotal" required>

                                </div>

                              </td>

                            </tr>

                          </tbody>
                        </table>
                        
                      </div>

                      <hr>
                      
                    </div>

                    <hr>

                    <!--=====================================
                      RETURN TYPE AND REASON
                      ======================================-->

                    <div class="form-group row">
                      
                      <div class="col-xs-6" style="padding-right: 0">

                        <div class="input-group">
                      
                          <span class="input-group-addon"><i class="fa fa-info"></i></span>

                          <select class="form-control" name="returnType" id="returnType" required>
                            
                              <option value="">-Select Type-</option>
                              <option value="refund">Refund</option>
                              <option value="exchange">Exchange</option>

                          </select>

                        </div>

                      </div>

                      <div class="col-xs-6">

                        <div class="input-group">
                      
                          <span class="input-group-addon"><i class="fa fa-comment"></i></span>

                          <select class="form-control" name="returnReason" id="returnReason" required>
                            
                              <option value="">-Select Reason-</option>
                              <option value="Defective Product">Defective Product</option>
                              <option value="Wrong Item">Wrong Item</option>
                              <option value="Customer Changed Mind">Customer Changed Mind</option>
                              <option value="Damaged on Arrival">Damaged on Arrival</option>
                              <option value="Not as Described">Not as Described</option>
                              <option value="Other">Other</option>

                          </select>

                        </div>

                      </div>

                    </div>

                    <br>
                    
                </div>

            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-success pull-right">Save Return</button>
            </div>
          </form>

          <?php

            $saveReturn = new ControllerReturns();
            $saveReturn -> ctrCreateReturn();
            
          ?>

        </div>

      </div>

    </div>

  </section>

</div>

