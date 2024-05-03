<?php
	session_start();
	include_once "database_iiq.php";
    $base_url = "https://interlinkiq.com/";

    $current_userID = '';
    $current_userAvatar = '';
    if (isset($_COOKIE['ID'])) {
    	$current_userID = $_COOKIE['ID'];
    }
    
    function employerID($ID) {
        global $conn;

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];

        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }

        return $current_userEmployerID;
    }
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">

		<title><?php echo $title; ?></title>
		<meta content="" name="description">
		<meta content="" name="keywords">

		<!-- Favicons -->
        <link rel="shortcut icon" href="assets/img/interlink icon.png" />

		<!-- Google Fonts -->
		<link rel="preconnect" href="//fonts.googleapis.com">
		<link rel="preconnect" href="//fonts.gstatic.com" crossorigin>
		<link rel="stylesheet" href="//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap">

		<!-- Vendor CSS Files -->
		<link rel="stylesheet" href="assets/specialist/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/specialist/vendor/bootstrap-icons/bootstrap-icons.css">
		<link rel="stylesheet" href="assets/specialist/vendor/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="assets/specialist/vendor/aos/aos.css">
		<link rel="stylesheet" href="assets/specialist/vendor/glightbox/css/glightbox.min.css">
		<link rel="stylesheet" href="assets/specialist/vendor/swiper/swiper-bundle.min.css">

        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.css" />
    	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.thumbs.css" />

        <link rel="stylesheet" type="text/css" href="assets/global/plugins/ladda/ladda-themeless.min.css" />

        <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" />
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

		<!-- Template Main CSS File -->
		<link rel="stylesheet" href="assets/specialist/css/main.css">
	</head>

	<body>
		<!-- ======= Header ======= -->
		<header id="header" class="header d-flex align-items-center"  >
			<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
				<a href="index.php" class=" d-flex align-items-center"><img src="LandingPageFiles/img/iiq logo white.png" alt="" height="100" style="margin:-1.2rem 0 0 -1.5rem"></a>

				<i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
				<i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
				<nav id="navbar" class="navbar">
					<ul>
						<li><a class="<?php echo $site === "home" ? "active" : ""; ?>" href="/">Home</a></li>
						<li class="d-none"><a class="<?php echo $site === "services" ? "active" : ""; ?>" href="management_services">Services</a></li>
						<li class="d-none"><a class="<?php echo $site === "forum" ? "active" : ""; ?>" href="forum/index">Forum</a></li>
						<li class="d-none"><a class="<?php echo $site === "specialist" ? "active" : ""; ?>" href="specialist">Specialist</a></li>
						<li class="d-none"><a class="<?php if($site == "marketplace" OR $site == "marketplace-view") { echo 'active'; } ?>" href="marketplace">Marketplace</a></li>
						<li class="d-none"><a class="" href="grant">Grant Services</a></li>
						<li><a class="<?php if($site == "contact") { echo 'active'; } ?>" href="contact">Contact</a></li>
						<?php 
							// if(isset($_SESSION['unique_id'])) {
							if(!empty($current_userID)) {
	                    		$selectUser = mysqli_query( $conn,"SELECT * FROM tbl_user WHERE is_active = 1 AND ID = $current_userID" );
								if(mysqli_num_rows($selectUser) > 0) {
									$rowUser = mysqli_fetch_assoc($selectUser);

									echo '<li><a href="profile">Profile</a></li>';

									include_once 'widget_chatbox.php';	
								}
							}

							// if(!isset($_SESSION['unique_id'])) {
							if(empty($current_userID)) {
								echo '<li><a href="login">Login</a></li>  ';
							}
						?>
					</ul>
				</nav><!-- .navbar -->
			</div>
		</header><!-- End Header -->
		<!-- <div  style="margin-bottom: 10rem;"></div> -->
		<main id="main">
			<!-- ======= Breadcrumbs ======= -->
			<div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/specialist/img/blog-3.jpg'); height: 50vh;">
				<div class="container position-relative d-flex flex-column align-items-center">
					<h2><?php echo $title; ?></h2>
				</div>
			</div><!-- End Breadcrumbs -->

			<!-- ======= Services Section ======= -->
			<section id="services" class="services section-bg">
				<div class="container">