<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('hotels');
$page = 'hotels';

page_head(
    $lang==='he' ? 'מלונות בקישינב — Moldova Plus' : 'Hotels in Chișinău — Moldova Plus',
    $lang==='he' ? 'המלונות הטובים ביותר בקישינב — בוטיק, יוקרה ומשפחה. מחירים שקופים, אישור מיידי.' : 'Best hotels in Chișinău — boutique, luxury and family. Transparent prices, instant confirmation.',
    $lang
);
?>
<?php include 'includes/header.php'; ?>

<?php
$hotels_default = [
  [
    'id'      => 1,
    'scene'   => 'blue',
    'name_he' => 'Nobil Luxury Boutique Hotel',
    'name_en' => 'Nobil Luxury Boutique Hotel',
    'stars'   => 5,
    'rating'  => '9.6',
    'area_he' => 'מרכז העיר',
    'area_en' => 'City Center',
    'price'   => 89,
    'desc_he' => 'מלון בוטיק יוקרתי במרכז קישינב. עיצוב מודרני, ספא, מסעדת שף ושירות אישי ברמה הגבוהה ביותר.',
    'desc_en' => 'Luxury boutique hotel in the heart of Chișinău. Modern design, spa, chef restaurant and top-tier personal service.',
    'tags_he' => ['ספא', 'מסעדה', 'בריכה'],
    'tags_en' => ['Spa', 'Restaurant', 'Pool'],
  ],
  [
    'id'      => 2,
    'scene'   => 'dark',
    'name_he' => 'Hotel Leogrand & Convention Centre',
    'name_en' => 'Hotel Leogrand & Convention Centre',
    'stars'   => 5,
    'rating'  => '9.2',
    'area_he' => 'רובע עסקים',
    'area_en' => 'Business District',
    'price'   => 75,
    'desc_he' => 'המלון הגדול בקישינב. מרכז כנסים, בריכת שחייה, ספא מלא ומסעדה פרנקו-מולדבית מפורסמת.',
    'desc_en' => "Chișinău's largest hotel. Conference centre, swimming pool, full spa and a renowned Franco-Moldovan restaurant.",
    'tags_he' => ['כנסים', 'ספא', 'בריכה'],
    'tags_en' => ['Conferences', 'Spa', 'Pool'],
  ],
  [
    'id'      => 3,
    'scene'   => 'light',
    'name_he' => 'Radisson Blu Leogrand Hotel',
    'name_en' => 'Radisson Blu Leogrand Hotel',
    'stars'   => 5,
    'rating'  => '9.4',
    'area_he' => 'בולבר סטפן צ׳ל מארה',
    'area_en' => 'Stefan cel Mare Blvd',
    'price'   => 110,
    'desc_he' => 'רשת Radisson Blu בלב קישינב. חדרים מרווחים, מרכז כושר, בר וגישה מהירה לאטרקציות המרכזיות.',
    'desc_en' => 'Radisson Blu brand in the heart of Chișinău. Spacious rooms, fitness center, bar and quick access to top attractions.',
    'tags_he' => ['כושר', 'בר', 'Wi-Fi חינם'],
    'tags_en' => ['Fitness', 'Bar', 'Free Wi-Fi'],
  ],
  [
    'id'      => 4,
    'scene'   => 'warm',
    'name_he' => 'Hotel Jolly Alon',
    'name_en' => 'Hotel Jolly Alon',
    'stars'   => 4,
    'rating'  => '8.8',
    'area_he' => 'מרכז העיר',
    'area_en' => 'City Center',
    'price'   => 55,
    'desc_he' => 'מלון ארבעה כוכבים נוח ונגיש. מיקום מצוין, חדרים מודרניים וארוחת בוקר בופה עשירה.',
    'desc_en' => 'Comfortable and accessible 4-star hotel. Great location, modern rooms and a rich breakfast buffet.',
    'tags_he' => ['ארוחת בוקר', 'חניה', 'Wi-Fi'],
    'tags_en' => ['Breakfast', 'Parking', 'Wi-Fi'],
  ],
  [
    'id'      => 5,
    'scene'   => 'green',
    'name_he' => 'Hotel Griff',
    'name_en' => 'Hotel Griff',
    'stars'   => 4,
    'rating'  => '8.5',
    'area_he' => 'פארק הציבורי',
    'area_en' => 'Central Park area',
    'price'   => 48,
    'desc_he' => 'מלון ארבעה כוכבים בנוף ירוק. סמוך לפארק הציבורי של קישינב. מחיר מצוין לעומת איכות גבוהה.',
    'desc_en' => "4-star hotel with green views, close to Chișinău's main public park. Excellent value for money.",
    'tags_he' => ['נוף לפארק', 'רסטורנט', 'Wi-Fi'],
    'tags_en' => ['Park view', 'Restaurant', 'Wi-Fi'],
  ],
  [
    'id'      => 6,
    'scene'   => 'city',
    'name_he' => 'Hotel Dacia',
    'name_en' => 'Hotel Dacia',
    'stars'   => 3,
    'rating'  => '8.1',
    'area_he' => 'רובע ישן',
    'area_en' => 'Old Quarter',
    'price'   => 32,
    'desc_he' => 'מלון שלושה כוכבים בעל אופי, ברובע ההיסטורי של קישינב. האווירה המקומית האמיתית במחיר נגיש.',
    'desc_en' => 'Characterful 3-star hotel in the historic quarter of Chișinău. Authentic local atmosphere at a budget-friendly price.',
    'tags_he' => ['מיקום היסטורי', 'Wi-Fi', 'בר'],
    'tags_en' => ['Historic location', 'Wi-Fi', 'Bar'],
  ],
];
$_hotels_json = __DIR__ . '/data/hotels.json';
$_hotels_from_json = file_exists($_hotels_json) ? (json_decode(file_get_contents($_hotels_json), true) ?? []) : [];
$_json_by_id = [];
foreach ($_hotels_from_json as $_hj) {
    if (isset($_hj['id'])) $_json_by_id[$_hj['id']] = $_hj;
}
$hotels = [];
foreach ($hotels_default as $_hd) {
    $_ov = $_json_by_id[$_hd['id']] ?? [];
    if (isset($_ov['status']) && $_ov['status'] !== 'פעיל') continue;
    $hotels[] = array_merge($_hd, $_ov);
}
if (empty($hotels)) $hotels = $hotels_default;
?>

<div class="container" style="padding-top:36px;padding-bottom:0">
  <h1 style="font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:800;color:var(--ink);margin:0">
    <span class="he"><?= mp_s('page_hotels_title_he','מלונות בקישינב') ?></span>
    <span class="en"><?= mp_s('page_hotels_title_en','Hotels in Chișinău') ?></span>
  </h1>
  <p style="color:var(--ink-soft);margin:6px 0 0;font-size:15px">
    <span class="he"><?= mp_s('page_hotels_desc_he','המלונות הטובים ביותר בקישינב — בוטיק, יוקרה ומשפחה. מחירים שקופים, אישור מיידי.') ?></span>
    <span class="en"><?= mp_s('page_hotels_desc_en','Best hotels in Chișinău — boutique, luxury and family. Transparent prices, instant confirmation.') ?></span>
  </p>
</div>

<section class="page-pad">
  <div class="container">

    <!-- Filter bar -->
    <div class="filter-bar" style="margin-bottom:28px">
      <a href="hotels<?= $lang==='en'?'?lang=en':'' ?>" class="filter-pill active">
        <span class="he">הכל</span><span class="en">All</span>
      </a>
      <a href="#" class="filter-pill">
        <span class="he">5 כוכבים</span><span class="en">5 Stars</span>
      </a>
      <a href="#" class="filter-pill">
        <span class="he">4 כוכבים</span><span class="en">4 Stars</span>
      </a>
      <a href="#" class="filter-pill">
        <span class="he">מרכז העיר</span><span class="en">City Center</span>
      </a>
      <a href="#" class="filter-pill">
        <span class="he">ספא ובריכה</span><span class="en">Spa & Pool</span>
      </a>
    </div>

    <!-- Hotels grid -->
    <div class="card-grid">
      <?php foreach ($hotels as $h): ?>
      <div class="card" style="cursor:default">
        <div class="card-img"<?= le_img('hotels:' . $h['id'] . ':image_url') ?>>
          <?= scene_img($h['scene']) ?>
          <span class="card-rating">
            <span class="star">★</span> <?= $h['rating'] ?>
          </span>
          <span class="card-nights" style="right:auto;left:12px">
            <?= str_repeat('★', $h['stars']) ?>
          </span>
        </div>
        <div class="card-body">
          <span class="card-loc"<?= le('hotels:' . $h['id'] . ':area_he') ?>>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
            <?= $lang==='he' ? $h['area_he'] : htmlspecialchars($h['area_en']) ?>
          </span>
          <h3 class="card-title"<?= le('hotels:' . $h['id'] . ':name_he') ?>><?= htmlspecialchars($h['name_he']) ?></h3>
          <p style="font-size:13px;color:var(--ink-soft);margin:4px 0 6px;line-height:1.5"<?= le('hotels:' . $h['id'] . ':desc_he') ?>>
            <?= $lang==='he' ? $h['desc_he'] : htmlspecialchars($h['desc_en']) ?>
          </p>
          <div class="card-meta">
            <?php $tags = $lang==='he' ? $h['tags_he'] : $h['tags_en']; ?>
            <?php foreach ($tags as $tag): ?>
              <span class="card-tag"><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
          </div>
          <div class="card-foot">
            <div class="card-price">
              <small><?= $lang==='he'?'מחיר ללילה':'per night' ?></small>
              <b<?= le('hotels:' . $h['id'] . ':price') ?>>$<?= $h['price'] ?><sub> /<?= $lang==='he'?'לילה':'night' ?></sub></b>
            </div>
            <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>?text=<?= urlencode($lang==='he' ? 'היי, אני מעוניין להזמין חדר ב-' . $h['name_he'] : 'Hi, I\'d like to book a room at ' . $h['name_en']) ?>"
               target="_blank" rel="noopener"
               class="btn btn-primary" style="padding:10px 18px;font-size:13px;text-decoration:none">
              <span class="he">הזמן</span><span class="en">Book</span>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
