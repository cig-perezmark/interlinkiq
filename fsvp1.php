<?php 

    $site = 'fsvp1';

    // links or directories allowed to be rerouted
    $links = [
        // first priority
        'index',
        'api',
        // last priority
    ];
    
    // default page view
    $view = 'index';

    // stops
    foreach($links as $l) {
        if(in_array($l, array_keys($_GET))) {
            $view = $l;
            break;
        }
    }
    
    $title = 'Foreign Supplier Verification Program';

    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once "modules/fsvp1/$view.php";
    
?>
