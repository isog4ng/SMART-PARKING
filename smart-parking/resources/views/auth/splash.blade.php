@extends('layouts.hero')
@section('title','Selamat Datang')

@section('content')
<div class="page-content" id="pageContent" style="text-align:center; padding: 0 24px 80px; width:100%; max-width:680px;">

  {{-- Headline --}}
  <h1 style="
    font-size:clamp(42px, 6vw, 76px);
    font-weight:900; color:white; line-height:1.08;
    letter-spacing:-2px; margin-bottom:22px;
    text-shadow:0 2px 40px rgba(0,0,0,.35);
  ">
    Parkir Lebih Cepat,<br>Tanpa Ribet.
  </h1>

  {{-- Subtitle --}}
  <p style="
    font-size:clamp(15px,1.3vw,18px); color:rgba(255,255,255,.70);
    line-height:1.7; max-width:500px; margin:0 auto 44px;
  ">
    Platform parkir cerdas yang membantu Anda menemukan, memesan, dan membayar parkir dalam satu genggaman di ratusan lokasi strategis.
  </p>

  {{-- CTA --}}
  <div style="display:flex; flex-direction:column; align-items:center; gap:18px;">
    <a href="{{ route('register') }}"
      class="splash-btn"
      style="
        display:inline-flex; align-items:center; justify-content:center;
        background:rgba(20,20,20,.85);
        backdrop-filter:blur(10px);
        border-radius:50px; padding:15px 40px;
        font-size:15px; font-weight:600; color:white;
        letter-spacing:.2px; text-decoration:none;
        box-shadow:0 4px 24px rgba(0,0,0,.35);
        transition:transform .2s, box-shadow .2s, background .2s;
      ">
      Mulai Sekarang
    </a>

    <span style="font-size:14px; color:rgba(255,255,255,.60);">
      Sudah punya akun?
      <a href="{{ route('login') }}"
        style="color:white; font-weight:600; text-decoration:none;
               border-bottom:1px solid rgba(255,255,255,.4); padding-bottom:1px;">
        Masuk
      </a>
    </span>
  </div>
</div>

@push('styles')
<style>
.splash-btn:hover {
  background: rgba(10,10,10,.96) !important;
  transform: translateY(-3px) !important;
  box-shadow: 0 10px 36px rgba(0,0,0,.45) !important;
}
.splash-btn:active { transform: translateY(0) !important; }
</style>
@endpush
@endsection

@section('extras')
{{-- Stats bottom-left --}}
<div class="stats-strip">
  <div class="stat"><span class="num">500+</span><span class="lbl">Lokasi Parkir</span></div>
  <div class="stat-sep"></div>
@endsection
