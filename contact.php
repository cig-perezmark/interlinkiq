<?php 
    $title = "Contact";
    $site = "contact";

    include_once ('head.php');
?>
					
					<form method="post" enctype="multipart/form-data" class="contactForm">
						<div class="row">
							<div class="col-md-4">
								<label class="form-label fw-bold">Name</label>
					            <input class="form-control" type="text" id="name" name="name" required />
							</div>
							<div class="col-md-4">
								<label class="form-label fw-bold">Email Address</label>
					            <input class="form-control" type="email" id="email" name="email" required />
							</div>
							<div class="col-md-4">
								<label class="form-label fw-bold">Contact Number</label>
					            <input class="form-control" type="text" id="contact" name="contact" required />
							</div>
							<div class="col-md-12 mt-3">
								<label class="form-label fw-bold">Messsage</label>
					            <textarea class="form-control" rows="5" id="message" name="message" required></textarea>
								<button type="submit" class="btn btn-primary mt-3" name="btnSend_Contact" id="btnSend_Contact" data-style="zoom-out"><span class="ladda-label">Send</span></button>
							</div>
						</div>
					</form>

		<?php include_once ('foot.php'); ?>

		<script type="text/javascript">
			function btnReset() {
				$('#name').val('');
				$('#email').val('');
				$('#contact').val('');
				$('#message').val('');
			}

			$(".contactForm").on('submit',(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('btnSend_Contact',true);

                var l = Ladda.create(document.querySelector('#btnSend_Contact'));
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
                            msg = "Successfully Sent!";
                            btnReset();
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