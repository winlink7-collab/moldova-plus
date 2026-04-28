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
?>
<?php include 'includes/header.php'; ?>

<section style="padding:40px 0 0">
  <div class="container">

    <!-- Breadcrumb -->
    <div class="crumbs" style="margin-bottom:20px">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur"><span class="he">כתבות ומדריכים</span><span class="en">Articles & Guides</span></span>
    </div>

    <!-- Page header -->
    <div class="s-head" style="margin-bottom:36px">
      <h1 style="font-size:clamp(28px,5vw,42px)">
        <span class="he">כתבות <span>ומדריכים</span></span>
        <span class="en">Articles <span>&amp; Guides</span></span>
      </h1>
    </div>

    <!-- Articles grid -->
    <div class="article-grid" style="--cols:3">
      <?php foreach ($ARTICLES as $i => $a):
        $_art_img = !empty($a['image_url'])
          ? '<div class="scene-img"><img src="'.htmlspecialchars($a['image_url']).'" alt="" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;"></div>'
          : scene_img($a['scene']);
      ?>
      <a href="article/<?= $a['id'] ?><?= $lang==='en'?'?lang=en':'' ?>" class="article reveal d<?= $i+1 ?>">
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

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
