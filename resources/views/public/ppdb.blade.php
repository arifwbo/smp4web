@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="p-5 mb-4 bg-dinas rounded-3 text-center reveal-segment">
        <h1 class="display-5 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #ffffff; text-shadow: 0 2px 12px rgba(0,0,0,0.2);">PPDB Online</h1>
        <p class="fs-5 mb-0" style="color: rgba(255,255,255,0.85);">Informasi Penerimaan Peserta Didik Baru</p>
    </div>

    @if($ppdb)
        <div class="card shadow-sm reveal-segment" data-reveal="up">
            <div class="card-header bg-dinas text-white fw-bold">
                {{ $ppdb->judul }}
            </div>
            <div class="card-body">
                @php
                    $attachmentList = $ppdb->lampiran_collection;
                    $linkList = $ppdb->link_collection;
                @endphp

                <div class="mb-4">
                    {!! nl2br(e($ppdb->konten)) !!}
                </div>

                @if($ppdb->status == 'buka')
                    <div class="alert alert-success text-center reveal-segment">
                        <h4 class="alert-heading">Pendaftaran DIBUKA!</h4>
                        <p>Silakan pilih link di bawah untuk mengakses formulir atau panduan resmi.</p>
                        @if(!empty($linkList))
                            <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                                @foreach($linkList as $link)
                                    <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="btn btn-primary flex-fill">
                                        {{ $link['label'] ?? 'Link ' . $loop->iteration }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted">Link pendaftaran belum tersedia.</span>
                        @endif
                    </div>

                    @if(!empty($attachmentList))
                        <div class="card border-0 shadow-sm mt-4 reveal-segment">
                            <div class="card-body">
                                <h5 class="fw-bold text-dinas mb-3">Lampiran Resmi</h5>
                                <ul class="list-unstyled mb-0">
                                    @foreach($attachmentList as $file)
                                        <li class="d-flex align-items-center gap-3 mb-2">
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M7 10V6a5 5 0 0 1 10 0v4" stroke="#dc3545" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <rect x="5" y="10" width="14" height="11" rx="2" fill="#fdeaea" stroke="#dc3545" stroke-width="1.5" />
                                                <path d="M12 14v4" stroke="#dc3545" stroke-width="1.5" stroke-linecap="round" />
                                                <circle cx="12" cy="13" r="1" fill="#dc3545" />
                                            </svg>
                                            <a href="{{ $file['url'] }}" target="_blank" rel="noopener" class="text-decoration-underline">
                                                {{ $file['label'] ?? 'Lampiran ' . $loop->iteration }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-danger text-center reveal-segment">
                        <div class="mb-3">
                            <svg width="96" height="96" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="5" y="10" width="14" height="10" rx="2" fill="#f8d7da" stroke="#dc3545" stroke-width="1.5" />
                                <path d="M9 10V7a3 3 0 0 1 6 0v3" stroke="#dc3545" stroke-width="1.5" stroke-linecap="round" />
                                <circle cx="12" cy="15" r="1.5" fill="#dc3545" />
                                <path d="M12 16.5V18" stroke="#dc3545" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </div>
                        <h4 class="alert-heading">Pendaftaran DITUTUP</h4>
                        <p>Mohon maaf, periode pendaftaran belum dibuka atau sudah berakhir. Silakan cek kembali nanti.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center reveal-segment">Belum ada informasi PPDB saat ini.</div>
    @endif
</div>
@endsection
