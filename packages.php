<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';

[$lang, $t] = page_init('packages');
$page = 'packages';

// Only vacation packages on this page
$vacation_pkgs = array_values(array_filter($PACKAGES, fn($p) => ($p['page'] ?? 'vacation') === 'vacation'));

// Active type filter from URL
$type = isset($_GET['type']) && in_array($_GET['type'], ['couples','wine','lux','food','spa'])
    ? $_GET['type'] : 'all';

page_head(
    $lang==='he' ? 'חבילות נופש — Moldova Plus' : 'Travel Packages — Moldova Plus',
    $lang==='he' ? 'כל חבילות הנופש שלנו במולדובה — מבוקרות, שקופות, באישור מיידי.' : 'All our Moldova vacation packages — vetted, transparent, instant booking.',
    $lang
);
?>
<?php include 'includes/header.php'; ?>


<!-- Packages -->
<section class="page-pad">
  <div class="container">
    <!-- Filter bar -->
    <div class="filter-bar">
      <?php
      $filter_types = [
        'all'     => ['he'=>'הכל',      'en'=>'All'],
        'couples' => ['he'=>'זוגיות',   'en'=>'Couples'],
        'wine'    => ['he'=>'יקבים',    'en'=>'Wineries'],
        'lux'     => ['he'=>'יוקרה',    'en'=>'Luxury'],
        'food'    => ['he'=>'גסטרו',    'en'=>'Gastro'],
        'spa'     => ['he'=>'ספא',      'en'=>'Spa'],
      ];
      foreach ($filter_types as $fid => $fl): ?>
      <a href="packages?type=<?= $fid ?><?= $lang==='en'?'&lang=en':'' ?>" class="filter-pill <?= $type===$fid?'active':'' ?>">
        <span class="he"><?= $fl['he'] ?></span>
        <span class="en"><?= htmlspecialchars($fl['en']) ?></span>
      </a>
      <?php endforeach; ?>

      <!-- Sort -->
      <select class="filter-sort" id="sort-select" onchange="sortCards(this.value)">
        <option value="pop"><span class="he">מיון: פופולריות</span><span>Sort: Popular</span></option>
        <option value="priceL">
          <?= $lang==='he'?'מחיר: נמוך לגבוה':'Price: low to high' ?>
        </option>
        <option value="priceH">
          <?= $lang==='he'?'מחיר: גבוה לנמוך':'Price: high to low' ?>
        </option>
        <option value="rating">
          <?= $lang==='he'?'דירוג':'Rating' ?>
        </option>
      </select>

      <?php
      $filtered = $type === 'all' ? $vacation_pkgs : array_values(array_filter($vacation_pkgs, fn($p) => $p['type'] === $type));
      ?>
      <span class="filter-results">
        <?= count($filtered) ?> <span class="he">תוצאות</span><span class="en">results</span>
      </span>
    </div>

    <!-- Cards -->
    <div class="card-grid" id="pkg-grid">
      <?php foreach ($filtered as $p): ?>
      <div class="card-wrap" data-type="<?= $p['type'] ?>" data-price="<?= $p['price'] ?>" data-rating="<?= $p['rating'] ?>">
        <?= render_card($p, $lang, $t['nights'], $t['from']) ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
