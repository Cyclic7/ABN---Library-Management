<?php
include "../../config/db_connect.php";
include "../../includes/header.php";

if (!isset($_GET['id'])) {
    die("Missing book ID.");
}
$id = (int)$_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM books WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    die("Book not found.");
}
?>

<div class="container">
    <h2>Edit Book: <?= htmlspecialchars($book['title']) ?></h2>
    <form action="update_book.php" method="POST">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

        <label>Author</label>
        <input type="text" name="author_name" value="<?= htmlspecialchars($book['author_name'] ?? '') ?>" required>

        <label>ISBN</label>
        <input type="text" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required>

        <label>Category</label>
        <input type="text" name="category_name" value="<?= htmlspecialchars($book['category_name'] ?? '') ?>" required>

        <label>Published Year</label>
        <input type="number" name="published_year" value="<?= $book['published_year'] ?>" min="1000" max="2025" required>

        <label>Status</label>
        <select name="status">
            <option value="Available" <?= $book['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Borrowed" <?= $book['status'] == 'Borrowed' ? 'selected' : '' ?>>Borrowed</option>
        </select>

        <button type="submit" class="btn btn-add">Update Book</button>
        <a href="view_books.php">Cancel</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>