<?php
require_once __DIR__ . '/includes/auth.php';

if (session_status() === PHP_SESSION_NONE) session_start();

echo '<pre>';
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'ACTIVE' : 'INACTIVE') . "\n";
echo "Session ID: " . session_id() . "\n";
echo "mp_admin_ok: " . (!empty($_SESSION['mp_admin_ok']) ? 'YES' : 'NO') . "\n";
echo "CSRF: " . (!empty($_SESSION['csrf']) ? 'YES' : 'NO') . "\n";
echo "\n=== All SESSION data ===\n";
print_r($_SESSION);
echo "\n=== Now checking auth ===\n";

mp_admin_check(); // This should redirect if not logged in

echo "✓ Auth check PASSED - you are logged in\n";
?>
