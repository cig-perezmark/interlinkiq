<?php 
    $title = "Marketplace";
    $site = "marketplace";

    include_once ('head.php');
?>
<style type="text/css">
	.imgCover {
	    height: 100vh;
    	max-height: 500px;
		object-fit: contain;
	    object-position: center;
	}
	#myCarousel {
		max-width: 640px;
		margin: 0 auto;
	}
	#myCarousel .f-carousel__slide {
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.star-rating {
		font-size: 0;
		white-space: nowrap;
		display: inline-block;
		/* width: 250px; remove this */
		height: 25px;
		overflow: hidden;
		position: relative;
		background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjREREREREIiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
		background-size: contain;
		}
	.star-rating i {
		opacity: 0;
		position: absolute;
		left: 0;
		top: 0;
		height: 100%;
		/* width: 20%; remove this */
		z-index: 1;
		background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjRkZERjg4IiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
		background-size: contain;
	}
	.star-rating input {
		-moz-appearance: none;
		-webkit-appearance: none;
		opacity: 0;
		display: inline-block;
		/* width: 20%; remove this */
		height: 100%;
		margin: 0;
		padding: 0;
		z-index: 2;
		position: relative;
	}
	.star-rating input[name="rating"]:hover + i,
	.star-rating input:checked + i {
		opacity: 1;
	}
	.star-rating i ~ i {
		width: 40%;
	}
	.star-rating i ~ i ~ i {
		width: 60%;
	}
	.star-rating i ~ i ~ i ~ i {
		width: 80%;
	}
	.star-rating i ~ i ~ i ~ i ~ i {
		width: 100%;
	}

	.star-rating.star-5 {width: 125px;}
	.star-rating.star-5 input,
	.star-rating.star-5 i {width: 20%;}
	.star-rating.star-5 i ~ i {width: 40%;}
	.star-rating.star-5 i ~ i ~ i {width: 60%;}
	.star-rating.star-5 i ~ i ~ i ~ i {width: 80%;}
	.star-rating.star-5 i ~ i ~ i ~ i ~i {width: 100%;}

	li .star-rating { height:20px; }
	li .star-rating.star-5 { width:100px; }
</style>
					
					<div class="row">
						<div class="col-md-9">
							<div class="bg-white rounded p-3 mb-3">
								<?php
									$ID = $_GET['ID'];
									$selectProd = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE deleted = 0 AND ID = $ID" );
		                            if ( mysqli_num_rows($selectProd) > 0 ) {
		                            	$rowProd = mysqli_fetch_array($selectProd);
	                            		$data_ID = $rowProd['ID'];
	                            		$data_name = $rowProd['name'];
	                            		$data_description = $rowProd['description'];
	                            		$data_code = $rowProd['code'];
	                            		$data_shelf = $rowProd['shelf'];
	                            		$data_countries = $rowProd['countries'];
	                            		$data_allergen = $rowProd['allergen'];
	                            		$data_storage = $rowProd['storage'];
	                            		$data_material = $rowProd['material'];
	                            		$data_packaging_1 = $rowProd['packaging_1'];
	                            		$data_packaging_2 = $rowProd['packaging_2'];
	                            		$data_packaging_3 = $rowProd['packaging_3'];

	                            		$data_intended = '';
	                            		$data_intended_id = $rowProd['intended'];
	                            		if ($rowProd['intended'] > 0) {
	                            			$selectIntended = mysqli_query( $conn,"SELECT * FROM tbl_products_intended WHERE ID = $data_intended_id" );
                                    		if ( mysqli_num_rows($selectIntended) > 0 ) {
                                    			$rowIntended = mysqli_fetch_array($selectIntended);
                                    			$data_intended = $rowIntended["name"];
                                    		}
	                            		}

	                            		$claims_array = explode(", ", $rowProd["claims"]);
	                            		$data_claims = '';
	                            		$data_claims_array = array();
	                                    $selectClaims = mysqli_query( $conn,"SELECT * FROM tbl_products_claims WHERE deleted = 0 ORDER BY name" );
	                                    if ( mysqli_num_rows($selectClaims) > 0 ) {
	                                        while($rowClaims = mysqli_fetch_array($selectClaims)) {
	                                            $claims_ID = $rowClaims["ID"];
	                                            $claims_name = $rowClaims["name"];

	                                            if (in_array($claims_ID, $claims_array)) {
	                                            	array_push($data_claims_array, $claims_name);
	                                            }
	                                        }

	                                        $data_claims = implode(', ', $data_claims_array);
	                                    }

	                            		$data_category_text = '';
	                            		$data_category = $rowProd['category'];
	                            		if (!empty($data_category)) {
	                            			if ($data_category == 9) {
	                            				$data_category_text = $rowProd['category_other'];
	                            			} else {
			                            		$selectProductCategory = mysqli_query( $conn,"SELECT * FROM tbl_products_category WHERE ID = $data_category" );
				                            	if ( mysqli_num_rows($selectProductCategory) > 0 ) {
				                            		$rowProdCat = mysqli_fetch_array($selectProductCategory);
				                            		$data_category_text = $rowProdCat['name'];
				                            	}
	                            			}
	                            		}

	                            		$data_allergen_text = '';
	                            		$data_allergen_text_arr = array();
	                            		$data_allergen_text_array = array(
										    1 => 'Milk',
										    2 => 'Egg',
										    3 => 'Fish (e.g., bass, flounder, cod)',
										    4 => 'Crustacean shellfish (e.g., crab, lobster, shrimp)',
										    5 => 'Tree nuts (e.g., almonds, walnuts, peca',
										    6 => 'Peanuts',
										    7 => 'Wheat',
										    8 => 'Soybeans',
										    9 => 'Sesame',
										    10 => 'None',
										    11 => 'Other'
	                            		);
	                            		$data_allergen = $rowProd['allergen'];
	                            		if (!empty($data_allergen)) {
	                            			$data_allergen_arr = explode(', ', $data_allergen);
	                            			foreach ($data_allergen_arr as $value) {
	                            				array_push($data_allergen_text_arr, $data_allergen_text_array[$value]);
	                            			}
	                            			$data_allergen_text = implode(', ', $data_allergen_text_arr);
	                            		}

	                            		$user_mobile = '';
	                            		$user_website = '';
	                            		$user_avatar = '';
	                            		$data_user_id = $rowProd['user_id'];
	                            		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $data_user_id" );
										if ( mysqli_num_rows($selectUser) > 0 ) {
											$rowUser = mysqli_fetch_array($selectUser);
											$user_fullname = $rowUser['first_name'] .' '. $rowUser['last_name'];
											$user_email = $rowUser['email'];
										}
	                            		$selectUserInfo = mysqli_query( $conn,"SELECT * FROM tbl_user_info WHERE user_id = $data_user_id" );
										if ( mysqli_num_rows($selectUserInfo) > 0 ) {
											$rowUserInfo = mysqli_fetch_array($selectUserInfo);
											$user_mobile = $rowUserInfo['mobile'];
											$user_website = $rowUserInfo['website'];
											$user_avatar = $rowUserInfo['avatar'];
										}

										echo '<div class="row">
											<div class="col-md-2">
												<img src="'.$base_url.'uploads/avatar/'.$user_avatar.'"  class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; object-position: center;" onerror="this.onerror=null;this.src=\'https://via.placeholder.com/150x150/EFEFEF/AAAAAA.png?text=no+image\';" />
											</div>
											<div class="col-md-6">
												<span class="fw-bold">'.$user_fullname.'</span><br>
												<span>'.$user_mobile.'</span><br>
												<a href="mailto:'.$user_email.'" target="_blank">'.$user_email.'</a>';

												if (!empty($user_website)) {
													echo '<br><a href="'.$user_website.'" target="_blank">'.$user_website.'</a>';
												}
												
											echo '</div>
											<div class="col-md-2 d-none">
												98% <span class="text-success">High</span><br>
												Seller rate
											</div>
											<div class="col-md-2 d-none">
												23% <span class="text-danger">Low</span><br>
												Customer Service
											</div>
										</div>';

	                            		$data_image = $rowProd['image'];
	                            		$image_counter = 0;
	                            		if (!empty($data_image)) {
	                            			$data_image_array = explode(", ", $data_image);
	                            			echo '<div class="f-carousel mt-3" id="myCarousel">';
		                            			foreach($data_image_array as $value) {
		                            				if (!empty($value)) {
		                            					echo '<div class="f-carousel__slide" data-thumb-src="'.$base_url.'uploads/products/'.$value.'" >
												        	<img href="'.$base_url.'uploads/products/'.$value.'" data-lazy-src="'.$base_url.'uploads/products/'.$value.'" data-fancybox="gallery" alt="" class="imgCover" />
												        </div>';
		                            				}
		                            			}
	                            			echo '</div>';
	                            		}
	                            	}
		                        ?>
							</div>

							<p class="fw-bold mb-0">Rate this product</p>
							<small class="text-muted">Your review might help the seller to become more productive in the marketplace</small>
							<form method="post" enctype="multipart/form-data" class="modalForm formReview">
								<div class="mb-3">
									<span class="star-rating star-5">
										<input type="radio" name="rating" value="1" required><i></i>
										<input type="radio" name="rating" value="2" required><i></i>
										<input type="radio" name="rating" value="3" required><i></i>
										<input type="radio" name="rating" value="4" required><i></i>
										<input type="radio" name="rating" value="5" required><i></i>
									</span>
									<input type="hidden" name="ID" value="<?php echo $ID; ?>" />
									<textarea class="form-control" name="comment" rows="3" required></textarea>
								</div>
								<?php
									if (isset($_COOKIE['ID'])) {
										echo '<button type="submit" class="btn btn-primary mb-3 ladda-button" name="btnMarket_Review" id="btnMarket_Review" data-style="zoom-out"><span class="ladda-label">Submit Review</span></button>';
									} else {
										echo '<a href="login" class="btn btn-primary mb-3 ladda-button">Submit Review</a>';
									}
								?>
							</form>
							<hr>
							<ol class="list-group list-group-numbered mt-4" id="listReview">
								<?php
									$selectProdReview = mysqli_query( $conn,"SELECT * FROM tbl_products_review WHERE reply_to = 0 AND deleted = 0 AND product_id = $ID" );
									if ( mysqli_num_rows($selectProdReview) > 0 ) {
										while($rowProdReview = mysqli_fetch_array($selectProdReview)) {
											$review_ID = $rowProdReview['ID'];
											$review_rating = $rowProdReview['rating'];
											$review_comment = stripcslashes($rowProdReview['comment']);

											$review_last_modified = $rowProdReview['last_modified'];
								            $review_last_modified = new DateTime($review_last_modified);
								            $review_last_modified = $review_last_modified->format('M d, Y');

											$review_user = 'Annonymous';
											$review_user_id  = $rowProdReview['user_id'];
											if ($review_user_id > 0) {
												$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE ID = $review_user_id" );
												if ( mysqli_num_rows($selectUser) > 0 ) {
													$rowUser = mysqli_fetch_array($selectUser);
													$review_user = $rowUser['first_name'] .' '. $rowUser['last_name'][0] .'.';
												}
											}

											echo '<li class="list-group-item d-flex justify-content-between align-items-start" id="li_'.$review_ID.'">
												<div class="ms-2 me-auto">
													<div class="fw-bold">'.$review_user.'</div>
													<span class="star-rating star-5">
														<input type="radio" name="rating_'.$review_ID.'" value="1" disabled '; echo $review_rating == 1 ? 'checked':''; echo '><i></i>
														<input type="radio" name="rating_'.$review_ID.'" value="2" disabled '; echo $review_rating == 2 ? 'checked':''; echo '><i></i>
														<input type="radio" name="rating_'.$review_ID.'" value="3" disabled '; echo $review_rating == 3 ? 'checked':''; echo '><i></i>
														<input type="radio" name="rating_'.$review_ID.'" value="4" disabled '; echo $review_rating == 4 ? 'checked':''; echo '><i></i>
														<input type="radio" name="rating_'.$review_ID.'" value="5" disabled '; echo $review_rating == 5 ? 'checked':''; echo '><i></i>
													</span><br>
													'.stripcslashes($review_comment).'
												</div>
												<div class="text-end">
													<small class="fw-lighter text-muted">'.$review_last_modified.'</small><br>
													<span class="btn badge btn-primary rounded-pill '; echo isset($_COOKIE['ID']) ? '':'d-none'; echo '" onclick="btnReviewReply('.$review_ID.')">Reply</span>
												</div>
											</li>';
										}
									}

								?>
							</ol>
						</div>
						<div class="col-md-3">
							<div class="bg-white rounded p-3">
								<?php
									echo '<h4>Product Details</h4>
									<small class="form-label fw-bold text-muted">Product Name</small>
						            <p>'.$data_name.'</p>

									<small class="form-label fw-bold text-muted">Description</small>
						           	<p>'.$data_description.'</p>';

						            if (!empty($data_code)) {
						            	echo '<small class="form-label fw-bold text-muted">Product Code</small>
						            	<p>'.$data_code.'</p>';
						            }

						            if (!empty($data_shelf)) {
						            	echo '<small class="form-label fw-bold text-muted">Shelf Life</small>
						            	<p>'.$data_shelf.'</p>';
						            }

						            if (!empty($data_category_text)) {
						            	echo '<small class="form-label fw-bold text-muted">Category</small>
						            	<p>'.$data_category_text.'</p>';
						            }

						            if (!empty($data_countries)) {
						            	echo '<small class="form-label fw-bold text-muted">Country</small>
						            	<p>'.$data_countries.'</p>';
						            }

						            if (!empty($data_allergen_text)) {
						            	echo '<small class="form-label fw-bold text-muted">Allergen</small>
						            	<p>'.$data_allergen_text.'</p>';
						            }

						            if (!empty($data_storage)) {
						            	echo '<small class="form-label fw-bold text-muted">Storage and Handling</small>
						            	<p>'.$data_storage.'</p>';
						            }

						            if (!empty($data_packaging_1)) {
						            	echo '<small class="form-label fw-bold text-muted">Primary/Unit</small>
						            	<p>'.$data_packaging_1.'</p>';
						            }

						            if (!empty($data_packaging_2)) {
						            	echo '<small class="form-label fw-bold text-muted">Secondary/Case</small>
						            	<p>'.$data_packaging_2.'</p>';
						            }

						            if (!empty($data_packaging_3)) {
						            	echo '<small class="form-label fw-bold text-muted">Tertiary/Master Pack</small>
						            	<p>'.$data_packaging_3.'</p>';
						            }

						            if (!empty($data_intended)) {
						            	echo '<small class="form-label fw-bold text-muted">Intended Use</small>
						            	<p>'.$data_intended.'</p>';
						            }

						            if (!empty($data_claims)) {
						            	echo '<small class="form-label fw-bold text-muted">Tertiary/Master Pack</small>
						            	<p>'.$data_claims.'</p>';
						            }
								?>
							</div>
						</div>
					</div>
					<input class="d-none" type="button" onClick="document.getElementById('middle').scrollIntoView();" />

		<?php include_once ('foot.php'); ?>

		<script>
			const container = document.getElementById("myCarousel");
			const options = { Dots: false };
			new Carousel(container, options, { Thumbs });

            $(".formReview").on('submit',(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('btnMarket_Review',true);

                var l = Ladda.create(document.querySelector('#btnMarket_Review'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            // msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            $('#listReview').append(obj.data);
                        } else {
                            // msg = "Error!"
                        }
                        l.stop();

                        // bootstrapGrowl(msg);
                    }        
                });
            }));
		</script>
	</body>
</html>
