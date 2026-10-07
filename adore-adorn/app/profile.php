<?php
include "includes/db.php";
include "includes/auth.php";
$uid = $_SESSION['user_id'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $newPass = $_POST['new_password'];

    if ($name == "") {
        $msg = "Name cannot be empty.";
    } elseif ($newPass != "" && strlen($newPass) < 6) {
        $msg = "New password must be at least 6 characters.";
    } else {
        q("UPDATE users SET name=?, phone=?, address=? WHERE id=?", "sssi", [$name, $phone, $address, $uid]);
        if ($newPass != "") {
            q("UPDATE users SET password=? WHERE id=?", "si", [password_hash($newPass, PASSWORD_DEFAULT), $uid]);
        }
        $_SESSION['user_name'] = $name;
        $msg = "Profile updated.";
    }
}

$user = one("SELECT * FROM users WHERE id=?", "i", [$uid]);
include "includes/header.php";
?>
<h2>My Profile</h2>
<?php if ($msg) echo "<p class=\"notice success\">" . e($msg) . "</p>"; ?>
<p>Email: <?= e($user['email']) ?></p>
<form method="post">
    <input type="text" name="name" value="<?= e($user['name']) ?>" required><br>
    <input type="text" name="phone" placeholder="Phone" value="<?= e($user['phone']) ?>"><br>
    <textarea name="address" placeholder="Address"><?= e($user['address']) ?></textarea><br>
    <input type="password" name="new_password" placeholder="New password (leave blank to keep)"><br>
    <button type="submit">Save</button>
</form>
<?php include "includes/footer.php"; ?>
