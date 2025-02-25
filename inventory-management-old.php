<?php 
	$title = "Inventory Management";
	$site = "inventory-management";
	$breadcrumbs = '';
	$sub_breadcrumbs = '';

	if ($sub_breadcrumbs) {
		$breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
	}
	$breadcrumbs .= '<li><span>'. $title .'</span></li>';

	include_once ('header.php'); 
?>

<style type="text/css">
	.product-image {
	  overflow: hidden;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	}

	.product-image img {
	  max-width: 280px;
	  width: auto;
	  height: 200px;
	  object-fit: cover;
	  object-position: center;
	}

	#productUploadImage, 
	#detailsOfproductUploadImage {
	  display: none !important;
	}

	textarea {
	  resize: vertical !important;
	}

	div[data-page-content].active {
	  display: block;
	}

	div[data-page-content] {
	  display: none;
	}

	.no-category {
	  border: 1px solid #e7ecf1;
	  border-top: none;
	  text-align: center;
	  font-size: 14px;
	  padding: 8px;
	  color: #999;
	}

	.no-category-wrap {
	  margin-bottom: 20px;
	}

	.currentInventoryProductImage {
	  width: 80px;
	  height: auto;
	  object-fit: cover;
	  object-position: center;
	}

	.stocks td {
	  vertical-align: middle !important;
	}

	.stocks .text-center {
	  text-align: center;
	}

	.field-title {
	  font-weight: 700 !important;
	  padding: .5rem .75rem;
	  color: #555;
	  background-color:#E5E5E5;
	  margin-top: 1rem !important;
	}

	.chevron-btn {
	  background: transparent;
	}

	.chevron-btn:hover {
	  color: #999;
	}

	.productDetails-q-summary {
	  display: flex;
	  align-items: center;
	  justify-content: space-between;
	  margin-top: .5rem;
	}

	.w-100 {
	  width: 100%;
	}
</style>


<div class="row">
	<div class="col-md-12">
		<div class="portlet light portlet-fit">
			<div class="portlet-title">
				<div class="caption">
					<i class=" icon-social-dropbox font-green"></i>
					<span class="caption-subject font-green sbold uppercase pageTitleName">Inventory</span>
				</div>
				<div class="actions">
					<div class="btn-group">
						<a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions <i class="fa fa-angle-down"></i></a>
						<ul class="dropdown-menu pull-right">
							<li>
                            	<a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#new_purchase_form':'#modalService'; ?>" >Add/Purchase New Material</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="portlet-body">
			      <!--id="stocksTable"-->
			    <table class="table table-bordered">
			        <thead>
			            <tr>
			                <th>Item/Product</th>
			                <th>Supplier</th>
        			        <th>SKU</th>
        			         <th>On-Hand</th>
        			         <th>
        			             Expected
        			             <a class="btn-xs bg-warning" title="Amount of stock that is expected to arrive in the stock.">!</a>
        			         </th>
        			        <th width="120px">Delivery</th>
        			        <th>Status</th>
        			        <th>Action</th>
			            </tr>
			        </thead>
			        <tbody id="supplier_data">
			            <?php 
			                $invty = mysqli_query($conn, "select * from tbl_inventory_management_materials where user_id = $switch_user_id and is_deleted = 0");
			                foreach($invty as $row){?>
        			            <tr id="row_supplier_<?= $row['id']; ?>">
        			                <td>
        			                     <?php 
                	                        $mtrl = $row['name']; 
                	                        $material_qry = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl'");
                	                        foreach($material_qry as $row_raw){?>
                	                            <span>
        											<strong> <?= $row_raw['material_name']; ?> </strong>
        											<p class="font-grey-mint" style="margin: 0; font-size: .95em;"> <?= $row_raw['description']; ?> </p>
        										</span>
                	                       <?php }
                	                    ?>
        			                    
        			                </td>
        			                <td>
        			                    <?php 
                	                        $sppr = $row['manufacturer']; 
                	                        $suppr = mysqli_query($conn, "select * from tbl_supplier where id = '$sppr'");
                	                        foreach($suppr as $row_sup){?>
                	                            <?= $row_sup['name']; ?>
                	                       <?php }
                	                    ?>
        			                </td>
        			                <td>
        			                    <?php 
                	                        $mtrl1 = $row['name']; 
                	                        $material_qry1 = mysqli_query($conn, "select * from tbl_supplier_material where id = '$mtrl1'");
                	                        foreach($material_qry1 as $row_raw1){?>
                	                            <?= $row_raw1['material_id']; ?>
                	                       <?php }
	                                    ?>          
	                                </td>
        			                <td><?= $row['stocks']; ?></td>
	                                <td>
	                                    <?php
                                            $item_pk= $row['id']; 
                                            $qry_stocks = mysqli_query($conn, "select sum(purchase_stocks) as count from tbl_inventory_purchase where item_pk = $item_pk");
                                            if(mysqli_num_rows($qry_stocks) > 0){
                                                foreach($qry_stocks as $row_stock){
                                                    echo $row_stock['count'];
                                                }
                                            }
                                        ?>
	                                </td>
        			                <td>
        			                     <div class="form-group">
        			                         <div class="col-md-12">
            			                         <select id="single-append-radio" class="bs-select form-control get_delivery" data-show-subtext="true" onchange="get_delivery_data(this.value)">
                                                    <option data-icon="fa-square text-default" value="0">Not Recieved</option>
                                                    <option data-icon="fa-square text-warning" value="<?= $row['id']; ?>"> Receive some</option>
                                                    <option data-icon="fa-square text-success" value="rec_<?= $row['id']; ?>">Receive all</option>
                                                </select>
            			                     </div>
        			                     </div>
        			                </td>
        			                <td>
        			                    <?php 
        			                        if($row['status'] == 1){ echo 'Active';} 
        			                     ?>
        			                </td>
        			                <td width="150px">
                                        <div class="btn-group btn-group-circle">
                                            <a  href="#modal_update_inventory" data-toggle="modal" type="button" id="update_inventory" data-id="<?= $row['id']; ?>" class="btn btn-outline dark btn-sm">View</a>
                    	                    <a href="#modal_delete_inventory" data-toggle="modal" type="button" id="delete_inventory" data-id="<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="">Delete</a>
                                        </div>
                                    </td>
        			            </tr>
			                <?php }
			            ?>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
</div>


<!-- purchase new stock modal -->
<div class="modal fade in bs-modal-lg" data-submit-action="add" id="new_purchase_form" tabindex="-1" role="meetingMinutesModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add/Purchase new material</h4>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal modalForm new_purchase_form">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            Please provide the necessary details of the material.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            Saved successfuly!
                        </div>
                         <div class="col-md-12">
                            <div class="form-group">
                                <label for="productManufacturer">
                                    Supplier
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <select id="single-append-radio" class="form-control select2-allow-clear get_supplier" onchange="search_filter(this.value)" name="manufacturer" placeholder="Company Name" required>
                                    <option></option>
                                    <?php
                                       
                                        $queryType = "SELECT * FROM  tbl_supplier WHERE page = 1 AND is_deleted = 0 AND user_id = $switch_user_id ORDER BY name";
                                        $resultType = mysqli_query($conn, $queryType);
                                        while($rowType = mysqli_fetch_array($resultType))
                                        { 
                                           echo '<option value="'.$rowType['ID'].'" >'.$rowType['name'].'</option>'; 
                                        } 
                                     ?>
                                </select>
                            </div>
                        </div>
                          <div class="form-group">
                              <div class="col-md-12">
                                  <label>Order #</label>
                                  <input class="form-control" name="order_no" required>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-md-6">
                                  <label>Expected Arrival</label>
                                  <input class="form-control" type="date" name="expected_arrival" required>
                              </div>
                              <div class="col-md-6">
                                  <label>Created Date</label>
                                  <input class="form-control" type="date" name="created_date" required>
                              </div>
                          </div>
                        <div id="inventory_data">
                              <div class="form-group">
                                  <div class="col-md-12">
                                     <div class="table-scrollable" style="height:29vh;background-color:#EEEEEE;overflow:scroll;">
                                          <table class="table table-bordered">
                                              <thead>
                                                  <tr>
                                                      <th></th>
                                                      <th>Items/Material</th>
                                                      <th>SKU</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>          
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Items/Material</th>
                                            <th rowspan="2">Quantity</th>
                                            <th rowspan="2">UoM</th>
                                            <th colspan="1" width="115px">Price Per Unit</th>
                                            <th colspan="1" width="100px">Total Price</th>
                                        </tr>
                                        <tr>
                                            <th><center><i>USD</i></center></th>
                                            <th><center><i>USD</i></center></th>
                                        </tr>
                                    </thead>
                                    <tbody id="data_table">
                                        
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td style="border:none !important"></td>
                                            <td style="border:none !important"></td>
                                            <td style="border:none !important"></td>
                                            <td style="border:none !important"><b style="float:right;">Total</b></td>
                                            <td style="border:none !important"><b id="Ftotal"></b> USD</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <input class="btn green" type="submit" name="btnAdd_purchase" id="btnAdd_purchase" value="Submit new material" >
            </div>
            </form>
        </div>
    </div>
</div>

<!--Update material-->
<div class="modal fade" id="modal_update_inventory" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_update_inventory">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Product Details</h4>
                </div>
                <div class="modal-body">
                   
                </div>
                <!--<div class="modal-footer">-->
                <!--   <input class="btn btn-info" type="submit" name="btnSave_material" id="btnSave_material" value="Save" >-->
                <!--</div>-->
            </form>
        </div>
    </div>
</div>
<!--delete material-->
<div class="modal fade" id="modal_delete_inventory" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_delete_inventory">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Are You Sure You Want to delete the details below?</h4>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                   <input class="btn btn-warning" type="submit" name="btndelete_material" id="btndelete_material" value="Yes" >
                   <input type="button" class="btn btn-info" data-dismiss="modal" value="No" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade " id="modal_delivery" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_delivery">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                   <input class="btn btn-success" type="submit" name="btnReceive_material" id="btnReceive_material" value="Receive" >
                </div>
            </form>
        </div>
    </div>
</div>
	<?php include_once ('footer.php'); ?>

    <!-- <script type="text/javascript" src="assets/pages/scripts/datatable.js"></script> -->
    <script type="text/javascript" src="assets/pages/scripts/form_validation.js"></script>
    <script type="text/javascript" src="assets/pages/scripts/page_handler.js"></script>
    
    <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
            $('#stocksTable, #purchasesTable').DataTable();
		});
        
		function Calc(value) {
            var index = $(value).parent().parent().index();
            var qty = document.getElementsByClassName("qty_Cal")[index].value;
            var cost_data = document.getElementsByClassName("cost_data")[index].value;
            var amt = qty * cost_data;
            document.getElementsByName("amt")[index].value = amt;
           GetTotal();
        }
        function GetTotal(){
            var sum = 0;
            var amts = document.getElementsByName("amt");
            
            for(let index = 0; index < amts.length; index++)
            {
            	var amt = amts[index].value;
            	sum = +(sum) + +(amt);
            }
            // document.getElementById("Ftotal").html(sum);
            $('#Ftotal').html(sum);
        }
		function search_filter(search_field){
           var search_val = $('.get_supplier').val();
            $.ajax({
                url:'inventory_management_folder/fetch_data.php',
                method: 'POST',
                data: {search_val:search_val,search_field:search_field},
                success:function(data){
                    // alert(data);
                    $('#data_table').empty();  
                    $("#inventory_data").empty();
                    $("#inventory_data").html(data);
                }
            });
         }
         
         function get_data(val){
            if(val.checked == true){
                 $.ajax({  
                    url:"inventory_management_folder/fetch_material.php",  
                    method:"POST",  
                    data:{ val:val.value},  
                    success:function(data){
                        $(".text_"+val.value).css({"color":"green","text-decoration": "line-through"});
                        $('#data_table').append(data);  
                    }  
               }); 
            }
            else{
                $(".text_"+val.value).css({"color":"","text-decoration": "none"});
               $('.data_'+val.value).remove();
            }
            
        }
        
        //new purchase
        $(".new_purchase_form").on('submit',(function(e) {
            e.preventDefault();
            formObj = $(this);
            if (!formObj.validate().form()) return false;
                
            var formData = new FormData(this);
            formData.append('btnAdd_purchase',true);
        
            var l = Ladda.create(document.querySelector('#btnAdd_purchase'));
            l.start();
        
            $.ajax({
                url: "inventory_management_folder/function.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData:false,
                cache: false,
                success: function(response) {
                    if ($.trim(response)) {
                        console.log(response);
                        msg = "Successfully Added!";
                        $('#supplier_data').append(response);
                        $('#new_purchase_form').modal('hide');
                    } else {
                        msg = "Error!"
                    }
                    l.stop();
        
                    bootstrapGrowl(msg);
                }
            });
        }));
        
        //update material
        $(document).on('click', '#update_inventory', function(){
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "inventory_management_folder/function.php?get_material_id="+id,
                dataType: "html",
                success: function(data){
                    $("#modal_update_inventory .modal-body").html(data);
                }
            });
        });
        $(".modal_update_inventory").on('submit',(function(e) {
            e.preventDefault();
             var row_id = $("#row_id").val();
            formObj = $(this);
            if (!formObj.validate().form()) return false;
                
            var formData = new FormData(this);
            formData.append('btnSave_material',true);
        
            var l = Ladda.create(document.querySelector('#btnSave_material'));
            l.start();
        
            $.ajax({
                url: "inventory_management_folder/function.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData:false,
                cache: false,
                success: function(response) {
                    if ($.trim(response)) {
                        msg = "Successfully Save!";
                        $('#row_supplier_'+row_id).empty();
                         $('#row_supplier_'+row_id).append(response);
                         $('#modal_update_inventory').modal('hide');
                    } else {
                        msg = "Error!"
                    }
                    l.stop();
        
                    bootstrapGrowl(msg);
                }
            });
        }));
        //delete material
        $(document).on('click', '#delete_inventory', function(){
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "inventory_management_folder/function.php?delete_material_id="+id,
                dataType: "html",
                success: function(data){
                    $("#modal_delete_inventory .modal-body").html(data);
                }
            });
        });
        $(".modal_delete_inventory").on('submit',(function(e) {
            e.preventDefault();
             var row_id = $("#row_id").val();
            formObj = $(this);
            if (!formObj.validate().form()) return false;
                
            var formData = new FormData(this);
            formData.append('btndelete_material',true);
        
            var l = Ladda.create(document.querySelector('#btndelete_material'));
            l.start();
        
            $.ajax({
                url: "inventory_management_folder/function.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData:false,
                cache: false,
                success: function(response) {
                    if ($.trim(response)) {
                        msg = "Successfully Deleted!!!";
                        $('#row_supplier_'+row_id).empty();
                         $('#modal_delete_inventory').modal('hide');
                    } else {
                        msg = "Error!"
                    }
                    l.stop();
        
                    bootstrapGrowl(msg);
                }
            });
        }));
        
        function get_delivery_data(get_field){
          var get_val = $('.get_delivery').val();
          var receive_all = get_field;
            $.ajax({
                url:'inventory_management_folder/get_delivery.php',
                method: 'POST',
                data: {get_val:get_val,get_field:get_field,receive_all:receive_all},
                success:function(data){
                    if(get_field != 0){
                        $("#modal_delivery .modal-body").html(data);
                        $("#modal_delivery").modal('show');
                    }
                }
            });
      }
      
        $(".modal_delivery").on('submit',(function(e) {
            e.preventDefault();
             var project_id = $("#project_id").val();
            formObj = $(this);
            if (!formObj.validate().form()) return false;
                
            var formData = new FormData(this);
            formData.append('btnReceive_material',true);
        
            var l = Ladda.create(document.querySelector('#btnReceive_material'));
            l.start();
        
            $.ajax({
                url: "inventory_management_folder/function.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData:false,
                cache: false,
                success: function(response) {
                    if ($.trim(response)) {
                        msg = "Sucessfully Save!";
                        $('#row_supplier_'+project_id).empty();
                        $('#row_supplier_'+project_id).append(response);
                        $('#modal_delivery').modal('hide');
                    } else {
                        msg = "Error!"
                    }
                    l.stop();
        
                    bootstrapGrowl(msg);
                }
            });
        }));
	</script>
</body>
</html>
