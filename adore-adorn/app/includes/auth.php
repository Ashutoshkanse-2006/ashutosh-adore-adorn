<?php
// Include AFTER db.php on pages that need a logged-in user
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
