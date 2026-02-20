<?php
require_once 'config.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Delete student
$sql = "DELETE FROM students WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: index.php?message=Student deleted successfully!");
    exit();
} else {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: index.php?message=Error deleting student!");
    exit();
}
?>
