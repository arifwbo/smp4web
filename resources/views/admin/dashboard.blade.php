@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@php
    use App\Models\Post;
    use App\Models\Teacher;
    use App\Models\Facility;
    use App\Models\Message;
    use App\Models\Gallery;

    $statCards = [
        [
            'label'   => 'Total Berita',
            'value'   => Post::count(),
            'icon'    => 'fas fa-newspaper',
            'color'   => '#2563eb',
            'bg'      => '#eff6ff',
            'route'   => 'admin.posts.index',
        ],
        [
            'label'   => 'GTK & Staf',
            'value'   => Teacher::count(),
            'icon'    => 'fas fa-user-graduate',
            'color'   => '#10b981',
            'bg'      => '#ecfdf5',
            'route'   => 'admin.teachers.index',
        ],
        [
            'label'   => 'Fasilitas',
            'value'   => Facility::count(),
            'icon'    => 'fas fa-building',
            'color'   => '#f59e0b',
            'bg'      => '#fffbeb',
            'route'   => 'admin.facilities.index',
        ],
        [
            'label'   => 'Pesan Masuk',
            'value'   => Message::count(),
            'icon'    => 'fas fa-inbox',
            'color'   => '#ef4444',
            'bg'      => '#fef2f2',
            'route'   => 'admin.messages.index',
        ],
    ];

    $recentPosts   = Post::latest()->take(5)->get();
    $recentMessages = Message::latest()->take(5)->get();

    $quickActions = [
        ['label' => 'Tambah Berita',    'icon' => 'fas fa-pen-to-square', 'route' => 'admin.posts.create',           'color' => '#2563eb'],
        ['label' => 'Tambah GTK',       'icon' => 'fas fa-user-plus',     'route' => 'admin.teachers.index',         'color' => '#10b981'],
        ['label' => 'Upload Galeri',    'icon' => 'fas fa-images',         'route' => 'admin.galleries.index',        'color' => '#8b5cf6'],
        ['label' => 'Lihat Pesan',      'icon' => 'fas fa-inbox',          'route' => 'admin.messages.index',         'color' => '#f59e0b'],
        ['label' => 'Kelola Fasilitas', 'icon' => 'fas fa-building',       'route' => 'admin.facilities.index',       'color' => '#06b6d4'],
        ['label' => 'Edit Profil',      'icon' => 'fas fa-school',         'route' => 'admin.profile.edit',           'color' => '#64748b'],
    ];
@endphp

@section('content')
<div style="display:flex; flex-direction:column; gap:1.5rem;">

    {{-- Welcome Banner --}}
    <div style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%); border-radius:16px; padding:2rem 2.5rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; color:#fff; overflow:hidden; position:relative;">
        <div style="position:absolute;right:-40px;top:-40px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,0.06);"></div>
        <div style="position:absolute;right:60px;bottom:-60px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
        <div style="position:relative;z-index:1;">
            <p style="font-size:0.8rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;opacity:0.75;margin-bottom:0.4rem;">
                Panel Administrasi
            </p>
            <h2 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.6rem;font-weight:800;margin-bottom:0.4rem;letter-spacing:-0.02em;">
                Selamat datang, {{ auth()->user()->name ?? 'Administrator' }} 👋
            </h2>
            <p style="opacity:0.75;font-size:0.875rem;margin:0;">
                {{ now()->translatedFormat('l, d F Y') }} &mdash; SMP Negeri 4 Samarinda
            </p>
        </div>
        <a href="{{ route('home') }}" target="_blank" style="position:relative;z-index:1;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:#fff;border-radius:10px;padding:0.6rem 1.25rem;font-size:0.875rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.5rem;backdrop-filter:blur(6px);transition:all 0.2s;">
            <i class="fas fa-globe-asia"></i> Lihat Situs
        </a>
    </div>

    {{-- Stat Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;">
        @foreach($statCards as $stat)
        <a href="{{ route($stat['route']) }}" style="text-decoration:none;">
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:1.5rem;display:flex;align-items:center;gap:1rem;transition:all 0.2s;box-shadow:0 1px 3px rgba(0,0,0,.06);" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.10)'" onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(0,0,0,.06)'">
                <div style="width:52px;height:52px;border-radius:14px;background:{{ $stat['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="{{ $stat['icon'] }}" style="font-size:1.2rem;color:{{ $stat['color'] }};"></i>
                </div>
                <div>
                    <div style="font-size:1.75rem;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;color:#0f172a;line-height:1;">{{ $stat['value'] }}</div>
                    <div style="font-size:0.8rem;color:#64748b;margin-top:0.2rem;font-weight:500;">{{ $stat['label'] }}</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Quick Actions --}}
    <div>
        <h6 style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#94a3b8;margin-bottom:0.85rem;">Aksi Cepat</h6>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(155px,1fr));gap:0.75rem;">
            @foreach($quickActions as $action)
            <a href="{{ route($action['route']) }}" style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;display:flex;flex-direction:column;align-items:center;gap:0.6rem;text-decoration:none;text-align:center;transition:all 0.2s;box-shadow:0 1px 3px rgba(0,0,0,.06);" onmouseover="this.style.borderColor='{{ $action['color'] }}';this.style.background='{{ $action['color'] }}14';this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='#fff';this.style.transform=''">
                <div style="width:42px;height:42px;border-radius:12px;background:{{ $action['color'] }}15;display:flex;align-items:center;justify-content:center;">
                    <i class="{{ $action['icon'] }}" style="font-size:1rem;color:{{ $action['color'] }};"></i>
                </div>
                <span style="font-size:0.8rem;font-weight:600;color:#0f172a;">{{ $action['label'] }}</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Tables Row --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

        {{-- Recent Posts --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
                <div style="font-weight:700;font-size:0.9rem;color:#0f172a;">Berita Terbaru</div>
                <a href="{{ route('admin.posts.index') }}" style="font-size:0.78rem;color:#2563eb;text-decoration:none;font-weight:500;">Lihat semua →</a>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="padding:0.65rem 1rem;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:#64748b;text-align:left;border-bottom:1px solid #e2e8f0;">Judul</th>
                            <th style="padding:0.65rem 1rem;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:#64748b;text-align:left;border-bottom:1px solid #e2e8f0;white-space:nowrap;">Kategori</th>
                            <th style="padding:0.65rem 1rem;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:#64748b;text-align:left;border-bottom:1px solid #e2e8f0;white-space:nowrap;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPosts as $post)
                        <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                            <td style="padding:0.75rem 1rem;font-size:0.82rem;color:#0f172a;font-weight:500;">
                                {{ \Illuminate\Support\Str::limit($post->judul, 38) }}
                            </td>
                            <td style="padding:0.75rem 1rem;">
                                <span style="font-size:0.72rem;font-weight:600;padding:0.2em 0.6em;border-radius:6px;background:#eff6ff;color:#2563eb;">
                                    {{ ucfirst($post->kategori) }}
                                </span>
                            </td>
                            <td style="padding:0.75rem 1rem;font-size:0.78rem;color:#94a3b8;white-space:nowrap;">
                                {{ $post->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="padding:2rem;text-align:center;color:#94a3b8;font-size:0.85rem;">Belum ada berita</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Messages --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
                <div style="font-weight:700;font-size:0.9rem;color:#0f172a;">Pesan Masuk</div>
                <a href="{{ route('admin.messages.index') }}" style="font-size:0.78rem;color:#2563eb;text-decoration:none;font-weight:500;">Lihat semua →</a>
            </div>
            <div>
                @forelse($recentMessages as $msg)
                <div style="padding:0.85rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:flex-start;gap:0.75rem;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <div style="width:36px;height:36px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.9rem;font-weight:700;color:#64748b;">
                        {{ strtoupper(substr($msg->nama ?? 'A', 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.82rem;font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $msg->nama ?? '-' }}</div>
                        <div style="font-size:0.78rem;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ \Illuminate\Support\Str::limit($msg->pesan ?? '', 50) }}</div>
                    </div>
                    <div style="font-size:0.72rem;color:#cbd5e1;white-space:nowrap;">{{ $msg->created_at->format('d M') }}</div>
                </div>
                @empty
                <div style="padding:2rem;text-align:center;color:#94a3b8;font-size:0.85rem;">Belum ada pesan</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
