<?php

if($_SESSION["profile"] == "Seller"){

  echo '<script>

    window.location = "home";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Product Management

    </h1>

    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Dashboard</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-success" data-toggle="modal" data-target="#addProduct"> <i class="fa fa-plus"></i> Add Product</button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-hover table-striped dt-responsive productsTable" width="100%">
       
          <thead>
           <tr>
             
             <th style="width:10px">#</th>
             <th>Image</th>
             <th>Code</th>
             <th>Description</th>
             <th>Category</th>
             <th>Stock</th>
             <th>Buying Price</th>
             <th>Selling Price</th>
             <th>Date added</th>
             <th>Actions</th>

           </tr> 

          </thead>

        </table>

        <input type="hidden" value="<?php echo $_SESSION['profile']; ?>" id="hiddenProfile">

      </div>
    
    </div>

  </section>

</div>

<!--=====================================
=            module add Product            =
======================================-->

<!-- Modal -->
<div id="addProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">

        <!--=====================================
        HEADER
        ======================================-->

        <div class="modal-header" style="background: #DD4B39; color: #fff">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Add Product</h4>

        </div>

        <!--=====================================
        BODY
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- input category -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-lg" id="newCategory" name="newCategory">

                  <option value="">Select Category</option>

                   <?php

                    $item = null;
                    $value1 = null;

                    $categories = controllerCategories::ctrShowCategories($item, $value1);

                    foreach ($categories as $key => $value) {
                      
                      echo '<option value="'.$value["id"].'">'.$value["Category"].'</option>';
                    }

                  ?>

                </select>

              </div>

            </div>

            <!--Input Code -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-code"></i></span>

                <input class="form-control input-lg" type="text" id="newCode" name="newCode" placeholder="Add Product Code" required>

              </div>

            </div>

            <!-- input description -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <input class="form-control input-lg" type="text" id="newDescription" name="newDescription" placeholder="Add Description/Product Name" required>

              </div>

            </div>

             <!-- input Stock -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-check"></i></span>

                <input class="form-control input-lg" type="number" id="newStock" name="newStock" placeholder="Add Stock" min="0" required>

              </div>

            </div>

            <!-- INPUT BUYING PRICE -->
            <div class="form-group row">

              <div class="col-xs-12 col-sm-6">

                <div class="input-group"> 

                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                  <input type="number" class="form-control input-lg" id="newBuyingPrice" name="newBuyingPrice" step="any" min="0" placeholder="Buying Price" required>

                </div>

              </div>

              <!-- INPUT SELLING PRICE -->
              <div class="col-xs-12 col-sm-6">  

                <div class="input-group"> 

                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                  <input type="number" class="form-control input-lg" id="newSellingPrice" name="newSellingPrice" step="any" min="0" placeholder="Selling Price" required>

                </div> 

                <br>

                <!-- CHECKBOX PERCENTAGE -->
                <div class="col-xs-6"> 

                  <div class="form-group">   

                    <label>     

                      <input type="checkbox" class="minimal percentage" checked>

                      Use Percentage

                    </label>

                  </div>

                </div>

                <!-- INPUT PERCENTAGE -->
                <div class="col-xs-6" style="padding:0">

                  <div class="input-group"> 

                    <input type="number" class="form-control input-lg newPercentage" min="0" value="40" required>

                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                  </div>

                </div>

              </div>

            </div>

            <!-- input image -->
            <div class="form-group">

              <div class="panel">Upload image</div>

              <input id="newProdPhoto" type="file" class="newImage" name="newProdPhoto">

              <p class="help-block">Maximum size 2Mb</p>

              <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" alt="" width="100px">

            </div> 

          </div>

        </div>

        <!--=====================================
        FOOTER
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-success">Save Product</button>

        </div>

      </form>

      <?php

          $createProduct = new ControllerProducts();
          $createProduct -> ctrCreateProducts();

        ?> 
    </div>

  </div>

</div>

<!--====  End of module add Product  ====-->

<!--=====================================
EDIT PRODUCT
======================================-->

<div id="modalEditProduct" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        HEADER
        ======================================-->

        <div class="modal-header" style="background:#DD4B39; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit product</h4>

        </div>

        <!--=====================================
         BODY
        ======================================-->
        <div class="modal-body">

          <div class="box-body">

            <!-- Select Category -->
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" name="editCategory" readonly required>
                  
                  <option id="editCategory"></option>

                </select>

              </div>

            </div>

            <!-- INPUT FOR THE CODE -->          
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="editCode" name="editCode" readonly required>

              </div>

            </div>

            <!-- INPUT FOR THE DESCRIPTION -->
             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" id="editDescription" name="editDescription" required>

              </div>

            </div>

             <!-- INPUT FOR THE STOCK -->
             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" id="editStock" name="editStock" min="0" required>

              </div>

            </div>

             <!-- INPUT FOR BUYING PRICE -->
             <div class="form-group row">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="editBuyingPrice" name="editBuyingPrice" step="any" min="0" required>

                  </div>

                </div>

                <!-- INPUT FOR SELLING PRICE -->
                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                    <input type="number" class="form-control input-lg" id="editSellingPrice" name="editSellingPrice" step="any" min="0" readonly required>

                  </div>
                
                  <br>

                  <!-- PERCENTAGE CHECKBOX -->
                  <div class="col-xs-6">
                    
                    <div class="form-group">
                      
                      <label>
                        
                        <input type="checkbox" class="minimal percentage" checked>
                        
                        Use Percentage

                      </label>

                    </div>

                  </div>

                  <!-- INPUT FOR PORCENTAJE -->
                  <div class="col-xs-6" style="padding:0">
                    
                    <div class="input-group">
                      
                      <input type="number" class="form-control input-lg newPercentage" min="0" value="40" required>

                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                    </div>

                  </div>

                </div>

            </div>

            <!-- INPUT TO UPLOAD IMAGE -->
             <div class="form-group">
              
              <div class="panel">Upload Image</div>

              <input type="file" class="newImage" name="editImage">

              <p class="help-block">2MB max</p>

              <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" width="100px">

              <input type="hidden" name="currentImage" id="currentImage">

            </div>

          </div>

        </div>

        <!--=====================================
        FOOTER
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-success">Save Changes</button>

        </div>

      </form>

        <?php

          $editProduct = new controllerProducts();
          $editProduct -> ctrEditProduct();

        ?>      

    </div>

  </div>

</div>

<!--=====================================
MODAL PRODUCT IMAGE LIGHTBOX
======================================-->

<div id="productImageModal" class="modal fade" role="dialog" tabindex="-1">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#3C8DBC; color:white; border:none;">

        <button type="button" class="close" data-dismiss="modal" style="color:white; opacity:1;">&times;</button>

        <h4 class="modal-title" id="productModalTitle">Product Details</h4>

      </div>

      <div class="modal-body" style="padding:0; background:#000;">

        <div class="row" style="margin:0;">

          <!-- Image Section -->
          <div class="col-md-7" style="padding:20px; background:#000; text-align:center;">
            
            <img id="productModalImage" src="" alt="Product Image" class="img-responsive" style="max-height:500px; margin:0 auto; transition: transform 0.3s ease;">

          </div>

          <!-- Details Section -->
          <div class="col-md-5" style="padding:20px; background:#fff;">

            <h4 style="margin-top:0; color:#3C8DBC;">Product Information</h4>

            <table class="table table-bordered">
              <tr>
                <td><strong>Product Code:</strong></td>
                <td id="modalProductCode"></td>
              </tr>
              <tr>
                <td><strong>Description:</strong></td>
                <td id="modalProductDescription"></td>
              </tr>
              <tr>
                <td><strong>Category:</strong></td>
                <td id="modalProductCategory"></td>
              </tr>
              <tr>
                <td><strong>Stock:</strong></td>
                <td id="modalProductStock"></td>
              </tr>
              <tr>
                <td><strong>Buying Price:</strong></td>
                <td id="modalProductBuying"></td>
              </tr>
              <tr>
                <td><strong>Selling Price:</strong></td>
                <td id="modalProductSelling"></td>
              </tr>
            </table>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<style>
/* Lightbox Modal Styles */
#productImageModal .modal-dialog {
  margin: 30px auto;
}

#productImageModal .modal-content {
  border-radius: 8px;
  overflow: hidden;
}

#productImageModal .modal-body {
  padding: 0;
}

/* Image Zoom Effect on Hover */
#productModalImage:hover {
  transform: scale(1.05);
  cursor: zoom-in;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  #productImageModal .col-md-7,
  #productImageModal .col-md-5 {
    width: 100%;
  }
  
  #productModalImage {
    max-height: 300px;
  }
}

/* Click outside to close effect */
#productImageModal .modal-dialog {
  pointer-events: none;
}

#productImageModal .modal-content {
  pointer-events: auto;
}

/* Smooth fade-in animation */
#productImageModal.fade .modal-dialog {
  transform: scale(0.9);
  opacity: 0;
  transition: all 0.3s ease-out;
}

#productImageModal.fade.in .modal-dialog {
  transform: scale(1);
  opacity: 1;
}
</style>

<?php

  $deleteProduct = new controllerProducts();
  $deleteProduct -> ctrDeleteProduct();

?>
