@extends('layouts.admin')

@section('content')
<div class="dashboard-wrapper py-4">
    <div class="dashboard-hero card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">Panel Admin</p>
                <h1 class="h4 fw-bold mb-2">Selamat datang, {{ auth()->user()->name ?? 'Administrator' }}</h1>
                <p class="mb-0 text-muted">Pantau statistik sekolah dan aktivitas terbaru dalam satu tempat.</p>
            </div>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-clipboard-list mr-2"></i>Lihat Audit Log
            </a>
        </div>
    </div>

    @php
        $cards = [
            ['label' => 'Total Berita', 'value' => $stats['posts'], 'icon' => 'fa-newspaper', 'accent' => 'primary'],
            ['label' => 'Guru & Tendik', 'value' => $stats['teachers'], 'icon' => 'fa-person-chalkboard', 'accent' => 'success'],
            ['label' => 'Fasilitas', 'value' => $stats['facilities'], 'icon' => 'fa-building', 'accent' => 'info'],
            ['label' => 'Pesan Masuk', 'value' => $stats['messages'], 'icon' => 'fa-inbox', 'accent' => 'warning'],
        ];
    @endphp

    <div class="row g-3 g-lg-4">
        @foreach($cards as $card)
        <div class="col-sm-6 col-xl-3">
            <div class="dashboard-stat-card card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon text-{{ $card['accent'] }}">
                        <i class="fa-solid {{ $card['icon'] }}"></i>
                    </div>
                    <div>
                        <p class="text-muted text-uppercase mb-1 small">{{ $card['label'] }}</p>
                        <h3 class="fw-bold mb-0">{{ number_format($card['value']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-7">
            <div class="card dashboard-panel shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Aktivitas 7 Hari Terakhir</h5>
                        <span class="badge bg-light text-dark">Activity Log</span>
                    </div>
                    <canvas id="activityChart" height="220"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card dashboard-panel shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Aktivitas Terbaru</h5>
                        <span class="text-muted small">{{ $recentLogs->count() }} entri</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <tbody>
                                @forelse($recentLogs as $log)
                                <tr>
                                    <td class="align-middle">
                                        <strong>{{ $log->user->name ?? 'Sistem' }}</strong>
                                        <div class="small text-muted">{{ $log->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-secondary">{{ $log->action }}</span>
                                        <div class="small text-muted">{{ \Illuminate\Support\Str::limit($log->description, 50) }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Belum ada aktivitas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    .dashboard-hero {
        background: linear-gradient(135deg, rgba(1, 42, 99, 0.93), rgba(15, 118, 184, 0.85));
        color: #fff;
        border-radius: 1.25rem;
    }

    .dashboard-hero .text-muted {
        color: rgba(255, 255, 255, 0.75) !important;
    }

    .dashboard-stat-card {
        border-radius: 1.1rem;
    }

    .dashboard-stat-card .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: rgba(0, 0, 0, 0.03);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .dashboard-panel {
        border-radius: 1.1rem;
    }

    .dashboard-panel table tbody tr td {
        border-top: none;
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const activityCtx = document.getElementById('activityChart');
    if (activityCtx) {
        const activityData = @json($activitySeries);
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: activityData.labels,
                datasets: [{
                    label: 'Aktivitas',
                    data: activityData.data,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.15)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#0d6efd'
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    }
</script>
@endpush
