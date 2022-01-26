<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #25694b;">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <a href="{{route('welcome')}}">
            <img type="button" src="https://static.wixstatic.com/media/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/dbafb3_66684a1bebd64728a5440dc94bbb7821%7Emv2.png" alt="">
        </a>
        <!-- Toggle button -->
        <button
        class="navbar-toggler"
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#navbarRightAlignExample"
        aria-controls="navbarRightAlignExample"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarRightAlignExample">
            <!-- Left links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                <!-- Check to see if the user is logged in. -->
                @if(Auth::user())
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🥺 Logout</a>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">🔑 Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">🔓 Register</a>
                    </li>
                @endif
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>