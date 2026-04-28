<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';

[$lang, $t] = page_init('bachelor');
$page = 'bachelor';

page_head(
    $lang==='he' ? 'מסיבות רווקים — Moldova Plus' : 'Bachelor Parties — Moldova Plus',
    $lang==='he' ? 'הוילות, הבארים, התחבורה והליווי המקומי — מסיבת רווקים שלא ישכחו.' : 'Villas, bars, transport and local fixers — bachelor parties to remember.',
    $lang
);

$results = array_values(array_filter($PACKAGES, fn($p) => ($p['page'] ?? '') === 'bachelor'));
?>
<?php include 'includes/header.php'; ?>

<section class="page-banner" style="background:linear-gradient(135deg,#0a0e22,#0c1430)">
  <div class="container">
    <div class="crumbs" style="color:rgba(255,255,255,.5)">
      <a href="index.php<?= $lang==='en'?'?lang=en':'' ?>" style="color:rgba(255,255,255,.5)">
        <span class="he">בית</span><span class="en">Home</span>
      </a> /
      <span class="cur" style="color:#ffd400">
        <span class="he">מסיבות רווקים</span><span class="en">Bachelor Parties</span>
      </span>
    </div>
    <h1 style="color:#fff">
      <span class="he">מסיבות <span style="color:#ffd400">רווקים</span></span>
      <span class="en">Bachelor <span style="color:#ffd400">Parties</span></span>
    </h1>
    <p style="color:rgba(255,255,255,.8)">
      <span class="he">הוילות, הבארים, התחבורה והליווי המקומי — מסיבת רווקים שלא ישכחו.</span>
      <span class="en">Villas, bars, transport and local fixers — bachelor parties to remember.</span>
    </p>
  </div>
</section>

<!-- Why Chisinau for bachelor -->
<section class="section" style="padding-bottom:0">
  <div class="container">
    <div class="perks-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:48px">
      <?php
      $perks = [
        ['icon'=>'✈️','he'=>'טיסה ישירה 3 שעות','en'=>'3h direct flight'],
        ['icon'=>'💰','he'=>'מחירים נמוכים פי 3','en'=>'3× cheaper than Europe'],
        ['icon'=>'🎉','he'=>'חיי לילה אגדיים','en'=>'Legendary nightlife'],
        ['icon'=>'👑','he'=>'וילות יוקרה בשפע','en'=>'Abundance of luxury villas'],
      ];
      foreach ($perks as $perk): ?>
      <div class="reveal" style="background:var(--bg-2);border-radius:14px;padding:24px;text-align:center;border:1px solid var(--line)">
        <div style="font-size:32px;margin-bottom:12px"><?= $perk['icon'] ?></div>
        <b style="font-size:15px;color:var(--ink)">
          <span class="he"><?= $perk['he'] ?></span>
          <span class="en"><?= htmlspecialchars($perk['en']) ?></span>
        </b>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Packages -->
<section class="page-pad" style="padding-top:24px">
  <div class="container">
    <div class="filter-bar">
      <?php
      $bt = [
        'all'   => ['he'=>'הכל','en'=>'All'],
        'bach'  => ['he'=>'רווקים','en'=>'Bachelor'],
        'adv'   => ['he'=>'אדרנלין','en'=>'Adrenaline'],
        'group' => ['he'=>'קבוצות','en'=>'Groups'],
      ];
      $active_type = isset($_GET['type']) && array_key_exists($_GET['type'], $bt) && $_GET['type'] !== 'all' ? $_GET['type'] : 'all';
      foreach ($bt as $fid => $fl): ?>
      <a href="bachelor.php?type=<?= $fid ?><?= $lang==='en'?'&lang=en':'' ?>" class="filter-pill <?= $active_type===$fid?'active':'' ?>">
        <span class="he"><?= $fl['he'] ?></span>
        <span class="en"><?= htmlspecialchars($fl['en']) ?></span>
      </a>
      <?php endforeach; ?>
      <?php if ($active_type !== 'all') $results = array_values(array_filter($results, fn($p) => $p['type'] === $active_type)); ?>
      <span class="filter-results"><?= count($results) ?> <span class="he">תוצאות</span><span class="en">results</span></span>
    </div>

    <div class="card-grid">
      <?php foreach ($results as $p): ?>
        <?= render_card($p, $lang, $t['nights'], $t['from']) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
