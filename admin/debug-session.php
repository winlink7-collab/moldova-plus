<?php
require_once __DIR__ . '/includes/auth.php';

echo '<pre style="font-family: monospace; background: #f5f5f5; padding: 20px; margin: 20px;">';
echo "=== PHP SESSION CONFIGURATION ===\n";
echo "session.cookie_lifetime: " . ini_get('session.cookie_lifetime') . "\n";
echo "session.gc_maxlifetime: " . ini_get('session.gc_maxlifetime') . "\n";
echo "session.save_path: " . ini_get('session.save_path') . "\n";
echo "session.save_handler: " . ini_get('session.save_handler') . "\n";
echo "session.name: " . ini_get('session.name') . "\n";
echo "\n=== CURRENT SESSION STATUS ===\n";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'ACTIVE' : 'NOT ACTIVE') . "\n";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "Session ID: " . session_id() . "\n";
    echo "Session Data:\n";
    print_r($_SESSION);
}
echo "\n=== COOKIES ===\n";
echo "Cookies sent:\n";
print_r($_COOKIE);
echo "\n=== AUTH CHECK ===\n";
$has_cookie = !empty($_COOKIE['admin_token']);
$has_session = !empty($_SESSION['mp_admin_ok']);
echo "Has admin_token cookie: " . ($has_cookie ? 'YES' : 'NO') . "\n";
echo "Has mp_admin_ok session: " . ($has_session ? 'YES' : 'NO') . "\n";
echo "Will authenticate: " . ($has_cookie || $has_session ? 'YES' : 'NO') . "\n";
echo "</pre>";

if (!($has_cookie || $has_session)) {
    echo "<p style='color: red; padding: 20px; font-weight: bold;'>❌ NOT AUTHENTICATED - would redirect to login</p>";
} else {
    echo "<p style='color: green; padding: 20px; font-weight: bold;'>✓ AUTHENTICATED</p>";
}
?>
