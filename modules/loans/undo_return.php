<?php
include "../../config/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['id'])) {
    header("Location: view_loans.php");
    exit();
}

$loan_id = (int)$_POST['id'];

// Start transaction
mysqli_begin_transaction($conn);

// Get loan details
$stmt = mysqli_prepare($conn, "SELECT book_id FROM loans WHERE id = ? AND status = 'Returned'");
mysqli_stmt_bind_param($stmt, "i", $loan_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$loan = mysqli_fetch_assoc($result);

if (!$loan) {
    mysqli_rollback($conn);
    header("Location: view_loans.php?msg=undo_failed");
    exit();
}

$book_id = $loan['book_id'];

// Check if the book is currently available (not borrowed elsewhere)
$check_book = mysqli_query($conn, "SELECT status FROM books WHERE id = $book_id");
$book = mysqli_fetch_assoc($check_book);

if ($book['status'] != 'Available') {
    mysqli_rollback($conn);
    header("Location: view_loans.php?msg=undo_failed");
    exit();
}

// Update loan status back to Ongoing
$update_loan = mysqli_prepare($conn, "UPDATE loans SET status = 'Ongoing' WHERE id = ?");
mysqli_stmt_bind_param($update_loan, "i", $loan_id);
$loan_updated = mysqli_stmt_execute($update_loan);

// Update book status to Borrowed
$update_book = mysqli_query($conn, "UPDATE books SET status = 'Borrowed' WHERE id = $book_id");

if ($loan_updated && $update_book) {
    mysqli_commit($conn);
    header("Location: view_loans.php?msg=undo_success");
} else {
    mysqli_rollback($conn);
    header("Location: view_loans.php?msg=undo_failed");
}
exit();
?>