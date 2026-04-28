(function () {
  'use strict';

  var editMode = false;

  // ── Store originals on load ────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-le]').forEach(function (el) {
      el.dataset.leOrig = el.innerText.trim();
    });
  });

  // ── Toggle edit mode ───────────────────────────────────
  window.leToggle = function () {
    editMode = !editMode;
    document.body.classList.toggle('le-on', editMode);

    var btn  = document.getElementById('le-btn-txt');
    if (btn) btn.textContent = editMode ? 'עריכה פעילה' : 'מצב עריכה';

    if (editMode) {
      enableText();
      enableImg();
    } else {
      disableText();
      disableImg();
    }
  };

  // ── Text editing ───────────────────────────────────────
  function enableText() {
    document.querySelectorAll('[data-le]').forEach(function (el) {
      el.setAttribute('contenteditable', 'true');
      el.setAttribute('spellcheck', 'false');
      el.addEventListener('blur',    onBlur);
      el.addEventListener('keydown', onKey);
    });
  }

  function disableText() {
    document.querySelectorAll('[data-le]').forEach(function (el) {
      el.removeAttribute('contenteditable');
      el.removeEventListener('blur',    onBlur);
      el.removeEventListener('keydown', onKey);
    });
  }

  function onBlur(e) {
    var el  = e.target;
    var val = el.innerText.trim();
    if (val === (el.dataset.leOrig || '')) return; // unchanged
    save(el.dataset.le, val, 'text', el);
  }

  function onKey(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      e.target.blur();
    }
    if (e.key === 'Escape') {
      e.target.innerText = e.target.dataset.leOrig || '';
      e.target.blur();
    }
  }

  // ── Image swap ────────────────────────────────────────
  function enableImg() {
    document.querySelectorAll('[data-le-img]').forEach(function (el) {
      el.addEventListener('click', onImgClick);
    });
  }

  function disableImg() {
    document.querySelectorAll('[data-le-img]').forEach(function (el) {
      el.removeEventListener('click', onImgClick);
    });
  }

  function onImgClick(e) {
    e.preventDefault();
    e.stopPropagation();
    var target = this;
    var key    = target.dataset.leImg;

    var input     = document.createElement('input');
    input.type    = 'file';
    input.accept  = 'image/*';
    input.onchange = function () {
      if (!input.files.length) return;
      var fd = new FormData();
      fd.append('image', input.files[0]);
      status('מעלה תמונה...', 'saving');

      fetch('admin/upload.php', { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d.error) { status('שגיאה ✗', 'error'); return; }
          // Update DOM immediately
          if (target.tagName === 'IMG') {
            target.src = d.url;
          } else {
            var img = target.querySelector('img');
            if (img) img.src = d.url;
            target.style.backgroundImage = 'url(' + d.url + ')';
          }
          save(key, d.url, 'img', target);
        })
        .catch(function () { status('שגיאה ✗', 'error'); });
    };
    input.click();
  }

  // ── Save to server ────────────────────────────────────
  function save(key, value, type, el) {
    status('שומר...', 'saving');
    var fd = new FormData();
    fd.append('csrf',  window.LE_CSRF);
    fd.append('key',   key);
    fd.append('value', value);
    fd.append('type',  type);

    fetch(window.LE_SAVE_URL, { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (d.ok) {
          if (el) el.dataset.leOrig = value;
          status('נשמר ✓', 'saved');
          setTimeout(function () { status('', ''); }, 2500);
        } else {
          status('שגיאה: ' + (d.error || '?'), 'error');
        }
      })
      .catch(function () { status('שגיאה בשמירה ✗', 'error'); });
  }

  // ── Status indicator ─────────────────────────────────
  function status(msg, cls) {
    var el = document.getElementById('le-status');
    if (!el) return;
    el.textContent = msg;
    el.className   = msg ? 'le-' + cls : '';
  }

})();
