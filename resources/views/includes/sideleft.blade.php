<ul class="metismenu list-unstyled mm-show" id="side-menu">
    {{-- <li class="menu-title" data-key="t-menu">Dashboard</li> --}}

    <li class="">
        @can('dashboard_access')
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-chart-area" style="font-size:16px"></i>
                <span data-key="t-dashboard">Dashboard</span>
            </a>
        @endcan
    </li>

    @can('transaksi_masukan_access')
        <li>
            <a href="{{ route('insert-contract.index') }}">
                <i class="fa fa-chart-simple" style="font-size:16px"></i>
                <span data-key="t-dashboard">Input Kontrak AC</span>
            </a>
        </li>
    @endcan

    {{-- @canany(['master_pelanggan_access', 'master_tipe_kontrak_access', 'master_kontrak_access', 'daerah_access'])
        <li class="menu-title" data-key="t-menu">Master</li>
    @endcanany --}}

    {{-- <li>
        @canany(['master_pelanggan_access'])
            <a href="javascript: void(0);" class="has-arrow">
                <i class="fa fa-users" style="font-size:16px"></i>
                <span data-key="t-components">Pelanggan</span>
            </a>
        @endcanany

        <ul class="sub-menu mm-collapse" aria-expanded="false">
            @can('master_pelanggan_access')
                <li><a href="{{ route('customers.index') }}">Data Pelanggan</a></li>
                <li><a href="{{ route('insert-contract.index') }}">Masukan Kontrak AC</a></li>
            @endcan
        </ul>
    </li> --}}

    @can('master_pelanggan_access')
        <li>
            <a href="{{ route('customers.index') }}">
                <i class="fa fa-users" style="font-size:16px"></i>
                <span data-key="t-dashboard">Data Pelanggan</span>
            </a>
        </li>
    @endcan

    @canany(['master_tipe_kontrak_access', 'master_kontrak_access'])
        <li>
            <a href="{{ route('type_contract.index') }}">
                <i class="fa fa-folder-open" style="font-size:16px"></i>
                <span data-key="t-dashboard">Kontrak</span>
            </a>
        </li>
    @endcanany

    {{-- @can('master_daerah_access')
        <li>
            <a href="{{ route('region.index') }}">
                <i class="fa fa-map-location-dot" style="font-size:16px"></i>
                <span data-key="t-dashboard">Daerah</span>
            </a>
        </li>
    @endcan --}}


    @canany(['quotes_access'])
        {{-- <li class="menu-title" data-key="t-menu">Quotes</li> --}}

        <li>
            <a href="{{ route('quotes.index') }}">
                <i class="fa fa-comment-dots" style="font-size:16px"></i>
                <span data-key="t-dashboard">Quotes</span>
            </a>
        </li>
    @endcanany



    {{-- @canany(['laporan_access', 'laporan_ringkasan_access'])
        <li class="menu-title mt-2" data-key="t-components">Laporan</li>
    @endcanany --}}

    <li>
        @canany(['laporan_access', 'laporan_ringkasan_access'])
            <a href="javascript: void(0);" class="has-arrow">
                <i class="fa fa-box-archive" style="font-size:16px"></i>
                <span data-key="t-components">Laporan</span>
            </a>
        @endcanany

        <ul class="sub-menu mm-collapse" aria-expanded="false">
            @can('laporan_ringkasan_access')
                <li><a href="{{ route('reports.index.toko') }}">Toko</a></li>
            @endcan
            @can('laporan_ringkasan_access')
                <li><a href="{{ route('reports.non-toko.index') }}">Non Toko</a></li>
            @endcan
            @can('laporan_ringkasan_access')
                <li><a href="{{ route('reports.index.all') }}">All</a></li>
            @endcan
            @can('laporan_details_access')
                <li><a href="{{ route('report.details.index') }}">Details</a></li>
            @endcan
            @can('laporan_details_access')
                <li><a href="{{ route('report.rekap') }}">Rekap Untuk Tagihan</a></li>
            @endcan
            @can('laporan_habis_sewa_access')
                <li><a href="{{ route('sewa.index') }}">Laporan Habis Sewa</a></li>
            @endcan
        </ul>
    </li>


    {{-- @canany(['permissions_access', 'roles_access', 'users_access'])
        <li class="menu-title mt-2" data-key="t-components">Pengaturan</li>
    @endcanany --}}

    <li>
        @canany(['permissions_access', 'roles_access', 'users_access'])
            <a href="javascript: void(0);" class="has-arrow">
                <i class="fa fa-user-cog" style="font-size:16px"></i>
                <span data-key="t-components">Roles & Permissions</span>
            </a>
        @endcanany

        <ul class="sub-menu mm-collapse" aria-expanded="false">
            @can('roles_access')
                <li><a href="{{ route('roles.index') }}">Roles</a></li>
            @endcan
            @can('permissions_access')
                <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
            @endcan
        </ul>
    </li>


    @can('users_access')
        <li>
            <a href="{{ route('users.index') }}">
                <i class="fa fa-user-shield" style="font-size:16px"></i>
                <span data-key="t-dashboard">Users</span>
            </a>
        </li>
    @endcan



</ul>
