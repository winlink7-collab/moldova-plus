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

// 301-redirect old /article?id=X to /article/X
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

$title    = $lang==='he' ? $article['title_he'] : $article['title_en'];
$desc     = $lang==='he' ? $article['desc_he']  : $article['desc_en'];
$body     = $lang==='he' ? ($article['body_he'] ?? '') : ($article['body_en'] ?? $article['body_he'] ?? '');
$tag      = $lang==='he' ? $article['tag_he']   : $article['tag_en'];
$hero_img = $article['image_url'] ?? '';

page_head($title . ' — Moldova Plus', $desc, $lang, '/article/' . $id . ($lang==='en'?'?lang=en':''));
?>
<?php include 'includes/header.php'; ?>

<!-- Reading progress bar -->
<div class="art-progress-bar" id="art-progress-bar"></div>

<!-- ── Hero ─────────────────────────────────────────────── -->
<div class="art-hero">
  <?php if ($hero_img): ?>
    <img src="<?= htmlspecialchars($hero_img) ?>" alt="<?= htmlspecialchars($title) ?>" class="art-hero-img">
  <?php else: ?>
    <div class="art-hero-img art-hero-scene"><?= scene_img($article['scene'] ?? 'gold') ?></div>
  <?php endif; ?>
  <div class="art-hero-overlay"></div>
  <div class="art-hero-body container">
    <div class="crumbs crumbs-light">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <a href="/blog<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בלוג תיירות</span><span class="en">Travel blog</span></a> /
      <span class="cur"><?= htmlspecialchars($tag) ?></span>
    </div>
    <span class="art-tag-pill"<?= le('articles:'.$id.':tag_he') ?>><?= htmlspecialchars($tag) ?></span>
    <h1<?= le('articles:'.$id.':title_he') ?>><?= htmlspecialchars($title) ?></h1>
    <p class="art-hero-lead"<?= le('articles:'.$id.':desc_he') ?>><?= htmlspecialchars($desc) ?></p>
    <div class="art-hero-meta">
      <span class="art-hero-meta-item">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <?= $article['read'] ?> <span class="he">דקות קריאה</span><span class="en">min read</span>
      </span>
      <span class="art-hero-meta-sep">·</span>
      <span class="art-hero-meta-item"><?= $article['date'] ?></span>
    </div>
  </div>
</div>

<!-- ── Article layout ────────────────────────────────────── -->
<div class="art-layout">
  <div class="container">
    <div class="art-layout-grid">

      <!-- Main content -->
      <main class="art-content">
        <div class="art-prose-v2">
          <?= $body ?>
        </div>

        <!-- Tags -->
        <div class="art-tags">
          <span class="art-tag-item"><?= htmlspecialchars($tag) ?></span>
          <span class="art-tag-item"><span class="he">מולדובה</span><span class="en">Moldova</span></span>
          <span class="art-tag-item"><span class="he">טיול</span><span class="en">Travel</span></span>
        </div>

        <!-- Share -->
        <div class="art-share">
          <span class="art-share-label"><span class="he">שתפו את הכתבה</span><span class="en">Share this article</span></span>
          <a href="https://wa.me/?text=<?= urlencode($title . ' — ' . (isset($_SERVER['HTTP_HOST']) ? 'https://'.$_SERVER['HTTP_HOST'].'/article/'.$id : '')) ?>" target="_blank" rel="noopener" class="art-share-btn art-share-wa" aria-label="WhatsApp">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(isset($_SERVER['HTTP_HOST']) ? 'https://'.$_SERVER['HTTP_HOST'].'/article/'.$id : '') ?>" target="_blank" rel="noopener" class="art-share-btn art-share-fb" aria-label="Facebook">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <button class="art-share-btn art-share-copy" onclick="navigator.clipboard&&navigator.clipboard.writeText(window.location.href).then(function(){this.classList.add('copied')}.bind(this))" aria-label="Copy link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
          </button>
        </div>
      </main>

      <!-- Sidebar -->
      <aside class="art-sidebar">

        <!-- WhatsApp CTA -->
        <div class="art-sidebar-cta">
          <div class="art-sidebar-cta-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          </div>
          <h4 class="he">רוצים לטוס למולדובה?</h4>
          <h4 class="en">Ready to visit Moldova?</h4>
          <p class="he">הצוות שלנו בוואטסאפ — מענה תוך דקות.</p>
          <p class="en">Our team on WhatsApp — answers in minutes.</p>
          <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, קראתי את "'.$title.'" ואשמח לשמוע על חבילות' : 'Hi, I read "'.$title.'" and want to hear about packages') ?>"
             target="_blank" rel="noopener" class="art-sidebar-cta-btn">
            <span class="he">שלחו הודעה עכשיו</span>
            <span class="en">Message us now</span>
          </a>
        </div>

        <!-- More articles -->
        <?php $others = array_values(array_filter($ARTICLES, fn($a) => ($a['id']??'') !== $id));
        if ($others): ?>
        <div class="art-sidebar-more">
          <h5 class="art-sidebar-more-title">
            <span class="he">כתבות נוספות</span><span class="en">More articles</span>
          </h5>
          <?php foreach ($others as $oa):
            $_oa_img = !empty($oa['image_url'])
              ? '<img src="'.htmlspecialchars($oa['image_url']).'" alt="" style="width:100%;height:100%;object-fit:cover">'
              : scene_img($oa['scene']);
          ?>
          <a href="/article/<?= $oa['id'] ?><?= $lang==='en'?'?lang=en':'' ?>" class="art-sidebar-card">
            <div class="art-sidebar-card-img"><?= $_oa_img ?></div>
            <div class="art-sidebar-card-body">
              <span class="art-tag-sm"><?= htmlspecialchars($lang==='he' ? $oa['tag_he'] : $oa['tag_en']) ?></span>
              <b><?= htmlspecialchars($lang==='he' ? $oa['title_he'] : $oa['title_en']) ?></b>
              <small><?= $oa['read'] ?> <span class="he">דק׳</span><span class="en">min</span> · <?= $oa['date'] ?></small>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

      </aside>
    </div>
  </div>
</div>

<!-- ── Recommended packages ──────────────────────────────── -->
<?php if ($feature_pkgs): ?>
<section class="art-pkgs-section">
  <div class="container">
    <div class="art-pkgs-head">
      <div>
        <p class="art-pkgs-kicker"><span class="he">בהמשך לקריאה</span><span class="en">Continue reading</span></p>
        <h2 class="art-pkgs-title">
          <span class="he">חבילות <span>מומלצות</span></span>
          <span class="en">Recommended <span>packages</span></span>
        </h2>
      </div>
      <a href="packages<?= $lang==='en'?'?lang=en':'' ?>" class="btn-link art-pkgs-link">
        <span class="he">כל החבילות</span><span class="en">All packages</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
    <div class="card-grid">
      <?php foreach ($feature_pkgs as $fp): echo render_card($fp, $lang, $t['nights'], $t['from']); endforeach; ?>
    </div>
    <div class="art-pkgs-cta">
      <div class="art-pkgs-cta-inner">
        <div class="art-pkgs-cta-text">
          <h3><span class="he">רוצים חבילה שמתאימה בדיוק לכם?</span><span class="en">Want a package tailored for you?</span></h3>
          <p><span class="he">הצוות שלנו יבנה לכם חבילה אישית — מחיר, תאריכים ותוכנית שמתאימים לכם.</span><span class="en">Our team builds custom packages — price, dates and itinerary that fit you perfectly.</span></p>
        </div>
        <div class="art-pkgs-cta-btns">
          <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, אשמח לשמוע על חבילות למולדובה' : 'Hi, I want to hear about Moldova packages') ?>"
             target="_blank" rel="noopener" class="btn btn-wa-lg">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            <span class="he">שלחו לנו הודעה</span><span class="en">Message us</span>
          </a>
          <a href="packages<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-outline-blue">
            <span class="he">לכל החבילות</span><span class="en">Browse all</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<script>
// Reading progress bar
(function(){
  var bar = document.getElementById('art-progress-bar');
  if (!bar) return;
  window.addEventListener('scroll', function(){
    var s = document.documentElement;
    var pct = (s.scrollTop || document.body.scrollTop) / (s.scrollHeight - s.clientHeight) * 100;
    bar.style.width = Math.min(pct, 100) + '%';
  }, {passive: true});
})();
</script>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
