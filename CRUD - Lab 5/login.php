<?php
session_start();
require_once 'config.php';

// Already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: login.php?status=error&action=login&message=Email+and+password+are+required.");
        exit();
    }

    $sql  = "SELECT id, name, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        mysqli_close($conn);
        header("Location: index.php?status=success&action=login");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: login.php?status=error&action=login");
        exit();
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — EduTrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">

        <a href="index.php" class="auth-logo">
            <i class="fas fa-graduation-cap"></i> EduTrack
        </a>

        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Sign in to your account to continue</p>

        <?php include 'includes/alerts.php'; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label class="form-label" for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                       placeholder="you@example.com" required autofocus>
            </div>

            <div class="mb-4">
                <label class="form-label" for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <p class="text-center mt-4 mb-0" style="font-size:.875rem;color:var(--muted);">
            Don't have an account?
            <a href="register.php" style="color:var(--accent);font-weight:600;">Create one</a>
        </p>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
