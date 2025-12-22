@extends('layouts.app')

@section('content')

<div class="container">
    <div id="alert-success"></div>
    <div class="header-gh d-flex justify-content-between align-items-center mb-4">
        <h1 class="judulgh">Rumah Kaca</h1>
        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
            <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahGH">
                <i class="bi bi-plus"></i> Tambah Rumah Kaca
            </button>
        @endif
    </div>
    <div class="card-list-gh">
        @foreach ($greenhouses as $gh)
        <div class="gh-card">
            <div class="card-header-gh d-flex justify-content-between align-items-center">
                <div class="title-gh d-flex gap-3 align-items-center">
                    <!-- Link detail hanya untuk judul + ID -->
                    <a href="{{ route('detail_greenhouse', $gh->id_greenhouse) }}" class="gh-card-link">
                        <h2 class="nama-gh">{{ $gh->nama_greenhouse }}</h2>
                        <p class="id-gh">#{{ $gh->id_greenhouse }}</p>
                    </a>
                </div>

                @if (Auth::user()->role === 'admin')
                <div class="card-action-gh">
                    <!-- Tombol edit/hapus tidak di dalam link -->
                    <button type="button" class="btn edit-btn"
                            data-id="{{ $gh->id_greenhouse }}"
                            data-name="{{ $gh->nama_greenhouse }}"
                            data-alamat="{{ $gh->alamat_greenhouse }}"
                            data-status="{{ $gh->status_greenhouse }}"
                            data-bs-toggle="modal" data-bs-target="#modalEditGH">
                        <i class="bi bi-pencil-fill"></i> Ubah
                    </button>
                    <button type="button" class="btn hapus-btn"
                            data-id="{{ $gh->id_greenhouse }}"
                            data-bs-toggle="modal" data-bs-target="#modalHapusGH">
                        <i class="bi bi-trash-fill"></i> Hapus
                    </button>
                </div>
                @endif
            </div>

            <!-- Body card bisa juga dijadikan link penuh -->
            <a href="{{ route('detail_greenhouse', $gh->id_greenhouse) }}" class="gh-card-link">
                <div class="card-body-gh">
                    <div class="card-image-gh">
                        @if ($gh->gambar_greenhouse)
                            <img src="{{ asset('storage/' . $gh->gambar_greenhouse) }}" alt="Gambar Rumah Kaca">
                        @else
                            <img src="{{ asset('gambar/gh.jpg') }}" alt="Gambar Default Rumah Kaca">
                        @endif
                    </div>
                    <div class="card-conten-gh">
                        <div class="info-row">
                            <div class="info-label">Status:</div>
                            <div class="info-value">
                                <span class="status-gh {{ strtolower(str_replace(' ', '-', $gh->status_greenhouse)) }}">
                                    {{ $gh->status_greenhouse }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Suhu:</div>
                            <div class="info-value">{{ $gh->suhu_greenhouse ?? '-' }}°C</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Kelembapan:</div>
                            <div class="info-value">{{ $gh->kelembaban_greenhouse ?? '-' }}%</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Alamat:</div>
                            <div class="info-value">{{ $gh->alamat_greenhouse ?? '-'}}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<!-- tambah -->
<div class="modal fade" id="modalTambahGH" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rumah Kaca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahGH" method="POST" action="{{ route('store_greenhouse') }}">
                    @csrf
                    <div class=mb-3>
                        <label>ID Greenhouse</label>
                        <input type="text" name="id_greenhouse" class="form-control" value="{{ $newid }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama_greenhouse" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat_greenhouse" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status_greenhouse" class="form-control">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Perbaikan">Perbaikan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar_greenhouse" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-tambah">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- edit -->
 <div class="modal fade" id="modalEditGH" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Rumah Kaca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditGH" method="POST">
                    @csrf
                    <!-- @method('PUT') -->
                    <div class="mb-3">
                        <label>ID Greenhouse</label>
                        <input type="text" name="id_greenhouse" id="editID" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama_greenhouse" id="editNama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat_greenhouse" id="editAlamat" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status_greenhouse" id="editStatus" class="form-control">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Perbaikan">Perbaikan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar_greenhouse" id="editGambar" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-tambah">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
 </div>
 <!-- hapus -->
<div class="modal fade" id="modalHapusGH" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Greenhouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus greenhouse ini?
            </div>
            <div class="modal-footer">
                <form id="formHapusGH" method="POST">
                @csrf
                @method('DELETE')
                    <input type="hidden" name="id_greenhouse" id="hapusId">
                    <button type="submit" class="btn btn-hapus">Hapus</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
// Fungsi buat buka dan tutup modal
    document.addEventListener('DOMContentLoaded', function() {
    // modal edit
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-name');
            const alamat = this.getAttribute('data-alamat');
            const status = this.getAttribute('data-status');

            // isi value pada form edit
            document.getElementById('editID').value = id;
            document.getElementById('editNama').value = nama;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editStatus').value = status;

            const formEdit = document.querySelector('#formEditGH');
            formEdit.action = '/greenhouse/edit/' + id;
        });
    });

    // modal hapus
    const hapusButtons = document.querySelectorAll('.hapus-btn'); // samakan dengan Blade
    hapusButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = this.getAttribute('data-id');
            document.getElementById('hapusId').value = id;

            const formHapus = document.querySelector('#formHapusGH');
            formHapus.action = '/greenhouse/hapus/' + id;
        });
    });
});

</script>

