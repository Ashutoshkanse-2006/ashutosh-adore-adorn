<?php
include "../includes/db.php";
include "../includes/admin-auth.php";
csrf_check();
// cart and orders are removed with the user (ON DELETE CASCADE)
q("DELETE FROM users WHERE id=?", "i", [(int)($_POST['id'] ?? 0)]);
header("Location: users.php");
exit;
