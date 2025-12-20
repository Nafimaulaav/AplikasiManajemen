@extends('layouts.auth')
@section('content')
<div class="login-bg">

    <div class="overlay"></div>

        <div class="login-container">
            <h2>Masuk</h2>

            @if ($errors-> any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif
            <form action="{{ url('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>User </label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username"required>

                </div>

                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>

                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </div>  
</div>
@endsection
