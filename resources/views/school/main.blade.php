<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            background-color: #FFFFFFFF;
            box-shadow: #1e1e1e;

            /* Gradient to bottom */
            /* background: linear-gradient(to bottom, #FF000DFF, #720303FF); */
            
            /* Gradient to right */
            /* background: linear-gradient(to right, #C506C8, #7209B7); */

            /* Multi Warna */
            /* background: linear-gradient(135deg, #C506C8, #7209B7, #3A0CA3); */

            /* Radial Gradient */
            /* background: radial-gradient(circle, #C506C8, #3A0CA3); */
        }

        .full-navbar {
            position: fixed;
            top: 0;
            left: 300px;
            width: calc(100% - 300px); /* ✅ Perbaikan di sini */
            color: #fff;
            z-index: 999;
            background-color: #004dd1;
            border-bottom: 1px solid #e0e0e0;
            padding-left: 10px; /* karena sidebar lebarnya 300px */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .content {
            margin-left: 10px;
            padding: 100px 30px 30px; /* tambah top padding karena navbar fixed */
            flex: 1;
        }



        .sidebar {
            width: 300px;
            /* background: linear-gradient(to bottom, #C506C8, #7209B7); */
            background: #004dd1;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow: hidden; /* agar scroll hanya terjadi di menu */
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu {
            overflow-y: auto;
            max-height: 100%;
            padding-right: 10px;
        }

        /* Opsional: tambahkan scrollbar yang elegan (khusus WebKit browser seperti Chrome) */
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        
        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #001772FF
        }

        .sidebar a.active {
            background-color: #fff;
            color: #07267BFF;
            font-weight: bold;
        }

        .content {
            margin-left: 300px;
            padding: 30px;
            flex: 1;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .app-title {
            font-size: 1.6rem;
            color: #fff;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .app-title strong {
            color: #fffbea;
        }

    </style>

    @yield('styles')
    
</head>
<body>
    @include('sweetalert::alert')

    <!-- Navbar Full Width -->
    <nav class="navbar navbar-expand-lg full-navbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-light">Status Akun: Admin </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end pe-4" id="navbarContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i> {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="userDropdown">
                            <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar --> 
    <div class="sidebar">
        <a href="{{ url('/') }}">
             <h4 class="app-title">
                📚<span>Sudirman</span> <strong>School</strong>
            </h4>
        </a>
        
        <h5 class="mb-4 text-center">
            Selamat Datang <br>
            {{ Auth::user()->name }}
        </h5>


        <hr>

        <div class="sidebar-menu">
            @include('school.sideMenu')
        </div>

        <hr>
    </div>

    <!-- Content -->
    <div class="content mt-4">
        @yield('content')
    </div>

    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>