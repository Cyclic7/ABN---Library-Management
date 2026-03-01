<?php
include "../../config/db_connect.php";
include "../../includes/header.php";
$result = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");
?>

<div class="container">
    <h2>📚 Book Inventory</h2>
    <a href="add_book.php" class="btn btn-add">+ Add New Book</a>

    <div class="card-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author_name'] ?? 'N/A'); ?></p>
                <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category_name'] ?? 'N/A'); ?></p>
                <p><strong>Year:</strong> <?php echo $row['published_year']; ?></p>
                <p><strong>Status:</strong> 
                    <span style="color: <?php echo ($row['status'] == 'Available') ? 'green' : 'red'; ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </p>
                <hr>
                <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                <form action="delete_book.php" method="POST" style="display:inline; background:none; padding:0;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Remove this book?')">Delete</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>