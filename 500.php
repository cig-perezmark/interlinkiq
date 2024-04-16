<?php 
    $title = "500 - Page went something wrong";
    $site = "505";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12 page-500">
                            <div class=" number font-red"> 500 </div>
                            <div class=" details">
                                <h3>Oops! Something went wrong.</h3>
                                <p> We are fixing it! Please come back in a while.
                                    <br/> </p>
                                <p>
                                    <a href="dashboard" class="btn red btn-outline"> Return home </a>
                                    <br> </p>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

    </body>
</html>