<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();
require_once __DIR__ . '/../includes/data.php';

$saved = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && mp_csrf_verify()) {
    $overrides = mp_read_json('packages.json');
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $overrides[$id] = [
            'price'    => (int)($_POST['price'] ?? 0),
            'discount' => (int)($_POST['discount'] ?? 0),
            'status'   => $_POST['status'] ?? 'now',
            'tag_he'   => trim($_POST['tag_he'] ?? ''),
            'tag_en'   => trim($_POST['tag_en'] ?? ''),
        ];
        if (mp_write_json('packages.json', $overrides)) {
            $saved = true;
        } else {
            $error = 'שגיאה בשמירה';
        }
    }
}

$overrides = mp_read_json('packages.json');

$type_labels = [
    'couples'=>'זוגות','bach'=>'רווקים','lux'=>'יוקרה',
    'wine'=>'יקב','group'=>'קבוצות','food'=>'גסטרו',
    'spa'=>'ספא','adv'=>'אדרנלין'
];
$type_colors = [
    'couples'=>'red','bach'=>'blue','lux'=>'yel',
    'wine'=>'green','group'=>'gray','food'=>'yel',
    'spa'=>'green','adv'=>'red'
];
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>חבילות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
  <style>
    .pkg-edit-row { display:none; background:#f8faff; }
    .pkg-edit-row.open { display:table-row; }
    .pkg-edit-form { padding:20px 24px; display:grid; grid-template-columns:repeat(4,1fr) auto; gap:12px; align-items:end; }
    .pkg-edit-form .form-group { margin:0; }
    tr.editing td { background:#eef4ff; }
  </style>
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <div>
        <h1>ניהול חבילות</h1>
        <p>עריכת מחיר, הנחה ותגית לכל חבילה</p>
      </div>
    </div>
    <div class="admin-content">
      <?php if ($saved): ?>
      <div class="alert success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
        החבילה עודכנה בהצלחה!
      </div>
      <?php endif; ?>
      <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="admin-card">
        <div class="card-head">
          <div>
            <h2>כל החבילות</h2>
            <p>לחצו על "ערוך" לשינוי מחיר, הנחה ותגית</p>
          </div>
          <span class="badge blue"><?= count($PACKAGES) ?> חבילות</span>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>#</th>
              <th>שם החבילה</th>
              <th>סוג</th>
              <th>מחיר (€)</th>
              <th>הנחה</th>
              <th>לילות</th>
              <th>דירוג</th>
              <th>סטטוס</th>
              <th>תגית</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($PACKAGES as $p):
              $ov = $overrides[$p['id']] ?? [];
              $price    = $ov['price']    ?? $p['price'];
              $discount = $ov['discount'] ?? $p['discount'];
              $status   = $ov['status']   ?? $p['status'];
              $tag_he   = $ov['tag_he']   ?? $p['tag_he'];
            ?>
            <tr id="row-<?= $p['id'] ?>">
              <td><b><?= $p['id'] ?></b></td>
              <td>
                <b><?= htmlspecialchars($p['title_he']) ?></b>
                <div style="font-size:11px;color:var(--ink-mute);margin-top:2px"><?= htmlspecialchars($p['loc_he']) ?></div>
              </td>
              <td><span class="badge <?= $type_colors[$p['type']] ?? 'gray' ?>"><?= $type_labels[$p['type']] ?? $p['type'] ?></span></td>
              <td><b style="color:var(--blue)">€<?= $price ?></b></td>
              <td><?= $discount > 0 ? '<span style="color:var(--red);font-weight:700">' . $discount . '%</span>' : '<span style="color:var(--ink-mute)">—</span>' ?></td>
              <td><?= $p['nights'] ?></td>
              <td>★ <?= $p['rating'] ?></td>
              <td><span class="badge <?= $status==='now'?'green':'yel' ?>"><?= $status==='now'?'אישור מיידי':'יום עסקים' ?></span></td>
              <td><?= $tag_he ? '<span class="badge blue">' . htmlspecialchars($tag_he) . '</span>' : '<span style="color:var(--ink-mute);font-size:12px">—</span>' ?></td>
              <td>
                <button class="btn-admin ghost sm" onclick="toggleEdit(<?= $p['id'] ?>)">ערוך</button>
              </td>
            </tr>
            <tr class="pkg-edit-row" id="edit-<?= $p['id'] ?>">
              <td colspan="10">
                <form method="POST" class="pkg-edit-form">
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <div class="form-group">
                    <label>מחיר (€)</label>
                    <input type="number" name="price" value="<?= $price ?>" min="1">
                  </div>
                  <div class="form-group">
                    <label>הנחה (%)</label>
                    <input type="number" name="discount" value="<?= $discount ?>" min="0" max="99">
                  </div>
                  <div class="form-group">
                    <label>סטטוס</label>
                    <select name="status">
                      <option value="now" <?= $status==='now'?'selected':'' ?>>אישור מיידי</option>
                      <option value="day" <?= $status==='day'?'selected':'' ?>>יום עסקים</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>תגית (עברית)</label>
                    <input type="text" name="tag_he" value="<?= htmlspecialchars($tag_he) ?>" placeholder="הכי פופולרי">
                  </div>
                  <div style="display:flex;gap:8px;padding-bottom:1px">
                    <button type="submit" class="btn-admin primary sm">שמור</button>
                    <button type="button" class="btn-admin ghost sm" onclick="toggleEdit(<?= $p['id'] ?>)">ביטול</button>
                  </div>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="admin-card" style="margin-top:16px">
        <div class="card-body" style="display:flex;align-items:center;gap:12px;padding:16px 20px">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span style="font-size:13px;color:var(--ink-soft)">שינויים כאן (מחיר/הנחה/סטטוס/תגית) נשמרים ב-<code>data/packages.json</code> ויחולו באתר אחרי Pull ב-Cloudways.</span>
        </div>
      </div>
    </div>
  </main>
</div>
<script>
function toggleEdit(id) {
  const row = document.getElementById('edit-' + id);
  const mainRow = document.getElementById('row-' + id);
  const isOpen = row.classList.contains('open');
  document.querySelectorAll('.pkg-edit-row.open').forEach(r => r.classList.remove('open'));
  document.querySelectorAll('tr.editing').forEach(r => r.classList.remove('editing'));
  if (!isOpen) { row.classList.add('open'); mainRow.classList.add('editing'); }
}
</script>
</body>
</html>
