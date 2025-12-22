<div class="header">
    <div class="header-kiri">
        <div class="logo-tempat">
            <img src="{{ asset('images/logo-karsadia.png') }}" class="icon-logo">
            <span class="judul-apk">Karsadia Management</span>
        </div>
    </div>

    @auth
    <div class="header-kanan">
        <i class="bi bi-person-circle"></i>
        <a href="{{ route('profile') }}" class="user-email">{{ Auth::user()->username ?? 'users'}}</a>
    </div>
    @endauth
</div>

