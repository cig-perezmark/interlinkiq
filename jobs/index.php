<?php
require_once('../database.php');
     //setcookie('ID', 1);
     //$usertype = $_COOKIE['ID'];
    $uid=$_COOKIE['ID'];
    echo "<input type='hidden' id='currentId' value='$uid'>"
?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>Interlink - Jobs</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css'>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="../images/interlink icon.png">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">
        <link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
        <link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../../assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
       <!-- BEGIN THEME GLOBAL STYLES -->
       <link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css">
        <link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css">
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../../assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css">
        <link href="../../assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color">
        <link href="../../assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>        
    </head>
<body>
<!-- partial:index.partial.html -->
<header><img src="http://projects.lollypop.design/job-listing/bg-header-desktop.svg" alt="header"/></header>
<main>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="filter-tags-c">
          <ul id="filter-tags-list"></ul>
          <p class="clear-tags" id="js-clear-tags"> Clear</p>
        </div>
      </div>
    </div>
    <?php 
        // function displayEdit($utype, $dataid, $datatitle, $datadesc,$location,$isworldwide,$status,$salary,$skill){
        //     $display="";
        //     if($utype==0||$utype==1){
        //         $display='<div> <a  class="editButton icon-pencil pull-left" data-id="'.$dataid.'" data-title='.$datatitle.' data-desc='.$datadesc.'
        //         data-loc='.$location.' data-ww='.$isworldwide.'  data-stat='.$status.'  data-sal='.$salary.' data-skill='.$skill.' 
        //         data-toggle="modal" href="#modalJob"/></a> </div>';
        //     }
        //     return $display;
        // }
            // if($usertype==1){
        ?>
    <div class="row actionBar">
        <!--hide unhide action dropdown button depends on user type -->
        <div class="col-lg-12">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="#">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Jobs</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a class="addJobButton" data-toggle="modal" href="#modalJob"> Add New Job</a>
                                <!--<a class="filterJob" data-toggle="modal" href="#modalJob"> My Job List</a>-->
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        // }//closing 
    ?>
    <!-- Modal -->                
    <div class="modal fade bs-modal-lg" id="modalJob" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modal Title</h4>
                    </div>
                    <div class="modal-body"> Modal body goes here </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn green">Save changes</button>
                    </div> -->
                    <?php
                    require_once('form.php');
                    ?>
                </div>
            </div>
        </div>            
    <!-- End of Modal -->    
        <!-- Modal Apply Job -->                
        <div class="modal fade bs-modal-lg" id="modalApplyJob" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                 <div class="modal-dialog modal-lg">
                <div class="modal-content">
                 <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <?php
                        require_once('applyJob.php');
                    ?>
                </div>
            </div>
            </div>
        </div>            
    <!-- End of Modal -->  

    <div class="row">
        <ul class="col-12" id="job-list">
            <?php                
                // function convertDate($minute,$datePosted){//convert date from the date of job posted
                //     $display=null;
                //     if($minute<60){
                //         $display=round($minute).' minute(s) ago';
                //     }
                //     else if($minute>=60){
                //         // $display=$minute;
                //         $hhours=round($minute/60);//compute hours
                //         if($hhours<24){
                //             $display=round($hhours).' hour(s) ago';
                //         }
                //         else if($hhours>=24){
                //             $ddays=round($hhours/24);//compute days
                //             if($ddays<7){
                //                 $display=round($ddays).' day(s) ago';
                //             }
                //             else if($ddays>=7){
                //                 $wweeks=round($ddays/7);//compute weeks
                                
                //                 if($wweeks<4){
                //                     $display=round($ddays/7).' week(s) ago';
                //                 }
                //                 else if($wweeks==4){
                //                     $display=round($ddays/7).' month(s) ago';
                //                 }
                //                 else if($wweeks>4){
                //                     $date=date_create($datePosted);
                //                     $display=date_format($date, "M d Y g:i A");
                //                 }
                //             }
                            
                //         }

                        
                //     }
                //    return $display;
                // }

                // $empstatus=null;  
                // $display=null;  
                // $currentDate=null;
                // $datePosted=null;
                //     foreach($conn->query('SELECT NOW()') as $row) {
                //         $currentDate=$row['NOW()'];
                //     }
                //     $result=mysqli_query($conn,'SELECT * from tbl_jobs');
                //     if ( mysqli_num_rows($result) > 0 ) {
                //     while($row=mysqli_fetch_assoc($result)){
                //         $to_time = strtotime($currentDate);
                //         $from_time = strtotime($row['createdat']);
                //         $datePosted= round(abs($to_time - $from_time) / 60,2);
                //         $displaySkills="";

                //         if($row['status']==0){
                //             $empstatus='Part Time';
                //         }
                //         else if($row['status']==1){
                //             $empstatus='Full Time';
                //         }
                //         else if($row['status']=2){
                //             $empstatus='Freelance';
                //         }

                //         $skill_array = preg_split ("/\,/", $row['skill']); 
                //         foreach($skill_array as $skills)
                //         {
                //             $displaySkills.='<li>'.$skills.'</li>';   
                //         }                    
                //         $display.='                   
                        
                //         <li class="job-card new">
                //             <div class="job-card__info">                               
                //                 <div class="d-md-flex align-items-center">
                //                 <div class="img-c"><img src="http://projects.lollypop.design/job-listing/account.svg"/></div>
                //                 <div>
                //                     <div class="d-flex align-items-center">
                //                     <p>Account</p>
                //                     <p class="tag-new">New!</p>
                //                     <p class="tag-featured">Featured</p>
                //                     </div><a href="javascript:void(0)">
                //                     <h6 >'.$row['title'].'</h6></a>
                //                     <ul>
                //                     <li>'.convertDate($datePosted,$row['createdat']).'</li>
                //                     <li>'. $empstatus.'</li>
                //                     <li>'.$row['location'].'</li>
                //                     </ul>
                //                 </div>
                //                 </div>
                //                 '.displayEdit($usertype,$row['id'],$row['title'], $row['description'],$row['location'], $row['isworldwide'],$row['status'],$row['salary'], $row['skill']).'
                //             </div>
                //             <div>
                //            <ul class="job-card__tags">'
                //                 . $displaySkills.'
                //             </ul>                              
                //             </li>'
                //             ;
                //         }
                    
                // }
                // else{
                //     $display='No Data Found';
                // }
                // echo $display;

                // // end fetching data
                
            ?>

            </ul>
            </div>
    <!-- <div class="row">
      <ul class="col-12" id="job-list">
        <li class="job-card new featured">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/photosnap.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>Photosnap</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Senior Frontend Developer</h6></a>
                <ul>
                  <li>1d ago</li>
                  <li>Full Time</li>
                  <li>USA Only</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Frontened</li>
            <li>Senior</li>
            <li>HTML</li>
            <li>CSS</li>
            <li>JavaScript</li>
          </ul>
        </li>
        <li class="job-card new featured">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/manage.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>Manage</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Fullstack Developer</h6></a>
                <ul>
                  <li>1d ago</li>
                  <li>Part Time</li>
                  <li>Remote</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Fullstack</li>
            <li>Midweight</li>
            <li>Python</li>
            <li>React</li>
          </ul>
        </li>
        <li class="job-card new">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/account.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>Account</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Junior Frontend Developer</h6></a>
                <ul>
                  <li>2d ago</li>
                  <li>Part Time</li>
                  <li>USA Only</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Frontened</li>
            <li>Junior</li>
            <li>React</li>
            <li>Sass</li>
            <li>JavaScript</li>
          </ul>
        </li>
        <li class="job-card">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/myhome.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>MyHome</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Junior Frontend Developer</h6></a>
                <ul>
                  <li>5d ago</li>
                  <li>Contract</li>
                  <li>USA Only</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Frontened</li>
            <li>Junior</li>
            <li>CSS</li>
            <li>JavaScript</li>
          </ul>
        </li>
        <li class="job-card">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/loop-studios.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>Loop Studios</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Software Engineer</h6></a>
                <ul>
                  <li>1w ago</li>
                  <li>Full Time</li>
                  <li>Worldwide</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>FullStack</li>
            <li>Midweight</li>
            <li>JavaScript</li>
            <li>Sass</li>
            <li>Ruby</li>
          </ul>
        </li>
        <li class="job-card">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/faceit.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>FaceIt</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Senior Frontend Developer</h6></a>
                <ul>
                  <li>2w ago</li>
                  <li>Full Time</li>
                  <li>UK only</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Backend</li>
            <li>Junior</li>
            <li>Ruby</li>
            <li>RoR</li>
          </ul>
        </li>
        <li class="job-card">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/shortly.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>Shotly</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Junior Developer</h6></a>
                <ul>
                  <li>1w ago</li>
                  <li>Full Time</li>
                  <li>Worldwide</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Frontened</li>
            <li>Junior</li>
            <li>HTML</li>
            <li>Sass</li>
            <li>JavaScript</li>
          </ul>
        </li>
        <li class="job-card">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/insure.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>Insure</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Junior Frontend Developer</h6></a>
                <ul>
                  <li>1w ago</li>
                  <li>Full Time</li>
                  <li>USA Only</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Frontened</li>
            <li>Junior</li>
            <li>Vue</li>
            <li>Javascript</li>
            <li>Sass</li>
          </ul>
        </li>
        <li class="job-card">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c"><img src="http://projects.lollypop.design/job-listing/eyecam-co.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>Eyecam Co.</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Senior Frontend Developer</h6></a>
                <ul>
                  <li>1w ago</li>
                  <li>Full Time</li>
                  <li>Worldwide</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Fullstack</li>
            <li>Midweight</li>
            <li>Javascipt</li>
            <li>Django</li>
            <li>Python</li>
          </ul>
        </li>
        <li class="job-card">
          <div class="job-card__info">
            <div class="d-md-flex align-items-center">
              <div class="img-c">
                  <img src="http://projects.lollypop.design/job-listing/the-air-filter-company.svg"/></div>
              <div>
                <div class="d-flex align-items-center">
                  <p>The Air Filter Company</p>
                  <p class="tag-new">New!</p>
                  <p class="tag-featured">Featured</p>
                </div><a href="javascript:void(0)">
                  <h6>Frontend Developer</h6></a>
                <ul>
                  <li>1mo ago</li>
                  <li>Part Time</li>
                  <li>Worldwide</li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="job-card__tags">
            <li>Frontened</li>
            <li>Junior</li>
            <li>React</li>
            <li>Sass</li>
            <li>Javascript</li>
          </ul>
        </li>
      </ul>
    </div> -->
  </div>
</main>
<!-- partial -->
    <script  src="script.js"></script>
    <!-- BEGIN CORE PLUGINS -->
    <script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="../../assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../../assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
    <script src="../../assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <!-- <script src="../../assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
    <script src="../../assets/pages/scripts/components-typeahead.min.js" type="text/javascript"></script> -->
    <!-- <script src="../../assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script> -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="../../assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
    <script src="../../assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
    <!-- <script src="../../assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script> -->
    <!-- <script src="../../assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script> -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="../../assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
    <script src="../../assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
    <script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
</body>
</html>
