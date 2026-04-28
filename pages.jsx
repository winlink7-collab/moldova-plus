// pages.jsx — page-level layouts

const HomePage = ({ lang, t, go, fav, toggleFav }) => {
  const [tab, setTab] = React.useState('all');
  const isHe = lang==='he';
  const filtered = tab==='all' ? PACKAGES : PACKAGES.filter(p => p.type===tab);
  const tabs = [
    { id:'all', he:'הכל', en:'All' },
    { id:'couples', he:'זוגיות', en:'Couples' },
    { id:'bach', he:'רווקים', en:'Bachelor' },
    { id:'lux', he:'יוקרה', en:'Luxury' },
    { id:'wine', he:'יקבים', en:'Wineries' },
    { id:'group', he:'קבוצות', en:'Groups' },
  ];

  return (
    <React.Fragment>
      {/* HERO */}
      <section className="hero">
        <div className="container">
          <div className="hero-band">
            <div className="hero-text">
              <span className="hero-eyebrow">✦ {t.hero.kicker}</span>
              <h1>{t.hero.h1[0]} <span>{t.hero.h1[1]}</span></h1>
              <p>{t.hero.sub}</p>
              <div style={{display:'flex',gap:12,flexWrap:'wrap'}}>
                <button className="btn btn-primary" onClick={()=>go('packages')}>
                  {isHe?'גלו חבילות':'Browse packages'} <Icon name={isHe?'arrow-l':'arrow'} size={15}/>
                </button>
                <button className="btn btn-ghost" onClick={()=>go('bachelor')}>
                  <Icon name="glass" size={15}/> {isHe?'מסיבת רווקים':'Bachelor party'}
                </button>
              </div>
              <div className="hero-trust">
                <div className="ti"><span className="ti-ic"><Icon name="check" size={16}/></span><div><b>{t.hero.best}</b><span>{isHe?'מוסכם':'Guaranteed'}</span></div></div>
                <div className="ti"><span className="ti-ic"><Icon name="badge" size={16}/></span><div><b>{t.hero.verified}</b><span>4,200+</span></div></div>
                <div className="ti"><span className="ti-ic"><Icon name="shield" size={16}/></span><div><b>{t.hero.pkgs}</b><span>{isHe?'מאומתות':'Vetted'}</span></div></div>
              </div>
            </div>
            <div className="hero-img-wrap">
              <div className="hero-img-1"><Placeholder kind="warm" label="HERO · CHIȘINĂU OLD TOWN ROOFTOP · 800×600"/></div>
              <div className="hero-img-2"><Placeholder kind="gold" label="WINERY CELLAR · 500×300"/></div>
              <div className="hero-floating">
                <div className="av-row"><span className="av"/><span className="av" style={{background:'linear-gradient(135deg,#ffd400,#0046ae)'}}/><span className="av" style={{background:'linear-gradient(135deg,#cc1126,#ffd400)'}}/></div>
                <div><b>+12,400</b><span>{isHe?'אורחים מרוצים':'happy guests'}</span></div>
              </div>
            </div>
          </div>
          {/* Search bar */}
          <div className="search-bar">
            <div className="search-cell">
              <span className="ic"><Icon name="pin" size={18}/></span>
              <div className="col"><label>{t.search.where}</label><b>{t.search.whereV}</b></div>
            </div>
            <div className="search-cell">
              <span className="ic"><Icon name="cal" size={18}/></span>
              <div className="col"><label>{t.search.when}</label><b>{t.search.whenV}</b></div>
            </div>
            <div className="search-cell">
              <span className="ic"><Icon name="people" size={18}/></span>
              <div className="col"><label>{t.search.who}</label><b>{t.search.whoV}</b></div>
            </div>
            <div className="search-cell">
              <span className="ic"><Icon name="sparkles" size={18}/></span>
              <div className="col"><label>{t.search.type}</label><b>{t.search.typeV}</b></div>
            </div>
            <button className="search-go" onClick={()=>go('packages')}>
              <Icon name="search" size={16}/> {t.search.go}
            </button>
          </div>
        </div>
      </section>

      {/* QUICK CATEGORIES */}
      <section className="quick-cats">
        <div className="container">
          <div className="qc-grid">
            {QUICK_CATS.map(c=>(
              <div key={c.id} className="qc" onClick={()=>go('packages')}>
                <div className="qc-ic"><Icon name={c.ic} size={22}/></div>
                <span>{lang==='he'?c.he:c.en}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* RECOMMENDED */}
      <section className="s">
        <div className="container">
          <div className="s-head">
            <h2>{isHe?'חבילות ':'Recommended '}<span>{isHe?'מומלצות':'packages'}</span></h2>
            <div className="r">
              <button className="btn-link" onClick={()=>go('packages')}>{isHe?'כל החבילות':'View all'} <Icon name={isHe?'arrow-l':'arrow'} size={14}/></button>
            </div>
          </div>
          <div className="tabs">
            {tabs.map(tb=>(
              <button key={tb.id} className={'tab '+(tab===tb.id?'active':'')} onClick={()=>setTab(tb.id)}>
                {lang==='he'?tb.he:tb.en}
                <span className="count">{tb.id==='all'?PACKAGES.length:PACKAGES.filter(p=>p.type===tb.id).length}</span>
              </button>
            ))}
          </div>
          <div className="card-grid">
            {filtered.slice(0,8).map((p,i)=>(
              <Card key={p.id} p={p} lang={lang} t={t} onOpen={()=>go('detail',p.id)} onFav={toggleFav} fav={fav[p.id]} kind={['warm','dark','gold','green','blue','light'][i%6]}/>
            ))}
          </div>
        </div>
      </section>

      {/* PROMO STRIP */}
      <section><div className="container">
        <div className="promo-strip">
          <div>
            <h3>{isHe?'מועדון Moldova Plus — הצטרפו חינם':'Moldova Plus Club — join free'}</h3>
            <p>{isHe?'5% הנחה בכל הזמנה, גישה מוקדמת לחבילות חדשות והטבה אישית בכל יום הולדת. ללא דמי חבר.':'5% off every booking, early access to new packages and a birthday perk. No membership fee.'}</p>
          </div>
          <button className="btn">{isHe?'הצטרפו עכשיו':'Join now'} <Icon name={isHe?'arrow-l':'arrow'} size={15}/></button>
        </div>
      </div></section>

      {/* REGIONS */}
      <section className="s">
        <div className="container">
          <div className="s-head">
            <h2>{isHe?'חיפוש לפי ':'Browse by '}<span>{isHe?'אזור':'region'}</span></h2>
          </div>
          <div className="region-grid">
            {REGIONS.map((r,i)=>(
              <div className="region" key={i} onClick={()=>go('packages')}>
                <Placeholder kind={r.kind} label={`REGION · ${(r.en||'').toUpperCase()}`}/>
                <span>{lang==='he'?r.he:r.en}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* REVIEWS */}
      <section className="reviews-strip">
        <div className="container">
          <div className="s-head">
            <h2>{isHe?'חוות דעת ':'Verified '}<span>{isHe?'גולשים':'reviews'}</span></h2>
            <div className="r"><span style={{fontSize:13,color:'var(--ink-mute)'}}>★★★★★ <b style={{color:'var(--ink)'}}>4.9</b> · {isHe?'מתוך 4,247 ביקורות':'from 4,247 reviews'}</span></div>
          </div>
          <div className="reviews-grid">
            {REVIEWS.map((r,i)=>{
              const c = r[lang];
              return (
                <div className="review" key={i}>
                  <div className="review-head">
                    <span className="review-place">{c.place}</span>
                    <span className="review-stars">{'★'.repeat(r.stars)}</span>
                  </div>
                  <p>{c.body}</p>
                  <div className="review-foot"><b>{c.n}</b><span>{r.when}</span></div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* ARTICLES */}
      <section className="s">
        <div className="container">
          <div className="s-head">
            <h2>{isHe?'כתבות ':'From the '}<span>{isHe?'ומדריכים':'magazine'}</span></h2>
            <button className="btn-link">{isHe?'כל הכתבות':'View all'} <Icon name={isHe?'arrow-l':'arrow'} size={14}/></button>
          </div>
          <div className="article-grid">
            {ARTICLES.map((a,i)=>{
              const c = a[lang];
              return (
                <div className="article" key={i}>
                  <div className="article-img"><Placeholder kind={a.kind} label={`ARTICLE · ${(a.en && a.en.tag||'').toUpperCase()}`}/></div>
                  <div className="article-body">
                    <span className="article-tag">{c.tag}</span>
                    <h4>{c.title}</h4>
                    <p>{c.desc}</p>
                    <span className="article-foot">5 {isHe?'דק׳ קריאה':'min read'} · 14.04.2026</span>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>
    </React.Fragment>
  );
};

const ListPage = ({ lang, t, go, fav, toggleFav, kind, title, sub, types }) => {
  const isHe = lang==='he';
  const [filter, setFilter] = React.useState('all');
  const [sort, setSort] = React.useState('pop');
  let list = types ? PACKAGES.filter(p=>types.includes(p.type)) : PACKAGES;
  if (filter !== 'all') list = list.filter(p => p.type===filter);
  if (sort==='priceL') list = [...list].sort((a,b)=>a.price-b.price);
  else if (sort==='priceH') list = [...list].sort((a,b)=>b.price-a.price);
  else if (sort==='rating') list = [...list].sort((a,b)=>parseFloat(b.rating||0)-parseFloat(a.rating||0));

  const filterTypes = types || ['couples','bach','wine','lux','group','food','spa','adv'];

  return (
    <React.Fragment>
      <section className="ph-banner">
        <div className="container">
          <div className="crumbs"><a onClick={()=>go('home')}>{isHe?'בית':'Home'}</a> / <span>{title[lang]}</span></div>
          <h1>{title[lang].split(' ')[0]} <span>{title[lang].split(' ').slice(1).join(' ')}</span></h1>
          <p>{sub[lang]}</p>
        </div>
      </section>
      <section className="page-pad">
        <div className="container">
          <div className="filter-bar">
            <button className={'filter-pill '+(filter==='all'?'active':'')} onClick={()=>setFilter('all')}>{isHe?'הכל':'All'}</button>
            {filterTypes.map(ft=>{
              const labels = { couples:{he:'זוגיות',en:'Couples'}, bach:{he:'רווקים',en:'Bachelor'}, wine:{he:'יקבים',en:'Wineries'}, lux:{he:'יוקרה',en:'Luxury'}, group:{he:'קבוצות',en:'Groups'}, food:{he:'גסטרו',en:'Gastro'}, spa:{he:'ספא',en:'Spa'}, adv:{he:'אדרנלין',en:'Adventure'} };
              return <button key={ft} className={'filter-pill '+(filter===ft?'active':'')} onClick={()=>setFilter(ft)}>{labels[ft][lang]}</button>;
            })}
            <select value={sort} onChange={e=>setSort(e.target.value)}>
              <option value="pop">{isHe?'מיון: פופולריות':'Sort: Popular'}</option>
              <option value="priceL">{isHe?'מחיר: נמוך לגבוה':'Price: low to high'}</option>
              <option value="priceH">{isHe?'מחיר: גבוה לנמוך':'Price: high to low'}</option>
              <option value="rating">{isHe?'דירוג':'Rating'}</option>
            </select>
            <span className="results">{list.length} {isHe?'תוצאות':'results'}</span>
          </div>
          <div className="card-grid">
            {list.map((p,i)=>(
              <Card key={p.id} p={p} lang={lang} t={t} onOpen={()=>go('detail',p.id)} onFav={toggleFav} fav={fav[p.id]} kind={['warm','dark','gold','green','blue','light'][i%6]}/>
            ))}
          </div>
        </div>
      </section>
    </React.Fragment>
  );
};

const PackagesPage = (p) => <ListPage {...p} title={{he:'חבילות נופש',en:'Travel Packages'}} sub={{he:'כל החבילות שלנו במולדובה — מבוקרות, שקופות, באישור מיידי.',en:'All our Moldova packages — vetted, transparent, instant booking.'}}/>;
const BachelorPage = (p) => <ListPage {...p} types={['bach','adv','group']} title={{he:'מסיבות רווקים',en:'Bachelor Parties'}} sub={{he:'הוילות, הבארים, התחבורה והליווי המקומי — מסיבת רווקים שלא ישכחו.',en:'Villas, bars, transport and local fixers — bachelor parties to remember.'}}/>;

const AttractionsPage = ({ lang, go }) => {
  const isHe = lang==='he';
  const items = [
    { he:'יקב Mileștii Mici', en:'Mileștii Mici Winery', cat:'wine', kind:'gold', he2:'200 ק״מ של מנהרות תת-קרקעיות', en2:'200km of underground tunnels' },
    { he:'יקב Cricova', en:'Cricova Winery', cat:'wine', kind:'warm', he2:'מנהרות יין היסטוריות', en2:'Historic wine tunnels' },
    { he:'מנזר Capriana', en:'Capriana Monastery', cat:'culture', kind:'green', he2:'מנזר מהמאה ה-15', en2:'15th century monastery' },
    { he:'אורהיי וצי', en:'Orheiul Vechi', cat:'culture', kind:'warm', he2:'מתחם ארכיאולוגי מרהיב', en2:'Stunning archaeological site' },
    { he:'Carrera (Karting)', en:'Carrera Karting', cat:'adrenaline', kind:'dark', he2:'הקארטינג הגדול במזרח אירופה', en2:'Largest karting in E. Europe' },
    { he:'Castel Mimi', en:'Castel Mimi', cat:'wine', kind:'light', he2:'יקב טירה ב-50 דק׳ מקישינב', en2:'Castle winery, 50 min from city' },
    { he:'מסעדת Pegas', en:'Pegas Restaurant', cat:'food', kind:'blue', he2:'אגם פרטי + ספא דגים', en2:'Private lake + fish spa' },
    { he:'רובע La 33', en:'La 33 District', cat:'nightlife', kind:'dark', he2:'חיי הלילה הכי שווים בקישינב', en2:'Best nightlife in Chișinău' },
  ];
  const cats = [
    { id:'all', he:'הכל', en:'All' },
    { id:'wine', he:'יקבים', en:'Wineries' },
    { id:'culture', he:'תרבות', en:'Culture' },
    { id:'adrenaline', he:'אדרנלין', en:'Adrenaline' },
    { id:'food', he:'אוכל', en:'Food' },
    { id:'nightlife', he:'חיי לילה', en:'Nightlife' },
  ];
  const [c,setC] = React.useState('all');
  const filtered = c==='all'?items:items.filter(i=>i.cat===c);
  return (
    <React.Fragment>
      <section className="ph-banner">
        <div className="container">
          <div className="crumbs"><a onClick={()=>go('home')}>{isHe?'בית':'Home'}</a> / <span>{isHe?'אטרקציות':'Attractions'}</span></div>
          <h1>{isHe?'אטרקציות ':'Attractions in '}<span>{isHe?'במולדובה':'Moldova'}</span></h1>
          <p>{isHe?'יקבים, מנזרים, אדרנלין וחיי לילה — כל מה ששווה לבקר בו במולדובה.':'Wineries, monasteries, adrenaline and nightlife — everything worth visiting in Moldova.'}</p>
        </div>
      </section>
      <section className="page-pad"><div className="container">
        <div className="filter-bar">
          {cats.map(cat=>(<button key={cat.id} className={'filter-pill '+(c===cat.id?'active':'')} onClick={()=>setC(cat.id)}>{cat[lang]}</button>))}
          <span className="results">{filtered.length} {isHe?'אטרקציות':'attractions'}</span>
        </div>
        <div className="card-grid">
          {filtered.map((it,i)=>(
            <div className="card" key={i}>
              <div className="card-img"><Placeholder kind={it.kind} label={`ATTR · ${it.en.toUpperCase()}`}/></div>
              <div className="card-body">
                <span className="card-loc"><span className="ic"><Icon name="pin" size={12}/></span> {isHe?'מולדובה':'Moldova'}</span>
                <h3 className="card-title">{it[lang]}</h3>
                <p style={{fontSize:13,color:'var(--ink-soft)',margin:'4px 0 0',lineHeight:1.5}}>{lang==='he'?it.he2:it.en2}</p>
              </div>
            </div>
          ))}
        </div>
      </div></section>
    </React.Fragment>
  );
};

const DetailPage = ({ lang, t, go, fav, toggleFav, packageId }) => {
  const p = PACKAGES.find(x=>x.id===packageId) || PACKAGES[0];
  const c = p[lang];
  const isHe = lang==='he';
  const oldPrice = p.discount ? Math.round(p.price * (1 + p.discount/100)) : null;
  const inc = isHe ? [
    '4 לילות במלון בוטיק יוקרתי',
    'ארוחות בוקר עשירות',
    'יום ספא מלא לזוג',
    'סיור ביקב Mileștii Mici',
    'ערב גסטרונומי עם זיווגי יין',
    'איסוף ופיזור משדה התעופה',
    'ליווי מקומי דובר אנגלית',
    'WiFi מהיר וביטוח בריאות',
  ] : [
    '4 nights in a luxury boutique hotel','Generous breakfasts','Full spa day for the couple','Mileștii Mici winery tour','Gastronomic evening with wine pairing','Airport pickup & drop-off','English-speaking local fixer','Fast WiFi and health insurance'
  ];
  const itin = isHe ? [
    { d:'יום 1', t:'הגעה והכרות', p:'איסוף משדה התעופה, צ׳ק-אין במלון, סיור הליכה ערב במרכז העיר ההיסטורי וארוחת ערב פתיחה במסעדת שף מקומית.' },
    { d:'יום 2', t:'יום היין הגדול', p:'יציאה ל-Mileștii Mici — היקב הגדול בעולם. סיור ברכב מתחת לאדמה, טעימה של 6 יינות וארוחת צהריים בקלרייר תת-קרקעי.' },
    { d:'יום 3', t:'יום ספא ופינוק', p:'בוקר חופשי, צהריים יום ספא מלא — סאונה, ג׳קוזי, עיסוי זוגי ופנים. ערב חופשי לבחירתכם.' },
    { d:'יום 4', t:'אדרנלין או תרבות', p:'בחירה: יום קארטינג ורכבי שטח, או סיור במנזר Capriana ואורהיי וצי הארכיאולוגי. ארוחת ערב פרידה.' },
    { d:'יום 5', t:'פרידה', p:'ארוחת בוקר אחרונה, צ׳ק-אאוט והסעה לשדה התעופה.' },
  ] : [
    { d:'Day 1', t:'Arrival', p:'Airport pickup, hotel check-in, evening walking tour of the historic center and welcome dinner at a chef-driven local restaurant.' },
    { d:'Day 2', t:'The Big Wine Day', p:"Excursion to Mileștii Mici — the world's largest winery. Underground vehicle tour, 6-wine tasting and lunch in a subterranean cellar." },
    { d:'Day 3', t:'Spa & Indulgence', p:'Free morning, afternoon full spa day — sauna, jacuzzi, couples massage and facial. Evening at your leisure.' },
    { d:'Day 4', t:'Adrenaline or Culture', p:"Choice of: karting and ATV day, or visit to Capriana Monastery and Orheiul Vechi archaeological site. Farewell dinner." },
    { d:'Day 5', t:'Departure', p:'Final breakfast, check-out and airport transfer.' },
  ];

  return (
    <React.Fragment>
      <section style={{padding:'24px 0 0'}}>
        <div className="container">
          <div style={{fontSize:13,color:'var(--ink-mute)',marginBottom:16}}>
            <a onClick={()=>go('home')} style={{cursor:'pointer'}}>{isHe?'בית':'Home'}</a> / <a onClick={()=>go('packages')} style={{cursor:'pointer'}}>{isHe?'חבילות':'Packages'}</a> / <span style={{color:'var(--rose)',fontWeight:600}}>{c.title}</span>
          </div>
          <div className="detail-gal">
            <div className="gm main"><Placeholder kind="warm" label="MAIN HOTEL · 1200×800"/></div>
            <div className="gm"><Placeholder kind="gold" label="ROOM · 600×400"/></div>
            <div className="gm"><Placeholder kind="green" label="SPA · 600×400"/></div>
            <div className="gm"><Placeholder kind="dark" label="DINING · 600×400"/></div>
            <div className="gm"><Placeholder kind="blue" label="WINERY · 600×400"/></div>
          </div>
          <div className="detail-grid">
            <div className="detail-main">
              <span className="card-loc" style={{marginBottom:8}}><span className="ic"><Icon name="pin" size={12}/></span> {c.loc}</span>
              <h1>{c.title}</h1>
              <div className="detail-meta">
                <span className="badge">★ {p.rating}</span>
                <span><Icon name="moon" size={13}/> {p.nights} {t.nights}</span>
                <span><Icon name="people" size={13}/> {p.people}</span>
                <span><Icon name="check" size={13}/> {isHe?'אישור מיידי':'Instant booking'}</span>
                {p.tag && <span style={{background:'var(--rose)',color:'#fff',padding:'5px 10px',borderRadius:6,fontWeight:600}}>{p.tag}</span>}
              </div>

              <div className="det-section">
                <h3>{isHe?'על החבילה':'About this package'}</h3>
                <p>{p.he.desc || (isHe?'חבילה ייחודית במולדובה שעוצבה במיוחד עבור אורחים שמחפשים שילוב של יוקרה, חוויה אותנטית וערך כלכלי גבוה. כל פרט בחבילה תוכנן בקפידה — מהאיסוף בשדה התעופה ועד הליווי המקומי.':'A distinctive Moldova package designed for guests seeking a blend of luxury, authentic experience and high value. Every detail is carefully planned — from the airport pickup to the local fixer.')}</p>
              </div>

              <div className="det-section">
                <h3>{isHe?'מה כלול':'What\'s included'}</h3>
                <ul className="incl">{inc.map((x,i)=><li key={i}>{x}</li>)}</ul>
              </div>

              <div className="det-section">
                <h3>{isHe?'המסלול':'Itinerary'}</h3>
                {itin.map((d,i)=>(
                  <div className="itin-row" key={i}>
                    <div className="itin-day">{d.d}</div>
                    <div><b>{d.t}</b><p>{d.p}</p></div>
                  </div>
                ))}
              </div>
            </div>

            <aside className="booking">
              <div className="price">
                <small>{t.from}</small>
                {oldPrice && <span className="old">€{oldPrice.toLocaleString()}</span>}
                <b>€{p.price.toLocaleString()}<sub> /{isHe?'אדם':'person'}</sub></b>
                {p.discount && <span style={{display:'inline-block',marginTop:6,fontSize:12,fontWeight:700,color:'var(--rose)',background:'var(--rose-soft)',padding:'4px 10px',borderRadius:6}}>{isHe?'חיסכון של':'Save'} {p.discount}%</span>}
              </div>
              <div className="booking-row split">
                <div><label>{isHe?'הגעה':'Check-in'}</label><div className="ctrl"><Icon name="cal" size={14}/>15 ספט</div></div>
                <div><label>{isHe?'יציאה':'Check-out'}</label><div className="ctrl"><Icon name="cal" size={14}/>19 ספט</div></div>
              </div>
              <div className="booking-row"><label>{isHe?'אורחים':'Guests'}</label><div className="ctrl"><Icon name="people" size={14}/><select><option>2 {isHe?'מבוגרים':'adults'}</option><option>4 {isHe?'מבוגרים':'adults'}</option></select></div></div>
              <button className="btn btn-primary" style={{marginTop:6}}>{isHe?'הזמינו עכשיו':'Book now'} <Icon name={isHe?'arrow-l':'arrow'} size={14}/></button>
              <button className="btn btn-ghost" style={{width:'100%',justifyContent:'center',marginTop:8}}><Icon name="whatsapp" size={14}/> {isHe?'דברו איתנו':'Chat with us'}</button>
              <div className="booking-trust">
                <span><span className="ic"><Icon name="check" size={13}/></span> {isHe?'ביטול חינם עד 14 יום':'Free cancellation up to 14 days'}</span>
                <span><span className="ic"><Icon name="check" size={13}/></span> {isHe?'אישור מיידי':'Instant confirmation'}</span>
                <span><span className="ic"><Icon name="check" size={13}/></span> {isHe?'תשלום מאובטח':'Secure payment'}</span>
              </div>
            </aside>
          </div>
        </div>
      </section>
    </React.Fragment>
  );
};

window.HomePage = HomePage;
window.PackagesPage = PackagesPage;
window.BachelorPage = BachelorPage;
window.AttractionsPage = AttractionsPage;
window.DetailPage = DetailPage;
