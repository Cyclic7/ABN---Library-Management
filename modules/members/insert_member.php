<?php
include "../../config/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = mysqli_prepare($conn, "INSERT INTO members (full_name, email, phone, membership_type) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $_POST['full_name'], $_POST['email'], $_POST['phone'], $_POST['type']);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_member.php?msg=added");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>