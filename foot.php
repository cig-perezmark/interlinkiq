
				</div>
			</section>
		</main><!-- End #main -->

		<!-- ======= Footer ======= -->
		<?php //include_once 'modal.php'; ?>

		<div class="modal fade" id="sendMessage"> 
		    <div class="modal-dialog modal-lg">
		        <div class="modal-content">
		            <form method="post" enctype="multipart/form-data" class="php-email-formx modalMessage">
		                <div class="contact">
		                    <div class="d-flex justify-content-center pb-3 pt-5 text-dark text-uppercase">
		                        <h3 style="font-weight: 550">Send a Message</h3>
		                    </div>
		                    <div class="modal-body"></div>
		                    <div class="modal-footer border-0">
		                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi-x-circle"></i> &nbsp;Close</button>
		                        <button type="submit" class="btn btn-primary ladda-button" name="btnSend_Message" id="btnSend_Message" data-style="zoom-out"><i class="bi-send-check"></i> &nbsp;Send</button>
		                    </div>
		                </div>
		            </form>
		        </div>
		    </div>
		</div>

		<style>
			#sendMessage2 .modal-body .secMessage > div {
				background: #ccc;
				display: table;
				margin-right: auto;
				margin-left: unset;
				border-radius: 10px;
				--bs-bg-opacity: 1;
				background-color: rgba(var(--bs-light-rgb),var(--bs-bg-opacity))!important;
			}

			#sendMessage2 .modal-body .secContainer.secReceiver .secMessage {
				margin-left: 1rem;
			}
			#sendMessage2 .modal-body .secContainer.secSender {
				flex-direction: row-reverse;
			}
			#sendMessage2 .modal-body .secContainer.secSender .secMessage {
				margin-right: 1rem;
			}
			#sendMessage2 .modal-body .secContainer.secSender .secMessage > div {
				margin-right: unset;
				margin-left: auto;
				color: #fff;
				background-color: rgba(var(--bs-primary-rgb),var(--bs-bg-opacity))!important;
			}
		</style>

		<div class="modal fade" id="sendMessage2"> 
		    <div class="modal-dialog modal-lg">
		        <div class="modal-content">
		            <form method="post" enctype="multipart/form-data" class="php-email-formx modalMessage2">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="exampleModalLabel">Chat</h1>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
	                    <div class="modal-body overflow-auto d-flex flex-column-reverse justify-content-endx" style="height: 100vh; max-height: 45vh;"></div>
	                    <div class="modal-footer">
	                    	<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Write message here..." aria-label="Write message here..." aria-describedby="btnSend_Chat" name="message">
								<button class="btn btn-primary" type="submit" id="btnSend_Chat"><i class="bi-send-check me-2"></i>Send</button>
							</div>
	                    </div>
		            </form>
		        </div>
		    </div>
		</div>


		<footer id="footer" class="footer">
			<div class="footer-content position-relative">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<img src="LandingPageFiles/img/iiq logo white.png" alt="" height="60" style="margin:-1.7rem 0 0 -1rem; filter: brightness(0) invert(1);">
							<div class="footer-info">     
								<p>
									Subscribe to our mailing list to get the updates to your email inbox.<br><br>
								</p>
								<div class="input-group mb-3">
									<input type="text" class="form-control" placeholder="E-mail">
									<button class="btn btn-primary" type="button" id="button-addon2">Subscribe</button>
								</div>
								<div class="social-links d-flex mt-3">
									<a href="//www.facebook.com/ConsultareIncConsulting" class="d-flex align-items-center justify-content-center"><i class="bi bi-facebook"></i></a>
									<a href="//twitter.com/consultarei" class="d-flex align-items-center justify-content-center"><i class="bi bi-twitter"></i></a>
									<a href="//www.youtube.com/channel/UCLbjTwJUmtaa25OPqRjIwfA" class="d-flex align-items-center justify-content-center"><i class="bi bi-instagram"></i></a>
									<a href="//ph.linkedin.com/company/consultareinc" class="d-flex align-items-center justify-content-center"><i class="bi bi-linkedin"></i></a>
								</div>
							</div>
						</div><!-- End footer info column-->

						<div class="col-md-3 footer-links">
							<h4>Sites</h4>
							<ul>
								<li><a href="//consultareinc.com/">Consultare Inc. Group</a></li>
								<li><a href="//consultareinc.com/training-ace/">Training Ace</a></li>
								<li><a href="//consultareinc.com/shop/">SOPKing</a></li>
								<li><a href="//itblaster.net/">IT Blaster</a></li>
							</ul>
						</div><!-- End footer links column-->

						<div class="col-md-3 footer-links">
							<h4>Link Categories</h4>
							<ul>
								<li><a href="/">Home</a></li>
								<li><a href="directory">Directory</a></li>
								<li><a href="blog_posts_table">Blog</a></li>
								<li><a href="terms_of_services/Terms%20of%20Service.pdf">Terms of Service</a></li>
							</ul>
						</div><!-- End footer links column-->

						<div class="col-md-3 footer-links">
							<h4>Our Services</h4>
							<ul>
								<li><a href="tel:202-982-3002">202-982-3002</a></li>
								<li><a href="mailto:services@interlinkiq.com">services@interlinkiq.com</a></li>
								<li><a href="javascript:;">Open hours: 8.00-18.00 Mon-Fri</a></li>
							</ul>
						</div><!-- End footer links column-->
					</div>
				</div>
			</div>

			<div class="footer-legal text-center position-relative">
				<div class="container">
					<div class="copyright">&copy; Copyright <strong><span>InterlinkIQ</span></strong> All Rights Reserved</div>
				</div>
			</div>
		</footer>
		<!-- End Footer -->

		<div id="preloader"></div>
		<!-- Vendor JS Files -->
		<script src="assets/specialist/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!--<script src="assets/specialist/vendor/aos/aos.js"></script>-->
		<script src="assets/specialist/vendor/glightbox/js/glightbox.min.js"></script>
		<!-- <script src="assets/specialist/vendor/isotope-layout/isotope.pkgd.min.js"></script> -->
		<script src="assets/specialist/vendor/swiper/swiper-bundle.min.js"></script>
		<script src="assets/specialist/vendor/purecounter/purecounter_vanilla.js"></script>
		<!-- <script src="assets/specialist/vendor/php-email-form/validate.js"></script> -->
		<!--<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

		<script type="text/javascript" src="//cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
		<script src="//cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.umd.js"></script>
		<script src="//cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.thumbs.umd.js"></script>
		
		<script type="text/javascript" src="assets/global/plugins/ladda/spin.min.js"></script>
		<script type="text/javascript" src="assets/global/plugins/ladda/ladda.min.js"></script>

		<script type="text/javascript" src="assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
		<script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		<!-- <script src="../assets/specialist/js/users.js"></script> -->
		<!-- <script src="../assets/specialist/js/count-notif.js"></script> -->

		<!-- Template Main JS File -->
		<script src="../assets/specialist/js/main.js"></script>

		<script>
			// $('#notification-count').on('click', function(e){
			// 	e.preventDefault();
			// 	$.ajax({
			// 		url: 'widget_notification.php',
			// 		success:function(res){
			// 			console.log(res);
			// 		}
			// 	})
			// })
		</script>


        <script type="text/javascript">
        	$(document).ready(function(){
        		$('.selectpicker').selectpicker();
        		
        		var id = '<?php echo !empty($current_userID) ? $current_userID:'0'; ?>';
        		setInterval(function() {
	                $.ajax({
	                    type: "GET",
	                    url: "function.php?modalChat_Refresh="+id,
	                    dataType: "html",
	                    success: function(data){
	                    	var countNotif = $('#notification-count #countNotif');
	                    	var sendMessage2 = $('#sendMessage2').hasClass('show');
	                    	
	                    	if (data > 0) {
		                    	if (countNotif.html() != data) {
	                    			$('#notification-count span').removeClass('d-none');
		                    		countNotif.html(data);
		                    		offCanvasChat(id);

			                    	if (sendMessage2 == true) {
			                    		var to_id = $('#sendMessage2 input[name*="to_id"]').val();
			                    		var from_id = $('#sendMessage2 input[name*="from_id"]').val();
			                    		
			                    		sendChat(to_id, from_id)
			                    	}
		                    	}
	                    	} else {
		                    	if (countNotif.html() != data) {
	                    			$('#notification-count span').addClass('d-none');
		                    		countNotif.html(data);
		                    		offCanvasChat(id);

			                    	if (sendMessage2 == true) {
			                    		var to_id = $('#sendMessage2 input[name*="to_id"]').val();
			                    		var from_id = $('#sendMessage2 input[name*="from_id"]').val();
			                    		
			                    		sendChat(to_id, from_id)
			                    	}
		                    	}
	                    	}
	                    }
	                });
				}, 1000);
        	});
        	
			function offCanvasChat(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalChatBox_Refresh="+id+"&p=2",
                    dataType: "html",
                    success: function(data){
                    	$('#chatbox #userList').html(data);
                    }
                });
			}
        	function sendMessage(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Message="+id,
                    dataType: "html",
                    success: function(data){
                        $("#sendMessage .modal-body").html(data);
                    }
                });
        	}
        	function sendChat(id, id2) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalNew_Chat="+id+"&chat="+id2,
                    dataType: "html",
                    success: function(data){
                        $("#sendMessage2 .modal-body").html(data);
                        $('.modalMessage2').trigger("reset");
                    }
                });
        	}
        	$(".modalMessage").on('submit',(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('btnSend_Message',true);

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                    	var obj = jQuery.parseJSON(response);
                        $('#sendMessage').modal('hide');
                        alert(obj.message);
                    }
                });
            }));
        	$(".modalMessage2").on('submit',(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('btnSend_Chat',true);

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                    	var obj = jQuery.parseJSON(response);
                    	var secContainer = $('#sendMessage2 .modal-body .secContainer').first().hasClass('secSender');

                    	if (secContainer == true) {
                    		$('#sendMessage2 .modal-body .secContainer').first().find('.secMessage').prepend(obj.data_2);
                    	} else {
                    		$('#sendMessage2 .modal-body').prepend(obj.data_1);
                    	}
                        $('.modalMessage2').trigger("reset");
                        offCanvasChat(obj.current_userID);
                    }
                });
            }));

            $("#txtSearch").keyup(function() {

				// Retrieve the input field text and reset the count to zero
				var filter = $(this).val(),
				count = 0;

				// Loop through the comment list
				$('#userList > div .userData').each(function() {

					// If the list item does not contain the text phrase fade it out
					if ($(this).text().search(new RegExp(filter, "i")) < 0) {
						$(this).parent().parent().hide();

					// Show the list item if the phrase matches and increase the count by 1
					} else {
						$(this).parent().parent().show();
						count++;
					}
				});
			});
            $("#txtSearch2").keyup(function() {

				// Retrieve the input field text and reset the count to zero
				var filter = $(this).val(),
				count = 0;

				// Loop through the comment list
				$('.service-item').each(function() {

					// If the list item does not contain the text phrase fade it out
					if ($(this).text().search(new RegExp(filter, "i")) < 0) {
						$(this).parent().hide();

					// Show the list item if the phrase matches and increase the count by 1
					} else {
						$(this).parent().show();
						count++;
					}
				});
			});

			$("#multipleSelect2").select2({
			    theme: "bootstrap-5",
			    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
			    placeholder: $( this ).data( 'placeholder' ),
			    closeOnSelect: false,
			});
        </script>