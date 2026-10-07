<?php
include "../includes/db.php";
$error = "";

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin = one("SELECT * FROM admins WHERE username=?", "s", [trim($_POST['username'])]);
    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        header("Location: dashboard.php");
        exit;
    }
    $error = "Wrong username or password.";
}
include "../includes/header.php";
?>
<h2>Admin Login</h2>
<?php if ($error) echo "<p>" . e($error) . "</p>"; ?>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<?php include "../includes/footer.php"; ?>
