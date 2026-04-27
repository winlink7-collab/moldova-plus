<?php
// SVG scene illustrations — called as scene_img($kind)
// Each scene uses CSS gradient on container + SVG overlay for silhouettes.
// No <defs> gradient IDs used inside SVG to avoid document-scope conflicts.

function scene_img(string $kind, string $cls = ''): string {
    $fn = 'scene_' . $kind;
    if (!function_exists($fn)) $fn = 'scene_dark';
    return "<div class=\"scene-img {$kind} {$cls}\">" . $fn() . '</div>';
}

// ── WARM — Sunset vineyard ───────────────────────────────────────────────────
function scene_warm(): string { return <<<SVG
<svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <!-- sky glow layers -->
  <rect width="400" height="280" fill="#ff8c42"/>
  <ellipse cx="310" cy="140" rx="220" ry="160" fill="#ffb347" opacity=".6"/>
  <ellipse cx="310" cy="280" rx="280" ry="120" fill="#ffd700" opacity=".5"/>
  <!-- sun -->
  <circle cx="310" cy="130" r="62" fill="#fff" opacity=".12"/>
  <circle cx="310" cy="130" r="42" fill="#fff9c4" opacity=".22"/>
  <circle cx="310" cy="130" r="26" fill="#fff7d0" opacity=".45"/>
  <!-- light rays -->
  <line x1="310" y1="130" x2="10"  y2="300" stroke="#fff" stroke-width="22" opacity=".04"/>
  <line x1="310" y1="130" x2="80"  y2="300" stroke="#fff" stroke-width="14" opacity=".04"/>
  <line x1="310" y1="130" x2="160" y2="300" stroke="#fff" stroke-width="10" opacity=".03"/>
  <!-- far hills -->
  <path d="M0 190 Q80 155 180 172 Q280 190 380 162 Q392 158 400 162 L400 280 L0 280Z" fill="#3d6b35"/>
  <!-- near hill -->
  <path d="M0 225 Q60 218 130 222 Q200 228 280 214 Q350 204 400 218 L400 280 L0 280Z" fill="#2a4f24"/>
  <!-- vineyard rows -->
  <g fill="#1e3b18">
    <ellipse cx="30"  cy="252" rx="17" ry="9"/>
    <ellipse cx="84"  cy="255" rx="17" ry="9"/>
    <ellipse cx="138" cy="252" rx="17" ry="9"/>
    <ellipse cx="192" cy="255" rx="17" ry="9"/>
    <ellipse cx="246" cy="252" rx="17" ry="9"/>
  </g>
  <g stroke="#2d5228" stroke-width="1.5" stroke-linecap="round" fill="none" opacity=".7">
    <line x1="30"  y1="243" x2="30"  y2="228"/>
    <line x1="84"  y1="246" x2="84"  y2="231"/>
    <line x1="138" y1="243" x2="138" y2="228"/>
    <line x1="192" y1="246" x2="192" y2="231"/>
    <line x1="246" y1="243" x2="246" y2="228"/>
  </g>
  <!-- grape clusters -->
  <g fill="#5a2d82" opacity=".55">
    <circle cx="26" cy="224" r="3.5"/><circle cx="34" cy="224" r="3.5"/><circle cx="30" cy="218" r="3.5"/>
    <circle cx="80" cy="227" r="3.5"/><circle cx="88" cy="227" r="3.5"/><circle cx="84" cy="221" r="3.5"/>
  </g>
  <!-- wine glass silhouette -->
  <g transform="translate(348,148)" fill="#1a0e00" opacity=".28">
    <path d="M-11 0 L11 0 Q9 22 6 33 L-6 33 Q-9 22 -11 0Z"/>
    <rect x="-1.5" y="33" width="3" height="24" rx="1.5"/>
    <rect x="-9" y="57" width="18" height="3.5" rx="1.75"/>
    <line x1="-9" y1="16" x2="9" y2="16" stroke="#fff" stroke-width=".8" opacity=".4"/>
  </g>
</svg>
SVG; }

// ── GOLD — Underground wine cellar ──────────────────────────────────────────
function scene_gold(): string { return <<<SVG
<svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <!-- cave base -->
  <rect width="400" height="280" fill="#3d2000"/>
  <ellipse cx="200" cy="30" rx="240" ry="120" fill="#7a4800" opacity=".7"/>
  <ellipse cx="200" cy="0"  rx="180" ry="80"  fill="#c97d00" opacity=".35"/>
  <!-- tunnel perspective arches -->
  <ellipse cx="200" cy="120" rx="160" ry="80" fill="none" stroke="#5a3500" stroke-width="18"/>
  <ellipse cx="200" cy="120" rx="110" ry="55" fill="none" stroke="#4a2c00" stroke-width="14"/>
  <ellipse cx="200" cy="120" rx="70"  ry="36" fill="none" stroke="#3d2200" stroke-width="10"/>
  <ellipse cx="200" cy="120" rx="38"  ry="20" fill="#1e1000" opacity=".8"/>
  <!-- floor -->
  <path d="M0 280 L40 200 L360 200 L400 280Z" fill="#2a1600" opacity=".8"/>
  <!-- wine barrels -->
  <g fill="#5c3a10" stroke="#3d2600" stroke-width="1.2">
    <ellipse cx="60"  cy="230" rx="32" ry="20"/>
    <rect x="28"  y="210" width="64" height="40" rx="6"/>
    <ellipse cx="60"  cy="210" rx="32" ry="20"/>
    <ellipse cx="148" cy="225" rx="28" ry="17"/>
    <rect x="120" y="208" width="56" height="34" rx="5"/>
    <ellipse cx="148" cy="208" rx="28" ry="17"/>
    <ellipse cx="252" cy="225" rx="28" ry="17"/>
    <rect x="224" y="208" width="56" height="34" rx="5"/>
    <ellipse cx="252" cy="208" rx="28" ry="17"/>
    <ellipse cx="340" cy="230" rx="32" ry="20"/>
    <rect x="308" y="210" width="64" height="40" rx="6"/>
    <ellipse cx="340" cy="210" rx="32" ry="20"/>
  </g>
  <!-- barrel hoops -->
  <g stroke="#2d1800" stroke-width="2" fill="none" opacity=".6">
    <line x1="28" y1="220" x2="92" y2="220"/>
    <line x1="28" y1="235" x2="92" y2="235"/>
    <line x1="120" y1="215" x2="176" y2="215"/>
    <line x1="120" y1="228" x2="176" y2="228"/>
    <line x1="224" y1="215" x2="280" y2="215"/>
    <line x1="224" y1="228" x2="280" y2="228"/>
    <line x1="308" y1="220" x2="372" y2="220"/>
    <line x1="308" y1="235" x2="372" y2="235"/>
  </g>
  <!-- candle glow -->
  <ellipse cx="200" cy="200" rx="60" ry="30" fill="#ffb347" opacity=".18"/>
  <ellipse cx="200" cy="200" rx="30" ry="15" fill="#ffd700" opacity=".22"/>
  <rect x="198" y="185" width="4" height="16" fill="#ffeaa0" opacity=".6"/>
  <ellipse cx="200" cy="183" rx="4" ry="6" fill="#fff" opacity=".5"/>
  <!-- ambient light on ceiling -->
  <ellipse cx="200" cy="0" rx="120" ry="50" fill="#c97d00" opacity=".12"/>
</svg>
SVG; }

// ── GREEN — Forest spa ───────────────────────────────────────────────────────
function scene_green(): string { return <<<SVG
<svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <!-- sky through canopy -->
  <rect width="400" height="280" fill="#0d2b0d"/>
  <ellipse cx="200" cy="0"   rx="220" ry="110" fill="#1a4d1a" opacity=".7"/>
  <ellipse cx="200" cy="-20" rx="130" ry="80"  fill="#2a6a2a" opacity=".4"/>
  <!-- light shafts -->
  <g opacity=".07" fill="#fff">
    <polygon points="160,0 180,0 220,280 200,280"/>
    <polygon points="210,0 228,0 265,280 247,280"/>
    <polygon points="130,0 148,0 185,280 167,280"/>
  </g>
  <!-- far trees -->
  <g fill="#0d2b0d" opacity=".9">
    <polygon points="0,180   30,60  60,180"/>
    <polygon points="50,185  85,55  120,185"/>
    <polygon points="100,175 140,45 180,175"/>
    <polygon points="150,180 185,50 220,180"/>
    <polygon points="200,175 240,42 280,175"/>
    <polygon points="250,180 290,52 330,180"/>
    <polygon points="300,175 340,48 380,175"/>
    <polygon points="350,180 385,58 400,180 400,280 0,280 0,180"/>
  </g>
  <!-- near trees -->
  <g fill="#0a200a">
    <polygon points="-10,280 30,120 70,280"/>
    <polygon points="60,280  110,100 160,280"/>
    <polygon points="140,280 195,90  250,280"/>
    <polygon points="220,280 275,105 330,280"/>
    <polygon points="300,280 350,115 400,280"/>
  </g>
  <!-- forest floor / pool -->
  <ellipse cx="200" cy="270" rx="220" ry="30" fill="#1a3d1a"/>
  <ellipse cx="200" cy="262" rx="120" ry="12" fill="#2d6b6b" opacity=".6"/>
  <!-- water reflections -->
  <g stroke="#4a9e9e" stroke-width="1" opacity=".3" fill="none">
    <ellipse cx="180" cy="262" rx="25" ry="4"/>
    <ellipse cx="220" cy="265" rx="18" ry="3"/>
  </g>
  <!-- mist at base -->
  <ellipse cx="200" cy="280" rx="300" ry="50" fill="#a8d8c8" opacity=".08"/>
  <ellipse cx="200" cy="280" rx="200" ry="30" fill="#c8e8d8" opacity=".07"/>
</svg>
SVG; }

// ── DARK — City nightlife ────────────────────────────────────────────────────
function scene_dark(): string { return <<<SVG
<svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <!-- night sky -->
  <rect width="400" height="280" fill="#0a0e22"/>
  <ellipse cx="200" cy="0" rx="300" ry="100" fill="#0f1840" opacity=".8"/>
  <!-- stars -->
  <g fill="rgba(255,255,255,0.7)">
    <circle cx="18"  cy="18"  r="1"/><circle cx="55"  cy="35"  r=".7"/>
    <circle cx="90"  cy="12"  r="1"/><circle cx="130" cy="28"  r=".8"/>
    <circle cx="160" cy="10"  r=".9"/><circle cx="195" cy="22"  r=".6"/>
    <circle cx="230" cy="8"   r="1"/><circle cx="265" cy="32"  r=".7"/>
    <circle cx="295" cy="14"  r=".9"/><circle cx="325" cy="24"  r=".8"/>
    <circle cx="358" cy="10"  r="1"/><circle cx="388" cy="30"  r=".6"/>
    <circle cx="42"  cy="55"  r=".7"/><circle cx="75"  cy="68"  r=".5"/>
    <circle cx="105" cy="48"  r=".8"/><circle cx="145" cy="62"  r=".6"/>
    <circle cx="175" cy="45"  r=".7"/><circle cx="212" cy="58"  r=".9"/>
    <circle cx="248" cy="44"  r=".6"/><circle cx="278" cy="65"  r=".7"/>
    <circle cx="312" cy="50"  r=".8"/><circle cx="345" cy="40"  r=".6"/>
    <circle cx="375" cy="60"  r=".7"/>
  </g>
  <!-- moon -->
  <circle cx="348" cy="52" r="26" fill="rgba(255,248,200,0.12)"/>
  <circle cx="356" cy="46" r="20" fill="#0a0e22"/>
  <!-- city building silhouettes -->
  <g fill="#0c1a36">
    <rect x="0"   y="155" width="45"  height="125"/>
    <rect x="43"  y="130" width="30"  height="150"/>
    <rect x="71"  y="168" width="26"  height="112"/>
    <rect x="95"  y="140" width="58"  height="140"/>
    <rect x="60"  y="118" width="16"  height="16"/>
    <rect x="151" y="158" width="36"  height="122"/>
    <rect x="185" y="118" width="48"  height="162"/>
    <rect x="185" y="100" width="20"  height="22"/>
    <rect x="231" y="148" width="52"  height="132"/>
    <rect x="281" y="132" width="36"  height="148"/>
    <rect x="315" y="158" width="42"  height="122"/>
    <rect x="355" y="142" width="45"  height="138"/>
  </g>
  <!-- lit windows -->
  <g fill="#ffd07a" opacity=".55">
    <rect x="6"   y="162" width="5" height="7"/><rect x="14"  y="162" width="5" height="7"/>
    <rect x="22"  y="162" width="5" height="7"/><rect x="6"   y="176" width="5" height="7"/>
    <rect x="22"  y="176" width="5" height="7"/>
    <rect x="48"  y="138" width="5" height="7"/><rect x="56"  y="138" width="5" height="7"/>
    <rect x="48"  y="152" width="5" height="7"/><rect x="56"  y="152" width="5" height="7"/>
    <rect x="48"  y="166" width="5" height="7"/>
    <rect x="100" y="148" width="5" height="7"/><rect x="110" y="148" width="5" height="7"/>
    <rect x="120" y="148" width="5" height="7"/><rect x="100" y="162" width="5" height="7"/>
    <rect x="120" y="162" width="5" height="7"/><rect x="110" y="176" width="5" height="7"/>
    <rect x="192" y="125" width="5" height="7"/><rect x="202" y="125" width="5" height="7"/>
    <rect x="192" y="140" width="5" height="7"/><rect x="212" y="140" width="5" height="7"/>
    <rect x="202" y="155" width="5" height="7"/><rect x="192" y="170" width="5" height="7"/>
    <rect x="286" y="140" width="5" height="7"/><rect x="296" y="140" width="5" height="7"/>
    <rect x="306" y="140" width="5" height="7"/><rect x="286" y="156" width="5" height="7"/>
    <rect x="306" y="156" width="5" height="7"/>
    <rect x="360" y="150" width="5" height="7"/><rect x="370" y="150" width="5" height="7"/>
    <rect x="380" y="150" width="5" height="7"/><rect x="360" y="165" width="5" height="7"/>
    <rect x="380" y="165" width="5" height="7"/>
  </g>
  <!-- neon street glow -->
  <rect x="0" y="258" width="400" height="22" fill="#0a0e22"/>
  <rect x="0" y="256" width="400" height="4" fill="#cc1126" opacity=".35"/>
  <ellipse cx="200" cy="258" rx="220" ry="12" fill="#cc1126" opacity=".08"/>
  <ellipse cx="90"  cy="260" rx="60"  ry="8"  fill="#0046ae" opacity=".18"/>
  <ellipse cx="300" cy="260" rx="60"  ry="8"  fill="#ffd400" opacity=".15"/>
</svg>
SVG; }

// ── BLUE — Luxury hotel ──────────────────────────────────────────────────────
function scene_blue(): string { return <<<SVG
<svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <!-- deep night sky -->
  <rect width="400" height="280" fill="#002058"/>
  <ellipse cx="200" cy="0"  rx="280" ry="130" fill="#003580" opacity=".7"/>
  <ellipse cx="200" cy="-30" rx="180" ry="90"  fill="#0046ae" opacity=".35"/>
  <!-- stars -->
  <g fill="rgba(255,255,255,0.5)">
    <circle cx="25"  cy="20" r=".9"/><circle cx="60"  cy="10" r=".7"/>
    <circle cx="95"  cy="30" r=".8"/><circle cx="140" cy="15" r=".9"/>
    <circle cx="170" cy="35" r=".6"/><circle cx="330" cy="18" r=".9"/>
    <circle cx="360" cy="8"  r=".7"/><circle cx="385" cy="28" r=".8"/>
  </g>
  <!-- grand hotel building -->
  <rect x="60"  y="80"  width="280" height="200" fill="#001540"/>
  <!-- rooftop ornament -->
  <rect x="155" y="60"  width="90"  height="24"  fill="#001540"/>
  <rect x="180" y="44"  width="40"  height="20"  fill="#001540"/>
  <rect x="193" y="28"  width="14"  height="18"  fill="#001540"/>
  <!-- classical columns -->
  <g fill="#001e52">
    <rect x="75"  y="130" width="16" height="150"/>
    <rect x="110" y="130" width="16" height="150"/>
    <rect x="145" y="130" width="16" height="150"/>
    <rect x="238" y="130" width="16" height="150"/>
    <rect x="273" y="130" width="16" height="150"/>
    <rect x="308" y="130" width="16" height="150"/>
  </g>
  <!-- column capitals -->
  <g fill="#002870">
    <rect x="72"  y="126" width="22" height="8" rx="2"/>
    <rect x="107" y="126" width="22" height="8" rx="2"/>
    <rect x="142" y="126" width="22" height="8" rx="2"/>
    <rect x="235" y="126" width="22" height="8" rx="2"/>
    <rect x="270" y="126" width="22" height="8" rx="2"/>
    <rect x="305" y="126" width="22" height="8" rx="2"/>
  </g>
  <!-- main entrance arch -->
  <path d="M170 280 L170 190 Q200 165 230 190 L230 280Z" fill="#001030"/>
  <!-- entrance light -->
  <ellipse cx="200" cy="198" rx="22" ry="14" fill="#ffd700" opacity=".18"/>
  <!-- lit windows (golden) -->
  <g fill="#ffd07a" opacity=".7">
    <rect x="80"  y="88"  width="18" height="24" rx="2"/>
    <rect x="108" y="88"  width="18" height="24" rx="2"/>
    <rect x="136" y="88"  width="18" height="24" rx="2"/>
    <rect x="164" y="88"  width="18" height="24" rx="2"/>
    <rect x="218" y="88"  width="18" height="24" rx="2"/>
    <rect x="246" y="88"  width="18" height="24" rx="2"/>
    <rect x="274" y="88"  width="18" height="24" rx="2"/>
    <rect x="302" y="88"  width="18" height="24" rx="2"/>
    <rect x="80"  y="130" width="14" height="20" rx="2" opacity=".5"/>
    <rect x="108" y="130" width="14" height="20" rx="2" opacity=".8"/>
    <rect x="136" y="130" width="14" height="20" rx="2" opacity=".5"/>
    <rect x="246" y="130" width="14" height="20" rx="2" opacity=".8"/>
    <rect x="274" y="130" width="14" height="20" rx="2" opacity=".5"/>
    <rect x="302" y="130" width="14" height="20" rx="2" opacity=".8"/>
  </g>
  <!-- ground glow -->
  <ellipse cx="200" cy="280" rx="240" ry="40" fill="#ffd700" opacity=".06"/>
  <!-- flag on top -->
  <rect x="198" y="14" width="2.5" height="15" fill="#c8c8c8" opacity=".6"/>
  <rect x="200" y="15" width="12"  height="4"  fill="#0046ae" opacity=".8"/>
  <rect x="200" y="19" width="12"  height="4"  fill="#ffd400" opacity=".8"/>
  <rect x="200" y="23" width="12"  height="4"  fill="#cc1126" opacity=".8"/>
</svg>
SVG; }

// ── LIGHT — Villa outdoor ────────────────────────────────────────────────────
function scene_light(): string { return <<<SVG
<svg viewBox="0 0 400 280" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <!-- bright sky -->
  <rect width="400" height="280" fill="#fff9e6"/>
  <ellipse cx="200" cy="0"   rx="280" ry="100" fill="#fff3c4" opacity=".8"/>
  <ellipse cx="200" cy="-20" rx="180" ry="70"  fill="#ffe88a" opacity=".4"/>
  <!-- sun -->
  <circle cx="70"  cy="60"  r="50" fill="#fff" opacity=".2"/>
  <circle cx="70"  cy="60"  r="32" fill="#fff7b0" opacity=".4"/>
  <circle cx="70"  cy="60"  r="20" fill="#fff5a0" opacity=".6"/>
  <!-- garden ground -->
  <path d="M0 220 Q80 205 200 214 Q320 224 400 210 L400 280 L0 280Z" fill="#4a7a28"/>
  <path d="M0 240 Q60 235 130 238 Q230 245 350 234 Q380 232 400 236 L400 280 L0 280Z" fill="#3d6820"/>
  <!-- garden path -->
  <path d="M185 280 Q195 240 200 220 Q205 200 210 280Z" fill="#d4c87a" opacity=".5"/>
  <!-- villa building -->
  <rect x="100" y="90" width="200" height="140" fill="#fff8e8"/>
  <rect x="110" y="100" width="180" height="130" fill="#fdf5e0"/>
  <!-- roof -->
  <path d="M90 90 L200 30 L310 90Z" fill="#e8d4a0"/>
  <path d="M95 90 L200 35 L305 90Z" fill="#f0ddb0"/>
  <!-- windows -->
  <g fill="#a8c8e8">
    <rect x="120" y="110" width="40" height="50" rx="3"/>
    <rect x="238" y="110" width="40" height="50" rx="3"/>
    <rect x="180" y="115" width="40" height="44" rx="3"/>
  </g>
  <!-- window frames -->
  <g stroke="#c8b888" stroke-width="2" fill="none">
    <rect x="120" y="110" width="40" height="50" rx="3"/>
    <rect x="238" y="110" width="40" height="50" rx="3"/>
    <rect x="180" y="115" width="40" height="44" rx="3"/>
  </g>
  <!-- arched entrance -->
  <path d="M178 230 L178 180 Q200 162 222 180 L222 230Z" fill="#c8b888"/>
  <path d="M180 230 L180 182 Q200 166 220 182 L220 230Z" fill="#e8d8b0"/>
  <!-- shutters -->
  <g fill="#c4a85a" opacity=".6">
    <rect x="114" y="110" width="9" height="50" rx="2"/>
    <rect x="157" y="110" width="9" height="50" rx="2"/>
    <rect x="232" y="110" width="9" height="50" rx="2"/>
    <rect x="275" y="110" width="9" height="50" rx="2"/>
  </g>
  <!-- garden hedge -->
  <g fill="#3a6018">
    <ellipse cx="85"  cy="225" rx="30" ry="22"/>
    <ellipse cx="315" cy="225" rx="30" ry="22"/>
    <ellipse cx="65"  cy="235" rx="22" ry="16"/>
    <ellipse cx="335" cy="235" rx="22" ry="16"/>
  </g>
  <!-- flowers -->
  <g fill="#cc1126" opacity=".7">
    <circle cx="88" cy="208" r="4"/><circle cx="76" cy="212" r="3"/>
    <circle cx="320" cy="208" r="4"/><circle cx="332" cy="212" r="3"/>
  </g>
  <g fill="#ffd400" opacity=".8">
    <circle cx="82" cy="215" r="3"/><circle cx="326" cy="215" r="3"/>
  </g>
</svg>
SVG; }

// ── HERO — Chisinau panorama (large, 800x500) ────────────────────────────────
function scene_hero_main(): string { return <<<SVG
<svg viewBox="0 0 800 500" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <!-- sky gradient layers -->
  <rect width="800" height="500" fill="#1a3a6e"/>
  <rect width="800" height="500" fill="#e08030" opacity=".28"/>
  <ellipse cx="580" cy="500" rx="460" ry="280" fill="#ff9a3c" opacity=".35"/>
  <ellipse cx="580" cy="380" rx="300" ry="160" fill="#ffb347" opacity=".28"/>
  <!-- sun on horizon -->
  <circle cx="580" cy="320" r="90" fill="#fff" opacity=".08"/>
  <circle cx="580" cy="320" r="60" fill="#ffd700" opacity=".18"/>
  <circle cx="580" cy="320" r="38" fill="#fff9c4" opacity=".32"/>
  <!-- light rays -->
  <g opacity=".04" fill="#fff">
    <polygon points="580,320 525,500 560,500"/>
    <polygon points="580,320 590,500 615,500"/>
    <polygon points="580,320 480,500 505,500"/>
    <polygon points="580,320 640,500 665,500"/>
  </g>
  <!-- far hills -->
  <path d="M0 320 Q120 280 280 300 Q440 320 580 288 Q700 265 800 282 L800 500 L0 500Z" fill="#2d5228" opacity=".6"/>
  <!-- city building silhouettes -->
  <!-- Parliament dome style -->
  <g fill="#0c1a30" opacity=".88">
    <rect x="60" y="200" width="160" height="180"/>
    <rect x="80" y="185" width="120" height="20"/>
    <ellipse cx="140" cy="185" rx="52" ry="58"/>
    <rect x="110" y="128" width="60" height="60"/>
    <!-- columns -->
    <rect x="70"  y="195" width="8" height="185"/>
    <rect x="88"  y="195" width="8" height="185"/>
    <rect x="106" y="195" width="8" height="185"/>
    <rect x="162" y="195" width="8" height="185"/>
    <rect x="180" y="195" width="8" height="185"/>
    <rect x="198" y="195" width="8" height="185"/>
    <!-- flag -->
    <rect x="138" y="70" width="3" height="60"/>
    <rect x="141" y="72" width="20" height="6"  fill="#0046ae" opacity=".9"/>
    <rect x="141" y="78" width="20" height="6"  fill="#ffd400" opacity=".9"/>
    <rect x="141" y="84" width="20" height="6"  fill="#cc1126" opacity=".9"/>
  </g>
  <!-- Triumphal Arch -->
  <g fill="#0c1a30" opacity=".82" transform="translate(290,230)">
    <rect x="0"   y="50" width="28"  height="120"/>
    <rect x="80"  y="50" width="28"  height="120"/>
    <rect x="0"   y="25" width="108" height="30"/>
    <path d="M28 50 Q54 22 80 50Z"/>
    <rect x="8"   y="0"  width="92"  height="28"/>
    <rect x="35"  y="-18" width="38" height="20"/>
  </g>
  <!-- other buildings -->
  <g fill="#0c1a30" opacity=".7">
    <rect x="440" y="235" width="55"  height="165"/>
    <rect x="455" y="215" width="25"  height="24"/>
    <rect x="500" y="248" width="70"  height="152"/>
    <rect x="575" y="230" width="50"  height="170"/>
    <rect x="575" y="210" width="20"  height="24"/>
    <rect x="630" y="242" width="60"  height="158"/>
    <rect x="695" y="235" width="50"  height="165"/>
    <rect x="748" y="248" width="52"  height="152"/>
  </g>
  <!-- lit windows on buildings -->
  <g fill="#ffd07a" opacity=".5">
    <rect x="448" y="244" width="6" height="9"/><rect x="460" y="244" width="6" height="9"/>
    <rect x="472" y="244" width="6" height="9"/><rect x="448" y="260" width="6" height="9"/>
    <rect x="472" y="260" width="6" height="9"/><rect x="460" y="276" width="6" height="9"/>
    <rect x="508" y="256" width="6" height="9"/><rect x="520" y="256" width="6" height="9"/>
    <rect x="532" y="256" width="6" height="9"/><rect x="544" y="256" width="6" height="9"/>
    <rect x="508" y="272" width="6" height="9"/><rect x="532" y="272" width="6" height="9"/>
    <rect x="583" y="238" width="6" height="9"/><rect x="595" y="238" width="6" height="9"/>
    <rect x="607" y="238" width="6" height="9"/><rect x="583" y="254" width="6" height="9"/>
    <rect x="607" y="254" width="6" height="9"/>
    <rect x="638" y="250" width="6" height="9"/><rect x="650" y="250" width="6" height="9"/>
    <rect x="662" y="250" width="6" height="9"/><rect x="674" y="250" width="6" height="9"/>
    <rect x="638" y="266" width="6" height="9"/><rect x="674" y="266" width="6" height="9"/>
    <rect x="703" y="243" width="6" height="9"/><rect x="715" y="243" width="6" height="9"/>
    <rect x="727" y="243" width="6" height="9"/><rect x="703" y="259" width="6" height="9"/>
    <rect x="727" y="259" width="6" height="9"/>
  </g>
  <!-- vineyard foreground -->
  <path d="M0 400 Q200 382 400 392 Q600 402 800 386 L800 500 L0 500Z" fill="#1e3d18"/>
  <path d="M0 430 Q100 425 200 428 Q350 435 500 422 Q650 412 800 426 L800 500 L0 500Z" fill="#162e12"/>
  <!-- vine rows -->
  <g fill="#0d200e" opacity=".8">
    <ellipse cx="50"  cy="452" rx="18" ry="9"/>
    <ellipse cx="110" cy="455" rx="18" ry="9"/>
    <ellipse cx="170" cy="452" rx="18" ry="9"/>
    <ellipse cx="230" cy="455" rx="18" ry="9"/>
    <ellipse cx="290" cy="452" rx="18" ry="9"/>
    <ellipse cx="350" cy="455" rx="18" ry="9"/>
  </g>
  <!-- river / atmospheric haze -->
  <ellipse cx="400" cy="395" rx="400" ry="18" fill="#4a8ab0" opacity=".12"/>
  <!-- Moldova flag strip (subtle) -->
  <rect x="0" y="0" width="800" height="4" fill="#0046ae" opacity=".15"/>
  <rect x="0" y="4" width="800" height="4" fill="#ffd400" opacity=".15"/>
  <rect x="0" y="8" width="800" height="4" fill="#cc1126" opacity=".15"/>
</svg>
SVG; }

// ── HERO secondary — Wine cellar entrance ───────────────────────────────────
function scene_hero_secondary(): string { return <<<SVG
<svg viewBox="0 0 500 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
  <rect width="500" height="300" fill="#3d2000"/>
  <ellipse cx="250" cy="20" rx="300" ry="140" fill="#8a5200" opacity=".6"/>
  <ellipse cx="250" cy="0"  rx="200" ry="90"  fill="#c97d00" opacity=".3"/>
  <!-- tunnel arches -->
  <ellipse cx="250" cy="130" rx="180" ry="90"  fill="none" stroke="#5a3500" stroke-width="22"/>
  <ellipse cx="250" cy="130" rx="120" ry="60"  fill="none" stroke="#4a2c00" stroke-width="16"/>
  <ellipse cx="250" cy="130" rx="72"  ry="40"  fill="none" stroke="#3d2200" stroke-width="12"/>
  <ellipse cx="250" cy="130" rx="38"  ry="22"  fill="#1e1000"/>
  <!-- floor -->
  <path d="M0 300 L50 210 L450 210 L500 300Z" fill="#2a1600" opacity=".9"/>
  <!-- barrels -->
  <g fill="#5c3a10" stroke="#3d2600" stroke-width="1.2">
    <ellipse cx="80"  cy="255" rx="36" ry="22"/><rect x="44"  y="233" width="72" height="44" rx="7"/><ellipse cx="80"  cy="233" rx="36" ry="22"/>
    <ellipse cx="180" cy="250" rx="30" ry="18"/><rect x="150" y="232" width="60" height="36" rx="6"/><ellipse cx="180" cy="232" rx="30" ry="18"/>
    <ellipse cx="320" cy="250" rx="30" ry="18"/><rect x="290" y="232" width="60" height="36" rx="6"/><ellipse cx="320" cy="232" rx="30" ry="18"/>
    <ellipse cx="420" cy="255" rx="36" ry="22"/><rect x="384" y="233" width="72" height="44" rx="7"/><ellipse cx="420" cy="233" rx="36" ry="22"/>
  </g>
  <!-- candle light -->
  <ellipse cx="250" cy="215" rx="70" ry="35" fill="#ffb347" opacity=".16"/>
  <ellipse cx="250" cy="215" rx="35" ry="18" fill="#ffd700" opacity=".2"/>
  <rect x="248" y="196" width="4" height="20" fill="#ffeaa0" opacity=".7"/>
  <ellipse cx="250" cy="194" rx="5" ry="7" fill="#fff" opacity=".5"/>
</svg>
SVG; }
