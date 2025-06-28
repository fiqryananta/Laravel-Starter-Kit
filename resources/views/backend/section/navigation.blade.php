@php
    $routeName = \Route::currentRouteName();
@endphp

<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative">
        <a href="index.html" class="d-block text-decoration-none position-relative">
            <img src="{{ mix('backend/images/logo-icon.png') }}" alt="logo-icon">
            <span class="logo-text fw-bold text-dark">Trezo</span>
        </a>
        <button class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu">
            <i data-feather="x"></i>
        </button>
    </div>

    <aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
        <ul class="menu-inner">
            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">MAIN</span>
            </li>

            <li class="menu-item {{ isMenuRoute($routeName, 'dashboard') ? 'open' : '' }}">
                <a href="{{ route('dashboard.index') }}" class="menu-link {{ isMenuRoute($routeName, 'dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined menu-icon">dashboard</span>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">MANAJEMEN</span>
            </li>

            <li class="menu-item {{ isMenuRoute($routeName, 'user') ? 'open' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">group</span>
                    <span class="title">Pengguna</span>
                </a>
            </li>

            <li class="menu-item {{ isMenuRoute($routeName, 'role') || isMenuRoute($routeName, 'permission') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle active">
                    <span class="material-symbols-outlined menu-icon">lock_open</span>
                    <span class="title">Akses</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ isMenuRoute($routeName, 'role') ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}" class="menu-link">
                            Role
                        </a>
                    </li>
                    <li class="menu-item {{ isMenuRoute($routeName, 'permission') ? 'active' : '' }}">
                        <a href="{{ route('permission.index') }}" class="menu-link">
                            Permission
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="logout.html" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">logout</span>
                    <span class="title">Logout</span>
                </a>
            </li>
        </ul>
    </aside>
</div>