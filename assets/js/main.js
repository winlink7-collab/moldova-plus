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

  /* ── Shurik Chatbot ──────────────────────────────────── */
  var shurikWrap   = document.getElementById('shurik-wrap');
  if (shurikWrap) {
    var shurikBox    = document.getElementById('shurik-box');
    var shurikBubble = document.getElementById('shurik-bubble');
    var shurikClose  = document.getElementById('shurik-close');
    var shurikMsgs   = document.getElementById('shurik-msgs');
    var shurikQuick  = document.getElementById('shurik-quick');
    var shurikInput  = document.getElementById('shurik-input');
    var shurikSend   = document.getElementById('shurik-send');
    var shurikBadge  = document.getElementById('shurik-badge');
    var chatLang     = document.documentElement.lang || 'he';
    var isHe         = chatLang !== 'en';
    var chatOpen     = false;
    var waNum        = '972355501880';

    // Bot knowledge base
    var responses = [
      {
        keys: ['חבילה','חבילות','package','packages','טיול','נסיעה','trip'],
        he: 'יש לנו חבילות לכל סוג נסיעה 🍷\n• <b>זוגיות</b> — ספא + יין\n• <b>רווקים</b> — מסיבות + וילות\n• <b>יוקרה</b> — מלונות 5 כוכבים\n• <b>יקבים</b> — סיורי יין מקצועיים\n\nרוצה לראות את כל החבילות?',
        en: 'We have packages for every trip 🍷\n• <b>Couples</b> — spa + wine\n• <b>Bachelor</b> — parties + villas\n• <b>Luxury</b> — 5-star hotels\n• <b>Wine tours</b> — professional tastings\n\nWant to see all packages?',
        quick: { he: ['כן, תראה לי','מחירים','רווקים','יין'], en: ['Show me','Prices','Bachelor','Wine'] }
      },
      {
        keys: ['מחיר','מחירים','עלות','כמה','price','cost','how much'],
        he: 'המחירים שלנו מתחילים מ-₪1,200 לאדם 💰\n\n• בסיסי: ₪1,200 – ₪1,800\n• מתקדם: ₪2,000 – ₪3,000\n• יוקרה: ₪3,500+\n\nכל החבילות כוללות: מלון, ארוחות בוקר, סיורים ולווי מקומי.',
        en: 'Our prices start from ₪1,200 per person 💰\n\n• Basic: ₪1,200 – ₪1,800\n• Premium: ₪2,000 – ₪3,000\n• Luxury: ₪3,500+\n\nAll packages include: hotel, breakfasts, tours & local guide.',
        quick: { he: ['הזמנה','דברו איתי','כל החבילות'], en: ['Book now','Talk to us','All packages'] }
      },
      {
        keys: ['רווקים','bachelor','מסיבה','party','חברים','friends'],
        he: 'מסיבות רווקים במולדובה 🎉 — הבחירה הכי חכמה!\n\n✅ וילות פרטיות עם בריכה\n✅ חיי לילה אגדיים בקישינב\n✅ מחירים פי 3 זולים מאירופה\n✅ סיפור שיספרו עליו שנים\n\nכמה אנשים בקבוצה?',
        en: 'Bachelor parties in Moldova 🎉 — the smartest choice!\n\n✅ Private villas with pool\n✅ Legendary nightlife in Chisinau\n✅ 3× cheaper than Europe\n✅ A story they\'ll tell for years\n\nHow many people in the group?',
        quick: { he: ['5-10 אנשים','10-20 אנשים','דברו איתי'], en: ['5-10 people','10-20 people','Talk to us'] }
      },
      {
        keys: ['יין','יקב','wine','winery','קריקובה','מילשטי','cricova','milestii'],
        he: 'יין מולדובי — הטוב בעולם 🍇\n\nסיורים ב-2 היקבים הגדולים בעולם:\n• <b>Mileștii Mici</b> — 200 ק"מ מנהרות תת-קרקעיות\n• <b>Cricova</b> — היקב של הסלבס\n\nכולל: טעימת יין, ארוחה וסיור ברכב.',
        en: 'Moldovan wine — among the world\'s best 🍇\n\nTours to 2 of the world\'s largest wineries:\n• <b>Mileștii Mici</b> — 200km underground tunnels\n• <b>Cricova</b> — the celebrity winery\n\nIncludes: wine tasting, meal & vehicle tour.',
        quick: { he: ['הזמנה','מחירים','כל החבילות'], en: ['Book now','Prices','All packages'] }
      },
      {
        keys: ['ספא','spa','מסאז','massage','זוגי','couple','רומנטי','romantic'],
        he: 'חבילות ספא רומנטיות 💆‍♀️\n\nמושלם לזוגות:\n✅ מלון בוטיק 4-5 כוכבים\n✅ יום ספא מלא + עיסוי זוגי\n✅ ארוחת ערב רומנטית\n✅ סיור ביקב עם זיווגי יין\n\nחבילות זוגיות מ-₪2,200 לזוג.',
        en: 'Romantic Spa Packages 💆‍♀️\n\nPerfect for couples:\n✅ 4-5 star boutique hotel\n✅ Full spa day + couples massage\n✅ Romantic dinner\n✅ Winery tour with wine pairing\n\nCouples packages from ₪2,200 per couple.',
        quick: { he: ['הזמנה','מחירים','דברו איתי'], en: ['Book now','Prices','Talk to us'] }
      },
      {
        keys: ['הזמנה','להזמין','book','reserve','קניה','buy'],
        he: 'מעולה! 🎯 הדרך הכי מהירה להזמין — שלח לנו הודעה בוואטסאפ ונחזור אליך תוך דקות.',
        en: 'Great! 🎯 The fastest way to book — send us a WhatsApp message and we\'ll get back to you within minutes.',
        quick: { he: ['פתח וואטסאפ 💬'], en: ['Open WhatsApp 💬'] }
      },
      {
        keys: ['שלום','היי','hello','hi','hey','בוקר','ערב'],
        he: 'שלום! 👋 שמח שפנית אלינו. איך אפשר לעזור?',
        en: 'Hello! 👋 Happy you reached out. How can I help?',
        quick: { he: ['חבילות','מחירים','רווקים','ספא'], en: ['Packages','Prices','Bachelor','Spa'] }
      }
    ];

    var waQuickKeys = isHe ? ['פתח וואטסאפ 💬','דברו איתי'] : ['Open WhatsApp 💬','Talk to us'];

    function addMsg(text, who, delay) {
      delay = delay || 0;
      setTimeout(function() {
        var el = document.createElement('div');
        el.className = 'shurik-msg ' + who;
        el.innerHTML = text.replace(/\n/g,'<br>');
        shurikMsgs.appendChild(el);
        shurikMsgs.scrollTop = shurikMsgs.scrollHeight;
      }, delay);
    }

    function showTyping(duration, cb) {
      var t = document.createElement('div');
      t.className = 'shurik-typing';
      t.innerHTML = '<span></span><span></span><span></span>';
      shurikMsgs.appendChild(t);
      shurikMsgs.scrollTop = shurikMsgs.scrollHeight;
      setTimeout(function() {
        if (t.parentNode) t.parentNode.removeChild(t);
        cb();
      }, duration);
    }

    function setQuick(btns) {
      shurikQuick.innerHTML = '';
      if (!btns) return;
      btns.forEach(function(label) {
        var b = document.createElement('button');
        b.className = 'shurik-qbtn';
        b.textContent = label;
        b.addEventListener('click', function() { handleInput(label); });
        shurikQuick.appendChild(b);
      });
    }

    function handleInput(text) {
      if (!text.trim()) return;
      addMsg(text, 'user');
      shurikInput.value = '';
      setQuick(null);

      // Check if WA redirect
      if (waQuickKeys.indexOf(text) !== -1) {
        showTyping(700, function() {
          addMsg(isHe ? 'בסדר! מעביר אותך לוואטסאפ... 💬' : 'On it! Redirecting to WhatsApp... 💬', 'bot');
          setTimeout(function() {
            var msg = isHe ? 'היי שוריק, שמחתי לדבר! אשמח לשמוע על חבילות' : 'Hi Shurik! I chatted with the bot and want to hear about packages';
            window.open('https://wa.me/' + waNum + '?text=' + encodeURIComponent(msg), '_blank');
          }, 1000);
        });
        return;
      }

      // Find matching response
      var lc = text.toLowerCase();
      var found = null;
      for (var i = 0; i < responses.length; i++) {
        for (var j = 0; j < responses[i].keys.length; j++) {
          if (lc.indexOf(responses[i].keys[j]) !== -1) { found = responses[i]; break; }
        }
        if (found) break;
      }

      if (found) {
        showTyping(900, function() {
          addMsg(isHe ? found.he : found.en, 'bot');
          setQuick(isHe ? found.quick.he : found.quick.en);
        });
      } else {
        showTyping(700, function() {
          addMsg(
            isHe ? 'לא הבנתי לגמרי 😅 אבל אשמח לעזור! לחץ על אחת האפשרויות או שלח לנו ב-וואטסאפ.' : 'I didn\'t quite get that 😅 Happy to help though! Choose an option or contact us on WhatsApp.',
            'bot'
          );
          setQuick(isHe ? ['חבילות','מחירים','פתח וואטסאפ 💬'] : ['Packages','Prices','Open WhatsApp 💬']);
        });
      }
    }

    function openChat() {
      chatOpen = true;
      shurikBox.classList.add('open');
      shurikBadge.classList.add('hide');
      if (shurikMsgs.children.length === 0) {
        // Welcome message
        showTyping(800, function() {
          addMsg(
            isHe ? 'שלום! שמי שוריק ממולדובה פלוס 🇲🇩<br>אני כאן לעזור לך לתכנן את הטיול המושלם!' : 'Hi! I\'m Shurik from Moldova Plus 🇲🇩<br>I\'m here to help you plan the perfect trip!',
            'bot'
          );
          setQuick(isHe ? ['חבילות','מחירים','רווקים','ספא','יין'] : ['Packages','Prices','Bachelor','Spa','Wine']);
        });
      }
    }
    function closeChat() {
      chatOpen = false;
      shurikBox.classList.remove('open');
    }

    shurikBubble.addEventListener('click', function() { chatOpen ? closeChat() : openChat(); });
    shurikClose && shurikClose.addEventListener('click', closeChat);

    shurikSend && shurikSend.addEventListener('click', function() { handleInput(shurikInput.value); });
    shurikInput && shurikInput.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') handleInput(shurikInput.value);
    });

    // Show badge after 4s
    setTimeout(function() {
      if (!chatOpen) shurikBadge.classList.remove('hide');
    }, 4000);
  }

  /* ── Gallery Lightbox ────────────────────────────────── */
  var galLightbox = document.getElementById('gal-lightbox');
  if (galLightbox) {
    var galImgs   = [];
    var galIdx    = 0;
    var lbImg     = document.getElementById('gal-lb-img');
    var lbCounter = document.getElementById('gal-lb-counter');
    var lbThumbs  = document.getElementById('gal-lb-thumbs');
    var lbPrev    = document.getElementById('gal-lb-prev');
    var lbNext    = document.getElementById('gal-lb-next');
    var lbClose   = document.getElementById('gal-lb-close');

    // Collect all gallery images
    document.querySelectorAll('#detail-gal .gm img').forEach(function(img) {
      galImgs.push(img.src);
    });

    // Build thumbs
    galImgs.forEach(function(src, i) {
      var t = document.createElement('div');
      t.className = 'gal-lb-thumb' + (i === 0 ? ' active' : '');
      var ti = document.createElement('img');
      ti.src = src; ti.alt = '';
      t.appendChild(ti);
      t.addEventListener('click', function() { showImg(i); });
      lbThumbs.appendChild(t);
    });

    function showImg(idx) {
      galIdx = (idx + galImgs.length) % galImgs.length;
      lbImg.src = galImgs[galIdx];
      lbCounter.textContent = (galIdx + 1) + ' / ' + galImgs.length;
      lbThumbs.querySelectorAll('.gal-lb-thumb').forEach(function(t, i) {
        t.classList.toggle('active', i === galIdx);
      });
      // scroll thumb into view
      var activeThumb = lbThumbs.children[galIdx];
      if (activeThumb) activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }

    function openLightbox(idx) {
      showImg(idx);
      galLightbox.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
      galLightbox.classList.remove('open');
      document.body.style.overflow = '';
    }

    // Open on image click
    document.querySelectorAll('#detail-gal .gm').forEach(function(gm, i) {
      gm.addEventListener('click', function() { openLightbox(i); });
    });

    // "All photos" button
    var galAllBtn = document.querySelector('.gal-all-btn');
    if (galAllBtn) galAllBtn.addEventListener('click', function(e) { e.stopPropagation(); openLightbox(0); });

    lbClose && lbClose.addEventListener('click', closeLightbox);
    lbPrev  && lbPrev.addEventListener('click', function() { showImg(galIdx - 1); });
    lbNext  && lbNext.addEventListener('click', function() { showImg(galIdx + 1); });

    // Click backdrop to close
    galLightbox.addEventListener('click', function(e) {
      if (e.target === galLightbox) closeLightbox();
    });

    // Keyboard
    document.addEventListener('keydown', function(e) {
      if (!galLightbox.classList.contains('open')) return;
      if (e.key === 'Escape')     closeLightbox();
      if (e.key === 'ArrowRight') showImg(galIdx - 1);
      if (e.key === 'ArrowLeft')  showImg(galIdx + 1);
    });

    // Touch swipe
    var tsX = 0;
    galLightbox.addEventListener('touchstart', function(e) { tsX = e.touches[0].clientX; }, { passive: true });
    galLightbox.addEventListener('touchend', function(e) {
      var diff = tsX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) showImg(diff > 0 ? galIdx + 1 : galIdx - 1);
    }, { passive: true });
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
