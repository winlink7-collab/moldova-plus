<?php
// Live Visual Editor — AJAX save endpoint
require_once __DIR__ . '/includes/auth.php';
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) session_start();

// Must be admin — accept cookie OR session
$_is_admin = !empty($_SESSION['mp_admin_ok']) || !empty($_COOKIE[ADMIN_TOKEN]);
if (!$_is_admin) {
    echo json_encode(['ok' => false, 'error' => 'unauthorized']);
    exit;
}

// Default reviews (mirrors data.php defaults)
$_REVIEW_DEFAULTS = [
  ['id'=>1,'name_he'=>'אבי כהן','place_he'=>'תל אביב','body_he'=>'חוויה בלתי נשכחת! הצוות של Moldova Plus דאג לכל פרט, מהמלון ועד הסיורים ביקבים. מחיר מעולה ביחס למה שקיבלנו. מומלץ בחום.','stars'=>5,'when'=>'03.2026','initials'=>'א','color'=>'#0046ae'],
  ['id'=>2,'name_he'=>'מיכל לוי','place_he'=>'חיפה','body_he'=>'מסיבת רווקים שלא תשכח! הארגון היה מושלם, הווילה, השף הפרטי והמועדונים — הכל ברמה הכי גבוהה. תודה ענקית לכל הצוות.','stars'=>5,'when'=>'02.2026','initials'=>'מ','color'=>'#e53935'],
  ['id'=>3,'name_he'=>'יוסי ברק','place_he'=>'ירושלים','body_he'=>'בואנו כזוג לחבילה רומנטית ויצאנו עם זיכרונות לכל החיים. קישינב הפתיעה אותנו לטובה — יוקרה במחיר שפוי. ממליץ לכל זוג.','stars'=>5,'when'=>'01.2026','initials'=>'י','color'=>'#2e7d32'],
  ['id'=>4,'name_he'=>'שרה גולן','place_he'=>'רעננה','body_he'=>'הסיור ביקב Mileștii Mici היה חוויה של פעם בחיים. 200 ק"מ מנהרות עם בקבוקי יין — מדהים! כל הלוגיסטיקה עבדה חלק כשמן.','stars'=>5,'when'=>'04.2026','initials'=>'ש','color'=>'#6a1b9a'],
];

// Default attractions (mirrors data.php defaults with IDs)
$_ATTR_DEFAULTS = [
  ['id'=>1,'he'=>'יקב Mileștii Mici','en'=>'Mileștii Mici Winery','cat'=>'wine','scene'=>'gold','he2'=>'200 ק"מ של מנהרות תת-קרקעיות','en2'=>'200km of underground tunnels','image_url'=>''],
  ['id'=>2,'he'=>'יקב Cricova','en'=>'Cricova Winery','cat'=>'wine','scene'=>'warm','he2'=>'מנהרות יין היסטוריות','en2'=>'Historic wine tunnels','image_url'=>''],
  ['id'=>3,'he'=>'מנזר Capriana','en'=>'Capriana Monastery','cat'=>'culture','scene'=>'green','he2'=>'מנזר מהמאה ה-15','en2'=>'15th century monastery','image_url'=>''],
  ['id'=>4,'he'=>'אורהיי וצי','en'=>'Orheiul Vechi','cat'=>'culture','scene'=>'light','he2'=>'מתחם ארכיאולוגי מרהיב','en2'=>'Stunning archaeological site','image_url'=>''],
  ['id'=>5,'he'=>'Carrera Karting','en'=>'Carrera Karting','cat'=>'adrenaline','scene'=>'dark','he2'=>'הקארטינג הגדול במזרח אירופה','en2'=>'Largest karting in E. Europe','image_url'=>''],
  ['id'=>6,'he'=>'Castel Mimi','en'=>'Castel Mimi','cat'=>'wine','scene'=>'blue','he2'=>'יקב טירה ב-50 דק׳ מקישינב','en2'=>'Castle winery, 50 min from city','image_url'=>''],
  ['id'=>7,'he'=>'מסעדת Pegas','en'=>'Pegas Restaurant','cat'=>'food','scene'=>'warm','he2'=>'אגם פרטי + ספא דגים','en2'=>'Private lake + fish spa','image_url'=>''],
  ['id'=>8,'he'=>'רובע La 33','en'=>'La 33 District','cat'=>'nightlife','scene'=>'dark','he2'=>'חיי הלילה הכי שווים בקישינב','en2'=>'Best nightlife in Chișinău','image_url'=>''],
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'method']);
    exit;
}

if (!mp_csrf_verify()) {
    echo json_encode(['ok' => false, 'error' => 'csrf']);
    exit;
}

$key   = trim($_POST['key']   ?? '');
$value = $_POST['value']      ?? '';
$type  = $_POST['type']       ?? 'text';

// Sanitize by type
if ($type === 'text') {
    $value = strip_tags(trim($value));
} elseif ($type === 'img') {
    $value = trim($value);
    if ($value !== '' && !preg_match('#^(https?://|/assets/)#i', $value)) {
        echo json_encode(['ok' => false, 'error' => 'invalid_url']);
        exit;
    }
} elseif ($type === 'gallery') {
    $arr = json_decode($value, true);
    if (!is_array($arr)) $arr = [];
    $value = array_values(array_filter($arr, fn($v) => is_string($v) && $v !== ''));
} elseif ($type === 'tags') {
    $value = array_values(array_filter(array_map('trim', explode(',', $value))));
}

// Parse key: "file:field" or "file:id:field"
$parts = explode(':', $key, 3);
$file  = $parts[0] ?? '';

$allowed = ['settings', 'deal', 'hotels', 'packages', 'attractions', 'articles', 'faq', 'reviews'];
if (!in_array($file, $allowed, true)) {
    echo json_encode(['ok' => false, 'error' => 'bad_file']);
    exit;
}

$data = mp_read_json($file . '.json');

switch ($file) {
    case 'settings':
    case 'deal':
        // format: "file:field"
        $field = $parts[1] ?? '';
        if (!$field) { echo json_encode(['ok' => false, 'error' => 'no_field']); exit; }
        $data[$field] = $value;
        break;

    case 'hotels':
        // format: "hotels:id:field" — find item by id in array, create if missing
        $id    = $parts[1] ?? '';
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        $found = false;
        foreach ($data as &$item) {
            if ((string)($item['id'] ?? '') === $id) {
                $item[$field] = $value;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) {
            $data[] = ['id' => is_numeric($id) ? (int)$id : $id, $field => $value];
        }
        break;

    case 'attractions':
        // format: "attractions:id:field" — initialize from defaults if JSON is empty
        $id    = $parts[1] ?? '';
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        // If JSON is empty, seed with defaults so we don't lose the full list
        if (empty($data)) $data = $_ATTR_DEFAULTS;
        $found = false;
        foreach ($data as &$item) {
            if ((string)($item['id'] ?? '') === $id) {
                $item[$field] = $value;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) {
            // New entry: start from default if available, then add field
            $base = ['id' => is_numeric($id) ? (int)$id : $id];
            foreach ($_ATTR_DEFAULTS as $_ad) {
                if ((string)$_ad['id'] === $id) { $base = $_ad; break; }
            }
            $base[$field] = $value;
            $data[] = $base;
        }
        break;

    case 'packages':
        // packages.json is an override map: {"1": {field: val}, "2": {...}}
        // format: "packages:id:field"
        $id    = $parts[1] ?? '';
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        if (!isset($data[$id])) $data[$id] = [];
        $data[$id][$field] = $value;
        break;

    case 'articles':
        // format: "articles:slug:field" — upsert by id
        $id    = $parts[1] ?? '';
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        $found = false;
        foreach ($data as &$item) {
            if (($item['id'] ?? '') === $id) {
                $item[$field] = $value;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) { $data[] = ['id' => $id, $field => $value]; }
        break;

    case 'faq':
        // format: "faq:id:field"
        $id    = (int)($parts[1] ?? 0);
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        foreach ($data as &$item) {
            if ((int)($item['id'] ?? 0) === $id) {
                $item[$field] = $value;
                break;
            }
        }
        unset($item);
        break;

    case 'reviews':
        // format: "reviews:id:field"
        $id    = (int)($parts[1] ?? 0);
        $field = $parts[2] ?? '';
        if (!$id || !$field) { echo json_encode(['ok' => false, 'error' => 'no_id']); exit; }
        // Seed from defaults if JSON is empty
        if (empty($data)) $data = $_REVIEW_DEFAULTS;
        $found = false;
        foreach ($data as &$item) {
            if ((int)($item['id'] ?? 0) === $id) {
                $item[$field] = $value;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) {
            $base = ['id' => $id];
            foreach ($_REVIEW_DEFAULTS as $_rd) {
                if ((int)$_rd['id'] === $id) { $base = $_rd; break; }
            }
            $base[$field] = $value;
            $data[] = $base;
        }
        break;
}

$ok = mp_write_json($file . '.json', $data);
echo json_encode(['ok' => $ok, 'error' => $ok ? null : 'write_failed']);
