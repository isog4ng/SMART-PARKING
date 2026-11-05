<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Smart Parking – @yield('title','Welcome')</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --accent:   #4f8ef7;
      --accent-h: #3a7ae8;
      --bg-panel: rgba(13, 17, 28, 0.82);
      --bg-input: rgba(255,255,255,.07);
      --border:   rgba(255,255,255,.12);
      --border-focus: #4f8ef7;
      --text:     #ffffff;
      --text-muted: hsla(0, 0%, 100%, 0.55);
      --text-ph:  rgba(255,255,255,.28);
      --danger:   #ef4444;
      --link:     #dddddd;
    }

    html, body {
      height: 100%;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      overflow: hidden;
    }

    /* ══════════════════════════════════════════
       HERO WRAPPER – full screen background
    ══════════════════════════════════════════ */
    .hero {
      position: relative;
      width: 100vw; height: 100vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute; inset: 0;
      background:
        url('https://images.unsplash.com/photo-1573348722427-f1d6819fdf98?w=1800&q=90')
        center / cover no-repeat;
      transform: scale(1.03);
      transition: transform 14s ease;
    }
    .hero:hover .hero-bg { transform: scale(1.0); }

    .hero-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to bottom,
        rgba(8,12,24,.60) 0%,
        rgba(8,12,24,.35) 45%,
        rgba(8,12,24,.65) 100%
      );
    }

    /* ══════════════════════════════════════════
       NAVBAR (shared)
    ══════════════════════════════════════════ */
    .navbar {
      position: relative; z-index: 20;
      display: flex; align-items: center;
      justify-content: space-between;
      padding: 26px 56px;
      flex-shrink: 0;
    }

    .nav-logo {
      display: flex; align-items: center;
      gap: 10px; text-decoration: none;
    }
    .nav-logo .logo-box {
      width: 42px; height: 42px; border-radius: 11px;
      background: white;
      display: flex; align-items: center; justify-content: center;
      padding: 7px;
      box-shadow: 0 2px 12px rgba(0,0,0,.2);
    }
    .nav-logo .logo-box img { width: 100%; height: 100%; object-fit: contain; }
    .nav-logo span { font-size: 20px; font-weight: 800; color: white; letter-spacing: -.3px; }

    .nav-links { display: flex; align-items: center; gap: 4px; list-style: none; }
    .nav-links li a,
    .nav-links li button {
      display: flex; align-items: center; gap: 4px;
      padding: 8px 14px;
      color: rgba(255,255,255,.85);
      font-size: 14px; font-weight: 500;
      text-decoration: none; border-radius: 20px;
      border: none; background: none; cursor: pointer;
      transition: background .2s, color .2s;
    }
    .nav-links li a:hover,
    .nav-links li button:hover { background: rgba(255,255,255,.1); color: white; }
    .nav-links li a svg, .nav-links li button svg { opacity: .7; }

    .nav-cta {
      padding: 10px 22px;
      background: rgba(255,255,255,.15);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,.28);
      border-radius: 24px;
      color: white; font-size: 14px; font-weight: 600;
      text-decoration: none;
      transition: background .2s, border-color .2s;
    }
    .nav-cta:hover { background: rgba(255,255,255,.26); border-color: rgba(255,255,255,.5); }
    .nav-cta.active { background: var(--accent); border-color: var(--accent); }

    /* ══════════════════════════════════════════
       PAGE TRANSITION ANIMATIONS
    ══════════════════════════════════════════ */
    @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateY(28px) scale(.97); }
      to   { opacity: 1; transform: translateY(0)    scale(1);   }
    }
    @keyframes fadeSlideOut {
      from { opacity: 1; transform: translateY(0)    scale(1);   }
      to   { opacity: 0; transform: translateY(-20px) scale(.97); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }
    @keyframes bgZoom {
      from { transform: scale(1.06); }
      to   { transform: scale(1.03); }
    }

    /* Hero bg entrance */
    .hero-bg { animation: bgZoom .9s ease forwards; }

    /* Overlay fades in */
    .hero-overlay { animation: fadeIn .6s ease forwards; }

    /* Navbar slides down */
    @keyframes navSlideDown {
      from { opacity: 0; transform: translateY(-18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .navbar { animation: navSlideDown .55s cubic-bezier(.4,0,.2,1) forwards; }

    /* Page content wrapper */
    .page-content {
      animation: fadeSlideIn .55s cubic-bezier(.4,0,.2,1) forwards;
    }
    .page-content.leaving {
      animation: fadeSlideOut .35s cubic-bezier(.4,0,.2,1) forwards;
      pointer-events: none;
    }

    /* ══════════════════════════════════════════
       BODY SLOT – flex: 1
    ══════════════════════════════════════════ */
    .hero-body {
      position: relative; z-index: 10;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* ══════════════════════════════════════════
       FORM PANEL (centered)
    ══════════════════════════════════════════ */
    .form-panel {
      width: 100%;
      max-width: 480px;
      background: var(--bg-panel);
      backdrop-filter: blur(28px);
      -webkit-backdrop-filter: blur(28px);
      border: 1px solid rgba(255,255,255,.10);
      border-radius: 24px;
      overflow-y: auto;
      max-height: calc(100vh - 130px);
      scrollbar-width: thin;
      scrollbar-color: rgba(255,255,255,.12) transparent;
      padding: 36px 36px 32px;
      display: flex;
      flex-direction: column;
      gap: 0;
    }
    .form-panel::-webkit-scrollbar { width: 4px; }
    .form-panel::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }

    /* ── Titles ── */
    .form-title { font-size: 26px; font-weight: 800; color: white; margin-bottom: 6px; letter-spacing: -.4px; }
    .form-sub   { font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 26px; }

    /* ── Alerts ── */
    .alert {
      display: flex; align-items: flex-start; gap: 10px;
      padding: 11px 14px; border-radius: 10px;
      font-size: 13px; font-weight: 500; margin-bottom: 18px;
    }
    .alert-success { background: rgba(34,197,94,.12); color: #4ade80; border: 1px solid rgba(34,197,94,.25); }
    .alert-error   { background: rgba(239,68,68,.12); color: #f87171; border: 1px solid rgba(239,68,68,.25); }

    /* ── Social ── */
    .social-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
    .social-btn {
      display: flex; align-items: center; justify-content: center; gap: 9px;
      padding: 12px;
      background: rgba(255,255,255,.07);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 12px;
      color: white; font-size: 13px; font-weight: 600;
      cursor: pointer; transition: background .2s, border-color .2s;
    }
    .social-btn:hover { background: rgba(255,255,255,.13); border-color: rgba(255,255,255,.25); }
    .g-icon {
      width: 20px; height: 20px; border-radius: 50%; background: white;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .g-icon svg { width: 14px; height: 14px; }
    .fb-icon {
      width: 20px; height: 20px; border-radius: 4px; background: #1877F2;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .fb-icon svg { width: 11px; height: 11px; fill: white; }

    /* ── Divider ── */
    .divider {
      display: flex; align-items: center; gap: 10px;
      color: var(--text-muted); font-size: 12px; font-weight: 500;
      margin-bottom: 20px;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: rgba(255,255,255,.1);
    }

    /* ── Fields ── */
    .field { display: flex; flex-direction: column; gap: 7px; margin-bottom: 16px; }
    .field label { font-size: 13px; font-weight: 600; color: white; }
    .input-wrap { position: relative; display: flex; align-items: center; }
    .input-wrap input {
      width: 100%;
      padding: 13px 44px 13px 42px;
      background: var(--bg-input);
      border: 1.5px solid var(--border);
      border-radius: 12px;
      color: white; font-size: 14px; outline: none;
      transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .input-wrap input::placeholder { color: var(--text-ph); }
    .input-wrap input:focus {
      border-color: var(--border-focus);
      background: rgba(79,142,247,.08);
      box-shadow: 0 0 0 4px rgba(79,142,247,.18);
    }
    .input-wrap input.is-invalid { border-color: var(--danger); }
    .input-icon {
      position: absolute; left: 13px;
      color: rgba(255,255,255,.35); pointer-events: none;
      display: flex; align-items: center;
    }
    .toggle-pw {
      position: absolute; right: 13px;
      background: none; border: none; cursor: pointer;
      color: rgba(255,255,255,.35); display: flex; align-items: center;
      transition: color .2s; padding: 4px;
    }
    .toggle-pw:hover { color: rgba(255,255,255,.75); }
    .toggle-pw.active { color: var(--accent); }
    .err-msg { font-size: 12px; color: var(--danger); display: flex; align-items: center; gap: 4px; }

    /* ── Check row ── */
    .check-row {
      display: flex; align-items: flex-start; gap: 10px;
      font-size: 13px; color: var(--text-muted); line-height: 1.5;
      margin-bottom: 20px; cursor: pointer;
    }
    .check-row input[type="checkbox"] {
      width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px;
      accent-color: var(--accent); cursor: pointer; border-radius: 4px;
    }
    .check-row a { color: var(--link); text-decoration: none; font-weight: 600; }

    /* ── Flex between ── */
    .flex-between {
      display: flex; justify-content: space-between; align-items: center;
      gap: 10px; margin-bottom: 20px;
    }
    .forgot-link { font-size: 13px; color: var(--link); text-decoration: none; white-space: nowrap; }

    /* ── Submit button ── */
    .btn-submit {
      width: 100%; padding: 15px;
      background: var(--accent); color: white;
      border: none; border-radius: 12px;
      font-size: 15px; font-weight: 700; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: background .2s, transform .1s, box-shadow .2s;
      margin-bottom: 20px;
    }
    .btn-submit:hover  { background: var(--accent-h); box-shadow: 0 4px 20px rgba(79,142,247,.4); }
    .btn-submit:active { transform: scale(.98); }

    /* Spinner */
    .spinner {
      display: none; width: 18px; height: 18px;
      border: 2.5px solid rgba(255,255,255,.3); border-top-color: white;
      border-radius: 50%; animation: spin .6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-loading .spinner  { display: inline-block; }
    .btn-loading .btn-text { display: none; }
    .btn-loading           { pointer-events: none; }

    /* ── Bottom link ── */
    .bottom-link { text-align: center; font-size: 13px; color: var(--text-muted); }
    .bottom-link a { color: var(--link); font-weight: 700; text-decoration: none; }
    .bottom-link a:hover { text-decoration: underline; }

    /* ── Staggered children inside page-content ── */
    .page-content > * {
      animation: fadeSlideIn .5s cubic-bezier(.4,0,.2,1) both;
    }
    .page-content > *:nth-child(1) { animation-delay: .05s; }
    .page-content > *:nth-child(2) { animation-delay: .10s; }
    .page-content > *:nth-child(3) { animation-delay: .15s; }
    .page-content > *:nth-child(4) { animation-delay: .20s; }
    .page-content > *:nth-child(5) { animation-delay: .25s; }

    /* Stagger inside form-panel too */
    .form-panel > * {
      animation: fadeSlideIn .45s cubic-bezier(.4,0,.2,1) both;
    }
    .form-panel > *:nth-child(1)  { animation-delay: .08s; }
    .form-panel > *:nth-child(2)  { animation-delay: .13s; }
    .form-panel > *:nth-child(3)  { animation-delay: .18s; }
    .form-panel > *:nth-child(4)  { animation-delay: .23s; }
    .form-panel > *:nth-child(5)  { animation-delay: .28s; }
    .form-panel > *:nth-child(6)  { animation-delay: .33s; }
    .form-panel > *:nth-child(7)  { animation-delay: .36s; }
    .form-panel > *:nth-child(8)  { animation-delay: .39s; }
    .form-panel > *:nth-child(9)  { animation-delay: .42s; }
    .form-panel > *:nth-child(10) { animation-delay: .44s; }
    .hidden { display: none !important; }

    /* ══════════════════════════════════════════
       LOCATION DROPDOWN
    ══════════════════════════════════════════ */
    .loc-wrap { position: relative; }
    .loc-btn {
      display: flex; align-items: center; gap: 6px;
      padding: 8px 14px;
      color: rgba(255,255,255,.85);
      font-size: 14px; font-weight: 500;
      text-decoration: none; border-radius: 20px;
      border: none; background: none; cursor: pointer;
      font-family: inherit;
      transition: background .2s, color .2s;
    }
    .loc-btn:hover,
    .loc-btn.open { background: rgba(255,255,255,.15); color: white; }
    .loc-btn svg  { opacity: .75; transition: transform .2s; }
    .loc-btn.open svg { transform: rotate(180deg); opacity: 1; }

    .loc-dropdown {
      position: absolute; top: calc(100% + 8px); left: 0;
      background: white; border-radius: 12px;
      box-shadow: 0 8px 36px rgba(0,0,0,.22), 0 2px 8px rgba(0,0,0,.1);
      min-width: 200px; overflow: hidden; z-index: 999;
      opacity: 0; transform: translateY(-6px) scale(.97);
      pointer-events: none;
      transition: opacity .18s ease, transform .18s ease;
    }
    .loc-dropdown.open {
      opacity: 1; transform: translateY(0) scale(1);
      pointer-events: auto;
    }
    .loc-item {
      display: flex; align-items: center; gap: 12px;
      padding: 13px 18px;
      font-size: 14px; font-weight: 500; color: #111827 !important;
      cursor: pointer; text-decoration: none;
      transition: background .12s;
      border: none; background: none; width: 100%; text-align: left;
      font-family: inherit;
    }
    .loc-item:hover { background: #f9fafb !important; }
    .loc-flag {
      width: 28px; height: 28px; border-radius: 50%;
      flex-shrink: 0; overflow: hidden;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px; line-height: 1;
      border: 1px solid rgba(0,0,0,.08);
    }
    .loc-check {
      margin-left: auto; color: #111827 !important;
      display: none;
    }
    .loc-item.selected .loc-check { display: block; }
    ══════════════════════════════════════════ */
    .stats-strip {
      position: absolute; bottom: 36px; left: 56px; z-index: 5;
      display: flex; align-items: center; gap: 28px;
    }
    .stat { display: flex; flex-direction: column; }
    .stat .num { font-size: 22px; font-weight: 800; color: white; letter-spacing: -.5px; line-height: 1; }
    .stat .lbl { font-size: 11px; color: rgba(255,255,255,.5); font-weight: 500; margin-top: 2px; }
    .stat-sep  { width: 1px; height: 32px; background: rgba(255,255,255,.18); }

    /* ══════════════════════════════════════════
       LIVE BADGE (bottom-right)
    ══════════════════════════════════════════ */
    .live-badge {
      position: absolute; bottom: 44px; right: 56px; z-index: 5;
      display: flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,.1); backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,.18);
      border-radius: 24px; padding: 8px 16px;
      color: white; font-size: 12px; font-weight: 600;
    }
    .live-dot {
      width: 7px; height: 7px; border-radius: 50%; background: #22c55e;
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%,100% { opacity:1; box-shadow: 0 0 0 0 rgba(34,197,94,.5); }
      50%      { opacity:.8; box-shadow: 0 0 0 5px rgba(34,197,94,0); }
    }
  </style>
  @stack('styles')
</head>
<body>
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>

  {{-- ══ NAVBAR ══ --}}
  <nav class="navbar">
    <a href="{{ route('splash') }}" class="nav-logo">
      <div class="logo-box">
        <img src="{{ asset('logo.png') }}" alt="SmartParking"/>
      </div>
      <span>SmartParking</span>
    </a>

    <ul class="nav-links">
      <li><button type="button">Layanan <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></button></li>

      {{-- Lokasi Dropdown --}}
      <li class="loc-wrap" id="locMenu">
        <button type="button" class="loc-btn" id="locBtn" onclick="toggleLocMenu()">
          <span id="locLabel">Surabaya</span>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
        </button>
        <div class="loc-dropdown" id="locDropdown">
          <button class="loc-item selected" id="opt-surabaya" onclick="selectLoc('Surabaya','opt-surabaya')">
            <span>Surabaya</span>
            <svg class="loc-check" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
          </button>
          <button class="loc-item" id="opt-sidoarjo" onclick="selectLoc('Sidoarjo','opt-sidoarjo')">
            <span>Sidoarjo</span>
            <svg class="loc-check" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
          </button>
        </div>
      </li>

      <li><button type="button">Tentang <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></button></li>
      <li><a href="#">FAQ</a></li>
      <li><a href="#">Kontak</a></li>
    </ul>

    @yield('nav-cta')
  </nav>

  {{-- ══ PAGE CONTENT ══ --}}
  <div class="hero-body">
    <div class="page-content" id="pageContent">
      @yield('content')
    </div>
  </div>

  @yield('extras')
</section>

<script>
/* ── Location Dropdown ── */
function toggleLocMenu() {
  const dd  = document.getElementById('locDropdown');
  const btn = document.getElementById('locBtn');
  const isOpen = dd.classList.contains('open');
  dd.classList.toggle('open', !isOpen);
  btn.classList.toggle('open', !isOpen);
}

function selectLoc(name, optId) {
  // Update label
  document.getElementById('locLabel').textContent = name;
  // Update selected state
  document.querySelectorAll('.loc-item').forEach(el => el.classList.remove('selected'));
  document.getElementById(optId).classList.add('selected');
  // Close
  document.getElementById('locDropdown').classList.remove('open');
  document.getElementById('locBtn').classList.remove('open');
}

// Close loc dropdown on outside click
document.addEventListener('click', function(e) {
  const menu = document.getElementById('locMenu');
  if (menu && !menu.contains(e.target)) {
    document.getElementById('locDropdown')?.classList.remove('open');
    document.getElementById('locBtn')?.classList.remove('open');
  }
});

/* ── Toggle password visibility ── */
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.classList.toggle('active');
  btn.querySelector('.eye-open').classList.toggle('hidden');
  btn.querySelector('.eye-off').classList.toggle('hidden');
}

/* ══════════════════════════════════════════
   PAGE TRANSITION SYSTEM
══════════════════════════════════════════ */
const content = document.getElementById('pageContent');

/* Navigate with exit animation */
function navigateTo(url) {
  if (!content) { location.href = url; return; }
  content.classList.add('leaving');
  setTimeout(() => { location.href = url; }, 340);
}

/* Intercept all internal <a> links */
document.addEventListener('click', e => {
  const a = e.target.closest('a[href]');
  if (!a) return;
  const href = a.getAttribute('href');
  /* Skip: external, hash, javascript: */
  if (!href || href.startsWith('#') || href.startsWith('javascript') ||
      href.startsWith('http') || href.startsWith('mailto')) return;
  e.preventDefault();
  navigateTo(href);
});

/* Intercept form submissions – add exit animation before submit */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
      const btn = this.querySelector('.btn-submit');
      if (btn) btn.classList.add('btn-loading');
      /* No exit animation on form submit (stays on page if validation fails) */
    });
  });
});
</script>
@stack('scripts')
</body>
</html>
