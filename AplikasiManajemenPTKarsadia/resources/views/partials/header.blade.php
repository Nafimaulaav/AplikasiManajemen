<div class="header">
    <div class="header-kiri">
        <div class="logo-tempat">
            <img src="{{ asset('images/logo-karsadia.png') }}" class="icon-logo">
            <span class="judul-apk">Karsadia Management</span>
        </div>
    </div>

    @auth
    <div class="header-kanan">
        <img src="{{ asset('gambar/icon/user.png') }}" class="icon-user" alt="User">
        <span class="user-email">{{ Auth::user()->email ?? 'users'}}</span>
    </div>
    @endauth
</div>

