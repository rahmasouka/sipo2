<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="/assets/img/logo.png" width="25px" alt="">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">sipo</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        {{-- <li class="menu-item active open">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Menu Utama</div>
                <div class="badge bg-danger rounded-pill ms-auto">5</div>
            </a> --}}

        <li class="menu-item {{ $link == 'dashboard' ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                <div data-i18n="Email">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Master</span>
        </li>

        <li class="menu-item {{ $link == 'obat' ? 'active' : '' }}">
            <a href="/obat" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-capsule"></i>
                <div data-i18n="Email">Obat</div>
            </a>
        </li>

        <li class="menu-item {{ $link == 'satuan' ? 'active' : '' }}">
            <a href="/satuan" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-sushi"></i>
                <div data-i18n="Email">Satuan</div>
            </a>
        </li>
        <li class="menu-item {{ $link == 'pelaku' ? 'active' : '' }}">
            <a href="/pelaku" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-network-chart"></i>
                <div data-i18n="Email">Pelaku</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Transaksi</span>
        </li>

        <li class="menu-item {{ $link == 'batch' ? 'active' : '' }}">
            <a href="/batch" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-truck"></i>
                <div data-i18n="Email">Batch</div>
            </a>
        </li>
        <li class="menu-item {{ $link == 'stok-opname' ? 'active' : '' }}">
            <a href="/stok-opname" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-package"></i>
                <div data-i18n="Email">Stok Opname</div>
            </a>
        </li>
        <li class="menu-item {{ $link == 'permintaan-obat' ? 'active' : '' }}">
            <a href="/batch" class="menu-link">
                <i class="menu-icon tf-icons bx bx-git-pull-request"></i>
                <div data-i18n="Email">Permintaan Obat</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Master Setting</span>
        </li>

        <li class="menu-item {{ $link == 'website-setting' ? 'active' : '' }}">
            <a href="/website-setting" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-cog"></i>
                <div data-i18n="Email">Website Setting</div>
            </a>
        </li>
        <li class="menu-item {{ $link == 'user-admin' ? 'active' : '' }}">
            <a href="/user-admin" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="Email">User Admin</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Laporan</span>
        </li>

        <li class="menu-item {{ $link == 'laporan-stok-opname' ? 'active' : '' }}">
            <a href="/stok-opname" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Email">Laporan Stok Opname</div>
            </a>
        </li>
        <li class="menu-item {{ $link == 'laporan-permintaan' ? 'active' : '' }}">
            <a href="/batch" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Email">Laporan Permintaan</div>
            </a>
        </li>
        <li class="menu-item {{ $link == 'laporan-master-obat' ? 'active' : '' }}">
            <a href="/batch" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Email">Laporan Master Obat</div>
            </a>
        </li>
    </ul>
</aside>
