// data.jsx — content + i18n

const T = {
  he: {
    nights: 'לילות',
    from: 'החל מ',
    nav:{ home:'בית', packages:'חבילות נופש', bachelor:'מסיבות רווקים', attractions:'אטרקציות' },
    hero:{
      kicker:'יעד #1 לחבילות מולדובה',
      h1:['חוויית מולדובה','מתחילה כאן.'],
      sub:'פורטל ההזמנות הגדול בישראל לחבילות נופש בקישינב — מסיבות רווקים, חוויות יוקרה ויקבים מובילים. מחירים שקופים, אישור מיידי.',
      pkgs:'1,200+ חבילות', verified:'ביקורות מאומתות', best:'מחיר הטוב ביותר',
    },
    search:{ where:'לאן?', whereV:'קישינב, מולדובה', when:'מתי?', whenV:'הוסיפו תאריכים', who:'כמה?', whoV:'2 אורחים', type:'סוג חבילה', typeV:'הכל', go:'חיפוש' },
    foot:{ about:'הפורטל הגדול בישראל לחבילות מולדובה. כל חבילה עוברת בדיקה — מקומות שלא הוכיחו את עצמם יורדים מהאתר.', copy:'© 2026 Moldova Plus · כל הזכויות שמורות' }
  },
  en: {
    nights: 'nights',
    from: 'from',
    nav:{ home:'Home', packages:'Travel packages', bachelor:'Bachelor parties', attractions:'Attractions' },
    hero:{
      kicker:'#1 destination for Moldova',
      h1:['The Moldova experience','starts here.'],
      sub:"Israel's largest portal for Chișinău getaways — bachelor parties, luxury escapes and top wineries. Transparent prices, instant confirmation.",
      pkgs:'1,200+ packages', verified:'Verified reviews', best:'Best price guarantee',
    },
    search:{ where:'Where?', whereV:'Chișinău, Moldova', when:'When?', whenV:'Add dates', who:'Guests', whoV:'2 guests', type:'Package type', typeV:'All', go:'Search' },
    foot:{ about:"Israel's largest portal for Moldova getaways. Every package is vetted — venues that don't perform are removed.", copy:'© 2026 Moldova Plus · All rights reserved' }
  }
};

const QUICK_CATS = [
  { id:'couples', he:'חבילות זוגיות', en:'Couples', ic:'sparkles' },
  { id:'bach', he:'מסיבות רווקים', en:'Bachelor', ic:'glass' },
  { id:'lux', he:'יוקרה', en:'Luxury', ic:'badge' },
  { id:'wine', he:'יקבים', en:'Wineries', ic:'wine' },
  { id:'spa', he:'ספא', en:'Spa', ic:'spa' },
  { id:'food', he:'גסטרו', en:'Gastro', ic:'plane' },
  { id:'group', he:'קבוצות', en:'Groups', ic:'people' },
  { id:'adv', he:'אדרנלין', en:'Adventure', ic:'mountain' },
];

const PACKAGES = [
  { id:1, type:'couples', price:890, discount:12, nights:4, people:'2 אורחים', rating:'9.6', tag:'הכי פופולרי', status:'now',
    he:{ title:'חבילת רומנטיקה במלון בוטיק נובל', loc:'קישינב — מרכז העיר', desc:'4 לילות במלון בוטיק יוקרתי במרכז קישינב, ארוחות בוקר, יום בספא וסיור ביקב הגדול בעולם — Mileștii Mici.' },
    en:{ title:'Romance package · Nobil Boutique Hotel', loc:'Chișinău — City center' } },
  { id:2, type:'bach', price:650, discount:8, nights:3, people:'8-12 אורחים', rating:'9.9', tag:'BEST SELLER', status:'now',
    he:{ title:'מסיבת רווקים אולטימטיבית', loc:'קישינב — רובע הבילויים' },
    en:{ title:'Ultimate Bachelor Party', loc:'Chișinău — Nightlife district' } },
  { id:3, type:'wine', price:740, nights:5, people:'2-4 אורחים', rating:'9.4', status:'now',
    he:{ title:'מסע יקבים — Cricova & Mileștii Mici', loc:'מולדובה — כל הארץ' },
    en:{ title:'Wine Trail · Cricova & Mileștii Mici', loc:'Moldova — Countrywide' } },
  { id:4, type:'lux', price:1290, discount:10, nights:5, people:'2 אורחים', rating:'9.8', status:'now',
    he:{ title:'יוקרה אולטימטיבית — סוויטה נשיאותית', loc:'קישינב — Radisson Blu' },
    en:{ title:'Ultimate Luxury — Presidential Suite', loc:'Chișinău — Radisson Blu' } },
  { id:5, type:'group', price:520, nights:3, people:'10-20 אורחים', rating:'9.2', status:'day',
    he:{ title:'חבילת קבוצות לחברה / משפחה', loc:'קישינב — מרכז העיר' },
    en:{ title:'Group package — Company / Family', loc:'Chișinău — City center' } },
  { id:6, type:'food', price:680, discount:15, nights:4, people:'2 אורחים', rating:'9.5', tag:'חדש', status:'now',
    he:{ title:'גסטרו טור — מסעדות שף + יקבים', loc:'קישינב + Codru' },
    en:{ title:'Gastro Tour — Chef restaurants + Wineries', loc:'Chișinău + Codru' } },
  { id:7, type:'spa', price:560, nights:3, people:'2 אורחים', rating:'9.3', status:'now',
    he:{ title:'חבילת ספא וטבע — Codru', loc:'יער Codru — 30 דק׳ מקישינב' },
    en:{ title:'Spa & Nature — Codru Forest', loc:'Codru forest — 30 min' } },
  { id:8, type:'adv', price:480, nights:3, people:'4-8 אורחים', rating:'9.0', status:'day',
    he:{ title:'אדרנלין — קארטינג, רכבי שטח וירי', loc:'קישינב + סביבה' },
    en:{ title:'Adrenaline — Karting, ATV & Shooting', loc:'Chișinău area' } },
];

const REGIONS = [
  { he:'מרכז קישינב', en:'Chișinău center', kind:'warm' },
  { he:'רובע הבילויים', en:'Nightlife district', kind:'dark' },
  { he:'יקב Mileștii Mici', en:'Mileștii Mici', kind:'gold' },
  { he:'יער Codru', en:'Codru forest', kind:'green' },
  { he:'יקב Cricova', en:'Cricova', kind:'blue' },
  { he:'אורחי הוילה', en:'Villas', kind:'light' },
];

const REVIEWS = [
  { he:{ place:'מסיבת רווקים אולטימטיבית', body:'יצאנו לחגיגה של החבר הכי טוב — הכל אורגן בצורה מושלמת. הוילה הייתה מטורפת, השף מעולה והליווי בלילה היה מקצועי. ממליץ בחום.', n:'דניאל ב' }, en:{ place:'Bachelor Party', body:'Organized to perfection. Wild villa, top chef, and a pro local fixer all night. Highly recommended.', n:'Daniel B.' }, stars:5, when:'18.04.2026' },
  { he:{ place:'מסע יקבים', body:'Mileștii Mici היה חוויה מטריפה — 200 ק״מ של מנהרות יין מתחת לאדמה. הסיור באנגלית, ארוחת ערב היין הייתה ברמה של מישלן.', n:'מיכל ל' }, en:{ place:'Wine Trail', body:'Mileștii Mici is mind-blowing — 200km of underground tunnels. Wine pairing dinner was Michelin-level.', n:'Michal L.' }, stars:5, when:'12.04.2026' },
  { he:{ place:'יוקרה — Radisson Blu', body:'הסוויטה הייתה ענקית, השירות בלתי רגיל. מולדובה הפתיעה אותנו לטובה — נחזור בטוח.', n:'אורן ש' }, en:{ place:'Luxury — Radisson Blu', body:'Massive suite, exceptional service. Moldova was a wonderful surprise — definitely returning.', n:'Oren S.' }, stars:5, when:'09.04.2026' },
  { he:{ place:'חבילת רומנטיקה', body:'יום הולדת לאשתי, רצינו משהו שונה — קיבלנו חוויה אינטימית עם כל הפינוקים. שווה כל אגורה.', n:'יואב ק' }, en:{ place:'Romance Package', body:"My wife's birthday — wanted something different. Intimate experience with every detail handled. Worth every euro.", n:'Yoav K.' }, stars:5, when:'05.04.2026' },
];

const ARTICLES = [
  { he:{ tag:'מדריך', title:'הסיבה שמולדובה הפכה ליעד החם של 2026', desc:'יקבים תת-קרקעיים, מחירים נמוכים, טיסה של 3 שעות וחיי לילה משתוללים — מה הופך את קישינב למה שהיא היום.' }, en:{ tag:'Guide', title:'Why Moldova became the hottest destination of 2026', desc:'Underground wineries, low prices, a 3-hour flight and wild nightlife — what makes Chișinău what it is today.' }, kind:'gold' },
  { he:{ tag:'יקבים', title:'4 היקבים שחייבים לבקר בהם', desc:'Mileștii Mici, Cricova, Purcari ו-Castel Mimi — הסיורים, הטעימות והדגשים.' }, en:{ tag:'Wineries', title:'4 wineries you must visit', desc:'Mileștii Mici, Cricova, Purcari & Castel Mimi.' }, kind:'warm' },
  { he:{ tag:'רווקים', title:'מסיבת רווקים בקישינב — המדריך', desc:'הכל מהוילות והבארים ועד התחבורה — איך מארגנים מסיבת רווקים שלא ישכחו.' }, en:{ tag:'Bachelor', title:'Bachelor party in Chișinău — the guide', desc:'From villas and bars to transport — how to organize a memorable bash.' }, kind:'dark' },
];

window.T = T; window.QUICK_CATS = QUICK_CATS; window.PACKAGES = PACKAGES; window.REGIONS = REGIONS; window.REVIEWS = REVIEWS; window.ARTICLES = ARTICLES;
