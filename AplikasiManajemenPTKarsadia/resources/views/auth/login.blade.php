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
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                        <i id="togglePassword" class="bi bi-eye-slash-fill" onclick="togglePassword()"></i>  
                    </div>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </div>  
</div>
@endsection

<script>
    function togglePassword(){
        const password = document.getElementById('password');
        const icon = document.getElementById('togglePassword');

        if (password.type === 'password'){
            password.type = 'text';
            icon.classList.remove('bi-eye-slash-fill');
            icon.classList.add('bi-eye-fill');
        }else {
            password.type ='password';
            icon.classList.remove('bi-eye-fill');
            icon.classList.add('bi-eye-slash-fill');
        }
    }
</script>
