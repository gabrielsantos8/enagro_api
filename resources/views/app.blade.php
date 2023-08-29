<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="/cows" class="nav_logo"> <i class='bx bx-refresh nav_logo-icon'></i><span
                        class="nav_logo-name"><img src="{{ asset('img/logo_enagro_admin_white.png') }}" style="width: 30%"></span></a>
                <div class="nav_list">
                    {{-- <a href="{{ route('cows.create') }}" class="nav_link @yield('manClass')"> <i class='bx bx-slider-alt nav_icon'></i> --}}

                    <a href="" class="nav_link @yield('relClass')"> <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Usuários</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='bx bx-plus-medical nav_icon'></i>
                        <span class="nav_name">Planos de Saúde</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='bx bx-lock-alt nav_icon'></i>
                        <span class="nav_name">Seguros</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='bx bx-briefcase-alt-2 nav_icon'></i>
                        <span class="nav_name">Serviços Avulsos</span> </a>

                    <a href="" class="nav_link @yield('relClass')"> <i class='bx bx-donate-heart nav_icon'></i>
                        <span class="nav_name">Veterinários</span> </a>
                </div>
            </div>
        </nav>
    </div>
    <div class="height-100 bg-light">
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
