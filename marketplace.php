<?php 
    $title = "Marketplace";
    $site = "marketplace";

    include_once ('head.php');
?>
<style type="text/css">
	.imgCover {
	    height: 200px;
		object-fit: cover;
	    object-position: center;
	}
	.imgView {
	    top: 0;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    visibility: hidden;
	}
	.imgSet:hover .imgView {
		visibility: visible;
	}
	.imgName {
		display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
	}
</style>
					
					<div class="row">
						<div class="col-md-3">
				            <div class="mb-3">
								<label class="form-label fw-bold">Search</label>
					            <div class="input-group">
					                <input class="form-control border-end-0 border rounded-pill bg-white" type="search" placeholder="search" id="txtSearchProd">
					                <span class="input-group-append">
					                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button" style="margin-left: -40px;">
					                        <i class="fa fa-search"></i>
					                    </button>
					                </span>
					            </div>
							</div>
				            <div class="mb-3">
								<label class="form-label fw-bold">Filter by Category</label>
					            <select class="form-control form-select" id="multipleSelect2" data-placeholder="Choose anything" multiple onchange="selCategory(this, event)">
									<?php
										$product_cat_arr_data = array();
										$product_cat_arr = array();
										$selectProduCat = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE deleted = 0 GROUP BY category" );
										if ( mysqli_num_rows($selectProduCat) > 0 ) {
		                            		while($rowProdCat = mysqli_fetch_array($selectProduCat)) {
		                            			array_push($product_cat_arr, $rowProdCat['category']);
		                            		}
		                            	}
										$selectProductCategory = mysqli_query( $conn,"SELECT * FROM tbl_products_category ORDER BY name" );
										if ( mysqli_num_rows($selectProductCategory) > 0 ) {
		                            		while($rowProdCategory = mysqli_fetch_array($selectProductCategory)) {
		                            			$cat_ID = $rowProdCategory['ID'];
		                            			$cat_name = $rowProdCategory['name'];

		                            			if (in_array($cat_ID, $product_cat_arr)) {
		                            				array_push($product_cat_arr_data, $cat_name);

		                            				echo '<option value="'.$cat_ID.'">'.$cat_name.'</option>';
		                            			}
		                            		}
		                            	}
									?>
								</select>
								<ul class="d-none" id="JSResult"></ul>
							</div>
							<button type="submit" class="btn btn-primary" onclick="btnReset()">Reset</button>
						</div>
						<div class="col-md-9">
							<div class="row" id="listProduct"></div>
						</div>
					</div>
					<input class="d-none" type="button" onClick="document.getElementById('middle').scrollIntoView();" />

		<?php include_once ('foot.php'); ?>

		<script type="text/javascript">
            $(document).ready(function(){
                listMarketplace(0);
            });

            function selCategory(element, event) {
            	var category = [];
				var result = document.getElementById('JSResult');
				while(result.firstChild) result.removeChild(result.firstChild);
				var values = [];
				for (var i = 0; i < element.options.length; i++) {
					if (element.options[i].selected) {
						var li = document.createElement('li');
						li.appendChild(document.createTextNode(element.options[i].value));
						result.appendChild(li);

						category.push(element.options[i].value);
					}
				}
				category = category.join(", ");
				listMarketplace(category);
			}
			function btnReset() {
				$('#txtSearchProd').val('');
				$("#multipleSelect2").val('').trigger('change')
                listMarketplace(0);
			}
			function listMarketplace(category) {
                $.ajax({
                    type: "GET",
                    url: "function.php?marketplace_view=1",
                    dataType: "html",
                    data: { category: category },
                    success: function(data){
                        $("#listProduct").html(data);
                    }
                });
			}
			
            $("#txtSearchProd").keyup(function() {

				// Retrieve the input field text and reset the count to zero
				var filter = $(this).val(),
				count = 0;

				// Loop through the comment list
				$('.imgSet').each(function() {

					// If the list item does not contain the text phrase fade it out
					if ($(this).text().search(new RegExp(filter, "i")) < 0) {
						$(this).hide();

					// Show the list item if the phrase matches and increase the count by 1
					} else {
						$(this).show();
						count++;
					}
				});
			});
		</script>

	</body>
</html>