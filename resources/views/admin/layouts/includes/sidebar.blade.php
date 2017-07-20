<div class="col-md-2">
    <div class="sidebar content-box" style="position:fixed;width: 194px;">
        <ul class="nav">
            <!-- Main menu -->
            <li class="current"><a href="{{ url('/admincp') }}"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
            <li><a href="{{ url('/admincp/users') }}"><i class="glyphicon glyphicon-user"></i> Users</a></li>
            <li><a href="{{ url('/admincp/services') }}"><i class="glyphicon glyphicon-film"></i> Services</a></li>
            <li><a href="{{ url('/admincp/orders') }}"><i class="glyphicon glyphicon-glass"></i> Orders</a></li>
            <li><a href="{{ url('/admincp/profits') }}"><i class="glyphicon glyphicon-glass"></i> Profits</a></li>
            <li class="submenu">
                <a href="#">
                    <i class="glyphicon glyphicon-list"></i> Pages
                    <span class="caret pull-right"></span>
                </a>
                <!-- Sub menu -->
                <ul>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="signup.html">Signup</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
