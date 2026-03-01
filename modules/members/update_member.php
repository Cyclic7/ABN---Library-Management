<?php
include "../../config/db_connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = mysqli_prepare($conn, "UPDATE members SET full_name=?, account_status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $_POST['full_name'], $_POST['account_status'], $_POST['id']);
    mysqli_stmt_execute($stmt);
    header("Location: view_member.php");
}
?>