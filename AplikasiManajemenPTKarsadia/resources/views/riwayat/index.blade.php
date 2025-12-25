@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Riwayat Aktivitas</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Petugas</th>
                <th>Aksi</th>
                <th>Menu</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayat as $log)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($log->waktu_aksi)->format('d M Y H:i') }}</td>
                    <td>{{ $log->user->username ?? $log->user_id }}</td>
                    <td>{{ $log->tipe_aksi }}</td>
                    <td>{{ $log->menu_terkait }}</td>
                    <td>{{ $log->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
