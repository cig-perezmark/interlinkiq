<?php

	require_once __DIR__ . '/vendor/autoload.php';
    include_once ('../database_iiq.php');

	$mpdf = new \Mpdf\Mpdf();
    // $base_url = "https://interlinkiq.com/";
    $base_url = "../";

	$ID = $_GET['i'];
    $selectData = mysqli_query( $conn,"SELECT * FROM tbl_products WHERE ID = $ID" );
    if ( mysqli_num_rows($selectData) > 0 ) {
        $rowData = mysqli_fetch_array($selectData);
        $user_id = $rowData['user_id'];

        // Product Overview
        $data_image = $rowData['image'];
        $data_image_array = explode(", ", $data_image);
        $image_main = "//placehold.co/400x250/FFFFFF/FFFFFF?text=no+image";
        $image_angle = "//placehold.co/120x90/FFFFFF/FFFFFF?text=no+image";

        $name = htmlentities($rowData['name'] ?? '');
        $category_group_id = htmlentities($rowData['category_group'] ?? '');
        $code = htmlentities($rowData['code'] ?? '');
        $leads = htmlentities($rowData['leads'] ?? '');
        $lead_type = htmlentities($rowData['lead_type'] ?? '');
        $private_label = htmlentities($rowData['private_label'] ?? '');
        $cost = htmlentities($rowData['cost'] ?? '');
        $incoterms = htmlentities($rowData['incoterms'] ?? '');
        $moq = htmlentities($rowData['moq'] ?? '');
        $imports = htmlentities($rowData['imports'] ?? '');
        $description = htmlentities($rowData['description'] ?? '');
        $feature = htmlentities($rowData['feature'] ?? '');
        $ingredients = htmlentities($rowData['ingredients'] ?? '');
        $claims = htmlentities($rowData['claims'] ?? '');
        $intended = htmlentities($rowData['intended'] ?? '');
        $intended_consumers = htmlentities($rowData['intended_consumers'] ?? '');
        $allergen = htmlentities($rowData['allergen'] ?? '');
        $flavor = htmlentities($rowData['flavor'] ?? '');
        $size_uom = htmlentities($rowData['size_uom'] ?? '');
        $size_uom_type = htmlentities($rowData['size_uom_type'] ?? '');
        $shelf = htmlentities($rowData['shelf'] ?? '');
        $shelf_type = htmlentities($rowData['shelf_type'] ?? '');
        $temperature = htmlentities($rowData['temperature'] ?? '');
        $retail_accounts = htmlentities($rowData['retail_accounts'] ?? '');
        $competing_brands = htmlentities($rowData['competing_brands'] ?? '');



        // Packaging
        $packaging_1 = htmlentities($rowData['packaging_1'] ?? '');
        $packaging_1_image = htmlentities($rowData['packaging_1_image'] ?? '');
        $packaging_1_dimension = htmlentities($rowData['packaging_1_dimension'] ?? '');
        $packaging_1_upc = htmlentities($rowData['packaging_1_upc'] ?? '');
        $packaging_1_cube = htmlentities($rowData['packaging_1_cube'] ?? '');
        $packaging_1_weight = htmlentities($rowData['packaging_1_weight'] ?? '');
        $packaging_1_unit = htmlentities($rowData['packaging_1_unit'] ?? '');
        $packaging_1_size_uom = htmlentities($rowData['packaging_1_size_uom'] ?? '');
        $packaging_1_size_uom_type = htmlentities($rowData['packaging_1_size_uom_type'] ?? '');

        $packaging_2 = htmlentities($rowData['packaging_2'] ?? '');
        $packaging_2_image = htmlentities($rowData['packaging_2_image'] ?? '');
        $packaging_2_dimension = htmlentities($rowData['packaging_2_dimension'] ?? '');
        $packaging_2_upc = htmlentities($rowData['packaging_2_upc'] ?? '');
        $packaging_2_cube = htmlentities($rowData['packaging_2_cube'] ?? '');
        $packaging_2_weight = htmlentities($rowData['packaging_2_weight'] ?? '');
        $packaging_2_unit = htmlentities($rowData['packaging_2_unit'] ?? '');
        $packaging_2_size_uom = htmlentities($rowData['packaging_2_size_uom'] ?? '');
        $packaging_2_size_uom_type = htmlentities($rowData['packaging_2_size_uom_type'] ?? '');

        $pallet_image = htmlentities($rowData['pallet_image'] ?? '');
        $packaging_3 = htmlentities($rowData['packaging_3'] ?? '');
        $packaging_3_image = htmlentities($rowData['packaging_3_image'] ?? '');
        $packaging_3_dimension = htmlentities($rowData['packaging_3_dimension'] ?? '');
        $packaging_3_upc = htmlentities($rowData['packaging_3_upc'] ?? '');
        $packaging_3_cube = htmlentities($rowData['packaging_3_cube'] ?? '');
        $packaging_3_weight = htmlentities($rowData['packaging_3_weight'] ?? '');
        $packaging_3_unit = htmlentities($rowData['packaging_3_unit'] ?? '');
        $packaging_3_size_uom = htmlentities($rowData['packaging_3_size_uom'] ?? '');
        $packaging_3_size_uom_type = htmlentities($rowData['packaging_3_size_uom_type'] ?? '');

        $pallet_type = htmlentities($rowData['pallet_type'] ?? '');
        $pallet_dimension = htmlentities($rowData['pallet_dimension'] ?? '');
        $pallet_upc = htmlentities($rowData['pallet_upc'] ?? '');
        $pallet_cube = htmlentities($rowData['pallet_cube'] ?? '');
        $pallet_weight = htmlentities($rowData['pallet_weight'] ?? '');
        $pallet_unit = htmlentities($rowData['pallet_unit'] ?? '');
        $pallet_boxes = htmlentities($rowData['pallet_boxes'] ?? '');

        $production_day = htmlentities($rowData['production_day'] ?? '');
        $production_week = htmlentities($rowData['production_week'] ?? '');
        $production_cost = htmlentities($rowData['production_cost'] ?? '');
        $production_profit = htmlentities($rowData['production_profit'] ?? '');

        $cost_operation = htmlentities($rowData['cost_operation'] ?? '');
        $cost_rent = htmlentities($rowData['cost_rent'] ?? '');
        $cost_material = htmlentities($rowData['cost_material'] ?? '');
        $cost_financing = htmlentities($rowData['cost_financing'] ?? '');
        $cost_transportation = htmlentities($rowData['cost_transportation'] ?? '');

        $mock_recall = htmlentities($rowData['mock_recall'] ?? '');
        $product_trace = htmlentities($rowData['product_trace'] ?? '');
    }

	$html = '<html>
    	<head>
    		<title>Report</title>
    		<style>
    			.image_main {
    				width: 400px;
				    height: 250px;
    			}
    			.image_angle {
    				width: 120px;
				    height: 90px;
    			}
    			.image_main, .image_angle {
				    background-position: center;
				    background-repeat: no-repeat;
				    background-size: contain;
				    background-image-resize: 3;
    			}
    		</style>
    	</head>
    	<body>
    		<h2>Product Overview</h2>
    		<table cellpadding="7" cellspacing="0" width="100%" border="1">';
    			    
                if ($user_id == 1684) {
        			$html .= '<tr>
        				<td colspan="12">Main Product View</td>
        			</tr>
        			<tr>';
        				if (!empty($data_image_array[0])) { $html .= '<td colspan="12" class="image_main" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[0] .'\');"></td>'; }
                        else { $html .= '<td colspan="12" class="image_main" style="background-image: url(\''. $image_main .'\');"></td>'; }
        			$html .= '</tr>';
                } else {
        			$html .= '<tr>
        				<td colspan="6">Main Product View</td>
        				<td colspan="2">Top View</td>
        				<td colspan="2">Front View</td>
        				<td colspan="2">Left View</td>
        			</tr>
        			<tr>';
        				if (!empty($data_image_array[0])) { $html .= '<td colspan="6" rowspan="3" class="image_main" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[0] .'\');"></td>'; }
                        else { $html .= '<td colspan="6" rowspan="3" class="image_main" style="background-image: url(\''. $image_main .'\');"></td>'; }
    
        				if (!empty($data_image_array[1])) { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[1] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        				if (!empty($data_image_array[2])) { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[2] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        				if (!empty($data_image_array[3])) { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[3] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        			$html .= '</tr>
        			<tr>
        				<td colspan="2">Bottom View</td>
        				<td colspan="2">Back View</td>
        				<td colspan="2">Right View</td>
        			</tr>
        			<tr>';
        			
        				if (!empty($data_image_array[4])) { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[4] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        				if (!empty($data_image_array[5])) { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[5] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        				if (!empty($data_image_array[6])) { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[6] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        			$html .= '</tr>';
                }
    		
    			$html .= '<tr>
    				<td colspan="8">Product Name</td>
    				<td colspan="4">Category Group Description</td>
    			</tr>
    			<tr>
    				<td colspan="8">'.$name.'</td>
    				<td colspan="4">';

    					$selectCategory = mysqli_query( $conn,"
                            SELECT 
                            g.id AS group_id,
                            g.name AS group_name,
                            d.id AS desciption_id,
                            d.name AS desciption_name
                            FROM tbl_products_category_group AS g

                            LEFT JOIN (
                                SELECT
                                *
                                FROM tbl_products_category_group_description
                                WHERE deleted = 0
                            ) AS d
                            ON g.ID = d.category_id

                            WHERE g.deleted = 0
                        " );
                        if ( mysqli_num_rows($selectCategory) > 0 ) {
                            $category_group = array();
                            $category_group_prev = 0;
                            while($rowCategory = mysqli_fetch_array($selectCategory)) {
                                if ($category_group_id == $rowCategory['desciption_id']) {
                                	$html .= $rowCategory['desciption_name'];
                                }
                            }
                        }
    				$html .= '</td>
    			</tr>';
    			
    			if ($user_id == 1684) {
    				$html .= '<tr>
    					<td colspan="4">Product / Item Code</td>
    					<td colspan="2">Private Label</td>
                        <td colspan="2">Imports</td>
    					<td colspan="2">Brand Logo</td>
    					<td colspan="2">QR Code</td>
    				</tr>
    				<tr>
    					<td colspan="4">'.$code.'</td>
    					<td colspan="2">';
    
    						$private_label_arr = array(
                                0 => 'No',
                                1 => 'Yes'
                            );
                            $html .= $private_label_arr[$private_label];
    
    					$html .= '</td>
    					<td colspan="2">';
    
    						$imports_arr = array(
                                0 => 'No',
                                1 => 'Yes'
                            );
                            $html .= $imports_arr[$imports];
    
    					$html .='</td>';
    					
        				if (!empty($data_image_array[7])) { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[7] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        				if (!empty($data_image_array[8])) { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[8] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
    				$html .= '</tr>';
    			} else {
    				$html .= '<tr>
    					<td colspan="3">Product / Item Code</td>
    					<td colspan="3">Lead Time</td>
    					<td colspan="2">Private Label</td>
    					<td colspan="2">Brand Logo</td>
    					<td colspan="2">QR Code</td>
    				</tr>
    				<tr>
    					<td colspan="3">'.$code.'</td>
    					<td colspan="3">';
    
    						$lead_type_arr = array(
                                0 => 'Day',
                                1 => 'Week',
                                2 => 'Month',
                                3 => 'Year'
                            );
    						$html .= $leads .' '.$lead_type_arr[$lead_type];
    
    					$html .= '</td>
    					<td colspan="2">';
    
    						$private_label_arr = array(
                                0 => 'No',
                                1 => 'Yes'
                            );
                            $html .= $private_label_arr[$private_label];
    
    					$html .= '</td>';
    					
        				if (!empty($data_image_array[7])) { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[7] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
        				if (!empty($data_image_array[8])) { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $data_image_array[8] .'\');"></td>'; }
                        else { $html .= '<td colspan="2" rowspan="3" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
    				$html .= '</tr>
    				<tr>
    					<td colspan="2">Cost</td>
    					<td colspan="2">Incoterms</td>
    					<td colspan="2">MOQ</td>
    					<td colspan="2">Imports</td>
    				</tr>
    				<tr>
    					<td colspan="2">$'.$cost.'</td>
    					<td colspan="2">';
    
    						$selectIncoterms = mysqli_query( $conn,"SELECT * from tbl_products_incoterms WHERE deleted = 0 AND ID = $incoterms" );
                            if ( mysqli_num_rows($selectIncoterms) > 0 ) {
                                while($rowIncoterms = mysqli_fetch_array($selectIncoterms)) {
                                    $html .= $rowIncoterms['name'];
                                }
                            }
    
    					$html .='</td>
    					<td colspan="2">'.$moq.'</td>
    					<td colspan="2">';
    
    						$imports_arr = array(
                                0 => 'No',
                                1 => 'Yes'
                            );
                            $html .= $imports_arr[$imports];
    
    					$html .='</td>
    				</tr>';
    			}
    			
				$html .= '<tr>
					<td colspan="6">Product Description</td>
					<td colspan="6">Product Characteristics</td>
				</tr>
				<tr>
					<td colspan="6">'.nl2br($description).'</td>
					<td colspan="6">'.nl2br($feature).'</td>
				</tr>
				<tr>
					<td colspan="12">Ingredients List</td>
				</tr>
				<tr>
					<td colspan="12">'.nl2br($ingredients).'</td>
				</tr>
				<tr>
					<td colspan="3">Product Claims</td>
					<td colspan="3">Intended Use</td>
					<td colspan="3">Intended Consumers</td>
					<td colspan="3">Allergens</td>
				</tr>
				<tr>
					<td colspan="3">-</td>
					<td colspan="3">';

						$selectIntended = mysqli_query( $conn,"SELECT * FROM tbl_products_intended WHERE deleted = 0 AND ID = $intended" );
                        if ( mysqli_num_rows($selectIntended) > 0 ) {
                            while($rowIntended = mysqli_fetch_array($selectIntended)) {
                                $html .= $rowIntended["name"];
                            }
                        }

					$html .= '</td>
					<td colspan="3">'.$intended_consumers.'</td>
					<td colspan="3">-</td>
				</tr>';
				
				if ($user_id == 1684) {
				    $html .= '<tr>
    					<td colspan="4">Size/UOM</td>
    					<td colspan="4">Shelf Life</td>
    					<td colspan="4">Temperature</td>
    				</tr>
    				<tr>
    					<td colspan="4">';
    
    						$html .= $size_uom;
    						$selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0 AND ID = $size_uom_type" );
                            if ( mysqli_num_rows($selectUOM) > 0 ) {
                                while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                    $html .= $rowUOM['name'];
                                }
                            }
    
    					$html .= '</td>
    					<td colspan="4">';
    
    						$shelf_type_arr = array(
                                0 => 'Day',
                                1 => 'Week',
                                2 => 'Month',
                                3 => 'Year'
                            );
    						$html .= $shelf .' '.$shelf_type_arr[$shelf_type];
    
    					$html .= '</td>
    					<td colspan="4">'.$temperature.'</td>
    				</tr>';
				} else {
    				$html .= '<tr>
    					<td colspan="3">Available Flavors</td>
    					<td colspan="3">Size/UOM</td>
    					<td colspan="3">Shelf Life</td>
    					<td colspan="3">Temperature</td>
    				</tr>
    				<tr>
    					<td colspan="3">'.$flavor.'</td>
    					<td colspan="3">';
    
    						$html .= $size_uom;
    						$selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0 AND ID = $size_uom_type" );
                            if ( mysqli_num_rows($selectUOM) > 0 ) {
                                while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                    $html .= $rowUOM['name'];
                                }
                            }
    
    					$html .= '</td>
    					<td colspan="3">';
    
    						$shelf_type_arr = array(
                                0 => 'Day',
                                1 => 'Week',
                                2 => 'Month',
                                3 => 'Year'
                            );
    						$html .= $shelf .' '.$shelf_type_arr[$shelf_type];
    
    					$html .= '</td>
    					<td colspan="3">'.$temperature.'</td>
    				</tr>
    				<tr>
    					<td colspan="6">Retail Accounts</td>
    					<td colspan="6">Competing Brands</td>
    				</tr>
    				<tr>
    					<td colspan="6">'.$retail_accounts.'</td>
    					<td colspan="6">'.$competing_brands.'</td>
    				</tr>';
				}
    		
    		$html .= '</table>

    		<h2>Product Characteristics</h2>
    		<table cellpadding="7" cellspacing="0" width="100%" border="1">
    			<tr>
    				<td colspan="4">Organoleptic/Sensory Characteristics</td>
    				<td colspan="4">Physico - Chemical Characteristics</td>
    				<td colspan="4">Microbiological Characteristics</td>
    			</tr>
    			<tr>
    				<td colspan="4">
    				    <ul>';
        				    $data = json_decode($rowData['physical_characteristics']) ?? null;
                            if(isset($data) && is_array($data)) foreach($data as $v) {
                                $html .= '<li>'.$v.'</li>';
                            }
    				
    				    $html .= '</ul>
    				</td>
    				<td colspan="4">
    				    <ul>';
        				    $data = json_decode($rowData['physico_chemical_characteristics']) ?? null;
                            if(isset($data) && is_array($data)) foreach($data as $v) {
                                $html .= '<li>'.$v.'</li>';
                            }
    				
    				    $html .= '</ul>
    				</td>
    				<td colspan="4">
    				    <ul>';
        				    $data = json_decode($rowData['microbiological_characteristics']) ?? null;
                            if(isset($data) && is_array($data)) foreach($data as $v) {
                                $html .= '<li>'.$v.'</li>';
                            }
    				
    				    $html .= '</ul>
    				</td>
    			</tr>
    		</table>
    	</body>
    </html>';

	$html2 = '<html>
    	<head>
    		<title>Report</title>
    		<style>
    			.image_main {
    				width: 400px;
				    height: 250px;
    			}
    			.image_angle {
    				width: 120px;
				    height: 90px;
    			}
    			.image_main, .image_angle {
				    background-position: center;
				    background-repeat: no-repeat;
				    background-size: contain;
				    background-image-resize: 3;
    			}
    		</style>
    	</head>
    	<body>
    		<h2>Packaging</h2>
			<table cellpadding="7" cellspacing="0" width="100%" border="1">
				<tr>
					<td colspan="12"><h3>Primary</h3></td>
				</tr>
				<tr>';

    				if (!empty($packaging_1_image)) { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $packaging_1_image .'\');"></td>'; }
                    else { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }

					$html2 .= '<td colspan="1">Unit</td>
					<td colspan="3">Dimension</td>
					<td colspan="3">UPC</td>
					<td colspan="3">Cube</td>
				</tr>
				<tr>
					<td colspan="1">';

						$selectPrimary = mysqli_query( $conn,"SELECT * from tbl_products_primary WHERE deleted = 0 AND ID = '".$packaging_1."'" );
                        if ( mysqli_num_rows($selectPrimary) > 0 ) {
                            while($rowPrimary = mysqli_fetch_array($selectPrimary)) {
                                $html2 .= $rowPrimary['name'];
                            }
                        }

					$html2 .= '</td>
					<td colspan="3">'.$packaging_1_dimension.'</td>
					<td colspan="3">'.$packaging_1_upc.'</td>
					<td colspan="3">'.$packaging_1_cube.'</td>
				</tr>
				<tr>
					<td colspan="4">Ship Weight</td>
					<td colspan="4">No. of Units</td>
					<td colspan="2">Size/UOM</td>
				</tr>
				<tr>
					<td colspan="4">'.$packaging_1_weight.'</td>
					<td colspan="4">'.$packaging_1_unit.'</td>
					<td colspan="2">';

						$html2 .=$packaging_1_size_uom;
						$selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0 AND ID = $packaging_1_size_uom_type" );
			            if ( mysqli_num_rows($selectUOM) > 0 ) {
			                while($rowUOM = mysqli_fetch_array($selectUOM)) {
			                    $html2 .= $rowUOM['name'];
			                }
			            }

					$html2 .= '</td>
				</tr>';
				
				if ($user_id == 1684) {
				    $html2 .= '<tr>
                        <td colspan="12"><h3>Secondary Packaging</h3></td>
                    </tr>
                    
                    <tr>';

                        if (!empty($rowData['packaging_2a_image'])) { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'.$rowData['packaging_2a_image'].'\');"></td>'; }
                        else { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }

                        $html2 .= '<td colspan="10"><b>Case</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Material</td>
                        <td colspan="6">';

                            $packaging_2a_material = $rowData['packaging_2a_material'];
                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_products_material WHERE deleted = 0 AND ID = $packaging_2a_material" );
                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                $html2 .= $rowMaterial['name'];
                            }

                        $html2 .='</td>
                    </tr>
                    <tr>
                        <td colspan="4">Weight (lbs)</td>
                        <td colspan="6">'.$rowData['packaging_2a_weight'].'</td>
                    </tr>
                    <tr>
                        <td colspan="4">Dimension - H x L x W (in)</td>
                        <td colspan="6">'.$rowData['packaging_2a_dimension'].'</td>
                    </tr>

                    <tr>';

                        if (!empty($rowData['packaging_2b_image'])) { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'.$rowData['packaging_2b_image'].'\');"></td>'; }
                        else { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }

                        $html2 .= '<td colspan="10"><b>Case OD</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Material</td>
                        <td colspan="6">';

                            $packaging_2b_material = $rowData['packaging_2b_material'];
                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_products_material WHERE deleted = 0 AND ID = $packaging_2b_material" );
                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                $html2 .= $rowMaterial['name'];
                            }

                        $html2 .='</td>
                    </tr>
                    <tr>
                        <td colspan="4">Weight (lbs)</td>
                        <td colspan="6">'.$rowData['packaging_2b_weight'].'</td>
                    </tr>
                    <tr>
                        <td colspan="4">Dimension - H x L x W (in)</td>
                        <td colspan="6">'.$rowData['packaging_2b_dimension'].'</td>
                    </tr>

                    <tr>';

                        if (!empty($rowData['packaging_2c_image'])) { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'.$rowData['packaging_2c_image'].'\');"></td>'; }
                        else { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }

                        $html2 .= '<td colspan="10"><b>Case ID</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">Material</td>
                        <td colspan="6">';

                            $packaging_2c_material = $rowData['packaging_2c_material'];
                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_products_material WHERE deleted = 0 AND ID = $packaging_2c_material" );
                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                $html2 .= $rowMaterial['name'];
                            }

                        $html2 .='</td>
                    </tr>
                    <tr>
                        <td colspan="4">Weight (lbs)</td>
                        <td colspan="6">'.$rowData['packaging_2c_weight'].'</td>
                    </tr>
                    <tr>
                        <td colspan="4">Dimension - H x L x W (in)</td>
                        <td colspan="6">'.$rowData['packaging_2c_dimension'].'</td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="3"><b>Material</b></td>
                        <td colspan="3"><b>Weight (lbs)</b></td>
                        <td colspan="3"><b>Dimension - H x L x W (in)</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Pallet</b></td>
                        <td colspan="3">';

                            $packaging_3a_material = $rowData['packaging_3a_material'] ?? 0;
                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_products_material WHERE deleted = 0 AND ID = $packaging_3a_material" );
                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                $html2 .= $rowMaterial['name'];
                            }

                        $html2 .='</td>
                        <td colspan="3">'.$rowData['packaging_3a_weight'].'</td>
                        <td colspan="3">'.$rowData['packaging_3a_dimension'].'</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Pallet Label</b></td>
                        <td colspan="3">';

                            $packaging_3b_material = $rowData['packaging_3b_material'] ?? 0;
                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_products_material WHERE deleted = 0 AND ID = $packaging_3b_material" );
                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                $html2 .= $rowMaterial['name'];
                            }

                        $html2 .='</td>
                        <td colspan="3">'.$rowData['packaging_3b_weight'].'</td>
                        <td colspan="3">'.$rowData['packaging_3b_dimension'].'</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Pallet Wrap</b></td>
                        <td colspan="3">';

                            $packaging_3c_material = $rowData['packaging_3c_material'] ?? 0;
                            $selectMaterial = mysqli_query( $conn,"SELECT * FROM tbl_products_material WHERE deleted = 0 AND ID = $packaging_3c_material" );
                            if ( mysqli_num_rows($selectMaterial) > 0 ) {
                                $rowMaterial = mysqli_fetch_array($selectMaterial);
                                $html2 .= $rowMaterial['name'];
                            }

                        $html2 .='</td>
                        <td colspan="3">'.$rowData['packaging_3c_weight'].'</td>
                        <td colspan="3">'.$rowData['packaging_3c_dimension'].'</td>
                    </tr>';
				} else {
    				$html2 .= '<tr>
    					<td colspan="12"><h3>Secondary</h3></td>
    				</tr>
    				<tr>';
    
        				if (!empty($packaging_2_image)) { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $packaging_2_image .'\');"></td>'; }
                        else { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
    					$html2 .= '<td colspan="1">Case</td>
    					<td colspan="3">Dimension</td>
    					<td colspan="3">UPC</td>
    					<td colspan="3">Cube</td>
    				</tr>
    				<tr>
    					<td colspan="1">'; 
    
    						$selectSecondary = mysqli_query( $conn,"SELECT * from tbl_products_secondary WHERE deleted = 0 AND ID = '".$packaging_2."'" );
    	                    if ( mysqli_num_rows($selectSecondary) > 0 ) {
    	                        while($rowSecondary = mysqli_fetch_array($selectSecondary)) {
    	                            $html2 .=$rowSecondary['name'];
    	                        }
    	                    }
    
    					$html2 .= '</td>
    					<td colspan="3">'.$packaging_2_dimension.'</td>
    					<td colspan="3">'.$packaging_2_upc.'</td>
    					<td colspan="3">'.$packaging_2_cube.'</td>
    				</tr>
    				<tr>
    					<td colspan="4">Ship Weight</td>
    					<td colspan="4">No. of Units</td>
    					<td colspan="2">Size/UOM</td>
    				</tr>
    				<tr>
    					<td colspan="4">'.$packaging_2_weight.'</td>
    					<td colspan="4">'.$packaging_2_unit.'</td>
    					<td colspan="2">';
    
    						$html2 .=$packaging_2_size_uom;
    						$selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0 AND ID = $packaging_2_size_uom_type" );
                            if ( mysqli_num_rows($selectUOM) > 0 ) {
                                while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                    $html2 .= $rowUOM['name'];
                                }
                            }
    
    					$html2 .= '</td>
    				</tr>
    				<tr>
    					<td colspan="12"><h3>Tertiary</h3></td>
    				</tr>
    				<tr>';
    
        				if (!empty($packaging_3_image)) { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $packaging_3_image .'\');"></td>'; }
                        else { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }
    
    					$html2 .= '<td colspan="1">Master Pack</td>
    					<td colspan="3">Dimension</td>
    					<td colspan="3">UPC</td>
    					<td colspan="3">Cube</td>
    				</tr>
    				<tr>
    					<td colspan="1">';
    
    						$selectTertiary = mysqli_query( $conn,"SELECT * from tbl_products_tertiary WHERE deleted = 0 AND ID = '".$packaging_3."'" );
                            if ( mysqli_num_rows($selectTertiary) > 0 ) {
                                while($rowTertiary = mysqli_fetch_array($selectTertiary)) {
                                    $html2 .= $rowTertiary['name'];
                                }
                            }
    
    					$html2 .= '</td>
    					<td colspan="3">'.$packaging_3_dimension.'</td>
    					<td colspan="3">'.$packaging_3_upc.'</td>
    					<td colspan="3">'.$packaging_3_cube.'</td>
    				</tr>
    				<tr>
    					<td colspan="4">Ship Weight</td>
    					<td colspan="4">No. of Units</td>
    					<td colspan="2">Size/UOM</td>
    				</tr>
    				<tr>
    					<td colspan="4">'.$packaging_3_weight.'</td>
    					<td colspan="4">'.$packaging_3_unit.'</td>
    					<td colspan="2">';
    
    						$html2 .=$packaging_3_size_uom;
    						$selectUOM = mysqli_query( $conn,"SELECT * FROM tbl_products_uom WHERE deleted = 0 AND ID = $packaging_3_size_uom_type" );
                            if ( mysqli_num_rows($selectUOM) > 0 ) {
                                while($rowUOM = mysqli_fetch_array($selectUOM)) {
                                    $html2 .= $rowUOM['name'];
                                }
                            }
    
    					$html2 .= '</td>
    				</tr>';
				}
				
				$html2 .= '<tr>
					<td colspan="12"><h3>Pallet Configuration</h3></td>
				</tr>
				<tr>';

    				if (!empty($pallet_image)) { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $base_url .'uploads/products/'. $pallet_image .'\');"></td>'; }
                    else { $html2 .= '<td colspan="2" rowspan="4" class="image_angle" style="background-image: url(\''. $image_angle .'\');"></td>'; }

					$html2 .= '<td colspan="1">Pallet Type</td>
					<td colspan="3">Dimension</td>
					<td colspan="3">UPC</td>
					<td colspan="3">Cube</td>
				</tr>
				<tr>
					<td colspan="1">';

						$selectPallet = mysqli_query( $conn,"
                            SELECT 
                            p.id AS group_id,
                            p.name AS group_name,
                            t.id AS desciption_id,
                            t.name AS desciption_name
                            FROM tbl_products_pallet AS p

                            LEFT JOIN (
                                SELECT
                                *
                                FROM tbl_products_pallet_type
                                WHERE deleted = 0
                            ) AS t
                            ON p.ID = t.pallet_id

                            WHERE p.deleted = 0
                        " );
                        if ( mysqli_num_rows($selectPallet) > 0 ) {
                            $pallet_arr = array();
                            $pallet_arr_prev = 0;
                            while($rowPallet = mysqli_fetch_array($selectPallet)) {

                            	if ($pallet_type == $rowPallet['desciption_id']) {
                            		$html2 .=$rowPallet['desciption_name'];
                            	}
                            }
                        }

					$html2 .= '</td>
					<td colspan="3">'.$pallet_dimension.'</td>
					<td colspan="3">'.$pallet_upc.'</td>
					<td colspan="3">'.$pallet_cube.'</td>
				</tr>
				<tr>
					<td colspan="4">Ship Weight</td>
					<td colspan="4">No. of Units</td>
					<td colspan="2">No. of Cartons/Boxes</td>
				</tr>
				<tr>
					<td colspan="4">'.$pallet_weight.'</td>
					<td colspan="4">'.$pallet_unit.'</td>
					<td colspan="2">'.$pallet_boxes.'</td>
				</tr>
			</table>';

            if ($user_id == 1684) {
                $html2 .= '<h2>Palletization</h2>
                <table cellpadding="7" cellspacing="0" width="100%" border="1">
                    <tr>
                        <td colspan="12"><h3>Unit</h3></td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Content (bags)</b></td>
                        <td colspan="4"><b>Bag net weight (lbs)</b></td>
                        <td colspan="4"><b>Bag gross weight (lbs)</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">'.$rowData['pallet_unit_content'].'</td>
                        <td colspan="4">'.$rowData['pallet_unit_net'].'</td>
                        <td colspan="4">'.$rowData['pallet_unit_gross'].'</td>
                    </tr>
                    <tr>
                        <td colspan="12"><h3>Case</h3></td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Content (bags)</b></td>
                        <td colspan="4"><b>Case net weight (lbs)</b></td>
                        <td colspan="4"><b>Case gross weight (lbs)</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">'.$rowData['pallet_case_content'].'</td>
                        <td colspan="4">'.$rowData['pallet_case_net'].'</td>
                        <td colspan="4">'.$rowData['pallet_case_gross'].'</td>
                    </tr>
                    <tr>
                        <td colspan="12"><h3>Pallet Stacking Pattern</h3></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Cases / layer</b></td>
                        <td colspan="2"><b>Layers / pallet</b></td>
                        <td colspan="2"><b>Cases / pallet</b></td>
                        <td colspan="2"><b>Net weight (lbs)</b></td>
                        <td colspan="2"><b>Gross weight (lbs)</b></td>
                        <td colspan="2"><b>Pallet height (in)</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">'.$rowData['pallet_cases_layer'].'</td>
                        <td colspan="2">'.$rowData['pallet_layers'].'</td>
                        <td colspan="2">'.$rowData['pallet_cases'].'</td>
                        <td colspan="2">'.$rowData['pallet_net_weight'].'</td>
                        <td colspan="2">'.$rowData['pallet_gross_weight'].'</td>
                        <td colspan="2">'.$rowData['pallet_height'].'</td>
                    </tr>
                    <tr>
                        <td colspan="12"><h3>Trailer Loading Pattern</h3></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Trailer Type</b></td>
                        <td colspan="2"><b>Layout</b></td>
                        <td colspan="2"><b>Pallets / Trailer</b></td>
                        <td colspan="3"><b>Net Weight (lbs)</b></td>
                        <td colspan="3"><b>Gross weight (lbs)</b></td>
                    </tr>';

                    $trailer = htmlentities($rowData['trailer'] ?? '');
                    if (!empty($trailer)) {
                        $selectTrailer = mysqli_query( $conn,"SELECT * FROM tbl_products_trailer WHERE deleted = 0 AND FIND_IN_SET(ID, REPLACE('$trailer', ' ', ''))" );
                        if ( mysqli_num_rows($selectTrailer) > 0 ) {
                            while($rowTrailer = mysqli_fetch_array($selectTrailer)) {

                                $html2 .= '<tr>
                                    <td colspan="2">'.htmlentities($rowTrailer['type'] ?? '').'</td>
                                    <td colspan="2">'.htmlentities($rowTrailer['layout'] ?? '').'</td>
                                    <td colspan="2">'.htmlentities($rowTrailer['pallet'] ?? '').'</td>
                                    <td colspan="3">'.htmlentities($rowTrailer['net'] ?? '').'</td>
                                    <td colspan="3">'.htmlentities($rowTrailer['gross'] ?? '').'</td>
                                </tr>';
                            }
                        }
                    }

                $html2 .= '</table>';
            } else {
    			$html2 .= '<h3>Production</h3>
    			<table cellpadding="7" cellspacing="0" width="100%" border="1">
    				<tr>
    					<td colspan="3">No. of Units / Day</td>
    					<td colspan="3">No. of Units / Week</td>
    					<td colspan="3">Production Cost</td>
    					<td colspan="3">Profit %</td>
    				</tr>
    				<tr>
    					<td colspan="3">'.$production_day.'</td>
    					<td colspan="3">'.$production_week.'</td>
    					<td colspan="3">'.$production_cost.'</td>
    					<td colspan="3">'.$production_profit.'</td>
    				</tr>
    			</table>
    
    			<h3>Cost Calculation</h3>
    			<table cellpadding="7" cellspacing="0" width="100%" border="1">
    				<tr>
    					<td colspan="3">Operation</td>
    					<td colspan="3">Rent, Utilities</td>
    					<td colspan="3">Materials</td>
    					<td colspan="3">Financing</td>
    				</tr>
    				<tr>
    					<td colspan="3">'.$cost_operation.'</td>
    					<td colspan="3">'.$cost_rent.'</td>
    					<td colspan="3">'.$cost_material.'</td>
    					<td colspan="3">'.$cost_financing.'</td>
    				</tr>
    				<tr>
    					<td colspan="3">Transportation</td>
    				</tr>
    				<tr>
    					<td colspan="3">'.$cost_transportation.'</td>
    				</tr>
    			</table>
    			
    			<h3>Production</h3>
    			<table cellpadding="7" cellspacing="0" width="100%" border="1">
    				<tr>
    					<td colspan="4">Material Name</td>
    					<td colspan="3">Lead Time</td>
    					<td colspan="3">% in Formula</td>
    					<td colspan="2">Cost</td>
    				</tr>';
    
    				$materials = htmlentities($rowData['materials'] ?? '');
                    if (!empty($materials)) {
                        $selectProductData = mysqli_query( $conn,"SELECT * FROM tbl_products_lead_time WHERE deleted = 0 AND FIND_IN_SET(ID, REPLACE('$materials', ' ', ''))" );
                        if ( mysqli_num_rows($selectProductData) > 0 ) {
                            while($rowProductData = mysqli_fetch_array($selectProductData)) {
    
                                $lead_time_type = $rowProductData['type'];
                                $dat_type = array(
                                    0 => 'Day',
                                    1 => 'Week',
                                    2 => 'Month',
                                    3 => 'Year',
                                );
    
                                $html2 .='<tr>
    								<td colspan="4">'.htmlentities($rowProductData['name']).'</td>
    								<td colspan="3">'.htmlentities($rowProductData['lead_time']).' '.$dat_type[$lead_time_type].'</td>
    								<td colspan="3">$'.htmlentities($rowProductData['formula']).' %</td>
    								<td colspan="2">$'.htmlentities($rowProductData['cost']).'</td>
    							</tr>';
                            }
                        }
                    }
    			$html2 .= '</table>';
            }
            
    	$html2 .= '</body>
    </html>';

    // echo $html;
    
	$mpdf->WriteHTML($html);
	$mpdf->WriteHTML($html2);
	$mpdf->Output();

?>
