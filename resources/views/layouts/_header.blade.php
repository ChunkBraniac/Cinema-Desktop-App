@if (!Request::is('register') && !Request::is('login') && !Request::is('404'))
    {{-- header begins here --}}
    <div class="container-fluid bg-dark p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark position-fixed p-3"
            style="width: 100%; top: 0; z-index: 3">
            <div class="container">
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
                            <a class="nav-link active text-light" style="font-size: 16px; margin-right: 20px"
                                href="{{ url('/') }}" aria-current="page">Home
                                <span class="visually-hidden">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-light" href="{{ url('#') }}" id="dropdownId"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="font-size: 16px; margin-right: 20px">Genres <i class="fa fa-plus"
                                    aria-hidden="true" style="font-size: 12px"></i></a>
                            <div class="dropdown-menu bg-dark mt-0 mt-xl-3 m-lg-auto justify-content-center position-absolute text-left text-xl-left"
                                aria-labelledby="dropdownId"
                                style="border-radius: 0px; font-size: 16px; margin-top: 10px">
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('action') }}">Action</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('animation') }}">Animation</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('comedy') }}">Comedy</a>
                                <a class="dropdown-item text-light"m id="hover" href="{{ url('drama') }}">Drama</a>
                                <a class="dropdown-item text-light"m id="hover"
                                    href="{{ url('horror') }}">Horror</a>
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
    {{-- header ends here --}}
@endif
