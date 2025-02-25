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
											<span class="caption-subject font-green sbold uppercase pageTitleName">Current Inventory</span>
										</div>
										<div class="actions">
											<div class="btn-group">
												<a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions <i class="fa fa-angle-down"></i></a>
												<ul class="dropdown-menu pull-right">
													<li>
                                                    	<a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#productFormModal':'#modalService'; ?>" >Add/Purchase New Material</a>
													</li>
													<li class="divider"> </li>
													<li>
														<a href="#CATEGORIES" data-content-name="Categories Management"> Manage Categories </a>
													</li>
													<li>
														<a href="#INVENTORY" data-content-name="Current Inventory"> Current Inventory </a>
													</li>
													<li>
														<a href="#PURCHASES" data-content-name="Incoming Purchases"> Incoming Purchases </a>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="portlet-body active" data-page-content="INVENTORY">
										<div style="display:flex;justify-content:end;align-items:center;margin-bottom:1rem;">
											<div id="pie_chart_1" class="chart hide"> </div>
											<div style="display: flex; gap: 1rem; align-items: center;">
												<label style="margin: 0;" for="productCategorySort">Category:</label>
												<select id="productCategorySort" class="form-control">
													<option value="0" selected>All</option>
													<?php 
														$categories = $conn->query("SELECT * FROM tbl_inventory_management_categories WHERE user_id = $switch_user_id AND status <> '0'");

														if(mysqli_num_rows($categories) > 0) {
															while($row = $categories->fetch_assoc()) {
													?>
																<option value="<?= $row['id'] ?>"
																	<?= isset($_COOKIE['sort']) && $_COOKIE['sort'] == $row['id'] ? "selected" : "" ?>>
																	<?= $row['category_name'] ?>
																</option>
													<?php
															}
														}
													?>
												</select>
											</div>
										</div>
										<table class="table table-striped table-bordered order-column stocks" id="stocksTable">
											<thead>
												<tr>
													<th> Image </th>
													<th class="hide">Product Code</th>
													<th style="width: 100% !important;"> Item/Product </th>
													<th> SKU </th>
													<th> Last Purchase </th>
													<th> On Hand </th>
													<th> Status </th>
													<?php
														if ($FreeAccess != 1) {
															echo '<th style="min-width: 10rem !important;">Actions</th>';
														}
													?>
												</tr>
											</thead>
											<tbody>
												<?php
													$products = $conn->query("SELECT * FROM `tbl_inventory_management_materials` WHERE user_id = $switch_user_id AND status <> '0' 
													ORDER BY updated_at DESC, inserted_at DESC");

													if(mysqli_num_rows($products) > 0) {
														while($row = $products->fetch_assoc()) {
														// if(isset($_COOKIE['sort'])) {
														//   $productCategories = json_decode($row['categories']);

														//   if($_COOKIE['sort'] != '0' && array_search($_COOKIE['sort'], $productCategories) == false)
														//     continue;
														// }
												?>
													<tr>
														<td class="text-center">
															<img src="<?= $row['image'] != "" ? "uploads/material_img/{$row['image']}" : 'https://via.placeholder.com/100x80/EFEFEF/AAAAAA&amp;text=no+image'?>" class="currentInventoryProductImage" alt="product image">
														</td>
														<td class="hide"> <?= $row['id'] ?> </td>
														<td>
															<span>
																<strong> <?= $row['name'] ?> </strong>
																<p class="font-grey-mint" style="margin: 0; font-size: .95em;"> <?= $row['description'] ?> </p>
															</span>
														</td>
														<td class="text-center"> <?= $row['stockkeeping_unit'] ?> </td>
														<td class="text-center">
															<?php 
																$lastPurchase = $conn->query("SELECT order_date FROM tbl_inventory_management_purchases WHERE material_id = {$row['id']} ORDER BY order_date DESC LIMIT 1");

																if(mysqli_num_rows($lastPurchase) > 0) {
																	echo $lastPurchase->fetch_assoc()['order_date'];
																} else {
																	echo 'none';
																}
															?>
														</td>
														<td class="text-center"> <?= $row['stocks'] ?> </td>
														<td class="text-center">
															<?php 
																$stats = json_decode($conn->query("SELECT status FROM tbl_inventory_management_materials WHERE id = 0")->fetch_assoc()['status']);
																echo $stats[$row['status']];
															?>
														</td>
														<?php
															if ($FreeAccess != 1) {
																echo '<td>
																	<div style="display: flex; justify-content: center;">
																		<div class="btn-group btn-group-circle">
																			<a href="#editProduct" type="button" data-id="'.$row['id'].'" class="btn btn-outline dark btn-sm">View</a>
																			<a href="#deleteProduct" type="button" data-id="'.$row['id'].'" class="btn red btn-sm">Delete</a>
																		</div>
																	</div>
																</td>';
															}
														?>
													</tr>
												<?php
														}
													}
												?>
											</tbody>
										</table>
									</div>
									<div class="portlet-body" data-page-content="CATEGORIES">
										<div style="display:flex;justify-content:end;align-items:center;margin-bottom:1.5rem;">
											<a href="<?php echo $FreeAccess == false ? '#categoryModal':'#modalService'; ?>" class="btn btn-info" data-toggle="modal"><i class="fa fa-plus"></i> Add new category</a>
										</div>
										<div class="table-responsive">
											<table class="table table-bordered" style="margin-bottom: 0 !important;">
												<thead>
													<tr>
														<th style="width: 4rem;">No.</th>
														<th>Category Name</th>
														<th>Products</th>
														<?php
															if ($FreeAccess != 1) {
																echo '<th class="text-center" style="width: 135px">Actions</th>';
															}
														?>
													</tr>
												</thead>
												<tbody>
													<?php 
														$categories = $conn->query("SELECT * FROM tbl_inventory_management_categories 
														WHERE user_id = $switch_user_id AND (NOT status = '0');");

														if(mysqli_num_rows($categories) > 0) {
															$counter = 0;
															while($row = $categories->fetch_assoc()) {
													?>
																<tr>
																	<td><?= ++$counter ?></td>
																	<td>
																		<a href="#viewProductsByCategory" data-category="<?= $row['id'] ?>"><?= $row['category_name'] ?></a>
																	</td>
																	<td>
																		<?php
																			$stockCount = $conn->query("SELECT COUNT(*) as totalProducts FROM tbl_inventory_management_materials WHERE category = '{$row['id']}'");

																			echo $stockCount->fetch_assoc()['totalProducts'];
																		?>
																	</td>
																	<?php
																		if ($FreeAccess != 1) {
																			echo '<td class="text-center">
																				<div class="btn-group btn-group-circle">
																					<a href="#editCategory" type="button" data-id="'.$row['id'].'" class="btn btn-outline dark btn-sm">Edit</a>
																					<a href="#deleteCategory" type="button" data-id="'.$row['id'].'" class="btn red btn-sm">Delete</a>
																				</div>
																			</td>';
																		}
																	?>
																</tr>
													<?php
															}
														}
													?>
												</tbody>
											</table>
											<div class="no-category-wrap">
												<?php
													if(mysqli_num_rows($categories) == 0)
													echo "<div class='no-category'>No category added.</div>";
												?>
											</div>
										</div>
									</div>
									<div class="portlet-body" data-page-content="PURCHASES">
										<div><p>Recent purchases</p></div>
										<table class="table table-bordered stocks" id="purchasesTable">
											<thead>
												<tr>
													<th> Image </th>
													<th> Item </th>
													<th class="hide">material_id</th>
													<th class="hide">sku</th>
													<th class="text-center">Date of Order</th>
													<th class="text-center">Stocks</th>
													<th class="text-center">Total Cost</th>
													<th class="text-center" style="width: 135px;">Mfg. Date</th>
													<th class="text-center" style="width: 135px;">Expiry Date</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT * FROM `tbl_inventory_management_purchases` a LEFT JOIN tbl_inventory_management_materials b ON a.material_id = b.id
													WHERE a.user_id = $switch_user_id AND a.status = 1 ORDER BY a.order_date DESC";

													$products = $conn->query($sql);

													if(mysqli_num_rows($products) > 0) {
														while($row = $products->fetch_assoc()) {
												?>
													<tr>
														<td class="text-center">
															<img src="<?= $row['image'] != "" ? "uploads/material_img/{$row['image']}" : 'https://via.placeholder.com/100x80/EFEFEF/AAAAAA&amp;text=no+image'?>" class="currentInventoryProductImage" alt="product image">
														</td>
														<td>
															<span>
																<strong> <?= $row['name'] ?> </strong>
																<p class="font-grey-mint" style="margin: 0; font-size: .95em;"> <?= $row['description'] ?> </p>
															</span>
														</td>
														<td class="hide"> <?= $row['stockkeeping_unit'] ?> </td>
														<td class="hide"> <?= $row['material_id'] ?> </td>
														<td class="text-center"> <?= $row['order_date'] ?> </td>
														<td class="text-center"> <?= $row['package_quantity'] * $row['qty_per_packet'] ?> </td>
														<td class="text-center"> <?= $row['total_cost'] ?> </td>
														<td class="text-center"> <?= $row['mfg_date'] ?> </td>
														<td class="text-center" style="width: 135px;"> <?= $row['expiry_date'] ?> </td>
													</tr>
												<?php
														}
													}
												?>
											</tbody>
										</table>
									</div>
									<div class="portlet-body" data-page-content="PRODUCTVIEW">
										<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
											<h5 style="font-weight: 700 !important; font-style: italic;">*<span class="productNameHeaderView">Product Name</span></h5>
											<div>
												<span style="margin-right: 1rem;">
													<span class="productNavCurrent">0</span> of <span class="productNavTotal">0</span>
												</span>
												<div class="btn-group" style="border: none;">
													<button type="button" class="btn chevron-btn prevProductBtn"><i class="fa fa-chevron-left"></i></button>
													<button type="button" class="btn chevron-btn nextProductBtn"><i class="fa fa-chevron-right"></i></button>
												</div>
											</div>
										</div>
										<div>
											<form role="form" id="productDetailsForm">
												<div class="form-body">
													<div class="alert alert-danger display-hide">
														<button class="close" data-close="alert"></button>
														Please provide the necessary details of the product.
													</div>
													<div class="alert alert-success display-hide">
														<button class="close" data-close="alert"></button>
														Saved successfuly!
													</div>
													<div class="row">
														<div class="col-md-12">
															<p class="field-title bg-grey">Product Information</p>
														</div>
														<div class="col-md-8">
															<div class="row">
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="detailsOfproductSKU">Stockkeeping Unit (SKU)</label>
																		<input type="text" class="form-control" id="detailsOfproductSKU" name="sku_number" placeholder="Enter SKU ">
																	</div>
																</div>
																<div class="col-sm-6">
																	<div class="form-group">
																		<label for="detailsOfproductCode">Country of Origin</label>
																		<input type="text" class="form-control" id="detailsOfproductCode" name="country" placeholder="Enter country of origin">
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group">
																		<label for="detailsOfproductName">Material Name</label>
																		<input type="text" class="form-control" id="detailsOfproductName" name="material_name" placeholder="Enter product name">
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group">
																		<label for="detailsOfproductDescription">Description</label>
																		<textarea name="description" id="detailsOfproductDescription" rows="3" class="form-control" placeholder="Provide a short description of the material"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group" style="margin-bottom: 0 !important;">
																<label for="detailsOf">Image</label>
																<div class="product-image">
																	<img class="productDetailsImageThumbnail" src="https://via.placeholder.com/280x180/EFEFEF/AAAAAA&amp;text=no+image" class="img-responsive thumbnailx" alt="Image">
																</div>
																<input type="file" accept="image/*" name="product_image" id="detailsOfproductUploadImage" data-view=".productDetailsImageThumbnail">
																<a href="#productUploadImage" data-target-view="#detailsOfproductUploadImage" class="btn btn-link">Upload image</a>
																<a href="#clearProductUploadImage" data-target-view="#detailsOfproductUploadImage" class="btn btn-link">Clear</a>
															</div>
														</div>
														<div class="col-sm-12">
															<div class="form-group">
																<label for="detailsOfproductPreparation">Preparation and/or handling before use</label>
																<textarea name="preparation" id="detailsOfproductPreparation" rows="3" class="form-control" placeholder=""></textarea>
															</div>
														</div>
														<div class="col-md-12">
															<p class="field-title">Inventory Information </p>
														</div>

														<div class="col-sm-4">
															<div class="form-group">
																<label for="productDetailsPackagingMaterial">Packaging Material</label>
																<div>
																	<select name="packaging_material" id="productDetailsPackagingMaterial" class="form-control">
																		<option value="" selected disabled>Select type</option>
																		<?php
																			$pmItems = $conn->query("SELECT packaging_material FROM tbl_inventory_management_materials WHERE id=0");

																			if(mysqli_num_rows($pmItems) > 0) {
																				$pmItems = json_decode($pmItems->fetch_assoc()['packaging_material'], true);

																				foreach($pmItems as $item) {
																					echo "<option value='$item'>$item</option>";
																				}
																			}
																		?>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="productDetailsUnitMeasure">Unit of Measure</label>
																<div>
																	<select name="unit_measure" id="productDetailsUnitMeasure" class="form-control">
																		<option value="" selected disabled>Select unit</option>
																		<?php
																			$umItems = $conn->query("SELECT unit_of_measure FROM tbl_inventory_management_materials WHERE id=0");

																			if(mysqli_num_rows($umItems) > 0) {
																				$umItems = json_decode($umItems->fetch_assoc()['unit_of_measure'], true);

																				foreach($umItems as $key => $items) {
																					echo "<optgroup label='$key'>";
																					foreach($items as $i) {
																						echo "<option value='$i'>$i</option>";
																					}
																					echo "</optgroup>";
																				}
																			}
																		?>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="">Stocks on Hand</label>
																<div>
																	<input type="text" class="form-control" name="stocks_on_hand" placeholder="Total current stocks" readonly>
																</div>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="productDetailsCategoryType">Category/Type</label>
																<div>
																	<select name="category" id="productDetailsCategoryType" class="form-control">
																		<option value="" selected disabled>Select category</option>
																		<?php
																			$categoryItems = $conn->query("SELECT id,category_name FROM tbl_inventory_management_categories WHERE user_id = $switch_user_id AND status=1");

																			if(mysqli_num_rows($categoryItems) > 0) {
																				while($row = $categoryItems->fetch_assoc()) {
																					echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
																				}
																			}
																			else {
																				echo "<option disabled>Please add a category first</option> ";
																			}
																		?>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="detailsOfproductStatus">Product Status</label>
																<select name="product_status" id="detailsOfproductStatus" class="form-control">
																	<option value="" selected disabled>Select product status</option>
																	<?php 
																		$stats = json_decode($conn->query("SELECT status FROM tbl_inventory_management_materials WHERE id = 0")->fetch_assoc()['status']);

																		if(is_array($stats)) {
																			foreach($stats as $key => $value) {
																				if($key > 0)
																				echo "<option value='$key'>$value</option>";
																			}
																		}
																	?>
																</select>
															</div>
														</div>
														<div class="col-md-4"></div>
														<div class="col-md-12"></div>
														<div class="col-md-8">
															<p class="field-title">Manufacturer</p>
															<div class="form-group">
																<label for="detailsOfproductSupplier">Manufacturer</label>
																<input type="text" class="form-control" id="detailsOfproductSupplier" name="manufacturer" placeholder="Enter manufacturer's name">
															</div>
															<div>
																<div style="border-bottom: 1px solid #ddd; margin: 0 0 1rem 0; padding: 0 0 .35rem 0; font-weight: bold !important;">Files</div>
																<ul class="fileRequirementsDisplay"></ul>
															</div>
														</div>
														<div class="col-md-4">
															<p class="field-title">Available Actions</p>
															<div>
																<a href="#purchaseStocksModal" class="btn btn-link"><i class="fa fa-shopping-cart" style="margin-right: 1rem;"></i> Purchase new stock/s</a>
																<a href="#INVENTORY" data-content-name="Current Inventory" class="btn btn-link"><i class="fa fa-dropbox" style="margin-right: 1rem;"></i> Go to current inventory</a>
															</div>
														</div>
														<div class="col-md-12">
															<div style="display: flex; justify-content: end; gap: 1rem;">
																<a href="#deleteProduct" style="justify-self: start;" class="btn btn-danger">Remove from inventory</a>
																<button type="submit" class="btn btn-success">Save changes</button>
															</div>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>


<!-- purchase new stock modal -->
<div class="modal fade in bs-modal" data-submit-action="add" id="purchaseStocksModal" role="meetingMinutesModal"
aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title"><h5><strong><i>*Purchase new stocks of <span class="purchaseMaterialName"></span></i></strong></h5></h4>
	</div>
<div class="modal-body">
<form role="form" class="form-horizontal" id="purchaseForm">
<div class="form-body">
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		Please provide a complete info for your purchase.
	</div>
	<div class="alert alert-success display-hide">
		<button class="close" data-close="alert"></button>
		Saved successfuly!
	</div>
	<input type="hidden" class="hide" name="product_id">
	<div class="form-group">
		<label for="purchaseDate" class="col-sm-3 control-label">Purchase Date <span class="required"> * </span></label>
		<div class="col-sm-8">
			<input type="date" id="purchaseDate" class="form-control" name="purchase_date">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="puchasePKGQuantity">Pkg. Quantity <span class="required"> * </span></label>
		<div class="col-sm-8">
			<input type="number" id="puchasePKGQuantity" class="form-control" step="1" min="1" name="package_quantity" placeholder="Total quantity purchased">
		</div>
	</div>
	<div class="form-group">
		<label for="purchasePackageSize" class="col-sm-3 control-label">Package Size <span class="required"> * </span></label>
		<div class="col-sm-8">
			<input type="number" id="purchasePackageSize" step="1" min="1" class="form-control" name="qty_per_packet" placeholder="Unit per package quantity">
		</div>
	</div>
<div class="form-group">
<label class="col-sm-3 control-label" id="">Cost Per Pack
<span class="required"> * </span>
</label>
<div class="col-sm-8">
<div class="input-group">
<input type="number" class="form-control" step="0.01" name="cost_per_pack" value="0">
<span class="input-group-addon">
<i class="fa fa-dollar"></i>
</span>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="purchaseAmountPaid">Amount Paid
<span class="required"> * </span>
</label>
<div class="col-sm-8">
<div class="input-group">
<input type="number" id="purchaseAmountPaid" class="form-control" step="0.01" name="total_cost"
value="0">
<span class="input-group-addon">
<i class="fa fa-dollar"></i>
</span>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="purchaseDeliveryMethod">Delivery Methods</label>
<div class="col-sm-8">
<input type="text" id="purchaseDeliveryMethod" class="form-control" name="delivery_methods"
placeholder="Provide the delivery method of the stocks">
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="purchaseMFG">Mfg. Date
<span class="required"> * </span>
</label>
<div class="col-sm-8">
<input type="date" id="purchaseMFG" class="form-control" name="mfg_date">
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" for="purchaseExpiryDate">Expiry Date
<span class="required"> * </span>
</label>
<div class="col-sm-8">
<input type="date" id="purchaseExpiryDate" class="form-control" name="expiry_date">
</div>
</div>
</div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<button type="button" onclick="$('#purchaseForm').submit()" class="btn green">
Submit
</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<!-- category modal -->
<div class="modal fade in bs-modal" data-submit-action="add" id="categoryModal" tabindex="-1" role="meetingMinutesModal"
aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Add new category</h4>
</div>
<div class="modal-body">
<form role="form" class="form-horizontal" id="categoryForm">
<div class="form-body">
<div class="alert alert-danger display-hide">
<button class="close" data-close="alert"></button>
Please provide a valid name for this category.
</div>
<div class="alert alert-success display-hide">
<button class="close" data-close="alert"></button>
Saved successfuly!
</div>
<div class="form-group">
<label for="categoryName" class="col-sm-3 control-label">Category Name</label>
<div class="col-sm-8">
<input class="form-control" type="text" name="category_name" id="categoryName"
placeholder="Enter category name">
</div>
</div>
</div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<button type="button" onclick="$('#categoryForm').submit()" class="btn green categorysubmitbtn">
Submit
</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<!-- product modal -->
<div class="modal fade in bs-modal-lg" data-submit-action="add" id="productFormModal" tabindex="-1"
role="meetingMinutesModal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Add/Purchase new material</h4>
</div>
<div class="modal-body">
<form role="form" id="productForm">
<div class="form-body">
<div class="alert alert-danger display-hide">
<button class="close" data-close="alert"></button>
Please provide the necessary details of the material.
</div>
<div class="alert alert-success display-hide">
<button class="close" data-close="alert"></button>
Saved successfuly!
</div>
<div class="row">
<div class="col-md-8">
<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label for="productSKU">
Stockkeeping Unit (SKU) Number
<span class="required" aria-required="true"> * </span>
</label>
<input type="text" class="form-control" id="productSKU" name="sku_number"
placeholder="Enter SKU number">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label for="productCountryOfOrigin">
Country of Origin
<span class="required" aria-required="true"> * </span>
</label>
<input type="text" class="form-control" id="productCountryOfOrigin" name="country"
placeholder="Enter country of origin">
</div>
</div>
<div class="col-sm-12">
<div class="form-group">
<label for="productMaterialName">
Material Name
<span class="required" aria-required="true"> * </span>
</label>
<input type="text" class="form-control" id="productMaterialName" name="material_name"
placeholder="Enter name of the material">
</div>
</div>
<div class="col-sm-12">
<div class="form-group">
<label for="productDescription">Description</label>
<textarea name="description" id="productDescription" rows="3" class="form-control"
placeholder="Provide description of the material"></textarea>
</div>
<div class="form-group">
<label for="productPreparation">Preparation and/or handling before use <span
class="font-grey-cascade">(optional)</span> </label>
<textarea name="preparation" id="productPreparation" rows="2" class="form-control"
placeholder="Preparation and handling info of the item"></textarea>
</div>
<div class="form-group">
<label for="productManufacturer">
Manufacturer
<span class="required" aria-required="true"> * </span>
</label>
<input type="text" class="form-control" id="productManufacturer" name="manufacturer"
placeholder="Manufacturer's name">
</div>
<div>
<div
style="border-bottom: 1px solid #ddd; display: flex; gap: 1rem; align-items:center; padding-bottom: .25rem;">
<p class="bold" style="margin: 0">File requirements</p>
<button type="button" class="btn btn-sm blue" id="addFileRequirementRowBtn">
<i class="fa fa-plus"></i>
</button>
</div>
<div class="fileRequirementRowContainer"></div>
</div>
</div>
</div>
</div>
<div class="col-md-4">
<div class="form-group" style="margin-bottom: 0 !important;">
<label for="">Image</label>
<div class="product-image">
<img class="productImageThumbnail"
src="https://via.placeholder.com/280x200/EFEFEF/AAAAAA&amp;text=no+image"
class="img-responsive thumbnailx" alt="Image">
</div>
<input type="file" accept="image/*" name="product_image" id="productUploadImage"
data-view=".productImageThumbnail">
<a href="#productUploadImage" data-target-view="#productUploadImage" class="btn btn-link">Upload
image</a>
<a href="#clearProductUploadImage" data-target-view="#productUploadImage"
class="btn btn-link">Clear</a>
</div>
<div class="form-group">
<label for="productPackagingMaterial">
Packaging Material
<span class="required" aria-required="true"> * </span>
</label>
<div>
<select name="packaging_material" id="productPackagingMaterial" class="form-control">
<option value="" selected disabled>Select type</option>
<?php
$pmItems = $conn->query("SELECT packaging_material FROM tbl_inventory_management_materials WHERE id=0");

if(mysqli_num_rows($pmItems) > 0) {
$pmItems = json_decode($pmItems->fetch_assoc()['packaging_material'], true);

foreach($pmItems as $item) {
echo "<option value='$item'>$item</option>";
}
}
?>
</select>
</div>
</div>
<div class="form-group">
<label for="productUnitMeasure">
Unit of Measure
<span class="required" aria-required="true"> * </span>
</label>
<div>
<select name="unit_measure" id="productUnitMeasure" class="form-control">
<option value="" selected disabled>Select unit</option>
<?php
$umItems = $conn->query("SELECT unit_of_measure FROM tbl_inventory_management_materials WHERE id=0");

if(mysqli_num_rows($umItems) > 0) {
$umItems = json_decode($umItems->fetch_assoc()['unit_of_measure'], true);

foreach($umItems as $key => $items) {
echo "<optgroup label='$key'>";
foreach($items as $i) {
echo "<option value='$i'>$i</option>";
}
echo "</optgroup>";
}
}
?>
</select>
</div>
</div>
<div class="form-group">
<label for="productCategoryType">
Category/Type
<span class="required" aria-required="true"> * </span>
</label>
<div>
<select name="category" id="productCategoryType" class="form-control">
<option value="" selected disabled>Select category</option>
<?php
$categoryItems = $conn->query("SELECT id,category_name FROM tbl_inventory_management_categories WHERE user_id = $switch_user_id AND status=1");

if(mysqli_num_rows($categoryItems) > 0) {
while($row = $categoryItems->fetch_assoc()) {
echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
}
}
else {
echo "<option disabled>Please add a category first</option> ";
}
?>
</select>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<!-- <button type="button" class="btn btn-warning productSubmitAndPurchaseStocksBtn">
Submit, then proceed to purchase
</button> -->
<button type="button" onclick="$('#productForm').submit()" class="btn green productSubmitButton">
Submit new material
</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

		<?php include_once ('footer.php'); ?>

        <!-- <script type="text/javascript" src="assets/pages/scripts/datatable.js"></script> -->
        <script type="text/javascript" src="assets/pages/scripts/form_validation.js"></script>
        <script type="text/javascript" src="assets/pages/scripts/page_handler.js"></script>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(document).ready(function(){
                $('#stocksTable, #purchasesTable').DataTable();
			});
		</script>
	</body>
</html>
