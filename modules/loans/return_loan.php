<?php
include "../../config/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $loan_id = (int)$_POST['id'];

    // Start transaction
    mysqli_begin_transaction($conn);

    // Get book_id from this loan
    $stmt = mysqli_prepare($conn, "SELECT book_id FROM loans WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $loan_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $loan = mysqli_fetch_assoc($result);
    $book_id = $loan['book_id'];

    // Update loan status to Returned
    $update_loan = mysqli_prepare($conn, "UPDATE loans SET status = 'Returned' WHERE id = ?");
    mysqli_stmt_bind_param($update_loan, "i", $loan_id);
    $loan_updated = mysqli_stmt_execute($update_loan);

    // Update book status to Available
    $update_book = mysqli_prepare($conn, "UPDATE books SET status = 'Available' WHERE id = ?");
    mysqli_stmt_bind_param($update_book, "i", $book_id);
    $book_updated = mysqli_stmt_execute($update_book);

    if ($loan_updated && $book_updated) {
        mysqli_commit($conn);
        header("Location: view_loans.php?msg=returned");
        exit();
    } else {
        mysqli_rollback($conn);
        echo "Error returning book: " . mysqli_error($conn);
    }
} else {
    header("Location: view_loans.php");
    exit();
}
?>