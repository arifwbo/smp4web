@extends('layouts.admin')
@section('title', 'Edit Kepala Sekolah Terdahulu')
@section('page-title', 'Edit Kepala Sekolah')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.former-principals.index') }}">Kepala Sekolah Terdahulu</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <form action="{{ route('admin.former-principals.update', $principal) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.former-principals._form', ['principal' => $principal])
    </form>
@endsection
