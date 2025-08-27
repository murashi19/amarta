@extends('layouts.app')

@section('content')

<section id="lowongan-detail">
  <div class="container">
    <div class="section-title">
      <h2>Pekerjaan yang Kami Sediakan</h2>
      <div class="underline"></div>
    </div>

    <p class="lowongan-subtext">
      Berikut adalah beberapa bidang pekerjaan dari SO (Sending Organization) kami yang tersedia untuk program magang ke Jepang melalui LPK Amarta.
    </p>

    <div class="poster-grid">
      <!-- Poster 1 -->
      <div class="poster-item">
        <img src="{{ asset('Asset/img/poster-manufaktur.jpg') }}" alt="Manufaktur">
        <h4>Manufaktur</h4>
      </div>

      <!-- Poster 2 -->
      <div class="poster-item">
        <img src="{{ asset('Asset/img/poster-pertanian.jpg') }}" alt="Pertanian & Perikanan">
        <h4>Pertanian & Perikanan</h4>
      </div>

      <!-- Poster 3 -->
      <div class="poster-item">
        <img src="{{ asset('Asset/img/poster-makanan.jpg') }}" alt="Pengelolaan Makanan & Minuman">
        <h4>Pengolahan Makanan & Minuman</h4>
      </div>

      <!-- Poster 4 -->
      <div class="poster-item">
        <img src="{{ asset('Asset/img/poster-konstruksi.jpg') }}" alt="Konstruksi">
        <h4>Konstruksi</h4>
      </div>

      <!-- Poster 5 -->
      <div class="poster-item">
        <img src="{{ asset('Asset/img/poster-peternakan.jpg') }}" alt="Peternakan">
        <h4>Peternakan</h4>
      </div>
    </div>
  </div>
</section>

@endsection