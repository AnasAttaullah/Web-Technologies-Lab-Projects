<?php
session_start();
require_once 'config.php';

$errors = [];
$student = null;

// Get student ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch student data
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$student) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $course = trim($_POST['course']);

    // Validation
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($phone)) {
        $errors[] = "Phone is required";
    }
    if (empty($course)) {
        $errors[] = "Course is required";
    }

    // If no errors, update database
    if (empty($errors)) {
        $sql = "UPDATE students SET name = ?, email = ?, phone = ?, address = ?, course = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $phone, $address, $course, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?status=success&action=updated&id={$id}");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    
    // Update student array with submitted values
    $student['name'] = $name;
    $student['email'] = $email;
    $student['phone'] = $phone;
    $student['address'] = $address;
    $student['course'] = $course;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student — EduTrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="page-wrapper" style="max-width:700px;">

    <div class="page-heading">
        <a href="index.php" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>
        <h2>Edit Student</h2>
        <p>Updating record for <strong><?php echo htmlspecialchars($student['name']); ?></strong> &mdash; ID #<?php echo $student['id']; ?></p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
            <i class="fas fa-exclamation-circle mt-1 flex-shrink-0"></i>
            <div>
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <button type="button" class="btn-close ms-auto flex-shrink-0" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="">

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" for="name"><i class="fas fa-user"></i> Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="<?php echo htmlspecialchars($student['name']); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="email"><i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="phone"><i class="fas fa-phone"></i> Phone Number <span class="text-danger">*</span></label>
                    <input type="text" id="phone" name="phone" class="form-control"
                           value="<?php echo htmlspecialchars($student['phone']); ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label" for="course"><i class="fas fa-book-open"></i> Course <span class="text-danger">*</span></label>
                    <input type="text" id="course" name="course" class="form-control"
                           value="<?php echo htmlspecialchars($student['course']); ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label" for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" class="form-control" rows="3"><?php echo htmlspecialchars($student['address']); ?></textarea>
                </div>
            </div>

            <hr class="form-divider">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="index.php" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
