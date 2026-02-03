@extends('layouts.admin')

@section('title', 'Edit Slider')
@section('page-title', 'Edit Slider Beranda')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home-sliders.index') }}">Slider Beranda</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.home-sliders.update', $slider) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.home-sliders.partials.form', ['slider' => $slider])
    </form>
@endsection
