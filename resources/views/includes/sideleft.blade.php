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
                <i class="fa fa-calendar" style="font-size:16px"></i>
                <span data-key="t-dashboard">Pasang Baru</span>
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
