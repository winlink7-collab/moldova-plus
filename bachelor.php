<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/mp_settings.php';

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

<div class="container" style="padding-top:36px;padding-bottom:0">
  <h1 style="font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:800;color:var(--ink);margin:0">
    <span class="he"<?= le('settings:page_bachelor_title_he') ?>><?= mp_s('page_bachelor_title_he','מסיבות רווקים בקישינב') ?></span>
    <span class="en"<?= le('settings:page_bachelor_title_en') ?>><?= mp_s('page_bachelor_title_en','Bachelor Parties in Chișinău') ?></span>
  </h1>
  <p style="color:var(--ink-soft);margin:6px 0 0;font-size:15px">
    <span class="he"<?= le('settings:page_bachelor_desc_he') ?>><?= mp_s('page_bachelor_desc_he','וילות, בארים, תחבורה וליווי מקומי — מסיבת רווקים שלא ישכחו.') ?></span>
    <span class="en"<?= le('settings:page_bachelor_desc_en') ?>><?= mp_s('page_bachelor_desc_en','Villas, bars, transport and local fixers — bachelor parties to remember.') ?></span>
  </p>
</div>

<!-- Why Chisinau for bachelor -->
<section class="section" style="padding-bottom:0">
  <div class="container">
    <div class="perks-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:48px">
      <?php
      $perks = [
        ['icon'=>'✈️','key'=>'bach_perk_1','he'=>'טיסה ישירה 3 שעות',   'en'=>'3h direct flight'],
        ['icon'=>'💰','key'=>'bach_perk_2','he'=>'מחירים נמוכים פי 3',  'en'=>'3× cheaper than Europe'],
        ['icon'=>'🎉','key'=>'bach_perk_3','he'=>'חיי לילה אגדיים',     'en'=>'Legendary nightlife'],
        ['icon'=>'👑','key'=>'bach_perk_4','he'=>'וילות יוקרה בשפע',    'en'=>'Abundance of luxury villas'],
      ];
      foreach ($perks as $perk): ?>
      <div class="reveal" style="background:var(--bg-2);border-radius:14px;padding:24px;text-align:center;border:1px solid var(--line)">
        <div style="font-size:32px;margin-bottom:12px"><?= $perk['icon'] ?></div>
        <b style="font-size:15px;color:var(--ink)">
          <span class="he"<?= le('settings:'.$perk['key'].'_he') ?>><?= mp_s($perk['key'].'_he', $perk['he']) ?></span>
          <span class="en"<?= le('settings:'.$perk['key'].'_en') ?>><?= mp_s($perk['key'].'_en', $perk['en']) ?></span>
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
      <a href="/bachelor?type=<?= $fid ?><?= $lang!=='he'?'&lang='.$lang:'' ?>" class="filter-pill <?= $active_type===$fid?'active':'' ?>">
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
