<?php
include "../../config/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $title = $_POST['title'];
    $author_name = $_POST['author_name'];
    $isbn = $_POST['isbn'];
    $category_name = $_POST['category_name'];
    $published_year = (int)$_POST['published_year'];
    $status = $_POST['status'];

    $stmt = mysqli_prepare($conn, "UPDATE books SET title=?, author_name=?, isbn=?, category_name=?, published_year=?, status=? WHERE id=?");
    
    mysqli_stmt_bind_param($stmt, "ssssisi", $title, $author_name, $isbn, $category_name, $published_year, $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_books.php?msg=updated");
        exit();
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>