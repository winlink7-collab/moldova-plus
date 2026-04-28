<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';
$_S = mp_site_settings();

[$lang, $t] = page_init('home');
$page = 'home';

// Load deal-of-week from admin JSON
$_deal_file = __DIR__ . '/data/deal.json';
$DEAL = file_exists($_deal_file) ? (json_decode(file_get_contents($_deal_file), true) ?? []) : [];
$DEAL_ON = !empty($DEAL['enabled']);

$title_he = 'Moldova Plus — חבילות נופש בקישינב, מולדובה';
$title_en = 'Moldova Plus — Travel packages in Chișinău, Moldova';
$desc_he  = 'פורטל ההזמנות הגדול בישראל לחבילות נופש בקישינב — מסיבות רווקים, חוויות יוקרה ויקבים מובילים. מחירים שקופים, אישור מיידי.';
$desc_en  = "Israel's largest portal for Chișinău getaways — bachelor parties, luxury escapes and top wineries. Transparent prices, instant confirmation.";

page_head($lang==='he' ? $title_he : $title_en, $lang==='he' ? $desc_he : $desc_en, $lang);
?>

<?php include 'includes/header.php'; ?>

<!-- ══ HERO ══════════════════════════════════════════════════ -->
<section class="hero">
  <div class="container">
    <div class="hero-band">
      <!-- Text -->
      <div class="hero-text">
        <span class="hero-eyebrow">
          ✦ <span class="he"><?= $t['hero']['kicker'] ?></span>
             <span class="en"><?= htmlspecialchars($t['hero']['kicker']) ?></span>
        </span>
        <h1>
          <span class="he"><?= $t['hero']['h1'][0] ?> <span><?= $t['hero']['h1'][1] ?></span></span>
          <span class="en"><?= htmlspecialchars($t['hero']['h1'][0]) ?> <span><?= htmlspecialchars($t['hero']['h1'][1]) ?></span></span>
        </h1>
        <p>
          <span class="he"><?= $t['hero']['sub'] ?></span>
          <span class="en"><?= htmlspecialchars($t['hero']['sub']) ?></span>
        </p>
        <div class="hero-btns">
          <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-primary">
            <span class="he">גלו חבילות</span>
            <span class="en">Browse packages</span>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="he"><path d="M19 12H5M11 5l-7 7 7 7"/></svg>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="en"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
          </a>
          <a href="bachelor.php<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-ghost">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3h14l-2 9a5 5 0 0 1-10 0L5 3z"/><path d="M12 17v4M8 21h8"/></svg>
            <span class="he">מסיבת רווקים</span>
            <span class="en">Bachelor party</span>
          </a>
        </div>
        <div class="hero-trust">
          <div class="ti">
            <span class="ti-ic">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
            </span>
            <div>
              <b><span class="he"><?= $t['hero']['best'] ?></span><span class="en"><?= htmlspecialchars($t['hero']['best']) ?></span></b>
              <span class="he">מוסכם</span><span class="en">Guaranteed</span>
            </div>
          </div>
          <div class="ti">
            <span class="ti-ic">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="6"/><path d="M9 14l-2 7 5-3 5 3-2-7"/></svg>
            </span>
            <div>
              <b><span class="he"><?= $t['hero']['verified'] ?></span><span class="en"><?= htmlspecialchars($t['hero']['verified']) ?></span></b>
              <span>4,200+</span>
            </div>
          </div>
          <div class="ti">
            <span class="ti-ic">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 3v6c0 5-3.5 9.5-8 11-4.5-1.5-8-6-8-11V5l8-3z"/></svg>
            </span>
            <div>
              <b><span class="he"><?= $t['hero']['pkgs'] ?></span><span class="en"><?= htmlspecialchars($t['hero']['pkgs']) ?></span></b>
              <span class="he">מאומתות</span><span class="en">Vetted</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Hero package card visual -->
      <div class="hero-card-wrap">

        <!-- Main package card -->
        <div class="hero-pkg-card">
          <div class="hero-pkg-img">
            <img src="https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=700&h=420&q=85" alt="" loading="eager">
            <div class="hero-pkg-overlay"></div>
            <span class="hero-pkg-badge">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2l-8 11h7l-1 9 9-11h-7l2-9z"/></svg>
              <span class="he">מבצע השבוע</span><span class="en">Deal of the week</span>
            </span>
            <span class="hero-pkg-rating">★ 4.9</span>
          </div>
          <div class="hero-pkg-body">
            <div class="hero-pkg-top">
              <div>
                <p class="hero-pkg-loc">
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
                  <span class="he">קישינב, מולדובה</span><span class="en">Chișinău, Moldova</span>
                </p>
                <h3 class="hero-pkg-title">
                  <span class="he">חופשת יין וספא — 4 לילות</span>
                  <span class="en">Wine & Spa Escape — 4 nights</span>
                </h3>
              </div>
              <div class="hero-pkg-disc">
                <span>35%</span>
                <small><span class="he">הנחה</span><span class="en">OFF</span></small>
              </div>
            </div>
            <div class="hero-pkg-includes">
              <span><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><span class="he">מלון 5★</span><span class="en">5★ Hotel</span></span>
              <span><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><span class="he">סיור יקב</span><span class="en">Winery tour</span></span>
              <span><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><span class="he">ספא זוגי</span><span class="en">Couples spa</span></span>
              <span><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><span class="he">ארוחות בוקר</span><span class="en">Breakfasts</span></span>
            </div>
            <div class="hero-pkg-foot">
              <div class="hero-pkg-price">
                <span class="hero-pkg-was">€470</span>
                <div><small class="he">מ-</small><small class="en">from </small><b>€299</b><small class="he"> /אדם</small><small class="en"> /pp</small></div>
              </div>
              <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, אני מעוניין בחבילת יין וספא 4 לילות' : "Hi, interested in Wine & Spa 4 nights deal") ?>" target="_blank" rel="noopener" class="hero-pkg-cta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                <span class="he">הזמינו</span><span class="en">Book</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Floating guests pill -->
        <div class="hero-guests-pill">
          <div class="av-row">
            <span class="av av1"></span>
            <span class="av av2"></span>
            <span class="av av3"></span>
          </div>
          <div class="fl-text">
            <b><?= htmlspecialchars(mp_sr('stat_customers','15,000+')) ?></b>
            <span class="he">אורחים מרוצים</span>
            <span class="en">happy guests</span>
          </div>
        </div>

        <!-- Floating review pill -->
        <div class="hero-review-pill">
          <span class="hero-review-stars">★★★★★</span>
          <span class="he">״חוויה מדהימה, חוזרים!״</span>
          <span class="en">"Amazing, coming back!"</span>
        </div>

      </div>
    </div>

    <!-- Search bar -->
    <div class="search-bar" id="search-bar" data-lang="<?= $lang ?>">

      <!-- 1. Where (static) -->
      <div class="search-cell">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="var(--flag-blue)" opacity=".18"/>
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="var(--flag-blue)" stroke-width="1.8" fill="none"/>
            <circle cx="12" cy="9" r="2.5" fill="var(--flag-blue)"/>
          </svg>
        </span>
        <div class="sc-col">
          <label><?= htmlspecialchars($t['search']['where']) ?></label>
          <b><?= htmlspecialchars($t['search']['whereV']) ?></b>
        </div>
      </div>

      <!-- 2. When (month dropdown) -->
      <div class="search-cell sc-interactive" data-field="when">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="5" width="18" height="16" rx="3" fill="var(--flag-blue)" opacity=".12"/>
            <rect x="3" y="5" width="18" height="16" rx="3" stroke="var(--flag-blue)" stroke-width="1.8" fill="none"/>
            <path d="M3 10h18" stroke="var(--flag-blue)" stroke-width="1.8"/>
            <path d="M8 3v4M16 3v4" stroke="var(--flag-blue)" stroke-width="2" stroke-linecap="round"/>
            <circle cx="8" cy="15" r="1.2" fill="var(--flag-blue)"/>
            <circle cx="12" cy="15" r="1.2" fill="var(--flag-blue)"/>
            <circle cx="16" cy="15" r="1.2" fill="var(--flag-blue)"/>
          </svg>
        </span>
        <div class="sc-col">
          <label><?= htmlspecialchars($t['search']['when']) ?></label>
          <b class="sc-val" data-placeholder="<?= htmlspecialchars($t['search']['whenV']) ?>"><?= htmlspecialchars($t['search']['whenV']) ?></b>
        </div>
        <svg class="sc-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
        <div class="sc-dropdown sc-drop-months">
          <?php
          $months = $lang==='he'
            ? ['ינואר','פברואר','מרץ','אפריל','מאי','יוני','יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר']
            : ['January','February','March','April','May','June','July','August','September','October','November','December'];
          foreach ($months as $m): ?>
          <button class="sc-opt" type="button"><?= $m ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- 3. Guests (counter) -->
      <div class="search-cell sc-interactive" data-field="who">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <circle cx="8" cy="8" r="3.5" fill="var(--flag-blue)" opacity=".2"/>
            <circle cx="8" cy="8" r="3.5" stroke="var(--flag-blue)" stroke-width="1.8" fill="none"/>
            <path d="M2 20c0-3.3 2.7-6 6-6s6 2.7 6 6" stroke="var(--flag-blue)" stroke-width="1.8" stroke-linecap="round" fill="none"/>
            <circle cx="17" cy="9" r="2.5" stroke="var(--flag-blue)" stroke-width="1.6" fill="none"/>
            <path d="M14.5 19.5c0-2.5 2-4.5 4.5-4.5" stroke="var(--flag-blue)" stroke-width="1.6" stroke-linecap="round" fill="none"/>
          </svg>
        </span>
        <div class="sc-col">
          <label><?= htmlspecialchars($t['search']['who']) ?></label>
          <b class="sc-val" id="sc-guests-display">2 <span class="he">אורחים</span><span class="en">guests</span></b>
        </div>
        <svg class="sc-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
        <div class="sc-dropdown sc-drop-counter">
          <div class="sc-counter-row">
            <span class="he">מספר אורחים</span><span class="en">Number of guests</span>
            <div class="sc-counter" dir="ltr">
              <button class="sc-cnt-btn" id="sc-minus" type="button">−</button>
              <span class="sc-cnt-val" id="sc-cnt">2</span>
              <button class="sc-cnt-btn" id="sc-plus" type="button">+</button>
            </div>
          </div>
        </div>
      </div>

      <!-- 4. Package type (dropdown) -->
      <div class="search-cell sc-interactive" data-field="type">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6L12 2z" fill="var(--flag-yel)" opacity=".6"/>
            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6L12 2z" stroke="var(--flag-blue)" stroke-width="1.6" fill="none" stroke-linejoin="round"/>
          </svg>
        </span>
        <div class="sc-col">
          <label><?= htmlspecialchars($t['search']['type']) ?></label>
          <b class="sc-val" data-placeholder="<?= htmlspecialchars($t['search']['typeV']) ?>" data-type=""><?= htmlspecialchars($t['search']['typeV']) ?></b>
        </div>
        <svg class="sc-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 9l6 6 6-6"/></svg>
        <div class="sc-dropdown sc-drop-types">
          <button class="sc-opt sc-opt-active" type="button" data-type="">
            <span class="he">הכל</span><span class="en">All</span>
          </button>
          <?php foreach ($QUICK_CATS as $cat): ?>
          <button class="sc-opt" type="button" data-type="<?= $cat['id'] ?>">
            <span class="he"><?= htmlspecialchars($cat['he']) ?></span>
            <span class="en"><?= htmlspecialchars($cat['en']) ?></span>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Search button -->
      <button type="button" class="search-go" id="search-go" data-base="packages.php" data-lang="<?= $lang ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.5-4.5"/></svg>
        <?= htmlspecialchars($t['search']['go']) ?>
      </button>
    </div>
  </div>
</section>

<!-- ══ QUICK CATEGORIES ══════════════════════════════════════ -->
<section class="quick-cats">
  <div class="container reveal">
    <div class="qc-grid">
      <?php foreach ($QUICK_CATS as $cat): ?>
      <a href="packages.php?type=<?= $cat['id'] ?><?= $lang==='en'?'&lang=en':'' ?>" class="qc">
        <div class="qc-ic"><?= qc_icon($cat['ic']) ?></div>
        <span class="he"><?= $cat['he'] ?></span>
        <span class="en"><?= htmlspecialchars($cat['en']) ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if ($DEAL_ON): ?>
<!-- ══ DEAL OF THE WEEK (admin-controlled) ════════════════════ -->
<section class="section" style="padding-bottom:0">
  <div class="container">
    <div class="deal-banner reveal">
      <div class="deal-visual">
        <div class="deal-scene"><?= scene_img('warm','deal-img') ?></div>
        <div class="deal-badge-float">
          <span class="deal-pct"><?= (int)$DEAL['discount'] ?>%</span>
          <span class="deal-off he">הנחה</span><span class="deal-off en">OFF</span>
        </div>
      </div>
      <div class="deal-info">
        <div class="deal-eyebrow">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="var(--flag-red)" stroke="none"><path d="M13 2l-8 11h7l-1 9 9-11h-7l2-9z"/></svg>
          <span class="he">מבצע השבוע — מוגבל ל-<?= (int)$DEAL['spots_total'] ?> מקומות</span>
          <span class="en">Deal of the week — limited to <?= (int)$DEAL['spots_total'] ?> spots</span>
        </div>
        <h2 class="deal-title">
          <span class="he"><?= htmlspecialchars($DEAL['title_he'] ?? '') ?></span>
          <span class="en"><?= htmlspecialchars($DEAL['title_en'] ?? '') ?></span>
        </h2>
        <p class="deal-desc">
          <span class="he"><?= htmlspecialchars($DEAL['desc_he'] ?? '') ?></span>
          <span class="en"><?= htmlspecialchars($DEAL['desc_en'] ?? '') ?></span>
        </p>
        <ul class="deal-includes">
          <?php foreach (($DEAL['includes_he'] ?? []) as $i => $inc): ?>
          <li>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
            <span class="he"><?= htmlspecialchars($inc) ?></span>
            <span class="en"><?= htmlspecialchars($DEAL['includes_en'][$i] ?? $inc) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="deal-price-row">
          <div class="deal-price">
            <span class="deal-price-was"><span class="he">במקום</span><span class="en">Was</span> €<?= (int)$DEAL['was_price'] ?></span>
            <div class="deal-price-now">
              <span class="deal-from he">מ-</span><span class="deal-from en">from </span>
              <b>€<?= (int)$DEAL['price'] ?></b>
              <span class="deal-pp">/<span class="he">אדם</span><span class="en">pp</span></span>
            </div>
          </div>
          <div class="deal-spots">
            <?php $fill = $DEAL['spots_total'] > 0 ? round((1-$DEAL['spots_left']/$DEAL['spots_total'])*100) : 65; ?>
            <div class="deal-spots-bar"><div class="deal-spots-fill" style="width:<?= $fill ?>%"></div></div>
            <span class="he">נותרו <?= (int)$DEAL['spots_left'] ?> מקומות</span>
            <span class="en"><?= (int)$DEAL['spots_left'] ?> spots left</span>
          </div>
        </div>
        <div class="deal-actions">
          <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, אני מעוניין במבצע השבוע: '.$DEAL['title_he'] : 'Hi, interested in deal: '.($DEAL['title_en']??'')) ?>" target="_blank" rel="noopener" class="btn btn-primary btn-lg">
            <span class="he">הזמינו עכשיו</span><span class="en">Book now</span>
          </a>
          <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-ghost">
            <span class="he">ראו פרטים</span><span class="en">View details</span>
          </a>
        </div>
        <p class="deal-timer">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          <span class="he">המבצע מסתיים בעוד:</span><span class="en">Deal ends in:</span>
          <b id="deal-countdown"></b>
        </p>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ RECOMMENDED PACKAGES ══════════════════════════════════ -->
<section class="section">
  <div class="container">
    <div class="s-head reveal">
      <h2>
        <span class="he">חבילות <span>מומלצות</span></span>
        <span class="en">Recommended <span>packages</span></span>
      </h2>
      <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="btn-link">
        <span class="he">כל החבילות</span><span class="en">View all</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="he"><path d="M19 12H5M11 5l-7 7 7 7"/></svg>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="en"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </a>
    </div>

    <!-- Tab filter (JS-driven) -->
    <div class="tabs reveal" id="pkg-tabs">
      <?php
      $tab_labels = [
        'all'=>['he'=>'הכל','en'=>'All'],
        'couples'=>['he'=>'זוגיות','en'=>'Couples'],
        'bach'=>['he'=>'רווקים','en'=>'Bachelor'],
        'lux'=>['he'=>'יוקרה','en'=>'Luxury'],
        'wine'=>['he'=>'יקבים','en'=>'Wineries'],
        'group'=>['he'=>'קבוצות','en'=>'Groups'],
      ];
      foreach ($tab_labels as $tid => $labels):
        $count = $tid === 'all' ? count($PACKAGES) : count(array_filter($PACKAGES, fn($p) => $p['type'] === $tid));
      ?>
      <button class="tab <?= $tid==='all'?'active':'' ?>" data-filter="<?= $tid ?>">
        <span class="he"><?= $labels['he'] ?></span>
        <span class="en"><?= htmlspecialchars($labels['en']) ?></span>
        <span class="count"><?= $count ?></span>
      </button>
      <?php endforeach; ?>
    </div>

    <div class="card-grid" id="pkg-grid">
      <?php foreach ($PACKAGES as $p): ?>
      <div class="card-wrap" data-type="<?= $p['type'] ?>">
        <?= render_card($p, $lang, $t['nights'], $t['from']) ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══ PROMO STRIP ════════════════════════════════════════════ -->
<section class="section" style="padding-top:0;padding-bottom:32px">
  <div class="container">
    <div class="promo-strip">
      <div class="promo-bg"></div>
      <div class="promo-orb" style="width:300px;height:300px;top:-80px;right:-80px"></div>
      <div class="promo-orb" style="width:200px;height:200px;bottom:-60px;left:30%"></div>
      <div style="position:relative;z-index:1">
        <h3>
          <span class="he">מועדון Moldova Plus — הצטרפו חינם</span>
          <span class="en">Moldova Plus Club — join free</span>
        </h3>
        <p>
          <span class="he">5% הנחה בכל הזמנה, גישה מוקדמת לחבילות חדשות והטבה אישית בכל יום הולדת. ללא דמי חבר.</span>
          <span class="en">5% off every booking, early access to new packages and a birthday perk. No membership fee.</span>
        </p>
      </div>
      <a href="#" class="btn btn-cta" style="position:relative;z-index:1">
        <span class="he">הצטרפו עכשיו ←</span>
        <span class="en">Join now →</span>
      </a>
    </div>
  </div>
</section>

<!-- ══ REGIONS ════════════════════════════════════════════════ -->
<section class="section" style="padding-top:0">
  <div class="container">
    <div class="s-head reveal">
      <h2>
        <span class="he">חיפוש לפי <span>אזור</span></span>
        <span class="en">Browse by <span>region</span></span>
      </h2>
    </div>
    <div class="region-grid reveal">
      <?php foreach ($REGIONS as $r): ?>
      <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="region">
        <?= scene_img($r['scene']) ?>
        <span class="he"><?= $r['he'] ?></span>
        <span class="en"><?= htmlspecialchars($r['en']) ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══ REVIEWS ════════════════════════════════════════════════ -->
<section class="section alt">
  <div class="container">
    <div class="s-head reveal">
      <h2>
        <span class="he">חוות דעת <span>גולשים</span></span>
        <span class="en">Verified <span>reviews</span></span>
      </h2>
      <span style="font-size:13px;color:var(--ink-mute)">★★★★★ <b style="color:var(--ink)">4.9</b> · <span class="he">מתוך 4,247 ביקורות</span><span class="en">from 4,247 reviews</span></span>
    </div>
    <div class="reviews-slider">
      <div class="reviews-track">
        <?php foreach ([$REVIEWS, $REVIEWS] as $set): foreach ($set as $r): ?>
        <div class="review">
          <div class="review-top">
            <div class="review-avatar" style="background:<?= $r['color'] ?>"><?= $r['initials'] ?></div>
            <div class="review-author">
              <b class="he"><?= $r['name_he'] ?></b>
              <b class="en"><?= htmlspecialchars($r['name_en']) ?></b>
              <span><?= $r['when'] ?></span>
            </div>
            <span class="review-stars"><?= str_repeat('★', $r['stars']) ?></span>
          </div>
          <p>
            <span class="he"><?= $r['body_he'] ?></span>
            <span class="en"><?= htmlspecialchars($r['body_en']) ?></span>
          </p>
          <div class="review-place">
            <span class="he"><?= $r['place_he'] ?></span>
            <span class="en"><?= htmlspecialchars($r['place_en']) ?></span>
          </div>
        </div>
        <?php endforeach; endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══ ARTICLES ═══════════════════════════════════════════════ -->
<section class="section">
  <div class="container">
    <div class="s-head reveal">
      <h2>
        <span class="he">כתבות <span>ומדריכים</span></span>
        <span class="en">From the <span>magazine</span></span>
      </h2>
      <button class="btn-link">
        <span class="he">כל הכתבות</span><span class="en">View all</span>
      </button>
    </div>
    <div class="article-grid">
      <?php foreach ($ARTICLES as $i => $a): ?>
      <a href="article.php?id=<?= $a['id'] ?><?= $lang==='en'?'&lang=en':'' ?>" class="article reveal d<?= $i+1 ?>">
        <div class="article-img"><?= scene_img($a['scene']) ?></div>
        <div class="article-body">
          <span class="article-tag">
            <span class="he"><?= $a['tag_he'] ?></span>
            <span class="en"><?= htmlspecialchars($a['tag_en']) ?></span>
          </span>
          <h4>
            <span class="he"><?= $a['title_he'] ?></span>
            <span class="en"><?= htmlspecialchars($a['title_en']) ?></span>
          </h4>
          <p>
            <span class="he"><?= $a['desc_he'] ?></span>
            <span class="en"><?= htmlspecialchars($a['desc_en']) ?></span>
          </p>
          <div class="article-foot">
            <span><?= $a['read'] ?> <span class="he">דק׳ קריאה</span><span class="en">min read</span></span>
            <span>·</span>
            <span><?= $a['date'] ?></span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>

<?php
// Helper for quick-category icons
function qc_icon(string $name): string {
    $s = 'stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"';
    $icons = [
        'sparkles' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" fill="currentColor" opacity=".15"/>
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>',

        'glass' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <path d="M8 3h8l-2 8a4 4 0 0 1-4 0L8 3z" fill="currentColor" opacity=".15"/>
          <path d="M8 3h8l-2 8a4 4 0 0 1-4 0L8 3z"/>
          <line x1="12" y1="15" x2="12" y2="20"/>
          <line x1="9" y1="20" x2="15" y2="20"/>
        </svg>',

        'badge' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" fill="currentColor" opacity=".15"/>
          <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
        </svg>',

        'wine' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <path d="M8 3h8a7 7 0 0 1-7 7A7 7 0 0 1 8 3z" fill="currentColor" opacity=".15"/>
          <path d="M8 3h8a7 7 0 0 1-7 7A7 7 0 0 1 8 3z"/>
          <line x1="12" y1="10" x2="12" y2="18"/>
          <line x1="8.5" y1="18" x2="15.5" y2="18"/>
        </svg>',

        'spa' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <path d="M12 18c-1-3-5-5-6-8a5 5 0 0 1 6-3" fill="currentColor" opacity=".15"/>
          <path d="M12 18c1-3 5-5 6-8a5 5 0 0 0-6-3" fill="currentColor" opacity=".15"/>
          <path d="M12 18c-1-3-5-5-6-8a5 5 0 0 1 6-3"/>
          <path d="M12 18c1-3 5-5 6-8a5 5 0 0 0-6-3"/>
          <line x1="12" y1="18" x2="12" y2="21"/>
          <line x1="9" y1="21" x2="15" y2="21"/>
        </svg>',

        'plane' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <path d="M18 8h-5l-2-5H9l1 5H5L3 6H1l1 6 1 6h2l2-2h4l-1 5h2l2-5h5a3 3 0 0 0 0-6z" fill="currentColor" opacity=".15"/>
          <path d="M18 8h-5l-2-5H9l1 5H5L3 6H1l1 6 1 6h2l2-2h4l-1 5h2l2-5h5a3 3 0 0 0 0-6z"/>
        </svg>',

        'people' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <circle cx="9" cy="7" r="3" fill="currentColor" opacity=".15"/>
          <circle cx="9" cy="7" r="3"/>
          <path d="M3 21v-2a6 6 0 0 1 6-6h0a6 6 0 0 1 6 6v2"/>
          <circle cx="17" cy="7" r="2.5" fill="currentColor" opacity=".15"/>
          <circle cx="17" cy="7" r="2.5"/>
          <path d="M21 21v-2a5 5 0 0 0-3.5-4.7"/>
        </svg>',

        'mountain' => '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" '.$s.' stroke-width="1.7">
          <path d="M14 2L5 14h7l-1 8 9-12h-7l2-8z" fill="currentColor" opacity=".15"/>
          <path d="M14 2L5 14h7l-1 8 9-12h-7l2-8z"/>
        </svg>',
    ];
    return $icons[$name] ?? '';
}
?>
