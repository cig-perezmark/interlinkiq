<?php 

include_once __DIR__ .'/database_iiq.php';
include_once __DIR__ . '/alt-setup/setup.php';

error_reporting(E_ALL);

default_timezone();
$local_date = date('Y-m-d');
$saveNewItem = 1;
$base_url = "https://interlinkiq.com/";

function fileExtension($file) {
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $src = 'https://view.officeapps.live.com/op/embed.aspx?src=';
    $embed = '&embedded=true';
    $type = 'iframe';
	if (strtolower($extension) == "pdf") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-pdf-o"; }
	else if (strtolower($extension) == "doc" OR strtolower($extension) == "docx") { $file_extension = "fa-file-word-o"; }
	else if (strtolower($extension) == "ppt" OR strtolower($extension) == "pptx") { $file_extension = "fa-file-powerpoint-o"; }
	else if (strtolower($extension) == "xls" OR strtolower($extension) == "xlsb" OR strtolower($extension) == "xlsm" OR strtolower($extension) == "xlsx" OR strtolower($extension) == "csv" OR strtolower($extension) == "xlsx") { $file_extension = "fa-file-excel-o"; }
	else if (strtolower($extension) == "gif" OR strtolower($extension) == "jpg"  OR strtolower($extension) == "jpeg" OR strtolower($extension) == "png" OR strtolower($extension) == "ico") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-image-o"; }
	else if (strtolower($extension) == "mp4" OR strtolower($extension) == "mov"  OR strtolower($extension) == "wmv" OR strtolower($extension) == "flv" OR strtolower($extension) == "avi" OR strtolower($extension) == "avchd" OR strtolower($extension) == "webm" OR strtolower($extension) == "mkv") { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-video-o"; }
	else { $src = ''; $embed = ''; $type = ''; $file_extension = "fa-file-code-o"; }

	$output['src'] = $src;
    $output['embed'] = $embed;
    $output['type'] = $type;
    $output['file_extension'] = $file_extension;
    $output['file_mime'] = $extension;
    return $output;
}

try {
    $result = null;
    $conn->begin_transaction();
    
    // saving new record
    if(isset($_POST['save_new_coa']) &&  $_POST['save_new_coa'] == true) {
        $arr_item = array();
        
        if($_POST['category'] == 'others') {
            if(!empty($_POST['other_category'])) {
                $conn->execute("INSERT INTO tbl_coa_categories (user_id,name,in_dropdown) VALUE(?,?,?)", $user_id, esc($_POST['other_category']), $saveNewItem);
                $_POST['category'] = $conn->lastInsertID();
            } else {
                $_POST['category'] = null;
            }
        }
        
        if($_POST['analysis_type'] == 'others') {
            if(!empty($_POST['other_analysis_type'])) {
                $conn->execute("INSERT INTO tbl_coa_analysis_types (user_id,name,in_dropdown) VALUE(?,?,?)", $user_id, esc($_POST['other_analysis_type']), $saveNewItem);
                $_POST['analysis_type'] = $conn->lastInsertID();
            } else {
                $_POST['analysis_type'] = null;
            }
        }
    
        $filename = null;
    	$filetype = $_POST['filetype'];
        if ($filetype == 1) {
            $files = $_FILES['file']['name'];
            if (!empty($files)) {
                $path = 'uploads/eforms/';
                $filesize = $_FILES['file']['size'];
                $tmp = $_FILES['file']['tmp_name'];
                // renamed the files but keeping its original file extension
                $randomPrefix = rand(1000,1000000);
                $filename = $randomPrefix .' - ' . uniqid() . '.'. pathinfo($files, PATHINFO_EXTENSION);
                $path = $path . $filename;
                move_uploaded_file($tmp,$path);
            }
        } else {
            $files = $_POST['fileurl'];
            $filesize = 0;
        }
    
        $output = array (
            'type'  =>  $filetype,
            'name' =>  $files,
            'size' =>  $filesize,
            'date' =>  $local_date
        );
        array_push($arr_item, $output);
        $file_history = json_encode($arr_item, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);
    
    // 	$assigned_to_id = '';
    // 	if (!empty($_POST['assigned_to_id'])) {
    // 		$assigned_to_id = implode(", ",$_POST['assigned_to_id']);
    // 	}
    	
    	$sql = 'INSERT INTO `tbl_coa`(`user_id`, `portal_user`, `product_name`, `category`, `analysis_type`, `laboratory_type`, `files`, `filetype`, `filesize`, `file_history`, `files_date`, `frequency`, `frequency_other`, `received_by`, `notes`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    	$conn->execute($sql, array(
    	    $user_id,
    	    $portal_user,
    	    esc($_POST['product']),
    	    $_POST['category'],
    	    $_POST['analysis_type'],
    	    $_POST['laboratory_type'],
    	    $filename ?? $files,
    	    $filetype,
    	    $filesize, 
    	    $file_history,
    	    $_POST['file_date'],
            $_POST['frequency'],
            esc($_POST['frequency_other']),
            esc($_POST['received']),
            esc($_POST['notes']),
        ));
    
    	$last_id = $conn->lastInsertID();
    	$selectData = $conn->execute("SELECT * FROM tbl_coa WHERE id = ?", $last_id)->fetchAssoc();
    	if (count($selectData) > 0 ) {
    		$data_ID = $selectData['ID'];
    		$data_record = $selectData['product'];
    		$data_files_date = $selectData['files_date'];
    		$data_verified = $selectData['verified_by'];
    
    		$result = array(
    		    'data' => array(
        			"ID" => $data_ID,
        			"record" => $data_record,
        			"files_date" => $data_files_date,
        // 			"verified" => $data_verified
        		)    
    		);
    	}
    }
    
    // view/form record
    if(isset($_GET['view_coa']) && $_GET['view_coa'] == true) {
        $id = $_GET['view_coa'];
        
        $categories = $conn->execute("SELECT * FROM tbl_coa_categories WHERE in_dropdown = 1 AND deleted_at IS NULL")->fetchAll();
        $analysisTypes = $conn->execute("SELECT * FROM tbl_coa_analysis_types WHERE in_dropdown = 1 AND deleted_at IS NULL")->fetchAll();
        
        $data = $conn->execute("SELECT *,
            (SELECT name FROM tbl_coa_categories WHERE id = c.category) as category_name,
            (SELECT name FROM tbl_coa_analysis_types WHERE id = c.analysis_type) as analysis_type_name 
            FROM tbl_coa c WHERE id = ?", $id)->fetchAssoc();
        
        if(count($data)) {
            $filetype = $data['filetype'];
			$data_files = $data['files'];
			if (!empty($data_files)) {
			    if ($filetype == 1) {
				    $fileExtension = fileExtension($data_files);
					$src = $fileExtension['src'];
					$embed = $fileExtension['embed'];
					$type = $fileExtension['type'];
					$file_extension = $fileExtension['file_extension'];
				    $url = $base_url.'uploads/eforms/';

				    $data_files = $src.$url.rawurlencode($data_files).$embed;
				} else if ($filetype == 3) {
					$data_files = preg_replace('#[^/]*$#', '', $data_files).'preview';
				}
			}
?>
            <input type="hidden" name="id" value="<?= $data['id'] ?>" />
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Product/Item Name</label>
                        <input type="type" class="form-control" name="product" placeholder="Enter product/item name" value="<?= $data['product_name'] ?>" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Category</label>
                        <select class="form-control" name="category" onchange="catOnChange(this)" required>
                            <option value="" disabled>Select category</option>
                            <?php 
                                $isPreset = false;
                                foreach($categories ?? [] as $c) {
                                    $selected = '';
                                    if($data['category'] == $c['id']) {
                                        $selected = 'selected';
                                        $isPreset = true;
                                    }
                                    echo '<option value="'.$c['id'].'" '.$selected.' '. (empty($c['name']) ? 'disabled' : '' ) .'>'.(empty($c['name']) ? '(empty)' : $c['name']).'</option>'; 
                                }
                            ?>
                            <option value="others" <?= empty($isPreset) ? 'selected' : '' ?>>Others</option>
                        </select>
                        <input type="text" name="other_category" class="form-control margin-top-15 <?= !empty($isPreset) ? 'hide' : '' ?>" value="<?= empty($isPreset) ? $data['category_name'] : '' ?>"  placeholder="Others (please specify)" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Type of Analysis</label>
                        <select class="form-control" name="analysis_type" onchange="toaOnchangeEvt(this)" required>
                            <option value="" disabled>Select category</option>
                            <?php 
                                $isPreset = false;
                                foreach($analysisTypes ?? [] as $c) {
                                    $selected = '';
                                    if($data['analysis_type'] == $c['id']) {
                                        $selected = 'selected';
                                        $isPreset = true;
                                    }
                                    echo '<option value="'.$c['id'].'" '.$selected.' '. (empty($c['name']) ? 'disabled' : '' ) .'>'.(empty($c['name']) ? '(empty)' : $c['name']).'</option>'; 
                                }
                            ?>
                            <option value="others" <?= empty($isPreset) ? 'selected' : '' ?>>Others</option>
                        </select>
                        <input type="text" name="other_analysis_type" class="form-control margin-top-15  <?= !empty($isPreset) ? 'hide' : '' ?>" value="<?= empty($isPreset) ? $data['analysis_type_name'] : '' ?>" placeholder="Others (please specify)" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Laboratory Type</label>
                        <select class="form-control" name="laboratory_type" required>
                            <option value="" disabled>Select type</option>
                            <option value="in-house" <?= $data['laboratory_type'] == 'in-house' ? 'selected' : '' ?>>In house</option>
                            <option value="third-party" <?= $data['laboratory_type'] == 'third-party' ? 'selected' : '' ?>>Third Party</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Upload Document</label>
                        <select class="form-control <?= !empty($data_files) ? 'hide' : '' ?>" name="filetype" onchange="changeType(this)" required>
                            <option value="" selected disabled>Select option</option>
                            <option value="1">Manual Upload</option>
                            <option value="3">Google Drive URL</option>
                        </select>
                        <input class="form-control margin-top-15 fileUpload" type="file" name="file" style="display: none;" />
                        <input class="form-control margin-top-15 fileURL" type="url" name="fileurl" style="display: none;" placeholder="https://" />
                        <p class="<?= empty($data_files) ? 'hide' : '' ?>" style="margin: 0;"><a href="<?= $data_files ?>" data-src="<?= $data_files ?>" data-fancybox data-type="iframe" class="btn btn-link">View</a> | <button type="button" class="btn btn-link uploadNew" onclick="uploadNew(this)">Upload New</button></p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="ccontrol-label">Document Date</label>
                        <input class="form-control" type="date" name="file_date" value="<?= $data['files_date'] ?>" required />
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
                                        <input type="radio" value="0" name="frequency" <?= $data['frequency'] == '0' ? 'checked' : '' ?> />
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline"> Weekly
                                        <input type="radio" value="1" name="frequency" <?= $data['frequency'] == '1' ? 'checked' : '' ?> />
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline"> Monthly
                                        <input type="radio" value="2" name="frequency" <?= $data['frequency'] == '2' ? 'checked' : '' ?> />
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-radio-list">
                                    <label class="mt-radio mt-radio-outline"> Quarterly
                                        <input type="radio" value="3" name="frequency" <?= $data['frequency'] == '3' ? 'checked' : '' ?> />
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline"> Biannual
                                        <input type="radio" value="4" name="frequency" <?= $data['frequency'] == '4' ? 'checked' : '' ?> />
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline"> Annually
                                        <input type="radio" value="5" name="frequency" <?= $data['frequency'] == '5' ? 'checked' : '' ?> />
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <label>Others</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="radio" value="6" name="frequency" <?= $data['frequency'] == '6' ? 'checked' : '' ?> />
                                <span></span>
                            </span>
                            <input class="form-control " type="text" name="frequency_other" value="<?= $data['frequency_other'] ?>" placeholder="Please specify">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label">Received By</label>
                        <input class="form-control" type="text" name="received" required placeholder="Enter received by" value="<?= $data['received_by'] ?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Comment/Notes</label>
                        <textarea class="form-control" name="notes" placeholder="Write some comment or notes here" required><?= $data['notes'] ?></textarea>
                    </div>
                </div>
            </div>
<?php
        }
    }
    
    // updating  record
    if(isset($_POST['coa_update']) && $_POST['coa_update']  == true) {
        $arr_item = array();
        
        if($_POST['category'] == 'others') {
            if(!empty($_POST['other_category'])) {
                $existingId = empty($_POST['category_id']) ? null : $_POST['category_id'];
                if($existingId) {
                    $conn->execute("UPDATE tbl_coa_categories SET name = ? WHERE id = ?", esc($_POST['other_category']), $existingId);
                    $_POST['category'] = $existingId;
                } else {
                    $conn->execute("INSERT INTO tbl_coa_categories (user_id,name,in_dropdown) VALUE(?,?,?)", $user_id, esc($_POST['other_category']), $saveNewItem);
                    $_POST['category'] = $conn->lastInsertID();
                }
            }
        }
        
        if($_POST['analysis_type'] == 'others') {
            if(!empty($_POST['other_analysis_type'])) {
                $existingId = empty($_POST['analysis_type_id']) ? null : $_POST['analysis_type_id'];
                if($existingId) {
                    $conn->execute("UPDATE tbl_coa_analysis_types SET name = ? WHERE id = ?", esc($_POST['other_analysis_type']), $existingId);
                    $_POST['analysis_type'] = $existingId;
                } else {
                    $conn->execute("INSERT INTO tbl_coa_analysis_types (user_id,name,in_dropdown) VALUE(?,?,?)", $user_id, esc($_POST['other_analysis_type']), $saveNewItem);
                    $_POST['analysis_type'] = $conn->lastInsertID();
                }
            }
        }
		
		$sql = 'UPDATE `tbl_coa` SET `portal_user` = ?, `product_name` = ?, `category` = ?, `analysis_type` = ?, `laboratory_type` = ?, `frequency` = ?, `frequency_other` = ?, `received_by` = ?, `notes` = ?, files_date = ? WHERE id = ?';
    	$conn->execute($sql, array(
    	    $portal_user,
    	    esc($_POST['product']),
    	    $_POST['category'],
    	    $_POST['analysis_type'],
    	    $_POST['laboratory_type'],
            $_POST['frequency'],
            esc($_POST['frequency_other']),
            esc($_POST['received']),
            esc($_POST['notes']),
            $_POST['file_date'],
            $_POST['id'],
        ));
        
		$prevData = $conn->execute('SELECT * FROM tbl_coa WHERE id = ?',  $_POST['id'])->fetchAssoc();
		if (count($prevData) > 0 ) {
            $files = '';
            $arr_item = array();
            if (!empty($prevData["file_history"])) {
                $arr_item = json_decode($prevData["file_history"],true);
            }
            
            $filename = null;
            $filetype = $_POST['filetype'];
            if ($filetype > 0) {
                if ($filetype == 1) {
                    $files = $_FILES['file']['name'];
                    if (!empty($files)) {
                        $path = 'uploads/eforms/';
                        $filesize = $_FILES['file']['size'];
                        $tmp = $_FILES['file']['tmp_name'];
                        // renamed the files but keeping its original file extension
                        $randomPrefix = rand(1000,1000000);
                        $filename = $randomPrefix .' - ' . uniqid() . '.'. pathinfo($files, PATHINFO_EXTENSION);
                        $path = $path . $filename;
                        move_uploaded_file($tmp,$path);
                        

                        $filesize_tot = $filesize + $prevData["filesize"];
                        $conn->execute("UPDATE tbl_coa SET filesize = ? WHERE id = ?", $filesize_tot, $_POST['id']);
                    }
                } else {
                    $files = $_POST['fileurl'];
                    $filesize = 0;
                }

                if (!empty($files)) {
                    $output = array (
                        'type'  =>  $filetype,
                        'name' =>  $files,
                        'size' =>  $filesize,
                        'date' =>  $local_date
                    );
                    array_push($arr_item, $output);
                    $file_history = json_encode($arr_item, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);
                    
                    $conn->execute("UPDATE tbl_coa SET files = ?, filetype = ?, file_history = ? WHERE id = ?", $filename ?? $files, $filetype, $file_history, $_POST['id']);
                }
            }

			$result = array(
			    'data' => array(
    				"ID" => $data_ID,
    				"record" => $data_record,
    				"files_date" => $data_files_date,
    				"verified" => $data_verified
    			)    
			);
		}
    }
    
    // 
    if(isset($_GET['coa_view_file'])  &&  $_GET['coa_view_file']) {
        $id = $_GET['coa_view_file'];
        $FreeAccess = $_GET['freeaccess'];
        
        $data = $conn->execute("SELECT *,
            (SELECT name FROM tbl_coa_categories WHERE id = c.category) as category_name,
            (SELECT name FROM tbl_coa_analysis_types WHERE id = c.analysis_type) as analysis_type_name 
            FROM tbl_coa c WHERE id = ?", $id)->fetchAssoc();
            
        if(count($data)) {
            
            $frequency = match($data['frequency']) {
                0 => "Daily",
                1 => "Weekly",
                2 => "Monthly",
                3 => "Quarterly",
                4 => "Biannual",
                5 => "Annually",
                default => "Others: ". strip_tags($data['frequency_other']),
            };
            
            $fileView = '';
            $filetype = $data['filetype'];
            $data_files = $data['files'];
            $type = 'iframe';
            if (!empty($data_files)) {
                if ($filetype == 1) {
                    $fileExtension = fileExtension($data_files);
                    $src = $fileExtension['src'];
                    $embed = $fileExtension['embed'];
                    $type = $fileExtension['type'];
                    $file_extension = $fileExtension['file_extension'];
                    $url = $base_url.'uploads/eforms/';

                    $data_files = $src.$url.rawurlencode($data_files).$embed;

                    if (strtolower($file_extension) == "gif" OR strtolower($file_extension) == "jpg"  OR strtolower($file_extension) == "jpeg" OR strtolower($file_extension) == "png" OR strtolower($file_extension) == "ico") {
                        $fileView .= '<img src="'.$data_files.'" style="width: 100%; height: 400px; object-fit: contain; object-position: center;" />';
                    } else {
                        if ($FreeAccess == 1) { $fileView .= '<div style="height: 375px; overflow: hidden;">'; }
                            $fileView .= '<iframe src="'.$data_files.'" style="width: 100%; height: 400px; '; 
                            if (strtolower($file_extension) == "pdf" && $FreeAccess == 1) { $fileView .= 'margin-top: -75px;'; } $fileView .= '"></iframe>';
                        if ($FreeAccess == 1) { $fileView .= '</div>'; }
                    }

                    if ($FreeAccess != 1) {
                        $fileView .= '<a href="'.$data_files.'" data-src="'.$data_files.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a>';
                    }
                } else {
                    if ($filetype == 3) {
                        $data_files = preg_replace('#[^/]*$#', '', $data_files).'preview';
                    }

                    if ($FreeAccess == 1) { $fileView .= '<div style="height: 375px; overflow: hidden;">'; }
                        $fileView .= '<iframe src="'.$data_files.'" style="width: 100%; height: 400px; '; 
                        if ($FreeAccess == 1) { $fileView .= 'margin-top: -75px;'; } $fileView .= '"></iframe>';
                    if ($FreeAccess == 1) { $fileView .= '</div>'; }

                    if ($FreeAccess != 1) {
                        $fileView .= '<a href="'.$data_files.'" data-src="'.$data_files.'" data-fancybox data-type="'.$type.'" class="btn btn-link">View</a>';
                    }
                }
            } else {
                $fileView .= 'Empty File';
            }
            
            
?>
            <div class="row">
                <div class="col-md-6"><?= $fileView ?></div>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td>Product/Item Name</td>
                                <td><strong><?= strip_tags($data['product_name']) ?></strong></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><strong><?= strip_tags($data['category_name']) ?></strong></td>
                            </tr>
                            <tr>
                                <td>Type of Analysis</td>
                                <td><strong><?= strip_tags($data['analysis_type_name']) ?></strong></td>
                            </tr>
                            <tr>
                                <td>Laboratory Type</td>
                                <td><strong><?= match($data['laboratory_type']) { 'in-house' => 'In house', 'third-party' => 'Third Party', default => '' }; ?></strong></td>
                            </tr>
                            <tr>
                                <td>Frequency of Collection</td>
                                <td><strong><?= $frequency ?></strong></td>
                            </tr>
                            <tr>
                                <td>Document Date</td>
                                <td><strong><?= strip_tags($data['files_date']) ?></strong></td>
                            </tr>
                            <tr>
                                <td>Received By</td>
                                <td><strong><?= strip_tags($data['received_by']) ?></strong></td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td><strong><?= strip_tags($data['notes']) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php
        }
    }
    
    // fetching records
    if(isset($_POST['fetch_coa'])) {
        // search ids of 'others' menu
        if(!empty($_POST['other_category'])) {
            $ids = $conn->execute("SELECT id FROM tbl_coa_categories WHERE name LIKE '%{$_POST['other_category']}%'")->fetchAll();
            if(count($ids)) {
                $_POST['category'] = $_POST['category'] ?? [];
                foreach($ids as $id) $_POST['category'][] = $id['id'];
            }
        }
        if(!empty($_POST['other_analysis_type'])) {
            $ids = $conn->execute("SELECT id FROM tbl_coa_analysis_types WHERE name LIKE '%{$_POST['other_analysis_type']}%'")->fetchAll();
            if(count($ids)) {
                $_POST['analysis_type'] = $_POST['analysis_type'] ?? [];
                foreach($ids as $id) $_POST['analysis_type'][] = $id['id'];
            }
        }
        
        $categories = implode(',', $_POST['category'] ?? []);
        $analysisTypes = implode(',', $_POST['analysis_type'] ?? []);
        
        $sql = "SELECT c.product_name, c.received_by, c.files_date, c.id,
            (SELECT cc.name FROM tbl_coa_categories cc WHERE id = c.category) as category_name,
            (SELECT ca.name FROM tbl_coa_analysis_types ca WHERE id = c.category) as analysis_type_name
            FROM tbl_coa c WHERE ";
        $conArr = [];
        
        if(!empty($categories)) {
            $conArr[] = " category IN ($categories) ";
        }
        
        if(!empty($analysisTypes)) {
            $conArr[] = " analysis_type IN ($analysisTypes) ";
        }
        
        if(count($conArr)) {
            $sql .= "(". implode('OR', $conArr) .") AND";
        }
        $sql .= " user_id = ?";
        $records = $conn->execute($sql, $user_id)->fetchAll();
        
        $categories = $conn->execute("SELECT * FROM tbl_coa_categories WHERE in_dropdown = 1 AND deleted_at IS NULL AND (user_id = ? OR user_id IS NULL)", $user_id)->fetchAll();
        $analysisTypes = $conn->execute("SELECT * FROM tbl_coa_analysis_types WHERE in_dropdown = 1 AND deleted_at IS NULL AND (user_id = ? OR user_id IS NULL)", $user_id)->fetchAll();
        
        foreach($categories as $k => &$v) {
            if(in_array($v['id'], $_POST['category'] ?? [])) {
                $v['filtered'] = true;
            }
        }
        
        foreach($analysisTypes as $k => &$v) {
            if(in_array($v['id'], $_POST['analysis_type'] ?? [])) {
                $v['filtered'] = true;
            }
        }
        
        $result = array(
            'data' => $records,
            'categories' => $categories,
            'analysis_types' => $analysisTypes,
        );
    }
    
    $conn->commit();
    
    if(!empty($result)) {
        send_response($result);
    }
} catch(Exception $e)  {
    $conn->rollback();
    send_response($e->getMessage(), 500);
}

function esc($string) {
    global $conn;
    return (mysqli_real_escape_string($conn, $string));
}