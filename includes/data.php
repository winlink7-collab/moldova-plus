<?php
// ─── Translations ───────────────────────────────────────────────────────────
$T = [
  'he' => [
    'nights'  => 'לילות',
    'from'    => 'החל מ',
    'nav'     => ['home'=>'בית','packages'=>'חבילות נופש','bachelor'=>'מסיבות רווקים','attractions'=>'אטרקציות'],
    'hero'    => [
      'kicker'   => 'יעד #1 לחבילות מולדובה',
      'h1'       => ['חוויית מולדובה', 'מתחילה כאן.'],
      'sub'      => 'פורטל ההזמנות הגדול בישראל לחבילות נופש בקישינב — מסיבות רווקים, חוויות יוקרה ויקבים מובילים. מחירים שקופים, אישור מיידי.',
      'pkgs'     => '1,200+ חבילות',
      'verified' => 'ביקורות מאומתות',
      'best'     => 'מחיר הטוב ביותר',
    ],
    'search'  => ['where'=>'לאן?','whereV'=>'קישינב, מולדובה','when'=>'מתי?','whenV'=>'הוסיפו תאריכים','who'=>'כמה?','whoV'=>'2 אורחים','type'=>'סוג חבילה','typeV'=>'הכל','go'=>'חיפוש'],
    'foot'    => [
      'about' => 'הפורטל הגדול בישראל לחבילות מולדובה. כל חבילה עוברת בדיקה — מקומות שלא הוכיחו את עצמם יורדים מהאתר.',
      'copy'  => '© 2026 Moldova Plus · כל הזכויות שמורות',
    ],
  ],
  'en' => [
    'nights'  => 'nights',
    'from'    => 'from',
    'nav'     => ['home'=>'Home','packages'=>'Travel packages','bachelor'=>'Bachelor parties','attractions'=>'Attractions'],
    'hero'    => [
      'kicker'   => '#1 destination for Moldova',
      'h1'       => ['The Moldova experience', 'starts here.'],
      'sub'      => "Israel's largest portal for Chișinău getaways — bachelor parties, luxury escapes and top wineries. Transparent prices, instant confirmation.",
      'pkgs'     => '1,200+ packages',
      'verified' => 'Verified reviews',
      'best'     => 'Best price guarantee',
    ],
    'search'  => ['where'=>'Where?','whereV'=>'Chișinău, Moldova','when'=>'When?','whenV'=>'Add dates','who'=>'Guests','whoV'=>'2 guests','type'=>'Package type','typeV'=>'All','go'=>'Search'],
    'foot'    => [
      'about' => "Israel's largest portal for Moldova getaways. Every package is vetted — venues that don't perform are removed.",
      'copy'  => '© 2026 Moldova Plus · All rights reserved',
    ],
  ],
];

// ─── Quick categories ────────────────────────────────────────────────────────
$QUICK_CATS = [
  ['id'=>'couples','he'=>'חבילות זוגיות','en'=>'Couples',   'ic'=>'sparkles'],
  ['id'=>'bach',   'he'=>'מסיבות רווקים','en'=>'Bachelor',  'ic'=>'glass'],
  ['id'=>'lux',    'he'=>'יוקרה',        'en'=>'Luxury',    'ic'=>'badge'],
  ['id'=>'wine',   'he'=>'יקבים',        'en'=>'Wineries',  'ic'=>'wine'],
  ['id'=>'spa',    'he'=>'ספא',          'en'=>'Spa',       'ic'=>'spa'],
  ['id'=>'food',   'he'=>'גסטרו',        'en'=>'Gastro',    'ic'=>'plane'],
  ['id'=>'group',  'he'=>'קבוצות',       'en'=>'Groups',    'ic'=>'people'],
  ['id'=>'adv',    'he'=>'אדרנלין',      'en'=>'Adventure', 'ic'=>'mountain'],
];

// ─── Packages ────────────────────────────────────────────────────────────────
$PACKAGES = [
  [
    'id'=>1,'type'=>'couples','price'=>890,'discount'=>12,'nights'=>4,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.6','tag_he'=>'הכי פופולרי','tag_en'=>'Most popular','status'=>'now','scene'=>'warm',
    'title_he'=>'חבילת רומנטיקה במלון בוטיק נובל','title_en'=>'Romance package · Nobil Boutique Hotel',
    'loc_he'=>'קישינב — מרכז העיר','loc_en'=>'Chișinău — City center',
    'desc_he'=>'4 לילות במלון בוטיק יוקרתי במרכז קישינב, ארוחות בוקר, יום בספא וסיור ביקב הגדול בעולם — Mileștii Mici.',
    'desc_en'=>'4 nights in a luxury boutique hotel in downtown Chișinău, breakfasts, a full spa day and a tour of the world\'s largest winery — Mileștii Mici.',
  ],
  [
    'id'=>2,'type'=>'bach','price'=>650,'discount'=>8,'nights'=>3,'people_he'=>'8-12 אורחים','people_en'=>'8-12 guests','rating'=>'9.9','tag_he'=>'BEST SELLER','tag_en'=>'BEST SELLER','status'=>'now','scene'=>'dark',
    'title_he'=>'מסיבת רווקים אולטימטיבית','title_en'=>'Ultimate Bachelor Party',
    'loc_he'=>'קישינב — רובע הבילויים','loc_en'=>'Chișinău — Nightlife district',
    'desc_he'=>'וילה פרטית, שף אישי, בארים ומועדונים מובחרים וליווי מקומי מקצועי כל הלילה. חוויה שלא ישכחו.',
    'desc_en'=>'Private villa, personal chef, top bars and clubs with a professional local fixer all night. A night they won\'t forget.',
  ],
  [
    'id'=>3,'type'=>'wine','price'=>740,'discount'=>0,'nights'=>5,'people_he'=>'2-4 אורחים','people_en'=>'2-4 guests','rating'=>'9.4','tag_he'=>'','tag_en'=>'','status'=>'now','scene'=>'gold',
    'title_he'=>'מסע יקבים — Cricova & Mileștii Mici','title_en'=>'Wine Trail · Cricova & Mileștii Mici',
    'loc_he'=>'מולדובה — כל הארץ','loc_en'=>'Moldova — Countrywide',
    'desc_he'=>'5 ימים של יין, תרבות ואוכל. ביקור ב-Mileștii Mici (200 ק"מ מנהרות תת-קרקעיות) ו-Cricova — שני היקבים המרהיבים בעולם.',
    'desc_en'=>'5 days of wine, culture and food. Visit Mileștii Mici (200km underground tunnels) and Cricova — two of the world\'s most spectacular wineries.',
  ],
  [
    'id'=>4,'type'=>'lux','price'=>1290,'discount'=>10,'nights'=>5,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.8','tag_he'=>'','tag_en'=>'','status'=>'now','scene'=>'blue',
    'title_he'=>'יוקרה אולטימטיבית — סוויטה נשיאותית','title_en'=>'Ultimate Luxury — Presidential Suite',
    'loc_he'=>'קישינב — Radisson Blu','loc_en'=>'Chișinău — Radisson Blu',
    'desc_he'=>'סוויטה נשיאותית ב-Radisson Blu, ארוחות שף פרטי, ספא יוקרתי וטיפולים בלעדיים. השירות הכי גבוה שיש.',
    'desc_en'=>'Presidential suite at the Radisson Blu, private chef dinners, luxury spa and exclusive treatments. The highest level of service.',
  ],
  [
    'id'=>5,'type'=>'group','price'=>520,'discount'=>0,'nights'=>3,'people_he'=>'10-20 אורחים','people_en'=>'10-20 guests','rating'=>'9.2','tag_he'=>'','tag_en'=>'','status'=>'day','scene'=>'light',
    'title_he'=>'חבילת קבוצות לחברה / משפחה','title_en'=>'Group package — Company / Family',
    'loc_he'=>'קישינב — מרכז העיר','loc_en'=>'Chișinău — City center',
    'desc_he'=>'חבילה מותאמת לקבוצות גדולות — לוגיסטיקה שלמה, מלון מרכזי, פעילויות ייחודיות וליווי לאורך כל הביקור.',
    'desc_en'=>'Fully tailored for large groups — complete logistics, central hotel, unique activities and escort throughout.',
  ],
  [
    'id'=>6,'type'=>'food','price'=>680,'discount'=>15,'nights'=>4,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.5','tag_he'=>'חדש','tag_en'=>'New','status'=>'now','scene'=>'gold',
    'title_he'=>'גסטרו טור — מסעדות שף + יקבים','title_en'=>'Gastro Tour — Chef restaurants + Wineries',
    'loc_he'=>'קישינב + Codru','loc_en'=>'Chișinău + Codru',
    'desc_he'=>'4 ימים של אוכל ויין ברמה הגבוהה ביותר — מסעדות שף מקומיים, טעימות יין מודרכות וארוחת גורמה ביקב Purcari.',
    'desc_en'=>'4 days of top-tier food and wine — local chef restaurants, guided tastings and a gourmet dinner at Purcari winery.',
  ],
  [
    'id'=>7,'type'=>'spa','price'=>560,'discount'=>0,'nights'=>3,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.3','tag_he'=>'','tag_en'=>'','status'=>'now','scene'=>'green',
    'title_he'=>'חבילת ספא וטבע — Codru','title_en'=>'Spa & Nature — Codru Forest',
    'loc_he'=>'יער Codru — 30 דק׳ מקישינב','loc_en'=>'Codru forest — 30 min from city',
    'desc_he'=>'3 ימים של שקט ושלווה ביער Codru — ספא מלא, עיסויים, שחייה בבריכות טבעיות וארוחות אורגניות טריות.',
    'desc_en'=>'3 days of peace and quiet in Codru forest — full spa, massages, natural pool swimming and fresh organic meals.',
  ],
  [
    'id'=>8,'type'=>'adv','price'=>480,'discount'=>0,'nights'=>3,'people_he'=>'4-8 אורחים','people_en'=>'4-8 guests','rating'=>'9.0','tag_he'=>'','tag_en'=>'','status'=>'day','scene'=>'dark',
    'title_he'=>'אדרנלין — קארטינג, רכבי שטח וירי','title_en'=>'Adrenaline — Karting, ATV & Shooting',
    'loc_he'=>'קישינב + סביבה','loc_en'=>'Chișinău area',
    'desc_he'=>'3 ימים של אדרנלין מטורף — קארטינג מקצועי, רכבי שטח בשטח פתוח, אימון ירי ופעילויות לבחירה.',
    'desc_en'=>'3 days of pure adrenaline — professional karting, ATV off-road, shooting range and activities of your choice.',
  ],
];

// ─── Regions ─────────────────────────────────────────────────────────────────
$REGIONS = [
  ['he'=>'מרכז קישינב',   'en'=>'Chișinău center',  'scene'=>'warm'],
  ['he'=>'רובע הבילויים', 'en'=>'Nightlife district','scene'=>'dark'],
  ['he'=>'יקב Mileștii',  'en'=>'Mileștii Mici',    'scene'=>'gold'],
  ['he'=>'יער Codru',     'en'=>'Codru forest',     'scene'=>'green'],
  ['he'=>'יקב Cricova',   'en'=>'Cricova',          'scene'=>'blue'],
  ['he'=>'וילות יוקרה',  'en'=>'Luxury villas',    'scene'=>'light'],
];

// ─── Reviews ─────────────────────────────────────────────────────────────────
$REVIEWS = [
  ['place_he'=>'מסיבת רווקים אולטימטיבית','place_en'=>'Bachelor Party',
   'body_he'=>'יצאנו לחגיגה של החבר הכי טוב — הכל אורגן בצורה מושלמת. הוילה הייתה מטורפת, השף מעולה והליווי בלילה היה מקצועי. ממליץ בחום.',
   'body_en'=>'Organized to perfection. Wild villa, top chef, and a pro local fixer all night. Highly recommended.',
   'name_he'=>'דניאל ב׳','name_en'=>'Daniel B.','stars'=>5,'when'=>'18.04.2026','initials'=>'ד','color'=>'#cc1126'],
  ['place_he'=>'מסע יקבים','place_en'=>'Wine Trail',
   'body_he'=>'Mileștii Mici היה חוויה מטריפה — 200 ק"מ של מנהרות יין מתחת לאדמה. הסיור באנגלית, ארוחת ערב היין הייתה ברמה של מישלן.',
   'body_en'=>'Mileștii Mici is mind-blowing — 200km of underground tunnels. Wine pairing dinner was Michelin-level.',
   'name_he'=>'מיכל ל׳','name_en'=>'Michal L.','stars'=>5,'when'=>'12.04.2026','initials'=>'מ','color'=>'#0046ae'],
  ['place_he'=>'יוקרה — Radisson Blu','place_en'=>'Luxury — Radisson Blu',
   'body_he'=>'הסוויטה הייתה ענקית, השירות בלתי רגיל. מולדובה הפתיעה אותנו לטובה — נחזור בטוח.',
   'body_en'=>'Massive suite, exceptional service. Moldova was a wonderful surprise — definitely returning.',
   'name_he'=>'אורן ש׳','name_en'=>'Oren S.','stars'=>5,'when'=>'09.04.2026','initials'=>'א','color'=>'#2e9b5e'],
  ['place_he'=>'חבילת רומנטיקה','place_en'=>'Romance Package',
   'body_he'=>'יום הולדת לאשתי, רצינו משהו שונה — קיבלנו חוויה אינטימית עם כל הפינוקים. שווה כל אגורה.',
   'body_en'=>"My wife's birthday — wanted something different. Intimate experience with every detail handled. Worth every euro.",
   'name_he'=>'יואב ק׳','name_en'=>'Yoav K.','stars'=>5,'when'=>'05.04.2026','initials'=>'י','color'=>'#ffd400'],
];

// ─── Articles ────────────────────────────────────────────────────────────────
$ARTICLES = [
  ['tag_he'=>'מדריך','tag_en'=>'Guide','scene'=>'gold',
   'title_he'=>'הסיבה שמולדובה הפכה ליעד החם של 2026',
   'title_en'=>'Why Moldova became the hottest destination of 2026',
   'desc_he'=>'יקבים תת-קרקעיים, מחירים נמוכים, טיסה של 3 שעות וחיי לילה משתוללים — מה הופך את קישינב למה שהיא היום.',
   'desc_en'=>'Underground wineries, low prices, a 3-hour flight and wild nightlife — what makes Chișinău what it is today.',
   'date'=>'14.04.2026','read'=>'5'],
  ['tag_he'=>'יקבים','tag_en'=>'Wineries','scene'=>'warm',
   'title_he'=>'4 היקבים שחייבים לבקר בהם',
   'title_en'=>'4 wineries you must visit',
   'desc_he'=>'Mileștii Mici, Cricova, Purcari ו-Castel Mimi — הסיורים, הטעימות והדגשים.',
   'desc_en'=>'Mileștii Mici, Cricova, Purcari & Castel Mimi — tours, tastings and highlights.',
   'date'=>'10.04.2026','read'=>'4'],
  ['tag_he'=>'רווקים','tag_en'=>'Bachelor','scene'=>'dark',
   'title_he'=>'מסיבת רווקים בקישינב — המדריך המלא',
   'title_en'=>'Bachelor party in Chișinău — the complete guide',
   'desc_he'=>'הכל מהוילות והבארים ועד התחבורה — איך מארגנים מסיבת רווקים שלא ישכחו.',
   'desc_en'=>'From villas and bars to transport — how to organize a memorable bachelor party.',
   'date'=>'07.04.2026','read'=>'6'],
];

// ─── Attractions ─────────────────────────────────────────────────────────────
$ATTRACTIONS = [
  ['he'=>'יקב Mileștii Mici','en'=>'Mileștii Mici Winery','cat'=>'wine','scene'=>'gold','he2'=>'200 ק"מ של מנהרות תת-קרקעיות','en2'=>'200km of underground tunnels'],
  ['he'=>'יקב Cricova',      'en'=>'Cricova Winery',       'cat'=>'wine','scene'=>'warm','he2'=>'מנהרות יין היסטוריות','en2'=>'Historic wine tunnels'],
  ['he'=>'מנזר Capriana',    'en'=>'Capriana Monastery',   'cat'=>'culture','scene'=>'green','he2'=>'מנזר מהמאה ה-15','en2'=>'15th century monastery'],
  ['he'=>'אורהיי וצי',       'en'=>'Orheiul Vechi',        'cat'=>'culture','scene'=>'light','he2'=>'מתחם ארכיאולוגי מרהיב','en2'=>'Stunning archaeological site'],
  ['he'=>'Carrera Karting',  'en'=>'Carrera Karting',      'cat'=>'adrenaline','scene'=>'dark','he2'=>'הקארטינג הגדול במזרח אירופה','en2'=>'Largest karting in E. Europe'],
  ['he'=>'Castel Mimi',      'en'=>'Castel Mimi',          'cat'=>'wine','scene'=>'blue','he2'=>'יקב טירה ב-50 דק׳ מקישינב','en2'=>'Castle winery, 50 min from city'],
  ['he'=>'מסעדת Pegas',     'en'=>'Pegas Restaurant',     'cat'=>'food','scene'=>'warm','he2'=>'אגם פרטי + ספא דגים','en2'=>'Private lake + fish spa'],
  ['he'=>'רובע La 33',       'en'=>'La 33 District',       'cat'=>'nightlife','scene'=>'dark','he2'=>'חיי הלילה הכי שווים בקישינב','en2'=>'Best nightlife in Chișinău'],
];
