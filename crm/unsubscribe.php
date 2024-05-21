<?php
require '../database.php';
$pageUrl =  "http://" . $_SERVER['SERVER_NAME'];
// Check for HTTPS if enabled
if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
	$pageUrl = "https://" . $_SERVER['SERVER_NAME'];
}
if (isset($_GET['token'])) {
    $method = "AES-256-CBC";
    $key = "interlink";
    $options = 0;
    $iv = '1234567891011121';
    $decryptedToken = openssl_decrypt($_GET['token'], $method, $key, $options, $iv);

    if ($decryptedToken !== false) {
        $stmt = $conn->prepare("UPDATE tbl_Customer_Relationship SET flag = 0 WHERE crm_id = ?");
        $stmt->bind_param('i', $decryptedToken);
        if ($stmt->execute()) {
            header("Location: $pageUrl/subscribe-page?token=" . $_GET['token']);
            exit();
        } else {
            echo 'Error updating contact status.';
        }
        $stmt->close();
    } else {
        echo 'Error decrypting token.';
    }
    $conn->close();
} else {
    die("Token not provided.");
}
?>
