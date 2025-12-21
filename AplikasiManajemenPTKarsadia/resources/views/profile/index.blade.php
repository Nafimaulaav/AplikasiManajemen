@extends('layouts.app')

@section('content')
<div class="profile-page">
    <h2>Profil saya</h2>
    <p><strong>Username:</strong> {{ $user->username }}</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="sumbit" class="btn btn-danger">Keluar</button>
    </form>
</div>


@endsection