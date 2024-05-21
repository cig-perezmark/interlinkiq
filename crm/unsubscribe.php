<?php
require '../database.php';
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
            header("Location: https://interlinkiq.com//subscribe-page?token=" . $_GET['token']);
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
