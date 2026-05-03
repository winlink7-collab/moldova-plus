<?php
require_once __DIR__ . '/includes/auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
mp_admin_check();
require_once __DIR__ . '/../includes/data.php';

$settings = mp_read_json('settings.json');
$deal     = mp_read_json('deal.json');
$wa = $settings['whatsapp'] ?? '972355501880';
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>דשבורד — Moldova Plus Admin</title>
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
        <h1>דשבורד</h1>
        <p>ברוכים הבאים — סקירה מלאה של האתר</p>
      </div>
      <div class="topbar-right">
        <span class="topbar-time" id="admin-clock"></span>
        <a href="../index.php" target="_blank" class="btn-admin ghost sm">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          צפו באתר
        </a>
      </div>
    </div>

    <div class="admin-content">

      <!-- Stats -->
      <div class="stats-row">
        <div class="stat-box">
          <div class="stat-ic blue">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
          </div>
          <div>
            <div class="stat-val"><?= count($PACKAGES) ?></div>
            <div class="stat-label">חבילות פעילות</div>
            <div class="stat-delta up">↑ הכל זמין</div>
          </div>
        </div>
        <div class="stat-box">
          <div class="stat-ic green">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          </div>
          <div>
            <div class="stat-val">15K+</div>
            <div class="stat-label">אורחים מרוצים</div>
            <div class="stat-delta up">↑ מ-2018</div>
          </div>
        </div>
        <div class="stat-box">
          <div class="stat-ic yel">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </div>
          <div>
            <div class="stat-val">4.9</div>
            <div class="stat-label">דירוג ממוצע</div>
            <div class="stat-delta neutral">מ-4,247 ביקורות</div>
          </div>
        </div>
        <div class="stat-box">
          <div class="stat-ic red">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2l-8 11h7l-1 9 9-11h-7l2-9z"/></svg>
          </div>
          <div>
            <div class="stat-val"><?= !empty($deal['enabled']) ? 'פעיל' : 'כבוי' ?></div>
            <div class="stat-label">מבצע השבוע</div>
            <div class="stat-delta <?= !empty($deal['enabled']) ? 'up' : 'neutral' ?>">
              <?= !empty($deal['enabled']) ? '↑ מוצג באתר' : '— מוסתר' ?>
            </div>
          </div>
        </div>
      </div>

      <div class="two-col" style="gap:20px;margin-bottom:20px">

        <!-- Quick actions -->
        <div class="admin-card">
          <div class="card-head">
            <div>
              <h2>פעולות מהירות</h2>
              <p>הכלים הנפוצים ביותר</p>
            </div>
          </div>
          <div class="card-body">
            <div class="quick-actions">
              <a href="deal.php" class="qa-btn">
                <div class="qa-ic" style="background:#fff3f4;color:#cc1126">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2l-8 11h7l-1 9 9-11h-7l2-9z"/></svg>
                </div>
                <span class="qa-label">מבצע השבוע</span>
                <span class="qa-sub"><?= !empty($deal['enabled']) ? 'פעיל כרגע' : 'כבוי כרגע' ?></span>
              </a>
              <a href="packages.php" class="qa-btn">
                <div class="qa-ic" style="background:#eef4ff;color:#0046ae">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </div>
                <span class="qa-label">חבילות</span>
                <span class="qa-sub"><?= count($PACKAGES) ?> פעילות</span>
              </a>
              <a href="settings.php" class="qa-btn">
                <div class="qa-ic" style="background:#dcfce7;color:#16a34a">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </div>
                <span class="qa-label">הגדרות</span>
                <span class="qa-sub">וואטסאפ ועוד</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Contact info status -->
        <div class="admin-card">
          <div class="card-head">
            <div>
              <h2>פרטי התקשרות</h2>
              <p>מה מוגדר כרגע באתר</p>
            </div>
            <a href="settings.php" class="btn-admin ghost sm">עריכה</a>
          </div>
          <div class="card-body" style="display:flex;flex-direction:column;gap:14px">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:var(--bg);border-radius:var(--r);border:1px solid var(--line)">
              <span style="font-size:13px;color:var(--ink-mute)">וואטסאפ</span>
              <b style="font-size:14px;direction:ltr">+<?= htmlspecialchars($settings['whatsapp'] ?? '972355501880') ?></b>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:var(--bg);border-radius:var(--r);border:1px solid var(--line)">
              <span style="font-size:13px;color:var(--ink-mute)">טלפון</span>
              <b style="font-size:14px;direction:ltr"><?= htmlspecialchars($settings['phone'] ?? '035550188') ?></b>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:var(--bg);border-radius:var(--r);border:1px solid var(--line)">
              <span style="font-size:13px;color:var(--ink-mute)">אימייל</span>
              <b style="font-size:14px"><?= htmlspecialchars($settings['email'] ?? 'hello@moldovaplus.com') ?></b>
            </div>
          </div>
        </div>
      </div>

      <!-- Packages table -->
      <div class="admin-card">
        <div class="card-head">
          <div>
            <h2>חבילות פעילות באתר</h2>
            <p>כל <?= count($PACKAGES) ?> החבילות — לעריכה מלאה לחצו "עריכת חבילות"</p>
          </div>
          <a href="packages.php" class="btn-admin primary sm">עריכת חבילות</a>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>#</th>
              <th>שם החבילה</th>
              <th>סוג</th>
              <th>מחיר</th>
              <th>הנחה</th>
              <th>לילות</th>
              <th>דירוג</th>
              <th>סטטוס</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($PACKAGES as $p): ?>
            <tr>
              <td><b><?= $p['id'] ?></b></td>
              <td><b><?= htmlspecialchars($p['title_he']) ?></b></td>
              <td>
                <span class="badge <?= ['couples'=>'red','bach'=>'blue','lux'=>'yel','wine'=>'green','group'=>'gray','food'=>'yel','spa'=>'green','adv'=>'red'][$p['type']] ?? 'gray' ?>">
                  <?= ['couples'=>'זוגות','bach'=>'רווקים','lux'=>'יוקרה','wine'=>'יקב','group'=>'קבוצות','food'=>'גסטרו','spa'=>'ספא','adv'=>'אדרנלין'][$p['type']] ?? $p['type'] ?>
                </span>
              </td>
              <td>€<?= $p['price'] ?></td>
              <td><?= $p['discount'] > 0 ? '<span style="color:var(--red);font-weight:700">' . $p['discount'] . '%</span>' : '—' ?></td>
              <td><?= $p['nights'] ?></td>
              <td>★ <?= $p['rating'] ?></td>
              <td>
                <span class="badge <?= $p['status']==='now' ? 'green' : 'yel' ?>">
                  <?= $p['status']==='now' ? 'אישור מיידי' : 'יום עסקים' ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </main>
</div>
<script>
function updateClock() {
  const el = document.getElementById('admin-clock');
  if (el) el.textContent = new Date().toLocaleTimeString('he-IL', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
}
updateClock(); setInterval(updateClock, 1000);
</script>
</body>
</html>
