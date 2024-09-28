<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <img src="{{ asset('uin.png') }}" alt="arsip surat" width="70">
            <span class="app-brand-text demo text-black fw-bolder ms-2">arsip surat</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Beranda -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Beranda</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu Utama</span>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaksi.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-mail-send"></i>
                <div>Transaksi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaksi.masuk.*') || \Illuminate\Support\Facades\Route::is('transaksi.disposisi.*') ? 'active' : '' }}">
                    <a href="{{ route('transaksi.masuk.index') }}" class="menu-link">
                        <div>Surat Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaksi.keluar.*') ? 'active' : '' }}">
                    <a href="{{ route('transaksi.keluar.index') }}" class="menu-link">
                        <div>Surat Keluar</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('riwayat.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div>Riwayat</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('riwayat.masuk') ? 'active' : '' }}">
                    <a href="{{ route('riwayat.masuk') }}" class="menu-link">
                        <div>Surat Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('riwayat.keluar') ? 'active' : '' }}">
                    <a href="{{ route('riwayat.keluar') }}" class="menu-link">
                        <div>Surat Keluar</div>
                    </a>
                </li>
            </ul>
        </li>
            @if(auth()->user()->role == 'admin')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu Lainnya</span>
        </li>
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('reference.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-analyse"></i>
                    <div>Referensi</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('reference.kategori.*') ? 'active' : '' }}">
                        <a href="{{ route('reference.kategori.index') }}" class="menu-link">
                            <div>Kategori</div>
                        </a>
                    </li>
                    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('reference.status.*') ? 'active' : '' }}">
                        <a href="{{ route('reference.status.index') }}" class="menu-link">
                            <div>Status</div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Manajemen Pengguna -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('user.*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-pin"></i>
                    <div>Pengguna</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
