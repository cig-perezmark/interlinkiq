
<?php 
include "navbar/header.php";
include "database.php";
 
?>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner" style="background-color:#fff;">
                <!-- BEGIN LOGO -->
                <div class="page-logo" style="background-color:#fff;">
                    <a href="#">
                         <img src="assets/img/interlinkiq v3.png" alt="logo" class="logo-default" height="70" style="margin-top:-3px;" /> </a>
                        </a>
                </div>
                <div class="page-top">
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <?php include "navbar/topbar.php"; ?>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
                <div class="portlet-title">
                    <br><br><br><br>
                    <br><br><br><br>
                </div>
                <div class="col-md-12">
                     <div class="portlet-body">
                            <table class="table table-bordered table-hover" id="tableData2">
                                <thead>
                                    <tr>
                                        <th style="font-weight:600;font-size:25px;">Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $t=1;
                                        $query = "SELECT * FROM tbl_blogs_pages where status_publish = 1 order by blogs_title ASC";
                                        $result = mysqli_query($conn, $query);
                                                                    
                                        while($row = mysqli_fetch_array($result)){?>
                                        <tr>
                                            
                                            <td>
                                                 <div class="panel-group accordion " id="accordion1">
                                                    <div class="panel panel-primary" >
                                                        <div class="panel-heading" style="background-color:#277BC0;">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#<?php echo $row['blogs_id']; ?>"> <?php echo $row['description_view']; ?> </a>
                                                            </h4>
                                                        </div>
                                                        <div id="<?php echo $row['blogs_id']; ?>" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                               <?php 
                                                                $blogid = $row['blogs_id'];
                                                                $query1 = "SELECT * FROM tbl_blogs_pages where blogs_id = $blogid";
                                                                $result1 = mysqli_query($conn, $query1);
                                                                                            
                                                                while($row1 = mysqli_fetch_array($result1)){?>
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $row1['descriptions']; ?><br></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                <?php }
                                                               ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                         </tr>
                                   <?php } ?>
                                </tbody>
                            </table>
                    </div>
                </div>
    <!-- END CONTAINER -->
  <?php
  include "navbar/footer.php";
  ?>
  <script>
      
  </script>