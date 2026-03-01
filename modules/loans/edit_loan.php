<?php
include "../../config/db_connect.php";
include "../../includes/header.php";

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: view_loans.php");
    exit();
}

$loan_id = (int)$_GET['id'];

// Fetch loan details
$stmt = mysqli_prepare($conn, "SELECT * FROM loans WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $loan_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$loan = mysqli_fetch_assoc($result);

if (!$loan) {
    header("Location: view_loans.php");
    exit();
}

// Only allow editing ongoing loans
if ($loan['status'] != 'Ongoing') {
    header("Location: view_loans.php?msg=edit_not_allowed");
    exit();
}

// Fetch available books and active members for dropdowns
$books = mysqli_query($conn, "SELECT id, title FROM books WHERE status = 'Available' OR id = " . $loan['book_id']);
$members = mysqli_query($conn, "SELECT id, full_name FROM members WHERE account_status = 'Active'");
?>

<div class="container">
    <h2>Edit Loan #<?= $loan['id'] ?></h2>
    <form action="update_loan.php" method="POST">
        <input type="hidden" name="id" value="<?= $loan['id'] ?>">

        <label>Select Member:</label>
        <select name="member_id" required>
            <?php while($m = mysqli_fetch_assoc($members)): ?>
                <option value="<?= $m['id'] ?>" <?= $m['id'] == $loan['member_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['full_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Select Book:</label>
        <select name="book_id" required>
            <?php 
            mysqli_data_seek($books, 0); // Reset pointer
            while($b = mysqli_fetch_assoc($books)): ?>
                <option value="<?= $b['id'] ?>" <?= $b['id'] == $loan['book_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($b['title']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Return Deadline:</label>
        <input type="date" name="return_deadline" value="<?= $loan['return_deadline'] ?>" required>

        <button type="submit" class="btn btn-add">Update Loan</button>
        <a href="view_loans.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>