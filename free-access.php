<?php
    $title = "Free Access";
    $site = "free-access";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .img_cover {
        width: 100px;
        height: 100px;
        object-fit: contain;
        object-position: center;
        border-radius: 100% !important;
        border: 1px solid #c1c1c1;
        overflow: hidden;
        margin: auto;
        position: relative;
    }
    .img_cover img {
        width: 100%;
    }
    .img_cover button {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        display: none;
    }
    .img_cover:hover button {
        display: block;
    }
</style>

            <!--Start of App Cards-->
            <!-- BEGIN : USER CARDS -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-grid font-dark"></i>
                                <span class="caption-subject font-dark bold uppercase">Module</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                            <?php
                                $selectMenu = mysqli_query( $conn,"
                                    SELECT 
                                    m.ID AS m_ID,
                                    m.collab AS m_collab,
                                    m.icon AS m_icon,
                                    m.url AS m_url,
                                    m.description AS m_description,
                                    s.date_start AS s_date_start,
                                    s.date_end AS s_date_end,
                                    p.plugin_id AS p_plugin_id,
                                    p.plugin_name AS p_plugin_name,
                                    p.available AS p_available,
                                    p.file_attachment AS p_file_attachment
                                    FROM tbl_menu AS m
                                    
                                    LEFT JOIN (
                                        SELECT
                                        *
                                        FROM tbl_menu_subscription
                                        WHERE display = 1 
                                        AND deleted = 0
                                        AND type = 1
                                        AND user_id = $switch_user_id
                                    ) AS s
                                    ON m.ID = s.menu_id
                                    
                                    LEFT JOIN (
                                    	SELECT
                                        *
                                        FROM tblPlugins
                                        WHERE deleted = 0
                                    ) AS p
                                    ON m.ID = p.menu_id
                                    
                                    WHERE m.module = 1 
                                    AND m.type = 0 
                                    AND m.deleted = 0 
                                    AND s.date_start IS NOT NULL
                                    AND s.date_end IS NOT NULL
                                    
                                    ORDER BY m.description ASC
                                " );
                                if ( mysqli_num_rows($selectMenu) > 0 ) {
                                    while($rowMenu = mysqli_fetch_array($selectMenu)) {
                                        $menu_ID = $rowMenu['m_ID'];
                                        $menu_collab = $rowMenu['m_collab'];
                                        $menu_icon = $rowMenu['m_icon'];
                                        $menu_url = $rowMenu['m_url'];
                                        $menu_description = $rowMenu['m_description'];
    
                                        $sub_date_start = $rowMenu["s_date_start"];
                                        $sub_date_start = new DateTime($sub_date_start);
                                        $sub_date_start_o = $sub_date_start->format('Y/m/d');
                                        $sub_date_start = $sub_date_start->format('M d, Y');
    
                                        $sub_date_end = $rowMenu["s_date_end"];
                                        $sub_date_end = new DateTime($sub_date_end);
                                        $sub_date_end_o = $sub_date_end->format('Y/m/d');
                                        $sub_date_end = $sub_date_end->format('M d, Y');
                                        
                                        $p_plugin_id = $rowMenu['p_plugin_id'];
                                        $p_plugin_name = stripcslashes($rowMenu['p_plugin_name']);
                                        $p_available = stripcslashes($rowMenu['p_available']);
                                        $p_file_attachment = $rowMenu['p_file_attachment'];
                                        $m_url = $rowMenu['m_url'];
    
                                        echo '<div class="col-md-3 text-center margin-bottom-15 '; if ($menu_collab == 1 AND $current_userEmployeeID > 0) { echo menu($menu_url, $current_userEmployerID, $current_userEmployeeID); } echo'" style="height: 170px; min-height: 170px;">
                                            <div class="img_cover margin-bottom-15">
                                                <img src="data:image/png;base64,'.$p_file_attachment.'" onerror="this.onerror=null;this.src=\'https://via.placeholder.com/100x100/EFEFEF/AAAAAA.png?text=no+image\';"  />';
                                            echo '</div>';

                                            if ($m_url) {
                                                echo '<a href="'.$m_url.'" class="blue-steel bold" target="_blank">'.$menu_description.'</a>';
                                            } else {
                                                echo $menu_description;
                                            }
                                        echo '</div>';
                                    }
                                }
                            ?>
        				</div>
                    </div>
                </div>
    	    </div><!-- END CONTENT BODY -->
        
    	<?php include('footer.php'); ?>
    </body>
</html>
