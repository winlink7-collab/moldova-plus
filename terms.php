<?php
require_once 'includes/functions.php';
require_once 'includes/data.php';
require_once 'includes/mp_settings.php';

[$lang, $t] = page_init('terms');
$page = 'terms';

page_head(
    $lang==='he' ? 'תקנון ותנאי שימוש — Moldova Plus' : 'Terms & Conditions — Moldova Plus',
    $lang==='he' ? 'תנאי השימוש, מדיניות הביטולים ותנאי ההזמנה של Moldova Plus.' : 'Terms of use, cancellation policy and booking conditions of Moldova Plus.',
    $lang
);
?>
<?php include 'includes/header.php'; ?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <div class="crumbs">
      <a href="index.php<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">בית</span><span class="en">Home</span></a> /
      <span class="cur he">תקנון</span><span class="cur en">Terms</span>
    </div>
    <h1>
      <span class="he">תקנון ותנאי <span>שימוש</span></span>
      <span class="en">Terms & <span>Conditions</span></span>
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
        <span class="he">ברוכים הבאים ל-Moldova Plus. השימוש באתר ובשירותים שלנו כפוף לתנאים המפורטים להלן. אנא קראו אותם בעיון לפני ביצוע הזמנה.</span>
        <span class="en">Welcome to Moldova Plus. Use of our website and services is subject to the terms detailed below. Please read them carefully before making a booking.</span>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">1. כללי</span>
          <span class="en">1. General</span>
        </h2>
        <p><span class="he">Moldova Plus היא חברת תיירות ישראלית המתמחה בחבילות נופש למולדובה. בעצם ביצוע הזמנה דרך האתר, בוואטסאפ או בטלפון, הלקוח מאשר את קריאתו והסכמתו לתנאי תקנון זה.</span><span class="en">Moldova Plus is an Israeli tourism company specialising in vacation packages to Moldova. By placing a booking through the website, WhatsApp or phone, the customer confirms having read and accepted these terms.</span></p>
        <p><span class="he">כל הזמנה כפופה לחוק שירותי תיירות, התשל"ו-1976 ולחקיקה הישראלית הרלוונטית.</span><span class="en">Every booking is subject to the Tourism Services Law, 5736–1976 and relevant Israeli legislation.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">2. אישור הזמנה</span>
          <span class="en">2. Booking Confirmation</span>
        </h2>
        <p><span class="he">הזמנה תיחשב מאושרת רק לאחר קבלת אישור בכתב מ-Moldova Plus ולאחר ביצוע תשלום מקדמה. אישור בעל פה אינו מחייב את החברה.</span><span class="en">A booking is considered confirmed only after receiving written confirmation from Moldova Plus and after making a deposit payment. Verbal confirmation is not binding on the company.</span></p>
        <p><span class="he">אישור ההזמנה יישלח ל-SMS ו/או לאימייל ו/או לוואטסאפ תוך 4 שעות מביצוע ההזמנה בימי עסקים.</span><span class="en">Booking confirmation will be sent by SMS and/or email and/or WhatsApp within 4 hours of booking on business days.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">3. מחירים ותשלום</span>
          <span class="en">3. Prices & Payment</span>
        </h2>
        <p><span class="he">כל המחירים המוצגים באתר כוללים מע"מ ישראלי ועמלות שירות. אין עמלות נסתרות. מחירי החבילות נקובים לאדם ומבוססים על תפוסה כפולה בחדר, אלא אם צוין אחרת.</span><span class="en">All prices shown on the website include Israeli VAT and service fees. There are no hidden fees. Package prices are per person based on double-room occupancy unless otherwise stated.</span></p>
        <p><span class="he">תשלום מקדמה בשיעור 30% מסכום העסקה נדרש לאישור ההזמנה. יתרת התשלום תשולם לא יאוחר מ-14 ימים לפני מועד הנסיעה.</span><span class="en">A 30% deposit of the total is required to confirm the booking. The balance must be paid no later than 14 days before the travel date.</span></p>
        <p><span class="he">Moldova Plus שומרת לעצמה את הזכות לעדכן מחירים עקב שינויים בשערי חליפין, עלויות ספקים או מסים חדשים. לקוח שאישר הזמנה לא ייפגע משינויי מחיר שיחולו לאחר אישורו.</span><span class="en">Moldova Plus reserves the right to update prices due to exchange rate changes, supplier costs or new taxes. A customer who has confirmed a booking will not be affected by price changes occurring after confirmation.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">4. מדיניות ביטולים</span>
          <span class="en">4. Cancellation Policy</span>
        </h2>
        <div class="policy-table">
          <table>
            <thead>
              <tr>
                <th><span class="he">זמן הביטול לפני הנסיעה</span><span class="en">Cancellation time before travel</span></th>
                <th><span class="he">החזר כספי</span><span class="en">Refund</span></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="he">יותר מ-14 ימים</span><span class="en">More than 14 days</span></td>
                <td class="good"><span class="he">החזר מלא</span><span class="en">Full refund</span></td>
              </tr>
              <tr>
                <td><span class="he">7–14 ימים</span><span class="en">7–14 days</span></td>
                <td class="mid"><span class="he">החזר 50%</span><span class="en">50% refund</span></td>
              </tr>
              <tr>
                <td><span class="he">פחות מ-7 ימים</span><span class="en">Less than 7 days</span></td>
                <td class="bad"><span class="he">אין החזר (ניתן לדחות פעם אחת)</span><span class="en">No refund (one postponement allowed)</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <p><span class="he">ביטול יש לבצע בכתב (וואטסאפ / אימייל). תאריך הביטול הקובע הוא תאריך קבלת ההודעה על ידי Moldova Plus בשעות העסקים.</span><span class="en">Cancellation must be made in writing (WhatsApp / email). The determining date is when Moldova Plus receives the notice during business hours.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">5. שינויים בהזמנה</span>
          <span class="en">5. Booking Changes</span>
        </h2>
        <p><span class="he">שינוי תאריכים מותר פעם אחת ללא עמלה, עד 10 ימים לפני הנסיעה, בכפוף לזמינות. שינוי שני ואילך כרוך בעמלת שינוי של 50 ₪. Moldova Plus אינה אחראית לפערי מחיר הנובעים משינויים.</span><span class="en">Date changes are permitted once at no charge, up to 10 days before travel, subject to availability. A second or further change incurs a ₪50 amendment fee. Moldova Plus is not responsible for price differences arising from changes.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">6. אחריות ומגבלות</span>
          <span class="en">6. Liability & Limitations</span>
        </h2>
        <p><span class="he">Moldova Plus פועלת כסוכנות תיירות ואינה אחראית ישירות לשירותי ספקי משנה (מלונות, חברות תעופה, יקבים). בעיות עם ספקים ייטופלו על ידינו כמתווכים.</span><span class="en">Moldova Plus operates as a travel agency and is not directly responsible for sub-supplier services (hotels, airlines, wineries). Issues with suppliers will be handled by us as intermediaries.</span></p>
        <p><span class="he">Moldova Plus לא תישא באחריות לנזק שנגרם עקב כוח עליון — מלחמות, אסונות טבע, שביתות, מגיפות וגורמים שאינם בשליטתה.</span><span class="en">Moldova Plus will not be liable for damage caused by force majeure — wars, natural disasters, strikes, epidemics and factors beyond its control.</span></p>
        <p><span class="he">מומלץ לרכוש ביטוח נסיעות מקיף הכולל כיסוי לביטול טיול, אובדן כבודה ורפואה. Moldova Plus אינה מחייבת אך ממליצה בחום.</span><span class="en">We recommend purchasing comprehensive travel insurance covering trip cancellation, baggage loss and medical. Moldova Plus does not require but strongly recommends this.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">7. קניין רוחני</span>
          <span class="en">7. Intellectual Property</span>
        </h2>
        <p><span class="he">כל תוכן האתר — טקסטים, תמונות, עיצוב וקוד — הוא קניינה הבלעדי של Moldova Plus. אין להעתיק, לשכפל או להשתמש בתכנים ללא רשות מפורשת בכתב.</span><span class="en">All website content — texts, images, design and code — is the exclusive property of Moldova Plus. No copying, duplicating or using content without explicit written permission.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">8. יישוב סכסוכים</span>
          <span class="en">8. Dispute Resolution</span>
        </h2>
        <p><span class="he">כל סכסוך שיתעורר בין הצדדים יובא תחילה לבוררות ידידותית. אם לא הגיעו להסכמה תוך 30 יום — הסמכות השיפוטית הבלעדית תהיה לבתי המשפט של תל אביב–יפו, בהתאם לדין הישראלי.</span><span class="en">Any dispute arising between the parties shall first be brought to friendly arbitration. If no agreement is reached within 30 days — exclusive jurisdiction shall be with the courts of Tel Aviv–Yafo, under Israeli law.</span></p>
      </div>

      <div class="policy-section">
        <h2>
          <span class="he">9. יצירת קשר</span>
          <span class="en">9. Contact</span>
        </h2>
        <p><span class="he">לכל שאלה הנוגעת לתנאי השימוש:</span><span class="en">For any question regarding these terms:</span></p>
        <p>
          <a href="mailto:<?= mp_s('email','hello@moldovaplus.com') ?>" style="color:var(--flag-blue)"><?= mp_s('email','hello@moldovaplus.com') ?></a><br>
          <a href="https://wa.me/<?= mp_sr('whatsapp','972355501880') ?>" style="color:var(--flag-blue)">WhatsApp: +<?= mp_s('phone_display','+972 35-550-1880') ?></a>
        </p>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<?php page_foot(); ?>
