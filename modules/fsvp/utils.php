<?php

include_once __DIR__ ."/../../alt-setup/setup.php";

function getSuppliersByUser($conn, $userId) {
    return $conn->select("tbl_supplier", "ID as id, name", [ 'user_id'=> $userId, 'status'=>1, 'page'=>1])->fetchAll();
}