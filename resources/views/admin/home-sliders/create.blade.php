@extends('layouts.admin')

@section('title', 'Tambah Slider')
@section('page-title', 'Tambah Slider Beranda')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home-sliders.index') }}">Slider Beranda</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.home-sliders.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.home-sliders.partials.form')
    </form>
@endsection
