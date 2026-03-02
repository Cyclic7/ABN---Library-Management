<?php
include "../../config/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $membership_type = $_POST['membership_type'];
    $account_status = $_POST['account_status'];

    $stmt = mysqli_prepare($conn, "UPDATE members SET full_name=?, email=?, phone=?, membership_type=?, account_status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $email, $phone, $membership_type, $account_status, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_member.php?msg=updated");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    header("Location: view_member.php");
}
exit();
?>