<?php

if($_SESSION["profile"] == "Special"){

  echo '<script>

    window.location = "home";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Customer management

    </h1>

    <ol class="breadcrumb">

      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Dashboard</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-success" data-toggle="modal" data-target="#addCustomer">

        Add Customer

        </button>

      </div>
      <div class="box-body">
        <table class="table table-bordered table-hover table-striped dt-responsive tables" width="100%">
       
          <thead>
           
           <tr>
             
             <th style="width:10px">#</th>
             <th>Name</th>
             <th>I.D Doc.</th>
             <th>Email</th>
             <th>Contact</th>
             <th>Address</th>
             <th>Birthday</th>
             <th>Total Purchases</th>
             <th>Last Purchase</th>
             <th>Last login</th>
             <th>Actions</th>

           </tr> 

          </thead>

          <tbody>
          
          <?php

            $item = null;
            $valor = null;

            $Customers = controllerCustomers::ctrShowCustomers($item, $valor);

            foreach ($Customers as $key => $value) {
              
              // Check for customer alerts (warnings/reminders/info)
              $alerts = ControllerCustomerNotes::ctrCheckCustomerAlerts($value["id"]);
              $badgeHtml = '';
              
              if($alerts["has_warning"]){
                $badgeHtml .= ' <span class="label label-danger" title="Has Warning"><i class="fa fa-exclamation-triangle"></i></span>';
              }
              if($alerts["has_reminder"]){
                $badgeHtml .= ' <span class="label label-warning" title="Has Reminder"><i class="fa fa-bell"></i></span>';
              }
              if($alerts["has_info"]){
                $badgeHtml .= ' <span class="label label-success" title="Has Info"><i class="fa fa-info-circle"></i></span>';
              }

              echo '<tr>

                      <td>'.($key+1).'</td>

                      <td>'.$value["name"].$badgeHtml.'</td>

                      <td>'.$value["idDocument"].'</td>

                      <td>'.$value["email"].'</td>

                      <td>'.$value["phone"].'</td>

                      <td>'.$value["address"].'</td>

                      <td>'.$value["birthdate"].'</td>             

                      <td>'.$value["purchases"].'</td>

                      <td>'.$value["lastPurchase"].'</td>

                      <td>'.$value["registerDate"].'</td>

                      <td>

                        <div class="btn-group">
                            
                          <button class="btn btn-info btnViewNotes" customerId="'.$value["id"].'" customerName="'.$value["name"].'" data-toggle="modal" data-target="#modalCustomerNotes"><i class="fa fa-sticky-note"></i></button>
                          
                          <button class="btn btn-primary btnEditCustomer" data-toggle="modal" data-target="#modalEditCustomer" idCustomer="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                          <button class="btn btn-danger btnDeleteCustomer" idCustomer="'.$value["id"].'"><i class="fa fa-trash"></i></button>

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
MODAL ADD CUSTOMER
======================================-->

<div id="addCustomer" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST">

        <!--=====================================
        MODAL HEADER
        ======================================-->

        <div class="modal-header" style="background: #DD4B39; color: #fff">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Add Customer</h4>

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
                <input class="form-control input-lg" type="text" name="newCustomer" placeholder="Write name" required>
              </div>
            </div>

            <!-- I.D DOCUMENT INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input class="form-control input-lg" type="number" min="0" name="newIdDocument" placeholder="Write your ID" required>
              </div>
            </div>

            <!-- EMAIL INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input class="form-control input-lg" type="text" name="newEmail" placeholder="Email" required>
              </div>
            </div>

            <!-- PHONE INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input class="form-control input-lg" type="text" name="newPhone" placeholder="phone" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
              </div>
            </div>

            <!-- ADDRESS INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="newAddress" placeholder="Address" required>
              </div>
            </div>


             <!-- BIRTH DATE INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control input-lg" type="text" name="newBirthdate" placeholder="Birth Date" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>
              </div>
            </div>

          </div>

        </div>

        <!--=====================================
        MODAL FOOTER
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save Customer</button>
        </div>
      </form>

      <?php

        $createCustomer = new ControllerCustomers();
        $createCustomer -> ctrCreateCustomer();

      ?>
    </div>

  </div>

</div>


<!--=====================================
MODAL EDIT CUSTOMER
======================================-->

<div id="modalEditCustomer" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        MODAL HEADER
        ======================================-->

        <div class="modal-header" style="background:#DD4B39; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Customer</h4>

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

                <input type="text" class="form-control input-lg" name="editCustomer" id="editCustomer" required>
                <input type="hidden" id="idCustomer" name="idCustomer">
              </div>

            </div>

            <!-- I.D DOCUMENT INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="editIdDocument" id="editIdDocument" required>

              </div>

            </div>

            <!-- EMAIL INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="editEmail" id="editEmail" required>

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

            <!-- BIRTH DATE INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control input-lg" name="editBirthdate" id="editBirthdate"  data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

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

        $EditCustomer = new ControllerCustomers();
        $EditCustomer -> ctrEditCustomer();

      ?>

    

    </div>
  </div>

</div>

<!--=====================================
MODAL CUSTOMER NOTES
======================================-->

<div id="modalCustomerNotes" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#3C8DBC; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Customer Notes - <span id="customerNotesName"></span></h4>

      </div>

      <div class="modal-body">

        <div class="box-body">

          <input type="hidden" id="noteCustomerId">

          <!-- Add New Note Button -->
          <button type="button" class="btn btn-success btn-sm pull-right" id="btnAddNote" style="margin-bottom: 15px;">
            <i class="fa fa-plus"></i> Add Note
          </button>

          <div class="clearfix"></div>

          <!-- Add Note Form (Hidden by default) -->
          <div id="addNoteForm" style="display:none; margin-bottom:20px;">
            <form role="form" method="POST">
              <input type="hidden" name="customerId" id="addNoteCustomerId">
              
              <div class="form-group">
                <label>Note Type:</label>
                <select class="form-control" name="noteType" id="addNoteType" required>
                  <option value="info">🟢 Info</option>
                  <option value="reminder">🟡 Reminder</option>
                  <option value="warning">🔴 Warning</option>
                </select>
              </div>

              <div class="form-group">
                <label>Note Text:</label>
                <textarea class="form-control" name="noteText" id="addNoteText" rows="3" required></textarea>
              </div>

              <button type="submit" name="addCustomerNote" class="btn btn-success">Save Note</button>
              <button type="button" class="btn btn-default" id="btnCancelNote">Cancel</button>
            </form>

            <?php
              $addNote = new ControllerCustomerNotes();
              $addNote -> ctrAddCustomerNote();
            ?>
          </div>

          <!-- Edit Note Form (Hidden by default) -->
          <div id="editNoteForm" style="display:none; margin-bottom:20px;">
            <form role="form" method="POST">
              <input type="hidden" name="noteId" id="editNoteId">
              
              <div class="form-group">
                <label>Note Type:</label>
                <select class="form-control" name="noteType" id="editNoteType" required>
                  <option value="info">🟢 Info</option>
                  <option value="reminder">🟡 Reminder</option>
                  <option value="warning">🔴 Warning</option>
                </select>
              </div>

              <div class="form-group">
                <label>Note Text:</label>
                <textarea class="form-control" name="noteText" id="editNoteText" rows="3" required></textarea>
              </div>

              <button type="submit" name="editCustomerNote" class="btn btn-primary">Update Note</button>
              <button type="button" class="btn btn-default" id="btnCancelEdit">Cancel</button>
            </form>

            <?php
              $editNote = new ControllerCustomerNotes();
              $editNote -> ctrEditCustomerNote();
            ?>
          </div>

          <hr>

          <!-- Notes List -->
          <div id="notesListContainer">
            <table class="table table-bordered" id="notesTable">
              <thead>
                <tr>
                  <th width="80px">Type</th>
                  <th>Note</th>
                  <th width="120px">Created By</th>
                  <th width="150px">Date</th>
                  <th width="100px">Actions</th>
                </tr>
              </thead>
              <tbody id="notesTableBody">
                <!-- Notes will be loaded here via AJAX -->
              </tbody>
            </table>
          </div>

        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>

</div>

<?php

  $deleteCustomer = new ControllerCustomers();
  $deleteCustomer -> ctrDeleteCustomer();

  $deleteNote = new ControllerCustomerNotes();
  $deleteNote -> ctrDeleteCustomerNote();

?>

<script>
// Pass session profile to JavaScript
var userProfile = "<?php echo $_SESSION['profile']; ?>";
</script>