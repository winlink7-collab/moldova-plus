// app.jsx — root + routing + tweaks

const { useState, useEffect } = React;

const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
  "theme":"rose",
  "accent":"#cc1126"
}/*EDITMODE-END*/;

function App(){
  const [route, setRoute] = useState('home');
  const [packageId, setPackageId] = useState(1);
  const [lang, setLang] = useState('he');
  const [fav, setFav] = useState({});
  const [tweaks, setTweak] = useTweaks(TWEAK_DEFAULTS);

  // sync lang to body
  useEffect(()=>{
    document.body.dataset.lang = lang;
    document.body.dir = lang==='he' ? 'rtl' : 'ltr';
    document.documentElement.lang = lang;
  },[lang]);

  // sync theme to body class + accent var
  useEffect(()=>{
    document.body.classList.remove('theme-rose','theme-blue','theme-yellow','theme-dark');
    document.body.classList.add('theme-'+tweaks.theme);
    document.documentElement.style.setProperty('--rose', tweaks.accent);
  },[tweaks.theme, tweaks.accent]);

  // scroll to top on nav
  useEffect(()=>{ window.scrollTo({top:0,behavior:'smooth'}); },[route, packageId]);

  const go = (r, id) => {
    setRoute(r);
    if (id) setPackageId(id);
  };
  const toggleFav = (id) => setFav(f=>({...f,[id]:!f[id]}));

  const t = T[lang];
  const pageProps = { lang, t, go, fav, toggleFav, packageId };

  return (
    <React.Fragment>
      <Header route={route} go={go} lang={lang} setLang={setLang} t={t}/>
      {route==='home' && <HomePage {...pageProps}/>}
      {route==='packages' && <PackagesPage {...pageProps}/>}
      {route==='bachelor' && <BachelorPage {...pageProps}/>}
      {route==='attractions' && <AttractionsPage {...pageProps}/>}
      {route==='detail' && <DetailPage {...pageProps}/>}
      <Footer t={t} go={go} lang={lang}/>

      <TweaksPanel title="Tweaks">
        <TweakSection label="Theme"/>
        <TweakRadio
          label="Theme"
          value={tweaks.theme}
          onChange={v=>setTweak({theme:v, accent: v==='rose'?'#cc1126':v==='blue'?'#0046ae':v==='yellow'?'#e0b400':'#ffd400'})}
          options={['rose','blue','yellow','dark']}/>
        <TweakColor label="Accent" value={tweaks.accent} onChange={v=>setTweak('accent',v)}/>
      </TweaksPanel>
    </React.Fragment>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<App/>);
