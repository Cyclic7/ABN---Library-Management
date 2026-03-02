<?php
include "../../config/db_connect.php";
include "../../includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: view_member.php");
    exit();
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM members WHERE id = $id");
$member = mysqli_fetch_assoc($result);

if (!$member) {
    header("Location: view_member.php");
    exit();
}
?>

<div class="container">
    <h2>Edit Member: <?= htmlspecialchars($member['full_name']) ?></h2>
    <form action="update_member.php" method="POST">
        <input type="hidden" name="id" value="<?= $member['id'] ?>">
        
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($member['full_name']) ?>" required>
        
        <label>Email Address</label>
        <input type="email" name="email" value="<?= htmlspecialchars($member['email']) ?>" required>
        
        <label>Phone Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($member['phone']) ?>">
        
        <label>Membership Type</label>
        <select name="membership_type" required>
            <option value="Student" <?= $member['membership_type'] == 'Student' ? 'selected' : '' ?>>Student</option>
            <option value="Faculty" <?= $member['membership_type'] == 'Faculty' ? 'selected' : '' ?>>Faculty</option>
            <option value="Guest" <?= $member['membership_type'] == 'Guest' ? 'selected' : '' ?>>Guest</option>
        </select>
        
        <label>Account Status</label>
        <select name="account_status" required>
            <option value="Active" <?= $member['account_status'] == 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Suspended" <?= $member['account_status'] == 'Suspended' ? 'selected' : '' ?>>Suspended</option>
        </select>
        
        <button type="submit" class="btn btn-add">Update Member</button>
        <a href="view_member.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>