<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = $_POST['password'] ?? '';
    if (password_verify($pass, mp_get_pass())) {
        $token = bin2hex(random_bytes(32));
        $_SESSION['mp_admin_ok'] = $token;
        setcookie('admin_token', $token, time() + (86400 * 30), '/admin/');
        header('Location: index.php');
        exit;
    }
    $error = 'סיסמה שגויה. נסה שוב.';
}
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>כניסה — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <div class="login-logo">
      <div class="login-logo-mark">M+</div>
      <h1>Moldova Plus</h1>
      <p>פאנל ניהול — כניסה מאובטחת</p>
    </div>

    <?php if ($error): ?>
    <div class="alert error">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
      <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="form-group">
        <label>סיסמת כניסה</label>
        <input type="password" name="password" placeholder="••••••••" autofocus autocomplete="current-password" required>
      </div>
      <button type="submit" class="login-submit">כניסה לדשבורד</button>
    </form>
  </div>
</div>
</body>
</html>
