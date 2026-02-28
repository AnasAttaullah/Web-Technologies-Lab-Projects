<?php
/**
 * URL-Based Bootstrap 5 Alert System
 *
 * Reads the following GET parameters:
 *   status  — success | error | warning | info
 *   action  — created | updated | deleted | login | logout | register
 *   id      — student ID (optional, shown in message)
 *   message — custom override message (optional)
 */

$_alert = null;

if (isset($_GET['status'])) {
    $alertStatus  = htmlspecialchars(strip_tags($_GET['status']));
    $alertAction  = isset($_GET['action'])  ? htmlspecialchars(strip_tags($_GET['action']))  : '';
    $alertId      = isset($_GET['id'])      ? intval($_GET['id'])                            : null;
    $alertMessage = isset($_GET['message']) ? htmlspecialchars(strip_tags($_GET['message'])) : '';

    // Bootstrap alert class
    $bsClass = match($alertStatus) {
        'success' => 'success',
        'error'   => 'danger',
        'warning' => 'warning',
        'info'    => 'info',
        default   => 'secondary',
    };

    // Icon per status
    $iconClass = match($alertStatus) {
        'success' => 'fas fa-check-circle',
        'error'   => 'fas fa-times-circle',
        'warning' => 'fas fa-exclamation-triangle',
        default   => 'fas fa-info-circle',
    };

    // Auto-generate message when none is provided
    if (empty($alertMessage)) {
        $idLabel = $alertId ? " <strong>(ID: #{$alertId})</strong>" : '';

        $alertMessage = match("{$alertStatus}:{$alertAction}") {
            'success:created'  => "Student{$idLabel} was successfully created.",
            'success:updated'  => "Student{$idLabel} was successfully updated.",
            'success:deleted'  => "Student{$idLabel} was successfully deleted.",
            'error:created'    => "Failed to create the student. Please try again.",
            'error:updated'    => "Failed to update student{$idLabel}. Please try again.",
            'error:deleted'    => "Failed to delete student{$idLabel}. Please try again.",
            'success:login'    => "Welcome back! You have logged in successfully.",
            'error:login'      => "Invalid email or password. Please try again.",
            'success:logout'   => "You have been logged out successfully.",
            'success:register' => "Account created successfully! You can now log in.",
            'error:register'   => "Registration failed. Please try again.",
            'error:email_taken'=> "That email address is already registered. Please use a different one.",
            default            => "Operation completed.",
        };
    }

    $_alert = [
        'class'   => $bsClass,
        'icon'    => $iconClass,
        'message' => $alertMessage,
    ];
}
?>

<?php if ($_alert): ?>
<div class="alert alert-<?= $_alert['class'] ?> alert-dismissible fade show d-flex align-items-start gap-2 shadow-sm" role="alert">
    <i class="<?= $_alert['icon'] ?> mt-1 fs-5 flex-shrink-0"></i>
    <div class="flex-grow-1"><?= $_alert['message'] ?></div>
    <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
