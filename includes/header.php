<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABN Library Management System</title>
    <link rel="stylesheet" href="/Aleria_IM302/library_system/assets/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/Aleria_IM302/library_system/index.php" class="nav-brand">
                <span class="brand-icon"></span>
                <span class="brand-text">ABN Library</span>
            </a>
            <ul class="nav-menu">
                <li class="nav-item <?= $current_page == 'index.php' ? 'active' : '' ?>">
                    <a href="/Aleria_IM302/library_system/index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item <?= strpos($current_page, 'books') !== false ? 'active' : '' ?>">
                    <a href="/Aleria_IM302/library_system/modules/books/view_books.php" class="nav-link">Books</a>
                </li>
                <li class="nav-item <?= strpos($current_page, 'member') !== false ? 'active' : '' ?>">
                    <a href="/Aleria_IM302/library_system/modules/members/view_member.php" class="nav-link">Members</a>
                </li>
                <li class="nav-item <?= strpos($current_page, 'loans') !== false ? 'active' : '' ?>">
                    <a href="/Aleria_IM302/library_system/modules/loans/view_loans.php" class="nav-link">Loans</a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="main-content">