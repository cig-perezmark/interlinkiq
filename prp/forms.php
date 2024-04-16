<?php
    include_once ('../database_forms.php');

    $data = array();

    $title     = "PRP Tracking";

    // $color_red   = "#c0392b ";
    $color_white = "#FFFFFF";
    $color_green = "#16a085 ";
    $color_orange = "#e59866 ";

    $ID        = "id";
    $PERFORMED = "performed";
    $REVIEWED  = "reviewed";
    $DEVIATION = "length_deviation";
    $TOTAL_ERRORS = "total_errors";

    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    
    if (!empty($start_date) AND !empty($end_date)) {
        
        # START DATE RANGE
        $all_dates = [];
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end_date);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start_date), $interval, $realEnd);
    
        foreach($period as $date) {
            $all_dates[] = $date->format('Y-m-d'); 
        }
        # END DATE RANGE

        # ALL PROJECTS
        $all_projects = [];

        $project = new stdClass();
        $project->name = "Thermometer Calibration";
        $project->sql  = "SELECT b.PK_id AS $ID, clr_datetime_created AS $PERFORMED, clr_datetime_verified AS $REVIEWED, IF(clrd_result='P' OR (clrd_result!='P' AND LENGTH(TRIM(clrd_corrective_action))>0),0,1) AS $DEVIATION FROM tbl_thermometer_calibration_log_record_details a LEFT JOIN tbl_thermometer_calibration_log_records b ON a.clrd_clr_id=b.PK_id WHERE DATE_FORMAT(clr_datetime_created,'%Y-%m-%d')='DATE_VAR' ORDER by clr_datetime_created DESC";
        // $project->pending_form = "";
        $project->pending_form = "e-forms/AP_records/ap/thcal_log/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Lactic Acid Testing Log";
        $project->sql  = "SELECT b.id AS $ID, date_performed AS $PERFORMED, date_submitted AS $REVIEWED, IF((functionality='pass' AND coverage='pass') OR (LENGTH(TRIM(deviation))>0 AND date_corrected IS NOT NULL),0,1) AS $DEVIATION FROM tbl_latl a LEFT JOIN tbl_latl_records b ON a.record_no=b.id WHERE DATE_FORMAT(date_performed,'%Y-%m-%d')='DATE_VAR' AND deleted='no' ORDER by date_performed DESC";
        // $project->pending_form = "latl/view_form_details?id=";
        $project->pending_form = "e-forms/AP_records/ap/latl/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Acetic Acid Mix Log";
        $project->sql  = "SELECT b.id AS $ID, date_performed AS $PERFORMED, date_recorded AS $REVIEWED, IF((LENGTH(TRIM(deviation))>0 AND date_corrected IS NOT NULL) OR functionality='pass',0,1) AS $DEVIATION FROM tbl_aaml_data a LEFT JOIN tbl_aaml b ON a.aaml_id=b.id WHERE DATE_FORMAT(date_performed,'%Y-%m-%d')='DATE_VAR' AND deleted='no' ORDER by date_performed DESC";
        // $project->pending_form = "aaml/view_form_details?id=";
        $project->pending_form = "e-forms/AP_records/ap/aaml/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Foreign Material Program";
        $project->sql  = "SELECT c.id AS $ID, entry_time AS $PERFORMED, date_reviewed AS $REVIEWED, IF(rule1='fail',1,0) AS $DEVIATION FROM tbl_fmp_data a LEFT JOIN tbl_fmp_descriptions b ON a.description_id=b.id LEFT JOIN tbl_fmp c ON b.fmp_id=c.id WHERE DATE_FORMAT(entry_time,'%Y-%m-%d')='DATE_VAR' AND a.deleted='no' ORDER by entry_time DESC";
        // $project->pending_form = "fmp/view_form_details?id=";
        $project->pending_form = "e-forms/AP_records/ap/fmp/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Freezer Temperatures";
        $project->sql  = "SELECT b.id AS $ID, date_initial AS $PERFORMED, date_reviewed AS $REVIEWED, IF((LENGTH(TRIM(deviation))>0 AND date_corrected IS NOT NULL) OR a.condition='pass',0,1) AS $DEVIATION FROM tbl_ft_data a LEFT JOIN tbl_ft b ON a.ft_id=b.id WHERE DATE_FORMAT(date_initial,'%Y-%m-%d')='DATE_VAR' AND a.deleted='no' ORDER by date_initial DESC";
        // $project->pending_form = "ft/view_form_details?id=";
        $project->pending_form = "e-forms/AP_records/ap/ft/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Carcass Chill Log - Cooler";
        $project->sql  = "SELECT b.id AS $ID, date_initial AS $PERFORMED, date_reviewed AS $REVIEWED, IF((LENGTH(TRIM(deviation))>0 AND date_corrected IS NOT NULL) OR a.condition='pass',0,1) AS $DEVIATION FROM tbl_cclc_data a LEFT JOIN tbl_cclc b ON a.ft_id=b.id WHERE DATE_FORMAT(date_initial,'%Y-%m-%d')='DATE_VAR' AND a.deleted='no' ORDER by date_initial DESC";
        // $project->pending_form = "cclc/view_form_details?id=";
        $project->pending_form = "e-forms/AP_records/ap/cclc/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Ambient Room Temperature";
        $project->sql  = "SELECT b.id AS $ID, date_initial AS $PERFORMED, date_reviewed AS $REVIEWED, IF((LENGTH(TRIM(deviation))>0 AND date_corrected IS NOT NULL) OR a.condition='pass',0,1) AS $DEVIATION FROM tbl_art_data a LEFT JOIN tbl_art b ON a.ft_id=b.id WHERE DATE_FORMAT(date_initial,'%Y-%m-%d')='DATE_VAR' AND a.deleted='no' ORDER by date_initial DESC";
        // $project->pending_form = "art/view_form_details?id=";
        $project->pending_form = "e-forms/AP_records/ap/art/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Pre-Ops / Inspection - Packaging";
        $project->sql  = preops_sql("kill_floor", $ID, $PERFORMED, $REVIEWED, $DEVIATION, $TOTAL_ERRORS);
        // $project->pending_form = "";
        $project->pending_form = "e-forms/AP_records/ap/gmp_packaging/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Pre-Ops / Inspection - Kill Floor";
        $project->sql  = preops_sql("packaging", $ID, $PERFORMED, $REVIEWED, $DEVIATION, $TOTAL_ERRORS);
        // $project->pending_form = "";
        $project->pending_form = "e-forms/AP_records/ap/gmp_kill_floor/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Pre-Ops / Inspection - Boning";
        $project->sql  = preops_sql("boning", $ID, $PERFORMED, $REVIEWED, $DEVIATION, $TOTAL_ERRORS);
        // $project->pending_form = "";
        $project->pending_form = "e-forms/AP_records/ap/gmp_boning/details?id=";
        $all_projects[] = $project;

        $project = new stdClass();
        $project->name = "Pre-Ops / Inspection - Grinding";
        $project->sql  = preops_sql("grinding", $ID, $PERFORMED, $REVIEWED, $DEVIATION, $TOTAL_ERRORS);
        // $project->pending_form = "";
        $project->pending_form = "e-forms/AP_records/ap/gmp_grinding/details?id=";
        $all_projects[] = $project;

        foreach($all_projects as $project){
            
            $project_data = [];

            foreach($all_dates as $date){

                $sql = str_replace("DATE_VAR", $date, $project->sql);
                $result = mysqli_query( $e_connection, $sql );

                $obj = new stdClass();
                $obj->date = $date;
                
	            if ( mysqli_num_rows($result) > 0 ) {
                    $row = mysqli_fetch_array($result);
                    $id        = $row[$ID];
                    $performed = $row[$PERFORMED];
                    $reviewed  = $row[$REVIEWED];
                    $deviation = $row[$DEVIATION];
                    // $total_errors = $row[$TOTAL_ERRORS];

                    $obj->performed = $color_green;
                    
                    if($reviewed == null){
                        $obj->reviewed = $color_orange;
                        // $obj->r_form = $this->get_url($project->pending_form.$id);
                        $obj->r_form = $project->pending_form.$id;
                    }else{
                        $obj->reviewed = $color_green;
                    }

                    if($performed == null){
                        $obj->deviation = $color_white; 
                    }else if(intval($deviation)>0){
                        $obj->deviation = $color_orange; 
                        // $obj->d_form = get_url($project->pending_form.$id);
                        $obj->d_form = $project->pending_form.$id;
                    }else{
                        $obj->deviation = $color_green; 
                    }

                    if(isset($row[$TOTAL_ERRORS])){
                        $obj->total_errors = $row[$TOTAL_ERRORS]; 
                    }
                }
                else {
                    $obj->performed = $color_white;
                    $obj->reviewed  = $color_white; 
                    $obj->deviation = $color_white; 
                }
                $project_data[] = $obj;
            }

            $obj = new stdClass();
            $obj->name = $project->name;
            $obj->data = $project_data; 
            $data[] = $obj;
        }
        echo json_encode($data);
    } else {
        $data['title'] = $title;
        echo json_encode($data);
    }

    function get_url($path){
        return site_url("records/classCode/$path");
    }

    function preops_sql($form, $ID, $PERFORMED, $REVIEWED, $DEVIATION, $TOTAL_ERRORS){
        $sql = '
            SELECT id AS '.$ID.', date_created AS '.$PERFORMED.', gr_approved_by AS '.$REVIEWED.', SUM(if(dev>0 AND ACTION=0,1,0)) as '.$DEVIATION.', SUM(if(dev>0 AND action=0,1,0)) AS '.$TOTAL_ERRORS.' from (
            SELECT 
                c.PK_id AS id,
                c.gr_approved_by, 
                c.gr_datetime_created AS date_created,
                length(IFNULL(trim(a.grd_deviation_findings),"")) AS dev, 
                length(IFNULL(trim(a.grd_corrective_action),"")) AS action
                from tbl_ap_gmp_records_details_items_'.$form.' a left join tbl_ap_gmp_records_details_'.$form.' b on a.PK_id=b.PK_id left join tbl_ap_gmp_records_'.$form.' c on b.FK_grd_record_id=c.PK_id where date_format(gr_datetime_created, "%Y-%m-%d")="DATE_VAR"
            UNION 
            SELECT
                b.PK_id AS id,
                b.gr_approved_by, 
                b.gr_datetime_created AS date_created,
                length(IFNULL(trim(a.grd_deviation_findings),"")) AS dev, 
                length(IFNULL(trim(a.grd_corrective_action),"")) AS action
                from tbl_ap_gmp_records_details_'.$form.' a left join tbl_ap_gmp_records_'.$form.' b on a.FK_grd_record_id=b.PK_id where date_format(gr_datetime_created, "%Y-%m-%d")="DATE_VAR"
            ) c group by date_created';
        return $sql;
    }
?>