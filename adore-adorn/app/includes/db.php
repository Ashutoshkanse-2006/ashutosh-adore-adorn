<?php
// Database connection + helpers. Included at the top of every page.
// $conn and the (database-backed) session are created in session.php.
require_once __DIR__ . '/db_connect.php';
if (!isset($conn) || !($conn instanceof PgcConn)) {
    $conn = db_connect('adore_adorn');
}
require_once __DIR__ . '/session.php';

// $base makes links/images work from both the main folder and the admin folder
$inAdmin = basename(dirname($_SERVER['SCRIPT_NAME'])) == 'admin';
$base = $inAdmin ? '../' : '';

// Safe output (prevents HTML injection)
function e($text) {
    return htmlspecialchars($text ?? '');
}

// Run a query. Example: q("SELECT * FROM users WHERE id=?", "i", [5]);
// SELECT returns a result you can loop over; other queries return false.
function q($sql, $types = "", $params = []) {
    global $conn;
    $st = pgc_prepare($conn, $sql);
    if ($types != "") {
        pgc_stmt_bind_param($st, $types, ...$params);
    }
    pgc_stmt_execute($st);
    return pgc_stmt_get_result($st);
}

// Get all rows of a SELECT as an array
function rows($result) {
    return pgc_fetch_all($result);
}

// Get a single row (or null)
function one($sql, $types = "", $params = []) {
    return pgc_fetch_assoc(q($sql, $types, $params));
}

// Upload a product image. Vercel has no permanent disk, so the image is stored in the database
// (table uploaded_files) and served by file.php. Returns "db:<id>", '' if none chosen,
// or false if the file type is not allowed.
function uploadImage($file) {
    global $conn;
    if (!isset($file) || $file['error'] != 0) return '';
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) return false;
    $mimes = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp'];
    $data = file_get_contents($file['tmp_name']);
    q("INSERT INTO uploaded_files (filename, mime, data) VALUES (?,?,?)", "sss", [$file['name'], $mimes[$ext], $data]);
    return "db:" . pgc_insert_id($conn);
}

// Public URL of a product image. Old images are bundled files; new ones come from the database.
function imgUrl($image) {
    global $base;
    if (strpos($image, 'db:') === 0) return $base . 'file.php?id=' . (int) substr($image, 3);
    return $base . 'uploads/products/' . $image;
}

// Remove an image that was uploaded through the admin panel (bundled images are read-only).
function deleteImage($image) {
    if (strpos($image, 'db:') === 0) {
        q("DELETE FROM uploaded_files WHERE id=?", "i", [(int) substr($image, 3)]);
    }
}


// CSRF protection for state-changing admin actions (delete, etc.)
function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function csrf_field() { return '<input type="hidden" name="csrf" value="' . csrf_token() . '">'; }
function csrf_check() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(400);
        exit('Invalid request.');
    }
}
