<?php
session_start();
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
    <title>Students — EduTrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="page-wrapper">

    <div class="page-heading d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h2>Students</h2>
            <p>All enrolled students in the system</p>
        </div>
        <a href="create.php" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Student
        </a>
    </div>

    <?php include 'includes/alerts.php'; ?>

    <div class="card">
        <div class="card-header-bar">
            <h5><i class="fas fa-table me-2 text-muted"></i>Student Records</h5>
            <span class="text-muted" style="font-size:.8rem;">
                <?php echo mysqli_num_rows($result); ?> student(s)
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Course</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-muted" style="font-size:.8rem;"><?php echo $row['id']; ?></td>
                                <td>
                                    <div style="font-weight:500;"><?php echo htmlspecialchars($row['name']); ?></div>
                                </td>
                                <td class="text-muted"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="text-muted"><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td class="text-muted" style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    <?php echo htmlspecialchars($row['address']); ?>
                                </td>
                                <td>
                                    <span class="badge-course"><?php echo htmlspecialchars($row['course']); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="update.php?id=<?php echo $row['id']; ?>"
                                           class="tbl-btn tbl-btn-edit" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                                           class="tbl-btn tbl-btn-delete" title="Delete"
                                           onclick="return confirm('Delete <?php echo addslashes(htmlspecialchars($row['name'])); ?>?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-user-graduate"></i>
                                    <p>No students yet — <a href="create.php" style="color:var(--accent);">add the first one</a>.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
