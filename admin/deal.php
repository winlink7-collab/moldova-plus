<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$deal = mp_read_json('deal.json');
$saved = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && mp_csrf_verify()) {
    $deal['enabled']   = isset($_POST['enabled']);
    $deal['title_he']  = trim($_POST['title_he'] ?? '');
    $deal['title_en']  = trim($_POST['title_en'] ?? '');
    $deal['desc_he']   = trim($_POST['desc_he'] ?? '');
    $deal['desc_en']   = trim($_POST['desc_en'] ?? '');
    $deal['price']     = (int)($_POST['price'] ?? 0);
    $deal['was_price'] = (int)($_POST['was_price'] ?? 0);
    $deal['discount']  = (int)($_POST['discount'] ?? 0);
    $deal['spots_left']  = (int)($_POST['spots_left'] ?? 0);
    $deal['spots_total'] = (int)($_POST['spots_total'] ?? 12);
    $deal['includes_he'] = array_values(array_filter(array_map('trim', explode("\n", $_POST['includes_he'] ?? ''))));
    $deal['includes_en'] = array_values(array_filter(array_map('trim', explode("\n", $_POST['includes_en'] ?? ''))));

    if (mp_write_json('deal.json', $deal)) {
        $saved = true;
    } else {
        $error = 'שגיאה בשמירה — בדוק הרשאות תיקיית data/';
    }
}

$fill_pct = $deal['spots_total'] > 0
    ? round((1 - $deal['spots_left'] / $deal['spots_total']) * 100)
    : 0;
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>מבצע השבוע — Moldova Plus Admin</title>
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
        <h1>מבצע השבוע</h1>
        <p>שליטה מלאה על הבאנר שמוצג בעמוד הבית</p>
      </div>
    </div>
    <div class="admin-content">
      <?php if ($saved): ?>
      <div class="alert success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
        המבצע נשמר בהצלחה<?= $deal['enabled'] ? ' — מוצג באתר כרגע!' : ' — המבצע כבוי (מוסתר מהאתר).' ?>
      </div>
      <?php endif; ?>
      <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="two-col" style="align-items:start">

        <!-- Form -->
        <div>
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">

            <!-- Toggle -->
            <div class="admin-card" style="margin-bottom:16px">
              <div class="card-body" style="display:flex;align-items:center;justify-content:space-between">
                <div>
                  <b style="font-size:15px">הצג מבצע בעמוד הבית</b>
                  <p style="font-size:13px;color:var(--ink-mute);margin:4px 0 0">כשמופעל — הבאנר יופיע מיד לאחר קטגוריות החבילות</p>
                </div>
                <label class="toggle">
                  <input type="checkbox" name="enabled" <?= !empty($deal['enabled']) ? 'checked' : '' ?>>
                  <span class="toggle-slider"></span>
                </label>
              </div>
            </div>

            <div class="admin-card" style="margin-bottom:16px">
              <div class="card-head"><div><h2>תוכן המבצע</h2></div></div>
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group">
                    <label>כותרת — עברית</label>
                    <input type="text" name="title_he" value="<?= htmlspecialchars($deal['title_he'] ?? '') ?>" required>
                  </div>
                  <div class="form-group">
                    <label>כותרת — English</label>
                    <input type="text" name="title_en" value="<?= htmlspecialchars($deal['title_en'] ?? '') ?>" style="direction:ltr">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>תיאור — עברית</label>
                    <textarea name="desc_he"><?= htmlspecialchars($deal['desc_he'] ?? '') ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>תיאור — English</label>
                    <textarea name="desc_en" style="direction:ltr"><?= htmlspecialchars($deal['desc_en'] ?? '') ?></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="admin-card" style="margin-bottom:16px">
              <div class="card-head"><div><h2>מחיר ומלאי</h2></div></div>
              <div class="card-body">
                <div class="form-row-3">
                  <div class="form-group">
                    <label>מחיר מבצע (€)</label>
                    <input type="number" name="price" value="<?= (int)($deal['price'] ?? 0) ?>" min="1">
                  </div>
                  <div class="form-group">
                    <label>מחיר מקורי (€)</label>
                    <input type="number" name="was_price" value="<?= (int)($deal['was_price'] ?? 0) ?>" min="1">
                  </div>
                  <div class="form-group">
                    <label>אחוז הנחה (%)</label>
                    <input type="number" name="discount" value="<?= (int)($deal['discount'] ?? 0) ?>" min="0" max="99">
                    <p class="form-hint">מוצג בעיגול האדום</p>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>מקומות שנותרו</label>
                    <input type="number" name="spots_left" value="<?= (int)($deal['spots_left'] ?? 4) ?>" min="0">
                  </div>
                  <div class="form-group">
                    <label>סה"כ מקומות</label>
                    <input type="number" name="spots_total" value="<?= (int)($deal['spots_total'] ?? 12) ?>" min="1">
                    <p class="form-hint">משפיע על פס הזמינות</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="admin-card" style="margin-bottom:16px">
              <div class="card-head"><div><h2>מה כלול במבצע</h2><p>שורה אחת לכל פריט (מוצג באתר עם ✓)</p></div></div>
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group">
                    <label>כולל — עברית (שורה לכל פריט)</label>
                    <textarea name="includes_he" rows="5" placeholder="4 לילות במלון 5★&#10;ארוחות בוקר&#10;סיור ביקב&#10;איסוף משדה התעופה"><?= htmlspecialchars(implode("\n", $deal['includes_he'] ?? [])) ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Includes — English (one per line)</label>
                    <textarea name="includes_en" rows="5" style="direction:ltr" placeholder="4 nights 5★ hotel&#10;Daily breakfasts&#10;Winery tour&#10;Airport transfer"><?= htmlspecialchars(implode("\n", $deal['includes_en'] ?? [])) ?></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="btn-save-row" style="border:0;padding:0">
              <button type="submit" class="btn-admin primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                שמור שינויים
              </button>
              <span style="font-size:13px;color:var(--ink-mute)">השינוי ייכנס לתוקף מיד</span>
            </div>
          </form>
        </div>

        <!-- Live preview -->
        <div style="position:sticky;top:24px">
          <div class="admin-card">
            <div class="card-head"><div><h2>תצוגה מקדימה</h2><p>כך ייראה הבאנר באתר</p></div></div>
            <div class="card-body">
              <div class="deal-preview">
                <div class="deal-preview-badge">
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2l-8 11h7l-1 9 9-11h-7l2-9z"/></svg>
                  מבצע השבוע — מוגבל ל-<?= (int)($deal['spots_total'] ?? 12) ?> מקומות
                </div>
                <h3><?= htmlspecialchars($deal['title_he'] ?? '') ?></h3>
                <p><?= htmlspecialchars(mb_strimwidth($deal['desc_he'] ?? '', 0, 90, '...')) ?></p>
                <div class="deal-preview-price">
                  <span class="was">€<?= (int)($deal['was_price'] ?? 0) ?></span>
                  <span class="now">€<?= (int)($deal['price'] ?? 0) ?></span>
                  <span class="pp">/אדם</span>
                </div>
                <div style="margin-bottom:10px">
                  <div style="height:5px;background:rgba(255,255,255,.2);border-radius:3px;overflow:hidden">
                    <div style="height:100%;width:<?= $fill_pct ?>%;background:linear-gradient(90deg,#0046ae,#cc1126);border-radius:3px"></div>
                  </div>
                  <p style="font-size:11px;color:#f87171;margin:5px 0 0;font-weight:600">נותרו <?= (int)($deal['spots_left'] ?? 0) ?> מקומות</p>
                </div>
                <div class="deal-preview-tags">
                  <?php foreach (($deal['includes_he'] ?? []) as $inc): ?>
                    <span class="deal-preview-tag">✓ <?= htmlspecialchars($inc) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
              <div style="margin-top:12px;padding:12px;background:var(--bg);border-radius:var(--r);font-size:13px;color:var(--ink-mute)">
                <b style="color:<?= !empty($deal['enabled']) ? 'var(--green)' : 'var(--ink-mute)' ?>">
                  סטטוס: <?= !empty($deal['enabled']) ? '● מוצג באתר' : '○ מוסתר' ?>
                </b>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
</div>
</body>
</html>
