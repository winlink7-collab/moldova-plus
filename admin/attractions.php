<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';
$attractions = mp_read_json('attractions.json');

// --- DELETE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && mp_csrf_verify()) {
    $id = (int)($_POST['id'] ?? 0);
    $attractions = array_values(array_filter($attractions, fn($a) => (int)$a['id'] !== $id));
    mp_write_json('attractions.json', $attractions) ? $msg = 'האטרקציה נמחקה.' : $error = 'שגיאה במחיקה.';
    $attractions = mp_read_json('attractions.json');
}

// --- SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save' && mp_csrf_verify()) {
    $id = (int)($_POST['id'] ?? 0);
    $entry = [
        'id'    => $id ?: (count($attractions) ? max(array_column($attractions,'id')) + 1 : 1),
        'he'    => trim($_POST['he'] ?? ''),
        'en'    => trim($_POST['en'] ?? ''),
        'he2'   => trim($_POST['he2'] ?? ''),
        'en2'   => trim($_POST['en2'] ?? ''),
        'cat'   => trim($_POST['cat'] ?? 'wine'),
        'scene' => trim($_POST['scene'] ?? 'warm'),
    ];
    if ($id) {
        foreach ($attractions as &$a) { if ((int)$a['id'] === $id) { $a = $entry; break; } }
        unset($a);
    } else {
        $attractions[] = $entry;
    }
    mp_write_json('attractions.json', array_values($attractions)) ? $msg = 'נשמר בהצלחה!' : $error = 'שגיאה בשמירה.';
    $attractions = mp_read_json('attractions.json');
}

$edit_id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$edit = null;
if ($edit_id) {
    foreach ($attractions as $a) { if ((int)$a['id'] === $edit_id) { $edit = $a; break; } }
}
if (isset($_GET['edit']) && $_GET['edit'] === 'new') $edit = [];

$cats   = ['wine'=>'יקב / יין','culture'=>'תרבות','food'=>'אוכל','adrenaline'=>'אדרנלין','nightlife'=>'חיי לילה'];
$scenes = ['warm','dark','light','green','gold','blue','honey','city'];
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>אטרקציות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <div><h1>אטרקציות</h1><p>ניהול האטרקציות המוצגות בדף "אטרקציות" ובאתר</p></div>
      <div style="display:flex;gap:10px">
        <a href="../attractions.php" target="_blank" class="btn-admin ghost sm">צפה בדף</a>
        <a href="attractions.php?edit=new" class="btn-admin primary">+ הוסף אטרקציה</a>
      </div>
    </div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Edit/Add Form -->
      <?php if (isset($_GET['edit'])): ?>
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><h2><?= $edit && !empty($edit) ? 'עריכת אטרקציה' : 'הוסף אטרקציה חדשה' ?></h2></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= $edit['id'] ?? 0 ?>">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>שם (עברית)</label>
                <input type="text" name="he" value="<?= htmlspecialchars($edit['he'] ?? '') ?>" placeholder="יקב Mileștii Mici" required>
              </div>
              <div class="form-group">
                <label>Name (English)</label>
                <input type="text" name="en" value="<?= htmlspecialchars($edit['en'] ?? '') ?>" placeholder="Mileștii Mici Winery" style="direction:ltr">
              </div>
              <div class="form-group">
                <label>תת-כותרת (עברית)</label>
                <input type="text" name="he2" value="<?= htmlspecialchars($edit['he2'] ?? '') ?>" placeholder='200 ק"מ של מנהרות תת-קרקעיות'>
              </div>
              <div class="form-group">
                <label>Subtitle (English)</label>
                <input type="text" name="en2" value="<?= htmlspecialchars($edit['en2'] ?? '') ?>" placeholder="200km of underground tunnels" style="direction:ltr">
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
              <div class="form-group">
                <label>קטגוריה</label>
                <select name="cat">
                  <?php foreach ($cats as $k => $v): ?>
                  <option value="<?= $k ?>" <?= ($edit['cat'] ?? 'wine') === $k ? 'selected' : '' ?>><?= $v ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Scene (רקע)</label>
                <select name="scene">
                  <?php foreach ($scenes as $sc): ?>
                  <option value="<?= $sc ?>" <?= ($edit['scene'] ?? 'warm') === $sc ? 'selected' : '' ?>><?= $sc ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div style="display:flex;gap:10px">
              <button type="submit" class="btn-admin primary">שמור</button>
              <a href="attractions.php" class="btn-admin ghost">ביטול</a>
            </div>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <!-- Table -->
      <div class="admin-card">
        <div class="card-head">
          <div><h2>רשימת אטרקציות</h2><p><?= count($attractions) ?> אטרקציות — <?= empty($attractions) ? 'יוצגו ברירת המחדל' : 'מחליפות את ברירת המחדל' ?></p></div>
        </div>
        <table class="admin-table">
          <thead><tr><th>שם</th><th>תת-כותרת</th><th>קטגוריה</th><th>Scene</th><th></th></tr></thead>
          <tbody>
            <?php if ($attractions): ?>
            <?php foreach ($attractions as $a): ?>
            <tr>
              <td><b><?= htmlspecialchars($a['he']) ?></b><div style="font-size:11px;color:var(--ink-mute)"><?= htmlspecialchars($a['en']) ?></div></td>
              <td><?= htmlspecialchars($a['he2'] ?? '') ?></td>
              <td><span class="badge gray"><?= htmlspecialchars($cats[$a['cat']] ?? $a['cat']) ?></span></td>
              <td><?= htmlspecialchars($a['scene']) ?></td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="attractions.php?edit=<?= $a['id'] ?>" class="btn-admin ghost sm">ערוך</a>
                  <form method="POST" style="display:inline" onsubmit="return confirm('למחוק?')">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $a['id'] ?>">
                    <button type="submit" class="btn-admin ghost sm" style="color:var(--red)">מחק</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--ink-mute)">אין אטרקציות — יוצגו ברירת מחדל. לחץ "+ הוסף אטרקציה" לעריכה.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </main>
</div>
</body>
</html>
