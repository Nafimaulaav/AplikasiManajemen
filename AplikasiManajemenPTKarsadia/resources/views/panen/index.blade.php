@extends('layouts.app')

@section('content')
<div class="panen-main">
    <!-- Header -->
    <div class="panen-header">
        <h1>Panen</h1>
        <button class="btn-tambah" onclick="openModal()">+ Tambah</button>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Card -->
    <div class="panen-card">
        <!-- Search -->
        <div class="panen-action">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Telusuri" id="searchInput">
            </div>
        </div>

        <!-- Table -->
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>ID Panen</th>
                        <th>Greenhouse</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Kualitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($panen as $p)
                    <tr>
                        <td>{{ $p->id_panen }}</td>
                        <td>{{ $p->greenhouse->nama ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_panen)->format('d-m-Y') }}</td>
                        <td>{{ $p->jumlah_panen }}</td>
                        <td>
                            @if($p->kualitas == 'Baik')
                                <span class="badge-baik">{{ $p->kualitas }}</span>
                            @elseif($p->kualitas == 'Sedang')
                                <span class="badge-sedang">{{ $p->kualitas }}</span>
                            @else
                                <span class="badge-buruk">{{ $p->kualitas }}</span>
                            @endif
                        </td>
                        <td class="aksi">
                            <a href="{{ route('edit_panen', $p->id_panen) }}" class="btn-edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('destroy_panen', $p->id_panen) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Hapus data?')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data panen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal-overlay" id="modal">
    <div class="modal-card">
        <h2>Tambah Data Panen</h2>

        <form method="POST" action="{{ route('store_panen') }}">
            @csrf

            <div class="form-group">
                <label>Tanggal Panen *</label>
                <input type="date" name="tanggal_panen" required value="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label>Greenhouse *</label>
                <select name="id_greenhouse" required>
                    <option value="">-- Pilih Greenhouse --</option>
                    @foreach($greenhouses as $gh)
                        <option value="{{ $gh->id_greenhouse }}">
                            {{ $gh->nama ?? $gh->id_greenhouse }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Panen *</label>
                <input type="number" name="jumlah_panen" min="1" required placeholder="Contoh: 100">
            </div>

            <div class="form-group">
                <label>Kualitas *</label>
                <select name="kualitas" required>
                    <option value="">-- Pilih --</option>
                    <option value="Baik">Baik</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Buruk">Buruk</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn-submit">Simpan</button>
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= STYLE ================= -->
<style>
/* Main Container */
.panen-main {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

/* Header */
.panen-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.panen-header h1 {
    color: #2D5443;
    font-size: 28px;
    margin: 0;
}

.btn-tambah {
    background: #EAA652;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-tambah:hover {
    background: #d89440;
}

/* Alerts */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
    border-left: 4px solid #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
    border-left: 4px solid #dc3545;
}

.alert-error ul {
    margin: 5px 0;
    padding-left: 20px;
}

/* Card */
.panen-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Search */
.panen-action {
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.search-box {
    position: relative;
    width: 300px;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
}

.search-box input {
    width: 100%;
    padding: 10px 10px 10px 35px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
}

/* Table */
.table-box {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table thead {
    background: #f8f9fa;
}

table th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #dee2e6;
}

table td {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

table tbody tr:hover {
    background: #f8f9fa;
}

/* Badge Kualitas */
.badge-baik {
    background: #d4edda;
    color: #155724;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-sedang {
    background: #fff3cd;
    color: #856404;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-buruk {
    background: #f8d7da;
    color: #721c24;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* Aksi Buttons */
.aksi {
    display: flex;
    gap: 8px;
}

.btn-edit {
    background: #4CAF50;
    color: white;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
}

.btn-delete {
    background: #dc3545;
    color: white;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.btn-edit:hover {
    background: #45a049;
}

.btn-delete:hover {
    background: #c82333;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-card {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 100%;
    max-width: 450px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.modal-card h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #2D5443;
    font-size: 24px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #555;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #ddd;
    font-size: 14px;
    transition: border 0.3s;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #EAA652;
    box-shadow: 0 0 0 2px rgba(234, 166, 82, 0.2);
}

.modal-actions {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.btn-submit {
    flex: 1;
    background: #EAA652;
    border: none;
    padding: 12px;
    color: white;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-submit:hover {
    background: #d89440;
}

.btn-cancel {
    flex: 1;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-cancel:hover {
    background: #5a6268;
}

/* Responsive */
@media (max-width: 768px) {
    .panen-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .search-box {
        width: 100%;
    }
    
    .modal-card {
        margin: 20px;
        padding: 20px;
    }
    
    .aksi {
        flex-wrap: wrap;
    }
}
</style>

<!-- ================= SCRIPT ================= -->
<script>
function openModal() {
    document.getElementById('modal').style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        closeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
});

// Confirm delete with custom message
function confirmDelete(event) {
    if (!confirm('Apakah Anda yakin ingin menghapus data panen ini?')) {
        event.preventDefault();
    }
}

// Attach confirm to all delete buttons
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', confirmDelete);
    });
});
</script>
@endsection