<?php 
    $title = "Archive";
    $site = "archive";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
</style>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Department / Area</th>
                                                    <th>No. of Files</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    // $result = mysqli_query( $conn,"SELECT ID, name FROM tbl_archiving_department ORDER BY name" );
                                                    $result = mysqli_query( $conn,"
                                                        SELECT
                                                        ID,
                                                        name,
                                                        count,
                                                        src
                                                        FROM (
                                                            SELECT 
                                                            ad.ID, 
                                                            ad.name,
                                                            COUNT(ad.ID) AS count,
                                                            '1' AS src

                                                            FROM tbl_archiving_department AS ad

                                                            RIGHT JOIN (
                                                                SELECT 
                                                                ID,
                                                                department_id
                                                                FROM tbl_archiving
                                                                WHERE user_id = $switch_user_id
                                                                AND src = 1
                                                            ) AS a
                                                            ON ad.ID = a.department_id
                                                            
                                                            GROUP BY ad.ID

                                                            UNION ALL

                                                            SELECT 
                                                            d.ID,
                                                            d.title AS name,
                                                            COUNT(d.ID) AS count,
                                                            '2' AS src
                                                            FROM tbl_hr_department AS d

                                                            RIGHT JOIN (
                                                                SELECT 
                                                                ID,
                                                                department_id
                                                                FROM tbl_archiving
                                                                WHERE user_id = $switch_user_id
                                                                AND src = 2
                                                            ) AS a2
                                                            ON d.ID = a2.department_id

                                                            WHERE d.deleted = 0 
                                                            AND d.status = 1 
                                                            AND d.user_id = $switch_user_id
                                                            AND d.facility_switch = $facility_switch_user_id

                                                            GROUP BY d.ID
                                                        ) r
                                                        GROUP BY r.ID, r.src
                                                        ORDER BY r.name
                                                    " );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = htmlentities($row['ID'] ?? '');
                                                            $name = htmlentities($row['name'] ?? '');
                                                            $count = $row['count'];
                                                            $src = $row['src'];

                                                            if ($count > 0) {
                                                                echo '<tr id="tr_'. $ID .'" onclick="btnViewDepartment('. $ID .', '.$FreeAccess.', '.$src.')">
                                                                    <td>'. $name .'</td>
                                                                    <td>'. $count .'</td>
                                                                </tr>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php echo '<button class="btn btn-success hide" id="tableDataViewAll" onclick="btnViewDepartmentViewAll('.$switch_user_id.', '.$FreeAccess.')">View All</button>'; ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-title">
                                    <div class="caption pictogram-align">
                                        <span class="icon-folder-alt font-dark fa-fw"></span>
                                        <span class="caption-subject font-dark bold uppercase">Archived Records</span>
                                        <?php
                                            // if($current_client == 0) {
                                            //     $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                            //     while ($row = mysqli_fetch_assoc($result)) {
                                            //         $type_id = htmlentities($row["type"] ?? '');
                                            //         $file_title = htmlentities($row["file_title"] ?? '');
                                            //         $video_url = htmlentities($row["youtube_link"] ?? '');
                                                    
                                            //         $file_upload = htmlentities($row["file_upload"] ?? '');
                                            //         if (!empty($file_upload)) {
                                        	   //         $fileExtension = fileExtension($file_upload);
                                        				// $src = $fileExtension['src'];
                                        				// $embed = $fileExtension['embed'];
                                        				// $type = $fileExtension['type'];
                                        				// $file_extension = $fileExtension['file_extension'];
                                        	   //         $url = $base_url.'uploads/instruction/';
                                        
                                            //     		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                            //         }
                                                    
                                            //         $icon = htmlentities($row["icon"] ?? '');
                                            //         if (!empty($icon)) { 
                                            //             if ($type_id == 0) {
                                            //                 echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                            //             } else {
                                            //                 echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                            //             }
                                            //         }
	                                           // }
                                            // }
                                        ?>
                                        
                                        <?php
                                            $pictogram = 'arc_record';
                                            if ($switch_user_id == 163) {
                                                echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                            } else {
                                                $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                    $row = mysqli_fetch_array($selectPictogram);

                                                    $files = '';
                                                    $type = 'iframe';
                                                    if (!empty($row["files"])) {
                                                        $arr_filename = explode(' | ', $row["files"]);
                                                        $arr_filetype = explode(' | ', $row["filetype"]);
                                                        $str_filename = '';

                                                        foreach($arr_filename as $val_filename) {
                                                            $str_filename = $val_filename;
                                                        }
                                                        foreach($arr_filetype as $val_filetype) {
                                                            $str_filetype = $val_filetype;
                                                        }

                                                        $files = $row["files"];
                                                        if ($row["filetype"] == 1) {
                                                            $fileExtension = fileExtension($files);
                                                            $src = $fileExtension['src'];
                                                            $embed = $fileExtension['embed'];
                                                            $type = $fileExtension['type'];
                                                            $file_extension = $fileExtension['file_extension'];
                                                            $url = $base_url.'uploads/pictogram/';

                                                            $files = $src.$url.rawurlencode($files).$embed;
                                                        } else if ($row["filetype"] == 3) {
                                                            $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                        }
                                                    }

                                                    if (!empty($files)) {
                                                        echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" >Add New Archiving</a>
                                                </li>
                                                <?php if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163): ?>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#modalInstruction" onclick="btnInstruction()">Add New Instruction</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable" style="border: 0;">
                                        <table class="table table-bordered table-hover" id="tableData">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="text-center" style="width: 135px;">Document Date</th>
                                                    <th style="width: 135px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = mysqli_query( $conn,"SELECT ID, record, files_date, deleted, reason FROM tbl_archiving WHERE deleted = 0 AND user_id = $switch_user_id ORDER BY record" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = htmlentities($row['ID'] ?? '');
                                                            $record = htmlentities($row['record'] ?? '');
                                                            $files_date = htmlentities($row['files_date'] ?? '');

                                                            $approval = '';
                                                            if ($row['deleted'] == 0 AND !empty($row['reason'])) {
                                                                $reason_array = explode(" | ", htmlentities($row['reason'] ?? ''));
                                                                $reason = htmlentities($reason_array[1] ?? '');
                                                                $approval = '<br><i class="help-block">User requested to delete this item because '.$reason.'</i>
                                                                <div class="remark_action">
                                                                    <a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnAccept('.$ID.')">Accept</a>
                                                                     | 
                                                                    <a href="javascript:;" type="button" class="btn btn-sm btn-link" onclick="btnReject('.$ID.')">Reject</a>
                                                                </div>';
                                                            }

                                                            echo '<tr id="tr_'. $ID .'">
                                                                <td>'.$record.$approval.'</td>
                                                                <td class="text-center">'.$files_date.'</td>
                                                                <td class="text-center">';

                                                                    if ($FreeAccess == false) {
                                                                        echo '<div class="btn-group btn-group-circle">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('. $ID.')">Edit</a>
                                                                            <a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>
                                                                            <a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('. $ID .', '.$FreeAccess.')">Delete</a>
                                                                        </div>';
                                                                    } else {
                                                                        echo '<a href="#modalViewFile" class="btn btn-success btn-sm btnView btn-circle" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>';
                                                                    }

                                                                echo '</td>
                                                            </tr>';
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL SERVICE -->
                        <div class="modal fade" id="modalNew" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalNew">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title pictogram-align">
                                                Archive
                                                <?php
                                                    $pictogram = 'arc_add';
                                                    if ($switch_user_id == 163) {
                                                        echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                    } else {
                                                        $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                        if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                            $row = mysqli_fetch_array($selectPictogram);

                                                            $files = '';
                                                            $type = 'iframe';
                                                            if (!empty($row["files"])) {
                                                                $arr_filename = explode(' | ', $row["files"]);
                                                                $arr_filetype = explode(' | ', $row["filetype"]);
                                                                $str_filename = '';

                                                                foreach($arr_filename as $val_filename) {
                                                                    $str_filename = $val_filename;
                                                                }
                                                                foreach($arr_filetype as $val_filetype) {
                                                                    $str_filetype = $val_filetype;
                                                                }

                                                                $files = $row["files"];
                                                                if ($row["filetype"] == 1) {
                                                                    $fileExtension = fileExtension($files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/pictogram/';

                                                                    $files = $src.$url.rawurlencode($files).$embed;
                                                                } else if ($row["filetype"] == 3) {
                                                                    $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                }
                                                            }

                                                            if (!empty($files)) {
                                                                echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Department / Area</label>
                                                        <select class="form-control select2" name="department_id" onchange="changeDepartment(this, 1)" style="width: 100%;">
                                                            <option value="">Select</option>
                                                            <?php
                                                                // $result = mysqli_query($conn,"
                                                                //     SELECT 
                                                                //     d.ID AS d_ID,
                                                                //     d.name AS d_name
                                                                //     FROM tbl_archiving_department AS d

                                                                //     LEFT JOIN (
                                                                //         SELECT
                                                                //         *
                                                                //         FROM tbl_archiving
                                                                //     ) AS a
                                                                //     ON a.department_id = d.ID

                                                                //     WHERE a.user_id = $switch_user_id

                                                                //     GROUP BY d.name

                                                                //     ORDER BY d.name
                                                                // ");
                                                                // $result = mysqli_query($conn,"
                                                                //     SELECT
                                                                //     ID,
                                                                //     name,
                                                                //     src
                                                                //     FROM (
                                                                //         SELECT 
                                                                //         ad.ID, 
                                                                //         ad.name,
                                                                //         '1' AS src

                                                                //         FROM tbl_archiving_department AS ad

                                                                //         RIGHT JOIN (
                                                                //             SELECT 
                                                                //             ID,
                                                                //             department_id
                                                                //             FROM tbl_archiving
                                                                //             WHERE user_id = $switch_user_id
                                                                //             AND src = 1
                                                                //         ) AS a
                                                                //         ON ad.ID = a.department_id

                                                                //         UNION ALL

                                                                //         SELECT 
                                                                //         d.ID,
                                                                //         d.title AS name,
                                                                //         '2' AS src
                                                                //         FROM tbl_hr_department AS d

                                                                //         WHERE d.deleted = 0 
                                                                //         AND d.status = 1 
                                                                //         AND d.user_id = $switch_user_id
                                                                //         AND d.facility_switch = $facility_switch_user_id
                                                                //     ) r
                                                                //     GROUP BY r.ID, r.src
                                                                //     ORDER BY r.name
                                                                // ");
                                                                $result = mysqli_query($conn,"
                                                                    SELECT
                                                                    ID,
                                                                    name,
                                                                    count,
                                                                    src
                                                                    FROM (
                                                                        SELECT 
                                                                        ad.ID, 
                                                                        ad.name,
                                                                        COUNT(ad.ID) AS count,
                                                                        '1' AS src
            
                                                                        FROM tbl_archiving_department AS ad
            
                                                                        RIGHT JOIN (
                                                                            SELECT 
                                                                            ID,
                                                                            department_id
                                                                            FROM tbl_archiving
                                                                            WHERE user_id = $switch_user_id
                                                                            AND src = 1
                                                                        ) AS a
                                                                        ON ad.ID = a.department_id
                                                                        
                                                                        GROUP BY ad.ID
            
                                                                        UNION ALL
            
                                                                        SELECT 
                                                                        d.ID,
                                                                        d.title AS name,
                                                                        COUNT(d.ID) AS count,
                                                                        '2' AS src
                                                                        FROM tbl_hr_department AS d
            
                                                                        RIGHT JOIN (
                                                                            SELECT 
                                                                            ID,
                                                                            department_id
                                                                            FROM tbl_archiving
                                                                            WHERE user_id = $switch_user_id
                                                                            AND src = 2
                                                                        ) AS a2
                                                                        ON d.ID = a2.department_id
            
                                                                        WHERE d.deleted = 0 
                                                                        AND d.status = 1 
                                                                        AND d.user_id = $switch_user_id
                                                                        AND d.facility_switch = $facility_switch_user_id
            
                                                                        GROUP BY d.ID
                                                                    ) r
                                                                    GROUP BY r.ID, r.src
                                                                    ORDER BY r.name
                                                                ");
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = htmlentities($row['ID'] ?? '');
                                                                    $name = htmlentities($row['name'] ?? '');
                                                                    $src = $row['src'];
                                                                    echo '<option value="'.$ID.' | '.$src.'">'. $name .'</option>';
                                                                }
                                                            ?>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <input type="text" class="form-control margin-top-15 display-none" name="department_id_other" id="department_id_other_1" placeholder="Specify others" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Name</label>
                                                        <input type="type" class="form-control" name="record" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Upload Document</label>
                                                        <select class="form-control" name="filetype" onchange="changeType(this)" required>
                                                            <option value="0">Select option</option>
                                                            <option value="1">Manual Upload</option>
                                                            <option value="2">Youtube URL</option>
                                                            <option value="3">Google Drive URL</option>
                                                            <option value="4">Sharepoint URL</option>
                                                        </select>
                                                        <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                                                        <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="ccontrol-label">Document Date</label>
                                                        <input class="form-control" type="date" name="file_date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <textarea class="form-control" name="description" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Comment/Notes</label>
                                                <textarea class="form-control" name="notes" placeholder="Write some comment or notes here" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_archiving" id="btnSave_archiving" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" class="modalForm modalUpdate">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title pictogram-align">
                                                Archive
                                                <?php
                                                    $pictogram = 'arc_edit';
                                                    if ($switch_user_id == 163) {
                                                        echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                    } else {
                                                        $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                        if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                            $row = mysqli_fetch_array($selectPictogram);

                                                            $files = '';
                                                            $type = 'iframe';
                                                            if (!empty($row["files"])) {
                                                                $arr_filename = explode(' | ', $row["files"]);
                                                                $arr_filetype = explode(' | ', $row["filetype"]);
                                                                $str_filename = '';

                                                                foreach($arr_filename as $val_filename) {
                                                                    $str_filename = $val_filename;
                                                                }
                                                                foreach($arr_filetype as $val_filetype) {
                                                                    $str_filetype = $val_filetype;
                                                                }

                                                                $files = $row["files"];
                                                                if ($row["filetype"] == 1) {
                                                                    $fileExtension = fileExtension($files);
                                                                    $src = $fileExtension['src'];
                                                                    $embed = $fileExtension['embed'];
                                                                    $type = $fileExtension['type'];
                                                                    $file_extension = $fileExtension['file_extension'];
                                                                    $url = $base_url.'uploads/pictogram/';

                                                                    $files = $src.$url.rawurlencode($files).$embed;
                                                                } else if ($row["filetype"] == 3) {
                                                                    $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                                }
                                                            }

                                                            if (!empty($files)) {
                                                                echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_archiving" id="btnUpdate_archiving" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalViewFile" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title pictogram-align">
                                            Archive
                                            <?php
                                                $pictogram = 'arc_file';
                                                if ($switch_user_id == 163) {
                                                    echo '<div class="pictogram" href="#modalPictogram" data-toggle="modal" onclick="btnPictogram(\''.$pictogram.'\')"></div>';
                                                } else {
                                                    $selectPictogram = mysqli_query( $conn,"SELECT * FROM tbl_pictogram WHERE code = '$pictogram'" );
                                                    if ( mysqli_num_rows($selectPictogram) > 0 ) {
                                                        $row = mysqli_fetch_array($selectPictogram);

                                                        $files = '';
                                                        $type = 'iframe';
                                                        if (!empty($row["files"])) {
                                                            $arr_filename = explode(' | ', $row["files"]);
                                                            $arr_filetype = explode(' | ', $row["filetype"]);
                                                            $str_filename = '';

                                                            foreach($arr_filename as $val_filename) {
                                                                $str_filename = $val_filename;
                                                            }
                                                            foreach($arr_filetype as $val_filetype) {
                                                                $str_filetype = $val_filetype;
                                                            }

                                                            $files = $row["files"];
                                                            if ($row["filetype"] == 1) {
                                                                $fileExtension = fileExtension($files);
                                                                $src = $fileExtension['src'];
                                                                $embed = $fileExtension['embed'];
                                                                $type = $fileExtension['type'];
                                                                $file_extension = $fileExtension['file_extension'];
                                                                $url = $base_url.'uploads/pictogram/';

                                                                $files = $src.$url.rawurlencode($files).$embed;
                                                            } else if ($row["filetype"] == 3) {
                                                                $files = preg_replace('#[^/]*$#', '', $files).'preview';
                                                            }
                                                        }

                                                        if (!empty($files)) {
                                                            echo '<div class="pictogram" href="'.$files.'" data-src="'.$files.'" data-fancybox data-type="'.$type.'"></div>';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- / END MODAL AREA -->
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                var i = '<?php echo isset($_GET['i']) ? $_GET['i']:''; ?>';
                if (i != '') {
                    $('#modalViewFile').modal('show');
                    btnView(i, 0);
                }
                
                $.fn.modal.Constructor.prototype.enforceFocus = function() {};

                $('.select2').select2();

                fancyBoxes();
                $('#tableData').DataTable();
            });

            function btnDelete(id) {
                swal({
                    title: "Are you sure?",
                    text: "Write some reason on it!",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Reason"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnDelete_archiving="+id+"&reason="+inputValue,
                        dataType: "html",
                        success: function(response){
                            // $('.panel_'+id+' > .panel-heading h4 a').append('<i class="fa fa-warning font-red" style="margin-left: 5px;"></i>');
                        }
                    });
                    swal("Notification Sent!", "You wrote: " + inputValue, "success");
                });
            }
            function btnAccept(id) {
                swal({
                    title: "Are you sure?",
                    text: "Please confirm if the data are correct!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, confirm it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnAccept_archiving="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id+' .remark_action').html('<span class="text-success">Accepted!</span>');
                        }
                    });
                    swal("Accepted!", "Data is accepted", "success");
                });
            }
            function btnReject(id) {
                swal({
                    title: "Are you sure?",
                    text: "Please confirm if the data are correct!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, reject it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type: "GET",
                        url: "function.php?btnReject_archiving="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tr_'+id+' .remark_action').html('<span class="text-danger">Rejected!</span>');
                        }
                    });
                    swal("Rejected!", "Data is rejected", "success");
                });
            }
            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_archiving="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        $('.select2').select2();
                        selectMulti();
                    }
                });
            }
            function btnView(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewFile_archiving="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewFile .modal-body").html(data);
                    }
                });
            }
            function btnViewDepartment(id, freeaccess, src) {
                $('#tableData').DataTable().clear();
                $('#tableData').DataTable().destroy();
                $('#tableData body').empty();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartment_archiving="+id+"&freeaccess="+freeaccess+"&src="+src,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').removeClass('hide');
                        $("#tableData tbody").html(data);
                        $('#tableData').DataTable();
                    }
                });
            }
            function btnViewDepartmentViewAll(id, freeaccess) {
                $('#tableData').DataTable().clear();
                $('#tableData').DataTable().destroy();
                $('#tableData body').empty();
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartmentViewAll_archiving="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').addClass('hide');
                        $('#tableData').DataTable();
                    }
                });
            }
            function changeDepartment(id, modal) {
                if (id.value == "other") {
                    $('#department_id_other_'+modal).show();
                } else {
                    $('#department_id_other_'+modal).hide();
                }
            }

            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_archiving',true);

                var l = Ladda.create(document.querySelector('#btnSave_archiving'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);
                            }
                       }, false);
                       return xhr;
                    },
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<tr id="tr_'+obj.ID+'">';
                                result += '<td>'+obj.record+'</td>';
                                result += '<td class="text-center">'+obj.files_date+'</td>';
                                result += '<td class="text-center">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        result += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    result += '</div>';
                                result += '</td>';
                            result += '</tr>';

                            $("#tableData tbody").prepend(result);
                            $('#modalNew').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            $(".modalUpdate").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnUpdate_archiving',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_archiving'));
                l.start();

                $.ajax({
                    url: "function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                l.setProgress(percentComplete / 100);
                            }
                       }, false);
                       return xhr;
                    },
                    success:function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";

                            var obj = jQuery.parseJSON(response);
                            var result = '<td>'+obj.record+'</td>';
                            result += '<td class="text-center">'+obj.files_date+'</td>';
                            result += '<td class="text-center">';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                    result += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                result += '</div>';
                            result += '</td>';

                            $("#tableData tbody #tr_"+obj.ID).html(result);
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
        </script>
    </body>
</html>