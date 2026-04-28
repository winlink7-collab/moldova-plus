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
        // Show a tiny discreet admin-login button for non-admins
        echo '<a href="admin/" id="le-admin-hint" title="Admin login" style="position:fixed;bottom:12px;left:12px;z-index:9999;width:28px;height:28px;background:rgba(15,23,42,.55);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-size:13px;opacity:.35;transition:opacity .2s" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=.35">🔐</a>';
        return;
    }
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    $csrf = $_SESSION['csrf'];
?>
<link rel="stylesheet" href="assets/css/live-editor.css">
<div id="le-bar">
  <div class="le-logo">M+</div>
  <button id="le-edit-btn" onclick="leToggle()">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    <span id="le-btn-txt">מצב עריכה</span>
  </button>
  <span id="le-hint">לחץ על כל טקסט כחול לעריכה &nbsp;·&nbsp; Enter = שמור &nbsp;·&nbsp; Esc = ביטול</span>
  <span id="le-status"></span>
  <a href="admin/" id="le-admin-link">
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
    פאנל ניהול
  </a>
  <button id="le-exit-btn" onclick="leToggle()">✕ יציאה</button>
</div>
<script>
window.LE_CSRF     = '<?= htmlspecialchars($csrf, ENT_QUOTES) ?>';
window.LE_SAVE_URL = 'admin/live-save.php';
</script>
<script src="assets/js/live-editor.js"></script>
<?php
}
