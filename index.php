<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';

[$lang, $t] = page_init('home');
$page = 'home';

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

      <!-- Images -->
      <div class="hero-img-wrap">
        <div class="hero-img-1"><?= scene_hero_main() ?></div>
        <div class="hero-img-2"><?= scene_hero_secondary() ?></div>
        <div class="hero-floating">
          <div class="av-row">
            <span class="av"></span>
            <span class="av" style="background:linear-gradient(135deg,#ffd400,#0046ae)"></span>
            <span class="av" style="background:linear-gradient(135deg,#cc1126,#ffd400)"></span>
          </div>
          <div class="fl-text">
            <b>+12,400</b>
            <span class="he">אורחים מרוצים</span>
            <span class="en">happy guests</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Search bar -->
    <div class="search-bar">
      <div class="search-cell" onclick="location.href='packages.php<?= $lang==='en'?'?lang=en':'' ?>'">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
      <div class="search-cell">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
          <b><?= htmlspecialchars($t['search']['whenV']) ?></b>
        </div>
      </div>
      <div class="search-cell">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="8" cy="8" r="3.5" fill="var(--flag-blue)" opacity=".2"/>
            <circle cx="8" cy="8" r="3.5" stroke="var(--flag-blue)" stroke-width="1.8" fill="none"/>
            <path d="M2 20c0-3.3 2.7-6 6-6s6 2.7 6 6" stroke="var(--flag-blue)" stroke-width="1.8" stroke-linecap="round" fill="none"/>
            <circle cx="17" cy="9" r="2.5" stroke="var(--flag-blue)" stroke-width="1.6" fill="none"/>
            <path d="M14.5 19.5c0-2.5 2-4.5 4.5-4.5" stroke="var(--flag-blue)" stroke-width="1.6" stroke-linecap="round" fill="none"/>
          </svg>
        </span>
        <div class="sc-col">
          <label><?= htmlspecialchars($t['search']['who']) ?></label>
          <b><?= htmlspecialchars($t['search']['whoV']) ?></b>
        </div>
      </div>
      <div class="search-cell">
        <span class="sc-ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6L12 2z" fill="var(--flag-yel)" opacity=".6"/>
            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6L12 2z" stroke="var(--flag-blue)" stroke-width="1.6" fill="none" stroke-linejoin="round"/>
          </svg>
        </span>
        <div class="sc-col">
          <label><?= htmlspecialchars($t['search']['type']) ?></label>
          <b><?= htmlspecialchars($t['search']['typeV']) ?></b>
        </div>
      </div>
      <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="search-go">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.5-4.5"/></svg>
        <?= htmlspecialchars($t['search']['go']) ?>
      </a>
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
<section class="section" style="padding-top:0">
  <div class="container reveal">
    <div class="promo-strip">
      <div class="promo-bg"></div>
      <div class="promo-orb" style="width:300px;height:300px;top:-80px;right:-80px"></div>
      <div class="promo-orb" style="width:200px;height:200px;bottom:-60px;left:30%"></div>
      <div>
        <h3>
          <span class="he">מועדון Moldova Plus — הצטרפו חינם</span>
          <span class="en">Moldova Plus Club — join free</span>
        </h3>
        <p>
          <span class="he">5% הנחה בכל הזמנה, גישה מוקדמת לחבילות חדשות והטבה אישית בכל יום הולדת. ללא דמי חבר.</span>
          <span class="en">5% off every booking, early access to new packages and a birthday perk. No membership fee.</span>
        </p>
      </div>
      <a href="#" class="btn">
        <span class="he">הצטרפו עכשיו</span>
        <span class="en">Join now</span>
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
    <div class="reviews-grid">
      <?php foreach ($REVIEWS as $i => $r): ?>
      <div class="review reveal d<?= ($i%4)+1 ?>">
        <div class="review-top">
          <div class="review-avatar" style="background:<?= $r['color'] ?>"><?= $r['initials'] ?></div>
          <div class="review-author">
            <b class="he"><?= $r['name_he'] ?></b>
            <b class="en"><?= htmlspecialchars($r['name_en']) ?></b>
            <span><?= $r['when'] ?></span>
          </div>
          <span class="review-stars" style="margin-right:auto"><?= str_repeat('★', $r['stars']) ?></span>
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
      <?php endforeach; ?>
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
      <a href="#" class="article reveal d<?= $i+1 ?>">
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
    $icons = [
        'sparkles' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16 4l2.5 7.5L26 14l-7.5 2.5L16 24l-2.5-7.5L6 14l7.5-2.5L16 4z" fill="#ffd400" stroke="#0046ae" stroke-width="1.5" stroke-linejoin="round"/>
          <circle cx="7" cy="7" r="2" fill="#cc1126" opacity=".7"/>
          <circle cx="25" cy="25" r="1.5" fill="#0046ae" opacity=".6"/>
        </svg>',

        'glass' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8 4h16l-2.5 11A5.5 5.5 0 0 1 10.5 15L8 4z" fill="#cc1126" opacity=".18"/>
          <path d="M8 4h16l-2.5 11A5.5 5.5 0 0 1 10.5 15L8 4z" stroke="#cc1126" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
          <line x1="16" y1="15" x2="16" y2="24" stroke="#cc1126" stroke-width="2" stroke-linecap="round"/>
          <rect x="11" y="24" width="10" height="2.5" rx="1.25" fill="#cc1126" opacity=".5"/>
          <ellipse cx="16" cy="10" rx="4" ry="1.5" fill="#cc1126" opacity=".25"/>
        </svg>',

        'badge' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16 3l3 5 6 1-4.5 4 1 6L16 16l-5.5 3 1-6L7 9l6-1 3-5z" fill="#ffd400" stroke="#0046ae" stroke-width="1.5" stroke-linejoin="round"/>
          <circle cx="16" cy="10" r="3" fill="#0046ae" opacity=".3"/>
          <path d="M12 20l-2 8 6-3.5 6 3.5-2-8" stroke="#0046ae" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </svg>',

        'wine' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M11 4h10v5a5 5 0 0 1-10 0V4z" fill="#5a1a6b" opacity=".2"/>
          <path d="M11 4h10v5a5 5 0 0 1-10 0V4z" stroke="#5a1a6b" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
          <ellipse cx="16" cy="11" rx="3.5" ry="1.2" fill="#5a1a6b" opacity=".3"/>
          <line x1="16" y1="14" x2="16" y2="24" stroke="#5a1a6b" stroke-width="2" stroke-linecap="round"/>
          <rect x="11" y="24" width="10" height="2.5" rx="1.25" fill="#5a1a6b" opacity=".5"/>
          <path d="M11 7.5 Q14 9 17 7.5" stroke="#fff" stroke-width="1" opacity=".5" fill="none"/>
        </svg>',

        'spa' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16 4c2 5 7 7 7 12 0 4.5-3.1 7-7 7s-7-2.5-7-7c0-5 5-7 7-12z" fill="#2e9b5e" opacity=".2"/>
          <path d="M16 4c2 5 7 7 7 12 0 4.5-3.1 7-7 7s-7-2.5-7-7c0-5 5-7 7-12z" stroke="#2e9b5e" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
          <path d="M12 19c1.5-2 4-2.5 4-2.5s2.5.5 4 2.5" stroke="#2e9b5e" stroke-width="1.5" stroke-linecap="round" fill="none"/>
          <ellipse cx="16" cy="27" rx="5" ry="1.2" fill="#2e9b5e" opacity=".2"/>
        </svg>',

        'plane' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M27 10l-5 2-7-7-3 1 4 8-5 2-2-2-2 1 2 4 4 2 1-2 2-2 8 4 1-3-7-7 5-2 4 2 1-1z" fill="#0046ae" opacity=".2"/>
          <path d="M27 10l-5 2-7-7-3 1 4 8-5 2-2-2-2 1 2 4 4 2 1-2 2-2 8 4 1-3-7-7 5-2 4 2 1-1z" stroke="#0046ae" stroke-width="1.6" stroke-linejoin="round" fill="none"/>
          <line x1="6" y1="26" x2="14" y2="26" stroke="#0046ae" stroke-width="1.8" stroke-linecap="round" opacity=".5"/>
        </svg>',

        'people' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="11" cy="10" r="4" fill="#0046ae" opacity=".2"/>
          <circle cx="11" cy="10" r="4" stroke="#0046ae" stroke-width="1.8" fill="none"/>
          <path d="M3 26c0-4.4 3.6-8 8-8s8 3.6 8 8" stroke="#0046ae" stroke-width="1.8" stroke-linecap="round" fill="none"/>
          <circle cx="22" cy="11" r="3" stroke="#ffd400" stroke-width="1.8" fill="#ffd400" opacity=".35"/>
          <path d="M19 26c0-3.3 2.7-6 6-6" stroke="#ffd400" stroke-width="1.8" stroke-linecap="round" fill="none"/>
        </svg>',

        'mountain' => '<svg width="26" height="26" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 26l7-13 5 7 5-9 7 15H4z" fill="#cc1126" opacity=".15"/>
          <path d="M4 26l7-13 5 7 5-9 7 15H4z" stroke="#cc1126" stroke-width="1.8" stroke-linejoin="round" fill="none"/>
          <path d="M11 13l1.5-1 1.5 1" stroke="#fff" stroke-width="1.2" stroke-linecap="round" opacity=".7"/>
          <circle cx="23" cy="8" r="2.5" fill="#ffd400" opacity=".7"/>
          <path d="M21.5 8.5 Q23 7 24.5 8.5" stroke="#fff" stroke-width=".8" opacity=".6" fill="none"/>
        </svg>',
    ];
    return $icons[$name] ?? '';
}
?>
