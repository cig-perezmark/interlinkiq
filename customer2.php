<?php 
    $dashboardView = null;
    isset($_GET['it']) && ($dashboardView = 'it');
    isset($_GET['free']) && ($dashboardView = 'free');
    isset($_GET['demo']) && ($dashboardView = 'demo');
    isset($_GET['paid']) && ($dashboardView = 'paid');

    $title = "Customer Dashboard";
    $site = "customer_dashboard_test";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li>'.createNav('Subscriber', 'paid').'<i class="fa fa-angle-right"></i></li>';
    $breadcrumbs .= '<li>'.createNav('Demo Account', 'demo').'<i class="fa fa-angle-right"></i></li>';
    $breadcrumbs .= '<li>'.createNav('Free Access', 'free').'<i class="fa fa-angle-right"></i></li>';
    $breadcrumbs .= '<li>'.createNav('IT Projects', 'it').'</li>';

    function createNav($text, $link) {
        global $dashboardView;
        return $dashboardView == $link ? '<span style="text-decoration:underline;font-weight:600;">'.$text.'</span>' : '<a href="admin_2/customer2?'.$link.'">'.$text.'</a>';
    }

    function getSumFromArray($arr) {
        $sum = 0;
        foreach($arr as $a) $sum += $a ?? 0;
        return $sum;
    }

    include_once ('header.php');

    $u_demo = 0;
    $u_free = 0;
    $u_paid = 0;
    $total_demo = 0;
    $total_usage_arr = array();
    $total_paid = 0;
    $total_free = 0;

    function monthlyReport($i, $array, $type) {
        $months = array(
            '01',
            '02',
            '03',
            '04',
            '05',
            '06',
            '07',
            '08',
            '09',
            '10',
            '11',
            '12'
        );
        $date = $months[$i];
        $sums = array_sum(array_column(array_filter($array, function($item) use ($date, $type) {
            // return $item['date'] === $date && $item['type'] === $type;
            return intVal(date('n', strtotime($item['date']))) === intVal($date) && $item['type'] === $type;
        }), 'size'));

        $sums = number_format($sums / 1048576, 2);
        return $sums;
    }
    function totalReport($array, $type) {
        $sums = array_sum(array_column(array_filter($array, function($item) use ($type) {
            return $item['type'] === $type;
        }), 'size'));
        return $sums;
    }
    function formatSize($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2);
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2);
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2);
        } elseif ($bytes > 1) {
            $bytes = $bytes;
        } elseif ($bytes == 1) {
            $bytes = $bytes;
        } else {
            $bytes = '0';
        }

        return $bytes;
    }
    function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = 'GB';
        } elseif ($bytes >= 1048576) {
            $bytes = 'MB';
        } elseif ($bytes >= 1024) {
            $bytes = 'KB';
        } elseif ($bytes > 1) {
            $bytes = 'bytes';
        } elseif ($bytes == 1) {
            $bytes = 'byte';
        } else {
            $bytes = 'bytes';
        }

        return $bytes;
    }
    function accountUsage2($account_id) {
        global $conn;
        $total_usage = 0;

        // Compliance Dashboard (File, Reference, Compliance, Review, Template, Video)
        $selectComplianceDashboard = mysqli_query( $conn,"SELECT
            SUM(total) AS bytes
            FROM (
                SELECT
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_file AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_references AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_compliance AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_review AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_template AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_video AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id
            ) o" );
        if ( mysqli_num_rows($selectComplianceDashboard) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectComplianceDashboard);
            $compliance_dashboard = $rowSQL["bytes"];
            $total_usage += $compliance_dashboard;
        }

        // HR (Departmetn, File, Job Description, Trainings)
        $selectHRModule = mysqli_query( $conn,"SELECT
            SUM(total) AS bytes
            FROM (
                SELECT
                SUM(filesize) AS total
                FROM tbl_hr_department 
                WHERE user_id = $account_id
                AND filesize > 0

                UNION ALL

                SELECT
                SUM(filesize) AS total
                FROM tbl_hr_file 
                WHERE user_id = $account_id
                AND filesize > 0

                UNION ALL
                
                SELECT
                SUM(filesize) AS total
                FROM tbl_hr_job_description 
                WHERE user_id = $account_id
                AND filesize > 0

                UNION ALL
                
                SELECT
                SUM(filesize) AS total
                FROM tbl_hr_trainings 
                WHERE user_id = $account_id
                AND filesize > 0
            ) o" );
        if ( mysqli_num_rows($selectHRModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectHRModule);
            $hr_module = $rowSQL["bytes"];
            $total_usage += $hr_module;
        }

        // Product
        $selectProductModule = mysqli_query( $conn,"SELECT SUM(files) AS bytes FROM tbl_products WHERE user_id = $account_id;" );
        if ( mysqli_num_rows($selectProductModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectProductModule);
            $product_module = $rowSQL["bytes"];
            $total_usage += $product_module;
        }

        // Service
        $selectServiceModule = mysqli_query( $conn,"SELECT SUM(filesize) AS bytes FROM tbl_service WHERE user_id = $account_id;" );
        if ( mysqli_num_rows($selectServiceModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectServiceModule);
            $service_module = $rowSQL["bytes"];
            $total_usage += $service_module;
        }

        // Customer (Document, Regulatory, Services, Template)
        $selectCustomerModule = mysqli_query( $conn,"SELECT
            SUM(bytes) AS sum_bytes,
            SUM(bytes_other) AS sum_bytes_other
            FROM (
                SELECT
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.is_deleted = 0 
                AND s.page = 2
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE deleted = 0
                AND filetype = 1
                AND LENGTH(files) > 0
                AND user_id = $account_id

                UNION ALL

                SELECT 
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 2
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND user_id = $account_id
            ) o" );
        if ( mysqli_num_rows($selectCustomerModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectCustomerModule);
            $customer_module = $rowSQL["sum_bytes"] + $rowSQL["sum_bytes_other"];
            $total_usage += $customer_module;
        }

        // Supplier (Document, Material, Regulatory, Services, Template)
        $selectSupplierModule = mysqli_query( $conn,"SELECT
            SUM(bytes) AS sum_bytes,
            SUM(bytes_other) AS sum_bytes_other
            FROM (
                SELECT
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id

                UNION ALL

                SELECT 
                SUM(m.spec_file) AS bytes,
                SUM(m.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_material
                ) AS m
                ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE deleted = 0
                AND filetype = 1
                AND LENGTH(files) > 0
                AND user_id = $account_id

                UNION ALL

                SELECT 
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND user_id = $account_id
            ) o" );
        if ( mysqli_num_rows($selectSupplierModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectSupplierModule);
            $supplier_module = $rowSQL["sum_bytes"] + $rowSQL["sum_bytes_other"];
            $total_usage += $supplier_module;
        }

        // Archive
        $selectArchiveModule = mysqli_query( $conn,"SELECT SUM(filesize) AS bytes FROM tbl_archiving WHERE user_id = $account_id;" );
        if ( mysqli_num_rows($selectArchiveModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectArchiveModule);
            $archive_module = $rowSQL["bytes"];
            $total_usage += $archive_module;
        }

        // Library
        $selectLibraryModule = mysqli_query( $conn,"SELECT SUM(filesize) AS bytes FROM tbl_lib WHERE user_id = $account_id;" );
        if ( mysqli_num_rows($selectLibraryModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectLibraryModule);
            $library_module = $rowSQL["bytes"];
            $total_usage += $library_module;
        }

        // RVM
        $selectRVMModule = mysqli_query( $conn,"SELECT SUM(filesize) AS bytes FROM tbl_eforms WHERE user_id = $account_id;" );
        if ( mysqli_num_rows($selectRVMModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectRVMModule);
            $rvm_module = $rowSQL["bytes"];
            $total_usage += $rvm_module;
        }

        // FFVA
        $selectRVMModule = mysqli_query( $conn,"SELECT SUM(filesize) AS bytes FROM tbl_ffva WHERE user_id = $account_id;" );
        if ( mysqli_num_rows($selectRVMModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectRVMModule);
            $ffva_module = $rowSQL["bytes"];
            $total_usage += $ffva_module;
        }

        return $total_usage;
    }
    function accountUsage($account_id) {
        global $conn;
        $total_usage = 0;

        // Compliance Dashboard (File, Reference, Compliance, Review, Template, Video)
        // HR (Departmetn, File, Job Description, Trainings)
        // Product
        // Service
        // Archive
        // Library
        // RVM
        // FFVA
        // Customer (Document, Regulatory, Services, Template)
        // Supplier (Document, Regulatory, Material, Services, Template)
        $selectCustomerModule = mysqli_query( $conn,"SELECT
            SUM(bytes) AS sum_bytes,
            SUM(bytes_other) AS sum_bytes_other
            FROM (
                SELECT
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_file AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_references AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_compliance AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_review AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_template AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_video AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_department 
                WHERE user_id = $account_id
                AND filesize > 0

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_file 
                WHERE user_id = $account_id
                AND filesize > 0

                UNION ALL
                
                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_job_description 
                WHERE user_id = $account_id
                AND filesize > 0

                UNION ALL
                
                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_trainings 
                WHERE user_id = $account_id
                AND filesize > 0

                UNION ALL

                SELECT SUM(files) AS bytes, 0 AS bytes_other FROM tbl_products WHERE user_id = $account_id

                UNION ALL

                SELECT SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_service WHERE user_id = $account_id

                UNION ALL

                SELECT SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_archiving WHERE user_id = $account_id

                UNION ALL

                SELECT SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_lib WHERE user_id = $account_id

                UNION ALL

                SELECT SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_eforms WHERE user_id = $account_id

                UNION ALL

                SELECT SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_ffva WHERE user_id = $account_id

                UNION ALL
                
                SELECT
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.is_deleted = 0 
                AND s.page = 2
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE deleted = 0
                AND filetype = 1
                AND LENGTH(files) > 0
                AND user_id = $account_id

                UNION ALL

                SELECT 
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 2
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND user_id = $account_id

                UNION ALL

                SELECT
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id

                UNION ALL

                SELECT 
                SUM(m.spec_file) AS bytes,
                SUM(m.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_material
                ) AS m
                ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE deleted = 0
                AND filetype = 1
                AND LENGTH(files) > 0
                AND user_id = $account_id

                UNION ALL

                SELECT 
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id

                UNION ALL

                SELECT
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND user_id = $account_id
            ) o" );
        if ( mysqli_num_rows($selectCustomerModule) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectCustomerModule);
            $supplier_module = $rowSQL["sum_bytes"] + $rowSQL["sum_bytes_other"];
            $total_usage += $supplier_module;
        }

        return $total_usage;
    }
    function accountUsageMonth2($account_id) {
        global $conn;
        $total_usage_arr = array();

        // Compliance Dashboard (File, Reference, Review, Template, Video)
        $selectComplianceDashboard = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_file AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                    AND LENGTH(f.file_history) IS NULL
                ) o
                WHERE o.f_user = $account_id

                -- UNION ALL

                -- SELECT
                -- date_uploaded AS date,
                -- SUM(total_quantity) AS total
                -- FROM (
                --     SELECT
                --     f.filesize AS f_filesize,
                --     CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user,
                --     f.file_history, 
                --     DATE_FORMAT(j.date,'%Y-%m') AS date_uploaded,
                --     SUM(j.size) total_quantity
                --     FROM tbl_library_file AS f

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_user
                --         WHERE is_verified = 1
                --         AND is_active = 1
                --     ) AS u
                --     ON f.user_id = u.ID

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_hr_employee
                --         WHERE suspended = 0
                --         AND status = 1
                --     ) AS e
                --     ON u.employee_id = e.ID

                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j

                --     WHERE f.filesize > 0
                --     AND LENGTH(f.file_history) > 0
                --     GROUP BY f.file_history
                -- ) o
                -- WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_references AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                    AND LENGTH(f.file_history) IS NULL
                ) o
                WHERE o.f_user = $account_id

                -- UNION ALL

                -- SELECT
                -- date_uploaded AS date,
                -- SUM(total_quantity) AS total
                -- FROM (
                --     SELECT
                --     f.filesize AS f_filesize,
                --     CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user,
                --     f.file_history, 
                --     DATE_FORMAT(j.date,'%Y-%m') AS date_uploaded,
                --     SUM(j.size) total_quantity
                --     FROM tbl_library_references AS f

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_user
                --         WHERE is_verified = 1
                --         AND is_active = 1
                --     ) AS u
                --     ON f.user_id = u.ID

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_hr_employee
                --         WHERE suspended = 0
                --         AND status = 1
                --     ) AS e
                --     ON u.employee_id = e.ID

                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j

                --     WHERE f.filesize > 0
                --     AND LENGTH(f.file_history) > 0
                --     GROUP BY f.file_history
                -- ) o
                -- WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_compliance AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                    AND LENGTH(f.file_history) IS NULL
                ) o
                WHERE o.f_user = $account_id

                -- UNION ALL

                -- SELECT
                -- date_uploaded AS date,
                -- SUM(total_quantity) AS total
                -- FROM (
                --     SELECT
                --     f.filesize AS f_filesize,
                --     CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user,
                --     f.file_history, 
                --     DATE_FORMAT(j.date,'%Y-%m') AS date_uploaded,
                --     SUM(j.size) total_quantity
                --     FROM tbl_library_compliance AS f

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_user
                --         WHERE is_verified = 1
                --         AND is_active = 1
                --     ) AS u
                --     ON f.user_id = u.ID

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_hr_employee
                --         WHERE suspended = 0
                --         AND status = 1
                --     ) AS e
                --     ON u.employee_id = e.ID

                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j

                --     WHERE f.filesize > 0
                --     AND LENGTH(f.file_history) > 0
                --     GROUP BY f.file_history
                -- ) o
                -- WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_review AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                    AND LENGTH(f.file_history) IS NULL
                ) o
                WHERE o.f_user = $account_id

                -- UNION ALL

                -- SELECT
                -- date_uploaded AS date,
                -- SUM(total_quantity) AS total
                -- FROM (
                --     SELECT
                --     f.filesize AS f_filesize,
                --     CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user,
                --     f.file_history, 
                --     DATE_FORMAT(j.date,'%Y-%m') AS date_uploaded,
                --     SUM(j.size) total_quantity
                --     FROM tbl_library_review AS f

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_user
                --         WHERE is_verified = 1
                --         AND is_active = 1
                --     ) AS u
                --     ON f.user_id = u.ID

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_hr_employee
                --         WHERE suspended = 0
                --         AND status = 1
                --     ) AS e
                --     ON u.employee_id = e.ID

                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j

                --     WHERE f.filesize > 0
                --     AND LENGTH(f.file_history) > 0
                --     GROUP BY f.file_history
                -- ) o
                -- WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_template AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                    AND LENGTH(f.file_history) IS NULL
                ) o
                WHERE o.f_user = $account_id

                -- UNION ALL

                -- SELECT
                -- date_uploaded AS date,
                -- SUM(total_quantity) AS total
                -- FROM (
                --     SELECT
                --     f.filesize AS f_filesize,
                --     CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user,
                --     f.file_history, 
                --     DATE_FORMAT(j.date,'%Y-%m') AS date_uploaded,
                --     SUM(j.size) total_quantity
                --     FROM tbl_library_template AS f

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_user
                --         WHERE is_verified = 1
                --         AND is_active = 1
                --     ) AS u
                --     ON f.user_id = u.ID

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_hr_employee
                --         WHERE suspended = 0
                --         AND status = 1
                --     ) AS e
                --     ON u.employee_id = e.ID

                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j

                --     WHERE f.filesize > 0
                --     AND LENGTH(f.file_history) > 0
                --     GROUP BY f.file_history
                -- ) o
                -- WHERE o.f_user = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(f_filesize) AS total
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_video AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                        WHERE is_verified = 1
                        AND is_active = 1
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                        WHERE suspended = 0
                        AND status = 1
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                    AND LENGTH(f.file_history) IS NULL
                ) o
                WHERE o.f_user = $account_id

                -- UNION ALL

                -- SELECT
                -- date_uploaded AS date,
                -- SUM(total_quantity) AS total
                -- FROM (
                --     SELECT
                --     f.filesize AS f_filesize,
                --     CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user,
                --     f.file_history, 
                --     DATE_FORMAT(j.date,'%Y-%m') AS date_uploaded,
                --     SUM(j.size) total_quantity
                --     FROM tbl_library_video AS f

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_user
                --         WHERE is_verified = 1
                --         AND is_active = 1
                --     ) AS u
                --     ON f.user_id = u.ID

                --     LEFT JOIN (
                --         SELECT
                --         *
                --         FROM tbl_hr_employee
                --         WHERE suspended = 0
                --         AND status = 1
                --     ) AS e
                --     ON u.employee_id = e.ID

                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j

                --     WHERE f.filesize > 0
                --     AND LENGTH(f.file_history) > 0
                --     GROUP BY f.file_history
                -- ) o
                -- WHERE o.f_user = $account_id
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectComplianceDashboard) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectComplianceDashboard)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // HR (Departmetn, File, Job Description, Trainings)
        $selectHRModule = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_hr_department 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_hr_department 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_hr_file 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL
                
                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_hr_file 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0

                UNION ALL
                
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_hr_job_description 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL
                
                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_hr_job_description 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0

                UNION ALL
                
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_hr_trainings 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL
                
                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_hr_trainings 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectHRModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectHRModule)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // Product
        $selectProductModule = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(files) AS total
                FROM tbl_products 
                WHERE user_id = $account_id
                AND files > 0
                -- AND LENGTH(file_history) IS NULL

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_products 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectProductModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectProductModule)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // Service
        $selectServiceModule = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_service 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_service 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectServiceModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectServiceModule)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // Customer (Document, Regulatory, Services, Template)
        $selectCustomerModule = mysqli_query( $conn,"SELECT
            date,
            SUM(bytes) AS sum_bytes,
            SUM(bytes_other) AS sum_bytes_other
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                    AND filesize > 0
                    AND LENGTH(file_history) IS NULL
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.page = 2
                AND s.user_id = $account_id

                -- UNION ALL

                -- SELECT
                -- date,
                -- SUM(d.total_quantity) AS bytes,
                -- 0 AS bytes_other
                -- FROM tbl_supplier AS s

                -- LEFT JOIN (
                --     SELECT
                --     *,
                --     DATE_FORMAT(j.date,'%Y-%m') AS date,
                --     SUM(j.size) total_quantity
                --     FROM tbl_supplier_document
                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j
                --     WHERE LENGTH(file_history) > 0
                -- ) AS d
                -- ON s.ID = d.supplier_id
                -- WHERE s.page = 2
                -- AND s.user_id = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE filetype = 1
                AND LENGTH(files) > 0
                AND LENGTH(file_history) IS NULL
                AND user_id = $account_id

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS bytes,
                -- 0 AS bytes_other
                -- FROM tbl_supplier_regulatory
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE LENGTH(file_history) > 0
                -- AND user_id = $account_id

                UNION ALL

                SELECT 
                '2024-01-15' AS date,
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                    WHERE LENGTH(file_history) IS NULL
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.page = 2
                AND s.user_id = $account_id

                -- UNION ALL

                -- SELECT 
                -- date,
                -- SUM(ser.total_quantity) AS bytes,
                -- SUM(ser.total_quantity2) AS bytes_other
                -- FROM tbl_supplier AS s

                -- LEFT JOIN (
                --     SELECT
                --     *,
                --     DATE_FORMAT(j.date,'%Y-%m') AS date,
                --     SUM(j.size) AS total_quantity,
                --     SUM(j2.size2) AS total_quantity2
                --     FROM tbl_supplier_service
                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j
                --     , JSON_TABLE(other, '$[*]' COLUMNS (size2 INTEGER PATH '$.size')) j2
                --     WHERE LENGTH(file_history) > 0
                -- ) AS ser
                -- ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                -- WHERE s.page = 2
                -- AND s.user_id = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND LENGTH(file_history) IS NULL
                AND user_id = $account_id

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS bytes,
                -- 0 AS bytes_other
                -- FROM tbl_supplier_template
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE LENGTH(file_history) > 0
                -- AND user_id = $account_id
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectCustomerModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectCustomerModule)) {
                $customer_module = $rowSQL["sum_bytes"] + $rowSQL["sum_bytes_other"];
                $output = array (
                    'size' =>  $customer_module,
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // Supplier (Document, Regulatory, Material, Services, Template)
        $selectSupplierModule = mysqli_query( $conn,"SELECT
            date,
            SUM(bytes) AS sum_bytes,
            SUM(bytes_other) AS sum_bytes_other
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                    AND filesize > 0
                    AND LENGTH(file_history) IS NULL
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.page = 1
                AND s.user_id = $account_id

                -- UNION ALL

                -- SELECT
                -- date,
                -- SUM(d.total_quantity) AS bytes,
                -- 0 AS bytes_other
                -- FROM tbl_supplier AS s

                -- LEFT JOIN (
                --     SELECT
                --     *,
                --     DATE_FORMAT(j.date,'%Y-%m') AS date,
                --     SUM(j.size) total_quantity
                --     FROM tbl_supplier_document
                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j
                --     WHERE LENGTH(file_history) > 0
                -- ) AS d
                -- ON s.ID = d.supplier_id
                -- WHERE s.page = 1
                -- AND s.user_id = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE filetype = 1
                AND LENGTH(files) > 0
                AND LENGTH(file_history) IS NULL
                AND user_id = $account_id

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS bytes,
                -- 0 AS bytes_other
                -- FROM tbl_supplier_regulatory
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE LENGTH(file_history) > 0
                -- AND user_id = $account_id

                UNION ALL

                SELECT 
                '2024-01-15' AS date,
                SUM(m.spec_filesize) AS bytes,
                SUM(m.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_material
                    WHERE LENGTH(file_history) IS NULL
                ) AS m
                ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '')  ) > 0
                WHERE s.page = 1
                AND s.user_id = $account_id

                -- UNION ALL

                -- SELECT 
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(m.total_quantity) AS bytes,
                -- SUM(m.total_quantity2) AS bytes_other
                -- FROM tbl_supplier AS s

                -- LEFT JOIN (
                --     SELECT
                --     *,
                --     SUM(j.size) AS total_quantity,
                --     SUM(j2.size2) AS total_quantity2
                --     FROM tbl_supplier_material
                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j
                --     , JSON_TABLE(other, '$[*]' COLUMNS (size2 INTEGER PATH '$.size')) j2
                --     WHERE LENGTH(file_history) > 0
                -- ) AS m
                -- ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '')  ) > 0
                -- WHERE s.page = 1
                -- AND s.user_id = $account_id

                UNION ALL

                SELECT 
                '2024-01-15' AS date,
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                    WHERE LENGTH(file_history) IS NULL
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.page = 1
                AND s.user_id = $account_id

                -- UNION ALL

                -- SELECT 
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(ser.total_quantity) AS bytes,
                -- SUM(ser.total_quantity2) AS bytes_other
                -- FROM tbl_supplier AS s

                -- LEFT JOIN (
                --     SELECT
                --     *,
                --     SUM(j.size) AS total_quantity,
                --     SUM(j2.size2) AS total_quantity2
                --     FROM tbl_supplier_service
                --     , JSON_TABLE(
                --         file_history, '$[*]' COLUMNS (
                --             size INTEGER PATH '$.size',
                --             date VARCHAR ( 20 ) path '$.date'
                --         )
                --     ) j
                --     , JSON_TABLE(other, '$[*]' COLUMNS (size2 INTEGER PATH '$.size')) j2
                --     WHERE LENGTH(file_history) > 0
                -- ) AS ser
                -- ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                -- WHERE s.page = 1
                -- AND s.user_id = $account_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND LENGTH(file_history) IS NULL
                AND user_id = $account_id

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS bytes,
                -- 0 AS bytes_other
                -- FROM tbl_supplier_template
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE LENGTH(file_history) > 0
                -- AND user_id = $account_id
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectSupplierModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectSupplierModule)) {
                $customer_module = $rowSQL["sum_bytes"] + $rowSQL["sum_bytes_other"];
                $output = array (
                    'size' =>  $customer_module,
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // Archive
        $selectArchiveModule = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_archiving 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_archiving 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectArchiveModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectArchiveModule)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // Library
        $selectLibraryModule = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_lib 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_lib 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectLibraryModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectLibraryModule)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // RVM
        $selectRVMModule = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_eforms 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_eforms 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectRVMModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectRVMModule)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        // FFVA
        $selectFFVAModule = mysqli_query( $conn,"SELECT
            date,
            SUM(total) AS bytes
            FROM (
                SELECT
                '2024-01-15' AS date,
                SUM(filesize) AS total
                FROM tbl_ffva 
                WHERE user_id = $account_id
                AND filesize > 0
                AND LENGTH(file_history) IS NULL

                -- UNION ALL

                -- SELECT
                -- DATE_FORMAT(j.date,'%Y-%m') AS date,
                -- SUM(j.size) AS total
                -- FROM tbl_ffva 
                -- , JSON_TABLE(
                --     file_history, '$[*]' COLUMNS (
                --         size INTEGER PATH '$.size',
                --         date VARCHAR ( 20 ) path '$.date'
                --     )
                -- ) j
                -- WHERE user_id = $account_id
                -- AND LENGTH(file_history) > 0
            ) o

            GROUP BY date" );
        if ( mysqli_num_rows($selectFFVAModule) > 0 ) {
            while($rowSQL = mysqli_fetch_array($selectFFVAModule)) {
                $output = array (
                    'size' =>  $rowSQL["bytes"],
                    'date' =>  $rowSQL["date"]
                );
                array_push($total_usage_arr, $output);
            }
        }

        return $total_usage_arr;
    }
    function accountUsageMonth($account_id, $type) {
        global $conn;
        global $total_usage_arr;
        // $total_usage_arr = array();

        // Compliance Dashboard (File, Reference, Compliance, Review, Template, Video)
        // HR (Departmetn, File, Job Description, Trainings)
        // Product
        // Service
        // Archive
        // Library
        // RVM
        // FFVA
        // Customer (Document, Regulatory, Services, Template)
        // Supplier (Document, Regulatory, Material, Services, Template)
        $selectAccountUsage = mysqli_query( $conn,"SELECT
            date,
            user,
            SUM(bytes) AS sum_bytes,
            SUM(bytes_other) AS sum_bytes_other
            FROM (
                SELECT
                '2024-01-15' AS date,
                f_user AS user,
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_file AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id
                GROUP BY f_user

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                f_user AS user,
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_references AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id
                GROUP BY f_user

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                f_user AS user,
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_compliance AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id
                GROUP BY f_user

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                f_user AS user,
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_review AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id
                GROUP BY f_user

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                f_user AS user,
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_template AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id
                GROUP BY f_user

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                f_user AS user,
                SUM(f_filesize) AS bytes,
                0 AS bytes_other
                FROM (
                    SELECT
                    f.filesize AS f_filesize,
                    CASE WHEN u.employee_id > 0 THEN e.user_id ELSE u.ID END AS f_user
                    FROM tbl_library_video AS f

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS u
                    ON f.user_id = u.ID

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.employee_id = e.ID

                    WHERE f.filesize > 0
                ) o
                WHERE o.f_user = $account_id
                GROUP BY f_user

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_department 
                WHERE user_id = $account_id
                AND filesize > 0
                GROUP BY user_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_file 
                WHERE user_id = $account_id
                AND filesize > 0
                GROUP BY user_id

                UNION ALL
                
                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_job_description 
                WHERE user_id = $account_id
                AND filesize > 0
                GROUP BY user_id

                UNION ALL
                
                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_hr_trainings 
                WHERE user_id = $account_id
                AND filesize > 0
                GROUP BY user_id

                UNION ALL

                SELECT '2024-01-15' AS date, user_id AS user, SUM(files) AS bytes, 0 AS bytes_other FROM tbl_products WHERE user_id = $account_id GROUP BY user_id

                UNION ALL

                SELECT '2024-01-15' AS date, user_id AS user, SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_service WHERE user_id = $account_id GROUP BY user_id

                UNION ALL

                SELECT '2024-01-15' AS date, user_id AS user, SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_archiving WHERE user_id = $account_id GROUP BY user_id

                UNION ALL

                SELECT '2024-01-15' AS date, user_id AS user, SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_lib WHERE user_id = $account_id GROUP BY user_id

                UNION ALL

                SELECT '2024-01-15' AS date, user_id AS user, SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_eforms WHERE user_id = $account_id GROUP BY user_id

                UNION ALL

                SELECT '2024-01-15' AS date, user_id AS user, SUM(filesize) AS bytes, 0 AS bytes_other FROM tbl_ffva WHERE user_id = $account_id GROUP BY user_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                s.user_id AS user,
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.is_deleted = 0 
                AND s.page = 2
                AND s.user_id = $account_id
                GROUP BY s.user_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE deleted = 0
                AND filetype = 1
                AND LENGTH(files) > 0
                AND user_id = $account_id
                GROUP BY user_id

                UNION ALL

                SELECT 
                '2024-01-15' AS date,
                s.user_id AS user,
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 2
                AND s.user_id = $account_id
                GROUP BY s.user_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND user_id = $account_id
                GROUP BY user_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                s.user_id AS user,
                SUM(d.filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_document
                    WHERE filetype = 1
                    AND LENGTH(file) > 0
                ) AS d
                ON s.ID = d.supplier_id
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id
                GROUP BY s.user_id

                UNION ALL

                SELECT 
                '2024-01-15' AS date,
                s.user_id AS user,
                SUM(m.spec_file) AS bytes,
                SUM(m.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_material
                ) AS m
                ON FIND_IN_SET(m.ID, REPLACE(s.material, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id
                GROUP BY s.user_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_regulatory
                WHERE deleted = 0
                AND filetype = 1
                AND LENGTH(files) > 0
                AND user_id = $account_id
                GROUP BY user_id

                UNION ALL

                SELECT 
                '2024-01-15' AS date,
                s.user_id AS user,
                SUM(ser.spec_filesize) AS bytes,
                SUM(ser.other_filesize) AS bytes_other
                FROM tbl_supplier AS s

                LEFT JOIN (
                    SELECT
                    *
                    FROM tbl_supplier_service
                ) AS ser
                ON FIND_IN_SET(ser.ID, REPLACE(s.service, ' ', '')  ) > 0
                WHERE s.is_deleted = 0 
                AND s.page = 1
                AND s.user_id = $account_id
                GROUP BY s.user_id

                UNION ALL

                SELECT
                '2024-01-15' AS date,
                user_id AS user,
                SUM(filesize) AS bytes,
                0 AS bytes_other
                FROM tbl_supplier_template
                WHERE filetype = 1
                AND LENGTH(file) > 0
                AND user_id = $account_id
                GROUP BY user_id
            ) o
            WHERE date IS NOT NULL
            GROUP BY date" );
        if ( mysqli_num_rows($selectAccountUsage) > 0 ) {
            $rowSQL = mysqli_fetch_array($selectAccountUsage);
            $total_usage = $rowSQL["sum_bytes"] + $rowSQL["sum_bytes_other"];
            $output = array (
                'type' =>  $type,
                'user' =>  $rowSQL["user"],
                'size' =>  $total_usage,
                'date' =>  $rowSQL["date"]
            );
            array_push($total_usage_arr, $output);
        }

        return $total_usage_arr;
    }

    switch($dashboardView) {
        case 'it': {
            include_once "storage/customer_it.php";
        } break;
        case 'free': {
            include_once "storage/customer_free.php";
        } break;
        case 'demo': {
            include_once "storage/customer_demo.php";
        } break;
        case 'paid': {
            include_once "storage/customer_subscriber.php";
        } break;
        default: {

            $selectAccount = mysqli_query( $conn,"SELECT
                SUM(c.count_demo) AS a_demo,
                CASE WHEN SUM(c.count_free) >= c.count_paid THEN (SUM(c.count_free) - SUM(c.count_paid)) ELSE SUM(c.count_free) END AS a_free,
                SUM(c.count_paid) AS a_paid
                FROM (
                    SELECT 
                    SUM(CASE WHEN u.account_type = 1 THEN 1 ELSE 0 END) AS count_demo,
                    SUM(CASE WHEN u.account_type = 0 THEN 1 ELSE 0 END) AS count_free,
                    0 AS count_paid
                    FROM tbl_user AS u

                    WHERE u.employee_id = 0

                    UNION ALL

                    SELECT
                    0 AS count_demo,
                    0 AS count_free,
                    COUNT(o.u_email) AS count_paid
                    FROM (
                        SELECT
                        u.email AS u_email
                        FROM tbl_user AS u

                        INNER JOIN (
                            SELECT
                            *
                            FROM tbl_supplier
                        ) AS s
                        ON u.email = s.email

                        WHERE u.employee_id = 0
                        AND u.account_type = 0

                        GROUP BY u.email
                    ) o
                ) c" );
            while($rowAccount = mysqli_fetch_array($selectAccount)) {
                $a_demo = $rowAccount["a_demo"];
                $a_free = $rowAccount["a_free"];
                $a_paid = $rowAccount["a_paid"];
            }

            $selectDemo = mysqli_query( $conn,"SELECT 
                u.ID AS u_ID,
                u.first_name AS u_first_name,
                u.email AS u_email
                FROM tbl_user AS u

                WHERE u.employee_id = 0
                AND u.account_type = 1

                UNION ALL 

                SELECT 
                eu.ID AS u_ID,
                eu.first_name As u_first_name,
                eu.email AS u_email
                FROM tbl_user AS u

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_hr_employee
                ) AS e
                ON u.ID = e.user_id

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_user
                ) AS eu
                ON eu.employee_id = e.ID

                WHERE u.employee_id = 0
                AND u.account_type = 1");
            while($rowDemo = mysqli_fetch_array($selectDemo)) {
                $total_demo += accountUsage($rowDemo["u_ID"]);
                accountUsageMonth($rowDemo["u_ID"], 1);
            }

            $selectPaid = mysqli_query( $conn,"SELECT 
                u.ID AS u_ID,
                u.first_name AS u_first_name,
                u.email AS u_email
                FROM tbl_user AS u

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_supplier
                ) AS s
                ON u.email = s.email

                WHERE u.employee_id = 0
                AND u.account_type = 0

                GROUP BY u.email

                UNION ALL

                SELECT 
                eu.ID AS u_ID,
                eu.first_name As u_first_name,
                eu.email AS u_email
                FROM tbl_user AS u

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_supplier
                ) AS s
                ON u.email = s.email

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_hr_employee
                ) AS e
                ON u.ID = e.user_id

                INNER JOIN (
                    SELECT
                    *
                    FROM tbl_user
                ) AS eu
                ON eu.employee_id = e.ID

                WHERE u.employee_id = 0
                AND u.account_type = 0

                GROUP BY u.email");
            while($rowPaid = mysqli_fetch_array($selectPaid)) {
                $total_paid += accountUsage($rowPaid["u_ID"]);
                accountUsageMonth($rowPaid["u_ID"], 2);
            }

            $selectFree = mysqli_query( $conn,"SELECT
                *
                FROM (
                    SELECT 
                    u.ID AS u_ID,
                    u.first_name AS u_first_name,
                    u.email AS u_email
                    FROM tbl_user AS u

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_supplier
                    ) AS s
                    ON u.email = s.email

                    WHERE u.employee_id = 0
                    AND u.account_type = 0
                    AND s.ID IS NULL

                    UNION ALL

                    SELECT 
                    eu.ID AS u_ID,
                    eu.first_name As u_first_name,
                    eu.email AS u_email
                    FROM tbl_user AS u

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_supplier
                    ) AS s
                    ON u.email = s.email

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_hr_employee
                    ) AS e
                    ON u.ID = e.user_id

                    LEFT JOIN (
                        SELECT
                        *
                        FROM tbl_user
                    ) AS eu
                    ON eu.employee_id = e.ID

                    WHERE u.employee_id = 0
                    AND u.account_type = 0
                    AND s.ID IS NULL
                    AND eu.ID IS NULL
                ) o
                WHERE o.u_ID IS NOT NULL");
            while($rowFree = mysqli_fetch_array($selectFree)) {
                $total_free += accountUsage($rowFree["u_ID"]);
                accountUsageMonth($rowFree["u_ID"], 0);
            }

            $dashboardAccounts = [
                'paid' => intval($a_paid),
                'demo' => intval($a_demo),
                'free' => intval($a_free),
            ];
        
            $dashboardStorage = [
                'paid' => intval(totalReport($total_usage_arr, 2)),
                'demo' => intval(totalReport($total_usage_arr, 1)),
                'free' => intval(totalReport($total_usage_arr, 0)),
            ];

            // consists of 12 (months) per category
            $monthlyGrowthReport = [
                'paid' => [],
                'demo' => [],
                'free' => [],
            ];

            print_r($total_usage_arr).'<br><br>';
            print_r(totalReport($total_usage_arr, 0));



            // dummy data 
            $until = date('n');
            for($i = 0; $i<12; $i++) {
                $monthlyGrowthReport['paid'][] = $i < $until ? floatval(monthlyReport($i, $total_usage_arr, 2)) : 0;
                $monthlyGrowthReport['demo'][] = $i < $until ? floatval(monthlyReport($i, $total_usage_arr, 1)) : 0;
                $monthlyGrowthReport['free'][] = $i < $until ? floatval(monthlyReport($i, $total_usage_arr, 0)) : 0;
            }
        
            $totalAccounts = getSumFromArray($dashboardAccounts);
            $totalStorage = getSumFromArray($dashboardStorage);

            echo '<script>';
            echo 'const dfdc = { account : ' . json_encode($dashboardAccounts);
            echo ', storage : ' . json_encode($dashboardStorage);
            echo ', };';
            echo 'const monthlyGrowthReport = ' . json_encode($monthlyGrowthReport) . ';';
            echo '</script>';

            $scripts = '
                <script src="assets/global/plugins/highcharts/js/highcharts.js" type="text/javascript"></script>
                <script src="assets/global/plugins/highcharts/js/highcharts-3d.js" type="text/javascript"></script>
                <script src="assets/global/plugins/highcharts/js/highcharts-more.js" type="text/javascript"></script>
                <script src="admin_2/storage/js/dashboard.js" type="text/javascript"></script>
            ';

            include_once "storage/customer_main.php";
        } break;
    }
?>
        <?php 
            include_once ('footer.php');
            echo $scripts ?? '';
        ?>

        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>
        <<script type="text/javascript">
            var current_client = '<?php echo $_COOKIE['client']; ?>';
            $(document).ready(function(){
                if(window.location.href.indexOf('#new') != -1) {
                    $('#modalNew').modal('show');
                }
                $('#tableData_1, #tableData_2').DataTable({
                    dom: 'lBfrtip',
                    responsive: true,
                    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                    buttons: [
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        'colvis'
                    ]
                });

                changeIndustry(0, 1);

                // widget_tagInput();
                widget_formRepeater();
                widget_date_audit();
                $('.selectpicker').selectpicker();
                changeFrequency(2);

                $("#btnExport").click(function(){
                    $("#table2excel").table2excel({
                        exclude:".noExl",           // exclude CSS class
                        name:"Worksheet Name",
                        filename:"Customer",        //do not include extension
                        fileext:".xlsx",             // file extension
                        exclude_img:true,
                        exclude_links:true,
                        exclude_inputs:true
                    });
                });
            });

            function btnReset(view) {
                $('#'+view+' form')[0].reset();
            }
            function btnClose(view) {
                $('#'+view+' .modal-body').html('');
            }
            function uploadNewOld(e) {
                $(e).parent().hide();
                $(e).parent().prev('.form-control').removeClass('hide');
            }
            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().parent().find('select').removeClass('hide');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                $(e).parent().parent().find('td .document_filename').attr("required", false);
                $(e).parent().parent().find('td .daterange').attr("required", false);

                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }

                if($(e).val() > 0) {
                    $(e).parent().parent().find('td .document_filename').attr("required", true);
                    $(e).parent().parent().find('td .daterange').attr("required", true);
                }
            }
            function inputInvalid(modal) {
                var error = 0;
                $('.'+modal+' *:invalid').each(function () {
                    // Find the tab-pane that this element is inside, and get the id
                    var $closest = $(this).closest('.tab-pane');
                    var id = $closest.attr('id');

                    $(this).addClass('error');

                    // Find the link that corresponds to the pane and have it show
                    $('.'+modal+' .nav a[href="#' + id + '"]').tab('show');

                    // Only want to do it once
                    error++;
                });

                return error;
            }

            function changedCategory(sel) {
                if (sel.value == 3) {
                    $('.tabProducts').addClass('hide');
                    $('.tabService').removeClass('hide');
                } else {
                    $('.tabProducts').removeClass('hide');
                    $('.tabService').addClass('hide');
                }
            }
            function changeIndustry(id, modal) {
                var country = $('#tabBasic_'+modal+' select[name="countries"]').val();
                if (id == 13 || id == 22 || id == 25) { id = id; }
                else { id = 0; }
                $.ajax({
                    type: "GET",
                    url: "admin_2/function.php?modalView_Customer_Industry="+id+"&c="+country,
                    dataType: "html",                  
                    success: function(data){       
                        $('#tabDocuments_'+modal+' .mt-checkbox-list').html(data);
                        $('#tableData_Requirement_'+modal+' tbody').html('');
                    }
                });
            }
            function changeCountry(modal) {
                var industry = $('#tabBasic_'+modal+' select[name="supplier_countries"]').val();
                changeIndustry(industry, modal);
            }
            function changeFile(e, val) {
                // if (val != '') {
                //     $(e).parent().parent().find('td .document_filename').attr("required", true);
                //     $(e).parent().parent().find('td .daterange').attr("required", true);
                // } else {
                //     $(e).parent().parent().find('td .document_filename').attr("required", false);
                //     $(e).parent().parent().find('td .daterange').attr("required", false);
                // }
            }
            function changeDepartment(id, modal) {
                var selected = [];

                $.each($(".department_id option:selected"), function(){            
                    selected.push($(this).val());
                });

                $.ajax({
                    type: "POST",
                    data: {department_id:selected},
                    url: "admin_2/function.php?modalView_Customer_Employee="+modal,
                    success: function(data){
                        $('#tabPortal_'+modal+' .employee_id').html(data);
                        changeEmployee(modal);
                        $('.employee_id').multiselect('destroy');
                        selectMulti();
                    }
                });
            }
            function changeEmployee(modal) {
                var selectEmployee = $('#tabPortal_'+modal+' .employee_id');
                selectEmployee.html(selectEmployee.find('option').sort(function(x, y) {
                    // to change to descending order switch "<" for ">"
                    return $(x).text() > $(y).text() ? 1 : -1;
                }));
            }
            function changeFrequency(val) {
                if (val == 0) {
                    $('.bg-default').removeClass('hide');
                } else {
                    $('.bg-default').addClass('hide');
                }
            }

            function btnView(id) {
                btnClose('modalView');
                $.ajax({
                    type: "GET",
                    url: "admin_2/function.php?modalView_Customer="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalView .modal-body").html(data);
                        // widget_tagInput();

                        changeEmployee(2);
                        selectMulti();
                        widget_dates();
                        widget_date_audit();
                        $('.selectpicker').selectpicker();
                    }
                });
            }
            function btnDelete(id) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "admin_2/function.php?btnDelete_Supplier="+id,
                        dataType: "html",
                        success: function(response){
                            $('#tableData_1 tbody #tr_'+id).remove();
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            function btnReport(id) {
                $("#modalReport .modal-body table tbody").html('');
                $.ajax({
                    type: "GET",
                    url: "admin_2/function.php?modalView_Customer_Report="+id,
                    dataType: "html",
                    success: function(data){
                        $("#modalReport .modal-body table tbody").html(data);
                    }
                });
            }
            function btnSendInvite(id) {
                swal({
                    title: "Are you sure?",
                    text: "Send an Invitation Email!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "admin_2/function.php?modalSend_Customer="+id,
                        dataType: "html",
                        success: function(data){
                            // msg = "Sucessfully Sent!";
                            // bootstrapGrowl(msg);
                        }
                    });
                    swal("Done!", "Email has been sent.", "success");
                });
            }

            function widget_tagInput() {
                var ComponentsBootstrapTagsinput=function(){
                    var t=function(){
                        var t=$(".tagsinput");
                        t.tagsinput()
                    };
                    return{
                        init:function(){t()}
                    }
                }();
                jQuery(document).ready(function(){ComponentsBootstrapTagsinput.init()});
            }
            function widget_formRepeater() {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                            }, 500);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
                jQuery(document).ready(function(){FormRepeater.init()});
            }
            function widget_dates() {
                $('#tableData_Requirement_2 tbody .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('#tableData_Requirement_2 tbody .daterange_empty').val('');
            }
            function widget_date(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function widget_date_other(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_other_'+id+' .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            }
            function widget_date_clears(e) {
                $(e).parent().prev('.daterange').val('');
            }
            function widget_date_clear(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_'+id+' .daterange').val('');
            }
            function widget_date_clear_other(id, modal) {
                $('#tableData_Requirement_'+modal+' tbody .tr_other_'+id+' .daterange').val('');
            }
            function widget_dates_product(e) {
                $('#modal'+e+'Product .daterange').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('#modal'+e+'Product .daterange_empty').val('');
            }
            function widget_date_audit() {
                $('.daterange_audit').daterangepicker({
                    ranges: {
                        'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                        'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                        'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                    },
                    "autoApply": true,
                    "showDropdowns": true,
                    "linkedCalendars": false,
                    "alwaysShowCalendars": true,
                    "drops": "auto",
                    "opens": "left"
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $('.daterange_audit_empty').val('');
            }
            function widget_date_audit_clears(e) {
                $(e).parent().prev('.daterange_audit').val('');
            }
            function widget_formRepeater_material(i) {
                var FormRepeater=function(){
                    return{
                        init:function(){
                            $(".mt-repeater").each(function(){
                                $(this).repeater({
                                    show:function(){
                                        $(this).slideDown();

                                        $(this).find('.daterange').daterangepicker({
                                            ranges: {
                                                'Today': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],
                                                'One Month': [moment().subtract(1, 'day'), moment().add(1, 'month')],
                                                'One Year': [moment().subtract(1, 'day'), moment().add(1, 'year')]
                                            },
                                            "autoApply": true,
                                            "showDropdowns": true,
                                            "linkedCalendars": false,
                                            "alwaysShowCalendars": true,
                                            "drops": "auto",
                                            "opens": "left"
                                        }, function(start, end, label) {
                                            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                                        });
                                        (this).find('.daterange_empty').val('');
                                    },
                                    hide:function(e){
                                        let text = "Are you sure you want to delete this row?";
                                        if (confirm(text) == true) {
                                            $(this).slideUp(e);
                                            setTimeout(function() { 
                                            }, 500);
                                        }
                                    },
                                    ready:function(e){}
                                })
                            })
                        }
                    }
                }();
                jQuery(document).ready(function(){FormRepeater.init()});
            }

            $(".modalSave").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                if (inputInvalid('modalSave') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnSave_Customer',true);

                var l = Ladda.create(document.querySelector('#btnSave_Customer'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var tbl_counter = $("#tableData_1 tbody > tr").length + 1;
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.name+'</td>';
                                html += '<td>'+obj.category+'</td>';
                                html += '<td>'+obj.material+'</td>';
                                html += '<td>'+obj.contact_name+'</td>';
                                html += '<td>'+obj.contact_address+'</td>';
                                html += '<td class="text-center">'+obj.contact_info+'</td>';
                                html += '<td class="text-center hide">'+obj.reviewed_due+'</td>';
                                html += '<td class="text-center">'+obj.compliance+'%</td>';
                                html += '<td class="text-center">'+obj.status+'</td>';
                                html += '<td class="text-center">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_1 tbody').append(html);
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

                if (inputInvalid('modalUpdate') > 0) { return false; }
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Customer',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Customer'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var tbl_counter = $("#tableData_1 tbody > tr").length + 1;
                            var html = '<td>'+obj.supplier_name+'</td>';
                            html += '<td>'+obj.category+'</td>';
                            html += '<td>'+obj.material+'</td>';
                            html += '<td>'+obj.contact_name+'</td>';
                            html += '<td>'+obj.contact_address+'</td>';
                            html += '<td class="text-center">'+obj.contact_info+'</td>';
                            html += '<td class="text-center hide">'+obj.reviewed_due+'</td>';
                            html += '<td class="text-center">'+obj.compliance+'%</td>';
                            html += '<td class="text-center">'+obj.status+'</td>';
                            html += '<td class="text-center">';

                                if (obj.page == 1) {
                                    html += '<a href="#modalView" class="btn btn-outline btn-success btn-sm btn-circle btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                } else {
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalView" class="btn btn-outline dark btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
                                        html += '<a href="javascript:;" class="btn btn-danger btn-sm btnDelete" onclick="btnDelete('+obj.ID+')">Delete</a>';
                                    html += '</div>';
                                }

                            html += '</td>';

                            $('#tableData_1 tbody #tr_'+obj.ID).html(html);
                            $('#modalView').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));


            // Requirement Section
            function btnNew_Requirement(modal) {
                var requirement_other = $("#inputRequirementOther_"+modal).val();
                var switch_user_id = '<?php echo $switch_user_id; ?>';

                if (requirement_other != "") {
                    let x = Math.floor((Math.random() * 100) + 1);

                    var html = '<label class="mt-checkbox mt-checkbox-outline"> '+requirement_other;
                        html += '<input type="checkbox" value="'+requirement_other+'" name="document_other[]" data-id="'+x+'" onchange="checked_RequirementOther(this, '+modal+')" checked />';
                        html += '<span></span>';
                    html += '</label>';
                    $('#tabDocuments_'+modal+' .mt-checkbox-list').append(html);

                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+requirement_other+'" required /><b>'+requirement_other+'</b>';
                        data += '</td>';
                        data += '<td class="text-center">';
                            data += '<select class="form-control hide" name="document_other_filetype[]" onchange="changeType(this)" required>';
                                data += '<option value="0">Select option</option>';
                                data += '<option value="1">Manual Upload</option>';
                                data += '<option value="2">Youtube URL</option>';
                                data += '<option value="3">Google Drive URL</option>';
                            data += '</select>';
                            data += '<input class="form-control margin-top-15 fileUpload" type="file" name="document_other_file[]" onchange="changeFile(this, this.value)" style="display: none;" />';
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" style="display: none;" placeholder="https://" />';
                            data += '<p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                        data += '<td><input type="text" class="form-control document_filename" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td class="text-center">';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';

                        if (current_client == 0) {
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
                                data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+x+', 0, '+modal+')">Upload</a>';
                            data += '</td>';
                        }
                        
                        data += '<td rowspan="2" class="text-center">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';

                            if (switch_user_id == 5) {
                                data += '<div class="row margin-top-10">';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_reviewed[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Approved By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_approved[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                data += '</div>';
                            }

                        data += '</td>';
                    data += '</tr>';

                    $('#tableData_Requirement_'+modal+' tbody').append(data);
                    widget_date_other(x, modal);
                    widget_date_clear_other(x, modal);
                }
            }
            function checked_Requirement(id, modal, main, checked) {
                if (id.checked == true) {
                    $.ajax({
                        type: "GET",
                        url: "admin_2/function.php?modalView_Customer_Requirement="+id.value+"&modal="+modal+"&main="+main,
                        dataType: "html",                  
                        success: function(data){       
                            $('#tableData_Requirement_'+modal+' tbody').append(data);
                            widget_date(id.value, modal);

                            if (checked == 0) { widget_date_clear(id.value, modal); }
                        }
                    });
                } else {
                     $('#tableData_Requirement_'+modal+' tbody .tr_'+id.value).remove();
                }
            }
            function checked_RequirementOther(id, modal) {
                var x = $(id).attr("data-id");
                var switch_user_id = '<?php echo $switch_user_id; ?>';

                if (id.checked == true) {
                    var data = '<tr class="tr_other_'+x+'">';
                        data += '<td rowspan="2">';
                            data += '<input type="hidden" class="form-control" name="document_other_name[]" value="'+id.value+'" required /><b>'+id.value+'</b>';
                        data += '</td>';
                        data += '<td class="text-center">';
                            data += '<select class="form-control hide" name="document_other_filetype[]" onchange="changeType(this)" required>';
                                data += '<option value="0">Select option</option>';
                                data += '<option value="1">Manual Upload</option>';
                                data += '<option value="2">Youtube URL</option>';
                                data += '<option value="3">Google Drive URL</option>';
                            data += '</select>';
                            data += '<input class="form-control margin-top-15 fileUpload" type="file" name="document_other_file[]" onchange="changeFile(this, this.value)" style="display: none;" />';
                            data += '<input class="form-control margin-top-15 fileURL" type="url" name="document_other_fileurl[]" style="display: none;" placeholder="https://" />';
                            data += '<p style="margin: 0;"><button type="button" class="btn btn-sm red-haze uploadNew" onclick="uploadNew(this)">Upload</button></p>';
                        data += '</td>';
                        data += '<td><input type="text" class="form-control document_filename" name="document_other_filename[]" placeholder="Document Name" /></td>';
                        data += '<td class="text-center">';
                            data += '<div class="input-group">';
                                data += '<input type="text" class="form-control daterange" name="document_other_daterange[]" value="" />';
                                data += '<span class="input-group-btn">';
                                    data += '<button class="btn default date-range-toggle" type="button" onclick="widget_date_clears(this)">';
                                        data += '<i class="fa fa-close"></i>';
                                    data += '</button>';
                                data += '</span>';
                            data += '</div>';
                            data += '<input type="date" class="form-control hide" name="document_other_date[]" />';
                            data += '<input type="date" class="form-control hide" name="document_other_due[]" />';
                        data += '</td>';

                        if (current_client == 0) {
                            data += '<td rowspan="2" class="text-center">';
                                data += '<input type="file" class="form-control hide" name="document_other_template[]" />';
                                data += '<a href="#modalTemplate2" class="btn btn-sm red-haze" data-toggle="modal" onclick="btnTemplate2('+id+', 0, '+modal+')">Upload </a>';
                            data += '</td>';
                        }
                        
                        data += '<td rowspan="2" class="text-center">0%</td>';
                    data += '</tr>';
                    data += '<tr class="tr_other_'+x+'">';
                        data += '<td colspan="3">';
                            data += '<input type="text" class="form-control" name="document_other_comment[]" placeholder="Comment" />';

                            if (switch_user_id == 5) {
                                data += '<div class="row margin-top-10">';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Reviewed By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_reviewed[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                    data += '<div class="col-md-6">';
                                        data += '<div class="form-group">';
                                            data += '<label class="control-label">Approved By</label>';
                                            data += '<input type="hidden" class="form-control" name="document_other_approved[]" value="0"/>';
                                            data += '<p style="margin: 0; font-weight: 700;">Not Yet</p>';
                                        data += '</div>';
                                    data += '</div>';
                                data += '</div>';
                            }

                        data += '</td>';
                    data += '</tr>';

                    $('#tableData_Requirement_'+modal+' tbody').append(data);
                    widget_date_other(x, modal);
                    widget_date_clear_other(x, modal);
                } else {
                    $('#tableData_Requirement_'+modal+' tbody .tr_other_'+x).remove();
                }
            }

            // Contact Section
            $(".modalSave_Contact").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Contact',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Contact'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.contact_name+'</td>';
                                html += '<td>'+obj.contact_title+'</td>';
                                html += '<td>'+obj.contact_address+'</td>';
                                html += '<td class="text-center">';
                                    html += '<ul class="list-inline">';
                                        if (obj.contact_email != "") { html += '<li><a href="mailto:'+obj.contact_email+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                        if (obj.contact_phone != "") { html += '<li><a href="tel:'+obj.contact_phone+'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                        if (obj.contact_cell != "") { html += '<li><a href="tel:'+obj.contact_cell+'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                        if (obj.contact_fax != "") { html += '<li><a href="tel:'+obj.contact_fax+'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                    html += '</ul>';
                                html += '</td>';
                                html += '<td class="text-center hide">';
                                    html += '<input type="checkbox" class="make-switch" data-size="mini" name="contact_status_arr[]" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="default" />';
                                html += '</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="contact_id[]" value="'+obj.ID+'" readonly />';
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1, \'modalEditContact\')">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Contact_'+obj.modal+' tbody').append(html);
                            $('#modalNewContact').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Contact(id, modal, view) {
                btnReset(view);
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalNew_Supplier_Contact="+id+"&m="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalNewContact .modal-body").html(data);
                    }
                });
            }
            $(".modalUpdate_Contact").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Supplier_Contact',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Supplier_Contact'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var html = '<td>'+obj.contact_name+'</td>';
                            html += '<td>'+obj.contact_title+'</td>';
                            html += '<td>'+obj.contact_address+'</td>';
                            html += '<td class="text-center">';
                                html += '<ul class="list-inline">';
                                    if (obj.contact_email != "") { html += '<li><a href="mailto:'+obj.contact_email+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'; }
                                    if (obj.contact_phone != "") { html += '<li><a href="tel:'+obj.contact_phone+'" target="_blank" title="Phone"><i class="fa fa-phone-square"></i></a></li>'; }
                                    if (obj.contact_cell != "") { html += '<li><a href="tel:'+obj.contact_cell+'" target="_blank" title="Cell Number"><i class="fa fa-phone"></i></a></li>'; }
                                    if (obj.contact_fax != "") { html += '<li><a href="tel:'+obj.contact_fax+'" target="_blank" title="Fax"><i class="fa fa-print"></i></a></li>'; }
                                html += '</ul>';
                            html += '</td>';
                            html += '<td class="text-center hide">';
                                html += '<input type="checkbox" class="make-switch" data-size="mini" name="contact_status_arr[]" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="default" />';
                            html += '</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="contact_id[]" value="'+obj.ID+'" readonly />';
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditContact" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Contact" onclick="btnEdit_Contact('+obj.ID+', 1)">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Contact" onclick="btnRemove_Contact('+obj.ID+', 1)">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</td>';

                            $('#tableData_Contact_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditContact').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Contact(id, modal, view) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalView_Supplier_Contact="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditContact .modal-body").html(data);
                    }
                });
            }
            function btnRemove_Contact(id, modal) {
                // $('#tableData_Contact_'+modal+' tbody #tr_'+id).remove();

                swal({
                    title: "Are you sure?",
                    text: "Your item will be remove!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $('#tableData_Contact_'+modal+' tbody #tr_'+id).remove();
                    swal("Done!", "This item has been removed. Make sure to click SAVE to save the changes.", "success");
                });
            }

            // Product Section
            $(".modalSave_Product").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Customer_Product',true);

                var l = Ladda.create(document.querySelector('#btnSave_Customer_Product'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.material_name+'</td>';
                                html += '<td>'+obj.material_id+'</td>';
                                html += '<td>'+obj.material_description+'</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditProduct" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Product" onclick="btnEdit_Product('+obj.ID+', '+obj.modal+', \'modalEditProduct\')">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Product" onclick="btnRemove_Product('+obj.ID+', '+obj.modal+')">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Product_'+obj.modal+' tbody').append(html);
                            $('#modalNewProduct').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Product(id, modal, view) {
                btnReset(view);
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalNew_Customer_Product="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewProduct .modal-body").html(data);
                        widget_formRepeater_material('New');
                        widget_dates_product('New');
                    }
                });
            }
            $(".modalUpdate_Product").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Customer_Product',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Customer_Product'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var html = '<td>'+obj.material_name+'</td>';
                            html += '<td>'+obj.material_id+'</td>';
                            html += '<td>'+obj.material_description+'</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="material_id[]" value="'+obj.ID+'" readonly />';
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditProduct" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Product" onclick="btnEdit_Product('+obj.ID+', '+obj.modal+', \'modalEditProduct\')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Product" onclick="btnRemove_Product('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</td>';

                            $('#tableData_Product_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditProduct').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Product(id, modal, view) {
                btnClose(view);
                $.ajax({
                    type: "GET",
                    url: "admin_2/function.php?modalView_Customer_Product="+id+"&m="+modal,
                    dataType: "html",
                    success: function(data){
                        $("#modalEditProduct .modal-body").html(data);
                        widget_formRepeater_material('Edit');
                        widget_dates_product('Edit');
                    }
                });
            }
            function btnRemove_Product(id, modal) {
                $('#tableData_Product_'+modal+' tbody #tr_'+id).remove();
            }

            // Service Section
            $(".modalSave_Service").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Customer_Service',true);

                var l = Ladda.create(document.querySelector('#btnSave_Customer_Service'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var html = '<tr id="tr_'+obj.ID+'">';
                                html += '<td>'+obj.service_name+'</td>';
                                html += '<td>'+obj.service_id+'</td>';
                                html += '<td>'+obj.service_description+'</td>';
                                html += '<td class="text-center">';
                                    html += '<input type="hidden" class="form-control" name="service_id[]" value="'+obj.ID+'" readonly />';
                                    html += '<div class="mt-action-buttons">';
                                        html += '<div class="btn-group btn-group-circle">';
                                            html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+', \'modalEditService\')">Edit</a>';
                                            html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                        html += '</div>';
                                    html += '</div>';
                                html += '</td>';
                            html += '</tr>';

                            $('#tableData_Service_'+obj.modal+' tbody').append(html);
                            $('#modalNewService').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnNew_Service(id, modal, view) {
                btnReset(view);
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalNew_Customer_Service="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalNewService .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            $(".modalUpdate_Service").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnUpdate_Customer_Service',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_Customer_Service'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            var html = '<td>'+obj.service_name+'</td>';
                            html += '<td>'+obj.service_id+'</td>';
                            html += '<td>'+obj.service_description+'</td>';
                            html += '<td class="text-center">';
                                html += '<input type="hidden" class="form-control" name="service_id[]" value="'+obj.ID+'" readonly />';
                                html += '<div class="mt-action-buttons">';
                                    html += '<div class="btn-group btn-group-circle">';
                                        html += '<a href="#modalEditService" data-toggle="modal" class="btn btn-outline dark btn-sm btnEdit_Service" onclick="btnEdit_Service('+obj.ID+', '+obj.modal+', \'modalEditService\')">Edit</a>';
                                        html += '<a href="javascript:;" class="btn btn-outlinex red btn-sm btnRemove_Service" onclick="btnRemove_Service('+obj.ID+', '+obj.modal+')">Delete</a>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</td>';

                            $('#tableData_Service_'+obj.modal+' tbody #tr_'+obj.ID).html(html);
                            $('#modalEditService').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnEdit_Service(id, modal, view) {
                btnClose(view);
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalView_Customer_Service="+id+"&m="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalEditService .modal-body").html(data);
                        widget_formRepeater();
                    }
                });
            }
            function btnRemove_Service(id, modal) {
                $('#tableData_Service_'+modal+' tbody #tr_'+id).remove();
            }

            //Template Section
            function btnTemplate(id, temp) {
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalNew_Supplier_Template="+id+"&temp="+temp,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalTemplate .modal-body").html(data);
                    }
                });
            }
            function btnTemplate_delete(id, temp) {
                swal({
                    title: "Are you sure?",
                    text: "Your item will be deleted!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: "admin_2/function.php?btnDelete_Supplier_Template="+temp,
                        dataType: "html",
                        success: function(response){
                            $dataTemp = '<a href="#modalTemplate" class="btn btn-xs btn-success" data-toggle="modal" onclick="btnTemplate('+id+', '+temp+')"><i class="fa fa-cloud-upload"></i></a>';
                            $('#tableData_3 tbody #tr_'+id+' > td:last-child').html($dataTemp);
                        }
                    });
                    swal("Done!", "This item has been deleted.", "success");
                });
            }
            $(".modalSave_Template").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Template',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Template'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            $('#tableData_3 tbody #tr_'+obj.ID+' > td:last-child').html(obj.view);

                            $('#modalTemplate').modal('hide');
                        } else {
                            msg = "Error!"
                        }
                        l.stop();

                        bootstrapGrowl(msg);
                    }
                });
            }));
            function btnTemplate2(id, temp, modal) {
                $.ajax({    
                    type: "GET",
                    url: "admin_2/function.php?modalNew_Supplier_Template2="+id+"&temp="+temp+"&modal="+modal,
                    dataType: "html",                  
                    success: function(data){       
                        $("#modalTemplate2 .modal-body").html(data);
                    }
                });
            }
            $(".modalSave_Template2").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;
                    
                var formData = new FormData(this);
                formData.append('btnSave_Supplier_Template2',true);

                var l = Ladda.create(document.querySelector('#btnSave_Supplier_Template2'));
                l.start();

                $.ajax({
                    url: "admin_2/function.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData:false,
                    cache: false,
                    success: function(response) {
                        if ($.trim(response)) {
                            msg = "Sucessfully Save!";
                            var obj = jQuery.parseJSON(response);
                            $('#tableData_Requirement_'+obj.modal+' tbody .tr_'+obj.ID+':first-child > td:nth-last-child(2)').html(obj.view2);
                            $('#tableData_3 tbody #tr_'+obj.ID+' > td:last-child').html(obj.view);

                            $('#modalTemplate2').modal('hide');
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