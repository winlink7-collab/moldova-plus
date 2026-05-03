<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();
if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: text/html; charset=utf-8');

$data_dir = __DIR__ . '/../data/';
$test_file = $data_dir . '_write_test.tmp';

// Test write
$can_write = (bool) file_put_contents($test_file, 'ok');
if ($can_write) @unlink($test_file);

$csrf_token = mp_csrf();
$csrf_ok    = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_ok = mp_csrf_verify();
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="he">
<head>
  <meta charset="utf-8">
  <title>אבחון — Moldova Plus Admin</title>
  <style>
    body { font-family: 'Heebo', sans-serif; padding: 30px; background: #f8faff; direction: rtl; }
    .box { background: #fff; border-radius: 12px; padding: 20px 24px; margin-bottom: 16px; border: 1px solid #e2e8f0; }
    .ok  { color: #16a34a; font-weight: 700; }
    .err { color: #dc2626; font-weight: 700; }
    h2   { margin: 0 0 12px; font-size: 16px; }
    table { border-collapse: collapse; width: 100%; font-size: 14px; }
    td, th { padding: 8px 12px; border-bottom: 1px solid #f1f5f9; text-align: right; }
    th { font-weight: 700; color: #64748b; font-size: 12px; }
    .btn { background: #2563eb; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; cursor: pointer; font-size: 14px; font-family: inherit; font-weight: 700; }
  </style>
</head>
<body>
<h1 style="margin:0 0 20px;font-size:20px">🔍 אבחון מערכת</h1>

<div class="box">
  <h2>כתיבה לתיקיית data/</h2>
  <?php if ($can_write): ?>
    <span class="ok">✓ תיקיית data/ ניתנת לכתיבה</span>
  <?php else: ?>
    <span class="err">✗ שגיאה: לא ניתן לכתוב לתיקיית data/ — בדוק הרשאות</span>
  <?php endif; ?>
</div>

<div class="box">
  <h2>Session</h2>
  <table>
    <tr><th>מפתח</th><th>ערך</th></tr>
    <tr><td>Session ID</td><td><?= session_id() ?: '<em>ריק</em>' ?></td></tr>
    <tr><td>mp_admin_ok</td><td><?= !empty($_SESSION['mp_admin_ok']) ? '<span class="ok">✓ כן</span>' : '<span class="err">✗ לא</span>' ?></td></tr>
  </table>
</div>

<div class="box">
  <h2>Cookie ניהול</h2>
  <?php if (!empty($_COOKIE[ADMIN_TOKEN])): ?>
    <span class="ok">✓ Cookie "<?= ADMIN_TOKEN ?>" קיים</span>
  <?php else: ?>
    <span class="err">✗ Cookie "<?= ADMIN_TOKEN ?>" חסר</span>
  <?php endif; ?>
</div>

<div class="box">
  <h2>CSRF Token</h2>
  <p style="font-size:13px;margin:0 0 12px;color:#64748b">Token: <code><?= $csrf_token ?></code></p>
  <?php if ($csrf_ok === true): ?>
    <p class="ok">✓ CSRF עבר בהצלחה!</p>
  <?php elseif ($csrf_ok === false): ?>
    <p class="err">✗ CSRF נכשל — זו הסיבה שטפסים לא נשמרים!</p>
  <?php endif; ?>
  <form method="POST">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf_token) ?>">
    <button type="submit" class="btn">בדוק CSRF</button>
  </form>
</div>

<div class="box">
  <h2>קבצי JSON</h2>
  <table>
    <tr><th>קובץ</th><th>גודל</th><th>תוכן</th></tr>
    <?php
    $files = ['packages.json','new_packages.json','settings.json','faq.json','reviews.json','hotels.json','attractions.json'];
    foreach ($files as $f) {
        $path = $data_dir . $f;
        if (file_exists($path)) {
            $size = filesize($path);
            $content = file_get_contents($path);
            echo "<tr><td>$f</td><td>{$size} bytes</td><td style='font-size:11px;color:#64748b'>" . htmlspecialchars(substr($content, 0, 60)) . "</td></tr>";
        } else {
            echo "<tr><td>$f</td><td colspan='2' style='color:#dc2626'>לא קיים</td></tr>";
        }
    }
    ?>
  </table>
</div>

<p style="margin-top:20px"><a href="packages.php">← חזרה לחבילות</a></p>
</body>
</html>
