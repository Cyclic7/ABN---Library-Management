<?php
include "../../config/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['id'])) {
    header("Location: view_loans.php");
    exit();
}

$loan_id = (int)$_POST['id'];
$member_id = (int)$_POST['member_id'];
$book_id = (int)$_POST['book_id'];
$return_deadline = $_POST['return_deadline'];

// Start transaction
mysqli_begin_transaction($conn);

// Check if the loan still exists and is ongoing
$check_loan = mysqli_prepare($conn, "SELECT status, book_id FROM loans WHERE id = ? FOR UPDATE");
mysqli_stmt_bind_param($check_loan, "i", $loan_id);
mysqli_stmt_execute($check_loan);
$result = mysqli_stmt_get_result($check_loan);
$loan = mysqli_fetch_assoc($result);

if (!$loan || $loan['status'] != 'Ongoing') {
    mysqli_rollback($conn);
    header("Location: view_loans.php?msg=edit_failed");
    exit();
}

$old_book_id = $loan['book_id'];

// If book is being changed, check new book availability
if ($book_id != $old_book_id) {
    $check_book = mysqli_query($conn, "SELECT status FROM books WHERE id = $book_id");
    $new_book = mysqli_fetch_assoc($check_book);
    if ($new_book['status'] != 'Available') {
        mysqli_rollback($conn);
        header("Location: edit_loan.php?id=$loan_id&error=book_unavailable");
        exit();
    }
}

// Update the loan
$update_loan = mysqli_prepare($conn, "UPDATE loans SET member_id = ?, book_id = ?, return_deadline = ? WHERE id = ?");
mysqli_stmt_bind_param($update_loan, "iisi", $member_id, $book_id, $return_deadline, $loan_id);
$updated = mysqli_stmt_execute($update_loan);

if ($updated) {
    // If book changed, update statuses of old and new books
    if ($book_id != $old_book_id) {
        // Old book becomes Available
        mysqli_query($conn, "UPDATE books SET status = 'Available' WHERE id = $old_book_id");
        // New book becomes Borrowed
        mysqli_query($conn, "UPDATE books SET status = 'Borrowed' WHERE id = $book_id");
    }
    mysqli_commit($conn);
    header("Location: view_loans.php?msg=updated");
} else {
    mysqli_rollback($conn);
    header("Location: edit_loan.php?id=$loan_id&error=update_failed");
}
exit();
?>