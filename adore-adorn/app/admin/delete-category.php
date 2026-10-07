<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
csrf_check();
// products in this category will simply have no category (ON DELETE SET NULL)
q("DELETE FROM categories WHERE id=?", "i", [(int)($_POST['id'] ?? 0)]);
header("Location: categories.php");
exit;
