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

    <li class="">
        @can('input_spk_access')
            <a href="{{ route('input-spk.index') }}">
                <i class="fa fa-keyboard" style="font-size:16px"></i>
                <span data-key="t-dashboard">Input SPK</span>
            </a>
        @endcan
    </li>

    <li class="">
        @can('pasang_baru_access')
            <a href="{{ route('pasang-baru.index') }}">
                <i class="fa fa-calendar-check" style="font-size:16px"></i>
                <span data-key="t-dashboard">Pasang Baru</span>
            </a>
        @endcan
    </li>

    <li class="">
        @can('dc_access')
            <a href="{{ route('dc.index') }}">
                <i class="fa fa-id-card" style="font-size:16px"></i>
                <span data-key="t-dashboard">DC</span>
            </a>
        @endcan
    </li>

    <li class="">
        @can('relokasi_access')
            <a href="{{ route('relokasi.index') }}">
                <i class="fa fa-file-text" style="font-size:16px"></i>
                <span data-key="t-dashboard">Relokasi</span>
            </a>
        @endcan
    </li>

    <li class="">
        @can('extSementara_access')
            <a href="{{ route('extSementara.index') }}">
                <i class="fa fa-share" style="font-size:16px"></i>
                <span data-key="t-dashboard">Exit Sementara</span>
            </a>
        @endcan
    </li>

    <li class="">
        @can('putus_access')
            <a href="{{ route('putus.index') }}">
                <i class="fa fa-file-text" style="font-size:16px"></i>
                <span data-key="t-dashboard">Putus</span>
            </a>
        @endcan
    </li>

    <li class="">
        @can('geser_access')
            <a href="{{ route('geser.index') }}">
                <i class="fa fa-calendar-plus" style="font-size:16px"></i>
                <span data-key="t-dashboard">Geser</span>
            </a>
        @endcan
    </li>

    <li class="">
        @can('laporan_access')
            <a href="{{ route('laporan.index') }}">
                <i class="fa fa-folder-open" style="font-size:16px"></i>
                <span data-key="t-dashboard">Laporan</span>
            </a>
        @endcan
    </li>


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
