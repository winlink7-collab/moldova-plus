<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/scenes.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('about');

$_stat_years     = mp_sr('stat_years',     '8+');
$_stat_packages  = mp_sr('stat_packages',  '1,200+');
$_stat_customers = mp_sr('stat_customers', '15,000+');
$_stat_rating    = mp_sr('stat_rating',    '4.9');
$page = 'about';

page_head(
    $lang==='he' ? 'אודות Moldova Plus — הסיפור שלנו' : 'About Moldova Plus — Our Story',
    $lang==='he' ? 'הפורטל הגדול בישראל לחבילות נופש במולדובה. מי אנחנו, הערכים שלנו והסיבה שאלפי ישראלים בחרו בנו.' : "Israel's largest Moldova travel portal. Who we are, our values and why thousands of Israelis choose us.",
    $lang
);
?>
<?php include 'includes/header.php'; ?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur he">אודות</span><span class="cur en">About</span>
    </div>
    <h1>
      <span class="he">הסיפור <span>שלנו</span></span>
      <span class="en">Our <span>Story</span></span>
    </h1>
    <p>
      <span class="he">מ-2018 אנחנו עוזרים לישראלים לגלות את מולדובה — ביושר, בשקיפות ועם ניסיון אישי.</span>
      <span class="en">Since 2018 we've been helping Israelis discover Moldova — with honesty, transparency and personal experience.</span>
    </p>
  </div>
</section>

<!-- Stats -->
<section class="section" style="padding-bottom:0">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-card reveal">
        <div class="stat-num"<?= le('settings:stat_years') ?>><?= htmlspecialchars($_stat_years) ?></div>
        <div class="stat-label"><span class="he">שנות פעילות</span><span class="en">Years active</span></div>
      </div>
      <div class="stat-card reveal d1">
        <div class="stat-num"<?= le('settings:stat_packages') ?>><?= htmlspecialchars($_stat_packages) ?></div>
        <div class="stat-label"><span class="he">חבילות נמכרו</span><span class="en">Packages sold</span></div>
      </div>
      <div class="stat-card reveal d2">
        <div class="stat-num"<?= le('settings:stat_customers') ?>><?= htmlspecialchars($_stat_customers) ?></div>
        <div class="stat-label"><span class="he">לקוחות מרוצים</span><span class="en">Happy customers</span></div>
      </div>
      <div class="stat-card reveal d3">
        <div class="stat-num"<?= le('settings:stat_rating') ?>><?= htmlspecialchars($_stat_rating) ?></div>
        <div class="stat-label"><span class="he">דירוג ממוצע</span><span class="en">Average rating</span></div>
      </div>
    </div>
  </div>
</section>

<!-- Story -->
<section class="section">
  <div class="container">
    <div class="about-story">
      <div>
        <span class="hero-eyebrow">
          <span class="he">הסיפור שלנו</span><span class="en">Our story</span>
        </span>
        <h2 style="font-size:clamp(26px,3vw,38px);font-weight:800;margin:14px 0 18px;letter-spacing:-.02em;color:var(--ink)">
          <span class="he">נולדנו מתוך <span style="color:var(--flag-blue)">אהבה למולדובה</span></span>
          <span class="en">Born from a <span style="color:var(--flag-blue)">love for Moldova</span></span>
        </h2>
        <?php
        $_about_he = mp_s('about_story_he','');
        $_about_en = mp_s('about_story_en','');
        $_default_he = "Moldova Plus נוסדה ב-2018 על ידי ישראלים שחיו ועבדו בקישינב ונפלו בקסם של המדינה הקטנה הזו — היינות המדהימים, הכנסת האורחים האמיתית, הלילות האינסופיים, והמחירים שפשוט לא קיימים באירופה.\n\nראינו שאין מקום אמין בעברית שמסביר למה לבוא, מה לעשות ואיך להזמין — אז בנינו אחד. כל חבילה שאנחנו מוכרים — אנחנו מכירים אישית. כל מלון בדקנו. כל מסעדה טעמנו.";
        $_default_en = "Moldova Plus was founded in 2018 by Israelis who lived and worked in Chișinău and fell in love with this small country — its amazing wines, genuine hospitality, endless nights and prices that simply don't exist in Europe.\n\nWe saw there was no reliable Hebrew source explaining why to come, what to do and how to book — so we built one. Every package we sell, we know personally. Every hotel we've tested. Every restaurant we've tasted.";
        $_story_he = $_about_he ?: $_default_he;
        $_story_en = $_about_en ?: $_default_en;
        ?>
        <?php if (LE_ADMIN): ?>
        <span data-le="settings:about_story_he" data-le-init="<?= htmlspecialchars($_story_he) ?>" class="le-trigger-btn he" style="margin-bottom:14px">✏ ערוך סיפור</span>
        <?php endif; ?>
        <?php foreach (explode("\n\n", trim($_story_he)) as $_para): ?>
        <p style="font-size:16px;color:var(--ink-soft);line-height:1.8;margin:0 0 16px">
          <span class="he"><?= nl2br(htmlspecialchars($_para)) ?></span>
        </p>
        <?php endforeach;
        foreach (explode("\n\n", trim($_story_en)) as $_para): ?>
        <p style="font-size:16px;color:var(--ink-soft);line-height:1.8;margin:0 0 16px">
          <span class="en"><?= nl2br(htmlspecialchars($_para)) ?></span>
        </p>
        <?php endforeach; ?>
        <div style="display:flex;gap:12px;flex-wrap:wrap">
          <a href="packages<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-primary">
            <span class="he">גלו את החבילות שלנו</span><span class="en">Browse our packages</span>
          </a>
          <a href="contact<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-ghost">
            <span class="he">דברו איתנו</span><span class="en">Contact us</span>
          </a>
        </div>
      </div>
      <div class="story-img"<?= le_img('settings:about_img') ?>>
        <?= scene_img('city') ?>
      </div>
    </div>
  </div>
</section>

<!-- Values -->
<section class="section alt">
  <div class="container">
    <div class="s-head reveal">
      <h2><span class="he">למה <span>בוחרים בנו</span></span><span class="en">Why <span>choose us</span></span></h2>
    </div>
    <div class="values-grid">
      <div class="value-card reveal">
        <div class="value-ic">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 3v6c0 5-3.5 9.5-8 11-4.5-1.5-8-6-8-11V5l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
        </div>
        <h4><span class="he">שקיפות מלאה</span><span class="en">Full transparency</span></h4>
        <p><span class="he">אין עמלות נסתרות, אין הפתעות. המחיר שרואים הוא המחיר שמשלמים — כולל מסים ועמלות.</span><span class="en">No hidden fees, no surprises. The price you see is the price you pay — taxes and commissions included.</span></p>
      </div>
      <div class="value-card reveal d1">
        <div class="value-ic">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <h4><span class="he">אישור מיידי</span><span class="en">Instant confirmation</span></h4>
        <p><span class="he">רוב החבילות מאושרות תוך שניות. ללא המתנה, ללא בירוקרטיה — מזמינים ויוצאים.</span><span class="en">Most packages are confirmed within seconds. No waiting, no bureaucracy — book and go.</span></p>
      </div>
      <div class="value-card reveal d2">
        <div class="value-ic">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h4><span class="he">ליווי מקומי אישי</span><span class="en">Personal local support</span></h4>
        <p><span class="he">בכל חבילה יש ליווי מקומי דובר עברית. אתם לא נוסעים לבד — אנחנו כאן בכל שלב.</span><span class="en">Every package includes Hebrew-speaking local support. You're never traveling alone — we're with you every step.</span></p>
      </div>
      <div class="value-card reveal">
        <div class="value-ic">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2"/><path d="M2 12h20"/><path d="M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20"/></svg>
        </div>
        <h4><span class="he">ניסיון אישי</span><span class="en">Personal experience</span></h4>
        <p><span class="he">לא מוכרים מה שלא בדקנו. כל יעד, כל מלון, כל אטרקציה — ביקרנו בעצמנו לפני שהכנסנו לאתר.</span><span class="en">We don't sell what we haven't tested. Every destination, hotel and attraction — we visited personally before listing.</span></p>
      </div>
      <div class="value-card reveal d1">
        <div class="value-ic">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        </div>
        <h4><span class="he">מחיר הכי טוב</span><span class="en">Best price guaranteed</span></h4>
        <p><span class="he">מצאתם אותה חבילה זולה יותר במקום אחר? נשווה את המחיר ונוסיף 5% הנחה.</span><span class="en">Found the same package cheaper elsewhere? We'll match the price and add a 5% discount.</span></p>
      </div>
      <div class="value-card reveal d2">
        <div class="value-ic">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.07V12a10 10 0 1 1-5.93-9.14"/><path d="M23 3L12 14l-3-3"/></svg>
        </div>
        <h4><span class="he">ביטול גמיש</span><span class="en">Flexible cancellation</span></h4>
        <p><span class="he">ביטול חינם עד 14 יום לפני הנסיעה. אנחנו מבינים שחיים קורים — המדיניות שלנו היא לטובתכם.</span><span class="en">Free cancellation up to 14 days before travel. We understand life happens — our policy is for your benefit.</span></p>
      </div>
    </div>
  </div>
</section>

<!-- How it works -->
<section class="section">
  <div class="container">
    <div class="s-head reveal">
      <h2><span class="he">איך זה <span>עובד</span></span><span class="en">How it <span>works</span></span></h2>
    </div>
    <div class="steps-grid reveal">
      <div class="step">
        <div class="step-num">1</div>
        <h4><span class="he">בוחרים חבילה</span><span class="en">Choose a package</span></h4>
        <p><span class="he">עוברים על כל החבילות, מסננים לפי תאריך, תקציב וסוג חוויה.</span><span class="en">Browse all packages, filter by date, budget and experience type.</span></p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <h4><span class="he">שולחים הודעה</span><span class="en">Send a message</span></h4>
        <p><span class="he">לוחצים על "הזמינו עכשיו", פותחים שיחה בוואטסאפ וסוגרים בשנייה.</span><span class="en">Click "Book now", open a WhatsApp conversation and close in seconds.</span></p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <h4><span class="he">יוצאים ליהנות</span><span class="en">Go enjoy</span></h4>
        <p><span class="he">אנחנו מסדרים את כל הלוגיסטיקה — אתם רק מגיעים ונהנים.</span><span class="en">We handle all the logistics — you just show up and enjoy.</span></p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section" style="padding-top:0;padding-bottom:48px">
  <div class="container">
    <div class="promo-strip">
      <div class="promo-bg"></div>
      <div class="promo-orb" style="width:280px;height:280px;top:-80px;right:-60px"></div>
      <div style="position:relative;z-index:1">
        <h3><span class="he">מוכנים לחוויה הבאה?</span><span class="en">Ready for the next experience?</span></h3>
        <p><span class="he">הצטרפו ל-15,000 ישראלים שכבר גילו את מולדובה דרכנו.</span><span class="en">Join 15,000 Israelis who already discovered Moldova through us.</span></p>
      </div>
      <a href="packages<?= $lang==='en'?'?lang=en':'' ?>" class="btn btn-cta" style="position:relative;z-index:1">
        <span class="he">לכל החבילות ←</span><span class="en">All packages →</span>
      </a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
