<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();
require_once __DIR__ . '/../includes/data.php';

$saved = false;
$error = '';

// Load uploaded images for the media picker
$UPLOAD_DIR = __DIR__ . '/../assets/images/uploads/';
$UPLOAD_URL = '../assets/images/uploads/';
$upload_images = [];
if (is_dir($UPLOAD_DIR)) {
    foreach (glob($UPLOAD_DIR . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE) as $path) {
        $upload_images[] = ['name' => basename($path), 'url' => $UPLOAD_URL . basename($path)];
    }
    usort($upload_images, fn($a,$b) => filemtime($UPLOAD_DIR.$b['name']) - filemtime($UPLOAD_DIR.$a['name']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && mp_csrf_verify()) {
    $overrides = mp_read_json('packages.json');
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $gallery_raw = $_POST['gallery_images'] ?? '[]';
        $gallery_arr = json_decode($gallery_raw, true);
        if (!is_array($gallery_arr)) $gallery_arr = [];
        $overrides[$id] = [
            'price'          => (int)($_POST['price'] ?? 0),
            'discount'       => (int)($_POST['discount'] ?? 0),
            'status'         => $_POST['status'] ?? 'now',
            'tag_he'         => trim($_POST['tag_he'] ?? ''),
            'tag_en'         => trim($_POST['tag_en'] ?? ''),
            'title_he'       => trim($_POST['title_he'] ?? ''),
            'loc_he'         => trim($_POST['loc_he'] ?? ''),
            'desc_he'        => trim($_POST['desc_he'] ?? ''),
            'nights'         => (int)($_POST['nights'] ?? 0),
            'people_he'      => trim($_POST['people_he'] ?? ''),
            'image_url'      => trim($_POST['image_url'] ?? ''),
            'gallery_images' => array_values(array_filter($gallery_arr)),
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
    .pkg-edit-form { padding:20px 24px; }
    .pkg-edit-form .form-group { margin:0; }
    .pkg-edit-grid-1 { display:grid; grid-template-columns:repeat(4,1fr) auto; gap:12px; align-items:end; margin-bottom:12px; }
    .pkg-edit-grid-2 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:12px; }
    .pkg-edit-grid-3 { display:grid; grid-template-columns:1fr 1fr auto; gap:12px; align-items:end; }
    .pkg-image-row { display:flex; gap:6px; }
    .pkg-image-row input { flex:1; min-width:0; }
    .pkg-image-preview { width:48px; height:36px; object-fit:cover; border-radius:6px; border:1px solid var(--border); display:none; }
    tr.editing td { background:#eef4ff; }

    /* Gallery strip */
    .gal-edit-section { margin-top:14px; padding-top:14px; border-top:1px solid var(--border); }
    .gal-edit-label { font-size:12px; font-weight:700; color:var(--ink-soft); margin-bottom:10px; display:flex; align-items:center; gap:8px; }
    .gal-edit-strip { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:10px; min-height:0; }
    .gal-thumb-wrap { position:relative; width:72px; height:54px; border-radius:8px; overflow:hidden; border:1px solid var(--border); }
    .gal-thumb-wrap img { width:100%; height:100%; object-fit:cover; display:block; }
    .gal-thumb-remove { position:absolute; top:2px; left:2px; width:18px; height:18px; background:rgba(0,0,0,.65); border:none; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#fff; font-size:11px; line-height:1; }
    .gal-thumb-remove:hover { background:#e53e3e; }
    .gal-add-btn { width:72px; height:54px; border:2px dashed var(--border); border-radius:8px; background:#f8faff; cursor:pointer; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:2px; color:var(--ink-mute); font-size:10px; font-weight:600; transition:border-color .15s; font-family:inherit; }
    .gal-add-btn:hover { border-color:var(--blue); color:var(--blue); }

    /* Media picker modal */
    .mp-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:9000; align-items:center; justify-content:center; }
    .mp-modal-overlay.open { display:flex; }
    .mp-modal { background:#fff; border-radius:16px; width:min(860px,94vw); max-height:88vh; display:flex; flex-direction:column; overflow:hidden; }
    .mp-modal-head { padding:18px 22px 14px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
    .mp-modal-head h3 { margin:0; font-size:16px; font-weight:800; }
    .mp-modal-close { border:none; background:none; cursor:pointer; color:var(--ink-mute); padding:4px; border-radius:6px; }
    .mp-modal-close:hover { background:#f0f2f5; color:var(--ink); }
    .mp-modal-toolbar { padding:12px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; flex-shrink:0; }
    .mp-upload-area { flex:1; border:2px dashed var(--border); border-radius:10px; padding:10px 16px; display:flex; align-items:center; gap:10px; cursor:pointer; position:relative; transition:border-color .15s; overflow:hidden; }
    .mp-upload-area:hover { border-color:var(--blue); }
    .mp-upload-area input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .mp-upload-area span { font-size:13px; color:var(--ink-soft); font-weight:600; }
    .mp-upload-progress { font-size:12px; color:var(--blue); font-weight:700; display:none; }
    .mp-modal-body { overflow-y:auto; padding:16px 22px; flex:1; }
    .mp-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(120px,1fr)); gap:10px; }
    .mp-item { border:2px solid transparent; border-radius:10px; overflow:hidden; cursor:pointer; transition:border-color .15s, box-shadow .15s; position:relative; }
    .mp-item img { width:100%; aspect-ratio:4/3; object-fit:cover; display:block; }
    .mp-item.selected { border-color:var(--blue); box-shadow:0 0 0 2px #dbeafe; }
    .mp-item .mp-check { position:absolute; top:6px; right:6px; width:22px; height:22px; border-radius:50%; background:var(--blue); color:#fff; display:none; align-items:center; justify-content:center; font-size:12px; font-weight:700; }
    .mp-item.selected .mp-check { display:flex; }
    .mp-item .mp-item-name { font-size:10px; padding:4px 6px; color:var(--ink-mute); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; background:#f8faff; }
    .mp-modal-foot { padding:14px 22px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; flex-shrink:0; }
    .mp-empty { text-align:center; padding:40px; color:var(--ink-mute); font-size:13px; }
  </style>
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <div>
        <h1>ניהול חבילות</h1>
        <p>עריכת מחיר, הנחה, תוכן ותגית לכל חבילה</p>
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
            <p>לחצו על "ערוך" לשינוי מחיר, הנחה, תוכן ותגית</p>
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
                  <div class="pkg-edit-grid-1">
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
                    <div></div>
                  </div>
                  <div class="pkg-edit-grid-2">
                    <div class="form-group">
                      <label>שם החבילה (עברית)</label>
                      <input type="text" name="title_he" value="<?= htmlspecialchars($ov['title_he'] ?? '') ?>" placeholder="<?= htmlspecialchars($p['title_he']) ?>">
                    </div>
                    <div class="form-group">
                      <label>מיקום (עברית)</label>
                      <input type="text" name="loc_he" value="<?= htmlspecialchars($ov['loc_he'] ?? '') ?>" placeholder="<?= htmlspecialchars($p['loc_he']) ?>">
                    </div>
                    <div class="form-group">
                      <label>אורחים (עברית)</label>
                      <input type="text" name="people_he" value="<?= htmlspecialchars($ov['people_he'] ?? '') ?>" placeholder="<?= htmlspecialchars($p['people_he']) ?>">
                    </div>
                  </div>
                  <div class="pkg-edit-grid-3">
                    <div class="form-group">
                      <label>תיאור (עברית)</label>
                      <textarea name="desc_he" rows="2" placeholder="<?= htmlspecialchars($p['desc_he']) ?>"><?= htmlspecialchars($ov['desc_he'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>תמונה ראשית</label>
                      <div class="pkg-image-row">
                        <img class="pkg-image-preview" id="prev-<?= $p['id'] ?>"
                          src="<?= htmlspecialchars($ov['image_url'] ?? '') ?>"
                          style="<?= !empty($ov['image_url']) ? 'display:block' : '' ?>">
                        <input type="text" name="image_url" id="img-<?= $p['id'] ?>"
                          value="<?= htmlspecialchars($ov['image_url'] ?? '') ?>" placeholder="https://...">
                        <button type="button" class="btn-admin ghost sm" style="white-space:nowrap"
                          onclick="openMediaPicker('single',<?= $p['id'] ?>)">בחר מהמדיה</button>
                        <label class="btn-admin ghost sm" style="white-space:nowrap;cursor:pointer">
                          העלה
                          <input type="file" accept="image/*" style="display:none"
                            onchange="quickUpload(this,'img-<?= $p['id'] ?>','prev-<?= $p['id'] ?>')">
                        </label>
                      </div>
                    </div>
                    <div style="display:flex;gap:8px;align-items:flex-end;padding-bottom:1px">
                      <button type="submit" class="btn-admin primary sm">שמור</button>
                      <button type="button" class="btn-admin ghost sm" onclick="toggleEdit(<?= $p['id'] ?>)">ביטול</button>
                    </div>
                  </div>

                  <!-- Gallery -->
                  <?php $gal_imgs = $ov['gallery_images'] ?? []; ?>
                  <input type="hidden" name="gallery_images" id="gal-data-<?= $p['id'] ?>"
                    value="<?= htmlspecialchars(json_encode($gal_imgs, JSON_UNESCAPED_UNICODE)) ?>">
                  <div class="gal-edit-section">
                    <div class="gal-edit-label">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                      גלריית תמונות
                      <span style="font-weight:400;color:var(--ink-mute);font-size:11px">(מוצגות בדף החבילה)</span>
                    </div>
                    <div class="gal-edit-strip" id="gal-strip-<?= $p['id'] ?>">
                      <?php foreach ($gal_imgs as $gurl): ?>
                      <div class="gal-thumb-wrap">
                        <img src="<?= htmlspecialchars($gurl) ?>" alt="">
                        <button type="button" class="gal-thumb-remove"
                          onclick="removeGalImg(<?= $p['id'] ?>,this)">×</button>
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <button type="button" class="gal-add-btn"
                      onclick="openMediaPicker('multi',<?= $p['id'] ?>)">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                      הוסף תמונות
                    </button>
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
          <span style="font-size:13px;color:var(--ink-soft)">שינויים כאן (מחיר/הנחה/סטטוס/תגית/תוכן/תמונה) נשמרים ב-<code>data/packages.json</code> ויחולו באתר אחרי Pull ב-Cloudways.</span>
        </div>
      </div>
    </div>
  </main>
</div>
<!-- Media Picker Modal -->
<div class="mp-modal-overlay" id="mp-modal-overlay">
  <div class="mp-modal">
    <div class="mp-modal-head">
      <h3 id="mp-modal-title">בחר תמונה</h3>
      <button class="mp-modal-close" onclick="closeMediaPicker()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="mp-modal-toolbar">
      <label class="mp-upload-area">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 5 5 12"/></svg>
        <span>גרור תמונה לכאן או לחץ להעלאה</span>
        <input type="file" accept="image/*" multiple id="mp-file-input" onchange="modalUpload(this)">
      </label>
      <div class="mp-upload-progress" id="mp-upload-progress">מעלה...</div>
    </div>
    <div class="mp-modal-body">
      <div class="mp-grid" id="mp-grid">
        <?php if ($upload_images): ?>
          <?php foreach ($upload_images as $img): ?>
          <div class="mp-item" data-url="<?= htmlspecialchars($img['url']) ?>" onclick="toggleMpItem(this)">
            <img src="<?= htmlspecialchars($img['url']) ?>" alt="" loading="lazy">
            <div class="mp-item-name"><?= htmlspecialchars($img['name']) ?></div>
            <div class="mp-check">✓</div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="mp-empty">עדיין לא הועלו תמונות — העלה תמונה ראשונה למעלה</div>
        <?php endif; ?>
      </div>
    </div>
    <div class="mp-modal-foot">
      <button class="btn-admin ghost sm" onclick="closeMediaPicker()">ביטול</button>
      <button class="btn-admin primary sm" id="mp-confirm-btn" onclick="confirmMediaPicker()">בחר</button>
    </div>
  </div>
</div>

<script>
// ── Toggle edit row ──────────────────────────────────────
function toggleEdit(id) {
  const row = document.getElementById('edit-' + id);
  const mainRow = document.getElementById('row-' + id);
  const isOpen = row.classList.contains('open');
  document.querySelectorAll('.pkg-edit-row.open').forEach(r => r.classList.remove('open'));
  document.querySelectorAll('tr.editing').forEach(r => r.classList.remove('editing'));
  if (!isOpen) { row.classList.add('open'); mainRow.classList.add('editing'); }
}

// ── Image preview helper ─────────────────────────────────
function updatePreview(inputId, previewId) {
  const val = document.getElementById(inputId)?.value || '';
  const prev = document.getElementById(previewId);
  if (prev) { prev.src = val; prev.style.display = val ? 'block' : 'none'; }
}
document.addEventListener('input', e => {
  if (e.target.name === 'image_url') {
    const id = e.target.id.replace('img-', '');
    updatePreview('img-' + id, 'prev-' + id);
  }
});

// ── Quick upload (inline file input) ────────────────────
function quickUpload(fileInput, imgFieldId, previewId) {
  if (!fileInput.files.length) return;
  const fd = new FormData();
  fd.append('image', fileInput.files[0]);
  fetch('upload.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(data => {
      if (data.error) { alert('שגיאה: ' + data.error); return; }
      const field = document.getElementById(imgFieldId);
      if (field) field.value = data.url;
      updatePreview(imgFieldId, previewId);
      addToModalGrid(data.url, data.name);
    })
    .catch(() => alert('שגיאת העלאה'));
}

// ── Media picker modal ───────────────────────────────────
let _mpMode   = 'single'; // 'single' | 'multi'
let _mpPkgId  = null;

function openMediaPicker(mode, pkgId) {
  _mpMode  = mode;
  _mpPkgId = pkgId;
  document.getElementById('mp-modal-title').textContent =
    mode === 'multi' ? 'בחר תמונות לגלרייה' : 'בחר תמונה ראשית';
  document.getElementById('mp-confirm-btn').textContent =
    mode === 'multi' ? 'הוסף לגלרייה' : 'בחר';
  // Clear selections
  document.querySelectorAll('.mp-item.selected').forEach(el => el.classList.remove('selected'));
  // Pre-select current gallery items
  if (mode === 'multi') {
    const hidden = document.getElementById('gal-data-' + pkgId);
    const current = JSON.parse(hidden?.value || '[]');
    current.forEach(url => {
      const el = document.querySelector('.mp-item[data-url="' + CSS.escape(url) + '"]');
      if (el) el.classList.add('selected');
    });
  }
  document.getElementById('mp-modal-overlay').classList.add('open');
}

function closeMediaPicker() {
  document.getElementById('mp-modal-overlay').classList.remove('open');
}

function toggleMpItem(el) {
  if (_mpMode === 'single') {
    document.querySelectorAll('.mp-item.selected').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
  } else {
    el.classList.toggle('selected');
  }
}

function confirmMediaPicker() {
  const selected = [...document.querySelectorAll('.mp-item.selected')].map(el => el.dataset.url);
  if (!selected.length) { closeMediaPicker(); return; }

  if (_mpMode === 'single') {
    const url = selected[0];
    const field = document.getElementById('img-' + _mpPkgId);
    const prev  = document.getElementById('prev-' + _mpPkgId);
    if (field) field.value = url;
    if (prev) { prev.src = url; prev.style.display = 'block'; }
  } else {
    // Replace gallery with selected set
    const hidden = document.getElementById('gal-data-' + _mpPkgId);
    const strip  = document.getElementById('gal-strip-' + _mpPkgId);
    if (!hidden || !strip) { closeMediaPicker(); return; }
    hidden.value = JSON.stringify(selected);
    renderGalStrip(_mpPkgId, selected);
  }
  closeMediaPicker();
}

function renderGalStrip(pkgId, urls) {
  const strip = document.getElementById('gal-strip-' + pkgId);
  strip.innerHTML = '';
  urls.forEach(url => {
    const wrap = document.createElement('div');
    wrap.className = 'gal-thumb-wrap';
    wrap.innerHTML = '<img src="' + escHtml(url) + '" alt="">' +
      '<button type="button" class="gal-thumb-remove" onclick="removeGalImg(' + pkgId + ',this)">×</button>';
    strip.appendChild(wrap);
  });
}

function removeGalImg(pkgId, btn) {
  const wrap = btn.closest('.gal-thumb-wrap');
  const url  = wrap.querySelector('img').src;
  const hidden = document.getElementById('gal-data-' + pkgId);
  let arr = JSON.parse(hidden.value || '[]');
  // Match relative or absolute URL
  arr = arr.filter(u => !url.endsWith(u.replace('../', '')) && u !== url);
  hidden.value = JSON.stringify(arr);
  wrap.remove();
}

// ── Modal upload ─────────────────────────────────────────
function modalUpload(fileInput) {
  const files = [...fileInput.files];
  if (!files.length) return;
  const prog = document.getElementById('mp-upload-progress');
  prog.style.display = 'inline';
  prog.textContent = 'מעלה ' + files.length + ' תמונ' + (files.length>1?'ות':'ה') + '...';

  const uploads = files.map(file => {
    const fd = new FormData();
    fd.append('image', file);
    return fetch('upload.php', { method: 'POST', body: fd }).then(r => r.json());
  });

  Promise.all(uploads).then(results => {
    prog.style.display = 'none';
    results.forEach(data => {
      if (!data.error) addToModalGrid(data.url, data.name);
    });
    // Auto-select newly uploaded in multi mode
    if (_mpMode === 'multi') {
      results.forEach(data => {
        if (!data.error) {
          const el = document.querySelector('.mp-item[data-url="' + data.url + '"]');
          if (el) el.classList.add('selected');
        }
      });
    }
  }).catch(() => { prog.style.display = 'none'; alert('שגיאת העלאה'); });

  fileInput.value = '';
}

function addToModalGrid(url, name) {
  // Remove empty state if present
  const empty = document.querySelector('.mp-empty');
  if (empty) empty.remove();

  const grid = document.getElementById('mp-grid');
  const item = document.createElement('div');
  item.className = 'mp-item';
  item.dataset.url = url;
  item.setAttribute('onclick', 'toggleMpItem(this)');
  item.innerHTML = '<img src="' + escHtml(url) + '" alt="" loading="lazy">' +
    '<div class="mp-item-name">' + escHtml(name) + '</div>' +
    '<div class="mp-check">✓</div>';
  grid.insertBefore(item, grid.firstChild);
}

function escHtml(s) {
  return s.replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// Close modal on overlay click
document.getElementById('mp-modal-overlay').addEventListener('click', function(e) {
  if (e.target === this) closeMediaPicker();
});
</script>
</body>
</html>
