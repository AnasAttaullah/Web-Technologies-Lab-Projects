<?php
// Database setup script
$host = 'localhost';
$user = 'root';
$pass = '';

// Connect without selecting a database
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully<br>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS student_crud";
if (mysqli_query($conn, $sql)) {
    echo "Database 'student_crud' created successfully<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select the database
mysqli_select_db($conn, 'student_crud');

// Create table
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    course VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'students' created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Insert sample data
$sql = "INSERT INTO students (name, email, phone, address, course) VALUES
('John Doe', 'john.doe@example.com', '123-456-7890', '123 Main St, City', 'Computer Science'),
('Jane Smith', 'jane.smith@example.com', '098-765-4321', '456 Oak Ave, Town', 'Engineering'),
('Mike Johnson', 'mike.johnson@example.com', '555-123-4567', '789 Pine Rd, Village', 'Mathematics')
ON DUPLICATE KEY UPDATE name=name";

if (mysqli_query($conn, $sql)) {
    echo "Sample data inserted successfully<br>";
} else {
    echo "Error inserting data: " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);

echo "<br><strong style='color: green;'>✅ Setup completed! You can now <a href='index.php'>go to the main page</a></strong>";
?>
