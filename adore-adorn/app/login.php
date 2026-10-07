<?php
include "includes/db.php";
$error = "";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $user = one("SELECT * FROM users WHERE email=?", "s", [$email]);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: products.php");
        exit;
    }
    $error = "Wrong email or password.";
}
include "includes/header.php";
?>
<h2>Login</h2>
<?php if (isset($_GET['registered'])) echo "<p class=\"notice success\">Registration successful. Please login.</p>"; ?>
<?php if ($error) echo "<p class=\"notice\">" . e($error) . "</p>"; ?>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<p>New here? <a href="register.php">Register</a></p>
<?php include "includes/footer.php"; ?>
