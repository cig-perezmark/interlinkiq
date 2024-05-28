<?php 
    $title = "Dashboard";
    $site = "enterprise_record";

     $breadcrumbs = '';
    $sub_breadcrumbs = 'Enterprise Record';
     include "header.php"; 
     if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

?>
        <!--Start of App Cards-->
        <!-- BEGIN : USER CARDS -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-home"></i>
                            <span class="caption-subject bold uppercase">Dashboard</span>
                        </div>
                    </div>
                 	
                        <!--END SEARCH BAR-->
                        <?php if($_COOKIE['ID'] == 2): ?>
						<div class="row">
							<div class="col-lg-12">
                        		<div class="portlet-title" style="margin-bottom:10px;float:right">
                                	<div class="actions">
                                    	<div class="btn-group">
        	                                <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
            	                                <i class="fa fa-angle-down"></i>
                	                        </a>
                    	                    <ul class="dropdown-menu pull-right">
                        	                    <li>
                        	                        
                                                	<a data-toggle="modal" href="#imageModal"> Add External App</a>
                                                
                                            	</li>
                                            	<li>
                                                	<a data-toggle="modal" href="#"> Add Library</a>
                                            	</li>
                                            	<li class="divider"> </li>
                                            	<li>
        	                                        <a href="javascript:;">Option 2</a>
                                            	</li>
                                            	<li>
        	                                        <a href="javascript:;">Option 3</a>
                                            	</li>
                                            	<li>
                                                	<a href="javascript:;">Option 4</a>
                                            	</li>
                                        	</ul>
                                    	</div>
                                	</div>
                            	</div>
                            </div>
						</div>
        	<?php endif ?>
						<!-- List of apps in tbl_app_store table -->
			<div class="portlet-body">
                <div class="tab-content">
                    <div id="clone" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">   
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                            <th>#</th>
                                            <th>Legal Name</th>
                                            <th>Email</th>
                                            <th>Country</th>
                                            <th></th>
                                            <th>City</th>
                                            <th>States</th>
                                            <th>Zip Code</th>
                                            <th>Enterprise Process</th>
                                    </thead>
                                    <?php
                                    $i = 1;
                                    $query = "SELECT * from tblEnterpiseDetails left join countries on id = country where businessname !='' order by enterp_id desc";
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_array($result)) {?> 
                                    <tbody>
                                         <?php
                                                 $array_busi = explode(", ", $row["BusinessPROCESS"]); 
                                            ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['businessname'];?></td>
                                            <td><?php echo $row['businessemailAddress'];?></td>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo $row['Bldg'];?></td>
                                            <td><?php echo $row['city'];?></td>
                                            <td><?php echo $row['States'];?></td>
                                            <td><?php echo $row['ZipCode'];?></td> 
                                            <td>
                                            	<?php 
                                            	    if(in_array('1', $array_busi)){ echo 'Manufacturing';echo ", ";} else{ echo "";}
                                            	    if(in_array('2', $array_busi)){ echo 'Distribution';echo ", ";} else{ echo "";}
                                            	    if(in_array('3', $array_busi)){ echo 'Co-Packer';echo ", ";} else{ echo "";}
                                            	    if(in_array('4', $array_busi)){ echo 'Co-Manufacturer';echo ", ";} else{ echo "";}
                                            	    if(in_array('5', $array_busi)){ echo 'Retailer';echo ", ";} else{ echo "";}
                                            	    if(in_array('6', $array_busi)){ echo 'Reseller';echo ", ";} else{ echo "";}
                                            	    if(in_array('7', $array_busi)){ echo 'Buyer';echo ", ";} else{ echo "";}
                                            	    if(in_array('8', $array_busi)){ echo 'Seller';echo ", ";} else{ echo "";}
                                            	    if(in_array('9', $array_busi)){ echo 'Broker';echo ", ";} else{ echo "";}
                                            	    if(in_array('10', $array_busi)){ echo 'Packaging';echo ", ";} else{ echo "";}
                                            	    if(in_array('11', $array_busi)){ echo 'Professional Services';echo ", ";} else{ echo "";}
                                            	    if(in_array('12', $array_busi)){ echo 'IT Services';echo ", ";} else{ echo "";}
                                            	    if(in_array('13', $array_busi)){ echo 'Brand Owner';echo ", ";} else{ echo "";}
                                            	    if(in_array('14', $array_busi)){ echo 'Cultivation';echo ", ";} else{ echo "";}
                                            	    if(in_array('15', $array_busi)){ echo 'Others';echo ", ";} else{ echo "";}
                                            	?>
                                            </td>
                                        </tr>
                                    </tbody> 
                                    <?php } ?>      
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
        <!--End of App Cards-->

	</div><!-- END CONTENT BODY -->
</div>

<div class="modal fade bs-modal-lg" id="modalGetContact" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <form action="sales-function/clone-function.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Contact Person</h4>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                        
                        <div class="modal-footer">
                            <input type="submit" name="btnClone" value="Update" class="btn btn-info">       
                         </div>
                    </form>
                </div>
      </div>
 </div>
	<?php include('footer.php'); ?>
    <script>  
    // View  Contact
         $(".btnViewCon").click(function() {
                var id = $(this).data("id");
                $.ajax({    
                    type: "GET",
                    url: "sales-function/fetch-clone-data.php?modalViewApp="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalGetContact .modal-body").html(data);
                       
                    }
                });
            });
		function btnClone(id) {
		    $.ajax({
		        type: "GET",
		        url: "sales-function/clone-function.php?btnClone="+id,
		        dataType: "html",
		        success: function(data){
		            // $("#modalReport .modal-body").html(data);
		            alert(data);
		        }
		    });
		}
</script>

<style>
    .mt_element_card .mt_card_item {
        border: 1px solid;
        border-color: #e7ecf1;
        position: relative;
        margin-bottom: 30px;
    }
    .mt_element_card .mt_card_item .mt_card_avatar {
        margin-bottom: 15px;
    }
    .mt_element_card.mt_card_round .mt_card_item {
        padding: 50px 50px 10px 50px;
    }
    .mt_element_card.mt_card_round .mt_card_item .mt_card_avatar {
        border-radius: 50% !important;
        -webkit-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
    }
    .mt_element_card .mt_card_item .mt_card_content {
        text-align: center;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .mt_element_card .mt_card_item .mt_card_content .mt_card_desc {
        font-size: 14px;
        margin: 0 0 10px 0;
       
    }
    .mt_element_overlay .mt_overlay_1 {
        width: 100%;
        height: 100%;
        float: left;
        overflow: hidden;
        position: relative;
        text-align: center;
        cursor: default;
    }
    .mt_element_overlay .mt_overlay_1 img {
        display: block;
        position: relative;
        -webkit-transition: all .4s linear;
        transition: all .4s linear;
        width: 100%;
        height: auto;
        opacity: 0.5;
    }
 
	</style>
    </body>
</html>