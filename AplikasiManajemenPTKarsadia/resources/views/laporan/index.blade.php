@extends('layouts.app')

@section('content')
<div class="container">
    <div id="alert-success"></div>
    <div class="header-gh d-flex justify-content-between align-items-center mb-4">
        <h1 class="judullaporan">Laporan Harian</h1>
        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
            <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahLaporan">
                <i class="bi bi-plus"></i> Tambah Laporan
            </button>
        @endif
        {{-- Modal Tambah Laporan --}}
        <div class="modal fade" id="modalTambahLaporan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                    <h5 class="modal-title">Tambah Laporan Harian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                          <label>Judul Laporan</label>
                          <input type="text" name="judul_laporan" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label>Tanggal Laporan</label>
                          <input type="date" name="tanggal_laporan" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label>Greenhouse</label>
                          <select name="id_greenhouse" class="form-select" required>
                            <option value="">
                              @foreach ($greenhouse as $gh)
                                <option value="{{ $gh->id_greenhouse }}">
                                  {{ $gh->id_greenhouse }} - {{ $gh->nama_greenhouse }}
                                </option>
                              @endforeach
                            </option>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label>Nama Petugas</label>
                          <input type="text" name="nama_petugas" class="form-control" required>
                      </div>
                      <div class="mb-3">
                          <label>Aktivitas</label>
                          <select name="aktivitas" class="form-select" required>
                          <option value="Penanaman">Penanaman</option>
                          <option value="Perawatan">Perawatan</option>
                          <option value="Pembersihan">Pembersihan</option>
                          </select>
                      </div>
                      <div class="mb-3">
                          <label>Catatan</label>
                          <textarea name="catatan" class="form-control" rows="3"></textarea>
                      </div>
                      <div class="mb-3">
                          <label>Gambar (Opsional)</label>
                          <input type="file" name="gambar_laporan" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-tambah">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>

    <div class="card-list-gh">
        @foreach ($dataLaporan as $laporan)
        <div class="gh-card">
            <div class="card-header-gh d-flex justify-content-between align-items-start">
                <div class="title-gh">
                    <h2 class="nama-gh">{{ $laporan->judul_laporan }}</h2>
                    <p class="id-gh">{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d M Y') }}</p>
                </div>

                @if (Auth::user()->role === 'admin')
                <div class="card-action-gh">
                    <button type="button" class="btn edit-btn"
                            data-id="{{ $laporan->id_laporanharian }}"
                            data-judul="{{ $laporan->judul_laporan }}"
                            data-tanggal="{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('Y-m-d') }}"
                            data-petugas="{{ $laporan->nama_petugas }}"
                            data-aktivitas="{{ $laporan->aktivitas }}"
                            data-catatan="{{ $laporan->catatan }}"
                            data-bs-toggle="modal" data-bs-target="#modalEditLaporan">
                        <i class="bi bi-pencil-fill"></i> Ubah
                    </button>

                    <button type="button" class="btn btn-hapus open-hapus-modal"
                            data-id="{{ $laporan->id_laporanharian }}"
                            data-bs-toggle="modal" data-bs-target="#modalHapusLaporan">
                        <i class="bi bi-trash-fill"></i> Hapus
                    </button>

                </div>
                @endif
            </div>

            <div class="card-body-gh">
                <div class="card-image-gh">
                    @if ($laporan->gambar_laporan)
                        <img src="{{ asset('storage/' . $laporan->gambar_laporan) }}" alt="Gambar Laporan">
                    @else
                        <img src="{{ asset('gambar/laporan-default.jpg') }}" alt="Gambar Default">
                    @endif
                </div>
                <div class="card-conten-gh">
                    <div class="info-row"><strong>Petugas:</strong> {{ $laporan->nama_petugas }}</div>
                    <div class="info-row"><strong>Aktivitas:</strong> {{ $laporan->aktivitas }}</div>
                    <div class="info-row"><strong>Catatan:</strong> {{ $laporan->catatan }}</div>
                </div>
            </div>
        </div>
        @endforeach

                            {{-- Modal Edit Laporan --}}
                      <div class="modal fade" id="modalEditLaporan" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content">
                            <form id="formEditLaporan" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('POST')
                              <div class="modal-header">
                                <h5 class="modal-title">Ubah Laporan Harian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" name="id" id="editId">
                                <div class="mb-3">
                                  <label>Judul Laporan</label>
                                  <input type="text" name="judul_laporan" id="editJudul" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                  <label>Tanggal Laporan</label>
                                  <input type="date" name="tanggal_laporan" id="editTanggal" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                  <label>Greenhouse</label>
                                  <select name="id_greenhouse" class="form-select" required>
                                      @foreach ($greenhouse as $gh)
                                          <option value="{{ $gh->id_greenhouse }}"
                                              {{ $laporan->id_greenhouse == $gh->id_greenhouse ? 'selected' : '' }}>
                                              {{ $gh->nama_greenhouse }}
                                          </option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="mb-3">
                                  <label>Nama Petugas</label>
                                  <input type="text" name="nama_petugas" id="editPetugas" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                  <label>Aktivitas</label>
                                  <select name="aktivitas" id="editAktivitas" class="form-select" required>
                                    <option value="Penanaman">Penanaman</option>
                                    <option value="Perawatan">Perawatan</option>
                                    <option value="Pembersihan">Pembersihan</option>
                                  </select>
                                </div>
                                <div class="mb-3">
                                  <label>Catatan</label>
                                  <textarea name="catatan" id="editCatatan" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                  <label>Gambar (Opsional)</label>
                                  <input type="file" name="gambar_laporan" class="form-control">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-tambah">Simpan Perubahan</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    {{-- Modal Hapus Laporan --}}
                  <div class="modal fade" id="modalHapusLaporan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <form id="formHapusLaporan" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="modal-header">
                            <h5 class="modal-title">Hapus Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            Yakin ingin menghapus laporan ini?
                            <input type="hidden" name="id" id="hapusId">
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-hapus">Hapus</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
    </div>
</div>
@endsection

<!-- js buat modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== EDIT LAPORAN =====
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {

            const id = this.dataset.id;

            document.getElementById('editId').value = id;
            document.getElementById('editJudul').value = this.dataset.judul;
            document.getElementById('editTanggal').value = this.dataset.tanggal;
            document.getElementById('editPetugas').value = this.dataset.petugas;
            document.getElementById('editAktivitas').value = this.dataset.aktivitas;
            document.getElementById('editCatatan').value = this.dataset.catatan;

            document.getElementById('formEditLaporan').action =
                `/laporan/edit/${id}`;
        });
    });

    // ===== HAPUS LAPORAN =====
    document.querySelectorAll('.open-hapus-modal').forEach(button => {
        button.addEventListener('click', function () {

            const id = this.dataset.id;
            document.getElementById('hapusId').value = id;

            document.getElementById('formHapusLaporan').action =
                `/laporan/hapus/${id}`;
        });
    });

});
</script>
