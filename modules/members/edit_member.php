<?php
include "../../config/db_connect.php";
include "../../includes/header.php";
$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM members WHERE id = $id");
$member = mysqli_fetch_assoc($result);
?>
<div class="container">
    <h2>Edit Member: <?= htmlspecialchars($member['full_name']) ?></h2>
    <form action="update_member.php" method="POST">
        <input type="hidden" name="id" value="<?= $member['id'] ?>">
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($member['full_name']) ?>" required>
        
        <label>Status</label>
        <select name="account_status">
            <option value="Active" <?= $member['account_status'] == 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Suspended" <?= $member['account_status'] == 'Suspended' ? 'selected' : '' ?>>Suspended</option>
        </select>
        <button type="submit" class="btn btn-add">Update Member</button>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>