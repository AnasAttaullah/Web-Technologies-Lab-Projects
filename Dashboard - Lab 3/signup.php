<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $age = $_POST["age"];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $file = fopen("users.txt", "a");

    $data = $name . "|" . $email . "|" . $username . "|" . $password . "|" . $age . "\n";

    fwrite($file, $data);
    fclose($file);

    $message = "Signup successful! <a href='login.php'>Login Here</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Dashboard App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .signup-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 500px;
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
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <div class="card-header-custom">
            <i class="bi bi-person-plus-fill" style="font-size: 3rem;"></i>
            <h3 class="mt-3 mb-0">Create Account</h3>
            <p class="mb-0 opacity-75">Join us today</p>
        </div>
        <div class="card-body-custom">
            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person-fill"></i> Full Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name" required 
                               placeholder="John Doe">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">
                            <i class="bi bi-calendar-fill"></i> Age
                        </label>
                        <input type="number" class="form-control" id="age" name="age" required 
                               placeholder="25" min="1" max="150">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope-fill"></i> Email Address
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required
                           placeholder="john@example.com">
                </div>
                
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="bi bi-at"></i> Username
                    </label>
                    <input type="text" class="form-control" id="username" name="username" required 
                           placeholder="johndoe">
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill"></i> Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required
                           placeholder="Create a strong password">
                </div>
                
                <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                    <i class="bi bi-person-check-fill"></i> Create Account
                </button>
            </form>
            
            <div class="text-center">
                <p class="mb-0 text-muted">Already have an account?</p>
                <a href="login.php" class="text-decoration-none fw-bold">Login Here</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
