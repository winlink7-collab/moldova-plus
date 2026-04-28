<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('articles');

$id = isset($_GET['id']) ? preg_replace('/[^a-z0-9\-]/', '', $_GET['id']) : '';

// Find article
$article = null;
foreach ($ARTICLES as $a) {
    if (($a['id'] ?? '') === $id) { $article = $a; break; }
}
if (!$article) { header('Location: index.php'); exit; }

// Related packages
$related_types = $article['related_types'] ?? [];
$related_pkgs  = array_slice(array_values(array_filter($PACKAGES, fn($p) => in_array($p['type'], $related_types))), 0, 3);
if (count($related_pkgs) < 2) {
    $related_pkgs = array_slice($PACKAGES, 0, 3);
}

$title    = $lang==='he' ? $article['title_he'] : $article['title_en'];
$desc     = $lang==='he' ? $article['desc_he']  : $article['desc_en'];
$body     = $lang==='he' ? ($article['body_he'] ?? '') : ($article['body_en'] ?? $article['body_he'] ?? '');
$tag      = $lang==='he' ? $article['tag_he']   : $article['tag_en'];

page_head($title . ' — Moldova Plus', $desc, $lang);
?>
<?php include 'includes/header.php'; ?>

<!-- Banner -->
<section class="page-banner art-banner" style="padding-bottom:0;overflow:hidden">
  <div class="container">
    <div class="crumbs">
      <a href="index.php<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur"><?= htmlspecialchars($tag) ?></span>
    </div>
    <span class="art-tag-pill"><?= htmlspecialchars($tag) ?></span>
    <h1><?= htmlspecialchars($title) ?></h1>
    <p class="art-desc"><?= htmlspecialchars($desc) ?></p>
    <div class="art-meta">
      <span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <?= $article['read'] ?> <span class="he">דקות קריאה</span><span class="en">min read</span>
      </span>
      <span>·</span>
      <span><?= $article['date'] ?></span>
    </div>
  </div>
  <div class="art-hero-img">
    <?= scene_img($article['scene'], 'art-hero-scene') ?>
    <div class="art-hero-fade"></div>
  </div>
</section>

<!-- Content + Sidebar -->
<section class="section" style="padding-top:48px">
  <div class="container">
    <div class="art-layout">

      <!-- ── Main article content ── -->
      <article class="art-body">
        <div class="art-prose">
          <?= $body ?>
        </div>

        <!-- Share / CTA -->
        <div class="art-cta-box">
          <div class="art-cta-text">
            <b class="he">מוכנים לתכנן את הטיול?</b>
            <b class="en">Ready to plan your trip?</b>
            <span class="he">הצוות שלנו זמין עכשיו בוואטסאפ</span>
            <span class="en">Our team is available now on WhatsApp</span>
          </div>
          <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, קראתי את הכתבה "'.$title.'" ואשמח לשמוע על חבילות מתאימות' : 'Hi, I read the article "'.$title.'" and would like to hear about relevant packages') ?>"
             target="_blank" rel="noopener" class="btn btn-whatsapp-cta">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            <span class="he">דברו איתנו</span><span class="en">Contact us</span>
          </a>
        </div>

        <!-- Other articles -->
        <div class="art-more">
          <h3 class="he">כתבות נוספות</h3><h3 class="en">More articles</h3>
          <div class="art-more-grid">
            <?php foreach ($ARTICLES as $oa): if ($oa['id'] === $id) continue; ?>
            <a href="article.php?id=<?= $oa['id'] ?><?= $lang==='en'?'&lang=en':'' ?>" class="art-more-card">
              <div class="art-more-img"><?= scene_img($oa['scene']) ?></div>
              <div class="art-more-body">
                <span class="article-tag"><?= $lang==='he' ? $oa['tag_he'] : htmlspecialchars($oa['tag_en']) ?></span>
                <b><?= $lang==='he' ? $oa['title_he'] : htmlspecialchars($oa['title_en']) ?></b>
                <small><?= $oa['read'] ?> <span class="he">דק׳ קריאה</span><span class="en">min</span> · <?= $oa['date'] ?></small>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </article>

      <!-- ── Sidebar ── -->
      <aside class="art-sidebar">
        <div class="art-sidebar-inner">
          <h3 class="art-sidebar-title">
            <span class="he">חבילות מומלצות</span>
            <span class="en">Recommended packages</span>
          </h3>
          <?php foreach ($related_pkgs as $p): ?>
          <a href="package-detail.php?id=<?= $p['id'] ?><?= $lang==='en'?'&lang=en':'' ?>" class="art-pkg-card">
            <div class="art-pkg-img">
              <?= scene_img($p['scene'], 'art-pkg-scene') ?>
              <?php if (!empty($p['tag_he'])): ?>
              <span class="art-pkg-badge"><?= $lang==='he' ? $p['tag_he'] : htmlspecialchars($p['tag_en'] ?? $p['tag_he']) ?></span>
              <?php endif; ?>
            </div>
            <div class="art-pkg-body">
              <span class="art-pkg-loc">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
                <?= $lang==='he' ? $p['loc_he'] : htmlspecialchars($p['loc_en']) ?>
              </span>
              <b class="art-pkg-title"><?= $lang==='he' ? $p['title_he'] : htmlspecialchars($p['title_en']) ?></b>
              <div class="art-pkg-info">
                <span>🌙 <?= $p['nights'] ?> <span class="he">לילות</span><span class="en">nights</span></span>
                <span class="art-pkg-price">₪<?= number_format($p['price']) ?></span>
              </div>
            </div>
          </a>
          <?php endforeach; ?>

          <a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-outline art-all-pkgs">
            <span class="he">כל החבילות</span><span class="en">All packages</span>
          </a>
        </div>
      </aside>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
