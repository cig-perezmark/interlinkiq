<?php
// Database connection
require '../database.php';

// Function to get employer ID
function employerID($ID) {
    global $conn;

    $stmt = $conn->prepare("SELECT employee_id FROM tbl_user WHERE ID = ?");
    if ($stmt === false) {
        error_log("SQL error: " . $conn->error);
        return $ID;
    }
    
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowUser = $result->fetch_assoc();

    $current_userEmployeeID = $rowUser['employee_id'];
    $current_userEmployerID = $ID;

    if ($current_userEmployeeID > 0) {
        $stmt = $conn->prepare("SELECT user_id FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID = ?");
        if ($stmt === false) {
            error_log("SQL error: " . $conn->error);
            return $ID;
        }

        $stmt->bind_param("i", $current_userEmployeeID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $rowEmployer = $result->fetch_assoc();
            $current_userEmployerID = $rowEmployer["user_id"];
        }
    }

    return $current_userEmployerID;
}

// Check and get user IDs from cookies
if (!empty($_COOKIE['switchAccount'])) {
    $portal_user = $_COOKIE['ID'];
    $user_id = $_COOKIE['switchAccount'];
} else {
    $portal_user = $_COOKIE['ID'];
    $user_id = employerID($portal_user);
}

// Set $id from POST data if it exists
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Combined SQL Query
$sql = "
WITH ClaimSplit AS (
    SELECT
        tbl_products.id AS product_id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_products.claims, ',', numbers.n), ',', -1) AS claim_id
    FROM
        tbl_products
    INNER JOIN (
        SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
        SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL
        SELECT 9 UNION ALL SELECT 10
    ) numbers ON CHAR_LENGTH(tbl_products.claims)
        -CHAR_LENGTH(REPLACE(tbl_products.claims, ',', '')) >= numbers.n - 1
)
SELECT
    p.name AS product_name,  
    c.name AS category_name,
    COUNT(DISTINCT p.id) AS category_count,
    i.name AS intended_name,
    COUNT(DISTINCT p.id) AS intended_count,
    cl.name AS claim_name,
    COUNT(ClaimSplit.claim_id) AS claims_count,
    p.specifcation,
    DATE_FORMAT(p.specifcation_date, '%d/%m/%Y') AS specifcation_date,
    IF(p.specifcation_date IS NULL OR p.specifcation_date = '', 'No Date',
        IF(DATE(NOW()) > DATE_ADD(p.specifcation_date, INTERVAL 1 YEAR), 'Non Compliance', 'Compliance')
    ) AS specification_status,
    IF(p.specifcation_date IS NULL OR p.specifcation_date = '', 'No Date', 
        IF(p.specifcation_date BETWEEN DATE(NOW()) AND DATE_ADD(DATE(NOW()), INTERVAL 30 DAY), '30 Days', 
        IF(p.specifcation_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 31 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 60 DAY), '60 Days',
        IF(p.specifcation_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 61 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 90 DAY), '90 Days', 'Beyond 90 Days')))
    ) AS specification_nearly_expired,
    p.specifcation_radio,
    p.artwork,
    DATE_FORMAT(p.artwork_date, '%d/%m/%Y') AS artwork_date,
    IF(p.artwork_date IS NULL OR p.artwork_date = '', 'No Date',
        IF(DATE(NOW()) > DATE_ADD(p.artwork_date, INTERVAL 1 YEAR), 'Non Compliance', 'Compliance')
    ) AS artwork_status,
    IF(p.artwork_date IS NULL OR p.artwork_date = '', 'No Date', 
        IF(p.artwork_date BETWEEN DATE(NOW()) AND DATE_ADD(DATE(NOW()), INTERVAL 30 DAY), '30 Days', 
        IF(p.artwork_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 31 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 60 DAY), '60 Days',
        IF(p.artwork_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 61 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 90 DAY), '90 Days', 'Beyond 90 Days')))
    ) AS artwork_nearly_expired,
    p.artwork_radio,
    p.haccp,
    DATE_FORMAT(p.haccp_date, '%d/%m/%Y') AS haccp_date,
    IF(p.haccp_date IS NULL OR p.haccp_date = '', 'No Date',
        IF(DATE(NOW()) > DATE_ADD(p.haccp_date, INTERVAL 1 YEAR), 'Non Compliance', 'Compliance')
    ) AS haccp_status,
    IF(p.haccp_date IS NULL OR p.haccp_date = '', 'No Date', 
        IF(p.haccp_date BETWEEN DATE(NOW()) AND DATE_ADD(DATE(NOW()), INTERVAL 30 DAY), '30 Days', 
        IF(p.haccp_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 31 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 60 DAY), '60 Days',
        IF(p.haccp_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 61 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 90 DAY), '90 Days', 'Beyond 90 Days')))
    ) AS haccp_nearly_expired,
    p.haccp_radio,
    p.label,
    DATE_FORMAT(p.label_date, '%d/%m/%Y') AS label_date,
    IF(p.label_date IS NULL OR p.label_date = '', 'No Date',
        IF(DATE(NOW()) > DATE_ADD(p.label_date, INTERVAL 1 YEAR), 'Non Compliance', 'Compliance')
    ) AS label_status,
    IF(p.label_date IS NULL OR p.label_date = '', 'No Date', 
        IF(p.label_date BETWEEN DATE(NOW()) AND DATE_ADD(DATE(NOW()), INTERVAL 30 DAY), '30 Days', 
        IF(p.label_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 31 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 60 DAY), '60 Days',
        IF(p.label_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 61 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 90 DAY), '90 Days', 'Beyond 90 Days')))
    ) AS label_nearly_expired,
    p.label_radio,
    p.formulation,
    DATE_FORMAT(p.formulation_date, '%d/%m/%Y') AS formulation_date,
    IF(p.formulation_date IS NULL OR p.formulation_date = '', 'No Date',
        IF(DATE(NOW()) > DATE_ADD(p.formulation_date, INTERVAL 1 YEAR), 'Non Compliance', 'Compliance')
    ) AS formulation_status,
    IF(p.formulation_date IS NULL OR p.formulation_date = '', 'No Date', 
        IF(p.formulation_date BETWEEN DATE(NOW()) AND DATE_ADD(DATE(NOW()), INTERVAL 30 DAY), '30 Days', 
        IF(p.formulation_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 31 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 60 DAY), '60 Days',
        IF(p.formulation_date BETWEEN DATE_ADD(DATE(NOW()), INTERVAL 61 DAY) AND DATE_ADD(DATE(NOW()), INTERVAL 90 DAY), '90 Days', 'Beyond 90 Days')))
    ) AS formulation_nearly_expired,
    p.formulation_radio,
    p.docs
FROM
    tbl_products p  
LEFT JOIN
    tbl_products_category c ON p.category = c.id
LEFT JOIN
    tbl_products_intended i ON p.intended = i.id
LEFT JOIN
    ClaimSplit ON p.id = ClaimSplit.product_id
LEFT JOIN
    tbl_products_claims cl ON ClaimSplit.claim_id = cl.id
WHERE
    p.id = ?  
    AND c.name IN ('Food', 'Beverages', 'Dietary Supplements', 'Pharmaceuticals', 'Produce', 'Medical Food', 'Cannabis', 'Cosmetics', 'Others', 'Equipment', 'Utensils', 'Consumables', 'Systems', 'Animal Feed', 'Chemicals', 'Confections', 'CPG/FMCG', 'Flavoring', 'Functional Foods', 'Herbal / Herbs', 'Nutraceuticals', 'Packaging', 'Pet Food', 'Raw Materials', 'Spices', 'Manufacturing', 'Distributed', 'Traded', 'Branded')
    AND i.name IN ('Immunocompromised', 'Immunosuppressed', 'Immune deficient', 'Pregnant', 'Elderly', 'Infant and younger children', 'Infants', 'Young Children', 'Allergy Sufferers')
    AND cl.name IN ('Organic', 'Kosher', 'Halal', 'Non-GMO', 'Vegan', 'Low Fat', 'Sugar Free', 'All Natural', 'Fair Trade', 'Dairy Free', 'Gluten-Free', 'Soy Free')
    AND p.deleted = 0
    AND p.user_id = ?
GROUP BY
    p.name, c.name, i.name, cl.name, p.specifcation, p.specifcation_date, specification_status, specification_nearly_expired, p.specifcation_radio, p.artwork, p.artwork_date, artwork_status, artwork_nearly_expired, p.artwork_radio, p.haccp, p.haccp_date, haccp_status, haccp_nearly_expired, p.haccp_radio, p.label, p.label_date, label_status, label_nearly_expired, p.label_radio, p.formulation, p.formulation_date, formulation_status, formulation_nearly_expired, p.formulation_radio, p.docs
ORDER BY
    c.name, i.name, cl.name;";



// Log the query
error_log("SQL Query: " . $sql);

$stmt = $conn->prepare($sql);

// Check for SQL preparation errors
if (!$stmt) {
    error_log("SQL error: " . $conn->error);
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("ii", $id, $user_id); // Bind the product ID and user ID
$stmt->execute();
$result = $stmt->get_result();

$data = [
    "product_name" => "",
    "category_counts" => [],
    "intended_counts" => [],
    "claim_counts" => [],

    "specifcation" => "",
    "specifcation_date" => "",
    "specification_status" => "",
    "specifcation_radio" => 0,
    "specification_nearly_expired" => 0,

    "artwork" => "",
    "artwork_date" => "",
    "artwork_status" => "",
    "artwork_radio" => 0,
    "artwork_nearly_expired" => 0,

    "haccp" => "",
    "haccp_date" => "",
    "haccp_status" => "",
    "haccp_radio" => 0,
    "haccp_nearly_expired" => 0,

    "label" => "",
    "label_date" => "",
    "label_status" => "",
    "label_radio" => 0,
    "label_nearly_expired" => 0,

    "formulation" => "",
    "formulation_date" => "",
    "formulation_status" => "",
    "formulation_radio" => 0,
    "formulation_nearly_expired" => 0,
    
    "docs" => [], // Initialize docs as an empty array
    "total_documents" => 0, // Initialize total documents count
    "compliance_percentage" => 0,
    "non_compliance_percentage" => 0

];

$docs_seen = []; // Array to track unique docs

// Initialize counters for compliance and total fields
$total_fields = 0;
$compliance_count = 0;

while ($row = $result->fetch_assoc()) {
    if (empty($data["product_name"])) {
        $data["product_name"] = $row['product_name'];
    }
    $data["category_counts"][$row['category_name']] = (int) $row['category_count'];
    $data["intended_counts"][$row['intended_name']] = (int) $row['intended_count'];
    $data["claim_counts"][$row['claim_name']] = (int) $row['claims_count'];
    
    $data["specifcation"] = $row['specifcation'];
    $data["specifcation_date"] = $row['specifcation_date'];
    $data["specification_status"] = $row['specification_status'];
    $data["specifcation_radio"] = $row['specifcation_radio'] ? 'Yes' : 'No';
    $data["specification_nearly_expired"] = $row['specification_nearly_expired'];
    
    $data["artwork"] = $row['artwork'];
    $data["artwork_date"] = $row['artwork_date'];
    $data["artwork_status"] = $row['artwork_status'];
    $data["artwork_radio"] = $row['artwork_radio'] ? 'Yes' : 'No';
    $data["artwork_nearly_expired"] = $row['artwork_nearly_expired'];
    
    $data["haccp"] = $row['haccp'];
    $data["haccp_date"] = $row['haccp_date'];
    $data["haccp_status"] = $row['haccp_status'];
    $data["haccp_radio"] = $row['haccp_radio'] ? 'Yes' : 'No';
    $data["haccp_nearly_expired"] = $row['haccp_nearly_expired'];
    
    $data["label"] = $row['label'];
    $data["label_date"] = $row['label_date'];
    $data["label_status"] = $row['label_status'];
    $data["label_radio"] = $row['label_radio'] ? 'Yes' : 'No';
    $data["label_nearly_expired"] = $row['label_nearly_expired'];
    
    $data["formulation"] = $row['formulation'];
    $data["formulation_date"] = $row['formulation_date'];
    $data["formulation_status"] = $row['formulation_status'];
    $data["formulation_radio"] = $row['formulation_radio'] ? 'Yes' : 'No';
    $data["formulation_nearly_expired"] = $row['formulation_nearly_expired'];

    // Only count non-null and non-empty document fields once
    $fields = ['specifcation', 'artwork', 'haccp', 'label', 'formulation'];
    foreach ($fields as $field) {
        if (!empty($row[$field]) && !in_array($field, $docs_seen)) {
            $data["total_documents"]++;
            $docs_seen[] = $field;
        }
    }

    // Handle `docs` JSON field
    if (!empty($row['docs'])) {
        $docs = json_decode($row['docs'], true);
        if (is_array($docs)) {
            foreach ($docs as $doc) {
                if (!empty($doc) && !in_array($doc, $docs_seen)) {
                    $docs_seen[] = $doc;
                    $data["docs"][] = $doc; // Store the doc
                    $data["total_documents"]++;
                }
            }
        }
    }

    // Count total fields and compliance status
    $fields = ['specification_status', 'artwork_status', 'haccp_status', 'label_status', 'formulation_status'];
    foreach ($fields as $field) {
        $total_fields++;
        if ($row[$field] === 'Compliance') {
            $compliance_count++;
        }
    }
}

// Calculate compliance and non-compliance percentages
if ($total_fields > 0) {
    $data["compliance_percentage"] = ($compliance_count / $total_fields) * 100;
    $data["non_compliance_percentage"] = 100 - $data["compliance_percentage"];
}


// Send the JSON response
header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$stmt->close();
$conn->close();
?>
