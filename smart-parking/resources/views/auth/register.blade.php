<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Daftar – Smart Parking</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
      height: 100%;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      font-size: 14px;
      color: #111827;
      background: #fff;
      -webkit-font-smoothing: antialiased;
    }

    /* ═══════════════════════════════
       NAVBAR
    ═══════════════════════════════ */
    .navbar {
      position: fixed; top: 0; left: 0; right: 0; z-index: 100;
      height: 48px;
      background: #fff;
      border-bottom: 1px solid #e5e7eb;
      display: flex; align-items: center;
      justify-content: space-between;
      padding: 0 20px;
    }

    .nav-logo {
      display: flex; align-items: center; gap: 7px;
      text-decoration: none; color: #111827;
    }
    .nav-logo .logo-box {
      width: 28px; height: 28px; border-radius: 7px;
      background: #2563eb;
      display: flex; align-items: center; justify-content: center;
      padding: 5px;
    }
    .nav-logo .logo-box img {
      width: 100%; height: 100%;
      object-fit: contain;
      filter: brightness(0) invert(1);
    }
    .nav-logo-text {
      font-size: 15px; font-weight: 700; letter-spacing: -.2px; color: #111827;
    }

    .nav-right { display: flex; align-items: center; gap: 10px; }
    .nav-btn {
      display: flex; align-items: center; gap: 6px;
      padding: 6px 14px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 13px; font-weight: 500; color: #374151;
      background: #fff; cursor: pointer; text-decoration: none;
      font-family: 'Inter', sans-serif;
      transition: background .15s, border-color .15s;
    }
    .nav-btn:hover { background: #f9fafb; border-color: #9ca3af; }

    /* ═══════════════════════════════
       PAGE LAYOUT
    ═══════════════════════════════ */
    .page {
      display: flex;
      min-height: 100vh;
      padding-top: 48px;
    }

    /* ═══════════════════════════════
       LEFT PANEL – FORM
    ═══════════════════════════════ */
    .left {
      width: 540px;
      flex-shrink: 0;
      padding: 36px 48px 48px 116px;
      border-right: 1px solid #e5e7eb;
      overflow-y: auto;
      animation: fadeUp .35s ease both;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Title */
    .form-title {
      font-size: 26px; font-weight: 800;
      color: #111827; margin-bottom: 5px;
      letter-spacing: -.5px; line-height: 1.2;
    }
    .form-sub {
      font-size: 13px; color: #6b7280;
      margin-bottom: 24px; line-height: 1.5;
    }
    .form-sub a {
      color: #111827; font-weight: 700;
      text-decoration: underline;
    }
    .form-sub a:hover { color: #2563eb; }

    /* Alert */
    .alert-err {
      padding: 10px 12px; border-radius: 6px;
      font-size: 13px; color: #dc2626;
      background: #fef2f2; border: 1px solid #fecaca;
      margin-bottom: 14px;
    }

    /* Google Button */
    .btn-google {
      width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;
      padding: 10px 16px;
      background: #fff; border: 1px solid #d1d5db;
      border-radius: 6px; cursor: pointer;
      font-size: 14px; font-weight: 500; color: #374151;
      font-family: 'Inter', sans-serif;
      transition: background .15s, border-color .15s;
      margin-bottom: 18px;
    }
    .btn-google:hover { background: #f9fafb; border-color: #9ca3af; }
    .g-logo { width: 18px; height: 18px; }

    /* Divider */
    .or-row {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 18px; color: #9ca3af; font-size: 13px;
    }
    .or-row::before, .or-row::after {
      content: ''; flex: 1; height: 1px; background: #e5e7eb;
    }

    /* Field */
    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .field { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
    .field label {
      font-size: 12.5px; font-weight: 500; color: #374151;
    }
    .field input {
      padding: 9px 11px;
      border: 1px solid #d1d5db; border-radius: 5px;
      font-size: 13.5px; color: #111827;
      font-family: 'Inter', sans-serif;
      outline: none; background: #fff;
      transition: border-color .15s, box-shadow .15s;
      width: 100%;
    }
    .field input::placeholder { color: #9ca3af; font-size: 13px; }
    .field input:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .field input.is-invalid { border-color: #dc2626; }
    .err-msg { font-size: 11.5px; color: #dc2626; margin-top: 2px; }

    /* Phone field */
    .phone-wrap { display: flex; }
    .phone-flag {
      display: flex; align-items: center; gap: 4px;
      padding: 9px 10px;
      border: 1px solid #d1d5db; border-right: none;
      border-radius: 5px 0 0 5px;
      background: #fff; cursor: pointer;
      font-size: 13px; color: #374151;
      white-space: nowrap;
    }
    .phone-flag:hover { background: #f9fafb; }
    .phone-wrap input {
      border-radius: 0 5px 5px 0 !important;
      border-left: none !important;
      flex: 1;
    }
    .phone-wrap input:focus { z-index: 1; position: relative; }

    /* Password wrap */
    .pw-wrap { position: relative; }
    .pw-wrap input { padding-right: 36px; }
    .toggle-pw {
      position: absolute; right: 9px; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer; padding: 2px;
      color: #9ca3af; display: flex; align-items: center;
      transition: color .15s;
    }
    .toggle-pw:hover { color: #374151; }
    .toggle-pw.on { color: #2563eb; }
    .hidden { display: none !important; }

    /* Terms */
    .terms-block {
      font-size: 12px; color: #6b7280;
      line-height: 1.65; margin-bottom: 14px;
    }
    .terms-block a {
      color: #111827; font-weight: 600;
      text-decoration: underline;
    }
    .terms-block a:hover { color: #2563eb; }

    /* Submit */
    .btn-submit {
      width: 100%; padding: 10px;
      background: #e5e7eb; color: #9ca3af;
      border: 1px solid #e5e7eb; border-radius: 6px;
      font-size: 14px; font-weight: 600;
      font-family: 'Inter', sans-serif; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: background .2s, color .2s, border-color .2s, transform .1s;
    }
    /* Activate when inputs have value */
    .btn-submit.active {
      background: #2563eb; color: #fff; border-color: #2563eb;
    }
    .btn-submit.active:hover  { background: #1d4ed8; border-color: #1d4ed8; }
    .btn-submit.active:active { transform: scale(.98); }
    .spinner {
      display: none; width: 16px; height: 16px;
      border: 2px solid rgba(255,255,255,.3); border-top-color: #fff;
      border-radius: 50%; animation: spin .6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-loading .spinner  { display: inline-block; }
    .btn-loading .btn-text { display: none; }
    .btn-loading           { pointer-events: none; background: #2563eb !important; color: #fff !important; }

    /* ═══════════════════════════════
       RIGHT PANEL – FEATURES
    ═══════════════════════════════ */
    .right {
      flex: 1;
      display: flex; align-items: flex-start;
      padding: 80px 0 48px 72px;
      animation: fadeUp .4s .08s ease both;
    }

    .features-box { max-width: 320px; }

    .features-title {
      font-size: 22px; font-weight: 800;
      color: #111827; margin-bottom: 28px;
      letter-spacing: -.4px; line-height: 1.25;
    }

    .feat {
      display: flex; align-items: flex-start; gap: 13px;
      margin-bottom: 22px;
    }
    .feat-icon {
      width: 28px; height: 28px; border-radius: 50%;
      flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      margin-top: 1px;
    }
    .feat-icon.navy   { background: #1e3a8a; }
    .feat-icon.navy2  { background: #1e40af; border-radius: 5px; }
    .feat-icon.amber  { background: #d97706; border-radius: 50%; }

    .feat-body h4 {
      font-size: 13.5px; font-weight: 700;
      color: #111827; margin-bottom: 4px;
      letter-spacing: -.1px;
    }
    .feat-body p {
      font-size: 13px; color: #6b7280;
      line-height: 1.55;
    }
    .feat-body a {
      color: #2563eb; text-decoration: none; font-weight: 500;
    }
    .feat-body a:hover { text-decoration: underline; }
  </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
  <a href="{{ route('splash') }}" class="nav-logo">
    <div class="logo-box">
      <img src="{{ asset('logo.png') }}" alt="SP"/>
    </div>
    <span class="nav-logo-text">SmartParking</span>
  </a>
  <div class="nav-right">
    <a href="{{ route('login') }}" class="nav-btn">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
      </svg>
      Masuk
    </a>
  </div>
</nav>

<div class="page">

  {{-- LEFT FORM --}}
  <div class="left">
    <h1 class="form-title">Daftar</h1>
    <p class="form-sub">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>

    @error('terms')<div class="alert-err">{{ $message }}</div>@enderror

    {{-- Google --}}
    <button class="btn-google" type="button">
      <svg class="g-logo" viewBox="0 0 24 24">
        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
      </svg>
      Continue with Google
    </button>

    <div class="or-row">atau</div>

    <form action="{{ route('register.post') }}" method="POST" novalidate id="regForm">
      @csrf

      {{-- Nama Depan + Belakang --}}
      <div class="row-2" style="margin-bottom:0">
        <div class="field">
          <label>Nama Depan</label>
          <input type="text" name="first_name" id="f_first"
            placeholder="Masukkan nama depan"
            value="{{ old('first_name') }}"
            class="{{ $errors->has('name') ? 'is-invalid' : '' }}"/>
        </div>
        <div class="field">
          <label>Nama Belakang</label>
          <input type="text" name="last_name" id="f_last"
            placeholder="Masukkan nama belakang"
            value="{{ old('last_name') }}"/>
        </div>
      </div>
      @error('name')<span class="err-msg" style="display:block;margin:-8px 0 10px;">{{ $message }}</span>@enderror

      {{-- Nomor HP --}}
      <div class="field">
        <label>Nomor HP</label>
        <div class="phone-wrap">
          <div class="phone-flag">
            🇮🇩 &nbsp;+62
            <svg width="10" height="10" viewBox="0 0 24 24" fill="#6b7280"><path d="M7 10l5 5 5-5z"/></svg>
          </div>
          <input type="tel" name="phone" id="f_phone" placeholder="8xx-xxxx-xxxx"/>
        </div>
      </div>

      {{-- Email --}}
      <div class="field">
        <label>Email</label>
        <input type="email" name="email" id="f_email"
          placeholder="Masukkan alamat email"
          value="{{ old('email') }}"
          class="{{ $errors->has('email') ? 'is-invalid' : '' }}"/>
        @error('email')<span class="err-msg">{{ $message }}</span>@enderror
      </div>

      {{-- Password --}}
      <div class="row-2" style="margin-bottom:0">
        <div class="field">
          <label>Password</label>
          <div class="pw-wrap">
            <input type="password" id="pw1" name="password"
              placeholder="Buat password"
              class="{{ $errors->has('password') ? 'is-invalid' : '' }}"/>
            <button type="button" class="toggle-pw" onclick="togglePw('pw1',this)" tabindex="-1">
              <svg class="eye-open" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
              <svg class="eye-off hidden" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27z"/></svg>
            </button>
          </div>
          @error('password')<span class="err-msg">{{ $message }}</span>@enderror
        </div>
        <div class="field">
          <label>Konfirmasi Password</label>
          <div class="pw-wrap">
            <input type="password" id="pw2" name="password_confirmation"
              placeholder="Ulangi password"/>
            <button type="button" class="toggle-pw" onclick="togglePw('pw2',this)" tabindex="-1">
              <svg class="eye-open" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
              <svg class="eye-off hidden" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27z"/></svg>
            </button>
          </div>
        </div>
      </div>

      {{-- Terms --}}
      <div class="terms-block">
        Dengan membuat akun, Anda menyetujui
        <a href="#">Syarat & Ketentuan SmartParking</a>
        dan mengakui <a href="#">Kebijakan Privasi SmartParking</a>.
        <input type="hidden" name="terms" value="1"/>
      </div>

      <button type="submit" class="btn-submit" id="submitBtn">
        <span class="btn-text">Buat akun</span>
        <div class="spinner"></div>
      </button>
    </form>
  </div>

  {{-- RIGHT FEATURES --}}
  <div class="right">
    <div class="features-box">
      <p class="features-title">Parkir jadi lebih mudah.</p>

      <div class="feat">
        <div class="feat-icon navy">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
          </svg>
        </div>
        <div class="feat-body">
          <h4>Promo & Penawaran</h4>
          <p>Buat akun untuk mendapatkan penawaran parkir eksklusif.</p>
        </div>
      </div>

      <div class="feat">
        <div class="feat-icon navy2">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
            <path d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
          </svg>
        </div>
        <div class="feat-body">
          <h4>Tiket & Riwayat Parkir</h4>
          <p>Akses semua <a href="#">tiket parkir</a> Anda dalam satu tempat di mana saja.</p>
        </div>
      </div>

      <div class="feat">
        <div class="feat-icon amber">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
            <path d="M7 2v11h3v9l7-12h-4l4-8z"/>
          </svg>
        </div>
        <div class="feat-body">
          <h4>Pembayaran Cepat</h4>
          <p>Simpan metode pembayaran dan profil kendaraan untuk checkout mudah.</p>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.classList.toggle('on');
  btn.querySelector('.eye-open').classList.toggle('hidden');
  btn.querySelector('.eye-off').classList.toggle('hidden');
}

// Activate submit button when required fields filled
const fields = ['f_first','f_email','pw1'];
const btn = document.getElementById('submitBtn');
function checkForm() {
  const filled = fields.every(id => document.getElementById(id).value.trim() !== '');
  btn.classList.toggle('active', filled);
}
fields.forEach(id => document.getElementById(id).addEventListener('input', checkForm));

// Loading on submit
document.getElementById('regForm').addEventListener('submit', function() {
  if (btn.classList.contains('active')) btn.classList.add('btn-loading');
});
</script>
</body>
</html>
