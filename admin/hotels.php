<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$UPLOAD_DIR = __DIR__ . '/../assets/images/uploads/';
$UPLOAD_URL = '../assets/images/uploads/';
$upload_images = [];
if (is_dir($UPLOAD_DIR)) {
    foreach (glob($UPLOAD_DIR . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE) as $path) {
        $upload_images[] = ['name' => basename($path), 'url' => $UPLOAD_URL . basename($path)];
    }
}

$msg = ''; $error = '';

// Default hotels (same as hotels.php)
$hotels_default = [
  ['id'=>1,'name_he'=>'Nobil Luxury Boutique Hotel','name_en'=>'Nobil Luxury Boutique Hotel','stars'=>5,'rating'=>'9.6','area_he'=>'מרכז העיר','area_en'=>'City Center','price'=>89,'desc_he'=>'מלון בוטיק יוקרתי במרכז קישינב. עיצוב מודרני, ספא, מסעדת שף ושירות אישי ברמה הגבוהה ביותר.','desc_en'=>'Luxury boutique hotel in the heart of Chișinău. Modern design, spa, chef restaurant and top-tier personal service.','tags_he'=>['ספא','מסעדה','בריכה'],'tags_en'=>['Spa','Restaurant','Pool'],'scene'=>'blue','status'=>'פעיל'],
  ['id'=>2,'name_he'=>'Hotel Leogrand & Convention Centre','name_en'=>'Hotel Leogrand & Convention Centre','stars'=>5,'rating'=>'9.2','area_he'=>'רובע עסקים','area_en'=>'Business District','price'=>75,'desc_he'=>'המלון הגדול בקישינב. מרכז כנסים, בריכת שחייה, ספא מלא ומסעדה פרנקו-מולדבית מפורסמת.','desc_en'=>"Chișinău's largest hotel. Conference centre, swimming pool, full spa and a renowned Franco-Moldovan restaurant.",'tags_he'=>['כנסים','ספא','בריכה'],'tags_en'=>['Conferences','Spa','Pool'],'scene'=>'dark','status'=>'פעיל'],
  ['id'=>3,'name_he'=>'Radisson Blu Leogrand Hotel','name_en'=>'Radisson Blu Leogrand Hotel','stars'=>5,'rating'=>'9.4','area_he'=>"בולבר סטפן צ'ל מארה",'area_en'=>'Stefan cel Mare Blvd','price'=>110,'desc_he'=>'רשת Radisson Blu בלב קישינב. חדרים מרווחים, מרכז כושר, בר וגישה מהירה לאטרקציות המרכזיות.','desc_en'=>'Radisson Blu brand in the heart of Chișinău. Spacious rooms, fitness center, bar and quick access to top attractions.','tags_he'=>['כושר','בר','Wi-Fi חינם'],'tags_en'=>['Fitness','Bar','Free Wi-Fi'],'scene'=>'light','status'=>'פעיל'],
  ['id'=>4,'name_he'=>'Hotel Jolly Alon','name_en'=>'Hotel Jolly Alon','stars'=>4,'rating'=>'8.8','area_he'=>'מרכז העיר','area_en'=>'City Center','price'=>55,'desc_he'=>'מלון ארבעה כוכבים נוח ונגיש. מיקום מצוין, חדרים מודרניים וארוחת בוקר בופה עשירה.','desc_en'=>'Comfortable and accessible 4-star hotel. Great location, modern rooms and a rich breakfast buffet.','tags_he'=>['ארוחת בוקר','חניה','Wi-Fi'],'tags_en'=>['Breakfast','Parking','Wi-Fi'],'scene'=>'warm','status'=>'פעיל'],
  ['id'=>5,'name_he'=>'Hotel Griff','name_en'=>'Hotel Griff','stars'=>4,'rating'=>'8.5','area_he'=>'פארק הציבורי','area_en'=>'Central Park area','price'=>48,'desc_he'=>'מלון ארבעה כוכבים בנוף ירוק. סמוך לפארק הציבורי של קישינב. מחיר מצוין לעומת איכות גבוהה.','desc_en'=>"4-star hotel with green views, close to Chișinău's main public park. Excellent value for money.",'tags_he'=>['נוף לפארק','רסטורנט','Wi-Fi'],'tags_en'=>['Park view','Restaurant','Wi-Fi'],'scene'=>'green','status'=>'פעיל'],
  ['id'=>6,'name_he'=>'Hotel Dacia','name_en'=>'Hotel Dacia','stars'=>3,'rating'=>'8.1','area_he'=>'רובע ישן','area_en'=>'Old Quarter','price'=>32,'desc_he'=>'מלון שלושה כוכבים בעל אופי, ברובע ההיסטורי של קישינב. האווירה המקומית האמיתית במחיר נגיש.','desc_en'=>'Characterful 3-star hotel in the historic quarter of Chișinău. Authentic local atmosphere at a budget-friendly price.','tags_he'=>['מיקום היסטורי','Wi-Fi','בר'],'tags_en'=>['Historic location','Wi-Fi','Bar'],'scene'=>'city','status'=>'פעיל'],
];

// Build merged hotels list: defaults + JSON overrides + JSON-only entries
$_hotels_raw = mp_read_json('hotels.json');
$_json_by_id = [];
foreach ($_hotels_raw as $_hj) {
    if (isset($_hj['id'])) $_json_by_id[(int)$_hj['id']] = $_hj;
}
$hotels = [];
$_default_ids = array_column($hotels_default, 'id');
foreach ($hotels_default as $_hd) {
    $hotels[] = isset($_json_by_id[$_hd['id']]) ? array_merge($_hd, $_json_by_id[$_hd['id']]) : $_hd;
}
// Add JSON-only entries (new hotels added from admin)
foreach ($_json_by_id as $_id => $_hj) {
    if (!in_array($_id, $_default_ids)) $hotels[] = $_hj;
}

// --- DELETE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && mp_csrf_verify()) {
    $del_id = (int)($_POST['id'] ?? 0);
    $_raw = mp_read_json('hotels.json');
    $_raw = array_values(array_filter($_raw, fn($h) => (int)($h['id'] ?? 0) !== $del_id));
    mp_write_json('hotels.json', $_raw) ? $msg = 'המלון נמחק.' : $error = 'שגיאה במחיקה.';
    // rebuild merged list
    $_hotels_raw = mp_read_json('hotels.json');
    $_json_by_id = [];
    foreach ($_hotels_raw as $_hj) { if (isset($_hj['id'])) $_json_by_id[(int)$_hj['id']] = $_hj; }
    $hotels = [];
    foreach ($hotels_default as $_hd) {
        if ($del_id === (int)$_hd['id']) continue; // deleted default — skip only if not in json
        $hotels[] = isset($_json_by_id[$_hd['id']]) ? array_merge($_hd, $_json_by_id[$_hd['id']]) : $_hd;
    }
    foreach ($_json_by_id as $_id => $_hj) {
        if (!in_array($_id, $_default_ids)) $hotels[] = $_hj;
    }
}

// --- SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save' && mp_csrf_verify()) {
    $save_id = (int)($_POST['id'] ?? 0);
    $tags_he = array_values(array_filter(array_map('trim', explode(',', $_POST['tags_he'] ?? ''))));
    $tags_en = array_values(array_filter(array_map('trim', explode(',', $_POST['tags_en'] ?? ''))));
    $_raw = mp_read_json('hotels.json');
    $entry = [
        'id'        => $save_id ?: (count($hotels) ? max(array_column($hotels,'id')) + 1 : 7),
        'name_he'   => trim($_POST['name_he'] ?? ''),
        'name_en'   => trim($_POST['name_en'] ?? ''),
        'stars'     => max(1, min(5, (int)($_POST['stars'] ?? 4))),
        'rating'    => trim($_POST['rating'] ?? ''),
        'area_he'   => trim($_POST['area_he'] ?? ''),
        'area_en'   => trim($_POST['area_en'] ?? ''),
        'price'     => (int)($_POST['price'] ?? 0),
        'desc_he'   => trim($_POST['desc_he'] ?? ''),
        'desc_en'   => trim($_POST['desc_en'] ?? ''),
        'tags_he'   => $tags_he,
        'tags_en'   => $tags_en,
        'scene'     => trim($_POST['scene'] ?? 'warm'),
        'image_url' => trim($_POST['image_url'] ?? ''),
        'status'    => trim($_POST['status'] ?? 'פעיל'),
        'whatsapp'     => preg_replace('/\D/', '', $_POST['whatsapp'] ?? ''),
        'whatsapp_url' => trim($_POST['whatsapp_url'] ?? ''),
    ];
    if ($save_id) {
        $found = false;
        foreach ($_raw as &$h) { if ((int)($h['id'] ?? 0) === $save_id) { $h = $entry; $found = true; break; } }
        unset($h);
        if (!$found) $_raw[] = $entry;
    } else {
        $_raw[] = $entry;
    }
    mp_write_json('hotels.json', array_values($_raw)) ? $msg = 'נשמר בהצלחה!' : $error = 'שגיאה בשמירה.';
    // rebuild merged list
    $_hotels_raw = mp_read_json('hotels.json');
    $_json_by_id = [];
    foreach ($_hotels_raw as $_hj) { if (isset($_hj['id'])) $_json_by_id[(int)$_hj['id']] = $_hj; }
    $hotels = [];
    foreach ($hotels_default as $_hd) {
        $hotels[] = isset($_json_by_id[$_hd['id']]) ? array_merge($_hd, $_json_by_id[$_hd['id']]) : $_hd;
    }
    foreach ($_json_by_id as $_id => $_hj) {
        if (!in_array($_id, $_default_ids)) $hotels[] = $_hj;
    }
}

$edit_id = isset($_GET['edit']) && $_GET['edit'] !== 'new' ? (int)$_GET['edit'] : 0;
$edit = null;
if (isset($_GET['edit'])) {
    if ($_GET['edit'] === 'new') {
        $edit = [];
    } else {
        foreach ($hotels as $h) { if ((int)($h['id'] ?? 0) === $edit_id) { $edit = $h; break; } }
    }
}
$scenes = ['warm','dark','light','green','gold','blue','honey','city'];
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
      <div style="display:flex;gap:8px">
        <a href="packages.php" class="btn-admin ghost sm">✈️ חבילות</a>
        <a href="attractions.php" class="btn-admin ghost sm">📍 אטרקציות</a>
        <a href="../hotels.php" target="_blank" class="btn-admin ghost sm">צפה בדף</a>
        <a href="hotels.php?edit=new" class="btn-admin primary">+ הוסף מלון</a>
      </div>
    </div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Edit/Add Form -->
      <?php if (isset($_GET['edit'])): ?>
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><h2><?= $edit && !empty($edit) ? 'עריכת מלון' : 'הוסף מלון חדש' ?></h2></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= $edit['id'] ?? 0 ?>">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>שם המלון (עברית)</label>
                <input type="text" name="name_he" value="<?= htmlspecialchars($edit['name_he'] ?? $edit['name'] ?? '') ?>" placeholder="Nobil Luxury Boutique" required>
              </div>
              <div class="form-group">
                <label>Hotel name (English)</label>
                <input type="text" name="name_en" value="<?= htmlspecialchars($edit['name_en'] ?? $edit['name'] ?? '') ?>" placeholder="Nobil Luxury Boutique" style="direction:ltr">
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>📱 מספר וואטסאפ להזמנה (עם קידומת, ללא +)</label>
                <input type="text" name="whatsapp" value="<?= htmlspecialchars($edit['whatsapp'] ?? '') ?>" placeholder="972501234567" style="direction:ltr">
                <small style="color:var(--ink-mute);font-size:11px">ריק = ישתמש במספר הכללי של האתר</small>
              </div>
              <div class="form-group">
                <label>כתובת URL ישירה לוואטסאפ (לינק מותאם אישית)</label>
                <input type="text" name="whatsapp_url" value="<?= htmlspecialchars($edit['whatsapp_url'] ?? '') ?>" placeholder="https://wa.me/972501234567?text=..." style="direction:ltr">
                <small style="color:var(--ink-mute);font-size:11px">אופציונלי — עוקף את המספר הרגיל לחלוטין</small>
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>כוכבים</label>
                <select name="stars">
                  <?php for($s=5;$s>=1;$s--): ?>
                  <option value="<?= $s ?>" <?= ($edit['stars'] ?? 4)==$s?'selected':'' ?>><?= $s ?> ★</option>
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
                <label>Scene (רקע)</label>
                <select name="scene">
                  <?php foreach ($scenes as $sc): ?>
                  <option value="<?= $sc ?>" <?= ($edit['scene'] ?? 'warm')===$sc?'selected':'' ?>><?= $sc ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>סטטוס</label>
                <select name="status">
                  <option value="פעיל" <?= ($edit['status'] ?? '')==='פעיל'?'selected':'' ?>>פעיל</option>
                  <option value="לא פעיל" <?= ($edit['status'] ?? '')==='לא פעיל'?'selected':'' ?>>לא פעיל</option>
                </select>
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:12px">
              <div class="form-group">
                <label>אזור (עברית)</label>
                <input type="text" name="area_he" value="<?= htmlspecialchars($edit['area_he'] ?? '') ?>" placeholder="מרכז העיר">
              </div>
              <div class="form-group">
                <label>Area (English)</label>
                <input type="text" name="area_en" value="<?= htmlspecialchars($edit['area_en'] ?? '') ?>" placeholder="City Center" style="direction:ltr">
              </div>
              <div class="form-group">
                <label>תיאור (עברית)</label>
                <textarea name="desc_he" rows="3" placeholder="תיאור קצר..."><?= htmlspecialchars($edit['desc_he'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>Description (English)</label>
                <textarea name="desc_en" rows="3" style="direction:ltr" placeholder="Short description..."><?= htmlspecialchars($edit['desc_en'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>תגיות (עברית, מופרדות בפסיק)</label>
                <?php $_th = $edit['tags_he'] ?? []; if (is_string($_th)) $_th = explode(',', $_th); ?>
                <input type="text" name="tags_he" value="<?= htmlspecialchars(implode(', ', array_filter(array_map('trim', $_th)))) ?>" placeholder="ספא, מסעדה, בריכה">
              </div>
              <div class="form-group">
                <label>Tags (English, comma-separated)</label>
                <?php $_te = $edit['tags_en'] ?? []; if (is_string($_te)) $_te = explode(',', $_te); ?>
                <input type="text" name="tags_en" value="<?= htmlspecialchars(implode(', ', array_filter(array_map('trim', $_te)))) ?>" placeholder="Spa, Restaurant, Pool" style="direction:ltr">
              </div>
            </div>
            <div class="form-group" style="margin-bottom:12px">
              <label>תמונה — העלה או הדבק URL</label>
              <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                <input type="text" name="image_url" id="hotel-img-url" value="<?= htmlspecialchars($edit['image_url'] ?? '') ?>" placeholder="https://... או העלה תמונה ←" style="flex:1;min-width:200px">
                <label class="btn-admin ghost sm" style="cursor:pointer;margin:0">
                  📁 העלה תמונה
                  <input type="file" id="hotel-img-file" accept="image/*" style="display:none">
                </label>
                <?php if ($upload_images): ?>
                <select id="hotel-media-select" onchange="document.getElementById('hotel-img-url').value=this.value;document.getElementById('hotel-img-preview').src=this.value;document.getElementById('hotel-img-preview').style.display='block';this.selectedIndex=0" style="max-width:180px">
                  <option value="">בחר מהמדיה...</option>
                  <?php foreach ($upload_images as $img): ?>
                  <option value="<?= htmlspecialchars($img['url']) ?>"><?= htmlspecialchars($img['name']) ?></option>
                  <?php endforeach; ?>
                </select>
                <?php endif; ?>
              </div>
              <div id="hotel-img-upload-status" style="font-size:12px;margin-top:4px;color:var(--blue)"></div>
              <?php if (!empty($edit['image_url'])): ?>
              <img id="hotel-img-preview" src="<?= htmlspecialchars($edit['image_url']) ?>" style="margin-top:8px;max-height:120px;border-radius:6px;object-fit:cover;display:block">
              <?php else: ?>
              <img id="hotel-img-preview" src="" style="margin-top:8px;max-height:120px;border-radius:6px;object-fit:cover;display:none">
              <?php endif; ?>
            </div>
            <script>
            var _hotelCsrf = <?= json_encode(mp_csrf()) ?>;
            document.getElementById('hotel-img-file').addEventListener('change', function() {
              var file = this.files[0]; if (!file) return;
              var status = document.getElementById('hotel-img-upload-status');
              status.textContent = 'מעלה...';
              status.style.color = 'var(--blue)';
              var fd = new FormData();
              fd.append('image', file);
              fd.append('csrf', _hotelCsrf);
              fetch('upload.php', {method:'POST', body:fd})
                .then(function(r){return r.json();})
                .then(function(d){
                  if (d.url || d.abs) {
                    var url = d.abs || d.url;
                    document.getElementById('hotel-img-url').value = url;
                    var prev = document.getElementById('hotel-img-preview');
                    prev.src = url; prev.style.display = 'block';
                    status.textContent = '✓ הועלה בהצלחה: ' + d.name;
                    status.style.color = 'var(--green)';
                    // Add to media dropdown
                    var sel = document.getElementById('hotel-media-select');
                    if (sel) {
                      var opt = document.createElement('option');
                      opt.value = url; opt.textContent = d.name;
                      sel.insertBefore(opt, sel.options[1]);
                    }
                  } else {
                    status.textContent = 'שגיאה: ' + (d.error || 'לא ידוע');
                    status.style.color = 'var(--red)';
                  }
                }).catch(function(){status.textContent='שגיאת רשת';status.style.color='var(--red)';});
            });
            </script>
            <div style="display:flex;gap:10px">
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
          <div><h2>רשימת מלונות</h2><p><?= count($hotels) ?> מלונות — מוצגים בדף hotels.php</p></div>
        </div>
        <table class="admin-table">
          <thead><tr><th>שם</th><th>★</th><th>מחיר/לילה</th><th>דירוג</th><th>אזור</th><th>סטטוס</th><th></th></tr></thead>
          <tbody>
            <?php if ($hotels): ?>
            <?php foreach ($hotels as $h): ?>
            <tr>
              <td><b><?= htmlspecialchars($h['name_he'] ?? $h['name'] ?? '') ?></b></td>
              <td><?= str_repeat('★', (int)($h['stars'] ?? 0)) ?></td>
              <td><b style="color:var(--blue)">$<?= (int)($h['price'] ?? 0) ?></b>/לילה</td>
              <td>★ <?= htmlspecialchars($h['rating'] ?? '') ?></td>
              <td><?= htmlspecialchars($h['area_he'] ?? '') ?></td>
              <td><span class="badge <?= ($h['status'] ?? 'פעיל')==='פעיל'?'green':'gray' ?>"><?= htmlspecialchars($h['status'] ?? 'פעיל') ?></span></td>
              <td>
                <div style="display:flex;gap:6px">
                  <a href="hotels.php?edit=<?= $h['id'] ?>" class="btn-admin ghost sm">ערוך</a>
                  <form method="POST" style="display:inline" onsubmit="return confirm('למחוק?')">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $h['id'] ?>">
                    <button type="submit" class="btn-admin ghost sm" style="color:var(--red)">מחק</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--ink-mute)">אין מלונות עדיין — לחץ "+ הוסף מלון" להוספת המלון הראשון</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="admin-card" style="margin-top:16px">
        <div class="card-body" style="padding:14px 20px;font-size:13px;color:var(--ink-soft)">
          <b>שים לב:</b> מלונות שנוספים כאן מוצגים בדף hotels.php. כל עוד הרשימה ריקה — יוצגו המלונות הברירת מחדל.
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
