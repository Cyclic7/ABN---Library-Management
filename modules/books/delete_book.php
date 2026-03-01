<?php
include "../../config/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM books WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_books.php?msg=deleted");
        exit();
    } else {
        echo "Delete failed: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    header("Location: view_books.php");
    exit();
}
?>