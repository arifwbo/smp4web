@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 col-lg-8 mx-auto">
        <div class="card-header bg-primary-custom text-white">
            Edit Portal Aplikasi
        </div>
        <div class="card-body">
            <form action="{{ route('admin.application-links.update', $application) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.application-links.partials.form')
                <div class="d-flex align-items-center" style="gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                    <a href="{{ route('admin.application-links.index') }}" class="btn btn-link">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
