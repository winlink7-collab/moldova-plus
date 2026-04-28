<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';

// --- SAVE CONTACT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'contact' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['whatsapp']       = preg_replace('/\D/', '', $_POST['whatsapp'] ?? '');
    $s['phone']          = trim($_POST['phone'] ?? '');
    $s['phone_display']  = trim($_POST['phone_display'] ?? '');
    $s['email']          = trim($_POST['email'] ?? '');
    $s['site_name']     = trim($_POST['site_name'] ?? '');
    $s['address_he']    = trim($_POST['address_he'] ?? '');
    $s['address_en']    = trim($_POST['address_en'] ?? '');
    $s['hours_sun_thu'] = trim($_POST['hours_sun_thu'] ?? '');
    $s['hours_fri']     = trim($_POST['hours_fri'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'הגדרות הקשר עודכנו!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE ABOUT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'about' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['about_story_he'] = trim($_POST['about_story_he'] ?? '');
    $s['about_story_en'] = trim($_POST['about_story_en'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'טקסט עמוד אודות עודכן!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE STATS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'stats' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['stat_years']     = trim($_POST['stat_years'] ?? '');
    $s['stat_packages']  = trim($_POST['stat_packages'] ?? '');
    $s['stat_customers'] = trim($_POST['stat_customers'] ?? '');
    $s['stat_rating']    = trim($_POST['stat_rating'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'הסטטיסטיקות עודכנו!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE PASSWORD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'password' && mp_csrf_verify()) {
    $p1 = $_POST['pass1'] ?? '';
    $p2 = $_POST['pass2'] ?? '';
    if (strlen($p1) < 6) {
        $error = 'הסיסמה חייבת להכיל לפחות 6 תווים.';
    } elseif ($p1 !== $p2) {
        $error = 'הסיסמאות אינן תואמות.';
    } else {
        $hash = password_hash($p1, PASSWORD_BCRYPT);
        $php  = '<?php return ' . var_export($hash, true) . ';';
        file_put_contents(ADMIN_PASS_FILE, $php) ? $msg = 'הסיסמה עודכנה בהצלחה!' : $error = 'שגיאה בשמירת הסיסמה.';
    }
}

$S = mp_read_json('settings.json');
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>הגדרות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar"><div><h1>הגדרות</h1><p>פרטי קשר, שעות, סטטיסטיקות וסיסמה</p></div></div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Contact Settings -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>פרטי קשר ושעות</h2><p>מוצגים בדף "צור קשר" ובכל האתר</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="contact">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>WhatsApp (ספרות בלבד)</label>
                <div style="display:flex;gap:8px">
                  <input type="text" name="whatsapp" value="<?= htmlspecialchars($S['whatsapp'] ?? '') ?>" placeholder="972355501880" style="flex:1">
                  <a href="https://wa.me/<?= htmlspecialchars($S['whatsapp'] ?? '') ?>" target="_blank" class="btn-admin ghost sm" style="white-space:nowrap">בדוק</a>
                </div>
              </div>
              <div class="form-group">
                <label>טלפון (לקישורי tel:)</label>
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
              <div class="form-group">
                <label>שם האתר</label>
                <input type="text" name="site_name" value="<?= htmlspecialchars($S['site_name'] ?? '') ?>" placeholder="Moldova Plus">
              </div>
              <div class="form-group">
                <label>כתובת (עברית)</label>
                <input type="text" name="address_he" value="<?= htmlspecialchars($S['address_he'] ?? '') ?>" placeholder="רחוב הברזל 3, תל אביב–יפו, קומה 4">
              </div>
              <div class="form-group">
                <label>כתובת (אנגלית)</label>
                <input type="text" name="address_en" value="<?= htmlspecialchars($S['address_en'] ?? '') ?>" placeholder="3 HaBarzel St, Tel Aviv–Yafo, Floor 4">
              </div>
              <div class="form-group">
                <label>שעות א'–ה'</label>
                <input type="text" name="hours_sun_thu" value="<?= htmlspecialchars($S['hours_sun_thu'] ?? '') ?>" placeholder="09:00 – 20:00">
              </div>
              <div class="form-group">
                <label>שעות שישי</label>
                <input type="text" name="hours_fri" value="<?= htmlspecialchars($S['hours_fri'] ?? '') ?>" placeholder="09:00 – 14:00">
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור פרטי קשר</button>
          </form>
        </div>
      </div>

      <!-- Stats Settings -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>סטטיסטיקות האתר</h2><p>מוצגות בדף "אודות" ובעמוד הבית</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="stats">
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px">
              <div class="form-group">
                <label>שנות פעילות</label>
                <input type="text" name="stat_years" value="<?= htmlspecialchars($S['stat_years'] ?? '8+') ?>" placeholder="8+">
              </div>
              <div class="form-group">
                <label>חבילות נמכרו</label>
                <input type="text" name="stat_packages" value="<?= htmlspecialchars($S['stat_packages'] ?? '1,200+') ?>" placeholder="1,200+">
              </div>
              <div class="form-group">
                <label>לקוחות מרוצים</label>
                <input type="text" name="stat_customers" value="<?= htmlspecialchars($S['stat_customers'] ?? '15,000+') ?>" placeholder="15,000+">
              </div>
              <div class="form-group">
                <label>דירוג ממוצע</label>
                <input type="text" name="stat_rating" value="<?= htmlspecialchars($S['stat_rating'] ?? '4.9') ?>" placeholder="4.9">
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור סטטיסטיקות</button>
          </form>
        </div>
      </div>

      <!-- About Story -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>טקסט עמוד אודות</h2><p>הסיפור שמוצג בעמוד "אודות"</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="about">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>הסיפור שלנו — עברית</label>
                <textarea name="about_story_he" rows="7" placeholder="Moldova Plus נוסדה ב-2018..."><?= htmlspecialchars($S['about_story_he'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>Our Story — English</label>
                <textarea name="about_story_en" rows="7" style="direction:ltr" placeholder="Moldova Plus was founded in 2018..."><?= htmlspecialchars($S['about_story_en'] ?? '') ?></textarea>
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור טקסט אודות</button>
          </form>
        </div>
      </div>

      <!-- Password -->
      <div class="admin-card">
        <div class="card-head"><div><h2>שינוי סיסמה</h2><p>סיסמת כניסה לפאנל הניהול</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST" style="max-width:420px">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="password">
            <div class="form-group">
              <label>סיסמה חדשה (מינימום 6 תווים)</label>
              <input type="password" name="pass1" placeholder="••••••••" autocomplete="new-password">
            </div>
            <div class="form-group">
              <label>אימות סיסמה</label>
              <input type="password" name="pass2" placeholder="••••••••" autocomplete="new-password">
            </div>
            <button type="submit" class="btn-admin primary">עדכן סיסמה</button>
          </form>
        </div>
      </div>

    </div>
  </main>
</div>
</body>
</html>
