<?php
// footer.php
// Expects: $lang, $t
?>
<footer class="site-footer">
  <div class="container">
    <div class="foot-grid">
      <!-- About -->
      <div class="about">
        <a href="index.php" class="logo logo-light">
          <span class="logo-mark">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 19 L12 5 L19 19Z"/><path d="M9 14 L12 17 L15 14"/>
            </svg>
          </span>
          <span class="logo-word">
            <span class="l1">Moldova<span> Plus</span></span>
          </span>
        </a>
        <p>
          <span class="he"><?= $t['foot']['about'] ?></span>
          <span class="en"><?= htmlspecialchars($t['foot']['about']) ?></span>
        </p>
        <div class="foot-social">
          <a href="https://wa.me/972355501880" target="_blank" rel="noopener" title="WhatsApp" aria-label="WhatsApp">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          </a>
          <a href="mailto:hello@moldovaplus.com" title="Email" aria-label="Email">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
          </a>
          <a href="tel:+97235550188" title="Phone" aria-label="Phone">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7l.8 4a2 2 0 0 1-.6 1.9L7.6 11.4a16 16 0 0 0 6 6l1.8-1.7a2 2 0 0 1 1.9-.6l4 .8a2 2 0 0 1 1.7 2z"/></svg>
          </a>
        </div>
      </div>

      <!-- Packages -->
      <div>
        <h5><span class="he">חבילות</span><span class="en">Packages</span></h5>
        <ul>
          <li><a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">חבילות נופש</span><span class="en">Travel packages</span></a></li>
          <li><a href="bachelor.php<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">מסיבות רווקים</span><span class="en">Bachelor parties</span></a></li>
          <li><a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>#couples"><span class="he">חבילות זוגיות</span><span class="en">Couples</span></a></li>
          <li><a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>#wine"><span class="he">יקבים</span><span class="en">Wine tours</span></a></li>
          <li><a href="packages.php<?= $lang==='en'?'?lang=en':'' ?>#lux"><span class="he">יוקרה</span><span class="en">Luxury</span></a></li>
        </ul>
      </div>

      <!-- Attractions -->
      <div>
        <h5><span class="he">אטרקציות</span><span class="en">Attractions</span></h5>
        <ul>
          <li><a href="attractions.php<?= $lang==='en'?'?lang=en':'' ?>"><span class="he">יקבים</span><span class="en">Wineries</span></a></li>
          <li><a href="attractions.php<?= $lang==='en'?'?lang=en':'' ?>#culture"><span class="he">תרבות</span><span class="en">Culture</span></a></li>
          <li><a href="attractions.php<?= $lang==='en'?'?lang=en':'' ?>#adrenaline"><span class="he">אדרנלין</span><span class="en">Adrenaline</span></a></li>
          <li><a href="attractions.php<?= $lang==='en'?'?lang=en':'' ?>#food"><span class="he">מסעדות</span><span class="en">Restaurants</span></a></li>
          <li><a href="attractions.php<?= $lang==='en'?'?lang=en':'' ?>#nightlife"><span class="he">חיי לילה</span><span class="en">Nightlife</span></a></li>
        </ul>
      </div>

      <!-- Info -->
      <div>
        <h5><span class="he">מידע</span><span class="en">Info</span></h5>
        <ul>
          <li><a href="#"><span class="he">אודות</span><span class="en">About</span></a></li>
          <li><a href="#"><span class="he">שאלות נפוצות</span><span class="en">FAQ</span></a></li>
          <li><a href="#"><span class="he">תקנון</span><span class="en">Terms</span></a></li>
          <li><a href="#"><span class="he">מדיניות פרטיות</span><span class="en">Privacy</span></a></li>
          <li><a href="#"><span class="he">צור קשר</span><span class="en">Contact</span></a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="foot-newsletter">
        <h5><span class="he">הצטרפו למועדון</span><span class="en">Join the club</span></h5>
        <p>
          <span class="he">הטבות, מבצעים וגישה מוקדמת לחבילות חדשות.</span>
          <span class="en">Perks, deals and early access to new packages.</span>
        </p>
        <form class="nl-form" onsubmit="return false">
          <input type="email" placeholder="<?= $lang==='he'?'כתובת אימייל':'Email address' ?>" autocomplete="email">
          <button type="submit">
            <span class="he">הרשמה</span>
            <span class="en">Subscribe</span>
          </button>
        </form>
      </div>
    </div>

    <div class="foot-base">
      <span>
        <span class="he"><?= $t['foot']['copy'] ?></span>
        <span class="en"><?= htmlspecialchars($t['foot']['copy']) ?></span>
      </span>
      <div class="foot-trust">
        <span>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 3v6c0 5-3.5 9.5-8 11-4.5-1.5-8-6-8-11V5l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
          <span class="he">תשלום מאובטח</span><span class="en">Secure payment</span>
        </span>
        <span>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
          <span class="he">אמינות מעל הכל</span><span class="en">Trusted since 2018</span>
        </span>
      </div>
    </div>
  </div>
</footer>

<!-- WhatsApp floating button -->
<a href="https://wa.me/972355501880" target="_blank" rel="noopener" class="wa-float" id="wa-float">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.124 1.525 5.858L.057 23.5l5.797-1.516A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.663-.49-5.207-1.348l-.374-.218-3.44.9.924-3.35-.239-.386A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
  <span class="he">שלחו הודעה</span>
  <span class="en">Message us</span>
</a>

<!-- Back to top -->
<button class="back-top" id="back-top" aria-label="חזרה למעלה">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
</button>
