<?php
session_start();
require_once 'config.php';

// Already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = trim($_POST['name']             ?? '');
    $email           = trim($_POST['email']            ?? '');
    $password        = $_POST['password']              ?? '';
    $confirmPassword = $_POST['confirm_password']      ?? '';

    $errors = [];

    if (empty($name))     $errors[] = "Full name is required.";
    if (empty($email))    $errors[] = "Email address is required.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($password)) $errors[] = "Password is required.";
    elseif (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirmPassword) $errors[] = "Passwords do not match.";

    if (empty($errors)) {
        // Check for duplicate email
        $chk = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($chk, "s", $email);
        mysqli_stmt_execute($chk);
        mysqli_stmt_store_result($chk);

        if (mysqli_stmt_num_rows($chk) > 0) {
            mysqli_stmt_close($chk);
            mysqli_close($conn);
            header("Location: register.php?status=error&action=email_taken");
            exit();
        }
        mysqli_stmt_close($chk);

        // Insert new user
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $ins = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($ins, "sss", $name, $email, $hashed);

        if (mysqli_stmt_execute($ins)) {
            mysqli_stmt_close($ins);
            mysqli_close($conn);
            header("Location: login.php?status=success&action=register");
            exit();
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($ins);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — EduTrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card" style="max-width:480px;">

        <a href="index.php" class="auth-logo">
            <i class="fas fa-graduation-cap"></i> EduTrack
        </a>

        <h1 class="auth-title">Create your account</h1>
        <p class="auth-sub">Register to manage student records</p>

        <?php include 'includes/alerts.php'; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
                <i class="fas fa-exclamation-circle mt-1 flex-shrink-0"></i>
                <div>
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        <?php foreach ($errors as $e): ?>
                            <li><?php echo htmlspecialchars($e); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button type="button" class="btn-close ms-auto flex-shrink-0" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="mb-3">
                <label class="form-label" for="name"><i class="fas fa-user"></i> Full Name</label>
                <input type="text" id="name" name="name" class="form-control"
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                       placeholder="John Doe" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                       placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">
                    <i class="fas fa-lock"></i> Password
                    <span class="text-muted fw-normal" style="font-size:.8rem;"> (min. 6 chars)</span>
                </label>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>

            <div class="mb-4">
                <label class="form-label" for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                       placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>

        <p class="text-center mt-4 mb-0" style="font-size:.875rem;color:var(--muted);">
            Already have an account?
            <a href="login.php" style="color:var(--accent);font-weight:600;">Sign in</a>
        </p>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
