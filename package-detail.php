<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('detail');
$page = 'detail';

$slug = $_GET['slug'] ?? '';
$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$p    = null;
if ($slug) {
    foreach ($PACKAGES as $pkg) { if (($pkg['slug'] ?? '') === $slug) { $p = $pkg; break; } }
} elseif ($id) {
    foreach ($PACKAGES as $pkg) { if ($pkg['id'] === $id) { $p = $pkg; break; } }
}
if (!$p) $p = $PACKAGES[0];

// 301-redirect legacy ?id= URLs to clean slug URL
if (!$slug && !empty($p['slug'])) {
    $dest = '/package/' . $p['slug'] . ($lang === 'en' ? '?lang=en' : '');
    header('Location: ' . $dest, true, 301);
    exit;
}

$title  = raw($p, 'title', $lang);
$loc    = raw($p, 'loc', $lang);
$desc   = raw($p, 'desc', $lang);
$old    = $p['discount'] ? (int)round($p['price'] * (1 + $p['discount']/100)) : 0;
$wa_msg = urlencode($lang==='he'
    ? "היי, אני מעוניין בחבילה: {$title} — {$p['nights']} לילות, " . eur($p['price'])
    : "Hi, I'm interested in: {$title} — {$p['nights']} nights, " . eur($p['price'])
);

// Load overrides from admin
$_pkg_overrides = [];
$_pkg_data_path = __DIR__ . '/data/packages.json';
if (file_exists($_pkg_data_path)) {
    $_pkg_overrides = json_decode(file_get_contents($_pkg_data_path), true) ?? [];
}
$_pov = $_pkg_overrides[$p['id']] ?? [];
$_gal_custom = $_pov['gallery_images'] ?? [];

$scenes_gallery = [$p['scene'] ?? 'warm', 'gold', 'green', 'dark', 'honey', 'light'];
$use_custom_gallery = count($_gal_custom) > 0;

$_canonical = !empty($p['slug']) ? '/package/' . $p['slug'] . ($lang==='en'?'?lang=en':'') : '';
page_head(
    ($lang==='he' ? $title : htmlspecialchars($title)) . ' — Moldova Plus',
    ($lang==='he' ? $desc  : htmlspecialchars($desc)),
    $lang,
    $_canonical
);
?>
<?php include 'includes/header.php'; ?>

<section style="padding:28px 0 0">
  <div class="container">

    <!-- Breadcrumb -->
    <div class="crumbs" style="margin-bottom:16px">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <a href="packages<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">חבילות</span><span class="en">Packages</span></a> /
      <span class="cur"><?= htmlspecialchars($title) ?></span>
    </div>

    <!-- Lightbox -->
    <div class="gal-lightbox" id="gal-lightbox" role="dialog" aria-modal="true">
      <div class="gal-lb-top">
        <span class="gal-lb-counter" id="gal-lb-counter">1 / 6</span>
        <button class="gal-lb-close" id="gal-lb-close" aria-label="<?= $lang==='he'?'סגור':'Close' ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="gal-lb-img-wrap">
        <img src="" alt="" id="gal-lb-img">
      </div>
      <button class="gal-lb-prev" id="gal-lb-prev" aria-label="<?= $lang==='he'?'הקודם':'Previous' ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button class="gal-lb-next" id="gal-lb-next" aria-label="<?= $lang==='he'?'הבא':'Next' ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
      </button>
      <div class="gal-lb-thumbs" id="gal-lb-thumbs"></div>
    </div>

    <!-- Gallery: 6 images -->
    <div class="detail-gal" id="detail-gal"<?= LE_ADMIN ? ' data-le-gallery="packages:' . $p['id'] . ':gallery_images" data-gal-current="' . htmlspecialchars(json_encode($_gal_custom, JSON_UNESCAPED_UNICODE), ENT_QUOTES) . '"' : '' ?>>
      <?php if ($use_custom_gallery):
        $gal_show = array_slice($_gal_custom, 0, 6);
        while (count($gal_show) < 6) {
          $gal_show[] = null; // fill with scenes below
        }
        foreach ($gal_show as $i => $gurl):
          $is_last = $i === 5;
      ?>
      <div class="gm<?= $is_last?' gm-last':'' ?>">
        <?php if ($gurl): ?>
        <img src="<?= htmlspecialchars($gurl) ?>" alt="" style="width:100%;height:100%;object-fit:cover">
        <?php else: ?>
        <?= scene_img($scenes_gallery[$i] ?? 'warm') ?>
        <?php endif; ?>
        <?php if ($is_last): ?>
        <button class="gal-all-btn" type="button">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
          <span class="he">כל התמונות</span><span class="en">All photos</span>
        </button>
        <?php endif; ?>
      </div>
      <?php endforeach;
      else:
        foreach ($scenes_gallery as $i => $sc): ?>
      <div class="gm<?= $i===5?' gm-last':'' ?>">
        <?= scene_img($sc) ?>
        <?php if ($i===5): ?>
        <button class="gal-all-btn" type="button">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
          <span class="he">כל התמונות</span><span class="en">All photos</span>
        </button>
        <?php endif; ?>
      </div>
      <?php endforeach;
      endif; ?>
    </div>

    <!-- Content grid -->
    <div class="detail-grid">

      <!-- Main content -->
      <div class="detail-main">
        <span class="card-loc"<?= le('packages:' . $p['id'] . ':loc_he') ?> style="margin-bottom:10px">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
          <?= htmlspecialchars($loc) ?>
        </span>
        <h1<?= le('packages:' . $p['id'] . ':title_he') ?>><?= htmlspecialchars($title) ?></h1>

        <div class="detail-meta">
          <span class="badge">★ <?= $p['rating'] ?></span>
          <span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 13a9 9 0 1 1-10-10 7 7 0 0 0 10 10z"/></svg>
            <?= $p['nights'] ?> <?= htmlspecialchars($t['nights']) ?>
          </span>
          <span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><circle cx="17" cy="9" r="2.5"/><path d="M15 20a5 5 0 0 1 6.5-4.7"/></svg>
            <?= htmlspecialchars(raw($p,'people',$lang)) ?>
          </span>
          <span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
            <span class="he">אישור מיידי</span><span class="en">Instant booking</span>
          </span>
          <?php if (raw($p,'tag',$lang)): ?>
          <span style="background:var(--rose);color:#fff;padding:5px 11px;border-radius:7px;font-weight:700"><?= htmlspecialchars(raw($p,'tag',$lang)) ?></span>
          <?php endif; ?>
        </div>

        <!-- About -->
        <div class="det-section">
          <h3><span class="he">על החבילה</span><span class="en">About this package</span></h3>
          <p<?= le('packages:' . $p['id'] . ':desc_he') ?>><?= htmlspecialchars($desc ?: ($lang==='he'
              ? 'חבילה ייחודית במולדובה שעוצבה במיוחד עבור אורחים שמחפשים שילוב של יוקרה, חוויה אותנטית וערך כלכלי גבוה. כל פרט בחבילה תוכנן בקפידה — מהאיסוף בשדה התעופה ועד הליווי המקומי.'
              : 'A distinctive Moldova package designed for guests seeking a blend of luxury, authentic experience and high value. Every detail is carefully planned — from the airport pickup to the local fixer.')) ?>
          </p>
        </div>

        <!-- What's included -->
        <div class="det-section">
          <h3><span class="he">מה כלול</span><span class="en">What's included</span></h3>
          <?php
          $_default_inc_he = ['4 לילות במלון בוטיק יוקרתי','ארוחות בוקר עשירות','יום ספא מלא לזוג','סיור ביקב Mileștii Mici','ערב גסטרונומי עם זיווגי יין','איסוף ופיזור משדה התעופה','ליווי מקומי דובר אנגלית','WiFi מהיר וביטוח בריאות'];
          $_default_inc_en = ['4 nights in a luxury boutique hotel','Generous daily breakfasts','Full spa day for two','Mileștii Mici winery tour','Gastronomic evening with wine pairing','Airport pickup & drop-off','English-speaking local fixer','Fast WiFi and health insurance'];
          $inc_he = !empty($_pov['includes_he']) ? $_pov['includes_he'] : $_default_inc_he;
          $inc_en = $_default_inc_en;
          ?>
          <ul class="incl">
            <?php foreach ($lang==='he' ? $inc_he : $inc_en as $item): ?>
              <li><?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Itinerary -->
        <div class="det-section">
          <h3><span class="he">המסלול</span><span class="en">Itinerary</span></h3>
          <?php
          $itin = $lang === 'he' ? [
            ['d'=>'יום 1','t'=>'הגעה והכרות','p'=>'איסוף משדה התעופה, צ׳ק-אין במלון, סיור הליכה ערב במרכז העיר ההיסטורי וארוחת ערב פתיחה במסעדת שף מקומית.'],
            ['d'=>'יום 2','t'=>'יום היין הגדול','p'=>'יציאה ל-Mileștii Mici — היקב הגדול בעולם. סיור ברכב מתחת לאדמה, טעימה של 6 יינות וארוחת צהריים בקלרייר תת-קרקעי.'],
            ['d'=>'יום 3','t'=>'יום ספא ופינוק','p'=>'בוקר חופשי, צהריים יום ספא מלא — סאונה, ג׳קוזי, עיסוי זוגי ופנים. ערב חופשי לבחירתכם.'],
            ['d'=>'יום 4','t'=>'אדרנלין או תרבות','p'=>'בחירה: יום קארטינג ורכבי שטח, או סיור במנזר Capriana ואורהיי וצי הארכיאולוגי. ארוחת ערב פרידה.'],
            ['d'=>'יום 5','t'=>'פרידה','p'=>'ארוחת בוקר אחרונה, צ׳ק-אאוט והסעה לשדה התעופה.'],
          ] : [
            ['d'=>'Day 1','t'=>'Arrival','p'=>'Airport pickup, hotel check-in, evening walking tour of the historic center and welcome dinner at a chef restaurant.'],
            ['d'=>'Day 2','t'=>'The Big Wine Day','p'=>"Excursion to Mileștii Mici — the world's largest winery. Underground vehicle tour, 6-wine tasting and lunch in a subterranean cellar."],
            ['d'=>'Day 3','t'=>'Spa & Indulgence','p'=>'Free morning, afternoon full spa day — sauna, jacuzzi, couples massage and facial. Evening at your leisure.'],
            ['d'=>'Day 4','t'=>'Adrenaline or Culture','p'=>"Choice of: karting and ATV day, or visit to Capriana Monastery and Orheiul Vechi. Farewell dinner."],
            ['d'=>'Day 5','t'=>'Departure','p'=>'Final breakfast, check-out and airport transfer.'],
          ];
          foreach ($itin as $day): ?>
          <div class="itin-row">
            <div class="itin-day"><?= htmlspecialchars($day['d']) ?></div>
            <div>
              <b><?= htmlspecialchars($day['t']) ?></b>
              <p><?= htmlspecialchars($day['p']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Booking sidebar -->
      <aside class="booking">
        <div class="price">
          <small><?= htmlspecialchars($t['from']) ?></small>
          <?php if ($old): ?><span class="old"><?= eur($old) ?></span><?php endif; ?>
          <b<?= le('packages:' . $p['id'] . ':price') ?>><?= eur($p['price']) ?><sub> /<?= $lang==='he'?'אדם':'person' ?></sub></b>
          <?php if ($p['discount']): ?>
            <span class="save">
              <span class="he">חיסכון של <?= $p['discount'] ?>%</span>
              <span class="en">Save <?= $p['discount'] ?>%</span>
            </span>
          <?php endif; ?>
        </div>

        <div class="booking-row split">
          <div>
            <label><span class="he">הגעה</span><span class="en">Check-in</span></label>
            <div class="ctrl">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
              <input type="date" style="border:0;background:transparent;flex:1;font:inherit;color:var(--ink);outline:none;cursor:pointer" min="<?= date('Y-m-d') ?>">
            </div>
          </div>
          <div>
            <label><span class="he">יציאה</span><span class="en">Check-out</span></label>
            <div class="ctrl">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
              <input type="date" style="border:0;background:transparent;flex:1;font:inherit;color:var(--ink);outline:none;cursor:pointer" min="<?= date('Y-m-d') ?>">
            </div>
          </div>
        </div>

        <div class="booking-row">
          <label><span class="he">אורחים</span><span class="en">Guests</span></label>
          <div class="ctrl">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><circle cx="17" cy="9" r="2.5"/><path d="M15 20a5 5 0 0 1 6.5-4.7"/></svg>
            <select>
              <option>2 <?= $lang==='he'?'מבוגרים':'adults' ?></option>
              <option>3 <?= $lang==='he'?'מבוגרים':'adults' ?></option>
              <option>4 <?= $lang==='he'?'מבוגרים':'adults' ?></option>
              <option>6 <?= $lang==='he'?'מבוגרים':'adults' ?></option>
              <option>8 <?= $lang==='he'?'מבוגרים':'adults' ?></option>
            </select>
          </div>
        </div>

        <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= $wa_msg ?>" target="_blank" rel="noopener"
           class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;text-decoration:none">
          <span class="he">הזמינו עכשיו</span>
          <span class="en">Book now</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="he"><path d="M19 12H5M11 5l-7 7 7 7"/></svg>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="en"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>

        <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= $wa_msg ?>" target="_blank" rel="noopener"
           class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:8px;text-decoration:none">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          <span class="he">דברו איתנו</span>
          <span class="en">Chat with us</span>
        </a>

        <div class="booking-trust">
          <span>
            <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg></span>
            <span class="he">ביטול חינם עד 14 יום</span><span class="en">Free cancellation up to 14 days</span>
          </span>
          <span>
            <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg></span>
            <span class="he">אישור מיידי</span><span class="en">Instant confirmation</span>
          </span>
          <span>
            <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg></span>
            <span class="he">תשלום מאובטח</span><span class="en">Secure payment</span>
          </span>
        </div>
      </aside>
    </div>

    <!-- Related packages -->
    <?php
    $related = array_values(array_filter($PACKAGES, fn($pkg) => $pkg['id'] !== $p['id'] && $pkg['type'] === $p['type']));
    if (!$related) $related = array_values(array_filter($PACKAGES, fn($pkg) => $pkg['id'] !== $p['id']));
    $related = array_slice($related, 0, 4);
    if ($related): ?>
    <div style="margin-top:56px;padding-top:40px;border-top:1px solid var(--line)">
      <div class="s-head">
        <h2 style="font-size:24px">
          <span class="he">חבילות <span>דומות</span></span>
          <span class="en">Related <span>packages</span></span>
        </h2>
      </div>
      <div class="card-grid">
        <?php foreach ($related as $rp): ?>
          <?= render_card($rp, $lang, $t['nights'], $t['from']) ?>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
