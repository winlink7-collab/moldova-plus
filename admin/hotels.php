<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();
require_once __DIR__ . '/../includes/data.php';
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>מלונות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar"><div><h1>מלונות בקישינב</h1><p>סקירת המלונות הפעילים באתר</p></div></div>
    <div class="admin-content">
      <?php
      $hotels = [
        ['name'=>'Nobil Luxury Boutique','stars'=>5,'price'=>89,'rating'=>'9.8','status'=>'פעיל'],
        ['name'=>'Leogrand Hotel & Convention','stars'=>5,'price'=>75,'rating'=>'9.6','status'=>'פעיל'],
        ['name'=>'Radisson Blu','stars'=>5,'price'=>110,'rating'=>'9.7','status'=>'פעיל'],
        ['name'=>'Jolly Alon','stars'=>4,'price'=>55,'rating'=>'9.2','status'=>'פעיל'],
        ['name'=>'Griff Hotel','stars'=>4,'price'=>48,'rating'=>'9.0','status'=>'פעיל'],
        ['name'=>'Hotel Dacia','stars'=>3,'price'=>32,'rating'=>'8.7','status'=>'פעיל'],
      ];
      ?>
      <div class="admin-card">
        <div class="card-head">
          <div><h2>רשימת מלונות</h2><p><?= count($hotels) ?> מלונות רשומים</p></div>
          <a href="../hotels.php" target="_blank" class="btn-admin ghost sm">צפה בדף המלונות</a>
        </div>
        <table class="admin-table">
          <thead>
            <tr><th>שם המלון</th><th>כוכבים</th><th>מחיר ללילה ($)</th><th>דירוג</th><th>סטטוס</th></tr>
          </thead>
          <tbody>
            <?php foreach ($hotels as $h): ?>
            <tr>
              <td><b><?= htmlspecialchars($h['name']) ?></b></td>
              <td><?= str_repeat('★', $h['stars']) ?></td>
              <td><b style="color:var(--blue)">$<?= $h['price'] ?></b>/לילה</td>
              <td>★ <?= $h['rating'] ?></td>
              <td><span class="badge green"><?= $h['status'] ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="admin-card" style="margin-top:16px">
        <div class="card-body" style="padding:16px 20px">
          <p style="font-size:13px;color:var(--ink-mute);margin:0">לעריכת פרטי מלון — יש לערוך את הקובץ <code>hotels.php</code> ישירות.</p>
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
