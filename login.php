<?php include_once 'database_iiq.php'; ?>
<?php
  if(isset($_COOKIE['ID'])) {
    // $url='profile';
    // $url=$_SERVER['HTTP_REFERER'];
    // // echo '<META HTTP-EQUIV=REFRESH CONTENT="0; '.$url.'">';
    // // header('Location: profile');
    
    echo '<script>
      if (document.referrer == "") {
        window.history.back();
      } else {
        window.location.href = "profile";
      }
    </script>';
  }
?>

<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>InterlinkIQ - Login</title>

    <link rel="canonical" href="//getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="icon" href="uploads/login/icon/interlinkIQ.png">

    <style>
      label.error {
        border: 0 !important;
        color: #fff !important;
      }

      .bg-body {
        height: 100vh;
        background: #07193A;
        background-image: linear-gradient(#07193A, #07284F);
        /*background: url(uploads/login/bg/iiq_wave.png);
        background-position: bottom left;
        background-repeat: no-repeat;*/
      }.bg-body:after {
        content: '';
        background: url(uploads/login/bg/iiq_wave.png);
        background-size: cover;
        position: absolute;
        width: 100%;
        height: 20%;
        bottom: 0;
        z-index: -1;
      }
      .container-form {
        height: 100vh;
        border-radius: 50px 0 0 50px;
      }
      .text-blue {
        color: #07418B;
      }
      .text-light-blue {
        color: #0BA6CC;
      }
      .btn-light-blue {
        background: #0BA6CC;
        border-color: #0BA6CC;
        border-radius: 50px;
      }
      input {
        border-width: 1px !important;
        border-color: #0BA6CC !important;
      }
      input::-ms-reveal,
      input::-ms-clear {
        display: none;
      }
      .sec-float {
        position: absolute;
        width: 100%;
      }
      .sec-form {
        height: 100vh;
        box-shadow: 0 0 10rem #000;
        border-radius: 50px 0 0 50px;
      }

      @media only screen and (max-width: 992px) {
        .sec-float {
          position: unset;
        }
        .sec-form {
          height: auto;
          border-radius: 15px;
          margin: 15px;
        }
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="custom.css" rel="stylesheet">
  </head>
  <body class="d-flexx flex-columnx justify-content-centerx align-items-centerx row-direction-column bg-body">

    <?php
      $confirm = false;
      $predefine = false;
      $ID = '';

      // Registration
      if ( !empty( $_GET['i'] ) AND !empty( $_GET['r'] ) AND $_GET['r'] == 1 ) {
        $ID = $_GET['i'];
        $invited_id = '';
        $selectEmployee = mysqli_query( $conn,"SELECT ID, email, first_name, last_name FROM tbl_hr_employee WHERE verified = 0 AND ID = $ID" );
        if ( mysqli_num_rows($selectEmployee) > 0 ) {
          $rowEmployee = mysqli_fetch_array($selectEmployee);
          $predefine = true;
          $invited_id = $rowEmployee['ID'];
          $data_email = $rowEmployee['email'];
          $data_first_name = $rowEmployee['first_name'];
          $data_last_name = $rowEmployee['last_name'];
          $data_last_name = $rowEmployee['last_name'];
        }
      }

      // Confirm
      if ( !empty( $_GET['i'] ) AND !empty( $_GET['c'] ) AND $_GET['c'] == 1 ) {
        $ID = $_GET['i'];
        $selectUser = mysqli_query( $conn,"SELECT employee_id FROM tbl_user WHERE is_verified = 0 AND is_active = 1 AND ID = $ID" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
          $rowUser = mysqli_fetch_array($selectUser);
          $data_employee_id = $rowUser['employee_id'];

          if ( !empty($data_employee_id) ) {
            mysqli_query( $conn,"UPDATE tbl_hr_employee set status = 1 WHERE ID = $data_employee_id" );
          }

          mysqli_query( $conn,"UPDATE tbl_user set is_verified = 1 WHERE ID = $ID" );
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

    <div class="container-fluid">
      <!-- Header -->
      <div class="row sec-float">
        <div class="offset-lg-1 col-lg-4">
          <img src="uploads/login/icon/interlinkIQ.png" style="width: 100px; height: 100px;" />
          <p class="text-center text-white lead">Your Private Portal Partner in Streamlined Compliance and Operational Excellence</p>
        </div>
      </div>

      <!-- Body -->
      <div class="row">
        <div class="offset-lg-5 col-lg-7 text-center">
          <div class="row align-items-center bg-white sec-form">
            <div class="col-1" style="position: relative;">
              <img class="my-auto" src="uploads/login/bg/iiq_globe.png" style="width: 25rem; position: absolute; right: 3rem; top: 0; bottom: 0;"/>
            </div>
            <div class="col-lg-6">

              <!-- Login -->
              <form method="POST" class="form formSignIn">
                <h2 class="text-blue mt-5 mb-5" style="font-weight: 800;">Welcome Back</h1>

                <div class="alert_msg text-white"></div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" id="email2" name="email" placeholder="Email Address" required />
                  <label for="email2">Email Address</label>
                </div>

                <div class="input-group mb-3">
                  <div class="form-floating">
                    <input type="password" class="form-control" id="password2" name="password" placeholder="Password" required />
                    <label for="password2">Password</label>
                  </div>
                  <button class="btn btn-outline-secondary viewPW" type="button"><i class="fa fa-eye text-light-blue"></i></button>
                </div>

                <div class="d-grid gap-2 my-5">
                  <button class="btn btn-primary btn-light-blue btn-lg" type="submit">Login</button>
                </div>

                <p class=" my-5">
                  Dont have account yet? 
                  <a href="javascript:;" class="text-dark" onclick="btnCreate()">Create here</a>
                </p>
              </form>

              <!-- Register -->
              <form method="POST" class="form formSignUp" style="display: none;">
                <h2 class="text-blue mt-5" style="font-weight: 800;">Create Account</h1>
                <p class="text-light-blue mb-5">Get Your FREE Access Now!</p>

                <div class="alert_msg text-white"></div>
                <input class="form-control" type="hidden" name="ID" value="<?php echo !empty($invited_id) ? $invited_id : ''; ?>" />
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $predefine === true ? $data_first_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
                  <label for="first_name">First Name</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $predefine === true ? $data_last_name : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> required />
                  <label for="last_name">Last Name</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="email" name="email" value="<?php echo $predefine === true ? $data_email : ''; ?>" <?php echo $predefine === true ? 'readonly' : ''; ?> placeholder="Email" required />
                  <label for="email">Email</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="phone" required />
                  <label for="phone">Phone Number</label>
                </div>

                <div class="input-group mb-3">
                  <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                    <label for="password">Password</label>
                  </div>
                  <button class="btn btn-outline-secondary viewPW" type="button"><i class="fa fa-eye text-light-blue"></i></button>
                </div>

                <div class="input-group mb-3">
                  <div class="form-floating">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
                    <label for="confirm_password">Confirm Password</label>
                  </div>
                  <button class="btn btn-outline-secondary viewPW" type="button"><i class="fa fa-eye text-light-blue"></i></button>
                </div>

                <div class="d-grid gap-2 my-5">
                  <button class="btn btn-primary btn-light-blue btn-lg" type="submit">Sign Up</button>
                </div>

                <p class=" my-5">
                  Already have an account? 
                  <a href="javascript:;" class="text-dark" onclick="btnBack()">Create here</a>
                </p>
              </form>
              
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="row sec-float align-items-center text-center" style="bottom: 0;">
        <div class="offset-lg-2 col-lg-3">
          <h5 style="color: yellow;">
            <svg xmlns="//www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-fill" viewBox="0 0 16 16">
              <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641z"></path>
            </svg>
            <span class="text-white">Powered by:</span>
          </h5>
        </div>
        <div class="col-lg-5">
          <img src="uploads/login/icon/interlinkiq.com - logo.png" style="width: 100%; max-width: 250px;" />
        </div>
      </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

    <script>
      var $ = jQuery;
      $(document).ready(function(){
        $(".form").validate();
      });

      $('.viewPW').click(function(){
          var x = $(this).prev().find('input').attr('type');
          if (x === "password") {
              $(this).prev().find('input').prop("type", "text");
              $(this).find('i').addClass('fa-eye-slash');
          } else {
              $(this).prev().find('input').prop("type", "password");
              $(this).find('i').removeClass('fa-eye-slash');
          }
      });

      function btnCreate() {
        $(".formSignIn").hide(),$(".formSignUp").show();
      }

      function btnBack() {
        $(".formSignIn").show(),$(".formSignUp").hide();
      }

      $(".formSignIn").on('submit',(function(e) {
        e.preventDefault();

        formObj = $(this);
        if (!formObj.validate().form()) return false;

        var formData = new FormData(this);
        formData.append('btnSignIn',true);
        formData.append('client',0);

        $.ajax({
          url: "function.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData:false,
          cache: false,
          success: function(response) {
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
        formData.append('client',0);

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
              btnBack();
            } else {
              var data = '<div class="alert alert-danger">';
              data += obj.message;
              data += '</div>';
              
              $('.formSignUp .alert_msg').html(data);
            }
          }
        });
      }));
    </script>
  </body>
</html>