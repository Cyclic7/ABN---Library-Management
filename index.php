<?php
include 'includes/header.php';
include 'config/db_connect.php';

// Get statistics
$total_books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM books"))['count'];
$total_members = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM members"))['count'];
$active_loans = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM loans WHERE status = 'Ongoing'"))['count'];
?>

<div class="dashboard">
    <div class="welcome-header">
        <h1>Dashboard</h1>
        <p>Welcome back! Here's what's happening at ABN Library.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-details">
                <span class="stat-number"><?= $total_books ?></span>
                <span class="stat-label">Total Books</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-details">
                <span class="stat-number"><?= $total_members ?></span>
                <span class="stat-label">Total Members</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📖</div>
            <div class="stat-details">
                <span class="stat-number"><?= $active_loans ?></span>
                <span class="stat-label">Active Loans</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="modules/books/add_book.php" class="quick-action-btn">➕ Add Book</a>
        <a href="modules/members/add_member.php" class="quick-action-btn">👤 Add Member</a>
        <a href="modules/loans/borrow_book.php" class="quick-action-btn">📤 Issue Loan</a>
        <a href="modules/loans/view_loans.php" class="quick-action-btn">📋 Manage Loans</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>