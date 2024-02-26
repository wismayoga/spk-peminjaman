<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link hide-sidebar-toggle-button" href="#"><i
                                class="material-icons">first_page</i></a>
                    </li>
                </ul>

            </div>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown"
                            data-bs-toggle="dropdown"><img src="{{ asset('assets/images/user.png') }}"
                                alt=""></a>
                        <ul class="dropdown-menu dropdown-menu-end language-dropdown"
                            aria-labelledby="languageDropDown">
                            {{-- <li class="text-start mb-2">Halo, {{ ucfirst(explode(' ', auth()->user()->name)[0]) }}</li> --}}
                            {{-- <li><a class="dropdown-item" href="#"><img src="../../assets/images/user1.png"
                                        alt="">Profile</a>
                            </li> --}}
                            <li>
                                {{-- <a class="dropdown-item" href="{{ route('logout') }}"><img
                                        src="{{ asset('assets/images/exit.png') }}" alt="">Logout</a> --}}
                                <div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <img src="{{ asset('assets/images/exit.png') }}" width="20px" alt="" class="mr-1">  Logout
                                        </button>
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
