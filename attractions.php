<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';

[$lang, $t] = page_init('attractions');
$page = 'attractions';

page_head(
    $lang==='he' ? 'אטרקציות — Moldova Plus' : 'Attractions — Moldova Plus',
    $lang==='he' ? 'יקבים, מנזרים, אדרנלין וחיי לילה — כל מה ששווה לבקר בו במולדובה.' : 'Wineries, monasteries, adrenaline and nightlife — everything worth visiting in Moldova.',
    $lang
);

$cat_filter = isset($_GET['cat']) && in_array($_GET['cat'], ['wine','culture','adrenaline','food','nightlife'])
    ? $_GET['cat'] : 'all';
$filtered = $cat_filter === 'all' ? $ATTRACTIONS : array_values(array_filter($ATTRACTIONS, fn($a) => $a['cat'] === $cat_filter));
?>
<?php include 'includes/header.php'; ?>

<section class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="index.php<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur he">אטרקציות</span><span class="cur en">Attractions</span>
    </div>
    <h1>
      <span class="he">אטרקציות <span>במולדובה</span></span>
      <span class="en">Attractions in <span>Moldova</span></span>
    </h1>
    <p>
      <span class="he">יקבים, מנזרים, אדרנלין וחיי לילה — כל מה ששווה לבקר בו במולדובה.</span>
      <span class="en">Wineries, monasteries, adrenaline and nightlife — everything worth visiting in Moldova.</span>
    </p>
  </div>
</section>

<section class="page-pad">
  <div class="container">
    <div class="filter-bar">
      <?php
      $cats = [
        'all'        => ['he'=>'הכל',       'en'=>'All'],
        'wine'       => ['he'=>'יקבים',     'en'=>'Wineries'],
        'culture'    => ['he'=>'תרבות',     'en'=>'Culture'],
        'adrenaline' => ['he'=>'אדרנלין',   'en'=>'Adrenaline'],
        'food'       => ['he'=>'אוכל',      'en'=>'Food'],
        'nightlife'  => ['he'=>'חיי לילה',  'en'=>'Nightlife'],
      ];
      foreach ($cats as $cid => $cl): ?>
      <a href="attractions.php?cat=<?= $cid ?><?= $lang==='en'?'&lang=en':'' ?>" class="filter-pill <?= $cat_filter===$cid?'active':'' ?>">
        <span class="he"><?= $cl['he'] ?></span>
        <span class="en"><?= htmlspecialchars($cl['en']) ?></span>
      </a>
      <?php endforeach; ?>
      <span class="filter-results"><?= count($filtered) ?> <span class="he">אטרקציות</span><span class="en">attractions</span></span>
    </div>

    <div class="card-grid">
      <?php foreach ($filtered as $a): ?>
      <div class="card reveal">
        <div class="card-img"><?= scene_img($a['scene']) ?></div>
        <div class="card-body">
          <span class="card-loc">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
            <span class="he">מולדובה</span><span class="en">Moldova</span>
          </span>
          <h3 class="card-title">
            <span class="he"><?= $a['he'] ?></span>
            <span class="en"><?= htmlspecialchars($a['en']) ?></span>
          </h3>
          <p style="font-size:13px;color:var(--ink-soft);margin:4px 0 0;line-height:1.55">
            <span class="he"><?= $a['he2'] ?></span>
            <span class="en"><?= htmlspecialchars($a['en2']) ?></span>
          </p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
