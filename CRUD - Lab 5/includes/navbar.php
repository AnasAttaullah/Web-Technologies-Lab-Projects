<nav class="topbar">
    <a href="index.php" class="topbar-brand">
        <i class="fas fa-graduation-cap"></i> EduTrack
    </a>
    <div class="topbar-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="topbar-user d-none d-sm-flex">
                <i class="fas fa-user-circle"></i>
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </span>
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-sign-out-alt"></i>
                <span class="d-none d-sm-inline">Logout</span>
            </a>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="register.php" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus"></i> Register
            </a>
        <?php endif; ?>
    </div>
</nav>
