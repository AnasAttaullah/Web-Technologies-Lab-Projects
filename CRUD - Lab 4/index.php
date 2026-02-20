<?php
require_once 'config.php';

// Fetch all students
$sql = "SELECT * FROM students ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-graduation-cap"></i> Student Management System</h1>
            <p>Manage your student records efficiently</p>
        </header>

        <div class="actions">
            <a href="create.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Student
            </a>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><span class="course-badge"><?php echo htmlspecialchars($row['course']); ?></span></td>
                                <td class="actions-cell">
                                    <a href="update.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                       class="btn-action btn-delete" 
                                       title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this student?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-data">
                                <i class="fas fa-inbox"></i>
                                <p>No students found. Add your first student!</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
