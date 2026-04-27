<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';

$reviews = mp_read_json('reviews.json');

// --- DELETE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && mp_csrf_verify()) {
    $id = (int)($_POST['id'] ?? 0);
    $reviews = array_values(array_filter($reviews, fn($r) => (int)$r['id'] !== $id));
    mp_write_json('reviews.json', $reviews) ? $msg = 'הביקורת נמחקה.' : $error = 'שגיאה במחיקה.';
    $reviews = mp_read_json('reviews.json');
}

// --- SAVE (add or edit) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save' && mp_csrf_verify()) {
    $id      = (int)($_POST['id'] ?? 0);
    $entry = [
        'id'       => $id ?: (count($reviews) ? max(array_column($reviews,'id')) + 1 : 1),
        'name_he'  => trim($_POST['name_he'] ?? ''),
        'place_he' => trim($_POST['place_he'] ?? ''),
        'body_he'  => trim($_POST['body_he'] ?? ''),
        'stars'    => max(1, min(5, (int)($_POST['stars'] ?? 5))),
        'when'     => trim($_POST['when'] ?? date('d.m.Y')),
        'initials' => mb_substr(trim($_POST['name_he'] ?? ''), 0, 1),
        'color'    => trim($_POST['color'] ?? '#0046ae'),
    ];
    if ($id) {
        foreach ($reviews as &$r) { if ((int)$r['id'] === $id) { $r = $entry; break; } }
        unset($r);
    } else {
        $reviews[] = $entry;
    }
    mp_write_json('reviews.json', array_values($reviews)) ? $msg = 'נשמר בהצלחה!' : $error = 'שגיאה בשמירה.';
    $reviews = mp_read_json('reviews.json');
}

$edit_id = (int)($_GET['edit'] ?? 0);
$edit = $edit_id ? (array_values(array_filter($reviews, fn($r) => (int)$r['id'] === $edit_id))[0] ?? null) : null;
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
    <div class="admin-topbar">
      <div><h1>ביקורות</h1><p>ניהול ביקורות המוצגות בעמוד הבית</p></div>
      <a href="reviews.php?edit=new" class="btn-admin primary">+ הוסף ביקורת</a>
    </div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Add / Edit form -->
      <?php if (isset($_GET['edit'])): ?>
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><h2><?= $edit ? 'עריכת ביקורת' : 'הוסף ביקורת חדשה' ?></h2></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= $edit ? $edit['id'] : 0 ?>">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>שם הלקוח</label>
                <input type="text" name="name_he" value="<?= htmlspecialchars($edit['name_he'] ?? '') ?>" placeholder="דניאל ב׳" required>
              </div>
              <div class="form-group">
                <label>שם החבילה / חוויה</label>
                <input type="text" name="place_he" value="<?= htmlspecialchars($edit['place_he'] ?? '') ?>" placeholder="מסיבת רווקים אולטימטיבית" required>
              </div>
              <div class="form-group">
                <label>דירוג (כוכבים)</label>
                <select name="stars">
                  <?php for($s=5;$s>=1;$s--): ?>
                  <option value="<?= $s ?>" <?= ($edit['stars'] ?? 5)==$s?'selected':'' ?>><?= str_repeat('★',$s) ?> (<?= $s ?>)</option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="form-group">
                <label>תאריך</label>
                <input type="text" name="when" value="<?= htmlspecialchars($edit['when'] ?? date('d.m.Y')) ?>" placeholder="18.04.2026">
              </div>
              <div class="form-group">
                <label>צבע אווטאר</label>
                <input type="color" name="color" value="<?= htmlspecialchars($edit['color'] ?? '#0046ae') ?>" style="height:42px;padding:4px 8px;cursor:pointer">
              </div>
            </div>
            <div class="form-group" style="margin-top:4px">
              <label>תוכן הביקורת</label>
              <textarea name="body_he" rows="3" placeholder="כתבו את הביקורת כאן..." required><?= htmlspecialchars($edit['body_he'] ?? '') ?></textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:4px">
              <button type="submit" class="btn-admin primary">שמור</button>
              <a href="reviews.php" class="btn-admin ghost">ביטול</a>
            </div>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <!-- Reviews table -->
      <div class="admin-card">
        <div class="card-head">
          <div><h2>כל הביקורות</h2><p><?= count($reviews) ?> ביקורות מוצגות באתר</p></div>
          <div style="display:flex;align-items:center;gap:8px">
            <div class="stat-ic yel" style="width:32px;height:32px;border-radius:8px"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
            <span style="font-weight:700;font-size:15px">4.9 ממוצע</span>
          </div>
        </div>
        <table class="admin-table">
          <thead><tr><th>לקוח</th><th>חבילה</th><th>דירוג</th><th>ביקורת</th><th>תאריך</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($reviews as $r): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <span style="width:32px;height:32px;border-radius:50%;background:<?= htmlspecialchars($r['color']) ?>;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0"><?= htmlspecialchars($r['initials']) ?></span>
                  <b><?= htmlspecialchars($r['name_he']) ?></b>
                </div>
              </td>
              <td><?= htmlspecialchars($r['place_he']) ?></td>
              <td><?= str_repeat('★', (int)$r['stars']) ?></td>
              <td style="font-size:13px;max-width:260px;color:var(--ink-soft)"><?= htmlspecialchars(mb_strimwidth($r['body_he'], 0, 70, '...')) ?></td>
              <td style="white-space:nowrap;color:var(--ink-mute);font-size:12px"><?= htmlspecialchars($r['when']) ?></td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="reviews.php?edit=<?= $r['id'] ?>" class="btn-admin ghost sm">ערוך</a>
                  <form method="POST" style="display:inline" onsubmit="return confirm('למחוק ביקורת זו?')">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                    <button type="submit" class="btn-admin ghost sm" style="color:var(--red)">מחק</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (!$reviews): ?>
            <tr><td colspan="6" style="text-align:center;color:var(--ink-mute);padding:32px">אין ביקורות. הוסף ביקורת ראשונה.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </main>
</div>
</body>
</html>
