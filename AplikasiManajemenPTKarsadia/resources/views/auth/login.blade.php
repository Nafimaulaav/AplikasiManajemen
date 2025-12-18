@extends('layouts.app')
@section('content')

<div class="overlay">
    <div value="login-container">
        <h2>Masuk</h2>

        @if ($errors-> any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif
        <form action="{{ url('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

            </div>

            <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" name="password" required>

            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

    </div>
</div>
@endsection