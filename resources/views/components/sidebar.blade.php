<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <img src="{{ asset('pustipanda.png') }}" alt="pengarsipan surat" width="50">
            <span class="app-brand-text demo text-black fw-bolder ms-1" style="font-size: 20px;">pengarsipan surat</span>
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

        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaksi.*') || \Illuminate\Support\Facades\Route::is('riwayat.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div class="menu-title">Menu Utama</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaksi.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="menu-title">Transaksi</div>
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
                        <div class="menu-title">Riwayat</div>
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
            </ul>
        </li>

        @if(auth()->user()->role == 'admin')
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('reference.kategori.*') || \Illuminate\Support\Facades\Route::is('reference.status.*') || \Illuminate\Support\Facades\Route::is('user.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div>Menu Lainnya</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('reference.kategori.*') ? 'active' : '' }}">
                    <a href="{{ route('reference.kategori.index') }}" class="menu-link">
                        <div>Kategori</div>
                    </a>
                </li>

                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('user.*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="menu-link">
                        <div>Pengguna</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <li class="menu-item">
            <form action="{{ route('logout') }}" method="post" style="margin: 0;">
                @csrf
                <a href="javascript:void(0);" class="menu-link" 
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="menu-icon tf-icons bx bx-log-out"></i>
                    <div>Keluar</div>
                </a>
            </form>
        </li>
    </ul>
</aside>

<style>

    .menu-sub .menu-item {
        padding-left: 8px;
    }
</style>