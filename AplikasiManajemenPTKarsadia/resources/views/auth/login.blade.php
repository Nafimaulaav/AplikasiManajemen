@extends('layouts.auth')
@section('content')
<div class="login-bg">

    <div class="overlay"></div>

        <div class="login-container">
            <h2>Masuk</h2>

            @error('username')
            <div class="error">
                {{ $message }}
            </div>
            @enderror

            <div id="errorBox" class="error" style="display: none;"></div>
            <form id="formLogin" action="{{ url('login') }}" method="POST">
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
