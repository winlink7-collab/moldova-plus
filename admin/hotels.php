<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';
$hotels = mp_read_json('hotels.json');

// --- DELETE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && mp_csrf_verify()) {
    $id = (int)($_POST['id'] ?? 0);
    $hotels = array_values(array_filter($hotels, fn($h) => (int)$h['id'] !== $id));
    mp_write_json('hotels.json', $hotels) ? $msg = 'המלון נמחק.' : $error = 'שגיאה במחיקה.';
    $hotels = mp_read_json('hotels.json');
}

// --- SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save' && mp_csrf_verify()) {
    $id = (int)($_POST['id'] ?? 0);
    $entry = [
        'id'     => $id ?: (count($hotels) ? max(array_column($hotels,'id')) + 1 : 1),
        'name'   => trim($_POST['name'] ?? ''),
        'stars'  => max(1, min(5, (int)($_POST['stars'] ?? 4))),
        'price'  => (int)($_POST['price'] ?? 0),
        'rating' => trim($_POST['rating'] ?? ''),
        'status' => trim($_POST['status'] ?? 'פעיל'),
    ];
    if ($id) {
        foreach ($hotels as &$h) { if ((int)$h['id'] === $id) { $h = $entry; break; } }
        unset($h);
    } else {
        $hotels[] = $entry;
    }
    mp_write_json('hotels.json', array_values($hotels)) ? $msg = 'נשמר בהצלחה!' : $error = 'שגיאה בשמירה.';
    $hotels = mp_read_json('hotels.json');
}

$edit_id = (int)($_GET['edit'] ?? 0);
$edit = $edit_id ? (array_values(array_filter($hotels, fn($h) => (int)$h['id'] === $edit_id))[0] ?? null) : null;
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
    <div class="admin-topbar">
      <div><h1>מלונות בקישינב</h1><p>ניהול המלונות המוצגים באתר</p></div>
      <div style="display:flex;gap:10px">
        <a href="../hotels.php" target="_blank" class="btn-admin ghost sm">צפה בדף המלונות</a>
        <a href="hotels.php?edit=new" class="btn-admin primary">+ הוסף מלון</a>
      </div>
    </div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Form -->
      <?php if (isset($_GET['edit'])): ?>
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><h2><?= $edit ? 'עריכת מלון' : 'הוסף מלון חדש' ?></h2></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= $edit ? $edit['id'] : 0 ?>">
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr;gap:16px;align-items:end">
              <div class="form-group">
                <label>שם המלון</label>
                <input type="text" name="name" value="<?= htmlspecialchars($edit['name'] ?? '') ?>" placeholder="Nobil Luxury Boutique" required>
              </div>
              <div class="form-group">
                <label>כוכבים</label>
                <select name="stars">
                  <?php for($s=5;$s>=1;$s--): ?>
                  <option value="<?= $s ?>" <?= ($edit['stars'] ?? 4)==$s?'selected':'' ?>><?= $s ?> כוכבים</option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="form-group">
                <label>מחיר/לילה ($)</label>
                <input type="number" name="price" value="<?= $edit['price'] ?? '' ?>" min="1" placeholder="89">
              </div>
              <div class="form-group">
                <label>דירוג</label>
                <input type="text" name="rating" value="<?= htmlspecialchars($edit['rating'] ?? '') ?>" placeholder="9.8">
              </div>
              <div class="form-group">
                <label>סטטוס</label>
                <select name="status">
                  <option value="פעיל" <?= ($edit['status'] ?? '')==='פעיל'?'selected':'' ?>>פעיל</option>
                  <option value="לא פעיל" <?= ($edit['status'] ?? '')==='לא פעיל'?'selected':'' ?>>לא פעיל</option>
                </select>
              </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:8px">
              <button type="submit" class="btn-admin primary">שמור</button>
              <a href="hotels.php" class="btn-admin ghost">ביטול</a>
            </div>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <!-- Table -->
      <div class="admin-card">
        <div class="card-head">
          <div><h2>רשימת מלונות</h2><p><?= count($hotels) ?> מלונות רשומים</p></div>
        </div>
        <table class="admin-table">
          <thead><tr><th>שם המלון</th><th>כוכבים</th><th>מחיר/לילה</th><th>דירוג</th><th>סטטוס</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($hotels as $h): ?>
            <tr>
              <td><b><?= htmlspecialchars($h['name']) ?></b></td>
              <td><?= str_repeat('★', (int)$h['stars']) ?></td>
              <td><b style="color:var(--blue)">$<?= (int)$h['price'] ?></b>/לילה</td>
              <td>★ <?= htmlspecialchars($h['rating']) ?></td>
              <td><span class="badge <?= $h['status']==='פעיל'?'green':'gray' ?>"><?= htmlspecialchars($h['status']) ?></span></td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="hotels.php?edit=<?= $h['id'] ?>" class="btn-admin ghost sm">ערוך</a>
                  <form method="POST" style="display:inline" onsubmit="return confirm('למחוק מלון זה?')">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $h['id'] ?>">
                    <button type="submit" class="btn-admin ghost sm" style="color:var(--red)">מחק</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>
</body>
</html>
