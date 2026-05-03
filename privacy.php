<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';

[$lang, $t] = page_init('privacy');
$page = 'privacy';

page_head(
    $lang==='he' ? 'מדיניות פרטיות — Moldova Plus' : 'Privacy Policy — Moldova Plus',
    $lang==='he' ? 'כיצד Moldova Plus אוספת, משתמשת ומגנה על המידע האישי שלכם.' : 'How Moldova Plus collects, uses and protects your personal information.',
    $lang
);
?>
<?php include 'includes/header.php'; ?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="/<?= $lang!=='he'?'?lang='.$lang:'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur he">מדיניות פרטיות</span><span class="cur en">Privacy Policy</span>
    </div>
    <h1>
      <span class="he">מדיניות <span>פרטיות</span></span>
      <span class="en">Privacy <span>Policy</span></span>
    </h1>
    <p>
      <span class="he">עודכן לאחרונה: ינואר 2025</span>
      <span class="en">Last updated: January 2025</span>
    </p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="policy-body">

      <div class="policy-intro">
        <span class="he">Moldova Plus מחויבת לשמירה על פרטיותכם. מדיניות זו מסבירה אילו נתונים אנחנו אוספים, כיצד אנו משתמשים בהם ואת זכויותיכם.</span>
        <span class="en">Moldova Plus is committed to protecting your privacy. This policy explains what data we collect, how we use it and your rights.</span>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">1. מידע שאנחנו אוספים</span>
          <span class="en">1. Information We Collect</span>
        </h2>
        <p><span class="he">אנו אוספים מידע שאתם מספקים לנו ישירות:</span><span class="en">We collect information you provide to us directly:</span></p>
        <ul>
          <li><span class="he">שם מלא, מספר טלפון, כתובת אימייל</span><span class="en">Full name, phone number, email address</span></li>
          <li><span class="he">פרטי הזמנה — תאריכים, העדפות, מספר נוסעים</span><span class="en">Booking details — dates, preferences, number of travellers</span></li>
          <li><span class="he">פרטי תשלום (מעובדים על ידי גורם צד שלישי מאובטח)</span><span class="en">Payment details (processed by a secure third-party provider)</span></li>
          <li><span class="he">תכתובות שיחה בוואטסאפ ואימייל</span><span class="en">WhatsApp and email correspondence</span></li>
        </ul>
        <p><span class="he">בנוסף, אנו אוספים אוטומטית מידע טכני כגון כתובת IP, סוג דפדפן ודפים שנצפו, לצורכי אנליטיקה ואבטחה.</span><span class="en">Additionally, we automatically collect technical information such as IP address, browser type and pages viewed, for analytics and security purposes.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">2. כיצד אנחנו משתמשים במידע</span>
          <span class="en">2. How We Use the Information</span>
        </h2>
        <ul>
          <li><span class="he">עיבוד ואישור הזמנות</span><span class="en">Processing and confirming bookings</span></li>
          <li><span class="he">תקשורת לפני, במהלך ואחרי הנסיעה</span><span class="en">Communication before, during and after the trip</span></li>
          <li><span class="he">שליחת עדכונים, מבצעים וניוזלטר (ניתן לביטול בכל עת)</span><span class="en">Sending updates, promotions and newsletter (can be unsubscribed at any time)</span></li>
          <li><span class="he">שיפור השירותים וחוויית המשתמש באתר</span><span class="en">Improving services and user experience on the website</span></li>
          <li><span class="he">עמידה בדרישות חוקיות ורגולטוריות</span><span class="en">Compliance with legal and regulatory requirements</span></li>
        </ul>
        <p><span class="he">אנחנו לא מוכרים, משכירים או מעבירים את פרטיכם לצדדים שלישיים לצרכי שיווק.</span><span class="en">We do not sell, rent or transfer your details to third parties for marketing purposes.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">3. שיתוף מידע עם צדדים שלישיים</span>
          <span class="en">3. Sharing Information with Third Parties</span>
        </h2>
        <p><span class="he">אנו משתפים מידע רק במקרים הבאים:</span><span class="en">We share information only in the following cases:</span></p>
        <ul>
          <li><span class="he"><strong>ספקי שירות:</strong> מלונות, יקבים וגורמים אחרים הדרושים לביצוע ההזמנה</span><span class="en"><strong>Service providers:</strong> Hotels, wineries and other parties required to fulfil the booking</span></li>
          <li><span class="he"><strong>עיבוד תשלומים:</strong> ספק סליקה מאובטח בהתאם לתקן PCI-DSS</span><span class="en"><strong>Payment processing:</strong> A secure payment processor complying with PCI-DSS standard</span></li>
          <li><span class="he"><strong>חובה חוקית:</strong> אם נדרש על פי חוק או צו בית משפט</span><span class="en"><strong>Legal obligation:</strong> If required by law or court order</span></li>
        </ul>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">4. אבטחת מידע</span>
          <span class="en">4. Data Security</span>
        </h2>
        <p><span class="he">אנחנו מיישמים אמצעי אבטחה מתקדמים: הצפנת SSL על כל העברות הנתונים, גישה מוגבלת למידע אישי לצוות המורשה בלבד, ואחסון מאובטח בשרתים המוגנים.</span><span class="en">We implement advanced security measures: SSL encryption on all data transfers, restricted access to personal data for authorised staff only, and secure storage on protected servers.</span></p>
        <p><span class="he">פרטי כרטיסי אשראי אינם נשמרים על שרתינו — עיבוד כרטיסים מתבצע ישירות אצל ספק הסליקה.</span><span class="en">Credit card details are not stored on our servers — card processing is done directly with the payment provider.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">5. עוגיות (Cookies)</span>
          <span class="en">5. Cookies</span>
        </h2>
        <p><span class="he">האתר שלנו משתמש בעוגיות לצורכי:</span><span class="en">Our website uses cookies for:</span></p>
        <ul>
          <li><span class="he">שמירת העדפת שפה</span><span class="en">Saving language preference</span></li>
          <li><span class="he">שמירת רשימת מועדפים</span><span class="en">Saving favourites list</span></li>
          <li><span class="he">אנליטיקה אנונימית לשיפור האתר (Google Analytics)</span><span class="en">Anonymous analytics to improve the site (Google Analytics)</span></li>
        </ul>
        <p><span class="he">ניתן לחסום עוגיות דרך הגדרות הדפדפן. חסימת עוגיות עשויה לפגוע בחלק מפונקציות האתר.</span><span class="en">Cookies can be blocked through browser settings. Blocking cookies may impair some site functions.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">6. זכויותיכם</span>
          <span class="en">6. Your Rights</span>
        </h2>
        <p><span class="he">בהתאם לחוק הגנת הפרטיות, התשמ"א-1981, יש לכם את הזכויות הבאות:</span><span class="en">Under the Privacy Protection Law, 5741–1981, you have the following rights:</span></p>
        <ul>
          <li><span class="he">לעיין במידע שנשמר עליכם</span><span class="en">To review information stored about you</span></li>
          <li><span class="he">לתקן מידע שגוי</span><span class="en">To correct inaccurate information</span></li>
          <li><span class="he">לבקש מחיקת המידע (בכפוף לחובות חוקיות)</span><span class="en">To request deletion of information (subject to legal obligations)</span></li>
          <li><span class="he">לבטל הסכמה לקבלת תוכן שיווקי בכל עת</span><span class="en">To withdraw consent to marketing content at any time</span></li>
        </ul>
        <p><span class="he">לממש את זכויותיכם — פנו אלינו בכתב ל: <a href="mailto:privacy@moldovaplus.com" style="color:var(--flag-blue)">privacy@moldovaplus.com</a></span><span class="en">To exercise your rights — contact us in writing at: <a href="mailto:privacy@moldovaplus.com" style="color:var(--flag-blue)">privacy@moldovaplus.com</a></span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">7. שמירת מידע</span>
          <span class="en">7. Data Retention</span>
        </h2>
        <p><span class="he">אנו שומרים מידע הקשור להזמנות למשך 7 שנים בהתאם לדרישות חשבונאיות וחוקיות. מידע שיווקי נמחק על פי בקשה.</span><span class="en">We retain information related to bookings for 7 years in accordance with accounting and legal requirements. Marketing information is deleted upon request.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">8. עדכוני מדיניות</span>
          <span class="en">8. Policy Updates</span>
        </h2>
        <p><span class="he">אנחנו עשויים לעדכן מדיניות זו מעת לעת. שינויים מהותיים יפורסמו באתר ויישלח עליהם הודעה למשתמשים רשומים. המשך שימוש באתר לאחר פרסום השינויים מהווה הסכמה אליהם.</span><span class="en">We may update this policy from time to time. Material changes will be published on the site and registered users will be notified. Continued use of the site after changes are published constitutes agreement to them.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">9. יצירת קשר בנושא פרטיות</span>
          <span class="en">9. Privacy Contact</span>
        </h2>
        <p><span class="he">לשאלות, בקשות או תלונות בנושא פרטיות:</span><span class="en">For questions, requests or complaints about privacy:</span></p>
        <p>
          <a href="mailto:privacy@moldovaplus.com" style="color:var(--flag-blue)">privacy@moldovaplus.com</a><br>
          <span class="he">Moldova Plus, רחוב הברזל 3, תל אביב–יפו 6971019</span>
          <span class="en">Moldova Plus, 3 HaBarzel St, Tel Aviv–Yafo 6971019</span>
        </p>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
