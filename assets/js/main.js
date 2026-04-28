/* Moldova Plus — main.js */
(function () {
  'use strict';

  /* ── Language persistence ─────────────────────────────── */
  const urlLang = new URLSearchParams(location.search).get('lang');
  if (urlLang) {
    localStorage.setItem('mp_lang', urlLang);
  }

  /* ── Mobile menu ──────────────────────────────────────── */
  const hamburger  = document.getElementById('hamburger');
  const mobNav     = document.getElementById('mob-nav');
  const mobOverlay = document.getElementById('mob-overlay');

  var scrollY = 0;
  function openMenu() {
    scrollY = window.scrollY;
    mobNav    && mobNav.classList.add('open');
    mobOverlay && mobOverlay.classList.add('open');
    hamburger && hamburger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow   = 'hidden';
    document.body.style.position   = 'fixed';
    document.body.style.top        = '-' + scrollY + 'px';
    document.body.style.width      = '100%';
  }
  function closeMenu() {
    mobNav    && mobNav.classList.remove('open');
    mobOverlay && mobOverlay.classList.remove('open');
    hamburger && hamburger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow   = '';
    document.body.style.position   = '';
    document.body.style.top        = '';
    document.body.style.width      = '';
    window.scrollTo(0, scrollY);
  }

  hamburger  && hamburger.addEventListener('click', () =>
    mobNav && mobNav.classList.contains('open') ? closeMenu() : openMenu()
  );
  mobOverlay && mobOverlay.addEventListener('click', closeMenu);

  const mobClose = document.getElementById('mob-close');
  mobClose && mobClose.addEventListener('click', closeMenu);

  /* close menu on nav link click (mobile) */
  mobNav && mobNav.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));

  /* ── Header scroll shadow ─────────────────────────────── */
  const siteHeader = document.querySelector('.site-header');
  if (siteHeader) {
    const onScroll = () =>
      siteHeader.classList.toggle('scrolled', window.scrollY > 10);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Scroll reveal ────────────────────────────────────── */
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    const io = new IntersectionObserver(
      entries => entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          io.unobserve(e.target);
        }
      }),
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    revealEls.forEach(el => io.observe(el));
  }

  /* ── Back-to-top button ───────────────────────────────── */
  const backTop = document.getElementById('back-top');
  if (backTop) {
    window.addEventListener('scroll', () =>
      backTop.classList.toggle('visible', window.scrollY > 400), { passive: true }
    );
    backTop.addEventListener('click', () =>
      window.scrollTo({ top: 0, behavior: 'smooth' })
    );
  }

  /* ── Homepage package tab filter ─────────────────────── */
  const tabs    = document.querySelectorAll('.tab[data-filter]');
  const pkgGrid = document.getElementById('pkg-grid');

  if (tabs.length && pkgGrid) {
    tabs.forEach(tab => tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const filter = tab.dataset.filter;
      pkgGrid.querySelectorAll('.card-wrap').forEach(wrap => {
        const show = filter === 'all' || wrap.dataset.type === filter;
        wrap.style.display = show ? '' : 'none';
      });
    }));
  }

  /* ── Packages page: sort dropdown ────────────────────── */
  window.sortCards = function (val) {
    const grid  = document.getElementById('pkg-grid');
    if (!grid) return;
    const wraps = Array.from(grid.querySelectorAll('.card-wrap'));

    wraps.sort((a, b) => {
      if (val === 'priceL') return +a.dataset.price - +b.dataset.price;
      if (val === 'priceH') return +b.dataset.price - +a.dataset.price;
      if (val === 'rating') return +b.dataset.rating - +a.dataset.rating;
      return 0; // 'pop' — keep server order
    });

    wraps.forEach(w => grid.appendChild(w));
  };

  /* ── Favorites (heart toggle) ─────────────────────────── */
  let favs = JSON.parse(localStorage.getItem('mp_favs') || '[]');

  function initFavs() {
    document.querySelectorAll('.card-fav').forEach(btn => {
      const id = btn.closest('[data-id]')?.dataset.id;
      if (!id) return;
      if (favs.includes(id)) btn.classList.add('on');

      btn.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
        btn.classList.toggle('on');
        if (favs.includes(id)) {
          favs = favs.filter(f => f !== id);
        } else {
          favs.push(id);
        }
        localStorage.setItem('mp_favs', JSON.stringify(favs));
      });
    });
  }
  initFavs();

  /* ── Booking sidebar: date defaults ──────────────────── */
  const checkIn  = document.getElementById('check-in');
  const checkOut = document.getElementById('check-out');
  if (checkIn && checkOut) {
    const today    = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);
    const fmt = d => d.toISOString().split('T')[0];
    checkIn.min  = fmt(today);
    checkIn.value = checkIn.value || fmt(tomorrow);
    checkOut.min  = fmt(tomorrow);

    checkIn.addEventListener('change', () => {
      const next = new Date(checkIn.value);
      next.setDate(next.getDate() + 1);
      checkOut.min   = fmt(next);
      if (checkOut.value && checkOut.value <= checkIn.value) {
        checkOut.value = fmt(next);
      }
    });
  }

  /* ── Guest counter (+/−) ──────────────────────────────── */
  document.querySelectorAll('.guest-ctrl').forEach(ctrl => {
    const input = ctrl.querySelector('.guest-val');
    ctrl.querySelector('.guest-minus')?.addEventListener('click', () => {
      const v = parseInt(input.value, 10);
      if (v > 1) input.value = v - 1;
    });
    ctrl.querySelector('.guest-plus')?.addEventListener('click', () => {
      const v = parseInt(input.value, 10);
      if (v < 20) input.value = v + 1;
    });
  });

  /* ── Dynamic search bar ──────────────────────────────── */
  const searchBar = document.getElementById('search-bar');
  if (searchBar) {
    const lang      = searchBar.dataset.lang || 'he';
    const guestWord = lang === 'he' ? 'אורחים' : 'guests';

    // Toggle dropdown open/closed on cell click
    searchBar.querySelectorAll('.sc-interactive').forEach(cell => {
      cell.addEventListener('click', function(e) {
        if (e.target.closest('.sc-dropdown')) return; // clicks inside dropdown handled separately
        const drop = cell.querySelector('.sc-dropdown');
        if (!drop) return;
        const isOpen = drop.classList.contains('open');
        // close all
        searchBar.querySelectorAll('.sc-dropdown.open').forEach(d => {
          d.classList.remove('open');
          d.closest('.sc-interactive').classList.remove('sc-active');
        });
        if (!isOpen) {
          drop.classList.add('open');
          cell.classList.add('sc-active');
        }
      });
    });

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
      if (!searchBar.contains(e.target)) {
        searchBar.querySelectorAll('.sc-dropdown.open').forEach(d => {
          d.classList.remove('open');
          d.closest('.sc-interactive').classList.remove('sc-active');
        });
      }
    });

    // Month selection
    searchBar.querySelectorAll('.sc-drop-months .sc-opt').forEach(btn => {
      btn.addEventListener('click', function() {
        const cell = btn.closest('.sc-interactive');
        const val  = cell.querySelector('.sc-val');
        val.textContent = btn.textContent.trim();
        searchBar.querySelectorAll('.sc-drop-months .sc-opt').forEach(b => b.classList.remove('sc-opt-active'));
        btn.classList.add('sc-opt-active');
        btn.closest('.sc-dropdown').classList.remove('open');
        cell.classList.remove('sc-active');
      });
    });

    // Guest counter
    let guestCount = 2;
    const cntEl    = document.getElementById('sc-cnt');
    const dispEl   = document.getElementById('sc-guests-display');

    function updateGuests(n) {
      guestCount = Math.max(1, Math.min(30, n));
      if (cntEl)  cntEl.textContent = guestCount;
      if (dispEl) dispEl.innerHTML  = guestCount + ' <span class="' + (lang === 'he' ? 'he' : 'en') + '">' + guestWord + '</span>';
    }

    const minusBtn = document.getElementById('sc-minus');
    const plusBtn  = document.getElementById('sc-plus');
    minusBtn && minusBtn.addEventListener('click', function(e) { e.stopPropagation(); updateGuests(guestCount - 1); });
    plusBtn  && plusBtn.addEventListener('click',  function(e) { e.stopPropagation(); updateGuests(guestCount + 1); });

    // Type selection
    searchBar.querySelectorAll('.sc-drop-types .sc-opt').forEach(btn => {
      btn.addEventListener('click', function() {
        const cell = btn.closest('.sc-interactive');
        const val  = cell.querySelector('.sc-val');
        val.textContent = btn.textContent.trim();
        val.dataset.type = btn.dataset.type || '';
        searchBar.querySelectorAll('.sc-drop-types .sc-opt').forEach(b => b.classList.remove('sc-opt-active'));
        btn.classList.add('sc-opt-active');
        btn.closest('.sc-dropdown').classList.remove('open');
        cell.classList.remove('sc-active');
      });
    });

    // Search button
    const goBtn = document.getElementById('search-go');
    goBtn && goBtn.addEventListener('click', function() {
      const typeVal  = searchBar.querySelector('[data-field="type"] .sc-val');
      const selType  = typeVal ? (typeVal.dataset.type || '') : '';
      const params   = new URLSearchParams();
      if (selType)      params.set('type', selType);
      if (lang === 'en') params.set('lang', 'en');
      const qs = params.toString();
      location.href = 'packages.php' + (qs ? '?' + qs : '');
    });
  }

  /* ── Newsletter form ──────────────────────────────────── */
  document.querySelectorAll('.nl-form').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const input = form.querySelector('input[type="email"]');
      if (!input?.value) return;
      const btn = form.querySelector('button');
      if (btn) {
        const orig = btn.textContent;
        btn.textContent = '✓';
        btn.disabled = true;
        setTimeout(() => { btn.textContent = orig; btn.disabled = false; }, 3000);
      }
      input.value = '';
    });
  });

  /* ── Deal countdown timer ────────────────────────────── */
  const dealEl = document.getElementById('deal-countdown');
  if (dealEl) {
    // End of next Sunday 23:59:59
    const now   = new Date();
    const end   = new Date(now);
    end.setDate(now.getDate() + (7 - now.getDay()));
    end.setHours(23, 59, 59, 0);
    function tickDeal() {
      const diff = Math.max(0, end - new Date());
      const h = String(Math.floor(diff / 3600000)).padStart(2, '0');
      const m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
      const s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
      dealEl.textContent = `${h}:${m}:${s}`;
    }
    tickDeal();
    setInterval(tickDeal, 1000);
  }

  /* ── FAQ accordion ───────────────────────────────────── */
  document.querySelectorAll('.faq-q').forEach(q => {
    q.addEventListener('click', () => {
      const item = q.closest('.faq-item');
      const ans  = item.querySelector('.faq-a');
      const open = q.classList.contains('open');
      // close all
      document.querySelectorAll('.faq-q.open').forEach(oq => {
        oq.classList.remove('open');
        oq.closest('.faq-item').querySelector('.faq-a').classList.remove('open');
      });
      if (!open) { q.classList.add('open'); ans.classList.add('open'); }
    });
  });

  /* ── Contact form ─────────────────────────────────────── */
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', e => {
      e.preventDefault();
      const btn = contactForm.querySelector('button[type="submit"]');
      const name  = contactForm.querySelector('[name="name"]')?.value || '';
      const phone = contactForm.querySelector('[name="phone"]')?.value || '';
      const msg   = contactForm.querySelector('[name="message"]')?.value || '';
      const text  = encodeURIComponent(`שלום, שמי ${name} (${phone}).\n${msg}`);
      window.open(`https://wa.me/972355501880?text=${text}`, '_blank');
      if (btn) { btn.textContent = '✓ נשלח!'; btn.disabled = true; }
    });
  }

  /* ── Smooth anchor scroll ─────────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      closeMenu();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

})();
