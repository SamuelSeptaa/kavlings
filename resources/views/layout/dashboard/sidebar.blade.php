<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item @if ($controller== 'Dashboard') {{" active"}} @endif">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item @if ($controller== 'userlist') {{" active"}} @endif">
            <a class="nav-link" href="{{route('user-list')}}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">User List</span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->