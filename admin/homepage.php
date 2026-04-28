<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';

// --- SAVE HERO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'hero' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['hero_kicker_he'] = trim($_POST['hero_kicker_he'] ?? '');
    $s['hero_kicker_en'] = trim($_POST['hero_kicker_en'] ?? '');
    $s['hero_h1_he']     = trim($_POST['hero_h1_he'] ?? '');
    $s['hero_h1_en']     = trim($_POST['hero_h1_en'] ?? '');
    $s['hero_sub_he']    = trim($_POST['hero_sub_he'] ?? '');
    $s['hero_sub_en']    = trim($_POST['hero_sub_en'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'טקסט ה-Hero עודכן!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE PROMO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'promo' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['promo_he']     = trim($_POST['promo_he'] ?? '');
    $s['promo_en']     = trim($_POST['promo_en'] ?? '');
    $s['promo_active'] = isset($_POST['promo_active']);
    mp_write_json('settings.json', $s) ? $msg = 'הפרומו עודכן!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE HERO CARD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'herocard' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['hc_title_he']    = trim($_POST['hc_title_he'] ?? '');
    $s['hc_loc_he']      = trim($_POST['hc_loc_he'] ?? '');
    $s['hc_nights']      = trim($_POST['hc_nights'] ?? '');
    $s['hc_disc']        = trim($_POST['hc_disc'] ?? '');
    $s['hc_price']       = trim($_POST['hc_price'] ?? '');
    $s['hc_was']         = trim($_POST['hc_was'] ?? '');
    $s['hc_rating']      = trim($_POST['hc_rating'] ?? '');
    $s['hc_img']         = trim($_POST['hc_img'] ?? '');
    $s['hc_includes_he'] = array_values(array_filter(array_map('trim', explode("\n", $_POST['hc_includes_he'] ?? ''))));
    mp_write_json('settings.json', $s) ? $msg = 'כרטיס ה-Hero עודכן!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE FOOTER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'footer' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['footer_about_he'] = trim($_POST['footer_about_he'] ?? '');
    $s['footer_about_en'] = trim($_POST['footer_about_en'] ?? '');
    $s['footer_copy']     = trim($_POST['footer_copy'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'טקסטי הפוטר עודכנו!' : $error = 'שגיאה בשמירה.';
}

$S = mp_read_json('settings.json');
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>עמוד הבית — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar"><div><h1>עמוד הבית</h1><p>עריכת טקסטי Hero, פרומו ופוטר</p></div></div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Hero Section -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>סקשן Hero</h2><p>הכותרת, תת-כותרת והכיתוב הקצר בראש עמוד הבית</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="hero">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>Kicker (עברית)</label>
                <input type="text" name="hero_kicker_he" value="<?= htmlspecialchars($S['hero_kicker_he'] ?? '') ?>" placeholder="יעד #1 לחבילות מולדובה">
              </div>
              <div class="form-group">
                <label>Kicker (English)</label>
                <input type="text" name="hero_kicker_en" value="<?= htmlspecialchars($S['hero_kicker_en'] ?? '') ?>" placeholder="#1 destination for Moldova">
              </div>
              <div class="form-group">
                <label>כותרת H1 (עברית)</label>
                <input type="text" name="hero_h1_he" value="<?= htmlspecialchars($S['hero_h1_he'] ?? '') ?>" placeholder="חוויית מולדובה מתחילה כאן.">
              </div>
              <div class="form-group">
                <label>H1 (English)</label>
                <input type="text" name="hero_h1_en" value="<?= htmlspecialchars($S['hero_h1_en'] ?? '') ?>" placeholder="The Moldova experience starts here.">
              </div>
              <div class="form-group">
                <label>תת-כותרת (עברית)</label>
                <textarea name="hero_sub_he" rows="3" placeholder="פורטל ההזמנות הגדול..."><?= htmlspecialchars($S['hero_sub_he'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>Sub-title (English)</label>
                <textarea name="hero_sub_en" rows="3" placeholder="Israel's largest portal..."><?= htmlspecialchars($S['hero_sub_en'] ?? '') ?></textarea>
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור Hero</button>
          </form>
        </div>
      </div>

      <!-- Hero Package Card -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>כרטיס חבילה בהירו</h2><p>הכרטיס הצף בצד ימין של עמוד הבית</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="herocard">
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>שם החבילה (עברית)</label>
                <input type="text" name="hc_title_he" value="<?= htmlspecialchars($S['hc_title_he'] ?? '') ?>" placeholder="חופשת יין וספא — 4 לילות">
              </div>
              <div class="form-group">
                <label>מיקום</label>
                <input type="text" name="hc_loc_he" value="<?= htmlspecialchars($S['hc_loc_he'] ?? '') ?>" placeholder="קישינב, מולדובה">
              </div>
              <div class="form-group">
                <label>לילות</label>
                <input type="text" name="hc_nights" value="<?= htmlspecialchars($S['hc_nights'] ?? '') ?>" placeholder="4">
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>מחיר (€)</label>
                <input type="text" name="hc_price" value="<?= htmlspecialchars($S['hc_price'] ?? '') ?>" placeholder="299">
              </div>
              <div class="form-group">
                <label>מחיר מקורי (€)</label>
                <input type="text" name="hc_was" value="<?= htmlspecialchars($S['hc_was'] ?? '') ?>" placeholder="470">
              </div>
              <div class="form-group">
                <label>הנחה (%)</label>
                <input type="text" name="hc_disc" value="<?= htmlspecialchars($S['hc_disc'] ?? '') ?>" placeholder="35">
              </div>
              <div class="form-group">
                <label>דירוג</label>
                <input type="text" name="hc_rating" value="<?= htmlspecialchars($S['hc_rating'] ?? '') ?>" placeholder="4.9">
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>תמונה (URL)</label>
                <input type="text" name="hc_img" value="<?= htmlspecialchars($S['hc_img'] ?? '') ?>" placeholder="https://images.unsplash.com/...">
              </div>
              <div class="form-group">
                <label>מה כלול (שורה לכל פריט, עד 4)</label>
                <textarea name="hc_includes_he" rows="4" placeholder="מלון 5★&#10;סיור יקב&#10;ספא זוגי&#10;ארוחות בוקר"><?= htmlspecialchars(implode("\n", $S['hc_includes_he'] ?? [])) ?></textarea>
              </div>
            </div>
            <button type="submit" class="btn-admin primary">שמור כרטיס Hero</button>
          </form>
        </div>
      </div>

      <!-- Promo Bar -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>סרגל פרומו עליון</h2><p>הטקסט שמוצג בשורת המידע בראש כל עמוד</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="promo">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>טקסט פרומו (עברית)</label>
                <input type="text" name="promo_he" value="<?= htmlspecialchars($S['promo_he'] ?? '') ?>" placeholder="✦ מבצע אביב — עד 15% הנחה">
              </div>
              <div class="form-group">
                <label>Promo text (English)</label>
                <input type="text" name="promo_en" value="<?= htmlspecialchars($S['promo_en'] ?? '') ?>" placeholder="✦ Spring offer — up to 15% off">
              </div>
            </div>
            <div class="form-group" style="margin-top:12px">
              <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-weight:500">
                <input type="checkbox" name="promo_active" value="1" <?= !empty($S['promo_active']) ? 'checked' : '' ?> style="width:16px;height:16px;cursor:pointer">
                הצג את סרגל הפרומו באתר
              </label>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור פרומו</button>
          </form>
        </div>
      </div>

      <!-- Footer Texts -->
      <div class="admin-card">
        <div class="card-head"><div><h2>טקסטי פוטר</h2><p>טקסט "אודות" ושורת הזכויות בתחתית האתר</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="footer">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>תיאור קצר (עברית)</label>
                <textarea name="footer_about_he" rows="3" placeholder="הפורטל הגדול בישראל..."><?= htmlspecialchars($S['footer_about_he'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>About text (English)</label>
                <textarea name="footer_about_en" rows="3" placeholder="Israel's largest portal..."><?= htmlspecialchars($S['footer_about_en'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>שורת הזכויות (Copyright)</label>
                <input type="text" name="footer_copy" value="<?= htmlspecialchars($S['footer_copy'] ?? '') ?>" placeholder="© 2026 Moldova Plus · כל הזכויות שמורות">
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור פוטר</button>
          </form>
        </div>
      </div>

    </div>
  </main>
</div>
</body>
</html>
