<?php 
    $title = "Coming Soon";
    $site = "coming";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1 class="text-success sbold">COMING SOON</h1>
                            <p>Something great is on the way!</p>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

    </body>
</html>