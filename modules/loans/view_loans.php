<?php
include "../../config/db_connect.php";
include "../../includes/header.php";

$sql = "SELECT loans.*, books.title AS book_title, members.full_name AS member_name " .
        "FROM loans " .
        "LEFT JOIN books ON loans.book_id = books.id " .
        "LEFT JOIN members ON loans.member_id = members.id " .
        "ORDER BY loans.loan_date DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h2>📄 Loan Management</h2>
    <a href="borrow_book.php" class="btn btn-add">New Loan</a>

    <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-dismissible" id="auto-alert">
        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
        <?php 
            $message = '';
            if ($_GET['msg'] == 'loaned') $message = "Book loaned successfully!";
            if ($_GET['msg'] == 'returned') $message = "Book returned successfully!";
            if ($_GET['msg'] == 'deleted') $message = "Loan record deleted.";
            if ($_GET['msg'] == 'updated') $message = "Loan updated successfully!";
            if ($_GET['msg'] == 'edit_not_allowed') $message = "You can only edit ongoing loans.";
            if ($_GET['msg'] == 'edit_failed') $message = "Failed to update loan. It may no longer be ongoing.";
            if ($_GET['msg'] == 'undo_success') $message = "Loan reverted to ongoing successfully!";
            if ($_GET['msg'] == 'undo_failed') $message = "Could not undo return. The book may be already borrowed.";
            echo $message;
        ?>
    </div>
    <script>
        setTimeout(function() {
            var alert = document.getElementById('auto-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000);
    </script>
<?php endif; ?>

    <div class="card-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="card" style="border-left-color: <?= $row['status'] == 'Ongoing' ? '#e74c3c' : '#2ecc71' ?>;">
                <p><strong>Book:</strong> <?= htmlspecialchars($row['book_title']) ?></p>
                <p><strong>Member:</strong> <?= htmlspecialchars($row['member_name']) ?></p>
                <p><strong>Loan Date:</strong> <?= $row['loan_date'] ?></p>
                <p><strong>Return Deadline:</strong> <?= $row['return_deadline'] ?></p>
                <p><strong>Status:</strong> 
                    <span style="color: <?= $row['status'] == 'Ongoing' ? '#e74c3c' : '#27ae60' ?>; font-weight: bold;">
                        <?= $row['status'] ?>
                    </span>
                </p>
                <hr>
                <?php if ($row['status'] == 'Ongoing'): ?>
                    <a href="edit_loan.php?id=<?= $row['id'] ?>" class="btn btn-edit" style="margin-right: 5px;">✏️ Edit</a>
                    <form action="return_loan.php" method="POST" style="display:inline; background:none; padding:0;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-edit" onclick="return confirm('Mark this book as returned?')">↩ Return</button>
                    </form>
                <?php endif; ?>

                <?php if ($row['status'] == 'Returned'): ?>
                    <form action="undo_return.php" method="POST" style="display:inline; background:none; padding:0;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-edit" onclick="return confirm('Revert this loan to ongoing? This will mark the book as borrowed again.')">↩ Undo Return</button>
                    </form>
                <?php endif; ?>

                <form action="delete_loan.php" method="POST" style="display:inline; background:none; padding:0;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this loan record? This action cannot be undone.')">🗑 Delete</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>