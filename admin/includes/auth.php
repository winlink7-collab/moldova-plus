<?php
define('ADMIN_PASS_FILE', __DIR__ . '/../../data/admin_pass.php');
define('ADMIN_TOKEN', 'admin_token');

ini_set('session.cookie_lifetime', 86400 * 30);
ini_set('session.gc_maxlifetime', 86400 * 30);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function mp_admin_check(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $has_cookie = !empty($_COOKIE[ADMIN_TOKEN]);
    $has_session = !empty($_SESSION['mp_admin_ok']);

    if (!$has_cookie && !$has_session) {
        header('Location: login.php?return=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function mp_admin_url(string $page = ''): string {
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    if (substr($base, -6) !== '/admin') {
        $base = dirname($base);
    }
    return $base . ($page ? '/' . $page : '');
}

function mp_data_path(string $file): string {
    return __DIR__ . '/../../data/' . $file;
}

function mp_read_json(string $file): array {
    $path = mp_data_path($file);
    if (!file_exists($path)) return [];
    return json_decode(file_get_contents($path), true) ?? [];
}

function mp_write_json(string $file, array $data): bool {
    $path = mp_data_path($file);
    return (bool) file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function mp_get_pass(): string {
    if (file_exists(ADMIN_PASS_FILE)) {
        $p = include ADMIN_PASS_FILE;
        return is_string($p) ? $p : '';
    }
    return '$2y$10$.IAFajs8RnDSoGpRBiNJauxqsmjsk6iqD7TXYFTyKYO/jrYNA2fvq';
}

function mp_csrf(): string {
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function mp_csrf_verify(): bool {
    if (empty($_POST['csrf'])) {
        return false;
    }
    $token = $_POST['csrf'];
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }

    $stored = $_SESSION['csrf'] ?? '';
    if (!empty($stored) && hash_equals($token, $stored)) {
        return true;
    }

    return false;
}
