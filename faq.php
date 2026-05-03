<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('faq');
$page = 'faq';

page_head(
    $lang==='he' ? 'שאלות נפוצות — Moldova Plus' : 'FAQ — Moldova Plus',
    $lang==='he' ? 'תשובות לכל השאלות הנפוצות על טיול למולדובה: הזמנה, טיסות, מלונות, ביטול ועוד.' : 'Answers to all common questions about travelling to Moldova: booking, flights, hotels, cancellation and more.',
    $lang
);
?>
<?php include 'includes/header.php'; ?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="/<?= $lang!=='he'?'?lang='.$lang:'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur he">שאלות נפוצות</span><span class="cur en">FAQ</span>
    </div>
    <h1>
      <span class="he">שאלות <span>נפוצות</span></span>
      <span class="en">Frequently Asked <span>Questions</span></span>
    </h1>
    <p>
      <span class="he">כל מה שרצית לדעת לפני שאתה יוצא למולדובה — ענינו כאן.</span>
      <span class="en">Everything you wanted to know before heading to Moldova — answered here.</span>
    </p>
  </div>
</section>

<!-- FAQ Categories + List -->
<section class="section">
  <div class="container">

    <!-- Category filters -->
    <div class="faq-cats reveal">
      <button class="faq-cat-btn active" data-cat="all">
        <span class="he">הכל</span><span class="en">All</span>
      </button>
      <button class="faq-cat-btn" data-cat="booking">
        <span class="he">הזמנה</span><span class="en">Booking</span>
      </button>
      <button class="faq-cat-btn" data-cat="flights">
        <span class="he">טיסות</span><span class="en">Flights</span>
      </button>
      <button class="faq-cat-btn" data-cat="hotels">
        <span class="he">מלונות</span><span class="en">Hotels</span>
      </button>
      <button class="faq-cat-btn" data-cat="cancel">
        <span class="he">ביטולים</span><span class="en">Cancellation</span>
      </button>
      <button class="faq-cat-btn" data-cat="general">
        <span class="he">כללי</span><span class="en">General</span>
      </button>
    </div>

    <?php
    $_faq_file = __DIR__ . '/data/faq.json';
    $_FAQS = file_exists($_faq_file) ? (json_decode(file_get_contents($_faq_file), true) ?? []) : [];
    ?>
    <div class="faq-list">

      <?php if ($_FAQS): foreach ($_FAQS as $_fi => $_fq): ?>
      <div class="faq-item reveal <?= $_fi>0?'d'.min($_fi%3,2):'' ?>" data-cat="<?= htmlspecialchars($_fq['cat']) ?>">
        <button class="faq-q">
          <span class="he"><?= htmlspecialchars($_fq['q_he']) ?></span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><?= nl2br(htmlspecialchars($_fq['a_he'])) ?></p>
        </div>
      </div>
      <?php endforeach; else: ?>
      <!-- BOOKING (fallback static) -->
      <div class="faq-item reveal" data-cat="booking">
        <button class="faq-q">
          <span class="he">איך מזמינים חבילה?</span>
          <span class="en">How do I book a package?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">הזמנה פשוטה: בוחרים חבילה, לוחצים על "הזמינו עכשיו" ונפתחת שיחת וואטסאפ ישירה עם הצוות שלנו. אנחנו מסיימים את הפרטים, מאשרים ושולחים אישור רשמי תוך דקות.</span><span class="en">Booking is simple: choose a package, click "Book now" and a WhatsApp conversation opens directly with our team. We finalise details, confirm and send an official confirmation within minutes.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d1" data-cat="booking">
        <button class="faq-q">
          <span class="he">האם ניתן לבקש תאריכים מותאמים אישית?</span>
          <span class="en">Can I request custom dates?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">בהחלט! כל חבילה ניתנת להתאמה. ספרו לנו את התאריכים הרצויים ואנחנו נבנה עבורכם הצעה מותאמת אישית, כולל טיסות, מלון ופעילויות.</span><span class="en">Absolutely! Every package can be customised. Tell us your preferred dates and we'll build a personalised proposal including flights, hotel and activities.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d2" data-cat="booking">
        <button class="faq-q">
          <span class="he">אילו אמצעי תשלום מקובלים?</span>
          <span class="en">What payment methods do you accept?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">אנחנו מקבלים העברה בנקאית, כרטיסי אשראי (ויזה, מסטרקארד) ותשלום דרך ביט/פייבוקס. כל עסקה מאובטחת ומוצפנת.</span><span class="en">We accept bank transfers, credit cards (Visa, Mastercard) and payment via Bit/Paybox. Every transaction is secured and encrypted.</span></p>
        </div>
      </div>

      <div class="faq-item reveal" data-cat="booking">
        <button class="faq-q">
          <span class="he">מתי מקבלים אישור הזמנה?</span>
          <span class="en">When do I receive booking confirmation?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">רוב ההזמנות מאושרות תוך 15 דקות. לחבילות שדורשות תיאום עם ספקים (כמו יקבים פרטיים) — עד יום עסקים אחד. תמיד נעדכן אתכם בוואטסאפ.</span><span class="en">Most bookings are confirmed within 15 minutes. For packages requiring supplier coordination (such as private wineries) — up to one business day. We always update you via WhatsApp.</span></p>
        </div>
      </div>

      <!-- FLIGHTS -->
      <div class="faq-item reveal" data-cat="flights">
        <button class="faq-q">
          <span class="he">האם החבילה כוללת טיסות?</span>
          <span class="en">Do packages include flights?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">חבילות הבסיס שלנו הן ללא טיסות — כך תוכלו להשוות ולהזמין טיסות בעצמכם במחיר הטוב ביותר. עם זאת, אנחנו שמחים לסייע בהמלצות על קווי טיסה וזמנים אופטימליים.</span><span class="en">Our base packages are flight-free — so you can compare and book flights yourself at the best price. However, we're happy to advise on airlines and optimal timings.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d1" data-cat="flights">
        <button class="faq-q">
          <span class="he">באיזה שדה תעופה נוחתים?</span>
          <span class="en">Which airport do we land at?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">שדה התעופה הבינלאומי של קישינב (KIV) הוא היחיד במולדובה. המרחק מהמרכז של קישינב הוא כ-13 ק"מ — נסיעה של כ-20 דקות בטקסי. אנחנו יכולים לארגן העברה מהשדה.</span><span class="en">Chișinău International Airport (KIV) is the only airport in Moldova. It's about 13 km from Chișinău city centre — roughly 20 minutes by taxi. We can arrange airport transfer.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d2" data-cat="flights">
        <button class="faq-q">
          <span class="he">האם יש טיסות ישירות מישראל?</span>
          <span class="en">Are there direct flights from Israel?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">כן! יש טיסות ישירות מתל אביב לקישינב עם מספר חברות תעופה, כולל וויז אייר. זמן הטיסה הוא כשעתיים וחצי. מומלץ להזמין מוקדם לקבלת המחירים הטובים ביותר.</span><span class="en">Yes! There are direct flights from Tel Aviv to Chișinău with several airlines, including Wizz Air. Flight time is about two and a half hours. We recommend booking early for the best prices.</span></p>
        </div>
      </div>

      <!-- HOTELS -->
      <div class="faq-item reveal" data-cat="hotels">
        <button class="faq-q">
          <span class="he">אילו מלונות כלולים בחבילות?</span>
          <span class="en">Which hotels are included in packages?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">אנחנו עובדים עם מלונות 3–5 כוכבים שבדקנו אישית. כל מלון עבר ביקורת מטעמנו — בדקנו חדרים, ארוחות בוקר, ניקיון ושירות. הרשימה המלאה זמינה בדף המלונות שלנו.</span><span class="en">We work with 3–5 star hotels we have personally inspected. Every hotel has undergone our review — we checked rooms, breakfast, cleanliness and service. The full list is on our hotels page.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d1" data-cat="hotels">
        <button class="faq-q">
          <span class="he">האם ניתן לבחור מלון ספציפי?</span>
          <span class="en">Can I choose a specific hotel?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">כן! ניתן לבחור מלון ספציפי מהרשימה שלנו, ואנחנו נתאים את החבילה בהתאם. אם יש מלון שלא ברשימה ואתם רוצים להתארח בו — נבדוק ונחזור אליכם.</span><span class="en">Yes! You can select a specific hotel from our list and we'll tailor the package accordingly. If there's a hotel not on our list that you'd like — we'll check it and get back to you.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d2" data-cat="hotels">
        <button class="faq-q">
          <span class="he">האם ארוחת בוקר כלולה?</span>
          <span class="en">Is breakfast included?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">ברוב החבילות ארוחת הבוקר כלולה. בדף כל חבילה מופיע מה בדיוק כלול. חבילות ה-VIP כוללות גם ארוחת ערב בנקודות המומלצות שלנו.</span><span class="en">Most packages include breakfast. Each package page specifies exactly what's included. VIP packages also include dinner at our recommended spots.</span></p>
        </div>
      </div>

      <!-- CANCELLATION -->
      <div class="faq-item reveal" data-cat="cancel">
        <button class="faq-q">
          <span class="he">מה מדיניות הביטול?</span>
          <span class="en">What is the cancellation policy?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">ביטול חינם עד 14 יום לפני הנסיעה — החזר מלא ללא עמלות. בין 7–14 יום — החזר של 50%. פחות מ-7 ימים — אין החזר כספי, אבל ניתן לדחות את הנסיעה ללא עלות פעם אחת.</span><span class="en">Free cancellation up to 14 days before travel — full refund with no fees. Between 7–14 days — 50% refund. Less than 7 days — no refund, but you can postpone the trip once at no extra cost.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d1" data-cat="cancel">
        <button class="faq-q">
          <span class="he">האם ניתן לשנות תאריכים לאחר ההזמנה?</span>
          <span class="en">Can I change dates after booking?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">כן, ניתן לשנות תאריכים פעם אחת ללא עמלה, עד 10 ימים לפני הנסיעה, בכפוף לזמינות. שינוי שני ואילך כרוך בעמלת שינוי של 50₪.</span><span class="en">Yes, you can change dates once at no charge, up to 10 days before travel, subject to availability. A second change or more incurs a ₪50 amendment fee.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d2" data-cat="cancel">
        <button class="faq-q">
          <span class="he">מה קורה אם הטיסה בוטלה?</span>
          <span class="en">What happens if my flight is cancelled?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">אם הטיסה בוטלה על ידי חברת התעופה — תקבלו החזר מלא על החבילה שלנו ללא כל עמלה. אנחנו כאן לסייע גם בתהליך מול חברת התעופה.</span><span class="en">If the flight is cancelled by the airline — you will receive a full refund on our package with no fees. We're here to assist with the process against the airline too.</span></p>
        </div>
      </div>

      <!-- GENERAL -->
      <div class="faq-item reveal" data-cat="general">
        <button class="faq-q">
          <span class="he">האם צריך ויזה לכניסה למולדובה?</span>
          <span class="en">Do I need a visa to enter Moldova?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">אזרחי ישראל פטורים מויזה לכניסה למולדובה לתקופה של עד 90 יום. מספיק דרכון בתוקף ל-6 חודשים לפחות מתאריך הכניסה. אין צורך בשום אישור מיוחד.</span><span class="en">Israeli citizens are visa-exempt for entry to Moldova for up to 90 days. A passport valid for at least 6 months from the entry date is sufficient. No special permit is required.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d1" data-cat="general">
        <button class="faq-q">
          <span class="he">מה המטבע ואיך מומלץ לשלם?</span>
          <span class="en">What is the currency and how should I pay?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">המטבע הרשמי הוא ליי מולדובני (MDL). מומלץ להביא מזומן דולר או יורו ולהמיר במולדובה — הקורס שם טוב יותר. רוב המסעדות והמלונות מקבלים גם כרטיסי אשראי.</span><span class="en">The official currency is the Moldovan Leu (MDL). We recommend bringing cash in USD or EUR and exchanging in Moldova — the rate there is better. Most restaurants and hotels also accept credit cards.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d2" data-cat="general">
        <button class="faq-q">
          <span class="he">האם מולדובה בטוחה לתיירים?</span>
          <span class="en">Is Moldova safe for tourists?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">מולדובה נחשבת לאחת המדינות הבטוחות ביותר באירופה לתיירים. קישינב היא עיר שקטה ומסודרת. מ-2018 שלחנו אלפי לקוחות ולא היה אף אירוע ביטחוני. תמיד יש לנו נציג מקומי זמין 24/7.</span><span class="en">Moldova is considered one of the safest countries in Europe for tourists. Chișinău is a quiet, orderly city. Since 2018 we've sent thousands of customers with zero security incidents. We always have a local representative available 24/7.</span></p>
        </div>
      </div>

      <div class="faq-item reveal" data-cat="general">
        <button class="faq-q">
          <span class="he">מה מזג האוויר במולדובה?</span>
          <span class="en">What is the weather like in Moldova?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">אקלים ארבעת העונות. הקיץ (יוני–אוגוסט) חם ומושלם לבילוי חוץ — 25–35°. האביב והסתיו נעימים מאוד. החורף יכול להיות קר. עונת השיא שלנו היא מאפריל עד אוקטובר.</span><span class="en">Four-season climate. Summer (June–August) is warm and perfect for outdoor activities — 25–35°C. Spring and autumn are very pleasant. Winter can be cold. Our peak season is April to October.</span></p>
        </div>
      </div>

      <div class="faq-item reveal d1" data-cat="general">
        <button class="faq-q">
          <span class="he">האם יש SIM מקומי לתיירים?</span>
          <span class="en">Is there a local SIM for tourists?</span>
          <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-a">
          <p><span class="he">כן! ניתן לרכוש SIM מקומי בשדה התעופה או בחנויות תקשורת בעיר. כרטיס של 7 ימים עם 10GB עולה כ-5 דולר. אנחנו ממליצים על אורנג' מולדובה או מולדסל.</span><span class="en">Yes! You can purchase a local SIM at the airport or communication shops in the city. A 7-day card with 10GB costs about $5. We recommend Orange Moldova or Moldcell.</span></p>
        </div>
      </div>

      <?php endif; ?>
    </div><!-- /faq-list -->
  </div>
</section>

<!-- Still have questions -->
<section class="section alt">
  <div class="container">
    <div class="promo-strip">
      <div class="promo-bg"></div>
      <div class="promo-orb" style="width:260px;height:260px;top:-70px;right:-50px"></div>
      <div style="position:relative;z-index:1">
        <h3><span class="he">לא מצאתם תשובה?</span><span class="en">Didn't find an answer?</span></h3>
        <p><span class="he">הצוות שלנו זמין בוואטסאפ ומשיב תוך דקות.</span><span class="en">Our team is available on WhatsApp and responds within minutes.</span></p>
      </div>
      <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>" target="_blank" rel="noopener" class="btn btn-cta" style="position:relative;z-index:1">
        <span class="he">שלחו הודעה ←</span><span class="en">Send a message →</span>
      </a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
<script>
(function(){
  // FAQ category filter
  const catBtns = document.querySelectorAll('.faq-cat-btn');
  const faqItems = document.querySelectorAll('.faq-item[data-cat]');
  catBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      catBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const cat = btn.dataset.cat;
      faqItems.forEach(item => {
        item.style.display = (cat === 'all' || item.dataset.cat === cat) ? '' : 'none';
      });
    });
  });
})();
</script>
