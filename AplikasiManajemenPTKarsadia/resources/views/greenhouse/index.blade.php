@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="judulgh">Rumah Kaca</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
    
    
    @endif
</div>

@endsection