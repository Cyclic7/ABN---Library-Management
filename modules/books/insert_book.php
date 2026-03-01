<?php
include "../../config/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO books (title, author_name, isbn, category_name, published_year) VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $_POST['title'],
        $_POST['author_name'],
        $_POST['isbn'],
        $_POST['category_name'],
        $_POST['published_year']
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_books.php?msg=added");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>