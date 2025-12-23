@extends('layouts.app')

@section('content')

<div class="container">
    <div class="header-gh d-flex justify-content-between align-items-center mb-4">
        <h1 class="judulgh">Laporan Pendapatan</h1>

        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            + Tambah Transaksi
        </a>
    </div>

    <!-- CARD RINGKASAN -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="gh-card p-4">
                <h5>Total Pendapatan Bulan Ini</h5>
                <h3 class="fw-bold">
                    Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="gh-card p-4">
                <h5>Jumlah Transaksi</h5>
                <h3 class="fw-bold">{{ $jumlahPendapatan }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="gh-card p-4">
                <h5>Pendapatan Terbaru</h5>
                <h3 class="fw-bold">
                    Rp {{ number_format($pendapatanTerbaru ?? 0, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <!-- TABEL REKAP -->
    <div class="gh-card p-4">
        <h4 class="mb-3">Rekap Transaksi</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Petugas</th>
                        <th>Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekapPendapatan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id_transaksi }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_waktu_transaksi)->format('d-m-Y H:i') }}
                            </td>
                            <td>{{ $item->nama_petugas }}</td>
                            <td>
                                Rp {{ number_format($item->total_transaksi_harian, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('transaksi.edit', $item->id_transaksi) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('transaksi.destroy', $item->id_transaksi) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus transaksi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada data transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
