<?php
require __DIR__ . "/inc/bootstrap.php";
$u = need_user("studio");
?><!doctype html>
<html lang="es"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($u["sname"]) ?> · Ink CRM</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Cinzel:wght@500;700&family=Jost:wght@400;600&family=Nunito:wght@500;700&family=Orbitron:wght@500;700&family=Quicksand:wght@500;700&family=Rye&family=Shippori+Mincho:wght@500;700&display=swap">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<style>
:root{--bg:#f6f3ef;--cd:#fff;--tx:#1c1a19;--mu:#6b655f;--ac:#c62f3a;--bd:#e7e1da;--ok:#1f8a4c;--wr:#b7791f;--r:16px;--sh:0 1px 2px rgba(0,0,0,.05),0 8px 24px rgba(0,0,0,.05);color-scheme:light;box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#121212;--cd:#1e1e20;--tx:#f2eee9;--mu:#a39c94;--ac:#ef4d58;--bd:#302e2c;--ok:#4cc380;--wr:#e0a84a;--sh:0 1px 2px rgba(0,0,0,.4);color-scheme:dark}}
:root[data-theme="dark"]{--bg:#121212;--cd:#1e1e20;--tx:#f2eee9;--mu:#a39c94;--ac:#ef4d58;--bd:#302e2c;--ok:#4cc380;--wr:#e0a84a;--sh:0 1px 2px rgba(0,0,0,.4);color-scheme:dark}
:root[data-skin="girly"]{--bg:#fff0f6;--cd:#fff;--tx:#4a2640;--mu:#9a6b8a;--ac:#e0489a;--bd:#f7cfe3;--ok:#2f9e75;--wr:#d98a1f;--r:26px;--bt:99px;--sh:0 10px 28px rgba(224,72,154,.16);--orn:"✿";--ff:Quicksand,"Trebuchet MS",system-ui,sans-serif;--pat:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64'%3E%3Ctext x='6' y='26' font-size='18' fill='%23e0489a' fill-opacity='.14'%3E%E2%99%A5%3C/text%3E%3Ccircle cx='46' cy='46' r='3' fill='%23e0489a' fill-opacity='.14'/%3E%3C/svg%3E");color-scheme:light}
:root[data-skin="tradicional"]{--bg:#f1e6c8;--cd:#fbf4de;--tx:#1d2a44;--mu:#6b6046;--ac:#b3262e;--bd:#cdb98a;--cb:#1d2a44;--bw:2px;--ok:#2e6b3a;--wr:#c98a14;--r:4px;--bt:4px;--sh:5px 5px 0 #1d2a44;--bs:3px 3px 0 #1d2a44;--tt:uppercase;--ls:.04em;--orn:"★";--ff:Georgia,"Times New Roman",serif;--fh:Rye,Georgia,serif;--pat:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='44' height='44'%3E%3Cpath d='M22 2l4 16 16 4-16 4-4 16-4-16L2 22l16-4z' fill='%23b3262e' fill-opacity='.09'/%3E%3C/svg%3E");color-scheme:light}
:root[data-skin="blackwork"]{--bg:#0a0a0a;--cd:#151515;--tx:#f2f2f2;--mu:#9a9a9a;--ac:#c1121f;--bd:#2b2b2b;--cb:#3a3a3a;--ok:#6fcf97;--wr:#e0b341;--r:2px;--bt:2px;--sh:none;--tt:uppercase;--ls:.12em;--orn:"✠";--fh:Cinzel,Georgia,serif;--pat:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48'%3E%3Cpath d='M0 48L48 0M-6 6L6-6M42 54L54 42' stroke='%23fff' stroke-opacity='.05'/%3E%3Cpath d='M24 20v8M20 24h8' stroke='%23c1121f' stroke-opacity='.3'/%3E%3C/svg%3E");color-scheme:dark}
:root[data-skin="fineline"]{--bg:#fafafa;--cd:#fff;--tx:#111;--mu:#777;--ac:#111;--bd:#e6e6e6;--ok:#2a7a4b;--wr:#a8741a;--r:6px;--bt:6px;--sh:none;--orn:"—";--ff:Jost,system-ui,sans-serif;--pat:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24'%3E%3Ccircle cx='2' cy='2' r='1' fill='%23000' fill-opacity='.13'/%3E%3C/svg%3E");color-scheme:light}
:root[data-skin="neon"]{--bg:#0b0b1a;--cd:#15152b;--tx:#eaf0ff;--mu:#8a93c9;--ac:#d6249f;--bd:#2a2a55;--cb:#d6249f;--ok:#00e676;--wr:#ffd600;--r:14px;--bt:10px;--sh:0 0 18px rgba(214,36,159,.35);--bs:0 0 14px rgba(214,36,159,.6);--tt:uppercase;--ls:.08em;--orn:"▸";--fh:Orbitron,system-ui,sans-serif;--pat:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Cpath d='M40 0H0V40' fill='none' stroke='%23d6249f' stroke-opacity='.16'/%3E%3C/svg%3E");color-scheme:dark}
:root[data-skin="irezumi"]{--bg:#14110f;--cd:#1f1a17;--tx:#f3e9dc;--mu:#b09f8a;--ac:#c8102e;--bd:#3a2f28;--cb:#6b4f2a;--ok:#7fb069;--wr:#d4a437;--r:6px;--bt:4px;--sh:inset 0 0 0 3px #1f1a17,inset 0 0 0 4px rgba(212,164,55,.55);--orn:"❖";--ff:"Shippori Mincho",Georgia,serif;--pat:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='20'%3E%3Cg fill='none' stroke='%23d4a437' stroke-opacity='.18'%3E%3Ccircle cx='20' cy='20' r='18'/%3E%3Ccircle cx='20' cy='20' r='12'/%3E%3Ccircle cx='20' cy='20' r='6'/%3E%3Ccircle cx='0' cy='10' r='18'/%3E%3Ccircle cx='0' cy='10' r='12'/%3E%3Ccircle cx='0' cy='10' r='6'/%3E%3Ccircle cx='40' cy='10' r='18'/%3E%3Ccircle cx='40' cy='10' r='12'/%3E%3Ccircle cx='40' cy='10' r='6'/%3E%3C/g%3E%3C/svg%3E");color-scheme:dark}
:root[data-skin="acuarela"]{--bg:#eef6fb;--cd:#fff;--tx:#24324a;--mu:#6a7f99;--ac:#7a5cc9;--bd:#d3e3f0;--ok:#2a9d8f;--wr:#e09a2b;--r:26px;--bt:20px;--sh:0 12px 32px rgba(122,92,201,.16);--orn:"❀";--ff:Nunito,system-ui,sans-serif;--pat:radial-gradient(circle at 12% 8%,rgba(122,92,201,.22),transparent 38%),radial-gradient(circle at 88% 18%,rgba(42,157,143,.2),transparent 36%),radial-gradient(circle at 60% 92%,rgba(233,162,59,.18),transparent 40%);color-scheme:light}
html{scroll-padding-top:env(safe-area-inset-top,0px)}
*{box-sizing:border-box}
body{margin:0;background-color:var(--bg);background-image:var(--pat,none);background-attachment:fixed;color:var(--tx);font:16px/1.45 var(--ff,system-ui,-apple-system,"Segoe UI",Roboto,sans-serif);-webkit-font-smoothing:antialiased}
h1,h2,h3,nav .brand{font-family:var(--fh,inherit);text-transform:var(--tt,none);letter-spacing:var(--ls,0)}
h1{font-size:20px;margin:0}h2{margin:0 0 8px;font-size:20px}h3{margin:18px 0 8px;font-size:16px}
h2::before,h3::before{content:var(--orn,"");color:var(--ac);margin-right:.45em}
button,input,select,textarea{font:inherit;color:inherit}
small,.mu{color:var(--mu)}.pos{color:var(--ok)}.neg{color:var(--ac)}
nav{position:fixed;left:0;right:0;bottom:0;z-index:5;display:flex;background:var(--cd);border-top:1px solid var(--cb,var(--bd));padding-bottom:env(safe-area-inset-bottom,0px)}
nav .brand,nav .me{display:none}
#nv{display:flex;flex:1}
#nv button{flex:1;background:none;border:0;padding:8px 2px 7px;font-size:11px;color:var(--mu);display:flex;flex-direction:column;align-items:center;gap:2px;cursor:pointer}
#nv button span{font-size:21px;line-height:1.1}#nv button.on{color:var(--ac);font-weight:700}
#wrap{padding:14px 14px 100px;max-width:1120px;margin:auto}
.top{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:10px}
.hd{display:flex;align-items:center;gap:10px;min-width:0}.hd h1{white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
#lg{height:40px;max-width:90px;object-fit:contain;display:none;border-radius:8px}#st{font-size:14px}
.ban{text-align:center;letter-spacing:.35em;font-size:13px;color:var(--ac);white-space:nowrap;overflow:hidden;margin:0 0 12px;opacity:.85}
.cd{background:var(--cd);border:var(--bw,1px) solid var(--cb,var(--bd));border-radius:var(--r);padding:16px;margin-bottom:14px;box-shadow:var(--sh)}
.b1,.b2{border-radius:var(--bt,12px);padding:11px 18px;border:1px solid var(--ac);cursor:pointer;text-decoration:none;display:inline-block;text-align:center;min-height:44px;font-weight:600;box-shadow:var(--bs,none);text-transform:var(--tt,none);transition:transform .12s}
.b1:active,.b2:active{transform:scale(.97)}
.b1{background:var(--ac);color:#fff}.b2{background:var(--cd);color:var(--tx);border-color:var(--cb,var(--bd))}
.wb{background:#25d366;border-color:#25d366;color:#063}
.hero{position:relative;overflow:hidden;border-radius:var(--r);padding:20px;margin-bottom:14px;color:#fff;background:var(--ac);background:linear-gradient(135deg,var(--ac),color-mix(in srgb,var(--ac) 55%,#000));box-shadow:var(--sh)}
.hero .mk{position:absolute;right:-6px;top:-12px;font-size:110px;opacity:.16;line-height:1;pointer-events:none}
.hero small{color:rgba(255,255,255,.82)}.hero .big{font-size:36px;font-weight:800;display:block;line-height:1.1}.hero h2::before{content:none}
.pb{height:8px;border-radius:9px;background:rgba(255,255,255,.25);margin-top:10px}.pb i{display:block;height:100%;border-radius:9px;background:#fff}
.kp{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:14px}
.kp>div{background:var(--cd);border:var(--bw,1px) solid var(--cb,var(--bd));border-radius:var(--r);padding:12px;box-shadow:var(--sh)}
.kp .ic{display:inline-grid;place-items:center;width:34px;height:34px;border-radius:10px;background:color-mix(in srgb,var(--ac) 14%,var(--cd));margin-bottom:6px}
.kp small{display:block}.kp b{font-size:21px}
.row{display:grid;grid-template-columns:auto 1fr auto;gap:12px;align-items:center;padding:12px 2px;border-bottom:1px solid var(--bd);cursor:pointer}.row:last-child{border:0}
.av{width:42px;height:42px;border-radius:50%;background:color-mix(in srgb,var(--ac) 16%,var(--cd));color:var(--ac);display:grid;place-items:center;font-weight:700;flex:none}
.in{display:flex;flex-direction:column;min-width:0}.in small{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.rt{display:flex;flex-direction:column;align-items:flex-end;gap:3px}
.pill{font-size:12px;font-weight:600;padding:2px 10px;border-radius:99px;border:1px solid var(--bd)}
.p-Confirmada{color:var(--ok);border-color:var(--ok)}.p-Pendiente{color:var(--wr);border-color:var(--wr)}.p-Cancelada,.p-Nopresentó{color:var(--ac);border-color:var(--ac)}.p-Completada{color:var(--mu)}
.em{text-align:center;color:var(--mu);padding:18px 8px}.em span{display:block;font-size:40px;opacity:.7}
.cal{display:grid;grid-template-columns:repeat(7,1fr);gap:4px}.cal>small{text-align:center;font-weight:600}
.d{min-height:56px;border:1px solid var(--bd);border-radius:calc(var(--r)/2);padding:4px;background:var(--bg);cursor:pointer;overflow:hidden;font-size:12px}
.d.x{border:0;background:none;cursor:default}.d.t span{background:var(--ac);color:#fff;border-radius:99px;padding:0 6px;font-weight:700}.d.s{outline:2px solid var(--ac)}
.d i{display:none;font-style:normal;background:var(--ac);color:#fff;border-radius:5px;padding:1px 5px;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.d i.p-Pendiente{background:var(--wr)}.d i.p-Completada{background:var(--ok)}
.d em{display:none;color:var(--mu);font-style:normal}.d .n{display:inline-block;background:var(--ac);color:#fff;border-radius:99px;padding:0 6px;margin-top:4px}
.ch{display:flex;gap:8px;align-items:flex-end}.bc{flex:1;text-align:center}.bb{height:110px;display:flex;gap:3px;align-items:flex-end;justify-content:center}
.bb i{width:40%;background:var(--ok);border-radius:5px 5px 0 0;min-height:2px}.bb i.e{background:var(--ac)}
.g{display:grid;grid-template-columns:1fr 1fr;gap:10px}.g .w{grid-column:1/-1}
label{display:block;font-size:13px;color:var(--mu)}
input,select,textarea{width:100%;margin-top:4px;padding:11px 12px;border:1px solid var(--bd);border-radius:calc(var(--r)/1.6);background:var(--bg);font-size:16px}
input:focus,select:focus,textarea:focus{outline:2px solid var(--ac);outline-offset:0}
.bar{display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end;margin-top:14px}
#modal{position:fixed;inset:0;background:rgba(0,0,0,.55);display:none;align-items:flex-end;justify-content:center;z-index:10}#modal.on{display:flex}
.sh2{background:var(--cd);width:100%;max-width:660px;max-height:94vh;overflow:auto;border-radius:22px 22px 0 0;padding:18px 18px calc(18px + env(safe-area-inset-bottom,0px));animation:up .22s ease;border:var(--bw,1px) solid var(--cb,transparent)}
@keyframes up{from{transform:translateY(30px);opacity:0}}
canvas{width:100%;height:200px;background:#fff;border:2px dashed var(--bd);border-radius:12px;touch-action:none;display:block}
.ck{display:flex;gap:10px;align-items:flex-start;margin:7px 0;color:var(--tx);font-size:15px}.ck input{width:22px;height:22px;margin:0;flex:none;accent-color:var(--ac)}
.kv{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin:10px 0}.kv>div{background:var(--bg);border-radius:12px;padding:8px 10px}
.wa{white-space:pre-wrap;background:#dcf8c6;color:#111;border-radius:14px 14px 14px 3px;padding:12px 14px;font-size:14.5px;line-height:1.4;max-height:46vh;overflow:auto}
#lock{position:fixed;inset:0;background:var(--bg);background-image:var(--pat,none);z-index:20;display:none;align-items:center;justify-content:center;padding:20px}#lock.on{display:flex}#lock .cd{width:100%;max-width:380px;text-align:center}#lock label{text-align:left}
.sks{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px}
.sk{display:flex;flex-direction:column;align-items:flex-start;gap:4px;padding:12px;border-radius:14px;border:2px solid var(--bd);cursor:pointer;text-align:left}.sk.on{border-color:var(--ac)}.sk .m{font-size:26px}.sk .sw{display:flex;gap:4px}.sk .sw i{width:16px;height:16px;border-radius:50%}
@media(min-width:640px){.d{min-height:92px}.d i,.d em{display:block}.d .n{display:none}.kp{grid-template-columns:repeat(3,1fr)}}
@media(min-width:860px){nav{top:0;right:auto;width:224px;flex-direction:column;padding:18px 12px;border-top:0;border-right:1px solid var(--cb,var(--bd))}nav .brand{display:flex;align-items:center;gap:10px;padding:4px 10px 18px;font-size:18px}nav .brand img{height:34px;max-width:60px;object-fit:contain}nav .brand span{font-size:28px}#nv{flex:none;flex-direction:column;gap:4px}#nv button{flex:none;flex-direction:row;font-size:15px;padding:12px 14px;gap:12px;border-radius:var(--bt,12px);text-align:left}#nv button.on{background:var(--ac);color:#fff}nav .me{display:flex;gap:10px;align-items:center;margin-top:auto;padding:12px 6px 0;border-top:1px solid var(--bd)}#wrap{margin-left:224px;max-width:none;padding:22px 32px 40px}#modal{align-items:center}.sh2{border-radius:var(--r)}.g2{display:grid;grid-template-columns:1fr 1fr;gap:16px}h1{font-size:25px}}
#fx{position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0}#wrap{position:relative;z-index:1}
.f{position:absolute;color:var(--ac);opacity:.3;user-select:none;will-change:transform;animation-timing-function:ease-in-out;animation-iteration-count:infinite}
.f.rise{animation-name:rise}.f.fall{animation-name:fall}.f.twk{animation-name:twk}.f.drift{animation-name:drift}.f.pulse{animation-name:pulse}
@keyframes rise{0%{transform:translate(0,0) rotate(0);opacity:0}10%{opacity:.45}50%{transform:translate(18px,-55vh) rotate(15deg)}100%{transform:translate(-10px,-115vh) rotate(-10deg);opacity:0}}
@keyframes fall{0%{transform:translate(0,0) rotate(0);opacity:0}10%{opacity:.55}100%{transform:translate(70px,115vh) rotate(360deg);opacity:0}}
@keyframes twk{0%,100%{opacity:.08;transform:scale(.7)}50%{opacity:.6;transform:scale(1.25) rotate(20deg)}}
@keyframes drift{0%,100%{transform:translate(0,0) rotate(0)}50%{transform:translate(32px,-26px) rotate(12deg)}}
@keyframes pulse{0%,100%{opacity:.06}50%{opacity:.55;text-shadow:0 0 12px currentColor}}
@keyframes pop{0%,100%{transform:scale(1)}40%{transform:scale(1.35) rotate(-8deg)}}
@keyframes wig{0%,100%{transform:rotate(0)}25%{transform:rotate(-14deg) scale(1.2)}75%{transform:rotate(14deg) scale(1.2)}}
@keyframes swing{0%,100%{transform:rotate(0)}30%{transform:rotate(20deg)}60%{transform:rotate(-14deg)}}
@keyframes flick{0%,100%{opacity:1}20%{opacity:.25}40%{opacity:1}60%{opacity:.5}}
@keyframes zap{0%,100%{filter:none}50%{filter:drop-shadow(0 0 8px var(--ac)) brightness(1.5)}}
@keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-7px)}}
@keyframes flt{0%,100%{transform:translateY(0) rotate(0)}50%{transform:translateY(8px) rotate(6deg)}}
@keyframes grow{from{transform:scaleY(0)}}@keyframes fill{from{width:0}}
@keyframes beat{0%,100%{box-shadow:0 0 0 0 color-mix(in srgb,var(--ac) 55%,transparent)}50%{box-shadow:0 0 0 7px transparent}}
@keyframes glow{0%,100%{box-shadow:0 0 10px var(--ac)}50%{box-shadow:0 0 22px var(--ac),0 0 38px color-mix(in srgb,var(--ac) 50%,transparent)}}
@keyframes marq{to{transform:translateX(-50%)}}
@keyframes bgm{to{background-position:240px 240px}}@keyframes bgw{0%,100%{background-position:0 0}50%{background-position:40% 30%}}
@keyframes enter{from{opacity:0;transform:translateY(14px)}}
@keyframes bounce{0%{opacity:0;transform:translateY(26px) scale(.96)}60%{transform:translateY(-7px) scale(1.01)}100%{opacity:1;transform:none}}
@keyframes stamp{0%{opacity:0;transform:scale(1.12) rotate(-1.5deg)}60%{opacity:1;transform:scale(.98)}100%{transform:none}}
@keyframes glitch{0%{opacity:0;transform:translateX(-8px)}30%{opacity:1;transform:translateX(5px)}50%{opacity:.4;transform:translateX(-3px)}100%{opacity:1;transform:none}}
@keyframes ink{from{opacity:0;filter:blur(8px);transform:scale(1.02)}}@keyframes bloom{from{opacity:0;filter:blur(6px);transform:scale(.96)}}
body{background-size:var(--bgs,auto);animation:var(--bga,none) 90s linear infinite}
.ban{text-align:left}.ban span{display:inline-block;animation:marq 55s linear infinite}.ban:hover span{animation-play-state:paused}
main.in>*{animation:var(--en,enter) .6s cubic-bezier(.2,.7,.2,1) both}main.in>*:nth-child(2){animation-delay:.07s}main.in>*:nth-child(3){animation-delay:.14s}main.in>*:nth-child(4){animation-delay:.21s}
main.in .bb i{animation:grow .9s cubic-bezier(.2,.7,.2,1) both}main.in .bb i.e{animation-delay:.12s}main.in .pb i{animation:fill 1.1s cubic-bezier(.2,.7,.2,1) both}
.cd,.kp>div,.hero,.sk,.row,.d,.av,#nv button,.pill{transition:transform .25s cubic-bezier(.2,.7,.2,1),box-shadow .25s,border-color .25s,background-color .25s,padding .2s,color .2s}
.cd{position:relative;overflow:hidden}.cd:hover{border-color:var(--hb,color-mix(in srgb,var(--ac) 45%,var(--cb,var(--bd))))}
.cd::after{content:"";position:absolute;inset:0;background:linear-gradient(115deg,transparent 35%,var(--shm,transparent) 50%,transparent 65%);transform:translateX(-120%);transition:transform .9s;pointer-events:none}.cd:hover::after{transform:translateX(120%)}
.kp>div:hover,.sk:hover{transform:var(--hl,translateY(-4px));box-shadow:var(--hs,0 12px 28px rgba(0,0,0,.14));border-color:var(--ac)}
.hero:hover{transform:translateY(-2px)}.hero .mk{animation:flt 6s ease-in-out infinite}
.row:hover{background:color-mix(in srgb,var(--ac) 7%,transparent);padding-left:8px}.row:hover .av{transform:rotate(-8deg) scale(1.1)}.row:hover .pill{transform:scale(1.08)}
.d:not(.x):hover{transform:translateY(-2px) scale(1.04);border-color:var(--ac);position:relative;z-index:1}.d.t span{animation:beat 2.2s infinite}
#nv button:hover{color:var(--ac)}#nv button:hover span{animation:var(--hv,pop) .55s}
.b1,.b2{position:relative;overflow:hidden}.b1::after{content:"";position:absolute;inset:0;background:linear-gradient(110deg,transparent 30%,rgba(255,255,255,.4) 50%,transparent 70%);transform:translateX(-120%);transition:transform .6s}.b1:hover::after{transform:translateX(120%)}
.b1:hover{transform:var(--bh,translateY(-2px));filter:brightness(1.07)}.b2:hover{border-color:var(--ac);color:var(--ac)}.b1:active,.b2:active{transform:scale(.96)}
:root[data-skin="girly"]{--hv:wig;--en:bounce;--bh:translateY(-3px) scale(1.05);--hs:0 14px 32px rgba(224,72,154,.3);--shm:rgba(255,255,255,.8);--bga:bgm}
:root[data-skin="tradicional"]{--hv:swing;--en:stamp;--hl:translate(-3px,-3px);--hs:8px 8px 0 #1d2a44;--bh:translate(-2px,-2px);--bga:bgm}
:root[data-skin="tradicional"] .b1:hover,:root[data-skin="tradicional"] .b2:hover{box-shadow:5px 5px 0 #1d2a44}:root[data-skin="tradicional"] .b1:active,:root[data-skin="tradicional"] .b2:active{transform:translate(3px,3px);box-shadow:0 0 0 #1d2a44}
:root[data-skin="blackwork"]{--hv:flick;--en:ink;--hb:#c1121f;--hs:0 0 0 1px #c1121f,0 10px 30px rgba(193,18,31,.3);--shm:rgba(193,18,31,.16);--bga:bgm}
:root[data-skin="blackwork"] .b2:hover{background:var(--ac);color:#fff}:root[data-skin="blackwork"] h1,:root[data-skin="blackwork"] h2{transition:letter-spacing .3s}:root[data-skin="blackwork"] .cd:hover h3{letter-spacing:.2em}
:root[data-skin="fineline"]{--hv:pop;--en:enter;--hs:0 6px 18px rgba(0,0,0,.08);--bga:bgm}:root[data-skin="fineline"] .row:hover{padding-left:14px}
:root[data-skin="neon"]{--hv:zap;--en:glitch;--hb:#00e5ff;--hs:0 0 30px rgba(214,36,159,.7),0 0 60px rgba(214,36,159,.25);--shm:rgba(0,229,255,.2);--bga:bgm}
:root[data-skin="neon"] .b1{animation:glow 2.4s ease-in-out infinite}:root[data-skin="neon"] h1,:root[data-skin="neon"] h2,:root[data-skin="neon"] h3,:root[data-skin="neon"] .ban{text-shadow:0 0 10px color-mix(in srgb,var(--ac) 70%,transparent)}:root[data-skin="neon"] .hero{animation:glow 3s ease-in-out infinite}
:root[data-skin="irezumi"]{--hv:floaty;--en:ink;--hb:#d4a437;--hs:inset 0 0 0 3px #1f1a17,inset 0 0 0 4px #d4a437,0 0 28px rgba(200,16,46,.35);--shm:rgba(212,164,55,.22);--bga:bgm}
:root[data-skin="acuarela"]{--hv:floaty;--en:bloom;--hs:0 16px 40px rgba(122,92,201,.28);--shm:rgba(255,255,255,.7);--bgs:150% 150%;--bga:bgw}
:root:not([data-skin]){--hv:pop;--shm:rgba(255,255,255,.35)}
@media (prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition:none!important}#fx{display:none}}

/* ================= Rediseño profesional ================= */
:root:not([data-skin]){--ff:Inter,system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;--fh:Inter,system-ui,sans-serif;--r:14px}
:root{--ease:cubic-bezier(.2,.7,.2,1)}
body{font-size:15px;line-height:1.5}
h1{font-size:22px;font-weight:700;letter-spacing:-.02em}
h2{font-size:18px;font-weight:700;letter-spacing:-.015em;margin:0 0 12px}
h3{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--mu);margin:0 0 14px}
h3::before{content:none}
.wr{color:var(--wr)}
.cd{padding:20px;margin-bottom:16px}
.cd::after{display:none}
.top{margin-bottom:18px}
.hd #lg{height:36px}
.ban{margin-bottom:16px}
/* botones */
.b1,.b2{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 18px;font-size:14px;font-weight:600;letter-spacing:0}
.ic{width:18px;height:18px;flex:none}
.b1:hover{transform:none;filter:brightness(1.08)}
/* formularios */
label{font-size:12px;font-weight:600;letter-spacing:.02em}
input,select,textarea{padding:11px 13px;transition:border-color .15s,box-shadow .15s}
input:focus,select:focus,textarea:focus{outline:none;border-color:var(--ac);box-shadow:0 0 0 3px color-mix(in srgb,var(--ac) 22%,transparent)}
/* tarjetas y listas */
.kp{gap:12px;margin-bottom:16px}.kp>div{padding:16px}.kp b{font-size:22px;font-weight:700;letter-spacing:-.02em}.kp small{font-size:12px}
.kp>div:hover,.sk:hover{transform:none}
.row{padding:14px 4px}.row:hover{padding-left:4px}.row:hover .av,.row:hover .pill{transform:none}
:root[data-skin] .row:hover{padding-left:4px}
.hero{padding:24px}.hero .big{font-size:38px;letter-spacing:-.03em}
#nv button:hover span{animation:none}
nav{backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)}
.me .lo{margin-left:auto;display:grid;place-items:center;width:34px;height:34px;border-radius:10px;color:var(--mu);flex:none}.me .lo:hover{color:var(--ac)}
/* calendario */
.cal{gap:6px}
.cal>small{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:4px 0}
.d{display:flex;flex-direction:column;gap:3px;min-height:64px;padding:6px;border-radius:10px}
.d>span{align-self:flex-start;min-width:22px;text-align:center;font-size:12px;font-weight:600}
.d i{display:block!important;font-size:10.5px;font-weight:600;line-height:1.55;padding:1px 6px;border-radius:6px;cursor:pointer;transition:filter .15s}
.d i:hover,.d i:focus-visible{filter:brightness(1.12);outline:2px solid var(--tx);outline-offset:1px}
.d em{display:block;font-size:10.5px}.d .n{display:none}
.d:not(.x):hover{transform:none;box-shadow:0 4px 14px rgba(0,0,0,.1)}
@media(max-width:639px){.d{min-height:58px;padding:4px}.d i{font-size:9.5px;padding:0 3px}.d em{display:none}}
@media(min-width:640px){.d{min-height:104px}}
/* ventanas / detalle de cita */
#modal{background:rgba(10,10,14,.5);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px)}
.sh2{padding:22px 22px calc(22px + env(safe-area-inset-bottom,0px));max-width:600px;box-shadow:0 30px 80px rgba(0,0,0,.35)}
.mh{display:flex;gap:14px;align-items:center;margin-bottom:18px}
.mh .mt{flex:1;min-width:0}
.mh h2{margin:0;font-size:20px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.mh h2::before{content:none}
.mh p{margin:2px 0 0;color:var(--mu);font-size:13px;text-transform:capitalize}
.av.lg{width:52px;height:52px;font-size:17px}
.x{width:36px;height:36px;border-radius:50%;border:1px solid var(--cb,var(--bd));background:var(--bg);color:var(--mu);display:grid;place-items:center;cursor:pointer;flex:none;padding:0}
.x:hover{color:var(--ac);border-color:var(--ac)}
.pay{display:grid;grid-template-columns:repeat(3,1fr);gap:10px 14px;padding:16px;border-radius:calc(var(--r)*.8);background:color-mix(in srgb,var(--ac) 6%,var(--bg));border:1px solid var(--bd);margin-bottom:12px}
.pay small,.it small{display:block;font-size:11px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--mu)}
.pay b{font-size:20px;font-weight:700;letter-spacing:-.02em}
.pb2{grid-column:1/-1;height:6px;border-radius:9px;background:color-mix(in srgb,var(--mu) 22%,transparent);overflow:hidden}
.pb2 i{display:block;height:100%;border-radius:9px;background:var(--ok);animation:fill .8s var(--ease) both}
.info{display:grid;grid-template-columns:1fr 1fr;gap:1px;border:1px solid var(--bd);border-radius:calc(var(--r)*.8);overflow:hidden;background:var(--bd);margin-bottom:12px}
.it{background:var(--cd);padding:12px 14px;min-width:0}.it b{display:block;font-weight:600;font-size:14.5px;overflow-wrap:anywhere;margin-top:2px}
.note{margin:0 0 12px;padding:12px 14px;border-left:3px solid var(--ac);background:var(--bg);border-radius:0 10px 10px 0;color:var(--mu);font-size:14px}
.ctl{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin:16px 0}
.ctl label{margin:0}.fl>span{display:block;font-size:12px;font-weight:600;letter-spacing:.02em;color:var(--mu)}
.pr{display:flex;gap:8px;margin-top:4px}.pr input{margin:0;min-width:0}.pr .b1{flex:none;padding:0 16px}
.acts{display:grid;grid-template-columns:1fr 1fr;gap:8px}.acts .b1,.acts .b2{width:100%}
.mf{display:flex;gap:8px;margin-top:16px;padding-top:16px;border-top:1px solid var(--bd)}.mf .b2{flex:1}
.b2.dng{color:var(--ac);border-color:color-mix(in srgb,var(--ac) 35%,var(--bd))}
.b2.dng:hover{background:var(--ac);color:#fff;border-color:var(--ac)}
@media(max-width:520px){.ctl{grid-template-columns:1fr}.pay b{font-size:17px}.mh .pill{display:none}}

</style></head><body>
<div id="fx"></div><div id="app"><nav><div class="brand" id="nb"></div><div id="nv"></div><div class="me" id="me"></div></nav>
<div id="wrap"><header class="top"><div class="hd"><img id="lg" alt=""><h1 id="sn">Ink CRM</h1><span id="st"></span></div><button class="b1" onclick="openForm()">＋ Nueva cita</button></header><div class="ban" id="ban"></div><main id="main"></main></div></div>
<div id="lock"></div><div id="modal" onclick="if(event.target===this)closeM()"></div>
<script>
const BOOT=<?= json_encode(["csrf"=>csrf()], JSON_HEX_TAG|JSON_HEX_AMP) ?>;
const ES=['Pendiente','Confirmada','Completada','Cancelada','No presentó'],CAT=['Material','Renta','Servicios','Marketing','Equipo','Otro'],NAV=[['dash','Resumen'],['cal','Agenda'],['cli','Clientes'],['fin','Gastos'],['cfg','Ajustes']];
const TH={
clasico:{n:'Clásico',bg:'#f6f3ef',ac:'#c62f3a',ic:['📊','📅','👥','💰','⚙️'],mk:'🖋️',ban:''},
girly:{n:'Girly',bg:'#fff0f6',ac:'#e0489a',ic:['🌸','🗓️','💖','🛍️','🎀'],mk:'🌸',ban:'🌸 ✿ 🎀 ✿ 🦋 ✿ 🎀 ✿ 🌸 ✿ 🎀 ✿ 🦋 ✿ 🌸'},
tradicional:{n:'Old school',bg:'#f1e6c8',ac:'#b3262e',ic:['⚓','🗓️','🌹','💵','🗡️'],mk:'⚓',ban:'⚓ ✦ 🌹 ✦ 🗡️ ✦ 🦅 ✦ 🌹 ✦ ⚓ ✦ 🗡️ ✦ 🌹 ✦ ⚓'},
blackwork:{n:'Blackwork',bg:'#0a0a0a',ac:'#c1121f',ic:['◈','☽','⛧','✠','✶'],mk:'☠',ban:'✠ ⛧ ☽ ✠ ⛧ ☽ ✠ ⛧ ☽ ✠ ⛧ ☽ ✠ ⛧ ☽ ✠ ⛧'},
fineline:{n:'Fine line',bg:'#fafafa',ac:'#111111',ic:['○','▭','◔','＄','✦'],mk:'✦',ban:'· · ✦ · · ✧ · · ✦ · · ✧ · · ✦ · · ✧ · ·'},
neon:{n:'Neón',bg:'#0b0b1a',ac:'#d6249f',ic:['⚡','📆','👾','💸','🔧'],mk:'⚡',ban:'⚡ ▲ ◆ ▲ ⚡ ▲ ◆ ▲ ⚡ ▲ ◆ ▲ ⚡ ▲ ◆ ▲ ⚡'},
irezumi:{n:'Irezumi',bg:'#14110f',ac:'#c8102e',ic:['🐉','🗓️','🎎','💰','🌊'],mk:'🐉',ban:'🌊 ❖ 🐉 ❖ 🌸 ❖ 🐉 ❖ 🌊 ❖ 🐉 ❖ 🌸 ❖ 🐉 ❖ 🌊'},
acuarela:{n:'Acuarela',bg:'#eef6fb',ac:'#7a5cc9',ic:['🎨','🗓️','🦋','🌿','🖌️'],mk:'🎨',ban:'🌿 ❀ 🦋 ❀ 🎨 ❀ 🦋 ❀ 🌿 ❀ 🦋 ❀ 🎨 ❀ 🦋 ❀ 🌿'}};
const FX={girly:{g:['♥','✿','🌸','💗','🎀'],a:'rise',n:16},tradicional:{g:['✦','★','⚓','✦'],a:'twk',n:16},blackwork:{g:['✠','⛧','·','✠'],a:'rise',n:12},fineline:{g:['·','○','·'],a:'drift',n:10},neon:{g:['▲','◆','●','+'],a:'pulse',n:16},irezumi:{g:['🌸','❀','🌸'],a:'fall',n:14},acuarela:{g:['🦋','✿','●','🌿'],a:'drift',n:12}};
function fx(){const k=S.cfg.skin||'clasico',b=$('#fx'),f=FX[k];if(b.dataset.k===k)return;b.dataset.k=k;b.innerHTML='';if(!f)return;for(let i=0;i<f.n;i++){const s=document.createElement('span'),r=Math.random;s.textContent=f.g[i%f.g.length];s.className='f '+f.a;s.style.cssText=`left:${r()*100}%;top:${f.a==='rise'?'100%':f.a==='fall'?'-8%':r()*100+'%'};font-size:${12+r()*22}px;animation-delay:${-r()*24}s;animation-duration:${16+r()*18}s`;b.appendChild(s)}}
function enter(){const m=$('#main');m.classList.remove('in');void m.offsetWidth;m.classList.add('in');setTimeout(()=>m.classList.remove('in'),1100)}
const mob=()=>/Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent)||(navigator.maxTouchPoints>1&&/Macintosh/.test(navigator.userAgent));
function waUrl(c,t){const p=ph(c),e=encodeURIComponent(t);return mob()?`https://wa.me/${p}?text=${e}`:`https://web.whatsapp.com/send?${p?'phone='+p+'&':''}text=${e}`}
async function copyTxt(t,b){try{await navigator.clipboard.writeText(t)}catch(e){const a=document.createElement('textarea');a.value=t;document.body.appendChild(a);a.select();try{document.execCommand('copy')}catch(_){}a.remove()}if(b){const o=b.textContent;b.textContent='✅ Copiado';setTimeout(()=>{b.textContent=o},1500)}}
const cpm=(id,r,b)=>copyTxt(msg(S.citas.find(x=>x.id===id),r),b);
const DC={estudio:'Mi estudio de tatuajes',pais:'52',pct:30,skin:'clasico',logo:'',lock:false,pin:''};
let K='inkcrm1',S={citas:[],gastos:[],cfg:{...DC}},DB=null,U=null,UID='',NAME='',ready=false,booted=false,local=false,auth=false,sig={},pdfC={},tab='dash',cur=new Date(),Q='',dr=false;
const $=s=>document.querySelector(s),pad=n=>String(n).padStart(2,'0');
const esc=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const mn=n=>'$'+Number(n||0).toLocaleString('es-MX',{maximumFractionDigits:0}),ymd=d=>d.getFullYear()+'-'+pad(d.getMonth()+1)+'-'+pad(d.getDate());
const today=ymd(new Date()),sel0=today;let sel=today;cur.setDate(1);
const fdate=s=>new Date(s+'T12:00').toLocaleDateString('es-MX',{weekday:'long',day:'numeric',month:'long',year:'numeric'}),dshort=s=>new Date(s+'T12:00').toLocaleDateString('es-MX',{weekday:'short',day:'numeric',month:'short'});
const fdt=s=>{const d=new Date(s);return pad(d.getDate())+'/'+pad(d.getMonth()+1)+'/'+d.getFullYear()+' '+pad(d.getHours())+':'+pad(d.getMinutes())};
const cmp=(a,b)=>(a.fecha+a.hora).localeCompare(b.fecha+b.hora),uid=()=>Date.now().toString(36)+Math.random().toString(36).slice(2,5);
const act=()=>S.citas.filter(c=>c.estado!=='Cancelada'&&c.estado!=='No presentó'),pc=e=>'p-'+e.replace(/ /g,''),ini=n=>String(n||'?').trim().split(/\s+/).slice(0,2).map(x=>x[0]).join('').toUpperCase();
const inc=k=>S.citas.filter(c=>c.fecha.slice(0,7)===k).reduce((a,c)=>a+ +c.abonado,0),exp=k=>S.gastos.filter(g=>g.fecha.slice(0,7)===k).reduce((a,g)=>a+ +g.monto,0);
try{auth=sessionStorage.getItem('inkok')==='1'}catch(e){}
/* ---------- datos y sincronización con el servidor ---------- */
const API=(a,o)=>fetch('api.php?a='+a,Object.assign({credentials:'same-origin',headers:{'Content-Type':'application/json','X-CSRF':BOOT.csrf}},o)).then(r=>{if(r.status===401){location.href='index.php';throw 0}if(!r.ok)throw new Error(r.status);return r.json()});
const lsave=()=>{},save=()=>push();
const snap=()=>{const n={};S.citas.forEach(x=>n['c_'+x.id]=JSON.stringify(Object.assign({t:'c'},x)));S.gastos.forEach(x=>n['g_'+x.id]=JSON.stringify(Object.assign({t:'g'},x)));n.cfg=JSON.stringify(Object.assign({t:'f'},S.cfg));return n};
let saving=false,again=false;
async function push(){if(!ready)return;if(saving){again=true;return}const n=snap(),set={},del=[];for(const k in n)if(sig[k]!==n[k])set[k]=n[k];for(const k in sig)if(!(k in n))del.push(k);
 if(!Object.keys(set).length&&!del.length)return;saving=true;const prev=sig;sig=n;
 try{await API('save',{method:'POST',body:JSON.stringify({set,del})});$('#st').textContent='☁️'}catch(e){sig=prev;$('#st').textContent='⚠️'}
 saving=false;if(again){again=false;push()}}
function gate(h){const L=$('#lock');L.dataset.k='msg';L.innerHTML='<div class="cd">'+h+'</div>';L.classList.add('on')}
function boot(){booted=true;render();enter();lock()}
const toData=u=>new Promise((res,rej)=>{const i=new Image();i.onload=()=>{const k=Math.min(1,320/Math.max(i.width,i.height)),c=document.createElement('canvas');c.width=Math.round(i.width*k);c.height=Math.round(i.height*k);c.getContext('2d').drawImage(i,0,0,c.width,c.height);res(c.toDataURL('image/png'))};i.onerror=rej;i.src=u});
async function initSync(){
 gate('<div style="font-size:42px">🖋️</div><h2>Cargando…</h2><p class="mu">Un momento</p>');
 try{const r=await API('load');NAME=r.user.name;S={citas:[],gastos:[],cfg:{...DC}};let cf=null;
  r.docs.forEach(d=>{const o=JSON.parse(d.json),t=o.t;delete o.t;if(t==='c')S.citas.push(o);else if(t==='g')S.gastos.push(o);else if(t==='f')cf=o});
  S.cfg=Object.assign({},DC,cf||{});DB=true;sig=snap();ready=true;
  const st=r.studio;if(!cf||S.cfg.estudioSrc!==st.name){S.cfg.estudio=st.name;S.cfg.estudioSrc=st.name}
  if(st.logo&&S.cfg.logoSrc!==st.logo){try{S.cfg.logo=await toData(st.logo);S.cfg.logoSrc=st.logo}catch(e){}}
  boot();push()
 }catch(e){gate('<div style="font-size:42px">📡</div><h2>No se pudo cargar</h2><p class="mu">Revisa tu conexión.</p><button class="b1" style="width:100%" onclick="location.reload()">Reintentar</button>')}}
/* ---------- UI base ---------- */
function modal(h){const m=$('#modal');m.innerHTML='<div class="sh2">'+h+'</div>';m.classList.add('on')}
const closeM=()=>{$('#modal').classList.remove('on');$('#modal').innerHTML=''},go=t=>{tab=t;render();enter()};
function brand(){const c=S.cfg,k=TH[c.skin]?c.skin:'clasico',t=TH[k],l=c.logo,g=$('#lg');
 if(k!=='clasico')document.documentElement.dataset.skin=k;else document.documentElement.removeAttribute('data-skin');
 $('#sn').textContent=c.estudio;g.style.display=l?'block':'none';if(l)g.src=l;
 $('#nb').innerHTML=(l?`<img src="${l}" alt="">`:`<span>${t.mk}</span>`)+`<b>${esc(c.estudio)}</b>`;
 $('#nv').innerHTML=NAV.map((n,i)=>`<button class="${tab===n[0]?'on':''}" onclick="go('${n[0]}')"><span>${t.ic[i]}</span>${n[1]}</button>`).join('');
 const b=$('#ban');if(b.dataset.k!==k){b.dataset.k=k;b.innerHTML=t.ban?'<span>'+(t.ban+' &nbsp; ').repeat(4)+'</span>':''}b.style.display=t.ban?'block':'none';fx();
 $('#me').innerHTML=`<div class="av">${esc(ini(NAME||'T'))}</div><div class="in"><b>${esc(NAME||'Tatuador')}</b><small>${ready?'☁️ Sincronizado':'⏳ Conectando…'}</small></div><a class="lo" href="logout.php" title="Cerrar sesión">${ic('out')}</a>`;
 $('#st').textContent=DB?(ready?'☁️':'⏳'):'📴'}
function render(){if(!booted)return;brand();$('#main').innerHTML=({dash:vDash,cal:vCal,cli:vCli,fin:vFin,cfg:vCfg})[tab]()}
function lock(){const L=$('#lock');if(!booted)return;if(!(S.cfg.lock&&S.cfg.pin&&!auth)){L.classList.remove('on');return}
 if(L.dataset.k==='pin'&&L.classList.contains('on'))return;L.dataset.k='pin';const l=S.cfg.logo;
 L.innerHTML=`<div class="cd">${l?`<img src="${l}" alt="" style="max-height:80px;max-width:200px;object-fit:contain">`:'<div style="font-size:42px">'+(TH[S.cfg.skin]||TH.clasico).mk+'</div>'}<h2>${esc(S.cfg.estudio)}</h2><label>PIN<input id="lp" type="password" inputmode="numeric" onkeydown="if(event.key==='Enter')login()"></label><p id="le" class="neg" style="min-height:1.4em;margin:6px 0"></p><button class="b1" style="width:100%" onclick="login()">Entrar</button></div>`;L.classList.add('on')}
function login(){if($('#lp').value===String(S.cfg.pin)){auth=true;try{sessionStorage.setItem('inkok','1')}catch(e){}lock()}else $('#le').textContent='PIN incorrecto'}
function logout(){auth=false;try{sessionStorage.removeItem('inkok')}catch(e){}$('#lock').dataset.k='';lock()}
const row=(c,d)=>`<div class="row" onclick="openCita('${c.id}')"><div class="av">${esc(ini(c.nombre))}</div><div class="in"><b>${esc(c.nombre)}</b><small>${d?dshort(c.fecha)+' · ':''}${esc(c.hora)} · ${esc(c.diseno||'Sin diseño')}</small><small>${c.consent?'✍️ Consentimiento firmado':'⚠️ Falta consentimiento'}</small></div><div class="rt"><span class="pill ${pc(c.estado)}">${c.estado}</span><small>${mn(c.abonado)} / ${mn(c.total)}</small></div></div>`;
const empty=m=>`<div class="em"><span>${(TH[S.cfg.skin]||TH.clasico).mk}</span>${m}</div>`;
function vDash(){
 const t=TH[S.cfg.skin]||TH.clasico,mk=today.slice(0,7),I=inc(mk),E=exp(mk),Ut=I-E,M=I?Math.round(Ut/I*100):0;
 const mc=act().filter(c=>c.fecha.slice(0,7)===mk),fut=act().filter(c=>c.fecha>=today).sort(cmp),pend=fut.reduce((a,c)=>a+Math.max(0,c.total-c.abonado),0),prox=fut.slice(0,6),sinF=fut.filter(c=>!c.consent).length;
 const ms=[];for(let i=5;i>=0;i--){const d=new Date();d.setDate(1);d.setMonth(d.getMonth()-i);const k=ymd(d).slice(0,7);ms.push([d.toLocaleDateString('es-MX',{month:'short'}),inc(k),exp(k)])}
 const top=Math.max(1,...ms.map(x=>Math.max(x[1],x[2]))),tk=mc.length?mc.reduce((a,c)=>a+ +c.total,0)/mc.length:0;
 const kp=[['💵','Ingresos',mn(I)],['🧾','Gastos',mn(E)],['🎟️','Citas del mes',mc.length],['🏷️','Ticket promedio',mn(tk)],['⏳','Por cobrar',mn(pend)],['✍️','Sin consentimiento',sinF]];
 return `<div class="hero"><span class="mk">${t.mk}</span><small style="text-transform:capitalize">${new Date().toLocaleDateString('es-MX',{month:'long',year:'numeric'})}</small><h2 style="margin:2px 0 12px">Hola${NAME?', '+esc(NAME.split(' ')[0]):''} 👋</h2><small>Utilidad del mes</small><span class="big">${mn(Ut)}</span><small>Margen de ganancia: <b>${M}%</b></small><div class="pb"><i style="width:${Math.max(0,Math.min(100,M))}%"></i></div></div>
 <div class="kp">${kp.map(k=>`<div><span class="ic">${k[0]}</span><small>${k[1]}</small><b>${k[2]}</b></div>`).join('')}</div>
 <div class="g2"><div class="cd"><h3 style="margin-top:0">Ingresos vs gastos</h3><div class="ch">${ms.map(x=>`<div class="bc"><div class="bb"><i title="${mn(x[1])}" style="height:${x[1]/top*100}%"></i><i class="e" title="${mn(x[2])}" style="height:${x[2]/top*100}%"></i></div><small>${x[0]}</small></div>`).join('')}</div><small><span class="pos">■</span> Ingresos &nbsp;<span class="neg">■</span> Gastos</small></div>
 <div class="cd"><h3 style="margin-top:0">Próximas citas</h3>${prox.map(c=>row(c,1)).join('')||empty('Aún no hay citas próximas')}</div></div>`}
function vCal(){
 const y=cur.getFullYear(),m=cur.getMonth(),off=(new Date(y,m,1).getDay()+6)%7,dim=new Date(y,m+1,0).getDate();let cells='';
 for(let i=0;i<off;i++)cells+='<div class="d x"></div>';
 for(let d=1;d<=dim;d++){const k=y+'-'+pad(m+1)+'-'+pad(d),l=act().filter(c=>c.fecha===k).sort(cmp);
  cells+=`<div class="d ${k===today?'t':''} ${k===sel?'s':''}" onclick="sel='${k}';render()"><span>${d}</span>${l.slice(0,2).map(c=>`<i class="${pc(c.estado)}" role="button" tabindex="0" onclick="event.stopPropagation();openCita('${c.id}')" onkeydown="if(event.key==='Enter'){event.stopPropagation();openCita('${c.id}')}">${esc(c.hora)} ${esc(c.nombre.split(' ')[0])}</i>`).join('')}${l.length>2?`<em>+${l.length-2} más</em>`:''}${l.length?`<b class="n">${l.length}</b>`:''}</div>`}
 const day=S.citas.filter(c=>c.fecha===sel).sort(cmp);
 return `<div class="cd"><div class="top"><button class="b2" onclick="mv(-1)">‹</button><h2 style="text-transform:capitalize;margin:0">${new Date(y,m,1).toLocaleDateString('es-MX',{month:'long',year:'numeric'})}</h2><button class="b2" onclick="mv(1)">›</button></div><div class="cal">${['L','M','X','J','V','S','D'].map(x=>`<small>${x}</small>`).join('')}${cells}</div></div>
 <div class="cd"><div class="top"><h2 style="margin:0;text-transform:capitalize">${fdate(sel)}</h2><button class="b2" onclick="openForm('','${sel}')">＋ Cita este día</button></div>${day.map(c=>row(c)).join('')||empty('Sin citas este día')}</div>`}
const mv=n=>{cur.setMonth(cur.getMonth()+n);render()};
function openForm(id,f){
 const c=S.citas.find(x=>x.id===id)||{fecha:f||sel||today,hora:'12:00',dur:3,estado:'Confirmada',total:'',abonado:'',nombre:'',tel:'',diseno:'',zona:'',notas:''},v=(i,l,val,t,x)=>`<label ${x||''}>${l}<input id="${i}" ${t||''} value="${esc(val)}"></label>`;
 modal(`<h2>${id?'Editar':'Nueva'} cita</h2><div class="g">${v('fn','Cliente',c.nombre,'','class="w"')}${v('ft','Celular / WhatsApp',c.tel,'type="tel" inputmode="tel" placeholder="10 dígitos"')}${v('ff','Fecha',c.fecha,'type="date"')}${v('fh','Hora',c.hora,'type="time"')}${v('fd','Duración (horas)',c.dur,'type="number" step="0.5"')}
 <label>Estado<select id="fe">${ES.map(e=>`<option ${e===c.estado?'selected':''}>${e}</option>`).join('')}</select></label>${v('fi','Diseño / estilo',c.diseno,'','class="w"')}${v('fz','Zona del cuerpo',c.zona)}${v('fp','Precio total',c.total,'type="number" inputmode="decimal"')}${v('fa','Anticipo / pago recibido',c.abonado,'type="number" inputmode="decimal"')}
 <div class="w"><button class="b2" type="button" onclick="quick(0)">Anticipo ${S.cfg.pct}%</button> <button class="b2" type="button" onclick="quick(1)">Pago completo</button></div>
 <label class="w">Notas<textarea id="fo" rows="2">${esc(c.notas)}</textarea></label></div>
 <div class="bar"><button class="b2" onclick="closeM()">Cancelar</button><button class="b1" onclick="saveCita('${id||''}')">Guardar y confirmar</button></div>`)}
function quick(f){const t=+$('#fp').value||0;$('#fa').value=Math.round(f?t:t*S.cfg.pct/100)}
function saveCita(id){
 const g=i=>$('#'+i).value.trim();if(!g('fn')||!g('ff')){alert('Falta el nombre o la fecha');return}
 const n={nombre:g('fn'),tel:g('ft'),fecha:g('ff'),hora:g('fh')||'12:00',dur:+g('fd')||1,estado:g('fe'),diseno:g('fi'),zona:g('fz'),total:+g('fp')||0,abonado:+g('fa')||0,notas:g('fo')};
 let c=S.citas.find(x=>x.id===id);if(c)Object.assign(c,n);else{c=Object.assign({id:uid()},n);S.citas.push(c)}
 save();sel=c.fecha;cur=new Date(c.fecha+'T12:00');cur.setDate(1);render();showSent(c)}
/* ---------- WhatsApp con formato ---------- */
const ph=c=>{let d=(c.tel||'').replace(/\D/g,'');if(d.length===10)d=S.cfg.pais+d;return d};
function msg(c,rec){const r=Math.max(0,c.total-c.abonado),n=c.nombre.split(' ')[0],e=S.cfg.estudio,reg=c.estado==='Pendiente';
 const pago=c.abonado>0?(c.abonado>=c.total&&c.total>0?`• Pago completo recibido: *${mn(c.abonado)}* ✅`:`• Anticipo recibido: *${mn(c.abonado)}* ✅`):'• Anticipo: _pendiente_ (para apartar tu lugar)';
 return [rec?'⏰ *RECORDATORIO DE CITA*':(reg?'📝 *CITA REGISTRADA*':'✅ *CITA CONFIRMADA*'),'━━━━━━━━━━━━━━',`Hola *${n}* 👋`,rec?`Te recordamos tu cita en *${e}*:`:`Tu cita en *${e}* quedó ${reg?'registrada':'confirmada'}:`,'',`📅 *Fecha:* ${fdate(c.fecha)}`,`🕒 *Hora:* ${c.hora} (aprox. ${c.dur} h)`,`🎨 *Diseño:* ${c.diseno||'Por definir'}`,c.zona?`📍 *Zona:* ${c.zona}`:null,'','💵 *Pagos*',`• Total: *${mn(c.total)}*`,pago,r>0?`• Restante el día de la cita: *${mn(r)}*`:'• Sin saldo pendiente 🎉','','📌 *Recuerda*','• Llega puntual, comido/a e hidratado/a','• Evita alcohol 24 h antes','• Para reagendar avisa con 48 h de anticipación','','¡Te esperamos! 🖋️',`_${e}_`].filter(x=>x!==null).join('\n')}
const wafmt=t=>esc(t).replace(/\*(.+?)\*/g,'<b>$1</b>').replace(/_(.+?)_/g,'<i>$1</i>'),wa=(c,t)=>waUrl(c,t),smsl=(c,t)=>`sms:+${ph(c)}?&body=${encodeURIComponent(t)}`;
function showSent(c){modal(`<h2>Cita guardada ✅</h2><p class="mu" style="margin-top:0">Así le llegará al cliente:</p><div class="wa">${wafmt(msg(c))}</div><div class="bar"><a class="b1 wb" target="_blank" rel="noopener" href="${wa(c,msg(c))}">📲 Enviar por WhatsApp</a><a class="b2" href="${smsl(c,msg(c))}">SMS</a><button class="b2" onclick="cpm('${c.id}',0,this)">📋 Copiar</button><button class="b2" onclick="openConsent('${c.id}')">✍️ Consentimiento</button><button class="b2" onclick="closeM()">Listo</button></div><small>Si en WhatsApp de escritorio ves símbolos raros en lugar de emojis, usa Copiar y pega el mensaje en el chat.</small>`)}
const ic=n=>`<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${({wa:'<path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 21l2.2-5.4A8.4 8.4 0 1 1 21 11.5z"/>',bell:'<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9M10.3 21a1.9 1.9 0 0 0 3.4 0"/>',copy:'<rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h8"/>',doc:'<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 14l2 2 4-4"/>',edit:'<path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',trash:'<path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14"/>',x:'<path d="M18 6 6 18M6 6l12 12"/>',out:'<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>'})[n]}</svg>`;
function openCita(id){const c=S.citas.find(x=>x.id===id),rest=Math.max(0,c.total-c.abonado),pct=c.total?Math.min(100,Math.round(c.abonado/c.total*100)):0,it=(l,v)=>`<div class="it"><small>${l}</small><b>${v}</b></div>`;
 modal(`<div class="mh"><div class="av lg">${esc(ini(c.nombre))}</div><div class="mt"><h2>${esc(c.nombre)}</h2><p>${fdate(c.fecha)} · ${esc(c.hora)} · ${c.dur} h</p></div><span class="pill ${pc(c.estado)}">${c.estado}</span><button class="x" onclick="closeM()" aria-label="Cerrar">${ic('x')}</button></div>
 <div class="pay"><div><small>Pagado</small><b>${mn(c.abonado)}</b></div><div><small>Resta</small><b class="${rest?'neg':'pos'}">${mn(rest)}</b></div><div><small>Total</small><b>${mn(c.total)}</b></div><div class="pb2"><i style="width:${pct}%"></i></div></div>
 <div class="info">${it('Diseño',esc(c.diseno||'—'))}${it('Zona',esc(c.zona||'—'))}${it('Celular',esc(c.tel||'—'))}${it('Consentimiento',c.consent?'<span class="pos">Firmado</span>':'<span class="wr">Pendiente</span>')}</div>${c.notas?`<p class="note">${esc(c.notas)}</p>`:''}
 <div class="ctl"><label>Estado<select onchange="setEst('${id}',this.value)">${ES.map(e=>`<option ${e===c.estado?'selected':''}>${e}</option>`).join('')}</select></label><div class="fl"><span>Registrar pago</span><div class="pr"><input id="ab" type="number" inputmode="decimal" placeholder="$ monto"><button class="b1" onclick="addAb('${id}')">Registrar</button></div></div></div>
 <div class="acts"><a class="b1 wb" target="_blank" rel="noopener" href="${wa(c,msg(c))}">${ic('wa')}WhatsApp</a><a class="b2" target="_blank" rel="noopener" href="${wa(c,msg(c,1))}">${ic('bell')}Recordatorio</a><button class="b2" onclick="cpm('${id}',0,this)">${ic('copy')}Copiar mensaje</button><button class="b2" onclick="openConsent('${id}')">${ic('doc')}Consentimiento</button></div>
 <div class="mf"><button class="b2" onclick="openForm('${id}')">${ic('edit')}Editar</button><button class="b2 dng" onclick="delC('${id}',this)">${ic('trash')}Eliminar</button></div>`)}
function setEst(id,v){S.citas.find(x=>x.id===id).estado=v;save();render()}
function addAb(id){const c=S.citas.find(x=>x.id===id),v=+$('#ab').value;if(!v)return;c.abonado=+c.abonado+v;if(c.estado==='Pendiente')c.estado='Confirmada';save();render();showSent(c)}
function delC(id,b){if(!b.dataset.s){b.dataset.s=1;b.textContent='¿Seguro? Toca otra vez';return}S.citas=S.citas.filter(x=>x.id!==id);save();closeM();render()}
/* ---------- consentimiento + PDF ---------- */
const CT=['Declaro que soy mayor de 18 años y solicito voluntariamente la realización de un tatuaje.','Entiendo que el tatuaje es permanente y que su eliminación total es difícil o imposible.','Conozco los riesgos: infección, reacción alérgica, cicatrización irregular y variaciones de color. Me comprometo a seguir los cuidados posteriores indicados.','Aprobé el diseño, tamaño y ubicación antes de iniciar. El anticipo no es reembolsable; para reagendar debo avisar con al menos 48 horas.','Se utiliza material nuevo, estéril y desechable.'];
const HL=['Alergias (látex, tintas, medicamentos)','Diabetes','Problemas de coagulación / anticoagulantes','Embarazo o lactancia','Enfermedad de la piel o cicatrices queloides','Enfermedad infecciosa (hepatitis, VIH)','Alcohol o drogas en las últimas 24 h','Toma medicación actualmente'];
function openConsent(id){const c=S.citas.find(x=>x.id===id);if(c.consent)return viewConsent(c);const l=S.cfg.logo;
 modal(`<div style="display:flex;align-items:center;gap:12px">${l?`<img src="${l}" alt="" style="height:48px;max-width:110px;object-fit:contain">`:''}<div><h2 style="margin:0">Consentimiento informado</h2><small>${esc(c.nombre)} · ${esc(S.cfg.estudio)}</small></div></div><h3>Salud (marca lo que aplique)</h3>${HL.map(h=>`<label class="ck"><input type="checkbox" class="hk" value="${esc(h)}">${h}</label>`).join('')}<label>Detalles / alergias<textarea id="cd" rows="2"></textarea></label><h3>Acuerdo</h3>${CT.map((t,i)=>`<p style="margin:5px 0;font-size:15px"><b>${i+1}.</b> ${t}</p>`).join('')}
 <label class="ck"><input type="checkbox" id="cf">Autorizo usar fotos del trabajo terminado (sin mostrar mi rostro) en el portafolio del estudio.</label><label class="ck"><input type="checkbox" id="ca"><b>He leído y acepto lo anterior.</b></label>
 <h3>Firma del cliente</h3><canvas id="sig"></canvas><div class="bar"><button class="b2" onclick="sigInit()">Borrar firma</button><button class="b2" onclick="closeM()">Cancelar</button><button class="b1" onclick="saveConsent('${id}')">Firmar y generar PDF</button></div>`);setTimeout(sigInit,30)}
function sigInit(){const cv=$('#sig'),r=cv.getBoundingClientRect(),p=window.devicePixelRatio||1;cv.width=r.width*p;cv.height=r.height*p;const x=cv.getContext('2d');x.scale(p,p);x.lineWidth=2.4;x.lineCap='round';x.lineJoin='round';x.strokeStyle='#111';let on=false;dr=false;
 const pt=e=>{const b=cv.getBoundingClientRect();return[e.clientX-b.left,e.clientY-b.top]};
 cv.onpointerdown=e=>{on=true;cv.setPointerCapture(e.pointerId);x.beginPath();x.moveTo(...pt(e));e.preventDefault()};
 cv.onpointermove=e=>{if(!on)return;x.lineTo(...pt(e));x.stroke();dr=true;e.preventDefault()};
 cv.onpointerup=cv.onpointercancel=()=>{on=false}}
function saveConsent(id){if(!$('#ca').checked){alert('El cliente debe aceptar el consentimiento');return}if(!dr){alert('Falta la firma');return}
 const c=S.citas.find(x=>x.id===id);c.consent={salud:[...document.querySelectorAll('.hk:checked')].map(i=>i.value),det:$('#cd').value.trim(),fotos:$('#cf').checked,firma:$('#sig').toDataURL('image/png'),fecha:new Date().toISOString()};delete pdfC[id];save();render();viewConsent(c)}
const loadImg=u=>new Promise((res,rej)=>{const i=new Image();i.onload=()=>res(i);i.onerror=rej;i.src=u});
const h2r=h=>{h=h.replace('#','').trim();if(h.length===3)h=h.split('').map(x=>x+x).join('');return[0,2,4].map(i=>parseInt(h.substr(i,2),16))};
async function mkPdf(c){
 const {jsPDF}=window.jspdf,d=new jsPDF({unit:'mm',format:'a4'}),W=210,M=16,k=c.consent,CW=W-2*M,ac=h2r(getComputedStyle(document.documentElement).getPropertyValue('--ac')||'#c62f3a');
 let y=14;const need=h=>{if(y+h>282){d.addPage();y=16}};
 d.setFillColor(...ac);d.rect(0,0,W,4,'F');
 if(S.cfg.logo){try{const im=await loadImg(S.cfg.logo),sc=Math.min(60/im.width,24/im.height);d.addImage(S.cfg.logo,'PNG',M,y,im.width*sc,im.height*sc)}catch(e){}}
 d.setFont('helvetica','bold');d.setFontSize(17);d.setTextColor(30);d.text(S.cfg.estudio,W-M,y+9,{align:'right'});
 d.setFont('helvetica','normal');d.setFontSize(9);d.setTextColor(110);d.text('Consentimiento informado para tatuaje',W-M,y+15,{align:'right'});
 y=42;d.setDrawColor(...ac);d.setLineWidth(.6);d.line(M,y,W-M,y);y+=10;
 d.setFont('helvetica','bold');d.setFontSize(15);d.setTextColor(...ac);d.text('CONSENTIMIENTO INFORMADO',W/2,y,{align:'center'});y+=7;
 d.setFont('helvetica','normal');d.setFontSize(9);d.setTextColor(110);d.text('Documento firmado digitalmente por el cliente',W/2,y,{align:'center'});y+=8;
 d.setFillColor(246,244,241);d.roundedRect(M,y,CW,33,2,2,'F');
 [['Cliente',c.nombre],['Teléfono',c.tel||'-'],['Fecha de cita',fdate(c.fecha)],['Hora',c.hora+' h'],['Diseño',c.diseno||'-'],['Zona',c.zona||'-']].forEach((r,i)=>{const x=M+5+(i%2)*(CW/2),yy=y+8+Math.floor(i/2)*10;d.setFont('helvetica','bold');d.setFontSize(7);d.setTextColor(130);d.text(r[0].toUpperCase(),x,yy-2.5);d.setFont('helvetica','normal');d.setFontSize(10);d.setTextColor(30);d.text(String(r[1]),x,yy+2,{maxWidth:CW/2-8})});
 y+=42;
 const sec=t=>{need(16);d.setFont('helvetica','bold');d.setFontSize(10.5);d.setTextColor(...ac);d.text(t.toUpperCase(),M,y);d.setDrawColor(...ac);d.setLineWidth(.3);d.line(M,y+1.8,W-M,y+1.8);y+=8;d.setTextColor(40)};
 sec('Declaración de salud');
 HL.forEach((h,i)=>{const x=M+(i%2)*(CW/2),yy=y+Math.floor(i/2)*7,on=k.salud.includes(h);d.setDrawColor(90);d.setLineWidth(.3);d.rect(x,yy-3,3.6,3.6);if(on){d.setFillColor(...ac);d.rect(x,yy-3,3.6,3.6,'F');d.setDrawColor(255);d.setLineWidth(.5);d.line(x+.7,yy-1.2,x+1.6,yy-.3);d.line(x+1.6,yy-.3,x+3,yy-2.5)}d.setFont('helvetica',on?'bold':'normal');d.setFontSize(9);d.setTextColor(40);d.text(h,x+5.5,yy,{maxWidth:CW/2-8})});
 y+=Math.ceil(HL.length/2)*7+1;
 if(k.det){d.setFont('helvetica','italic');d.setFontSize(9);const l=d.splitTextToSize('Detalles: '+k.det,CW);need(l.length*4.5+4);d.text(l,M,y);y+=l.length*4.5+3}
 y+=3;sec('Acuerdo y consentimiento');d.setFont('helvetica','normal');d.setFontSize(9.5);d.setTextColor(40);
 CT.forEach((t,i)=>{const l=d.splitTextToSize((i+1)+'.  '+t,CW-2);need(l.length*4.6+3);d.text(l,M+1,y);y+=l.length*4.6+2.5});
 need(10);d.setFont('helvetica','bold');d.text('Uso de fotografias en portafolio: '+(k.fotos?'SI autorizado':'NO autorizado'),M+1,y);y+=6;
 d.setFont('helvetica','normal');const fin=d.splitTextToSize('Al firmar, el cliente declara que ha leido y comprendido este documento y que acepta voluntariamente los terminos descritos.',CW);need(fin.length*4.6+50);d.text(fin,M+1,y);y+=fin.length*4.6+8;
 const sg=await loadImg(k.firma),sc=Math.min(74/sg.width,24/sg.height);
 d.setDrawColor(200);d.setLineWidth(.3);d.roundedRect(M,y,86,32,2,2);d.addImage(k.firma,'PNG',M+(86-sg.width*sc)/2,y+3,sg.width*sc,sg.height*sc);
 d.setDrawColor(60);d.setLineWidth(.4);d.line(M+4,y+27,M+82,y+27);d.setFont('helvetica','normal');d.setFontSize(8);d.setTextColor(110);d.text('Firma del cliente',M+43,y+31,{align:'center'});
 d.setFont('helvetica','bold');d.setFontSize(10);d.setTextColor(30);d.text(c.nombre,M+95,y+8,{maxWidth:CW-95});
 d.setFont('helvetica','normal');d.setFontSize(9);d.setTextColor(110);d.text('Firmado el '+fdt(k.fecha),M+95,y+14);d.text(S.cfg.estudio,M+95,y+20,{maxWidth:CW-95});
 const n=d.getNumberOfPages();for(let i=1;i<=n;i++){d.setPage(i);d.setFontSize(8);d.setTextColor(150);d.text(S.cfg.estudio+'  |  Consentimiento informado  |  Pagina '+i+' de '+n,W/2,291,{align:'center'})}
 return d.output('blob')}
const getPdf=async c=>pdfC[c.id]||(pdfC[c.id]=await mkPdf(c)),fname=c=>'Consentimiento - '+c.nombre.replace(/[^\wáéíóúñÁÉÍÓÚÑ ]/g,'').trim()+'.pdf';
async function viewConsent(c){modal('<h2>Generando PDF…</h2><p class="mu">Un momento, estamos armando el documento.</p>');let ok=true;try{await getPdf(c)}catch(e){ok=false}
 const k=c.consent;modal(`<h2>Consentimiento firmado ✅</h2><p class="mu" style="margin-top:0">${esc(c.nombre)} · ${fdt(k.fecha)}</p><img src="${k.firma}" alt="Firma" style="width:100%;max-height:150px;object-fit:contain;background:#fff;border-radius:12px;border:1px solid var(--bd)"><p class="mu">Condiciones marcadas: ${k.salud.length?esc(k.salud.join(', ')):'ninguna'}${k.det?' · '+esc(k.det):''}</p>${ok?`<div class="bar" style="justify-content:stretch"><button class="b1 wb" style="flex:1" onclick="sendPdf('${c.id}')">📲 Enviar PDF por WhatsApp</button><button class="b2" onclick="dlPdf('${c.id}')">⬇ Descargar PDF</button></div><div id="wf"></div>`:'<p class="neg">No se pudo generar el PDF. Revisa tu conexión e inténtalo de nuevo.</p>'}<div class="bar"><button class="b2" onclick="closeM()">Cerrar</button></div>`)}
async function dlPdf(id){const c=S.citas.find(x=>x.id===id),b=await getPdf(c),a=document.createElement('a');a.href=URL.createObjectURL(b);a.download=fname(c);a.click()}
async function sendPdf(id){const c=S.citas.find(x=>x.id===id),b=await getPdf(c),f=new File([b],fname(c),{type:'application/pdf'}),t=`📄 *Consentimiento informado firmado*\nHola *${c.nombre.split(' ')[0]}*, te comparto la copia de tu consentimiento de tatuaje.\n_${S.cfg.estudio}_`;
 try{if(navigator.canShare&&navigator.canShare({files:[f]})){await navigator.share({files:[f],text:t,title:fname(c)});return}}catch(e){if(e&&e.name==='AbortError')return}
 await dlPdf(id);$('#wf').innerHTML=`<p class="mu">Descarga el PDF y adjúntalo en el chat de WhatsApp:</p><a class="b1 wb" target="_blank" rel="noopener" href="${wa(c,t)}">Abrir chat de WhatsApp</a>`}
/* ---------- clientes, gastos, ajustes ---------- */
function cliArr(){const m={};S.citas.forEach(c=>{const k=(ph(c)||c.nombre.toLowerCase());const o=m[k]||(m[k]={k,nombre:c.nombre,tel:c.tel,n:0,g:0,u:''});o.n++;o.g+=+c.abonado;if(c.fecha>o.u)o.u=c.fecha});const q=Q.toLowerCase();return Object.values(m).filter(o=>(o.nombre+o.tel).toLowerCase().includes(q)).sort((a,b)=>b.u.localeCompare(a.u))}
const cliList=()=>cliArr().map(o=>`<div class="row" onclick="openCli('${encodeURIComponent(o.k)}')"><div class="av">${esc(ini(o.nombre))}</div><div class="in"><b>${esc(o.nombre)}</b><small>${esc(o.tel||'Sin teléfono')} · última: ${dshort(o.u)}</small></div><div class="rt"><small>${o.n} cita(s)</small><b>${mn(o.g)}</b></div></div>`).join('')||empty('Los clientes aparecen al agendar citas');
const vCli=()=>`<div class="cd"><input placeholder="🔎 Buscar cliente…" value="${esc(Q)}" oninput="Q=this.value;$('#cl').innerHTML=cliList()" style="margin:0 0 8px"><div id="cl">${cliList()}</div></div>`;
function openCli(k){k=decodeURIComponent(k);const o=cliArr().find(x=>x.k===k),l=S.citas.filter(c=>(ph(c)||c.nombre.toLowerCase())===k).sort((a,b)=>cmp(b,a));modal(`<h2>${esc(o.nombre)}</h2><p class="mu" style="margin-top:0">${esc(o.tel)} · Total pagado ${mn(o.g)}</p>${l.map(c=>row(c,1)).join('')}<div class="bar"><button class="b2" onclick="closeM()">Cerrar</button></div>`)}
function vFin(){const mk=today.slice(0,7),by={};S.gastos.filter(g=>g.fecha.slice(0,7)===mk).forEach(g=>by[g.cat]=(by[g.cat]||0)+ +g.monto);
 return `<div class="cd"><h3 style="margin-top:0">Registrar gasto</h3><div class="g"><label>Fecha<input id="gf" type="date" value="${today}"></label><label>Monto<input id="gm" type="number" inputmode="decimal"></label><label>Concepto<input id="gc"></label><label>Categoría<select id="gk">${CAT.map(c=>`<option>${c}</option>`).join('')}</select></label></div><div class="bar"><button class="b1" onclick="addG()">Agregar gasto</button></div></div>
 <div class="cd"><h2 style="margin:0 0 4px">Este mes: ${mn(exp(mk))}</h2><small>${Object.entries(by).map(([k,v])=>k+' '+mn(v)).join(' · ')||'Sin gastos'}</small>${S.gastos.slice().sort((a,b)=>b.fecha.localeCompare(a.fecha)).slice(0,40).map(g=>`<div class="row" style="grid-template-columns:auto 1fr auto"><small>${g.fecha.slice(5)}</small><div class="in"><b>${esc(g.concepto)}</b><small>${g.cat}</small></div><span>${mn(g.monto)} <button class="b2" style="min-height:34px;padding:4px 10px" onclick="delG('${g.id}')">✕</button></span></div>`).join('')}</div>`}
function addG(){const m=+$('#gm').value;if(!m)return;S.gastos.push({id:uid(),fecha:$('#gf').value||today,concepto:$('#gc').value.trim()||$('#gk').value,cat:$('#gk').value,monto:m});save();render()}
const delG=id=>{S.gastos=S.gastos.filter(g=>g.id!==id);save();render()},setSkin=id=>{S.cfg.skin=id;save();render();enter()};
function setLogo(f){if(!f)return;const r=new FileReader();r.onload=()=>{const im=new Image();im.onload=()=>{const w=im.width||300,h=im.height||300,k=Math.min(1,320/Math.max(w,h)),c=document.createElement('canvas');c.width=Math.round(w*k);c.height=Math.round(h*k);c.getContext('2d').drawImage(im,0,0,c.width,c.height);S.cfg.logo=c.toDataURL('image/png');delete pdfC.x;pdfC={};save();render()};im.src=r.result};r.readAsDataURL(f)}
function imp(){try{const d=JSON.parse($('#bk').value);if(!d.citas)throw 0;S={citas:d.citas,gastos:d.gastos||[],cfg:Object.assign({},DC,d.cfg)};save();render()}catch(e){alert('Respaldo no válido')}}
function vCfg(){const c=S.cfg;return `<div class="cd"><h3>Mi cuenta</h3><div style="display:flex;gap:12px;align-items:center"><div class="av">${esc(ini(NAME||'T'))}</div><div class="in" style="flex:1"><b>${esc(NAME||'Tatuador')}</b><small>${ready?'☁️ Datos guardados en la nube':'⏳ Conectando…'}</small></div><a class="b2" href="logout.php">${ic('out')}Cerrar sesión</a></div></div>
<div class="cd"><h3 style="margin-top:0">Estudio y logo</h3><div class="g"><label class="w">Nombre del estudio<input value="${esc(c.estudio)}" onchange="S.cfg.estudio=this.value;save();render()"></label><div class="w" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">${c.logo?`<img src="${c.logo}" alt="" style="height:56px;max-width:140px;object-fit:contain;border-radius:8px;background:#fff">`:''}<label class="b2" style="font-size:16px;color:var(--tx);cursor:pointer;margin:0">Subir logo<input type="file" accept="image/*" hidden onchange="setLogo(this.files[0])"></label>${c.logo?'<button class="b2" onclick="S.cfg.logo=\'\';pdfC={};save();render()">Quitar</button>':''}</div><label>Código de país (WhatsApp)<input value="${esc(c.pais)}" onchange="S.cfg.pais=this.value.replace(/\\D/g,'');save()"></label><label>% de anticipo sugerido<input type="number" value="${c.pct}" onchange="S.cfg.pct=+this.value||30;save()"></label></div></div>
<div class="cd"><h3 style="margin-top:0">Tema de la app</h3><div class="sks">${Object.entries(TH).map(([id,t])=>`<button class="sk ${(c.skin||'clasico')===id?'on':''}" style="background:${t.bg};color:${parseInt(t.bg.slice(1,3),16)>128?'#1c1a19':'#f2eee9'}" onclick="setSkin('${id}')"><span class="m">${t.mk}</span><b>${t.n}</b><span class="sw"><i style="background:${t.ac}"></i><i style="background:${t.bg};border:1px solid #8884"></i></span></button>`).join('')}</div></div>
<div class="cd"><h3 style="margin-top:0">Bloqueo de pantalla</h3><label class="ck"><input type="checkbox" ${c.lock?'checked':''} onchange="S.cfg.lock=this.checked;save()">Pedir PIN al abrir (útil en la tablet frente a clientes)</label><div class="g"><label>PIN<input type="password" inputmode="numeric" value="${esc(c.pin)}" onchange="S.cfg.pin=this.value.replace(/\\D/g,'');save()"></label><div style="align-self:end"><button class="b2" onclick="logout()">Bloquear ahora</button></div></div></div>
<div class="cd"><h3 style="margin-top:0">Respaldo</h3><textarea id="bk" rows="3"></textarea><div class="bar"><button class="b2" onclick="$('#bk').value=JSON.stringify(S);$('#bk').select()">Generar respaldo</button><button class="b1" onclick="imp()">Restaurar</button></div></div>`}
initSync();
</script></body></html>
