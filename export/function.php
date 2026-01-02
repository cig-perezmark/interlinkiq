<?php
    include_once ('../database_iiq.php');
    
    function fileList($item_ID) {
        global $conn;
        $file_names = array();

        $selectData = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE deleted = 0 AND library_id = $item_ID");
        if ( mysqli_num_rows($selectData) > 0 ) {
            while($rowData = mysqli_fetch_array($selectData)) {
                $data_files = urldecode($rowData['files']);
                array_push($file_names, $data_files);
            }
        }

        return $file_names;
    }
    function fileParent($child_id, $file_names_child) {
        global $conn;

        $resultItemChild = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE deleted = 0 AND ID = $child_id" );
        if ( mysqli_num_rows($resultItemChild) > 0 ) {
            $rowItemChild = mysqli_fetch_array($resultItemChild);
            $item_ID = $rowItemChild["ID"];
            $new_parent_id = $rowItemChild["parent_id"];
            $new_child_id = $rowItemChild["child_id"];
            $file_names_child_new = array();

            $file_names_child = array_merge($file_names_child, fileList($item_ID));

            if (!empty($new_child_id)) {
                $new_child_id_arr = explode(', ', $new_child_id);
                foreach($new_child_id_arr as $child_id_new){
                    $file_names_child = array_merge($file_names_child, fileParent($child_id_new, $file_names_child_new));
                }
            }
        }

        return $file_names_child;
    }
    function zipFilesAndDownload($file_names, $file_zip_name, $file_path) {
        //echo $file_path;die;
        $zip = new \ZipArchive();
        //create the file and throw the error if unsuccessful
        if ($zip->open($file_zip_name, ZIPARCHIVE::CREATE )!==TRUE) {
            exit("cannot open <$file_zip_name>\n");
        }
        //add each files of $file_name array to archive
        foreach($file_names as $files)
        {
            $zip->addFile($file_path.$files, $files);
            //echo $file_path.$files,$files."

        }
        $zip->close();
        //then send the headers to force download the zip file
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$file_zip_name");
        header("Content-length: " . filesize($file_zip_name));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile("$file_zip_name");
        exit;
    }
    
    if( isset($_GET['modalDownload']) ) {
        $ID = $_GET['modalDownload'];

        $resultItem = mysqli_query( $conn,"SELECT * FROM tbl_library WHERE deleted = 0 AND ID = $ID" );
        if ( mysqli_num_rows($resultItem) > 0 ) {
            $rowItem = mysqli_fetch_array($resultItem);
            $item_ID = $rowItem["ID"];
            $new_parent_id = $rowItem["parent_id"];
            $new_child_id = $rowItem["child_id"];

            $name = $rowItem["name"];
            $array_name_id = explode(", ", $name);
            if ( count($array_name_id) == 4 ) {
                $data_name = array();

                $selectType = mysqli_query($conn,"SELECT * FROM tbl_library_type WHERE ID = '".$array_name_id[0]."'");
                if ( mysqli_num_rows($selectType) > 0 ) {
                    while($rowType = mysqli_fetch_array($selectType)) {
                        array_push($data_name, $rowType["name"]);
                    }
                }

                $selectCategory = mysqli_query($conn,"SELECT * FROM tbl_library_category WHERE ID = '".$array_name_id[1]."'");
                if ( mysqli_num_rows($selectCategory) > 0 ) {
                    while($rowCategory = mysqli_fetch_array($selectCategory)) {
                        array_push($data_name, $rowCategory["name"]);
                    }
                }

                $selectScope = mysqli_query($conn,"SELECT * FROM tbl_library_scope WHERE ID = '".$array_name_id[2]."'");
                if ( mysqli_num_rows($selectScope) > 0 ) {
                    while($rowScope = mysqli_fetch_array($selectScope)) {
                        array_push($data_name, $rowScope["name"]);
                    }
                }

                $selectModule = mysqli_query($conn,"SELECT * FROM tbl_library_module WHERE ID = '".$array_name_id[3]."'");
                if ( mysqli_num_rows($selectModule) > 0 ) {
                    while($rowModule = mysqli_fetch_array($selectModule)) {
                        array_push($data_name, $rowModule["name"]);
                    }
                }

                $name = implode(" - ",$data_name);
            }
            $file_zip_name = date('Y-m-d') .'_backup_'.$name.'.zip';
            $file_path = '../uploads/library/';
            $file_names = array();
            $file_names_child = array();

            $file_names = array_merge($file_names, fileList($item_ID));
            if (!empty($new_child_id)) {
                $new_child_id_arr = explode(', ', $new_child_id);
                foreach($new_child_id_arr as $child_id){
                    $file_names = array_merge($file_names, fileParent($child_id, $file_names_child));
                }
            }

            if ( count($file_names) > 0 ) { 
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLCD']) ) {
        $user_id = $_GET['modalDLCD'];
        $file_zip_name = date('Y-m-d') .'_backup_library.zip';
        $file_path = '../uploads/library/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
			f.files AS f_files
			FROM tbl_library AS l

			RIGHT JOIN (
			    SELECT
			    *
			    FROM tbl_library_file
			    WHERE deleted = 0
			    AND filetype = 1
			    AND files IS NOT NULL
			    AND files != ''
			) AS f
			ON l.ID = f.library_id

			WHERE l.deleted = 0 
			AND l.user_id = $user_id

			UNION ALL

			SELECT
			c.files AS f_files
			FROM tbl_library AS l

			RIGHT JOIN (
			    SELECT
			    *
			    FROM tbl_library_compliance
			    WHERE deleted = 0
			    AND filetype = 1
			    AND files IS NOT NULL
			    AND files != ''
			) AS c
			ON l.ID = c.library_id

			WHERE l.deleted = 0 
			AND l.user_id = $user_id

			UNION ALL

			SELECT
			r.files AS f_files
			FROM tbl_library AS l

			RIGHT JOIN (
			    SELECT
			    *
			    FROM tbl_library_review
			    WHERE is_deleted = 0
			    AND filetype = 1
			    AND files IS NOT NULL
			    AND files != ''
			) AS r
			ON l.ID = r.library_id

			WHERE l.deleted = 0 
			AND l.user_id = $user_id

			UNION ALL

			SELECT
			t.files AS f_files
			FROM tbl_library AS l

			RIGHT JOIN (
			    SELECT
			    *
			    FROM tbl_library_template
			    WHERE is_deleted = 0
			    AND filetype = 1
			    AND files IS NOT NULL
			    AND files != ''
			) AS t
			ON l.ID = t.library_id

			WHERE l.deleted = 0 
			AND l.user_id = $user_id

			UNION ALL

			SELECT
			ref.files AS f_files
			FROM tbl_library AS l

			RIGHT JOIN (
			    SELECT
			    *
			    FROM tbl_library_references
			    WHERE is_deleted = 0
			    AND filetype = 1
			    AND files IS NOT NULL
			    AND files != ''
			) AS ref
			ON l.ID = ref.library_id

			WHERE l.deleted = 0 
			AND l.user_id = $user_id

			UNION ALL

			SELECT
			v.files COLLATE utf8mb4_general_ci AS f_files
			FROM tbl_library AS l

			RIGHT JOIN (
			    SELECT
			    *
			    FROM tbl_library_video
			    WHERE is_deleted = 0
			    AND filetype = 1
			    AND files IS NOT NULL
			    AND files != ''
			) AS v
			ON l.ID = v.library_id

			WHERE l.deleted = 0 
			AND l.user_id = $user_id
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["f_files"];
                array_push($file_names, $f_files);
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        }
    }
    if( isset($_GET['modalDLE']) ) {
        $user_id = $_GET['modalDLE'];
        $file_zip_name = date('Y-m-d') .'_backup_enterprise.zip';
        $file_path = '../companyDetailsFolder/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            BrandLogos AS files 
            FROM tblEnterpiseDetails 
            WHERE users_entities = $user_id
            AND BrandLogos IS NOT NULL
            AND BrandLogos != ''

            UNION ALL

            SELECT
            files
            FROM tblEnterpiseDetails_BusinessStructure
            WHERE deleted = 0
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''

            UNION ALL

            SELECT
            files
            FROM tblEnterpiseDetails_Agent
            WHERE deleted = 0
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''

            UNION ALL

            SELECT
            supporting_file AS files
            FROM tblFacilityDetails_registration
            WHERE ownedby = $user_id
            AND supporting_file IS NOT NULL
            AND supporting_file != ''

            UNION ALL

            SELECT
            EnterpriseRecordsFile AS files
            FROM tblEnterpiseDetails_Records
            WHERE user_cookies = $user_id
            AND EnterpriseRecordsFile IS NOT NULL
            AND EnterpriseRecordsFile != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                array_push($file_names, $f_files);
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLF']) ) {
        $user_id = $_GET['modalDLF'];
        $file_zip_name = date('Y-m-d') .'_backup_facility.zip';
        $file_path = '../facility_files_Folder/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            supporting_file AS files
            FROM tblFacilityDetails_registration
            WHERE ownedby = $user_id
            AND supporting_file IS NOT NULL
            AND supporting_file != ''

            UNION ALL

            SELECT 
            Permits AS files
            FROM tblFacilityDetails_Permits
            WHERE user_cookies = $user_id
            AND Permits IS NOT NULL
            AND Permits != ''

            UNION ALL

            SELECT 
            Accreditation AS files
            FROM tblFacilityDetails_Accreditation
            WHERE user_cookies = $user_id
            AND Accreditation IS NOT NULL
            AND Accreditation != ''

            UNION ALL

            SELECT 
            Certification AS files
            FROM tblFacilityDetails_Certification
            WHERE user_cookies = $user_id
            AND Certification IS NOT NULL
            AND Certification != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                array_push($file_names, $f_files);
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLHRD']) ) {
        $user_id = $_GET['modalDLHRD'];
        $file_zip_name = date('Y-m-d') .'_backup_hr_department.zip';
        $file_path = '../uploads/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files
            FROM tbl_hr_department
            WHERE deleted = 0
            AND filetype = 1
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];

                // Check if the string contains 'file_type'
                if (strpos($f_files, 'file_type') !== false) {
                    $output_file = json_decode($f_files,true);
                    if (!empty($output_file)) {
                        foreach ($output_file as $key => $value) {
                            $filetype = 1;
                            if (!empty($value['file_type'])) { $filetype = $value['file_type']; }
                            if ($filetype == 1) {
                                $file_doc = $value['file_doc'];
                                array_push($file_names, $file_doc);
                            }
                        }
                    }
                } else {
                    array_push($file_names, $f_files);
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLHRJD']) ) {
        $user_id = $_GET['modalDLHRJD'];
        $file_zip_name = date('Y-m-d') .'_backup_hr_job_description.zip';
        $file_path = '../uploads/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files
            FROM tbl_hr_job_description
            WHERE deleted = 0
            AND filetype = 1
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];

                // Check if the string contains 'file_type'
                if (strpos($f_files, 'file_type') !== false) {
                    $output_file = json_decode($f_files,true);
                    if (!empty($output_file)) {
                        foreach ($output_file as $key => $value) {
                            $filetype = 1;
                            if (!empty($value['file_type'])) { $filetype = $value['file_type']; }
                            if ($filetype == 1) {
                                $file_doc = $value['file_doc'];
                                array_push($file_names, $file_doc);
                            }
                        }
                    }
                } else {
                    array_push($file_names, $f_files);
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLHRER']) ) {
        $user_id = $_GET['modalDLHRER'];
        $file_zip_name = date('Y-m-d') .'_backup_hr_employee.zip';
        $file_path = '../uploads/hr/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files
            FROM tbl_hr_file
            WHERE deleted = 0
            AND filetype = 1
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];

                // Check if the string contains 'file_type'
                if (strpos($f_files, 'file_type') !== false) {
                    $output_file = json_decode($f_files,true);
                    if (!empty($output_file)) {
                        foreach ($output_file as $key => $value) {
                            $filetype = 1;
                            if (!empty($value['file_type'])) { $filetype = $value['file_type']; }
                            if ($filetype == 1) {
                                $file_doc = $value['file_doc'];
                                array_push($file_names, $file_doc);
                            }
                        }
                    }
                } else {
                    array_push($file_names, $f_files);
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLHRT']) ) {
        $user_id = $_GET['modalDLHRT'];
        $file_zip_name = date('Y-m-d') .'_backup_hr_training.zip';
        $file_path = '../uploads/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files
            FROM tbl_hr_trainings
            WHERE deleted = 0
            AND filetype = 1
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];

                // Check if the string contains 'file_type'
                if (strpos($f_files, 'file_type') !== false) {
                    $output_file = json_decode($f_files,true);
                    if (!empty($output_file)) {
                        foreach ($output_file as $key => $value) {
                            $filetype = 1;
                            if (!empty($value['file_type'])) { $filetype = $value['file_type']; }
                            if ($filetype == 1) {
                                $file_doc = $value['file_doc'];
                                array_push($file_names, $file_doc);
                            }
                        }
                    }
                } else {
                    array_push($file_names, $f_files);
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLSC']) ) {
        $user_id = $_GET['modalDLSC'];
        $user_email = '';
        $file_zip_name = date('Y-m-d') .'_backup_supplier_customer.zip';
        $file_path = '../uploads/supplier/';
        $file_names = array();

        $selectUser = mysqli_query( $conn,"SELECT email FROM tbl_user WHERE ID = $user_id");
        if ( mysqli_num_rows($selectUser) > 0 ) {
            while($rowUser = mysqli_fetch_array($selectUser)) {
                $user_email = $rowUser["email"];
            }
        }

        $selectFiles = mysqli_query( $conn,"
            SELECT
			*
			FROM (
			    SELECT
			    t.file AS files,
			    'template' AS src
			    FROM tbl_supplier_template AS t

			    LEFT JOIN (
			        SELECT
			        *
			        FROM tbl_supplier_requirement
			    ) AS r
			    ON t.requirement_id = r.ID

			    WHERE t.filetype = 1
			    AND t.user_id = $user_id
			    AND t.file IS NOT NULL
			    AND t.file != ''

			    UNION ALL

			    SELECT 
			    r.files,
			    'regulatory' AS src
			    FROM tbl_supplier AS s

			    LEFT JOIN (
			        SELECT
			        ID,
			        files
			        FROM tbl_supplier_regulatory
			        WHERE deleted = 0
			        AND filetype = 1
			    ) AS r
			    ON FIND_IN_SET(r.ID, REPLACE(s.regulatory, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND s.regulatory IS NOT NULL 
			    AND s.regulatory != ''

			    UNION ALL

			    SELECT
			    m.spec_file AS files,
			    'material' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        spec_file
			        FROM tbl_supplier_material
			        WHERE spec_file IS NOT NULL
			        AND spec_file != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND s.material IS NOT NULL 
			    AND s.material != ''

			    UNION ALL

			    SELECT 
			    m.other AS files,
			    'material other' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        other
			        FROM tbl_supplier_material
			        WHERE other IS NOT NULL
			        AND other != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND s.material IS NOT NULL 
			    AND s.material != ''

			    UNION ALL

			    SELECT
			    m.spec_file AS files,
			    'service' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        spec_file
			        FROM tbl_supplier_service
			        WHERE spec_file IS NOT NULL
			        AND spec_file != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.service, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND s.service IS NOT NULL 
			    AND s.service != ''

			    UNION ALL

			    SELECT
			    m.other AS files,
			    'service other' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        other
			        FROM tbl_supplier_service
			        WHERE other IS NOT NULL
			        AND other != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.service, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND s.service IS NOT NULL 
			    AND s.service != ''

			    UNION ALL

			    SELECT
			    d.file COLLATE utf8mb4_general_ci AS files,
			    'document' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        * 
			        FROM tbl_supplier_document 
			        WHERE type = 0
			        AND file IS NOT NULL
			        AND file != ''
			        AND ID IN (
			            SELECT
			            MAX(ID)
			            FROM tbl_supplier_document
			            WHERE type = 0
			            GROUP BY name, supplier_id
			        )
			    ) AS d
			    ON s.ID = d.supplier_ID
			    AND FIND_IN_SET(d.name, REPLACE(REPLACE(s.document, ' ', ''), '|',','  )  ) > 0

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND s.document IS NOT NULL 
			    AND s.document != ''

			    UNION ALL

			    SELECT
			    d.file COLLATE utf8mb4_general_ci AS files,
			    'document other' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        * 
			        FROM tbl_supplier_document 
			        WHERE type = 1
			        AND file IS NOT NULL
			        AND file != ''
			        AND ID IN (
			            SELECT
			            MAX(ID)
			            FROM tbl_supplier_document
			            WHERE type = 1
			            GROUP BY name, supplier_id
			        )
			    ) AS d
			    ON s.ID = d.supplier_ID
			    AND FIND_IN_SET(REPLACE(d.name, ', ', ' / '), REPLACE(REPLACE(s.document_other, ', ', ' / '), ' | ',','  )  ) > 0

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND s.document_other IS NOT NULL 
			    AND s.document_other != ''

			    UNION ALL

			    SELECT 
			    audit_report AS files,
			    'audit_report' AS src
			    FROM tbl_supplier AS s

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND audit_report IS NOT NULL
			    AND audit_report != ''

			    UNION ALL

			    SELECT 
			    audit_certificate AS files,
			    'audit_certificate' AS src
			    FROM tbl_supplier AS s

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND audit_certificate IS NOT NULL
			    AND audit_certificate != ''

			    UNION ALL

			    SELECT 
			    audit_action AS files,
			    'audit_action' AS src
			    FROM tbl_supplier AS s

			    WHERE s.is_deleted = 0
			    AND s.user_id = $user_id
			    AND audit_action IS NOT NULL
			    AND audit_action != ''




			    UNION ALL

			    SELECT 
			    r.files,
			    'regulatory' AS src
			    FROM tbl_supplier AS s

			    LEFT JOIN (
			        SELECT
			        ID,
			        files
			        FROM tbl_supplier_regulatory
			        WHERE deleted = 0
			        AND filetype = 1
			    ) AS r
			    ON FIND_IN_SET(r.ID, REPLACE(s.regulatory, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND s.regulatory IS NOT NULL 
			    AND s.regulatory != ''

			    UNION ALL

			    SELECT
			    m.spec_file AS files,
			    'material' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        spec_file
			        FROM tbl_supplier_material
			        WHERE spec_file IS NOT NULL
			        AND spec_file != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND s.material IS NOT NULL 
			    AND s.material != ''

			    UNION ALL

			    SELECT 
			    m.other AS files,
			    'material other' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        other
			        FROM tbl_supplier_material
			        WHERE other IS NOT NULL
			        AND other != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND s.material IS NOT NULL 
			    AND s.material != ''

			    UNION ALL

			    SELECT
			    m.spec_file AS files,
			    'service' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        spec_file
			        FROM tbl_supplier_service
			        WHERE spec_file IS NOT NULL
			        AND spec_file != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.service, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND s.service IS NOT NULL 
			    AND s.service != ''

			    UNION ALL

			    SELECT
			    m.other AS files,
			    'service other' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        ID,
			        other
			        FROM tbl_supplier_service
			        WHERE other IS NOT NULL
			        AND other != ''
			    ) AS m
			    ON FIND_IN_SET(m.ID, REPLACE(s.service, ' ', '') ) > 0

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND s.service IS NOT NULL 
			    AND s.service != ''

			    UNION ALL

			    SELECT
			    d.file COLLATE utf8mb4_general_ci AS files,
			    'document' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        * 
			        FROM tbl_supplier_document 
			        WHERE type = 0
			        AND file IS NOT NULL
			        AND file != ''
			        AND ID IN (
			            SELECT
			            MAX(ID)
			            FROM tbl_supplier_document
			            WHERE type = 0
			            GROUP BY name, supplier_id
			        )
			    ) AS d
			    ON s.ID = d.supplier_ID
			    AND FIND_IN_SET(d.name, REPLACE(REPLACE(s.document, ' ', ''), '|',','  )  ) > 0

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND s.document IS NOT NULL 
			    AND s.document != ''

			    UNION ALL

			    SELECT
			    d.file COLLATE utf8mb4_general_ci AS files,
			    'document other' AS src
			    FROM tbl_supplier AS s

			    RIGHT JOIN (
			        SELECT
			        * 
			        FROM tbl_supplier_document 
			        WHERE type = 1
			        AND file IS NOT NULL
			        AND file != ''
			        AND ID IN (
			            SELECT
			            MAX(ID)
			            FROM tbl_supplier_document
			            WHERE type = 1
			            GROUP BY name, supplier_id
			        )
			    ) AS d
			    ON s.ID = d.supplier_ID
			    AND FIND_IN_SET(REPLACE(d.name, ', ', ' / '), REPLACE(REPLACE(s.document_other, ', ', ' / '), ' | ',','  )  ) > 0

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND s.document_other IS NOT NULL 
			    AND s.document_other != ''

			    UNION ALL

			    SELECT 
			    audit_report AS files,
			    'audit_report' AS src
			    FROM tbl_supplier AS s

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND audit_report IS NOT NULL
			    AND audit_report != ''

			    UNION ALL

			    SELECT 
			    audit_certificate AS files,
			    'audit_certificate' AS src
			    FROM tbl_supplier AS s

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND audit_certificate IS NOT NULL
			    AND audit_certificate != ''

			    UNION ALL

			    SELECT 
			    audit_action AS files,
			    'audit_action' AS src
			    FROM tbl_supplier AS s

			    WHERE s.is_deleted = 0
			    AND s.email = '$user_email'
			    AND audit_action IS NOT NULL
			    AND audit_action != ''
			) r

			WHERE r.files IS NOT NULL
			AND r.files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                $f_src = $rowFile["src"];

                if ($f_src == 'template' OR $f_src == 'regulatory' OR $f_src == 'material' OR $f_src == 'document' OR $f_src == 'document other') {
                    array_push($file_names, $f_files);
                } else if ($f_src == 'material other') {
                    if (strpos($f_files, 'material_file_doc') !== false) {
                        $output_file = json_decode($f_files,true);
                        if (!empty($output_file)) {
                            foreach ($output_file as $key => $value) {
                                $file_doc = $value['material_file_doc'];
                                if (!empty($file_doc)) {
                                    array_push($file_names, $file_doc);
                                }
                            }
                        }
                    }
                } else if ($f_src == 'service other') {
                    if (strpos($f_files, 'service_file_doc') !== false) {
                        $output_file = json_decode($f_files,true);
                        if (!empty($output_file)) {
                            foreach ($output_file as $key => $value) {
                                $file_doc = $value['service_file_doc'];
                                if (!empty($file_doc)) {
                                    array_push($file_names, $file_doc);
                                }
                            }
                        }
                    }
                } else if ($f_src == 'audit_report' OR $f_src == 'audit_certificate' OR $f_src == 'audit_action') {
                    $f_files_arr = explode(" | ", $f_files);
                    if (!empty($f_files_arr[0])) {
                        array_push($file_names, $f_files_arr[0]);
                    }
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        }
    }
    if( isset($_GET['modalDLCAM']) ) {
        $user_id = $_GET['modalDLCAM'];
        $file_zip_name = date('Y-m-d') .'_backup_capam.zip';
        $file_path = '../uploads/cam/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            observation_file AS files,
            'observation_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND observation_file IS NOT NULL
            AND observation_file != ''

            UNION ALL

            SELECT 
            root_cause_file AS files,
            'root_cause_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND root_cause_file IS NOT NULL
            AND root_cause_file != ''

            UNION ALL

            SELECT 
            corrective_file AS files,
            'corrective_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND corrective_file IS NOT NULL
            AND corrective_file != ''

            UNION ALL

            SELECT 
            implementation_file AS files,
            'implementation_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND implementation_file IS NOT NULL
            AND implementation_file != ''

            UNION ALL

            SELECT 
            preventive_file AS files,
            'preventive_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND preventive_file IS NOT NULL
            AND preventive_file != ''

            UNION ALL

            SELECT 
            evaluation_file AS files,
            'evaluation_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND evaluation_file IS NOT NULL
            AND evaluation_file != ''

            UNION ALL

            SELECT 
            comment_file AS files,
            'comment_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND comment_file IS NOT NULL
            AND comment_file != ''

            UNION ALL

            SELECT 
            training_file AS files,
            'training_file' AS src
            FROM tbl_cam
            WHERE user_id = $user_id
            AND training_file IS NOT NULL
            AND training_file != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                $f_files_arr = explode(" | ", $f_files);
                foreach($f_files_arr as $value) {
                    if (!empty($value)) {
                        array_push($file_names, $value);
                    }
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLJT']) ) {
        $user_id = $_GET['modalDLJT'];
        $file_zip_name = date('Y-m-d') .'_backup_job_ticket.zip';
        $file_path = '../uploads/services/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files
            FROM tbl_services 

            WHERE deleted = 0
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                $f_files_arr = explode(" | ", $f_files);
                foreach($f_files_arr as $value) {
                    if (!empty($value)) {
                        array_push($file_names, $value);
                    }
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLRVM']) ) {
        $user_id = $_GET['modalDLRVM'];
        $file_zip_name = date('Y-m-d') .'_backup_rvm.zip';
        $file_path = '../uploads/eforms/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT
            files
            FROM tbl_eforms 

            WHERE user_id = $user_id
            AND filetype = 1
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                array_push($file_names, $f_files);
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLP']) ) {
        $user_id = $_GET['modalDLP'];
        $file_zip_name = date('Y-m-d') .'_backup_products.zip';
        $file_path = '../uploads/products/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files 
            FROM tbl_archiving

            WHERE deleted = 0
            AND user_id = $user_id
            AND filetype = 1
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                array_push($file_names, $f_files);
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLA']) ) {
        $user_id = $_GET['modalDLA'];
        $file_zip_name = date('Y-m-d') .'_backup_archive.zip';
        $file_path = '../uploads/archiving/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files 
            FROM tbl_archiving

            WHERE deleted = 0
            AND user_id = $user_id
            AND filetype = 1
            AND files IS NOT NULL
            AND files != ''
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                array_push($file_names, $f_files);
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
    if( isset($_GET['modalDLS']) ) {
        $user_id = $_GET['modalDLS'];
        $file_zip_name = date('Y-m-d') .'_backup_services.zip';
        $file_path = '../uploads/services/';
        $file_names = array();

        $selectFiles = mysqli_query( $conn,"
            SELECT 
            files 
            FROM tbl_service

            WHERE is_deleted = 0
            AND user_id = $user_id
            AND files IS NOT NULL
            AND files != ''
            AND files LIKE '%file_offering%'
        " );
        if ( mysqli_num_rows($selectFiles) > 0 ) {
            while($rowFile = mysqli_fetch_array($selectFiles)) {
                $f_files = $rowFile["files"];
                $output_file = json_decode($f_files,true);
                if (!empty($output_file)) {
                    foreach ($output_file as $key => $value) {
                        $file_doc = $value['file_offering'];
                        if (!empty($file_doc)) {
                            array_push($file_names, $file_doc);
                        }
                    }
                }
            }

            if ( count($file_names) > 0 ) {
                zipFilesAndDownload($file_names, $file_zip_name, $file_path);
            } else {
                echo '<script>window.history.back();</script>';
            }
        } else {
            echo '<script>window.history.back();</script>';
        }
    }
?>
