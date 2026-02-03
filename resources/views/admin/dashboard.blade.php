@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Dashboard Admin</h1>
            <p class="text-muted mb-0">Halo, {{ auth()->user()->name ?? 'Administrator' }}.</p>
        </div>
        <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary mt-3 mt-lg-0">Lihat Audit Log</a>
    </div>

    @php
        $cards = [
            ['label' => 'Total Berita', 'value' => $stats['posts'], 'icon' => 'fa-newspaper', 'accent' => 'primary'],
            ['label' => 'Guru & Tendik', 'value' => $stats['teachers'], 'icon' => 'fa-person-chalkboard', 'accent' => 'success'],
            ['label' => 'Fasilitas', 'value' => $stats['facilities'], 'icon' => 'fa-building', 'accent' => 'info'],
            ['label' => 'Pesan Masuk', 'value' => $stats['messages'], 'icon' => 'fa-inbox', 'accent' => 'warning'],
        ];
    @endphp

    <div class="row g-4">
        @foreach($cards as $card)
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-{{ $card['accent'] }}">
                        <i class="fa-solid {{ $card['icon'] }} fa-2x"></i>
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
            <div class="card shadow-sm border-0 h-100">
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
            <div class="card shadow-sm border-0 h-100">
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
