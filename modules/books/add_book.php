<?php include '../../includes/header.php'; ?>
<div class="container">
    <h2>Add New Book to Collection</h2>
    <form action="insert_book.php" method="POST">
        <label>Book Title:</label>
        <input type="text" name="title" required placeholder="e.g. The Great Gatsby">

        <label>Author:</label>
        <input type="text" name="author_name" required placeholder="e.g. F. Scott Fitzgerald">

        <label>ISBN:</label>
        <input type="text" name="isbn" required placeholder="13-digit code">

        <label>Category:</label>
        <input type="text" name="category_name" required placeholder="e.g. Fiction">

        <label>Published Year:</label>
        <input type="number" name="published_year" min="1000" max="2025" value="2023">

        <button type="submit" class="btn btn-add">Save Book</button>
        <a href="view_books.php" style="margin-left: 10px;">Cancel</a>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>