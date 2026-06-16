@extends('layouts.app')

@section('content')
<!-- <style>
    /* Styling Modal & Card */
    .modal-overlay {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content-custom {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 15px;
        width: 450px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        position: relative;
    }

    .modal-header-custom {
        text-align: center;
        margin-bottom: 20px;
    }

    .modal-header-custom h3 {
        font-weight: bold;
        color: #333;
    }

    .form-group-custom {
        margin-bottom: 15px;
    }

    .form-group-custom label {
        display: block;
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .form-group-custom input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
    }

    .btn-submit-custom {
        background-color: #e6a04d;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: bold;
        width: 100%;
        margin-top: 10px;
    }

    .gh-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style> -->

<div class="container">
    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum dapat disimpan:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="header-gh d-flex justify-content-between align-items-center mb-4">
        <h1 class="judulgh">Laporan Pendapatan</h1>
        <button type="button" class="btn btn-primary" onclick="toggleAddModal(true)">
            + Tambah Transaksi
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="gh-card p-4">
                <h5>Total Pendapatan Bulan Ini</h5>
                <h3 class="fw-bold">Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</h3>
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
                <h3 class="fw-bold">Rp {{ number_format($pendapatanTerbaru ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- Table Rekap --}}
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
                            <td>{{ $item->tanggal_waktu_transaksi?->format('d-m-Y H:i') ?? '-' }}</td>
                            <td>{{ $item->nama_petugas }}</td>
                            <td>Rp {{ number_format($item->total_transaksi_harian, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if(auth()->user()->role === 'admin')
                                    <button type="button"
                                            class="btn btn-sm btn-warning"
                                            data-id="{{ $item->id_transaksi }}"
                                            data-url="{{ route('transaksi.update', ['id' => $item->id_transaksi]) }}"
                                            data-tanggal="{{ $item->tanggal_waktu_transaksi?->format('Y-m-d\TH:i') }}"
                                            data-total="{{ $item->total_transaksi_harian }}"
                                            data-petugas="{{ $item->nama_petugas }}"
                                            onclick="openEditModal(this)">
                                        Edit
                                    </button>

                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            data-id="{{ $item->id_transaksi }}"
                                            onclick="openDeleteModal(this)">
                                        Hapus
                                    </button>
                                @else
                                    <span style="color:#aaa;">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH DATA --}}
<div id="modalTambah" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h3>Tambah Transaksi Baru</h3>
        </div>
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="form-group-custom">
                <label>ID Transaksi</label>
                <input type="text"
                    value="{{ $newId }}"
                    readonly>
            </div>
            <div class="form-group-custom">
                <label>Tanggal Transaksi</label>
                <input type="datetime-local" name="tanggal_waktu_transaksi" required>
            </div>
            <div class="form-group-custom">
                <label>Jumlah Pendapatan</label>
                <input type="number"
                    name="total_transaksi_harian"
                    min="0"
                    step="0"
                    placeholder="Rp"
                    required>
            </div>
            <div class="form-group-custom">
                <label>Nama Petugas</label>
                <input type="text"
                    name="nama_petugas"
                    maxlength="100"
                    placeholder="Nama Petugas"
                    required>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-submit-custom">Tambahkan</button>
                <button type="button" class="btn btn-cancel-custom" onclick="toggleAddModal(false)">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT DATA --}}
<div id="modalEdit" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h3>Edit Transaksi</h3>
            <span id="edit_id_label" class="badge bg-warning text-dark"></span>
        </div>
        <form id="formEditAction" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="form-group-custom">
                <label>ID Transaksi</label>
                <input type="text"
                    id="edit_id_display"
                    readonly>
            </div>
            <div class="form-group-custom">
                <label>Tanggal Transaksi</label>
                <input type="datetime-local"
                    name="tanggal_waktu_transaksi"
                    id="edit_tanggal"
                    required>
            </div>

            <div class="form-group-custom">
                <label>Jumlah Pendapatan</label>
                <input type="number"
                    name="total_transaksi_harian"
                    id="edit_total"
                    min="1"
                    step="1"
                    required>
            </div>

            <div class="form-group-custom">
                <label>Nama Petugas</label>
                <input type="text"
                    name="nama_petugas"
                    id="edit_petugas"
                    maxlength="100"
                    required>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn-submit-custom">
                    Simpan Perubahan
                </button>

                <button type="button"
                        class="btn btn-cancel-custom"
                        onclick="toggleEditModal(false)">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Konfirmasi Hapus -->
<div id="modalHapus" class="modal-overlay">
    <div class="modal-content-custom">
        <h3 class="text-center mb-3">Konfirmasi Hapus Data</h3>
        <p class="text-center">Apakah Anda yakin ingin menghapus data <br><strong id="hapus_id_display"></strong>?</p>
        
        <form id="formHapusAction" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-actions d-flex justify-content-center gap-2">
                {{-- Tombol ini cukup type="submit" saja, tidak perlu onclick lagi --}}
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" onclick="toggleDeleteModal(false)">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Menampilkan atau menyembunyikan modal tambah.
    function toggleAddModal(show) {
        document.getElementById('modalTambah').style.display =
            show ? 'flex' : 'none';
    }

    // Menampilkan atau menyembunyikan modal edit.
    function toggleEditModal(show) {
        document.getElementById('modalEdit').style.display =
            show ? 'flex' : 'none';
    }

    // Mengisi data modal edit dari atribut data-* tombol.
    function openEditModal(button) {
        document.getElementById('formEditAction').action =
            button.dataset.url;

        document.getElementById('edit_id_display').value =
            button.dataset.id;

        document.getElementById('edit_id_label').innerText =
            button.dataset.id;

        document.getElementById('edit_tanggal').value =
            button.dataset.tanggal;

        document.getElementById('edit_total').value =
            button.dataset.total;

        document.getElementById('edit_petugas').value =
            button.dataset.petugas;

        toggleEditModal(true);
    }

    // Menampilkan atau menyembunyikan modal hapus.
    function toggleDeleteModal(show) {
        document.getElementById('modalHapus').style.display =
            show ? 'flex' : 'none';
    }

    // Mengatur ID transaksi yang akan dihapus.
    function openDeleteModal(button) {
        document.getElementById('formHapusAction').action =
            '/pendapatan/' + button.dataset.id;

        document.getElementById('hapus_id_display').innerText =
            button.dataset.id;

        toggleDeleteModal(true);
    }

    // Tutup modal ketika pengguna mengeklik area gelap di luar popup.
    window.addEventListener('click', function (event) {
        const modals = [
            document.getElementById('modalTambah'),
            document.getElementById('modalEdit'),
            document.getElementById('modalHapus')
        ];

        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Sembunyikan notifikasi setelah 3 detik.
    document.addEventListener('DOMContentLoaded', function () {
        const alertBox = document.querySelector('.alert');

        if (alertBox) {
            setTimeout(() => {
                alertBox.style.transition = 'opacity 0.5s ease';
                alertBox.style.opacity = '0';

                setTimeout(() => {
                    alertBox.remove();
                }, 500);
            }, 3000);
        }
    });
</script>

@endsection