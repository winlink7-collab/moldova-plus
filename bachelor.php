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
      <a href="bachelor?type=<?= $fid ?><?= $lang==='en'?'&lang=en':'' ?>" class="filter-pill <?= $active_type===$fid?'active':'' ?>">
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
