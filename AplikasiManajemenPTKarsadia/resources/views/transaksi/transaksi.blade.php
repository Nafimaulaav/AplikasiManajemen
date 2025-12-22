<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h3 class="mb-4">Laporan Pendapatan</h3>

    {{-- CARD --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Pendapatan Bulan Ini</h6>
                    <h4 class="fw-bold">
                        Rp {{ number_format($totalPendapatanBulanIni ?? 0, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Jumlah Transaksi</h6>
                    <h4 class="fw-bold">
                        {{ $jumlahPendapatan ?? 0 }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Pendapatan Terbaru</h6>
                    <h4 class="fw-bold">
                        Rp {{ number_format($pendapatanTerbaru ?? 0, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Rekap Transaksi Harian</h5>

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Tanggal & Waktu</th>
                        <th>Nama Petugas</th>
                        <th>Total Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekapPendapatan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id_transaksi }}</td>
                            <td>{{ $item->tanggal_waktu_transaksi }}</td>
                            <td>{{ $item->nama_petugas }}</td>
                            <td>
                                Rp {{ number_format($item->total_transaksi_harian, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>
