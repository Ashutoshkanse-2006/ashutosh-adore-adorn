<?php
include "includes/db.php";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    if ($name == "" || $email == "" || $password == "") {
        $error = "Name, email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif (one("SELECT id FROM users WHERE email=?", "s", [$email])) {
        $error = "Email already registered.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        q("INSERT INTO users (name, email, password, phone) VALUES (?,?,?,?)", "ssss", [$name, $email, $hash, $phone]);
        header("Location: login.php?registered=1");
        exit;
    }
}
include "includes/header.php";
?>
<h2>Register</h2>
<?php if ($error) echo "<p class=\"notice\">" . e($error) . "</p>"; ?>
<form method="post">
    <input type="text" name="name" placeholder="Full name" value="<?= e($_POST['name'] ?? '') ?>" required><br>
    <input type="email" name="email" placeholder="Email" value="<?= e($_POST['email'] ?? '') ?>" required><br>
    <input type="text" name="phone" placeholder="Phone" value="<?= e($_POST['phone'] ?? '') ?>"><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login</a></p>
<?php include "includes/footer.php"; ?>
