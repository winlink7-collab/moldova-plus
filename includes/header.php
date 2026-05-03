<?php
// header.php — Top bar + sticky navigation
// Expects: $page (current page slug), $lang (he/en/ru), $t (translations)
require_once __DIR__ . '/mp_settings.php';
$_HS = mp_site_settings();
global $T;
// Lang query suffix helper
$_lq = $lang !== 'he' ? '?lang=' . $lang : '';
$_lqs = function(string $path) use ($lang): string {
    return $path . ($lang !== 'he' ? '?lang=' . $lang : '');
};
?>
<div class="top-bar">
  <div class="container top-bar-inner">
    <div class="top-bar-l">
      <a href="tel:+<?= preg_replace('/\D/', '', $_HS['phone'] ?? '035550188') ?>" class="top-contact-item">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7l.8 4a2 2 0 0 1-.6 1.9L7.6 11.4a16 16 0 0 0 6 6l1.8-1.7a2 2 0 0 1 1.9-.6l4 .8a2 2 0 0 1 1.7 2z"/></svg>
        <span<?= le('settings:phone_display') ?>><?= mp_s('phone_display', '+972 3-555-0188') ?></span>
      </a>
      <span class="top-bar-sep"></span>
      <a href="mailto:<?= htmlspecialchars($_HS['email'] ?? 'hello@moldovaplus.com') ?>" class="top-contact-item">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
        <span<?= le('settings:email') ?>><?= mp_s('email', 'hello@moldovaplus.com') ?></span>
      </a>
      <?php if (!empty($_HS['promo_active'])): ?>
      <span class="top-bar-sep"></span>
      <span class="top-promo">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        <span class="he"<?= le('settings:promo_he') ?>><?= mp_s('promo_he') ?></span>
        <span class="en"><?= mp_s('promo_en') ?></span>
        <span class="ru"><?= mp_s('promo_en') ?></span>
      </span>
      <?php endif; ?>
    </div>
    <div class="top-bar-r">
      <div class="lang-switcher">
        <a href="?lang=he" class="lang-pill <?= ($lang==='he')?'active':'' ?>" title="עברית">
          <span class="lang-flag">🇮🇱</span>
          <span class="lang-label">עב</span>
        </a>
        <a href="?lang=ru" class="lang-pill <?= ($lang==='ru')?'active':'' ?>" title="Русский">
          <span class="lang-flag">🇷🇺</span>
          <span class="lang-label">РУ</span>
        </a>
        <a href="?lang=en" class="lang-pill <?= ($lang==='en')?'active':'' ?>" title="English">
          <span class="lang-flag">🇬🇧</span>
          <span class="lang-label">EN</span>
        </a>
      </div>
    </div>
  </div>
</div>

<header class="site-header" id="site-header">
  <div class="container site-inner">
    <!-- Logo -->
    <a href="/<?= $lang !== 'he' ? '?lang='.$lang : '' ?>" class="logo">
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
        <span class="l2 ru">Туры в Кишинёв</span>
      </span>
    </a>

    <!-- Desktop nav -->
    <nav class="primary-nav">
      <a href="/<?= $_lq ?>" class="<?= $page==='home'?'active':'' ?>">
        <span class="he"><?= $t['nav']['home'] ?></span>
        <span class="en"><?= htmlspecialchars($T['en']['nav']['home']) ?></span>
        <span class="ru"><?= htmlspecialchars($T['ru']['nav']['home']) ?></span>
      </a>
      <a href="/packages<?= $_lq ?>" class="<?= in_array($page,['packages','detail'])?'active':'' ?>">
        <span class="he"><?= $t['nav']['packages'] ?></span>
        <span class="en"><?= htmlspecialchars($T['en']['nav']['packages']) ?></span>
        <span class="ru"><?= htmlspecialchars($T['ru']['nav']['packages']) ?></span>
      </a>
      <a href="/bachelor<?= $_lq ?>" class="<?= $page==='bachelor'?'active':'' ?>">
        <span class="he"><?= $t['nav']['bachelor'] ?></span>
        <span class="en"><?= htmlspecialchars($T['en']['nav']['bachelor']) ?></span>
        <span class="ru"><?= htmlspecialchars($T['ru']['nav']['bachelor']) ?></span>
      </a>
      <a href="/attractions<?= $_lq ?>" class="<?= $page==='attractions'?'active':'' ?>">
        <span class="he"><?= $t['nav']['attractions'] ?></span>
        <span class="en"><?= htmlspecialchars($T['en']['nav']['attractions']) ?></span>
        <span class="ru"><?= htmlspecialchars($T['ru']['nav']['attractions']) ?></span>
      </a>
      <a href="/hotels<?= $_lq ?>" class="<?= $page==='hotels'?'active':'' ?>">
        <span class="he">מלונות בקישינב</span>
        <span class="en">Hotels</span>
        <span class="ru">Отели</span>
      </a>
    </nav>

    <!-- Header tools -->
    <div class="header-tools">
      <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>" target="_blank" rel="noopener" class="btn btn-whatsapp">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
        <span>WhatsApp</span>
      </a>
      <!-- Mobile lang switcher -->
      <div class="mob-header-lang">
        <a href="?lang=he" class="mob-hl-btn <?= ($lang==='he')?'active':'' ?>">🇮🇱</a>
        <a href="?lang=ru" class="mob-hl-btn <?= ($lang==='ru')?'active':'' ?>">🇷🇺</a>
        <a href="?lang=en" class="mob-hl-btn <?= ($lang==='en')?'active':'' ?>">🇬🇧</a>
      </div>
      <!-- Hamburger -->
      <button class="hamburger" id="hamburger" aria-label="תפריט">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
</header>

<!-- Mobile nav overlay -->
<div class="mob-nav" id="mob-nav">
  <div class="mob-nav-top">
    <a href="/<?= $lang !== 'he' ? '?lang='.$lang : '' ?>" class="mob-logo">
      <span class="logo-mark">M+</span>
      <span>Moldova Plus</span>
    </a>
    <button class="mob-close" id="mob-close" aria-label="סגור">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
  </div>
  <nav class="mob-links">
    <a href="/<?= $_lq ?>" class="<?= $page==='home'?'active':'' ?>">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      <span class="he">בית</span><span class="en">Home</span><span class="ru">Главная</span>
    </a>
    <a href="/packages<?= $_lq ?>" class="<?= in_array($page,['packages','detail'])?'active':'' ?>">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-4 0v2M8 7V5a2 2 0 0 0-4 0v2"/></svg>
      <span class="he">חבילות נופש</span><span class="en">Travel packages</span><span class="ru">Туры</span>
    </a>
    <a href="/bachelor<?= $_lq ?>" class="<?= $page==='bachelor'?'active':'' ?>">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      <span class="he">מסיבות רווקים</span><span class="en">Bachelor parties</span><span class="ru">Мальчишники</span>
    </a>
    <a href="/attractions<?= $_lq ?>" class="<?= $page==='attractions'?'active':'' ?>">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      <span class="he">אטרקציות</span><span class="en">Attractions</span><span class="ru">Достопримечательности</span>
    </a>
    <a href="/hotels<?= $_lq ?>" class="<?= $page==='hotels'?'active':'' ?>">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      <span class="he">מלונות בקישינב</span><span class="en">Hotels</span><span class="ru">Отели</span>
    </a>
  </nav>
  <div class="mob-nav-footer">
    <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>" target="_blank" rel="noopener" class="mob-wa">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
      <span class="he">דברו איתנו בוואטסאפ</span>
      <span class="en">Chat on WhatsApp</span>
      <span class="ru">Написать в WhatsApp</span>
    </a>
    <div class="mob-lang">
      <a href="?lang=he" class="mob-lang-btn <?= ($lang==='he')?'active':'' ?>">🇮🇱 עברית</a>
      <a href="?lang=ru" class="mob-lang-btn <?= ($lang==='ru')?'active':'' ?>">🇷🇺 Русский</a>
      <a href="?lang=en" class="mob-lang-btn <?= ($lang==='en')?'active':'' ?>">🇬🇧 English</a>
    </div>
  </div>
</div>
<div class="mob-overlay" id="mob-overlay"></div>
