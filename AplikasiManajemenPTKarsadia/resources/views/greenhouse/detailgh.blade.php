@extends('layouts.app')

@section('content')
    {{-- Judul halaman --}}
    <h1 class="gh-title">Rumah Kaca {{ $greenhouse->nama_greenhouse }}</h1>

    <div class="gh-banner">
        <img src="{{ asset('images/greenhouse-banner.jpg') }}" alt="Greenhouse Banner" class="gh-banner-image">
    </div>

    <div class="gh-detail-container">
        {{-- Session success --}}
        @if(session('success'))
            <div class="gh-alert-success">{{ session('success') }}</div>
        @endif

        <div class="gh-main-grid">
            {{-- Kiri: Monitoring & Spesifikasi --}}
            <div class="gh-left">
                {{-- Monitoring --}}
                <div class="gh-section">
                    <div class="gh-section-header">
                        <h2>Monitoring</h2>
                        <a href="{{ route('monitoring_edit', $greenhouse->id_greenhouse) }}" class="gh-btn-ubah">Ubah</a>
                    </div>
                    <ul class="gh-list">
                        <li><strong>Waktu Monitoring:</strong> {{ optional($greenhouse->waktu_monitoring)->format('d/m/Y H:i') ?? '-' }}</li>
                        <li><strong>Suhu:</strong> {{ $greenhouse->suhu_greenhouse }}°C</li>
                        <li><strong>Kelembapan:</strong> {{ $greenhouse->kelembaban_greenhouse }}%</li>
                        <li><strong>Intensitas Cahaya:</strong> {{ $greenhouse->intensitas_cahaya_greenhouse }} lux</li>
                        <li><strong>Volume Air:</strong> {{ $greenhouse->volume_air_greenhouse }} L</li>
                    </ul>
                </div>

                {{-- Spesifikasi --}}
                <div class="gh-section">
                    <div class="gh-section-header">
                        <h2>Spesifikasi</h2>
                        <a href="{{ route('spesifikasi_edit', $greenhouse->id_greenhouse) }}" class="gh-btn-ubah">Ubah</a>
                    </div>
                    <ul class="gh-list">
                        <li><strong>Luas:</strong> {{ $greenhouse->luas_greenhouse }} m²</li>
                        <li><strong>Tinggi:</strong> {{ $greenhouse->tinggi_greenhouse }} m</li>
                        <li><strong>Sistem yang Dipakai:</strong> {{ $greenhouse->sistem_dipakai_greenhouse }}</li>
                        <li><strong>Alamat:</strong> {{ $greenhouse->alamat_greenhouse }}</li>
                    </ul>
                </div>
            </div>

            {{-- Kanan: Riwayat QC --}}
            <div class="gh-right">
                {{-- Header QC --}}
                <div class="gh-section">
                    <div class="gh-section-header">
                        <h2 class="gh-qc-title">Riwayat Kontrol Kualitas</h2>
                        <a href="{{ route('tambah_qc', $greenhouse->id_greenhouse) }}" class="gh-btn-tambah">+ Tambah</a>
                    </div>
                </div>

                {{-- List QC Cards --}}
                @foreach($greenhouse->LogQC as $qc)
                    <div class="gh-qc-card">
                        <div class="gh-qc-header">
                            <div class="gh-qc-meta">
                                <strong>{{ \Carbon\Carbon::parse($qc->tanggal_qc)->format('d/m/Y H:i') }}</strong>
                            </div>
                            <div class="gh-qc-actions">
                                <a href="{{ route('edit_qc', $qc->id_log_qc) }}" class="gh-btn-edit">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <form action="{{ route('destroy_qc', $qc->id_log_qc) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="gh-btn-hapus">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="gh-qc-body">
                            <div class="gh-qc-gallery">
                                @foreach(array_slice($qc->gambar_qc, 0, 4) as $img)
                                    <img src="{{ asset($img) }}" class="gh-qc-thumb" alt="Foto QC">
                                @endforeach
                            </div>

                            <ul class="gh-list">
                                <li><strong>Tanggal QC:</strong> {{ \Carbon\Carbon::parse($qc->tanggal_qc)->translatedFormat('d F Y') }}</li>
                                <li><strong>Petugas:</strong> {{ $qc->nama_petugas }}</li>
                                <li><strong>Varietas:</strong> {{ $qc->varietas_melon }}</li>
                                <li><strong>Status:</strong> {{ $qc->status_tumbuh }}</li>
                                <li><strong>Total Tanaman:</strong> {{ $qc->total_tanaman }}</li>
                                <li><strong>Jumlah Tanaman Tumbuh:</strong> {{ $qc->jumlah_tanaman_tumbuh }}</li>
                                <li><strong>Jumlah Tanaman Sehat:</strong> {{ $qc->jumlah_tanaman_sehat }}</li>
                                <li><strong>Jumlah Tanaman Sakit:</strong> {{ $qc->jumlah_tanaman_sakit }}</li>
                                <li><strong>Jumlah Tanaman Mati:</strong> {{ $qc->jumlah_tanaman_mati }}</li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
