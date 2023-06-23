<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- Language -->
                <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class='fi fi-gb fis rounded-circle fs-3  me-1'></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{url('lang/en')}}" data-language="en">
                                <i class="fi fi-gb fis rounded-circle fs-4 me-1"></i>
                                <span class="align-middle">English</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{url('lang/ar')}}" data-language="ar">
                                <i class="fi fi-jo fis rounded-circle fs-4 me-1"></i>
                                <span class="align-middle">عربي</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ Language -->

                <!-- Style Switcher -->
                <li class="nav-item me-2 me-xl-0">
                    <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                        <i class='bx bx-sm'></i>
                    </a>
                </li>
                <!-- /Style Switcher -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <x-avatar :user="Auth::user()"/>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item"
                               href="{{ Route::has('profile.show') ? route('profile.show') : 'javascript:void(0);' }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <x-avatar :user="Auth::user()"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                    <span class="fw-semibold d-block">
                            {{ Auth::user()->name }}
                    </span>
                                        <small class="text-muted">Admin</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ Route::has('profile.show') ? route('profile.show') : 'javascript:void(0);' }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        @if (Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <li>
                                <a class="dropdown-item" href="{{ route('api-tokens.index') }}">
                                    <i class='bx bx-key me-2'></i>
                                    <span class="align-middle">API Tokens</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::User() && Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <h6 class="dropdown-header">Manage Team</h6>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                   href="{{ Auth::user() ? route('teams.show', Auth::user()->currentTeam->id) : 'javascript:void(0)' }}">
                                    <i class='bx bx-cog me-2'></i>
                                    <span class="align-middle">Team Settings</span>
                                </a>
                            </li>
                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <li>
                                    <a class="dropdown-item" href="{{ route('teams.create') }}">
                                        <i class='bx bx-user me-2'></i>
                                        <span class="align-middle">Create New Team</span>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <lI>
                                <h6 class="dropdown-header">Switch Teams</h6>
                            </lI>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            @if (Auth::user())
                                @foreach (Auth::user()->allTeams() as $team)
                                    {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}

                                    <x-switchable-team :team="$team"/>
                                @endforeach
                            @endif
                        @endif
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        @if (Auth::check())
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class='bx bx-power-off me-2'></i>
                                    <span class="align-middle">Logout</span>
                                </a>
                            </li>
                            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                @csrf
                            </form>
                        @else
                            <li>
                                <a class="dropdown-item"
                                   href="{{ Route::has('login') ? route('login') : url('auth/login-basic') }}">
                                    <i class='bx bx-log-in me-2'></i>
                                    <span class="align-middle">Login</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>

    </div>
</nav>
<!-- / Navbar -->
