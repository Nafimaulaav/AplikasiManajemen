<div class="header">
    <div class="header-kiri">
        <div class="logo-tempat">
            <img src="{{ asset('gambar/') }}" class="logo-icon">
            <span class="judul-apk">Karsadia Management</span>
        </div>
    </div>
</div>

<style>
    .header{
        background: #7ca55d;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 55px;
        color: white;
    }
    .header-kiri{
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .logo-tempat{
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .logo-icon{
        width: 32px;
        height: 32px;
        object-fit: contain;
        border-radius: 4px;
    }
    .judul-apk{
        font-size: 18px;
        font-weight: 600;
        color: white;
        letter-spacing: 0.5px;
    } 
</style>