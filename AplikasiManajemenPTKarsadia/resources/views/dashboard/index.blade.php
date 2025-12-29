@extends('layouts.app')

@section('content')
<div class="container py-3">

    <h3 class="fw-bold mb-1">Beranda</h3>
    <p class="text-muted mb-4">Ringkasan aktivitas dan laporan greenhouse</p>

    <!-- STATUS GREENHOUSE -->
    <div class="card mb-4 p-3">
        <h5>Status Rumah Kaca</h5>
        <div class="row text-center">
            <div class="col">
                <div class="text-muted">Aktif</div>
                <strong>{{ $aktif }}</strong>
            </div>
            <div class="col">
                <div class="text-muted">Perbaikan</div>
                <strong>{{ $perbaikan }}</strong>
            </div>
            <div class="col">
                <div class="text-muted">Tidak Aktif</div>
                <strong>{{ $tidak_aktif }}</strong>
            </div>
        </div>
    </div>

    <!-- DATA PERFORMA -->
    <div class="row mb-4">


        <div class="col-md-4 mb-3">
            <div class="card p-3 h-100">
                <div class="text-muted">Total Pendapatan</div>
                <strong class="text-success">
                    Rp {{ number_format($pendapatan, 0, ',', '.') }}
                </strong>
            </div>
        </div>


        <div class="col-md-4 mb-3">
            <div class="card p-3 h-100">
                <div class="text-muted">Total Panen</div>
                <strong>{{ $totalPanen }} Buah</strong>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card p-3 h-100">
                <div class="text-muted">Panen Terakhir</div>
                <strong>{{ $panenTerakhir }}</strong>
            </div>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="row">

        <!-- KIRI -->
        <div class="col-md-6 mb-4">

            <!-- KUALITAS PANEN -->
            <div class="card mb-3 p-3">
                <h5>Kualitas Panen</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        Kualitas A <strong>{{ $kualitasA }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        Kualitas B <strong>{{ $kualitasB }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        Kualitas C <strong>{{ $kualitasC }}</strong>
                    </li>
                </ul>
            </div>

            <!-- LAPORAN -->
            <div class="card p-3">
                <h5>Laporan Harian</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        Perawatan <strong>{{ $laporanPerawatan }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        Penanaman <strong>{{ $laporanPenanaman }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        Pembersihan <strong>{{ $laporanPembersihan }}</strong>
                    </li>
                </ul>
            </div>

        </div>

        <!-- KANAN -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 h-100">
                <h5>Riwayat Aktivitas</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat as $log)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</td>
                                <td>{{ $log->user->username ?? $log->user_id }}</td>
                                <td>{{ $log->tipe_aksi }}</td>
                                <td>{{ $log->menu_terkait }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Tidak ada riwayat aktivitas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
