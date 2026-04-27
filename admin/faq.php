<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';
$faqs = mp_read_json('faq.json');

$cats = ['booking'=>'הזמנה','flights'=>'טיסות','hotels'=>'מלונות','cancel'=>'ביטולים','general'=>'כללי'];

// --- DELETE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && mp_csrf_verify()) {
    $id = (int)($_POST['id'] ?? 0);
    $faqs = array_values(array_filter($faqs, fn($f) => (int)$f['id'] !== $id));
    mp_write_json('faq.json', $faqs) ? $msg = 'השאלה נמחקה.' : $error = 'שגיאה במחיקה.';
    $faqs = mp_read_json('faq.json');
}

// --- SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save' && mp_csrf_verify()) {
    $id = (int)($_POST['id'] ?? 0);
    $entry = [
        'id'    => $id ?: (count($faqs) ? max(array_column($faqs,'id')) + 1 : 1),
        'cat'   => trim($_POST['cat'] ?? 'general'),
        'q_he'  => trim($_POST['q_he'] ?? ''),
        'a_he'  => trim($_POST['a_he'] ?? ''),
    ];
    if ($id) {
        foreach ($faqs as &$f) { if ((int)$f['id'] === $id) { $f = $entry; break; } }
        unset($f);
    } else {
        $faqs[] = $entry;
    }
    mp_write_json('faq.json', array_values($faqs)) ? $msg = 'נשמר בהצלחה!' : $error = 'שגיאה בשמירה.';
    $faqs = mp_read_json('faq.json');
}

$edit_id = (int)($_GET['edit'] ?? 0);
$edit = $edit_id ? (array_values(array_filter($faqs, fn($f) => (int)$f['id'] === $edit_id))[0] ?? null) : null;
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>שאלות נפוצות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <div><h1>שאלות נפוצות (FAQ)</h1><p>ניהול השאלות והתשובות בדף FAQ</p></div>
      <div style="display:flex;gap:10px">
        <a href="../faq.php" target="_blank" class="btn-admin ghost sm">צפה בדף FAQ</a>
        <a href="faq.php?edit=new" class="btn-admin primary">+ הוסף שאלה</a>
      </div>
    </div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Form -->
      <?php if (isset($_GET['edit'])): ?>
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><h2><?= $edit ? 'עריכת שאלה' : 'הוסף שאלה חדשה' ?></h2></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= $edit ? $edit['id'] : 0 ?>">
            <div style="display:grid;grid-template-columns:1fr 2fr;gap:16px">
              <div class="form-group">
                <label>קטגוריה</label>
                <select name="cat">
                  <?php foreach ($cats as $k => $v): ?>
                  <option value="<?= $k ?>" <?= ($edit['cat'] ?? 'general')===$k?'selected':'' ?>><?= $v ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>שאלה (עברית)</label>
                <input type="text" name="q_he" value="<?= htmlspecialchars($edit['q_he'] ?? '') ?>" placeholder="כתוב את השאלה כאן..." required>
              </div>
            </div>
            <div class="form-group">
              <label>תשובה (עברית)</label>
              <textarea name="a_he" rows="4" placeholder="כתוב את התשובה כאן..." required><?= htmlspecialchars($edit['a_he'] ?? '') ?></textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:4px">
              <button type="submit" class="btn-admin primary">שמור</button>
              <a href="faq.php" class="btn-admin ghost">ביטול</a>
            </div>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <!-- Table by category -->
      <?php foreach ($cats as $cat_id => $cat_label):
        $cat_items = array_values(array_filter($faqs, fn($f) => $f['cat'] === $cat_id));
        if (!$cat_items) continue;
      ?>
      <div class="admin-card" style="margin-bottom:16px">
        <div class="card-head">
          <div><h2><?= $cat_label ?></h2><p><?= count($cat_items) ?> שאלות</p></div>
        </div>
        <table class="admin-table">
          <thead><tr><th>#</th><th>שאלה</th><th>תשובה</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($cat_items as $f): ?>
            <tr>
              <td style="color:var(--ink-mute);font-size:12px"><?= $f['id'] ?></td>
              <td><b style="font-size:13px"><?= htmlspecialchars($f['q_he']) ?></b></td>
              <td style="font-size:12px;color:var(--ink-soft);max-width:320px"><?= htmlspecialchars(mb_strimwidth($f['a_he'], 0, 90, '...')) ?></td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="faq.php?edit=<?= $f['id'] ?>" class="btn-admin ghost sm">ערוך</a>
                  <form method="POST" style="display:inline" onsubmit="return confirm('למחוק שאלה זו?')">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $f['id'] ?>">
                    <button type="submit" class="btn-admin ghost sm" style="color:var(--red)">מחק</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endforeach; ?>

    </div>
  </main>
</div>
</body>
</html>
