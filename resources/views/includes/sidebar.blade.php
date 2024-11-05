<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item {{ Route::is('home') ? 'active' : '' }} ">
            <a href="/home" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item {{ Route::is('admin.customer') ? 'active' : '' }}">
            <a href="{{ route('admin.customer') }}" class='sidebar-link'>
                <i class="iconly-boldProfile"></i>
                <span>Customer</span>
            </a>
        </li>

        <li class="sidebar-item {{ Route::is('admin.product') ? 'active' : '' }}">
            <a href="{{ route('admin.product') }}" class='sidebar-link'>
                <i class="bi bi-collection-fill"></i>
                <span>Products</span>
            </a>
        </li>

        <li class="sidebar-item {{ Route::is('admin.debt') ? 'active' : '' }}">
            <a href="{{ route('admin.debt') }}" class='sidebar-link'>
                <i class="bi bi-cash-stack"></i>
                <span>Hutang</span>
            </a>
        </li>


        <li class="sidebar-item  ">
            <a href="#" class='sidebar-link'
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </li>

    </ul>
</div>
