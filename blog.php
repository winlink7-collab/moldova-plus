<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('articles');

// Group articles by tag
$by_topic = [];
foreach ($ARTICLES as $a) {
    $topic_key  = $a['tag_he'] ?? 'כללי';
    $topic_en   = $a['tag_en'] ?? 'General';
    if (!isset($by_topic[$topic_key])) {
        $by_topic[$topic_key] = ['he' => $topic_key, 'en' => $topic_en, 'items' => []];
    }
    $by_topic[$topic_key]['items'][] = $a;
}

$featured = $ARTICLES[0] ?? null;
$recent   = array_slice($ARTICLES, 0, 3);

page_head(
    $lang === 'he' ? 'בלוג תיירות — כתבות ומדריכים | Moldova Plus' : 'Travel Blog — Articles & Guides | Moldova Plus',
    $lang === 'he' ? 'מדריכי טיול, יקבים, חיי לילה בקישינב ועוד — הבלוג של Moldova Plus.' : 'Travel guides, wineries, Chișinău nightlife and more — the Moldova Plus blog.',
    $lang
);
?>
<?php include 'includes/header.php'; ?>

<!-- ── Banner ──────────────────────────────────────────── -->
<div class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur"><span class="he">בלוג תיירות</span><span class="en">Travel Blog</span></span>
    </div>
    <h1><span class="he">בלוג <span>תיירות</span></span><span class="en">Travel <span>Blog</span></span></h1>
    <p>
      <span class="he">מדריכים, טיפים ויקבים — הכל על מולדובה ממי שמכירים אותה מבפנים.</span>
      <span class="en">Guides, tips and wineries — everything about Moldova from those who know it inside out.</span>
    </p>
  </div>
</div>

<!-- ── Featured / Latest post ──────────────────────────── -->
<?php if ($featured):
  $_f_img = !empty($featured['image_url'])
    ? '<img src="'.htmlspecialchars($featured['image_url']).'" alt="" style="width:100%;height:100%;object-fit:cover;display:block;">'
    : scene_img($featured['scene']);
?>
<section class="section" style="padding-bottom:12px">
  <div class="container">
    <div class="s-head reveal" style="margin-bottom:22px">
      <h2 style="font-size:clamp(18px,2vw,22px)">
        <span class="he">הפוסט <span>האחרון</span></span>
        <span class="en">Latest <span>post</span></span>
      </h2>
    </div>
    <a href="/article/<?= $featured['id'] ?><?= $lang==='en'?'?lang=en':'' ?>" class="blog-featured reveal">
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
          <span>·</span><span><?= $featured['date'] ?></span>
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

<!-- ── Posts by topic ──────────────────────────────────── -->
<?php foreach ($by_topic as $topic): ?>
<section class="section" style="padding-top:40px;padding-bottom:40px">
  <div class="container">

    <div class="blog-topic-head reveal">
      <div class="blog-topic-label">
        <span class="he"><?= htmlspecialchars($topic['he']) ?></span>
        <span class="en"><?= htmlspecialchars($topic['en']) ?></span>
      </div>
      <h2 class="blog-topic-title">
        <span class="he">כתבות — <span><?= htmlspecialchars($topic['he']) ?></span></span>
        <span class="en"><span><?= htmlspecialchars($topic['en']) ?></span> articles</span>
      </h2>
    </div>

    <div class="article-grid">
      <?php foreach ($topic['items'] as $i => $a):
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
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
