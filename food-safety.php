<?php 

    $site = 'food-safety';

    $links = [
        // first priority
        'index',
        'edit',
        'pdf', 
        'api',
        // last priority
    ];
    
    // default page view
    $view = 'index';

    foreach($links as $l) {
        if(in_array($l, array_keys($_GET))) {
            $view = $l;
            break;
        }
    }
    
    $title = ($view == 'edit' ? 'Edit ' : '') . 'Food Safety Plan';

    $breadcrumbs = '';
    $sub_breadcrumbs = '';
    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once "modules/fs/$view.php";
    
?>