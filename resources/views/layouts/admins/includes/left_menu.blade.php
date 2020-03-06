<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
    <div class="image">
        <img src="{{ asset('backend/images/user.png') }}" width="48" height="48" alt="User" />
    </div>
    <div class="info-container">
        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ Auth::guard('admin')->user()->name}}</div>
        <div class="email">{{ Auth::guard('admin')->user()->email }}</div>
        <div class="btn-group user-helper-dropdown">
            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
            <ul class="dropdown-menu pull-right">
                <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ route('admin.logout') }}"
                     onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();"><i class="material-icons">input</i>Sign Out</a></li>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                  </form>
            </ul>
        </div>
    </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
    <ul class="list">
        <li class="header">MAIN NAVIGATION</li>
        <li {{ (request()->is('admin/dashboard')) ? 'class=active' : '' }}>
            <a href="{{ route('admin.dashboard') }}">
                <i class="material-icons">home</i>
                <span>Home</span>
            </a>
        </li>
        <li {{ (request()->is('admin/manage_users')) ? 'class=active' : '' }}>
            <a href="{{ route('admin.manage_users') }}" class="toggled waves-effect waves-block">
                <i class="material-icons">people</i>
                <span>Users</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);">
                <i class="material-icons col-light-blue">donut_large</i>
                <span>Information</span>
            </a>
        </li>
    </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
    <div class="copyright">
        &copy; 2020 by <a href="#">Akram Chauhan</a>
    </div>
    <div class="version">
        <b>Version: </b> 1.1
    </div>
    </div>
    <!-- #Footer -->
</aside>