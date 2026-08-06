@extends('layouts.app')

@section('content')
<div class="login-wrapper py-5 d-flex align-items-center" style="min-height: calc(100vh - var(--topbar-h) - var(--nav-h)); background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">
                    
                    <!-- Decorative Top Border -->
                    <div style="height: 6px; background: linear-gradient(90deg, #0a1628, var(--accent), var(--gold));"></div>

                    <div class="card-body p-4 p-sm-5 bg-white">
                        <div class="text-center mb-4">
                            @php
                                $publicProfile = cache()->remember('layout_public_profile', 300, function () {
                                    return \App\Models\SchoolProfile::select('logo_path')->first();
                                });
                                $logoPath = optional($publicProfile)->logo_path;
                                $schoolLogoUrl = $logoPath ? asset('storage/' . $logoPath) : asset('img/logo-smp4.jpg');
                            @endphp
                            <a href="{{ route('home') }}">
                                <img src="{{ $schoolLogoUrl }}" alt="Logo SMPN 4" height="85" class="mb-3" onerror="this.style.display='none'" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                            </a>
                            <h4 class="fw-bold display-font mb-1" style="color: #0a1628;">Login Portal</h4>
                            <p class="text-muted small">Silakan masuk untuk mengakses dasbor sistem.</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-floating mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email" autofocus style="border-radius: 0.75rem; background: #f8fafc; border: 1px solid #e2e8f0;">
                                <label for="email" class="text-muted"><i class="fas fa-envelope me-2 text-primary opacity-75"></i>Alamat Email</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password" style="border-radius: 0.75rem; background: #f8fafc; border: 1px solid #e2e8f0;">
                                <label for="password" class="text-muted"><i class="fas fa-lock me-2 text-primary opacity-75"></i>Password</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input shadow-sm" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="cursor: pointer;">
                                    <label class="form-check-label text-muted small" for="remember" style="cursor: pointer; user-select: none;">
                                        Ingat Saya
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small fw-semibold" href="{{ route('password.request') }}" style="color: var(--accent); transition: color 0.2s;">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="btn w-100 py-3 fw-bold text-white shadow-sm" style="background: #0a1628; border-radius: 0.75rem; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(10,22,40,0.3)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                                <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Sistem
                            </button>
                            
                            <div class="text-center mt-4">
                                <a href="{{ route('home') }}" class="text-decoration-none text-muted small" style="transition: color 0.2s;" onmouseover="this.style.color='#0a1628'" onmouseout="this.style.color='#6c757d'">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4 text-muted small" style="opacity: 0.7;">
                    &copy; {{ date('Y') }} SMP Negeri 4 Samarinda
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
