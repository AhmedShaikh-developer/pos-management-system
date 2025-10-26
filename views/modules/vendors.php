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

      Vendor Management

    </h1>

    <ol class="breadcrumb">

      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Vendors</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-success" data-toggle="modal" data-target="#addVendor">

        Add Vendor

        </button>

      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover table-striped dt-responsive tables" width="100%">
       
          <thead>
           
           <tr>
             
             <th style="width:10px">#</th>
             <th>Name</th>
             <th>Phone</th>
             <th>Address</th>
             <th>Unpaid Balance</th>
             <th>Created Date</th>
             <th>Actions</th>

           </tr> 

          </thead>

          <tbody>
          
          <?php

            $item = null;
            $value = null;

            $vendors = ControllerVendors::ctrShowVendors($item, $value);

            foreach ($vendors as $key => $value) {

              $balance = ControllerPurchases::ctrGetVendorBalance($value["id"]);

              $balanceAmount = $balance["balance"] ? $balance["balance"] : 0;

              echo '<tr>

                      <td>'.($key+1).'</td>

                      <td>'.$value["name"].'</td>

                      <td>'.$value["phone"].'</td>

                      <td>'.$value["address"].'</td>

                      <td>'.number_format($balanceAmount, 2).'</td>

                      <td>'.$value["created_at"].'</td>

                      <td>

                        <div class="btn-group">
                            
                          <button class="btn btn-primary btnEditVendor" data-toggle="modal" data-target="#modalEditVendor" idVendor="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                          <button class="btn btn-danger btnDeleteVendor" idVendor="'.$value["id"].'"><i class="fa fa-trash"></i></button>

                        </div>  

                      </td>

                    </tr>';
            
              }

          ?>
            
          </tbody>
        </table>

      </div>
    
    </div>

  </section>

</div>

<!--=====================================
MODAL ADD VENDOR
======================================-->

<div id="addVendor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST">

        <!--=====================================
        MODAL HEADER
        ======================================-->

        <div class="modal-header" style="background: #DD4B39; color: #fff">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Add Vendor</h4>

        </div>

        <!--=====================================
        MODAL BODY
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

             <!-- NAME INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" name="newVendor" placeholder="Vendor name" required>
              </div>
            </div>

            <!-- PHONE INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input class="form-control input-lg" type="text" name="newPhone" placeholder="Phone" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
              </div>
            </div>

            <!-- ADDRESS INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="newAddress" placeholder="Address" required>
              </div>
            </div>

          </div>

        </div>

        <!--=====================================
        MODAL FOOTER
        ======================================-->

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


<!--=====================================
MODAL EDIT VENDOR
======================================-->

<div id="modalEditVendor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        MODAL HEADER
        ======================================-->

        <div class="modal-header" style="background:#DD4B39; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Vendor</h4>

        </div>
        <!--=====================================
        MODAL BODY
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- NAME INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="editVendor" id="editVendor" required>
                <input type="hidden" id="idVendor" name="idVendor">
              </div>

            </div>

            <!-- PHONE INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="editPhone" id="editPhone" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

              </div>

            </div>

            <!-- ADDRESS INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="editAddress" id="editAddress"  required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        MODAL FOOTER
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-success">Save Changes</button>

        </div>

      </form>

      <?php

        $editVendor = new ControllerVendors();
        $editVendor -> ctrEditVendor();

      ?>

    

    </div>
  </div>

</div>

<?php

  $deleteVendor = new ControllerVendors();
  $deleteVendor -> ctrDeleteVendor();

?>

