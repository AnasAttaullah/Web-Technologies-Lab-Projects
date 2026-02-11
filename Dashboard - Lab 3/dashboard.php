<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-gradient);
            color: white;
            padding: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 1rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
        }
        
        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .content-area {
            padding: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .welcome-card {
            background: var(--primary-gradient);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }
        
        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 0 auto 1rem;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .info-item {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .badge-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0"><i class="bi bi-grid-fill"></i> Dashboard</h4>
            <small class="opacity-75">User Panel</small>
        </div>
        <ul class="sidebar-menu mt-3">
            <li>
                <a href="dashboard.php" class="active">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-person-fill me-2"></i> Profile
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-gear-fill me-2"></i> Settings
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-bell-fill me-2"></i> Notifications
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Welcome back, <?php echo $_SESSION["name"]; ?>! 👋</h5>
                    <small class="text-muted">Have a great day ahead</small>
                </div>
                <div>
                    <button class="btn btn-outline-secondary btn-sm me-2">
                        <i class="bi bi-bell"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-envelope"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Welcome Card -->
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">Hello, <?php echo $_SESSION["name"]; ?>! 🎉</h2>
                        <p class="mb-0 opacity-75">
                            Welcome to your personalized dashboard. Here you can view and manage your profile information.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <i class="bi bi-person-circle" style="font-size: 5rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <small class="text-muted d-block">Profile Status</small>
                                <h4 class="mb-0">Active</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="bi bi-calendar-check-fill text-white"></i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <small class="text-muted d-block">Member Since</small>
                                <h4 class="mb-0">2026</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="bi bi-shield-check-fill text-white"></i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <small class="text-muted d-block">Verification</small>
                                <h4 class="mb-0">Verified</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <i class="bi bi-star-fill text-white"></i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <small class="text-muted d-block">Rating</small>
                                <h4 class="mb-0">5.0</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="row">
                <div class="col-md-8">
                    <div class="profile-card">
                        <h5 class="mb-4">
                            <i class="bi bi-person-lines-fill me-2"></i>Profile Information
                        </h5>
                        <div class="info-item">
                            <div>
                                <i class="bi bi-person-fill text-primary me-2"></i>
                                <strong>Full Name</strong>
                            </div>
                            <span class="badge-custom"><?php echo $_SESSION["name"]; ?></span>
                        </div>
                        <div class="info-item">
                            <div>
                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                <strong>Email Address</strong>
                            </div>
                            <span><?php echo $_SESSION["email"]; ?></span>
                        </div>
                        <div class="info-item">
                            <div>
                                <i class="bi bi-at text-primary me-2"></i>
                                <strong>Username</strong>
                            </div>
                            <span><?php echo $_SESSION["username"]; ?></span>
                        </div>
                        <div class="info-item">
                            <div>
                                <i class="bi bi-calendar-fill text-primary me-2"></i>
                                <strong>Age</strong>
                            </div>
                            <span><?php echo $_SESSION["age"]; ?> years old</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="profile-card text-center">
                        <div class="profile-avatar">
                            <?php echo strtoupper(substr($_SESSION["name"], 0, 1)); ?>
                        </div>
                        <h5 class="mb-1"><?php echo $_SESSION["name"]; ?></h5>
                        <p class="text-muted mb-3">@<?php echo $_SESSION["username"]; ?></p>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-pencil-fill me-2"></i>Edit Profile
                            </button>
                            <a href="logout.php" class="btn btn-outline-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
