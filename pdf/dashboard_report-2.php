<?php

	require_once __DIR__ . '/vendor/autoload.php';
    include_once ('../database_iiq.php');

	$mpdf = new \Mpdf\Mpdf();
    $base_url = "https://interlinkiq.com/";
	$html = '';
    
	$ID = 0;
    
    $selectAPI = mysqli_query( $conn,"SELECT ID FROM tbl_api_keys" );
    if ( mysqli_num_rows($selectAPI) > 0 ) {
        $rowAPI = mysqli_fetch_array($selectAPI);
        $api_key = $rowAPI["ID"]; // 32 chars for AES-256
    }
    $encoded = urlencode($_GET['i']);
    if (!empty($encoded)) {
        $decoded = base64_decode(urldecode($encoded));

        // Extract IV (first 16 bytes) and ciphertext
        $api_iv = substr($decoded, 0, 16);
        $api_ciphertext = substr($decoded, 16);

        $ID = openssl_decrypt($api_ciphertext, 'aes-256-cbc', $api_key, OPENSSL_RAW_DATA, $api_iv);
    }
	
	$selectData = mysqli_query( $conn,"
	    SELECT 
        l.user_id AS l_user_id,
        CASE WHEN e.businessname IS NOT NULL AND e.businessname != '' THEN e.businessname ELSE CONCAT(u.first_name, ' ', u.last_name) END AS l_company,
        e.Bldg AS l_address,
        CONCAT_WS(', ', e.city, e.States, e.ZipCode) AS l_city,
        CASE WHEN e.businessemailAddress IS NOT NULL AND e.businessemailAddress != '' THEN e.businessemailAddress ELSE u.email END AS l_email,
        CASE WHEN e.BrandLogos IS NOT NULL AND e.BrandLogos != '' THEN 'companyDetailsFolder' ELSE 'uploads/avatar' END AS l_logo_path,
        CASE WHEN e.BrandLogos IS NOT NULL AND e.BrandLogos != '' THEN e.BrandLogos ELSE i.avatar END AS l_logo,
        e.ProductDesc AS l_product,
        CONCAT_WS(' ', c.contactpersonname, c.contactpersonlastname) AS l_primary_name,
        c.contactpersoncellno AS l_primary_contact,
        c.contactpersonemailAddress AS l_primary_email,
        CASE WHEN LENGTH(l.name) - LENGTH(REPLACE(l.name, ',', '')) = 3 THEN CONCAT_WS(' - ', nt.name, nc.name, ns.name, nm.name) ELSE l.name END AS l_name,
        l.child_id AS l_child_id,
        CONCAT_WS(' ', ula.first_name, ula.last_name) AS l_lead_auditor_name,
        ula.email AS l_lead_auditor_email,
        CONCAT_WS(' ', ua.first_name, ua.last_name) AS l_auditor_name,
        ua.email AS l_auditor_email,
        CONCAT_WS(' ', uo.first_name, uo.last_name) AS l_observer_name,
        GROUP_CONCAT(CONCAT_WS(' ', ute.first_name, ute.last_name) SEPARATOR ', ') AS l_technical_expert_name,
        l.reviewer_signature AS l_reviewer_signature,
        l.approver_signature AS l_approver_signature,
        l.audit_sched_from AS l_audit_sched_from,
        l.audit_sched_to AS l_audit_sched_to,
        l.category AS l_categories,
        l.scope AS l_scopes,
        l.summary AS l_summary
        
        FROM tbl_library AS l
        
        LEFT JOIN (
        	SELECT
            ID,
            first_name,
            last_name,
            email
            FROM tbl_user
        ) AS u
        ON u.ID = l.user_id
        
        LEFT JOIN (
        	SELECT
            ID,
            first_name,
            last_name,
            email
            FROM tbl_user
        ) AS ula
        ON ula.ID = l.lead_auditor
        
        LEFT JOIN (
        	SELECT
            ID,
            first_name,
            last_name,
            email
            FROM tbl_user
        ) AS ua
        ON ua.ID = l.auditor
        
        LEFT JOIN (
        	SELECT
            ID,
            first_name,
            last_name,
            email
            FROM tbl_user
        ) AS uo
        ON uo.ID = l.observer

        LEFT JOIN (
        	SELECT
            ID,
            first_name,
            last_name,
            email
            FROM tbl_user
        ) AS ute
        ON FIND_IN_SET(ute.ID, REPLACE(l.technical_expert, ' ', ''))
        
        LEFT JOIN (
        	SELECT
            user_id,
            avatar
            FROM tbl_user_info
        ) AS i
        ON i.user_id = l.user_id
        
        LEFT JOIN (
        	SELECT
            businessname,
            businessemailAddress,
            Bldg,
            city,
            States,
            ZipCode,
            BrandLogos,
            ProductDesc,
            users_entities
            FROM tblEnterpiseDetails
        ) AS e
        ON e.users_entities = l.user_id

        LEFT JOIN (
            SELECT 
            con_id,
            contactpersonname,
            contactpersonlastname,
            contactpersoncellno,
            contactpersonemailAddress,
            user_cookies
            FROM tblEnterpiseDetails_Contact
            WHERE deleted = 0 
            AND contactpersonType = 2
        ) AS c
        ON c.user_cookies = l.user_id
        
        LEFT JOIN (
        	SELECT
            ID, name 
            FROM tbl_library_type
        ) AS nt
        ON nt.ID = SUBSTRING_INDEX(l.name, ',', 1)
        
        LEFT JOIN (
        	SELECT
            ID, name 
            FROM tbl_library_category
        ) AS nc
        ON nc.ID = SUBSTRING_INDEX(SUBSTRING_INDEX(l.name, ',', 2), ',', -1)
        
        LEFT JOIN (
        	SELECT
            ID, name 
            FROM tbl_library_scope
        ) AS ns
        ON ns.ID = SUBSTRING_INDEX(SUBSTRING_INDEX(l.name, ',', 3), ',', -1)
        
        LEFT JOIN (
        	SELECT
            ID, name 
            FROM tbl_library_module
        ) AS nm
        ON nm.ID = SUBSTRING_INDEX(SUBSTRING_INDEX(l.name, ',', 4), ',', -1)
        
        WHERE l.ID = $ID
	" );
	if ( mysqli_num_rows($selectData) > 0 ) {
        $rowData = mysqli_fetch_array($selectData);
        $l_company = htmlentities($rowData['l_company'] ?? '');
        $l_address = $rowData['l_address'];
        $l_city = $rowData['l_city'];
        $l_email = $rowData['l_email'];
        $l_logo_path = $rowData['l_logo_path'];
        $l_logo = $rowData['l_logo'];
        $l_product = $rowData['l_product'];
        $l_primary_name = $rowData['l_primary_name'];
        $l_primary_contact = $rowData['l_primary_contact'];
        $l_primary_email = $rowData['l_primary_email'];
        $l_name = $rowData['l_name'];
        $l_child_id = $rowData['l_child_id'];
        
        $l_lead_auditor_name = $rowData['l_lead_auditor_name'];
        $l_lead_auditor_email = $rowData['l_lead_auditor_email'];
        $l_auditor_name = $rowData['l_auditor_name'];
        $l_auditor_email = $rowData['l_auditor_email'];
        $l_observer_name = $rowData['l_observer_name'];
        $l_technical_expert_name = $rowData['l_technical_expert_name'];
        
        $l_reviewer_signature = $rowData['l_reviewer_signature'];
        $l_approver_signature = $rowData['l_approver_signature'];
        
        $l_audit_sched_from = new DateTime($rowData['l_audit_sched_from']);
        $l_audit_sched_from_new = $l_audit_sched_from->format('F j, Y');
        
        $l_audit_sched_to = new DateTime($rowData['l_audit_sched_to']);
        $l_audit_sched_to_new = $l_audit_sched_to->format('F j, Y');
        
        $interval = $l_audit_sched_from->diff($l_audit_sched_to);
        $days = $interval->days + 1;
        
        $l_categories = htmlentities($rowData['l_categories'] ?? '');
        $l_scopes = htmlentities($rowData['l_scopes'] ?? '');
        $l_summary = htmlentities($rowData['l_summary'] ?? '');
	}
	
	
	$html_summary = '';   
	$html_full = '';   
    $selectLibrary= mysqli_query( $conn,"
    SELECT
    *
    FROM (
        SELECT
        *,
        CASE WHEN COUNT(ar2.ar_ID) = SUM(ar2.ar_output) THEN 1 ELSE 0 END AS r_result,
        CASE
            WHEN ar2.hierarchy_level = 1 THEN REGEXP_SUBSTR(ar2.l_name, '[0-9]+(?:\\.[0-9]+)?')
            WHEN ar2.hierarchy_level IN (2, 3) THEN REGEXP_SUBSTR(ar2.l_name, '^[0-9]+(?:\\.[0-9]+)*')
            WHEN ar2.hierarchy_level IN (4, 5) THEN SUBSTRING_INDEX(ar2.l_name, '-', 1)
            ELSE NULL
        END AS clause,
        CASE
            WHEN ar2.hierarchy_level = 1 THEN TRIM(REPLACE(l_name, REGEXP_SUBSTR(ar2.l_name, '[0-9]+(?:\\.[0-9]+)?'), ''))
            WHEN ar2.hierarchy_level IN (2, 3) THEN TRIM(SUBSTR(ar2.l_name, LENGTH(REGEXP_SUBSTR(ar2.l_name, '^[0-9]+(?:\\.[0-9]+)*')) + 1))
            WHEN ar2.hierarchy_level IN (4, 5) THEN TRIM(SUBSTR(ar2.l_name, LENGTH(SUBSTRING_INDEX(ar2.l_name, '-', 1)) + 2))
            ELSE NULL
        END AS title
        FROM (
            WITH RECURSIVE cte (l_ID, l_name, l_type, l1_parent_id, l1_child_id, l1_ordering, sort_path, hierarchy_level) AS (
            	SELECT
            	l1.ID AS l_ID,
            	l1.name AS l_name,
            	l1.type AS l_type,
            	l1.parent_id AS l1_parent_id,
            	l1.child_id AS l1_child_id,
            	l1.ordering AS l1_ordering,
            	CAST(l1.ID AS CHAR(1000000)) AS sort_path,
            	1 AS hierarchy_level
        
            	FROM tbl_library AS l1
        
            	WHERE l1.deleted = 0
            	AND l1.parent_id = $ID
        
            	UNION ALL
        
            	SELECT
            	l2.ID AS l_ID,
            	l2.name AS l_name,
            	l2.type AS l_type,
            	l2.parent_id AS l1_parent_id,
            	l2.child_id AS l1_child_id,
            	l2.ordering AS l1_ordering,
            	CONCAT(cte.sort_path, '.', l2.ID),
            	cte.hierarchy_level + 1
        
            	FROM tbl_library AS l2
            	JOIN cte ON cte.l_ID = l2.parent_id
        
            	WHERE l2.deleted = 0
            )
            SELECT
            l_ID, l_name, l_type, l1_parent_id, l1_child_id, l1_ordering, sort_path, hierarchy_level,
            COALESCE(ar.r_ID, 0) AS ar_ID,
            ar.r_action_items AS ar_ction_items, 
            ar.r_requirements AS ar_requirements,
            ar.r_files AS ar_files, 
            ar.r_compliant AS ar_compliant,
        
            COALESCE(ar.r2_ID, 0) AS r2_ID,
            ar.r2_compliant,
            COALESCE(ar.r3_ID, 0) AS r3_ID,
            ar.r3_result,
        
            aro.title AS aro_title,
            aro.comment AS aro_comment,
            aro.files AS aro_files,
            arc.title AS arc_title,
            arc.comment AS arc_comment,
            arc.files AS arc_files,
            
            CASE WHEN (ar.r2_compliant = 1 AND COUNT(ar.r2_ID) = SUM(ar.r3_result)) OR (ar.r2_compliant = 1 AND COUNT(ar.r2_ID) = 0) THEN 1 ELSE 0 END AS ar_output
            
            FROM cte
        
            LEFT JOIN (
            	SELECT
            	r.ID AS r_ID,
            	r.library_id AS r_library_id,
            	r.action_items AS r_action_items,
            	r.requirements AS r_requirements,
            	r.files AS r_files,
            	r.compliant AS r_compliant,
                r2.ID AS r2_ID,
                r2.compliant AS r2_compliant,
                r2.last_modified AS r2_last_modified,
                r3.ID AS r3_ID,
                r3.compliant AS r3_compliant,
                r3.last_modified AS r3_last_modified,
                DATE_ADD(r3.last_modified, INTERVAL 1 YEAR) AS r3_last_modified_new,
                r3.type AS r3_type,
                CASE WHEN (r3.type = 3 AND DATE_ADD(r3.last_modified, INTERVAL 1 YEAR) > CURDATE()) OR (r3.type IS NULL AND r.compliant = 1 AND DATE_ADD(r2.last_modified, INTERVAL 1 YEAR) > CURDATE()) THEN 1 ELSE 0 END AS r3_result
            	FROM tbl_library_review AS r
        
                LEFT JOIN (
                    SELECT
                    ID,
                    parent_id,
                    compliant,
                    last_modified,
                    type,
                    library_id
                    FROM tbl_library_review
                    WHERE is_deleted = 0
                ) AS r2
                ON r2.parent_id = r.ID 
                AND r2.library_id =  r.library_id
        
                LEFT JOIN (
                    SELECT
                    ID,
                    parent_id,
                    compliant,
                    last_modified,
                    type,
                    library_id
                    FROM tbl_library_review
                    WHERE is_deleted = 0
                ) AS r3
                ON r3.parent_id = r2.ID
                AND r3.library_id =  r.library_id
        
                WHERE r.parent_id = 0
                AND r.is_deleted = 0
            ) AS ar
            ON ar.r_library_id = cte.l_ID
            AND cte.hierarchy_level > 3
    
            LEFT JOIN (
                SELECT
                ID,
                title,
                comment,
                library_id,
                parent_id,
                files
                FROM tbl_library_review 
        
                WHERE type = 4
                AND is_deleted = 0
            ) AS aro
            ON aro.library_ID = l_ID
            AND aro.parent_id = ar.r_ID
        
            LEFT JOIN (
                SELECT
                ID,
                title,
                comment,
                library_id,
                parent_id,
                files
                FROM tbl_library_review 
        
                WHERE type < 4
                AND is_deleted = 0
            ) AS arc
            ON arc.library_ID = l_ID
            AND arc.parent_id = aro.ID
    
            GROUP BY l_ID, ar.r_ID, ar.r2_ID, ar.r3_ID
        
            ORDER BY 
              l_ID, ar.r_ID, ar.r_action_items
         ) ar2
         
        WHERE ar2.hierarchy_level < 5
        OR (ar2.hierarchy_level = 5 AND ar2.ar_ID > 0)
         
        GROUP BY ar2.l_ID, ar2.ar_ID
    ) ar3
    
ORDER BY
LPAD(SUBSTRING_INDEX(ar3.clause, '.', 1), 3, '0'),
LPAD( CAST( IF( LENGTH(ar3.clause) - LENGTH(REPLACE(ar3.clause, '.', '')) >= 1, SUBSTRING_INDEX(SUBSTRING_INDEX(ar3.clause, '.', 2), '.', -1), 0 ) AS UNSIGNED ), 3, '0' ),
LPAD( CAST( IF( LENGTH(ar3.clause) - LENGTH(REPLACE(ar3.clause, '.', '')) >= 2, SUBSTRING_INDEX(SUBSTRING_INDEX(ar3.clause, '.', 3), '.', -1), 0 ) AS UNSIGNED ), 3, '0' ),
IF( LENGTH(ar3.clause) - LENGTH(REPLACE(ar3.clause, '.', '')) >= 3, CONCAT( 'P', LPAD( CAST( REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(ar3.clause, '.', 4), '.', -1), 'P', '') AS UNSIGNED), 2, '0' ) ), '000' ),
IF( LENGTH(ar3.clause) - LENGTH(REPLACE(ar3.clause, '.', '')) >= 4, CONCAT( 'F', LPAD( CAST(REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(ar3.clause, '.', 5), '.', -1), 'F', '') AS UNSIGNED), 2, '0' ) ), '000' ),
IF( LENGTH(ar3.clause) - LENGTH(REPLACE(ar3.clause, '.', '')) >= 5, SUBSTRING_INDEX(SUBSTRING_INDEX(ar3.clause, '.', 6), '.', -1), '000' )

    " );
    if ( mysqli_num_rows($selectLibrary) > 0 ) {
        while($rowLibrary = mysqli_fetch_array($selectLibrary)) {
            $l_ID = $rowLibrary["l_ID"];
            $l_type = $rowLibrary["l_type"] < 3 ? 'bg-tbl-gray':'';
            $ar_ID = $rowLibrary["ar_ID"];
            $r2_ID = $rowLibrary["r2_ID"];
            $r3_ID = $rowLibrary["r3_ID"];
            $document = $rowLibrary["ar_files"];
            $compliant = $rowLibrary["r_result"];
            $aro_title = $rowLibrary["aro_title"];
            $aro_comment = $rowLibrary["aro_comment"];
            $aro_files = $rowLibrary["aro_files"];
            $arc_title = $rowLibrary["arc_title"];
            $arc_comment = $rowLibrary["arc_comment"];
            $arc_files = $rowLibrary["arc_files"];
            $sort_path = $rowLibrary["sort_path"];
            
            // $clause = $rowLibrary["l_ID"];
            $clause = '';
            $compliance_area = $rowLibrary["l_name"];
            $compliance_requirement = '';
            if ($rowLibrary["hierarchy_level"] == 1) {
                preg_match('/\d+/', $rowLibrary["l_name"], $matches);
                $clause = $matches[0];
            } else if ($rowLibrary["hierarchy_level"] == 2 OR $rowLibrary["hierarchy_level"] == 3) {
                // preg_match('/^\d+(\.\d+)+/', $rowLibrary["l_name"], $matches);
                // $clause = $matches[0];
                
                preg_match('/^(\d+(\.\d+)+)\s+(.*)$/', $rowLibrary["l_name"], $matches);
                $clause = $matches[1];
                $compliance_area = $matches[3];
            }
            
            if ($rowLibrary["l_type"] > 2) {
                $compliance_area = '';
                
                preg_match('/^([0-9]+(?:\\.[0-9]+)*\\.[A-Z0-9]+(?:\\.[A-Z0-9]+)*)-(.+)$/', $rowLibrary["l_name"], $matches);
                if (preg_match('/^([a-z])\\.\\s+(.*)$/i', $rowLibrary["ar_requirements"], $matches2)) {
                        
                    $clause = $matches[1].'.'.$matches2[1];
                    $compliance_requirement = $matches2[2];
                } else {
                    if (isset($matches[1])) {
                        $clause = $matches[1];
                    }
                    
                    if (isset($matches[2])) {
                        $compliance_area = $matches[2];
                    }
                    
                    $compliance_requirement = $rowLibrary["ar_requirements"];
                }
            }
            
            $clause = $rowLibrary["clause"];
            $compliance_area = $rowLibrary["title"];
            
            
            if ($compliant == 0) {
                $html_summary .= '<tr class="'.$l_type.'">
                    <td>'.$clause.'</td>
                    <td>'.$compliance_area.'</td>
                    <td>'.$compliance_requirement.'</td>
                    <td><a href="'.$base_url.'uploads/library/'.$document.'" target="_blank">'.$document.'</a></td>
                    <td>
                        <strong>'.$aro_title.'</strong><br>'.$aro_comment;
                    
                        if (!empty($aro_files)) {
                            $html_summary .= '<br><br><strong>Ref: </strong><a href="'.$base_url.'uploads/library/'.$aro_files.'" target="_blank">'.$aro_files.'</a>';
                        }
                    $html_summary .= '</td>
                    <td>
                        <strong>'.$arc_title.'</strong><br>'.$arc_comment;
                    
                        if (!empty($arc_files)) {
                            $html_summary .= '<br><br><strong>Ref: </strong><a href="'.$base_url.'uploads/library/'.$arc_files.'" target="_blank">'.$arc_files.'</a>';
                        }
                    $html_summary .= '</td>
                </tr>';
            } else {
                $html_full .= '<tr class="'.$l_type.'">
                    <td>'.$clause.'</td>
                    <td>'.$compliance_area.'</td>
                    <td>'.$compliance_requirement.'</td>
                    <td><a href="'.$base_url.'uploads/library/'.$document.'" target="_blank">'.$document.'</a></td>
                    <td style="text-align: center;"><input type="checkbox" onclick="return false" '; $html_full .= $compliant == 1 ? 'checked="checked"':''; $html_full .= ' readonly /></td>
                    <td style="text-align: center;"><input type="checkbox" onclick="return false" '; $html_full .= $compliant == 2 ? 'checked="checked"':''; $html_full .= ' readonly /></td>
                    <td>
                        <strong>'.$aro_title.'</strong><br>'.$aro_comment;
                    
                        if (!empty($aro_files)) {
                            $html_full .= '<br><br><strong>Ref: </strong><a href="'.$base_url.'uploads/library/'.$aro_files.'" target="_blank">'.$aro_files.'</a>';
                        }
                    $html_full .= '</td>
                    <td>
                        <strong>'.$arc_title.'</strong><br>'.$arc_comment;
                    
                        if (!empty($arc_files)) {
                            $html_full .= '<br><br><strong>Ref: </strong><a href="'.$base_url.'uploads/library/'.$arc_files.'" target="_blank">'.$arc_files.'</a>';
                        }
                    $html_full .= '</td>
                </tr>';
            }
        }
    }
	$html_company = '';
	
	$html = '<html>
	    <head>
	        <title>Compliance Dashboard Report</title>
    		<style>
    			.bg-tbl-gray {
    			    background: #dbdbdb;
    			    font-weight: 700;
    			}
    			.text-red {
    			    color: red;
    			}
    			@media print {
                    table {
                        page-break-inside: avoid; /* Avoids breaking the table initially */
                        break-inside: avoid; /* Modern equivalent */
                    }
                    
                    /* Optional: Allow breaking within table rows if necessary for very long content */
                    tr {
                        page-break-inside: auto;
                        break-inside: auto;
                    }
                }
    		</style>
	    </head>
	    <body>
	        <table width="100%" cellpadding="7" cellspacing="0" border="0">
                <tr>
                    <td width="20%" style="text-align: right;"><img src="../'.$l_logo_path.'/'.$l_logo.'" style="height: 100px;"></td>
                    <td width="60%" style="text-align: center;"><h3>'.$l_company.'<br>'.$l_address.$l_city.'</h3></td>
                    <td width="20%"></td>
                </tr>
                <tr>
                    <td width="20%"></td>
                    <td width="60%" style="text-align: center;"><h3>'.$l_name.' On-Site Internal Audit Summary Report</h3></td>
                    <td width="20%"></td>
                </tr>
            </table>
	        
	        <table width="100%" cellpadding="7" cellspacing="0" border="1">
	            <tr class="bg-tbl-gray">
	                <td colspan="2"><strong>COMPANY INFORMATION</strong></td>
	            </tr>
	            <tr>
	                <td><strong>Company Legal Name</strong></td>
	                <td>'.$l_company.'</td>
	            </tr>
	            <tr>
	                <td><strong>Address Line 1</strong></td>
	                <td>'.$l_address.'</td>
	            </tr>
	            <tr>
	                <td><strong>Address Line 2</strong></td>
	                <td></td>
	            </tr>
	            <tr>
	                <td><strong>Address Line 3</strong></td>
	                <td></td>
	            </tr>
	            <tr>
	                <td><strong>City, State, Postal Code</strong></td>
	                <td>'.$l_city.'</td>
	            </tr>
	            <tr>
	                <td><strong>Food Sector Categories</strong></td>
	                <td>'.$l_categories.'</td>
	            </tr>
	            <tr>
	                <td><strong>Products</strong></td>
	                <td>'.$l_product.'</td>
	            </tr>
	            <tr>
	                <td><strong>Scope Audited</strong></td>
	                <td>'.$l_scopes.'</td>
	            </tr>
	            <tr>
	                <td><strong>Primary Contact </strong></td>
	                <td>'.$l_primary_name.'</td>
	            </tr>
	            <tr>
	                <td><strong>Phone Number</strong></td>
	                <td>'.$l_primary_contact.'</td>
	            </tr>
	            <tr>
	                <td><strong>Email</strong></td>
	                <td>'.$l_primary_email.'</td>
	            </tr>
	            <tr class="bg-tbl-gray">
	                <td colspan="2"><strong>AUDIT TEAM AND AUDIT SCHEDULE<strong></td>
	            </tr>
	            <tr>
	                <td><strong>Lead Auditor</strong></td>
	                <td>'.$l_lead_auditor_name.'</td>
	            </tr>
	            <tr>
	                <td><strong>Email</strong></td>
	                <td>'.$l_lead_auditor_email.'</td>
	            </tr>
	            <tr>
	                <td><strong>Auditor</strong></td>
	                <td>'.$l_auditor_name.'</td>
	            </tr>
	            <tr>
	                <td><strong>Email</strong></td>
	                <td>'.$l_auditor_email.'</td>
	            </tr>
	            <tr>
	                <td><strong>Phone Number</strong></td>
	                <td>1-202-982-3002</td>
	            </tr>
	            <tr>
	                <td><strong>Technical Expert(s)</strong></td>
	                <td>'.$l_technical_expert_name.'</td>
	            </tr>
	            <tr>
	                <td><strong>Observer</strong></td>
	                <td>'.$l_observer_name.'</td>
	            </tr>
	            <tr>
	                <td><strong>Audit Schedule</strong></td>
	                <td>'.$l_audit_sched_from_new.' to '.$l_audit_sched_to_new.'</td>
	            </tr>
	            <tr>
	                <td><strong>Audit Duration</strong></td>
	                <td>'.$days.' days</td>
	            </tr>
	            <tr>
	                <td><strong>Working Language</strong></td>
	                <td>English</td>
	            </tr>
	        </table>
	        
	        <br>
	        
	        <table width="100%" cellpadding="7" cellspacing="0" border="1">
	            <tr class="bg-tbl-gray">
	                <td colspan="6"><strong>AUDIT FINDING</strong></td>
	            </tr>
	            <tr>
	                <td><strong>Clause</strong></td>
	                <td><strong>Compliance Area</strong></td>
	                <td><strong>Compliance Requirements</strong></td>
	                <td style="text-align: center;"><strong>Reference Document</strong></td>
	                <td><strong>Observation/ Comments</strong></td>
	                <td><strong>Recommendation/ Corrective Action</strong></td>
	            </tr>
	            '.$html_summary.'
	        </table>
	        
	        <br>
	        
	        <table width="100%" cellpadding="7" cellspacing="0" border="1">
	            <tr class="bg-tbl-gray">
	                <td><strong>AUDIT SUMMARY</strong></td>
	            </tr>
	            <tr>
	                <td>'.$l_summary.'</td>
	            </tr>
	        </table>
	        
	        <br>
	        
	        <table width="100%" cellpadding="7" cellspacing="0" border="1">
	            <tr class="bg-tbl-gray">
	                <td colspan=7"><strong>'.$l_name.' Requirements</strong></td>
	                <td><strong>Date: '.date('F j, Y').'</strong></td>
	            </tr>
	            <tr>
	                <td><strong>Clause</strong></td>
	                <td><strong>Compliance Area</strong></td>
	                <td><strong>Compliance Requirements</strong></td>
	                <td style="text-align: center;"><strong>Reference Document</strong></td>
	                <td style="text-align: center;"><strong>Compliant</strong></td>
	                <td style="text-align: center;"><strong>N/A</strong></td>
	                <td><strong>Observation/ Comments</strong></td>
	                <td><strong>Recommendation/ Corrective Action</strong></td>
	            </tr>
	            '.$html_full.'
	        </table>
	        
	        <br><br><br>
	        
	        <table width="100%" cellpadding="7" cellspacing="0" border="0">
	            <tr>
	                <td style="width: 15%;"</td>
	                <td style="width: 10%; text-align: right;">Prepared By:</td>
	                <td style="width: 30%;">
	                    <img src="'.$l_reviewer_signature.'" class="signature_img" style="display: block; border: 0; border-bottom: 1px solid; object-fit: contain;" />
	                    '.$l_auditor_name.'<br>
	                    Auditor, Compliance
	                </td>
	                
	                <td style="width: 10%;"></td>
	                
	                <td style="width: 10%; text-align: right;">Approved By:</td>
	                <td style="width: 30%;">
	                    <img src="'.$l_approver_signature.'" class="signature_img" style="display: block; border: 0; border-bottom: 1px solid; object-fit: contain;" />
	                    '.$l_lead_auditor_name.'<br>
	                    Lead Auditor, PCQI, Compliance
	                </td>
	                <td style="width: 15%;"</td>
	            </tr>
	        </table>
	    </body>
	</html>';
	

    // $mpdf->SetHTMLHeader('
    // <table width="100%" cellpadding="7" cellspacing="0" border="0">
    //     <tr>
    //         <td width="50%" style="border: 0;">'.$l_name.' Requirements</td>
    //         <td width="50%" style="border: 0; text-align: right;">Date: '.date('F j, Y').'</td>
    //     </tr>
    // </table>');
    // $mpdf->SetHTMLFooter('<div style="text-align: right;">{PAGENO}</div>');
    // $mpdf->AddPageByArray([
    //     'margin-top' => '30px'
    // ]);
    
    echo $html;
    
    // $mpdf->WriteHTML($html);
    // $mpdf->Output();
    
    // $title = htmlentities($topic ?? '').' - '.date('mdy');
    // $mpdf->SetDisplayMode('fullpage');
    // $mpdf->WriteHTML($html);
    // $mpdf->Output($title.'.pdf', 'I');
    
?>