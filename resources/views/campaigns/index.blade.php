<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Campaign - MR. BUAS</title>
    <!-- CSS Utama & Campaign CSS Asli Kamu -->
    <link rel="stylesheet" href="{{ asset('assests/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assests/css/campaign_css.css') }}">
</head>
<body style="background-color: #f7f9fc;">
<!-- ================= NAVBAR ================= -->
<nav class="navbar">
    <div class="container nav-wrapper">
        <a href="/" class="home-brand-logo teks-gradasi-biru">MR.<span>⚡</span><br>BUAS</a>
        <ul class="cmp-nav-menu">
            <li><a href="/" class="cmp-nav-link">Beranda</a></li>
            <li><a href="/campaigns" class="cmp-nav-link active">Campaign</a></li>
            <li><a href="/donors" class="cmp-nav-link">Donatur</a></li>
            <li><a href="/partners" class="cmp-nav-link">Mitra Penyalur</a></li>
            <li><a href="/about" class="cmp-nav-link">Tentang Kami</a></li>
        </ul>
    </div>
</nav>
<!-- ================= HEADER ================= -->
<header class="cmp-header-bg">
    <div class="container">
        <h1 class="cmp-header-title">Program Penggalangan Dana</h1>
        <p class="cmp-header-subtitle">Pilih program kebaikan dan salurkan bantuanmu secara transparan.</p>
        <!-- Form Filter & Pencarian -->
        <form action="/campaigns" method="GET" class="cmp-filter-section" style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
            <input type="text" name="q" class="cmp-search-box" placeholder="Cari program campaign..." value="{{ $keyword ?? '' }}">
            
            <select name="category" class="cmp-category-select" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ ($kategori ?? '') === $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-weight: 700;">Cari</button>
            @if (!empty($kategori) || !empty($keyword))
                <a href="/campaigns" class="btn btn-outline" style="padding: 10px 16px; background: #fff; text-decoration: none; border-radius: 8px;">Reset</a>
            @endif
        </form>
    </div>
</header>
<!-- ================= KONTEN UTAMA ================= -->
<main class="container" style="padding: 30px 0 60px 0;">
    
    <!-- Filter Tab Chips Kategori -->
    <div class="cmp-category-tabs">
        <a href="/campaigns{{ !empty($keyword) ? '?q='.urlencode($keyword) : '' }}" class="cmp-tab-chip {{ empty($kategori) ? 'active' : '' }}">
            Semua
        </a>
        @foreach ($categories as $cat)
            <a href="/campaigns?category={{ urlencode($cat) }}{{ !empty($keyword) ? '&q='.urlencode($keyword) : '' }}" class="cmp-tab-chip {{ ($kategori ?? '') === $cat ? 'active' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>
    <!-- Grid Katalog Campaign -->
    <div class="cmp-grid-3">
        @if (isset($campaigns) && $campaigns->count() > 0)
            @foreach ($campaigns as $row)
                @php
                    $current = (int)($row->current_amount ?? 0);
                    $target = ($row->target_amount ?? 0) > 0 ? (int)$row->target_amount : 1;
                    $persen = round(($current / $target) * 100);
                    if ($persen > 100) $persen = 100;
                    $gambar = !empty($row->image) ? $row->image : 'hero-home.jpg';
                @endphp
                <div class="cmp-card">
                    <div class="cmp-card-img-wrap">
                        <img src="{{ asset('assests/images/' . $gambar) }}" alt="{{ $row->title ?? 'Campaign' }}" class="cmp-card-img" style="width: 100%; height: 200px; object-fit: cover;">
                    </div>
                    <div class="cmp-card-body" style="padding: 20px;">
                        <span class="cmp-card-category" style="font-size: 0.8rem; font-weight: 700; color: #0284c7; text-transform: uppercase;">
                            {{ $row->category ?? 'Umum' }}
                        </span>
                        
                        <h3 class="cmp-card-title" style="margin: 10px 0; font-size: 1.15rem; color: #071a40;">
                            {{ $row->title ?? 'Tanpa Judul' }}
                        </h3>
                        <div class="cmp-progress-bar" style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden; margin: 12px 0 8px 0;">
                            <div class="cmp-progress-fill" style="width: {{ $persen }}%; height: 100%; background: #ffc107;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #64748b; margin-bottom: 16px;">
                            <span>Terkumpul: <strong>Rp {{ number_format($current, 0, ',', '.') }}</strong></span>
                            <span>{{ $persen }}%</span>
                        </div>
                        <a href="/campaigns/{{ $row->id ?? '' }}" class="btn btn-primary" style="display: block; text-align: center; text-decoration: none; padding: 10px; border-radius: 8px; font-weight: 700;">
                            Donasi Sekarang
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <h3 style="color: #64748b;">Belum ada program campaign pada kategori ini</h3>
                <p style="color: #94a3b8; margin-top: 8px;">Coba pilih kategori lain atau bersihkan kata kunci pencarian.</p>
                <a href="/campaigns" class="btn btn-primary" style="margin-top: 16px; display: inline-block;">Lihat Semua Campaign</a>
            </div>
        @endif
    </div>
</main>
</body>
</html>