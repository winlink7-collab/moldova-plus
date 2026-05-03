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

    // Value: tags type → join span texts; init attr → use that; else visible text
    var ta = document.getElementById('le-pop-ta');
    if (el.dataset.leType === 'tags') {
      var tagSpans = el.querySelectorAll('.card-tag');
      var tagTexts = [];
      tagSpans.forEach(function (s) { tagTexts.push(s.textContent.trim()); });
      ta.value = tagTexts.join(', ');
      document.getElementById('le-pop-label').textContent = '✏ תגיות (מופרדות בפסיק)';
    } else {
      ta.value = el.dataset.leInit !== undefined ? el.dataset.leInit : el.innerText.trim();
    }
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

    if (activeEl.dataset.leType === 'tags') {
      // Rebuild visible tag spans from comma-separated input
      var tags = val.split(',').map(function (t) { return t.trim(); }).filter(Boolean);
      activeEl.innerHTML = '';
      tags.forEach(function (t) {
        var sp = document.createElement('span');
        sp.className = 'card-tag';
        sp.textContent = t;
        activeEl.appendChild(sp);
      });
      save(activeKey, val, 'tags');
    } else if (activeEl.dataset.leInit !== undefined) {
      activeEl.dataset.leInit = val;
      save(activeKey, val, 'text');
    } else {
      var orig = activeEl.innerText.trim();
      if (val !== orig) activeEl.innerText = val;
      save(activeKey, val, 'text');
    }

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
    var galEl  = e.target.closest('[data-le-gallery]');

    if (textEl || imgEl || galEl) {
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      if (galEl)   openGalleryMgr(galEl);
      else if (textEl) openPopup(textEl);
      else         triggerImgUpload(imgEl);
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

      fetch('/admin/upload.php', { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d.error) { showStatus('שגיאה: ' + d.error, 'error'); return; }
          var absUrl = d.abs || d.url;
          // Update DOM: find <img> inside, or create one replacing the SVG
          var img = (el.tagName === 'IMG') ? el : el.querySelector('img');
          if (!img) {
            // Remove SVG scene, insert <img> as first child
            var svg = el.querySelector('svg,div.scene-img');
            if (svg) svg.remove();
            img = document.createElement('img');
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;position:absolute;top:0;left:0;';
            el.style.position = 'relative';
            el.insertBefore(img, el.firstChild);
          }
          img.src = absUrl; img.srcset = ''; img.removeAttribute('srcset');
          save(key, absUrl, 'img');
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

  // ── Gallery manager ───────────────────────────────────────
  var galModal = null;
  var galActiveEl = null;
  var galKey = null;
  var galImages = [];

  function buildGalModal() {
    var m = document.createElement('div');
    m.id = 'le-gal-modal';
    m.innerHTML =
      '<div class="le-gal-inner">' +
        '<div class="le-gal-head">' +
          '<span>🖼 ניהול גלריה</span>' +
          '<button id="le-gal-close">✕</button>' +
        '</div>' +
        '<label class="le-gal-upload-zone">' +
          '<input type="file" multiple accept="image/*" id="le-gal-files">' +
          '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 5 5 12"/></svg>' +
          '<span>גרור תמונות לכאן או לחץ — ניתן לבחור מספר תמונות</span>' +
        '</label>' +
        '<div id="le-gal-prog"></div>' +
        '<div id="le-gal-grid" class="le-gal-grid"></div>' +
        '<div class="le-gal-foot">' +
          '<button id="le-gal-save" class="le-pop-save">💾 שמור גלריה</button>' +
          '<button id="le-gal-cancel" class="le-pop-cancel">ביטול</button>' +
        '</div>' +
      '</div>';
    document.body.appendChild(m);
    document.getElementById('le-gal-close').addEventListener('click', closeGalModal);
    document.getElementById('le-gal-cancel').addEventListener('click', closeGalModal);
    document.getElementById('le-gal-save').addEventListener('click', saveGallery);
    document.getElementById('le-gal-files').addEventListener('change', function () {
      uploadGalFiles([].slice.call(this.files));
      this.value = '';
    });
    m.addEventListener('click', function (e) { if (e.target === m) closeGalModal(); });
    return m;
  }

  function openGalleryMgr(el) {
    if (!galModal) galModal = buildGalModal();
    galActiveEl = el;
    galKey = el.dataset.leGallery;
    try { galImages = JSON.parse(el.dataset.galCurrent || '[]'); } catch (e) { galImages = []; }
    renderGalGrid();
    galModal.style.display = 'flex';
  }

  function closeGalModal() {
    if (galModal) galModal.style.display = 'none';
  }

  function renderGalGrid() {
    var grid = document.getElementById('le-gal-grid');
    if (!grid) return;
    grid.innerHTML = '';
    if (!galImages.length) {
      grid.innerHTML = '<p style="color:#94a3b8;font-size:13px;text-align:center;padding:24px 0;grid-column:1/-1">אין תמונות בגלריה — העלה תמונות למעלה</p>';
      return;
    }
    galImages.forEach(function (url, i) {
      var item = document.createElement('div');
      item.className = 'le-gal-item';
      item.innerHTML = '<img src="' + url + '" alt=""><button class="le-gal-del" type="button">×</button>';
      item.querySelector('.le-gal-del').addEventListener('click', function () {
        galImages.splice(i, 1);
        renderGalGrid();
      });
      grid.appendChild(item);
    });
  }

  function uploadGalFiles(files) {
    if (!files.length) return;
    var prog = document.getElementById('le-gal-prog');
    prog.textContent = 'מעלה ' + files.length + ' תמונ' + (files.length > 1 ? 'ות' : 'ה') + '...';
    prog.style.color = '#fbbf24';

    var uploads = files.map(function (f) {
      var fd = new FormData(); fd.append('image', f);
      return fetch('/admin/upload.php', { method: 'POST', body: fd }).then(function (r) { return r.json(); });
    });
    Promise.all(uploads).then(function (results) {
      prog.textContent = '';
      results.forEach(function (d) { if (!d.error) galImages.push(d.abs || d.url); });
      renderGalGrid();
    }).catch(function () {
      prog.textContent = 'שגיאה בהעלאה ✗';
      prog.style.color = '#f87171';
    });
  }

  function saveGallery() {
    showStatus('שומר גלריה...', 'saving');
    var fd = new FormData();
    fd.append('csrf',  window.LE_CSRF);
    fd.append('key',   galKey);
    fd.append('value', JSON.stringify(galImages));
    fd.append('type',  'gallery');
    fetch(window.LE_SAVE_URL, { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (d.ok) {
          closeGalModal();
          showStatus('נשמר ✓', 'saved');
          setTimeout(function () { location.reload(); }, 700);
        } else {
          showStatus('שגיאה: ' + (d.error || '?'), 'error');
        }
      })
      .catch(function () { showStatus('שגיאה ✗', 'error'); });
  }

  // ── Status bar ────────────────────────────────────────────
  function showStatus(msg, cls) {
    var el = document.getElementById('le-status');
    if (!el) return;
    el.textContent = msg;
    el.className   = msg ? 'le-' + cls : '';
  }

})();
