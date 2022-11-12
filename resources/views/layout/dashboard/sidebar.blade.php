<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item @if ($controller== 'Dashboard') active @endif">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item @if ($controller== 'kavlingcontroller') active @endif">
            <a class="nav-link" href="{{route('list-kavling')}}">
                <i class="icon-marquee menu-icon"></i>
                <span class="menu-title">Kavling List</span>
            </a>
        </li>
        <li class="nav-item @if ($controller== 'add-ons') active @endif">
            <a class="nav-link" href="{{route('add-ons')}}">
                <i class="icon-circle-plus menu-icon"></i>
                <span class="menu-title">Add On List</span>
            </a>
        </li>
        <li class="nav-item @if ($controller== 'testimonials') active @endif">
            <a class="nav-link" href="{{route('testimonials')}}">
                <i class="icon-paper-clip menu-icon"></i>
                <span class="menu-title">Testimonials</span>
            </a>
        </li>
        <li class="nav-item @if ($controller== 'userlist') active @endif">
            <a class="nav-link" href="{{route('userlist')}}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">User List</span>
            </a>
        </li>

    </ul>
</nav>
<!-- partial -->