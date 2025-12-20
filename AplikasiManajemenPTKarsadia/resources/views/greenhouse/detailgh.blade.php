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
                        <a href="javascript:void(0)" onclick="openModal('modalEditMonitoring')" class="gh-btn-edit">Edit Monitoring</a>
                        
                        {{-- Modal Edit Monitoring --}}
                        <div id="modalEditMonitoring" class="gh-modal">
                            <div class="gh-modal-content">
                                <span class="gh-modal-close" onclick="closeModal('modalEditMonitoring')">&times;</span>
                                <h2 class="gh-modal-title">Edit Monitoring Greenhouse</h2>

                                <form action="{{ route('update_monitoring', $greenhouse->id_greenhouse) }}" method="POST" class="gh-form">
                                    @csrf

                                    <div class="gh-form-group">
                                        <label for="waktu_monitoring">Waktu Monitoring</label>
                                        <input type="datetime-local" name="waktu_monitoring" class="gh-input" value="{{ \Carbon\Carbon::parse($greenhouse->waktu_monitoring)->format('Y-m-d\TH:i') }}" required>
                                    </div>

                                    <div class="gh-form-group">
                                        <label for="suhu_greenhouse">Suhu (°C)</label>
                                        <input type="number" name="suhu_greenhouse" class="gh-input" value="{{ $greenhouse->suhu_greenhouse }}" step = "any" required>
                                    </div>

                                    <div class="gh-form-group">
                                        <label for="kelembaban_greenhouse">Kelembaban (%)</label>
                                        <input type="number" name="kelembaban_greenhouse" class="gh-input" value="{{ $greenhouse->kelembaban_greenhouse }}" step = "any" required>
                                    </div>

                                    <div class="gh-form-group">
                                        <label for="intensitas_cahaya_greenhouse">Intensitas Cahaya (lux)</label>
                                        <input type="number" name="intensitas_cahaya_greenhouse" class="gh-input" value="{{ $greenhouse->intensitas_cahaya_greenhouse }}" step = "any" required>
                                    </div>

                                    <div class="gh-form-group">
                                        <label for="volume_air_greenhouse">Volume Air (liter)</label>
                                        <input type="number" name="volume_air_greenhouse" class="gh-input" value="{{ $greenhouse->volume_air_greenhouse }}" step = "any" required>
                                    </div>

                                    <button type="submit" class="gh-btn-tambah gh-btn-center">Simpan Monitoring</button>
                                </form>
                            </div>
                        </div>



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
                        <a href="javascript:void(0)" onclick="openModal('modalEditSpecs')" class="gh-btn-edit">Edit Spesifikasi</a>

                        {{-- Modal Edit Spesifikasi --}}
                        <div id="modalEditSpecs" class="gh-modal">
                            <div class="gh-modal-content">
                                <span class="gh-modal-close" onclick="closeModal('modalEditSpecs')">&times;</span>
                                <h2 class="gh-modal-title">Edit Spesifikasi Greenhouse</h2>

                                <form action="{{ route('update_specs', $greenhouse->id_greenhouse) }}" method="POST" class="gh-form">
                                    @csrf

                                    <div class="gh-form-group">
                                        <label for="luas_greenhouse">Luas Greenhouse (m²)</label>
                                        <input type="number" name="luas_greenhouse" class="gh-input" value="{{ $greenhouse->luas_greenhouse }}" step = "any" required>
                                    </div>

                                    <div class="gh-form-group">
                                        <label for="tinggi_greenhouse">Tinggi Greenhouse (m)</label>
                                        <input type="number" name="tinggi_greenhouse" class="gh-input" value="{{ $greenhouse->tinggi_greenhouse }}" step = "any" required>
                                    </div>

                                    <div class="gh-form-group">
                                        <label for="sistem_dipakai_greenhouse">Sistem yang Dipakai</label>
                                        <input type="text" name="sistem_dipakai_greenhouse" class="gh-input" value="{{ $greenhouse->sistem_dipakai_greenhouse }}" required>
                                    </div>

                                    <button type="submit" class="gh-btn-tambah gh-btn-center">Simpan Spesifikasi</button>
                                </form>
                            </div>
                        </div>

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
                        <a href="javascript:void(0)" onclick="openModal('modalTambahQC')" class="gh-btn-tambah">+ Tambah</a>

                        {{-- Modal Tambah QC --}}
                        <div id="modalTambahQC" class="gh-modal">
                            <div class="gh-modal-content">
                                <span class="gh-modal-close" onclick="closeModal('modalTambahQC')">&times;</span>

                                <h2 class="gh-modal-title">Tambah Log QC</h2>

                                <form action="{{ route('store_qc', $greenhouse->id_greenhouse) }}" method="POST" enctype="multipart/form-data" class="gh-form">
                                    @csrf

                                    <div class="gh-form-section">
                                        <h3 class="gh-form-subtitle">Data Pemeriksaan</h3>

                                        <input type="hidden" name="id_greenhouse" value="{{ $greenhouse->id_greenhouse }}">

                                        <div class="gh-form-group">
                                            <label for="tanggal_qc">Tanggal QC</label>
                                            <input type="datetime-local" name="tanggal_qc" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="nama_petugas">Nama Petugas</label>
                                            <input type="text" name="nama_petugas" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="varietas_melon">Varietas Melon</label>
                                            <input type="text" name="varietas_melon" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="status_tumbuh">Status Tumbuh</label>
                                            <select name="status_tumbuh" class="gh-input" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="Vegetatif">Vegetatif</option>
                                                <option value="Generatif">Generatif</option>
                                                <option value="Panen">Panen</option>
                                                <option value="Gegetatif">Gegetatif</option>
                                            </select>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="total_tanaman">Total Tanaman</label>
                                            <input type="number" name="total_tanaman" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="jumlah_tanaman_tumbuh">Jumlah Tanaman Tumbuh</label>
                                            <input type="number" name="jumlah_tanaman_tumbuh" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="jumlah_tanaman_sehat">Jumlah Tanaman Sehat</label>
                                            <input type="number" name="jumlah_tanaman_sehat" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="jumlah_tanaman_sakit">Jumlah Tanaman Sakit</label>
                                            <input type="number" name="jumlah_tanaman_sakit" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="jumlah_tanaman_mati">Jumlah Tanaman Mati</label>
                                            <input type="number" name="jumlah_tanaman_mati" class="gh-input" required>
                                        </div>

                                        <div class="gh-form-group">
                                            <label for="gambar_qc[]">Upload Foto QC (maks. 4 gambar)</label>
                                            <input type="file" name="gambar_qc[]" class="gh-input" multiple accept="image/*">
                                        </div>
                                    </div>

                                    <button type="submit" class="gh-btn-tambah gh-btn-center">+ Tambah</button>
                                </form>
                            </div>
                        </div>


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
                                <a href="javascript:void(0)" onclick="openModal('modalEditQC{{ $qc->id_log_qc }}')" class="gh-btn-edit">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                {{-- Modal Edit QC --}}
                                    <div id="modalEditQC{{ $qc->id_log_qc }}" class="gh-modal">
                                        <div class="gh-modal-content">
                                            <span class="gh-modal-close" onclick="closeModal('modalEditQC{{ $qc->id_log_qc }}')">&times;</span>
                                            <h2 class="gh-modal-title">Edit Log QC</h2>

                                            <form action="{{ route('update_qc', $qc->id_log_qc) }}" method="POST" enctype="multipart/form-data" class="gh-form">
                                                @csrf
                                                {{-- Form section --}}
                                                <div class="gh-form-section">
                                                    <h3 class="gh-form-subtitle">Data Pemeriksaan</h3>

                                                    <div class="gh-form-group">
                                                        <label for="tanggal_qc">Tanggal QC</label>
                                                        <input type="datetime-local" name="tanggal_qc" class="gh-input" value="{{ \Carbon\Carbon::parse($qc->tanggal_qc)->format('Y-m-d\TH:i') }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="nama_petugas">Nama Petugas</label>
                                                        <input type="text" name="nama_petugas" class="gh-input" value="{{ $qc->nama_petugas }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="varietas_melon">Varietas Melon</label>
                                                        <input type="text" name="varietas_melon" class="gh-input" value="{{ $qc->varietas_melon }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="status_tumbuh">Status Tumbuh</label>
                                                        <select name="status_tumbuh" class="gh-input" required>
                                                            @foreach (['Vegetatif', 'Generatif', 'Panen', 'Gegetatif'] as $status)
                                                                <option value="{{ $status }}" {{ $qc->status_tumbuh == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="total_tanaman">Total Tanaman</label>
                                                        <input type="number" name="total_tanaman" class="gh-input" value="{{ $qc->total_tanaman }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="jumlah_tanaman_tumbuh">Jumlah Tanaman Tumbuh</label>
                                                        <input type="number" name="jumlah_tanaman_tumbuh" class="gh-input" value="{{ $qc->jumlah_tanaman_tumbuh }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="jumlah_tanaman_sehat">Jumlah Tanaman Sehat</label>
                                                        <input type="number" name="jumlah_tanaman_sehat" class="gh-input" value="{{ $qc->jumlah_tanaman_sehat }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="jumlah_tanaman_sakit">Jumlah Tanaman Sakit</label>
                                                        <input type="number" name="jumlah_tanaman_sakit" class="gh-input" value="{{ $qc->jumlah_tanaman_sakit }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="jumlah_tanaman_mati">Jumlah Tanaman Mati</label>
                                                        <input type="number" name="jumlah_tanaman_mati" class="gh-input" value="{{ $qc->jumlah_tanaman_mati }}" required>
                                                    </div>

                                                    <div class="gh-form-group">
                                                        <label for="gambar_qc[]">Upload Foto Baru (opsional)</label>
                                                        <input type="file" name="gambar_qc[]" class="gh-input" multiple accept="image/*">
                                                    </div>
                                                </div>

                                                <button type="submit" class="gh-btn-tambah gh-btn-center">Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>

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
                                    <img src="{{ asset('storage/'.$img) }}" class="gh-qc-thumb" alt="Foto QC">
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


<script>
// Fungsi buat buka dan tutup modal
    function openModal(id) {
        document.getElementById(id).style.display = 'block';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Tutup modal kalau klik di luar kontennya
    window.onclick = function(event) {
        const modal = document.getElementById('modalTambahQC');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
</script>


