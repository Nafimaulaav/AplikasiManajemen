@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="judulgh">Rumah Kaca</h1>

    <div id="alert-success"></div>
    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
        <div  class="btn-add-gh mb-3">
            <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahGH"></button>
                <i class="bi bi-plus-circle-fill"></i> Tambah Rumah Kaca
        </div>
    @endif

    <div class="card-list-gh">
        @foreach ($greenhouse as $gh)
        <div class="gh-card">
            <div class="card-image-gh">
                @if ($gh->gambar_greenhouse)
                    <img src="{{ asset('storage/' . $gh->gambar_greenhouse) }}" alt="Gambar Rumah Kaca">
                @else
                    <img src="{{ asset('gambar/gh.jpg') }}" alt="Gambar Default Rumah Kaca">
                @endif
            </div>
            <div class="card-conten-gh">
                <h2 class="nama-gh">{{ $gh->nama_greenhouse }}</h2>
                <p class="id-gh">#{{ $gh->id_greenhouse }}</p>
                <p class="info-gh">
                    <strong>Status</strong>
                    <span class="status-gh {{ strtolower(str_replace('','-', $gh->status_greenhouse)) }}">
                        {{ $gh->status_greenhouse }}
                    </span>
                </p>
                <p class="info-gh"><strong>Suhu: </strong> {{ $gh->suhu_greenhouse ?? '-' }}</p>
                <p class="info-gh"><strong>Kelembapan: </strong> {{ $gh->kelembapan_greenhouse ?? '-' }}</p>
                <p class="info-gh"><strong>Alamat: </strong> {{ $gh->alamat_greenhouse ?? '-' }}</p>
            </div>
            @if (Auth::user()->role === 'admin')
            <div class="card-action-gh">
                <button type="button" class="btn edit-btn" data-id= "{{ $gh->id_greenhouse }}" data-bs-toggle="model" data-bs-target="#modalEditGH">
                    <i class="bi bi-pencil-fill"></i> Ubah
                </button>
                <button type="button" class="btn btn-hapus" data-id="{{ $gh->id_greenhouse}}" data-bs-toggle="modal" data-bs-target="#modalHapusGH">
                    <i class="bi bi-trash-fill"></i> Hapus
                </button>
            </div>
            @endif
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
                <form id="formTambahGH">
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
 <div class="modal-fade" id="modalEditGH" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Rumah Kaca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="formEditGH">
                    @csrf
                    @method('PUT')
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
<div class="modal-fade" id="modalHapusGH" tabindex="-1" aria-hidden="true">
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
