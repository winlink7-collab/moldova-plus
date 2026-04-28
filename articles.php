<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('articles');

page_head(
    $lang === 'he' ? 'בלוג תיירות — כתבות ומדריכים | Moldova Plus' : 'Travel Blog — Articles & Guides | Moldova Plus',
    $lang === 'he' ? 'מדריכי טיול, המלצות על יקבים, חיי לילה בקישינב ועוד — הבלוג של Moldova Plus.' : 'Travel guides, winery tips, Chișinău nightlife and more — the Moldova Plus blog.',
    $lang
);

$featured = $ARTICLES[0] ?? null;
$rest     = array_slice($ARTICLES, 1);
?>
<?php include 'includes/header.php'; ?>

<!-- ── Page Banner ─────────────────────────────────────── -->
<div class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur"><span class="he">בלוג תיירות</span><span class="en">Travel Blog</span></span>
    </div>
    <h1>
      <span class="he">בלוג <span>תיירות</span></span>
      <span class="en">Travel <span>Blog</span></span>
    </h1>
    <p>
      <span class="he">מדריכים, טיפים ויקבים — הכל על מולדובה ממי שמכירים אותה מבפנים.</span>
      <span class="en">Guides, tips and wineries — everything about Moldova from those who know it inside out.</span>
    </p>
  </div>
</div>

<!-- ── Featured Article ─────────────────────────────────── -->
<?php if ($featured):
  $_f_img = !empty($featured['image_url'])
    ? '<img src="'.htmlspecialchars($featured['image_url']).'" alt="" style="width:100%;height:100%;object-fit:cover;display:block;">'
    : scene_img($featured['scene']);
?>
<section class="section" style="padding-bottom:0">
  <div class="container">
    <a href="/article/<?= $featured['id'] ?><?= $lang==='en'?'?lang=en':'' ?>" class="blog-featured">
      <div class="blog-featured-img"><?= $_f_img ?></div>
      <div class="blog-featured-body">
        <span class="art-tag-pill"><?= htmlspecialchars($lang==='he' ? $featured['tag_he'] : $featured['tag_en']) ?></span>
        <h2>
          <span class="he"><?= htmlspecialchars($featured['title_he']) ?></span>
          <span class="en"><?= htmlspecialchars($featured['title_en']) ?></span>
        </h2>
        <p>
          <span class="he"><?= htmlspecialchars($featured['desc_he']) ?></span>
          <span class="en"><?= htmlspecialchars($featured['desc_en']) ?></span>
        </p>
        <div class="blog-featured-meta">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <?= $featured['read'] ?> <span class="he">דקות קריאה</span><span class="en">min read</span>
          <span>·</span>
          <span><?= $featured['date'] ?></span>
        </div>
        <span class="blog-featured-cta">
          <span class="he">קרא עוד</span><span class="en">Read more</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path class="he" d="M19 12H5M12 19l-7-7 7-7"/><path class="en" d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
      </div>
    </a>
  </div>
</section>
<?php endif; ?>

<!-- ── All Articles Grid ─────────────────────────────────── -->
<?php if ($rest): ?>
<section class="section">
  <div class="container">
    <div class="s-head reveal" style="margin-bottom:28px">
      <h2 style="font-size:clamp(20px,2.5vw,26px)">
        <span class="he">עוד <span>כתבות</span></span>
        <span class="en">More <span>articles</span></span>
      </h2>
    </div>
    <div class="article-grid">
      <?php foreach ($rest as $i => $a):
        $_art_img = !empty($a['image_url'])
          ? '<div class="scene-img"><img src="'.htmlspecialchars($a['image_url']).'" alt="" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;"></div>'
          : scene_img($a['scene']);
      ?>
      <a href="/article/<?= $a['id'] ?><?= $lang==='en'?'?lang=en':'' ?>" class="article reveal d<?= $i+1 ?>">
        <div class="article-img"><?= $_art_img ?></div>
        <div class="article-body">
          <span class="article-tag">
            <span class="he"><?= htmlspecialchars($a['tag_he']) ?></span>
            <span class="en"><?= htmlspecialchars($a['tag_en']) ?></span>
          </span>
          <h4>
            <span class="he"><?= htmlspecialchars($a['title_he']) ?></span>
            <span class="en"><?= htmlspecialchars($a['title_en']) ?></span>
          </h4>
          <p>
            <span class="he"><?= htmlspecialchars($a['desc_he']) ?></span>
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
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
