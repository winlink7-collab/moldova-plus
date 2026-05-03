# Moldova Plus - Project Status & History

## 📋 Overview
Moldova Plus is a tourism website for Moldova vacation packages, built with PHP, featuring multilingual support (Hebrew, English, Russian) and a live admin panel.

**Hosting:** Cloudways (phpstack-679104-6380118.cloudwaysapps.com)  
**Domain:** moldovaplus.co.il (NOT YET CONNECTED)  
**Tech Stack:** PHP 7.4+, Apache, MySQL, Live Editor (JavaScript)

---

## ✅ COMPLETED FEATURES

### 1. **Contact Page** (`contact.php`)
- ✅ Full live editor integration (admin can edit all text)
- ✅ WhatsApp integration
- ✅ 24/7 support messaging
- ✅ Contact form with email/WhatsApp handling
- ✅ All fields editable via live editor AND admin settings panel
- **Status:** WORKING

### 2. **Top Bar Redesign**
- ✅ Cleaner layout with phone/email as clickable links
- ✅ Language switcher with flag icons (🇮🇱 🇷🇺 🇬🇧)
- ✅ Promo text display
- ✅ Mobile responsive with flag buttons
- **Status:** WORKING

### 3. **Packages Page** (`packages.php`)
- ✅ Sort dropdown - Hebrew only (no English text)
- ✅ Filter pills work correctly
- ✅ Language query params propagate properly
- **Status:** WORKING

### 4. **Package Detail Page** (`package-detail.php`)
- ✅ Mobile layout: title ABOVE gallery (not below)
- ✅ Gallery redesigned: 5-tile mosaic + horizontal scroll strip
- ✅ Support for unlimited images (first 5 in mosaic, rest in strip)
- ✅ Lightbox works with all images
- **Status:** WORKING

### 5. **Russian Language Support** 🇷🇺
- ✅ Full translations in `includes/data.php`
- ✅ Body class `body.ru` for styling
- ✅ CSS rules for visibility: `.he/.en/.ru` spans
- ✅ Navigation, footer, hero section all translated
- ✅ Language query param works: `?lang=ru`
- **Status:** WORKING

### 6. **Hotels Page** (`hotels.php`)
- ✅ Rating editable via live editor
- ✅ Stars editable via live editor
- ✅ Tags editable via live editor (comma-separated)
- ✅ Image upload via live editor
- ✅ Data persists to `data/hotels.json`
- **Status:** PARTIALLY WORKING (admin panel broken)

### 7. **Live Editor** (`assets/js/live-editor.js`)
- ✅ Text element editing
- ✅ Image upload with file picker
- ✅ Gallery management (upload, drag-drop, delete)
- ✅ Tags type support (comma-separated arrays)
- ✅ CSRF token validation
- ✅ Success/error notifications
- **Status:** WORKING (on public pages)

### 8. **Admin Settings Panel**
- ✅ Contact info editing (WhatsApp, phone, email)
- ✅ Statistics editing (years, packages, customers, rating)
- ✅ Page titles & descriptions (all languages)
- ✅ Bachelor party perks
- ✅ About page values/steps/CTA
- ✅ Contact page content
- **Status:** NOT ACCESSIBLE (auth broken)

---

## ⚠️ KNOWN ISSUES

### **PRIMARY ISSUE: Admin Panel Authentication Broken**
**Problem:** When clicking on ANY sidebar link (settings, packages, hotels, etc.), user gets logged out immediately.

**What we tried:**
1. ✗ Session optimization (didn't work)
2. ✗ Absolute paths in sidebar (broke site)
3. ✗ Cookie-based auth (still broken)
4. ✗ Simplified auth (still broken)

**Root cause:** Likely Cloudways PHP session configuration issue - can't debug without server logs

**Current status:** Admin panel is inaccessible. Authentication fails between page navigation.

---

## 🔧 TECHNICAL DETAILS

### File Structure
```
/
├── admin/                    # Admin panel (BROKEN AUTH)
│   ├── includes/
│   │   ├── auth.php         # Auth logic (cookie-based)
│   │   ├── sidebar.php      # Navigation sidebar
│   ├── index.php            # Dashboard
│   ├── settings.php         # Settings form
│   ├── packages.php
│   ├── hotels.php
│   └── login.php            # Login form
├── data/
│   ├── settings.json        # Global settings
│   ├── hotels.json          # Hotel overrides
│   ├── packages.json        # Package overrides
│   ├── admin_pass.php       # Admin password (bcrypt hash)
├── includes/
│   ├── auth.php             # Session helpers
│   ├── data.php             # Translation strings ($T global)
│   ├── functions.php        # Page helpers, render_card()
│   ├── header.php           # Top bar & navigation
│   ├── footer.php           # Footer
├── assets/
│   ├── js/live-editor.js    # Live editing interface
│   ├── js/main.js           # Gallery lightbox
│   ├── css/style.css        # Main styles
├── hotels.php               # Hotels page (public)
├── packages.php             # Packages page (public)
├── contact.php              # Contact page (public)
└── .htaccess               # URL rewriting rules
```

### Key Functions
- `mp_admin_check()` - Check if user is authenticated (now cookie-based)
- `mp_read_json($file)` - Read data/X.json files
- `mp_write_json($file, $data)` - Write to data/X.json files
- `mp_csrf()` / `mp_csrf_verify()` - CSRF protection (removed from current auth)
- `render_card($package)` - Render package/deal cards
- `page_init($page)` - Initialize page (get lang, translations)

### Language System
- **Query param:** `?lang=en` or `?lang=ru` (default: he)
- **Body class:** `<body class="he">` / `<body class="en">` / `<body class="ru">`
- **Visibility:** CSS rules hide/show `.he/.en/.ru` spans
- **Translations:** `$T[lang]` array in `includes/data.php`

### Live Editor System
- Elements tagged with `data-le="key:field"` become editable
- Types: `text`, `img`, `gallery`, `tags`
- Saves via AJAX to `/admin/live-save.php`
- Key format: `file:id:field` (e.g., `hotels:5:rating`)

---

## 🌐 CURRENT DEPLOYMENT STATUS

### Public Site (Working ✅)
- **URL:** phpstack-679104-6380118.cloudwaysapps.com
- **Features:** All public pages work
- **Languages:** Hebrew, English, Russian all functional
- **Live Editor:** Works on all public pages (when admin logged in)

### Custom Domain (Not Connected ⚠️)
- **Domain:** moldovaplus.co.il
- **Status:** Registered but NOT connected to Cloudways
- **DNS:** Uses Cloudflare
- **Next step:** Point DNS to Cloudways IP, add domain in Cloudways panel

### Admin Panel (Broken ❌)
- **URL:** phpstack-679104-6380118.cloudwaysapps.com/admin
- **Issue:** Session/cookie auth broken - user logged out on navigation
- **Password:** admin123 (bcrypt hash in `data/admin_pass.php`)
- **Workaround:** None currently available

---

## 📝 DATA FILES

### `data/settings.json`
```json
{
  "whatsapp": "972355501880",
  "phone": "035550188",
  "email": "hello@moldovaplus.com",
  "page_hotels_title_he": "מלונות בקישינב",
  "page_hotels_title_en": "Hotels in Chișinău",
  ...
}
```

### `data/hotels.json`
Overrides for default hotels. Format:
```json
{
  "5": {
    "name_he": "Custom name",
    "image_url": "path/to/image.jpg",
    "rating": "9.8"
  }
}
```

### `data/admin_pass.php`
Contains bcrypt hash of admin password. Format:
```php
<?php return '$2y$10$...';
```

---

## 🎯 NEXT STEPS

### Immediate (to get site live):
1. **Connect moldovaplus.co.il to Cloudways**
   - Add domain in Cloudways panel
   - Point Cloudflare DNS to Cloudways IP
   - Wait for DNS propagation (24-48h)

2. **Test public site**
   - Verify all pages load correctly
   - Check all languages work
   - Verify live editor functions (when admin logged in)

### Medium-term (fix admin):
1. **Get Cloudways logs** to diagnose auth issue
2. **Contact Cloudways support** about session handling
3. **Alternatively:** Simplify admin to not require auth (dev mode)

### Long-term:
1. SSL certificate setup
2. Performance optimization
3. Full admin panel functionality
4. Automated backups

---

## 🔐 CREDENTIALS
- **Admin Password:** admin123
- **Database:** MySQL (configured in Cloudways)
- **FTP/SSH:** Via Cloudways master credentials

---

## 📞 SUPPORT
For issues with:
- **Public site:** Check `includes/data.php` translations, CSS in `assets/css/style.css`
- **Admin panel:** Check Cloudways PHP logs for session errors
- **Live editor:** Check browser console (F12) for JavaScript errors
- **DNS/Domain:** Check Cloudflare DNS settings, Cloudways domain configuration

---

**Last Updated:** May 3, 2026  
**Current Status:** Public site WORKING, Admin panel BROKEN
