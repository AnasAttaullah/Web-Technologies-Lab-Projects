<?php
require_once 'config.php';

$errors = [];
$success = false;

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

    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO students (name, email, phone, address, course) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $address, $course);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?message=Student added successfully!");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-user-plus"></i> Add New Student</h1>
            <p>Fill in the details below to add a new student</p>
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
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address *</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone Number *</label>
                    <input type="text" id="phone" name="phone" 
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="course"><i class="fas fa-book"></i> Course *</label>
                    <input type="text" id="course" name="course" 
                           value="<?php echo isset($_POST['course']) ? htmlspecialchars($_POST['course']) : ''; ?>" 
                           required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Student
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
