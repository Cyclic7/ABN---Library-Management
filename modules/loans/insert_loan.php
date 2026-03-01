<?php
include "../../config/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = (int)$_POST['book_id'];
    $member_id = (int)$_POST['member_id'];
    $deadline = $_POST['return_deadline'];

    // Start transaction
    mysqli_begin_transaction($conn);

    // Check if book is still available
    $check = mysqli_query($conn, "SELECT status FROM books WHERE id = $book_id FOR UPDATE");
    $book = mysqli_fetch_assoc($check);
    if ($book['status'] != 'Available') {
        mysqli_rollback($conn);
        die("Book is not available for loan.");
    }

    // Insert loan
    $stmt = mysqli_prepare($conn, "INSERT INTO loans (book_id, member_id, return_deadline) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iis", $book_id, $member_id, $deadline);
    $inserted = mysqli_stmt_execute($stmt);

    if ($inserted) {
        // Update book status
        mysqli_query($conn, "UPDATE books SET status = 'Borrowed' WHERE id = $book_id");
        mysqli_commit($conn);
        header("Location: view_loans.php?msg=loaned");
        exit();
    } else {
        mysqli_rollback($conn);
        echo "Error: " . mysqli_error($conn);
    }
}
?>