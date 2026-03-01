<?php
include "../../config/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $loan_id = (int)$_POST['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM loans WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $loan_id);
    mysqli_stmt_execute($stmt);

    header("Location: view_loans.php?msg=deleted");
    exit();
} else {
    header("Location: view_loans.php");
    exit();
}
?>