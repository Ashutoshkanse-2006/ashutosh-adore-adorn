<?php
// Include AFTER db.php on admin pages (except admin/login.php)
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
