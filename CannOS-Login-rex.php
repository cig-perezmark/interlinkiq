<?php include_once 'database_iiq.php'; ?>
<?php
    echo '<script>
        window.location.href = "/login";
    </script>';
	if(isset($_COOKIE['ID'])) {
		// $url='profile';
		// $url=$_SERVER['HTTP_REFERER'];
		// // echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$url.'">';
		// // header('Location: profile');
		
        // echo '<script>
        // 	prev_link = document.referrer;
        //     if (prev_link == "") {
        //         window.location.href = "profile";
        //     } else {
        //         window.history.back();
        //     }
        // </script>';
        
        echo '<script>
            prev_link = document.referrer;
            if (prev_link == "") {
                window.location.href = "profile";
            } else if (prev_link.indexOf("management_services") > -1) {
                window.location.href = "profile";
            } else if (prev_link.indexOf("directory") > -1) {
                window.location.href = "profile";
            } else if (prev_link.indexOf("blog_posts_table") > -1) {
                window.location.href = "profile";
            } else if (prev_link.indexOf("forum") > -1) {
                window.location.href = "profile";
            } else if (prev_link == "https://interlinkiq.com/") {
                window.location.href = "profile";
            } else {
                // window.history.back();
                window.location.href = "profile";
            }
        </script>';
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CannOS Login</title>
		
		<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	    <!--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css">-->
		<!-- <link rel="stylesheet" type="text/css" href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" /> -->
		<!-- <link rel="stylesheet" type="text/css" href="../assets/global/css/components.min.css" id="style_components" /> -->
		<link rel="stylesheet" href="cann-os_login_files/style.css">
		<style type="text/css">
			.error {
				color: red;
				font-size: 10px;
				display: block;
			}
			.alert_msg {
				width: 100%;
				font-size: 13px;
			}
			.alert {
				border-width: 1px;
			}
			.alert-danger {
				background-color: #fbe1e3;
				border-color: #fbe1e3;
				color: #e73d4a;
			}
			.alert-success {
				background-color: #abe7ed;
				border-color: #abe7ed;
				color: #27a4b0;
			}
			.alert {
				padding: 15px;
				border: 1px solid transparent;
				border-radius: 4px;
			}
			.alert, .thumbnail {
				margin: 8px 0;
			}

			/*POPUP*/
			.fade {
			    opacity: 0;
			    -webkit-transition: opacity 0.15s linear;
			    -o-transition: opacity 0.15s linear;
			    transition: opacity 0.15s linear;
			}
			.popover {
			    position: absolute;
			    top: 0;
			    left: 0;
			    z-index: 1060;
			    display: none;
			    max-width: 276px;
			    padding: 1px;
			    font-family: "Lato","Helvetica Neue",Helvetica,Arial,sans-serif;
			    font-style: normal;
			    font-weight: normal;
			    letter-spacing: normal;
			    line-break: auto;
			    line-height: 1.42857143;
			    text-align: left;
			    text-align: start;
			    text-decoration: none;
			    text-shadow: none;
			    text-transform: none;
			    white-space: normal;
			    word-break: normal;
			    word-spacing: normal;
			    word-wrap: normal;
			    font-size: 15px;
			    background-color: #ffffff;
			    -webkit-background-clip: padding-box;
			    background-clip: padding-box;
			    border: 1px solid #cccccc;
			    border: 1px solid rgba(0,0,0,0.2);
			    border-radius: 6px;
			    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,0.2);
			    box-shadow: 0 5px 10px rgba(0,0,0,0.2);
			}
			.popover.top {
			    margin-top: -10px;
			}

			.fade.in {
			    opacity: 1;
			}
			.popover {
			    color: #2c3e50;
			}
			.popover.top>.arrow {
			    left: 50%;
			    margin-left: -11px;
			    border-bottom-width: 0;
			    border-top-color: #999999;
			    border-top-color: rgba(0,0,0,0.25);
			    bottom: -11px;
			}

			.popover>.arrow {
			    border-width: 11px;
			}
			.popover>.arrow, .popover>.arrow:after {
			    position: absolute;
			    display: block;
			    width: 0;
			    height: 0;
			    border-color: transparent;
			    border-style: solid;
			}
			.popover-title {
			    margin: 0;
			    padding: 8px 14px;
			    font-size: 15px;
			    background-color: #f7f7f7;
			    border-bottom: 1px solid #ebebeb;
			    border-radius: 5px 5px 0 0;
			}
			.popover-content {
			    padding: 9px 14px;
			}
			.popover-content ul, .popover-content ol {
			    margin-top: 0;
			    margin-bottom: 10.5px;
			    padding-left: 1rem;
			}
		</style>
	</head>
	<body>
		<div class="container" id="container">
			<?php
				$confirm = false;
				$predefine = false;
				$ID = '';

				// Registration
				if ( !empty( $_GET['i'] ) AND !empty( $_GET['r'] ) AND $_GET['r'] == 1 ) {
					$ID = $_GET['i'];
					$invited_id = '';
					$selectEmployee = mysqli_query( $conn,'SELECT * FROM tbl_hr_employee WHERE verified = 0 AND ID = "'. $ID .'"' );
					if ( mysqli_num_rows($selectEmployee) > 0 ) {
						$rowEmployee = mysqli_fetch_array($selectEmployee);
						$predefine = true;
						$invited_id = $rowEmployee['ID'];
						$data_email = $rowEmployee['email'];
						$data_first_name = $rowEmployee['first_name'];
						$data_last_name = $rowEmployee['last_name'];
					}
				}

				// Confirm
				if ( !empty( $_GET['i'] ) AND !empty( $_GET['c'] ) AND $_GET['c'] == 1 ) {
					$ID = $_GET['i'];
					$selectUser = mysqli_query( $conn,'SELECT * FROM tbl_user WHERE is_verified = 0 AND is_active = 1 AND ID = "'. $ID .'"' );
					if ( mysqli_num_rows($selectUser) > 0 ) {
						$rowUser = mysqli_fetch_array($selectUser);
						$data_employee_id = $rowUser['employee_id'];

						if ( !empty($data_employee_id) ) {
							mysqli_query( $conn,"UPDATE tbl_hr_employee set status='1' WHERE ID='". $data_employee_id ."'" );
						}

						mysqli_query( $conn,"UPDATE tbl_user set is_verified='1' WHERE ID='". $ID ."'" );
						$confirm = true;
					}
				}

				// Reset
				if ( !empty( $_GET['i'] ) AND !empty( $_GET['p'] ) AND $_GET['p'] == 1 ) {
					$ID = $_GET['i'];
				}

				// Locked
				if ( !empty( $_GET['i'] ) AND !empty( $_GET['l'] ) AND $_GET['l'] == 1 ) {
					$ID = $_GET['i'];
				}
			?>
			<div class="form-container sign-up-container">
				<form method="post" class="formSignUp">
					<h1>Create Account</h1>
		 
					<span>Grab Your FREE Access Now!</span>

					<div class="alert_msg"></div>

					<input class="form-control" type="hidden" name="ID" value="<?php echo !empty($invited_id) ? $invited_id : ''; ?>" />
                    <input class="form-control" type="hidden" name="client" value="1" />
					<div style="width: 100%;">
						<input class="form-control placeholder-no-fix" type="text" placeholder="First Name" name="first_name" value="<?php echo $predefine === true ? $data_first_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
					</div>
					<div style="width: 100%;">
						<input class="form-control placeholder-no-fix" type="text" placeholder="Last Name" name="last_name" value="<?php echo $predefine === true ? $data_last_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
					</div>
					<div style="width: 100%;">
						<input class="form-control placeholder-no-fix" type="email" placeholder="Email" name="email" value="<?php echo $predefine === true ? $data_email : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
					</div>
					<div style="width: 100%;">
						<input class="form-control placeholder-no-fix" type="password" placeholder="Password" autocomplete="off" id="password" name="password" required />
					</div>
					<div style="width: 100%;">
						<input class="form-control placeholder-no-fix" type="password" placeholder="Confirm Password" autocomplete="off" id="rpassword" name="rpassword" required /> 
					</div>
					<button type="submit" id="btn_SignUp">Sign Up</button>
				</form>
			</div>
			<div class="form-container sign-in-container">
				<form method="post" class="formSignIn">
					<h1>Sign in</h1>
					<span>or use your account</span>
					
					<div class="alert_msg"><?php echo $confirm === true ? '<div class="alert alert-success display-hide" style="display: block; margin-top: 0;">/button>Account confirmed! Please enter your login details</div>' : ''; ?></div>
					
                    <input class="form-control" type="hidden" name="client" value="1" />
					<div style="width: 100%;">
						<input type="email" class="form-control form-control-solid placeholder-no-fix" name="email" placeholder="Email" autocomplete="off" required />
					</div>
					<div style="width: 100%;">
						<input type="password" class="form-control form-control-solid placeholder-no-fix" name="password" placeholder="Password" autocomplete="off" required />
					</div>
					
					<a href="javascript:;" onclick="btnSwitch(1)">Forgot your password?</a>
					<button type="submit" id="btn_SignIn">Sign In</button>
				</form>
				<form method="post" class="formForgot" style="display: none;">
					<h1>Forgot Password</h1>
					<span>enter your account</span>
					
					<div class="alert_msg"></div>
					
					<div style="width: 100%;">
						<input type="email" class="form-control form-control-solid placeholder-no-fix" name="email" placeholder="Email" autocomplete="off" required />
					</div>

					<a href="javascript:;" onclick="btnSwitch(2)">Already have an account?</a>
					<button type="submit" id="btn_Fotgot">Reset Password</button>
				</form>
				<form method="post" class="formForgotPassword" style="display: none;">
					<h1>Update Password</h1>
					<span>check you email and enter the details below</span>
					
					<div class="alert_msg"></div>
					<input class="form-control" type="hidden" name="ID" value="<?php echo $ID; ?>" />
					<div style="width: 100%;">
						<input type="text" class="form-control form-control-solid placeholder-no-fix" name="code" placeholder="Verification Code" autocomplete="off" required />
					</div>
					<div style="width: 100%;">
						<input type="password" class="form-control form-control-solid placeholder-no-fix" id="npassword" name="npassword" placeholder="New Password" autocomplete="off" required />
					</div>
					<div style="width: 100%;">
						<input type="password" class="form-control form-control-solid placeholder-no-fix" id="cnpassword" name="cnpassword" placeholder="Confirm Password" autocomplete="off" required />
					</div>

					<a href="javascript:;" onclick="btnSwitch(2)">Already have an account?</a>
					<button type="submit" id="btn_FotgotPassword">Reset Password</button>
				</form>
				<form method="post" class="formUpdatePassword" style="display: none;">
					<h1>Update Password</h1>
					<span>enter the details below to unlock your account</span>
					
					<div class="alert_msg"></div>
					<input class="form-control" type="hidden" name="ID" value="<?php echo $ID; ?>" />
					<div style="width: 100%;">
						<input type="password" class="form-control form-control-solid placeholder-no-fix" id="npassword" name="lnpassword" placeholder="New Password" autocomplete="off" required />
					</div>
					<div style="width: 100%;">
						<input type="password" class="form-control form-control-solid placeholder-no-fix" id="cnpassword" name="lcnpassword" placeholder="Confirm Password" autocomplete="off" required />
					</div>

					<a href="javascript:;" onclick="btnSwitch(2)">Already have an account?</a>
					<button type="submit" id="btn_UpdatePassword">Update Password</button>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>Welcome Back!</h1>
						<p>To keep connected with us please login with your personal info</p>
						<button class="ghost" id="signIn">Sign In</button>
					</div>
					<div class="overlay-panel overlay-right">
						<h1>Hello, Friend!</h1>
						<p>Enter your personal details and start the journey with us</p>
						<button class="ghost" id="signUp">Sign Up</button>
					</div>
				</div>
			</div>
		</div>

		<div class="footer" style="display:inline-block"></div>
		<div class="footer-elem">
			<div class="footer-content footer-l"><a href="//www.begreenlegal.com/cannabis-cannabis-compliance-management-consulting/"><img src="cann-os_login_files/img/cann-os.png" width="100" height="50" ></a></div>
			<div class="footer-content footer-m"><span style="color:lightblue;"><i style="color:yellow;" class="fa fa-bolt" aria-hidden="true"></i>&nbsp;Powered by:</span></div>
			<div class="footer-content footer-l"><a href="//interlinkiq.com/"><img src="cann-os_login_files/img/interlink-iq.png" width="200" height="55" ></a></div>
		</div>


		<script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="//www.jqueryscript.net/demo/Validate-Password-Meets-Requirements-jQuery-PassRequirements/js/PassRequirements.js"></script>
		<script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
		<script>
			const signUpButton = document.getElementById('signUp');
			const signInButton = document.getElementById('signIn');
			const container = document.getElementById('container');

			signUpButton.addEventListener('click', () =>
			container.classList.add('right-panel-active'));

			signInButton.addEventListener('click', () =>
			container.classList.remove('right-panel-active'));


            <?php if ( !empty( $_GET['i'] ) AND !empty( $_GET['p'] ) AND $_GET['p'] == 1 ) { ?> ResetPassword(); <?php } ?>
            <?php if ( !empty( $_GET['i'] ) AND !empty( $_GET['l'] ) AND $_GET['l'] == 1 ) { ?> UpdatePassword(); <?php } ?>
            function ResetPassword() {
                $(".formSignIn").hide();
                $(".formForgot").hide();
                $(".formForgotPassword").show();
            }
            function UpdatePassword() {
                $(".formSignIn").hide();
                $(".formForgot").hide();
                $(".formForgotPassword").hide();
                $(".formUpdatePassword").show();
            }

            $('.formSignUp').validate({ // initialize the plugin
                rules : {
                    password : {
                        minlength : 8
                    },
                    rpassword : {
                        minlength : 8,
                        equalTo : "#password"
                    },
		            field: {
		                required: true,
		                alphanumeric: true
		            }
                }
            });
            $('.formForgotPassword').validate({ // initialize the plugin
                rules : {
                    npassword : {
                        minlength : 8
                    },
                    cnpassword : {
                        minlength : 8,
                        equalTo : "#npassword"
                    }
                }
            });
            $('#lnpassword, #lcnpassword, #npassword, #cnpassword, #password, #rpassword').PassRequirements({
				rules: {
					minlength: {
						text: "minimum minLength characters long",
						minLength: 8,
					},
					containSpecialChars: {
						text: "at least minLength special character",
						minLength: 1,
						regex: new RegExp('([^!,%,&,@,#,$,^,*,?,_,~])', 'g')
					},
					containLowercase: {
						text: "at least minLength lower case character",
						minLength: 1,
						regex: new RegExp('[^a-z]', 'g')
					},
					containUppercase: {
						text: "at least minLength upper case character",
						minLength: 1,
						regex: new RegExp('[^A-Z]', 'g')
					},
					containNumbers: {
						text: "at least minLength number",
						minLength: 1,
						regex: new RegExp('[^0-9]', 'g')
					}
				},
		        popoverPlacement: 'top'
			});

            <?php if ($predefine == true) { ?> $('#container').addClass('right-panel-active'); <?php } ?>

			$(".formSignIn").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;
					
				var formData = new FormData(this);
				formData.append('btn_SignIn',true);

				$.ajax({
					url: "function.php",
					type: "POST",
					data: formData,
					contentType: false,
					processData:false,
					cache: false,
					success:function(response) {

						var obj = jQuery.parseJSON(response);
						if (obj.exist == true) {
							var data = '<div class="alert alert-success">';
							data += obj.message;
							data += '</div>';

							localStorage.setItem('islogin','yes');

							prev_link = document.referrer;
							if (prev_link.indexOf('forum/index.php') > -1) { window.location.href = prev_link; }
							else { window.location.href = 'profile'; }
						} else {
							var data = '<div class="alert alert-danger">';
							data += obj.message;
							data += '</div>';
						}
						$('.formSignIn .alert_msg').html(data);
					}
				});
			}));
			$(".formSignUp").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;
					
				var formData = new FormData(this);
				formData.append('btn_SignUp',true);

				$.ajax({
					url: "function.php",
					type: "POST",
					data: formData,
					contentType: false,
					processData:false,
					cache: false,
					success:function(response) {

						var obj = jQuery.parseJSON(response);
                        if (obj.exist == false) {
                            var data = '<div class="alert alert-success">';
                            data += obj.message;
                            data += '</div>';

                            $('#container').removeClass('right-panel-active');
                            $('.formSignIn .alert_msg').html(data);
                        } else {
                            var data = '<div class="alert alert-danger">';
                            data += obj.message;
                            data += '</div>';
                            
                            $('.formSignUp .alert_msg').html(data);
                        }
					}
				});
			}));
			$(".formForgot").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;
					
				var formData = new FormData(this);
				formData.append('btn_Fotgot',true);

				$.ajax({
					url: "function.php",
					type: "POST",
					data: formData,
					contentType: false,
					processData:false,
					cache: false,
					success:function(response) {

						var obj = jQuery.parseJSON(response);
						if (obj.exist == true) {
							var data = '<div class="alert alert-success">';
							data += obj.message;
							data += '</div>';
						} else {
							var data = '<div class="alert alert-danger">';
							data += obj.message;
							data += '</div>';
						}
						$('.formForgot .alert_msg').html(data);
					}
				});
			}));
			$(".formForgotPassword").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;
					
				var formData = new FormData(this);
				formData.append('btn_FotgotPassword',true);

				$.ajax({
					url: "function.php",
					type: "POST",
					data: formData,
					contentType: false,
					processData:false,
					cache: false,
					success:function(response) {

						var obj = jQuery.parseJSON(response);
						if (obj.exist == true) {
							var data = '<div class="alert alert-success">';
							data += obj.message;
							data += '</div>';

							$(".formSignIn").show();
			                $(".formForgot").hide();
			                $(".formForgotPassword").hide();
							$('.formSignIn .alert_msg').html(data);
						} else {
							var data = '<div class="alert alert-danger">';
							data += obj.message;
							data += '</div>';
							$('.formForgotPassword .alert_msg').html(data);
						}
					}
				});
			}));
			$(".formUpdatePassword").on('submit',(function(e) {
				e.preventDefault();

				formObj = $(this);
				if (!formObj.validate().form()) return false;
					
				var formData = new FormData(this);
				formData.append('btn_UpdatePassword',true);

				$.ajax({
					url: "function.php",
					type: "POST",
					data: formData,
					contentType: false,
					processData:false,
					cache: false,
					success:function(response) {

						var obj = jQuery.parseJSON(response);
						if (obj.exist == true) {
							var data = '<div class="alert alert-success">';
							data += obj.message;
							data += '</div>';

							$(".formSignIn").show();
			                $(".formForgot").hide();
			                $(".formForgotPassword").hide();
							$('.formSignIn .alert_msg').html(data);
						} else {
							var data = '<div class="alert alert-danger">';
							data += obj.message;
							data += '</div>';
							$('.formForgotPassword .alert_msg').html(data);
						}
					}
				});
			}));

			function btnSwitch(id) {
				if (id == 1) {
					$('.formSignIn').hide();
					$('.formForgot').show();
				} else if (id == 2) {
					$('.formSignIn').show();
					$('.formForgot').hide();
				}
			}
		</script>
	</body>
</html>