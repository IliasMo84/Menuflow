<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MenuFlow') }} - Admin</title>

    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets (Bootstrap & Custom CSS/JS) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <!-- Navbar Supérieure -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-warning fs-4" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-utensils me-2"></i>MenuFlow
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav" aria-controls="topnav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="topnav">
                <ul class="navbar-fluid navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user me-1"></i> {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fa-solid fa-user-gear me-2"></i>Mon Profil
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse border-end min-vh-100 p-3">
                <div class="position-sticky pt-3">
                    <ul class="nav nav-pills flex-column mb-auto">

                        <li class="nav-item mb-1">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                                <i class="fa-solid fa-chart-line me-2"></i> Tableaux de bord
                            </a>
                        </li>

                        <li class="nav-item mb-1">
                            <a href="{{ route('restaurant.index') }}" class="nav-link {{ request()->routeIs('restaurant.*') ? 'active' : 'text-dark' }}">
                                <i class="fa-solid fa-store me-2"></i> Mon Restaurant
                            </a>
                        </li>

                        <li class="nav-item mb-1">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : 'text-dark' }}">
                                <i class="fa-solid fa-layer-group me-2"></i> Catégories
                            </a>
                        </li>

                        <li class="nav-item mb-1">
                            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : 'text-dark' }}">
                                <i class="fa-solid fa-burger me-2"></i> Produits
                            </a>
                        </li>

                        <li class="nav-item mb-1">
                            <a href="#" class="nav-link text-dark disabled">
                                <i class="fa-solid fa-chair me-2"></i> Tables & QR Codes
                            </a>
                        </li>

                        <li class="nav-item mb-1">
                            <a href="#" class="nav-link text-dark disabled">
                                <i class="fa-solid fa-receipt me-2"></i> Commandes
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>

            <!-- Contenu Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')

            </main>
        </div>
    </div>

</body>
</html>