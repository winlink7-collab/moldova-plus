<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('contact');

$_wa      = mp_sr('whatsapp',    '972355501880');
$_phone   = mp_sr('phone',       '035550188');
$_email   = mp_sr('email',       'hello@moldovaplus.com');
$_addr_he = mp_sr('address_he',  'רחוב הברזל 3, תל אביב–יפו, קומה 4');
$_addr_en = mp_sr('address_en',  '3 HaBarzel St, Tel Aviv–Yafo, Floor 4');
$_h_sun   = mp_sr('hours_sun_thu', '09:00 – 20:00');
$_h_fri   = mp_sr('hours_fri',   '09:00 – 14:00');
$page = 'contact';

page_head(
    $lang==='he' ? 'צור קשר — Moldova Plus' : 'Contact Us — Moldova Plus',
    $lang==='he' ? 'דברו איתנו — וואטסאפ, טלפון ואימייל. אנחנו מגיבים תוך דקות.' : 'Contact us — WhatsApp, phone and email. We respond within minutes.',
    $lang
);
?>
<?php include 'includes/header.php'; ?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="/<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur he">צור קשר</span><span class="cur en">Contact</span>
    </div>
    <h1>
      <span class="he">דברו <span>איתנו</span></span>
      <span class="en">Get in <span>Touch</span></span>
    </h1>
    <p>
      <span class="he">אנחנו כאן לכל שאלה — לפני, במהלך ואחרי הטיול.</span>
      <span class="en">We're here for every question — before, during and after your trip.</span>
    </p>
  </div>
</section>

<!-- Contact grid -->
<section class="section">
  <div class="container">
    <div class="contact-grid">

      <!-- Info cards -->
      <div class="contact-info-cards">

        <a href="https://wa.me/<?= htmlspecialchars($_wa) ?>" target="_blank" rel="noopener" class="ci-card reveal">
          <div class="ci-ic" style="background:#dcfce7;color:#16a34a">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          </div>
          <div>
            <b><span class="he">וואטסאפ</span><span class="en">WhatsApp</span></b>
            <span><span class="he">הדרך המהירה ביותר — +<?= htmlspecialchars($_wa) ?></span><span class="en">Fastest way to reach us — +<?= htmlspecialchars($_wa) ?></span></span>
          </div>
        </a>

        <a href="tel:+<?= htmlspecialchars($_phone) ?>" class="ci-card reveal d1">
          <div class="ci-ic" style="background:var(--flag-blue-pale);color:var(--flag-blue)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7l.8 4a2 2 0 0 1-.6 1.9L7.6 11.4a16 16 0 0 0 6 6l1.8-1.7a2 2 0 0 1 1.9-.6l4 .8a2 2 0 0 1 1.7 2z"/></svg>
          </div>
          <div>
            <b><span class="he">טלפון</span><span class="en">Phone</span></b>
            <span><span<?= le('settings:phone_display') ?>><?= htmlspecialchars($_phone) ?></span> | <span class="he">א'–ה' <span<?= le('settings:hours_sun_thu') ?>><?= htmlspecialchars($_h_sun) ?></span></span><span class="en">Sun–Thu <?= htmlspecialchars($_h_sun) ?></span></span>
          </div>
        </a>

        <a href="mailto:<?= htmlspecialchars($_email) ?>" class="ci-card reveal d2">
          <div class="ci-ic" style="background:#fefce8;color:#b45309">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
          </div>
          <div>
            <b><span class="he">אימייל</span><span class="en">Email</span></b>
            <span<?= le('settings:email') ?>><?= htmlspecialchars($_email) ?></span>
          </div>
        </a>

        <div class="ci-card reveal">
          <div class="ci-ic" style="background:#fff0f0;color:var(--flag-red)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
          </div>
          <div>
            <b><span class="he">כתובת</span><span class="en">Address</span></b>
            <span><span class="he"<?= le('settings:address_he') ?>><?= htmlspecialchars($_addr_he) ?></span><span class="en"><?= htmlspecialchars($_addr_en) ?></span></span>
          </div>
        </div>

        <!-- Working hours -->
        <div class="hours-card reveal">
          <h4 style="display:flex;align-items:center;gap:8px">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            <span class="he">שעות פעילות</span><span class="en">Working hours</span>
          </h4>
          <div class="hours-row">
            <span><span class="he">ראשון–חמישי</span><span class="en">Sun–Thu</span></span>
            <b<?= le('settings:hours_sun_thu') ?>><?= htmlspecialchars($_h_sun) ?></b>
          </div>
          <div class="hours-row">
            <span><span class="he">שישי</span><span class="en">Friday</span></span>
            <b<?= le('settings:hours_fri') ?>><?= htmlspecialchars($_h_fri) ?></b>
          </div>
          <div class="hours-row">
            <span><span class="he">שבת</span><span class="en">Saturday</span></span>
            <b style="color:var(--ink-mute)"><span class="he">סגור</span><span class="en">Closed</span></b>
          </div>
          <div class="hours-row" style="font-size:12px;color:var(--flag-blue);font-weight:600;border-bottom:0;gap:6px;padding-top:10px">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 3v6c0 5-3.5 9.5-8 11-4.5-1.5-8-6-8-11V5l8-3z"/></svg>
            <span><span class="he">וואטסאפ זמין 24/7 לדחוף</span><span class="en">WhatsApp available 24/7 for urgent matters</span></span>
          </div>
        </div>

      </div><!-- /contact-info-cards -->

      <!-- Contact form -->
      <div class="contact-form-card reveal">
        <h3>
          <span class="he">שלחו לנו הודעה</span>
          <span class="en">Send us a message</span>
        </h3>
        <p style="color:var(--ink-soft);font-size:14px;margin:-12px 0 24px">
          <span class="he">נחזור אליכם בוואטסאפ תוך דקות</span>
          <span class="en">We'll reply on WhatsApp within minutes</span>
        </p>
        <form id="contact-form" novalidate>
          <div class="cf-row-2">
            <div class="cf-row">
              <label><span class="he">שם מלא</span><span class="en">Full name</span></label>
              <input type="text" name="name" placeholder="<?= $lang==='he'?'ישראל ישראלי':'Israel Israeli' ?>" required>
            </div>
            <div class="cf-row">
              <label><span class="he">טלפון</span><span class="en">Phone</span></label>
              <input type="tel" name="phone" placeholder="050-000-0000" required>
            </div>
          </div>
          <div class="cf-row">
            <label><span class="he">נושא</span><span class="en">Subject</span></label>
            <select name="subject">
              <option value=""><span class="he">בחרו נושא...</span><span class="en">Choose subject...</span></option>
              <option value="booking"><span class="he">שאלה על הזמנה</span><span class="en">Booking question</span></option>
              <option value="package"><span class="he">פרטים על חבילה</span><span class="en">Package details</span></option>
              <option value="custom"><span class="he">חבילה מותאמת אישית</span><span class="en">Custom package</span></option>
              <option value="cancel"><span class="he">ביטול / שינוי</span><span class="en">Cancellation / change</span></option>
              <option value="other"><span class="he">אחר</span><span class="en">Other</span></option>
            </select>
          </div>
          <div class="cf-row">
            <label><span class="he">הודעה</span><span class="en">Message</span></label>
            <textarea name="message" rows="5" placeholder="<?= $lang==='he'?'ספרו לנו...':'Tell us...' ?>"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            <span class="he">שלחו בוואטסאפ</span>
            <span class="en">Send via WhatsApp</span>
          </button>
        </form>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
