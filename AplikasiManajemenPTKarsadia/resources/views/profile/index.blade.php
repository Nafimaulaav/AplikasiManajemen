@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px); font-family: 'Montserrat';">
    
    <div class="card shadow-sm p-5 text-center" style="max-width: 420px; width: 100%;">
        
        <i class="bi bi-person-circle mb-3" style="font-size: 80px; color: #000;"></i>

        <h3 class="fw-semibold mb-4">Profil Saya</h3>

        <p class="text-muted mb-1">Username</p>
        <p class="fs-5 fw-semibold mb-4">{{ $user->username }}</p>

        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-box-arrow-right me-2"></i>
            Keluar
        </button>

    </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-3">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle fs-1 text-warning mb-3"></i>
                <h5 class="fw-semibold">Yakin ingin keluar?</h5>
                <p class="text-muted">Anda akan keluar dari sistem</p>

                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-secondary w-50" data-bs-dismiss="modal">Batal</button>

                    <form action="{{ route('logout') }}" method="POST" class="w-50">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('logout_success'))
<!-- Modal Logout Berhasil -->
<div class="modal fade" id="logoutSuccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
                <h5 class="fw-semibold">Berhasil</h5>
                <p>Anda berhasil keluar</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
@if (session('logout_success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('logoutSuccessModal'));
    modal.show();

    setTimeout(() => {
        window.location.href = "{{ url('/login') }}";
    }, 2000);
});
</script>
@endif
@endpush
