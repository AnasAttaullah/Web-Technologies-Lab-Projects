<?php
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
            header("Location: index.php?message=Student updated successfully!");
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
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-user-edit"></i> Edit Student</h1>
            <p>Update student information below</p>
        </header>

        <div class="actions">
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name *</label>
                    <input type="text" id="name" name="name" 
                           value="<?php echo htmlspecialchars($student['name']); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address *</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($student['email']); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone Number *</label>
                    <input type="text" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($student['phone']); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($student['address']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="course"><i class="fas fa-book"></i> Course *</label>
                    <input type="text" id="course" name="course" 
                           value="<?php echo htmlspecialchars($student['course']); ?>" 
                           required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Student
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
