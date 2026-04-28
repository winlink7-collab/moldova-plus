(function () {
  'use strict';

  var editMode = false;
  var popup    = null;
  var activeEl = null;
  var activeKey = null;

  // ── Build popup (once) ────────────────────────────────────
  function buildPopup() {
    var p = document.createElement('div');
    p.id = 'le-popup';
    p.innerHTML =
      '<div class="le-pop-label" id="le-pop-label"></div>' +
      '<textarea class="le-pop-ta" id="le-pop-ta" rows="3" dir="rtl"></textarea>' +
      '<div class="le-pop-row">' +
        '<button class="le-pop-save" id="le-pop-save">✓ שמור</button>' +
        '<button class="le-pop-cancel" id="le-pop-cancel">ביטול</button>' +
      '</div>';
    document.body.appendChild(p);
    document.getElementById('le-pop-save').addEventListener('click', commitPopup);
    document.getElementById('le-pop-cancel').addEventListener('click', closePopup);
    document.getElementById('le-pop-ta').addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); commitPopup(); }
      if (e.key === 'Escape') { e.preventDefault(); closePopup(); }
    });
    return p;
  }

  // ── Open popup near element ───────────────────────────────
  function openPopup(el) {
    if (!popup) popup = buildPopup();
    if (activeEl) activeEl.classList.remove('le-active-edit');
    activeEl  = el;
    activeKey = el.dataset.le;

    // Label: show friendly field name
    var parts = activeKey.split(':');
    var label = parts[parts.length - 1]
      .replace(/_he$/, ' (עברית)')
      .replace(/_en$/, ' (EN)')
      .replace(/_/g, ' ');
    document.getElementById('le-pop-label').textContent = '✏ ' + label;

    // Value: prefer data-le-init (for complex/hidden text), else visible text
    var ta = document.getElementById('le-pop-ta');
    ta.value = el.dataset.leInit !== undefined ? el.dataset.leInit : el.innerText.trim();
    ta.rows  = Math.min(8, Math.max(2, (ta.value.match(/\n/g) || []).length + 2));

    popup.style.display = 'block';
    positionPopup(el);
    el.classList.add('le-active-edit');
    ta.focus();
    ta.setSelectionRange(0, ta.value.length);
  }

  function positionPopup(el) {
    var rect = el.getBoundingClientRect();
    var sy   = window.pageYOffset;
    var pw   = 310;

    var top  = rect.bottom + sy + 10;
    var left = Math.max(8, Math.min(rect.left, window.innerWidth - pw - 8));

    // Flip above if close to bottom
    if (rect.bottom + 220 > window.innerHeight) {
      top = Math.max(sy + 8, rect.top + sy - 220 - 10);
    }

    popup.style.top  = top  + 'px';
    popup.style.left = left + 'px';
  }

  function closePopup() {
    if (popup) popup.style.display = 'none';
    if (activeEl) activeEl.classList.remove('le-active-edit');
    activeEl  = null;
    activeKey = null;
  }

  function commitPopup() {
    if (!activeEl || !activeKey) return;
    var ta  = document.getElementById('le-pop-ta');
    var val = ta.value.trim();

    // Update visible text (unless data-le-init element — those are trigger buttons)
    if (activeEl.dataset.leInit !== undefined) {
      activeEl.dataset.leInit = val; // keep in sync
    } else {
      var orig = activeEl.innerText.trim();
      if (val !== orig) activeEl.innerText = val;
    }

    save(activeKey, val, 'text');
    closePopup();
  }

  // ── Toggle edit mode ──────────────────────────────────────
  window.leToggle = function () {
    editMode = !editMode;
    document.body.classList.toggle('le-on', editMode);
    var btn = document.getElementById('le-btn-txt');
    if (btn) btn.textContent = editMode ? 'עריכה פעילה ✓' : 'מצב עריכה';
    if (!editMode) closePopup();
  };

  // ── Click delegation (capture phase to intercept links) ───
  document.addEventListener('click', function (e) {
    if (!editMode) return;

    var textEl = e.target.closest('[data-le]');
    var imgEl  = e.target.closest('[data-le-img]');

    if (textEl || imgEl) {
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      if (textEl) openPopup(textEl);
      else        triggerImgUpload(imgEl);
      return;
    }

    // Close popup on outside click
    if (popup && popup.style.display === 'block' && !popup.contains(e.target)) {
      closePopup();
    }
  }, true); // capture phase

  // ── Image upload ──────────────────────────────────────────
  function triggerImgUpload(el) {
    var key = el.dataset.leImg;
    var inp = document.createElement('input');
    inp.type   = 'file';
    inp.accept = 'image/*';
    inp.onchange = function () {
      if (!inp.files.length) return;
      var fd = new FormData();
      fd.append('image', inp.files[0]);
      showStatus('מעלה תמונה...', 'saving');

      fetch('admin/upload.php', { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d.error) { showStatus('שגיאה: ' + d.error, 'error'); return; }
          // Update DOM: find <img> inside, or the element itself
          var img = (el.tagName === 'IMG') ? el : el.querySelector('img');
          if (img) { img.src = d.url; img.srcset = ''; img.removeAttribute('srcset'); }
          // Also try background
          if (!img) el.style.backgroundImage = 'url(' + d.url + ')';
          save(key, d.url, 'img');
        })
        .catch(function () { showStatus('שגיאה בהעלאה ✗', 'error'); });
    };
    inp.click();
  }

  // ── Save to server ────────────────────────────────────────
  function save(key, value, type) {
    showStatus('שומר...', 'saving');
    var fd = new FormData();
    fd.append('csrf',  window.LE_CSRF);
    fd.append('key',   key);
    fd.append('value', value);
    fd.append('type',  type || 'text');

    fetch(window.LE_SAVE_URL, { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (d.ok) {
          showStatus('נשמר ✓', 'saved');
          setTimeout(function () { showStatus('', ''); }, 3000);
        } else {
          showStatus('שגיאה: ' + (d.error || '?'), 'error');
        }
      })
      .catch(function () { showStatus('שגיאה בחיבור ✗', 'error'); });
  }

  // ── Status bar ────────────────────────────────────────────
  function showStatus(msg, cls) {
    var el = document.getElementById('le-status');
    if (!el) return;
    el.textContent = msg;
    el.className   = msg ? 'le-' + cls : '';
  }

})();
