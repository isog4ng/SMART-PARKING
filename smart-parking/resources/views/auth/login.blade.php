<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Masuk – Smart Parking</title>
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
    .nav-logo-text { font-size: 15px; font-weight: 700; letter-spacing: -.2px; }

    .nav-right { display: flex; align-items: center; gap: 10px; }
    .nav-btn {
      display: flex; align-items: center; gap: 6px;
      padding: 6px 14px;
      border: 1px solid #d1d5db; border-radius: 6px;
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
       LEFT – FORM
    ═══════════════════════════════ */
    .left {
      width: 540px;
      flex-shrink: 0;
      padding: 48px 60px 48px 55px;
      border-right: 1px solid #e5e7eb;
      overflow-y: auto;
      animation: fadeUp .35s ease both;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .form-title {
      font-size: 28px; font-weight: 800;
      color: #111827; margin-bottom: 4px;
      letter-spacing: -.5px; line-height: 1.2;
    }
    .form-sub {
      font-size: 13px; color: #6b7280;
      margin-bottom: 22px; line-height: 1.5;
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
      margin-bottom: 20px;
    }
    .btn-google:hover { background: #f9fafb; border-color: #9ca3af; }
    .g-logo { width: 18px; height: 18px; }

    /* Divider */
    .or-row {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 20px; color: #6b7280; font-size: 13px;
    }
    .or-line {
      flex: 1; height: 1px; background: #e5e7eb;
    }

    /* Fields */
    .field { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
    .field label { font-size: 13px; font-weight: 500; color: #374151; }
    .field input {
      padding: 10px 12px;
      border: 1px solid #d1d5db; border-radius: 5px;
      font-size: 14px; color: #111827;
      font-family: 'Inter', sans-serif;
      outline: none; background: #fff;
      transition: border-color .15s, box-shadow .15s;
      width: 100%;
    }
    .field input::placeholder { color: #9ca3af; font-size: 13.5px; }
    .field input:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .field input.is-invalid { border-color: #dc2626; }
    .err-msg { font-size: 11.5px; color: #dc2626; margin-top: 2px; }

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

    /* Forgot Password */
    .forgot {
      font-size: 13px; font-weight: 700;
      color: #111827; text-decoration: none;
      display: inline-block; margin-bottom: 20px;
    }
    .forgot:hover { color: #2563eb; }

    /* Submit */
    .btn-submit {
      width: 100%; padding: 11px;
      background: #e5e7eb; color: #9ca3af;
      border: 1px solid #e5e7eb; border-radius: 6px;
      font-size: 14px; font-weight: 600;
      font-family: 'Inter', sans-serif; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: background .2s, color .2s, border-color .2s, transform .1s;
    }
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
       RIGHT – FEATURES
    ═══════════════════════════════ */
    .right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      padding: 48px 48px 48px 80px;
      animation: fadeUp .4s .08s ease both;
    }

    .features-box { max-width: 320px; }
    .features-title {
      font-size: 24px; font-weight: 800;
      color: #111827; margin-bottom: 24px;
      letter-spacing: -.5px; line-height: 1.25;
    }

    .feat {
      display: flex; align-items: flex-start; gap: 12px;
    }
    .feat-icon {
      width: 26px; height: 26px; border-radius: 50%;
      flex-shrink: 0; margin-top: 2px;
      display: flex; align-items: center; justify-content: center;
    }
    .feat-icon.navy  { background: #1e3a8a; }

    .feat-body h4 {
      font-size: 14px; font-weight: 700;
      color: #111827; margin-bottom: 5px;
      letter-spacing: -.1px;
    }
    .feat-body p {
      font-size: 13px; color: #6b7280; line-height: 1.6;
    }
    .feat-body p a { color: #2563eb; text-decoration: none; font-weight: 500; }
    .feat-body p a:hover { text-decoration: underline; }
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
    <a href="{{ route('register') }}" class="nav-btn">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
      </svg>
      Daftar
    </a>
  </div>
</nav>

<div class="page">

  {{-- LEFT: FORM --}}
  <div class="left">
    <h1 class="form-title">Selamat datang kembali</h1>
    <p class="form-sub">
      Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
    </p>

    {{-- Error alert --}}
    @if($errors->has('email') && str_contains($errors->first('email'), 'salah'))
    <div class="alert-err">{{ $errors->first('email') }}</div>
    @endif
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

    <div class="or-row">
      <span class="or-line"></span>
      <span>or</span>
      <span class="or-line"></span>
    </div>

    <form action="{{ route('login.post') }}" method="POST" novalidate id="loginForm">
      @csrf

      {{-- Email --}}
      <div class="field">
        <label>Email</label>
        <input type="email" name="email" id="f_email"
          placeholder="Enter your email address"
          value="{{ old('email') }}"
          class="{{ $errors->has('email') ? 'is-invalid' : '' }}"/>
        @error('email')
          @if(!str_contains($message,'salah'))
          <span class="err-msg">{{ $message }}</span>
          @endif
        @enderror
      </div>

      {{-- Password --}}
      <div class="field">
        <label>Password</label>
        <div class="pw-wrap">
          <input type="password" id="f_pw" name="password"
            placeholder="Enter your password"
            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"/>
          <button type="button" class="toggle-pw" onclick="togglePw('f_pw',this)" tabindex="-1">
            <svg class="eye-open" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
            <svg class="eye-off hidden" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27z"/></svg>
          </button>
        </div>
        @error('password')<span class="err-msg">{{ $message }}</span>@enderror
      </div>

      {{-- Forgot --}}
      <a href="#" class="forgot">Forgot Password?</a>

      <input type="hidden" name="terms" value="1"/>

      <button type="submit" class="btn-submit" id="submitBtn">
        <span class="btn-text">Log In</span>
        <div class="spinner"></div>
      </button>
    </form>
  </div>

  {{-- RIGHT: FEATURES --}}
  <div class="right">
    <div class="features-box">
      <p class="features-title">Buat parkir lebih mudah.</p>

      <div class="feat">
        <div class="feat-icon navy">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="white">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
          </svg>
        </div>
        <div class="feat-body">
          <h4>Atur parkirmu di satu tempat</h4>
          <p>Simpan semua reservasi, pembelian, dan informasi kendaraanmu di satu tempat supaya lebih mudah saat checkout.</p>
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

// Activate submit when fields filled
const emailInput = document.getElementById('f_email');
const pwInput    = document.getElementById('f_pw');
const btn        = document.getElementById('submitBtn');

function checkForm() {
  const filled = emailInput.value.trim() !== '' && pwInput.value.trim() !== '';
  btn.classList.toggle('active', filled);
}
emailInput.addEventListener('input', checkForm);
pwInput.addEventListener('input', checkForm);

document.getElementById('loginForm').addEventListener('submit', function() {
  if (btn.classList.contains('active')) btn.classList.add('btn-loading');
});
</script>
</body>
</html>
