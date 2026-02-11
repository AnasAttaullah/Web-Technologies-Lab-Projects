<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $file = fopen("users.txt", "r");

    while (($line = fgets($file)) !== false) {

        $data = explode("|", trim($line));

        if ($data[2] == $username && password_verify($password, $data[3])) {

            $_SESSION["name"] = $data[0];
            $_SESSION["email"] = $data[1];
            $_SESSION["username"] = $data[2];
            $_SESSION["age"] = $data[4];

            header("Location: dashboard.php");
            exit();
        }
    }

    fclose($file);
    $message = "Invalid Username or Password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .card-body-custom {
            padding: 2rem;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color : white;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            color : white ;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="card-header-custom">
            <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
            <h3 class="mt-3 mb-0">Welcome Back</h3>
            <p class="mb-0 opacity-75">Login to your account</p>
        </div>
        <div class="card-body-custom">
            <?php if ($message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="bi bi-person-fill"></i> Username
                    </label>
                    <input type="text" class="form-control" id="username" name="username" required 
                           placeholder="Enter your username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill"></i> Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required
                           placeholder="Enter your password">
                </div>
                <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>
            
            <div class="text-center">
                <p class="mb-0 text-muted">Don't have an account?</p>
                <a href="signup.php" class="text-decoration-none fw-bold">Create Account</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
