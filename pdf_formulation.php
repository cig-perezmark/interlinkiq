<?php
    include_once ('database_iiq.php');
    
    function employerID($ID) {
        global $conn;

        $selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $ID" );
        $rowUser = mysqli_fetch_array($selectUser);
        $current_userEmployeeID = $rowUser['employee_id'];

        $current_userEmployerID = $ID;
        if ($current_userEmployeeID > 0) {
            $selectEmployer = mysqli_query( $conn,"SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID" );
            if ( mysqli_num_rows($selectEmployer) > 0 ) {
                $rowEmployer = mysqli_fetch_array($selectEmployer);
                $current_userEmployerID = $rowEmployer["user_id"];
            }
        }

        return $current_userEmployerID;
    }

    $ID = $_GET['id'];
    $html = '';

    //============================================================+
    // File name   : example_006.php
    // Begin       : 2008-03-04
    // Last Update : 2013-05-14
    //
    // Description : Example 006 for TCPDF class
    //               WriteHTML and RTL support
    //
    // Author: Nicola Asuni
    //
    // (c) Copyright:
    //               Nicola Asuni
    //               Tecnick.com LTD
    //               www.tecnick.com
    //               info@tecnick.com
    //============================================================+

    /**
     * Creates an example PDF TEST document using TCPDF
     * @package com.tecnick.tcpdf
     * @abstract TCPDF - Example: WriteHTML and RTL support
     * @author Nicola Asuni
     * @since 2008-03-04
     */

    // Include the main TCPDF library (search for installation path).
    require_once('TCPDF/tcpdf.php');

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('InterlinkIQ.com');
    $pdf->SetTitle('InterlinkIQ.com');
    $pdf->SetSubject('InterlinkIQ.com');
    $pdf->SetKeywords('InterlinkIQ.com');

    // set default header data
    // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // remove default header/footer
    $pdf->setPrintHeader(false);
    // $pdf->setPrintFooter(false);
    // $pdf->setHeaderMargin(0);
    // $pdf->setMargins(0, 0, 0, true);
    // $pdf->setPageOrientation('', false, 0);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // // set margins
    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('dejavusans', '', 8);

    // add a page
    $pdf->AddPage();

    // writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
    // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

    // create some HTML content

    // $img_base64_encoded = str_replace("image/;base64,", "", $img_base64_encoded);

    // // Image from data stream ('PHP rules')
    // $imgLogo = base64_decode($img_base64_encoded);

    // $imgLogo = setImageScale(7);
    // $imgLogo = Image('@'.$imgLogo);

    $st = ["Removed","Approved","R&D","Sample Use Only","Do Not Use"];
    $formula = $conn->query("SELECT * FROM tbl_formulation_formulas WHERE id={$ID}");

    if($formula->num_rows) {
        $formula = $formula->fetch_assoc();

        $html = '<h4>Basic Information</h4>
          <table cellpadding="7" cellspacing="0" border="1" nobr="true">
            <tbody>
              <tr>
                <th style="width: 15%">Formula Name</th>
                <td style="width: 45%">'.$formula['name'].'</td>
                <th style="width: 15%">Code</th>
                <td>'.$formula['formula_code'].'</td>
              </tr>
              <tr>
                <th>Serving Size</th>
                <td data-batch>'.$formula['serving_size'].'</td>
                <th>Version No.</th>
                <td>'.$formula['version_number'].'</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>'.$st[$formula['status']].'</td>
                <th>Date</th>
                <td>'.$formula['status_date'].'</td>
              </tr>
            </tbody>
          </table>
          <h4>Ingredients</h4>
          <table cellpadding="7" cellspacing="0" border="1" nobr="true">
            <thead>
              <tr>
                <th rowspan="2">Ingredient</th>
                <th rowspan="2">Amount/serving </th>
                <th rowspan="2">Price</th>
                <th rowspan="2">Formulation</th>
                <th colspan="3">Cost Per Serving</th>
              </tr>
              <tr>
                <th>lb</th>
                <th>oz</th>
                <th>kg</th>
              </tr>
            </thead>
            <tbody>';
            $ing = json_decode($formula['ingredients'], TRUE);
            $totalGrams = 0;
            $totalPrice = 0;
            foreach($ing as $ind => $i) {
              $srv = is_string($i['serving']) ? [
                'amount' => $i['serving'],
                'grams' => 1,
                'unit' => 'g'
              ] : $i['serving'];
              $ingName = $conn->query("SELECT material_name,material_ppu,material_count FROM tbl_supplier_material WHERE ID={$i['id']}")->fetch_assoc();
              $ing[$ind]['serving'] = $srv;
              $ing[$ind]['data'] = $ingName;
              $totalGrams += doubleval($srv['amount']) * doubleval($srv['grams']);
            }
            foreach($ing as $i) {
              $g = doubleval($i['serving']['amount']) * doubleval($i['serving']['grams']);
              $price = number_format(($g * doubleval($i['data']['material_ppu'] ?? 1)) / doubleval($i['data']['material_count'] ?? 1), 2);
              $totalPrice += $price;
              $html .= '<tr>
                <td>'.$i['data']['material_name'].'</td>
                <td><span data-batch>'.$i['serving']['amount']. '</span> ' .$i['serving']['unit'].'</td>
                <td data-batch>'.$price.'</td>
                <td>'.(number_format(($g / $totalGrams) * 100, 2)).'%</td>
                <td data-batch>'.convert($i['serving']['amount'] * $i['serving']['grams'], 'lb').'</td>
                <td data-batch>'.convert($i['serving']['amount'] * $i['serving']['grams'], 'oz').'</td>
                <td data-batch>'.convert($i['serving']['amount'] * $i['serving']['grams'], 'kg').'</td>
              </tr>';
            }
            $html .= '</tbody>
          </table>
          <h5>Total Amount/serving, g: <strong data-batch>'.($totalGrams).'</strong></h5>
          <h5>Total Price: <strong data-batch>'.($totalPrice).'</strong></h5>
          <h4 style="margin-top:3rem;">Notes</h4>
          <div style="padding: 1rem;">'.(isset($formula['notes']) || empty($formula['notes']) ? $formula['notes'] : "<i class='text-muted'>Not added.</i>").'</div>
          <h4 style="margin-top:3rem;">Instructions</h4>';
          $ins = json_decode($formula['instructions'], true);
          foreach($ins as  $i) {
            $html .= '<div style="padding: 1rem;"><h5 style="font-weight: 600;">'.$i['title'].'</h5><ol>';
            foreach($i['instructions'] as $ii) {
              $html .= '<li>'.$ii.'</li>';
            }
            $html .= '</ol></div>';
          }

        $conn->close();
    }

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    // $pdf->writeHTML($html);

    // reset pointer to the last page
    $pdf->lastPage();

    // ---------------------------------------------------------

    //Close and output PDF document
    // $pdf->Output($row["code"].'-'.$row["company"].'-'.date('Ymd'), 'I');
    $pdf->Output($formula['name'].'-'.date('Ymd').'.pdf', 'I');

    //============================================================+
    // END OF FILE
    //============================================================+
