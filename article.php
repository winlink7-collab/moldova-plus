<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('articles');

$id = isset($_GET['id']) ? preg_replace('/[^a-z0-9\-]/', '', $_GET['id']) : '';

$article = null;
foreach ($ARTICLES as $a) {
    if (($a['id'] ?? '') === $id) { $article = $a; break; }
}
if (!$article) { header('Location: /'); exit; }

// 301-redirect old /article?id=X to clean /article/X
if ($id && strpos($_SERVER['REQUEST_URI'] ?? '', '/article/') === false) {
    header('Location: /article/' . $id . ($lang === 'en' ? '?lang=en' : ''), true, 301);
    exit;
}

$related_types = $article['related_types'] ?? [];
$feature_pkgs  = array_slice(array_values(array_filter($PACKAGES, fn($p) => in_array($p['type'], $related_types))), 0, 3);
if (count($feature_pkgs) < 3) {
    $extra = array_filter($PACKAGES, fn($p) => !in_array($p['id'], array_column($feature_pkgs,'id')));
    $feature_pkgs = array_slice(array_merge($feature_pkgs, array_values($extra)), 0, 3);
}

$title = $lang==='he' ? $article['title_he'] : $article['title_en'];
$desc  = $lang==='he' ? $article['desc_he']  : $article['desc_en'];
$body  = $lang==='he' ? ($article['body_he'] ?? '') : ($article['body_en'] ?? $article['body_he'] ?? '');
$tag   = $lang==='he' ? $article['tag_he']   : $article['tag_en'];

page_head($title . ' — Moldova Plus', $desc, $lang);
?>
<?php include 'includes/header.php'; ?>

<!-- ── Article Banner ──────────────────────────────────── -->
<section class="art-banner-v2">
  <div class="container">
    <div class="crumbs">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <a href="articles<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בלוג תיירות</span><span class="en">Travel blog</span></a> /
      <span class="cur"><?= htmlspecialchars($tag) ?></span>
    </div>
    <div class="art-banner-text">
      <span class="art-tag-pill"><?= htmlspecialchars($tag) ?></span>
      <h1<?= le('articles:' . ($article['id'] ?? '') . ':title_he') ?>><?= htmlspecialchars($title) ?></h1>
      <p class="art-lead"<?= le('articles:' . ($article['id'] ?? '') . ':desc_he') ?>><?= htmlspecialchars($desc) ?></p>
      <div class="art-meta">
        <span>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <?= $article['read'] ?> <span class="he">דקות קריאה</span><span class="en">min read</span>
        </span>
        <span>·</span>
        <span><?= $article['date'] ?></span>
      </div>
    </div>
  </div>
</section>

<!-- ── Article Prose ─────────────────────────────────────── -->
<section class="art-prose-section">
  <div class="container">
    <div class="art-prose-wrap">
      <div class="art-prose-v2">
        <?= $body ?>
      </div>

      <!-- Inline WhatsApp CTA -->
      <div class="art-cta-inline">
        <div class="art-cta-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
        </div>
        <div>
          <b class="he">מוכנים לתכנן את הטיול?</b><b class="en">Ready to plan?</b>
          <span class="he">הצוות שלנו זמין עכשיו בוואטסאפ ומשיב תוך דקות.</span>
          <span class="en">Our team is available on WhatsApp and responds within minutes.</span>
        </div>
        <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, קראתי את "'.$title.'" ואשמח לשמוע על חבילות' : 'Hi, I read "'.$title.'" and want to hear about packages') ?>"
           target="_blank" rel="noopener" class="btn-wa-inline">
          <span class="he">דברו איתנו</span><span class="en">Chat now</span>
        </a>
      </div>

      <!-- Other articles -->
      <div class="art-related-articles">
        <h3 class="he">כתבות נוספות</h3><h3 class="en">More articles</h3>
        <div class="art-more-grid-v2">
          <?php foreach ($ARTICLES as $oa): if (($oa['id'] ?? '') === $id) continue; ?>
          <a href="article/<?= $oa['id'] ?><?= $lang==='en'?'?lang=en':'' ?>" class="art-more-card-v2">
            <div class="art-more-img-v2"><?= scene_img($oa['scene']) ?></div>
            <div class="art-more-body-v2">
              <span class="art-tag-sm"><?= $lang==='he' ? $oa['tag_he'] : htmlspecialchars($oa['tag_en']) ?></span>
              <b><?= $lang==='he' ? $oa['title_he'] : htmlspecialchars($oa['title_en']) ?></b>
              <small><?= $oa['read'] ?> <span class="he">דק׳</span><span class="en">min</span> · <?= $oa['date'] ?></small>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Featured Packages ─────────────────────────────────── -->
<section class="art-pkgs-section">
  <div class="container">

    <div class="art-pkgs-head">
      <div>
        <p class="art-pkgs-kicker"><span class="he">חבילות מומלצות</span><span class="en">Recommended packages</span></p>
        <h2 class="art-pkgs-title">
          <span class="he">תכננו את הטיול <span>הבא שלכם</span></span>
          <span class="en">Plan your <span>next trip</span></span>
        </h2>
      </div>
      <a href="packages<?= $lang==='en'?'?lang=en':'' ?>" class="btn-link art-pkgs-link">
        <span class="he">כל החבילות</span><span class="en">All packages</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="card-grid">
      <?php foreach ($feature_pkgs as $i => $p): ?>
      <a href="package-detail?id=<?= $p['id'] ?><?= $lang==='en'?'&lang=en':'' ?>" class="card reveal d<?= $i+1 ?>">
        <div class="card-img">
          <?= scene_img($p['scene']) ?>
          <?php if (!empty($p['tag_he'])): ?>
          <span class="card-badge"><?= $lang==='he' ? $p['tag_he'] : htmlspecialchars($p['tag_en'] ?? $p['tag_he']) ?></span>
          <?php endif; ?>
          <span class="card-rating"><span class="star">★</span> <?= $p['rating'] ?></span>
          <span class="card-nights"><?= $p['nights'] ?> <span class="he">לילות</span><span class="en">nights</span></span>
        </div>
        <div class="card-body">
          <span class="card-loc">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
            <?= $lang==='he' ? $p['loc_he'] : htmlspecialchars($p['loc_en']) ?>
          </span>
          <h3 class="card-title"><?= $lang==='he' ? $p['title_he'] : htmlspecialchars($p['title_en']) ?></h3>
          <p class="card-desc"><?= $lang==='he' ? $p['desc_he'] : htmlspecialchars($p['desc_en']) ?></p>
          <div class="card-foot">
            <div class="card-price">
              <small><?= $lang==='he'?'מחיר לאדם':'per person' ?></small>
              <b>₪<?= number_format($p['price']) ?></b>
            </div>
            <span class="btn btn-primary btn-sm">
              <span class="he">פרטים</span><span class="en">Details</span>
            </span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Bottom CTA -->
    <div class="art-pkgs-cta">
      <div class="art-pkgs-cta-inner">
        <div class="art-pkgs-cta-text">
          <h3>
            <span class="he">רוצים חבילה שמתאימה בדיוק לכם?</span>
            <span class="en">Want a package tailored just for you?</span>
          </h3>
          <p>
            <span class="he">הצוות שלנו יבנה לכם חבילה אישית — מחיר, תאריכים ותוכנית שמתאימים לכם.</span>
            <span class="en">Our team will build you a custom package — price, dates and itinerary that fits you perfectly.</span>
          </p>
        </div>
        <div class="art-pkgs-cta-btns">
          <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, אשמח לשמוע על חבילות למולדובה' : 'Hi, I want to hear about Moldova packages') ?>"
             target="_blank" rel="noopener" class="btn btn-wa-lg">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            <span class="he">שלחו לנו הודעה</span><span class="en">Message us</span>
          </a>
          <a href="packages<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-outline-blue">
            <span class="he">לכל החבילות</span><span class="en">Browse all packages</span>
          </a>
        </div>
      </div>
    </div>

  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
