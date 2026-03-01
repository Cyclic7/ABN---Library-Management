<?php
// Note: You must create the database 'library_db' in phpMyAdmin first!
include "../config/db_connect.php"; 

// drop tables to rebuild with new relationships
mysqli_query($conn, "DROP TABLE IF EXISTS loans");
mysqli_query($conn, "DROP TABLE IF EXISTS books");
mysqli_query($conn, "DROP TABLE IF EXISTS members");
mysqli_query($conn, "DROP TABLE IF EXISTS authors");
mysqli_query($conn, "DROP TABLE IF EXISTS categories");

// 1. Authors table (6 columns)
$sql_authors = "CREATE TABLE IF NOT EXISTS authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    birth_year INT,
    nationality VARCHAR(50),
    biography TEXT
)";

// 2. Categories table (6 columns)
$sql_categories = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('Active','Inactive') DEFAULT 'Active'
)";

// 3. Books Table with string fields for author and category (no foreign keys)
$sql_books = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_name VARCHAR(100),
    isbn VARCHAR(20) NOT NULL,
    category_name VARCHAR(100),
    published_year INT,
    status ENUM('Available', 'Borrowed') DEFAULT 'Available'
)";

// 4. Members Table (7 Columns)
$sql_members = "CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    membership_type ENUM('Student', 'Faculty', 'Guest'),
    join_date DATE DEFAULT CURRENT_DATE,
    account_status ENUM('Active', 'Suspended') DEFAULT 'Active'
)";

// 5. Loans Table (Relationship Table - 6 Columns)
$sql_loans = "CREATE TABLE IF NOT EXISTS loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT,
    member_id INT,
    loan_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    return_deadline DATE,
    status ENUM('Ongoing', 'Returned') DEFAULT 'Ongoing',
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
)";

// Execute queries using the mysqli_query pattern from your reference
$tables = [
    "authors" => $sql_authors,
    "categories" => $sql_categories,
    "books" => $sql_books, 
    "members" => $sql_members, 
    "loans" => $sql_loans
];

foreach ($tables as $name => $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Table '$name' created successfully.<br>";
    } else {
        echo "Error creating table '$name': " . mysqli_error($conn) . "<br>";
    }
}

mysqli_close($conn);
?>