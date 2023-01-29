<!-- Header -->
<header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container justify-content-between">

            <a class="navbar-brand" href="{{ url('/') }}"> SmokeyGlasses </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarColor01" style="">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">Brands</a>
                        <div class="dropdown-menu">
                            @include('partials.brands')
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">Categories</a>
                        <div class="dropdown-menu">
                            @include('partials.categories')
                        </div>
                    </li>
                </ul>
                <form class="d-flex w-50 mx-5" action='/search'>
                    <input class="form-control me-sm-2" type="text" placeholder="Search" method="GET"
                        name="search" action="/search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <ul class="navbar-nav ms-0">
                    @if (!Auth::check() || !Auth::user()['is_admin'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/shopping_cart') }}"><i
                                    class="fa-solid fa-cart-shopping"></i></a>
                        </li>
                    @endif
                    @if (Auth::check())
                        @if (!Auth::user()['is_admin'])
                            @include('partials.notifications')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/wishlist') }}"><i class="fa-solid fa-heart"></i></a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/user/ {{ Auth::user()->id_user }}">{{ Auth::user()->name }}</a>
                        </li>
                        @if (Auth::user()['is_admin'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Management</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/create_user">Create User</a>
                                    <a class="dropdown-item" href="/user_search">Search User</a>
                                    <a class="dropdown-item" href="/product/add">Create Product</a>
                                    <a class="dropdown-item" href="/reports">Manage Reports</a>
                                </div>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/register') }}"> Register </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}"> Login </a>
                        <li class="nav-item">
                    @endif
                </ul>
            </div>

        </div>
    </nav>
</header>
