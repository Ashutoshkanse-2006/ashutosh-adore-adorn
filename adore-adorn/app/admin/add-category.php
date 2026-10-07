<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && trim($_POST['name']) != "") {
    q("INSERT INTO categories (name) VALUES (?)", "s", [trim($_POST['name'])]);
    header("Location: categories.php");
    exit;
}
include "../includes/header.php";
?>
<h2>Add Category</h2>
<form method="post">
    <input type="text" name="name" placeholder="Category name" required>
    <button type="submit">Add</button>
</form>
<?php include "../includes/footer.php"; ?>
