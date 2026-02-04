@extends('layouts.admin')
@section('title', 'Tambah Kepala Sekolah Terdahulu')
@section('page-title', 'Tambah Kepala Sekolah')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.former-principals.index') }}">Kepala Sekolah Terdahulu</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
    <form action="{{ route('admin.former-principals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.former-principals._form')
    </form>
@endsection
