@extends('layouts.hero')
@section('title', 'Dashboard – Smart Parking')

@section('nav-cta')
<div style="position:relative;" id="accountMenu">

  {{-- Trigger Button --}}
  <button onclick="toggleAccountMenu()" id="accountBtn" style="
    display:flex; align-items:center; gap:9px;
    background: rgba(255,255,255,.12); backdrop-filter:blur(8px);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 10px; padding: 7px 14px 7px 10px;
    cursor: pointer; color: white; font-family: inherit;
    font-size: 14px; font-weight: 600;
    transition: background .18s, border-color .18s;
  "
  onmouseover="this.style.background='rgba(255,255,255,.2)'"
  onmouseout="if(!document.getElementById('accountDropdown').classList.contains('open'))this.style.background='rgba(255,255,255,.12)'"
  >
    {{-- Avatar --}}
    <div style="
      width:30px; height:30px; border-radius:50%;
      background: linear-gradient(135deg,#4f8ef7,#2563eb);
      display:flex; align-items:center; justify-content:center;
      font-size:12px; font-weight:800; color:white; flex-shrink:0;
    ">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
    <span>{{ Auth::user()->name }}</span>
    <svg id="chevronIcon" width="14" height="14" viewBox="0 0 24 24" fill="rgba(255,255,255,.8)"
      style="transition:transform .2s;">
      <path d="M7 10l5 5 5-5z"/>
    </svg>
  </button>

  {{-- Dropdown --}}
  <div id="accountDropdown" style="
    position: absolute; top: calc(100% + 10px); right: 0;
    background: white; border-radius: 12px;
    box-shadow: 0 8px 40px rgba(0,0,0,.18), 0 2px 8px rgba(0,0,0,.08);
    min-width: 220px; overflow: hidden;
    opacity: 0; transform: translateY(-8px) scale(.97);
    pointer-events: none;
    transition: opacity .18s ease, transform .18s ease;
    z-index: 999;
  ">
    {{-- Group 1 --}}
    <div style="padding: 6px 0;">
      <a href="#" class="dd-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#6b7280;flex-shrink:0"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>
        Sesi Parkir
      </a>
      <a href="#" class="dd-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#6b7280;flex-shrink:0"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14H7v-2h5v2zm5-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        Parkir Bulanan
      </a>
      <a href="#" class="dd-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#6b7280;flex-shrink:0"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        Favorit
      </a>
    </div>

    {{-- Divider --}}
    <div style="height:1px; background:#f3f4f6; margin:0 4px;"></div>

    {{-- Group 2 --}}
    <div style="padding: 6px 0;">
      <a href="#" class="dd-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#6b7280;flex-shrink:0"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        Profil
      </a>
      <a href="#" class="dd-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#6b7280;flex-shrink:0"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
        Metode Pembayaran
      </a>
      <a href="#" class="dd-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#6b7280;flex-shrink:0"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>
        Kendaraan
      </a>
    </div>

    {{-- Divider --}}
    <div style="height:1px; background:#f3f4f6; margin:0 4px;"></div>

    {{-- Logout --}}
    <div style="padding: 6px 0;">
      <form action="{{ route('logout') }}" method="POST" style="margin:0">
        @csrf
        <button type="submit" class="dd-item dd-logout" style="
          width:100%; text-align:left; background:none;
          border:none; cursor:pointer; font-family:inherit;
        ">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#ef4444;flex-shrink:0"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
          <span style="color:#ef4444;">Keluar</span>
        </button>
      </form>
    </div>
  </div>
</div>

<style>
.dd-item {
  display: flex; align-items: center; gap: 11px;
  padding: 10px 18px;
  font-size: 14px; font-weight: 500; color: #111827;
  text-decoration: none; cursor: pointer;
  transition: background .12s;
  line-height: 1;
}
.dd-item:hover { background: #f9fafb; }
.dd-logout:hover { background: #fff5f5 !important; }
#accountDropdown.open {
  opacity: 1 !important;
  transform: translateY(0) scale(1) !important;
  pointer-events: auto !important;
}
</style>
@endsection

@section('content')
<div class="page-content" id="pageContent" style="
  width:100%; height:100%;
  display:flex; flex-direction:column;
  justify-content:flex-end;
  padding: 0 56px 36px;
  box-sizing:border-box;
">

{{-- Headline --}}
  <h1 style="
    font-size:clamp(38px,5.5vw,70px);
    font-weight:900;color:white;line-height:1.08;
    letter-spacing:-2px;margin-bottom:14px;
    text-shadow:0 2px 32px rgba(0,0,0,.4);
    max-width:700px;
  ">
    Parkir untuk setiap perjalanan
  </h1>

  <p style="
    font-size:clamp(14px,1.2vw,17px);
    color:rgba(255,255,255,.75);
    line-height:1.6;margin-bottom:28px;
    max-width:460px;
  ">
    Temukan dan reservasi tempat parkir dengan mudah di ratusan lokasi strategis di seluruh Indonesia.
  </p>

  {{-- Tabs --}}
  <div style="display:flex;gap:8px;margin-bottom:20px;" id="searchTabs">
    <button onclick="setTab('reservasi')" id="tab-reservasi" style="
      padding:9px 22px;border-radius:24px;
      background:white;color:#111;
      border:none;font-size:14px;font-weight:800;cursor:pointer;
      transition:background .2s,color .2s;
    ">Reservasi</button>
    <button onclick="setTab('bulanan')" id="tab-bulanan" style="
      padding:9px 22px;border-radius:24px;
      background:rgba(255,255,255,.18);color:white;
      border:1px solid rgba(255,255,255,.25);
      font-size:14px;font-weight:600;cursor:pointer;
      backdrop-filter:blur(8px);
      transition:background .2s,color .2s;
    ">Bulanan</button>
  </div>

  {{-- Search Bar --}}
  {{-- === MODE RESERVASI === --}}
  <div id="bar-reservasi" style="
    display:grid;
    grid-template-columns: 1.9fr 1fr 1fr 0.7fr;
    gap:10px;
    max-width:960px;
    align-items:stretch;
  ">
    {{-- Card 1: Lokasi Parkir --}}
    <div style="background:white;border-radius:12px;padding:12px 18px;display:flex;flex-direction:column;gap:5px;position:relative;box-shadow:0 2px 16px rgba(0,0,0,.18);">
      <label style="font-size:12px;font-weight:500;color:#6b7280;">Lokasi Parkir</label>
      <div style="display:flex;align-items:center;gap:9px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#9ca3af" style="flex-shrink:0;">
          <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
        </svg>
        <input type="text" id="loc-input-res"
          placeholder="Masukkan Alamat, Kota, atau Venue"
          autocomplete="off"
          style="border:none;outline:none;font-size:15px;font-weight:400;color:#111;width:100%;background:transparent;font-family:inherit;"
          onfocus="openLocDropdown('res')"
          oninput="filterLoc('res')"
          onkeydown="handleLocKey(event,'res')"/>
      </div>
      {{-- Autocomplete Dropdown --}}
      <div id="loc-dd-res" style="
        display:none;position:absolute;top:calc(100% + 8px);left:0;right:0;
        background:white;border-radius:12px;z-index:500;
        box-shadow:0 8px 32px rgba(0,0,0,.22);
        overflow:hidden;min-width:340px;
      "></div>
    </div>

    {{-- Card 2: Waktu Masuk --}}
    <div id="col-masuk" style="
      background:white;border-radius:12px;padding:12px 18px;
      display:flex;flex-direction:column;gap:5px;
      box-shadow:0 2px 16px rgba(0,0,0,.18);
      cursor:pointer;
    " onclick="document.getElementById('masuk-time').showPicker()">
      <label style="font-size:12px;font-weight:500;color:#6b7280;cursor:pointer;">Waktu Masuk</label>
      <input type="datetime-local" id="masuk-time"
        value="{{ now()->format('Y-m-d\TH:i') }}"
        style="border:none;outline:none;font-size:15px;font-weight:400;color:#111;background:transparent;cursor:pointer;width:100%;font-family:inherit;padding:0;"/>
    </div>

    {{-- Card 3: Waktu Keluar --}}
    <div id="col-keluar" style="
      background:white;border-radius:12px;padding:12px 18px;
      display:flex;flex-direction:column;gap:5px;
      box-shadow:0 2px 16px rgba(0,0,0,.18);
      cursor:pointer;
    " onclick="document.getElementById('keluar-time').showPicker()">
      <label style="font-size:12px;font-weight:500;color:#ef4444;cursor:pointer;">Waktu Keluar</label>
      <input type="datetime-local" id="keluar-time"
        value="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}"
        style="border:none;outline:none;font-size:15px;font-weight:400;color:#111;background:transparent;cursor:pointer;width:100%;font-family:inherit;padding:0;"/>
    </div>

    {{-- Card 4: Find Button --}}
    <button style="
      background:#2563eb;color:white;
      border:none;border-radius:12px;
      font-size:15px;font-weight:700;
      padding:0 24px;cursor:pointer;white-space:nowrap;
      display:flex;align-items:center;justify-content:center;gap:9px;
      box-shadow:0 2px 16px rgba(0,0,0,.14);
      font-family:inherit;
      transition:background .2s;
    "
    onmouseover="this.style.background='#1d4ed8'"
    onmouseout="this.style.background='#2563eb'">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="white">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
      </svg>
      Cari Parkir
    </button>
  </div>

  {{-- === MODE BULANAN === --}}
  <div id="bar-bulanan" style="
    display:none;
    grid-template-columns: 1fr auto;
    gap:12px;
    max-width:900px;
    align-items:stretch;
  ">
    {{-- Search input --}}
    <div style="
      background:white; border-radius:14px;
      padding:14px 20px;
      display:flex;flex-direction:column;gap:5px;
      box-shadow:0 8px 40px rgba(0,0,0,.35);
      position:relative;
    ">
      <label style="font-size:12px;font-weight:600;color:#6b7280;letter-spacing:.1px;">
        Lokasi Parkir
      </label>
      <div style="display:flex;align-items:center;gap:10px;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="#9ca3af" style="flex-shrink:0;">
          <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
        </svg>
        <input type="text" id="loc-input-bul" placeholder="Masukkan Alamat, Kota, atau Venue"
          autocomplete="off"
          style="border:none;outline:none;font-size:15px;color:#111;width:100%;background:transparent;font-family:inherit;"
          onfocus="openLocDropdown('bul')"
          oninput="filterLoc('bul')"
          onkeydown="handleLocKey(event,'bul')"/>
      </div>
      {{-- Dropdown --}}
      <div id="loc-dd-bul" style="
        display:none; position:absolute; top:calc(100% + 6px); left:0; right:0;
        background:white; border-radius:12px; z-index:500;
        box-shadow:0 8px 32px rgba(0,0,0,.18);
        overflow:hidden; min-width:320px;
      "></div>
    </div>

    {{-- Find Button --}}
    <button style="
      background:#2563eb;color:white;
      border:none;border-radius:14px;
      font-size:15px;font-weight:700;
      padding:0 32px;cursor:pointer;white-space:nowrap;
      display:flex;align-items:center;gap:9px;
      box-shadow:0 8px 40px rgba(0,0,0,.25);
      font-family:inherit;
      transition:background .2s;
    "
  onmouseover="this.style.background='#3a7ae8'"
    onmouseout="this.style.background='#4f8ef7'">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
      </svg>
      Cari Parkir
    </button>
  </div>

</div>
@endsection

@push('scripts')
<style>
  /* Clip bar reservasi tapi biarkan dropdown keluar */
  #bar-reservasi { clip-path: none !important; }
  #bar-reservasi > div:first-child { border-radius: 16px 0 0 16px; }
  #bar-reservasi > div:last-child  { border-radius: 0 16px 16px 0; }
</style>
<script>
// ── Account Dropdown ──────────────────────────────────────
function toggleAccountMenu() {
  const dd     = document.getElementById('accountDropdown');
  const btn    = document.getElementById('accountBtn');
  const icon   = document.getElementById('chevronIcon');
  const isOpen = dd.classList.contains('open');

  if (isOpen) {
    dd.classList.remove('open');
    icon.style.transform = 'rotate(0deg)';
    btn.style.background = 'rgba(255,255,255,.12)';
  } else {
    dd.classList.add('open');
    icon.style.transform = 'rotate(180deg)';
    btn.style.background = 'rgba(255,255,255,.2)';
  }
}

// Close on outside click
document.addEventListener('click', function(e) {
  const menu = document.getElementById('accountMenu');
  if (menu && !menu.contains(e.target)) {
    const dd   = document.getElementById('accountDropdown');
    const icon = document.getElementById('chevronIcon');
    const btn  = document.getElementById('accountBtn');
    if (dd) dd.classList.remove('open');
    if (icon) icon.style.transform = 'rotate(0deg)';
    if (btn)  btn.style.background = 'rgba(255,255,255,.12)';
  }
});

// ── Location Autocomplete ─────────────────────────────────
const PARKIR_DATA = [
  // Surabaya — Pusat
  { name: 'Tunjungan Plaza 1-6', area: 'Surabaya Pusat', icon: '🏬' },
  { name: 'Pakuwon City Mall', area: 'Surabaya Timur', icon: '🏬' },
  { name: 'Galaxy Mall', area: 'Surabaya Timur', icon: '🏬' },
  { name: 'Lenmarc Mall', area: 'Surabaya Barat', icon: '🏬' },
  { name: 'Grand City Mall', area: 'Surabaya Pusat', icon: '🏬' },
  { name: 'Ciputra World Surabaya', area: 'Surabaya Selatan', icon: '🏬' },
  { name: 'Royal Plaza', area: 'Surabaya Selatan', icon: '🏬' },
  { name: 'Bubutan Park', area: 'Surabaya Pusat', icon: '🏢' },
  { name: 'Pakuwon Mall', area: 'Surabaya Barat', icon: '🏬' },
  { name: 'Surabaya Town Square (SUTOS)', area: 'Surabaya Selatan', icon: '🏬' },
  { name: 'BG Junction', area: 'Surabaya Pusat', icon: '🏬' },
  { name: 'Eastcoast Center', area: 'Surabaya Timur', icon: '🏢' },
  { name: 'Supermal Pakuwon Indah', area: 'Surabaya Barat', icon: '🏬' },
  { name: 'Plaza Surabaya (Delta)', area: 'Surabaya Pusat', icon: '🏬' },
  { name: 'Jembatan Merah Plaza', area: 'Surabaya Utara', icon: '🏬' },
  { name: 'WTC Surabaya', area: 'Surabaya Pusat', icon: '🏢' },
  { name: 'Pakuwon Trade Center', area: 'Surabaya Barat', icon: '🏢' },
  { name: 'Tunjungan Center', area: 'Surabaya Pusat', icon: '🏢' },
  { name: 'Bandara Juanda', area: 'Surabaya / Sidoarjo', icon: '✈️' },
  { name: 'Stasiun Surabaya Gubeng', area: 'Surabaya Pusat', icon: '🚉' },
  { name: 'Stasiun Pasar Turi', area: 'Surabaya Pusat', icon: '🚉' },
  { name: 'Rumah Sakit Dr. Soetomo', area: 'Surabaya Pusat', icon: '🏥' },
  { name: 'RSUD Dr. Sutomo Parkir Timur', area: 'Surabaya Pusat', icon: '🏥' },
  { name: 'Hotel JW Marriott Surabaya', area: 'Surabaya Pusat', icon: '🏨' },
  { name: 'Hotel Sheraton Surabaya', area: 'Surabaya Pusat', icon: '🏨' },
  // Sidoarjo
  { name: 'Lippo Plaza Sidoarjo', area: 'Sidoarjo Kota', icon: '🏬' },
  { name: 'Giant Sidoarjo', area: 'Sidoarjo Kota', icon: '🛒' },
  { name: 'Sun City Mall Sidoarjo', area: 'Sidoarjo Kota', icon: '🏬' },
  { name: 'Transmart Carrefour Sidoarjo', area: 'Sidoarjo Kota', icon: '🛒' },
  { name: 'Alun-Alun Sidoarjo', area: 'Sidoarjo Kota', icon: '🌳' },
  { name: 'RSUD Sidoarjo', area: 'Sidoarjo Kota', icon: '🏥' },
  { name: 'Stasiun Sidoarjo', area: 'Sidoarjo Kota', icon: '🚉' },
  { name: 'Sidoarjo Town Square', area: 'Sidoarjo Kota', icon: '🏬' },
  { name: 'Pasar Larangan Sidoarjo', area: 'Sidoarjo', icon: '🛒' },
  { name: 'Waru Business Center', area: 'Sidoarjo (Waru)', icon: '🏢' },
];

let locHighlight = { res: -1, bul: -1 };
let locFiltered  = { res: [], bul: [] };

function openLocDropdown(mode) {
  filterLoc(mode);
}

function filterLoc(mode) {
  const inp  = document.getElementById('loc-input-' + mode);
  const dd   = document.getElementById('loc-dd-' + mode);
  const q    = inp.value.trim().toLowerCase();

  let results;
  if (q === '') {
    // Show "allow location" default item
    renderLocDefault(dd, mode);
    return;
  }

  results = PARKIR_DATA.filter(p =>
    p.name.toLowerCase().includes(q) ||
    p.area.toLowerCase().includes(q)
  ).slice(0, 7);

  locFiltered[mode] = results;
  locHighlight[mode] = -1;

  if (results.length === 0) {
    dd.innerHTML = `<div style="padding:14px 18px;font-size:13px;color:#9ca3af;">Tidak ada hasil untuk "<b>${inp.value}</b>"</div>`;
  } else {
    dd.innerHTML = results.map((p, i) => `
      <div class="loc-opt" data-idx="${i}" data-mode="${mode}"
        style="display:flex;align-items:center;gap:13px;padding:12px 18px;cursor:pointer;transition:background .1s;"
        onmouseenter="hoverLocOpt(this,'${mode}',${i})"
        onmouseleave="unhoverLocOpt(this)"
        onmousedown="selectLocOpt('${mode}',${i})">
        <div style="width:36px;height:36px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;">${p.icon}</div>
        <div>
          <div style="font-size:14px;font-weight:600;color:#111827;">${highlightText(p.name, q)}</div>
          <div style="font-size:12px;color:#9ca3af;margin-top:1px;">${p.area}</div>
        </div>
      </div>
    `).join('');
  }

  dd.style.display = 'block';
}

function renderLocDefault(dd, mode) {
  dd.innerHTML = `
    <div style="display:flex;align-items:center;gap:13px;padding:14px 18px;cursor:pointer;background:#f9fafb;transition:background .1s;"
      onmouseenter="this.style.background='#f3f4f6'"
      onmouseleave="this.style.background='#f9fafb'"
      onmousedown="useMyLocation('${mode}')">
      <div style="width:36px;height:36px;border-radius:50%;background:#111827;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/></svg>
      </div>
      <div>
        <div style="font-size:14px;font-weight:700;color:#111827;">Izinkan akses lokasi</div>
        <div style="font-size:12px;color:#9ca3af;margin-top:1px;">Temukan tempat parkir terdekat dari lokasi Anda</div>
      </div>
    </div>
  `;
  dd.style.display = 'block';
}

function highlightText(text, q) {
  if (!q) return text;
  const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi');
  return text.replace(re, '<mark style="background:#fef9c3;border-radius:2px;padding:0 1px;">$1</mark>');
}

function hoverLocOpt(el, mode, idx) {
  document.querySelectorAll('.loc-opt').forEach(o => o.style.background = '');
  el.style.background = '#f3f4f6';
  locHighlight[mode] = idx;
}
function unhoverLocOpt(el) { el.style.background = ''; }

function handleLocKey(e, mode) {
  const dd      = document.getElementById('loc-dd-' + mode);
  const opts    = dd.querySelectorAll('.loc-opt');
  const results = locFiltered[mode];

  if (e.key === 'ArrowDown') {
    e.preventDefault();
    locHighlight[mode] = Math.min(locHighlight[mode] + 1, opts.length - 1);
    opts.forEach((o, i) => o.style.background = i === locHighlight[mode] ? '#f3f4f6' : '');
  } else if (e.key === 'ArrowUp') {
    e.preventDefault();
    locHighlight[mode] = Math.max(locHighlight[mode] - 1, 0);
    opts.forEach((o, i) => o.style.background = i === locHighlight[mode] ? '#f3f4f6' : '');
  } else if (e.key === 'Enter') {
    e.preventDefault();
    if (locHighlight[mode] >= 0 && results[locHighlight[mode]]) {
      selectLocOpt(mode, locHighlight[mode]);
    } else if (document.getElementById('loc-input-' + mode).value.trim()) {
      closeLocDropdown(mode);
      goToNextStep(mode);
    }
  } else if (e.key === 'Escape') {
    closeLocDropdown(mode);
  }
}

function selectLocOpt(mode, idx) {
  const p = locFiltered[mode][idx];
  document.getElementById('loc-input-' + mode).value = p.name;
  closeLocDropdown(mode);
  goToNextStep(mode);
}

function useMyLocation(mode) {
  document.getElementById('loc-input-' + mode).value = 'Lokasi Saya';
  closeLocDropdown(mode);
  goToNextStep(mode);
}

function closeLocDropdown(mode) {
  const dd = document.getElementById('loc-dd-' + mode);
  if (dd) dd.style.display = 'none';
}

function goToNextStep(mode) {
  if (mode === 'res') {
    // Focus Waktu Masuk
    const masuk = document.getElementById('masuk-time');
    if (masuk) { masuk.focus(); try { masuk.showPicker(); } catch(e) {} }
  } else {
    // Bulanan: langsung trigger cari
    document.getElementById('loc-input-bul').closest('div').parentElement
      .querySelector('button').click();
  }
}

// Close dropdown on outside click
document.addEventListener('click', function(e) {
  ['res','bul'].forEach(mode => {
    const inp = document.getElementById('loc-input-' + mode);
    const dd  = document.getElementById('loc-dd-' + mode);
    if (inp && dd && !inp.contains(e.target) && !dd.contains(e.target)) {
      dd.style.display = 'none';
    }
  });
});
function setTab(tab) {
  const tabs    = ['reservasi','bulanan'];
  const barRes  = document.getElementById('bar-reservasi');
  const barBul  = document.getElementById('bar-bulanan');

  tabs.forEach(t => {
    const el = document.getElementById('tab-'+t);
    if (t === tab) {
      el.style.background = 'white';
      el.style.color      = '#111827';
      el.style.border     = 'none';
      el.style.fontWeight = '800';
    } else {
      el.style.background = 'rgba(255,255,255,.18)';
      el.style.color      = 'white';
      el.style.border     = '1px solid rgba(255,255,255,.25)';
      el.style.fontWeight = '600';
    }
  });

  if (tab === 'bulanan') {
    barRes.style.display = 'none';
    barBul.style.display = 'grid';
  } else {
    barRes.style.display = 'grid';
    barBul.style.display = 'none';
  }
}
</script>
@endpush
