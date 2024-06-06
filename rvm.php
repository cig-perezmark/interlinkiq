<?php 
    $title = "Records Verification Management";
    $site = "rvm";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>
<style type="text/css">
    /* DataTable*/
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
        position: relative;
    }
</style>


                    <div class="row">
                        <?php
                            function get_remote_file_info($url) {
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                curl_setopt($ch, CURLOPT_HEADER, TRUE);
                                curl_setopt($ch, CURLOPT_NOBODY, TRUE);
                                $data = curl_exec($ch);
                                $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                                $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                curl_close($ch);
                                return [
                                    'fileExists' => (int) $httpResponseCode == 200,
                                    'fileSize' => (int) $fileSize
                                ];
                            }

                            for ($i = 22; $i <= 22; $i++) {

                                // Compliance Dashboard (file, references, compliance, review, template, video)
                                // if ($i == 1) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_library_file WHERE deleted = 0 AND filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/library/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_library_file set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 2) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_library_references WHERE is_deleted = 0 AND filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/library/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_library_references set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 3) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_library_review WHERE is_deleted = 0 AND filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/library/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_library_review set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 22) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_library_compliance WHERE filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/library/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_library_compliance set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 4) {
                                // //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_library_template WHERE is_deleted = 0 AND filetype = 1 AND LENGTH(files) > 0" );
                                // //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                // //         $sql_ID = $rowSQL["ID"];
                                // //         $sql_files = rawurlencode($rowSQL["files"]);
                                // //         $sql_url = $base_url.'uploads/library/'.$sql_files;

                                // //         $result = get_remote_file_info($sql_url);
                                // //         $bytes = $result['fileSize'];

                                // //         mysqli_query( $conn,"UPDATE tbl_library_template set filesize = $bytes WHERE ID = $sql_ID" );
                                // //     }
                                // } else if ($i == 5) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_library_video WHERE is_deleted = 0 AND type = 0 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/library/'.$sql_files;
                                        
                                //         // echo $sql_url .'<br>';
                                         
                                //         $result = get_remote_file_info($sql_url);
                                //         // $result = get_remote_file_info('https://interlinkiq.com/uploads/library/299838%20-%20UNO-SHOPE-110722-Picking-List.pdf');
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_library_video set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }

                                // HR (department, file, job description, training)
                                // if ($i == 6) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_hr_department WHERE deleted = 0 AND filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_hr_department set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 7) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_hr_file WHERE deleted = 0 AND filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/hr/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_hr_file set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 8) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_hr_job_description WHERE filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_hr_job_description set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 9) {
                                //     // $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE deleted = 0 AND LENGTH(files) > 0" );
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_hr_trainings WHERE deleted = 0 AND files LIKE '%file_doc%'" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_bytes = 0;
                                //         $sql_files_arr = json_decode($rowSQL["files"],true);

                                //         foreach ($sql_files_arr as $key => $value) {
                                //             $filetype = 1;
                                //             if (!empty($value['file_type'])) { $filetype = $value['file_type']; }

                                //             if ($filetype == 1) {
                                //                 if (!empty($value['file_doc'])) {
                                //                     $sql_files = rawurlencode($value['file_doc']);
                                //                     $sql_url = $base_url.'uploads/'.$sql_files;

                                //                     $result = get_remote_file_info($sql_url);
                                //                     $bytes = $result['fileSize'];

                                //                     if ($bytes > 0) { $sql_bytes += $bytes; }
                                //                 }
                                //             }
                                //         }

                                //         mysqli_query( $conn,"UPDATE tbl_hr_trainings set filesize = $sql_bytes WHERE ID = $sql_ID" );
                                //     }
                                // }
                                
                                // Customer/Supplier Module
                                // if ($i == 10) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_supplier WHERE is_deleted = 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $bytes = 0;

                                //         if (!empty($rowSQL["audit_report"])) {
                                //             $sql_audit_report_arr = explode(' | ', $rowSQL["audit_report"]);
                                //             $sql_audit_report_files = rawurlencode($sql_audit_report_arr[0]);

                                //             $sql_audit_report_url = $base_url.'uploads/supplier/'.$sql_audit_report_files;
                                //             $sql_audit_report_result = get_remote_file_info($sql_audit_report_url);
                                //             if ($sql_audit_report_result['fileSize'] > 0) { $bytes += $sql_audit_report_result['fileSize']; }
                                //         }

                                //         if (!empty($rowSQL["audit_certificate"])) {
                                //             $sql_audit_certificate_arr = explode(' | ', $rowSQL["audit_certificate"]);
                                //             $sql_audit_certificate_files = rawurlencode($sql_audit_certificate_arr[0]);

                                //             $sql_audit_certificate_url = $base_url.'uploads/supplier/'.$sql_audit_certificate_files;
                                //             $sql_audit_certificate_result = get_remote_file_info($sql_audit_certificate_url);
                                //             if ($sql_audit_certificate_result['fileSize'] > 0) { $bytes += $sql_audit_certificate_result['fileSize']; }
                                //         }

                                //         if (!empty($rowSQL["audit_action"])) {
                                //             $sql_audit_action_arr = explode(' | ', $rowSQL["audit_action"]);
                                //             $sql_audit_action_files = rawurlencode($sql_audit_action_arr[0]);

                                //             $sql_audit_action_url = $base_url.'uploads/supplier/'.$sql_audit_action_files;
                                //             $sql_audit_action_result = get_remote_file_info($sql_audit_action_url);
                                //             if ($sql_audit_action_result['fileSize'] > 0) { $bytes += $sql_audit_action_result['fileSize']; }
                                //         }

                                //         mysqli_query( $conn,"UPDATE tbl_supplier set audit_filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 11) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_supplier_document WHERE filetype = 1 AND LENGTH(file) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["file"]);
                                //         $sql_url = $base_url.'uploads/supplier/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_supplier_document set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 12) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_supplier_material" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["spec_file"]);
                                //         $sql_url = $base_url.'uploads/supplier/'.$sql_files;

                                //         $bytes = 0;
                                //         if (!empty($sql_files)) {
                                //             $result = get_remote_file_info($sql_url);
                                //             $bytes = $result['fileSize'];
                                //         }

                                //         $sql_bytes = 0;
                                //         if (!empty($rowSQL["other"])) {
                                //             $sql_files_arr = json_decode($rowSQL["other"],true);
                                //             foreach ($sql_files_arr as $key => $value) {
                                //                 if (!empty($value['material_file_doc'])) {
                                //                     $sql_files = rawurlencode($value['material_file_doc']);
                                //                     $sql_url = $base_url.'uploads/supplier/'.$sql_files;

                                //                     $result = get_remote_file_info($sql_url);
                                //                     $bytes_other = $result['fileSize'];

                                //                     if ($bytes_other > 0) { $sql_bytes += $bytes_other; }
                                //                 }
                                //             }
                                //         }

                                //         mysqli_query( $conn,"UPDATE tbl_supplier_material set spec_filesize = $bytes, other_filesize = $sql_bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 13) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_supplier_regulatory WHERE deleted = 0 AND filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/supplier/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_supplier_regulatory set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 14) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_supplier_service" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["spec_file"]);
                                //         $sql_url = $base_url.'uploads/supplier/'.$sql_files;

                                //         $bytes = 0;
                                //         if (!empty($sql_files)) {
                                //             $result = get_remote_file_info($sql_url);
                                //             $bytes = $result['fileSize'];
                                //         }

                                //         $sql_bytes = 0;
                                //         if(!empty($rowSQL["other"])) {
                                //             $sql_files_arr = json_decode($rowSQL["other"],true);
                                //             foreach ($sql_files_arr as $key => $value) {
                                //                 if (!empty($value['service_file_doc'])) {
                                //                     $sql_files = rawurlencode($value['service_file_doc']);
                                //                     $sql_url = $base_url.'uploads/supplier/'.$sql_files;
    
                                //                     $result = get_remote_file_info($sql_url);
                                //                     $bytes_other = $result['fileSize'];
    
                                //                     if ($bytes_other > 0) { $sql_bytes += $bytes_other; }
                                //                 }
                                //             }
                                //         }

                                //         mysqli_query( $conn,"UPDATE tbl_supplier_service set spec_filesize = $bytes, other_filesize = $sql_bytes WHERE ID = $sql_ID" );
                                //     }
                                // } else if ($i == 15) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_supplier_template WHERE filetype = 1 AND LENGTH(file) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["file"]);
                                //         $sql_url = $base_url.'uploads/supplier/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         $bytes = $result['fileSize'];

                                //         mysqli_query( $conn,"UPDATE tbl_supplier_template set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }
                                
                                // Products
                                // if ($i == 16) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_products" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $bytes = 0;
                                //         $sql_ID = $rowSQL["ID"];

                                //         $sql_image_arr = explode(', ', $rowSQL["image"]);
                                //         foreach ($sql_image_arr as $value) {
                                //             if (!empty($value)) {
                                //                 $sql_files = rawurlencode($value);
                                //                 $sql_url = $base_url.'uploads/products/'.$sql_files;

                                //                 $result = get_remote_file_info($sql_url);
                                //                 if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                                
                                //             }
                                //         }

                                //         if (!empty($rowSQL["specifcation"])) {
                                //             $sql_files = rawurlencode($rowSQL["specifcation"]);
                                //             $sql_url = $base_url.'uploads/products/'.$sql_files;

                                //             $result = get_remote_file_info($sql_url);
                                //             if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                //         }

                                //         if (!empty($rowSQL["artwork"])) {
                                //             $sql_files = rawurlencode($rowSQL["artwork"]);
                                //             $sql_url = $base_url.'uploads/products/'.$sql_files;

                                //             $result = get_remote_file_info($sql_url);
                                //             if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                //         }

                                //         if (!empty($rowSQL["haccp"])) {
                                //             $sql_files = rawurlencode($rowSQL["haccp"]);
                                //             $sql_url = $base_url.'uploads/products/'.$sql_files;

                                //             $result = get_remote_file_info($sql_url);
                                //             if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                //         }

                                //         if (!empty($rowSQL["label"])) {
                                //             $sql_files = rawurlencode($rowSQL["label"]);
                                //             $sql_url = $base_url.'uploads/products/'.$sql_files;

                                //             $result = get_remote_file_info($sql_url);
                                //             if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                //         }

                                //         if (!empty($rowSQL["formulation"])) {
                                //             $sql_files = rawurlencode($rowSQL["formulation"]);
                                //             $sql_url = $base_url.'uploads/products/'.$sql_files;

                                //             $result = get_remote_file_info($sql_url);
                                //             if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                //         }

                                //         if (!empty($rowSQL["docs"])) {
                                //             $sql_files_arr = json_decode($rowSQL["docs"],true);
                                //             foreach ($sql_files_arr as $key => $value) {
                                //                 if (!empty($value['docs_file'])) {
                                //                     $sql_files = rawurlencode($value['docs_file']);
                                //                     $sql_url = $base_url.'uploads/products/'.$sql_files;

                                //                     $result = get_remote_file_info($sql_url);
                                //                     if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                //                 }
                                //             }
                                //         }

                                //         mysqli_query( $conn,"UPDATE tbl_products set files = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }

                                // Service
                                // if ($i == 17) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_service" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $bytes = 0;
                                //         $sql_ID = $rowSQL["ID"];

                                //         if (!empty($rowSQL["files"])) {
                                //             $sql_files_arr = json_decode($rowSQL["files"],true);
                                //             foreach ($sql_files_arr as $key => $value) {
                                //                 if (!empty($value['file_offering'])) {
                                //                     $sql_files = rawurlencode($value['file_offering']);
                                //                     $sql_url = $base_url.'uploads/services/'.$sql_files;

                                //                     $result = get_remote_file_info($sql_url);
                                //                     if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                //                 }
                                //             }
                                //         }

                                //         mysqli_query( $conn,"UPDATE tbl_service set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }

                                // Archive
                                // if ($i == 18) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_archiving WHERE filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $bytes = 0;
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/archiving/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }

                                //         mysqli_query( $conn,"UPDATE tbl_archiving set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }

                                // Library
                                // if ($i == 19) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_lib WHERE filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $bytes = 0;
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/lib/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }

                                //         mysqli_query( $conn,"UPDATE tbl_lib set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }

                                // RVM
                                // if ($i == 20) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_eforms WHERE filetype = 1 AND LENGTH(files) > 0" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $bytes = 0;
                                //         $sql_ID = $rowSQL["ID"];
                                //         $sql_files = rawurlencode($rowSQL["files"]);
                                //         $sql_url = $base_url.'uploads/eforms/'.$sql_files;

                                //         $result = get_remote_file_info($sql_url);
                                //         if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }

                                //         mysqli_query( $conn,"UPDATE tbl_eforms set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }

                                // FFVA
                                // if ($i == 21) {
                                //     $sql_select = mysqli_query( $conn,"SELECT * FROM tbl_ffva" );
                                //     while($rowSQL = mysqli_fetch_array($sql_select)) {
                                //         $bytes = 0;
                                //         $sql_ID = $rowSQL["ID"];

                                //         $sql_files_likelihood = explode(' | ', $rowSQL["likelihood_file"]);
                                //         foreach ($sql_files_likelihood as $value) {
                                //             if (!empty($value)) {
                                //                 $sql_files = rawurlencode($value);
                                //                 $sql_url = $base_url.'uploads/ffva/'.$sql_files;

                                //                 $result = get_remote_file_info($sql_url);
                                //                 if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                                
                                //             }
                                //         }

                                //         $likelihood_file_other = explode(' | ', $rowSQL["likelihood_file_other"]);
                                //         foreach ($likelihood_file_other as $value) {
                                //             if (!empty($value)) {
                                //                 $sql_files = rawurlencode($value);
                                //                 $sql_url = $base_url.'uploads/ffva/'.$sql_files;

                                //                 $result = get_remote_file_info($sql_url);
                                //                 if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                                
                                //             }
                                //         }

                                //         $sql_files_consequence = explode(' | ', $rowSQL["consequence_file"]);
                                //         foreach ($sql_files_consequence as $value) {
                                //             if (!empty($value)) {
                                //                 $sql_files = rawurlencode($value);
                                //                 $sql_url = $base_url.'uploads/ffva/'.$sql_files;

                                //                 $result = get_remote_file_info($sql_url);
                                //                 if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                                
                                //             }
                                //         }

                                //         $sql_files_consequence_other = explode(' | ', $rowSQL["consequence_file_other"]);
                                //         foreach ($sql_files_consequence_other as $value) {
                                //             if (!empty($value)) {
                                //                 $sql_files = rawurlencode($value);
                                //                 $sql_url = $base_url.'uploads/ffva/'.$sql_files;

                                //                 $result = get_remote_file_info($sql_url);
                                //                 if ($result['fileSize'] > 0) { $bytes += $result['fileSize']; }
                                                
                                //             }
                                //         }

                                //         mysqli_query( $conn,"UPDATE tbl_ffva set filesize = $bytes WHERE ID = $sql_ID" );
                                //     }
                                // }
                            }
                        ?>
                        <div class="col-md-3">
                            <div class="portlet light portlet-fit">
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Department / Area</th>
                                                    <th>No. of Records</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                        $result = mysqli_query( $conn,"SELECT * FROM tbl_eforms_department ORDER BY name" );
                                                        if ( mysqli_num_rows($result) > 0 ) {
                                                            while($row = mysqli_fetch_array($result)) {
                                                                $ID = $row['ID'];
                                                                $name = $row['name'];
                                                                $records = 0;

                                                                $selectEForm = mysqli_query( $conn,'SELECT * FROM tbl_eforms WHERE user_id="'.$switch_user_id.'" AND department_id="'. $ID .'"' );
                                                                if ( mysqli_num_rows($selectEForm) > 0 ) {
                                                                    while($row = mysqli_fetch_array($selectEForm)) {
                                                                        $records++;
                                                                    }
                                                                }

                                                                if ($records > 0) {
                                                                    echo '<tr id="tr_'. $ID .'" onclick="btnViewDepartment('. $ID .', '.$FreeAccess.')">
                                                                        <td>'. $name .'</td>
                                                                        <td>'. $records .'</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </tr>
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
                                    <div class="caption">
                                        <i class="icon-docs font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">Records Verification Management</span>
                                        <?php
                                            if($current_client == 0) {
                                                // $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site' AND (user_id = $switch_user_id OR user_id = $current_userEmployerID OR user_id = 163)");
                                                $result = mysqli_query($conn, "SELECT * FROM tbl_pages_demo_video WHERE page = '$site'");
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $type_id = $row["type"];
                                                    $file_title = $row["file_title"];
                                                    $video_url = $row["youtube_link"];
                                                    
                                                    $file_upload = $row["file_upload"];
                                                    if (!empty($file_upload)) {
                                        	            $fileExtension = fileExtension($file_upload);
                                        				$src = $fileExtension['src'];
                                        				$embed = $fileExtension['embed'];
                                        				$type = $fileExtension['type'];
                                        				$file_extension = $fileExtension['file_extension'];
                                        	            $url = $base_url.'uploads/instruction/';
                                        
                                                		$file_url = $src.$url.rawurlencode($file_upload).$embed;
                                                    }
                                                    
                                                    $icon = $row["icon"];
                                                    if (!empty($icon)) { echo '<img src="'.$src.$url.rawurlencode($icon).'" style="width: 32px; height: 32px; object-fit: contain; object-position: center;" />'; }
                                                    if ($type_id == 0) {
                                                        echo ' - <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'">'.$file_title.'</a>';
                                                    } else {
                                                        echo ' - <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox>'.$file_title.'</a>';
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
                                                    <a data-toggle="modal" href="<?php echo $FreeAccess == false ? '#modalNew':'#modalService'; ?>" >Add New RVM</a>
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
                                                    <th>Record Name</th>
                                                    <th>Date Uploaded</th>
                                                    <th>Verified By</th>
                                                    <th style="width: 135px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = mysqli_query( $conn,"SELECT * FROM tbl_eforms WHERE user_id=$switch_user_id ORDER BY files_date DESC" );
                                                    if ( mysqli_num_rows($result) > 0 ) {
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $ID = $row['ID'];
                                                            $record = $row['record'];
                                                            $files_date = $row['files_date'];
                                                            $verified_by = $row['verified_by'];

                                                            echo '<tr id="tr_'. $ID .'">
                                                                <td>'. $record .'</td>
                                                                <td>'. $files_date .'</td>
                                                                <td>'. $verified_by .'</td>
                                                                <td class="text-center">';

                                                                    if ($FreeAccess == false) {
                                                                        echo '<div class="btn-group btn-group-circle">
                                                                            <a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('. $ID.')">Edit</a>
                                                                            <a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('. $ID .', '.$FreeAccess.')">View</a>
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
                                            <h4 class="modal-title">Records Verification Management</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Department / Area</label>
                                                        <select class="form-control select2" name="department_id" onchange="changeDepartment(this, 1)" style="width: 100%;" required>
                                                            <option value="">Select</option>
                                                            <?php
                                                                $result = mysqli_query($conn,"SELECT * FROM tbl_eforms_department WHERE user_id = $switch_user_id ORDER BY name");
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    $ID = $row['ID'];
                                                                    $name = $row['name'];
                                                                    echo '<option value="'. $ID .'">'. $name .'</option>';
                                                                }
                                                            ?>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <input type="text" class="form-control margin-top-15 display-none" name="department_id_other" id="department_id_other_1" placeholder="Specify others" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Record Name</label>
                                                        <input type="type" class="form-control" name="record" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Assigned To</label>
                                                        <select class="form-control mt-multiselect btn btn-default" name="assigned_to_id[]" multiple="multiple" required>
                                                            <?php
                                                                $selectEmployee = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE status = 1 AND user_id=$switch_user_id" );
                                                                if ( mysqli_num_rows($selectEmployee) > 0 ) {
                                                                    while($rowEmployee = mysqli_fetch_array($selectEmployee)) {
                                                                        $rowEmployeeID = $rowEmployee["ID"];
                                                                        $rowEmployeeFName = $rowEmployee["first_name"];
                                                                        $rowEmployeeLName = $rowEmployee["last_name"];

                                                                        echo '<option value="'. $rowEmployeeID .'">'. $rowEmployeeFName .' '. $rowEmployeeLName .'</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option disabled>No Available</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <textarea class="form-control" name="description" required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4" id="filled_1">
                                                    <div class="form-group">
                                                        <label>Properly Filled Out ?</label>
                                                        <div class="mt-radio-line">
                                                            <label class="mt-radio mt-radio-outline"> Yes
                                                                <input type="radio" value="1" name="filled_out" onchange="radioFilled(this, 1)">
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio mt-radio-outline"> No
                                                                <input type="radio" value="0" name="filled_out" onchange="radioFilled(this, 1)" checked>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <input type="text" class="form-control" name="filled_out_reason" id="filled_out_reason_1" placeholder="Enter your reason here" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="signed_1">
                                                    <div class="form-group">
                                                        <label>Properly Signed or Initialed ?</label>
                                                        <div class="mt-radio-line">
                                                            <label class="mt-radio mt-radio-outline"> Yes
                                                                <input type="radio" value="1" name="signed" onchange="radioSigned(this, 1)">
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio mt-radio-outline"> No
                                                                <input type="radio" value="0" name="signed" onchange="radioSigned(this, 1)" checked>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <input type="text" class="form-control" name="signed_reason" id="signed_reason_1" placeholder="Enter your reason here" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="compliance_1">
                                                    <div class="form-group">
                                                        <label>Is Compliant ?</label>
                                                        <div class="mt-radio-line">
                                                            <label class="mt-radio mt-radio-outline"> Yes
                                                                <input type="radio" value="1" name="compliance" onchange="radioCompliance(this, 1)" disabled>
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio mt-radio-outline"> No
                                                                <input type="radio" value="0" name="compliance" onchange="radioCompliance(this, 1)" checked>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <input type="text" class="form-control" name="compliance_reason" id="compliance_reason_1" placeholder="Enter your reason here" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Frequency of Collection</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio mt-radio-outline"> Daily
                                                                        <input type="radio" value="0" name="frequency" checked />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Weekly
                                                                        <input type="radio" value="1" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Monthly
                                                                        <input type="radio" value="2" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio mt-radio-outline"> Quarterly
                                                                        <input type="radio" value="3" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Biannual
                                                                        <input type="radio" value="4" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio mt-radio-outline"> Annually
                                                                        <input type="radio" value="5" name="frequency" />
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label>Others</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <input type="radio" value="6" name="frequency" />
                                                                <span></span>
                                                            </span>
                                                            <input class="form-control "type="text" name="frequency_other" placeholder="Please specify" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="control-label">Upload Document</label>
                                                        <select class="form-control" name="filetype" onchange="changeType(this)" required>
                                                            <option value="0">Select option</option>
                                                            <option value="1">Manual Upload</option>
                                                            <option value="2">Youtube URL</option>
                                                            <option value="3">Google Drive URL</option>
                                                        </select>
                                                        <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                                                        <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="ccontrol-label">Document Date</label>
                                                        <input class="form-control" type="date" name="file_date" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Verified By</label>
                                                        <input class="form-control" type="text" name="verified" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Comment/Notes</label>
                                                <textarea class="form-control" name="notes" placeholder="Write some comment or notes here" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnSave_Eforms" id="btnSave_Eforms" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
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
                                            <h4 class="modal-title">Records Verification Management</h4>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn green ladda-button" name="btnUpdate_EForms" id="btnUpdate_EForms" data-style="zoom-out"><span class="ladda-label">Save</span></button>
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
                                        <h4 class="modal-title">Records Verification Management</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                file
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-bordered table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <td>Record Name</td>
                                                            <td><strong>q</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Description</td>
                                                            <td><strong>w</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Filled Out</td>
                                                            <td><strong>e</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Signed</td>
                                                            <td><strong>r</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Frequency of Collection</td>
                                                            <td><strong>t</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Compliance</td>
                                                            <td><strong>y</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Date Uploaded</td>
                                                            <td><strong>u</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Verified By</td>
                                                            <td><strong>i</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Notes</td>
                                                            <td><strong>o</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- / END MODAL AREA -->
                        
                        <!--Emjay modal-->
                        
                        <div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data" action="controller.php">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Upload Demo Video</h4>
                                        </div>
                                        <div class="modal-body">
                                                <label>Video Title</label>
                                                <input type="text" id="file_title" name="file_title" class="form-control mt-2">
                                                <?php if($switch_user_id != ''): ?>
                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $switch_user_id ?>">
                                                <?php else: ?>
                                                    <input type="hidden" id="switch_user_id" name="switch_user_id" value="<?= $current_userEmployerID ?>">
                                                <?php endif; ?>
                                                <label style="margin-top:15px">Video Link</label>
                                                <!--<input type="file" id="file" name="file" class="form-control mt-2">-->
                                                <input type="text" class="form-control" name="youtube_link">
                                                <input type="hidden" name="page" value="<?= $site ?>">

                                                <!--<label style="margin-top:15px">Privacy</label>-->
                                                <!--<select class="form-control" name="privacy" id="privacy" required>-->
                                                <!--    <option value="Private">Private</option>-->
                                                <!--    <option value="Public">Public</option>-->
                                                <!--</select>-->
                                            
                                            <div style="margin-top:15px" id="message">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                                            <button type="submit" class="btn btn-success" name="save_video"><span id="save_video_text">Save</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                // Emjay script starts here
                fancyBoxes();
                $('#save_video').click(function(){
                $('#save_video').attr('disabled','disabled');
                $('#save_video_text').text("Uploading...");
                var action_data = "supplier";
                var user_id = $('#switch_user_id').val();
                var privacy = $('#privacy').val();
                var file_title = $('#file_title').val();
                
                 var fd = new FormData();
                 var files = $('#file')[0].files;
                 fd.append('file',files[0]);
                 fd.append('action_data',action_data);
                 fd.append('user_id',user_id);
                 fd.append('privacy',privacy);
                 fd.append('file_title',file_title);
    			    $.ajax({
        				method:"POST",
        				url:"controller.php",
        				data:fd,
        				processData: false, 
                        contentType: false,  
                        timeout: 6000000,
        				success:function(data){
        					console.log('done : ' + data);
        					if(data == 1){
        					    window.location.reload();
        					}
        					else{
        					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
        					}
        				}
    				});
    			});
    			
                // Emjay script ends here
                
                $.fn.modal.Constructor.prototype.enforceFocus = function() {};

                $('.select2').select2();
                $('#tableData').DataTable();

                fancyBoxes();
            });

            function uploadNew(e) {
                $(e).parent().hide();
                $(e).parent().parent().find('select').removeClass('hide');
            }
            function changeType(e) {
                $(e).parent().find('input').hide();
                $(e).parent().find('input').prop('required',false);
                if($(e).val() == 1) {
                    $(e).parent().find('.fileUpload').show();
                    $(e).parent().find('.fileUpload').prop('required',true);
                } else if($(e).val() == 2 || $(e).val() == 3) {
                    $(e).parent().find('.fileURL').show();
                    $(e).parent().find('.fileURL').prop('required',true);
                }
            }

            function btnEdit(id) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalView_Eforms="+id,
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
                    url: "function.php?modalViewFile_Eforms="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $("#modalViewFile .modal-body").html(data);
                    }
                });
            }
            function btnViewDepartment(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartment_Eforms="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').removeClass('hide');
                        $("#tableData tbody").html(data);
                    }
                });
            }
            function btnViewDepartmentViewAll(id, freeaccess) {
                $.ajax({
                    type: "GET",
                    url: "function.php?modalViewDepartmentViewAll_Eforms="+id+"&freeaccess="+freeaccess,
                    dataType: "html",
                    success: function(data){
                        $('#tableDataViewAll').addClass('hide');
                        $("#tableData tbody").html(data);
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
            function radioFilled(id, modal) {
                $('#compliance_'+modal+' input:radio[value="'+id.value+'"]').prop('checked',true);
                $('#compliance_'+modal+' input:radio').prop('disabled',false);
                $('#compliance_reason_'+modal).addClass('hide');
                if (id.value == 0) {
                    $('#filled_out_reason_'+modal).removeClass('hide');

                    $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                    $('#compliance_reason_'+modal).removeClass('hide');
                } else {
                    $('#filled_out_reason_'+modal).addClass('hide');

                    var signed = $('#signed_'+modal+' input[type="radio"]:checked').val();
                    if (signed == 0) {
                        $('#compliance_'+modal+' input:radio[value="0"]').prop('checked',true);
                        $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                        $('#compliance_reason_'+modal).removeClass('hide');
                    }
                }
            }
            function radioSigned(id, modal) {
                $('#compliance_'+modal+' input:radio[value="'+id.value+'"]').prop('checked',true);
                $('#compliance_'+modal+' input:radio').prop('disabled',false);
                $('#compliance_reason_'+modal).addClass('hide');
                if (id.value == 0) {
                    $('#signed_reason_'+modal).removeClass('hide');

                    $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                    $('#compliance_reason_'+modal).removeClass('hide');
                } else {
                    $('#signed_reason_'+modal).addClass('hide');

                    var filled = $('#filled_'+modal+' input[type="radio"]:checked').val();
                    if (filled == 0) {
                        $('#compliance_'+modal+' input:radio[value="0"]').prop('checked',true);
                        $('#compliance_'+modal+' input:radio[value="1"]').prop('disabled',true);
                        $('#compliance_reason_'+modal).removeClass('hide');
                    }
                }
            }
            function radioCompliance(id, modal) {
                if (id.value == 0) {
                    $('#compliance_reason_'+modal).removeClass('hide');
                } else {
                    $('#compliance_reason_'+modal).addClass('hide');
                }
            }

            $(".modalNew").on('submit',(function(e) {
                e.preventDefault();

                formObj = $(this);
                if (!formObj.validate().form()) return false;

                var formData = new FormData(this);
                formData.append('btnSave_Eforms',true);

                var l = Ladda.create(document.querySelector('#btnSave_Eforms'));
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
                                result += '<td>'+obj.files_date+'</td>';
                                result += '<td>'+obj.verified+'</td>';
                                result += '<td class="text-center">';
                                    result += '<div class="btn-group btn-group-circle">';
                                        result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                        result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
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
                formData.append('btnUpdate_EForms',true);

                var l = Ladda.create(document.querySelector('#btnUpdate_EForms'));
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
                            result += '<td>'+obj.files_date+'</td>';
                            result += '<td>'+obj.verified+'</td>';
                            result += '<td class="text-center">';
                                result += '<div class="btn-group btn-group-circle">';
                                    result += '<a href="#modalView" class="btn btn-outline dark btn-sm btnEdit" data-toggle="modal" onclick="btnEdit('+obj.ID+')">Edit</a>';
                                    result += '<a href="#modalViewFile" class="btn btn-success btn-sm btnView" data-toggle="modal" onclick="btnView('+obj.ID+')">View</a>';
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