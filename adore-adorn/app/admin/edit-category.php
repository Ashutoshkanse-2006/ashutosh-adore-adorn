<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
$id = (int)($_GET['id'] ?? 0);
$c = one("SELECT * FROM categories WHERE id=?", "i", [$id]);
if (!$c) {
    header("Location: categories.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && trim($_POST['name']) != "") {
    q("UPDATE categories SET name=? WHERE id=?", "si", [trim($_POST['name']), $id]);
    header("Location: categories.php");
    exit;
}
include "../includes/header.php";
?>
<h2>Edit Category</h2>
<form method="post">
    <input type="text" name="name" value="<?= e($c['name']) ?>" required>
    <button type="submit">Save</button>
</form>
<?php include "../includes/footer.php"; ?>
