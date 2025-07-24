<!doctype html>
<html lang="en">

<head>
    @stack('styles')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    {{-- Link CDN untuk menggunakan ICON --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .footer {
            background-color: #4f46e5;
            color: white;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -2px 15px rgba(79, 70, 229, 0.2);
        }

        .footer p {
            margin: 0;
            font-size: 0.95rem;
        }

        .footer {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.15);
        }

        .footer a:hover {
            color: #ffffff !important;
        }

        .navbar {
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 1.4rem;
            transition: color 0.3s ease;
        }

        .navbar .navbar-brand:hover {
            color: #e0e0ff;
        }

        .navbar .nav-link {
            color: #ffffffcc;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar .nav-link:not(.dropdown-toggle) {
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar .nav-link:not(.dropdown-toggle)::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .navbar .nav-link:not(.dropdown-toggle):hover::after {
            width: 100%;
        }



        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #fff;
        }

        .navbar-toggler {
            border: none;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffffff' viewBox='0 0 30 30'%3e%3cpath stroke='%23ffffff' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
    </style>

</head>

<body>
    @include('sweetalert::alert')
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">Library App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>

                    {{-- User --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/book') }}">Book</a>
                    </li>
                    @if (Auth::user())
                        {{-- Admin --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/books') }}">Books</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/category') }}">Category Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (Auth::check())
                                <i class="bi bi-person"></i> {{ Auth::user()->name }}
                            @else
                                Akun
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::check())
                                <li>
                                    <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ url('/login') }}">Login</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer mt-5 pt-4 pb-3 text-white">
        <div class="container">
            <div class="row text-center text-md-start">
                <!-- About -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Library App</h5>
                    <p class="small">Tempat terbaik untuk menemukan, membaca, dan mengelola koleksi buku favoritmu.
                        Gratis dan selalu up to date!</p>
                </div>
                <!-- Quick Links -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="{{ url('/book') }}" class="text-white-50 text-decoration-none">Book</a></li>
                        </li>
                        @if (Auth::user())
                            <li>
                                <a class="text-white-50 text-decoration-none" href="{{ url('/logout') }}">Logout</a>
                            </li>
                        @else
                            <li>
                                <a class="text-white-50 text-decoration-none" href="{{ url('/login') }}">Login</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- Social Media -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold">Follow Us</h6>
                    <a href="#" class="text-white-50 me-3 fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50 me-3 fs-5"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-white-50 me-3 fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white-50 fs-5"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <hr class="border-light">
            <div class="text-center small text-white-50">
                &copy; {{ date('Y') }} Library App. All rights reserved.
            </div>
        </div>
    </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</body>

</html>
