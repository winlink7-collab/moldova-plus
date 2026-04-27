<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$UPLOAD_DIR = __DIR__ . '/../assets/images/uploads/';
$UPLOAD_URL = '../assets/images/uploads/';
$ALLOWED    = ['image/jpeg','image/png','image/webp','image/gif'];
$MAX_SIZE   = 5 * 1024 * 1024; // 5MB

$msg   = '';
$error = '';

// --- DELETE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && mp_csrf_verify()) {
    $fname = basename($_POST['file'] ?? '');
    $fpath = $UPLOAD_DIR . $fname;
    if ($fname && file_exists($fpath) && is_file($fpath)) {
        unlink($fpath);
        $msg = 'התמונה נמחקה.';
    } else {
        $error = 'קובץ לא נמצא.';
    }
}

// --- UPLOAD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && mp_csrf_verify()) {
    $f = $_FILES['image'];
    if ($f['error'] === UPLOAD_ERR_OK) {
        if ($f['size'] > $MAX_SIZE) {
            $error = 'הקובץ גדול מ-5MB.';
        } else {
            $mime = mime_content_type($f['tmp_name']);
            if (!in_array($mime, $ALLOWED, true)) {
                $error = 'סוג קובץ לא מורשה. ניתן להעלות: JPG, PNG, WebP, GIF.';
            } else {
                $ext  = pathinfo($f['name'], PATHINFO_EXTENSION);
                $safe = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($f['name'], PATHINFO_FILENAME)));
                $name = ($safe ?: 'image') . '_' . time() . '.' . strtolower($ext);
                if (!is_dir($UPLOAD_DIR)) mkdir($UPLOAD_DIR, 0755, true);
                if (move_uploaded_file($f['tmp_name'], $UPLOAD_DIR . $name)) {
                    $msg = 'התמונה הועלתה בהצלחה!';
                } else {
                    $error = 'שגיאה בהעלאה — בדוק הרשאות תיקייה.';
                }
            }
        }
    } elseif ($f['error'] !== UPLOAD_ERR_NO_FILE) {
        $error = 'שגיאת העלאה (קוד ' . $f['error'] . ').';
    }
}

// --- LOAD IMAGES ---
$images = [];
if (is_dir($UPLOAD_DIR)) {
    foreach (glob($UPLOAD_DIR . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE) as $path) {
        $images[] = [
            'name' => basename($path),
            'url'  => $UPLOAD_URL . basename($path),
            'size' => filesize($path),
            'time' => filemtime($path),
        ];
    }
    usort($images, fn($a, $b) => $b['time'] - $a['time']);
}

function fmt_size(int $bytes): string {
    if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
    return round($bytes / 1024) . ' KB';
}
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>מדיה — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
  <style>
    .media-upload-zone {
      border: 2px dashed var(--border);
      border-radius: 14px;
      padding: 48px 24px;
      text-align: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
      background: #f8faff;
      position: relative;
    }
    .media-upload-zone.drag-over {
      border-color: var(--blue);
      background: #eef4ff;
    }
    .media-upload-zone input[type=file] {
      position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .media-upload-icon {
      width: 56px; height: 56px; border-radius: 14px;
      background: var(--blue); display: inline-flex; align-items: center; justify-content: center;
      margin-bottom: 14px;
    }
    .media-upload-zone h3 { font-size: 16px; font-weight: 700; margin: 0 0 6px; }
    .media-upload-zone p  { font-size: 13px; color: var(--ink-mute); margin: 0; }

    .media-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 16px;
      margin-top: 24px;
    }
    .media-card {
      border: 1px solid var(--border);
      border-radius: 12px;
      overflow: hidden;
      background: #fff;
      transition: box-shadow .2s;
    }
    .media-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.1); }
    .media-thumb {
      width: 100%; aspect-ratio: 4/3; object-fit: cover;
      display: block; background: #f0f2f5;
    }
    .media-card-body {
      padding: 10px 12px;
    }
    .media-name {
      font-size: 11px; font-weight: 600; color: var(--ink);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
      margin-bottom: 4px;
    }
    .media-meta { font-size: 11px; color: var(--ink-mute); margin-bottom: 8px; }
    .media-actions { display: flex; gap: 6px; }
    .media-actions button, .media-actions a {
      flex: 1; font-size: 11px; font-weight: 600; padding: 5px 0;
      border-radius: 7px; border: 1px solid var(--border); cursor: pointer;
      background: #f8faff; color: var(--ink); text-decoration: none;
      text-align: center; line-height: 1.4; transition: background .15s;
      font-family: inherit;
    }
    .media-actions button:hover { background: #eef4ff; }
    .media-actions .del-btn { color: var(--red); border-color: #fde8e8; background: #fff5f5; }
    .media-actions .del-btn:hover { background: #fde8e8; }
    .media-actions .copy-btn.copied { background: #e8f9f0; color: #0a7c42; border-color: #b7edcf; }

    .media-empty {
      text-align: center; padding: 60px 24px; color: var(--ink-mute);
    }
    .media-empty svg { margin-bottom: 14px; opacity: .3; }
    .media-empty p { font-size: 14px; margin: 0; }

    .upload-progress {
      display: none; margin-top: 12px;
      background: #e8f9f0; border-radius: 8px; padding: 10px 14px;
      font-size: 13px; color: #0a7c42; font-weight: 600;
    }
  </style>
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar">
      <div>
        <h1>מדיה</h1>
        <p>העלאה וניהול תמונות לשימוש באתר</p>
      </div>
      <label class="btn-admin primary" style="cursor:pointer">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 5 5 12"/></svg>
        העלה תמונה
        <input type="file" accept="image/*" style="display:none" id="topbar-upload" multiple>
      </label>
    </div>

    <div class="admin-content">
      <?php if ($msg): ?>
      <div class="alert success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
        <?= htmlspecialchars($msg) ?>
      </div>
      <?php endif; ?>
      <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <!-- Upload Zone -->
      <div class="admin-card">
        <div class="card-body" style="padding:20px">
          <form method="POST" enctype="multipart/form-data" id="upload-form">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <div class="media-upload-zone" id="drop-zone">
              <input type="file" name="image" accept="image/*" id="file-input">
              <div class="media-upload-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 5 5 12"/></svg>
              </div>
              <h3>גרור תמונה לכאן או לחץ לבחירה</h3>
              <p>JPG, PNG, WebP, GIF — עד 5MB</p>
            </div>
            <div class="upload-progress" id="upload-progress">מעלה תמונה...</div>
          </form>
        </div>
      </div>

      <!-- Stats -->
      <div style="display:flex;align-items:center;justify-content:space-between;margin:20px 0 8px">
        <h2 style="font-size:15px;font-weight:700;margin:0"><?= count($images) ?> תמונות</h2>
        <?php if ($images): ?>
        <span style="font-size:12px;color:var(--ink-mute)">לחץ "העתק URL" להוספה לחבילות / עיצוב</span>
        <?php endif; ?>
      </div>

      <!-- Gallery Grid -->
      <?php if ($images): ?>
      <div class="media-grid" id="media-grid">
        <?php foreach ($images as $img): ?>
        <div class="media-card" id="card-<?= htmlspecialchars($img['name']) ?>">
          <img src="<?= htmlspecialchars($img['url']) ?>" alt="" class="media-thumb" loading="lazy">
          <div class="media-card-body">
            <div class="media-name" title="<?= htmlspecialchars($img['name']) ?>"><?= htmlspecialchars($img['name']) ?></div>
            <div class="media-meta"><?= fmt_size($img['size']) ?></div>
            <div class="media-actions">
              <button class="copy-btn" data-url="<?= htmlspecialchars($img['url']) ?>" onclick="copyUrl(this)">העתק URL</button>
              <button class="del-btn" onclick="confirmDelete('<?= htmlspecialchars($img['name']) ?>', this)">מחק</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div class="media-empty">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        <p>עדיין לא הועלו תמונות</p>
      </div>
      <?php endif; ?>

      <!-- Hidden delete form -->
      <form method="POST" id="delete-form" style="display:none">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="file" id="delete-file">
      </form>
    </div>
  </main>
</div>

<script>
// Drag & Drop
const zone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-input');
const uploadForm = document.getElementById('upload-form');

zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
zone.addEventListener('drop', e => {
  e.preventDefault();
  zone.classList.remove('drag-over');
  if (e.dataTransfer.files.length) {
    fileInput.files = e.dataTransfer.files;
    submitUpload();
  }
});

fileInput.addEventListener('change', () => { if (fileInput.files.length) submitUpload(); });

// Topbar upload button
document.getElementById('topbar-upload').addEventListener('change', function() {
  if (this.files.length) {
    fileInput.files = this.files;
    submitUpload();
  }
});

function submitUpload() {
  document.getElementById('upload-progress').style.display = 'block';
  uploadForm.submit();
}

// Copy URL
function copyUrl(btn) {
  const url = btn.dataset.url;
  const abs = window.location.origin + '/' + url.replace('../', '');
  navigator.clipboard.writeText(abs).then(() => {
    btn.textContent = 'הועתק ✓';
    btn.classList.add('copied');
    setTimeout(() => { btn.textContent = 'העתק URL'; btn.classList.remove('copied'); }, 2000);
  });
}

// Delete
function confirmDelete(fname, btn) {
  if (!confirm('למחוק את "' + fname + '"?')) return;
  document.getElementById('delete-file').value = fname;
  document.getElementById('delete-form').submit();
}
</script>
</body>
</html>
