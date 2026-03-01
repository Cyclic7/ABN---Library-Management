<?php include 'includes/header.php'; ?>

<div class="welcome-container">
    <div class="welcome-message">
        <h1>Welcome to ABN Library</h1>
        <p class="tagline">Your central hub for library management</p>
        <p class="description">
            Easily manage your book inventory, member registrations, and loan transactions.
            Use the navigation menu above or the quick links below to get started.
        </p>
    </div>

    <div class="quick-access">
        <a href="modules/books/view_books.php" class="access-card">
            <span class="access-icon">📘</span>
            <span class="access-title">Books</span>
            <span class="access-desc">View, add, edit, or delete books</span>
        </a>
        <a href="modules/members/view_member.php" class="access-card">
            <span class="access-icon">👥</span>
            <span class="access-title">Members</span>
            <span class="access-desc">Manage library members</span>
        </a>
        <a href="modules/loans/view_loans.php" class="access-card">
            <span class="access-icon">📄</span>
            <span class="access-title">Loans</span>
            <span class="access-desc">Track book loans and returns</span>
        </a>
    </div>

    <div class="info-box">
        <p>Need help? Check the documentation or contact your system administrator.</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>