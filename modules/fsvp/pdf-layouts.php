<?php

function getLayout($type, $title, $data) {
    if($type === 'ipr-1') {
        $html = '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr style="font-weight:bold; text-align:center;">
                    <th>FSVP Importer Name</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Ingredient Name</th>
                    <th>Finished Product Brand Name</th>
                    <th>Intended Use</th>
                </tr>';

        foreach($data as $d) {
            $html .= '
                <tr style="text-align:center;">
                    <td>'.txt($d['importer_name']).'</td>
                    <td>'.txt($d['product_name']).'</td>
                    <td>'.txt($d['description']).'</td>
                    <td>'.txt($d['ingredients_list']).'</td>
                    <td>'.txt($d['brand_name']).'</td>
                    <td>'.txt($d['intended_use']).'</td>
                </tr>
            ';
        }

        $html .= '</table>';
        return $html;
    } else if($type === 'ipr-2') {
        return '
            <style>
                table { width: 100%; padding: 5px 0 5px 0; }
            </style>
            <br>
            <br><table class="borderless">
                <tr>
                    <td class="borderless">Reviewed By:</td>
                    <td>Approved By:</td>
                </tr>
                <tr>
                    <td>Signature:</td>
                    <td>Signature:</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>Date:</td>
                </tr>
            </table>
            <p style="display:none;">Note: Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</p>

        ';
    } else if($type === 'ipr-3') {
        return '
            <br>
            <br><strong>Comments:</strong>
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ';
    }

    
    return match ($type) {
        'evaluation_form'       => '
        ',
    
        'importer_information'  => '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr>
                    <td style="width: 20%; font-weight:bold;">FSVP Importer:</td>
                    <td style="width: 80%;">'.txt($data['importer_name']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">DUNS No.:</td>
                    <td>'.txt($data['duns_no']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Registration No.</td>
                    <td>'.(txt($data['fda_registration'])).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Supplier:</td>
                    <td>'. txt($data['supplier_name']) .'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Product(s):</td>
                    <td>'.txt($data['products']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Qualifying Individual:</td>
                    <td>'. txt($data['fsvpqi_name']) .'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Name:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Email:</td>
                    <td>'.txt($data['email']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Address:</td>
                    <td>'.txt($data['importer_address']).'</td>
                </tr>
            </table>
            <br>
            <br><strong>Importer Name and Signature:</strong>
            <br><table>
                <tr>
                    <td>Name and Signature:
                        <p style="text-align:center;">'.txt($data['importer_name']).'</p>
                    </td>
                    <td>Date:</td>
                </tr>
            </table>
            <br>
            <br>Comments:
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ',

        'cbp'                   => '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr>
                    <td><strong>Importer Name:</strong> '.($data['importer_name'] ?? '').'</td>
                    <td><strong>Date:</strong> '.(date('Ymd', strtotime($data['created_at']))).'</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Address:</strong> '.($data['importer_address']).'</td>
                </tr>
            </table>
            <p style="display:none;">Supplier information for FSVP importer
                <br>This Evaluation is to help the Supplier, the entity who received imported food, to ensure that an appropriate FSVP importer has been designated by parties involved in the importation of the food and that the U.S. Customs and Border Protection (CBP).
            </p>
            <br>
            <br><table>
                <tr style="text-align:center; font-weight:bold;">
                    <td>Imported Food(s) / Food Product(s) Information</td>
                    <td>Supplier Information</td>
                    <td>Determining FSVP Importer</td>
                    <td>Designated FSVP Importer</td>
                    <td>CBP Entry Filer</td>
                </tr>
                <tr>
                    <td>'.($data['foods_info'] ?? 'None').'</td>
                    <td>'.($data['supplier_info'] ?? 'None').'</td>
                    <td>'.($data['determining_importer'] ?? 'None').'</td>
                    <td>'.($data['designated_importer'] ?? 'None').'</td>
                    <td>'.($data['cbp_entry_filer'] ?? 'None').'</td>
                </tr>
                <tr style="display:none;">
                    <td colspan="5">*The Supplier identified as the FSVP “importer” in the CBP entry filing. FDA will see as responsible for complying with the FSVP rule.
                        <br>** The definition of FSVP importer is if there is no U.S. owner or consignee at the time of entry and you are the U.S. agent or representative of the foreign owner or consignee.
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 50%;"><strong>Reviewed By:</strong></td>
                    <td colspan="2" style="width: 50%;"><strong>Date:</strong></td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 50%;"><strong>Approved By:</strong></td>
                    <td colspan="2" style="width: 50%;"><strong>Date:</strong></td>
                </tr>
            </table>
            <span style="display:none;">Note: Review and return this form to the Quality Personnel within 24 hours. If the document is not approved, state the reason in the comment section below.</span>
            <br><br><strong>Comments:</strong>
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ',

        'activities-worksheet'  => '
            <h3 style="text-align:center;">'.$title.'</h3>
            <table>
                <tr>
                    <td style="width:25%;font-weight:bold;">Importer Name:</td>
                    <td style="width:75%">'.txt($data['importer_name']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Verification Date:</td>
                    <td>'.txt($data['verification_date']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Supplier Evaluation Date:</td>
                    <td>'.txt($data['supplier_evaluation_date']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Address:</td>
                    <td>'.txt($data['importer_address']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">QI Approval:</td>
                    <td>'.txt($data['qi_approval']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Approval Date:</td>
                    <td>'.txt($data['approval_date']).'</td>
                </tr>
            </table>
            <p></p>
            <table>
                <tr>
                    <td style="width:25%;font-weight:bold;">Foreign Supplier Name:</td>
                    <td style="width:75%">'.txt($data['supplier_name']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Foreign Supplier Address:</td>
                    <td>'.txt($data['supplier_address']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Product Imported:</td>
                    <td>'.txt($data['products']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Product Description(s), including Important Food Safety Characteristics:</td>
                    <td>'.txt($data['fdfsc']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Process Description (Ingredients/Packaging Materials):</td>
                    <td>'.txt($data['pdipm']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Food Safety Hazard(s) Controlled by Foreign Supplier:</td>
                    <td>'.txt($data['fshc']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Description of Foreign Supplier Control(s):</td>
                    <td>'.txt($data['dfsc']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Verification Activity(ies) and Frequency:</td>
                    <td>'.txt($data['vaf']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Justification for Verification Activity(ies) and Frequency:</td>
                    <td>'.txt($data['justification_vaf']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Verification Records (i.e audit summaries, test results):</td>
                    <td>'.txt($data['verification_records']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Assessment of Results of Verification Activity(ies):</td>
                    <td>'.txt($data['assessment_results']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Corrective Action(s), if needed:</td>
                    <td>'.txt($data['corrective_actions']).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Re-evaluation Date:</td>
                    <td>'.txt($data['reevaluation_date']).'</td>
                </tr>
            </table>
            <p></p>Comments:
            <br><table>
                <tr>
                    <td></td>
                </tr>
            </table>
        ',
        
        'report'                => '',

        default                 => '',
    };
}

function createFSVPReport(&$pdf) {
    
}