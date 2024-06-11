@if (!Request::is('admin') && !Request::is('admin/register'))
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ url('admin/dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ url('assets/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar m-auto">
            <form class="search-form d-flex align-items-center" method="get">
                <input type="text" autocomplete="off" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="{{ url('#') }}">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{ url('#') }}"
                        data-bs-toggle="dropdown">
                        <img src="{{ url('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::guard('admin')->user()->admin_name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::guard('admin')->user()->admin_name }}</h6>
                            <span>Web Developer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/profile') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('pages-faq.html') }}">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->


    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="comments">
                    <i class="fa fa-comment" aria-hidden="true"></i>
                    <span>Comments</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Components</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.all') }}">
                            <i class="bi bi-circle"></i><span>Movies & Series</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('seriesV1.api') }}">
                            <i class="bi bi-circle"></i><span>Trending Series</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('moviesV2.api') }}">
                            <i class="bi bi-circle"></i><span>Trending Movies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seriesUpdate.api') }}">
                            <i class="bi bi-circle"></i><span>Update Series Info</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('moviesUpdate.api') }}">
                            <i class="bi bi-circle"></i><span>Update Movies Info</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('series.trailer') }}">
                            <i class="bi bi-circle"></i><span>Get Series Trailer</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('series.trailer.v2') }}">
                            <i class="bi bi-circle"></i><span>Get Series Trailer V2</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('movies.trailer') }}">
                            <i class="bi bi-circle"></i><span>Get Movies Trailer</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('movies.trailer.v2') }}">
                            <i class="bi bi-circle"></i><span>Get Movies Trailer V2</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.seasons') }}">
                            <i class="bi bi-circle"></i><span>Get Seasons</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav1" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Others</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('pending.series') }}">
                            <i class="bi bi-circle"></i><span>Pending Series</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pending.movies') }}">
                            <i class="bi bi-circle"></i><span>Pending Movies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.approve') }}">
                            <i class="bi bi-circle"></i><span>Approve Movies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.approve.series') }}">
                            <i class="bi bi-circle"></i><span>Approve Series</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        </li><!-- End Components Nav -->

        </ul>

    </aside><!-- End Sidebar-->
@endif
