<?php
// Live Visual Editor — auto-loaded via functions.php for all front-end pages
if (session_status() === PHP_SESSION_NONE) session_start();
define('LE_ADMIN', !empty($_SESSION['mp_admin_ok']));

// Returns " data-le="file:id:field"" (with leading space) or '' for non-admins
function le(string $key): string {
    return LE_ADMIN ? ' data-le="' . htmlspecialchars($key, ENT_QUOTES) . '"' : '';
}

// Returns " data-le-img="key"" for image-swap targets
function le_img(string $key): string {
    return LE_ADMIN ? ' data-le-img="' . htmlspecialchars($key, ENT_QUOTES) . '"' : '';
}

// Output the editor toolbar + JS at page bottom (called from page_foot)
function le_footer(): void {
    if (!LE_ADMIN) {
        // Clear "Edit Site" tab — visible to admin users who aren't logged in yet
        $return = rawurlencode($_SERVER['REQUEST_URI'] ?? '/');
?>
<style>
#le-access-tab{position:fixed;bottom:0;left:50%;transform:translateX(-50%);z-index:99999;background:#0f172a;color:#e2e8f0;padding:9px 28px 10px;border-radius:12px 12px 0 0;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 -4px 24px rgba(0,0,0,.35);font-family:'Heebo',sans-serif;white-space:nowrap;transition:background .15s,transform .15s;}
#le-access-tab:hover{background:#1e3a5f;transform:translateX(-50%) translateY(-2px);}
#le-access-tab svg{flex-shrink:0}
</style>
<a href="admin/login.php?return=<?= $return ?>" id="le-access-tab">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
  עריכת האתר
</a>
<?php
        return;
    }
    $key    = $_COOKIE['admin_token'] ?? (session_id() ?: 'anon');
    $csrf   = substr(hash_hmac('sha256', $key . date('YmdH'), 'MoldovaPlus_CSRF_2026'), 0, 40);
?>
<link rel="stylesheet" href="/assets/css/live-editor.css">
<div id="le-bar">
  <div class="le-logo">M+</div>

  <button id="le-edit-btn" onclick="leToggle()">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    <span id="le-btn-txt">✏ ערוך דף</span>
  </button>

  <span id="le-hint">
    לחץ על כל טקסט לעריכה &nbsp;·&nbsp;
    לחץ על תמונה להחלפה &nbsp;·&nbsp;
    Enter = שמור &nbsp;·&nbsp; Esc = ביטול
  </span>

  <span id="le-status"></span>

  <a href="admin/" id="le-admin-link" target="_blank">
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
    פאנל ניהול
  </a>

  <a href="admin/logout.php?return=<?= rawurlencode($_SERVER['REQUEST_URI'] ?? '/') ?>" id="le-exit-btn">
    ✕ יציאה
  </a>
</div>
<script>
window.LE_CSRF     = '<?= htmlspecialchars($csrf, ENT_QUOTES) ?>';
window.LE_SAVE_URL = '/admin/live-save.php';
</script>
<script src="/assets/js/live-editor.js"></script>
<?php
}
