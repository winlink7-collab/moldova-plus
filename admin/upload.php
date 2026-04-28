<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

header('Content-Type: application/json; charset=utf-8');

$UPLOAD_DIR = __DIR__ . '/../assets/images/uploads/';
$ALLOWED    = ['image/jpeg','image/png','image/webp','image/gif'];
$MAX_SIZE   = 5 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image'])) {
    echo json_encode(['error' => 'Invalid request']); exit;
}

$f = $_FILES['image'];
if ($f['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Upload error ' . $f['error']]); exit;
}
if ($f['size'] > $MAX_SIZE) {
    echo json_encode(['error' => 'File too large (max 5MB)']); exit;
}
$mime = mime_content_type($f['tmp_name']);
if (!in_array($mime, $ALLOWED, true)) {
    echo json_encode(['error' => 'Allowed: JPG, PNG, WebP, GIF']); exit;
}

$ext  = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
$safe = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($f['name'], PATHINFO_FILENAME)));
$name = ($safe ?: 'img') . '_' . time() . '.' . $ext;

if (!is_dir($UPLOAD_DIR)) mkdir($UPLOAD_DIR, 0755, true);

if (move_uploaded_file($f['tmp_name'], $UPLOAD_DIR . $name)) {
    echo json_encode([
        'url'  => '../assets/images/uploads/' . $name,
        'name' => $name,
        'abs'  => '/assets/images/uploads/' . $name,
    ]);
} else {
    echo json_encode(['error' => 'Move failed — check folder permissions']);
}
