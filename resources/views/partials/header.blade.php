<header>
    <div class="brand">
        <a href="{{ route('home') }}">Monitoring</a>
    </div>

    {{-- Desktop Nav --}}
    <nav class="main-nav">
        <ul class="main-unordered-list">
            <li class="main-link-items"><a href="{{ route('home') }}" class="main-link">Dashboard</a></li>

            {{-- Services Dropdown --}}
            <li class="main-link-items dropdown" id="dropdown">
                <a href="#" class="main-link" id="dropdown-toggle">
                    Server <span class="dropdown-icon">&#9662;</span>
                </a>
                <div class="large-dropdown-list-box" id="dropdown-menu">
                    <ul>
                        <li class="drop-boxes">
                            <p>Servers</p>
                            <ul>
                                <li><a href="{{ route('create-server') }}">Add Server</a></li>
                                <li><a href="{{ route('update-server') }}">Update Server</a></li>
                                <li><a href="{{ route('update-server') }}">Delete Server</a></li>
                            </ul>
                        </li>
                        <li class="drop-boxes">
                            <p>Protocols</p>
                            <ul>
                                <li><a href="{{ route('test-page') }}">Add Protocol</a></li>
                                <li><a href="#">Update Protocol</a></li>
                                <li><a href="#">Delete Protocol</a></li>
                            </ul>
                        </li>
                        <li class="drop-boxes">
                            <p>Statuses</p>
                            <ul>
                                <li><a href="#">Add Status</a></li>
                                <li><a href="#">Update Status</a></li>
                                <li><a href="#">Delete Status</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="main-link-items"><a href="#" class="main-link">Make Request</a></li>
            <li class="main-link-items"><a href="{{ route('servers.all') }}" class="main-link">All Tests </a></li>
        </ul>

        <ul class="main-small-unordered-list">
            @guest
                <li class="main-link-items"><a href="{{ route('login') }}" class="main-link">Login</a></li>
            @else
                <li class="main-link-items">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="main-link logout-btn">Logout</button>
                    </form>
                </li>
                {{-- <li class="main-link-items"><a href="{{ route('home') }}" class="main-link">some</a></li> --}}
            @endguest
        </ul>
    </nav>

    {{-- Hamburger for Mobile --}}
    <div class="humburger-icon" id="humburger-icon">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>

        <ul class="mobile-menu">
            <h3>Monitoring Menu</h3>
            <hr>
            <li><a href="{{ route('home') }}">Dashboard</a></li>

            {{-- Mobile Dropdown --}}
            <li class="dropdown-mobile">
                <a href="#" class="dropdown-mobile-toggle">Server &#9662;</a>
                <div class="large-dropdown-list-box-mobile">
                    <ul>
                        <li class="drop-boxes">
                            <p>Servers</p>
                            <ul>
                                <li><a href="{{ route('create-server') }}">Add Server</a></li>
                                <li><a href="{{ route('update-server') }}">Update Server</a></li>
                                <li><a href="{{ route('update-server') }}">Delete Server</a></li>
                            </ul>
                        </li>
                        <li class="drop-boxes">
                            <p>Protocols</p>
                            <ul>
                                <li><a href="{{ route('test-page') }}">Add Protocol</a></li>
                                <li><a href="#">Update Protocol</a></li>
                                <li><a href="#">Delete Protocol</a></li>
                            </ul>
                        </li>
                        <li class="drop-boxes">
                            <p>Statuses</p>
                            <ul>
                                <li><a href="#">Add Status</a></li>
                                <li><a href="#">Update Status</a></li>
                                <li><a href="#">Delete Status</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </li>

            <li><a href="#">Make Request</a></li>
            <li><a href="{{ route('servers.all') }}">All Tests </a></li>


            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
            @else
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="main-link logout-btn">Logout</button>
                    </form>
                </li>
                <li><a href="{{ route('home') }}">Dashboard</a></li>
            @endguest
        </ul>
    </div>
</header>
