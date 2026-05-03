<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_start();
}
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();
require_once __DIR__ . '/../includes/data.php';

// مهم جداً: حفظ متغيرات الجلسة
$is_admin = !empty($_SESSION['mp_admin_ok']);
$csrf_token = mp_csrf();

$msg = '';
$error = '';
$S = mp_read_json('settings.json');

// معالجة النماذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // تحقق من CSRF
    $posted_csrf = $_POST['csrf'] ?? '';
    $stored_csrf = $_SESSION['csrf'] ?? '';

    if (empty($posted_csrf) || $posted_csrf !== $stored_csrf) {
        $error = 'خطأ أمني - حاول مرة أخرى';
    } else {
        $section = $_POST['section'] ?? '';

        if ($section === 'password') {
            $p1 = trim($_POST['pass1'] ?? '');
            $p2 = trim($_POST['pass2'] ?? '');

            if (strlen($p1) < 6) {
                $error = 'סיסמה חייבת להכיל לפחות 6 תווים';
            } elseif ($p1 !== $p2) {
                $error = 'הסיסמאות אינן תואמות';
            } else {
                $hash = password_hash($p1, PASSWORD_BCRYPT, ['cost' => 10]);
                $code = '<?php return ' . var_export($hash, true) . ';';

                if (@file_put_contents(ADMIN_PASS_FILE, $code)) {
                    // עדכן את ה-CSRF token אחרי שמירה בהצלחה
                    $_SESSION['csrf'] = bin2hex(random_bytes(16));
                    $msg = 'סיסמה עודכנה בהצלחה!';
                    $csrf_token = $_SESSION['csrf'];
                } else {
                    $error = 'שגיאה בשמירת הסיסמה';
                }
            }
        }
        elseif ($section === 'contact') {
            $S['whatsapp'] = preg_replace('/\D/', '', $_POST['whatsapp'] ?? '');
            $S['phone'] = trim($_POST['phone'] ?? '');
            $S['phone_display'] = trim($_POST['phone_display'] ?? '');
            $S['email'] = trim($_POST['email'] ?? '');

            if (@mp_write_json('settings.json', $S)) {
                $_SESSION['csrf'] = bin2hex(random_bytes(16));
                $msg = 'פרטי קשר עודכנו!';
                $csrf_token = $_SESSION['csrf'];
            } else {
                $error = 'שגיאה בשמירה';
            }
        }
    }
}

// טען את הנتונים מחדש אחרי שמירה
$S = mp_read_json('settings.json');
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>הגדרות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <main class="admin-main" style="width:100%; background:#fafafa">
    <div class="admin-topbar">
      <div>
        <h1>הגדרות</h1>
        <p>פרטי קשר וסיסמה</p>
      </div>
      <a href="index.php" class="btn-admin ghost sm">← חזור</a>
    </div>

    <div class="admin-content" style="max-width:800px">

      <?php if ($msg): ?>
      <div class="alert success" style="margin-bottom:20px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
        <?= htmlspecialchars($msg) ?>
      </div>
      <?php endif; ?>

      <?php if ($error): ?>
      <div class="alert error" style="margin-bottom:20px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <!-- Contact Settings -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head">
          <h2>פרטי קשר</h2>
        </div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf_token) ?>">
            <input type="hidden" name="section" value="contact">

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px">
              <div class="form-group">
                <label>WhatsApp</label>
                <input type="text" name="whatsapp" value="<?= htmlspecialchars($S['whatsapp'] ?? '') ?>" placeholder="972355501880">
              </div>
              <div class="form-group">
                <label>טלפון</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($S['phone'] ?? '') ?>" placeholder="035550188">
              </div>
              <div class="form-group">
                <label>טלפון (תצוגה)</label>
                <input type="text" name="phone_display" value="<?= htmlspecialchars($S['phone_display'] ?? '') ?>" placeholder="+972 3-555-0188">
              </div>
              <div class="form-group">
                <label>אימייל</label>
                <input type="email" name="email" value="<?= htmlspecialchars($S['email'] ?? '') ?>" placeholder="hello@moldovaplus.com">
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור פרטי קשר</button>
          </form>
        </div>
      </div>

      <!-- Password Change -->
      <div class="admin-card">
        <div class="card-head">
          <h2>שינוי סיסמה</h2>
        </div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf_token) ?>">
            <input type="hidden" name="section" value="password">

            <div style="max-width:400px">
              <div class="form-group">
                <label>סיסמה חדשה (מינימום 6 תווים)</label>
                <input type="password" name="pass1" placeholder="••••••••" autocomplete="new-password">
              </div>
              <div class="form-group">
                <label>אימות סיסמה</label>
                <input type="password" name="pass2" placeholder="••••••••" autocomplete="new-password">
              </div>
              <button type="submit" class="btn-admin primary">עדכן סיסמה</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </main>
</div>
</body>
</html>
