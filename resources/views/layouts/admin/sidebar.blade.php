<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Rental Kendaraan</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">RenKen</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('vehicles*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.vehicles.index') }}">
                    <i class="fas fa-car"></i> <!-- Ikon Kendaraan -->
                    <span>Kendaraan</span>
                </a>
            </li>
            <li class="{{ Request::is('rentals*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.rentals.index') }}">
                    <i class="fas fa-clipboard-list"></i> <!-- Ikon Rental -->
                    <span>Rental</span>
                </a>
            </li>
        </ul>
    </aside>
</div>