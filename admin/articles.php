<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';
$articles = mp_read_json('articles.json');

// --- DELETE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && mp_csrf_verify()) {
    $del_id = $_POST['art_id'] ?? '';
    $articles = array_values(array_filter($articles, fn($a) => ($a['id'] ?? '') !== $del_id));
    mp_write_json('articles.json', $articles) ? $msg = 'המאמר נמחק.' : $error = 'שגיאה במחיקה.';
    $articles = mp_read_json('articles.json');
}

// --- SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save' && mp_csrf_verify()) {
    $art_id_orig = trim($_POST['art_id_orig'] ?? '');
    $art_id      = trim($_POST['art_id'] ?? '');
    if (!$art_id) $art_id = preg_replace('/[^a-z0-9-]/', '', strtolower(str_replace(' ', '-', trim($_POST['title_he'] ?? 'article')))) ?: 'article-' . time();
    $entry = [
        'id'            => $art_id,
        'tag_he'        => trim($_POST['tag_he'] ?? ''),
        'tag_en'        => trim($_POST['tag_en'] ?? ''),
        'scene'         => trim($_POST['scene'] ?? 'warm'),
        'title_he'      => trim($_POST['title_he'] ?? ''),
        'title_en'      => trim($_POST['title_en'] ?? ''),
        'desc_he'       => trim($_POST['desc_he'] ?? ''),
        'desc_en'       => trim($_POST['desc_en'] ?? ''),
        'date'          => trim($_POST['date'] ?? ''),
        'read'          => trim($_POST['read'] ?? '5'),
        'related_types' => array_values(array_filter(array_map('trim', explode(',', $_POST['related_types'] ?? '')))),
        'body_he'       => trim($_POST['body_he'] ?? ''),
        'body_en'       => trim($_POST['body_en'] ?? ''),
    ];
    if ($art_id_orig && $art_id_orig !== $art_id) {
        // id changed — replace by orig
        foreach ($articles as &$a) { if (($a['id'] ?? '') === $art_id_orig) { $a = $entry; break; } }
        unset($a);
    } elseif ($art_id_orig) {
        foreach ($articles as &$a) { if (($a['id'] ?? '') === $art_id_orig) { $a = $entry; break; } }
        unset($a);
    } else {
        $articles[] = $entry;
    }
    mp_write_json('articles.json', array_values($articles)) ? $msg = 'נשמר בהצלחה!' : $error = 'שגיאה בשמירה.';
    $articles = mp_read_json('articles.json');
}

$edit_id = $_GET['edit'] ?? null;
$edit = null;
if ($edit_id !== null && $edit_id !== 'new') {
    foreach ($articles as $a) { if (($a['id'] ?? '') === $edit_id) { $edit = $a; break; } }
}
if ($edit_id === 'new') $edit = [];

$scenes = ['warm','dark','light','green','gold','blue','honey','city'];
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>מאמרים — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
  <style>
    .art-form textarea { font-family: monospace; font-size: 12px; }
  </style>
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <div><h1>מאמרים</h1><p>ניהול המאמרים המוצגים בדף הבית ובדף המאמרים</p></div>
      <a href="articles.php?edit=new" class="btn-admin primary">+ הוסף מאמר</a>
    </div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Edit/Add Form -->
      <?php if (isset($_GET['edit'])): ?>
      <div class="admin-card art-form" style="margin-bottom:20px">
        <div class="card-head"><h2><?= $edit && !empty($edit) ? 'עריכת מאמר' : 'הוסף מאמר חדש' ?></h2></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="art_id_orig" value="<?= htmlspecialchars($edit['id'] ?? '') ?>">

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>ID / slug (אנגלית, ייחודי)</label>
                <input type="text" name="art_id" value="<?= htmlspecialchars($edit['id'] ?? '') ?>" placeholder="moldova-2026" style="direction:ltr">
              </div>
              <div class="form-group">
                <label>תגית (עברית)</label>
                <input type="text" name="tag_he" value="<?= htmlspecialchars($edit['tag_he'] ?? '') ?>" placeholder="מדריך">
              </div>
              <div class="form-group">
                <label>Tag (English)</label>
                <input type="text" name="tag_en" value="<?= htmlspecialchars($edit['tag_en'] ?? '') ?>" placeholder="Guide" style="direction:ltr">
              </div>
              <div class="form-group">
                <label>Scene</label>
                <select name="scene">
                  <?php foreach ($scenes as $sc): ?>
                  <option value="<?= $sc ?>" <?= ($edit['scene'] ?? 'warm') === $sc ? 'selected' : '' ?>><?= $sc ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>כותרת (עברית)</label>
                <input type="text" name="title_he" value="<?= htmlspecialchars($edit['title_he'] ?? '') ?>" placeholder="הסיבה שמולדובה הפכה ליעד החם" required>
              </div>
              <div class="form-group">
                <label>Title (English)</label>
                <input type="text" name="title_en" value="<?= htmlspecialchars($edit['title_en'] ?? '') ?>" placeholder="Why Moldova became the hottest destination" style="direction:ltr">
              </div>
              <div class="form-group">
                <label>תיאור קצר (עברית)</label>
                <textarea name="desc_he" rows="2" placeholder="תיאור מקוצר..."><?= htmlspecialchars($edit['desc_he'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>Short description (English)</label>
                <textarea name="desc_en" rows="2" placeholder="Short description..." style="direction:ltr"><?= htmlspecialchars($edit['desc_en'] ?? '') ?></textarea>
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>תאריך (תצוגה, כגון 14.04.2026)</label>
                <input type="text" name="date" value="<?= htmlspecialchars($edit['date'] ?? '') ?>" placeholder="14.04.2026">
              </div>
              <div class="form-group">
                <label>זמן קריאה (דקות)</label>
                <input type="text" name="read" value="<?= htmlspecialchars($edit['read'] ?? '5') ?>" placeholder="5">
              </div>
              <div class="form-group">
                <label>חבילות קשורות (CSV: couples,lux,spa)</label>
                <input type="text" name="related_types" value="<?= htmlspecialchars(implode(', ', $edit['related_types'] ?? [])) ?>" placeholder="couples,lux,spa" style="direction:ltr">
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
              <div class="form-group">
                <label>תוכן המאמר — HTML (עברית)</label>
                <textarea name="body_he" rows="12" placeholder="&lt;p&gt;תוכן...&lt;/p&gt;"><?= htmlspecialchars($edit['body_he'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>Article body — HTML (English)</label>
                <textarea name="body_en" rows="12" style="direction:ltr" placeholder="&lt;p&gt;Content...&lt;/p&gt;"><?= htmlspecialchars($edit['body_en'] ?? '') ?></textarea>
              </div>
            </div>
            <div style="display:flex;gap:10px">
              <button type="submit" class="btn-admin primary">שמור</button>
              <a href="articles.php" class="btn-admin ghost">ביטול</a>
            </div>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <!-- Table -->
      <div class="admin-card">
        <div class="card-head">
          <div><h2>רשימת מאמרים</h2><p><?= count($articles) ?> מאמרים<?= empty($articles) ? ' — יוצגו ברירת המחדל' : '' ?></p></div>
        </div>
        <table class="admin-table">
          <thead><tr><th>כותרת</th><th>תגית</th><th>תאריך</th><th>קריאה</th><th></th></tr></thead>
          <tbody>
            <?php if ($articles): ?>
            <?php foreach ($articles as $a): ?>
            <tr>
              <td>
                <b><?= htmlspecialchars($a['title_he'] ?? '') ?></b>
                <div style="font-size:11px;color:var(--ink-mute)"><?= htmlspecialchars($a['id'] ?? '') ?></div>
              </td>
              <td><span class="badge gray"><?= htmlspecialchars($a['tag_he'] ?? '') ?></span></td>
              <td><?= htmlspecialchars($a['date'] ?? '') ?></td>
              <td><?= htmlspecialchars($a['read'] ?? '') ?> דק׳</td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="articles.php?edit=<?= urlencode($a['id'] ?? '') ?>" class="btn-admin ghost sm">ערוך</a>
                  <form method="POST" style="display:inline" onsubmit="return confirm('למחוק?')">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="art_id" value="<?= htmlspecialchars($a['id'] ?? '') ?>">
                    <button type="submit" class="btn-admin ghost sm" style="color:var(--red)">מחק</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--ink-mute)">אין מאמרים — יוצגו ברירת המחדל. לחץ "+ הוסף מאמר" לעריכה.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="admin-card" style="margin-top:16px">
        <div class="card-body" style="padding:14px 20px;font-size:13px;color:var(--ink-soft)">
          <b>שים לב:</b> מאמרים שנוספים כאן מחליפים את כל המאמרים המוגדרים כברירת מחדל. אם הרשימה ריקה — יוצגו המאמרים המובנים.
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
