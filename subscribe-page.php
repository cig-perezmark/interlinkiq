<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Subscription Management</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .page-404 .details {
            text-align: center;
        }
        .mb-2 {
            margin-bottom: 4rem;
        }
        .d-flex-center {
            display: flex;
            justify-content: center;
        }
        .widget-thumb {
            min-height: 120px;
            max-height: 120px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 1px 6px rgba(0,0,0,0.23);
        }
        .media-icons {
            display: flex;
            justify-content: center;
            gap: 2rem;
            font-size: 30px;
            cursor: pointer;
        }
        .subscription{
            width: 95%;
        }
        .text-dark {
            color: #000;
        }
        .bi-emoji-frown, .bi-emoji-laughing {
            font-size: 9rem;
        }
        .d-none {
            display: none;
        }
        .consultare {
            margin-top: 15px;
        }
        .message-content {
            max-width: 600px;
            text-align: justify;
            padding: 0 15px;
        }
        .img-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            max-width: 600px;
            margin: 0 auto;
            padding-left: 30px;
        }
        .img-links a {
            flex: 0 1 180px;
            max-width: 180px;
        }
        .img-links img {
            width: 100%;
            height: auto;
        }
        @media (min-width: 768px) {
            .img-links a {
                flex: 0 1 180px;
            }
        }
        @media (max-width: 767px) {
            .img-links a {
                flex: 0 1 45%;
            }
        }
        @media (max-width: 480px) {
            .img-links a {
                flex: 0 1 100%;
            }
        }
    </style>
</head>
<body class="page-404-full-page">
    <div class="row">
        <div class="col-md-12 page-404">
            <div class="details">
                <div id="subscription-content"></div> 
                <div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                            <h4 class="widget-thumb-heading">Check us on social media</h4>
                            <div class="media-icons">
                                <span class="toggler tooltips" data-container="body" data-placement="top" data-html="true" data-original-title="YouTube">
                                    <a href="https://www.youtube.com/@consultareinc.interlinkiq"><i class="bi bi-youtube text-danger"></i></a>
                                </span>
                                <span class="toggler tooltips" data-container="body" data-placement="top" data-html="true" data-original-title="Facebook">
                                    <a href="https://www.facebook.com/ConsultareIncGroup"><i class="bi bi-facebook text-primary"></i></a>
                                </span>
                                <span class="toggler tooltips" data-container="body" data-placement="top" data-html="true" data-original-title="Linkedin">
                                    <a href="https://www.linkedin.com/company/consultareinc/mycompany/"><i class="bi bi-linkedin text-success"></i></a>
                                </span>
                                <span class="toggler tooltips" data-container="body" data-placement="top" data-html="true" data-original-title="Tiktok">
                                    <a href="https://www.tiktok.com/@interlinkiq"><i class="bi bi-tiktok text-dark"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="widget-thumb widget-bg-color-white margin-bottom-20">
                            <h4 class="widget-thumb-heading text-uppercase">Visit our website</h4>
                            <a href="http://interlinkiq.com" class="btn green">Visit our website</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="img-links mt-2">
                <a href="https://consultareinc.com/shop" target="_blank"><img src="assets/img/sop.png" alt="logo"></a>
                <a href="https://consultareinc.com" target="blank"><img src="assets/img/cig.png" alt="logo" class="consultare"></a>
                <a href="https://consultareinc.com/training-ace" target="blank"><img src="assets/img/training.png" alt="logo"></a>
                <a href="http://www.foodsafety360.pro" target="blank"><img src="assets/img/fs360.png" alt="logo"></a>
                <a href="https://interlinkiq.com" target="blank"><img src="assets/img/interlink.png" alt="logo"></a>
            </div>
        </div>
    </div>

    <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            get_subscription_content();
            function get_subscription_content() {
                var token = new URLSearchParams(window.location.search).get('token');
                if (!token) {
                    alert('ID not provided.');
                    return;
                }
                $.ajax({
                    url: 'https://interlinkiq.com/crm/controller_functions.php',
                    method: 'POST',
                    data: { get_content: true, token: token },
                    success: function(response) {
                        console.log(response)
                        var response = JSON.parse(response)
                        $('#subscription-content').html(response);
                    }
                });
            }

            $(document).on('click', '.subscription', function() {
                var token = new URLSearchParams(window.location.search).get('token');
                // var flag = $(this).data('value');
                if (!token) {
                    alert('ID not provided.');
                    return;
                }
                $.ajax({
                    url: 'https://interlinkiq.com/crm/controller_functions.php',
                    method: 'POST',
                    data: { subscribe: true, token: token },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire({
                                icon: "success",
                                title: "Subscription Updated",
                                text: "Your subscription status has been updated.",
                                confirmButtonColor: "#32c5d2",
                                showConfirmButton: true,
                                timer: 3500
                            }).then(() => {
                                get_subscription_content();
                            });
                        } else {
                        console.log(response)

                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "There was an error updating your subscription.",
                                confirmButtonColor: "#d33",
                                showConfirmButton: true,
                                timer: 3500
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
