<?php
include "../../config/db_connect.php";
include "../../includes/header.php";
$books = mysqli_query($conn, "SELECT id, title FROM books WHERE status = 'Available'");
$members = mysqli_query($conn, "SELECT id, full_name FROM members WHERE account_status = 'Active'");
?>
<div class="container">
    <h2>📖 Issue a New Loan</h2>
    <form action="insert_loan.php" method="POST">
        <label>Select Member:</label>
        <select name="member_id" required>
            <?php while($m = mysqli_fetch_assoc($members)): ?>
                <option value="<?= $m['id'] ?>"><?= $m['full_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Select Book:</label>
        <select name="book_id" required>
            <?php while($b = mysqli_fetch_assoc($books)): ?>
                <option value="<?= $b['id'] ?>"><?= $b['title'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Return Deadline:</label>
        <input type="date" name="return_deadline" required>

        <button type="submit" class="btn btn-add">Confirm Loan</button>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>