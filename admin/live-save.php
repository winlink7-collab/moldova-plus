<?php
// Live Visual Editor — AJAX save endpoint
session_start();
header('Content-Type: application/json; charset=utf-8');

// Must be admin
if (empty($_SESSION['mp_admin_ok'])) {
    echo json_encode(['ok' => false, 'error' => 'unauthorized']);
    exit;
}

require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'method']);
    exit;
}

if (!mp_csrf_verify()) {
    echo json_encode(['ok' => false, 'error' => 'csrf']);
    exit;
}

$key   = trim($_POST['key']   ?? '');
$value = $_POST['value']      ?? '';
$type  = $_POST['type']       ?? 'text';

// Sanitize by type
if ($type === 'text') {
    $value = strip_tags(trim($value));
} elseif ($type === 'img') {
    $value = trim($value);
    if ($value !== '' && !preg_match('#^(https?://|\.\./|/?assets/)#i', $value)) {
        echo json_encode(['ok' => false, 'error' => 'invalid_url']);
        exit;
    }
} elseif ($type === 'gallery') {
    $arr = json_decode($value, true);
    if (!is_array($arr)) $arr = [];
    $value = array_values(array_filter($arr, fn($v) => is_string($v) && $v !== ''));
}

// Parse key: "file:field" or "file:id:field"
$parts = explode(':', $key, 3);
$file  = $parts[0] ?? '';

$allowed = ['settings', 'deal', 'hotels', 'packages', 'attractions', 'articles', 'faq', 'reviews'];
if (!in_array($file, $allowed, true)) {
    echo json_encode(['ok' => false, 'error' => 'bad_file']);
    exit;
}

$data = mp_read_json($file . '.json');

switch ($file) {
    case 'settings':
    case 'deal':
        // format: "file:field"
        $field = $parts[1] ?? '';
        if (!$field) { echo json_encode(['ok' => false, 'error' => 'no_field']); exit; }
        $data[$field] = $value;
        break;

    case 'hotels':
    case 'attractions':
        // format: "file:id:field" — find item by id in array
        $id    = $parts[1] ?? '';
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        $found = false;
        foreach ($data as &$item) {
            if ((string)($item['id'] ?? '') === $id) {
                $item[$field] = $value;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) { echo json_encode(['ok' => false, 'error' => 'not_found']); exit; }
        break;

    case 'packages':
        // packages.json is an override map: {"1": {field: val}, "2": {...}}
        // format: "packages:id:field"
        $id    = $parts[1] ?? '';
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        if (!isset($data[$id])) $data[$id] = [];
        $data[$id][$field] = $value;
        break;

    case 'articles':
        // format: "articles:slug:field" — upsert by id
        $id    = $parts[1] ?? '';
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        $found = false;
        foreach ($data as &$item) {
            if (($item['id'] ?? '') === $id) {
                $item[$field] = $value;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) { $data[] = ['id' => $id, $field => $value]; }
        break;

    case 'faq':
        // format: "faq:id:field"
        $id    = (int)($parts[1] ?? 0);
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        foreach ($data as &$item) {
            if ((int)($item['id'] ?? 0) === $id) {
                $item[$field] = $value;
                break;
            }
        }
        unset($item);
        break;

    case 'reviews':
        // format: "reviews:id:field"
        $id    = (int)($parts[1] ?? 0);
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        foreach ($data as &$item) {
            if ((int)($item['id'] ?? 0) === $id) {
                $item[$field] = $value;
                break;
            }
        }
        unset($item);
        break;
}

$ok = mp_write_json($file . '.json', $data);
echo json_encode(['ok' => $ok, 'error' => $ok ? null : 'write_failed']);
