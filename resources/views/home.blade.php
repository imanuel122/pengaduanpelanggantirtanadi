@extends('layouts.app')

@section('title', 'PDAM Tirtanadi Padang Bulan — Sistem Pengaduan Pelanggan')
@section('meta_description', 'Laporkan gangguan air, kebocoran pipa, atau kendala meteran PDAM Tirtanadi Cabang Padang Bulan tanpa perlu akun.')

@section('content')

    @include('home.hero')
    @include('home.fitur-utama')
    @include('home.tentang-layanan')
    @include('home.cara-mengadu')
    @include('home.cta-banner')

@endsection