<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$settings = mp_read_json('settings.json');
$saved = false;
$error = '';
$pass_saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && mp_csrf_verify()) {

    if (isset($_POST['action']) && $_POST['action'] === 'change_pass') {
        $new  = $_POST['new_pass'] ?? '';
        $conf = $_POST['confirm_pass'] ?? '';
        if (strlen($new) < 6) {
            $error = 'הסיסמה חייבת להיות לפחות 6 תווים';
        } elseif ($new !== $conf) {
            $error = 'הסיסמאות אינן תואמות';
        } else {
            $hash = password_hash($new, PASSWORD_BCRYPT);
            $php  = "<?php return " . var_export($hash, true) . ";";
            file_put_contents(ADMIN_PASS_FILE, $php);
            $pass_saved = true;
        }
    } else {
        $settings['whatsapp']  = preg_replace('/[^0-9]/', '', $_POST['whatsapp'] ?? '');
        $settings['phone']     = preg_replace('/[^0-9\-]/', '', $_POST['phone'] ?? '');
        $settings['email']     = trim($_POST['email'] ?? '');
        $settings['site_name'] = trim($_POST['site_name'] ?? 'Moldova Plus');

        if (mp_write_json('settings.json', $settings)) {
            $saved = true;
        } else {
            $error = 'שגיאה בשמירה — בדוק הרשאות תיקיית data/';
        }
    }
}
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
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <div>
        <h1>הגדרות</h1>
        <p>פרטי התקשרות, וואטסאפ וסיסמת כניסה</p>
      </div>
    </div>
    <div class="admin-content">

      <?php if ($saved): ?>
      <div class="alert success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
        ההגדרות נשמרו בהצלחה!
      </div>
      <?php endif; ?>
      <?php if ($pass_saved): ?>
      <div class="alert success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
        הסיסמה שונתה בהצלחה!
      </div>
      <?php endif; ?>
      <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="two-col" style="align-items:start;gap:20px">
        <!-- Contact settings -->
        <div>
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">

            <div class="admin-card" style="margin-bottom:16px">
              <div class="card-head"><div><h2>פרטי התקשרות</h2><p>אלו הפרטים שמוצגים בכל רחבי האתר</p></div></div>
              <div class="card-body">
                <div class="form-group">
                  <label>מספר וואטסאפ</label>
                  <input type="text" name="whatsapp" value="<?= htmlspecialchars($settings['whatsapp'] ?? '') ?>" style="direction:ltr" placeholder="972355501880">
                  <p class="form-hint">ספרות בלבד, כולל קידומת מדינה. לדוגמה: 972501234567</p>
                </div>
                <div class="form-group">
                  <label>מספר טלפון</label>
                  <input type="text" name="phone" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>" style="direction:ltr" placeholder="035550188">
                </div>
                <div class="form-group">
                  <label>כתובת אימייל</label>
                  <input type="email" name="email" value="<?= htmlspecialchars($settings['email'] ?? '') ?>" style="direction:ltr" placeholder="hello@moldovaplus.com">
                </div>
                <div class="form-group">
                  <label>שם האתר</label>
                  <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? 'Moldova Plus') ?>">
                </div>
              </div>
            </div>

            <button type="submit" class="btn-admin primary">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              שמור הגדרות
            </button>
          </form>
        </div>

        <!-- Password change -->
        <div>
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="action" value="change_pass">

            <div class="admin-card" style="margin-bottom:16px">
              <div class="card-head">
                <div>
                  <h2>שינוי סיסמה</h2>
                  <p>סיסמת כניסה לדשבורד</p>
                </div>
                <span class="badge green">מאובטח</span>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>סיסמה חדשה</label>
                  <input type="password" name="new_pass" placeholder="לפחות 6 תווים" autocomplete="new-password">
                </div>
                <div class="form-group">
                  <label>אימות סיסמה</label>
                  <input type="password" name="confirm_pass" placeholder="הקלד שוב" autocomplete="new-password">
                </div>
              </div>
            </div>

            <button type="submit" class="btn-admin ghost">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              שנה סיסמה
            </button>
          </form>

          <!-- WA test link -->
          <div class="admin-card" style="margin-top:16px">
            <div class="card-head"><div><h2>בדיקת קישורי וואטסאפ</h2></div></div>
            <div class="card-body">
              <p style="font-size:13px;color:var(--ink-mute);margin:0 0 14px">לחצו לבדוק שהוואטסאפ עובד עם המספר הנוכחי</p>
              <a href="https://wa.me/<?= htmlspecialchars($settings['whatsapp'] ?? '972355501880') ?>?text=<?= urlencode('שלום, בדיקת קישור מהאתר') ?>" target="_blank" rel="noopener" class="btn-admin primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                בדוק וואטסאפ
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
