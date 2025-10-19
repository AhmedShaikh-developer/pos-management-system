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

      Edit Purchase

    </h1>

    <ol class="breadcrumb">

      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Edit Purchase</li>
    </ol>

  </section>

  <section class="content">

    <div class="row">
      
      <!--=============================================
      THE FORM
      =============================================-->
      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-default">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="purchaseForm">

            <div class="box-body">
                
                <div class="box">

                  <?php

                    $item = "id";
                    $value = $_GET["idPurchase"];

                    $purchase = ControllerPurchases::ctrShowPurchaseSlips($item, $value);

                    $itemVendor = "id";
                    $valueVendor = $purchase["vendor_id"];

                    $vendor = ControllerVendors::ctrShowVendors($itemVendor, $valueVendor);

                  ?>

                    <!--=====================================
                    =            REFERENCE NO INPUT           =
                    ======================================-->
                  
                    
                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>

                        <input type="text" class="form-control" id="newPurchaseSlip" name="editPurchaseSlip" value="<?php echo $purchase["reference_no"]; ?>" readonly>

                      </div>


                    </div>


                    <!--=====================================
                    =            VENDOR INPUT           =
                    ======================================-->
                  
                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>

                        <select class="form-control" name="selectVendor" id="selectVendor" required>
                          
                            <option value="<?php echo $vendor["id"]; ?>"><?php echo $vendor["name"]; ?></option>

                            <?php 

                            $item = null;
                            $value = null;

                            $vendors = ControllerVendors::ctrShowVendors($item, $value);

                            foreach ($vendors as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
                            }


                            ?>

                        </select>

                        <span class="input-group-addon"><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalAddVendor" data-dismiss="modal">Add Vendor</button></span>

                      </div>

                      <div class="small" id="vendorBalance" style="margin-top:5px; color:#DD4B39;"></div>

                    </div>

                    <!--=====================================
                    =            PRODUCT INPUT           =
                    ======================================-->
                  
                    
                    <div class="form-group row newPurchaseProduct">
                      <?php

                        $tableItems = "purchase_items";
                        $itemPurchase = "purchase_slip_id";
                        $valuePurchase = $purchase["id"];

                        $productList = PurchasesModel::mdlShowPurchaseItems($tableItems, $itemPurchase, $valuePurchase);

                        foreach ($productList as $key => $value) {

                          $item = "id";
                          $valueProduct = $value["product_id"];
                          $order = "id";

                          $answer = ControllerProducts::ctrShowProducts($item, $valueProduct, $order);
                          
                          echo '<div class="row" style="padding:5px 15px">
                    
                                <div class="col-xs-6" style="padding-right:0px">
                    
                                  <div class="input-group">
                        
                                    <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removePurchaseProduct" idProduct="'.$value["product_id"].'"><i class="fa fa-trash"></i></button></span>

                                    <input type="text" class="form-control newPurchaseProductDescription" idProduct="'.$value["product_id"].'" name="addPurchaseProduct" value="'.$answer["description"].'" readonly required>

                                  </div>

                                </div>

                                <div class="col-xs-3">
                      
                                  <input type="number" class="form-control newPurchaseProductQuantity" name="newPurchaseProductQuantity" min="1" value="'.$value["quantity"].'" required>

                                </div>

                                <div class="col-xs-3 enterPrice" style="padding-left:0px">

                                  <div class="input-group">

                                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                           
                                    <input type="text" class="form-control newPurchaseProductPrice" realPrice="'.$answer["buyingPrice"].'" name="newPurchaseProductPrice" value="'.$value["subtotal"].'" readonly required>
           
                                  </div>
                       
                                </div>

                              </div>';
                        }


                        ?>

                    </div>

                    <input type="hidden" name="productsList" id="productsList">

                    <!--=====================================
                    =            ADD PRODUCT BUTTON          =
                    ======================================-->
                    
                    <button type="button" class="btn btn-default hidden-lg btnAddPurchaseProduct">Add Product</button>

                    <hr>
                    <div class="row">

                      <!--=====================================
                        TAXES AND TOTAL INPUT
                      ======================================-->

                      <div class="col-xs-8 pull-right">

                        <table class="table">
                          
                          <thead>
                            
                            <th>Tax %</th>
                            <th>Total</th>

                          </thead>


                          <tbody>
                            
                            <tr>
                              
                              <td style="width: 50%">

                                <div class="input-group">
                                  
                                  <input type="number" class="form-control" name="newTaxPurchase" id="newTaxPurchase" value="<?php echo $purchase["tax_percent"]; ?>" min="0" required>
                                  
                                  <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                                </div>
                              </td>
                              <td style="width: 50%">

                                <div class="input-group">
                                  
                                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  
                                  <?php

                                    $netAmount = $purchase["total_amount"] / (1 + ($purchase["tax_percent"] / 100));

                                  ?>

                                  <input type="number" class="form-control" name="newPurchaseTotal" id="newPurchaseTotal" placeholder="00000" totalPurchase="<?php echo $netAmount; ?>" value="<?php echo $purchase["total_amount"]; ?>" readonly required>

                                  <input type="hidden" name="purchaseTotal" id="purchaseTotal" value="<?php echo $purchase["total_amount"]; ?>" required>

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
                      PAYMENT STATUS
                      ======================================-->

                    <div class="form-group row">
                      
                      <div class="col-xs-6" style="padding-right: 0">

                        <div class="input-group">
                      
                          <span class="input-group-addon"><i class="fa fa-info"></i></span>

                          <select class="form-control" name="paymentStatus" id="paymentStatus" required>
                            
                              <option value="<?php echo $purchase["payment_status"]; ?>"><?php echo $purchase["payment_status"]; ?></option>
                              <option value="Paid">Paid</option>
                              <option value="Unpaid">Unpaid</option>

                          </select>

                        </div>

                      </div>

                      <div class="col-xs-6">

                        <div class="input-group">
                      
                          <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>

                          <select class="form-control" name="paymentMethod" id="paymentMethod" required>
                            
                              <option value="<?php echo $purchase["payment_method"]; ?>"><?php echo $purchase["payment_method"]; ?></option>
                              <option value="Cash">Cash</option>
                              <option value="Online">Online</option>

                          </select>

                        </div>

                      </div>

                    </div>

                    <br>

                    <!--=====================================
                      NOTES
                      ======================================-->

                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        
                        <textarea class="form-control" name="purchaseNotes" id="purchaseNotes" rows="3" placeholder="Optional notes"><?php echo $purchase["notes"]; ?></textarea>

                      </div>

                    </div>
                    
                </div>

            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success pull-right">Save Changes</button>
            </div>
          </form>

          <?php

            $editPurchase = new ControllerPurchases();
            $editPurchase -> ctrEditPurchaseSlip();
            
          ?>

        </div>

      </div>


      <!--=============================================
      =            PRODUCTS TABLE                   =
      =============================================-->


      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
          <div class="box box-default">
            
            <div class="box-header with-border"></div>

            <div class="box-body">
              
              <table class="table table-bordered table-hover table-striped dt-responsive purchasesProductsTable">
                  
                <thead>

                   <tr>
                     
                     <th style="width:10px">#</th>
                     <th>Image</th>
                     <th style="width:30px">Code</th>
                     <th>Description</th>
                     <th>Stock</th>
                     <th>Actions</th>
                   </tr> 

                </thead>

                <tbody>

                  <?php

                    $item = null;
                    $value = null;
                    $order = "id";

                    $products = ControllerProducts::ctrShowProducts($item, $value, $order);

                    foreach ($products as $key => $value) {

                      echo '<tr>

                              <td>'.($key+1).'</td>

                              <td><img src="'.$value["image"].'" class="img-thumbnail" width="40px"></td>

                              <td>'.$value["code"].'</td>

                              <td>'.$value["description"].'</td>

                              <td>'.$value["stock"].'</td>

                              <td><button class="btn btn-primary btn-xs addProductPurchase recoverButton" idProduct="'.$value["id"].'"><i class="fa fa-plus"></i></button></td>

                            </tr>';

                    }

                  ?>

                </tbody>

              </table>

            </div>

          </div>


      </div>

    </div>

  </section>

</div>


<!--=====================================
=            module add Vendor            =
======================================-->

<!-- Modal -->
<div id="modalAddVendor" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" method="POST">
        <div class="modal-header" style="background: #DD4B39; color: #fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Vendor</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">

            <!--Input name -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" name="newVendor" placeholder="Vendor name" required>
              </div>
            </div>

            <!--Input phone -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input class="form-control input-lg" type="text" name="newPhone" placeholder="Phone" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="newAddress" placeholder="Address" required>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save Vendor</button>
        </div>
      </form>

      <?php

        $createVendor = new ControllerVendors();
        $createVendor -> ctrCreateVendor();

      ?>
    </div>

  </div>
</div>

<!--====  End of module add Vendor  ====-->

