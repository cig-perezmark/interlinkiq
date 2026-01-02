<?php

include '../database.php'; // Adjust the path as needed

if (!empty($_COOKIE['switchAccount'])) {
    $portal_user = $_COOKIE['ID'];
    $user_id = $_COOKIE['switchAccount'];
} else {
    $portal_user = $_COOKIE['ID'];
    $user_id = employerID($portal_user);
}

function employerID($ID) {
    global $conn;

    $selectUser = mysqli_query($conn, "SELECT * from tbl_user WHERE ID = $ID");
    $rowUser = mysqli_fetch_array($selectUser);
    $current_userEmployeeID = $rowUser['employee_id'];

    $current_userEmployerID = $ID;
    if ($current_userEmployeeID > 0) {
        $selectEmployer = mysqli_query($conn, "SELECT * FROM tbl_hr_employee WHERE suspended = 0 AND status = 1 AND ID=$current_userEmployeeID");
        if (mysqli_num_rows($selectEmployer) > 0) {
            $rowEmployer = mysqli_fetch_array($selectEmployer);
            $current_userEmployerID = $rowEmployer["user_id"];
        }
    }

    return $current_userEmployerID;
}

// Connect to the database
$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "
WITH filtered_products AS (
    SELECT
        p.ID,
        p.name,
        c.name AS category_name
    FROM
        tbl_products p
    JOIN
        tbl_products_category_group_description c ON p.category_group = c.ID
    WHERE
        p.user_id = $user_id
        AND p.deleted = 0
),
category_aggregation AS (
    SELECT
        category_name,
        COUNT(ID) AS total_products,
        COUNT(DISTINCT category_name) AS total_categories,
        GROUP_CONCAT(name ORDER BY name ASC SEPARATOR ', ') AS product_names
    FROM
        filtered_products
    GROUP BY
        category_name
)
SELECT
    IFNULL(category_name, 'Total') AS category_name,
    total_products,
    total_categories,
    product_names
FROM (
    SELECT * FROM category_aggregation
    UNION ALL
    SELECT
        'Total' AS category_name,
        COUNT(ID) AS total_products,
        COUNT(DISTINCT category_name) AS total_categories,
        GROUP_CONCAT(name ORDER BY name ASC SEPARATOR ', ') AS product_names
    FROM
        filtered_products
) AS combined_results
ORDER BY
    category_name;
";

$result = $conn->query($query);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);

?>
