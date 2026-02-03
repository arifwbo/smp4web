@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 col-md-8 mx-auto">
        <div class="card-header bg-primary-custom text-white">Edit Informasi PPDB</div>
        <div class="card-body">
            <form action="{{ route('admin.ppdb.update', $ppdb) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.ppdb.partials.form')
                <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                <a href="{{ route('admin.ppdb.index') }}" class="btn btn-link">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
