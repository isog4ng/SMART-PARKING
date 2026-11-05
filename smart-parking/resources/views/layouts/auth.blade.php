<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Smart Parking – @yield('title', 'Welcome')</title>
  <style>
    /* ══════════════════════════════════════════
       GLOBAL RESET & VARIABLES
    ══════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:          #0f1117;
      --bg-panel:    #161b27;
      --bg-card:     #1e2535;
      --bg-input:    #252d3d;
      --border:      #2e3a52;
      --border-focus:#4f8ef7;
      --text:        #f1f5f9;
      --text-muted:  #8896b0;
      --text-ph:     #4a5568;
      --accent:      #4f8ef7;
      --accent-h:    #3a7ae8;
      --accent-glow: rgba(79,142,247,.25);
      --danger:      #ef4444;
      --success:     #22c55e;
      --google:      #1e2535;
      --fb:          #1877F2;
    }

    html, body {
      height: 100%;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background: var(--bg);
      color: var(--text);
      overflow: hidden;
    }

    /* ══════════════════════════════════════════
       LAYOUT – SPLIT SCREEN
    ══════════════════════════════════════════ */
    .wrapper {
      display: flex;
      height: 100vh;
      width: 100vw;
    }

    /* ── Left Panel (Hero) ── */
    .hero {
      flex: 1.1;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 56px 60px;
    }
    .hero-bg {
      position: absolute; inset: 0;
      background:
        linear-gradient(135deg, rgba(15,17,23,.55) 0%, rgba(79,142,247,.12) 100%),
        url('https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=1400&q=85') center/cover no-repeat;
      filter: brightness(.75) saturate(1.1);
      transition: transform 8s ease;
    }
    .hero:hover .hero-bg { transform: scale(1.03); }

    /* gradient overlay */
    .hero::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(10,13,20,.92) 0%, rgba(10,13,20,.3) 60%, transparent 100%);
    }

    .hero-content { position: relative; z-index: 2; }

    .hero-logo {
      position: absolute; top: 44px; left: 56px; z-index: 3;
      display: flex; align-items: center; gap: 10px;
    }
    .hero-logo .logo-icon {
      width: 46px; height: 46px;
      border-radius: 13px;
      background: #ffffff;
      display: flex; align-items: center; justify-content: center;
      padding: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,.18);
    }
    .hero-logo .logo-icon img { width: 100%; height: 100%; object-fit: contain; }
    .hero-logo span { font-size: 18px; font-weight: 800; letter-spacing: -.3px; color: white; }

    .hero-badge {
      display: inline-flex; align-items: center; gap: 7px;
      background: rgba(79,142,247,.18);
      border: 1px solid rgba(79,142,247,.35);
      color: #93c5fd; padding: 6px 14px;
      border-radius: 20px; font-size: 12px; font-weight: 600;
      margin-bottom: 20px;
      backdrop-filter: blur(8px);
    }
    .hero-badge span { width: 7px; height: 7px; border-radius: 50%; background: var(--accent); display: inline-block; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

    .hero h1 {
      font-size: clamp(28px, 3vw, 42px);
      font-weight: 900; line-height: 1.18;
      color: white; margin-bottom: 16px;
      letter-spacing: -.5px;
    }
    .hero h1 span { color: var(--accent); }

    .hero p {
      font-size: 15px; color: rgba(255,255,255,.65);
      line-height: 1.7; max-width: 420px; margin-bottom: 36px;
    }

    /* Stats strip */
    .stats {
      display: flex; gap: 32px;
    }
    .stat-item { display: flex; flex-direction: column; gap: 2px; }
    .stat-item .num {
      font-size: 22px; font-weight: 800; color: white; letter-spacing: -.5px;
    }
    .stat-item .lbl { font-size: 12px; color: rgba(255,255,255,.5); font-weight: 500; }
    .stat-sep {
      width: 1px; background: rgba(255,255,255,.12); align-self: stretch; margin: 2px 0;
    }

    /* ── Right Panel (Form) ── */
    .panel {
      flex: .9;
      background: var(--bg-panel);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 48px 60px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: var(--border) transparent;
    }
    .panel::-webkit-scrollbar { width: 4px; }
    .panel::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .form-box { width: 100%; max-width: 420px; }

    /* ══════════════════════════════════════════
       FORM ELEMENTS
    ══════════════════════════════════════════ */
    .form-title { font-size: 28px; font-weight: 800; color: var(--text); margin-bottom: 6px; letter-spacing: -.4px; }
    .form-sub   { font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 32px; }

    .field { display: flex; flex-direction: column; gap: 7px; margin-bottom: 20px; }
    .field label { font-size: 13px; font-weight: 600; color: var(--text); }
    .input-wrap { position: relative; display: flex; align-items: center; }
    .input-wrap input {
      width: 100%;
      padding: 13px 44px 13px 16px;
      background: var(--bg-input);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      color: var(--text);
      font-size: 14px;
      outline: none;
      transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .input-wrap input::placeholder { color: var(--text-ph); }
    .input-wrap input:focus {
      border-color: var(--border-focus);
      background: #1e2a3f;
      box-shadow: 0 0 0 4px var(--accent-glow);
    }
    .input-wrap input.is-invalid { border-color: var(--danger); }
    .input-wrap input.is-invalid:focus { box-shadow: 0 0 0 4px rgba(239,68,68,.2); }

    .input-icon {
      position: absolute; left: 14px;
      color: var(--text-muted); pointer-events: none;
      display: flex; align-items: center;
    }
    .has-icon input { padding-left: 42px; }

    .toggle-pw {
      position: absolute; right: 14px;
      background: none; border: none; cursor: pointer;
      color: var(--text-muted); display: flex; align-items: center; padding: 4px;
      transition: color .2s;
    }
    .toggle-pw:hover { color: var(--text); }
    .toggle-pw.active { color: var(--accent); }

    .err-msg { font-size: 12px; color: var(--danger); display: flex; align-items: center; gap: 4px; }
    .err-msg::before { content: '⚠'; font-size: 11px; }

    /* ── Two-column row ── */
    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    /* ── Check row ── */
    .check-row {
      display: flex; align-items: flex-start; gap: 10px;
      font-size: 13px; color: var(--text-muted); line-height: 1.5; cursor: pointer;
    }
    .check-row input[type="checkbox"] {
      width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px;
      accent-color: var(--accent); cursor: pointer; border-radius: 4px;
    }
    .check-row a { color: var(--accent); text-decoration: none; font-weight: 500; }
    .check-row a:hover { text-decoration: underline; }

    /* ── Flex row for check + forgot ── */
    .flex-between {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 24px; gap: 12px;
    }
    .forgot-link { font-size: 13px; color: var(--accent); text-decoration: none; white-space: nowrap; }
    .forgot-link:hover { text-decoration: underline; }

    /* ── Primary Button ── */
    .btn-primary {
      width: 100%; padding: 14px;
      background: var(--accent);
      color: white; border: none; border-radius: 10px;
      font-size: 15px; font-weight: 700; cursor: pointer;
      transition: background .2s, transform .1s, box-shadow .2s;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      position: relative; overflow: hidden;
    }
    .btn-primary::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.12), transparent);
      transform: translateX(-100%);
      transition: transform .4s;
    }
    .btn-primary:hover::before { transform: translateX(100%); }
    .btn-primary:hover  { background: var(--accent-h); box-shadow: 0 4px 20px var(--accent-glow); }
    .btn-primary:active { transform: scale(.98); }

    /* ── Spinner ── */
    .spinner {
      display: none;
      width: 18px; height: 18px;
      border: 2.5px solid rgba(255,255,255,.3);
      border-top-color: white;
      border-radius: 50%;
      animation: spin .6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-loading .spinner    { display: inline-block; }
    .btn-loading .btn-text   { display: none; }
    .btn-loading             { pointer-events: none; }

    /* ── Divider ── */
    .divider {
      display: flex; align-items: center; gap: 12px;
      color: var(--text-muted); font-size: 12px; font-weight: 500;
      margin: 24px 0;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: var(--border);
    }

    /* ── Social Buttons ── */
    .social-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; }
    .social-btn {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      padding: 11px; background: var(--bg-card);
      border: 1.5px solid var(--border); border-radius: 10px;
      color: var(--text); font-size: 13px; font-weight: 600;
      cursor: pointer; transition: background .2s, border-color .2s, transform .1s;
    }
    .social-btn:hover { background: var(--bg-input); border-color: #3e4f70; transform: translateY(-1px); }
    .social-btn:active { transform: translateY(0); }
    .g-icon {
      width: 20px; height: 20px; border-radius: 50%; background: white;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .g-icon svg { width: 14px; height: 14px; }
    .fb-icon {
      width: 20px; height: 20px; border-radius: 4px; background: var(--fb);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .fb-icon svg { width: 11px; height: 11px; fill: white; }

    /* ── Bottom Link ── */
    .bottom-link { text-align: center; font-size: 14px; color: var(--text-muted); }
    .bottom-link a { color: var(--accent); font-weight: 600; text-decoration: none; }
    .bottom-link a:hover { text-decoration: underline; }

    /* ══════════════════════════════════════════
       ALERTS
    ══════════════════════════════════════════ */
    .alert {
      display: flex; align-items: flex-start; gap: 10px;
      padding: 12px 16px; border-radius: 10px;
      font-size: 13px; font-weight: 500; margin-bottom: 20px;
    }
    .alert-success { background: rgba(34,197,94,.1); color: #4ade80; border: 1px solid rgba(34,197,94,.25); }
    .alert-error   { background: rgba(239,68,68,.1); color: #f87171; border: 1px solid rgba(239,68,68,.25); }
    .alert svg { flex-shrink: 0; margin-top: 1px; }

    /* ══════════════════════════════════════════
       DECORATIVE DOTS
    ══════════════════════════════════════════ */
    .dot-grid {
      position: absolute; bottom: -20px; right: -20px;
      width: 180px; height: 180px; z-index: 0; opacity: .15;
      background-image: radial-gradient(circle, #4f8ef7 1px, transparent 1px);
      background-size: 18px 18px;
      pointer-events: none;
    }
    .panel { position: relative; }

    /* ══════════════════════════════════════════
       SPLASH SCREEN
    ══════════════════════════════════════════ */
    .splash-panel {
      flex: .9;
      background: var(--bg-panel);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 48px 60px;
      position: relative; overflow: hidden;
    }
    .splash-box { width: 100%; max-width: 380px; text-align: center; position: relative; z-index: 1; }
    .splash-icon {
      width: 80px; height: 80px;
      border-radius: 22px;
      background: #ffffff;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 24px;
      padding: 14px;
      box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 2px 8px rgba(0,0,0,.08);
    }
    .splash-icon img { width: 100%; height: 100%; object-fit: contain; }
    .splash-box h2 { font-size: 26px; font-weight: 800; color: var(--text); margin-bottom: 12px; letter-spacing: -.4px; }
    .splash-box p  { font-size: 14px; color: var(--text-muted); line-height: 1.7; margin-bottom: 36px; }

    .splash-actions { display: flex; flex-direction: column; gap: 12px; }
    .btn-secondary {
      width: 100%; padding: 13px;
      background: transparent; color: var(--text);
      border: 1.5px solid var(--border); border-radius: 10px;
      font-size: 14px; font-weight: 600; cursor: pointer;
      text-decoration: none; display: block; text-align: center;
      transition: background .2s, border-color .2s;
    }
    .btn-secondary:hover { background: var(--bg-card); border-color: #3e4f70; }

    /* ── Features list ── */
    .feature-list { text-align: left; display: flex; flex-direction: column; gap: 14px; margin-bottom: 36px; }
    .feature-item { display: flex; align-items: center; gap: 12px; }
    .feature-icon {
      width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
      background: rgba(79,142,247,.12); border: 1px solid rgba(79,142,247,.2);
      display: flex; align-items: center; justify-content: center;
      color: var(--accent);
    }
    .feature-icon svg { width: 16px; height: 16px; fill: currentColor; }
    .feature-text { font-size: 13px; color: var(--text-muted); }
    .feature-text strong { color: var(--text); font-weight: 600; display: block; margin-bottom: 1px; }

    @media (max-width: 900px) {
      .hero { display: none; }
      .panel, .splash-panel { flex: 1; }
    }
  </style>
  @stack('styles')
</head>
<body>
<div class="wrapper">

  {{-- ══ HERO / LEFT PANEL ══ --}}
  <div class="hero">
    <div class="hero-bg"></div>

    <div class="hero-logo">
      <div class="logo-icon">
        <img src="{{ asset('logo.png') }}" alt="Smart Parking Logo"/>
      </div>
      <span>SmartParking</span>
    </div>

    <div class="hero-content">
      <div class="hero-badge">
        <span></span> Platform Parkir Terdepan di Indonesia
      </div>
      <h1>Parkir <span>Lebih Cepat</span>,<br>Tanpa Ribet.</h1>
      <p>Dukung mobilitas pintar dengan teknologi parkir otomatis. Temukan, reservasi, dan bayar parkir dalam satu genggaman tangan.</p>
      <div class="stats">
        <div class="stat-item">
          <span class="num">500+</span>
          <span class="lbl">Lokasi Parkir</span>
        </div>
      </div>
    </div>
  </div>

  {{-- ══ RIGHT PANEL (Form Content) ══ --}}
  @yield('content')

</div>

<script>
  /* Toggle password visibility */
  function togglePw(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.classList.toggle('active');
    // swap icon
    btn.querySelector('.eye-open').classList.toggle('hidden');
    btn.querySelector('.eye-off').classList.toggle('hidden');
  }

  /* Loading state */
  document.querySelectorAll('form').forEach(f => {
    f.addEventListener('submit', function() {
      const btn = this.querySelector('.btn-primary');
      if (btn) btn.classList.add('btn-loading');
    });
  });
</script>
@stack('scripts')
</body>
</html>
