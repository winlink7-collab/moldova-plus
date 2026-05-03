<?php
require_once __DIR__ . '/includes/auth.php';

echo '<pre style="font-family: monospace; background: #f5f5f5; padding: 20px; margin: 20px;">';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = $_POST['password'] ?? '';
    echo "Password submitted: " . (strlen($pass) > 0 ? 'YES (' . strlen($pass) . ' chars)' : 'NO') . "\n";

    $correct_pass = mp_get_pass();
    echo "Expected hash length: " . strlen($correct_pass) . "\n";

    $verify = password_verify($pass, $correct_pass);
    echo "Password verify result: " . ($verify ? 'TRUE ✓' : 'FALSE ✗') . "\n";

    if ($verify) {
        echo "\n=== SETTING LOGIN ===\n";
        $token = bin2hex(random_bytes(32));
        echo "Generated token: " . $token . "\n";

        $_SESSION['mp_admin_ok'] = $token;
        echo "Session var set: " . (!empty($_SESSION['mp_admin_ok']) ? 'YES' : 'NO') . "\n";

        setcookie('admin_token', $token, time() + (86400 * 30), '/admin/');
        echo "Cookie set command sent\n";

        echo "\n=== AFTER LOGIN ===\n";
        echo "Session mp_admin_ok: " . (!empty($_SESSION['mp_admin_ok']) ? 'YES' : 'NO') . "\n";
        echo "Cookie admin_token: " . (!empty($_COOKIE['admin_token']) ? 'YES' : 'NO') . "\n";

        echo "\nCookies set (headers):\n";
        echo "setcookie('admin_token', '" . substr($token, 0, 10) . "...', expire, '/admin/')";

        echo "\n\n✓ Login should work. Redirecting to index.php...";
        echo "\n(בדוק את cookies בדפדפן)";
    }
} else {
    echo "Test Login Form\n";
    echo "===============\n\n";
}

echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
?>

<form method="POST" style="padding: 20px; max-width: 400px;">
    <label style="display: block; margin-bottom: 10px;">סיסמה:</label>
    <input type="password" name="password" style="padding: 8px; width: 100%; margin-bottom: 10px;">
    <button type="submit" style="padding: 10px 20px; background: blue; color: white; border: none; cursor: pointer;">בדוק Login</button>
</form>

<?php } ?>
