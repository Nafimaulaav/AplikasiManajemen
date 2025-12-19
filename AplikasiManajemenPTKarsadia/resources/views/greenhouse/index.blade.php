@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="judulgh">Rumah Kaca</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
        <div class="btn-add-gh">
            <a href="{{ route('tambah_greenhouse') }}" class="btn-tambah">
                <i class="bi bi-plus-circle-fill"></i> Tambahkan Rumah Kaca
            </a>
        </div>
    @endif

    <div class="card-list-gh">
        @foreach ($greenhouse as $gh)
        <a href="{{ route('green') }}"></a>
        
        @endforeach
    </div>
</div>

@endsection