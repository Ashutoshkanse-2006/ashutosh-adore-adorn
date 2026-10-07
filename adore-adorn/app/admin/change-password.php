<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
$msg = ""; $ok = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    csrf_check();
    $admin = one("SELECT * FROM admins WHERE id=?", "i", [(int)$_SESSION['admin_id']]);
    $new = $_POST['new_password'] ?? '';
    if (!$admin || !password_verify($_POST['current_password'] ?? '', $admin['password'])) {
        $msg = "Current password is incorrect.";
    } elseif (strlen($new) < 6) {
        $msg = "New password must be at least 6 characters.";
    } elseif ($new !== ($_POST['confirm_password'] ?? '')) {
        $msg = "New passwords do not match.";
    } else {
        q("UPDATE admins SET password=? WHERE id=?", "si", [password_hash($new, PASSWORD_DEFAULT), (int)$_SESSION['admin_id']]);
        $ok = true; $msg = "Password changed.";
    }
}
include "../includes/header.php";
?>
<h2>Change Password</h2>
<?php if ($msg) echo '<p style="color:' . ($ok ? '#067647' : '#b42318') . '">' . e($msg) . '</p>'; ?>
<form method="post">
    <?= csrf_field() ?>
    <input type="password" name="current_password" placeholder="Current password" required><br>
    <input type="password" name="new_password" placeholder="New password" minlength="6" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm new password" minlength="6" required><br>
    <button type="submit">Change Password</button>
</form>
<?php include "../includes/footer.php"; ?>
