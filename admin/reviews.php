<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();
require_once __DIR__ . '/../includes/data.php';
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ביקורות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar"><div><h1>ביקורות</h1><p>ביקורות הלקוחות שמוצגות בעמוד הבית</p></div></div>
    <div class="admin-content">
      <div class="stats-row" style="grid-template-columns:repeat(3,1fr)">
        <div class="stat-box">
          <div class="stat-ic yel"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
          <div><div class="stat-val">4.9</div><div class="stat-label">דירוג ממוצע</div></div>
        </div>
        <div class="stat-box">
          <div class="stat-ic blue"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
          <div><div class="stat-val">4,247</div><div class="stat-label">סך ביקורות</div></div>
        </div>
        <div class="stat-box">
          <div class="stat-ic green"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg></div>
          <div><div class="stat-val"><?= count($REVIEWS) ?></div><div class="stat-label">מוצגות באתר</div></div>
        </div>
      </div>

      <div class="admin-card">
        <div class="card-head"><div><h2>ביקורות מוצגות</h2></div></div>
        <table class="admin-table">
          <thead><tr><th>שם</th><th>מקום</th><th>דירוג</th><th>ביקורת</th></tr></thead>
          <tbody>
            <?php foreach ($REVIEWS as $r): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <span style="width:32px;height:32px;border-radius:50%;background:<?= $r['color'] ?>;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0"><?= $r['initials'] ?></span>
                  <b><?= htmlspecialchars($r['name_he']) ?></b>
                </div>
              </td>
              <td><?= htmlspecialchars($r['place_he']) ?></td>
              <td><?= str_repeat('★', $r['stars']) ?></td>
              <td style="font-size:13px;max-width:300px"><?= htmlspecialchars(mb_strimwidth($r['body_he'], 0, 80, '...')) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="admin-card" style="margin-top:16px">
        <div class="card-body" style="padding:16px 20px">
          <p style="font-size:13px;color:var(--ink-mute);margin:0">לעריכת ביקורות — יש לערוך את הקובץ <code>includes/data.php</code> ישירות.</p>
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
