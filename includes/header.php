<?php
// header.php — Top bar + sticky navigation
// Expects: $page (current page slug), $lang (he/en), $t (translations)
?>
<div class="top-bar">
  <div class="container top-bar-inner">
    <div class="top-bar-l">
      <span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7l.8 4a2 2 0 0 1-.6 1.9L7.6 11.4a16 16 0 0 0 6 6l1.8-1.7a2 2 0 0 1 1.9-.6l4 .8a2 2 0 0 1 1.7 2z"/></svg>
        +972-3-555-0188
      </span>
      <span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
        hello@moldovaplus.com
      </span>
      <span class="top-promo">
        <span class="he">✦ מבצע אביב — עד 15% הנחה</span>
        <span class="en">✦ Spring offer — up to 15% off</span>
      </span>
    </div>
    <div class="top-bar-r">
      <a href="#" class="he">מועדון לקוחות</a>
      <a href="#" class="en">Loyalty club</a>
      <a href="?lang=en" class="lang-btn <?= ($lang==='en')?'active':'' ?>">EN</a>
      <a href="?lang=he" class="lang-btn <?= ($lang==='he')?'active':'' ?>">עב</a>
    </div>
  </div>
</div>

<header class="site-header" id="site-header">
  <div class="container site-inner">
    <!-- Logo -->
    <a href="index.php<?= $lang==='en'?'?lang=en':'' ?>" class="logo">
      <span class="logo-mark">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5 19 L12 5 L19 19Z"/>
          <path d="M9 14 L12 17 L15 14"/>
        </svg>
      </span>
      <span class="logo-word">
        <span class="l1">Moldova<span> Plus</span></span>
        <span class="l2 he">חבילות נופש בקישינב</span>
        <span class="l2 en">Moldova travel packages</span>
      </span>
    </a>

    <!-- Desktop nav -->
    <nav class="primary-nav">
      <a href="index.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= $page==='home'?'active':'' ?>">
        <span class="he"><?= $t['nav']['home'] ?></span>
        <span class="en"><?= htmlspecialchars($t['nav']['home']) ?></span>
      </a>
      <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= in_array($page,['packages','detail'])?'active':'' ?>">
        <span class="he"><?= $t['nav']['packages'] ?></span>
        <span class="en"><?= htmlspecialchars($t['nav']['packages']) ?></span>
      </a>
      <a href="bachelor.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= $page==='bachelor'?'active':'' ?>">
        <span class="he"><?= $t['nav']['bachelor'] ?></span>
        <span class="en"><?= htmlspecialchars($t['nav']['bachelor']) ?></span>
      </a>
      <a href="attractions.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= $page==='attractions'?'active':'' ?>">
        <span class="he"><?= $t['nav']['attractions'] ?></span>
        <span class="en"><?= htmlspecialchars($t['nav']['attractions']) ?></span>
      </a>
      <a href="#" class="he">שוברי מתנה</a>
      <a href="#" class="en">Gift cards</a>
      <a href="#" class="he">בלוג</a>
      <a href="#" class="en">Blog</a>
    </nav>

    <!-- Header tools -->
    <div class="header-tools">
      <a href="https://wa.me/972355501880" target="_blank" rel="noopener" class="btn btn-whatsapp">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
        WhatsApp
      </a>
      <!-- Hamburger -->
      <button class="hamburger" id="hamburger" aria-label="תפריט">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
</header>

<!-- Mobile nav overlay -->
<div class="mob-nav" id="mob-nav">
  <button class="mob-close" id="mob-close">✕</button>
  <a href="index.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= $page==='home'?'active':'' ?>">
    <span class="he">בית</span><span class="en">Home</span>
  </a>
  <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= $page==='packages'?'active':'' ?>">
    <span class="he">חבילות נופש</span><span class="en">Travel packages</span>
  </a>
  <a href="bachelor.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= $page==='bachelor'?'active':'' ?>">
    <span class="he">מסיבות רווקים</span><span class="en">Bachelor parties</span>
  </a>
  <a href="attractions.php<?= $lang==='en'?'?lang=en':'' ?>" class="<?= $page==='attractions'?'active':'' ?>">
    <span class="he">אטרקציות</span><span class="en">Attractions</span>
  </a>
  <a href="https://wa.me/972355501880" target="_blank" class="mob-wa">
    <span class="he">דברו איתנו בוואטסאפ</span>
    <span class="en">Chat on WhatsApp</span>
  </a>
</div>
<div class="mob-overlay" id="mob-overlay"></div>
