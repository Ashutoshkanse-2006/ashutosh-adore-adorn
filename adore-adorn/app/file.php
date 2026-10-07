<?php
// Serves an uploaded image stored in the database: /file.php?id=5
define('NO_SESSION', true);   // images don't need a login session
include "includes/db.php";
$id = (int) ($_GET['id'] ?? 0);
$f = one("SELECT mime, data FROM uploaded_files WHERE id=?", "i", [$id]);
if (!$f) { http_response_code(404); exit; }
header("Content-Type: " . $f['mime']);
header("Cache-Control: public, max-age=31536000, immutable");
echo $f['data'];
