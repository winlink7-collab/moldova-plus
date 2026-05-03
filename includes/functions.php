<?php
require_once __DIR__ . '/live-editor.php';

function get_lang(): string {
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['he','en','ru'], true)) {
        return $_GET['lang'];
    }
    return 'he';
}

function page_init(string $page): array {
    require_once __DIR__ . '/data.php';
    $lang = get_lang();
    global $T;
    $t = $T[$lang];
    return [$lang, $t];
}

function txt(array $item, string $key, string $lang): string {
    $k = $key . '_' . $lang;
    return htmlspecialchars($item[$k] ?? $item[$key . '_he'] ?? '', ENT_QUOTES, 'UTF-8');
}

function raw(array $item, string $key, string $lang): string {
    $k = $key . '_' . $lang;
    return $item[$k] ?? $item[$key . '_he'] ?? '';
}

function eur(int $price): string {
    return '€' . number_format($price, 0, '.', ',');
}

function render_card(array $p, string $lang, string $t_nights, string $t_from, bool $show_desc = false): string {
    require_once __DIR__ . '/scenes.php';
    $old = $p['discount'] ? (int)round($p['price'] * (1 + $p['discount']/100)) : 0;
    $wa_msg = urlencode($lang === 'he'
        ? "היי, אני מעוניין בחבילה: " . raw($p, 'title', $lang) . " — " . $p['nights'] . " לילות, " . eur($p['price'])
        : "Hi, I'm interested in: " . raw($p, 'title', $lang) . " — " . $p['nights'] . " nights, " . eur($p['price'])
    );
    $title = txt($p, 'title', $lang);
    $loc   = txt($p, 'loc',   $lang);
    $tag   = raw($p, 'tag',   $lang);
    $people = raw($p, 'people', $lang);
    $status_label = $p['status'] === 'now'
        ? ($lang==='he' ? 'אישור מיידי' : 'Instant booking')
        : ($lang==='he' ? 'יום עסקים' : '1 business day');

    $card_img = !empty($p['image_url'])
        ? '<div class="scene-img"><img src="' . htmlspecialchars($p['image_url']) . '" alt="" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;"></div>'
        : scene_img($p['scene'] ?? 'dark');
    $_card_url = !empty($p['slug']) ? '/package/' . $p['slug'] : '/package-detail?id=' . $p['id'];
    ob_start(); ?>
    <a href="<?= $_card_url ?><?= $lang!=='he'?(!empty($p['slug'])?'?lang='.$lang:'&lang='.$lang):'' ?>" class="card">
      <div class="card-img"<?= le_img('packages:' . $p['id'] . ':image_url') ?>>
        <?= $card_img ?>
        <span class="card-rating"><span class="star">★</span> <?= htmlspecialchars($p['rating']) ?></span>
        <?php if ($p['discount']): ?>
          <div class="card-discount">
            <span<?= le('packages:' . $p['id'] . ':discount') ?>><?= $p['discount'] ?></span>%<b><?= $lang==='he'?'הנחה':'OFF' ?></b>
          </div>
        <?php endif; ?>
        <span class="card-nights"><?= $p['nights'] ?> <?= htmlspecialchars($t_nights) ?></span>
        <button class="card-fav" onclick="toggleFav(event,<?= $p['id'] ?>)" data-id="<?= $p['id'] ?>" aria-label="שמור לרשימת המועדפים">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6c-2.5 4.5-9.5 9-9.5 9z"/></svg>
        </button>
      </div>
      <div class="card-body">
        <span class="card-loc">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
          <span<?= le('packages:' . $p['id'] . ':loc_he') ?>><?= $loc ?></span>
        </span>
        <h3 class="card-title"<?= le('packages:' . $p['id'] . ':title_he') ?>><?= $title ?></h3>
        <?php if ($show_desc && ($desc = raw($p, 'desc', $lang))): ?>
          <p style="font-size:13px;color:var(--ink-soft);margin:4px 0 0;line-height:1.5"><?= htmlspecialchars($desc) ?></p>
        <?php endif; ?>
        <div class="card-meta">
          <span>
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><circle cx="17" cy="9" r="2.5"/><path d="M15 20a5 5 0 0 1 6.5-4.7"/></svg>
            <span<?= le('packages:' . $p['id'] . ':people_he') ?>><?= htmlspecialchars($people) ?></span>
          </span>
          <span>·</span>
          <span>
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 13a9 9 0 1 1-10-10 7 7 0 0 0 10 10z"/></svg>
            <?= $p['nights'] ?> <?= htmlspecialchars($t_nights) ?>
          </span>
          <?php if ($tag): ?>
            <span>·</span><span class="card-tag"<?= le('packages:' . $p['id'] . ':tag_he') ?>><?= htmlspecialchars($tag) ?></span>
          <?php endif; ?>
        </div>
        <div class="card-foot">
          <div class="card-price">
            <?php if ($old): ?><span class="old"><?= eur($old) ?></span><?php endif; ?>
            <small><?= htmlspecialchars($t_from) ?></small>
            <b<?= le('packages:' . $p['id'] . ':price') ?>><?= eur($p['price']) ?><sub> /<?= $lang==='he'?'אדם':'pp' ?></sub></b>
          </div>
          <span class="card-status <?= $p['status'] ?>">
            <?php if ($p['status']==='now'): ?>
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
            <?php else: ?>
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
            <?php endif; ?>
            <?= htmlspecialchars($status_label) ?>
          </span>
        </div>
      </div>
    </a>
    <?php return ob_get_clean();
}

function page_head(string $title, string $desc = '', string $lang = 'he', string $canonical = ''): void { ?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $lang==='he'?'rtl':'ltr' ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <?php if ($desc): ?><meta name="description" content="<?= htmlspecialchars($desc) ?>"><?php endif; ?>
  <meta property="og:title"       content="<?= htmlspecialchars($title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($desc) ?>">
  <meta property="og:type"        content="website">
  <meta property="og:locale"      content="<?= $lang==='he'?'he_IL':($lang==='ru'?'ru_RU':'en_US') ?>">
  <?php if ($canonical): ?><link rel="canonical" href="<?= htmlspecialchars($canonical) ?>"><?php endif; ?>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 20'><rect width='10' height='20' fill='%230046ae'/><rect x='10' width='10' height='20' fill='%23ffd400'/><rect x='20' width='10' height='20' fill='%23cc1126'/></svg>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>
<body class="<?= $lang ?>">
<?php }

function page_foot(): void {
  le_footer();
?>
  <script src="/assets/js/main.js?v=<?= filemtime(__DIR__ . '/../assets/js/main.js') ?>"></script>
</body>
</html>
<?php }
