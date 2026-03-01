<?php
include "../../config/db_connect.php";
include "../../includes/header.php";
$result = mysqli_query($conn, "SELECT * FROM members ORDER BY id DESC");
?>

<div class="container">
    <h2>👥 Library Members</h2>
    <a href="add_member.php" class="btn btn-add">+ Register New Member</a>

    <div class="card-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card" style="border-left-color: #9b59b6;">
                <h3><?= htmlspecialchars($row['full_name']) ?></h3>
                <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
                <p><strong>Type:</strong> <?= $row['membership_type'] ?></p>
                <p><strong>Status:</strong> <?= $row['account_status'] ?></p>
                <p><small>Joined: <?= $row['join_date'] ?></small></p>
                <hr>
                <a href="edit_member.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                <form action="delete_member.php" method="POST" style="display:inline; background:none; padding:0;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Remove this member?')">Delete</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>