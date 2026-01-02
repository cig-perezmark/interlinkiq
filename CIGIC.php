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
    <title>CIG Intel Comp - Login</title>

    <link rel="canonical" href="//getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <!-- <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json"> -->
    <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }

      .login-container {
        background: url('uploads/login/bg/background web design 2.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
      }
      .sign-in-container {
        background: url('uploads/login/bg/ic.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
      }
      .sign-up-container {
        background: url('uploads/login/bg/web background.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
      }
      .sign-logo {
        max-height: 200px;
        max-width: inherit;
        height: auto;
        width: auto;
        background: #fbfbfb;
      }
      .error {
        border: 0 !important;
        color: #fff !important;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="custom.css" rel="stylesheet">
  </head>
  <body class="d-flex flex-column align-items-center row-direction-column py-4x bg-body-tertiaryx bg-dark login-container">

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

    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <img class="sign-logo" src="uploads/login/icon/cigic.png" />
        </div>
      </div>
    </div>

    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-lg-4 p-5 sign-in-container d-flex align-items-center">
          <form method="POST" class="form formSignIn w-100">
            <h1 class="text-white">Welcome Back</h1>

            <h3 class="text-white">Login</h3>
            <div class="alert_msg text-white"></div>

            <div class="input-group mb-3">
              <span class="input-group-text">
                <svg xmlns="//www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                </svg>
              </span>
              <div class="form-floating">
                <input type="email" class="form-control" id="email2" name="email" placeholder="Email Address" required />
                <label for="email2">Email Address</label>
              </div>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">
                <svg xmlns="//www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                  <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                </svg>
              </span>
              <div class="form-floating">
                <input type="password" class="form-control" id="password2" name="password" placeholder="Password" required />
                <label for="password2">Password</label>
              </div>
              <button class="btn btn-outline-secondary viewPW bg-white text-secondary" type="button"><i class="fa fa-eye text-light-blue"></i></button>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit" style="background: #0528ab; border-color: #0528ab;">
              Login
              <svg xmlns="//www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
              </svg>
            </button>
            <a href="#" class="text-white">Forgot Password?</a>
          </form>
        </div>
        <div class="col-lg-4 p-5 sign-up-container">
          <form method="POST" class="form formSignUp">
            <h1>Create Account</h1>

            <div class="alert_msg text-white"></div>
            <input class="form-control" type="hidden" name="ID" value="<?php echo !empty($invited_id) ? $invited_id : ''; ?>" />
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required />
              <label for="first_name">First Name</label>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required />
              <label for="last_name">Last Name</label>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="email" name="email" placeholder="Email" required />
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
              <button class="btn btn-outline-secondary viewPW bg-white text-secondary" type="button"><i class="fa fa-eye text-light-blue"></i></button>
            </div>
            <div class="input-group mb-3">
              <div class="form-floating">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
                <label for="confirm_password">Confirm Password</label>
              </div>
              <button class="btn btn-outline-secondary viewPW bg-white text-secondary" type="button"><i class="fa fa-eye text-light-blue"></i></button>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit" style="background: #031d7e; border-color: #031d7e;">SIGN UP</button>
          </form>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-4 d-flex justify-content-center align-items-centerc">
          <h5 style="color: yellow;">
            <svg xmlns="//www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-fill" viewBox="0 0 16 16">
              <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641z"></path>
            </svg>
            <span class="text-dark">Powered by:</span>
          </h5>
        </div>
        <div class="col-4 d-flex justify-content-center align-items-centerc text-centerx">
          <img src="//interlinkiq.com/assets/img/interlinkiq%20v3.png" style="height: 70px;">
        </div>
      </div>
    </div>

    <!-- <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <!-- <script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> -->
    <!-- <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->
    <!-- <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->
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


      $(".formSignIn").on('submit',(function(e) {
        e.preventDefault();

        formObj = $(this);
        if (!formObj.validate().form()) return false;

        var formData = new FormData(this);
        formData.append('btnSignIn',true);
        formData.append('client',31);

        // var l = Ladda.create(document.querySelector('#btnSave_Attached'));
        // l.start();

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
              else { window.location.href = obj.page; }
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
        formData.append('client',31);

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
    </script>
  </body>
</html>