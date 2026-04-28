// components.jsx — SpaPlus-style commercial UI

const Icon = ({ name, size=18, stroke=2 }) => {
  const c = { width:size, height:size, viewBox:'0 0 24 24', fill:'none', stroke:'currentColor', strokeWidth:stroke, strokeLinecap:'round', strokeLinejoin:'round' };
  switch(name){
    case 'pin': return <svg {...c}><path d="M12 22s7-7 7-12a7 7 0 1 0-14 0c0 5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>;
    case 'cal': return <svg {...c}><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>;
    case 'people': return <svg {...c}><circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><circle cx="17" cy="9" r="2.5"/><path d="M15 20a5 5 0 0 1 6.5-4.7"/></svg>;
    case 'arrow': return <svg {...c}><path d="M5 12h14M13 5l7 7-7 7"/></svg>;
    case 'arrow-l': return <svg {...c}><path d="M19 12H5M11 5l-7 7 7 7"/></svg>;
    case 'star': return <svg {...c} fill="currentColor" stroke="none"><path d="M12 2l3 6.5 7 1-5 5 1.5 7-6.5-3.5L5 21.5 6.5 14.5l-5-5 7-1L12 2z"/></svg>;
    case 'heart': return <svg {...c}><path d="M12 21s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6c-2.5 4.5-9.5 9-9.5 9z"/></svg>;
    case 'heart-fill': return <svg {...c} fill="currentColor"><path d="M12 21s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6c-2.5 4.5-9.5 9-9.5 9z"/></svg>;
    case 'check': return <svg {...c}><path d="M5 12l5 5L20 7"/></svg>;
    case 'phone': return <svg {...c}><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7l.8 4a2 2 0 0 1-.6 1.9L7.6 11.4a16 16 0 0 0 6 6l1.8-1.7a2 2 0 0 1 1.9-.6l4 .8a2 2 0 0 1 1.7 2z"/></svg>;
    case 'mail': return <svg {...c}><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>;
    case 'whatsapp': return <svg {...c}><path d="M21 12a9 9 0 1 1-3.5-7.1L21 4l-1 3a9 9 0 0 1 1 5z"/><path d="M8.5 9.5c0 4 3 6.5 5.5 6.5l1.5-1.5-2-1-1 1c-.8-.5-1.5-1.2-2-2l1-1-1-2L9.5 8c-.7 0-1 .8-1 1.5z" fill="currentColor"/></svg>;
    case 'moon': return <svg {...c}><path d="M21 13a9 9 0 1 1-10-10 7 7 0 0 0 10 10z"/></svg>;
    case 'search': return <svg {...c}><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.5-4.5"/></svg>;
    case 'wine': return <svg {...c}><path d="M8 3h8v4a4 4 0 0 1-8 0V3z"/><path d="M12 11v8M9 21h6"/></svg>;
    case 'spa': return <svg {...c}><path d="M12 2c2 4 6 5 6 9 0 4-3 6-6 6s-6-2-6-6c0-4 4-5 6-9z"/></svg>;
    case 'plane': return <svg {...c}><path d="M22 16l-8-3.5V5a2 2 0 1 0-4 0v7.5L2 16v2l8-2v5l-2 1.5V24l4-1 4 1v-1.5L14 21v-5l8 2v-2z"/></svg>;
    case 'glass': return <svg {...c}><path d="M5 3h14l-2 9a5 5 0 0 1-10 0L5 3z"/><path d="M12 17v4M8 21h8"/></svg>;
    case 'sparkles': return <svg {...c}><path d="M12 3l1.5 4.5L18 9l-4.5 1.5L12 15l-1.5-4.5L6 9l4.5-1.5L12 3zM19 14l.7 2 2 .8-2 .7-.7 2-.7-2-2-.7 2-.8.7-2zM5 16l.5 1.5L7 18l-1.5.5L5 20l-.5-1.5L3 18l1.5-.5L5 16z"/></svg>;
    case 'mountain': return <svg {...c}><path d="M3 20l6-10 4 6 4-7 4 11H3z"/></svg>;
    case 'shield': return <svg {...c}><path d="M12 2l8 3v6c0 5-3.5 9.5-8 11-4.5-1.5-8-6-8-11V5l8-3z"/><path d="M9 12l2 2 4-4"/></svg>;
    case 'badge': return <svg {...c}><circle cx="12" cy="9" r="6"/><path d="M9 14l-2 7 5-3 5 3-2-7"/></svg>;
    case 'globe': return <svg {...c}><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>;
    case 'menu': return <svg {...c}><path d="M3 6h18M3 12h18M3 18h18"/></svg>;
    case 'club': return <svg {...c}><path d="M12 4v8M4 8h16M6 12h12v8H6z"/></svg>;
    default: return null;
  }
};

const Logo = ({ light=false, onClick }) => (
  <a className="logo" onClick={onClick}>
    <span className="logo-mark">
      <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <path d="M5 19 L12 5 L19 19 Z"/>
        <path d="M9 14 L12 17 L15 14"/>
      </svg>
    </span>
    <span className="logo-word">
      <span className="l1" style={light?{color:'#fff'}:{}}>Moldova<span> Plus</span></span>
      <span className="l2" style={light?{color:'rgba(255,255,255,.6)'}:{}}>חבילות נופש בקישינב</span>
    </span>
  </a>
);

const Header = ({ route, go, lang, setLang, t }) => {
  const isHe = lang==='he';
  return (
    <React.Fragment>
      <div className="top-bar">
        <div className="container top-bar-inner">
          <div className="top-bar-l">
            <span><Icon name="phone" size={13}/> +972-3-555-0188</span>
            <span><Icon name="mail" size={13}/> hello@moldovaplus.com</span>
            <span style={{color:'#fff', fontWeight:600}}>✦ {isHe?'מבצע אביב — עד 15% הנחה':'Spring offer — up to 15% off'}</span>
          </div>
          <div className="top-bar-r">
            <a><Icon name="badge" size={13}/> {isHe?'מועדון לקוחות':'Loyalty club'}</a>
            <a>{isHe?'אזור אישי':'My account'}</a>
          </div>
        </div>
      </div>
      <header className="site">
        <div className="container site-inner">
          <Logo onClick={()=>go('home')}/>
          <nav className="primary">
            <a className={route==='home'?'active':''} onClick={()=>go('home')}>{t.nav.home}</a>
            <a className={route==='packages'||route==='detail'?'active':''} onClick={()=>go('packages')}>{t.nav.packages}</a>
            <a className={route==='bachelor'?'active':''} onClick={()=>go('bachelor')}>{t.nav.bachelor}</a>
            <a className={route==='attractions'?'active':''} onClick={()=>go('attractions')}>{t.nav.attractions}</a>
            <a>{isHe?'שוברי מתנה':'Gift cards'}</a>
            <a>{isHe?'ימי כיף':'Day trips'}</a>
            <a>{isHe?'בלוג':'Blog'}</a>
          </nav>
          <div className="header-tools">
            <div className="lang-pill">
              <button className={lang==='he'?'active':''} onClick={()=>setLang('he')}>עב</button>
              <button className={lang==='en'?'active':''} onClick={()=>setLang('en')}>EN</button>
            </div>
            <button className="btn btn-primary">
              <Icon name="whatsapp" size={15}/> WhatsApp
            </button>
          </div>
        </div>
      </header>
    </React.Fragment>
  );
};

const Footer = ({ t, go, lang }) => {
  const isHe = lang==='he';
  return (
    <footer className="site">
      <div className="container">
        <div className="foot-grid">
          <div className="about">
            <Logo light/>
            <p>{t.foot.about}</p>
            <div style={{display:'flex',gap:10,marginTop:18}}>
              <a style={{width:36,height:36,borderRadius:50,background:'rgba(255,255,255,.08)',display:'grid',placeItems:'center',color:'#fff'}}><Icon name="whatsapp" size={16}/></a>
              <a style={{width:36,height:36,borderRadius:50,background:'rgba(255,255,255,.08)',display:'grid',placeItems:'center',color:'#fff'}}><Icon name="mail" size={16}/></a>
              <a style={{width:36,height:36,borderRadius:50,background:'rgba(255,255,255,.08)',display:'grid',placeItems:'center',color:'#fff'}}><Icon name="phone" size={16}/></a>
            </div>
          </div>
          <div>
            <h5>{isHe?'חבילות':'Packages'}</h5>
            <ul>
              <li><a onClick={()=>go('packages')}>{isHe?'חבילות נופש':'Travel'}</a></li>
              <li><a onClick={()=>go('bachelor')}>{isHe?'מסיבות רווקים':'Bachelor'}</a></li>
              <li><a>{isHe?'חבילות זוגיות':'Couples'}</a></li>
              <li><a>{isHe?'קבוצות':'Groups'}</a></li>
              <li><a>{isHe?'יום כיף':'Day trips'}</a></li>
            </ul>
          </div>
          <div>
            <h5>{isHe?'אטרקציות':'Attractions'}</h5>
            <ul>
              <li><a onClick={()=>go('attractions')}>{isHe?'יקבים':'Wineries'}</a></li>
              <li><a>{isHe?'מסעדות שף':'Chef restaurants'}</a></li>
              <li><a>{isHe?'אדרנלין':'Adrenaline'}</a></li>
              <li><a>{isHe?'ספא':'Spa'}</a></li>
              <li><a>{isHe?'חיי לילה':'Nightlife'}</a></li>
            </ul>
          </div>
          <div>
            <h5>{isHe?'מידע':'Info'}</h5>
            <ul>
              <li><a>{isHe?'אודות':'About'}</a></li>
              <li><a>{isHe?'שאלות נפוצות':'FAQ'}</a></li>
              <li><a>{isHe?'תקנון':'Terms'}</a></li>
              <li><a>{isHe?'מדיניות פרטיות':'Privacy'}</a></li>
              <li><a>{isHe?'צור קשר':'Contact'}</a></li>
            </ul>
          </div>
          <div className="foot-newsletter">
            <h5>{isHe?'הצטרפו למועדון':'Join the club'}</h5>
            <p style={{fontSize:13,lineHeight:1.6,margin:'0 0 14px',color:'rgba(255,255,255,.6)'}}>{isHe?'הטבות, מבצעים וגישה מוקדמת לחבילות חדשות.':'Perks, deals and early access to new packages.'}</p>
            <input type="email" placeholder={isHe?'כתובת אימייל':'Email address'}/>
            <button>{isHe?'הרשמה':'Subscribe'}</button>
          </div>
        </div>
        <div className="foot-base">
          <span>{t.foot.copy}</span>
          <div className="foot-trust">
            <span><Icon name="shield" size={12}/> {isHe?'תשלום מאובטח':'Secure payment'}</span>
            <span><Icon name="check" size={12}/> {isHe?'אמינות מעל הכל':'Reliable since 2018'}</span>
          </div>
        </div>
      </div>
    </footer>
  );
};

const Placeholder = ({ label, kind='dark', style={} }) => (
  <div className={'ph '+kind} style={style}><span>{label}</span></div>
);

const Card = ({ p, lang, t, onOpen, onFav, fav, kind='dark' }) => {
  const c = p[lang];
  const oldPrice = p.discount ? Math.round(p.price * (1 + p.discount/100)) : null;
  return (
    <div className="card" onClick={() => onOpen(p.id)}>
      <div className="card-img">
        <Placeholder label={`PKG · ${p.id}`} kind={kind}/>
        <span className="card-rating"><span className="star">★</span> {p.rating || '9.4'}</span>
        {p.discount && <div className="card-discount">{p.discount}%<b>{lang==='he'?'הנחה':'OFF'}</b></div>}
        <span className="card-pkg-count">{p.nights} {t.nights}</span>
        <button className={'card-fav '+(fav?'on':'')} onClick={(e)=>{e.stopPropagation(); onFav(p.id);}}>
          <Icon name={fav?'heart-fill':'heart'} size={16}/>
        </button>
      </div>
      <div className="card-body">
        <span className="card-loc"><span className="ic"><Icon name="pin" size={12}/></span> {c.loc}</span>
        <h3 className="card-title">{c.title}</h3>
        <div className="card-meta">
          <span><Icon name="people" size={11}/> {p.people}</span>
          <span>·</span>
          <span><Icon name="moon" size={11}/> {p.nights} {t.nights}</span>
          {p.tag && <React.Fragment><span>·</span><span style={{color:'var(--rose)',fontWeight:600}}>{p.tag}</span></React.Fragment>}
        </div>
        <div className="card-foot">
          <div className="card-price">
            {oldPrice && <span className="old">€{oldPrice.toLocaleString()}</span>}
            <small>{t.from}</small>
            <b>€{p.price.toLocaleString()}<sub> /{lang==='he'?'אדם':'pp'}</sub></b>
          </div>
          <span className={'card-status '+(p.status==='now'?'now':'day')}>
            <Icon name={p.status==='now'?'check':'cal'} size={11}/>
            {p.status==='now' ? (lang==='he'?'אישור מיידי':'Instant booking') : (lang==='he'?'יום עסקים':'1 business day')}
          </span>
        </div>
      </div>
    </div>
  );
};

window.Icon = Icon;
window.Logo = Logo;
window.Header = Header;
window.Footer = Footer;
window.Placeholder = Placeholder;
window.Card = Card;
