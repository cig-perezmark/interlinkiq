<?php 
    $title = "Compliance Dashboard";
    $site = "dashboard";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs.'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
                <script src="https://cdn.amcharts.com/lib/5/plugins/legend.js"></script>
                
                <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
                <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
                <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>


                    <?php
                        function dashboardChild($parent_id, $user_id, $dashboard_result) {
                    		global $conn;
                    		
                            $selectDashboard = mysqli_query($conn, "SELECT 
                            *
                            FROM (
                                SELECT
                                t1.ID AS mainID,
                                t1.parent_id AS parentID,
                                t1.collaborator_id AS parentCollab,
                                t1.name AS parentName,
                                COUNT(t2.ID) AS childRow,
                                COALESCE(c.count_ID, 0) AS complyRow,
                                COALESCE(c.sum_compliant, 0) as complySum,
                                COALESCE(c.percent_compliant, 0) as complyPercentage,
                                COALESCE(f.count_ID, 0) AS fileRow,
                                COALESCE(f.expired_files, 0) AS fileExpire,
                                COALESCE(f.expired_files30, 0) AS fileExpire30,
                                COALESCE(f.expired_files90, 0) AS fileExpire90
                                FROM tbl_library AS t1 
                                
                                LEFT JOIN (
                                    SELECT * FROM tbl_library WHERE deleted = 0 AND parent_id <> 0
                                ) AS t2 
                                ON t1.ID = t2.parent_id
                                
                                LEFT JOIN (
                                    SELECT
                                    ID,
                                    library_id,
                                    action_items,
                                    COUNT(ID) AS count_ID, 
                                    SUM(compliant) as sum_compliant,
                                    CASE WHEN COUNT(ID) = SUM(compliant = 1) THEN 100 ELSE 0 END AS percent_compliant 
                                    FROM tbl_library_compliance 
                                    WHERE deleted = 0
                                    AND parent_id = 0
                                    GROUP BY library_id
                                ) AS c 
                                ON t1.ID = c.library_id
                                
                                LEFT JOIN (
                                    SELECT
                                    ID,
                                    library_id,
                                    COUNT(ID) AS count_ID,
                                    COUNT(CASE WHEN due_date < CURDATE() THEN 1 END) AS expired_files,
                                    CASE WHEN DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 0 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) <= 30 THEN 1 ELSE 0 END AS expired_files30,
                                    CASE WHEN DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 30 DAY)) >= 60 AND DATEDIFF(CURDATE(), DATE_SUB(due_date, INTERVAL 90 DAY)) <= 30 THEN 1 ELSE 0 END AS expired_files90
                                    FROM tbl_library_file
                                    WHERE deleted = 0
                                    GROUP BY library_id
                                ) AS f
                                ON t1.ID = f.library_id
                                
                                WHERE t1.deleted = 0
                                AND t1.parent_id = $parent_id
                                AND t1.user_id = $user_id
                                GROUP BY t1.ID
                            ) AS r");
                            if ( mysqli_num_rows($selectDashboard) > 0 ) {
                                while($rowDashboard = mysqli_fetch_array($selectDashboard)) {
                                    $dashboard_ID = $rowDashboard["mainID"];
                                    $dashboard_complyPercentage = $rowDashboard["complyPercentage"];
                                    $dashboard_fileRow = $rowDashboard["fileRow"];
                                    $dashboard_fileExpire = $rowDashboard["fileExpire"];
                                    $dashboard_fileExpire30 = $rowDashboard["fileExpire30"];
                                    $dashboard_fileExpire90 = $rowDashboard["fileExpire90"];

                                    $data_output = array (
                                        'compliance' => $dashboard_complyPercentage,
                                        'file_count' => $dashboard_fileRow,
                                        'file_expired' => $dashboard_fileExpire,
                                        'file_expired30' => $dashboard_fileExpire30,
                                        'file_expired90' => $dashboard_fileExpire90
                                    );
                                    array_push($dashboard_result, $data_output);

                                    $dashboard_result = dashboardChild($dashboard_ID, $user_id, $dashboard_result);
                                }
                            }

                            return $dashboard_result;
                        }
                        $newUser = 1;
                        $collabUser = 0;
                        if (!empty($_COOKIE['switchAccount'])) {
                            $selectDashboard = mysqli_query( $conn,"SELECT * from tbl_library WHERE deleted = 0 AND user_id = $switch_user_id" );
                            if ( mysqli_num_rows($selectDashboard) > 0 ) {
                                $newUser = 0;
                            }
                        } else {
                            if (!empty($current_userEmployeeID) OR $current_userEmployeeID > 0) {
                                $newUser = 0;

                                if ($current_userAdminAccess == 0) {
                                    
                                    $selectUserFacility = mysqli_query( $conn,"
                                        SELECT
                                        CASE WHEN r.employee_id > 0 THEN r.e_facility_switch ELSE 0 END AS facility_switch_user
                                        FROM (
                                            SELECT
                                            u.ID,
                                            u.employee_id,
                                            u.first_name,
                                            u.facility_switch AS u_facility_switch,
                                            e.facility_switch AS e_facility_switch
                                            FROM tbl_user AS u

                                            LEFT JOIN (
                                                SELECT
                                                *
                                                FROM tbl_hr_employee
                                            ) AS e
                                            ON e.ID = u.employee_id

                                            WHERE u.ID = $current_userID
                                        ) r
                                    " );
                                    if ( mysqli_num_rows($selectUserFacility) > 0 ) {
                                        $rowUserFacility = mysqli_fetch_array($selectUserFacility);
                                        $facility_switch_user = $rowUserFacility["facility_switch_user"];

                                        if ($facility_switch_user == $facility_switch_user_id) {
                                            $collabUser = 1;
                                        }
                                    }
                                }
                            } else {
                                $selectDashboard = mysqli_query( $conn,"SELECT * from tbl_library WHERE deleted = 0 AND user_id = $switch_user_id" );
                                if ( mysqli_num_rows($selectDashboard) > 0 ) {
                                    $newUser = 0;
                                }
                            }
                        }
                        
                        if($switch_user_id == 253 AND $switch_user_id == 1) { $newUser = 1; }
                        // if($switch_user_id == 423) { $newUser = 0; }
                        $newUser = 0;
                    ?>

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
                                if (!empty($icon)) { 
                                    if ($type_id == 0) {
                                        echo ' <a href="'.$src.$url.rawurlencode($file_upload).$embed.'" data-src="'.$src.$url.rawurlencode($file_upload).$embed.'" data-fancybox data-type="'.$type.'"><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                    } else {
                                        echo ' <a href="'.$video_url.'" data-src="'.$video_url.'" data-fancybox><img src="'.$src.$url.rawurlencode($icon).'" style="width: 60px; height: 60px; object-fit: contain; object-position: center;" /></a>';
                                    }
                                }
                            }
                            
                            if($current_userEmployerID == 185 OR $current_userEmployerID == 1  OR $current_userEmployerID == 163) {
                                echo ' <a data-toggle="modal" data-target="#modalInstruction" class="btn btn-circle btn-success btn-xs" onclick="btnInstruction()">Add New Instruction</a>';
                            }
                        }
                    ?>
                    
                    <!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>

        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/jquery.table2excel.js" type="text/javascript"></script>

        <script src="assets/jSignature/jSignature.min.js"></script>

        
        <?php if($switch_user_id == 464 OR $switch_user_id == 1457 OR $switch_user_id == 1649 OR $switch_user_id == 1795 OR $switch_user_id == 1820 OR $switch_user_id == 459 OR $switch_user_id == 522 OR $switch_user_id == 463) { ?>
            <script src='AnalyticsIQ/compliance_chart.js?i=<?php echo $switch_user_id; ?>'></script>
        <?php } ?>


        <script>
            $("#btnExport").click(function(){
                $("#table2excel").table2excel({
                    exclude:".noExl",           // exclude CSS class
                    name:"Worksheet Name",
                    filename:"Download",        //do not include extension
                    fileext:".xlsx",             // file extension
                    exclude_img:true,
                    exclude_links:true,
                    exclude_inputs:true
                });
            });
        </script>
        <!--Emjay codes start here-->
        <script>
            $(document).ready(function(){
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
        					// console.log('done : ' + data);
        					if(data == 1){
        					    window.location.reload();
        					}
        					else{
        					    $('#message').html('<span class="text-danger">Invalid Video Format</span>');
        					}
        				}
    				});
    			});
            });
        </script>
        <!--Emjay codes ends here-->
        <script type="text/javascript">
            $(document).ready(function(){
                var collabUser = '<?php echo $collabUser; ?>';
                widget_summernote();
                widget_tagInput();
                
                $.ajax({
                    async: true,
                    type: 'GET',
                    url: 'function.php?jstree_HTML2='+collabUser,
                    dataType: 'json',
                    success: function (json) {
                        if ($.trim(json)) {
                            const data = json;
    
                            // Create a map of id to its children
                            const childrenMap = data.reduce((acc, item) => {
                              if (!acc[item.parent]) {
                                acc[item.parent] = [];
                              }
                              acc[item.parent].push(item);
                              return acc;
                            }, {});
    
                            // Set of valid ids (including root #)
                            const validIds = new Set(['#']);
    
                            // Function to collect valid ids recursively
                            function collectValidIds(id) {
                              if (childrenMap[id]) {
                                childrenMap[id].forEach(child => {
                                  validIds.add(child.id);
                                  collectValidIds(child.id);
                                });
                              }
                            }
    
                            // Start with the root parents (those whose parent is '#')
                            collectValidIds('#');
    
                            // Filter the data to keep only valid items
                            const filteredData = data.filter(item => validIds.has(item.id));
                            
                            // Sorting Alphanumeric
                            if (switch_user_id != 1649 && switch_user_id != 1795 && switch_user_id != 1820) {
                                filteredData.sort((a, b) => a.text.localeCompare(b.text));
                                filteredData.sort((a, b) => a.text.localeCompare(b.text, 'en', { numeric: true }));
                            }
                            console.log("filteredData");
                            console.log(filteredData);

                            // Step 1: Create facility nodes for top-level items
                            const facilityGroups = {};
                            const transformed = [];

                            filteredData.forEach(item => {
                              if (item.parent === "#") {
                                const fid = item.facility;
                                const fidName = item.facility_name;
                                const facilityId = `facility_${fid}`;
                                
                                if (!facilityGroups[fid]) {
                                  facilityGroups[fid] = {
                                    id: facilityId,
                                    parent: "#",
                                    text: fidName,
                                    state: { opened: true }
                                  };
                                  transformed.push(facilityGroups[fid]);
                                }

                                transformed.push({ ...item, parent: facilityId });
                              } else {
                                transformed.push(item); // keep nested items untouched
                              }
                            });

                            jstree_data = transformed;
                            console.log("transformed");
                            console.log(transformed);

                            const filteredItems = filteredData.filter(item => item.facility === facility_switch_user_id);
    
                            removeInapplicable = removeInapplicable(filteredItems);
                            console.log("removeInapplicable");
                            console.log(removeInapplicable);
    
                            calculateCMMC = calculateCMMC(removeInapplicable);
                            console.log("calculateCMMC.data");
                            console.log(calculateCMMC.data);
                            
                            // Step 1: Find all top-level parents (parent === "#")
                            const topLevelItems2 = calculateCMMC.data.filter(item => item.parent === "#");
    
                            // Step 2: Count applicable statuses for each top-level item
                            const results2 = topLevelItems2.map(parentItem => {
                                let notApplicable = 0;
                                let notMet = 0;
                                let met = 0;
    
                                // Find all descendants (recursively)
                                const findDescendants = (id) => {
                                    const children = data.filter(item => item.parent === id);
                                    let all = [...children];
                                    for (let child of children) {
                                        all = all.concat(findDescendants(child.id));
                                    }
                                    return all;
                                };
    
                                const descendants = findDescendants(parentItem.id);
    
                                // Include the parent item itself in the evaluation
                                const allRelevant = [parentItem, ...descendants];
    
                                allRelevant.forEach(item => {
                                    if (item.applicable === "0") {
                                        notApplicable++;
                                    } else if ((item.applicable === "1"  || item.applicable === "2") && item.cmmc === "0") {
                                        notMet++;
                                    } else {
                                        met++;
                                    }
                                });
                                
                                cmmcTitle = parentItem.text;
                                cmmcNA = 'Total Not Applicable';
                                cmmcNM = 'Total Non Compliance';
                                cmmcMet = 'Total Compliance';
                                if (switch_user_id == 1649 || switch_user_id == 1795 || switch_user_id == 1820) {
                                    cmmcTitle = parentItem.cmmc_code;
                                    cmmcNA = 'Total Not Applicable';
                                    cmmcNM = 'Total Not Met';
                                    cmmcMet = 'Total Met';
                                }
                                
                                return {
                                    text: cmmcTitle,
                                    percent: allRelevant.length,
                                    point: parseInt(parentItem.cmmc_point),
                                    subData: [
                                        {
                                            name: cmmcNA,
                                            value: notApplicable
                                        },
                                        {
                                            name: cmmcNM,
                                            value: notMet
                                        },
                                        {
                                            name: cmmcMet,
                                            value: met
                                        }
                                    ]
                                };
                            });
                            // cmmcAnalytics = JSON.stringify(summary, null, 2);
                            // console.log(JSON.stringify(results2, null, 2));
                            // if (switch_user_ids != 163 && switch_user_ids != 1649 && switch_user_ids != 1795) {
                            //     cmmcPie(results2);
                            //     cmmcPie2(results2, calculateCMMC.total_cmmc);
                            //     console.log(JSON.stringify(results2, null, 2));
                            // }
                            
                            if (!((switch_user_ids === 163 && switch_user_ids === 1795) || (facility_switch_user_id === 0 && switch_user_ids === 1649))) {
                                cmmcPie(results2);
                                cmmcPie2(results2, calculateCMMC.total_cmmc);
                                console.log(JSON.stringify(results2, null, 2));
                            }
                            
                            
                            if (switch_user_ids == 1649 || switch_user_ids == 1795 || switch_user_ids == 1820 || switch_user_ids == 464 || switch_user_ids == 459 || switch_user_ids == 522 || switch_user_ids == 463) {
                                gaugeCount(results2, calculateCMMC.total_cmmc);
                                cmmcPoints = calculateCMMC.data;
                                cmmcMet = calculateCMMC.data;
                            }
                            
                            createJSTree(filteredItems);
                        }
                    },

                    error: function (xhr, ajaxOptions, thrownError) {
                        // alert(xhr.status);
                        // alert(thrownError);
                    }
                });

                function calculateCMMC(data) {
                    // Helper to build tree structure
                    const buildChildrenMap = (data) => {
                      const map = {};
                      for (const node of data) {
                        if (!map[node.parent]) {
                          map[node.parent] = [];
                        }
                        map[node.parent].push(node);
                      }
                      return map;
                    };

                    const childrenMap2 = buildChildrenMap(data);

                    const hasAnyCmmc0 = (node, map) => {
                      if (node.cmmc === "0") return true;
                      const children = map[node.id] || [];
                      return children.some(child => hasAnyCmmc0(child, map));
                    };


                
                    for (const node of data) {
                      if (node.parent === '#') {
                        const secondLevelChildren = data.filter(d => d.parent === node.id);
                        
                        if (secondLevelChildren.length === 0) {
                          // No children
                          if (node.cmmc === "0") {
                            node.cmmc_point = String(-Math.abs(Number(node.cmmc_point)));
                          }
                          // cmmc === "1" -> do nothing
                        } else {
                          const total = secondLevelChildren.length;
                          const negativeSum = secondLevelChildren.reduce((sum, child) => {
                            const val = Number(child.cmmc_point);
                            return val < 0 ? sum + Math.abs(val) : sum;
                          }, 0);
                          node.cmmc_point = String(total - negativeSum);
                        }
                      }
                    }

                    // Apply cmmc_met to all nodes based on full subtree (including self)
                    for (const node of data) {
                      node.cmmc_met = hasAnyCmmc0(node, childrenMap2) ? "0" : "1";
                    }

                    const totalCMMC = 110 - data.filter(d => d.parent === '#' && Number(d.cmmc_point) < 0).reduce((sum, d) => sum + Math.abs(Number(d.cmmc_point)), 0);

                    let result = {
                        data: data,
                        total_cmmc: totalCMMC
                    }
                    return result;
                }
                function createJSTree(jsondata) {            
                    $('#jstreeAjax').jstree({
                        'core': {
                            'data': jsondata
                        },
                        types:{
                            "default":{
                                icon:"fa fa-folder icon-state-warning"
                            },
                            file:{
                                icon:"fa fa-file icon-state-danger"
                            }
                        },
                        height: "200px",
                        search: {
                            case_insensitive: false,
                            show_only_matches : true,
                            show_only_matches_children : true
                        },
                        plugins : ["types", "search" ]
                    });
                    
                    
                    // Search functionality
                    $('#deliverable_search').on("keyup", function() {
                        var searchText = $(this).val();
                        $('#jstreeAjax').jstree(true).search(searchText);
                    });
                }
            });
        </script>
    </body>
</html>
