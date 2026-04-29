<?php
require_once __DIR__ . '/includes/auth.php';
mp_admin_check();

$msg = ''; $error = '';

// --- SAVE CONTACT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'contact' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['whatsapp']       = preg_replace('/\D/', '', $_POST['whatsapp'] ?? '');
    $s['phone']          = trim($_POST['phone'] ?? '');
    $s['phone_display']  = trim($_POST['phone_display'] ?? '');
    $s['email']          = trim($_POST['email'] ?? '');
    $s['site_name']     = trim($_POST['site_name'] ?? '');
    $s['address_he']    = trim($_POST['address_he'] ?? '');
    $s['address_en']    = trim($_POST['address_en'] ?? '');
    $s['hours_sun_thu'] = trim($_POST['hours_sun_thu'] ?? '');
    $s['hours_fri']     = trim($_POST['hours_fri'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'הגדרות הקשר עודכנו!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE ABOUT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'about' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['about_story_he'] = trim($_POST['about_story_he'] ?? '');
    $s['about_story_en'] = trim($_POST['about_story_en'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'טקסט עמוד אודות עודכן!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE STATS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'stats' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    $s['stat_years']     = trim($_POST['stat_years'] ?? '');
    $s['stat_packages']  = trim($_POST['stat_packages'] ?? '');
    $s['stat_customers'] = trim($_POST['stat_customers'] ?? '');
    $s['stat_rating']    = trim($_POST['stat_rating'] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'הסטטיסטיקות עודכנו!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE BACHELOR PERKS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'bach_perks' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    for ($i = 1; $i <= 4; $i++) {
        $s['bach_perk_'.$i.'_he'] = trim($_POST['bach_perk_'.$i.'_he'] ?? '');
        $s['bach_perk_'.$i.'_en'] = trim($_POST['bach_perk_'.$i.'_en'] ?? '');
    }
    mp_write_json('settings.json', $s) ? $msg = 'יתרונות מסיבת רווקים עודכנו!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE ABOUT VALUES/STEPS/CTA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'about_content' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    for ($i = 1; $i <= 6; $i++) {
        $s['about_val_'.$i.'_title_he'] = trim($_POST['about_val_'.$i.'_title_he'] ?? '');
        $s['about_val_'.$i.'_title_en'] = trim($_POST['about_val_'.$i.'_title_en'] ?? '');
        $s['about_val_'.$i.'_desc_he']  = trim($_POST['about_val_'.$i.'_desc_he']  ?? '');
        $s['about_val_'.$i.'_desc_en']  = trim($_POST['about_val_'.$i.'_desc_en']  ?? '');
    }
    for ($i = 1; $i <= 3; $i++) {
        $s['about_step_'.$i.'_title_he'] = trim($_POST['about_step_'.$i.'_title_he'] ?? '');
        $s['about_step_'.$i.'_title_en'] = trim($_POST['about_step_'.$i.'_title_en'] ?? '');
        $s['about_step_'.$i.'_desc_he']  = trim($_POST['about_step_'.$i.'_desc_he']  ?? '');
        $s['about_step_'.$i.'_desc_en']  = trim($_POST['about_step_'.$i.'_desc_en']  ?? '');
    }
    foreach (['about_cta_title_he','about_cta_title_en','about_cta_desc_he','about_cta_desc_en'] as $_k)
        $s[$_k] = trim($_POST[$_k] ?? '');
    mp_write_json('settings.json', $s) ? $msg = 'תוכן עמוד אודות עודכן!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE PAGE TITLES ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'page_titles' && mp_csrf_verify()) {
    $s = mp_read_json('settings.json');
    foreach (['packages','bachelor','attractions','hotels'] as $_pg) {
        $s['page_'.$_pg.'_title_he'] = trim($_POST['page_'.$_pg.'_title_he'] ?? '');
        $s['page_'.$_pg.'_title_en'] = trim($_POST['page_'.$_pg.'_title_en'] ?? '');
        $s['page_'.$_pg.'_desc_he']  = trim($_POST['page_'.$_pg.'_desc_he']  ?? '');
        $s['page_'.$_pg.'_desc_en']  = trim($_POST['page_'.$_pg.'_desc_en']  ?? '');
    }
    mp_write_json('settings.json', $s) ? $msg = 'כותרות הדפים עודכנו!' : $error = 'שגיאה בשמירה.';
}

// --- SAVE PASSWORD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['section'] ?? '') === 'password' && mp_csrf_verify()) {
    $p1 = $_POST['pass1'] ?? '';
    $p2 = $_POST['pass2'] ?? '';
    if (strlen($p1) < 6) {
        $error = 'הסיסמה חייבת להכיל לפחות 6 תווים.';
    } elseif ($p1 !== $p2) {
        $error = 'הסיסמאות אינן תואמות.';
    } else {
        $hash = password_hash($p1, PASSWORD_BCRYPT);
        $php  = '<?php return ' . var_export($hash, true) . ';';
        file_put_contents(ADMIN_PASS_FILE, $php) ? $msg = 'הסיסמה עודכנה בהצלחה!' : $error = 'שגיאה בשמירת הסיסמה.';
    }
}

$S = mp_read_json('settings.json');
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>הגדרות — Moldova Plus Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-layout">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="admin-main">
    <div class="admin-topbar"><div><h1>הגדרות</h1><p>פרטי קשר, שעות, סטטיסטיקות וסיסמה</p></div></div>
    <div class="admin-content">

      <?php if ($msg): ?><div class="alert success"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

      <!-- Contact Settings -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>פרטי קשר ושעות</h2><p>מוצגים בדף "צור קשר" ובכל האתר</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="contact">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>WhatsApp (ספרות בלבד)</label>
                <div style="display:flex;gap:8px">
                  <input type="text" name="whatsapp" value="<?= htmlspecialchars($S['whatsapp'] ?? '') ?>" placeholder="972355501880" style="flex:1">
                  <a href="https://wa.me/<?= htmlspecialchars($S['whatsapp'] ?? '') ?>" target="_blank" class="btn-admin ghost sm" style="white-space:nowrap">בדוק</a>
                </div>
              </div>
              <div class="form-group">
                <label>טלפון (לקישורי tel:)</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($S['phone'] ?? '') ?>" placeholder="035550188">
              </div>
              <div class="form-group">
                <label>טלפון (תצוגה)</label>
                <input type="text" name="phone_display" value="<?= htmlspecialchars($S['phone_display'] ?? '') ?>" placeholder="+972 3-555-0188">
              </div>
              <div class="form-group">
                <label>אימייל</label>
                <input type="email" name="email" value="<?= htmlspecialchars($S['email'] ?? '') ?>" placeholder="hello@moldovaplus.com">
              </div>
              <div class="form-group">
                <label>שם האתר</label>
                <input type="text" name="site_name" value="<?= htmlspecialchars($S['site_name'] ?? '') ?>" placeholder="Moldova Plus">
              </div>
              <div class="form-group">
                <label>כתובת (עברית)</label>
                <input type="text" name="address_he" value="<?= htmlspecialchars($S['address_he'] ?? '') ?>" placeholder="רחוב הברזל 3, תל אביב–יפו, קומה 4">
              </div>
              <div class="form-group">
                <label>כתובת (אנגלית)</label>
                <input type="text" name="address_en" value="<?= htmlspecialchars($S['address_en'] ?? '') ?>" placeholder="3 HaBarzel St, Tel Aviv–Yafo, Floor 4">
              </div>
              <div class="form-group">
                <label>שעות א'–ה'</label>
                <input type="text" name="hours_sun_thu" value="<?= htmlspecialchars($S['hours_sun_thu'] ?? '') ?>" placeholder="09:00 – 20:00">
              </div>
              <div class="form-group">
                <label>שעות שישי</label>
                <input type="text" name="hours_fri" value="<?= htmlspecialchars($S['hours_fri'] ?? '') ?>" placeholder="09:00 – 14:00">
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור פרטי קשר</button>
          </form>
        </div>
      </div>

      <!-- Stats Settings -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>סטטיסטיקות האתר</h2><p>מוצגות בדף "אודות" ובעמוד הבית</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="stats">
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px">
              <div class="form-group">
                <label>שנות פעילות</label>
                <input type="text" name="stat_years" value="<?= htmlspecialchars($S['stat_years'] ?? '8+') ?>" placeholder="8+">
              </div>
              <div class="form-group">
                <label>חבילות נמכרו</label>
                <input type="text" name="stat_packages" value="<?= htmlspecialchars($S['stat_packages'] ?? '1,200+') ?>" placeholder="1,200+">
              </div>
              <div class="form-group">
                <label>לקוחות מרוצים</label>
                <input type="text" name="stat_customers" value="<?= htmlspecialchars($S['stat_customers'] ?? '15,000+') ?>" placeholder="15,000+">
              </div>
              <div class="form-group">
                <label>דירוג ממוצע</label>
                <input type="text" name="stat_rating" value="<?= htmlspecialchars($S['stat_rating'] ?? '4.9') ?>" placeholder="4.9">
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור סטטיסטיקות</button>
          </form>
        </div>
      </div>

      <!-- About Story -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>טקסט עמוד אודות</h2><p>הסיפור שמוצג בעמוד "אודות"</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="about">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
              <div class="form-group">
                <label>הסיפור שלנו — עברית</label>
                <textarea name="about_story_he" rows="7" placeholder="Moldova Plus נוסדה ב-2018..."><?= htmlspecialchars($S['about_story_he'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>Our Story — English</label>
                <textarea name="about_story_en" rows="7" style="direction:ltr" placeholder="Moldova Plus was founded in 2018..."><?= htmlspecialchars($S['about_story_en'] ?? '') ?></textarea>
              </div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:8px">שמור טקסט אודות</button>
          </form>
        </div>
      </div>

      <!-- Bachelor Perks -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>יתרונות — מסיבת רווקים</h2><p>4 כרטיסי היתרונות בראש דף מסיבות רווקים</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="bach_perks">
            <?php
            $perk_defs = [1=>'טיסה ישירה 3 שעות',2=>'מחירים נמוכים פי 3',3=>'חיי לילה אגדיים',4=>'וילות יוקרה בשפע'];
            $perk_en   = [1=>'3h direct flight',2=>'3× cheaper than Europe',3=>'Legendary nightlife',4=>'Abundance of luxury villas'];
            for ($i=1;$i<=4;$i++): ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #f0f0f0">
              <div class="form-group" style="margin:0">
                <label>יתרון <?= $i ?> — עברית</label>
                <input type="text" name="bach_perk_<?= $i ?>_he" value="<?= htmlspecialchars($S['bach_perk_'.$i.'_he'] ?? $perk_defs[$i]) ?>">
              </div>
              <div class="form-group" style="margin:0">
                <label>Perk <?= $i ?> — English</label>
                <input type="text" name="bach_perk_<?= $i ?>_en" value="<?= htmlspecialchars($S['bach_perk_'.$i.'_en'] ?? $perk_en[$i]) ?>" style="direction:ltr">
              </div>
            </div>
            <?php endfor; ?>
            <button type="submit" class="btn-admin primary" style="margin-top:4px">שמור יתרונות</button>
          </form>
        </div>
      </div>

      <!-- About Values / Steps / CTA -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>תוכן עמוד אודות</h2><p>ערכים, שלבי הזמנה וCTA</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="about_content">
            <?php
            $val_defs = [
              1=>['title_he'=>'שקיפות מלאה','title_en'=>'Full transparency','desc_he'=>'אין עמלות נסתרות, אין הפתעות. המחיר שרואים הוא המחיר שמשלמים.','desc_en'=>'No hidden fees, no surprises. The price you see is the price you pay.'],
              2=>['title_he'=>'אישור מיידי','title_en'=>'Instant confirmation','desc_he'=>'רוב החבילות מאושרות תוך שניות. ללא המתנה, ללא בירוקרטיה.','desc_en'=>'Most packages confirmed in seconds. No waiting, no bureaucracy.'],
              3=>['title_he'=>'ליווי מקומי אישי','title_en'=>'Personal local support','desc_he'=>'בכל חבילה יש ליווי מקומי דובר עברית.','desc_en'=>'Every package includes Hebrew-speaking local support.'],
              4=>['title_he'=>'ניסיון אישי','title_en'=>'Personal experience','desc_he'=>'לא מוכרים מה שלא בדקנו. כל יעד — ביקרנו בעצמנו.','desc_en'=>"We don't sell what we haven't tested. Every destination — personally visited."],
              5=>['title_he'=>'מחיר הכי טוב','title_en'=>'Best price guaranteed','desc_he'=>'מצאתם זול יותר? נשווה ונוסיף 5% הנחה.','desc_en'=> "Found cheaper? We'll match and add 5% off."],
              6=>['title_he'=>'ביטול גמיש','title_en'=>'Flexible cancellation','desc_he'=>'ביטול חינם עד 14 יום לפני הנסיעה.','desc_en'=>'Free cancellation up to 14 days before travel.'],
            ];
            ?>
            <p style="font-weight:700;margin:0 0 12px;color:#374151">6 כרטיסי ערכים</p>
            <?php for($i=1;$i<=6;$i++): $vd=$val_defs[$i]; ?>
            <div style="border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-bottom:12px">
              <div style="font-size:12px;font-weight:700;color:#6b7280;margin-bottom:8px">ערך <?= $i ?></div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group" style="margin:0"><label>כותרת עברית</label><input type="text" name="about_val_<?= $i ?>_title_he" value="<?= htmlspecialchars($S['about_val_'.$i.'_title_he'] ?? $vd['title_he']) ?>"></div>
                <div class="form-group" style="margin:0"><label>Title English</label><input type="text" name="about_val_<?= $i ?>_title_en" value="<?= htmlspecialchars($S['about_val_'.$i.'_title_en'] ?? $vd['title_en']) ?>" style="direction:ltr"></div>
                <div class="form-group" style="margin:0"><label>תיאור עברית</label><textarea name="about_val_<?= $i ?>_desc_he" rows="2"><?= htmlspecialchars($S['about_val_'.$i.'_desc_he'] ?? $vd['desc_he']) ?></textarea></div>
                <div class="form-group" style="margin:0"><label>Description EN</label><textarea name="about_val_<?= $i ?>_desc_en" rows="2" style="direction:ltr"><?= htmlspecialchars($S['about_val_'.$i.'_desc_en'] ?? $vd['desc_en']) ?></textarea></div>
              </div>
            </div>
            <?php endfor; ?>
            <p style="font-weight:700;margin:16px 0 12px;color:#374151">3 שלבי הזמנה</p>
            <?php
            $step_defs=[1=>['title_he'=>'בוחרים חבילה','title_en'=>'Choose a package','desc_he'=>'עוברים על כל החבילות, מסננים לפי תאריך ותקציב.','desc_en'=>'Browse all packages, filter by date and budget.'],2=>['title_he'=>'שולחים הודעה','title_en'=>'Send a message','desc_he'=>'לוחצים "הזמינו עכשיו" ופותחים שיחת וואטסאפ.','desc_en'=>'Click "Book now" and open a WhatsApp chat.'],3=>['title_he'=>'יוצאים ליהנות','title_en'=>'Go enjoy','desc_he'=>'אנחנו מסדרים הכל — אתם רק מגיעים ונהנים.','desc_en'=>'We handle everything — you just show up and enjoy.']];
            for($i=1;$i<=3;$i++): $sd=$step_defs[$i]; ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #f0f0f0">
              <div class="form-group" style="margin:0"><label>שלב <?= $i ?> כותרת עברית</label><input type="text" name="about_step_<?= $i ?>_title_he" value="<?= htmlspecialchars($S['about_step_'.$i.'_title_he'] ?? $sd['title_he']) ?>"></div>
              <div class="form-group" style="margin:0"><label>Step <?= $i ?> title EN</label><input type="text" name="about_step_<?= $i ?>_title_en" value="<?= htmlspecialchars($S['about_step_'.$i.'_title_en'] ?? $sd['title_en']) ?>" style="direction:ltr"></div>
              <div class="form-group" style="margin:0"><label>תיאור עברית</label><input type="text" name="about_step_<?= $i ?>_desc_he" value="<?= htmlspecialchars($S['about_step_'.$i.'_desc_he'] ?? $sd['desc_he']) ?>"></div>
              <div class="form-group" style="margin:0"><label>Description EN</label><input type="text" name="about_step_<?= $i ?>_desc_en" value="<?= htmlspecialchars($S['about_step_'.$i.'_desc_en'] ?? $sd['desc_en']) ?>" style="direction:ltr"></div>
            </div>
            <?php endfor; ?>
            <p style="font-weight:700;margin:16px 0 12px;color:#374151">כפתור CTA תחתון</p>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
              <div class="form-group" style="margin:0"><label>כותרת עברית</label><input type="text" name="about_cta_title_he" value="<?= htmlspecialchars($S['about_cta_title_he'] ?? 'מוכנים לחוויה הבאה?') ?>"></div>
              <div class="form-group" style="margin:0"><label>Title English</label><input type="text" name="about_cta_title_en" value="<?= htmlspecialchars($S['about_cta_title_en'] ?? 'Ready for the next experience?') ?>" style="direction:ltr"></div>
              <div class="form-group" style="margin:0"><label>תיאור עברית</label><input type="text" name="about_cta_desc_he" value="<?= htmlspecialchars($S['about_cta_desc_he'] ?? 'הצטרפו ל-15,000 ישראלים שכבר גילו את מולדובה דרכנו.') ?>"></div>
              <div class="form-group" style="margin:0"><label>Description EN</label><input type="text" name="about_cta_desc_en" value="<?= htmlspecialchars($S['about_cta_desc_en'] ?? 'Join 15,000 Israelis who already discovered Moldova through us.') ?>" style="direction:ltr"></div>
            </div>
            <button type="submit" class="btn-admin primary" style="margin-top:14px">שמור תוכן אודות</button>
          </form>
        </div>
      </div>

      <!-- Page Titles -->
      <div class="admin-card" style="margin-bottom:20px">
        <div class="card-head"><div><h2>כותרות ותיאורי דפים</h2><p>הכותרת והמשפט שמופיעים בראש כל דף פנימי</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="page_titles">
            <?php
            $page_defs = [
              'packages'   => ['he'=>'חבילות נופש',           'en'=>'Vacation Packages',         'desc_he'=>'כל חבילות הנופש שלנו במולדובה — מבוקרות, שקופות, באישור מיידי.', 'desc_en'=>'All our Moldova vacation packages — vetted, transparent, instant booking.'],
              'bachelor'   => ['he'=>'מסיבות רווקים בקישינב', 'en'=>'Bachelor Parties in Chișinău','desc_he'=>'וילות, בארים, תחבורה וליווי מקומי — מסיבת רווקים שלא ישכחו.',         'desc_en'=>'Villas, bars, transport and local fixers — bachelor parties to remember.'],
              'attractions'=> ['he'=>'אטרקציות במולדובה',     'en'=>'Attractions in Moldova',    'desc_he'=>'יקבים, מנזרים, אדרנלין וחיי לילה — כל מה ששווה לבקר בו.',           'desc_en'=>'Wineries, monasteries, adrenaline and nightlife — everything worth visiting.'],
              'hotels'     => ['he'=>'מלונות בקישינב',        'en'=>'Hotels in Chișinău',        'desc_he'=>'המלונות הטובים ביותר בקישינב — בוטיק, יוקרה ומשפחה.',               'desc_en'=>'Best hotels in Chișinău — boutique, luxury and family.'],
            ];
            foreach ($page_defs as $pid => $pd): ?>
            <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px;margin-bottom:16px">
              <div style="font-weight:700;margin-bottom:12px;color:#374151"><?= $pd['he'] ?></div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="form-group">
                  <label>כותרת — עברית</label>
                  <input type="text" name="page_<?= $pid ?>_title_he" value="<?= htmlspecialchars($S['page_'.$pid.'_title_he'] ?? $pd['he']) ?>" placeholder="<?= htmlspecialchars($pd['he']) ?>">
                </div>
                <div class="form-group">
                  <label>Title — English</label>
                  <input type="text" name="page_<?= $pid ?>_title_en" value="<?= htmlspecialchars($S['page_'.$pid.'_title_en'] ?? $pd['en']) ?>" placeholder="<?= htmlspecialchars($pd['en']) ?>" style="direction:ltr">
                </div>
                <div class="form-group">
                  <label>תיאור — עברית</label>
                  <input type="text" name="page_<?= $pid ?>_desc_he" value="<?= htmlspecialchars($S['page_'.$pid.'_desc_he'] ?? $pd['desc_he']) ?>" placeholder="<?= htmlspecialchars($pd['desc_he']) ?>">
                </div>
                <div class="form-group">
                  <label>Description — English</label>
                  <input type="text" name="page_<?= $pid ?>_desc_en" value="<?= htmlspecialchars($S['page_'.$pid.'_desc_en'] ?? $pd['desc_en']) ?>" placeholder="<?= htmlspecialchars($pd['desc_en']) ?>" style="direction:ltr">
                </div>
              </div>
            </div>
            <?php endforeach; ?>
            <button type="submit" class="btn-admin primary">שמור כותרות</button>
          </form>
        </div>
      </div>

      <!-- Password -->
      <div class="admin-card">
        <div class="card-head"><div><h2>שינוי סיסמה</h2><p>סיסמת כניסה לפאנל הניהול</p></div></div>
        <div class="card-body" style="padding:20px">
          <form method="POST" style="max-width:420px">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(mp_csrf()) ?>">
            <input type="hidden" name="section" value="password">
            <div class="form-group">
              <label>סיסמה חדשה (מינימום 6 תווים)</label>
              <input type="password" name="pass1" placeholder="••••••••" autocomplete="new-password">
            </div>
            <div class="form-group">
              <label>אימות סיסמה</label>
              <input type="password" name="pass2" placeholder="••••••••" autocomplete="new-password">
            </div>
            <button type="submit" class="btn-admin primary">עדכן סיסמה</button>
          </form>
        </div>
      </div>

    </div>
  </main>
</div>
</body>
</html>
