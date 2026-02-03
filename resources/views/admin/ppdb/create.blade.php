@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 col-md-8 mx-auto">
        <div class="card-header bg-primary-custom text-white">Tambah Informasi PPDB</div>
        <div class="card-body">
            <form action="{{ route('admin.ppdb.store') }}" method="POST">
                @csrf
                @include('admin.ppdb.partials.form')
                <button type="submit" class="btn btn-primary-custom">Simpan</button>
                <a href="{{ route('admin.ppdb.index') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
