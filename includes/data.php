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

// Override hero text from settings.json if available
$_stf = __DIR__ . '/../data/settings.json';
if (file_exists($_stf)) {
    $_st = json_decode(file_get_contents($_stf), true) ?? [];
    if (!empty($_st['hero_kicker_he'])) $T['he']['hero']['kicker'] = $_st['hero_kicker_he'];
    if (!empty($_st['hero_kicker_en'])) $T['en']['hero']['kicker'] = $_st['hero_kicker_en'];
    if (!empty($_st['hero_sub_he'])) $T['he']['hero']['sub'] = $_st['hero_sub_he'];
    if (!empty($_st['hero_sub_en'])) $T['en']['hero']['sub'] = $_st['hero_sub_en'];
    if (!empty($_st['hero_h1_he'])) $T['he']['hero']['h1'] = [$_st['hero_h1_he'], ''];
    if (!empty($_st['hero_h1_en'])) $T['en']['hero']['h1'] = [$_st['hero_h1_en'], ''];
    if (!empty($_st['footer_about_he'])) $T['he']['foot']['about'] = $_st['footer_about_he'];
    if (!empty($_st['footer_about_en'])) $T['en']['foot']['about'] = $_st['footer_about_en'];
    if (!empty($_st['footer_copy'])) { $T['he']['foot']['copy'] = $_st['footer_copy']; $T['en']['foot']['copy'] = $_st['footer_copy']; }
}

// ─── Quick categories ────────────────────────────────────────────────────────
$QUICK_CATS = [
  ['id'=>'couples','he'=>'זוגי & ירח דבש','en'=>'Couples & Honeymoon','ic'=>'sparkles'],
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
    'id'=>1,'page'=>'vacation','type'=>'couples','price'=>890,'discount'=>12,'nights'=>4,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.6','tag_he'=>'הכי פופולרי','tag_en'=>'Most popular','status'=>'now','scene'=>'warm',
    'title_he'=>'חבילת רומנטיקה במלון בוטיק נובל','title_en'=>'Romance package · Nobil Boutique Hotel',
    'loc_he'=>'קישינב — מרכז העיר','loc_en'=>'Chișinău — City center',
    'desc_he'=>'4 לילות במלון בוטיק יוקרתי במרכז קישינב, ארוחות בוקר, יום בספא וסיור ביקב הגדול בעולם — Mileștii Mici.',
    'desc_en'=>'4 nights in a luxury boutique hotel in downtown Chișinău, breakfasts, a full spa day and a tour of the world\'s largest winery — Mileștii Mici.',
  ],
  [
    'id'=>2,'page'=>'bachelor','type'=>'bach','price'=>650,'discount'=>8,'nights'=>3,'people_he'=>'8-12 אורחים','people_en'=>'8-12 guests','rating'=>'9.9','tag_he'=>'BEST SELLER','tag_en'=>'BEST SELLER','status'=>'now','scene'=>'dark',
    'title_he'=>'מסיבת רווקים אולטימטיבית','title_en'=>'Ultimate Bachelor Party',
    'loc_he'=>'קישינב — רובע הבילויים','loc_en'=>'Chișinău — Nightlife district',
    'desc_he'=>'וילה פרטית, שף אישי, בארים ומועדונים מובחרים וליווי מקומי מקצועי כל הלילה. חוויה שלא ישכחו.',
    'desc_en'=>'Private villa, personal chef, top bars and clubs with a professional local fixer all night. A night they won\'t forget.',
  ],
  [
    'id'=>3,'page'=>'vacation','type'=>'wine','price'=>740,'discount'=>0,'nights'=>5,'people_he'=>'2-4 אורחים','people_en'=>'2-4 guests','rating'=>'9.4','tag_he'=>'','tag_en'=>'','status'=>'now','scene'=>'gold',
    'title_he'=>'מסע יקבים — Cricova & Mileștii Mici','title_en'=>'Wine Trail · Cricova & Mileștii Mici',
    'loc_he'=>'מולדובה — כל הארץ','loc_en'=>'Moldova — Countrywide',
    'desc_he'=>'5 ימים של יין, תרבות ואוכל. ביקור ב-Mileștii Mici (200 ק"מ מנהרות תת-קרקעיות) ו-Cricova — שני היקבים המרהיבים בעולם.',
    'desc_en'=>'5 days of wine, culture and food. Visit Mileștii Mici (200km underground tunnels) and Cricova — two of the world\'s most spectacular wineries.',
  ],
  [
    'id'=>4,'page'=>'vacation','type'=>'lux','price'=>1290,'discount'=>10,'nights'=>5,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.8','tag_he'=>'','tag_en'=>'','status'=>'now','scene'=>'blue',
    'title_he'=>'יוקרה אולטימטיבית — סוויטה נשיאותית','title_en'=>'Ultimate Luxury — Presidential Suite',
    'loc_he'=>'קישינב — Radisson Blu','loc_en'=>'Chișinău — Radisson Blu',
    'desc_he'=>'סוויטה נשיאותית ב-Radisson Blu, ארוחות שף פרטי, ספא יוקרתי וטיפולים בלעדיים. השירות הכי גבוה שיש.',
    'desc_en'=>'Presidential suite at the Radisson Blu, private chef dinners, luxury spa and exclusive treatments. The highest level of service.',
  ],
  [
    'id'=>5,'page'=>'bachelor','type'=>'group','price'=>520,'discount'=>0,'nights'=>3,'people_he'=>'10-20 אורחים','people_en'=>'10-20 guests','rating'=>'9.2','tag_he'=>'','tag_en'=>'','status'=>'day','scene'=>'light',
    'title_he'=>'חבילת קבוצות לחברה / משפחה','title_en'=>'Group package — Company / Family',
    'loc_he'=>'קישינב — מרכז העיר','loc_en'=>'Chișinău — City center',
    'desc_he'=>'חבילה מותאמת לקבוצות גדולות — לוגיסטיקה שלמה, מלון מרכזי, פעילויות ייחודיות וליווי לאורך כל הביקור.',
    'desc_en'=>'Fully tailored for large groups — complete logistics, central hotel, unique activities and escort throughout.',
  ],
  [
    'id'=>6,'page'=>'vacation','type'=>'food','price'=>680,'discount'=>15,'nights'=>4,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.5','tag_he'=>'חדש','tag_en'=>'New','status'=>'now','scene'=>'gold',
    'title_he'=>'גסטרו טור — מסעדות שף + יקבים','title_en'=>'Gastro Tour — Chef restaurants + Wineries',
    'loc_he'=>'קישינב + Codru','loc_en'=>'Chișinău + Codru',
    'desc_he'=>'4 ימים של אוכל ויין ברמה הגבוהה ביותר — מסעדות שף מקומיים, טעימות יין מודרכות וארוחת גורמה ביקב Purcari.',
    'desc_en'=>'4 days of top-tier food and wine — local chef restaurants, guided tastings and a gourmet dinner at Purcari winery.',
  ],
  [
    'id'=>7,'page'=>'vacation','type'=>'spa','price'=>560,'discount'=>0,'nights'=>3,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.3','tag_he'=>'','tag_en'=>'','status'=>'now','scene'=>'green',
    'title_he'=>'חבילת ספא וטבע — Codru','title_en'=>'Spa & Nature — Codru Forest',
    'loc_he'=>'יער Codru — 30 דק׳ מקישינב','loc_en'=>'Codru forest — 30 min from city',
    'desc_he'=>'3 ימים של שקט ושלווה ביער Codru — ספא מלא, עיסויים, שחייה בבריכות טבעיות וארוחות אורגניות טריות.',
    'desc_en'=>'3 days of peace and quiet in Codru forest — full spa, massages, natural pool swimming and fresh organic meals.',
  ],
  [
    'id'=>8,'page'=>'bachelor','type'=>'adv','price'=>480,'discount'=>0,'nights'=>3,'people_he'=>'4-8 אורחים','people_en'=>'4-8 guests','rating'=>'9.0','tag_he'=>'','tag_en'=>'','status'=>'day','scene'=>'dark',
    'title_he'=>'אדרנלין — קארטינג, רכבי שטח וירי','title_en'=>'Adrenaline — Karting, ATV & Shooting',
    'loc_he'=>'קישינב + סביבה','loc_en'=>'Chișinău area',
    'desc_he'=>'3 ימים של אדרנלין מטורף — קארטינג מקצועי, רכבי שטח בשטח פתוח, אימון ירי ופעילויות לבחירה.',
    'desc_en'=>'3 days of pure adrenaline — professional karting, ATV off-road, shooting range and activities of your choice.',
  ],
  [
    'id'=>9,'page'=>'vacation','type'=>'couples','price'=>1090,'discount'=>18,'nights'=>6,'people_he'=>'2 אורחים','people_en'=>'2 guests','rating'=>'9.9','tag_he'=>'ירח דבש','tag_en'=>'Honeymoon','status'=>'now','scene'=>'honey',
    'title_he'=>'חבילת ירח דבש — חוויה בלתי נשכחת','title_en'=>'Honeymoon Package — Unforgettable Experience',
    'loc_he'=>'קישינב — סוויטה רומנטית + יקב','loc_en'=>'Chișinău — Romantic suite + Winery',
    'desc_he'=>'6 לילות קסומים — סוויטת ירח דבש עם ג׳קוזי פרטי, ארוחות רומנטיות לאור נרות, עיסוי זוגי ספא וטיול יין ביקב Castel Mimi. כולל שמפניה, עיטור חדר ופרחים בהגעה.',
    'desc_en'=>'6 magical nights — honeymoon suite with private jacuzzi, candlelit dinners, couples spa massage and a wine tour at Castel Mimi. Includes champagne, room decoration and flowers on arrival.',
  ],
];

// Merge full package overrides from packages.json
$_pkg_file = __DIR__ . '/../data/packages.json';
if (file_exists($_pkg_file)) {
    $_overrides = json_decode(file_get_contents($_pkg_file), true) ?? [];
    foreach ($PACKAGES as &$_p) {
        $_ov = $_overrides[$_p['id']] ?? [];
        if (!empty($_ov)) {
            foreach (['price','discount','status','tag_he','tag_en','title_he','loc_he','desc_he','nights','people_he','image_url','page'] as $_k) {
                if (isset($_ov[$_k]) && $_ov[$_k] !== '') $_p[$_k] = $_ov[$_k];
            }
        }
    }
    unset($_p);
}

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
$_reviews_file = __DIR__ . '/../data/reviews.json';
$REVIEWS = file_exists($_reviews_file) ? (json_decode(file_get_contents($_reviews_file), true) ?? []) : [];

// ─── Articles ────────────────────────────────────────────────────────────────
$ARTICLES = [
  [
   'id'=>'moldova-2026',
   'tag_he'=>'מדריך','tag_en'=>'Guide','scene'=>'gold',
   'title_he'=>'הסיבה שמולדובה הפכה ליעד החם של 2026',
   'title_en'=>'Why Moldova became the hottest destination of 2026',
   'desc_he'=>'יקבים תת-קרקעיים, מחירים נמוכים, טיסה של 3 שעות וחיי לילה משתוללים — מה הופך את קישינב למה שהיא היום.',
   'desc_en'=>'Underground wineries, low prices, a 3-hour flight and wild nightlife — what makes Chișinău what it is today.',
   'date'=>'14.04.2026','read'=>'5',
   'related_types'=>['couples','lux','spa'],
   'body_he'=>'<p>קישינב, בירת מולדובה, כבר אינה סוד מוסתר. ב-2026 היא הפכה לאחת היעדים המדוברים ביותר בקרב ישראלים המחפשים חוויות מקוריות, מחירים שפויים ואווירה שלא תמצאו בשום מקום אחר.</p>
<h3>מה גרם לפריחה?</h3>
<p>שלושה גורמים עיקריים הביאו לגל התיירות: <strong>קרבה גיאוגרפית</strong> — טיסה ישירה של 3 שעות מתל אביב, <strong>מחירים מדהימים</strong> — ארוחת שף עולה פחות מ-30 דולר, ולילה במלון 5 כוכבים מתחיל ב-80 דולר, ו<strong>חוויות ייחודיות</strong> שלא ניתן לשחזר בקלות — ביקור ביקבים תת-קרקעיים שנחפרו בידי אדם לאורך עשרות שנים.</p>
<h3>יקבים שמסחררים את הדעת</h3>
<p>Mileștii Mici הוא היקב הגדול בעולם — עם יותר מ-200 ק"מ של מנהרות תת-קרקעיות שבהן מאוחסנים מיליוני בקבוקי יין. הסיור מתנהל ברכב בין המנהרות, עם תאורה עמומה ואווירה של אחר-עולם. Cricova, היריב הקרוב, מציע טעימות בסגנון יותר אירופאי — קלאסי, מעודן ומרשים לא פחות.</p>
<h3>חיי לילה שיפתיעו אתכם</h3>
<p>קישינב ידועה בקהילת הנייטקלאב שלה — מועדונים פתוחים עד שש בבוקר, מוזיקה אלקטרונית ברמה גבוהה, ובארים שלל סגנונות לאורך רחוב Stefan cel Mare. המחירים? רביעיית שוטים עולה פחות מ-8 שקלים. לא, לא טעינו.</p>
<h3>אז מתי טסים?</h3>
<p>חודשי מאי–ספטמבר הם הזמן הטוב ביותר — מזג אוויר נעים, פסטיבלי יין, ואנרגיה ברחובות. Moldova Plus מציעה חבילות מלאות הכוללות טיסה, מלון, סיורים ומדריך דובר עברית. כל מה שנשאר לכם הוא לארוז.</p>',
   'body_en'=>'<p>Chișinău, the capital of Moldova, is no longer a hidden secret. In 2026 it has become one of the most talked-about destinations among Israelis seeking authentic experiences, reasonable prices and an atmosphere found nowhere else.</p>
<h3>What caused the boom?</h3>
<p>Three main factors drove the tourism wave: <strong>geographic proximity</strong> — a direct 3-hour flight from Tel Aviv, <strong>incredible prices</strong> — a chef-cooked dinner costs under $30, and a 5-star hotel starts from $80 per night, and <strong>unique experiences</strong> — visiting underground wineries carved by hand over decades.</p>
<h3>Wineries that blow your mind</h3>
<p>Mileștii Mici is the world\'s largest winery — with over 200 km of underground tunnels housing millions of wine bottles. The tour is conducted by car through the tunnels, with dim lighting and an otherworldly atmosphere. Cricova, its close rival, offers tastings in a more European style — classic, refined and equally impressive.</p>
<h3>Nightlife that will surprise you</h3>
<p>Chișinău is known for its nightclub scene — clubs open until 6 AM, high-quality electronic music, and bars of all styles along Stefan cel Mare street. The prices? Four shots cost less than $2. No, that\'s not a typo.</p>',
  ],
  [
   'id'=>'wineries',
   'tag_he'=>'יקבים','tag_en'=>'Wineries','scene'=>'warm',
   'title_he'=>'4 היקבים שחייבים לבקר בהם',
   'title_en'=>'4 wineries you must visit',
   'desc_he'=>'Mileștii Mici, Cricova, Purcari ו-Castel Mimi — הסיורים, הטעימות והדגשים.',
   'desc_en'=>'Mileștii Mici, Cricova, Purcari & Castel Mimi — tours, tastings and highlights.',
   'date'=>'10.04.2026','read'=>'4',
   'related_types'=>['wine','couples','lux'],
   'body_he'=>'<p>מולדובה היא מדינת היין הקטנה שמכה מעל משקלה. עם יותר מ-170,000 הקטאר של כרמים ואקלים מושלם, היא מייצרת כמה מיינות הבוטיק הטובים בעולם. להלן ארבעת היקבים שכל מי שמגיע למולדובה חייב לבקר בהם.</p>
<h3>1. Mileștii Mici — היקב הגדול בעולם</h3>
<p>רשום בגינס כיקב הגדול בעולם, Mileștii Mici מחזיק מעל 1.5 מיליון בקבוקי יין במנהרות תת-קרקעיות שאורכן עולה על 200 ק"מ. הסיור מתנהל ברכב — כן, ברכב, כי אחרת לא תגיעו לשום מקום. הטעימות נערכות בחדרים מחצובים בסלע, ומלוות בלחם תוצרת בית וגבינות מקומיות. מגיל 6 ישנן ענבים טריים לאורחים הצעירים.</p>
<h3>2. Cricova — הקסם האירופאי</h3>
<p>אם Mileștii Mici הוא הגיגנט, Cricova הוא המלך המסוגנן. הקמרות הגותיות, הרחובות הנקיים עם שמות של יינות, והאווירה המכובדת — כולם מצביעים על ניסיון אחר לגמרי. פוטין הזמין פה חבית שלמה, ונשיאים ממדינות רבות ביקרו פה. הוא שייך לרשימה של כל מדריך "must-see" אירופאי.</p>
<h3>3. Castel Mimi — בוטיק עם נוף לתפארת</h3>
<p>כ-50 דקות מקישינב, Castel Mimi הוא יקב טירה עם חצר אירופאית, מסעדת שף ו-glamping בתוך הכרם. הוא המושלם לזוגות — ארוחת ערב מרהיבה בין שורות הגפנים, בקבוק Feteasca Neagra ולילה בקוטג׳ מרוהט להפליא.</p>
<h3>4. Purcari — מקום שמייצר יין מאז 1827</h3>
<p>הישן מכולם ואחד המכובדים. Purcari מייצר יין מ-1827, ונחשב ל"יין הצארים" — רוסיה קנתה ממנו בכמויות לאורך המאה ה-19. היום הוא יוצא לייצוא בכ-40 מדינות, ואפשר לסייר ביקב, לשתות ולישון פה תחת הכוכבים.</p>',
   'body_en'=>'<p>Moldova is the small wine country that punches above its weight. With over 170,000 hectares of vineyards and a perfect climate, it produces some of the world\'s best boutique wines. Here are the four wineries every visitor to Moldova must see.</p>
<h3>1. Mileștii Mici — the world\'s largest winery</h3>
<p>Listed in the Guinness Book as the world\'s largest winery, Mileștii Mici holds over 1.5 million wine bottles in underground tunnels stretching more than 200 km. The tour is conducted by car — yes, by car, otherwise you\'d never cover the ground. Tastings are held in rock-carved rooms, accompanied by homemade bread and local cheeses.</p>
<h3>2. Cricova — European elegance</h3>
<p>If Mileștii Mici is the giant, Cricova is the refined king. Gothic arches, clean streets named after wines, and a distinguished atmosphere — all pointing to a very different experience. Putin ordered a full barrel here, and presidents from many countries have visited. It belongs on every "must-see" European list.</p>
<h3>3. Castel Mimi — boutique with stunning views</h3>
<p>About 50 minutes from Chișinău, Castel Mimi is a castle winery with a European courtyard, chef\'s restaurant and glamping in the vineyard. Perfect for couples — a breathtaking dinner between vine rows, a bottle of Feteasca Neagra and a beautifully furnished cottage.</p>
<h3>4. Purcari — making wine since 1827</h3>
<p>The oldest and one of the most respected. Purcari has been making wine since 1827 and is known as the "Tsar\'s wine" — Russia bought it in large quantities throughout the 19th century. Today it exports to around 40 countries, and visitors can tour the winery, drink, and sleep under the stars.</p>',
  ],
  [
   'id'=>'bachelor-chisinau',
   'tag_he'=>'רווקים','tag_en'=>'Bachelor','scene'=>'dark',
   'title_he'=>'מסיבת רווקים בקישינב — המדריך המלא',
   'title_en'=>'Bachelor party in Chișinău — the complete guide',
   'desc_he'=>'הכל מהוילות והבארים ועד התחבורה — איך מארגנים מסיבת רווקים שלא ישכחו.',
   'desc_en'=>'From villas and bars to transport — how to organize a memorable bachelor party.',
   'date'=>'07.04.2026','read'=>'6',
   'related_types'=>['bach','adv','group'],
   'body_he'=>'<p>קישינב הפכה לאחת הבירות המבוקשות ביותר לאירועי רווקים בישראל. המחירים הנמוכים, חיי הלילה האגדיים, הוילות הפרטיות וספקי שירות שכבר מכירים את הצרכים של הישראלים — הכל נמצא כאן. אם אתם מתכננים ואתם רוצים לעשות את זה נכון, זהו המדריך שלכם.</p>
<h3>מתי לטוס?</h3>
<p>חמישי–ראשון הוא הנוסחה הכי טובה — שלושה ימים ושתי לילות, ונוחתים בחזרה ב-א׳ בצהריים. ימי חמישי–שבת בקישינב הם הלילות הכי שווים בשבוע. אם יש תקציב וזמן — הוסיפו יום נוסף ביום ד׳ לביקור יקב.</p>
<h3>וילה או מלון?</h3>
<p>לקבוצות של 8 נפשות ומעלה — <strong>וילה פרטית</strong> תמיד עדיפה. Moldova Plus עובדת עם מספר וילות פרטיות בסביבת קישינב: בריכה, מטבח מאובזר, שף פרטי אופציונלי ואבטחה. מחיר ללילה לכל הוילה: $250–$450 בהתאם לגודל. לקבוצות קטנות יותר — Radisson Blu או Nobil הם הבחירות הטבעיות.</p>
<h3>חיי לילה — איפה ואיך</h3>
<p>ה-TOP 3 מועדוני הקישינב: <strong>Soho</strong> (המועדון הכי גדול, EDM ברמה בינלאומית), <strong>Casablanca</strong> (אלגנטי, dress-code, קהל מיקס), ו-<strong>La Gusto</strong> (אווירה מועדון ים-תיכוני, מוזיקה קצת שונה). Moldova Plus מסדר כניסה מובטחת + שולחן VIP בכל אחד מהם — ללא תורים, ללא הפתעות.</p>
<h3>אטרקציות ביום</h3>
<p>אל תבזבזו את היום בשינה — קישינב מציעה Carrera Karting (הקארטינג הגדול במזרח אירופה), shooting range, paintball מקצועי, ואפילו סיור רכיבה על סוסים בסביבה הכפרית. Moldova Plus תבנה לכם תוכנית מלאה שמתחילה בשעה 11:00 ומגיעה לשיא בחצות.</p>
<h3>תחבורה ולוגיסטיקה</h3>
<p>עם Moldova Plus קבלתם van מרווח עם נהג דובר עברית זמין 24/7. אין מה לדאוג לוגיסטית — אנחנו מסדרים את הכל מנחיתה ועד המראה. הדרך מהמלון למועדון, חזרה, ביקור ביקב — הכל על אחד.</p>',
   'body_en'=>'<p>Chișinău has become one of the most sought-after bachelor party destinations among Israelis. Low prices, legendary nightlife, private villas and service providers already familiar with Israeli needs — it\'s all here. If you\'re planning one and want to do it right, this is your guide.</p>
<h3>When to fly?</h3>
<p>Thursday–Sunday is the best formula — three days, two nights, landing back Sunday afternoon. Thursday–Saturday nights in Chișinău are the best of the week. If you have budget and time, add an extra Wednesday for a winery visit.</p>
<h3>Villa or hotel?</h3>
<p>For groups of 8 or more, a <strong>private villa</strong> is always preferable. Moldova Plus works with several private villas near Chișinău: pool, equipped kitchen, optional private chef and security. Villa price per night: $250–$450 depending on size.</p>
<h3>Nightlife — where and how</h3>
<p>The top 3 Chișinău clubs: <strong>Soho</strong> (biggest club, international EDM), <strong>Casablanca</strong> (elegant, dress code, mixed crowd), and <strong>La Gusto</strong> (Mediterranean club vibe, different music). Moldova Plus arranges guaranteed entry + VIP table at any of them — no queues, no surprises.</p>',
  ],
];

// Override ARTICLES from articles.json if available
$_articles_json_path = __DIR__ . '/../data/articles.json';
if (file_exists($_articles_json_path)) {
    $_articles_from_json = json_decode(file_get_contents($_articles_json_path), true) ?? [];
    if (!empty($_articles_from_json)) $ARTICLES = $_articles_from_json;
}

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

// Override ATTRACTIONS from attractions.json if available
$_attr_json_path = __DIR__ . '/../data/attractions.json';
if (file_exists($_attr_json_path)) {
    $_attr_from_json = json_decode(file_get_contents($_attr_json_path), true) ?? [];
    if (!empty($_attr_from_json)) $ATTRACTIONS = $_attr_from_json;
}
