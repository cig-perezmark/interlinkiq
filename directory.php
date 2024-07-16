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
                    <a href="https://interlinkiq.com/">
                        <img src="assets/img/interlinkiq v3.png" alt="logo" class="logo-default" height="70" style="margin-top:-3px;" />
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
                            <thead style="background-color:#277BC0;color:#fff;font-weight:600;">
                                <tr>
                                    <td>Name</td>
                                      <td style="width:45%;">About</td>
                                      <td>Products</td>
                                      <td>Services</td>
                                      <!--<td>Food Safety Event</td>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $t=1;
                                    $query = "SELECT * FROM tbl_Customer_Relationship left join tbl_Customer_Relationship_FSE on crm_id = crm_ids where Account_Directory = 1 and account_about !='' and account_product !='' order by crm_id ASC";
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_array($result)){?>
                                        <tr>
                                            <td style=""><a target="_blank" href="https://interlinkiq.com/login.php"><?php echo htmlentities($row['account_name'] ?? ''); ?></a></td>
                                            <td>
                                                <?php  
                                                    $string = strip_tags(htmlentities($row['account_about'] ?? '')); 
                                                    if(strlen($string) > 250):
                                                        $stringCut = substr($string,0,250);
                                                        $endPoint = strrpos($stringCut,' ');
                                                        $string = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                                                        $string .='&nbsp;<a style="font-size:12px;" target="_blank" href="https://interlinkiq.com/login.php">See more...</a>';
                                                    endif;
                                                    echo $string;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $stringProduct = strip_tags(htmlentities($row['account_product'] ?? '')); 
                                                    if(strlen($stringProduct) > 150):
                                                        $stringCut = substr($stringProduct,0,150);
                                                        $endPoint = strrpos($stringCut,' ');
                                                        $stringProduct = $endPoint?substr($stringCut,0,$endPoint):substr($stringCut,0);
                                                        $stringProduct .='&nbsp;<a style="font-size:12px;" target="_blank" href="https://interlinkiq.com/login.php">See more...</a>';
                                                    endif;
                                                    echo $stringProduct;
                                                ?>
                                            </td>
                                            <td><?php echo htmlentities($row['account_service'] ?? ''); ?></td>
                                            <!--<td>-->
                                            <?php //echo $row['FSE_Title']; ?>
                                            <!--</td>-->
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
    <!-- END CONTAINER -->
<?php include "navbar/footer.php"; ?>