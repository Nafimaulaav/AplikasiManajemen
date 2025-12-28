@extends('layouts.app')

@section('content')
<div class="panen-main">

    <!-- HEADER -->
    <div class="panen-header">
        <h1>Panen</h1>
        <button class="btn-tambah" onclick="showModal('tambahModal')">+ Tambah</button>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- CARD -->
    <div class="panen-card">

        <!-- SEARCH -->
        <div class="panen-action">
            <input type="text" id="searchInput" placeholder="Cari data panen...">
        </div>

        <!-- TABLE -->
        <table id="panenTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Greenhouse</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Grade</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($panen as $p)
            <tr
                data-id="{{ $p->id_panen }}"
                data-tanggal="{{ $p->tanggal_panen }}"
                data-jumlah="{{ $p->jumlah_panen }}"
                data-a="{{ $p->jumlah_grade_a }}"
                data-b="{{ $p->jumlah_grade_b }}"
                data-c="{{ $p->jumlah_grade_c }}"
                data-greenhouse="{{ $p->id_greenhouse }}"
                data-greenhouse-nama="{{ $p->greenhouse->nama_greenhouse ?? '-' }}"
            >
                <td>{{ $p->id_panen }}</td>
                <td>{{ $p->greenhouse->nama_greenhouse ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_panen)->format('d-m-Y') }}</td>
                <td>{{ $p->jumlah_panen }}</td>
                <td>
                    A:{{ $p->jumlah_grade_a }} |
                    B:{{ $p->jumlah_grade_b }} |
                    C:{{ $p->jumlah_grade_c }}
                </td>
                <td class="aksi">
                    <button class="btn-edit" onclick="editPanen(this)">✏️</button>
                    <button class="btn-delete" onclick="hapusPanen(this)">🗑️</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">Belum ada data panen</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal-overlay" id="tambahModal">
<div class="modal-card">
<h3>Tambah Panen</h3>
<form method="POST" action="{{ route('store_panen') }}">
@csrf
<input type="date" name="tanggal_panen" required>
<select name="id_greenhouse" required>
    @foreach($greenhouses as $g)
        <option value="{{ $g->id_greenhouse }}">{{ $g->nama_greenhouse }}</option>
    @endforeach
</select>
<input type="number" name="jumlah_panen" placeholder="Jumlah Panen" required>
<input type="number" name="jumlah_grade_a" placeholder="Grade A" required>
<input type="number" name="jumlah_grade_b" placeholder="Grade B" required>
<input type="number" name="jumlah_grade_c" placeholder="Grade C" required>
<button type="submit" class="btn-submit">Simpan</button>
<button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
</form>
</div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div class="modal-overlay" id="editModal">
<div class="modal-card">
<h3>Edit Panen</h3>
<form method="POST" id="formEdit">
@csrf
@method('PUT')
<input id="e_id" readonly>
<input type="date" name="tanggal_panen" id="e_tanggal" required>
<select name="id_greenhouse" id="e_greenhouse" required>
    @foreach($greenhouses as $g)
        <option value="{{ $g->id_greenhouse }}">{{ $g->nama_greenhouse }}</option>
    @endforeach
</select>
<input type="number" name="jumlah_panen" id="e_jumlah" required>
<input type="number" name="jumlah_grade_a" id="e_a" required>
<input type="number" name="jumlah_grade_b" id="e_b" required>
<input type="number" name="jumlah_grade_c" id="e_c" required>
<button type="submit" class="btn-submit">Update</button>
<button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
</form>
</div>
</div>

<!-- ================= MODAL DELETE ================= -->
<div class="modal-overlay" id="deleteModal">
<div class="modal-card">
<h3>Hapus Data?</h3>
<p>ID Panen: <b><span id="d_id"></span></b></p>
<p>Greenhouse: <b><span id="d_gh"></span></b></p>
<form method="POST" id="formDelete">
@csrf
@method('DELETE')
<button type="submit" class="btn-delete">Hapus</button>
<button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
</form>
</div>
</div>

<!-- ================= CSS ================= -->
<style>
.panen-main{max-width:1100px;margin:auto;padding:20px}
.panen-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px}
.btn-tambah{padding:8px 16px;border:none;border-radius:6px;background:#EAA652;color:#fff}

.alert-success{background:#d4edda;padding:10px;border-radius:6px;margin-bottom:15px}

.panen-card{background:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.08);overflow:hidden}
.panen-action{padding:12px;border-bottom:1px solid #eee}
#searchInput{width:250px;padding:8px 12px;border-radius:6px;border:1px solid #ccc}

table{width:100%;border-collapse:collapse;font-size:14px}
thead{background:#f8f9fa}
th{padding:12px;text-align:left;border-bottom:2px solid #ddd}
td{padding:12px;border-bottom:1px solid #eee}
tbody tr:hover{background:#f5f7f8}

.aksi{display:flex;gap:6px}
.btn-edit{background:#4CAF50;color:#fff;border:none;padding:5px 8px;border-radius:4px}
.btn-delete{background:#dc3545;color:#fff;border:none;padding:5px 8px;border-radius:4px}

.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);justify-content:center;align-items:center}
.modal-card{background:#fff;padding:20px;border-radius:6px;width:100%;max-width:400px}

.modal-card input,.modal-card select{width:100%;padding:8px;margin-bottom:8px}
.btn-submit{background:#EAA652;border:none;color:#fff;padding:8px;border-radius:4px;width:100%}
.btn-cancel{background:#6c757d;border:none;color:#fff;padding:8px;border-radius:4px;width:100%;margin-top:5px}
</style>

<!-- ================= JS (RINGAN) ================= -->
<script>
function showModal(id){document.getElementById(id).style.display='flex'}
function closeModal(){document.querySelectorAll('.modal-overlay').forEach(m=>m.style.display='none')}

function editPanen(btn){
    let tr=btn.closest('tr');
    e_id.value=tr.dataset.id;
    e_tanggal.value=tr.dataset.tanggal;
    e_jumlah.value=tr.dataset.jumlah;
    e_a.value=tr.dataset.a;
    e_b.value=tr.dataset.b;
    e_c.value=tr.dataset.c;
    e_greenhouse.value=tr.dataset.greenhouse;
    formEdit.action=`/panen/edit/${tr.dataset.id}`;
    showModal('editModal');
}

function hapusPanen(btn){
    let tr=btn.closest('tr');
    d_id.innerText=tr.dataset.id;
    d_gh.innerText=tr.dataset.greenhouseNama;
    formDelete.action=`/panen/hapus/${tr.dataset.id}`;
    showModal('deleteModal');
}

document.getElementById('searchInput').addEventListener('keyup',function(){
    let key=this.value.toLowerCase();
    document.querySelectorAll('#panenTable tbody tr').forEach(r=>{
        r.style.display=r.innerText.toLowerCase().includes(key)?'':'none';
    });
});
</script>
@endsection
