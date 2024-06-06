@if (!Request::is('register') && !Request::is('login') && !Request::is('404'))
    {{-- header begins here --}}
    <div class="container-fluid bg-dark p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark position-fixed pt-3 pb-3"
            style="width: 100%; top: 0; z-index: 10; box-shadow: 0px 0px 40px 0px rgba(0, 0, 0, 0.623);">
            <div class="container-md">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('icons/video.png') }}"
                        style="height: 35px; width: 30px" alt=""> Cinema<span class="text-info">Hub</span></a>

                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation" style="border-radius: 0px; font-size: 14px; box-shadow: none;">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0 m-auto">
                        <li class="nav-item">
                            <a class="nav-link active text-light" style="font-size: 15px; margin-right: 20px"
                                href="{{ url('/') }}" aria-current="page">Home
                                <span class="visually-hidden">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-light" href="{{ url('#') }}" id="dropdownId"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="font-size: 15px; margin-right: 20px">Genres <i class="fa fa-plus"
                                    aria-hidden="true" style="font-size: 12px"></i></a>
                            <div class="dropdown-menu bg-dark mt-0 mt-xl-3 m-lg-auto justify-content-center position-absolute text-left text-xl-left"
                                aria-labelledby="dropdownId"
                                style="border-radius: 0px; font-size: 15px; margin-top: 10px;">
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('action') }}">Action</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('animation') }}">Animation & Anime</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('comedy') }}">Comedy</a>
                                <a class="dropdown-item text-light"m id="hover" href="{{ url('drama') }}">Drama</a>
                                <a class="dropdown-item text-light"m id="hover" href="{{ url('fantasy') }}">Fantasy</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('horror') }}">Horror</a>
                                <a class="dropdown-item text-light"m id="hover" href="{{ url('mystery') }}">Mystery</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('thriller') }}">Thriller</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('scifi') }}">Sci-Fi</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('tv.shows') }}"
                                style="font-size: 15px; margin-right: 20px;">TV Shows</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('movies') }}" style="font-size: 15px; margin-right: 20px;">Movies
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('about-us') }}" style="font-size: 15px; margin-right: 20px;">About Us
                            </a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" action="{{ route('movie.search') }}" method="get">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            name="search" required style="border-radius: 0px; box-shadow: none">
                        <button class="btn btn-outline-primary" type="submit" style="border-radius: 0px;"><i
                                class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    {{-- <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{ url('icons/video.png') }}" style="height: 35px; width: 30px"
                    alt=""> Cinema<span class="text-info">Hub</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" style="border-radius: 0px; font-size: 14px; box-shadow: none;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">
                        <img src="{{ url('icons/video.png') }}" style="height: 35px; width: 30px"
                    alt=""> Cinema<span class="text-info">Hub</span>
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <hr class="text-white">
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active text-light" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-light" href="{{ url('#') }}" id="dropdownId"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="font-size: 16px; margin-right: 20px">Genres <i class="fa fa-plus"
                                    aria-hidden="true" style="font-size: 12px"></i></a>
                            <div class="dropdown-menu bg-dark mt-0 mt-xl-0 m-lg-auto justify-content-center position-absolute text-left text-xl-left"
                                aria-labelledby="dropdownId"
                                style="border-radius: 0px; font-size: 16px; margin-top: 10px;">
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('action') }}">Action</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('animation') }}">Animation & Anime</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('comedy') }}">Comedy</a>
                                <a class="dropdown-item text-light"m id="hover" href="{{ url('drama') }}">Drama</a>
                                <a class="dropdown-item text-light"m id="hover" href="{{ url('fantasy') }}">Fantasy</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('horror') }}">Horror</a>
                                <a class="dropdown-item text-light"m id="hover" href="{{ url('mystery') }}">Mystery</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('thriller') }}">Thriller</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('scifi') }}">Sci-Fi</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ url('#') }}"
                                style="font-size: 16px; margin-right: 20px;">Help</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ url('#') }}" style="font-size: 16px;">About
                            </a>
                        </li>
                    </ul>
                    
                    <form class="d-flex mt-2">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                        name="search" required style="border-radius: 0px; box-shadow: none" />
                        <button class="btn btn-outline-success" type="submit" style="border-radius: 0px;"><i
                            class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </nav> --}}

    {{-- header ends here --}}
@endif
