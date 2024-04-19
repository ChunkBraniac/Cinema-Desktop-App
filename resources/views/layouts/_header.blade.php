{{-- header begins here --}}
<div class="container-fluid bg-dark p-1">
    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('icons/video.png') }}"
                    style="height: 35px; width: 30px" alt="">Cinema<span class="text-info">Hub</span></a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation" style="border-radius: 0px; font-size: 14px; box-shadow: none">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0 m-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-light" href="{{ url('/') }}" aria-current="page">Home
                            <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-light" href="{{ url('#') }}" id="dropdownId"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Genres <i
                                class="fa fa-plus" aria-hidden="true" style="font-size: 12px"></i></a>
                        <div class="dropdown-menu mt-3" aria-labelledby="dropdownId" style="border-radius: 0px">
                            <a class="dropdown-item" href="{{ url('#') }}">Action 1</a>
                            <a class="dropdown-item" href="{{ url('#') }}">Action 2</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('#') }}">Help</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('#') }}">About</a>
                    </li>
                </ul>
                <form class="d-flex my-2 my-lg-0">
                    <input class="form-control me-sm-2" type="text" placeholder="Search"
                        style="border-radius: 0px; box-shadow: none" required />
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="border-radius: 0px;">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
{{-- header ends here --}}