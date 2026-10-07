<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
csrf_check();
$id = (int)($_POST['id'] ?? 0);
$p = one("SELECT image FROM products WHERE id=?", "i", [$id]);
if ($p) {
    if ($p['image']) deleteImage($p['image']);
    q("DELETE FROM products WHERE id=?", "i", [$id]);
}
header("Location: products.php");
exit;
